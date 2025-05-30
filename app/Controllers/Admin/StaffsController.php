<?php
namespace App\Controllers\Admin;

use App\Controllers\Admin\MyAdminController;
use App\Models\Admin\StaffsModel as MainModel;
use App\Requests\Admin\StaffsRequest as MainRequest;

use App\Libraries\PasswordHash;

class StaffsController extends MyAdminController
{
    private $password_hash;

    public function __construct()
    {
        parent::__construct();
        $this->path_view_controller = 'admin/pages/staffs/';
        $this->controller_name      = 'staffs';
        $this->model                = new MainModel();
        $this->main_request         = new MainRequest();

        $this->tb_columns = [];
        $this->load_files = [
            "jsFiles" => [
                'scripts' => []
            ],
        ];
        $this->page_title = [
            'title' => 'Staffs',
            'right' => ['type' => '', 'action' => ''],
        ];
        // Load PHPass
        $this->password_hash = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);
    }

    public function profile()
    {
        $data = [
            'controller_name'     => $this->controller_name,
            'load_files'          => $this->load_files,
            'item'                => db_get('*', TB_STAFFS, ['id' => get_logged_in_user_info('sid')]),
        ];
        if ($this->request->getMethod(true) == 'GET') {
            if (!$data['item']) redirect(admin_url('logout'));
            return view($this->path_view_controller . 'profile', $data);
        }
        if (is_ajax_post_request()) {
            
            $action_type = (in_array(get_post('task'), ['change_password', 'account_info'])) ? get_post('task') : 'account_info';
            $validations = $this->main_request->validateData($this->request, $action_type);
            if (isset($validations['status']) && $validations['status'] == 'error') return json_response($validations);
            $this->params = [
                'input_posts' => $this->request->getPost(),
                'action_type' => $action_type,
            ];
            if ($action_type === 'change_password') {
                $new_hash_password = $this->password_hash->HashPassword(get_post('password'));
                $this->params['input_posts']['new_password'] = $new_hash_password;

                if (!$this->password_hash->CheckPassword(get_post('current_password'), $data['item']['password'])) {
                    _validation('error', 'Your current password is not correct. Please re-enter the correct password.');
                }
                // verify old pass and new
                if ($this->password_hash->CheckPassword($new_hash_password, $data['item']['password'])) {
                    _validation('error', 'The new password cannot be the same as your current password. Please enter a unique password.');
                }
            } 
            $result = $this->model->save_item($this->params, ['task' => 'update-profile']);
            json_response($result);
        }
    }
  
    public function login()
    {
        if (check_admin_status()) {
            return  redirect()->to(admin_url('services', true));
        } 
        $data = [
            'controller_name'     => $this->controller_name,
            'load_files'          => $this->load_files,
        ];
        if (is_ajax_post_request()) {
            $validations = $this->main_request->validateData($this->request, 'login');
            if (isset($validations['status']) && $validations['status'] == 'error') return json_response($validations);

            // / recaptcha
            verify_recaptcha_from_request('admin_login_form'); 

            $item = $this->model->get_item(['email' => get_post('email')], ['task' => 'get-item-by-email']);

            if(!$item) _validation('error', 'The email address and password you entered do not match any account. Please verify your details and try again');
            if (!$item['status']) _validation('error', 'Your account has not been activated');

            if($item && $this->password_hash->CheckPassword(get_post('password'), $item['password'])) {
                $item_user_login = [
                    'is_logged_in'  => true,
                    'is_admin'      => true,
                    'sid'           => $item['id'],
                    'timezone'      => $item['timezone'],
                ];
                session_set('user', $item_user_login);
                json_response([
                    'status' => 'success', 
                    'message' => 'Login successfully',
                    'redirect_url' => admin_url('services')
                ]);
            } else {
                _validation('error', 'The email address and password you entered do not match any account. Please verify your details and try again');
            };
        }

        if ($this->request->getMethod(true) == 'GET') {
            return view($this->path_view_controller . 'login', $data);
        }

    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(admin_url('login'));
    }
    
}
