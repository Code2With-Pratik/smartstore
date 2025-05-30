<?= $this->extend('themes/regular/theme_blade') ?>

<?= $this->section('content') ?>
	<div class="content-section-layout pt-5 pt-xl-6">
		<?php echo $sections_html; ?>
	</div>
<?= $this->endSection() ?>