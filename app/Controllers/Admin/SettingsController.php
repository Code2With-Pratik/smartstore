<?php
namespace App\Controllers\Admin;

use App\Controllers\Admin\MyAdminController;
use App\Models\Admin\SettingsModel as MainModel;
use App\Requests\Admin\SettingsRequest as MainRequest;

class SettingsController extends MyAdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->path_view_controller = 'admin/pages/settings/';
        $this->controller_name     = 'settings';
        $this->model              = new MainModel();
        $this->main_request       = new MainRequest();
        $this->tb_columns = [];
        $this->load_files = [
            "cssFiles"   => get_plugin_css_js_path(['jquery_ui', 'codemirror_lib', 'codemirror_theme', 'flags_docs', 'flags', 'tagsinput'], 'css'),
            "jsFiles" => [
                'head' => get_plugin_css_js_path(['jquery_ui']),
                'scripts' => get_plugin_css_js_path(['tinymce', 'notify', 'codemirror_lib', 'codemirror_theme', 'flags', 'tagsinput']), 
            ],
        ];
        $this->page_title = [
            'title' => 'Settings',
            'right' => ['type' => 'addButton', 'action' => 'ajaxModal'],
        ];
    }

    public function index()
    {
        $tab_key = segment(3);
        $sidebar = array_keys(config('AppConfig')->admin_setting['sidebar']);
        if (!in_array($tab_key, $sidebar)) {
            $tab_key = 'website_setting';
        }
        $tab_content = view($this->path_view_controller . '/tab_content', [
            'controller_name'       => $this->controller_name,
            'path_view_controller'  => $this->path_view_controller,
            'tab_key'               => $tab_key,
            'js_validation_config'  => $this->main_request->js_validation_config('update'),
        ]);

        return view($this->path_view_controller . 'index', [
            'controller_name'       => $this->controller_name,
            "tab_content"           => $tab_content,
            'load_files'            => $this->load_files,
            'path_view_controller'  => $this->path_view_controller,
        ]);
    }

    public function store()
    {
        if (is_ajax_post_request()) {
            $this->params = [
                'post_input' => $this->request->getPost(),
            ];
            $tab_key = get_post('tab_key') ?? '';
            $validations = $this->main_request->validateData($this->request, '');
            if (!empty($validations)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'type' => 'validation',
                    'message' => ($tab_key === 'header_footer') ? implode('<br>', array_values($validations)) : 'Please complete all required fields',
                    'errors' => $validations,
                ]);
            }

            $task = 'edit-item';
            $result = $this->model->save_item($this->params, ['task' => $task]);

            cache_delete(get_cache_key('general_settings'));
            json_response($result);
        }
    }

    public function send_test_mail()
    {   
        // Get form
        if (is_ajax_get_request()) {
            return view($this->path_view_controller . 'send_test_mail', [
                'controller_name' => $this->controller_name,
                'js_validation_config' => $this->main_request->js_validation_config('send_test_mail'),
            ]);
        }
        // Action
        if (is_ajax_post_request()) {

            $validations = $this->main_request->validateData($this->request, 'send_test_mail');
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
            $send_email = send_email($to, $subject, $message);
            json_response($send_email);
        }
    }

    public function cronjobs()
    {
        $data_views = [
            'controller_name'       => $this->controller_name,
            'load_files'            => $this->load_files,
        ];
        return view($this->path_view_controller . '/cronjobs', $data_views);
    }
}
