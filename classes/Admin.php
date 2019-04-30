<?php

/**
 * File For: HopeTracker.com
 * File Name: Admin.php.
 * Author: Mike Giammattei
 * Created On: 5/15/2017, 5:18 PM
 */
?>
<?php
if (!defined('ABSPATH')) {
    define('ABSPATH', $_SERVER['DOCUMENT_ROOT'] . '/hopetracker');
}
include_once(ABSPATH . '/classes/Database.php');

class Admin extends Database {
    protected $Session,$logged_in,$user_id;

    function __construct(){
        $this->Session = new Sessions();
        $this->logged_in = $this->Session->get('logged_in');
        if($this->Session->check('user-id') == true ){
            $this->user_id = $this->Session->get('user-id');
        }

    }
    public function user_role($user_id){
        $db = new Database();
        $sql = $db->prepare("SELECT role FROM `user_list` WHERE  id = $user_id");
        $sql->execute(array($user_id));
        return $sql->fetchColumn();
    }
    public function total_users(){
        $db = new Database();
        $sql = $db->prepare("SELECT id FROM `user_list`");
        $sql->execute();
        return $sql->rowCount();
    }
    public function total_users_online(){
        $db = new Database();
        $sql = $db->prepare("SELECT id FROM `users_online`");
        $sql->execute();
        return $sql->rowCount();
    }
    public function total_forum_categories(){
        $db = new Database();
        $sql = $db->prepare("SELECT id FROM `forum_categories`");
        $sql->execute();
        return $sql->rowCount();
    }
    public function all_users($campainMonitorStatus = false){
        $db = new Database();

        if($campainMonitorStatus == false):
	        $sql = $db->prepare("SELECT * FROM user_list");
        else:
	        $sql = $db->prepare("SELECT * FROM user_list WHERE updateRecorded = 0");
        endif;

        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();

        return $sql->fetchAll();
    }
    public function is_moderator($user_id){
        $db = new Database();
        $sql = $db->prepare("SELECT id FROM moderators WHERE user_id = ? LIMIT 1");
        $sql->execute(array($user_id));
        if($sql->rowCount() > 0){
            return true;
        }
    }
	public function is_admin($user_id){
		$db = new Database();
		$sql = $db->prepare("SELECT id FROM user_list WHERE id = ? AND role = 1 OR role = 2");
		$sql->execute(array($user_id));
		if($sql->rowCount() > 0){
			return true;
		}
	}
	public function recordUpdateStatus($userId){
		$db = new Database();

	    $sql = $db->prepare("UPDATE user_list SET updateRecorded = 1 WHERE id = ?");
	    $sql->execute(array($userId));

	    return $sql->rowCount() ? true : $sql->errorInfo();
	}

}