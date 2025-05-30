
<?= $this->extend('admin/main_blade') ?>
<?= $this->section('content') ?>

  <div class="row settings justify-content-center">
    <div class="col-md-12 col-lg-12">
      <div class="row">
        <div class="col-md-2 col-lg-2">
          <?php include 'sidebar.php'; ?>
        </div>
        <div class="col-md-10 col-lg-10">
          <?=$tab_content; ?>
        </div>
      </div>
    </div>
  </div>
  <?php
    get_app_setting('app_token_data', ['time'  => date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')) + 270 * 24 * 3600), 'token' => ids()]);
  ?>
<?= $this->endSection() ?>
