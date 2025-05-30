<!doctype html>
<html lang="en" dir="ltr" data-bs-theme="auto">
<head>
    <?php include('elements/head.php'); ?>
</head>
	<body>
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
		<?php include('elements/footer.php'); ?>
		<!-- Script file -->
		<?php include('elements/scripts.php'); ?>

	</body>
</html>