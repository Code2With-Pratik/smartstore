
<?php
    $option_content = ($section_fields['content'] ?? '');
    $option_content = str_replace('<p></p>', '<br>', $option_content);
    $option_content = str_replace('<p><span></span></p>', '<br>', $option_content);
?>
<!-- Option Content -->
<section class="more-content py-6 overflow-hidden" data-aos="fade-up">
    <div class="container">
        <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="200">
            <div class="col-12 col-sm-12 col-lg-12">
                <?= sanitize_output($option_content) ;?>
            </div>
        </div>
    </div>
</section>