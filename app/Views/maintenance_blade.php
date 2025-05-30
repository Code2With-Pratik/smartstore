<?php
    $page_author        = get_app_setting('website_name');
    $page_favicon       = get_app_setting('website_favicon');
    $default_page_seo   = json_decode(get_app_setting('website_seo'), true);
    $page_title         = (isset($page_seo['title']) && !empty($page_seo['title'])) ? $page_seo['title'] : $default_page_seo['title'];
    $page_keywords      = (isset($page_seo['keywords']) && !empty($page_seo['keywords'])) ? $page_seo['keywords'] : $default_page_seo['keywords'];
    $page_description   = (isset($page_seo['description']) && !empty($page_seo['description'])) ? $page_seo['description'] : $default_page_seo['description'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= sanitize_output($page_author); ?> | Maintenance Mode</title>
    <meta name="description" content="<?php echo sanitize_output($page_description); ?>">
    <meta name="keywords" content="<?php echo sanitize_output($page_keywords); ?>">
    <meta name="author" content="<?php echo sanitize_output($page_author); ?>">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="<?= sanitize_output($page_favicon); ?>">

    <style {csp-style-nonce}>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            transition: background-color 300ms ease, color 300ms ease;
        }

        *:focus {
            background-color: rgba(221, 72, 20, .2);
            outline: none;
        }

        html, body {
            height: 100%;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji";
            font-size: 16px;
            color: rgba(33, 37, 41, 1);
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        section {
            display: flex;
            flex-direction: column;
            justify-content: center; 
            align-items: center;     
            text-align: center;
            padding: 20px;
        }
        img {
            max-width: 100%;
            width: 75%; 
            margin-bottom: 20px;
        }
        h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            color: #333;
        }

        p {
            font-size: 1.2rem;
            color: #666;
        }
    </style>
</head>
<body>

<section>
    <img src="<?=  base_url(); ?>assets/images/maintenance.svg" alt="maintenance mode">
    <h1>Oops! The site is under maintenancee</h1>
    <p>We apologize for any inconvenience caused. We're almost done and will be back shortly!</p>
</section>

</body>
</html>
