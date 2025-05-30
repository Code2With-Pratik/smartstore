
<?= $this->extend('admin/main_blade') ?>
<?= $this->section('content') ?>
  <?php
    $cron_key = get_cron_key();
    $cron_format = config('AppConfig')->cronjobs['format'];
    $cron_links  = config('AppConfig')->cronjobs['links'];
  ?>
  <div class="row api-documentation">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Cronjobs configure</h3>
        </div>
        <div class="card-body">
          <div class="note">
            To be able to send order, order status. Cron task must be configured on your hosting. In cpanel, you should click Cron task and fill this command at the command filed:
          </div>
          <h6 class="m-t-30">Cronjob for main script <span class="small text-danger">(Once/minute)</span></h6>
          <div>
            <?php foreach ($cron_links as $key => $item_link): ?>
              <?php
                $link = base_url('cron/') . $key . '?key=' . $cron_key;
              ?>
              <div class="item m-t-20">
                <code><?= sprintf($cron_format, $link); ?></code>
              </div>
            <?php endforeach ?>
          </div>
          <div class="m-t-30">
            <p> With <strong>Hostinger</strong>, Please click  <a href="https://smartpanelsmm.com/docs/smartstore.php" target="_blank" rel="Documentation">this link</a> for more details</p>
          </div>
        </div>
      </div>
    </div>
  </div>

<?= $this->endSection() ?>
