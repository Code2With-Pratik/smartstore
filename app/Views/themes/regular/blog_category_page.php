<?= $this->extend('themes/regular/theme_blade') ?>

<?= $this->section('content') ?>
	<div class="content-section-layout py-5 py-xl-6">
		<section class="header-top overflow-hidden py-5 position-relative header-section">
			<div class="position-absolute top-0 start-0 w-100 h-100 img-background"></div>
			<div class="container h-100 d-flex align-items-center">
				<div class="max-w-2xl mx-auto text-center">
					<h1 class="m-0 mt-7 text-4xl fw-bold aos-init aos-animate" data-aos-delay="0" data-aos="fade" data-aos-duration="3000">
					<span class="text-primary"><?= sanitize_output($category_name)?></span> <small class="fs-4 text-muted"><?= __l("Category"); ?></small></h1>
					<p class="m-0 mt-4 text-lg leading-8 aos-init aos-animate" data-aos-delay="100" data-aos="fade" data-aos-duration="3000"><?= __l("Unlock_new_strategies_and_techniques_with_our_indepth_articles_designed_to_help_you_optimize_your_marketing_and_grow_your_digital_presence"); ?></p>
				</div>
			</div>
		</section>
		<?php echo $sections_html; ?>
	</div>
<?= $this->endSection() ?>