<?php
  $form_config          = config('AppConfig')->template['form'];
  $class_element        = $form_config['class_element'];
  $label_required       = $form_config['label_required'];
  $contact_informations   = get_app_setting('contact_informations');

  $elements = [
    [
      'label' => form_label('Blog author name (used for blog author)'),
      'element' => form_input(['name' => 'blog_author_name', 'value' => get_app_setting('blog_author_name'), 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label' => form_label('Copy Right Content'),
      'element' => form_input(['name' => 'site_copy_right_content', 'value' => sprintf(get_app_setting('site_copy_right_content'), date('Y')), 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
  ];

  $form_input_html = '';
  if ($contact_informations) {
    $contact_informations = json_decode($contact_informations, true);
    foreach ($contact_informations as $key => $value) {
      $name = ucfirst($key);
      $form_input_html .= render_elements_form([
        [
          'label' => form_label( $name),
          'element' => form_input(['name' => "contact_informations[$key]", 'value' => sanitize_output($value ?? ''), 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
          'class_main' => "col-md-12",
        ],
      ]);
    }
  }
?>
<div class="row">
  <div class="col-md-12">
    <h5>Contact Information</h5>
    <fieldset class="form-fieldset">
      <?php echo $form_input_html;?>
    </fieldset>  
  </div>
  <?= render_elements_form($elements); ?>
</div>

