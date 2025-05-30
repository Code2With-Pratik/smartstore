<header class="navbar navbar-expand-xl js-header">
    <div class="header-wrap">
    <a class="navbar-toggler mobile-menu">
        <span class="navbar-toggler-icon">
        <i class="icon fe fe-menu"></i>
        </span>
    </a>
    <a href="<?= admin_url(); ?>" class="navbar-brand text-inherit mr-md-3">
        <img src="<?= get_app_setting('website_logo') ?>" alt="<?= get_app_setting('website_name') ; ?>" class="d-md-none navbar-brand-logo">
    </a>
    <ul class="nav navbar-menu align-items-center order-1 order-lg-2">
        <li class="nav-item d-none d-lg-block">
        <a class="nav-link" href="#customize" data-toggle="modal">
            <span class="nav-icon">
            <i class="icon fe fe-sliders" data-toggle="tooltip" data-placement="bottom" title="Theme Customizer"></i>
            </span>
        </a>
        </li>
        <li class="nav-item dropdown">
        <a href="#" data-toggle="dropdown" class="nav-link d-flex align-items-center py-0 px-lg-0 px-2 text-color ml-2">
            <span class="ml-2 d-none d-lg-block leading-none">
            <span class="mt-1">Hi! Admin </span>
            </span>
            <span class="avatar admin-profile m-l-10"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
            <a class="dropdown-item" href="<?php echo admin_url('profile'); ?>">
                <i class="icon fe fe-user dropdown-icon"></i> Profile </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?php echo admin_url('logout');?>">
                <i class="icon fe fe-log-out dropdown-icon"></i> Logout </a>
        </div>
        </li>
    </ul>
    </div>
</header>