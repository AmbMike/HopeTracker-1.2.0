<?php

/**
 * FileName: CommunityUpdate.php
 * Description:
 *
 * Created by: Ambrosia Digital Team.
 * Author: Michael Giammattei
 * Date: 7/15/2019
 */

namespace Profile;

class CommunityUpdate
{
    private $userId, $Database,$Session,$General;
    public $allPosts,$totalComments;

    public function __construct()
    {
        $this->Session = new \Sessions();
        $this->Database = new \Database();
        $this->General = new \General();
        $this->userId = $this->Session->get('user-id');
        $this->setAllPost();
        $this->setTotalJournalComments();
    }

    function setAllPost(){

        $excludeSessionPosts = '3,4,5,7,8,9';
        $sql = $this->Database->prepare("SELECT * FROM journal_entries WHERE user_id = ? AND visibility != 1 AND course_session NOT IN($excludeSessionPosts) ORDER BY id DESC ");

        $sql->execute(array($this->userId));

        if($sql->rowCount() > 0){
            $this->allPosts =  $sql->fetchAll();
            return true;
        }else{
            return false;
        }
    }
    public function getComments($postId){
        include_once(CLASSES . 'class.ForumAnswerComment.php');

        $ForumAnswerComment =  new \ForumAnswerComment();

        return $ForumAnswerComment->getAnswerComment($postId);
    }
    public function storeNewPost($data){
        $sql = $this->Database->prepare('INSERT INTO journal_entries (user_id, created_entry, content,course_session, visibility, ip) VALUES(?,?,?,?,?,?)');
        $sql->execute(array(
            $this->userId,
            time(),
            $data['textarea'],
            $data['courseSession'],
            2,
            $this->General->getUserIP()
        ));
        if($sql->rowCount() > 0){
            $returnValue['status'] = 'success';
            $returnValue['returnType'] = 'new post';
            $returnValue['date'] = strtoupper(date("M d", time()));
            $returnValue['postID'] = $this->Database->lastInsertId();
            $returnValue['textarea'] = $data['textarea'];


        }else{
            $returnValue['status'] = 'failed';
        }
        echo json_encode($returnValue);
    }
    public function updatePost($data){
        $sql = $this->Database->prepare('UPDATE journal_entries set content = ?, last_updated = ?, ip = ?,visibility = ? WHERE user_id  = ? AND id =?');
        $sql->execute(array(
            $data['textarea'],
            time(),
            $this->General->getUserIP(),
            2,
            $this->userId,
            $data['post_id']
        ));

        $returnValue['status'] = 'success';
        $returnValue['returnType'] = 'edited';
        echo json_encode($returnValue);

        $lastPostId = $this->Database->lastInsertId();
        /** Dump Post */
        $sql = $this->Database->prepare('INSERT INTO journal_entries_dump (user_id, created_entry, content,course_session, visibility, ip,post_type,post_id) VALUES(?,?,?,?,?,?,?,?)');
        $sql->execute(array(
            $this->userId,
            time(),
            $data['textarea'],
            $data['courseSession'],
            2,
            $this->General->getUserIP(),
            0,
            $lastPostId
        ));
    }
    public function setTotalJournalComments(){


        $sql = $this->Database->prepare('SELECT * FROM `unviewed_posts` WHERE post_type = ? AND notify_user_id = ?');
        $sql->execute(array(
            5,
            $this->userId
        ));

        $this->totalComments = $sql->rowCount();
    }
}