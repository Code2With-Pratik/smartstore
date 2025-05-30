<?php
$form_config          = config('AppConfig')->template['form'];
$class_element        = $form_config['class_element'];
$label_required       = $form_config['label_required'];
$form_status          = get_form_item_status_config($controller_name);

if ($sub_controller == 'ip') {
  $elements = [
    [
      'label' => form_label('IP address', 'IP address'),
      'element' => form_input(['name' => 'ip', 'value' => @$item['ip'], 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
  ];
}
if ($sub_controller == 'link') {
  $elements = [
    [
      'label' => form_label('Order link', 'link'),
      'element' => form_input(['name' => 'link', 'value' => @$item['link'], 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
  ];
}
if ($sub_controller == 'email') {
  $elements = [
    [
      'label' => form_label('Email', 'email'),
      'element' => form_input(['name' => 'email', 'value' => @$item['email'], 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
  ];
}
$elements = array_merge($elements, [
  [
    'label'      => form_label('Description'),
    'element'    => form_textarea(['name' => 'description', 'value' => @$item['description'], 'class' => $class_element]),
    'class_main' => "col-md-12",
  ],
  [
    'label' => form_label('Status'),
    'element' => form_dropdown('status', $form_status, @$item['status'], ['class' => $class_element]),
    'class_main' => "col-md-12 col-sm-12 col-xs-12",
  ],
]);

$form_attributes = [
  'class'                 => 'form actionForm',
  'data-task'             => 'json',
  'data-set_html_element' => '',
  'method'                => "POST",
];
$modal_title = (isset($item['id'])) ? 'Edit' : 'Add New' ;
$form_hidden = [
  'id'   => (isset($item['id'])) ? $item['id'] : '', 
  'action_type' => $sub_controller, 
];

echo view('template/modal', [
  'modalTitle' => $modal_title,
  'modalType' => 'form',
  'formData' => [
    'url'        => admin_url($controller_name . "/store/"),
    'attributes' => $form_attributes
  ],
  'modalContent' => form_hidden($form_hidden) . render_elements_form($elements),
]);
