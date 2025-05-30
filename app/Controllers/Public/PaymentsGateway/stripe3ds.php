<?php
namespace App\Controllers\Public\PaymentsGateway;
require 'stripe_ver9/autoload.php';

use Stripe\Stripe;
use Stripe\Customer as StripeCustomer;
use Stripe\Charge as StripeCharge;

/**
 *
 */
class stripe3ds
{
    private $payment_type;
    private $environment;
    private $pm_details;
    private $convert_rate;
    private $currency_code;

    public $public_key;
    public $secret_key;

    public function __construct($payment = [])
    {
        $this->payment_type = 'stripe3ds';
        if (empty($payment)) {
            $payment = db_get('*', TB_PAYMENTS_METHOD, ['type' => $this->payment_type, 'status' => 1]);
        }
        if (empty($payment)) {
            json_response([
                'status' => 'error',
                'message' => 'The selected payment option is not available',
            ]);
        }
        $option                 = get_value_by_key($payment['params'], 'option');
        $this->environment      = get_value_by_key($option, 'environment');
        $this->convert_rate     = !empty(get_value_by_key($option, 'convert_rate')) ? get_value_by_key($option, 'convert_rate') : 1;
        $this->currency_code    = !empty(get_value_by_key($option, 'currency_code')) ? get_value_by_key($option, 'currency_code') : 'USD';
        $this->pm_details       = get_value_by_key($option, 'pm_details');
        $this->pm_name          = get_value_by_key($option, 'pm_name');

        $this->public_key = get_value_by_key($option, 'public_key');
        $this->secret_key     = get_value_by_key($option, 'secret_key');
        if (empty($this->public_key) || empty($this->secret_key)) {
            json_response([
                'status' => 'error',
                'message' => 'The selected payment option is not available',
            ]);
        }
        Stripe::setApiKey($this->secret_key);
    }
    
    public function create_payment($tnx_payment = [])
    {
        $amount = $tnx_payment['total_charge'] * $this->convert_rate;

        if (strtolower($this->currency_code) == 'jpy') {
            $charge = $amount;
        } else {
            $charge = $amount * 100;
        }
        $pm_ids = ids();
        $params = [
            'payment_method_types' => ['card'],
            'customer_email' => get_post('email'),
            'name' => $this->pm_name,
            'description' => $this->pm_details,
            'amount' => $charge,
            'currency' => $this->currency_code,
            'success_url' => client_url('checkout/stripe3ds/complete') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => client_url('checkout/stripe3ds/complete') . '?session_id={CHECKOUT_SESSION_ID}',
        ];
        $response = $this->send_payment($params);
        if (isset($response['status']) && $response['status'] == 'success') {
            $session = $response['session'];
            $response['send_payment_data'] = $params;
            $response['transaction_id'] = $session->id;
            $response['tnx_status'] = 0;
            $response['html_update'] = [
                'action_type' => 'html',
                'html_content' => $this->html_redirect_content($session->id),
                'target_selector' => 'div.response-html',
            ];
        }
        return $response;
    }
   
    private function send_payment($params = "")
    { 
        $result = array();
        if (is_array($params)) {
            try {
                $product = \Stripe\Product::create([
                    'name' => $params['name'],
                    'description' => $params['description'],
                ]);
                $price = \Stripe\Price::create([
                    'product' => $product->id,
                    'unit_amount' => $params['amount'],
                    'currency' => $params['currency'],
                ]);
                $session = \Stripe\Checkout\Session::create([
                    'payment_method_types' => $params['payment_method_types'],
                    'line_items' => [[
                      'quantity' => 1,
                      'price' => $price->id,
                    ]],
                    'mode' => 'payment',
                    'success_url' => $params['success_url'],
                    'cancel_url' => $params['cancel_url'],
                ]);

                $result = array(
                    "status" => "success",
                    "session" => $session,
                );
                return $result;
            } catch (Stripe_CardError $e) {
                $error1 = $e->getMessage();
                $result = array(
                    "status" => "error",
                    "message" => $error1,
                );
                return $result;
            } catch (Stripe_InvalidRequestError $e) {
                // Invalid parameters were supplied to Stripe's API
                $error2 = $e->getMessage();
                $result = array(
                    "status" => "error",
                    "message" => $error2,
                );
                return $result;
            } catch (Stripe_AuthenticationError $e) {
                // Authentication with Stripe's API failed
                $error3 = $e->getMessage();
                $result = array(
                    "status" => "error",
                    "message" => $error3,
                );
                return $result;
            } catch (Stripe_ApiConnectionError $e) {
                // Network communication with Stripe failed
                $error4 = $e->getMessage();
                $result = array(
                    "status" => "error",
                    "message" => $error4,
                );
                return $result;
            } catch (Stripe_Error $e) {
                // Display a very generic error to the user, and maybe send
                // yourself an email
                $error5 = $e->getMessage();
                $result = array(
                    "status" => "error",
                    "message" => $error5,
                );
                return $result;
            } catch (Exception $e) {
                // Something else happened, completely unrelated to Stripe
                $error6 = $e->getMessage();
                $result = array(
                    "status" => "error",
                    "message" => $error6,
                );
                return $result;
            }
        } else {
            redirect(client_url());
        }
    }

    public function verify_payment()
    {
        $session_id = get('session_id');
        if (empty($session_id)) {
            return [
                'status' => 'error',
                'message' => 'Invalid request',
            ];
        }
        $db_where = [
            'transaction_id' => $session_id,
            'type' => $this->payment_type,
            'status' => 0,
        ];
        $transaction_exists = check_transaction_exists($db_where);
        if (empty($transaction_exists)) {
            return [
                'status' => 'error',
                'message' => 'Transaction does not exist!',
            ];
        }
        $response = $this->retrieveStripeData($session_id);
        
        $verify_tnx_data = [
            'status' => 'pending',
            'new_tnx_id' => '',
            'update_new_tnx_id' => false,
        ];
        if (isset($response['status']) && $response['tnx_status'] == 'succeeded') {
            $verify_tnx_data['status'] = TNX_STATUS_PAID;
            $verify_tnx_data['data_details'] = $response['data'];

            if ($response['data']['balance_transaction']) {
                $verify_tnx_data['new_tnx_id'] = $response['data']['balance_transaction'];
                $verify_tnx_data['update_new_tnx_id'] = TRUE;
            }
        }    
        $response['verify_tnx_data'] = $verify_tnx_data;
        $response['item_transaction'] = $transaction_exists;
        return $response;
    }

    /**
     * Retrieve Stripe data by session Id
     *
     * @param string $sessionId
     *
     * request to Stripe checkout
     *---------------------------------------------------------------- */
    public function retrieveStripeData($session_id)
    {
        try {

            $sessionData = \Stripe\Checkout\Session::retrieve($session_id);

            if (empty($sessionData)) {
                throw new Exception("Session data does not exist.");
            }

            $paymentIntentData = \Stripe\PaymentIntent::retrieve($sessionData->payment_intent);
            $result = [
                'status' => 'success',
                'tnx_status' => $paymentIntentData->status,
                'data' => [
                    'payment_id' => $paymentIntentData->id,  
                    'amount'     => $paymentIntentData->amount,        
                    'currency'   => $paymentIntentData->currency,    
                    'created'    => $paymentIntentData->created,      
                    'balance_transaction'    => $paymentIntentData->charges->data[0]['balance_transaction'] ?? '',      
                ],
            ];
            return $result;

        } catch (\Stripe\Error\InvalidRequest $err) {
            //set error message if payment failed
            $result = [
                'status' => 'error',
                'message' => $err->getMessage(),
            ];
            //return error message array
            return $result;

        } catch (\Stripe\Error\Card $err) {
            //set error message if payment failed
            $result = [
                'status' => 'error',
                'message' => $err->getMessage(),
            ];
            //return error message array
            return $result;
        }
    }


    private function html_redirect_content($session_id)
    {
        if (empty($this->public_key) || empty($session_id)) {
            return null;
        }
        $html = '
                <script type="text/javascript">
                    var stripePublishKey 	= "'. $this->public_key .'",
                        stripe_session_id   = "'. $session_id .'";
                    var stripe = Stripe(stripePublishKey);
                    stripe.redirectToCheckout({
                        sessionId: stripe_session_id,
                    });
                </script>';

        return $html;
    }

}
