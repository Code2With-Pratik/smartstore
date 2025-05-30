<?php
$form_config          = config('AppConfig')->template['form'];
$class_element        = $form_config['class_element'];
$label_required       = $form_config['label_required'];
$form_status          = get_form_item_status_config($controller_name);

$image_popover = render_tooltip_popover_html('Display the image icon of category on home page. Use format 64px * 64px. You can insert the third party url');
$elements = [
    [
      'label' => form_label('Name ' . $label_required),
      'element' => form_input(['name' => 'name', 'value' => sanitize_output($item['name'] ?? ''), 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label' => form_label('Status ' . $label_required),
      'element' => form_dropdown('status', $form_status, sanitize_output($item['status'] ?? ''), ['class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ], 
    [
      'label' => form_label('Image Icon url ' . $label_required . ' '. $image_popover),
      'element' => form_input(['name' => 'image', 'value' => sanitize_output($item['image'] ?? ''), 'type' => 'text', 'class' => $class_element]),
      'type' => "upload-image-input-elfinder-directly",
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
];

$form_attributes = [
  'class'                 => 'form actionForm',
  'data-task'             => 'json',
  'data-set_html_element' => (isset($item['ids'])) ? 'tr.tr_'.$item['ids'] : '',
  'method'                => "POST",
];
$modal_title = (isset($item['id'])) ? 'Edit' : 'Add New' ;
$form_hidden = ['id' => (isset($item['id'])) ? $item['id'] : '' ];

echo view('template/modal', [
  'modalTitle' => $modal_title,
  'modalType' => 'form',
  'formData' => [
    'url'        => admin_url($controller_name . "/store/"),
    'attributes' => $form_attributes
  ],
  'modalContent' => form_hidden($form_hidden) . render_elements_form($elements) . form_input(['type'  => 'hidden', 'class' => 'plugin_editor d-none']),
]);
?>