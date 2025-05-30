<?php
namespace App\Controllers\Public;

use App\Models\Public\ClientModel as MainModel;
use App\Requests\Public\ClientRequest as MainRequest;

class ClientController extends MyPublicController
{
    public function __construct()
    {
        parent::__construct();
        $this->path_view_controller = 'themes/regular/';
        $this->controller_name      = 'home';
        $this->model                = new MainModel();
        $this->main_request         = new MainRequest();
        $this->load_files           = [];
        $this->page_title           = [
            'right' => ['type' => '', 'action' => ''],
        ];
    }

    // Submit a new review from the client
    public function submit_review()
    {
        if (is_ajax_post_request()) { 
            $validations = $this->main_request->validateData($this->request, 'submit_review');
            if (!empty($validations)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'type' => 'validation',
                    'errors' => $validations,
                ]);
            }

            // / recaptcha
            verify_recaptcha_from_request('review_form'); 


            $ip_address = $this->request->getIPAddress();
            $data_item = [
                'name' => sanitize_input($this->request->getPost('name')),
                'email' => get_post('email'),
                'client_order_id' => get_post('client_order_id'),
                'rating' => (int)get_post('rating'),
                'comment' => sanitize_input($this->request->getPost('review_text')),
                'ip' => $ip_address,
                'status' => 2,
                'last_submission_time' => NOW,
                'changed' => NOW,
            ];
            $existing_item  = db_get('id, ids, last_submission_time', TB_REVIEWS, ['client_order_id' => get_post('client_order_id')]);
            $check_order_id = db_get('id, cate_id', TB_ORDERS, ['client_order_id' => get_post('client_order_id')]);
            if (!empty($check_order_id)) {
                $data_item['options'] = json_encode(['note' => 'Valid Order ID']);
                $data_item['cate_id'] = $check_order_id['cate_id'];
            } else {
                $data_item['options'] = json_encode(['note' => 'Invalid Order ID']);
            }
            if (!empty($existing_item)) {
                $last_submission_time = strtotime($existing_item['last_submission_time']);
                $current_time = time();
                $time_diff = ($current_time - $last_submission_time) / 3600; 
                if ($time_diff < 24) {
                    $response = [
                        'status' => 'error',
                        'message' => __l("Youve_already_submitted_a_review_for_this_order_Please_allow_some_time_before_posting_another_review"),
                    ];
                } else {
                    $result = db_update(TB_REVIEWS, $data_item, ['id' => $existing_item['id']]);
                    $response = handle_db_operation_result($result, 'updated', 'error', [
                        'updated' => __l("Thank_you_Your_review_has_been_successfully_updated"), 
                        'error' => __l("An_error_occurred_Please_try_again_later")
                    ]);
                }
            } else {
                $data_item['ids'] = ids();
                $result = db_insert(TB_REVIEWS, $data_item);
                $response = handle_db_operation_result($result, 'added', 'error', [
                    'added' => __l("Thank_you_Your_review_has_been_successfully_updated"), 
                    'error' => __l("An_error_occurred_Please_try_again_later")
                ]);
            }
            return $this->response->setJSON($response);
        }
    }

    // submit contact us form
    public function submit_contact_us()
    {
        if (is_ajax_post_request()) { 
            $validations = $this->main_request->validateData($this->request, 'contact_us');
            if (!empty($validations)) {
                return json_response([
                    'status' => 'error',
                    'type' => 'validation',
                    'errors' => $validations,
                ]);
            }

            // recaptcha
            verify_recaptcha_from_request('contact_form'); 

            $subject = get_post('subject');
            switch ($subject) {
                case 'order_id':
                    $subject = "Order ID - ". get_post("order_id");
                    break;
                case 'payment':
                    $subject = "Payment -". get_post("transaction_id");
                    break;
            }
            $data_item_ticket = [
                'ids' 	            => ids(),
                'name' 	            => get_post("name"),
                'from' 	            => get_post("email"),
                'subject' 	        => $subject,
                'message' 	        => get_post("message"),
                'read' 	            => 1,
                'ip'  	            => $this->request->getIPAddress(),
                'status'  	        => 'new',
                'created'  	        => NOW,
                'changed'  	        => NOW,
            ];
            $result = db_insert(TB_TICKETS, $data_item_ticket);
            
            // Send notification
            if (!empty($result)) {
                $merge_fields = [
                    'ticket_id'         => $result,
                    'subject'           => $subject,
                    'customer_email'    => get_post("email"),
                ];
                $send_email_to_admin   = send_notification('new_ticket_via_contact_form_to_admin', $merge_fields);
            }
            $response = handle_db_operation_result($result, 'added', 'error', [
                'added' => __l("Thank_you_Your_message_has_been_successfully_submitted"), 
                'error' => __l("An_error_occurred_Please_try_again_later")
            ]);
            return json_response($response);
        }
    }

    public function load_more_reviews()
    {
        if (is_ajax_get_request()) {
            $limit = $this->reviews_limit_per_page; 
            $page = get('page') ?: 1; 
            $offset = ($page - 1) * $limit; 
            $items_reviews = db_fetch('ids, name, email, rating, status, comment', TB_REVIEWS, ['status' => 1], 'id', 'DESC', $offset, $limit);
            $total_reviews = db_fetch('id', TB_REVIEWS, ['status' => 1]);
            $total_pages = ceil(count($total_reviews) / $limit);
            if ($items_reviews) {
                $html_content = view('themes/regular/sections/child/reviews_section/items_list', ['items_reviews' => $items_reviews]);;
                return json_response([
                    'status'        => 'success',
                    'has_more'      => $page < $total_pages,  
                    'html_update'   => [
                            'action_type' => 'append',
                            'html_content' => $html_content,
                            'target_selector' => '#reviews-content',
                        ],  
                    ]);
            } else {
                return json_response([
                    'status' => 'error',
                    'message' => 'No reviews available.', 
                ]);
            }
        }
    }
}
