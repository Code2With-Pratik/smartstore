<!-- Contact us section -->
<?php
    $image_position = ($section_fields['image_position'] === 'left') ? 'order-first' : '';
?>

<section class="page-single-content overflow-hidden py-8 py-md-6 py-xl-10 position-relative">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 bg-light bg-opacity-75 p-4 rounded-3 text-dark dark:bg-dark bg-opacity-50 dark:text-light">
                <h1><?=sanitize_output($section_fields['title'] ?? '') ; ?></h1>
                <p><?=sanitize_output($section_fields['short_desc'] ?? '') ; ?></p>
                <form class="sendForm" action="<?= base_url('contact-us/message')?>" method="POST">
                    <div class="mb-3">
                        <label for="clientName" class="form-label"><?= __l("Your_Name"); ?> <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" id="clientName" required placeholder="John Smith">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label"><?= __l("Email"); ?> <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" id="email" required placeholder="johnsmith@example.com">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label"><?= __l("Phone"); ?> <span class="text-danger">*</span></label>
                        <input type="tel" name="phone" class="form-control" id="phone" required  placeholder="+84">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label"><?= __l("Subject"); ?> <span class="text-danger">*</span></label>
                        <select class="form-select" id="category" name="subject" required>
                            <option value="order_id" selected><?= __l("Order_ID"); ?></option>
                            <option value="payment"><?= __l("Payment"); ?></option>
                            <option value="other"><?= __l("Other"); ?></option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3" id="orderIdInput">
                        <label for="order_id" class="form-label"><?= __l("Your_Order_ID"); ?></label>
                        <input type="text" class="form-control" id="order_id" name="order_id" placeholder="Enter Your Order ID ....">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3 d-none" id="paymentIdInput">
                        <label for="payment_id" class="form-label"><?= __l("Transaction_ID"); ?></label>
                        <input type="text" class="form-control" id="payment_id" name="transaction_id" placeholder="Enter Transaction ID ....">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label"><?= __l("Message"); ?> <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="message"  id="message" rows="6" required placeholder="Describe your problem in at least 100 characters"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                    
                    <?= render_recaptcha_html('contact_form'); ?>

                    <button class="btn btn-primary mb-3" type="submit" >
                        <span class="spinner-border spinner-border-sm spinner d-none" role="status" aria-hidden="true"></span>
                        <?= __l("Submit"); ?>
                    </button>
                    <div class="ajax-alert-message mt-2"></div>
                </form>
            </div>
            <div class="col-12 col-lg-6 col-xl-6 d-flex  justify-content-center align-items-center <?= $image_position ?>">
                <img src="<?=sanitize_output( $section_fields['image_url'] ?? '') ; ?>" alt="<?=sanitize_output($section_fields['title'] ?? '') ; ?>" class="img-fluid rounded" style="max-height: 500px; width: auto;">
            </div>
        </div>

        <script>
            document.getElementById('category').addEventListener('change', function() {
                const selectedValue = this.value;

                document.getElementById('orderIdInput').classList.add('d-none');
                document.getElementById('paymentIdInput').classList.add('d-none');
                if (selectedValue === 'order_id') {
                    document.getElementById('orderIdInput').classList.remove('d-none');
                } else if (selectedValue === 'payment') {
                    document.getElementById('paymentIdInput').classList.remove('d-none');
                }
            });
        </script>
        <?php if (isset($section_fields['information_status']) && $section_fields['information_status']):?>
            <?php
                $contact_informations   = get_app_setting('contact_informations');
                $contact_informations = json_decode($contact_informations, true);
            ?>
            <div class="row mt-6">
                <div class="col-12 text-center">
                    <h3><?= __l("Contact_Information"); ?></h3>
                    <p><?= __l("Email"); ?>: <a href="mailto:<?= sanitize_output($contact_informations['email'] ?? '')?>"><?= sanitize_output($contact_informations['email'] ?? '')?></a></p>
                    <p><?= __l("Phone"); ?>: <a href="tel:<?= sanitize_output($contact_informations['phone'] ?? '')?>"><?= sanitize_output($contact_informations['phone'] ?? '')?></a></p>
                    <p><?= __l("address"); ?>: <?= sanitize_output($contact_informations['address'] ?? '')?></p>
                </div>
            </div>
        <?php endif;?>
    </div>
</section>