<!doctype html>
<html lang="en" dir="ltr" data-bs-theme="auto">
<head>
    <?php include('elements/head.php'); ?>
</head>
	<body>

        <!-- Coupon Header -->
		<?php include('elements/header_coupon.php'); ?>

		<!-- loader-wrapper -->
		<div class="loader-wrapper">
			<div class="spinner-grow text-primary p-5" role="status">
				<span class="visually-hidden">Loading...</span>
			</div>
		</div>

		<!-- Menu -->
		<?php include('elements/header_menu.php'); ?>

		<!-- Load Content -->
		<?= $this->renderSection('content') ?>

		<!-- Footer -->
		<?php include('elements/cookie_popup.php'); ?>
		<?php include('elements/footer.php'); ?>

		<!-- Script file -->
		<?php include('elements/scripts.php'); ?>

	</body>
</html>