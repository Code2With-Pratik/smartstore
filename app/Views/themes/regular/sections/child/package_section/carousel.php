<!-- home_page -->
<?php

use PhpParser\Node\Expr\Cast\Double;

 if ($items_social_network_with_category && $display_on_page == 'home_page' ): ?>
  <div class="row package-list-carousel ">
    <div class="col-md-12  owl-carousel">
      <?php foreach ($items_social_network_with_category as $key => $item_socical_network): ?>
        <div class="social-item py-3">
          <div class="p-4">
            <div class="img-logo">
              <img class="" src="<?= $item_socical_network['image']; ?>" alt="<?= sanitize_output($item_socical_network['name'] ?? ''); ?>">
            </div>
            <div class="package-btn-list">
              <div class="d-grid gap-2">
                <?php foreach ($item_socical_network['categories'] as $key => $item_category): ?>
                <a href="<?= render_language_url(sanitize_output($item_category['url_slug'] ?? '')) ?>" class="d-flex justify-content-between btn btn-light btn-md bg-white rounded-4 buy-package-item" type="button">
                  <span class=""><i class="<?= sanitize_output($item_category['icon_class'] ?? 'bi bi-person') ?> me-2 icon-square"></i><?=sanitize_output($item_category['name'] ?? '')?></span>
                  <i class="bi bi-chevron-right icon-right"></i>
                </a>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>  
    </div>
  </div>
  <!-- owl-carousel -->
  <script type="text/javascript">
    $(document).ready(function () {
        initialize_owl_carousel('.owl-carousel', 1, 2, 3);
    });
  </script>

<?php endif; ?>

<!-- category_page -->
<?php if ($items_service_by_category && $display_on_page == 'category_page' ): ?>
  <style>
    .package-category-carousel .box-item .text-title {
      top: -24px;
      left: 31%;
    }
    .package-category-carousel .box-item .card {
      transition: transform 0.3s ease, border 0.3s ease;
      border: 2px solid transparent;
    }
    .package-category-carousel .box-item .card:hover {
      border: 2px solid #df5403;
      transform: translateY(-5px);
    }
  </style>
  <section class="package-category-carousel container py-3">
    <div class="row">
      <div class="col-md-12 owl-carousel">
        <?php foreach ($items_service_by_category as $key => $item_service): ?>
          <?php
            $order_link = client_get_order_link($item_service);
          ?>
          <div class="mt-6 box-item py-3  pe-2 ms-2">
            <div class="card text-center shadow position-relative bg-body-tertiary rounded-4">
              <?php
                $current_tab_name = get_value_by_key($item_service['tab_name'], 'en');
                if ($item_service['is_tab_name'] && !empty($current_tab_name)) :
                  $bg_colors = array_keys(config('AppConfig')->template['background_colors']);  
                  $tab_name_bg_color = in_array($item_service['tab_name_background'], $bg_colors) ? $item_service['tab_name_background'] : 'danger';
                  $class_bg_color = 'bg-' . $tab_name_bg_color;
              ?>
              <div class="position-absolute text-title text-center">
                <div class="<?=esc($class_bg_color)?> bg-gradient text-white p-2 rounded-3"><?= sanitize_output($current_tab_name)?></div>
              </div>
              <?php endif; ?>
              <div class="card-body mt-4">
                <h5 class="card-title text-2xl">
                  <span class="text-primary"><?= sanitize_output($item_service['quantity'])?></span> 
                  <br> <?= sanitize_output($item_page['unit_name']) ?>
                </h5>
                <style>
                  .item-price {
                    min-height: 58px; 
                  }
                </style>
                <div class="d-flex flex-column align-items-start text-center mt-4 mb-2 item-price">
                  <div class="d-flex justify-content-between align-items-center w-100">
                    <p class="card-text display-5 text-4xl fw-bold me-2 ps-2"><?=format_price_with_currency($item_service['price'])?></p>
                    <?php if ($item_service['discount_value'] > 0) :?>
                      <p class="small pe-2">
                        <span class="text-info">Save <?=(double)$item_service['discount_value'];?>%</span>
                        <br>
                        <del><?=format_price_with_currency($item_service['original_price'] - $item_service['price'])?></del>
                      </p>
                    <?php endif; ?>
                  </div>
                </div>
                <a href="<?= $order_link; ?>" class="btn btn-outline-primary btn-lg rounded-3 mt-4"><?= __l("Order_now"); ?></a>
              </div>
              <?php if (!empty($section_fields['features_content'])) :  $i = 0; ?>
                <div class="text-start mt-3 mb-2 small">
                  <div class="">
                    <?php 
                      $category_features = explode("\r\n", $section_fields['features_content']);
                    ?>
                    <?php foreach ($category_features as $key => $feature)  : $i++?>
                      <div class="border-top py-2 ps-4"> <?= sanitize_output($feature)?></div>
                    <?php endforeach; ?>
                  </div>
                </div>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>  	
      </div>
    </div>
  </section>
  <!-- owl-carousel -->
  <script type="text/javascript">
    $(document).ready(function () {
      initialize_owl_carousel('.owl-carousel', 1, 2, 4);
    });
  </script>
<?php endif; ?>
