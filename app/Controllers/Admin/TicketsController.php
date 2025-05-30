<?php
namespace App\Controllers\Admin;

use App\Controllers\Admin\MyAdminController;
use App\Models\Admin\TicketsModel as MainModel;
use App\Requests\Admin\TicketsRequest as MainRequest;

class TicketsController extends MyAdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->path_view_controller = 'admin/pages/tickets/';
        $this->controller_name     = 'tickets';
        $this->model              = new MainModel();
        $this->main_request        = new MainRequest();
        
        $this->tb_columns = [
            "id"          => ['name' => '#',             'class' =>      'text-center'],
            "from"        => ['name' => 'From',    'class' =>      ''],
            "subject"     => ['name' => 'Subject',      'class' =>      'text-center'],
            "ip"          => ['name' => 'IP Address',    'class' =>      'text-center'],
            "status"      => ['name' => 'Status',        'class' =>      'text-center'],
            "created"     => ['name' => 'created',       'class' =>      'text-center'],
        ];

        $this->load_files = [
            "jsFiles" => [
                'scripts' => [
                    'tinymce' =>  'assets/plugins/tinymce/tinymce.min.js',
                ]
            ],
        ];
        
        $this->page_title = [
            'title' => 'Tickets',
            'right' => ['type' => '', 'action' => ''],
        ];
    }

    
    public function send_mail($id = null)
    {   
        // Get form
        if (is_ajax_get_request()) {
            $item = null;
            if ($id !== null) {
                $item = db_get('id, ids, from, name, subject, message, reply_message, ip, status', TB_TICKETS, ['id' => sanitize_input($id)]);

                if (empty($item)) return false; 

                return view($this->path_view_controller . 'send_mail', [
                    'controller_name' => $this->controller_name,
                    'item' => $item,
                ]);
            }
        }
        // Action
        if (is_ajax_post_request()) {
            $id = get_post('id');
            $item = db_get('id, ids, from, name, subject, message, reply_message, ip, status', TB_TICKETS, ['id' => sanitize_input($id)]);
            if ($item !== null) {
                if (empty($item)) return false;
                $validations = $this->main_request->validateData($this->request);
                if (!empty($validations)) {
                    return json_response([
                        'status' => 'error',
                        'type' => 'validation',
                        'errors' => $validations,
                    ]);
                }
                $to         =  $item['from'];
                $subject    =  $item['subject'];
                $content    = $this->request->getPost('reply_message');
                $content    = sanitize_output($content);
                $send_mail  = send_email($to, $subject, $content);

                $data_item_ticket = [
                    'status'        => 'answered',
                    'reply_message' => $content,
                ];
                db_update(TB_TICKETS, $data_item_ticket, ['id' => $item['id']]);
                return json_response($send_mail);
            } else {
                return json_response([
                    'status'    => 'error',
                    'message'   => 'An error occurred. Please try again later',
                ]);
            }
        }
    }
}
