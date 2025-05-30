<!--  why-choose-us -->
<section class="why-choose-us py-5 overflow-hidden">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row align-items-xl-center gy-5">
            <div class="col-xl-5 content">
                <h3 class="btn btn-primary text-white"><?=sanitize_output($section_fields['title'] ?? '') ; ?></h3>
                <h2><?=sanitize_output($section_fields['headling'] ?? '') ; ?></h2>
                <p><?=sanitize_output($section_fields['short_desc'] ?? '') ; ?></p>
            </div>
            <div class="col-xl-7">
                <div class="row gy-4 icon-boxes">
                    <?php
                        if (!empty($section_fields['features'])) :
                            $delay = 200;
                            foreach ($section_fields['features'] as $key => $feature) :
                    ?>
                    <div class="col-md-6 " data-aos="flip-up" data-aos-delay="<?=$delay?>">
                        <div class="icon-box bg-body-tertiary">
                            <i class="<?=sanitize_output($feature['icon'] ?? '')?>"></i>
                            <h3><?=sanitize_output($feature['title'] ?? '')?></h3>
                            <p><?=sanitize_output($feature['content'] ?? '')?></p>
                        </div>
                    </div>
                        <?php $delay += 200; endforeach;?>            
                    <?php endif;?>  

                </div>
            </div>
        </div>
    </div>
</section>