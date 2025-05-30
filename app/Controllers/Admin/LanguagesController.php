<?php
namespace App\Controllers\Admin;

use App\Controllers\Admin\MyAdminController;
use App\Models\Admin\LanguagesModel as MainModel;
use App\Requests\Admin\LanguagesRequest as MainRequest;

class LanguagesController extends MyAdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->path_view_controller = 'admin/pages/languages/';
        $this->controller_name     = 'languages';
        $this->model              = new MainModel();
        $this->main_request        = new MainRequest();

        $this->tb_columns = [
            "name"          => ['name' => 'Name',          'class' => 'text-center'],
            "code"          => ['name' => 'Code',          'class' => 'text-center'],
            "icon"          => ['name' => 'Icon',          'class' => 'text-center'],
            "default"       => ['name' => 'default',       'class' => 'text-center'],
            "status"        => ['name' => 'status',        'class' => 'text-center'],
            "changed"        => ['name' => 'status',        'class' => 'text-center'],
            "created"       => ['name' => 'Created',       'class' => 'text-center'],
        ];

        $this->load_files = [
            "cssFiles"   => [
                'flags' => 'assets/plugins/flags/css/docs.css',
                'flags2' => 'assets/plugins/flags/css/flag-icon.css'
            ],
            "jsFiles" => [
                'head' => [],
                'scripts' => [
                    'flags' =>  'assets/plugins/flags/js/docs.js',
                    'notify'  =>  'assets/plugins/notify/notify.min.js',
                ]
            ],
        ];
        
        $this->page_title = [
            'title' => 'Language',
            'right' => ['type' => 'addButton', 'action' => ''],
        ];
    }

    public function update($id = null)
    {   
        $item = null;
        $default_lang = get_language_data('en', 'default');
        $lang_by_code = [];
        if ($id !== null) {
            $item = db_get('*', TB_LANGUAGE_LIST, ['id' => sanitize_input($id)]);
            if (!empty($item)) {
                $lang_by_code = get_language_data($item ['code']);
            }
        }
        return view($this->path_view_controller . 'update', [
            'controller_name' => $this->controller_name,
            'item' => $item,
            'lang_by_code' => $lang_by_code,
            'default_lang' => $default_lang,
            'page_title'          => $this->page_title,
            'load_files'          => $this->load_files,
            'path_view_controller' => $this->path_view_controller,
        ]);
    }


    public function store()
    {
        if (is_ajax_request() && is_request_method('POST')) {
            $this->params = [
                'post_input' => $this->request->getPost(),
            ];
            $validations = $this->main_request->validateData($this->request);
            if (!empty($validations)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'type' => 'validation',
                    'errors' => $validations,
                ]);
            }
            $task = 'add-item';
            if (get_post('id')) {
                $task = 'edit-item';
            }
            $result = $this->model->save_item($this->params, ['task' => $task, 'controller_name' => $this->controller_name]);
            json_response($result);
        }
    }

}
