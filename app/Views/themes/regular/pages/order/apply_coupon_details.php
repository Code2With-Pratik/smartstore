
<div class="total-price-detail mt-2 mb-3">
    <?php if ($sub_total && $coupon_amount && $discount_percentage): ?>
    <div class="text-center text-success mb-2">
        <?= __l("Awesome_Youve_just_saved_with_this_promo_code"); ?>
    </div>
    <div class="d-flex justify-content-between">
        <span><?= __l("Subtotal"); ?>:</span>
        <span><?=format_price_with_currency($sub_total) ?></span>
    </div>
    <div class="d-flex justify-content-between mt-1">
        <span><?= __l("Coupon_amount"); ?>:</span>
        <del class="text-success"><?=format_price_with_currency($coupon_amount) ?></del>
    </div>
    <hr>
    <?php endif; ?>
    <div class="d-flex justify-content-between">
        <h4><?= __l("Total"); ?>:</h4>
        <h3><?=format_price_with_currency($new_total_charge) ?></h3>
    </div>
</div>