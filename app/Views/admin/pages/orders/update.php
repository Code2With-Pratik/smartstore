<?php
$class_element        = config('AppConfig')->template['form']['class_element'];
$class_element_editor = config('AppConfig')->template['form']['class_element_editor'];
$label_required       = config('AppConfig')->template['form']['label_required'];
$config_status        = config('AppConfig')->config['status'];

$formStatus        = order_status_update_form($controller_name, $item['status']);
$formCharge        = (!empty($item['charge']))         ? $item['charge']   : '';
$formQuantity      = (!empty($item['quantity']))       ? $item['quantity'] : '';
$formRemains       = (!empty($item['remains']))        ? $item['remains']  : '';
$formStartCounter = (!empty($item['start_counter']))  ? $item['start_counter'] : '';
$formLink          = (!empty($item['link']))           ? esc($item['link']) : '';
$elements = [
  [
    'label'      => form_label('Link'),
    'element'    => form_input(['name' => 'link', 'value' => $formLink, 'type' => 'text', 'class' => $class_element]),
    'class_main' => "col-md-12 col-sm-12 col-xs-12",
  ],
  [
    'label'      => form_label('Quantity'),
    'element'    => form_input(['name' => 'quantity', 'value' => $formQuantity, 'type' => 'text', 'readonly' => 'readonly', 'class' => $class_element]),
    'class_main' => "col-md-12 col-sm-12 col-xs-12",
  ],
  [
    'label'      => form_label('Charge'),
    'element'    => form_input(['name' => 'charge', 'value' => $formCharge, 'type' => 'text', 'readonly' => 'readonly', 'class' => $class_element]),
    'class_main' => "col-md-12 col-sm-12 col-xs-12",
  ],
  [
    'label'      => form_label('Start Counter'),
    'element'    => form_input(['name' => 'start_counter', 'value' => $formStartCounter, 'type' => 'number', 'class' => $class_element]),
    'class_main' => "col-md-12 col-sm-12 col-xs-12",
  ],
  [
    'label'      => form_label('Remains'),
    'element'    => form_input(['name' => 'remains', 'value' => $formRemains, 'type' => 'number', 'class' => $class_element]),
    'class_main' => "col-md-12 col-sm-12 col-xs-12",
  ],
];
if ($item['status'] != 'partial') {
  $elements[] = [
    'label'      => form_label('Status'),
    'element'    => form_dropdown('status', $formStatus, $item['status'], ['class' => $class_element]),
    'class_main' => "col-md-12 col-sm-12 col-xs-12",
  ];
}

$form_attributes = [
  'class'                 => 'form actionForm',
  'data-task'             => 'json',
  'data-set_html_element' => '',
  'method'                => "POST",
];
$modal_title = 'Edit - ID' . $item['id'];
$form_hidden = ['id' => (isset($item['id'])) ? $item['id'] : '' ];

echo view('template/modal', [
  'modalTitle' => $modal_title,
  'modalType' => 'form',
  'formData' => [
    'url'        => admin_url($controller_name . "/store/"),
    'attributes' => $form_attributes
  ],
  'modalContent' => form_hidden($form_hidden) . render_elements_form($elements),
]);

