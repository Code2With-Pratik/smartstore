<?php
namespace App\Controllers\Public\PaymentsGateway;

class payeer
{
    private $payment_type;
    private $environment;
    private $pm_details;
    private $convert_rate;
    private $currency_code;

    public $merchant_id;
    public $secret_key;
    public $pm_url;

    public function __construct($payment = [])
    {
        $this->payment_type = 'payeer';
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
        $this->currency_code    = 'USD';
        $this->pm_details       = get_value_by_key($option, 'pm_details');

        $this->merchant_id = get_value_by_key($option, 'merchant_id');
        $this->secret_key     = get_value_by_key($option, 'secret_key');

        if (empty($this->merchant_id) || empty($this->secret_key)) {
            json_response([
                'status' => 'error',
                'message' => 'The selected payment option is not available',
            ]);
        }
        $this->pm_url = 'https://payeer.com/merchant/';
    }
    
    public function create_payment($tnx_payment = [])
    {
        $amount = $tnx_payment['total_charge'] * $this->convert_rate;
        $m_shop    = $this->merchant_id;
        $m_orderid = "ORDS" . strtotime(NOW);
        $m_amount  = number_format($amount, 2, '.', '');
        $m_curr    = $this->currency_code;
        $m_desc    = base64_encode(get_post('email') . ' - ' . $this->pm_details);

        $m_key     = $this->secret_key;
        $arHash = [
            $m_shop,
            $m_orderid,
            $m_amount,
            $m_curr,
            $m_desc
        ];
        
        $arHash[] = $m_key;
        $sign = strtoupper(hash('sha256', implode(':', $arHash)));
        $params = [
            "m_shop" 		         => $m_shop,
            "m_orderid" 			 => $m_orderid,
            "m_amount" 	             => $m_amount,
            "m_curr" 	             => $m_curr,
            'm_desc'                 => $m_desc,
            'm_sign'                 => $sign,
        ];
        $response = [
            'status' => 'success',
            'send_payment_data' => $params,
            'transaction_id' => $m_orderid,
            'tnx_status' => 0,
            'html_update' => [
                'action_type' => 'after',
                'html_content' => generate_payment_form_html($params, $this->pm_url),
                'target_selector' => 'form.sendForm',
            ],
        ];
        return $response;
    }

    public function verify_payment()
    {
        if (array_diff(['m_orderid', 'm_shop', 'm_amount', 'm_status'], array_keys($_REQUEST))) {
            return [
                'status' => 'error',
                'message' => 'Invalid request',
            ];
        }
        $m_key = $this->secret_key;
        $arHash = [
            $_REQUEST['m_operation_id'],
            $_REQUEST['m_operation_ps'],
            $_REQUEST['m_operation_date'],
            $_REQUEST['m_operation_pay_date'],
            $_REQUEST['m_shop'],
            $_REQUEST['m_orderid'],
            $_REQUEST['m_amount'],
            $_REQUEST['m_curr'],
            $_REQUEST['m_desc'],
            $_REQUEST['m_status']
        ];

        if (isset($_REQUEST['m_params'])) {
            $arHash[] = $_REQUEST['m_params'];
        }

        $arHash[] = $m_key;
        $sign_hash = strtoupper(hash('sha256', implode(':', $arHash)));

        $tnx_id = strip_tags($_REQUEST['tnx_id']);
        if (empty($tnx_id)) {
            return [
                'status' => 'error',
                'message' => 'Invalid request',
            ];
        }
        
        $db_where = [
            'transaction_id' => $tnx_id,
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

        $response = sanitize_input($_REQUEST);
        
        $verify_tnx_data = [
            'status' => 'pending',
            'new_tnx_id' => '',
            'update_new_tnx_id' => false,
        ];

        if ($sign_hash == $_REQUEST['m_sign'] && $_REQUEST['m_status'] == 'success' && $_REQUEST['m_shop'] == $this->merchant_id) {
            $verify_tnx_data['status'] = TNX_STATUS_PAID;
            $verify_tnx_data['data_details'] = sanitize_input($_REQUEST);
        }
        

        $response = [
            'status' => 'success',
            'verify_tnx_data' => $verify_tnx_data,
            'item_transaction' => $transaction_exists,
        ];
        return $response;
    }

    public function verify_ipn() {
        return $this->verify_payment();
    }
}
