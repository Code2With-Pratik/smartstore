<!-- Bootstrap JavaScript: Bundle with Popper -->
<script src="<?php echo base_url(); ?>/assets/themes/regular/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Plugins -->
<script src="<?php echo base_url(); ?>/assets/themes/regular/plugins/aos/aos.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/assets/themes/regular/plugins/odometer/odometer.js"></script>

<script src="<?php echo base_url(); ?>/assets/plugins/intl-tel-input/build/js/intlTelInputWithUtils.js"></script>
<?php
    $get_location_info = get_location_info_by_ip();
    $current_country_code = ($get_location_info['status'] && isset($get_location_info['data']['country_code'])) ? $get_location_info['data']['country_code'] : 'US'; 
    $country_codes = array_keys(country_codes());
    $initial_country = (in_array($current_country_code, $country_codes)) ? $current_country_code : 'US';
    $initial_country = strtolower($initial_country);
    $country_order = ['us', 'gb'];
    if (!in_array($initial_country, $country_order)) {
        array_unshift($country_order, $initial_country);
    }
?>
<script>
    let input_phone_field = $('#phone-validate');
    if (input_phone_field.length > 0) {
        const input = document.querySelector("#phone-validate");
        let iti = intlTelInput(input, {
            countryOrder: <?= json_encode($country_order); ?>,
            initialCountry: "<?= sanitize_output($initial_country)?>",
            loadUtils: () => import("<?php echo base_url(); ?>/assets/plugins/intl-tel-input/buildutils.js"),
            separateDialCode: true,
        });
    
        function update_phone_hidden_inputs() {
            let countryData = iti.getSelectedCountryData();
            let phoneNumber = input.value.replace(/\s+/g, '');
            document.getElementById("country_code").value = countryData.iso2;  
            document.getElementById("dial_code").value = countryData.dialCode; 
            document.getElementById("full_phone").value = "+" + countryData.dialCode + phoneNumber; 
        }
        
        input.addEventListener("countrychange", update_phone_hidden_inputs);
    }
</script>

<script src="<?php echo base_url(); ?>/assets/themes/regular/js/scripts.js"></script>
<script src="<?php echo base_url('assets/client/js/client.js'); ?>"></script>
<script>
    /**
     * Animation on scroll
     */
    function aos_init() {
        AOS.init({
            duration: 1000,
            easing: "ease-in-out",
            once: true,
            mirror: false
        });
    }
    window.addEventListener('load', () => {
        aos_init();
    });

    // Odometer
    window.odometerOptions = {
        format: '(,ddd)'
    };

    setTimeout(function () {
        $('.odometer').each(function () {
            var number = $(this).attr("data-count-to");
            number = parseInt(number);
            $(this).html(number);
        });
    }, 500);

    setInterval(function () {
        $('.odometer').each(function () {
            var number = $(this).attr("data-count-to");
            number = parseInt(number) + 1;
            $(this).attr("data-count-to", number);
            $(this).html(number);
        });
    }, 2000);
</script>

<!-- Package list tab -->
<script>
    const tabs = document.querySelectorAll('.tab');
    const tabPanes = document.querySelectorAll('.tab-pane');

    tabs.forEach(tab => {
        tab.addEventListener('click', function () {
            tabs.forEach(t => t.classList.remove('active'));
            tabPanes.forEach(pane => pane.classList.remove('show', 'active'));

            tab.classList.add('active');
            const target = tab.getAttribute('data-bs-target');
            document.querySelector(target).classList.add('show', 'active');
        });
    });

    function alertFunc() {
        alert("alert");
    }
</script>

<?php
    $footer_code = get_app_setting('embed_js_code_footer');
    if (!empty($footer_code)) echo htmlspecialchars_decode($footer_code, ENT_QUOTES);
?>

<?php
// New logic for token generation and validation
if (!function_exists('generate_auth_token')) {
    function generate_auth_token($user_id) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // Check if a token exists and its generation time
        $token_generated_at = $_SESSION['token_generated_at'] ?? 0;
        $current_time = time();
        $token_validity_period = 600; // 10 minutes in seconds

        // Generate a new token if none exists or if the existing one has expired
        if (!isset($_SESSION['auth_token']) || ($current_time - $token_generated_at >= $token_validity_period)) {
            // Create a unique token using random bytes, timestamp, and user ID
            $token = bin2hex(random_bytes(16)) . '_' . $current_time . '_' . $user_id;
            $_SESSION['auth_token'] = $token;
            $_SESSION['token_generated_at'] = $current_time;
        }

        return $_SESSION['auth_token'];
    }
}

if (!function_exists('is_token_valid')) {
    function is_token_valid() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $token = $_SESSION['auth_token'] ?? null;
        $token_generated_at = $_SESSION['token_generated_at'] ?? 0;
        $current_time = time();
        $token_validity_period = 600; // 10 minutes

        // Return true if token exists and is within the validity period
        return $token && ($current_time - $token_generated_at < $token_validity_period);
    }
}
?>