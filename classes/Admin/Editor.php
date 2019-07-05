<?php

/**
 * FileName: Editor.php
 * Description:
 *
 * Created by: Ambrosia Digital Team.
 * Author: Michael Giammattei
 * Date: 6/28/2019
 */

namespace Admin;

include_once($_SERVER['DOCUMENT_ROOT'].'/hopetracker/config/constants.php');
require_once( CLASSES . 'Database.php' );
require_once( CLASSES . 'Sessions.php' );
require_once( CLASSES . 'class.Post.php' );


class Editor
{

    private $Session;
    private $AdminEditor;
    public function __construct(){
        $this->Session = new \Sessions();
    }
    private function trackChange($DB,$data,$org_data){
        $sql = $DB->prepare("INSERT INTO `editor_tracker`  (`user_id`, `date_changed`, `ip`, `post_id`, `postType`, `org_question`, `org_description`, `new_question`, `new_description`) VALUES (?,?,?,?,?,?,?,?,?)");

        $sql->execute(array(
            $this->Session->get('user-id'),
            time(),
            $_SERVER['REMOTE_ADDR'],
            $data['postID'],
            $data['postType'],
            $org_data['question'],
            $org_data['description'],
            $data['question'],
            $data['description'],
        ));

        if($sql->rowCount() > 0){
            return true;
        }
    }
    public function saveChange($data){
        $DB = new \Database();

        $sql = $DB->prepare("SELECT `question`,`description` FROM `ask_question_forum` WHERE id = ? AND post_type = ? ");
        $sql->execute(array(
            $data['postID'],
            $data['postType']
        ));

        $org_question = $sql->fetchAll();

        if($this->trackChange($DB,$data,$org_question[0])){
            $sql = $DB->prepare('UPDATE ask_question_forum SET question=?, description=? WHERE id = ?');

            $sql->execute(array(
                $data['question'],
                $data['description'],
                $data['postID']
            ));

            $returnArr = array();
            if($sql->rowCount() > 0){
                $returnArr['status'] = 'success';

            }else{
                $returnArr['status'] = 'failed';
            }

        }else{
            $returnArr['status'] = 'failed';
            $returnArr['detail'] = 'did not save to tracking';
        }


        echo json_encode($returnArr);
    }
    private function notification($postID,$postType,$show){

        $html = '<div class="alert alert-info i-admin-tools" style="margin-top: 10px;">
                  <strong>Editor\'s Options:</strong>
                  <a style="margin: 0;" href="/'.RELATIVE_PATH.'admin/post-editor/?post_id='.$postID .'&post_type='.$postType.'">Edit Question</a>
              </div>';

        if($show){
            return $html;
        }
        return null;
    }
    public function postEditor($postID,$postType,$showEditorTools){

        if($this->Session->get('logged_in')){

            if(\User::user_info('editor')){
                return $this->notification($postID,$postType,$showEditorTools);
            }

        }

    }
}