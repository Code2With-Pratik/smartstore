<?php
  $config_status        = config('AppConfig')->config['status'];
  $label_required       = config('AppConfig')->template['form']['label_required'];
  $class_element        = config('AppConfig')->template['form']['class_element'];
  $form_status          = get_form_item_status_config($controller_name);
  $template_type        = config('AppConfig')->template['pages'];
  $template_class = ($task == 'edit_item') ? 'd-none' : 'd-none';
  $elements_publish = [
    [
      'label' => form_label('Tempalate' . $label_required),
      'element' => form_dropdown('page_type', $template_type, @$item['page_type'], ['class' => $class_element . ' changeTemplateType'] ),
      'class_main' => "col-md-12 col-sm-12 col-xs-12 " . $template_class,
    ],
    [
      'label' => form_label('Status'),
      'element' => form_dropdown('status', $form_status, @$item['status'], ['class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
  ];
?>

<div class="row">
  <?php
    echo render_elements_form($elements_publish);
  ?>
  <div class="col-md-12 col-sm-12 col-xs-12">
    <?php echo render_button_form(['back_url' => admin_url($controller_name)]);?>
  </div>
</div>

<?php if (!empty($js_validation_config) && !empty($js_validation_config['rules']) && !empty($js_validation_config['messages'])) : ?>
  <script>
    $(document).ready(function () {
      const rules = <?= $js_validation_config['rules']; ?>;
      const messages = <?= $js_validation_config['messages']; ?>; 
      setup_form_js_validation(".actionForm", rules, messages);
    });
  </script>
<?php endif; ?>