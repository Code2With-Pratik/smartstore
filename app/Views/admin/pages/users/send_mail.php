<?php
$class_element        = config('AppConfig')->template['form']['class_element'];
$class_element_editor = config('AppConfig')->template['form']['class_element_editor'];
$label_required       = config('AppConfig')->template['form']['label_required'];
$elements = [
  [
    'label'      => form_label('To'),
    'element'    => form_input(['name' => 'mail_to', 'value' => $item['email'], 'type' => 'text', 'readonly' => 'readonly', 'class' => $class_element]),
    'class_main' => "col-md-12 col-sm-12 col-xs-12",
  ],
  [
    'label'      => form_label('Subject'),
    'element'    => form_input(['name' => 'subject', 'value' => '', 'type' => 'text', 'class' => $class_element]),
    'class_main' => "col-md-12 col-sm-12 col-xs-12",
  ],
  [
    'label'      => form_label('Message'),
    'element'    => form_textarea(['name' => 'message', 'value' => '' , 'class' => $class_element_editor]),
    'class_main' => "col-md-12",
  ],
];

$form_attributes = [
  'class'                 => 'form actionForm',
  'data-task'             => 'json',
  'data-set_html_element' => '',
  'method'                => "POST",
];
$modal_title = 'Send Mail - ' . @$item['email'];
$form_hidden = ['id' => (isset($item['id'])) ? $item['id'] : '' ];

echo view('template/modal', [
  'modalTitle' => $modal_title,
  'modalType' => 'form',
  'formData' => [
    'url'        => admin_url($controller_name . "/send_mail/"),
    'attributes' => $form_attributes
  ],
  'modalContent' => form_hidden($form_hidden) . render_elements_form($elements),
]);
?>
