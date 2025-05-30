<?php
  $form_config = config('AppConfig')->template['form'];
  $class_element                    = $form_config['class_element'];
  $label_required                   = $form_config['label_required'];

  $smtp_info       = get_app_setting('smtp_info');
  $smtp_info       = ($smtp_info) ? json_decode($smtp_info, true) : [];

  $smtp_protocol_arr = [
    'sendmail' => 'Sendmail',
    'mail' => 'PHP mail function',
    'smtp' => 'SMTP (Recommended)',
  ];
 
  $elements = [
    [
      'label' => form_label('Sender Email <i class="fa fa-question-circle" data-toggle="tooltip" data-title="The email address that will be shown as the sender of the emails"></i>'),
      'element' => form_input(['name' => 'smtp_info[smtp_from_email]', 'value' => sanitize_output($smtp_info['smtp_from_email'] ?? ''), 'placeholder' => 'Enter from email ...', 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
      'class_main' => "col-md-12",
    ],
    [
      'label' => form_label('Sender name <i class="fa fa-question-circle" data-toggle="tooltip" data-title="The name that will appear as the sender of the emails"></i>'),
      'element' => form_input(['name' => 'smtp_info[smtp_from_name]', 'value' => sanitize_output($smtp_info['smtp_from_name'] ?? ''), 'placeholder' => 'Enter from name ...', 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
      'class_main' => "col-md-12",
    ],
    [
      'label' => form_label('Mailer (protocol) ' . render_tooltip_popover_html("When using PHP mail or Sendmail, emails may sometimes be marked as spam. To avoid this, we recommend using SMTP. If you choose PHP mail or Sendmail, be sure to configure the <code>mailPath</code> correctly to ensure emails are sent reliably.")),
      'element' => form_dropdown('smtp_info[protocol]', $smtp_protocol_arr, sanitize_output($smtp_info['protocol'] ?? ''), ['class' => 'form-control', 'id' => 'protocol-select']),
      'class_main' => "col-md-12",
    ],
    [
      'label' => form_label('SMTP Host ' . render_tooltip_popover_html("The hostname or IP address of the SMTP server used to send emails")),
      'element' => form_input(['name' => 'smtp_info[smtp_host]', 'value' => sanitize_output($smtp_info['smtp_host'] ?? ''), 'placeholder' => 'e.g. smtp.gmail.com', 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
      'class_main' => "col-md-12 smtp-fields",
    ],
    [
      'label' => form_label('SMTP User ' . render_tooltip_popover_html("The username for the SMTP server. Usually, it is your email address")),
      'element' => form_input(['name' => 'smtp_info[smtp_user]', 'value' => sanitize_output($smtp_info['smtp_user'] ?? ''), 'placeholder' => 'Your SMTP username', 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
      'class_main' => "col-md-12 smtp-fields",
    ],
    [
      'label' => form_label('SMTP password ' . render_tooltip_popover_html("The password for the SMTP server. This is required to authenticate the email sending", 'tooltip')),
      'element' => form_input(['name' => 'smtp_info[smtp_pass]', 'value' => sanitize_output($smtp_info['smtp_pass'] ?? ''), 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
      'class_main' => "col-md-12 smtp-fields",
    ],
    [
      'label' => form_label('SMTP Port ' . render_tooltip_popover_html("The port number used to connect to the SMTP server. Common ports are 25, 465, 587, and 2525. ", 'tooltip')),
      'element' => form_input(['name' => 'smtp_info[smtp_port]', 'value' => sanitize_output($smtp_info['smtp_port'] ?? ''), 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
      'class_main' => "col-md-12 smtp-fields",
    ],
    [
      'label' => form_label('Mail Path ' . render_tooltip_popover_html("The <code>mailPath</code> is the path to the Sendmail executable. It is used to configure the PHP mail or Sendmail function. For example, <code>/usr/sbin/sendmail -bs -i</code> ensures proper email sending and prevents email from being truncated or marked as spam.")),
      'element' => form_input(['name' => 'smtp_info[mailPath]', 'value' => sanitize_output($smtp_info['mailPath'] ?? ''), 'placeholder' => '/usr/sbin/sendmail -bs -i', 'type' => 'text', 'required' => 'required', 'class' => $class_element]),
      'class_main' => "col-md-12 mail-path-field",
    ],
  ];
 
?>
<div class="row">
  <?= render_elements_form($elements);?>
  <div class="col-12 mb-1">
    <a href="<?= admin_url( $controller_name . '/send_test_mail')?>" type="submit" class="btn btn-outline-info  ajaxModal" >
      Send Test Mail
    </a>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#protocol-select').change(function() {
      var protocol = $(this).val();
      if (protocol === 'smtp') {
        $('.smtp-fields').removeClass('d-none');
        $('.mail-path-field').addClass('d-none');
      } else if (protocol === 'sendmail' || protocol === 'mail') {
        $('.smtp-fields').addClass('d-none');
        $('.mail-path-field').removeClass('d-none');
      }
    });
    $('#protocol-select').trigger('change');
  });

</script>