
<?php
    $coupon_header  = get_app_setting('coupon_header');
    $coupon_header  = json_decode($coupon_header, true);
?>

<?php if (isset($coupon_header['status']) && $coupon_header['status']) : ?>

    <style>
        .header-banner {
            text-align: center;
            background-color: #2de780;
            background-size: cover;
            background-image: url('<?= sanitize_output($coupon_header['image_background'] ?? BASE_URL . 'assets/themes/regular/img/home/coupon_header.webp') ?>');
            background-position: center;
            padding: 10px;
            color: #fff;
            font-weight: bold;
            text-transform: unset;
            margin-bottom: 0;
            position: relative;
        }

        .header-banner span {
            margin-bottom: 5px;
            font-weight: bold;
        }

        .header-banner p {
            margin: 0;
        }

        .header-banner a {
            text-decoration: underline;
            color: #fff;
        }

        .btn-close-banner {
            position: absolute;
            top: 5px;
            right: 10px;
            background-color: #b5b5b5;
            border: none;
            width: 24px;
            height: 24px;
            border-radius: 30%;
            font-size: 18px;
            line-height: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .countdown-timer {
            justify-content: center;
            margin-left: 3px;
        }
        
        .countdown-timer .label {
            font-size: 0.6rem;
        }
    </style>
    
    
    <div class="header-banner" id="coupon-banner">
        <button type="button" class="btn-close-banner" aria-label="Close">&times;</button>
        <?php if (isset($coupon_header['badge_title_status']) && $coupon_header['badge_title_status']) : ?>
            <span class="badge bg-primary"><?= sanitize_output($coupon_header['badge_title'] ?? '')?></span>
        <?php endif; ?>
        <span> <?= sanitize_output($coupon_header['content'] ?? '')?></span>

        <?php if (isset($coupon_header['counter_time_status']) && $coupon_header['counter_time_status']) : ?>
            <span class="countdown-timer">
                <span class="badge bg-dark">
                    <span class="hours">00</span><br>
                    <span class="label">HR</span>
                </span>
                <span class="badge bg-dark">
                    <span class="minutes">0</span><br>
                    <span class="label">MIN</span>
                </span>
                <span class="badge bg-dark">
                    <span class="seconds">00</span><br>
                    <span class="label">SEC</span>
                </span>
            </span>
        <?php endif; ?>

    </div>

    <script>
        $(document).ready(function() {
            // Declare variables for DOM elements
            var $couponBanner = $('#coupon-banner');
            var $btnCloseBanner = $('.btn-close-banner'); 
            // Start the countdown
            if ($('.countdown-timer').length > 0) {
                // Set default countdown values for hours and minutes
                var default_limit_coupon_hours = '<?=(int)sanitize_output($coupon_header['counter_time']['hours'] ?? 0) ?>';  
                var default_limit_coupon_minutes = '<?=(int)sanitize_output($coupon_header['counter_time']['minutes'] ?? 10) ?>';
                startCountdown(default_limit_coupon_hours, default_limit_coupon_minutes);
            }

            // Event listener for closing the banner when the close button is clicked
            $btnCloseBanner.click(function() {
                $couponBanner.addClass('d-none'); 
                localStorage.setItem('bannerClosed', 'true');
            });

            // Check if the banner has been closed previously by checking localStorage
            if (localStorage.getItem('bannerClosed') === 'true') {
                $couponBanner.addClass('d-none'); 
            }
        });
    </script>
<?php endif; ?>