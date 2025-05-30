<!-- What We Offer! -->
<?php
    $image_position = (isset($section_fields['image_position'] ) && $section_fields['image_position'] === 'left') ? 'order-first' : '';
?>
<section class="what-we-offer group-features py-5 overflow-hidden">
    <div class="container" data-aos="fade-up">
        <div class="row">
            <div class="col-lg-12 section-header">
                <div class="above-heading" data-aos="fade-up" data-aos-delay="200"><?=sanitize_output($section_fields['title'] ?? '') ; ?></div>
                <h2 class="h2-heading text-white" data-aos="fade-up" data-aos-delay="400"><?=sanitize_output($section_fields['headling'] ?? '') ; ?></h2>
                <p class="text-white"><?=sanitize_output($section_fields['short_desc'] ?? '') ; ?></p>
            </div>
        </div>
        <div class="row feature-icons " data-aos="fade-up">
            <div class="row">
                <div class="col-xl-8 d-flex content">
                    <div class="row align-self-center gy-4">
                        <?php
                            if (!empty($section_fields['features'])) :
                                $delay = 100;
                                foreach ($section_fields['features'] as $key => $feature) :
                        ?>
                        <div class="col-md-6 icon-box " data-aos="fade-up" data-aos-delay="<?=$delay?>">
                            <div class="icon text-white">
                                <i class="<?=sanitize_output($feature['icon'] ?? '')?>"></i>
                            </div>
                            <div class="text-white">
                                <h4><?=sanitize_output($feature['title'] ?? '')?></h4>
                                <p><?=sanitize_output($feature['content'] ?? '')?></p>
                            </div>
                        </div>            
                       
                            <?php $delay += 100; endforeach;?>            
                        <?php endif;?>  
                    </div>
                </div>

                <div class="col-xl-4 text-center <?= $image_position ?>" data-aos="fade-right" data-aos-delay="100">
                    <img src="<?=sanitize_output( $section_fields['image_url'] ?? '') ; ?>" class="img-fluid p-4" alt="<?=sanitize_output( $section_fields['title'] ?? '') ; ?>">
                </div>
            </div>
        </div>
    </div>
</section>