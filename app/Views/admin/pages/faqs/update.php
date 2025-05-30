<?php
$form_config = config('AppConfig')->template['form'];
$class_element        = $form_config['class_element'];
$label_required       = $form_config['label_required'];
$class_element_editor       = $form_config['class_element_editor'];
$form_status = get_form_item_status_config($controller_name);
$elements = [
  [
    'label' => form_label('Question', 'Question'),
    'element' => form_input(['name' => 'question', 'value' => @$item['question'], 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
    'class_main' => "col-md-12 col-sm-12 col-xs-12",
  ],
  [
    'label' => form_label('Status'),
    'element' => form_dropdown('status', $form_status, @$item['status'], ['class' => $class_element]),
    'class_main' => "col-md-12 col-sm-12 col-xs-12",
  ],
  [
    'label'      => form_label('Answer'),
    'element'    => form_textarea(['name' => 'answer', 'value' => @$item['answer'] , 'class' => $class_element]),
    'class_main' => "col-md-12",
  ],
];

$form_attributes = [
  'class'                 => 'form actionForm',
  'data-task'             => 'json',
  'data-set_html_element' => '',
  'method'                => "POST",
];
$modal_title = (isset($item['id'])) ? 'Edit' : 'Add New' ;
$form_hidden = ['id' => $item['id'] ?? '' ];

echo view('template/modal', [
  'modalTitle' => $modal_title,
  'modalType' => 'form',
  'formData' => [
    'url'        => admin_url($controller_name . "/store/"),
    'attributes' => $form_attributes
  ],
  'modalContent' => form_hidden($form_hidden) . render_elements_form($elements),
]);
?>

<script>
  $(document).ready(function() {
    plugin_editor('.plugin_editor', {height: 200});
  });
</script>