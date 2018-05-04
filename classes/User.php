<?php

/**
 * File For: HopeTracker.com
 * File Name: User.php.
 * Author: Mike Giammattei
 * Created On: 3/22/2017, 11:48 AM
 */
include_once(CLASSES.'Forms.php');
include_once (CLASSES.'Email.php');
include_once (CLASSES. 'Encrypt.php');
include_once (CLASSES. 'General.php');
include_once (CLASSES. 'Courses.php');

class User extends Sessions {
	private $logged_in = 0;
	protected $db,$Session;

	public $General;

	function __construct(){
		$General = new General();
		$this->db = new Database();
		$this->General = new General();
		$this->Session = new Sessions();

		if(empty(parent::get('logged_in'))){
			parent::set('logged_in',$this->logged_in);
		}
		parent::set('visitor_ip',$General->getUserIP());

	}
	static public function set_session(){
		$session_array = array();

		$session = new parent();
		if(empty($session->get('session_token'))){
			$session->set('session_token', General::random_string());
			$session->set('gen_array', $session_array);
		}
	}
	public function is_logged_in(){
		if(parent::get('logged_in') == 0){
			return 0;
		}else{
			return 1;
		}
	}
	public function get_username($username){
		$db = new Database();
		$User = new User();

		/* Put GET value into an array*/
		$username_array = explode('_',$username);

		/* If username is not first name last letter then get "i_am" value to create username */
		if(is_numeric($username_array[0])){
			$user_letter_name = $User->user_i_am($username_array[0]);

			return $user_letter_name . '_' . $username_array[1];
		}else{
			return $username;
		}

	}
	public function log_user_already($user_id){
		$sql = $this->db->prepare("SELECT id FROM `users_online` WHERE user_id = ? ");
		$sql->execute(array($user_id));
		if($sql->rowCount() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function log_user_online($user_id){
		if($this->log_user_already($user_id) == false){
			$sql = $this->db->prepare("INSERT INTO `users_online` (user_id, time_signed_in, ip) VALUES (?,?,?)");
			$sql->execute(array(
				$user_id, time(), $this->General->getUserIP()
			));
		}
	}
	public function log_user_offline($user_id){
		$sql = $this->db->prepare("DELETE FROM users_online WHERE user_id = ? ");
		$sql->execute(array(
			$user_id
		));
	}
	public function get_user_id_by_username($username){
		$db = new Database();

		$sql = $db->prepare("SELECT `id` FROM `user_list` WHERE `username` = ?");
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		$sql->execute(array($username));

		return $sql->fetchColumn();

	}
	public function sign_out(){
		$session = new parent();
		$this->log_user_offline($session->get('user-id'));
		session_destroy();
	}
	public static function user_info($name, $id = false){
		$session = new parent();
		$db = new Database();

		if($id == false){
			$user_id = $session->get('user-id');
		}else{
			$user_id = $id;
		}

		$sql = $db->prepare("SELECT * FROM `user_list` WHERE id = ? LIMIT 1");
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		$sql->execute(array($user_id));

		$return = $sql->fetch();
		return $return[$name];
	}
	public function login_user($data){
		$db = new Database();
		$session = new parent();

		$sql = $db->prepare("SELECT * FROM `user_list` WHERE `email` = ? AND `password` = md5(?)");
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		$sql->execute(array(strtolower($data['email']), $data['password']));
		$data_out = $sql->fetch();

		if($sql->rowCount() > 0) {
			$session->set('logged_in',1);
			$session->set('user-id',$data_out['id']);
			$session->set('user-fname',$data_out['fname']);
			return 'Redirect';
		}else{
			return 'Failed';
		}

	}
	private function login_archive($user_id,$cur_url){
		$db = new Database();
		$General = new General();

		$sql = $db->prepare("INSERT INTO login_archive (user_id, user_ip, loginURL) VALUES (?,?,?)");
		$sql->execute(array(
			$user_id,
			$General->getUserIP(),
			$cur_url
		));
	}
	public function sign_in($data){
		$db = new Database();
		$session = new parent();
		$Forms = new Forms();
		$Courses = new Courses();

		if($Forms->check_email($data['email']) === 1){
			$sql = $db->prepare("SELECT * FROM `user_list` WHERE `email` = ? AND `password` = md5(?)");
			$sql->setFetchMode(PDO::FETCH_ASSOC);
			$sql->execute(array(strtolower($data['email']), $data['password']));
			$data_out = $sql->fetch();

			if($sql->rowCount() > 0) {
				$session->set('logged_in',1);
				$session->set('user-id',$data_out['id']);
				$session->set('user-fname',$data_out['fname']);
				$session->set('user-username',$data_out['username']);


				/** Set Session If user viewed the courses page yet */
				if($Courses->has_viewed_courses($data_out['id']) == true){
					$session->set( 'viewed_course', true );
				}

				/** Archive login data to the database */
				$this->login_archive($session->get('user-id'), $data['cur_url']);

				/* Log User Online */
				$this->log_user_online($data_out['id']);

				/* Set Admin Session if is Admin */
				if($data_out['role'] == 1){
					$session->set('Admin Logged',1);

				}
				echo 'Email and Password Match';
			}else{
				echo 'Password Not Correct';
			}
		}else{
			echo 'No Email Found';
		}
	}
	public function check_users_idle_time($user_id = false){
		if($user_id == false){
			$sql = $this->db->prepare('DELETE FROM users_online WHERE timestamp < (NOW() - INTERVAL 30 MINUTE)');
			$sql->execute();
		}else{
			$sql = $this->db->prepare('DELETE FROM users_online WHERE id = ? AND timestamp < (NOW() - INTERVAL 1 MINUTE)');
			$sql->execute(array($user_id));
		}
		return $sql->rowCount();
	}
	public static function forgot_password($email){
		$email = strtolower($email);

		$db = new Database();
		$encrypt = new Encrypt();
		$general = new General();
		@$emailer = new Email();

		if($general->time_check($email) === 0){
			$general->set_time_check($email);
			$sql = $db->prepare("SELECT * FROM `user_list` WHERE `email` = ?");
			$sql->setFetchMode(PDO::FETCH_ASSOC);
			$sql->execute(array($email));

			if($sql->rowCount() > 0){
				$data = $sql->fetch();

				$subject = 'Reset your HopeTracker password';
				$emailer->send_email($data["email"],$subject,$data['fname'],BASE_URL .'/rpd/reset-password.'.FILE_EXTENSION.'?verify=' . $data['password'] .'&verifyE=' . $encrypt->mask_get_var($data['email']));
			}
			echo 'Sent';

		}else{
			echo 'Wait';
		}
	}
	public function reset_password($data){
		$db = new Database();

		$sql = $db->prepare("UPDATE `user_list` SET `password` = ? WHERE `email` = ?");
		$sql->execute(array(md5($data['password']),$data['email']));

		if($sql->rowCount() > 0){
			echo $this->login_user($data);
		}else{
			echo $this->login_user($data);
		}
	}
	private function check_password($data){
		$Database = new Database();
		$sql = $Database->prepare("SELECT id from user_list WHERE email = ? AND password = ?");
		$sql->execute( array(
			$data['email'],
			$data['validate_pass'],
		) );

		if($sql->rowCount() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function email_reset_password($data){

		/** Check if the new password matches the validation password. */
		if($this->check_password($data) == true){
			$Database = new Database();

			$sql = $Database->prepare("UPDATE user_list SET password = ? WHERE email = ? AND password = ? ");
			$sql->execute( array(
				md5($data['new_password']),
				$data['email'],
				$data['validate_pass']
			));

			/** Add password key and value need for the sign in method */
			$data['password'] =  $data['new_password'];

			$this->sign_in($data);

		}else{
			echo 'Failed';
		}

	}
	public function get_user_profile_img($user_id,$id = false){
		$db = new Database(); 

		if($id == false):
			$match_sql = $user_id;
			$sql = $db->prepare("SELECT `profile_img` FROM `user_list` WHERE `username` = ? LIMIT 1");

		else :
			$match_sql = $id;
			$sql = $db->prepare("SELECT `profile_img` FROM `user_list` WHERE `id` = ? LIMIT 1");
		endif;
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		$sql->execute(array($match_sql));

		$data = $sql->fetch();
		if(!empty($data['profile_img'])){
			return RELATIVE_PATH .  $data['profile_img'] . '?cache='. rand(4,1000);
		}else{
			return RELATIVE_PATH . 'site/public/images/main/icon.jpg';
		}

	}
	public function journal_entry_form($data){
		$Forms = new Forms();

		/* Process the form from the "Forms" class */
		$Forms->process_entry_form($data);
	}
	public function user_i_am($i_am_id){
		$db = new Database();
		$sql = $db->prepare("SELECT `value` FROM `i_am` WHERE `id` = ? LIMIT 1");
		$sql->execute(array($i_am_id));

		return $sql->fetchColumn();
	}
	public function user_concerned_about($concerned_about_id){
		$db = new Database();
		$sql = $db->prepare("SELECT `value` FROM `concerned_about` WHERE `id` = ? LIMIT 1");
		$sql->execute(array($concerned_about_id));

		return $sql->fetchColumn();
	}
	public function user_in_type($in_type_id){
		$db = new Database();
		$sql = $db->prepare("SELECT `value` FROM `status` WHERE `id` = ? LIMIT 1");
		$sql->execute(array($in_type_id));
		return $sql->fetchColumn();
	}
	public function all_users(){
		$db = new Database();
		$sql = $db->prepare("SELECT * FROM `user_list`");

		$sql->setFetchMode(PDO::FETCH_ASSOC);
		$sql->execute();
		return $sql->fetchAll();
	}
	public function is_user_still_logged_in($user_id = false){
		$sql = $this->db->prepare("SELECT id FROM `users_online` WHERE user_id = ?");

		if($user_id != false){
			$sql->execute(array($user_id));
		}else{
			$sql->execute(array($this->Session->get('user-id')));
		}
		if($sql->rowCount() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function update_online_timestamp(){
		sleep(1);
		if($this->Session->get('logged_in') == 1){
			/* Update timestamp to keep user logged in */
			$sql = $this->db->prepare("UPDATE `users_online` SET timestamp = NOW() WHERE user_id = ?");
			$sql->execute(array($this->Session->get('user-id')));

			if($sql->rowCount() == 0){
				$this->sign_out();
				echo 'Logged Out User';
			}
		}
	}
	public function users_online(){
		$db = new Database();
		$sql = $db->prepare("SELECT * FROM users_online");
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		$sql->execute();

		return $sql->fetchAll();
	}
	public function is_a_moderator($user_id){
		$db = new Database();
		$sql = $db->prepare("SELECT id FROM moderators WHERE user_id =?");
		$sql->execute(array($user_id));
		if($sql->rowCount() > 0){
			return true;
		}
	}
	public function users_online_plus_moderators(){
		$db = new Database();
		$unique_array = array();
		$sql = $db->prepare("SELECT * FROM moderators
                            UNION ALL
                            SELECT * FROM users_online");
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		$sql->execute();

		foreach($sql->fetchAll() as $element) {
			$hash = $element['user_id'];
			$unique_array[$hash] = $element;
		}
		return $unique_array;
	}
	public function him_or_her($user_id, $type = 'first person'){
		$i_am = $this->user_i_am($this->user_info('i_am_a',$user_id));
		$him_arr = array('dad','uncle','grandpa','brother','son','husband','nephew');
		$her_arr = array('mom','sister','aunt','grandma','daughter','wife','niece');

		$output = 'their';

		if(in_array($i_am,$him_arr)){
			if($type == "first person"){
				$output = 'his';
			}
			if($type == "second person"){
				$output = 'him';
			}
		}
		if(in_array($i_am,$her_arr)){

			if($type == "first person"){
				$output = 'her';
			}
			if($type == "second person"){
				$output = 'she';
			}
		}
		return $output;
	}
	public function moderator_offline($user_id){
		if($this->is_a_moderator($user_id)){
			if($this->is_user_still_logged_in($user_id) == 0) {
				return true;
			}
		}else{
			return false;
		}
	}
	public static function full_name($user_id){
		$returnValue = ucfirst(self::user_info('fname',$user_id)) . ' ' .  ucfirst(self::user_info('lname',$user_id));

		return $returnValue;
	}
	public static function Username($user_id = false ){

		if($user_id != false){
			$returnValue = ucwords(self::user_info('username',$user_id));
		}else{
			$returnValue = ucwords(self::user_info('username'));
		}
		return $returnValue;
	}
	public static function users_email($user_id){
		$returnValue = ucfirst(self::user_info('email',$user_id));

		return $returnValue;
	}
	public function full_name_public($user_id){
		$returnValue = ucfirst(self::user_info('fname',$user_id)) . ' ' .  ucfirst(self::user_info('lname',$user_id));

		return $returnValue;
	}
	public function Username_public($user_id = false ){

		if($user_id != false){
			$returnValue = ucwords(self::user_info('username',$user_id));
		}else{
			$returnValue = ucwords(self::user_info('username'));
		}
		return $returnValue;
	}
	public function users_email_public($user_id){
		$returnValue = ucfirst(self::user_info('email',$user_id));

		return $returnValue;
	}
	public function get_user_id_by_name($name) {
		$db = new Database();
		$General = new General();

		$names = $General->split_name($name);

		if(is_array($name)){
			$sql = $db->prepare("SELECT id FROM user_list WHERE fname LIKE :fname OR lname LIKE = :lname");
			$sql->setFetchMode(PDO::FETCH_ASSOC);
			$fname = "%".$names[0]."%";
			$lname = "%".$names[1]."%";
			$sql->bindParam(':fname', $fname, PDO::PARAM_STR);
			$sql->bindParam(':lname', $lname, PDO::PARAM_STR);
		}else{
			$sql = $db->prepare("SELECT id FROM user_list WHERE fname LIKE :fname ");
			$sql->setFetchMode(PDO::FETCH_ASSOC);
			$fname = "%".$names[0]."%";
			$sql->bindParam(':fname', $fname, PDO::PARAM_STR);
		}

		$sql->execute();

		return $sql->fetchAll();
	}
	public function get_users_ids_by_state($state,$zip = false){
		$db = new Database();
		$state = strtolower( $state );

		if($zip == false) {
			$sql = $db->prepare( "SELECT id FROM user_list WHERE state = ?" );
			$sql->setFetchMode( PDO::FETCH_ASSOC );
			$sql->execute( array( $state ) );
		}else{
			$sql = $db->prepare( "SELECT id FROM user_list WHERE state = ? AND zip = ?" );
			$sql->setFetchMode( PDO::FETCH_ASSOC );
			$sql->execute( array( $state, $zip) );
		}

		$returnValue = array_map( 'current', $sql->fetchAll() );
		return $returnValue;
	}
	public function get_users_ids_by_zip($zip,$state = false){
		$db = new Database();
		$zip = strtolower( $zip );

		if($state == false){
			$sql = $db->prepare( "SELECT id FROM user_list WHERE zip = ?" );
			$sql->setFetchMode( PDO::FETCH_ASSOC );
			$sql->execute(array($zip));
		}else{
			$sql = $db->prepare( "SELECT id FROM user_list WHERE zip = ? AND state" );
			$sql->setFetchMode( PDO::FETCH_ASSOC );
			$sql->execute(array($zip, $state));
		}


		$returnValue = array_map( 'current', $sql->fetchAll() );
		return $returnValue;
	}
	public function get_users_ids_by_i_am($role){
		$db = new Database();

		$roleList = implode( ',', $role );

		$sql = $db->prepare( "SELECT id FROM user_list WHERE i_am_a IN (". $roleList .")" );
		$sql->setFetchMode( PDO::FETCH_ASSOC );
		$sql->execute();


		$returnValue = array_map( 'current', $sql->fetchAll() );
		return $returnValue;
	}
	public function get_users_ids_by_concerned_about($concerned_about){
		$db = new Database();

		$concerned_about_List = implode( ',', $concerned_about );

		$sql = $db->prepare( "SELECT id FROM user_list WHERE user_list.concerned_about IN (". $concerned_about_List .")" );
		$sql->setFetchMode( PDO::FETCH_ASSOC );
		$sql->execute();


		$returnValue = array_map( 'current', $sql->fetchAll() );
		return $returnValue;
	}
	public function get_users_ids_by_status($status){
		$db = new Database();

		$status_List = implode( ',', $status );

		$sql = $db->prepare( "SELECT id FROM user_list WHERE user_list.in_type IN (". $status_List .")" );
		$sql->setFetchMode( PDO::FETCH_ASSOC );
		$sql->execute();


		$returnValue = array_map( 'current', $sql->fetchAll() );
		return $returnValue;
	}
}