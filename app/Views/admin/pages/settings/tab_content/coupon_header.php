<?php
  $form_class = config('AppConfig')->template['form'];
  $class_element                    = $form_class['class_element'];
  $label_required                   = $form_class['label_required'];
  $class_element_checkbox_switch    = $form_class['class_element_checkbox_switch'];

  $coupon_header                 = get_app_setting('coupon_header');
  $coupon_header                 = json_decode($coupon_header, true);
  $elements = [
    [
      'label' => form_label('Status ' . render_tooltip_popover_html("Please ensure that the selected coupons are enabled on the <code>Coupons page</code>  to make them active. Only enabled coupons will be visible to users"), 'tooltip'),
      'element' => [
          'input_name'    => 'coupon_header[status]',
          'value'         => $coupon_header['status'] ?? 0,
          'input_class'   => $class_element_checkbox_switch
      ],
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
      'type' => "checkbox-switch",
    ],
    [
      'label' => form_label('Content'),
      'element' => form_input(['name' => 'coupon_header[content]', 'value' => sanitize_output($coupon_header['content'] ?? ''), 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label' => form_label("Badge title status"),
      'element' => [
        'input_name'    => 'coupon_header[badge_title_status]',
        'value'         => $coupon_header['badge_title_status'] ?? 0,
        'input_class'   => $class_element_checkbox_switch . ' badge-title-switch'
      ],
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
      'type' => "checkbox-switch",
    ],
    [
      'label' => form_label('Badge title (left)'),
      'element' => form_input(['name' => 'coupon_header[badge_title]', 'value' => sanitize_output($coupon_header['badge_title'] ?? ''), 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12 badge-title-switch-options",
    ],
    [
      'label' => form_label('Image Background'),
      'element' => form_input(['name' => 'coupon_header[image_background]', 'value' => sanitize_output($coupon_header['image_background'] ?? ''), 'type' => 'text', 'class' => $class_element]),
      'type' => "upload-image-input-elfinder-directly",
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label' => form_label("Counter Time status"),
      'element' => [
        'input_name'    => 'coupon_header[counter_time_status]',
        'value'         => $coupon_header['counter_time_status'] ?? 0,
        'input_class'   => $class_element_checkbox_switch . ' counter-time-switch'
      ],
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
      'type' => "checkbox-switch",
    ],

    [
      'label' => form_label('Counter Time (hours)' ),
      'element' => form_dropdown('coupon_header[counter_time][hours]', generate_number_array(1, 100, 'hour', 0), sanitize_output($coupon_header['counter_time']['hours'] ?? ''), ['class' => 'form-control']),
      'class_main' => "col-md-12 counter-time-switch-options",
    ],
    [
      'label' => form_label('Counter Time (minutes)' ),
      'element' => form_dropdown('coupon_header[counter_time][minutes]', generate_number_array(1, 60, 'minute'), sanitize_output($coupon_header['counter_time']['minutes'] ?? ''), ['class' => 'form-control']),
      'class_main' => "col-md-12 counter-time-switch-options",
    ],

  ];
?>
<div class="row">
  <input type="hidden" class="plugin_editor d-none">
  <?= render_elements_form($elements);?>
</div>

<script>
  $(document).ready(function() {
    init_switch_toggle('.badge-title-switch', '.badge-title-switch-options', 'form');
    init_switch_toggle('.counter-time-switch', '.counter-time-switch-options', 'form');
  });
</script>
