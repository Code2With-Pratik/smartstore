<?= $this->extend('admin/main_blade') ?>
<?= $this->section('content') ?>
  
  <div class="row justify-content-center row-card statistics">
    <!-- header Statistic -->
    <?= $header_statistics_area; ?>

    <!-- Order chart spline -->
    <?= $order_chart_spline_area; ?>

    <!-- Top Clients orders area -->
    <?= $top_clients_orders_area; ?>

    <!-- Recent Clients area -->
    <?= $recent_clients_area; ?>

  </div>

<?= $this->endSection() ?>
