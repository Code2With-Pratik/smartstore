<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <?php include('elements/head.php'); ?>
    <script type="text/javascript">
      var token = '<?php echo csrf_hash(); ?>',
          PATH  = '<?php echo admin_url(); ?>',
          BASE  = '<?php echo base_url(); ?>';
    </script>
    <link href="<?php echo base_url('assets/admin/css/admin.css'); ?>" rel="stylesheet">
  </head>
  <body>
    <!-- Page Overlay -->
    <?php include('elements/page_overlay.php'); ?>
      <main class="app-content">
        <?= $this->renderSection('content') ?>
      </main>
    <!-- Scripts -->
    <?php include('elements/scripts.php'); ?>
  </body>
</html>