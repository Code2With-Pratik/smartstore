<?= $this->extend('themes/regular/theme_blade') ?>

<?= $this->section('content') ?>

	<style>
		.header-top .img-background {
			background: url('<?php echo base_url(); ?>/assets/themes/regular/img/home/header-top-bg.png');
		}
	</style>

	<!-- header Top -->
	<section class="header-top overflow-hidden py-5 py-xl-5 position-relative">
		<div class="position-absolute top-0 start-0 w-100 h-100 img-background"></div>
		<div class="container h-100 d-flex align-items-center">
			<div class="max-w-2xl mx-auto text-center">
				<h1 class="m-0 mt-7 text-4xl fw-bold" data-aos-delay="0" data-aos="fade" data-aos-duration="3000">
					<span class="text-primary"><?= __l("Get_Started"); ?></span>
				</h1>
				<p class="m-0 mt-4 text-lg leading-8" data-aos-delay="100" data-aos="fade" data-aos-duration="3000">
					<?= __l("Please_review_the_Order_Summary_again_before_entering_checkout_information"); ?>
				</p>
			</div>
		</div>
	</section>

	<?php
		echo view($path_view_controller . 'pages/order/get_started_form');
	?>

<?= $this->endSection() ?>