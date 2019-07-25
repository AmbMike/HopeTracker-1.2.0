<?php

/**
 * FileName: ProfileForm.php
 * Description:
 *
 * Created by: Ambrosia Digital Team.
 * Author: Michael Giammattei
 * Date: 7/12/2019
 */

class ProfileForm
{
    private $userId, $Database,$Session,$courseSession,$General;

    public function __construct($courseSession)
    {
        $this->Session = new Sessions();
        $this->Database = new Database();
        $this->General = new General();
        $this->userId = $this->Session->get('user-id');
        $this->courseSession = $courseSession;

    }

    public function getSessionFormData(){
        $sql = $this->Database->prepare('SELECT * FROM journal_entries WHERE user_id = ? AND course_session = ?');
      // $sql->setFetchMode(PDO::FETCH_COLUMN);
        $sql->execute(array(
            $this->userId,
            $this->courseSession
        ));

        return $sql->fetchAll();
    }
    public function setSession1($data){
        $returnValue = array();

        /** @var  $visibility - post to community */
        $visibility = $data['visibility'];

        $isPostArr = $this->getSessionFormData();


        if(empty($isPostArr)){

            $sql = $this->Database->prepare('INSERT INTO journal_entries (user_id, created_entry, content,course_session, visibility, ip) VALUES(?,?,?,?,?,?)');
            $sql->execute(array(
                $this->userId,
                time(),
                $data['textarea'],
                $data['courseSession'],
                $visibility,
                $this->General->getUserIP()
            ));
        }else{
            $sql = $this->Database->prepare('UPDATE journal_entries set content = ?, last_updated = ?, ip = ?,visibility = ? WHERE user_id = ? AND course_session = ?');
            $sql->execute(array(
                $data['textarea'],
                time(),
                $this->General->getUserIP(),
                $data['visibility'],
                $this->userId,
                $data['courseSession']
            ));
        }

        $lastPostId = $this->Database->lastInsertId();

        if($sql->rowCount() > 0){
            $returnValue['status'] = 'success';
            $returnValue['postID'] = $lastPostId;

        }else{
            $returnValue['status'] = 'failed';
        }
        echo json_encode($returnValue);

        /** Dump Post */
        $sql = $this->Database->prepare('INSERT INTO journal_entries_dump (user_id, created_entry, content,course_session, visibility, ip,post_type,post_id) VALUES(?,?,?,?,?,?,?,?)');
        $sql->execute(array(
            $this->userId,
            time(),
            $data['textarea'],
            $data['courseSession'],
            $visibility,
            $this->General->getUserIP(),
            2,
            $lastPostId
        ));
    }
}