<footer class="footer overflow-hidden py-5 bg-body-tertiary">
    <div class="container">
        <div class="row gy-5 g-sm-5">
            <div class="col-12 col-xl-4">
                <a href="<?= render_language_url() ?>"
                    class="mb-3 link-body-emphasis d-flex align-items-center text-decoration-none">
                    <img src="<?= get_app_setting('website_logo') ?>" height="40" alt="<?= get_app_setting('website_name') ?>" loading="lazy">
                </a>
                <p class="mt-4 mb-2 text-body-secondary leading-6 text-sm">
                    <?= __l("Modern_online_tool_to_increase_popularity_on_social_networks"); ?>
                </p>
                <?php
                    $social_links  = get_app_setting('social_links');
                    $social_links = json_decode($social_links, true);
                ?>
                <?php if ($social_links ) : ?>
                <div class="d-flex mt-2">
                    <?php foreach ($social_links as $key => $social_link): ?>
                        <a href="<?=sanitize_output($social_link['link'])?>" target="_blank" class="btn border bg-body-secondary-hover social me-2 p-2">
                            <span class="d-flex justify-content-center align-items-center">
                                <i class="<?= sanitize_output($social_link['icon']); ?>"></i>
                            </span>
                        </a>
                    <?php endforeach; ?>    
                </div>
                <?php endif; ?>
            </div>

            <div class="col-12 col-xl-8">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="">
                        <?php
                            $footer_links         = get_app_setting('footer_links');
                            $footer_links         = json_decode($footer_links, true);
                            $footer_links_by_lang = ($footer_links[current_locale()]) ?? [];
                        ?>
                        <?php if (!empty($footer_links_by_lang)) : ?>
                        <ul class="nav">
                            <?php foreach ($footer_links_by_lang as $key => $item_footer_link) :?>
                                <li class="nav-item">
                                    <a href="<?= render_language_url($item_footer_link['url_slug']) ?>" class="nav-link text-body-secondary"><?= sanitize_output($item_footer_link['title'] ?? '') ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php endif; ?>
                    </div>
                    <div class="d-flex mt-4">
                        <img src="<?= base_url() ?>/assets/themes/regular/img/home/trustpilot-stars.svg"
                            alt="Trustpilot Stars" height="40" class="ms-4 me-4">
                        <img src="<?= base_url() ?>/assets/themes/regular/img/home/norton.svg" alt="Norton Logo"
                            height="40" class="me-4">
                        <img src="<?= base_url() ?>/assets/themes/regular/img/home/trustedsite.svg" alt="Trustedsite"
                            height="40" class="me-2">
                    </div>
                </div>
            </div>
        </div>

        <hr class="mt-6 mb-0 text-body-emphasis opacity-10">

        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div class="order-last mt-5 text-body-secondary leading-6 text-sm">
                <?php echo get_app_setting('site_copy_right_content') ?>
            </div>
            <div class="order-first mt-5">
                <img src="<?= base_url()?>/assets/themes/regular/img/payments/paypal.svg" alt="Paypal Logo" height="30">
                <img src="<?= base_url()?>/assets/themes/regular/img/payments/visa.svg" alt="Visa Logo" height="30">
                <img src="<?= base_url()?>/assets/themes/regular/img/payments/mastercard.svg" alt="Mastercard Logo" height="30">
                <img src="<?= base_url()?>/assets/themes/regular/img/payments/american-express.svg" alt="American-express Logo" height="30">
                <img src="<?= base_url()?>/assets/themes/regular/img/payments/apple-pay.svg" alt="Apple pay Logo" height="30">
            </div>
        </div>
    </div>
</footer>

<!-- Back to top button -->
<button type="button"
		class="btn btn-primary btn-back-to-top rounded justify-content-center align-items-center p-2 text-white">
    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-up-short"
        viewBox="0 0 16 16">
        <path fill-rule="evenodd"
            d="M8 12a.5.5 0 0 0 .5-.5V5.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 5.707V11.5a.5.5 0 0 0 .5.5" />
    </svg>
</button>