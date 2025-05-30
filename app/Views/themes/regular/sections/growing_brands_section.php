<!-- Get Start -->
<section class="growing-brands-section py-5">
    <div class="container">
        <div class="my-5 position-relative rounded-2 shadow bg-body-tertiary">
            <span class="badge position-absolute translate-middle-y top-0 start-0 text-bg-success text-white px-3 py-2 rounded-3 ms-5"><?=sanitize_output($section_fields['title'] ?? '') ; ?></span>
            <div class="px-4 pb-5 d-flex flex-wrap justify-content-between">
                <h4 class="mt-5">
                    <?=sanitize_output($section_fields['short_desc'] ?? '') ; ?>
                </h4>
                <div class="mt-5">
                    <a  href="<?=client_url(sanitize_output($section_fields['button_url'] ?? ''))?>" class="btn btn-primary text-white px-5">
                        <?=sanitize_output($section_fields['button_name'] ?? '') ; ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
