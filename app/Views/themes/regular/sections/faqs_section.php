<!-- FAQs -->

<?php
    $layout_type = ($section_fields['layout_type'] == 'center') ? 'center' : 'left';
    if ($layout_type == 'center') {
        $title_class = 'col-12 col-md-8 col-xl-8 text-center';
        $faq_content_class = 'col-12 col-md-8 col-xl-8';
        $container_class = 'justify-content-center';
    } else {
        $title_class = 'col-12 col-sm-10 col-md-6 col-lg-6 col-xl-5 py-8';
        $faq_content_class = 'col-12 col-md-6 col-lg-6';
        $container_class = 'justify-content-between';
    }
?>


<section class="py-5 overflow-hidden faq" itemscope itemtype="https://schema.org/FAQPage">
    <div class="container py-5">
        <div class="row g-4 <?php echo $container_class; ?>">
            <div class="<?php echo $title_class; ?>">
                <div class=""> 
                    <h2 class="btn btn-primary btn-sm text-white" itemprop="name">
                        <?=sanitize_output($section_fields['title'] ?? '') ; ?>
                    </h2>
                    <div class="m-0 mt-2 text-body-emphasis text-4xl leading-snug tracking-tight fw-bold">
                        <?=sanitize_output($section_fields['short_desc'] ?? '') ; ?>
                    </div>
                </div>
            </div>

            <?php if (!empty($section_fields['features'])) :  $i = 0; ?>
                <div class="<?php echo $faq_content_class; ?>">
                    <div class="accordion" id="accordionFlushExample">

                        <?php foreach ($section_fields['features'] as $key => $feature)  : $i++?>
                            <?php if ($i > 1) echo '<hr class="opacity-10">'; 
                                $collapse_id = 'flush-collapse-' . ids();
                            ?>
                            <!-- FAQ Item 1 -->
                            <div class="accordion-item border-0" itemscope itemprop="mainEntity"
                                itemtype="https://schema.org/Question">
                                <h2 class="accordion-header" id="flush-headingOne">
                                    <button class="accordion-button h2 shadow-none <?= ($i <= 2 ) ? '' : 'collapsed'?>" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#<?= $collapse_id;?>" aria-expanded="true"
                                        aria-controls="<?= $collapse_id;?>">
                                        <span itemprop="name"><?= sanitize_output($feature['title']); ?></span>
                                    </button>
                                </h2>
                                <div id="<?= $collapse_id;?>" class="accordion-collapse collapse  <?= ($i <= 2 ) ? 'show' : ''?>"
                                    aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body text-body-secondary lh-lg" itemprop="acceptedAnswer"
                                        itemscope itemtype="https://schema.org/Answer">
                                        <span itemprop="text"><?= sanitize_output($feature['content']); ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>