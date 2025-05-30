<?php
    $new_tickets = db_fetch('id', TB_TICKETS, ['status' => 'new']);
    $total_unread_tickets = $new_tickets ? count($new_tickets) : 0;
    $sidebar_elements = config('AppConfig')->adminMenu;
    $xhtml_sidebar = '<ul class="navbar-nav mb-md-4" id="menu">';
    foreach ($sidebar_elements as $key => $item) {
        if ($item['area_title']) {
            $xhtml_sidebar .= sprintf('<h6 class="navbar-heading first"><span class="text">%s</span></h6>', $item['name']);
        } else {
            $route_name = $item['route-name'];
            $class_active = (segment(2) === $route_name || get('action_type') == $key) ? 'active' : '';
            $xmtml_ticket_unread_numbers = null;
        if ($key == 'tickets') {
            $xmtml_ticket_unread_numbers = sprintf('<span class="ml-auto badge badge-warning">%s</span>', $total_unread_tickets);
        }
        $xhtml_sidebar .= sprintf(
            '<li class="nav-item">
                <a class="nav-link %s" href="%s" data-toggle="tooltip" data-placement="right" title="%s">
                    <span class="nav-icon">
                    <i class="%s"></i>
                    </span>
                    <span class="nav-text">
                    %s
                    %s
                    </span>
                </a>
            </li>', $class_active, admin_url($route_name), $item['name'], $item['icon'],  $item['name'], $xmtml_ticket_unread_numbers);
        }
    }
    $xhtml_sidebar .= '</ul>';
?>


<style>
    .tickets-number {
        font-size: 14px !important;
    }
</style>
<aside class="navbar navbar-side navbar-fixed js-sidebar" id="aside">
    <div class="mobile-logo">
        <a href="<?= admin_url('orders'); ?>" class="navbar-brand text-inherit">
        <img src="<?= get_app_setting('website_logo') ?>" alt="<?= get_app_setting('website_name') ?>" class="hide-navbar-folded navbar-brand-logo">
        <img src="<?= get_app_setting('website_logo_mark') ?>" alt="<?= get_app_setting('website_name') ?>" class="hide-navbar-expanded navbar-brand-logo">
        </a>
    </div>
    <div class="flex-fill scroll-bar">
        <?=$xhtml_sidebar?>
    </div>
    <ul class="navbar-nav">
        <li class="nav-item">
        <a href="<?= admin_url('logout') ?>" class="nav-link" data-toggle="tooltip" data-placement="right" title="Logout">
            <span class="nav-icon">
            <i class="icon fe fe-power"></i>
            </span>
            <span class="nav-text">Logout</span>
        </a>
        </li>
    </ul>
</aside>