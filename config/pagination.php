<?php
/**
 * File For: HopeTracker.com
 * File Name: pagination.php.
 * Author: Mike Giammattei
 * Created On: 5/26/2017, 5:31 PM
 */;
 include_once($_SERVER['DOCUMENT_ROOT'].'/'. RELATIVE_PATH . 'config/constants.php');

 include_once(CLASSES . 'Pagination.php');
 $Pagination = new Pagination();

 $function = $_POST['function'];

 switch ($function){
     case 'C To C Pagination' :
         $Pagination->update_c_to_c($_POST);
     break;

     default : echo 'No Good';
 }