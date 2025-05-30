<?php
  $template = config('AppConfig')->admin_setting['sidebar'];
  $card_title = sprintf('<h3 class="card-title"><i class="%s"></i> %s</h3>', $template[$tab_key]['icon'], $template[$tab_key]['name']);
  $form_url = admin_url($controller_name."/store/");

  $form_attributes = [
    'class' => 'form actionForm', 
    'data-redirect' => current_url(), 
    'method' => "POST"
  ];

  $form_hidden = [
    'tab_key' => $tab_key, 
  ];
?>

<?php echo form_open($form_url, $form_attributes, $form_hidden); ?>
  <div class="card content">
    <div class="card-header">
      <?=sanitize_output($card_title)?>
    </div>

    <div class="card-body">
      <?php 
        echo view($path_view_controller . '/tab_content/' . $tab_key, []);
      ?>
    </div>
    <div class="card-footer text-end">
      <?php echo render_button_form([]);?>
    </div>
  </div>
<?php echo form_close(); ?>

<?php if (!empty($js_validation_config) && !empty($js_validation_config['rules']) && !empty($js_validation_config['messages'])) : ?>
  <script>
    $(document).ready(function () {
      const rules = <?= $js_validation_config['rules']; ?>;
      const messages = <?= $js_validation_config['messages']; ?>; 
      setup_form_js_validation(".actionForm", rules, messages);
    });
  </script>
<?php endif; ?>

<script>
  "use strict";
  $(document).ready(function() {
    plugin_editor('.plugin_editor', {append_plugins: 'code', height: 200});
  });
</script>