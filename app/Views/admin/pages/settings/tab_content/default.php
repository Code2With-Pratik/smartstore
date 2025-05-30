<?php
  $form_config = config('AppConfig')->template['form'];
  $class_element                    = $form_config['class_element'];
  $label_required                   = $form_config['label_required'];

  $currency_code_arr                = currency_codes();

  $blog_limit_posts_per_page_arr  = generate_number_array(2, 20, 'post');
  $reviews_limit_per_page_arr     = generate_number_array(3, 18, 'review');
  $admin_max_items_per_page_arr   = generate_number_array(10, 100, 'item');

  $elements_blog = [
    [
      'label' => form_label('Max blog posts per page'),
      'element' => form_dropdown('blog_limit_posts_per_page', $blog_limit_posts_per_page_arr, get_app_setting('blog_limit_posts_per_page'), ['class' => 'form-control']),
      'class_main' => "col-md-6",
    ],
    [
      'label' => form_label('Max reviews per page'),
      'element' => form_dropdown('reviews_limit_per_page', $reviews_limit_per_page_arr, get_app_setting('reviews_limit_per_page'), ['class' => 'form-control']),
      'class_main' => "col-md-6",
    ],
    [
      'label' => form_label('Items per page limit (Admin dashboard)'),
      'element' => form_dropdown('admin_max_items_per_page', $admin_max_items_per_page_arr, get_app_setting('admin_max_items_per_page'), ['class' => 'form-control']),
      'class_main' => "col-md-6",
    ],
  ];
?>
<div class="row">
  <div class="col-12">
    <h6><i class="fa fa-angle-double-right"></i> Pagination</h6>
  </div>
  <?= render_elements_form($elements_blog);?>
</div>

