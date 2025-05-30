<style>

    .header-top .img-background {
        background: url(assets/themes/regular/img/home/header-top-bg.png);
    }

    .header-top .checkout-icon-status {
        font-size: 90px;
    }   
    
</style>

<section class="header-top overflow-hidden pt-7 pt-md-5 pt-xl-10 mb-5 position-relative">
    <div class="position-absolute top-0 start-0 w-100 h-100 img-background"></div>
    <div class="container h-100 d-flex align-items-center">
        <div class="max-w-2xl mx-auto text-center">
            <i class="bi bi-x-circle text-danger checkout-icon-status"></i>
            <h3 class="text-4xl mt-2 fw-bold aos-init aos-animate">
                <span class=""><?= __l("Payment_Failed"); ?></span>
            </h3>
            <p class="m-0 mt-2 text-lg leading-8 aos-init aos-animate">
                <?= __l("Were_sorry_but_we_couldnt_process_your_payment_Please_check_your_payment_details_and_try_again"); ?>
            </p>
        </div>
    </div>
</section>

<section class="mb-10">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card shadow-sm my-4">
                    <div class="card-body">
                        <h5 class="card-title"><?= __l("What_Would_You_Like_to_Do_Next"); ?></h5>
                        <div class="text-center">
                            <a href="<?=client_url('contact-us');?>" class="btn btn-primary my-2"><?= __l("Contact_Us"); ?></a>
                            <a href="<?=client_url();?>" class="btn btn-outline-primary my-2"><?= __l("Back_to_home"); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
