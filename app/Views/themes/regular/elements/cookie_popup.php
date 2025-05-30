
<?php
    $cookie_popup   = get_app_setting('cookie_popup');
    $cookie_popup   = json_decode($cookie_popup, true);
?>

<?php if (isset($cookie_popup['status']) && $cookie_popup['status']) : ?>
    <style>
        .cookie-popup {
            display: none; 
            position: fixed;
            bottom: 10px;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            font-size: 14px;
            z-index: 1000;
            min-width: 300px;
            width: 400px;
            max-width: 90%;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.3);
        }

        /* Position classes */
        .cookie-popup.left {
            left: 20px;
        }

        .cookie-popup.right {
            right: 20px;
        }

        .cookie-popup.center {
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
    <?php
        $cookie_content = ($cookie_popup['content'] ?? '');
        $cookie_content = str_replace('<p></p>', '<br>', $cookie_content);
        $cookie_content = str_replace('<p><span></span></p>', '<br>', $cookie_content);
    ?>
    <div id="cookie-popup" class="cookie-popup" data-position="<?= sanitize_output($cookie_popup['popup_position'] ?? 'left'); ?>" data-expirydays= "<?= sanitize_output($cookie_popup['popup_position'] ?? 7); ?>">
        <div class="popup-content">
            <?= sanitize_output($cookie_content) ?>
            <div class="button-container">
                <button class="btn btn-primary" id="accept-cookies"><?= sanitize_output($cookie_popup['button_title'] ?? __l("Appcept_all_cookies")) ?></button>
                <button class="btn btn-dark close-popup" id="close-popup"><?= __l("Close"); ?></button>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        check_cookie_popup('cookie-popup', 'accept-cookies');
    });
    </script>
<?php endif; ?>