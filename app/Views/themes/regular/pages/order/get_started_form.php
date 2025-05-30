<!-- order-form -->

<section class="py-3 overflow-hidden order-form">
    <div class="container py-3">
        <div class="row g-4 justify-content-center">
            <div class="col-12 col-lg-7 col-xl-7">
                <!-- Card Wrapper -->
                <div class="card shadow-lg rounded-4 p-4">
                    <h3 class="card-title text-center mb-2 bg-light text-dark p-2"><?= __l("Order_form"); ?></h3>
                    <form class="form sendForm" action="<?=client_url('order/collect') ?>" method="POST" accept-charset="utf-8">
                        <?= csrf_field(); ?>
                        <!-- Your Name -->
                        <div class="mb-3">
                            <label for="link" class="form-label"><?= sanitize_output($required_field_name)?></label>
                            <input type="text" class="form-control" name="link" placeholder="<?= sanitize_output($required_field_name)?>" >
                            <div class="invalid-feedback"></div>
                        </div>

                        <!-- Your Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label"><?= __l("Your_Email"); ?></label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="<?= __l("Enter_your_email"); ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="quality" class="form-label"><?= __l("Choose_a_Package"); ?>
                                <i class="bi bi-pencil-square ms-2 text-primary" id="change_quality"
                                    style="cursor: pointer;" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="<?= __l("Switch_Package"); ?>"></i>
                            </label>
                            <select class="form-select" id="quality" disabled >
                                <?php 
                                    if (!empty($items_related)) {
                                        foreach ($items_related as $key => $item_service) {
                                            $item_ids = $item_service['ids'];
                                            $selected = ($item_service['ids'] == $item_main['ids']) ? 'selected' : '';
                                            $name = $item_service['quantity']  . ' '. $item_service['name'];
                                            echo sprintf('<option value="%s" %s> %s</option>', $item_ids, $selected, $name);
                                        }
                                    } else {
                                        echo '<option value="11">' . __l("Choose_a_Package"). '</option>';
                                    }
                                ?>
                            </select>
                            <input type="hidden" id="service_ids_hidden" name="service_ids" value="<?php echo $item_main['ids']; ?>">
                            <div class="invalid-feedback">
                                <?= __l("Please_select_a_valid_package"); ?>
                            </div>
                        </div>

                        <?= render_recaptcha_html('order_form'); ?>
                        
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-outline-primary btn-lg w-100">
                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> <?= __l("Continue"); ?>
                        </button>
                        <div class="mt-2">
                            <div class="ajax-alert-message"></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-12 col-lg-7 col-xl-7 text-center">
                <img src="<?= base_url() ?>/assets/themes/regular/img/home/trustpilot-stars.svg" alt="boost-your-social-media-impact-with-expert-support" height="100">
            </div>
        </div>
    </div>
</section>

<script>
    const editIcon = document.getElementById('change_quality');
    const qualitySelect = document.getElementById('quality');
    editIcon.addEventListener('click', function() {
        qualitySelect.disabled = false;
        qualitySelect.addEventListener('change', function() {
            var hiddenInput = document.getElementById('service_ids_hidden');
            hiddenInput.value = qualitySelect.value;
        
        });
    });
</script>

