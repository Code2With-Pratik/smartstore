<?php
  $config_status        = config('AppConfig')->config['status'];
  $label_required       = config('AppConfig')->template['form']['label_required'];
  $class_element        = config('AppConfig')->template['form']['class_element'];
  $form_status = get_form_item_status_config($controller_name);
  array_unshift($items_social_network, ['id' => '', 'name' => 'Choose Social network']);
  $items_social_network = array_column($items_social_network, 'name', 'id');
  $items_social_network = sanitize_output($items_social_network);
  $elements_publish = [
    [
      'label' => form_label('Social network type ' . $label_required),
      'element' => form_dropdown('sncate_id', $items_social_network, sanitize_output(@$item['sncate_id']), ['class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label' => form_label('Status'),
      'element' => form_dropdown('status', $form_status, @$item['status'], ['class' => $class_element]),
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
      <?php echo render_button_form(['back_url' => admin_url('category')]);?>
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