<?php
namespace App\Requests\Admin;

use App\Requests\Admin\MyAdminRequest;

class SettingsRequest extends MyAdminRequest
{
    
    public function __construct()
    {
        parent::__construct();
        $this->table = TB_OPTIONS;
        $this->request_name = strtolower(preg_replace('/Request$/', '', class_basename(__CLASS__)));
    }

    /**
     * Get the validation rules for the request.
     * @return array The validation rules.
     */
    protected function get_rules($task = '')
    {
        $rules = [];

        // website_setting tab
        if (get_post('website_name')) {
            $rules['website_name']          = 'required|min_length[3]';
            $rules['website_favicon']       = 'required|valid_url|validate_image_url';
            $rules['website_logo']          = 'required|valid_url|validate_image_url';
            $rules['website_logo_white']    = 'required|valid_url|validate_image_url';
            $rules['website_logo_mark']     = 'required|valid_url|validate_image_url';
        }

        // default tab
        if (get_post('blog_limit_posts_per_page')) {
            $rules['blog_limit_posts_per_page']         = 'required|is_natural_no_zero';
            $rules['reviews_limit_per_page']            = 'required|is_natural_no_zero';
            $rules['admin_max_items_per_page']          = 'required|is_natural_no_zero';
        }

        // Header Coupon tab
        if (get_post('coupon_header')) {
            $rules['coupon_header.status']                  = 'required|in_list[0,1]';
            $rules['coupon_header.content']                 = 'required|min_length[10]|max_length[80]';
            $rules['coupon_header.badge_title_status']      = 'required|in_list[0,1]';
            $rules['coupon_header.badge_title']             = 'required|min_length[3]|max_length[30]';
            $rules['coupon_header.image_background']        = 'required|valid_url|validate_image_url';
            $rules['coupon_header.counter_time_status']     = 'required|in_list[0,1]';
            $rules['coupon_header.counter_time.hours']      = 'required|numeric|greater_than_equal_to[0]';
            $rules['coupon_header.counter_time.minutes']    = 'required|numeric|greater_than_equal_to[1]';
        }

        // page_seo tab
        if (get_post('website_seo')) {
            $rules['website_seo.title']          = 'required|min_length[10]';
            $rules['website_seo.keywords']       = 'required|min_length[10]';
            $rules['website_seo.description']    = 'required|min_length[10]';
            $rules['website_seo.index']          = 'required|in_list[index,noindex]';
        }

        // page_seo tab
        if (get_post('embed_js_code_header')) {
            $rules['embed_js_code_header']    = 'validate_custom_header_code';
        }
        if (get_post('embed_js_code_footer')) {
            $rules['embed_js_code_footer']  = 'validate_custom_footer_code';
        }
        if (get_post('footer_links')) {
            $rules = array_merge($rules, $this->generate_rule_message_for_footer_links('rule', get_post('footer_links')));
        }

        // send test mail
        if ($task == 'send_test_mail') {
            $rules = [
                'mail_to' => 'required|valid_email',
                'subject' => 'trim|required|min_length[5]',
                'message' => 'trim|required|min_length[10]',
            ];
        }

        return $rules;
    }
   

    protected function get_messages()
    {
        $message = [
            'website_name' => [
                'min_length' => 'The name must be at least 3 characters long',
            ],
            'website_favicon' => [
                'required'   => 'Favicon URL must point to a valid image file (e.g., .jpg, .png)',
                'valid_url'   => 'Favicon URL must point to a valid image file (e.g., .jpg, .png)',
                'validate_image_url'   => 'Favicon URL must point to a valid image file (e.g., .jpg, .png)',
            ],
            'website_logo' => [
                'required'   => 'Logo URL must point to a valid image file (e.g., .jpg, .png)',
                'valid_url'   => 'Logo URL must point to a valid image file (e.g., .jpg, .png)',
                'validate_image_url'   => 'Logo URL must point to a valid image file (e.g., .jpg, .png)',
            ],
            'website_logo_white' => [
                'required'   => 'Logo (white) URL must point to a valid image file (e.g., .jpg, .png)',
                'valid_url'   => 'Logo (white) URL must point to a valid image file (e.g., .jpg, .png)',
                'validate_image_url'   => 'Logo (white) URL must point to a valid image file (e.g., .jpg, .png)',
            ],
            'website_logo_mark' => [
                'required'   => 'Logo (mark) URL must point to a valid image file (e.g., .jpg, .png)',
                'valid_url'   => 'Logo (mark) URL must point to a valid image file (e.g., .jpg, .png)',
                'validate_image_url'   => 'Logo (mark) URL must point to a valid image file (e.g., .jpg, .png)',
            ],
            // default
            'blog_limit_posts_per_page' => [
                'required'   => 'The field is required.',
                'is_natural_no_zero'   => 'Invalid value',
            ],
            'reviews_limit_per_page' => [
                'required'   => 'The field is required.',
                'is_natural_no_zero'   => 'Invalid value',
            ],
            'admin_max_items_per_page' => [
                'required'   => 'The field is required.',
                'is_natural_no_zero'   => 'Invalid value',
            ],

            // SEO
            'website_seo.title' => [
                'required'   => 'The field is required',
                'min_length' => 'The name must be at least 10 characters long',
            ],
            'website_seo.keywords' => [
                'required'   => 'The field is required',
                'min_length' => 'The name must be at least 10 characters long',
            ],
            'website_seo.description' => [
                'required'   => 'The field is required',
                'min_length' => 'The name must be at least 10 characters long',
            ],
            'website_seo.index' => [
                'required'   => 'The field is required',
                'min_length' => 'Invalid Type',
            ],
            
            // Footer and header
            'embed_js_code_header' => [
                'validate_custom_header_code'   => 'Invalid Code',
            ],
            'embed_js_code_footer' => [
                'validate_custom_footer_code'   => 'Invalid Code',
            ],


            // coupon_header
            'coupon_header.status' => [
                'required'   => 'The field is required',
                'in_list' => 'Invalid status',
            ],
            'coupon_header.content' => [
                'required'   => 'The field is required',
                'min_length' => 'The field must be at least 5 characters long',
                'max_length' => 'The field cannot be longer than 80 characters',
            ],
            'coupon_header.badge_title_status' => [
                'required'   => 'The field is required',
                'in_list' => 'Invalid status',
            ],
            'coupon_header.badge_title' => [
                'required'   => 'The field is required',
                'min_length' => 'The field must be at least 3 characters long',
                'max_length' => 'The field cannot be longer than 30 characters',
            ],
            'coupon_header.image_background' => [
                'required'   => 'The field is required',
                'valid_url' => 'The Image URL must point to a valid image file (e.g., .jpg, .png)',
                'validate_image_url' => 'The Image URL must point to a valid image file (e.g., .jpg, .png)',
            ],
            'coupon_header.counter_time_status' => [
                'required'   => 'The field is required',
                'in_list' => 'Invalid status',
            ],
            'coupon_header.counter_time.hours' => [
                'required'   => 'The field is required',
                'numeric' => 'Invalid value',
                'greater_than_equal_to' => 'The field is greater than equal to Zero',
            ],
            'coupon_header.counter_time.minutes' => [
                'required'   => 'The field is required',
                'numeric' => 'Invalid value',
                'greater_than_equal_to' => 'The field is greater than equal to 1',
            ],
        ];

        if (get_post('footer_links')) {
            $message = array_merge($message, $this->generate_rule_message_for_footer_links('message', get_post('footer_links')));
        }

        return $message; 
    }

    private function generate_rule_message_for_footer_links($task = 'rule', $footer_links) 
    {
        $rules_messages = [];
        if (!empty($footer_links)) {

            foreach ($footer_links as $lang_code => $footer_links_by_lang_code) {
                foreach ($footer_links_by_lang_code as $key => $footer_link) {
                    $key_name       = 'footer_links.' . $lang_code . '.' . $key;
                    $key_title      = $key_name . '.title';
                    $key_url_slug   = $key_name . '.url_slug';

                    if ($task == 'rule') { 

                        $rules_messages[$key_title] = 'required|min_length[3]|max_length[30]';
                        $rules_messages[$key_url_slug] = 'required|min_length[3]|regex_match[/^[a-z0-9-]+$/]';

                    } else if ($task == 'message') { 

                        $rules_messages[$key_title] = [
                            'required'      => 'The field is required (e.g., "Contact Us" or "FAQs" or "Blog")',
                            'min_length'    => 'The field must be at least 3 characters long (e.g., "Contact Us" or "FAQs" or "Blog")',
                            'max_length'    => 'The field must not exceed 30 characters (e.g., "Contact Us" or "FAQs" or "Blog")',
                        ];
                        $rules_messages[$key_url_slug] = [
                            'required'      => 'The Url slug is required. Example: "contact-us"',
                            'min_length'    => 'The Url slug must be at least 3 characters long. Example: "contact-us"',
                            'regex_match'   => 'The Url slug must only contain lowercase letters, numbers, and hyphens. Example: "contact-us"',
                        ];

                    }
                }
            }
        }
        return $rules_messages;
    }
}
