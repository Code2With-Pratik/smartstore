<?php
  $form_config = config('AppConfig')->template['form'];
  $class_element        = $form_config['class_element'];
  $label_required       = $form_config['label_required'];
  $form_status = get_form_item_status_config($controller_name);
  $api_popover = render_tooltip_popover_html(config('AppConfig')->general_setting['provider_note']);
  $elements = [
    [
      'label' => form_label('Name'),
      'element' => form_input(['name' => 'name', 'value' => sanitize_output($item['name'] ?? ''), 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label' => form_label('API Url ' . $api_popover),
      'element' => form_input(['name' => 'url', 'value' => sanitize_output($item['url'] ?? ''), 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label' => form_label('API Key ' . $api_popover),
      'element' => form_input(['name' => 'key', 'value' => hide_api_key(sanitize_output($item['key'] ?? '')), 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label' => form_label('Status'),
      'element' => form_dropdown('status', $form_status, @$item['status'], ['class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Note'),
      'element'    => form_textarea(['name' => 'description', 'value' => esc(@$item['description']), 'row' => 3, 'class' => $class_element]),
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
    'modalContent' => form_hidden($form_hidden) . render_elements_form($elements),
  ]);
