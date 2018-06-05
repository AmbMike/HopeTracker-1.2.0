<?php
/**
 * File For: HopeTracker.com
 * File Name: constants.php.
 * Author: Mike Giammattei
 * Created On: 3/10/2017, 10:48 AM
 */


/* Set application mode */
$Application_Mode = 'dev';

//$Application_Mode = 'live footer';

define('ENV',$Application_Mode);

if(ENV == 'dev'){
    define('SRC_PATH','cwd');

    error_reporting(3);
    /* Database */
    define('DB_TYPE','mysql');
    define('DB_NAME','hopetrac_main');
    define('DB_HOST','localhost');
    define('DB_USER','root');
    define('DB_PASS','');

}else{
    /* Database */

    define('SRC_PATH','public');

    define('DB_TYPE','mysql');
    define('SRC_PATH','cwd');
    define('DB_NAME','hopetrac_main');
    define('DB_HOST','localhost');
    define('DB_USER','hopetrac_main');
    define('DB_PASS','%gw)(rA5qL(r');
}

/* if file does not include index.php */
if (!defined('ABSPATH')) {
    define('ABSPATH',  dirname(dirname(__FILE__)));
}
define('root_slash','/');

/* File extension displayed in site url */
define('FILE_EXTENSION', 'ambrosia');
define('HOME_URL', '/home');

/* Domain */
define('DOMAIN', 'hopetracker.com/hopetracker');

/* URLs */
define('BASE_URL', 'http://hopetracker.com/hopetracker');

/* Information */
define('MAIN_PHONE','8884924199');

/* Email */
define('REPLY_EMAIL','reply@' . DOMAIN);
define('EMAIL_SENDER','mail@' . DOMAIN);

/** Root to relative path. */
define('RELATIVE_PATH','hopetracker/');
define('RELATIVE_PATH_NO_END_SLASH','hopetracker');
define('ABSOLUTE_PATH_NO_END_SLASH', $_SERVER['DOCUMENT_ROOT'] . '/hopetracker');
define('ABSOLUTE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/hopetracker/');

/* General Paths */
define('CONFIG', ABSPATH .  root_slash . 'config/');
define('CLASSES', ABSPATH .  root_slash . 'classes/');
define('VIEWS', ABSPATH .  root_slash . 'site/'.SRC_PATH.'/views/');
define('FORMS', ABSPATH .  root_slash . 'site/'.SRC_PATH.'/views/forms/');
define('HEADERS', ABSPATH .  root_slash . 'site/'.SRC_PATH.'/views/headers/');
define('CSS', BASE_URL .  root_slash . 'site/public/css/');
define('IMAGES',  root_slash . RELATIVE_PATH .  'site/public/images/');
define('IMAGES_NO_LEADING_SLASH', RELATIVE_PATH .  'site/public/images/');
define('MAIN_JS',  root_slash . 'site/public/js/main.js');
define('JS',  root_slash . RELATIVE_PATH .  'site/'.SRC_PATH.'/js/');
define('ARRAYS', ABSPATH .  root_slash . 'arrays/');
define('SIDEBAR', ABSPATH .  root_slash . 'site/'.SRC_PATH.'/views/includes/sidebar/index.php');
define('MODALS', ABSPATH .  root_slash . 'site/'.SRC_PATH.'/views/includes/modals/');
define('SIDEBAR_PATH', ABSPATH .  root_slash . 'site/'.SRC_PATH.'/views/includes/sidebar/');
define('USERS', ABSPATH .  root_slash . 'users');
define('LIBS', ABSPATH .  root_slash . 'libs/');
define('TINYMCE',  root_slash . RELATIVE_PATH . 'mod/tinymce/tinymce.min.js');
define('CROPPIC',  root_slash . RELATIVE_PATH . 'mod/croppic/croppic.js');
define('ADMIN',  root_slash . 'HopeAdmin/');
define('QUOTE_SLIDES', root_slash .  IMAGES . 'quotes/');
define('OG_IMAGES', root_slash . 'site/public/images/og-images/');

/* Default Profile Image */
define('DEFAULT_PROFILE_IMG', 'site/public/images/main/icon.jpg');

/* Main Includes File */
include_once (CONFIG  . 'includes.php');

function is_session_started()
{
    if ( php_sapi_name() !== 'cli' ) {
        if ( version_compare(phpversion(), '5.4.0', '>=') ) {
            return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
        } else {
            return session_id() === '' ? FALSE : TRUE;
        }
    }
    return FALSE;
}

