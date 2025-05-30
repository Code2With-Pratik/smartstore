<?php

$form_take_fee_from_user = [
  0 => "Deactive",
  1 => "Active",
];
$payment_elements = [
  [
    'label'      => form_label('Merchant ID ' . $label_required),
    'element'    => form_input(['name' => "payment_params[option][merchant_id]", 'value' => $payment_option['merchant_id'] ?? '', 'type' => 'text', 'class' => $class_element]),
    'class_main' => "col-md-12 col-sm-12 col-xs-12",
  ],
  [
    'label'      => form_label('Secret Key ' . $label_required),
    'element'    => form_input(['name' => "payment_params[option][secret_key]", 'value' => $payment_option['secret_key'] ?? '', 'type' => 'text', 'class' => $class_element]),
    'class_main' => "col-md-12 col-sm-12 col-xs-12",
  ],
  [
    'label'      => form_label('Payment Descriptions ' . $label_required),
    'element'    => form_textarea(['name' => 'payment_params[option][pm_details]', 'value' => $payment_option['pm_details'] ?? '', 'rows' => 3, 'class' => $class_element]),
    'class_main' => "col-md-12 col-sm-12 col-xs-12",
  ],
];

$payment_note = render_payment_note_html(
  [
    'Go to Merchant Settings',
    'Status URL: <code class="text-primary">' . client_url('payeer_ipn') . '</code>',
    'Success URL: <code class="text-primary">' . client_url('checkout/payeer/complete') . '</code>',
    'Fail URL: <code class="text-primary">' . client_url('checkout/unsuccess') . '</code>',
  ]
);
