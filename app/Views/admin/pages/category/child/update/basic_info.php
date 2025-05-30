<?php
  $class_element        = config('AppConfig')->template['form']['class_element'];
  $class_element_editor = config('AppConfig')->template['form']['class_element_editor'];
  $label_required       = config('AppConfig')->template['form']['label_required'];
  
  $elements_basic = [
    [
      'label' => form_label('Name ' . $label_required),
      'element' => form_input(['name' => 'name', 'value' => sanitize_output($item_lang['name'] ?? ''), 'type' => 'text', 'required' => 'required', 'placeholder' => 'Enter name...', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label' => form_label('Unit name'),
      'element' => form_input(['name' => 'unit_name', 'value' => sanitize_output($item_lang['unit_name'] ?? ''), 'placeholder' => 'Eg. Likes, Followers ...',  'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label' => form_label("Boostrap 5 icon's class " . $label_required),
      'element' => form_input(['name' => 'icon_class', 'value' => sanitize_output($item_lang['icon_class'] ?? 'bi bi-hand-thumbs-up'), 'placeholder' => 'bi bi-hand-thumbs-up', 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label' => form_label('Name of required field ' . $label_required),
      'element' => form_input(['name' => 'required_field', 'value' => sanitize_output($item_lang['required_field'] ?? ''), 'placeholder' => 'Link ...', 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'       => form_label('Url Slug ' . $label_required),
      'element'     => form_input(['name' => 'url_slug', 'value' => sanitize_output($item_lang['url_slug'] ?? ''), 'type' => 'text', 'class' => $class_element]),
      'type'        => "general-url-slug",
      'base_url'    => base_url(),
      'class_main'  => "col-md-12 col-sm-12 col-xs-12",
    ],
  ];
?>
<div class="row justify-content-md-center">
  <?php echo render_elements_form($elements_basic); ?>
</div>
