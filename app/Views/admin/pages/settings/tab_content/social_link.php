<?php
  $form_config = config('AppConfig')->template['form'];
  $class_element        = $form_config['class_element'];
  $label_required       = $form_config['label_required'];

  $social_links         = get_app_setting('social_links');
  $form_input_html = '';
  if ($social_links) {
    $social_links = json_decode($social_links, true);
    foreach ($social_links as $key => $social_link) {
      $name = ucfirst($key);
      $form_input_html .= render_elements_form([
        [
          'label' => form_label( $name . ' link'),
          'element' => form_input(['name' => "social_links[$key][link]", 'value' => sanitize_output($social_link['link'] ?? ''), 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
          'class_main' => "col-md-6",
        ],
        [
          'label' => form_label( $name . " icon's class (Boostrap 5)"),
          'element' => form_input(['name' => "social_links[$key][icon]", 'value' => sanitize_output($social_link['icon'] ?? ''), 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
          'class_main' => "col-md-6",
        ],
      ]);
    }
  }
?>
<div class="row">
  <?php echo $form_input_html;?>
</div>

