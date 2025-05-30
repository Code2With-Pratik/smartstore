<!-- How It work -->
<section class="how-it-work bg-body py-5 overflow-hidden" data-aos="fade-up">
    <div class="container">
        <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="200">
            <div class="col-12 col-sm-8 col-lg-6">
                <header class="section-header">
                    <h2 class="btn btn-primary btn-sm text-white"><?=sanitize_output($section_fields['title'] ?? '') ; ?></h2>
                    <p class="m-0 mt-2 text-body-emphasis text-3xl leading-snug tracking-tight fw-bold"><?=sanitize_output($section_fields['short_desc'] ?? '') ; ?></p>
                </header>
            </div>
        </div>
        <div class="row justify-content-between p-5">
            <?php
                if (!empty($section_fields['features'])) :
                    $delay = 300;
                    $i = 1;
                    $number_steps = ($section_fields['number_steps'] == 3) ? 3 : 4;
                    $step_class = ($number_steps == 3) ? 'col-sm-4 col-md-4' : 'col-sm-3 col-md-3';
                    foreach ($section_fields['features'] as $key => $feature) :
                     if ($i > $number_steps) break;
                      
            ?>
                <div class="single_work_step col-12 <?=$step_class?>" data-aos="fade-up" data-aos-delay="<?=$delay?>">
                    <div class="">
                        <span class="arrow"><i class="bi bi-chevron-compact-right"></i></span>
                        <div class="step-icon"><i><?=$i?></i></div>
                        <h5><?=sanitize_output($feature['title'] ?? '')?></h5>
                        <p><?=sanitize_output($feature['content'] ?? '')?></p>
                    </div>
                </div>
                <?php $delay += 100; $i++; endforeach;?>            
            <?php endif;?>
        </div>
    </div>
</section>