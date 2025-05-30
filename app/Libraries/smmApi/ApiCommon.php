<?php
namespace App\Libraries\SmmApi;

class ApiCommon
{
  public $api_url;
  public $api_key;

  public function __construct($api_params = "")
  {
    $this->api_url = $api_params['url'];
    $this->api_key = $api_params['key'];
  }

  public function order($data)
  {
    $post = array_merge(array('key' => $this->api_key, 'action' => 'add'), $data);
    return json_decode($this->connect($post), true);
  }

  public function status($order_id)
  {
    return json_decode($this->connect(array(
      'key' => $this->api_key,
      'action' => 'status',
      'order' => $order_id,
    )), true);
  }

  public function multiStatus($order_ids)
  {
    return json_decode($this->connect(array(
      'key' => $this->api_key,
      'action' => 'status',
      'orders' => implode(",", $order_ids),
    )), true);
  }

  public function services()
  {
    return json_decode($this->connect(array(
      'key' => $this->api_key,
      'action' => 'services',
    )), true);
  }

  // balance
  public function balance()
  { 
    return json_decode($this->connect(array(
      'key' => $this->api_key,
      'action' => 'balance',
    )), true);
  }

  // refill
  public function refill($order_id)
  { 
    return json_decode($this->connect(array(
      'key' => $this->api_key,
      'action' => 'refill',
      'order' => $order_id,
    )), true);
  }

  // refill_status
  public function refill_status($refill_id)
  { 
    return json_decode($this->connect(array(
      'key' => $this->api_key,
      'action' => 'refill_status',
      'refill' => $refill_id,
    )), true);
  }

  private function connect($post)
  {
    $_post = array();
    if (is_array($post)) {
      foreach ($post as $name => $value) {
          $_post[] = $name . '=' . urlencode($value);
      }
    }
    $ch = curl_init($this->api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    if (is_array($post)) {
      curl_setopt($ch, CURLOPT_POSTFIELDS, join('&', $_post));
    }
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    $result = curl_exec($ch);
    if (curl_errno($ch) != 0 && empty($result)) {
      $result = false;
    }
    curl_close($ch);
    return $result;
  }
}
