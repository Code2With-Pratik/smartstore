
<?php if (!empty($items_post)) : ?>
	<section class="blog-list py-5">
		<div class="container">
			<div class="row">
				<div class="col-lg-9">
					<div class="row gy-4" id="posts-content">
						<?= $posts_content ?? null; ?>
					</div>

					<?php if ($has_more_items) : ?>
						<?php
							$btn_load_more_options = [
								'spinner_selector'          => '.btnLoadMore .spinner',
								'method'                    => 'GET',
							];
							$load_more_slug = 'load-more-blog-post';
							if (isset($post_category_slug)) {
								$load_more_slug .= '/' . $post_category_slug;
							}
						?>
						<div class="col-12 text-center mt-5">
							<button class="btnLoadMore btn btn-outline-primary" type="button" data-page="1" 
									data-url="<?= base_url($load_more_slug) ?>"
									data-options='<?= json_encode($btn_load_more_options) ?>'>
								<span class="spinner-border spinner-border-sm spinner d-none" role="status" aria-hidden="true"></span>
								<?= __l("Load_More"); ?> <i class="bi bi-arrow-down-circle ms-2 align-middle"></i>
							</button>
						</div>
					<?php endif; ?>
				</div>
				<div class="col-lg-3">
					<?php 
						echo $post_categories_content ?? null;
						echo view('themes/regular/pages/blog/follow_us', []);
					?>
				</div>
			</div> 
		</div>
	</section>
<?php endif; ?>