<meta charset="utf-8" />
<?php
    //pr($controller_name, 1);
?>
<?=render_html_meta_token();?>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta http-equiv="Content-Language" content="en">
<title><?= generate_admin_title($controller_name); ?></title>
<link rel="shortcut icon" type="image/x-icon" href="<?= get_app_setting('website_favicon') ; ?>">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-capable" content="yes">
<meta name="HandheldFriendly" content="True">
<meta name="MobileOptimized" content="320">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
<script src="<?= base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url() ?>/assets/plugins/jquery/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>/assets/admin/js/ajaxHander.js"></script>
<?php
    if (isset($load_files) && isset($load_files['jsFiles']['head']) && $load_files['jsFiles']['head']) {
        foreach ($load_files['jsFiles']['head'] as $key => $jsFile) {
            echo sprintf('<!-- %s --><script type="text/javascript" src="%s"></script>', $key, base_url($jsFile));
        }
    }
?>
<link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/font-awesome/css/font-awesome.min.css">
<!-- vendor -->
<?php
    if (isset($load_files) && isset($load_files['cssFiles']) && $load_files['cssFiles']) {
        foreach ($load_files['cssFiles'] as $key => $cssFile) {
            echo sprintf('<!-- %s --><link rel="stylesheet" href="%s">', $key, base_url($cssFile));
        }
    }
?>
<link href="<?= base_url() ?>/assets/admin/vendors/css/vendor.css" rel="stylesheet">
<link href="<?= base_url() ?>/assets/admin/dist/css/admin-core.css" rel="stylesheet">
<link href="<?= base_url() ?>/assets/admin/dist/css/layout.css" rel="stylesheet">