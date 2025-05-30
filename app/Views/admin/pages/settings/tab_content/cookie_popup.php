<?php
  $form_class = config('AppConfig')->template['form'];
  $class_element                    = $form_class['class_element'];
  $label_required                   = $form_class['label_required'];
  $class_element_editor             = $form_class['class_element_editor'];
  $class_element_checkbox_switch    = $form_class['class_element_checkbox_switch'];
  $popup_position_arr           = config('AppConfig')->general_setting['cookie_popup']['popup_position_arr'];


  $cookie_popup                 = get_app_setting('cookie_popup');
  $cookie_popup                 = json_decode($cookie_popup, true);
  $elements = [
    [
      'label' => form_label("Status"),
      'element' => [
          'input_name'    => 'cookie_popup[status]',
          'value'         => $cookie_popup['status'] ?? 0,
          'input_class'   => $class_element_checkbox_switch
      ],
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
      'type' => "checkbox-switch",
    ],
    [
      'label' => form_label('Content'),
      'element' => form_textarea(['name' => 'cookie_popup[content]', 'value' => sanitize_output($cookie_popup['content'] ?? ''), 'rows' => '2', 'class' => $class_element_editor]),
      'class_main' => "col-md-12",
    ],
    [
      'label' => form_label('Button Title'),
      'element' => form_input(['name' => 'cookie_popup[button_title]', 'value' => sanitize_output($cookie_popup['button_title'] ?? ''), 'placeholder' => '...', 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
      'class_main' => "col-md-12",
    ],
    [
      'label' => form_label('Popup Position' ),
      'element' => form_dropdown('cookie_popup[popup_position]', $popup_position_arr, sanitize_output($cookie_popup['popup_position'] ?? ''), ['class' => 'form-control']),
      'class_main' => "col-md-6",
    ],
    [
      'label' => form_label('Consent expiry time' ),
      'element' => form_dropdown('cookie_popup[consent_expiry_time]', generate_number_array(1, 30, 'day'), sanitize_output($cookie_popup['consent_expiry_time'] ?? ''), ['class' => 'form-control']),
      'class_main' => "col-md-6",
    ],
  ];
  
?>
<div class="row">
  <?= render_elements_form($elements); ?>
</div>

