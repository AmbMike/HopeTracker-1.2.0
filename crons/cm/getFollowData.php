<?php

if (!defined('ABSPATH')) {
    define('ABSPATH', $_SERVER['DOCUMENT_ROOT'] . '/hopetracker/');
}
require_once(ABSPATH . 'config/constants.php');
require_once(ABSPATH . 'classes/GetData/FollowData.php');
require_once ABSPATH . 'campaign-monitor-api/csrest_campaigns.php';
require_once ABSPATH . 'campaign-monitor-api/csrest_general.php';
require_once ABSPATH . 'campaign-monitor-api/csrest_clients.php';
require_once ABSPATH . 'campaign-monitor-api/csrest_subscribers.php';
require_once(CLASSES . 'User.php');
require_once(CLASSES . 'General.php');

$User = new User();
$General = new General();
$FollowData = new FollowData();
$AuthorFollowArr =  $FollowData->build();


//Debug::data( $AuthorQuestionArr );


