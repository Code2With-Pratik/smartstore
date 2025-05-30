<?php
namespace App\Controllers\Public\PaymentsGateway;

require_once 'paypal/autoload.php';
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;

/**
 * Paypal PHP SDK
 */
class paypal
{
    private $payment_type;
    private $environment;
    private $pm_details;
    private $convert_rate;
    private $currency_code;

    private $client;
    private $clientId;
    private $clientSecret;

    public function __construct($payment = [])
    {
        $this->payment_type = 'paypal';
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

        $this->clientSecret = get_value_by_key($option, 'secret_key');
        $this->clientId     = get_value_by_key($option, 'client_id');
        if (empty($this->clientId) || empty($this->clientId)) {
            json_response([
                'status' => 'error',
                'message' => 'The selected payment option is not available',
            ]);
        }
        if ($this->environment == 'live') {
            $environment = new ProductionEnvironment($this->clientId, $this->clientSecret);
        } else {
            $environment = new SandboxEnvironment($this->clientId, $this->clientSecret);
        }
        $this->client = new PayPalHttpClient($environment);

    }

    public function create_payment($tnx_payment = [])
    {
        $amount = $tnx_payment['total_charge'] * $this->convert_rate;
        $params = [
            "refer_id" => ids(),
            "amount" => $amount,
            "currency" => $this->currency_code,
            "description" => $this->pm_details,
            "redirectUrls" => client_url("checkout/paypal/complete"),
            "cancelUrl" => client_url("checkout/unsuccess"),
        ];
        $response = $this->send_payment($params);
        if (isset($response['status']) && $response['status'] == 'success') {
            $response['send_payment_data'] = $params;
            $response['transaction_id'] = (isset($response['data_details']->id)) ? $response['data_details']->id : $params['refer_id'];
            $response['tnx_status'] = 0;
        }
        return $response;
    }

    public function verify_payment()
    {
        $token = get('token');
        $payerId = get('PayerID');
        if (empty($token) || empty($payerId)) {
            return [
                'status' => 'error',
                'message' => 'Invalid request',
            ];
        }
        $db_where = [
            'transaction_id' => $token,
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
        $response = $this->execute_payment($token, $payerId);
        $verify_tnx_data = [
            'status' => 'pending',
            'new_tnx_id' => '',
            'update_new_tnx_id' => false,
        ];
        if (isset($response['status']) && $response['status'] == 'success') {
            $data = $response['data'];
            if ($data->status == 'COMPLETED') { 
                $verify_tnx_data['status'] = TNX_STATUS_PAID;
                $verify_tnx_data['data_details'] = $data;
            }
        }    
        $response['verify_tnx_data'] = $verify_tnx_data;
        $response['item_transaction'] = $transaction_exists;
        return $response;
    }

    /**
     *
     * Define Payment && Create payment.
     *
     */
    private function send_payment($params = "")
    {
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => $params['refer_id'],
                "amount" => [
                    "value" => number_format($params['amount'], 2, '.', ''),
                    "currency_code" => $this->currency_code,
                ],
                "description" => $params['description'],
            ]],
            "application_context" => [
                "cancel_url" => $params['cancelUrl'],
                "return_url" => $params['redirectUrls'],
            ],
        ];
        try {
            // Call API with your client and get a response for your call
            $response = $this->client->execute($request);
            $createdOrder = $response->result;
            $foundApproveUrl = false;
            $approvalUrl = null;
            foreach ($createdOrder->links as $link) {
                if ("approve" === $link->rel) {
                    $foundApproveUrl = true;
                    $approvalUrl = $link->href;
                }
            }
            if ($foundApproveUrl) {
                $result = array(
                    'status' => 'success',
                    'redirect_url' => $approvalUrl,
                    'data_details' => $createdOrder,
                );
            } else {
                $result = array(
                    'status' => 'error',
                    'message' => 'Not Found Approval Url',
                );
            }
        } catch (HttpException $ex) {
            log_message('error', 'PayPal Payment Error: ' . $ex->statusCode . ' ' . $ex->getMessage());
            $result = array(
                'status' => 'error',
                'message' => $ex->statusCode . $ex->getMessage(),
            );
        }
        return $result;
    }

    /**
     *
     * Execute payment
     * If the customer accepts the payment, you can execute the payment.
     * To execute the payment, set the payment ID and payer ID parameters in the request:
     *
     */
    public function execute_payment($token, $payerId)
    {
        if (empty($token) || empty($payerId)) {
            return [
                'status' => 'error',
                'message' => 'Invalid token or payer ID',
            ];
        }
        $request = new OrdersCaptureRequest($token);
        $request->prefer('return=representation');
        try {
            $result = $this->client->execute($request);
            return [
                'status' => 'success',
                'data' => $result->result
            ];
        } catch (HttpException $ex) {
            log_message('error', 'PayPal Payment Capture Error: ' . $ex->statusCode . ' ' . $ex->getMessage());
            return [
                'status' => 'error',
                'message' => 'PayPal Payment Capture Error: ' . $ex->statusCode . ' ' . $ex->getMessage(),
            ];
        }
    }
}
