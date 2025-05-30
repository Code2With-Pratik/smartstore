<?php
$class_element        = config('AppConfig')->template['form']['class_element'];
$class_element_editor = config('AppConfig')->template['form']['class_element_editor'];
$label_required       = config('AppConfig')->template['form']['label_required'];
$elements = [
  [
    'label' => form_label('Subject'),
    'element' => form_input(['name' => 'subject', 'value' => sanitize_output($item['subject'] ?? ''), 'type' => 'text', 'disabled' => 'disabled', 'class' => $class_element]),
    'class_main' => "col-md-12 col-sm-12 col-xs-12",
  ],
  [
    'label' => form_label('From'),
    'element' => form_input(['name' => 'from', 'value' => sanitize_output($item['from'] ?? ''), 'type' => 'text', 'disabled' => 'disabled', 'class' => $class_element]),
    'class_main' => "col-md-12 col-sm-12 col-xs-12",
  ],
  [
    'label'      => form_label('Received Message'),
    'element'    => form_textarea(['name' => 'message', 'value' => sanitize_output($item['message'] ?? ''), 'disabled' => 'disabled', 'class' => $class_element]),
    'class_main' => "col-md-12",
  ],
  [
    'label'      => form_label('Reply message'),
    'element'    => form_textarea(['name' => 'reply_message', 'value' => '' , 'class' => $class_element_editor]),
    'class_main' => "col-md-12",
  ],
];

$form_attributes = [
  'class'                 => 'form actionForm',
  'data-task'             => 'json',
  'data-set_html_element' => '',
  'method'                => "POST",
];
$modal_title = 'Reply to ' . $item['from'];
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
