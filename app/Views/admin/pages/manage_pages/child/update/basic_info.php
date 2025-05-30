<?php
  $class_element        = config('AppConfig')->template['form']['class_element'];
  $class_element_editor = config('AppConfig')->template['form']['class_element_editor'];
  $label_required       = config('AppConfig')->template['form']['label_required'];
  
  $elements_basic = [
    [
      'label' => form_label('Name ' . $label_required),
      'element' => form_input(['name' => 'name', 'value' => sanitize_output(@$item_lang['name']), 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
  ];

  $page_type = $item['page_type'] ?? 'default';
  if (in_array($page_type, ['default'])) {
    $elements_basic = array_merge($elements_basic, [
      [
        'label'       => form_label('Permalink ' . $label_required),
        'element'     => form_input(['name' => 'url_slug', 'value' => sanitize_output($item_lang['url_slug'] ?? ''), 'type' => 'text', 'class' => $class_element]),
        'type'        => "general-url-slug",
        'base_url'    => base_url(),
        'class_main'  => "col-md-12 col-sm-12 col-xs-12",
      ],
    ]);
  } else {
    $elements_basic = array_merge($elements_basic, [
      [
        'label' => form_label('Permalink ' . $label_required),
        'element' => form_input(['name' => 'url_slug', 'value' => base_url($item['page_type'] == 'blog' ? 'blog' : ''), 'type' => 'text', 'readonly' => 'readonly', 'class' => $class_element]),
        'class_main' => "col-md-12 col-sm-12 col-xs-12",
      ],
    ]);
  }

?>
<div class="row justify-content-md-center">
  <?php echo render_elements_form($elements_basic); ?>
</div>