<?php

/**
 * File For: HopeTracker.com
 * File Name: Comments.php.
 * Author: Mike Giammattei
 * Created On: 5/10/2017, 4:23 PM
 */
include_once(CLASSES .'Pagination.php');
class Comments extends Database {

    public function like_comment($data){
        $General = new General();
        $db = new parent();
        $Session = new Sessions();

        /* Check if user is logged in */
        if($Session->check('user-id') == true):
            $user_id =  $Session->get('user-id');
            /* Check if liked or un-liked */
            if ($data['like_status'] == 'liked'){
                $sql = $db->prepare('INSERT INTO `liked_comments` (liked_entry_id, comment_liked_id, comment_owner_id, likers_id, create_on, ip) VALUES (?,?,?,?,?,?)');
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute(array(
                    $data['parent_post_id'],
                    $data['comment_id'],
                    $data['comment_owner_id'],
                    $user_id,
                    time(),
                    $General->getUserIP()
                ));
            } else{
                $sql = $db->prepare('DELETE FROM `liked_comments` WHERE  liked_entry_id = ? AND comment_liked_id = ? AND likers_id = ?');
                $sql->execute(array(
                    $data['parent_post_id'],
                    $data['comment_id'],
                    $Session->get('user-id'),
                ));
            }

            if($sql->rowCount() > 0){
                echo "Success";
            }else{
                echo "Failed";
            }

        else:
            echo 'Not Logged In';
        endif;
    }
    public function check_if_comments_liked($comment_owners_id,$parent_post_id,$comment_liked_id){
        $db = new parent();
        $Session = new Sessions();

        if($Session->check('user-id') == true):
            $user_id = $Session->get('user-id');
            $sql = $db->prepare("SELECT `id` FROM `liked_comments` WHERE `likers_id` = ? AND `comment_owner_id` = ? AND `liked_entry_id` = ? AND comment_liked_id = ?");
            $sql->execute(array($user_id,$comment_owners_id,$parent_post_id,$comment_liked_id));

            if($sql->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        else: return false;
        endif;
    }
    public function comment_of_comment($data){
        $db = new parent();
        $Session = new Sessions();
        $General = new General();

        $sql = $db->prepare("INSERT INTO `comment_to_comment` (parent_comment_post_id, parent_comment_id,parent_comment_user_id, child_comment_user_id, comment, create_date, ip) VALUES(?,?,?,?,?,?,?)");
        $sql->execute(array(
            $data['journal_id'],
            $data['optional_data']['parent_comment_id'],
            $data['optional_data']['parent_comment_user_id'],
            $Session->get('user-id'),
            $data['comment'],
            time(),
            $General->getUserIP()
        ));
        if($sql->rowCount() > 0){
            echo 'Success';
        }else{
            echo 'Failed';
        }
    }
    public function count_comment_of_comment($parent_comment_id){
        $db = new parent();
        $sql = $db->prepare("SELECT id FROM comment_to_comment WHERE parent_comment_id = ?");
        $sql->execute(array($parent_comment_id));
        return $sql->rowCount();
    }
    public function c_to_c_pagination_btns($parent_comment_id,$per_page){
        $Pagination = new Pagination();

        return $Pagination->btn_qty($this->count_comment_of_comment($parent_comment_id),$per_page);
    }
    public function show_comment_of_comment($parent_post_id,$parent_comment_id,$parent_comment_user_id,$start_num = 0, $per_page = 5, $get_page_btn_qty = true,$include_profile_img = false){
        $db = new parent();
        $data_out = array();

        if($include_profile_img == false) :
            $sql = $db->prepare("SELECT * FROM `comment_to_comment` WHERE parent_comment_post_id = :post_id AND parent_comment_id = :comment_id AND parent_comment_user_id = :parent_comment_user_id ORDER BY id DESC LIMIT :start_num, :end_num;");
        else:
            $sql = $db->prepare("SELECT comment_to_comment.*,user_list.profile_img,user_list.fname FROM `comment_to_comment` LEFT JOIN user_list ON comment_to_comment.child_comment_user_id = user_list.id WHERE parent_comment_post_id = :post_id AND parent_comment_id = :comment_id AND parent_comment_user_id = :parent_comment_user_id ORDER BY id DESC LIMIT :start_num, :end_num;");
        endif;
        //$sql = $db->prepare("SELECT * FROM `comment_to_comment` WHERE parent_comment_post_id = :post_id AND parent_comment_id = :comment_id AND parent_comment_user_id = :parent_comment_user_id ORDER BY id DESC LIMIT :start_num, :end_num;");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
            $sql->bindValue(':post_id', $parent_post_id,PDO::PARAM_INT);
            $sql->bindValue(':comment_id', $parent_comment_id,PDO::PARAM_INT);
            $sql->bindValue(':parent_comment_user_id', $parent_comment_user_id, PDO::PARAM_INT);
            $sql->bindValue(':start_num', $start_num, PDO::PARAM_INT);
            $sql->bindValue(':end_num', $per_page, PDO::PARAM_INT);
        $sql->execute();

        $data_out['comments'] = $sql->fetchAll();

        /* Generate the number of pagination btns to serve */
        if($get_page_btn_qty != false){
            $data_out['page_btn_qty'] = $this->c_to_c_pagination_btns($parent_comment_id,$per_page);
        }
        return $data_out;



    }

}