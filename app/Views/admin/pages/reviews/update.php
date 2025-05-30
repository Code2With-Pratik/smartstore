<?php
$form_config = config('AppConfig')->template['form'];
$class_element        = $form_config['class_element'];
$label_required       = $form_config['label_required'];
$form_status = get_form_item_status_config($controller_name);
$form_rating = [
  1 => '1',
  2 => '2',
  3 => '3',
  4 => '4',
  5 => '5',
];

$elements = [
    [
      'label' => form_label('Name'),
      'element' => form_input(['name' => 'name', 'value' => @$item['name'], 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label' => form_label('Email'),
      'element' => form_input(['name' => 'email', 'value' => @$item['email'], 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label' => form_label('Status'),
      'element' => form_dropdown('status', $form_status, @$item['status'], ['class' => $class_element]),
      'class_main' => "col-md-6 col-sm-12 col-xs-12",
    ],
    [
      'label' => form_label('Rating'),
      'element' => form_dropdown('rating', $form_rating, @$item['rating'], ['class' => $class_element]),
      'class_main' => "col-md-6 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Comment'),
      'element'    => form_textarea(['name' => 'comment', 'value' => @$item['comment'] , 'class' => $class_element]),
      'class_main' => "col-md-12",
    ],
];

$form_attributes = [
  'class'                 => 'form actionForm',
  'method'                => "POST",
];
$modal_title = (isset($item['id'])) ? 'Edit (ID: ' . $item['id'] . ')' : 'Add New' ;
$form_hidden = ['id' => $item['id'] ?? '' ];

echo view('template/modal', [
  'modalTitle' => $modal_title,
  'modalType' => 'form',
  'formData' => [
    'url'        => admin_url($controller_name . "/store/"),
    'attributes' => $form_attributes,
    'options' => [
      'redirect_delay' => 4000,
    ],
  ],
  'modalContent' => form_hidden($form_hidden) . render_elements_form($elements),
]);
?>

