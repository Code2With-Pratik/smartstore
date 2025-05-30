<!-- image-with-text-section-->
<?php
    $image_position = ($section_fields['image_position'] === 'left') ? 'order-first' : '';
?>
<section class="py-5 overflow-hidden section-1 image-with-text-section" data-aos="fade-up">
    <div class="container py-5">
        <div class="row g-4 justify-content-between">
            <div class="col-12 col-sm-10 col-md-10 col-lg-6 col-xl-5 py-10" data-aos="fade-up" data-aos-delay="200">
                <div class="max-w-2xl px-3  bg-body-tertiary shadow rounded-3 py-3">
                    <h2 class="m-0 text-primary text-base leading-7 fw-semibold">
                        <?=sanitize_output($section_fields['title'] ?? '') ; ?>
                    </h2>
                    <div class="m-0 mt-2 text-body-emphasis text-4xl leading-snug tracking-tight fw-bold">
                        <?=sanitize_output($section_fields['headling'] ?? '') ; ?>
                    </div>
                    <p><?=sanitize_output($section_fields['short_desc'] ?? '') ; ?></p>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-6 d-flex justify-content-center  <?= $image_position ?>" data-aos="zoom-out"
                data-aos-delay="200">
                <img src="<?=sanitize_output( $section_fields['image_url'] ?? '') ; ?>"
                    alt="<?=sanitize_output( $section_fields['tile'] ?? '') ; ?>" class="img-fluid">
            </div>
        </div>
    </div>
</section>