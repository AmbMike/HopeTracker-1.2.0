<?php

/**
 * File For: HopeTracker.com
 * File Name: Sessions.php.
 * Author: Mike Giammattei
 * Created On: 3/22/2017, 11:50 AM
 */
if(session_id() == '') {
    session_start();
}
class Sessions{

    public function set($name,$value){
        $_SESSION[$name] = $value;
    }
    public function get($name){
    	if(isset($_SESSION[$name])){
		    return $_SESSION[$name];
	    }else{
    		return '';
	    }

    }
    public  function delete($name){
        unset($_SESSION[$name]);
    }
    public function check($name){
        return (isset($_SESSION[$name])) ? true : false;
    }
    public function setViewedPost($postId,$userId,$postType){
        /** Build Viewed Post Session  */
        $viewedPost = '';

        /** Starting syntax */
        $viewedPost .= 'viewed-post-';

        /** Append the post id. */
        $viewedPost .= $postId;

        /** Append the user's id. */
        $viewedPost .= $userId;

        /** Append the post type. */
        $viewedPost .= $postType;

        $_SESSION[$viewedPost] = true;
    }
    public function checkViewedPost($postId,$userId,$postType){
        /** Build Viewed Post Session  */
        $viewedPost = '';

        /** Starting syntax */
        $viewedPost .= 'viewed-post-';

        /** Append the post id. */
        $viewedPost .= $postId;

        /** Append the user's id. */
        $viewedPost .= $userId;

        /** Append the post type. */
        $viewedPost .= $postType;

        return $this->check($viewedPost);
    }
}