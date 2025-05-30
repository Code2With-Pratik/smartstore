<?php
namespace App\Requests\Admin;

use App\Requests\Admin\MyAdminRequest;

class LanguagesRequest extends MyAdminRequest
{
    
    public function __construct()
    {
        parent::__construct();
        $this->table = TB_LANGUAGE_LIST;
    }

    protected function get_rules($task = '')
    {
        $language_codes = array_keys(language_codes());
        $country_codes = array_keys(country_codes());
        $rule_language_code = 'required|in_list[' . implode(',', $language_codes) . ']';
        $rule_country_code = 'required|in_list[' . implode(',', $country_codes) . ']';
        if (get_post('id')) {
            $rule_language_code .= '|is_unique['.$this->table. '.code,id,'. get_post('id') . ']';
            $rule_country_code .= '|is_unique['.$this->table. '.country_code,id,'. get_post('id') . ']';
        } else {
            $rule_language_code .= '|is_unique['.$this->table. '.code]';
            $rule_country_code .= '|is_unique['.$this->table. '.country_code]';
        }
        $rules = [
            'code'          => $rule_language_code,
            'country_code'  => $rule_country_code,
            'is_default'    => 'required|in_list[0,1]',
            'status'        => 'required|in_list[0,1]',
        ];
        return $rules;
    }

    protected function get_messages($task = '')
    {
        $message = [
            'code' => [
                'required'  => 'The field is required',
                'is_unique' => 'The language code already exists. Please try a different one',
                'in_list'   => 'Invalid Language Code'
            ],
            'country_code' => [
                'required'  => 'The field is required',
                'is_unique' => 'The location already exists. Please try a different one',
                'in_list'   => 'Invalid Location'
            ],
            'is_default' => [
                'required' => 'The field is required',
                'in_list' => 'The field is invalid value'
            ],
            'status' => [
                'required' => 'The field is required',
                'in_list' => 'The field is invalid value'
            ],
        ];
        return $message; 
    }
}
