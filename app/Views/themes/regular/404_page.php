<?= $this->extend('themes/regular/404_blade') ?>

<?= $this->section('content') ?>
	<style>
		.body {
			height: 100vh;
		}

		.header-top {
			margin-top: 40px;
			background: #9b9b9b33;
		}

		.content-404 {
			margin-bottom: -4rem!important;
			background: #9b9b9b33;
		}

		.error-page .error-code {
            font-size: 100px;
            font-weight: bold;
            color: #e74c3c;
        }

        .error-page .error-border {
            width: 100px;
            height: 5px;
            background-color: #e74c3c;
            margin: 20px auto;
        }

        .error-page h4 {
            font-size: 1.2rem;
            color: #555;
        }

        .error-page ul {
            text-align: left;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .error-page ul li {
            font-size: 1rem;
            color: #666;
            margin-bottom: 10px;
        }

        .error-page .btn-home {
            margin-top: 20px;
        }
	</style>

	<div class="content-section-layout py-5 py-xl-6">

		<section class="header-top overflow-hidden py-4 position-relative header-section">
			<div class="position-absolute top-0 start-0 w-100 h-100 img-background"></div>
			<div class="container h-100 d-flex align-items-center">
				<div class="max-w-2xl mx-auto text-center">
					<h1 class="m-0 mt-7 text-4xl fw-bold aos-init aos-animate" data-aos-delay="0" data-aos="fade" data-aos-duration="3000">
					<span class="text-primary">404</span> <small class="fs-4 text-muted"><?= __l("Not_found"); ?></small></h1>
					<p class="m-0 mt-4 text-lg leading-8 aos-init aos-animate" data-aos-delay="100" data-aos="fade" data-aos-duration="3000"><?= __l("You_are_requesting_a_page_that_does_not_exists"); ?></p>
				</div>
			</div>
		</section>

		<section class="content-404 py-5 py-xl-6 overflow-hidden">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-8 col-md-8 col-xl-8">
						<div class="page-content error-page">
							<div class="error-border"></div>
							<h4><?= __l("This_may_have_occurred_because_of_several_reasons"); ?></h4>
							<ul>
								<li><?= __l("The_page_you_requested_does_not_exist"); ?></li>
								<li><?= __l("The_link_you_clicked_is_no_longer_available"); ?></li>
								<li><?= __l("The_page_may_have_moved_to_a_new_location"); ?></li>
								<li><?= __l("An_error_may_have_occurred"); ?></li>
								<li><?= __l("You_are_not_authorized_to_view_the_requested_resource"); ?></li>
							</ul>
							<br>
							<strong><?= __l("Please_try_again_in_a_few_minutes_or_alternatively_return_to_the_homepage_by"); ?> <a href="<?php echo client_url();?>"><?= __l("clicking_here"); ?></a>.</strong>
							<br>
						</div>
					</div>
				</div>
			</div>
		</section>

	</div>

<?= $this->endSection() ?>