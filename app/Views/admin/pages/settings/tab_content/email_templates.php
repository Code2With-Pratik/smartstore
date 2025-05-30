<?php
  $form_class                         = config('AppConfig')->template['form'];
  $class_element                      = $form_class['class_element'];
  $class_element_editor               = $form_class['class_element_editor'];
  $label_required                     = $form_class['label_required'];
  $class_element_checkbox_switch      = $form_class['class_element_checkbox_switch'];

  $email_templates = config('AppConfig')->general_setting['notification_email_templates'];

  $db_email_templates  = db_fetch('status, name, subject, content', TB_EMAIL_TEMPLATES);
  if (!empty($db_email_templates)) {
    $db_email_templates_key  = array_column($db_email_templates, 'name');
    $db_email_templates  = array_combine($db_email_templates_key, array_values($db_email_templates));
  }
?>  
<div class="row">
  <div class="col-md-12">

    <?php if ($email_templates) : $i = 1; ?>
      <?php foreach ($email_templates as $key => $item_template) : ?>
        <?php
          $item_template_name = $i . '. '. $item_template['template_name'];
          $email_templates_name = 'email_templates[' . $key . ']';
          $item_template_status = isset($db_email_templates[$key]['status']) ? $db_email_templates[$key]['status'] : 0;
          $item_template_subject = isset($db_email_templates[$key]['subject']) ? $db_email_templates[$key]['subject'] : $item_template['subject'];
          $item_template_content = isset($db_email_templates[$key]['content']) ? $db_email_templates[$key]['content'] : $item_template['content'];

          $switch_class = 'item-template-switch-'. $i;
          $switch_class_options = 'item-template-switch-options-'. $i;

          $elements = [
            [
              'label' => form_label("Status"),
              'element' => [
                'input_name'    => $email_templates_name . '[status]',
                'value'         => $item_template_status,
                'input_class'   => $class_element_checkbox_switch . ' '. $switch_class
              ],
              'class_main' => "",
              'type' => "checkbox-switch",
            ],
            [
              'label' => form_label('Subject'),
              'element' => form_input(['name' => $email_templates_name . '[subject]', 'value' => $item_template_subject, 'type' => 'text', 'class' => $class_element]),
              'class_main' => $switch_class_options,
            ],
            [
              'label' => form_label('Content'),
              'element' => form_textarea(['name' => $email_templates_name. '[content]', 'value' => $item_template_content, 'rows' => '2', 'class' => $class_element_editor]),
              'class_main' => $switch_class_options,
            ],
          ];

          $available_merge_fields = $item_template['available_merge_fields'];
          $available_merge_fields_list = '';
          foreach ($available_merge_fields as $key => $field) {
            $available_merge_fields_list .= sprintf('<li><span class="text-blue copy-to-clipboard">{{%s}}</span> - %s</li>', $key, $field);
          }

          $available_merge_fields_html = sprintf('
            <div class="form-group %s">
              <div class="small">Available merge fields<br>
                <ul>
                  %s
                </ul>
              </div>
            </div>', $switch_class_options, $available_merge_fields_list);

        ?>
        <div class="item">
          <h5><?= sanitize_output($item_template_name); ?></h5>
          <fieldset class="form-fieldset">
            <?= render_elements_form($elements); ?>
            <?= $available_merge_fields_html; ?>
          </fieldset>
        </div>
        <script>
          $(document).ready(function() {
            init_switch_toggle('.<?php echo $switch_class ?>', '.<?php echo $switch_class_options ?>', 'form');
          });
        </script>

      <?php ++$i; endforeach; ?>
    <?php endif; ?>    

  </div>
</div>

<style>
    .copy-to-clipboard {
      cursor: pointer;
      position: relative;
    }
    
    .copy-to-clipboard:hover::after {
      content: "Click to copy";
      position: absolute;
      top: -25px; 
      left: 50%;
      transform: translateX(-50%);
      background-color: black;
      color: white;
      padding: 3px 6px;
      font-size: 12px;
      border-radius: 5px;
      white-space: nowrap;
      z-index: 1000;
    }
    .copy-to-clipboard:hover::before {
    content: "";
    position: absolute;
    top: -3px;
    left: 50%;
    transform: translateX(-50%);
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    border-top: 5px solid black; /* Tạo mũi tên chỉ xuống dưới */
}
</style>

<script>
  $(document).ready(function() {
    $(".copy-to-clipboard").click(function() {
      const text = $(this).text(); 
      copyToClipboard(text);
    });

    function copyToClipboard(text) {
      const textarea = document.createElement("textarea");
      textarea.value = text;
      document.body.appendChild(textarea);
      textarea.select(); 
      document.execCommand("copy");
      document.body.removeChild(textarea);
      alert("Copied!");
    }
  });
</script>