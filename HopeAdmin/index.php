<?php
/**
 * File For: HopeTracker.com
 * File Name: HopeAdmin/index.php.
 * Author: Mike Giammattei
 * Created On: 5/16/2017, 11:15 AM
 */
session_start();
define('ABSPATH', $_SERVER['DOCUMENT_ROOT'] . '/hopetracker/');

define('VIEWS', ABSPATH.'HopeAdmin/'.'site/public/views/');
define('WIDGETS', VIEWS . '/widgets/');

/* Config Root */
include_once(ABSPATH.'config/constants.php');
//echo $user->is_logged_in();
include_once(CLASSES .'General.php');
include_once(CLASSES .'URL.php');
include_once(CLASSES .'Page.php');
include_once(CLASSES .'Sessions.php');
include_once(CLASSES .'Admin.php');
include_once(CLASSES .'Parts.php');

$page_checks = new \Page_Attr\Checks();
$Sessions = new Sessions();
$general = new General();
$Admin = new Admin();
$url = new URL();
$Parts = new Parts();

error_reporting(0);

/* Check if user has admin privileges */
if($Sessions->get('logged_in') == 1 && $Admin->user_role($Sessions->get('user-id')) == 1){
    $p_url = ($_GET['page_url']) ? : 'index';
}else{
    $p_url = ($_GET['page_url']) ? : 'login';
}
/* Check if widget page exists*/
if($Parts->widget_exists() == 'Not Found'){
    $p_url = '404';
}

/* IMPORTANT - Keep Last Redirect User to Login if Not Logged In */
if($Sessions->get('logged_in') == 0){
    $p_url = 'login';
}

if(!file_exists(VIEWS . $p_url . '.php')){
    header("HTTP/1.0 404 Not Found");
    include(VIEWS .'header.php');
    include(VIEWS . '404.php');
    include_once(VIEWS . 'footer.php');
    echo $p_url;
}else{
    include(VIEWS .'header.php');
    include(VIEWS . $p_url.'.php');
    include_once(VIEWS . 'footer.php');
}

Debug::data($_SESSION);
