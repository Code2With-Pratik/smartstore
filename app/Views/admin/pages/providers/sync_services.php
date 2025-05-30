<?php
  $class_element        = config('AppConfig')->template['form']['class_element'];
  $config_status        = config('AppConfig')->config['status'];
  $form_request = [
    '0' => 'Current Services (Sync status with provider)'
  ];
  $elements = [
    [
      'label' => form_label('Name'),
      'element' => form_input(['name' => 'name', 'value' => @$item['name'], 'type' => 'text', 'readonly' => 'readonly', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label' => form_label('Synchronous request'),
      'element' => form_dropdown('request', $form_request, 0, ['class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    
  ];

  $form_attributes = [
    'class'                 => 'form actionForm',
    'data-task'             => 'json',
    'data-set_html_element' => '',
    'method'                => "POST",
  ];
  $modal_title = 'Sync Services - ' . $item['name'];
  $form_hidden = ['id' => $item['id']];

  echo view('template/modal', [
    'modalTitle' => $modal_title,
    'modalType' => 'form',
    'formData' => [
      'url'        => admin_url($controller_name . "/sync_services/"),
      'attributes' => $form_attributes
    ],
    'modalContent' => form_hidden($form_hidden) . render_elements_form($elements),
  ]);
