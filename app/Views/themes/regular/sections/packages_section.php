<!-- package section -->

<?php
    $layout_type = ($section_fields['layout_type'] === 'tab') ? 'tab' : 'carousel';
    $features_status = $section_fields['features_status'] ?? 1;
    $title_status = $section_fields['title_status'] ?? 0;
?>

<section class="py-5 overflow-hidden package-list" data-aos-duration="1000" data-aos="fade-up">
    <div class="container">
        <?php if ($title_status):  ?>
        <div class="row g-4 justify-content-center">
            <div class="col-12 col-sm-10 col-md-10 col-lg-8 col-xl-6 text-center" data-aos="fade-up" data-aos-delay="200">
                <h2 class="btn btn-primary btn-sm text-white">
                    <?=sanitize_output($section_fields['title'] ?? '') ; ?>
                </h2>
                <div class="m-0 mt-2 text-3xl leading-snug tracking-tight fw-bold">
                    <?=sanitize_output($section_fields['short_desc'] ?? '') ; ?>
                </div>
            </div>
        </div>
        <?php endif;  ?>
        <?php
            $child_view = 'themes/regular/sections/child/package_section/' . $layout_type;
            echo view($child_view);
        ?>
        <?php if ($features_status && $display_on_page === 'home_page'):  ?>
        <div class="row mt-5 justify-content-center">
            <div class="col-12 col-md-6 col-lg-5  d-flex justify-content-center mb-3">
                <div class="px-3 bg-body-tertiary shadow rounded-4 py-3">
                    <div class="item text-center mb-2">
                        <h4 class="font-weight-bold"><?=sanitize_output($section_fields['features_title'] ?? '') ; ?></h4>
                        <div class="stars text-success">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                    </div>
                    <div class="item me-6">
                        <?php echo nl2br(sanitize_output($section_fields['features_content'] ?? ''));?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif;  ?>    
    </div>
</section>