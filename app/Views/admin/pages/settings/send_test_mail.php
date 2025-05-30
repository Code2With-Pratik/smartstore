<?php
$class_element        = config('AppConfig')->template['form']['class_element'];
$class_element_editor = config('AppConfig')->template['form']['class_element_editor'];
$label_required       = config('AppConfig')->template['form']['label_required'];

$item_admin = db_get('email', TB_STAFFS, ['admin' => 1]);
if (empty($item_admin)) {
  $mail_to = '';
} else {
  $mail_to = $item_admin['email'];
}


$elements = [
  [
    'label'      => form_label('To (mail address)'),
    'element'    => form_input(['name' => 'mail_to', 'value' => $mail_to,  'placeholder' => 'Enter an email....', 'type' => 'text', 'class' => $class_element]),
    'class_main' => "col-md-12 col-sm-12 col-xs-12",
  ],
  [
    'label'      => form_label('Subject'),
    'element'    => form_input(['name' => 'subject', 'value' => 'Test Mail', 'type' => 'text', 'class' => $class_element]),
    'class_main' => "col-md-12 col-sm-12 col-xs-12",
  ],
  [
    'label'      => form_label('Message'),
    'element'    => form_textarea(['name' => 'message', 'value' => '' , 'placeholder' => 'Enter your message...', 'class' => $class_element]),
    'class_main' => "col-md-12",
  ],
];

$form_attributes = [
  'class'                 => 'form actionForm',
  'data-task'             => 'json',
  'data-set_html_element' => '',
  'method'                => "POST",
];
$modal_title = 'Send Test Mail';
$form_hidden = ['id' => (isset($item['id'])) ? $item['id'] : '' ];

echo view('template/modal', [
  'modalTitle' => $modal_title,
  'modalType' => 'form',
  'formData' => [
    'url'        => admin_url($controller_name . "/send_test_mail/"),
    'attributes' => $form_attributes
  ],
  'modalContent' => form_hidden($form_hidden) . render_elements_form($elements),
]);
?>
