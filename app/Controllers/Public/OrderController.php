<?php
namespace App\Controllers\Public;

use App\Models\Public\OrderModel as MainModel;
use App\Requests\Public\OrderRequest as MainRequest;

class OrderController extends MyPublicController
{
    protected $reviews_limit_per_page;
    protected $cart_name;
    protected $unsuccess_url;
    protected $thank_you_url;
    protected $payment_gateway;

    public function __construct()
    {
        parent::__construct();
        $this->path_view_controller = 'themes/regular/';
        $this->controller_name = 'home';
        $this->model = new MainModel();
        $this->main_request = new MainRequest();
        $this->load_files = [];
        $this->page_title = [
            'right' => ['type' => '', 'action' => ''],
        ];
        $this->reviews_limit_per_page = 3;
        $this->cart_name = 'cart';
        $this->unsuccess_url = client_url('payment-failed');
        $this->thank_you_url = client_url('payment-success');
    }

    public function index()
    {
        $cate_ids = get('cid');
        $s_ids = get('sid');
        $item = db_get('id, ids, cate_id', TB_SERVICES, ['ids' => $s_ids, 'status' => 1]);
        if (empty($item)) {
            return redirect()->to(base_url());
        };
        $items_related = db_fetch('id, ids, cate_id, name, price, quantity', TB_SERVICES, ['cate_id' => $item['cate_id'], 'status' => 1], 'price', 'ASC');
        $required_field_name = $this->model->get_required_field_name(['cate_id' => $item['cate_id']]);
        if (!empty($item) && !empty($items_related)) {
            $view_data = [
                'controller_name' => $this->controller_name,
                'path_view_controller' => $this->path_view_controller,
                'item_main' => $item,
                'items_related'         => $items_related,
                'required_field_name'    => $required_field_name,
            ];
            return view($this->path_view_controller . 'order_page', $view_data);
        } else {
            show_404_page();
        }
    }

    public function order_collect()
    {
        if (!is_ajax_post_request()) {
            show_404_page();
        }
        $email = get_post('email');
        $link = get_post('link');
        $service_ids = get_post('service_ids');

        $validations = $this->main_request->validateData($this->request, 'order_collect');
        if (!empty($validations)) {
            json_response([
                'status' => 'error',
                'type' => 'validation',
                'message' => __l("Please_make_sure_all_fields_are_filled_out_correctly"),
                'errors' => $validations,
            ]);
        }

        verify_recaptcha_from_request('order_form');

        // Blacklisted 
        $check_blacklist = $this->model->check_blacklist();
        if (isset($check_blacklist['status']) && $check_blacklist['status']) {
            json_response([
                'status' => 'error',
                'message' => __l("Your_request_cannot_be_processed_at_this_time_Please_try_again_later"),
            ]);
        }

        $item_db = db_get('id, ids, name, price, quantity', TB_SERVICES, ['ids' => $service_ids]);
        if (empty($item_db)) {
            json_response([
                'status' => 'error',
                'message' => __l("Invalid_service_package_Please_check_again"),
            ]);
        }
        $cart = session_get($this->cart_name) ?? [];
        $items = [];
        $new_item = [
            'service_ids'   => $service_ids,
            'link'          => $link,
            'quantity'      => $item_db['quantity'],
            'sub_total'     => $item_db['price'],
        ];
        $existing_service_ids = array_column($cart['items'] ?? [], 'service_ids');

        if (in_array($new_item['service_ids'], $existing_service_ids)) {
            // json_response([
            //     'status' => 'error',
            //     'message' => 'Item already exists in the cart',
            // ]);
        }
        $cart = [
            'email'         => $email,
            'item'          => $new_item,
            'total_charge'  => $item_db['price'],
        ];
        session_set($this->cart_name, $cart);
        $saved_cart = session_get($this->cart_name);
        if ($saved_cart !== null && $saved_cart['email'] == $email && count($saved_cart['item']) > 0) {
            json_response([
                'status' => 'success',
                'message' => __l("Your_order_has_been_successfully_added_to_the_cart_Please_wait_you_will_be_redirected_to_the_checkout_page_shortly"),
                'redirect_url' => client_url('checkout'),
            ]);
        } else {
            json_response([
                'status' => 'error',
                'message' => __l("There_was_an_issue_saving_your_cart_Please_try_again_or_refresh_the_page"),
            ]);
        }

    }

    public function checkout()
    {
        $cart = session_get($this->cart_name);
        if (empty($cart) || empty($cart['item'])) {
            return redirect()->to(client_url(''));
        }
        $item_db_service_in_cart = db_get('*', TB_SERVICES, ['status' => 1, 'ids' => $cart['item']['service_ids']]);
        if (empty($item_db_service_in_cart)) {
            session_remove($this->cart_name);
            return redirect()->to(client_url(''));
        }
        $items_payments = db_fetch('id, name, type', TB_PAYMENTS_METHOD, ['status' => 1, 'type !=' => 'free'], 'sort', 'ASC'); 
        $view_data = [
            'controller_name'       => $this->controller_name,
            'path_view_controller'  => $this->path_view_controller,
            'cart_name'             => $this->cart_name,
            'item_db_service'       => $item_db_service_in_cart,
            'items_payments'        => $items_payments,
        ];
        $data_content = view($this->path_view_controller . 'pages/order/checkout', $view_data);

        return view($this->path_view_controller . 'order', ['data_content' => $data_content]);

    }

    public function checkout_process()
    {
        if (!is_ajax_post_request())  return redirect()->to(client_url(''));
        $cart = session_get($this->cart_name);
        if (empty($cart) || empty($cart['item'])) {
            json_response([
                'status' => 'error',
                'message' => __l("There_was_an_issue_saving_your_cart_Please_try_again"),
                'redirect_url' => client_url('checkout'),
            ]);
        }
        $validations = $this->main_request->validateData($this->request, 'checkout_process');
        if (!empty($validations)) {
            json_response([
                'status' => 'error',
                'type' => 'validation',
                'message' => __l("Please_make_sure_all_fields_are_filled_out_correctly"),
                'errors' => $validations,
            ]);
        }

        // recaptcha
        verify_recaptcha_from_request('checkout_form');

        // check service ids
        $item_db_service_in_cart = db_get('*', TB_SERVICES, ['status' => 1, 'ids' => $cart['item']['service_ids']]);
        if (empty($item_db_service_in_cart)) {
            session_remove($this->cart_name);
            json_response([
                'status' => 'error',
                'type' => 'validation',
                'message' => __l("There_was_an_issue_with_your_cart_Please_place_your_order_again"),
                'errors' => $validations,
            ]);
        }
        // check link
        if (!isset($cart['item']['link'])) {
            session_remove($this->cart_name);
            json_response([
                'status' => 'error',
                'type' => 'validation',
                'message' => __l("There_was_an_issue_with_your_cart_Please_place_your_order_again"),
                'errors' => $validations,
            ]);
        }

        // check payment
        $item_payment = db_get('id, name, type, params', TB_PAYMENTS_METHOD, ['type' => get_post('payment_method'), 'status' => 1]);
        if (empty($item_payment)) {
            json_response(['status' => 'error', 'message' => __l("The_selected_payment_option_is_not_available")]);
        }
        $load_payment_gateway = $this->load_payment_gateway($item_payment['type']);
        if (!$load_payment_gateway['status']) {
            json_response(['status' => 'error', 'message' => __l("We_are_unable_to_process_your_payment_at_the_moment_Please_try_again_later")]);
        }
        $original_amount = $item_db_service_in_cart['price'];
        $total_charge = $original_amount;
        $discount_value = null;
        $coupon_code = null;
        // Apply coupon 
        $coupon_code = get_post('coupon_code');
        if ($coupon_code) {
            $item_coupon = db_get('id, ids, code, discount_value, discount_type, start_date, end_date', TB_COUPONS, ['code' => $coupon_code, 'status' => 1, 'start_date <=' => NOW, 'end_date >=' => NOW]);
            if (empty($item_coupon)) {
                json_response(['status' => 'error', 'message' => __l("Invalid_or_expired_coupon_code_Please_try_again_later")]);
            }
            if ($item_coupon['discount_type'] == 'percentage') {
                $discount_value = ($original_amount * $item_coupon['discount_value']) / 100;
            } else if ($coupon['discount_type'] == 'fixed') {
                $discount_value = $item_coupon['discount_value'];
            }
            $total_charge = $original_amount - $discount_value;
        }

        // insert link to item_db_service_in_cart
        $item_db_service_in_cart['link'] = $cart['item']['link'];

        $tnx_payment = [
            'total_charge' => $total_charge,
            'item' => $item_db_service_in_cart, 
        ];
        // Process to payment gateway
        $result = $this->payment_gateway->create_payment($tnx_payment);
        if (isset($result['status']) ) {
            if ($result['status'] == 'success') {
                session_remove($this->cart_name);
                $send_payment_data =  $result['send_payment_data'];
                $data_tnx = [
                    'amount'            => $total_charge,
                    'original_amount'   => $original_amount,
                    'discount_value'    => $discount_value,
                    'coupon_code'       => $coupon_code,
                    'type'              => $item_payment['type'],
                    'transaction_id'    => (isset($result['transaction_id'])) ? $result['transaction_id'] : ids(),
                    'tnx_fee'           => (!empty($result['tnx_fee'])) ? $result['tnx_fee'] : 0,
                    'data_details'      => (!empty($result['data_details'])) ? $result['data_details'] : '',
                    'status'            => (isset($result['tnx_status'])) ? $result['tnx_status'] : 0,
                ];
                $data_order = [
                    'item_service' => $item_db_service_in_cart
                ];
                $response = $this->model->created_order_and_transaction($data_order, $data_tnx);
                if (isset($response['status']) && $response['status'] == 'success') {
                    if (isset($result['redirect_url'])) {
                        json_response([
                            'status' => 'success',
                            'message' => __l("Please_wait_a_moment_you_will_be_redirected_to_the_payment_page"),
                            'redirect_url' => $result['redirect_url'],
                        ]);
                    }
                    
                    if (isset($result['html_update'])) {
                        json_response([
                            'status' => 'success',
                            'message' => __l("Please_wait_a_moment_you_will_be_redirected_to_the_payment_page"),
                            'html_update' => $result['html_update'],
                        ]);
                    }

                    if (isset($result['js_content'])) {
                        json_response([
                            'status' => 'success',
                            'message' => __l("Please_wait_a_moment_you_will_be_redirected_to_the_payment_page"),
                            'js_content' => $result['js_content'],
                        ]);
                    }

                } else {
                    json_response([
                        'status' => 'error',
                        'message' => __l("There_was_an_issue_creating_your_checkout_Please_try_again"),
                    ]);
                }
            } 
        } else {
            json_response([
                'status' => 'error',
                'message' => __l("There_was_an_issue_creating_your_checkout_Please_try_again"),
            ]);
        }
    }

    public function checkout_complete($type) {
        $error = false;
        $item_payment_type =  sanitize_input($type);
        // check payment
        $item_payment = db_get('id, name, type, params', TB_PAYMENTS_METHOD, ['type' => $item_payment_type, 'status' => 1]);
        if (empty($item_payment)) {
            return redirect()->to(client_url(''));
        }
        $load_payment_gateway = $this->load_payment_gateway($item_payment['type']);
        if (!$load_payment_gateway['status']) {
            return redirect()->to(client_url(''));
        }
        
        $result = $this->payment_gateway->verify_payment();
        if (isset($result['status']) && $result['status'] == 'success' && isset($result['verify_tnx_data']) && isset($result['item_transaction'])) {
            $verify_tnx_data = $result['verify_tnx_data'];
            $item_transaction = $result['item_transaction'];
            $response = $this->model->update_transaction_and_order($item_transaction, $verify_tnx_data);
            if ($response['is_thank_you_page']) {
                return redirect()->to($this->thank_you_url . '/' . $item_transaction['ids']);
            } else {
                return redirect()->to($this->unsuccess_url);
            }
        } else {
            return redirect()->to($this->unsuccess_url);
        }
    }

    public function handle_payment_ipn($type = '') {
        $item_payment_type =  sanitize_input($type);
        // check payment
        $item_payment = db_get('id, name, type, params', TB_PAYMENTS_METHOD, ['type' => $item_payment_type, 'status' => 1]);

        if (empty($item_payment)) {
            return $this->response->setStatusCode(200);
        }

        $load_payment_gateway = $this->load_payment_gateway($item_payment['type']);
        if (!$load_payment_gateway['status']) {
            return $this->response->setStatusCode(200);
        }

        if (!method_exists($this->payment_gateway, 'ipn')) {
            return $this->response->setStatusCode(200);
        }

        $result = $this->payment_gateway->verify_ipn();
        if (isset($result['status']) && $result['status'] == 'success' && isset($result['verify_tnx_data']) && isset($result['item_transaction'])) {
            $verify_tnx_data = $result['verify_tnx_data'];
            $item_transaction = $result['item_transaction'];
            $response = $this->model->update_transaction_and_order($item_transaction, $verify_tnx_data);
            return $this->response->setStatusCode(200);
        } else {
            return $this->response->setStatusCode(200);
        }
    }

    public function checkout_apply_coupon()
    {
        $response = ['status' => '', 'message' => ''];
        if (!is_ajax_post_request())  return redirect()->to(client_url(''));
        $cart = session_get($this->cart_name);
        if (empty($cart) || empty($cart['item'])) {
            json_response([
                'status' => 'error',
                'message' => 'Unable to apply the coupon at this time. Please try again later',
                'redirect_url' => client_url(''),
            ]);
        }
        $sub_total = null;
        $coupon_amount = null;
        $discount_percentage = null;
        $new_total_charge = $cart['item']['sub_total']; //Original total charge
        // Check if coupon code is provided
        $coupon_code = get_post('coupon_code');
        if (empty($coupon_code)) {
            $response = ['status' => 'error', 'message' => 'Coupon code is required.'];
        }
        $item_coupon = db_get('id, ids, code, discount_value, discount_type, start_date, end_date', TB_COUPONS, ['code' => $coupon_code, 'status' => 1, 'start_date <=' => NOW, 'end_date >=' => NOW]);
        if (empty($item_coupon)) {
            $response = ['status' => 'error', 'message' => 'Invalid or expired coupon code'];
        }
        // check service ids
        $item_db_service_in_cart = db_get('*', TB_SERVICES, ['status' => 1, 'ids' => $cart['item']['service_ids']]);
        if (empty($item_db_service_in_cart)) {
            $response = ['status' => 'error', 'message' => 'Unable to apply the coupon at this time. Please try again later'];
        } 

        if ($item_coupon && $item_db_service_in_cart) {
            $sub_total = $item_db_service_in_cart['price'];
            // Calculate the discount based on coupon type
            $discount_value = 0;
            if ($item_coupon['discount_type'] == 'percentage') {
                $discount_value = ($sub_total * $item_coupon['discount_value']) / 100;
            } else if ($coupon['discount_type'] == 'fixed') {
                $discount_value = $item_coupon['discount_value'];
            }
            $new_total_charge = $sub_total - $discount_value;
            $coupon_amount = $discount_value;
            $discount_percentage = $item_coupon['discount_value'];
            // Update cart 
            $cart['coupon_code'] = $coupon_code;
            $cart['total_charge'] = $new_total_charge;
            $cart['discount_value'] = $discount_value;
            session_set($this->cart_name, $cart);
            $response = ['status' => 'success', 'message' => 'Coupon code applied successfully!'];
        }

        $data_view = [
            'sub_total' => $sub_total,
            'coupon_amount' => $coupon_amount,
            'discount_percentage' => $discount_percentage,
            'new_total_charge' => $new_total_charge,
        ];
        $html_content = view($this->path_view_controller . 'pages/order/apply_coupon_details', $data_view);
        $response['html_update'] = [
            'action_type' => 'replaceWith',
            'html_content' => $html_content,
            'target_selector' => '.total-price-detail',
        ];
        json_response($response);
    }

    private function load_payment_gateway($payment_type)
    {
        $gatewayFile = APPPATH . 'Controllers/Public/PaymentsGateway/' . $payment_type . '.php';
        if (!file_exists($gatewayFile)) {
            return ['status' => false, 'message' => 'The payment gateway file does not exist.'];
        }
        require_once $gatewayFile;
        $gateway_class = 'App\\Controllers\\Public\\PaymentsGateway\\' . $payment_type;
        if (!class_exists($gateway_class)) {
            return ['status' => false, 'message' => 'The payment gateway class does not exist.'];
        }
        $this->payment_gateway = new $gateway_class();
        return ['status' => true, 'message' => 'Payment gateway loaded successfully'];
    }

    // success page
    public function checkout_success($tnx_ids = '')
    {
        $transaction_ids = sanitize_input($tnx_ids);
        if (empty($transaction_ids)) {
            return redirect()->to(client_url(''));
        }
        $item_transaction = db_get('id, ids, type, transaction_id , amount, order_id', TB_TRANSACTION_LOGS, ['ids' => $transaction_ids]);
        if (empty($item_transaction)) {
            return redirect()->to(client_url(''));
        }
        // $item_order = db_get('id, ids, link, quantity, client_order_id', TB_ORDERS, ['id' => $item_transaction['order_id']]);
        // $data['transaction_ids'] = $transaction_ids;

        // send notifications
        $item_order = $this->model->get_item_order_details($item_transaction['order_id']);
        if (!empty($item_order)) {
            // send_email to admin
            $merge_fields = $item_order;
            $send_email_to_customer = send_notification('new_order_notification_to_customer', $merge_fields);
            $send_email_to_admin    = send_notification('new_order_notification_to_admin', $merge_fields);
        }

        $view_data = [
            'controller_name'       => $this->controller_name,
            'path_view_controller'  => $this->path_view_controller,
            'item_transaction'      => $item_transaction,
            'item_order'            => $item_order,
        ];
        $data_content = view($this->path_view_controller . 'pages/order/checkout_success', $view_data);
        return view($this->path_view_controller . 'order', ['data_content' => $data_content]);
    }

    // un success page
    public function checkout_unsuccess()
    {
        $view_data = [
            'controller_name'       => $this->controller_name,
            'path_view_controller'  => $this->path_view_controller,
        ];
        $data_content = view($this->path_view_controller . 'pages/order/checkout_unsuccess', $view_data);
        return view($this->path_view_controller . 'order', ['data_content' => $data_content]);
    }

    // Track order
    public function track_order()
    {
        if (!is_ajax_post_request()) {
            $view_data = [
                'controller_name'       => $this->controller_name,
                'path_view_controller'  => $this->path_view_controller,
            ];
            $data_content = view($this->path_view_controller . 'pages/order/track_order', $view_data);
            return view($this->path_view_controller . 'order', ['data_content' => $data_content]);

        } else {
            $validations = $this->main_request->validateData($this->request, 'track_order');
            if (!empty($validations)) {
                json_response([
                    'status' => 'error',
                    'type' => 'validation',
                    'message' => 'Please make sure all fields are filled out correctly',
                    'errors' => $validations,
                ]);
            }

            // recaptcha
            verify_recaptcha_from_request('track_order_form');

            $item_order = $this->model->track_order_by_email_and_orderid(get_post('email'), get_post('order_id'));
            if (empty($item_order)) {
                json_response([
                    'status' => 'error',
                    'message' => 'Unfortunately, no order could be found matching the provided Order ID and Email. Please verify the details and try again.',
                ]);
            }
            $html_content = view($this->path_view_controller . 'pages/order/track_order_details', ['item_order' => $item_order]);
            $response = [
                'status' => 'success',
                'message' => 'Your order was found successfully. The order details are as follows',
            ];
            $response['html_update'] = [
                'action_type' => 'replaceWith',
                'html_content' => $html_content,
                'target_selector' => '#track-order-details',
            ];
            json_response($response);
        }
    }
}
