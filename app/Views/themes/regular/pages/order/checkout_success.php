
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
            <i class="bi bi-check2-circle text-success checkout-icon-status" ></i>
            <h3 class="text-4xl mt-2 fw-bold aos-init aos-animate">
                <span class=""><?= __l("Thank_You_for_Your_Order"); ?></span> 
            </h3>
            <p class="m-0 mt-2 text-lg leading-8 aos-init aos-animate"><?= __l("We_appreciate_your_most_recent_purchase_and_hope_you_enjoyed_your_purchase_An_email_receipt_including_the_details_about_your_order_has_been_sent_to_your_email_address"); ?></p>
        </div>
    </div>
</section>
<section class="mb-10">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-10">
                <div class="card shadow-sm my-4">
                    <div class="card-body">
                        <h5 class="card-title"><?= __l("Order_Details"); ?></h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th><?= __l("Order_ID"); ?></th>
                                        <td class="order_id">
                                            <strong class="text-info" id="clipboard-content"><?=sanitize_output($item_order['client_order_id']);?></strong>
                                            <button class="btn btn-outline-dark btn-sm ms-2 copy-to-clipboard-btn"><?= __l("Copy_to_Clipboard"); ?></button>
                                            <button class="copy-feedback btn btn-dark btn-sm ms-2 d-none"><?= __l("Copied"); ?></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?= __l("Transaction_ID"); ?></th>
                                        <td><?=sanitize_output($item_transaction['transaction_id']);?></td>
                                    </tr>
                                    <tr>
                                        <th><?= __l("Total_Charge_including_tax"); ?></th>
                                        <td><?=format_price_with_currency($item_transaction['amount']); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-end">
                            <a href="<?=client_url('track-order?order_id=' . sanitize_output($item_order['client_order_id']) );?>" class="btn btn-primary btn-sm"><?= __l("Track_Your_Order"); ?></a>
                            <a href="<?=client_url();?>" class="btn btn-outline-primary btn-sm"><?= __l("Back_to_home"); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function () {
        $('.copy-to-clipboard-btn').on('click', function () {
            var button = $(this); 
            var orderId = $('#clipboard-content').text(); 
            var feedback = button.siblings('.copy-feedback'); 

            var tempInput = $('<textarea>');
            tempInput.val(orderId).appendTo('body').select();
            document.execCommand('copy');
            tempInput.remove();

            button.addClass('d-none'); 
            feedback.removeClass('d-none'); 
            setTimeout(function () {
                feedback.addClass('d-none'); 
                button.removeClass('d-none'); 
            }, 3000);
        });
    });
</script>