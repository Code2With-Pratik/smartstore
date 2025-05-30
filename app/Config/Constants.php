<?php

/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 |
 | This defines the default Namespace that is used throughout
 | CodeIgniter to refer to the Application directory. Change
 | this constant to change the namespace that all application
 | classes should use.
 |
 | NOTE: changing this will require manually modifying the
 | existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2_592_000);
defined('YEAR')   || define('YEAR', 31_536_000);
defined('DECADE') || define('DECADE', 315_360_000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
 |
 | Used to indicate the conditions under which the script is exit()ing.
 | While there is no universal standard for error codes, there are some
 | broad conventions.  Three such conventions are mentioned below, for
 | those who wish to make use of them.  The CodeIgniter defaults were
 | chosen for the least overlap with these conventions, while still
 | leaving room for others to be defined in future versions and user
 | applications.
 |
 | The three main conventions used for determining exit status codes
 | are as follows:
 |
 |    Standard C/C++ Library (stdlibc):
 |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
 |       (This link also contains other GNU-specific conventions)
 |    BSD sysexits.h:
 |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
 |    Bash scripting:
 |       http://tldp.org/LDP/abs/html/exitcodes.html
 |
 */
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0);        // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1);          // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3);         // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4);   // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5);  // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7);     // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8);       // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9);      // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125);    // highest automatically-assigned error code

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_LOW instead.
 */
define('EVENT_PRIORITY_LOW', 200);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_NORMAL instead.
 */
define('EVENT_PRIORITY_NORMAL', 100);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_HIGH instead.
 */
define('EVENT_PRIORITY_HIGH', 10);


// ADDED
$base_url = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1)) || 
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' 
            ? "https" : "http";
$base_url .= "://" . $_SERVER['HTTP_HOST'];
$base_url .= rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/';
define('BASE_URL', $base_url);


// Table
define("TB_CATEGORIES", "categories");
define("TB_CATEGORIES_LANG", "categories_lang");

define("TB_SOCIAL_NETWORK_CATEGORIES", "social_network_categories");
define("TB_API_PROVIDERS", "api_providers");

define("TB_SERVICES", "services");
define("TB_ORDERS", "orders");
define("TB_TICKETS", "tickets");
define("TB_TICKET_MESSAGES", "ticket_messages");

// general
define("TB_OPTIONS", "options");
define("TB_MENU", "menu");
define("TB_PAYMENTS_METHOD", "payments_method");
define("TB_FAQS", "faqs");
define("TB_FILE_MANAGER", "file_manager");
define("TB_NEWS", "news");
define("TB_TRANSACTION_LOGS", "transactions");
define("TB_PURCHASE", "purchase");
define("TB_LANGUAGE", "languages");
define("TB_LANGUAGE_LIST", "languages_list");
define("TB_USERS", "users");
define("TB_SUBSCRIBERS", "subscribers");
define("TB_STAFFS", "staffs");
define("TB_EMAIL_TEMPLATES", "email_templates");

// BLogs
define("TB_BLOG_CATEGORIES", "blog_categories");
define("TB_BLOG_POSTS", "blog_posts");
define("TB_BLOG_POSTS_LANG", "blog_posts_lang");

// Reviews
define("TB_REVIEWS", "reviews");
define("TB_COUPONS", "coupons");

// Blacklist
define("TB_BLACKLIST_IP", "blacklist_ip");
define("TB_BLACKLIST_LINK", "blacklist_link");
define("TB_BLACKLIST_EMAIL", "blacklist_email");

// Manage Pages
define("TB_PAGES", "pages");
define("TB_PAGES_LANG", "pages_lang");

// Time
define("NOW", date("Y-m-d H:i:s"));
define("APP_LANG_CODE", 'en');

// Demo
define("APP_IS_DEMO", FALSE);


// PHPass
define("PHPASS_HASH_STRENGTH", 8);
define('PHPASS_HASH_PORTABLE', FALSE);


// transaction status
define('TNX_STATUS_CANCELLED', 'cancelled'); 
define('TNX_STATUS_ERROR', 'error'); 
define('TNX_STATUS_PENDING', 'pending'); 
define('TNX_STATUS_PAID', 'paid');


// CACH_KEY
defined('CACHE_GENERAL_SETTINGS_KEY') or define('CACHE_GENERAL_SETTINGS_KEY', 'general_settings');