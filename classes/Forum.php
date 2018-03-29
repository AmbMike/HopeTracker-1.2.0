<?php

/**
 * File For: HopeTracker.com
 * File Name: Forum.php.
 * Author: Mike Giammattei
 * Created On: 5/18/2017, 3:43 PM
 */
include_once(CLASSES . 'Admin.php');
class Forum{

    public function get_row_count(){
        $db = new Database();
        $sql = $db->prepare('SELECT COUNT(*) FROM `forum_categories` ');
        $sql->execute();
        return $sql->fetchColumn();
    }
    public function forum_sub_categories(){
        $db = new Database();
        $sql = $db->prepare('SELECT COUNT(*) FROM `forum_sub_categories` ');
        $sql->execute();
        return $sql->fetchColumn();
    }
    public function category_exists($category){
        $db = new Database();
        $sql = $db->prepare("SELECT id FROM `forum_categories` WHERE category = ?");
        $sql->execute(array($category));

        if($sql->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }
    public function add_categories($data){
        $response = array();
        $db = new Database();
        $Session = new Sessions();
        $General = new General();

        if($this->category_exists($data['category']) == false){

            $sql = $db->prepare("INSERT INTO `forum_categories` (category, created_data, ip, user_created_id,moderator_id) VALUES (?,?,?,?,?)");
            $sql->execute(array(
                urldecode($data['category']),
                time(),
                $General->getUserIP(),
                $Session->get('user-id'),
                urldecode($data['moderator'])
            ));

            /* Update variables */
            $last_id = $db->lastInsertId();
            $num_rows = $this->get_row_count();


            $sql = $db->prepare('UPDATE `forum_categories` SET `position` = ? WHERE id = ?');
            $sql->execute(array($num_rows,$last_id));

            if($sql->rowCount() > 0){
                $response['result'] = 'Successful';
            }else{
                $response['result'] = 'Failed';
            }
        }else{
            $response['result'] = 'Failed';
            $response['error'] = 'The category you entered already exists';
        }
        echo json_encode($response);
    }
    public function get_category_list(){
        $db = new Database();

        $sql = $db->prepare("SELECT * FROM `forum_categories` ORDER BY `position`");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();
        return $sql->fetchAll();
    }
    public function delete_category($id){
        $response = array();
        $db = new Database();

        $sql = $db->prepare("DELETE FROM `forum_categories` WHERE id = ?");
        $sql->execute(array($id));

        if($sql->rowCount() > 0){
            $response['result'] = "Success";
        }else{
            $response['result'] = "Failed";
        }
    }
    public function subcategory_exists($category,$parent_category_id){
        $db = new Database();

        $sql = $db->prepare("SELECT id FROM `forum_sub_categories` WHERE sub_category = ? AND parent_category_id = ?");
        $sql->execute(array($category,$parent_category_id));

        if($sql->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }
    public function get_sub_category_forum($id){
        $db = new Database();
        $sql = $db->prepare("SELECT * FROM `forum_sub_categories` WHERE id = ? LIMIT 1");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($id));
        return $sql->fetchAll()[0];
    }
    public function get_parent_category($category_id){
        $db = new Database();
        $sql = $db->prepare("SELECT category FROM `forum_categories` WHERE id = ? LIMIT 1");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($category_id));
        return $sql->fetchColumn();
    }
    public function get_category($id, $moderator_id = false){
        $db = new Database();

        if($moderator_id == false){
            $sql = $db->prepare("SELECT category FROM `forum_categories` WHERE id = ?");
        }else{
            $sql = $db->prepare("SELECT moderator_id FROM `forum_categories` WHERE id = ?");
        }
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($id));
        return $sql->fetchColumn();
    }
    public function get_category_id($category){
        $db = new Database();
        $sql = $db->prepare("SELECT id FROM `forum_categories` WHERE category = ?");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($category));
        return $sql->fetchColumn();
    }
    public function add_subcategories($data){
        $response = array();
        $db = new Database();
        $Session = new Sessions();
        $General = new General();

        /* Parse Form Data for Same Key Names */
        $form_data = $General->proper_parse_str($data);
        $categories_entered = array();

        if(is_array($form_data['category'])) :
            foreach ($form_data['category'] as $parent_id) {

            if($this->subcategory_exists($form_data['subcategories'], $parent_id) == false){

                $sql = $db->prepare("INSERT INTO `forum_sub_categories` (`parent_category_id`, `sub_category`, `created_data`, `ip`, `user_created_id`) VALUES (?,?,?,?,?)");
                $sql->execute(array(
                    $parent_id,
                    $form_data['subcategories'],
                    time(),
                    $General->getUserIP(),
                    $Session->get('user-id')
                ));

                $last_id = $db->lastInsertId();
                $num_rows = $this->forum_sub_categories();


                $sql = $db->prepare('UPDATE `forum_sub_categories` SET `position` = ? WHERE id = ?');
                $sql->execute(array($num_rows,$last_id));

                $response['added'][] = $this->get_category($parent_id);

            }else{
                $response['exists'][] = $this->get_category($parent_id);

            }

        }
        else:

            if($this->subcategory_exists($form_data['subcategories'], $form_data['category']) == false){

                $sql = $db->prepare("INSERT INTO `forum_sub_categories` (`parent_category_id`, `sub_category`, `created_data`, `ip`, `user_created_id`) VALUES (?,?,?,?,?)");
                $sql->execute(array(
                    $form_data['category'],
                    urldecode($form_data['subcategories']),
                    time(),
                    $General->getUserIP(),
                    $Session->get('user-id')
                ));

                $last_id = $db->lastInsertId();
                $num_rows = $this->forum_sub_categories();


                $sql = $db->prepare('UPDATE `forum_sub_categories` SET `position` = ? WHERE id = ?');
                $sql->execute(array($num_rows,$last_id));

                $response['added'][] = $this->get_category($form_data['category']);

            }else{
                $response['exists'][] = $this->get_category($form_data['category']);

            }
        endif;
        echo json_encode($response);
    }
    public function delete_sub_category($id){
        $response = array();
        $db = new Database();

        $sql = $db->prepare("DELETE FROM `forum_sub_categories` WHERE id = ?");
        $sql->execute(array($id));

        if($sql->rowCount() > 0){
            $response['result'] = "Success";
        }else{
            $response['result'] = "Failed";
        }
    }
    public function subcategory_list_by_cat_id($parent_id){
        $db = new Database();
        $sql = $db->prepare("SELECT * FROM `forum_sub_categories` WHERE `parent_category_id` = ? ORDER BY `position`");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($parent_id));
        return $sql->fetchAll();
    }
	public function subcategory_list_by_cat_value($category){
		$db = new Database();

		$category_id = $this->get_category_id($category);

		$sql = $db->prepare("SELECT sub_category FROM `forum_sub_categories` WHERE parent_category_id = ? ORDER BY `position`");
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		$sql->execute(array($category_id));
		return $sql->fetchAll();
	}
    public function add_post_to_category($data){
        parse_str($data,$data_out);
        $db = new Database();
        $Session = new Sessions();
        $General = new General();

        if($Session->get('logged_in') == 1){
            $sql = $db->prepare("INSERT INTO `forum_post` (sub_category_id, title, content, feeling, create_date, created_user_id, ip,anxiety,isolation,happiness) VALUES (?,?,?,?,?,?,?,?,?,?)");
            $sql->execute(array(
                $data_out['sub_cat_id'],
                $data_out['title'],
                $data_out['content'],
                $data_out['feeling'],
                time(),
                $Session->get('user-id'),
                $General->getUserIP(),
                $data_out['anxiety'],
                $data_out['isolation'],
                $data_out['happiness'],
            ));

            if($sql->rowCount() > 0){
                echo 'Success';
            }else{
                echo 'Failed';
            }
        }else{
            echo 'Not Logged In';
        }
    }
    public function get_post_for_sub_category($sub_category_id){
        $db = new Database();
        $sql = $db->prepare("SELECT * FROM `forum_post` WHERE `sub_category_id` = ? ORDER BY id DESC ");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($sub_category_id));

        return $sql->fetchAll();
    }
    public function started_following_sub_cat($sub_cat_id){
        $db = new Database();
        $Session = new Sessions();

        $sql = $db->prepare("SELECT TIMESTAMP FROM `forum_fol_sub_cat` WHERE user_id = ? AND sub_cat_id = ?");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($Session->get('user-id'),$sub_cat_id));

        if($sql->rowCount() > 0){
            return $sql->fetchColumn();
        }
    }
    public function new_post_for_sub($sub_category_id){
        $began_following = $this->started_following_sub_cat($sub_category_id);
        $db = new Database();
        $sql = $db->prepare("SELECT * FROM `forum_post` WHERE `sub_category_id` = ? AND TIMESTAMP > ? ORDER BY id DESC ");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($sub_category_id,$began_following));

        return $sql->fetchAll();
    }
    public function total_forums($userId = false){
        $db = new Database();
        if($userId == false){
            $sql = $db->prepare("SELECT id FROM `ask_question_forum`");
            $sql->execute();
        }else{
            $sql = $db->prepare("SELECT id FROM `ask_question_forum` WHERE user_id = ?");
            $sql->execute(array($userId));
        }

        return $sql->rowCount();
    }
    public function total_sub_cat_forums($sub_cat_id){
        $db = new Database();
        $sql = $db->prepare("SELECT count(*) as NUM FROM forum_post WHERE sub_category_id = ? GROUP BY sub_category_id");
        $sql->execute(array($sub_cat_id));

        return $sql->fetchColumn();
    }
    public function latest_post_by_sub_id($sub_cat_id){
        $db = new Database();
        $sql = $db->prepare("SELECT * FROM `forum_post` WHERE `sub_category_id` = ? LIMIT 1");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($sub_cat_id));

        return $sql->fetch();
    }
    public function following_sub_cat($follow_sub_cat,$user_id){
        $db = new Database();

        $sql = $db->prepare("SELECT id FROM `forum_fol_sub_cat` WHERE sub_cat_id = ? AND user_id = ? ");
        $sql->execute(array($follow_sub_cat,$user_id));

        if($sql->rowCount() > 0){
            return true;
        }
    }
    public function unfollow_sub_cat($follow_sub_cat,$user_id){
        $db = new Database();
        $sql = $db->prepare("DELETE FROM `forum_fol_sub_cat` WHERE sub_cat_id = ? AND user_id = ? ");
        $sql->execute(array($follow_sub_cat,$user_id));

        if($sql->rowCount() > 0){
            return true;
        }
    }
    public function follow_sub_cat($follow_sub_cat){
        $db = new Database();
        $General = new General();
        $Session = new Sessions();

        if($Session->get('logged_in') == 1){

            /* Check if user is already following the sub category */
            if($this->following_sub_cat($follow_sub_cat,$Session->get('user-id')) == false){
                $sql = $db->prepare("INSERT INTO `forum_fol_sub_cat` (user_id, sub_cat_id, ip) VALUES (?,?,?)");
                $sql->execute(array(
                    $Session->get('user-id'),
                    $follow_sub_cat,
                    $General->getUserIP()
                ));
                if($sql->rowCount() > 0){
                    echo 'Following';
                }else{
                    echo "Failed Follow Subcategory";
                }
            }else{
                if($this->unfollow_sub_cat($follow_sub_cat,$Session->get('user-id')) == true){
                    echo 'Un-follow Subcategory';
                }else{
                    echo 'Failed Unfollow';
                }
            }

        }else{
            echo 'Logged Out';
        }
    }
    public function following_sub_cat_post($follow_sub_cat_post,$user_id){
        $db = new Database();

        $sql = $db->prepare("SELECT id FROM `forum_fol_sub_cat_post` WHERE sub_cat_id_post = ? AND user_id = ? ");
        $sql->execute(array($follow_sub_cat_post,$user_id));

        if($sql->rowCount() > 0){
            return true;
        }
    }
    public function unfollow_sub_cat_post($follow_sub_cat_post,$user_id){
        $db = new Database();
        $sql = $db->prepare("DELETE FROM `forum_fol_sub_cat_post` WHERE sub_cat_id_post = ? AND user_id = ? ");
        $sql->execute(array($follow_sub_cat_post,$user_id));

        if($sql->rowCount() > 0){
            return true;
        }
    }
    public function follow_sub_cat_post($follow_sub_cat_post){
        $db = new Database();
        $General = new General();
        $Session = new Sessions();

        if($Session->get('logged_in') == 1){

            /* Check if user is already following the sub category */
            if($this->following_sub_cat_post($follow_sub_cat_post,$Session->get('user-id')) == false){
                $sql = $db->prepare("INSERT INTO `forum_fol_sub_cat_post` (user_id, sub_cat_id_post, ip) VALUES (?,?,?)");
                $sql->execute(array(
                    $Session->get('user-id'),
                    $follow_sub_cat_post,
                    $General->getUserIP()
                ));
                if($sql->rowCount() > 0){
                    echo 'Following';
                }else{
                    echo "Failed Follow Subcategory";
                }
            }else{
                if($this->unfollow_sub_cat_post($follow_sub_cat_post,$Session->get('user-id')) == true){
                    echo 'Un-follow Subcategory';
                }else{
                    echo 'Failed Unfollow';
                }
            }

        }else{
            echo 'Logged Out';
        }
    }
    public function user_full_name($user_id){
        $db = new Database();
        $sql = $db->prepare("SELECT fname, lname FROM user_list WHERE id = ? ");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($user_id));
        $user = $sql->fetchAll();
        return ucfirst($user[0]['fname']) . ' ' . ucfirst($user[0]['lname']);
    }
    public function edit_categories($data){
        $db = new Database();
        $General = new General();
        $Session = new Sessions();

        $json_out = array();

        $sql = $db->prepare("UPDATE `forum_categories` SET user_created_id = ?, category = ?, moderator_id = ? , updated_date = ?, ip=? WHERE id = ?");
        $sql->execute(array(
            $Session->get('user-id'),
            $data['category_value'],
            $data['moderator_value'],
            time(),
            $General->getUserIP(),
            $data['category_id']
        ));
        if($sql->rowCount() > 0){
            $json_out['status'] = 'Updated';
            $json_out['category_name'] = $data['category_value'];
            $json_out['moderator_name'] = $this->user_full_name($data['moderator_value']) ;
        }else{
            $json_out['status'] = 'Failed';
        }
        echo json_encode($json_out);
    }
    public function get_forum_by_id($forum_id){
        $db = new Database();
        $sql = $db->prepare("SELECT * FROM forum_post WHERE id = ? LIMIT 1");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($forum_id));
        return $sql->fetchAll()[0];
    }
    public function get_forum_by_user_id($userId){
        $db = new Database();
        $sql = $db->prepare("SELECT * FROM forum_post WHERE created_user_id = ?");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($userId));
        die($userId);
        return $sql->fetchAll();
    }
    public function get_followed_user_forum_by_user_id($userId,$timestamp){
        $db = new Database();
        $sql = $db->prepare("SELECT * FROM forum_post WHERE created_user_id = ? AND TIMESTAMP > ? ");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($userId,$timestamp));
        return $sql->fetchAll();
    }
    public function forum_reply($data){
        $db = new Database();
        $Session = new Sessions();
        $General = new General();
        if($Session->get('logged_in') == 1) :
            $sql = $db->prepare("INSERT INTO forum_replies (user_id, post_id, post_user_id, message, ip, date_created) VALUES (?,?,?,?,?,?)");
            $sql->execute(array(
                $Session->get('user-id'),
                $data['forum_id'],
                $data['forum_user_id'],
                $data['textarea'],
                $General->getUserIP(),
                time()
            ));
	        if(!isset($data['json'])){
		        if($sql->rowCount() > 0){
			        echo 'Success';
		        }else{
			        echo 'failed';
		        }
	        }else{
		        $returnValues = array();
		        if($sql->rowCount() > 0){

			        $returnValues['status'] = 'Success';
			        $returnValues['comment_id'] = $db->lastInsertId();
			        $returnValues['comment_user_id'] = $Session->get('user-id');
			        echo json_encode( $returnValues );
		        }else{
			        $returnValues['status'] = 'failed';
			        $returnValues['error'] = $db->errorInfo();
			        echo json_encode( $returnValues );
		        }
	        }


        endif;
    }
    public function get_forum_replies($sub_category_id){
        $db = new Database();
        $Session = new Sessions();

        $sql = $db->prepare("SELECT * FROM forum_replies WHERE post_id = $sub_category_id");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($sub_category_id));

        return $sql->fetchAll();
    }
	public function get_forum_replies_limit($forum_id, $limit = 100){
		$db = new Database();

		$sql = $db->prepare("SELECT * FROM forum_replies WHERE post_id = :id ORDER BY `id` DESC LIMIT :limit");
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		$sql->bindValue('id', $forum_id);
		$sql->bindValue('limit', $limit, PDO::PARAM_INT);
		$sql->execute();

		return $sql->fetchAll();
	}
    public function unlike_forum_post($post_id, $replied_post_id, $replys_user_id){
        $db = new Database();
        $Session = new Sessions();

        $sql = $db->prepare("DELETE FROM forum_reply_likes WHERE post_id = ? AND replyed_post_id = ? AND replys_user_id = ? AND likers_user_id = ? ");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array(
            $post_id,
            $replied_post_id,
            $replys_user_id,
            $Session->get('user-id')
        ));
    }
    public function liked_forum_post($post_id, $replied_post_id, $replys_user_id){
        $db = new Database();
        $Session = new Sessions();

        $sql = $db->prepare("SELECT * FROM forum_reply_likes WHERE post_id = ? AND replyed_post_id = ? AND replys_user_id = ? AND likers_user_id = ? ");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array(
            $post_id,
            $replied_post_id,
            $replys_user_id,
            $Session->get('user-id')
        ));
        if($sql->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }
    public function like_forum_reply($data){
        $db = new Database();
        $Session = new Sessions();
        $General = new General();

        if($this->liked_forum_post($data['post_id'],$data['data_forum_reply_id'],$data['post_reply_user_id']) == false):
            $sql = $db->prepare("INSERT INTO forum_reply_likes (likers_user_id, replys_user_id, post_id, ip, date_created, post_user_id, replyed_post_id) VALUES (?,?,?,?,?,?,?)");
            $sql->execute(array(
                $Session->get('user-id'),
                $data['post_reply_user_id'],
                $data['post_id'],
                $General->getUserIP(),
                time(),
                $data['post_user_id'],
                $data['data_forum_reply_id']
            ));

	        if(!isset($data['json'])){
		        if($sql->rowCount() > 0){
			        echo 'Liked';
		        }else{
			        echo 'failed';
		        }
	        }else{

		        if($sql->rowCount() > 0){
			        echo 'Success';
		        }else{
			        echo 'failed';
		        }
	        }
        else :
            $this->unlike_forum_post($data['post_id'],$data['data_forum_reply_id'],$data['post_reply_user_id']);
            echo 'Unliked';
        endif;
    }
    public function unlike_forum($forum_id){
        $db = new Database();
        $Session = new Sessions();

        $sql = $db->prepare("DELETE FROM forum_likes WHERE forum_id = ? AND likers_user_id = ? ");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array(
            $forum_id,
            $Session->get('user-id')
        ));
    }
    public function liked_forum($forum_id){
        $db = new Database();
        $Session = new Sessions();

        $sql = $db->prepare("SELECT * FROM forum_likes WHERE forum_id = ? AND likers_user_id = ?");
        $sql->execute(array(
            $forum_id,
            $Session->get('user-id')
        ));
        if($sql->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }
    public function like_forum($data){
        $db = new Database();
        $Session = new Sessions();
        $General = new General();

        if($this->liked_forum($data['forum_id']) == false):
            $sql = $db->prepare("INSERT INTO forum_likes (likers_user_id, forum_user_id, forum_id, ip, date_created) VALUES (?,?,?,?,?)");
            $sql->execute(array(
                $Session->get('user-id'),
                $data['forum_user_id'],
                $data['forum_id'],
                $General->getUserIP(),
                time()
            ));
            if($sql->rowCount() > 0){
                echo 'Liked';
            }else{
                echo 'failed';
            }
        else :
            $this->unlike_forum($data['forum_id']);
            echo 'Unliked';
        endif;
    }
    public function convert_emotions($emotion){
        $emotions = explode('_',$emotion);
        if($emotions[0] == 100){
            return 10;
        }else{
            return '0'.$emotions[0][0];
        }
    }
    public function get_sub_cats_following(){
        $db = new Database();
        $Session = new Sessions();

        $sql = $db->prepare("SELECT * FROM hopetrac_main.forum_fol_sub_cat WHERE user_id = ?");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($Session->get('user-id')));
        return $sql->fetchAll();
    }
	public function total_forum_post_likes($forum_id){
		$Database = new Database();

		$sql = $Database->prepare('SELECT count(*) AS qty FROM forum_likes WHERE forum_id =  ?');
		$sql->execute(array(
			$forum_id
		));

		return $sql->fetchColumn();
	}
}