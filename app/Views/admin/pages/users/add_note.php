<?php
$class_element        = config('AppConfig')->template['form']['class_element'];
$class_element_editor = config('AppConfig')->template['form']['class_element_editor'];
$label_required       = config('AppConfig')->template['form']['label_required'];
$config_status        = config('AppConfig')->config['status'];
$elements = [
  [
    'label'      => form_label('Add Note'),
    'element'    => form_textarea(['name' => 'description', 'value' => @$item['description'],  'required' => 'required', 'class' => $class_element]),
    'class_main' => "col-md-12",
  ],
];

$form_attributes = [
  'class'                 => 'form actionForm',
  'data-task'             => 'json',
  'data-redirect_url'      => admin_url($controller_name .'?'. http_build_query(['field' => 'email', 'query' => @$item['email']])),
  'data-set_html_element' => '',
  'method'                => "POST",
];
$modal_title = 'Add Note - ' . @$item['email'];
$form_hidden = [
  'id' => (isset($item['id'])) ? $item['id'] : '',
];

echo view('template/modal', [
  'modalTitle' => $modal_title,
  'modalType' => 'form',
  'formData' => [
    'url'        => admin_url($controller_name . "/add_note/"),
    'attributes' => $form_attributes
  ],
  'modalContent' => form_hidden($form_hidden) . render_elements_form($elements),
]);
?>
