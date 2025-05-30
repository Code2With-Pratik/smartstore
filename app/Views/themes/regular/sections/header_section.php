<!-- header Top -->
<style>
    .header-top .img-background {
        background: url('<?=sanitize_output( $section_fields['background_image_url'] ?? '') ; ?>');
    }
</style>
<section class="header-top overflow-hidden py-5 position-relative header-section">
    <div class="position-absolute top-0 start-0 w-100 h-100 img-background"></div>
    <div class="container h-100 d-flex align-items-center">
        <div class="max-w-2xl mx-auto text-center">
            <h1 class="m-0 mt-7 text-4xl fw-bold" data-aos-delay="0" data-aos="fade" data-aos-duration="3000">
                <span class="text-primary"><?=sanitize_output($section_fields['left_span_text_in_title'] ?? '') ; ?></span> <?=sanitize_output($section_fields['title'] ?? '') ; ?>
            </h1>
            <p class="m-0 mt-4 text-lg leading-8" data-aos-delay="100" data-aos="fade" data-aos-duration="3000">
                <?=sanitize_output($section_fields['short_desc'] ?? '') ; ?>
            </p>
            <?php if (isset($section_fields['button_status']) && $section_fields['button_status']):?>
                <div class="mt-5">
                    <a href="<?=render_language_url(sanitize_output($section_fields['button_url'] ?? ''))?>" class="btn btn-primary btn-lg shadow text-white" data-aos-delay="200"
                        data-aos="fade" data-aos-duration="3000"><?=sanitize_output($section_fields['button_name'] ?? '') ; ?></a>
                </div>
            <?php endif;?>
        </div>
    </div>
</section>