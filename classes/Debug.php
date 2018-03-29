<?php

/**
 * File For: HopeTracker.com
 * File Name: Debug.php.
 * Author: Mike Giammattei
 * Created On: 3/24/2017, 2:38 PM
 */
include_once($_SERVER['DOCUMENT_ROOT'] . '/hopetracker/config/constants.php');
class Debug{
    public static function to_file($data,$file){
        file_put_contents(ABSOLUTE_PATH_NO_END_SLASH.'/'.$file, print_r($data, true));
    }
    public static function data($data){
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
    public static function out($data){
	    global $DEBUGOUT;
	    $DEBUGOUT = $data;
	    return $data;
    }
    public static function clearCourseIntro(){
	    include_once( CLASSES . 'Database.php' );
	    include_once( CLASSES . 'Sessions.php' );
	    $db = new Database();
	    $Sessions = new Sessions();

	    $sql = $db->prepare("DELETE FROM intro_log WHERE user_id = ?");
	    $sql->execute(array($Sessions->get('user-id')));
	    $Sessions->delete('viewed_course');

	    if($sql->rowCount() > 0){
	    	return true;
	    }
    }

}