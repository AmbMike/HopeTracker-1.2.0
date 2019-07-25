<?php

/**
 * FileName: NewComments.php
 * Description:
 *
 * Created by: Ambrosia Digital Team.
 * Author: Michael Giammattei
 * Date: 7/22/2019
 */

namespace Profile;
error_reporting(3);

class NewComments
{

    private $userId, $Database,$Session,$General;

    public function __construct(){
        $this->Session = new \Sessions();
        $this->Database = new \Database();
        $this->General = new \General();
        $this->userId = $this->Session->get('user-id');
    }
    public function removeFromNewList($post_id){

        $sql = $this->Database->prepare('DELETE FROM `unviewed_posts` WHERE id = ? AND post_Type = ? AND notify_user_id = ?');
        $sql->execute(array(
            (int)$post_id,
            5,
            (int)$this->userId
        ));
        $returnValue = array();

        if($sql->rowCount() > 0){
            $returnValue['status'] = 'Success';
        }else{
            $returnValue['status'] = 'False';
        }
        return $returnValue['status'];
    }
    public function checkIfNotViewed($commentID){
        $sql = $this->Database->prepare('SELECT `id` FROM `unviewed_posts` WHERE post_id = ? AND post_Type =? AND notify_user_id=?');
        $sql->execute(array(
            $commentID,
            5,
            $this->userId
        ));

        $postData = $sql->fetch();
        $returnValue = array();
        if($sql->rowCount() > 0){
            $returnValue['status'] = true;
            $returnValue['post_id'] = $postData['id'];
        }
        return  $returnValue;
    }
    public function hasComment($postID){
        $sql = $this->Database->prepare('SELECT id FROM `journal_comments` WHERE `journal_id` = ?');
        $sql->execute(array($postID));

        if($sql->rowCount() > 0){
            return true;
        }
    }
}