<style>
    .header-top .img-background {
        background: url('assets/themes/regular/img/home/header-top-bg.png');
        background-size: cover;
    }
    .header-top .checkout-icon-status {
        font-size: 90px;
    }
    .card-title {
        font-size: 1.25rem;
        font-weight: bold;
    }
</style>

<section class="header-top overflow-hidden pt-7 pt-md-5 pt-xl-10 mb-5 position-relative">
    <div class="position-absolute top-0 start-0 w-100 h-100 img-background"></div>
    <div class="container h-100 d-flex align-items-center">
        <div class="max-w-2xl mx-auto text-center">
            <h3 class="text-4xl mt-2 fw-bold aos-init aos-animate">
                <span class=""><?= __l("Track_Order"); ?></span>
            </h3>
            <p class="m-0 mt-2 text-lg leading-8 aos-init aos-animate">
                <?= __l("Enter_your_tracking_number_to_see_the_status_of_your_order_You_can_find_the_tracking_number_in_the_email_confirmation_we_sent_to_your_inbox"); ?>
            </p>
        </div>
    </div>
</section>

<section class="mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6">
                <!-- Track Order Form -->
                <div class="card border-none shadow-sm my-4">
                    <div class="card-body">
                        <form action="#" method="POST" class="sendForm">
                            <?= csrf_field(); ?>
                            <div class="mb-3 text-start">
                                <label for="orderId" class="form-label"><?= __l("Order_ID"); ?></label>
                                <input type="text" class="form-control" id="orderId" name="order_id" value="<?=(get('order_id') ?? '')?>">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3 text-start">
                                <label for="email" class="form-label"><?= __l("Email"); ?></label>
                                <input type="email" class="form-control" id="email" name="email" value="<?=(get('email') ?? '')?>">
                                <div class="invalid-feedback"></div>
                            </div>
                            
                            <?= render_recaptcha_html('track_order_form'); ?>

                            <button type="submit" class="btn btn-outline-primary">
                                <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> <?= __l("Submit"); ?>
                            </button>
                            <div class="mt-2">
                                <div class="ajax-alert-message"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mb-5 d-none" id="track-order-details" >
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
<script>
    $(document).ready(function () {
        $(document).on('click', '#exportPdfBtn', function () {
            var elementHTML = $('#orderDetailsCard')[0];  
            var $exportBtn = $('#exportPdfBtn');
            $exportBtn.addClass('d-none');
            var options = {
                margin: [20, 10],
                filename: 'order-details.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };
            html2pdf().from(elementHTML).set(options).save().then(function() {
                $exportBtn.removeClass('d-none');
            }).catch(function(error) {
                $exportBtn.removeClass('d-none');
                console.error("Error exporting PDF:", error);
            });
        });
    });
</script>