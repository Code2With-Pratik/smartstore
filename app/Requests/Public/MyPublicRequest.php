<?php
namespace App\Requests\Public;

use App\Requests\BaseRequest;

class MyPublicRequest extends BaseRequest
{
    
    protected $table;

    public function __construct()
    {
        parent::__construct();
    }

    public function validateData($request_data, $task = '')
    {
        $this->validation->setRules($this->get_rules($task), $this->get_messages($task));
        $this->validation->withRequest($request_data)->run();
        // Validate the request data
        if (!$this->validation->withRequest($request_data)->run()) {
            return $this->validation->getErrors();
        }
        return null;
    }
}
