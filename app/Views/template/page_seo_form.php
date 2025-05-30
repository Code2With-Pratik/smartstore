<?php
  $class_element = 'form-control';
  $page_seo = [];
  if ($item_lang) {
    $page_seo = json_decode($item_lang['page_seo'], true);
  }
  $index_arr = [
    'index'   => 'Index',
    'noindex' => 'No Index',
  ];
  $image_url_proper = ' <i class="fa fa-question-circle" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="The image for SEO purposes enhances the visual appeal of your page when shared on social media.<br><br>Please upload a high-quality image with:<br>- Minimum width of 1200px<br>- Minimum height of 630px<br>- Aspect ratio of 1.91:1 (ideal)<br><br>Use formats like JPEG or PNG for best results.<br><br>The image should be clear, visually engaging, and well-composed to maximize its impact across social media feeds, helping improve the visibility and engagement of your content." data-title="SEO Image Guidelines"></i>';
  $elements = [
    [
      'label' => form_label('SEO Title'),
      'element' => form_input(['name' => 'page_seo[title]', 'value' => sanitize_output($page_seo['title'] ?? ''), 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label' => form_label('SEO Keywords'),
      'element' => form_input(['name' => 'page_seo[keywords]', 'value' => sanitize_output($page_seo['keywords'] ?? ''), 'data-role' => 'tagsinput', 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label' => form_label('SEO description'),
      'element' => form_textarea(['name' => 'page_seo[description]', 'value' => sanitize_output($page_seo['description'] ?? ''), 'rows' => '3', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label' => form_label('SEO Image '. $image_url_proper) ,
      'element' => form_input(['name' => 'page_seo[image_url]', 'value' => sanitize_output($page_seo['image_url'] ?? ''), 'type' => 'text', 'class' => $class_element]),
      'type' => "upload-image-input",
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label' => form_label('Index'),
      'element' => form_dropdown( 'page_seo[index]', $index_arr, sanitize_output($page_seo['index'] ?? ''), ['class' => 'form-control']),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
  ];
?>

<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <div class="text-danger">NOTE:
        <small class="form-text text-muted">If you want to use the default information from the settings page, leave these fields empty.</small>
      </div>
    </div>
  </div>
  <?php echo render_elements_form($elements); ?>
</div>