<?php
namespace App\Requests;

class BaseRequest
{
    /**
     * @var validation
     */
    public $validation;

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
    }

}
