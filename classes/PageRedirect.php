<?php

/**
 * FileName: Redirect.php
 * Description:
 *
 * Created by: Ambrosia Digital Team.
 * Author: Michael Giammattei
 * Date: 5/1/2019
 */

require_once(CLASSES . 'General.php');

class PageRedirect
{

    private $postID = null;
    private $General = null;

    public function __construct(){
        $this->General = new General();
    }

    public function forumIdV1(){
        $returnValue = null;

        /** The forum ID*/
        $this->postID = $_GET['forum_id'];

        require(CLASSES . 'class.SingleQuestion.php');
        $SingleQuestion = new SingleQuestion( $this->postID);

        /** The forum url identifier */
        $postSubcatUrlValue = $SingleQuestion->pageIdentifier;



        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ".BASE_URL."/forum/" . $postSubcatUrlValue);
        exit();
    }
}