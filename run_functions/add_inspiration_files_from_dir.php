<?php
/**
 * File For: HopeTracker.com
 * File Name: add_inspiration_files_from_dir.php.
 * Author: Mike Giammattei
 * Created On: 7/20/2017, 4:41 PM
 */;

include_once($_SERVER['DOCUMENT_ROOT'].'/config/constants.php');
include_once(CLASSES.'Forms.php');
include_once(CLASSES.'User.php');
include_once(CLASSES.'Journal.php');
include_once(CLASSES.'Comments.php');
include_once(CLASSES.'Forum.php');
include_once(CLASSES.'Chat.php');
include_once(CLASSES.'Emails.php');
include_once(CLASSES.'A_Form.php'); // Admin Class
include_once(CLASSES.'Sortable.php'); // Admin Class
include_once (CLASSES. 'Inspiration.php');

$Inspiration = new Inspiration();

$Inspiration->put_images_into_database();