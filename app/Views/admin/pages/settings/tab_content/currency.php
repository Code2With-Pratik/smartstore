<?php
  $form_config = config('AppConfig')->template['form'];
  $class_element                    = $form_config['class_element'];
  $label_required                   = $form_config['label_required'];
  $contact_informations             = get_app_setting('contact_informations');
  $currency_thousand_separator_arr  = config('AppConfig')->general_setting['currency_thousand_separator_arr'];
  $currency_position_arr            = config('AppConfig')->general_setting['currency_position_arr'];
  $currency_decimal_arr             = config('AppConfig')->general_setting['currency_decimal_arr'];
  $currency_code_arr                = currency_codes();

  $currency_decimal_separator_arr = $currency_thousand_separator_arr;
  unset($currency_decimal_separator_arr['space']);
  $elements = [
    [
      'label' => form_label('Currency Code (PayPal Payments only supports these currencies)'),
      'element' => form_dropdown('currency_code', $currency_code_arr, get_app_setting('currency_code'), ['class' => 'form-control']),
      'class_main' => "col-md-12",
    ],
    [
      'label' => form_label('Currency Symbol'),
      'element' => form_input(['name' => 'currency_symbol', 'value' => get_app_setting('currency_symbol'), 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
      'class_main' => "col-md-12",
    ],
    [
      'label' => form_label('Thousand Separator' ),
      'element' => form_dropdown('currency_thousand_separator', $currency_thousand_separator_arr, get_app_setting('currency_thousand_separator'), ['class' => 'form-control']),
      'class_main' => "col-md-6",
    ],
    [
      'label' => form_label('Decimal Separator' ),
      'element' => form_dropdown('currency_decimal_separator', $currency_decimal_separator_arr, get_app_setting('currency_decimal_separator'), ['class' => 'form-control']),
      'class_main' => "col-md-6",
    ],
    [
      'label' => form_label('Currency decimal places' ),
      'element' => form_dropdown('currency_decimal', $currency_decimal_arr, get_app_setting('currency_decimal'), ['class' => 'form-control']),
      'class_main' => "col-md-6",
    ],
    [
      'label' => form_label('Currency Symbol location'),
      'element' => form_dropdown('currency_position', $currency_position_arr, get_app_setting('currency_position'), ['class' => 'form-control']),
      'class_main' => "col-md-6",
    ],
  ];
?>
<div class="row">
  <?= render_elements_form($elements);?>
</div>

