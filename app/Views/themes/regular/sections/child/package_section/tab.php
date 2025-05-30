
<?php
    $display_on_page = (isset($display_on_page) && $display_on_page === 'category_page') ? 'category_page' : 'home_page';
?>
<!-- home page -->
<?php if ($items_social_network_with_category && $display_on_page == 'home_page'): ?>
    <div class="row justify-content-center package-list-tab mb-5">
        <div class="col-12 d-flex justify-content-center mb-3">
        <?php foreach ($items_social_network_with_category as $key => $item_social_network): ?>
            <?php
                $toggle_id = $item_social_network['ids'] ?? ids();
            ?>
            <div class="tab tab-item <?= $key === 0 ? 'active' : '' ?>" data-bs-toggle="tab" data-bs-target="#target_<?= $toggle_id; ?>">
            <div class="img-logo">
                <img class="img-fluid" src="<?=$item_social_network['image']?>" alt="<?= sanitize_output($item_social_network['name']?? ''); ?>">
            </div>
            </div>
        <?php endforeach; ?>   
        </div>
        <div class="col-12 col-md-6 col-lg-5 tab-content">
        <?php foreach ($items_social_network_with_category as $key => $item_social_network): ?> 
			<?php $toggle_id = $item_social_network['ids'] ?? ids(); ?> 
            <div class="tab-pane tab-item fade <?= $key === 0 ? 'show active' : '' ?> max-w-2xl px-3 bg-primary-opacity shadow rounded-4 py-3" id="target_<?= $toggle_id; ?>" role="tabpanel">
                <div class="package-btn-list">
                    <div class="d-grid gap-2">
						<?php if (isset($item_social_network['categories']) && !empty($item_social_network['categories'])): ?>
							<?php foreach ($item_social_network['categories'] as $item_category): ?>
								<?php if (empty($item_category['url_slug']) && empty($item_category['name'])) continue; ?>
								<a href="<?= render_language_url(sanitize_output($item_category['url_slug'] ?? '')) ?>" class="d-flex justify-content-between btn btn-light btn-md bg-white py-2 rounded-4 buy-package-item">
									<span>
									<i class="<?= sanitize_output($item_category['icon_class'] ?? 'bi bi-person') ?> me-2 icon-square"></i><?= sanitize_output($item_category['name']) ?>
									</span>
									<i class="bi bi-chevron-right icon-right"></i>
								</a>
							<?php endforeach; ?>
						<?php else: ?>
							<span class="text-muted">No categories available</span>
						<?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?> 
        </div>
    </div>
<?php endif; ?>


<!-- category Page -->

<?php if ($items_service_by_category && $display_on_page == 'category_page'): ?>
    <style>
		.package-category-tab .btn-package-group .btn-item {
			background: #f3f3f3 !important;
		}
		
		[data-bs-theme=dark] .package-category-tab .btn-package-group .btn-item {
			background: #3d210a !important;
		}

		.package-category-tab .btn-package-group .btn-item.active {
			background: #fd7702 !important;
			color: #fff;
		}

		.package-category-tab .btn-package-group .btn-item:hover {
			border: 1px solid #fd7702 !important;
		}
	</style>

	<section class="package-category-tab py-3">
		<div class="container mt-3">
			<div class="row justify-content-center">
				<div class="col-12 col-md-6 col-lg-5">
					<div class="card border-0 shadow rounded-4">
						<div class="card-body">
							<!-- Nav tabs -->
							<div class="d-flex mt-4 justify-content-center flex-wrap btn-package-group">
								<?php foreach ($items_service_by_category as $key => $item_service): ?>
									<div data-bs-toggle="tab" data-bs-target="#target-tab-<?= $item_service['ids']; ?>"
										class="tab tab-item btn btn-item me-3 mb-2 <?= $key === 0 ? 'active' : '' ?>">
										<div>
											<strong><?= sanitize_output($item_service['quantity'])?></strong><br>
											<small> <?= sanitize_output($item_page['unit_name']) ?></small>
										</div>
									</div>
								<?php endforeach; ?>  

							</div>

							<!-- Tab panes -->
							<div class="tab-content mt-3 text-center">

								<?php foreach ($items_service_by_category as $key => $item_service): ?>
									<?php
										$order_link = client_get_order_link($item_service);
									?>	
									<div id="target-tab-<?= sanitize_output($item_service['ids']); ?>" class="tab-pane fade <?= $key === 0 ? 'show active' : '' ?>"">
										<div class="mt-3 p-3">
											<p>
												<span class="text-3xl fw-bold me-2"><?=format_price_with_currency($item_service['price'])?></span>
												<?php if ($item_service['discount_value'] > 0) :?>
													<del>
														<?=format_price_with_currency($item_service['original_price'] - $item_service['price'])?>
													</del>
												<?php endif; ?>
											</p>
											<a href="<?= $order_link; ?>" class="btn btn-primary text-white btn-lg mb-3"><?= __l("Order_now"); ?></a>
											<?php if ($item_service['discount_value'] > 0) :?>
												<p class="mt-2">
													<i class="bi bi-check-circle"></i> <?= __l("Save"); ?>
													<span class="text-success"><?=(double)$item_service['discount_value'];?>%</span>
												</p>
											<?php endif; ?>
										</div>
									</div>
								<?php endforeach; ?>  	
								
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php if (isset($section_fields['features_status']) && $section_fields['features_status'] ) :  ?>						
				<div class="row justify-content-center mt-3">
					<div class="col-12 col-md-6 col-lg-5 justify-content-center mb-3">
						<div class="px-4 shadow rounded-4 py-3">
							<div class="item text-center mb-2">
								<h4 class="font-weight-bold"><?=sanitize_output($section_fields['features_title'] ?? '') ; ?></h4>
								<div class="stars text-success mb-2">
									<i class="bi bi-star-fill"></i>
									<i class="bi bi-star-fill"></i>
									<i class="bi bi-star-fill"></i>
									<i class="bi bi-star-fill"></i>
									<i class="bi bi-star-fill"></i>
								</div>
							</div>
                            <div class="mb-2"> <?php echo nl2br(sanitize_output($section_fields['features_content'] ?? ''));?> </div>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</section>
	<script>
		const tabs = document.querySelectorAll('.tab');
		const tabPanes = document.querySelectorAll('.tab-pane');

		tabs.forEach(tab => {
			tab.addEventListener('click', function () {
				tabs.forEach(t => t.classList.remove('active'));
				tabPanes.forEach(pane => pane.classList.remove('show', 'active'));

				tab.classList.add('active');
				const target = tab.getAttribute('data-bs-target');
				document.querySelector(target).classList.add('show', 'active');
			});
		});
	</script>
<?php endif; ?>