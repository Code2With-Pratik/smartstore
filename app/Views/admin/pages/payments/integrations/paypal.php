<?php

$form_take_fee_from_user = [
  0 => "Deactive",
  1 => "Active",
];
$payment_elements = [
  [
    'label'      => form_label('Environment'),
    'element'    => form_dropdown('payment_params[option][environment]', $payment_environment, @$payment_option['environment'], ['class' => $class_element]),
    'class_main' => "col-md-12 col-sm-12 col-xs-12",
  ],
  [
    'label'      => form_label('Take fee from user'),
    'element'    => form_dropdown('payment_params[take_fee_from_user]', $form_take_fee_from_user, @$payment_params['take_fee_from_user'], ['class' => $class_element]),
    'class_main' => "col-md-12 col-sm-12 col-xs-12",
  ],
  [
    'label'      => form_label('Paypal Client ID ' . $label_required),
    'element'    => form_input(['name' => "payment_params[option][client_id]", 'value' => @$payment_option['client_id'], 'type' => 'text', 'class' => $class_element]),
    'class_main' => "col-md-12 col-sm-12 col-xs-12",
  ],
  [
    'label'      => form_label('Paypal Client Secret ' . $label_required),
    'element'    => form_input(['name' => "payment_params[option][secret_key]", 'value' => @$payment_option['secret_key'], 'type' => 'text', 'class' => $class_element]),
    'class_main' => "col-md-12 col-sm-12 col-xs-12",
  ],
  [
    'label'      => form_label('Payment Descriptions ' . $label_required),
    'element'    => form_textarea(['name' => 'payment_params[option][pm_details]', 'value' => @$payment_option['pm_details'], 'rows' => 3, 'class' => $class_element]),
    'class_main' => "col-md-12 col-sm-12 col-xs-12",
  ],
];
