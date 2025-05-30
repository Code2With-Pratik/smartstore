<?php
  $is_message = null;
  if (isset($status) && isset($message)) {
    switch ($status) {
      case 'error':
        $title = 'ERROR!';
        $icon = 'fe fe-alert-triangle';
        $class_alert = 'alert-warning';
        break;
      case 'success':
        $title = 'SUCCESS!';
        $icon = 'fe fe-check';
        $class_alert = 'alert-success';
        break;
      
      default:
        $title = 'Error!';
        $icon = 'fe fe-alert-triangle';
        $class_alert = 'alert-warning';
        break;
    }
    $is_message =  true;
  };
?>
<?php
  if ($is_message) : 
?>
<style>
  button.close:before {
    font-size: 17px;
  }
</style>
<div class="m-t-20 ajax-alert-message">
  <div class="alert <?= $class_alert ?> alert-dismissible fade show" role="alert">
    <strong><i class="<?= $icon ?>"></i> <?= $title ?></strong>
    <div><?= $message ?></div>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true"></span>
    </button>
  </div>
</div>
<?php endif; ?>