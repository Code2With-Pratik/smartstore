<?php
  $form_config = config('AppConfig')->template['form'];
  $class_element        = $form_config['class_element'];
  $label_required       = $form_config['label_required'];
  $form_status = get_form_item_status_config($controller_name);


  $elements = [
    [
      'label' => form_label('Name ' . $label_required),
      'element' => form_input(['name' => 'name', 'value' => @$item['name'], 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label' => form_label('Status'),
      'element' => form_dropdown('status', $form_status, @$item['status'], ['class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
  ];

  $form_attributes = [
    'class'                 => 'form actionForm',
    'data-task'             => 'json',
    'method'                => "POST",
  ];
  $modal_title = 'Edit '.  strtoupper($item['type']);
  $form_hidden = ['id' => (isset($item['id'])) ? $item['id'] : '' ];
  // payment Options
  $payment_environment = [
    'live'    => "Live (Product)",
    'sandbox' => "Sandbox (Test)",
  ];
  $payment_params = json_decode($item['params'], true);
  $payment_option = $payment_params['option'];
  include('integrations/' . $item['type'] . '.php');

  $modal_content = form_hidden($form_hidden) . render_elements_form($elements);
  $modal_content .= '<hr>';
  $modal_content .= '<fieldset class="col-md-12 form-fieldset">'. render_elements_form($payment_elements) . '</fieldset>';
  if (!empty($payment_note)) {
    $modal_content .= $payment_note;
  }

echo view('template/modal', [
  'modalTitle' => $modal_title,
  'modalType' => 'form',
  'formData' => [
    'url'        => admin_url($controller_name . "/store/"),
    'attributes' => $form_attributes
  ],
  'modalContent' => $modal_content,
]);

