<!-- Include JavaScript for color modes -->
<script src="<?php echo base_url(); ?>/assets/themes/regular/js/color-modes.js"></script>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?=render_html_meta_token();?>
<?php
    $default_page_seo   = json_decode(get_app_setting('website_seo'), true);
    $page_title         = (isset($page_seo['title']) && !empty($page_seo['title'])) ? $page_seo['title'] : $default_page_seo['title'];
    $page_keywords      = (isset($page_seo['keywords']) && !empty($page_seo['keywords'])) ? $page_seo['keywords'] : $default_page_seo['keywords'];
    $page_description   = (isset($page_seo['description']) && !empty($page_seo['description'])) ? $page_seo['description'] : $default_page_seo['description'];
    $page_image_url   = (isset($page_seo['image_url']) && !empty($page_seo['image_url'])) ? $page_seo['image_url'] : $default_page_seo['image_url'];
    $page_url_index   = (isset($page_seo['index']) && !empty($page_seo['index'])) ? $page_seo['index'] : $default_page_seo['index'];
    $page_author        = get_app_setting('website_name');
    $page_favicon       = get_app_setting('website_favicon');
    if ($page_url_index == 'index') {
        $page_seo_url = current_url();
    } else {
        $page_seo_url = client_url();
    }
?>
<meta name="description" content="<?php echo sanitize_output($page_description); ?>">
<meta name="keywords" content="<?php echo sanitize_output($page_keywords); ?>">
<meta name="author" content="<?php echo sanitize_output($page_author); ?>">
<meta name="generator" content="<?php echo sanitize_output($page_title); ?>">

<!-- Open Graph Meta Tags -->
<meta property="og:title" content="<?php echo sanitize_output($page_title); ?>">
<meta property="og:description" content="<?php echo sanitize_output($page_description); ?>">
<?php
    if (!empty($page_image_url)) echo sprintf('<meta property="og:image" content="%s">', $page_image_url);
?>
<meta property="og:url" content="<?php echo $page_seo_url?>">
<meta property="og:type" content="website">
<meta property="og:locale" content="en_US">
<meta property="og:image:type" content="image/jpeg">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="<?php echo sanitize_output($page_title); ?>">

<!-- Twitter Card Meta Tags -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="<?php echo sanitize_output($page_title); ?>">
<meta name="twitter:title" content="<?php echo sanitize_output($page_title); ?>">
<meta name="twitter:description" content="<?php echo sanitize_output($page_description); ?>">
<?php
    if (!empty($page_image_url)) echo sprintf('<meta name="twitter:image" content="%s">', $page_image_url);
?>
<title><?php echo sanitize_output($page_title); ?></title>
<link rel="canonical" href="<?php echo $page_seo_url; ?>">

<!-- favicon -->
<link rel="icon" type="image/x-icon" href="<?php echo $page_favicon; ?>">

<!--jquery  -->
<script src="<?php echo base_url(); ?>/assets/plugins/jquery/jquery-3.6.0.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/admin/js/ajaxHander.js"></script>

<!-- main css -->
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/themes/regular/css/main.css">

<!-- Plugins -->
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/themes/regular/plugins/bootstrap/bootstrap-icons/bootstrap-icons.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/themes/regular/plugins/aos/aos.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/themes/regular/plugins/odometer/odometer.css">

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/themes/regular/plugins/owlcarousel/dist/assets/owl.carousel.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/themes/regular/plugins/owlcarousel/dist/assets/owl.theme.default.min.css">
<script src="<?php echo base_url(); ?>/assets/themes/regular/plugins/owlcarousel/dist/owl.carousel.min.js"></script>

<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/plugins/intl-tel-input/build/css/intlTelInput.css" />

<!-- landing page -->
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/themes/regular/css/landing_page.css">


<!-- Header code -->
<?php
    $header_code = get_app_setting('embed_js_code_header');
    if (!empty($header_code)) echo htmlspecialchars_decode($header_code, ENT_QUOTES);
?>
