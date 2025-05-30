<?php
namespace App\Requests\Admin;

use App\Requests\Admin\MyAdminRequest;

class FaqsRequest extends MyAdminRequest
{
    
    public function __construct()
    {
        parent::__construct();
        $this->table = TB_FAQS;
        $this->request_name = strtolower(preg_replace('/Request$/', '', class_basename(__CLASS__)));
    }

    protected function get_rules($task = '')
    {
        $rule_question = 'is_unique['.$this->table. '.question]';
        if (get_post('id')) {
            $rule_question = 'is_unique['.$this->table. '.question,id,'. get_post('id') . ']';
        }
        $rules = [
            'question' => 'required|min_length[10]|' . $rule_question,
            'answer' =>   'required|min_length[20]',
            'status' =>   get_status_rule_by_request($this->request_name),
        ];
        return $rules;
    }

    protected function get_messages($task = '')
    {
        $message = [
            'question' => [
                'required'      => 'The field is required',
                'is_unique'      => 'This question already exists. Kindly enter a new, unique question',
                'min_length'    => 'The name must be at least 10 characters long',
            ],
            'answer' => [
                'required' => 'The field is required',
                'min_length' => 'The name must be at least 20 characters long',
            ],
        ];
        return $message; 
    }
}
