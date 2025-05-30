<?php
namespace App\Libraries;

use \ReCaptcha\ReCaptcha as GoogleRecaptcha; 

class CustomRecaptcha
{
    protected $secretKey;
    protected $siteKey;

    public function __construct($site_key = '', $secret_key = '')
    {
        $this->siteKey = $site_key;
        $this->secretKey = $secret_key;

        require_once APPPATH . 'Libraries/recaptcha/src/autoload.php';
    }

    public function render_html()
    {
        $html = '<div class="g-recaptcha" data-sitekey="' . $this->siteKey . '"></div>';
        $html .= '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
        return $html;
    }

    public function verify($response, $remoteIp)
    {
        $recaptcha = new \ReCaptcha\ReCaptcha($this->secretKey);
        $verifyResponse = $recaptcha->verify($response, $remoteIp);
        return $verifyResponse->isSuccess(); 
    }
}
