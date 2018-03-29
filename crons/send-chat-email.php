<?php
/**
 * File For: HopeTracker.com
 * File Name: send-chat-email.php.
 * Author: Mike Giammattei
 * Created On: 7/14/2017, 1:58 PM
 */;

include_once($_SERVER['DOCUMENT_ROOT'].'/config/constants.php');
include_once(CLASSES.'Emails.php');

$Emails = new Emails();

$Emails->send_chat_emails();