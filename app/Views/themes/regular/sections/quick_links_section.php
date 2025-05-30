<section class="py-5 mb-3 quick-link">
    <div class="container">
        <div class="card rounded-4 shadow bg-gradient-dark text-white">
            <div class="card-body p-4 p-md-4 p-lg-5">
                <div class="row">
                    <div class="col-md-12 col-lg-8 mx-auto text-center">
                        <h3><?=sanitize_output($section_fields['title'] ?? '') ; ?></h3>
                        <div class="row mt-3">
                            <div class="col-12 d-flex flex-wrap justify-content-center">
                                <?php
                                    if (!empty($section_fields['features'])) :
                                        foreach ($section_fields['features'] as $key => $feature) :
                                ?>
                                    <a href="<?=render_language_url(sanitize_output($feature['content'] ?? ''))?>" class="btn btn-outline-light mb-2 me-2">
                                        <?=sanitize_output($feature['title'] ?? '')?>
                                    </a>
                                    <?php endforeach;?>            
                                <?php endif;?>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>   
