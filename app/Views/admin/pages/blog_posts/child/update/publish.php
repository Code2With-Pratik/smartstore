<?php
  $form_class                     = config('AppConfig')->template['form'];
  $class_element                  = $form_class['class_element'];
  $class_element_editor           = $form_class['class_element_editor'];
  $label_required                 = $form_class['label_required'];
  $class_element_datepicker       = $form_class['class_element_datepicker'];

  $form_status = get_form_item_status_config($controller_name);
  array_unshift($items_category, ['id' => '', 'name' => 'Choose Post Category']);
  $items_category = array_column($items_category, 'name', 'id');
  $items_category = sanitize_output($items_category);
  $elements_publish = [
    [
      'label' => form_label('Post Category ' . $label_required),
      'element' => form_dropdown('cate_id', $items_category, sanitize_output($item['cate_id'] ?? ''), ['class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label' => form_label('Status'),
      'element' => form_dropdown('status', $form_status, sanitize_output($item['status'] ?? ''), ['class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label' => form_label('Publication Date ' . $label_required),
      'element' => form_input(['name' => 'released', 'value' => sanitize_output($item['released'] ?? ''), 'type' => 'text', 'required' => 'required', 'class' => $class_element_datepicker]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
  ];
?>

<div class="form-body">
  <div class="row">
    <?php
      echo render_elements_form($elements_publish);
    ?>
    <div class="col-md-12 col-sm-12 col-xs-12">
      <?php echo render_button_form(['back_url' => admin_url($controller_name)]);?>
    </div>
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
