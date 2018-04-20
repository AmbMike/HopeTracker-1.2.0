<?php
/**
 * File For: HopeTracker.com
 * File Name: index.php.
 * Author: Mike Giammattei
 * Created On: 3/10/2017, 11:15 AM
 */
session_start();

define('ABSPATH', dirname(__FILE__));
/* Config Root */
include_once(ABSPATH.'/config/constants.php');
//echo $user->is_logged_in();
include_once(CLASSES .'General.php');
include_once(CLASSES .'URL.php');
include_once(CLASSES .'Page.php');
include_once(CLASSES .'Sessions.php');
include_once(CLASSES .'Admin.php');
include_once(CLASSES . 'class.Redirects.php');
date_default_timezone_set('America/New_York');


$page_checks = new \Page_Attr\Checks();
$Sessions = new Sessions();
$general = new General();
$Admin = new Admin();
$url = new URL();

/* Page Engine */
$p_url = (isset($_GET['page_url'])) ? $_GET['page_url'] : 'home';

/* check if is a user for journal page */
if(isset($_GET['user_id']) && $page_checks->is_a_user() === false){
    $p_url = '404';
}

/** Unset "back to ambrosia" session  */
if(isset($_COOKIE['fromHopeTracker'])){
	unset( $_COOKIE['fromHopeTracker'] );
}
/**  General Redirects */
$Redirects = new Redirects($p_url);
/** Check if page specific parameters exists */
$p_url = URL::isPage();

/* Check if url points to restricted page. URL CLASS */
$p_url = URL::restricted_url($p_url);

if(isset($_GET['chat_mod'])){
    $p_url = 'chat-mods/' . $p_url;
}

if(!file_exists(VIEWS . $p_url . '.php') || $p_url == '404'){
    header("HTTP/1.0 404 Not Found");
    include_once(CLASSES .'Page.php');
    include(VIEWS . '404.php');
    include_once(VIEWS . 'footer.php');
}else{
    $session = new Sessions();
    include_once(CLASSES .'FAQ.php');
    include_once(CLASSES .'Page.php');
    include(VIEWS . $p_url.'.php');
    include_once(VIEWS . 'footer.php');
}
/** Debug Panel */
if(ENV == 'live' || ENV == 'dev'){
	if($_SESSION['logged_in'] == 1  ){
		if(User::user_info('role',$Sessions->get('user-id')) == 1){
			include_once($_SERVER['DOCUMENT_ROOT'] . '/hopetracker/mg-error-panel/index.php');
		}
	}
}
if(isset($_GET['show_sessions'])){
    Debug::data($_SESSION);
}

