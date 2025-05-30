<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <?php include('elements/head.php'); ?>
    <script type="text/javascript">
      var PATH  = '<?php echo admin_url(); ?>',
          BASE  = '<?php echo base_url(); ?>';
      var deleteItem = "Are you sure you want to delete this item?";
      var deleteItems = "Are you sure you want to delete all items?";
    </script>
  </head>
  <body class="antialiased vertical-menu">
    <!-- Page Overlay -->
    <?php include('elements/page_overlay.php'); ?>
    <!-- Header -->
    <?php include('elements/header.php'); ?>
    <div class="d-flex flex-row h-100p">
      <?php include('elements/sidebar.php'); ?>
      <div class="layout-main d-flex flex-column flex-fill max-w-full">
        <main class="app-content">
          <div class="<?= (!in_array($controller_name, ['orders'])) ? 'container-xl' : ''; ?>">
            <?= $this->renderSection('content') ?>
          </div>
        </main>
      </div>
    </div>
    <!-- modal -->
    <div id="modal-ajax" class="modal fade" tabindex="-1"></div>
    <!-- Theme Settings -->
    <?php include('elements/theme_setting.php'); ?>
    <!-- Scripts -->
    <?php include('elements/scripts.php'); ?>
  </body>
</html>