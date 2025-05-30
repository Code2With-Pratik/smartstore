<?php

namespace Config;
use CodeIgniter\Config\BaseConfig;

class AppConfig extends BaseConfig
{
    public $prefixAdmin = 'admin';
    
    public $adminMenu = [
        'general_area'     => ['name' => 'General',         'icon' => '',                    'area_title' => true,  'route-name' => '#'],
        'statistics'       => ['name' => 'Statistics',      'icon' => 'fa fa-bar-chart',     'area_title' => false, 'route-name' => 'statistics'],

        'service_area'     => ['name' => 'Service',         'icon' => '',                    'area_title' => true,  'route-name' => '#'],
        'socialnetwork'    => ['name' => 'Social Network',  'icon' => 'fa fa-th-large',      'area_title' => false, 'route-name' => 'socialnetwork'],
        'category'         => ['name' => 'Category',        'icon' => 'fa fa-th-large',      'area_title' => false, 'route-name' => 'category'],
        'services'         => ['name' => 'Services',        'icon' => 'fa fa-list-ul',       'area_title' => false, 'route-name' => 'services'],
        'orders'           => ['name' => 'Orders',          'icon' => 'fe fe-shopping-cart', 'area_title' => false, 'route-name' => 'orders'],
        'support_area'     => ['name' => 'Support Area',    'icon' => '',                    'area_title' => true,  'route-name' => '#'],
        'tickets'          => ['name' => 'Ticket',          'icon' => 'fa fa-comments-o',    'area_title' => false, 'route-name' => 'tickets'],
        'users_area'       => ['name' => 'Manage Users',    'icon' => '',                    'area_title' => true, 'route-name' => '#'],
        'users'            => ['name' => 'Customers',        'icon' => 'fe fe-users',         'area_title' => false, 'route-name' => 'users'],
        'reviews'          => ['name' => 'Manage Reviews',        'icon' => 'fe fe-star',         'area_title' => false, 'route-name' => 'reviews'],
        'transactions'     => ['name' => 'Transactions', 'icon' => 'fa fa-file-text-o',   'area_title' => false, 'route-name' => 'transactions'],
        'subscribers'      => ['name' => 'Subscribers',     'icon' => 'fe fe-user-plus',     'area_title' => false, 'route-name' => 'subscribers'],
        'blog_area'        => ['name' => 'Blog',        'icon' => '',                    'area_title' => true,  'route-name' => '#'],
        'blogcategory'     => ['name' => 'Category',        'icon' => 'fa fa-th-large',      'area_title' => false, 'route-name' => 'blogcategory'],
        'blogposts'        => ['name' => 'Posts',        'icon' => 'fe fe-edit',      'area_title' => false, 'route-name' => 'blogposts'],
        'blacklist'        => ['name' => 'Blacklist',        'icon' => '',                    'area_title' => true,  'route-name' => '#'],
        'ip'               => ['name' => 'IP Address',       'icon' => 'icon-fa fa fa-user-times', 'area_title' => false, 'route-name' => 'blacklist?action_type=ip'],
        'email'            => ['name' => 'Email',       'icon' => 'icon-fa fa fa-user-times', 'area_title' => false, 'route-name' => 'blacklist?action_type=email'],
        'link'             => ['name' => 'Order Link',       'icon' => 'icon-fa fa fa-user-times', 'area_title' => false, 'route-name' => 'blacklist?action_type=link'],
        'setting_area'     => ['name' => 'Settings',        'icon' => '',                    'area_title' => true,  'route-name' => '#'],
        'settings'         => ['name' => 'Settings',        'icon' => 'fe fe-settings',      'area_title' => false, 'route-name' => 'settings'],
        'menu'             => ['name' => 'Manage Menu',        'icon' => 'fe fe-layout',      'area_title' => false, 'route-name' => 'menu'],
        'pages'            => ['name' => 'Manage Pages',        'icon' => 'fe fe-layout',      'area_title' => false, 'route-name' => 'pages'],
        'providers'        => ['name' => 'Providers',    'icon' => 'fe fe-link',      'area_title' => false, 'route-name' => 'providers'],
        'coupons'          => ['name' => 'Coupons',    'icon' => 'fe fe-award',      'area_title' => false, 'route-name' => 'coupons'],
        'payments'         => ['name' => 'Payments',        'icon' => 'fe fe-dollar-sign',   'area_title' => false, 'route-name' => 'payments'],
        'plugins'          => ['name' => 'Modules',         'icon' => 'fe fe-box',         'area_title' => false, 'route-name' => 'plugins'],
        'languages'        => ['name' => 'Languages',       'icon' => 'fa fa-language',      'area_title' => false, 'route-name' => 'languages'],
        'cronjobs'         => ['name' => 'Cronjobs',            'icon' => 'fe fe-help-circle',   'area_title' => false, 'route-name' => 'cronjobs'],
    ];

    public $admin_setting = [
        'sidebar' => [
            'website_setting' => ['name' => 'Site setting', 'icon' => 'fe fe-globe',       'area_title' => false, 'route-name' => 'website_setting'],
            'default'         => ['name' => 'Default setting', 'icon' => 'fe fe-box',         'area_title' => false, 'route-name' => 'default'],
            'page_seo'        => ['name' => 'General Page SEO',    'icon' => 'fe fe-image',       'area_title' => false, 'route-name' => 'page_seo'],
            'cookie_popup'    => ['name' => 'Cookie Popup',   'icon' => 'fe fe-bookmark',    'area_title' => false, 'route-name' => 'cookie_popup'],
            'coupon_header'   => ['name' => 'Coupon header',   'icon' => 'fe fe-award',    'area_title' => false, 'route-name' => 'coupon_header'],
            'currency'        => ['name' => 'Currency Format',  'icon' => 'fe fe-dollar-sign', 'area_title' => false, 'route-name' => 'currency'],
            'social_link'     => ['name' => 'Social Links',     'icon' => 'fe fe-link',     'area_title' => false, 'route-name' => 'social_link'],
            'footer_link'     => ['name' => 'Footer links',     'icon' => 'fe fe-link',     'area_title' => false, 'route-name' => 'footer_link'],
            'header_footer'   => ['name' => 'Header & Footer',     'icon' => 'fe fe-layout',     'area_title' => false, 'route-name' => 'header_footer'],
            'notifications'   => ['name' => 'Email Setting',     'icon' => 'fe fe-bell',     'area_title' => false, 'route-name' => 'notifications'],
            'email_templates' => ['name' => 'Email templates',     'icon' => 'fe fe-mail',     'area_title' => false, 'route-name' => 'email_templates'],
            'recaptcha'       => ['name' => 'Google reCAPTCHA',     'icon' => 'fe fe-zap',     'area_title' => false, 'route-name' => 'recaptcha'],
            'other'           => ['name' => 'Other',           'icon' => 'fe fe-command',     'area_title' => false, 'route-name' => 'other'],
        ],
    ];

    public $template = [
        'pages' => [
            'default'           => 'Default',
            'blog'              => 'Blog',
            'home_page'         => 'Home Page (Regular)',
        ],
        'menu_type' => [
            'link'                  => 'Link',
            'social_network_option' => 'Social Network Category List Options',
            'track_order'           => 'Track Order',
            'blog'                  => 'Blog'
        ],
        'form_link_target' => [
            'self'  => 'Normal',
            'blank' => 'Open new tab',
        ],
        'form' => [
            'class_element'                   => 'form-control',
            'class_element_checkbox'          => 'form-check-input',
            'class_element_checkbox_switch'   => 'custom-switch-input',
            'class_element_editor'            => 'form-control plugin_editor',
            'class_element_datepicker'        => 'form-control datepicker',
            'class_element_text_emoji'        => 'form-control text-emoji',
            'label_required'                  => '<span class="form-required">*</span>',
        ],
        'background_colors' => [
            'primary'    => 'Primary',
            'secondary'  => 'Secondary',
            'success'    => 'Success',
            'danger'     => 'Danger',
            'warning'    => 'Warning',
            'info'       => 'Info',
            'dark'       => 'Dark',
        ],
        'datetime' => [
            'long'      => 'Y-m-d H:i:s',
            'short'     => 'Y-m-d',
            'client'    => 'M j, Y',
        ],
        'status' => [
            'default' => [
                '1'      => ['name' => 'Active',   'class' => 'bg-indigo', 'class-badge' => 'bg-indigo-lt'],
                '0'      => ['name' => 'Deactive', 'class' => 'bg-orange', 'class-badge' => 'bg-orange-lt'],
                '2'      => ['name' => 'Unknow',   'class' => 'bg-orange', 'class-badge' => 'bg-orange-lt'],
                '3'      => ['name' => 'All',      'class' => 'bg-azure'],
            ],
            'tickets' => [
                'new'         => ['name' => 'New',  'class' => 'bg-purple', 'class-badge' => 'bg-green-lt'],
                'pending'     => ['name' => 'Pending',  'class' => 'bg-purple', 'class-badge' => 'bg-purple-lt'],
                'answered'    => ['name' => 'Answered', 'class' => 'bg-green',  'class-badge' => 'bg-secondary'],
                'closed'      => ['name' => 'Closed',   'class' => 'bg-indigo', 'class-badge' => 'bg-indigo-lt'],
            ], 
            'reviews' => [
                '0'     => ['name' => 'Rejected', 'class' => 'bg-red',    'class-badge' => 'bg-red'],
                '1'      => ['name' => 'Approved',      'class' => 'bg-indigo', 'class-badge' => 'bg-indigo-lt'],
                '2'      => ['name' => 'Pending',   'class' => 'bg-orange', 'class-badge' => 'bg-orange-lt'],
                '3'      => ['name' => 'All',      'class' => 'bg-azure'],
                '4'      => ['name' => 'Unknow',    'class' => 'bg-orange', 'class-badge' => 'bg-orange-lt'],
            ], 
            'pages' => [
                '0'         => ['name' => 'Draft', 'class' => 'bg-red',    'class-badge' => 'bg-red'],
                '1'         => ['name' => 'Publishied',      'class' => 'bg-indigo', 'class-badge' => 'bg-indigo-lt'],
                '2'         => ['name' => 'Pending',   'class' => 'bg-orange', 'class-badge' => 'bg-orange-lt'],
            ], 
            'coupons' => [
                '0'     => ['name' => 'Deactive', 'class' => 'bg-red',    'class-badge' => 'bg-red'],
                '1'      => ['name' => 'Active',      'class' => 'bg-indigo', 'class-badge' => 'bg-indigo-lt'],
                '2'      => ['name' => 'Expired',   'class' => 'bg-orange', 'class-badge' => 'bg-red-lt'],
                '3'      => ['name' => 'All',      'class' => 'bg-azure'],
            ], 
            'orders' => [
                'all'             => ['name' => 'All',       'class' => 'bg-purple', 'class-badge' => 'bg-purple'],
                'active'          => ['name' => 'Active',       'class' => 'bg-purple', 'class-badge' => 'bg-green-lt'],
                'completed'       => ['name' => 'Completed',    'class' => 'bg-green',  'class-badge' => 'bg-indigo-lt'],
                'processing'      => ['name' => 'Processing',   'class' => 'bg-indigo', 'class-badge' => 'bg-blue-lt'],
                'inprogress'      => ['name' => 'In progress',   'class' => 'bg-indigo', 'class-badge' => 'bg-cyan-lt'],
                'pending'         => ['name' => 'Pending',      'class' => 'bg-indigo', 'class-badge' => 'bg-green-lt'],
                'partial'         => ['name' => 'Partial',      'class' => 'bg-indigo', 'class-badge' => 'bg-pink-lt'],
                'canceled'        => ['name' => 'Canceled',     'class' => 'bg-secondary', 'class-badge' => 'bg-secondary'],
                'error'           => ['name' => 'Error',        'class' => 'bg-red', 'class-badge' => 'bg-red-lt'],
                'fail'            => ['name' => 'Fail',         'class' => 'bg-red', 'class-badge' => 'bg-red-lt'],
                'paused'          => ['name' => 'Paused',     'class' => 'bg-red', 'class-badge' => 'bg-red-lt'],
                'expired'         => ['name' => 'Expired',     'class' => 'bg-red', 'class-badge' => 'bg-red-lt'],
                'awaiting'        => ['name' => 'Awaiting',     'class' => 'bg-lime', 'class-badge' => 'bg-orange-lt'],
                'rejected'        => ['name' => 'Rejected',     'class' => 'bg-secondary', 'class-badge' => 'bg-secondary'],
                'refunded'        => ['name' => 'Refunded',     'class' => 'bg-indigo', 'class-badge' => 'bg-indigo-lt'],
                'approved'        => ['name' => 'Approved',     'class' => 'bg-indigo', 'class-badge' => 'bg-indigo-lt'],
            ], 
            'transactions' => [
                '-1'     => ['name' => 'Cancelled', 'class' => 'bg-red',    'class-badge' => 'bg-red'],
                '1'      => ['name' => 'Paid',      'class' => 'bg-indigo', 'class-badge' => 'bg-indigo-lt'],
                '0'      => ['name' => 'Waiting',   'class' => 'bg-orange', 'class-badge' => 'bg-orange-lt'],
                '2'      => ['name' => 'Unknow',    'class' => 'bg-orange', 'class-badge' => 'bg-orange-lt'],
                '3'      => ['name' => 'All',      'class' => 'bg-azure'],
            ],
        ],
        'button' => [
            'edit'         => ['name' => 'Edit',   'class' => 'ajaxModal',      'icon' => 'fe fe-edit', 'route-name' => '/update/'],
            'edit2'         => ['name' => 'Edit',   'class' => '',      'icon' => 'fe fe-edit', 'route-name' => '/update/'],
            'delete'         => ['name' => 'Delete',   'class' => 'ajaxDeleteItem', 'icon' => 'fe fe-trash-2', 'route-name' => '/delete/'],
            'duplicate'       => ['name' => 'Duplicate', 'class' => 'ajaxDuplicateItem', 'icon' => 'fe fe-copy', 'route-name' => '/duplicate/'],
            'delete_custom_rate' => ['name' => 'Delete custom rates', 'class' => 'ajaxDeleteItem', 'icon' => 'fe fe-trash', 'route-name' => '/delete_custom_rate/'],
            'view'         => ['name' => 'View', 'class' => 'ajaxModal', 'icon' => 'fe fe-eye', 'route-name' => '/view/'],
            'add_note'     => ['name' => 'Add Note', 'class' => 'ajaxModal', 'icon' => 'fe fe-dollar-sign', 'route-name' => '/add_note/'],
            'set_balance'   => ['name' => 'Set balance', 'class' => 'ajaxModal', 'icon' => 'fe fe-credit-card', 'route-name' => '/edit_funds/'],
            'send_mail'     => ['name' => 'Send Mail', 'class' => 'ajaxModal', 'icon' => 'fe fe-mail', 'route-name' => '/send_mail/'],
            'reply'         => ['name' => 'Reply', 'class' => 'ajaxModal', 'icon' => 'fe fe-mail', 'route-name' => '/send_mail/'],
            'sync_services' => ['name' => 'Sync services', 'class' => 'ajaxModal', 'icon' => 'fe fe-refresh-cw', 'route-name' => '/sync_services/'],
            'balance'       => ['name' => 'Update balance', 'class' => 'ajaxUpdateApiProvider', 'icon' => 'fe fe-dollar-sign', 'route-name' => '/balance/'],
            'resend'        => ['name'  => 'Resend Order', 'class' => '', 'icon' => 'fe fe-refresh-cw', 'route-name' => '/resend/'],
        ],
        'bulk_action' => [
            'delete'   => ['name' => 'Delete', 'class' => 'ajaxActionOptions', 'icon' => 'fe fe-trash-2',      'route-name' => '/bulk_action/'],
            'empty'    => ['name' => 'Empty The Data', 'class' => 'ajaxActionOptions', 'icon' => 'fe fe-trash-2',      'route-name' => '/bulk_action/'],
            'delete_custom_rates'   => ['name' => 'Delete custom rates', 'class' => 'ajaxActionOptions', 'icon' => 'fe fe-trash',      'route-name' => '/bulk_action/'],
            'deactive' => ['name' => 'Deactive All', 'class' => 'ajaxActionOptions', 'icon' => 'fe fe-x-square',     'route-name' => '/bulk_action/'],
            'active'   => ['name' => 'Active', 'class' => 'ajaxActionOptions', 'icon' => 'fe fe-check-square', 'route-name' => '/bulk_action/'],
            'pending'  => ['name' => 'Mark as Pending',  'class' => 'ajaxActionOptions', 'icon' => 'fe fe-navigation',  'route-name' => '/bulk_action/'],
            'closed'   => ['name' => 'Mark as Closed',   'class' => 'ajaxActionOptions', 'icon' => 'fe fe-lock',        'route-name' => '/bulk_action/'],
            'answered' => ['name' => 'Mark as Answered', 'class' => 'ajaxActionOptions', 'icon' => 'fe fe-check',       'route-name' => '/bulk_action/'],
            'unread'   => ['name' => 'Mark as Unread', 'class' => 'ajaxActionOptions', 'icon' => 'fe fe-mail',       'route-name' => '/bulk_action/'],
            'csv'      => ['name' => 'Export CSV',   'class' => '', 'icon' => 'fe fe-download',  'route-name' => '/export/'],
            'excel'    => ['name' => 'Export excel', 'class' => '', 'icon' => 'fe fe-download',  'route-name' => '/export/'],
            'pending'      => ['name' => 'Pending', 'class' => 'ajaxActionOptions', 'icon' => 'fe fe-clock', 'route-name' => '/bulk_action/'],
            'inprogress'   => ['name' => 'In progress', 'class' => 'ajaxActionOptions', 'icon' => 'fe fe-loader', 'route-name' => '/bulk_action/'],
            'completed'    => ['name' => 'Completed', 'class' => 'ajaxActionOptions', 'icon' => 'fe fe-check-square', 'route-name' => '/bulk_action/'],
            'resend'       => ['name' => 'Resend Order', 'class' => 'ajaxActionOptions', 'icon' => 'fe fe-refresh-cw', 'route-name' => '/bulk_action/'],
            'cancel'       => ['name' => 'Cancel and Refund', 'class' => 'ajaxActionOptions', 'icon' => 'fe fe-x', 'route-name' => '/bulk_action/'],
            'rejected'     => ['name' => 'Rejected', 'class' => 'ajaxActionOptions', 'icon' => 'fe fe-x', 'route-name' => '/bulk_action/'],
            'paused'       => ['name' => 'Paused', 'class' => 'ajaxActionOptions', 'icon' => 'fe fe-alert-triangle', 'route-name' => '/bulk_action/'],
            'copy_id'      => ['name' => 'Copy to Clipboard (ID)', 'class' => 'ajaxActionOptions', 'icon' => 'fe fe-copy', 'route-name' => '/bulk_action/'],
            'copy_order_id' => ['name' => 'Copy to Clipboard (Order ID)', 'class' => 'ajaxActionOptions', 'icon' => 'fe fe-copy', 'route-name' => '/bulk_action/'],
            'copy_api_order_id' => ['name' => 'Copy to Clipboard (API Order ID)', 'class' => 'ajaxActionOptions', 'icon' => 'fe fe-copy', 'route-name' => '/bulk_action/'],
            'copy_api_refill_id' => ['name' => 'Copy to Clipboard (API Refill ID)', 'class' => 'ajaxActionOptions', 'icon' => 'fe fe-copy', 'route-name' => '/bulk_action/'],
        ],
        'search_field' => [
            'all'           => ['name' => 'All'],
            'code'           => ['name' => 'Code'],
            'id'            => ['name' => 'ID'],
            'email'         => ['name' => 'Email'],
            'from'          => ['name' => 'From'],
            'name'          => ['name' => 'Name'],
            'client_order_id'      => ['name' => 'Client Order Id'],
            'order_id'      => ['name' => 'Order ID'],
            'sort'          => ['name' => 'Sort'],
            'question'      => ['name' => 'Question'],
            'answer'        => ['name' => 'Answer'],
            'description'    => ['name' => 'Description'],
            'ip'             => ['name' => 'IP address'],
            'history_ip'     => ['name' => 'History ip'],
            'country'        => ['name' => 'Location'],
            'first_name'     => ['name' => 'First name'],
            'last_name'      => ['name' => 'Last name'],
            'username'      => ['name'  => 'Username'],
            'transaction_id' => ['name' => 'Transaction id'],
            'note'           => ['name' => 'Note'],
            'subject'        => ['name' => 'Subject'],
            'api_service_id' => ['name' => 'API service id'],
            'api_order_id'   => ['name' => 'API Order id'],
            'service_id'     => ['name' => 'Service id'],
            'link'           => ['name' => 'Link'],
        ],
        'service_type' => [
            'default'                 => 'Default',
            'subscriptions'           => 'Subscriptions',
            'custom_comments'         => 'Custom comments',
            'custom_comments_package' => 'Custom comments package',
            'mentions_with_hashtags'  => 'Mentions with hashtags',
            'mentions_custom_list'    => 'Mentions custom list',
            'mentions_hashtag'        => 'Mentions hashtag',
            'mentions_user_followers' => 'Mentions user followers',
            'mentions_media_likers'   => 'Mentions media likers',
            'package'                 => 'Package',
            'comment_likes'           => 'Comment likes',
        ],
        'page_title' => [
            'firstRow'
        ],
    ];
    
    public $config = [
        'language_localization' => [
            'path' => [
                'default_file' => APPPATH . 'Language/en/default_lang.php',
                'data'    => APPPATH . 'Language/data/',
            ]
        ],
        'button' => [
            'default'          => ['edit', 'delete'],
            'payments'         => ['edit'],
            'languages'        => ['edit2', 'delete'],
            'socialnetwork'    => ['edit', 'duplicate', 'delete'],
            'menu'             => ['edit2', 'delete'],
            'faqs'             => ['edit', 'delete'],
            'blogcategory'     => ['edit', 'duplicate', 'delete'],
            'blogposts'        => ['edit2', 'duplicate', 'delete'],
            'category'         => [ 'edit2', 'duplicate', 'delete'],
            'pages'            => ['edit2', 'delete'],
            'reviews'          => ['edit','duplicate', 'delete'],
            'services'         => ['edit', 'duplicate', 'delete'],
            'transactions'     => ['delete'],
            'tickets'          => ['reply', 'delete'],
            'providers'        => ['edit', 'balance', 'delete'],
            'users'            => ['add_note', 'send_mail', 'delete'],
            'subscribers'      => ['delete'],
        ],
        'status' => [
            'default'  => [
                '1' => 'active',
                '0' => 'inactive', 
            ],
            'transactions'  => [
                '-1' => 'waiting', 
                '0' => 'pending', 
                '1' => 'paid'
            ],
            'reviews'  => [
                '0' => 'rejected', 
                '1' => 'approved',
                '2' => 'pending', 
            ],
            'pages'  => [
                '0' => 'draft', 
                '1' => 'Publishied',
                '2' => 'Pending', 
            ],
            'coupons'  => [
                '0' => 'deactive', 
                '1' => 'active',
                '2' => 'expired', 
            ],
            'tickets'  => [
                'pending'   => 'pending', 
                'answered'  => 'answered', 
                'closed'    => 'closed'
            ],
            'orders' => [
                'all'       => 'all',
                'awaiting'  => 'awaiting', 
                'processing'=> 'processing',
                'inprogress'=> 'in progress', 
                'pending'   => 'pending', 
                'completed' => 'completed',
                'partial'   => 'partial', 
                'canceled'  => 'canceled',
                'error'     => 'error',
                'fail'      => 'fail',
            ],
            'dripfeed' => [
                'all'       => 'all', 
                'active'    => 'active', 
                'completed' => 'completed',
                'canceled'  => 'canceled',
            ],
            'subscriptions' => [
                'all'      => 'all', 
                'active'   => 'active', 
                'paused'   => 'paused',
                'expired'  => 'expired',
                'completed'=> 'completed', 
                'error'    => 'error',
            ],
            'refill' => [
                'all'       => 'all',
                'pending'   => 'pending', 
                'awaiting'  => 'awaiting', 
                'inprogress'=> 'in progress',
                'rejected'  => 'rejected', 
                'completed' => 'completed',
            ],
        ],
        'search' => [
            'default'         => ['all', 'name'],
            'coupons'         => ['code'],
            'blacklist_ip'    => ['ip'],
            'blacklist_email'    => ['email'],
            'blacklist_link'    => ['link'],
            'socialnetwork'   => ['all', 'name'],
            'blogcategory'    => ['name'],
            'blogposts'       => ['name'],
            'users'           => ['all', 'email', 'history_ip'],
            'reviews'         => ['name', 'client_order_id', 'email', 'ip'],
            'tickets'         => ['id', 'from', 'subject', 'ip'],
            'category'        => ['name'],
            'pages'           => ['name'],
            'transactions'    => ['order_id', 'transaction_id', 'email'],
            'payments'        => ['name'],
            'faqs'            => ['question', 'answer'],
            'services'        => [ 'name', 'api_service_id'],
            'providers'       => [ 'name'],
            'orders'          => [ 'id', 'client_order_id', 'api_order_id', 'link', 'email', 'service_id'],
            'subscribers'     => [ 'email', 'history_ip'],
        ],
        'bulk_action' => [
            'default'          => ['active', 'deactive', 'delete'],
            'languages'        => ['active'],
            'subscribers'      => ['delete'],
            'socialnetwork'    => ['active', 'deactive', 'delete'],
            'transactions'     => ['delete'],
            'users'            => ['delete'],
            'reviews'          => ['delete'],
            'tickets'          => ['pending', 'closed', 'delete'],
            'services'         => ['active', 'deactive', 'delete'],
            'category'         => ['active', 'deactive', 'delete'],
            'payments'         => ['active', 'deactive'],
            'orders'           => ['pending', 'inprogress', 'completed', 'resend', 'cancel', 'copy_id', 'copy_api_order_id'],
        ],
        'content_section_layout_edit_form' => [
            'blog' => [
                'header_section', 
            ],
            'default' => [
                'header_section', 
                'optional_content_section',
                'faqs_section', 
                'quick_links_section',
            ],
            'home_page' => [
                'header_section', 
                'counters_section', 
                'packages_section', 
                'image_with_text_section', 
                'why_choose_us_section', 
                'what_we_offer_section', 
                'how_it_work_section', 
                'optional_content_section',
                'reviews_section', 
                'faqs_section', 
                'growing_brands_section', 
                'quick_links_section', 
            ],
            'category_page' => [
                'header_section', 
                'packages_section', 
                'why_choose_us_section', 
                'how_it_work_section', 
                'faqs_section', 
                'quick_links_section',
            ],
        ], 
    ];

    public $client_template = [
        'default_ui_components_lists' => [
            'header_section'            => ['title' => 'Header Section'],
            'counters_section'          => ['title' => 'Counters Section'],
            'image_with_text_section'   => ['title' => 'Image with text section'],
            'packages_section'          => ['title' => 'Packages section'],
            'why_choose_us_section'     => ['title' => 'Why choose us section'],
            'faqs_section'              => ['title' => 'FAQs Sections'],
            'what_we_offer_section'     => ['title' => 'What we offer section'],
            'contact_us_section'        => ['title' => 'Contact Us section'],
            'how_it_work_section'       => ['title' => 'How it works section'],
            'growing_brands_section'    => ['title' => 'Growing brands section'],
            'quick_links_section'       => ['title' => 'Quick links section'],
            'reviews_section'           => ['title' => 'Reviews section'],
            'optional_content_section'  => ['title' => 'Optional content section'],
        ],
        'default_sections' => [
            'packages_section' => [
                'fields' => [
                    'title_status'  => 1,
                    'title'         => 'Our Services',
                    'short_desc'    => 'Only the best quality. 100% risk-free and perfectly anonymous',
                    'display_on_page' => [
                        'category_page' => 'Category page',
                        'home_page' => 'Home page'
                    ],
                    'layout_type'  => 'tab',
                    'layout_type_arr' => [
                        'tab' => 'Tab',
                        'carousel' => 'Carousel'
                    ],
                    'items_per_carousel'  => 3,
                    'items_per_carousel_arr' => [
                        '1' => '1 item',
                        '2' => '2 items',
                        '3' => '3 items',
                        '4' => '4 items'
                    ], 
                    'features_status'   => 0,
                    'features_title'   => 'Elite Quality',
                    'features_content' => "⚡️ Delivery in: 58 seconds \r\n ✅ Lifetime guarantee \r\n 💬 24/7 support on WhatsApp \r\n 🙋‍♂️ 100% Real Users \r\n 🟢 Very Active Users \r\n 🚀 Engagement Improvement \r\n 🥇 The best quality on the market ",
                ],
            ],
            'optional_content_section' => [
                'fields' => [
                    'content'  => '',   
                ],
            ],
            'quick_links_section' => [
                'fields' => [
                    'title'         => 'Get the best social media services today!',
                    'features'   => [
                        [
                            'title' => 'Buy Instagram Likes',
                            'content' => 'buy-instagram-likes',
                        ],
                        [
                            'title' => 'Buy Instagram Followers',
                            'content' => 'buy-instagram-followers',
                        ],
                    ],
                ]
            ],
            'contact_us_section' => [
                'fields' => [
                    'title'         => 'Contact Us',
                    'short_desc'    => 'We would love to hear from you! Please fill out the form below and we will get back to you as soon as possible.',
                    'image_position' => 'left',
                    'image_position_arr' => [
                        'left'  => 'Left',
                        'right' => 'Right',
                    ],
                    'image_url'     => BASE_URL . 'assets/themes/regular/img/home/boost-your-social-media-impact-with-expert-support.png',
                    'information_status'  => 0,
                ]
            ],
            'how_it_work_section' => [
                'fields' => [
                    'title'         => 'How it works?',
                    'short_desc'    => 'By following the processes below you can make any order you want.',
                    'number_steps'  => 4,
                    'number_steps_arr' => [
                        '3' => '3 steps',
                        '4' => '4 steps'
                    ], 
                    'features' => [
                        [
                            'title' => 'Select Package',
                            'content' => 'Pick the package that is right for you, choose from different amounts and delivery time frames.',
                        ],
                        [
                            'title' => 'Add Username/URL',
                            'content' => 'Provide us with the relevant information to get started on your order!',
                        ],
                        [
                            'title' => 'Checkout',
                            'content' => 'Follow our SSL secured checkout to complete the payment for your order. No financial information is ever stored!',
                        ],
                        [
                            'title' => 'Hurray! (Instant delivery)',
                            'content' => 'Your order is now in the hands of the social media experts, watch the magic happen!',
                        ],
                    ],
                ]
            ],
            'counters_section' => [
                'fields' => [
                    'features'   => [
                        [
                            'icon' => 'bi bi-bag-heart',
                            'title' => 'Instagram Followers Delivered',
                            'number' => '2563456',
                        ],
                        [
                            'icon' => 'bi bi-bag-heart',
                            'title' => 'SoundCloud Plays Delivered',
                            'number' => '1978363',
                        ],
                        [
                            'icon' => 'bi bi-bookmark-heart-fill',
                            'title' => 'SoundCloud Plays Delivered',
                            'number' => '4792357',
                        ]
                    ],
                ]
            ],
            'header_section' => [
                'fields' => [
                    'left_span_text_in_title'   => 'SmartStore',
                    'title'                     => 'Promotion Service',
                    'short_desc'    => 'Your go-to source for top-notch social media services, dedicated to enhancing your online presence with authentic and effective solutions.',
                    'background_image_url'   => BASE_URL . 'assets/themes/regular/img/home/header-top-bg.png',
                    'button_status' => 1,
                    'button_name'   => 'Get Started',
                    'button_url'    => 'buy-instagram-likes',
                ]
            ],
            'faqs_section' => [
                'fields' => [
                    'title'         => 'Frequently Asked Questions',
                    'short_desc'    => 'Get answers to your queries about our likes and followers services.',
                    'layout_type'       => 'center',
                    'layout_type_arr'   => [
                        'center' => 'Title & FAQ at center',
                        'left' => 'Title left, FAQ right',
                    ],
                    'features'   => [
                        [
                            'title' => 'How do I place an order?',
                            'content' => "To place an order, simply choose the service you want, select the package that fits your needs, and proceed to checkout. You'll receive instant confirmation once your order is placed.",
                        ],
                        [
                            'title' => 'What payment methods do you accept?',
                            'content' => "We accept various payment methods including credit cards, PayPal, and other secure payment gateways. Your payment information is always protected.",
                        ],
                        [
                            'title' => 'How long will it take to see results?',
                            'content' => "Depending on the package you choose, results can typically be seen within a few hours to a few days. Our services are designed to provide quick and effective results.",
                        ],
                        [
                            'title' => 'Can I use your services for multiple accounts?',
                            'content' => "Yes, you can use our services for multiple accounts. Just make sure to place separate orders for each account to ensure accurate delivery of likes and followers.",
                        ],
                    ],
                ]
            ],
            'growing_brands_section' => [
                'fields' => [
                    'title'         => 'For For Growing Brands',
                    'short_desc'    => 'Looking to boost your social media presence and gain more followers?',
                    'button_name'   => 'Get Started',
                    'button_url'    => 'buy-instagram-likes',
                ]
            ],
            'image_with_text_section' => [
                'fields' => [
                    'image_position' => 'left',
                    'image_url'     => BASE_URL . 'assets/themes/regular/img/home/boost-your-social-media-impact-with-expert-support.png',
                    'title'         => 'Why Invest in Social Media Services?',
                    'headling'      => "Unlock the Future of Your Brand",
                    'short_desc'    => 'Investing in social media services is crucial for maximizing your reach and influence. Professional assistance allows you to effectively navigate the complexities of various platforms, ensuring your content resonates and builds lasting relationships with your audience.',
                ]
            ],
            'what_we_offer_section' => [
                'fields' => [
                    'image_url'     => BASE_URL . 'assets/themes/regular/img/home/what-we-offer.png',
                    'title'         => 'What we offer!',
                    'headling'      => 'Comprehensive Services for Your Social Media Needs',
                    'short_desc'    => 'Our diverse range of services is designed to help you dominate social media',
                    'features'   => [
                        [
                            'icon' => 'bi bi-person-plus',
                            'title' => 'Extensive Social Media Panel',
                            'content' => "Gain access to a wide array of tools for managing and boosting your accounts.",
                        ],
                        [
                            'icon' => 'bi bi-hand-thumbs-up',
                            'title' => 'Authentic Engagement Services',
                            'content' => "Foster real interactions with your audience through genuine likes, comments, and shares.",
                        ],
                        [
                            'icon' => 'bi bi-shield-check',
                            'title' => 'Targeted Advertising Campaigns',
                            'content' => "Reach specific demographics with precision through tailored ad strategies.",
                        ],
                        [
                            'icon' => 'bi bi-chat-right-heart',
                            'title' => 'Detailed Performance Analytics',
                            'content' => "Monitor your success with in-depth reporting and insights that guide your strategy.",
                        ],
                    ],
                ]
            ],
            'why_choose_us_section' => [
                'fields' => [
                    'title'         => 'Why Choose Us?',
                    'headling'      => 'The Difference You Can Trust',
                    'short_desc'    => 'Choosing us means choosing quality, dedication, and proven success',
                    'features'   => [
                        [
                            'icon' => 'bi bi-person-hearts',
                            'title' => 'Expert Team',
                            'content' => "Our professionals bring extensive experience and insights, staying updated with the latest industry trends.",
                        ],
                        [
                            'icon' => 'bi bi-server',
                            'title' => 'Data-Driven Approach',
                            'content' => "We leverage analytics to fine-tune your campaigns, ensuring you get the best return on investment",
                        ],
                        [
                            'icon' => 'bi bi-sliders',
                            'title' => 'Tailored Solutions',
                            'content' => "We customize our strategies to fit your specific needs, ensuring optimal results for your business",
                        ],
                        [
                            'icon' => 'bi bi-chat-right-heart',
                            'title' => '24/7 Support',
                            'content' => "Our dedicated support team is always available to assist you, providing peace of mind as you grow your online presence.",
                        ],
                    ],
                ]
            ],
            'reviews_section' => [
                'fields' => [
                    'title'                      => 'What do our customers say?',
                    'short_desc'                 => 'Customer reviews',
                    'btn_add_review_status'      => 1,
                    'btn_load_more_status'       => 1,
                ]
            ],
        ],
    ];

    public $general_setting = [
        'site_maintenance_mode'     => 0,
        'website_name'              => 'SmartStore',
        'website_favicon'           => BASE_URL . 'assets/images/favicon.png',
        'website_logo'              => BASE_URL . 'assets/images/logo.png',
        'website_logo_white'        => BASE_URL . 'assets/images/logo-white.png',
        'website_logo_mark'         => BASE_URL . 'assets/images/logo-mark.png',
        
        'website_seo' => [
            'title' => 'SmartStore - SMM Services for Your Social Media Growth',
            'keywords' => 'SmartStore, SMM services, social media marketing, Instagram followers, Facebook likes, YouTube views',
            'description' => "Boost your social media presence with SmartStore's SMM services. Get real followers, likes, and more for Instagram, Facebook, YouTube, and other platforms.",
            'image_url' => "",
            'index'     => 'index',
            'author'    => 'SmartStore', 
            'generator' => 'SmartStore - SMM Store Script',
            'favicon'   => BASE_URL . '/assets/images/favicon.png',
        ],
        
        'admin_max_items_per_page'          => 50,
        'reviews_limit_per_page'            => 6,
        'blog_limit_posts_per_page'         => 4,
        
        'currency_code'                     => 'USD',
        'currency_symbol'                   => '$',
        'currency_position'                 => 'before',
        'currency_position_arr'             => [
            'before' => '$1.0',
            'after' => '1.00$',
        ],
        'currency_thousand_separator'       => 'comma',
        'currency_thousand_separator_arr'   => [
            'dot'    => 'Dot',
            'comma'  => 'Comma',
            'space'  => 'Space',
        ],
        'provider_note' => '<p>Note: This script supports almost all SMM providers (API v2), such as:</p>
                                        <ul>
                                            <li>momopanel.com</li>
                                            <li>vinasmm.com</li>
                                            <li>hqsmartpanel.com</li>
                                            <li>etc.</li>
                                        </ul>
                                        <p>However, it does not support other API providers that have different API parameters.</p>',

        'service_tab_name_note' => '<p><strong>Tab Name</strong> is the name displayed to users. You can enter it in multiple languages. Important points:</p>
                                    <ul>
                                        <li><strong>Clear & concise:</strong> Choose a name that clearly describes the tab.</li>
                                        <li><strong>Multilingual:</strong> Add names for different languages.</li>
                                    </ul>
                                    <p>Example: <strong>Most Popular</strong> (English), <strong>Best Seller</strong> (English)</p>
                                    <p><em>Note:</em> Tab Name is only supported for the package list in <strong>carousel format</strong>.</p>
                                    ',
        
        'currency_decimal'       => '2',
        'currency_decimal_arr'   => [
            '0'    => '1',
            '1'    => '1.0',
            '2'    => '1.00',
            '3'    => '1.000',
            '4'    => '1.0000',
        ],

        'site_copy_right_content'   => 'SmartStore. All rights reserved.',
        'blog_author_name'   => 'SmartStore',
        'social_links' => [
            'facebook'      => ['link' => 'https://www.facebook.com/', 'icon' => 'bi bi-facebook'],
            'tiktok'        => ['link' => 'https://www.tiktok.com/', 'icon' => 'bi bi-tiktok'],
            'instagram'     => ['link' => 'https://www.instagram.com/', 'icon' => 'bi bi-youtube'],
            'twitter'       => ['link' => 'https://www.twitter.com/', 'icon' => 'bi bi-instagram'],
            'pinterest'     => ['link' => 'https://www.pinterest.com/', 'icon' => 'bi bi-pinterest'],
            'twitter'       => ['link' => 'https://www.twitter.com/', 'icon' => 'bi bi-twitter-x'],
            'youtube'       => ['link' => 'https://www.youtube.com/', 'icon' => 'bi bi-youtube'],
            'whatsapp'      => ['link' => 'https://www.whatsapp.com/', 'icon' => 'bi bi-whatsapp'],
            'linkedin'      => ['link' => 'https://www.linkedin.com/', 'icon' => 'bi bi-linkedin'],
        ],
        'cookie_popup' => [
            'status'            => 1,
            'content'           => 'We use cookies to improve your experience. By using our site, you agree to our Privacy Policy and Cookie Policy.',
            'button_title'      => 'Got it!',
            'popup_position'    => 'left',
            'consent_expiry_time'    => 7,
            'popup_position_arr'    => [
                'left' => 'Left',
                'center' => 'Center',
                'right' => 'Right',
            ],
        ],

        'coupon_header' => [
            'status'                => 1,
            'content'               => 'Save 10% today! Apply code: DISCOUNT10',
            'badge_title_status'    => 1,
            'badge_title'           => 'Special Offer',
            'image_background'      => BASE_URL . 'assets/themes/regular/img/home/coupon_header.webp',
            'counter_time_status'   => 1,
            'counter_time'      => [
                'hour' => 0,
                'minutes' => 30,
            ],
        ],

        'footer_links' => [
            'en' => [
                [
                    'title' => 'Terms of Use',
                    'type' =>  'url_slug', 
                    'url_slug' => 'terms-of-use', 
                ],
                [
                    'title' => 'About Us',
                    'type' =>  'url_slug', 
                    'url_slug' => 'about-us', 
                ],
                [
                    'title' => 'Contact Us',
                    'type' =>  'url_slug', // External link
                    'url_slug' => 'contact-us', 
                ],
            ],
        ],
        'contact_informations' => [
            'email'      => 'support@smartpanelsmm.com',
            'phone'      => '+123 456 789',
            'address'    => '123 Main Street, City, Country',
        ],

        

        'smtp_info' => [
            'smtp_host' => '',
            'smtp_user' => '', 
            'smtp_pass' => '', 
            'smtp_port' => '', 
            'smtp_from_email' => '',
            'smtp_from_name' => '',
            'protocol' => 'mail',
            'mailPath' => '/usr/sbin/sendmail -bs -i',
        ],

        'notification_email_templates' => [
            'new_order_notification_to_customer' => [
                'status' => 0,
                'template_name' => 'New Order Notifications (Send to Customer)',
                'subject' => '{{website_name}} - Your Order Has Been Successfully Placed!',
                'content' => '<p>Hello {{customer_name}},</p>
                                <p>Thank you for your purchase at <strong>{{website_name}}</strong>!</p>
                                <p>Your order has been successfully placed. Below is the delivery information for your order:</p>
                                <ul>
                                    <li><strong>Email:</strong> {{customer_email}}</li>
                                    <li><strong>Order ID:</strong> {{client_order_id}}</li>
                                    <li><strong>Amount:</strong> {{amount}}</li>
                                    <li><strong>Package:</strong> {{quantity}} - {{service_name}}</li>
                                    <li><strong>Track your order:</strong> <a href="{{track_order_link}}" target="_blank">{{track_order_link}}</a></li>
                                </ul>
                                <p>It has been a pleasure doing business with you. We wish you all the best with your order!</p>
                                <p>Thanks and Best Regards,<br/><strong>{{website_name}}</strong></p>
                            ',
                'available_merge_fields' => [
                    'customer_email' => 'Customer email',
                    'client_order_id' => 'Client Order id',
                    'service_name' => 'Service name',
                    'quantity' => 'Quantity',
                    'amount' => 'Amount',
                    'website_name' => 'Website name',
                    'track_order_link' => 'Track Order link',
                ],
            ],
           'new_order_notification_to_admin' => [
                'status' => 0,
                'template_name' => 'New Order Notification To Admin',
                'subject' => '{{website_name}} - New order successfully!',
                'content' => '<p>Hello Admin,</p>
                                <p>A new order has been placed successfully on <strong>{{website_name}}</strong>. Here are the details:</p>
                                <ul>
                                    <li><strong>Email:</strong> {{customer_email}}</li>
                                    <li><strong>Order ID:</strong> {{client_order_id}}</li>
                                    <li><strong>Amount:</strong> {{amount}}</li>
                                    <li><strong>Package:</strong> {{quantity}} - {{service_name}}</li>
                                </ul>
                                <p>Thank you for managing the orders!</p>
                                <p>Best Regards,<br/>{{website_name}}</p>
                            ',
                'available_merge_fields' => [
                    'customer_email'    => 'Customer email',
                    'client_order_id'   => 'Client Order id',
                    'service_name'      => 'Service name',
                    'quantity'          => 'Quantity',
                    'amount'            => 'Amount',
                    'website_name'      => 'Website name',
                ],
            ],
            'new_ticket_via_contact_form_to_admin' => [
                'status' => 0,
                'template_name' => 'New Ticket on Contact us form (Send to Admin)',
                'subject' => '{{website_name}} - New Ticket',
                'content' => '<p>Hello Admin,</p>
                                <p>A new ticket has been successfully submitted via the Contact Us form. Here are the details:</p>
                                <ul>
                                    <li><strong>Subject:</strong> {{subject}}</li>
                                    <li><strong>Customer email:</strong> {{customer_email}}</li>
                                    <li><strong>Ticket ID:</strong> {{ticket_id}}</li>
                                </ul>
                                <p>Thank you for your prompt attention to this matter!</p>
                                <p>
                                    Best Regards,
                                    <br/>{{website_name}}
                                </p>',
                'available_merge_fields' => [
                    'customer_email' => 'Customer email',
                    'subject'        => 'Subject',
                    'ticket_id'      => 'Ticket ID',
                    'website_name'   => 'Website name',
                ],
            ],
        ],

        'google_recaptcha' => [
            'status' => 0,
            'site_key'      => '',
            'secret_key'    => '',
            'options' => [
                'admin_login_form' => [
                    'status' => 0,
                    'name'  => 'Admin login form',
                ],
                'review_form'  => [
                    'status' => 0,
                    'name'  => 'Submit Review form',
                ],
                'track_order_form'  => [
                    'status' => 0,
                    'name'  => 'Track Order form',
                ],
                'contact_form'  => [
                    'status' => 0,
                    'name'  => 'Contact us form',
                ],
                'order_form'  => [
                    'status' => 0,
                    'name'  => 'Order form',
                ],
                'checkout_form' => [
                    'status' => 0,
                    'name'  => 'Checkout form',
                ],
            ],
        ],
    ];

    public $assets_plugin_paths = [
        'css' => [
            'charts_c3'             => 'assets/plugins/charts-c3/c3.css',
            'codemirror_lib'        => 'assets/plugins/codemirror/lib/codemirror.css',
            'codemirror_theme'      => 'assets/plugins/codemirror/theme/monokai.css',
            'tagsinput'             => 'assets/plugins/bootstrap-tagsinput/tagsinput.css',
            'flags'                 => 'assets/plugins/flags/css/flag-icon.css',
            'flags_docs'            => 'assets/plugins/flags/css/docs.css',
            'elfinder'              => 'assets/plugins/elFinder/css/elfinder.min.css',
            'jquery_ui'             => 'assets/plugins/jquery-ui/1.14/themes/smoothness/jquery-ui.css',
        ],
        'js' => [
            'jquery_ui'             => 'assets/plugins/jquery-ui/jquery-ui.min.js',
            'charts_d3_c3'          => 'assets/plugins/charts-c3/d3.v3.min.js',
            'charts_c3'             => 'assets/plugins/charts-c3/c3.min.js',
            'chart_int'             => 'assets/plugins/charts-c3/chart_template.js',
            'sortable'              => 'assets/admin/vendors/sortable/sortable.min.js',
            'manage_sections'       => 'assets/admin/js/manage_sections.js',
            'tinymce'               =>  'assets/plugins/tinymce/tinymce.min.js',
            'notify'                =>  'assets/plugins/notify/notify.min.js',
            'codemirror_lib'        =>  'assets/plugins/codemirror/lib/codemirror.js',
            'codemirror_theme'      =>  'assets/plugins/codemirror/mode/css/css.js',
            'tagsinput'             =>  'assets/plugins/bootstrap-tagsinput/tagsinput.js',
            'flags'                 =>  'assets/plugins/flags/js/docs.js',
            'datepicker'            =>  'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
            'elfinder'              =>  'assets/plugins/elFinder/js/elfinder.min.js?v=2.4.0',
        ],
    ];

    public $cronjobs = [
        'format' => 'curl -s %s >/dev/null 2>&1',
        'cron_key_length' => 10,
        'links' => [
            'order'     => 'order',
            'statuses'  => 'statuses',
        ],
    ];

    public $cache_keys = [
        'general_settings'      => 'cache_general_settings', 
        'client_header_menu'    => 'cache_client_header_menu', 
        'app_token'             => 'cache_app_token', 
        'app_plugins'           => 'cache_app_plugins', 
    ];
}
