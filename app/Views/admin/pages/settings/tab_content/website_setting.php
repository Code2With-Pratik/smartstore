<?php
  $form_config          = config('AppConfig')->template['form'];
  $class_element        = $form_config['class_element'];
  $label_required                     = $form_config['label_required'];
  $class_element_checkbox_switch      = $form_config['class_element_checkbox_switch'];
  $contact_informations               = get_app_setting('contact_informations');

  $elements = [
    [
      'label' => form_label('Maintenance mode '  . render_tooltip_popover_html('When maintenance mode is activated, the site will enter maintenance mode, and you will only be able to log in via the admin login URL', 'tooltip')),
      'element' => [
          'input_name'    => 'site_maintenance_mode',
          'value'         => get_app_setting('site_maintenance_mode') ?? 0,
          'input_class'   => $class_element_checkbox_switch
      ],
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
      'type' => "checkbox-switch",
    ],
    [
      'label' => form_label('Site name'),
      'element' => form_input(['name' => 'website_name', 'value' => get_app_setting('website_name'), 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label' => form_label('Favicon'),
      'element' => form_input(['name' => 'website_favicon', 'value' => get_app_setting('website_favicon'), 'type' => 'text', 'class' => $class_element]),
      'type' => "upload-image-input-elfinder-directly",
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label' => form_label('Logo'),
      'element' => form_input(['name' => 'website_logo', 'value' => get_app_setting('website_logo'), 'type' => 'text', 'class' => $class_element]),
      'type' => "upload-image-input-elfinder-directly",
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label' => form_label('Logo (white)'),
      'element' => form_input(['name' => 'website_logo_white', 'value' => get_app_setting('website_logo_white'), 'type' => 'text', 'class' => $class_element]),
      'type' => "upload-image-input-elfinder-directly",
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label' => form_label('Logo (mark)'),
      'element' => form_input(['name' => 'website_logo_mark', 'value' => get_app_setting('website_logo_mark'), 'type' => 'text', 'class' => $class_element]),
      'type' => "upload-image-input-elfinder-directly",
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
  ];
?>
<div class="row">
  <input type="hidden" class="plugin_editor d-none">
  <?= render_elements_form($elements);?>
</div>

