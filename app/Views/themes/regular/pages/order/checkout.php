

<style>
    /* Payment option container */
    .payment-options .form-check.item-payment .form-check-input {
        margin-left: 0px;
    }
    
    .payment-options .item-payment {
        border: #e3e5ee 3px solid;
        border-radius: 5px;
        padding: 10px;
        transition: border-color 0.3s, background-color 0.3s;
        cursor: pointer;
        
        
        height: 66px; 
        
        display: flex;
        align-items: center; 
        justify-content: flex-start; 
        
        /* Optional: prevent overflowing content */
        overflow: hidden;
    }

    .payment-options .item-payment .logo {
        max-width: 80px; 
        max-height: 70px; 
        object-fit: contain; 
    }

    .payment-options .payment-method {
        display: flex;
        align-items: center;
        justify-content: flex-start;
    }

    .payment-options .item-payment:hover {
        border-color: #e75b09;
    }

    .payment-options .item-payment.selected {
        border-color: #e75b09;
    }

    .payment-options .item-payment input:checked~label {
        font-weight: bold;
    }
</style>
<?php
    $session_cart = session_get($cart_name);
    $session_cart_item = $session_cart['item'];
    $total_price = 0;
?>

<section class="py-7 overflow-hidden order-form">
    <div class="py-14 d-flex justify-content-center d-none">
        <div class="text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
    <div class="form-replace-result">
        <form class="form sendForm" action="<?=client_url('checkout/payment-process')?>" method="POST" accept-charset="utf-8">
            <?= csrf_field(); ?>
            <div class="container py-7">
                <div class="row g-4 justify-content-center">
                    <div class="col-12 col-md-7">
                        <div class="card shadow-lg rounded-4  p-4 mb-3">
                            <h5 class="card-title text-center mb-2 bg-light text-dark p-2"><?= __l("Review_Your_Order"); ?></h5>
                            <div class="card-body">
                                <?php if (!empty($session_cart_item) && $item_db_service) : ?>
                                        <?php 
                                            $total_price = $item_db_service['price'];
                                        ?>
                                        <div class="cart-item">
                                            <p><strong><?=sanitize_output($item_db_service['name']);?></strong></p>
                                            <hr>
                                            <p><?= __l("Link"); ?>: <?=sanitize_output($session_cart_item['link'])?></p>
                                            <p><?= __l("Quantity"); ?>: <?=sanitize_output($item_db_service['quantity']);?></p>
                                            <p><?= __l("Sub_Total"); ?>: <?=format_price_with_currency($item_db_service['price']); ?></p>
                                        </div>
                                <?php endif; ?>       
                            </div>
                        </div>
    
                        <!-- Card Wrapper -->
                        <div class="card shadow-lg rounded-4  p-4">
                            <h5 class="card-title text-center mb-2 bg-light text-dark p-2"><?= __l("Bill_Information"); ?></h5>
                            <div class="card-body">
                                <!-- Your Name -->
                                <div class="mb-3">
                                    <label for="email" class="form-label d-flex align-items-center">
                                        <strong><?= __l("Email"); ?> <span class="text-danger ms-2">*</span></strong>
                                        <i class="bi bi-pencil-square ms-2 text-primary" id="editEmailBtn"
                                            style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="<?= __l("Switch_Email"); ?>"></i>
                                    </label>
                                    <input type="text" class="form-control" id="edit_email" placeholder="<?=$session_cart['email']?>" disabled>
                                    <input type="hidden" class="form-control" name="email" value="<?=$session_cart['email']?>"" id="hidden_email">
                                    <div class="invalid-feedback"></div>
                                </div>
    
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="subscribe_to_newsletter"
                                            value="1" checked>
                                        <label class="form-check-label d-flex align-items-center"><?= __l("Subscribe_to_our_newsletter"); ?></label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="link" class="form-label"><?= __l("First_name"); ?></label>
                                    <input type="text" class="form-control" name="first_name" placeholder="Jonh" >
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="link" class="form-label"><?= __l("Last_name"); ?></label>
                                    <input type="text" class="form-control" name="last_name" placeholder="Smith" >
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="link" class="form-label"><?= __l("Phone_Number"); ?></label>
                                    <div>
                                        <input type="hidden" name="country_code" id="country_code">
                                        <input type="hidden" name="dial_code" id="dial_code">
                                        <input type="hidden" name="full_phone" id="full_phone">
                                        <input type="text" class="form-control" name="phone" id="phone-validate">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <small id="error-phone-msg" class="text-danger d-none"><?= __l("Invalid_number"); ?></small>
                                </div>
    
                            </div>
                        </div>
                    </div>
    
                    <div class="col-12 col-md-5">
                        <!-- Card Wrapper -->
                        <div class="card shadow-lg rounded-4 p-4">
                            <h5 class="card-title text-center mb-2 bg-light text-dark p-2"><?= __l("Payment_Options"); ?></h5>
                            <!-- Payment Method Fieldset -->
                            <fieldset class="mb-3 payment-options">
                                <legend class="col-form-label"><?= __l("Payment_Method"); ?></legend>
                                <?php if (!empty($items_payments)) : $i = 0; ?>
                                    <?php foreach ($items_payments as $key => $item_payment): ++$i; ?>
                                        <div class="form-check item-payment mb-2 <?=($i == 1)? 'selected' : ''?>">
                                            <input class="form-check-input" type="radio" name="payment_method" value="<?=sanitize_output($item_payment['type']); ?>"
                                                id="paymentPaypal" <?=($i == 1) ? 'checked' : ''?>>
                                            <label class="form-check-label d-flex align-items-center" for="paymentPaypal">
                                                <img src="<?=base_url('assets/images/payments/'. $item_payment['type'] . '.png')?>"
                                                    alt="<?=sanitize_output($item_payment['name']); ?> Logo"  class="logo mx-2 w-50">
                                                <?=sanitize_output($item_payment['name']); ?>
                                            </label>
                                        </div>
                                    <?php endforeach;?>
                                <?php else : ?>     
    
                                <!-- No payment method available -->
                                <div class="form-check item-option mb-2">
                                    <input class="form-check-input" type="radio" name="payment_method_ids" value="null" id="paymentNone" disabled>
                                    <label class="form-check-label d-flex align-items-center" for="paymentNone">
                                        <?= __l("No_payment_method_available"); ?>
                                    </label>
                                </div>
                                <?php endif; ?>     
                               
                            </fieldset>
                            
                            <?php
                                $btn_apply_coupon_option = [
                                    'spinner_selector' => '.btn-coupon-spinner',
                                    'message_container' => '.ajax-apply-counpon-alert-message'
                                ];
                            ?>
    
                            <style> 
                                .custom-input { width: 60%; } 
                                .custom-button { width: 40%;} 
                            </style>
    
                            <!-- Coupon Form -->
                            <div class="coupon-form mt-3 mb-2">
                                <div class="d-flex align-items-center">
                                    <input type="text" class="form-control me-2 custom-input" name="coupon_code" id="couponCode"
                                        placeholder="<?= __l("Coupon_Code"); ?>">
                                    <div class="invalid-feedback"></div>
                                    <button type="button" class="btn btn-success btnApplyCoupon custom-button" data-options='<?php echo json_encode($btn_apply_coupon_option)?>'>
                                        <span class="spinner-border btn-coupon-spinner spinner-border-sm d-none" role="status" aria-hidden="true"></span> <?= __l("Apply"); ?>
                                    </button>
                                </div>
                                <div class="mt-2">
                                    <div class="ajax-apply-counpon-alert-message"></div>
                                </div>
                            </div>
                            <hr>
                            <div class="total-price-detail mt-3 mb-3">
                                <div class="d-flex justify-content-between">
                                    <h4><?= __l("Total"); ?>:</h4>
                                    <h3><?=format_price_with_currency($total_price); ?></h3>
                                </div>
                            </div>
                            <hr>

                            <?= render_recaptcha_html('checkout_form'); ?>
                            <!-- Confirm Button -->
                            <button type="submit" class="btn btn-outline-primary btn-lg w-100">
                                <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> <?= __l("Complete_payment"); ?>
                            </button>
                            <div class="mt-2">
                                <div class="ajax-alert-message"></div>
                            </div>
                            <script src="https://js.stripe.com/v3"></script>
    
                            <div class="response-html"></div>    
                            <div class="mt-3">
                                <label class="note-label"><strong><?= __l("Note"); ?></strong></label>
                                <!-- Notes List -->
                                <ol class="note-list mt-2 list-unstyled">
                                    <li class="text-muted small mb-2"><?= __l("Your_payment_information_is_secure_and_encrypted"); ?></li>
                                    <li class="text-muted small mb-2"><?= __l("Delivery_of_your_order_will_start_automatically_after_successful_payment_An_order_confirmation_email_will_be_sent_with_order_number_and_details"); ?></li>
                                </ol>
                            </div>
    
                            <!-- Secure Logos -->
                            <div class="form-group text-center mt-4">
                                <div>
                                    <img src="<?=base_url()?>assets/images/payments/secure-logo.png" alt="Secure Logo"
                                        class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
    // Get the email input, hidden email field, and edit button (icon)
    const emailInput = document.getElementById("edit_email");
    const hiddenEmailInput = document.getElementById("hidden_email");
    const editEmailBtn = document.getElementById("editEmailBtn");

    editEmailBtn.addEventListener("click", function () {
        if (emailInput.disabled) {
            emailInput.disabled = false;  
            emailInput.focus();  
            editEmailBtn.classList.replace("bi-pencil-square", "bi-save");  
        } else {
            emailInput.disabled = true;  // Disable editing
            editEmailBtn.classList.replace("bi-save", "bi-pencil-square");  

            hiddenEmailInput.value = emailInput.value;
        }
    });

    emailInput.addEventListener("input", function () {
        if (!emailInput.disabled) {
            hiddenEmailInput.value = emailInput.value;
        }
    });
</script>

<script>
    const radios = document.querySelectorAll('input[name="payment_method"]');
    const items = document.querySelectorAll('.item-payment');
    items.forEach(item => {
        item.addEventListener('click', function () {
            const radio = item.querySelector('input[type="radio"]'); // Find the radio button inside the clicked item
            
            if (!radio.checked) {
                radio.checked = true;
                // Trigger the change event for the radio button to run the existing code
                radio.dispatchEvent(new Event('change'));
            }
        });
    });

    // Handle radio button change event
    radios.forEach(radio => {
        radio.addEventListener('change', function () {
            document.querySelectorAll('.item-payment').forEach(option => {
                option.classList.remove('selected');
            });
            const selectedOption = radio.closest('.item-payment');
            if (selectedOption) {
                selectedOption.classList.add('selected');
            }
        });
    });
</script>
