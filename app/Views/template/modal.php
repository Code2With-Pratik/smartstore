<div id="main-modal-content">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header bg-pantone">
          <h4 class="modal-title"><i class="fa fa-edit"></i> <?=esc($modalTitle)?></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <?=($modalType == 'form' && isset($formData)) ? form_open($formData['url'], $formData['attributes'] + ['data-options' => isset($formData['options']) ? json_encode($formData['options']) : '', ENT_QUOTES, 'UTF-8']): ''?>
          <div class="modal-body">
            <div class="row justify-content-md-center">
              <?php echo $modalContent; ?>
            </div>
          </div>
          <div class="modal-footer">
            <?php echo render_button_form(['modal_close_btn' => true]);?>
          </div>
        <?=($modalType == 'form' && isset($formData)) ? form_close(): ''?>
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

<script>
  "use strict";
  $(document).ready(function() {
    plugin_editor('.plugin_editor', {height: 400}, true);
  });
</script>