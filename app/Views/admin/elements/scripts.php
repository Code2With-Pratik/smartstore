<script type="text/javascript" src="<?= base_url() ?>/assets/js/vendors/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/admin/vendors/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/js/core.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/admin/dist/js/admin-core.min.js"></script>

<?php if (segment(2) != 'login') : ?>
    <script type="text/javascript" src="<?= base_url() ?>/assets/admin/dist/js/customizer.js"></script>
<?php endif ?>

<!-- Plugins -->
<?php
    if (isset($load_files) && isset($load_files['jsFiles']['scripts']) && $load_files['jsFiles']['scripts']) {
        foreach ($load_files['jsFiles']['scripts'] as $key => $jsFile) {
            echo sprintf('<!-- %s --><script type="text/javascript" src="%s"></script>', $key, base_url($jsFile));
        }
    }
?>
<!-- toast -->
<script type="text/javascript" src="<?= base_url() ?>/assets/plugins/jquery-toast/js/jquery.toast.js"></script>
<!-- general JS -->
<script type="text/javascript" src="<?= base_url() ?>/assets/js/process.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/admin/js/admin.js"></script>