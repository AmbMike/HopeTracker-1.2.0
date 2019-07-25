<?php

/**
 * FileName: Boundaries.php
 * Description:
 *
 * Created by: Ambrosia Digital Team.
 * Author: Michael Giammattei
 * Date: 7/22/2019
 */

namespace Profile;


class Grateful
{
    private $userId, $Database,$Session,$General;
    public $thePost,$hasPost,$postContentObj;

    public function __construct()
    {
        $this->Session = new \Sessions();
        $this->General = new \General();
        $this->userId = $this->Session->get('user-id');
        $this->hasPost =  $this->thePost();
    }


    private function thePost(){
        $this->Database = new \Database();
        $sql = $this->Database->prepare('SELECT * FROM journal_entries  WHERE user_id = ? AND course_session = 8');
        $sql->execute(array(
            $this->userId
        ));

        if($sql->rowCount() > 0){
            $this->thePost = $sql->fetch();
            $this->postContentObj = json_decode($this->thePost['content_object']);
            return true;
        }
        else{
            return false;
        }
    }
    public function storePost($data){
        $contentObj =  json_encode($data['content']);
        $contentStr =  implode('<br><br>',$data['content']);

        $this->Database = new \Database();

        if($this->hasPost):
            $sql = $this->Database->prepare('UPDATE journal_entries SET user_id = ?,title = ?, created_entry = ?,content = ?, content_object = ?, course_session = ?,visibility = ?, ip =?  WHERE  id = ?');
            $sql->execute(array(
                $this->userId,
                $data['content']['sesOneEight12'],
                time(),
                $contentStr,
                $contentObj,
                $data['courseSession'],
                2,
                $this->General->getUserIP(),
                $data['post_id']
            ));
            if($sql->rowCount() > 0){
                $returnValue['status'] = 'success';
                $returnValue['returnType'] = 'edited';
                $returnValue['postID'] = $this->Database->lastInsertId();

            }else{
                $returnValue['status'] = 'failed';
            }
        else:
            $sql = $this->Database->prepare('INSERT INTO journal_entries (user_id, title,created_entry, content,content_object,course_session, visibility, ip) VALUES(?,?,?,?,?,?,?,?)');
            $sql->execute(array(
                $this->userId,
                $data['content']['sesOneEight12'],
                time(),
                $contentStr,
                $contentObj,
                $data['courseSession'],
                2,
                $this->General->getUserIP()
            ));
            if($sql->rowCount() > 0){
                $returnValue['status'] = 'success';
                $returnValue['returnType'] = 'edited';
                $returnValue['postID'] = $this->Database->lastInsertId();

            }else{
                $returnValue['status'] = 'failed';
            }
        endif;


        echo json_encode($returnValue);
    }


}