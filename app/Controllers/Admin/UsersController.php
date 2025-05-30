<?php
namespace App\Controllers\Admin;

use App\Controllers\Admin\MyAdminController;
use App\Models\Admin\UsersModel as MainModel;
use App\Requests\Admin\UsersRequest as MainRequest;

class UsersController extends MyAdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->path_view_controller = 'admin/pages/users/';
        $this->controller_name     = 'users';
        $this->model              = new MainModel();
        $this->main_request        = new MainRequest();

        $this->tb_columns = [
            "id"               => ['name' => '#',             'class'       => 'text-center'],
            "user"             => ['name' => 'Customer',      'class'       =>  'text-center'],
            "total_order"      => ['name' => 'Total Order',       'class'     => 'text-center'],
            "total_spent"      => ['name' => 'Total Spent',       'class'     => 'text-center'],
            "ip_address"       => ['name' => 'History IP',    'class' =>      'text-center'],
            "note"             => ['name' => 'Note',          'class'  =>  'text-center'],
            "last_order"       => ['name' => 'Last Order',       'class' =>  'text-center'],
            "created"          => ['name' => 'created',       'class' =>  'text-center'],
        ];
        $this->load_files = [
            "jsFiles" => [
                'scripts' => [
                    'tinymce' =>  'assets/plugins/tinymce/tinymce.min.js',
                ]
            ],
        ];
        $this->page_title = [
            'title' => 'Customers',
            'right' => ['type' => '', 'action' => ''],
        ];
    }

    public function add_note($id = null)
    {   
        // Get form
        if (is_ajax_get_request()) {
            $item = null;
            if ($id !== null) {
                $item = $this->model->get_item(['id' => sanitize_input($id)], ['task' => 'get-item']);
            }
            return view($this->path_view_controller . 'add_note', [
                'controller_name' => $this->controller_name,
                'item' => $item,
                'js_validation_config' => $this->main_request->js_validation_config('add_note'),
            ]);
        }
        if (is_ajax_post_request()) {
            $this->params = [
                'post_input' => $this->request->getPost(),
            ];
            $validations = $this->main_request->validateData($this->request, 'add_note');
            if (isset($validations['status']) && $validations['status'] == 'error') return json_response($validations);
            $task = 'edit-item';
            $this->params['success_msg'] = 'Updated Successfully!';
            $result = $this->model->save_item($this->params, ['task' => $task]);
            json_response($result);
        }
    }

    public function send_mail($id = null)
    {   
        // Get form
        if (is_ajax_get_request()) {
            $item = null;
            if ($id !== null) {
                $item = $this->model->get_item(['id' => sanitize_input($id)], ['task' => 'get-item']);
            }
            return view($this->path_view_controller . 'send_mail', [
                'controller_name' => $this->controller_name,
                'item' => $item,
                'js_validation_config' => $this->main_request->js_validation_config('send_mail'),
            ]);
        }
        // Action
        if (is_ajax_post_request()) {
            $validations = $this->main_request->validateData($this->request, 'send_mail');
            if (!empty($validations)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'type' => 'validation',
                    'errors' => $validations,
                ]);
            }
            $to = get_post('mail_to');
            $subject = get_post('subject');
            $message = $this->request->getPost('message');
            $message = sanitize_output($message);

            //Check item
            $item = db_get('id', TB_USERS, ['id' => get_post('id'), 'email' => $to]);
            if (empty($item)) _validation('error', "User email doesn't exists");
            $send_email = send_email($to, $subject, $message);
            json_response($send_email);
        }
    }

}
