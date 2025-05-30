<?php
  $form_class                         = config('AppConfig')->template['form'];
  $class_element                      = $form_class['class_element'];
  $class_element_editor               = $form_class['class_element_editor'];
  $label_required                     = $form_class['label_required'];
  $class_element_checkbox_switch      = $form_class['class_element_checkbox_switch'];
  $recaptcha_config       = config('AppConfig')->general_setting['google_recaptcha'];

  $db_google_recaptcha       = get_app_setting('google_recaptcha');
  $db_google_recaptcha       = ($db_google_recaptcha) ? json_decode($db_google_recaptcha, true) : [];

  $key_name = 'google_recaptcha';
  $switch_class = 'recaptcha-switch';
  $switch_class_options = 'recaptcha-switch-options';
  $elements = [
    [
      'label' => form_label("Status"),
      'element' => [
        'input_name'    => $key_name . '[status]',
        'value'         => sanitize_output($db_google_recaptcha['status'] ?? $recaptcha_config['status']),
        'input_class'   => $class_element_checkbox_switch  . ' '. $switch_class
      ],
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
      'type' => "checkbox-switch",
    ],
    [
      'label' => form_label('reCAPTCHA V2 Site Key'),
      'element' => form_input(['name' => $key_name . '[site_key]', 'value' => sanitize_output($db_google_recaptcha['site_key'] ?? $recaptcha_config['site_key']), 'type' => 'text', 'class' => $class_element]),
      'class_main' => 'col-md-12 col-sm-12 col-xs-12 ' . $switch_class_options,
    ],
    [
      'label' => form_label('reCAPTCHA V2 Secret'),
      'element' => form_input(['name' => $key_name . '[secret_key]', 'value' => sanitize_output($db_google_recaptcha['secret_key'] ?? $recaptcha_config['secret_key']), 'type' => 'text', 'class' => $class_element]),
      'class_main' => 'col-md-12 col-sm-12 col-xs-12 ' . $switch_class_options,
    ],
  ];


  $options = $recaptcha_config['options'];
  $db_options = $db_google_recaptcha['options'] ?? [];
  $field_elements = [];
  if ($options) {
    foreach ($options as $key => $option) {
      $option_status = isset($db_options[$key]) ? $db_options[$key] : $option['status'];
      $field_elements[] = [
        'label' => form_label($option['name']),
        'element' => [
          'input_name'    => $key_name . '[options][' . $key . ']',
          'value'         => $option_status,
          'input_class'   => $class_element_checkbox_switch
        ],
        'class_main' => "col-md-6 ",
        'type' => "checkbox-switch",
      ];
    }
  }

?>    

<div class="row">
  <?php echo render_elements_form($elements); ?>
  <fieldset class="col-md-12 form-fieldset <?php echo $switch_class_options; ?>">
    <div class="form-hint m-b-20">
      Obtain your Google reCAPTCHA credentials <a href="https://www.google.com/recaptcha/admin#list" target="_blank">here</a>.
    </div>
    <div class="row">
      <?php echo render_elements_form($field_elements); ?>
    </div>
  </fieldset>
</div>

<script>
  $(document).ready(function() {
    init_switch_toggle('.<?php echo $switch_class ?>', '.<?php echo $switch_class_options ?>', 'form');
  });
</script>