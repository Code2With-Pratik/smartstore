<!-- Counter -->
<style>
    .counter-section .feature-item:first-child .icon {
        color: #10b981;
    }
    .counter-section .feature-item:last-child .icon {
        color: #f43f5e;
    }
</style>

<section class="py-5 counts-area counter-section">
    <div class="container" data-aos="fade-up">
        <div class="row gy-4">
            <?php
                if (!empty($section_fields['features'])) :
                    foreach ($section_fields['features'] as $key => $feature) :
            ?>
            <div class="col-lg-4 col-md-6 feature-item">
                <div class="count-box bg-body-tertiary shadow">
                    <i class="<?=sanitize_output($feature['icon'] ?? '')?> icon"></i>
                    <div>
                        <span class="purecounter odometer" data-count-to="<?=sanitize_output($feature['number'] ?? '2324243')?>"></span>
                        <p><?=sanitize_output($feature['title'] ?? '')?></p>
                    </div>
                </div>
            </div>
                <?php endforeach;?>            
            <?php endif;?>            
            
        </div>
    </div>
</section>
