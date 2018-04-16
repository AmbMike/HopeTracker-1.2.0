<?php

/**
 * File For: HopeTracker.com
 * File Name: Forms.php.
 * Author: Mike Giammattei
 * Created On: 3/24/2017, 3:03 PM
 */

//session_start();
include_once(ARRAYS . 'states.php');
include_once(CLASSES.'General.php');
include_once(CLASSES.'Database.php');
include_once(CLASSES.'Sessions.php');



class Forms extends Database {

    protected $User;

    var $state_list;

    function __construct(){
        $this->User = new User();
    }

    public static function sign_up($data){
        $general = new General();

        if($data['form'] == 'Sign Up'){

            $general->delete_files();

            /* If form had image
            if(!empty($data['profile_img_path'])){
                $file = explode('/',$data['profile_img_path']);
                $general->move_file($file[0],'users', $file[1]);
            }
            */
        }
    }
    public function increment_username($id){
        $db = new Database();
        $sql = $db->prepare("UPDATE `i_am` set `qty` = `qty` + 1 WHERE id = ?");
        $sql->execute(array($id));
    }
    public function generate_select_list($table_name, $show_qty = false, $exclude = false){
        $db = new Database();

        $sql = $db->prepare("SELECT * FROM $table_name");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();

        $show_count = '';

        foreach ($sql->fetchAll() as $value){
            if($show_qty === true ){
                $show_count = '_' . $value['qty'];
            }

            if($value['value'] != $exclude){
                echo '<option value="' . $value['id'] . $show_count . '">'. ucwords($value['value'] . $show_count) .'</option>';
            }
        }
    }

    public function generate_checkbox_label_list($table_name){
        $db = new Database();

        $sql = $db->prepare("SELECT * FROM $table_name");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();

        foreach ($sql->fetchAll() as $value){
	        $showChecked = '';
        	/** Set input to "checked" for table "status" if it's in the url */
	        if ( isset( $_GET['filter'] ) && $_GET['filter'] == $value['id'] && $table_name == "status" ) {
		        $showChecked = 'checked';
	        }
        echo '<label><input type="checkbox" '.$showChecked.' value="' . $value['id']. '">'. ucwords($value['value']).'</label>';

        }
    }
    public static function get_states($shorten = false){

        $general = new General();
        $return = '';
        global $state_list;
        foreach ($state_list as $key => $value) {
        	if($shorten == false){
        		$format = $value;
	        }else{
        		$format = strtoupper($key);
	        }
           $return .= <<< EOD
<option value="{$key}">{$format}</option>
EOD;
        }

        return $return;
    }
    public function check_email($email){
        $db = new parent();

        $email = strtolower($email);

        $sql = $db->prepare("SELECT `email` FROM user_list WHERE `email` = ?");
        $sql->execute(array($email));

        return $sql->rowCount();
    }
    public function process_sign_up($data){

        $general = new General();

        /* Check if email exists */
        if($this->check_email(strtolower($data['email'])) === 0):
            $db = new parent();
            $session = new Sessions();

            $first =  strtolower($data['fname']);
            $last_name =  strtolower($data['lname']);
            $full_name = $first . ' ' . $last_name;
            $first_l = $first . ' ' . $last_name[0];
	        $build_username = '';

            $sql = $db->prepare("INSERT INTO user_list (fname, lname, email,password,created_on,state,zip,profile_img,i_am_a,concerned_about,in_type,username,ip) 
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $sql->execute(array(
	            trim($first),
	            trim($last_name),
                strtolower($data['email']),
                md5($data['password']),
                time(),
                strtolower($data['state']),
                $data['zip'],
                $data['profile_img_path'],
                $data['i_am'],
                $data['concerned_for'],
                $data['in_status'],
                $data['username'],
                $general->getUserIP()
            ));
            $last_id = $db->lastInsertId();

            if($sql->rowCount() > 0) :

	            function sendToCampaignMonitor($last_id){

		            require_once ABSPATH . '/campaign-monitor-api/csrest_campaigns.php';
		            require_once ABSPATH . '/campaign-monitor-api/csrest_general.php';
		            require_once ABSPATH . '/campaign-monitor-api/csrest_clients.php';
		            require_once ABSPATH . '/campaign-monitor-api/csrest_subscribers.php';
		            require_once (CLASSES .'Admin.php');
		            require_once (CLASSES .'User.php');
		            require_once (CLASSES .'Courses.php');
		            require_once (CLASSES .'class.ForumQuestions.php');
		            require_once (CLASSES .'class.FollowedPost.php');
		            require_once (CLASSES .'Journal.php');

		            $Admin = new Admin();
		            $User = new User();
		            $Courses = new Courses();
		            $Journal = new Journal();
		            $ForumQuestions = new ForumQuestions();
		            $FollowedPost = new FollowedPost();

		            $userListStatus1 = $Admin->all_users();

		            $wrap = new CS_REST_Subscribers('1abc19b3dcd7794d37363f6e8a9902ec', '29a644cdec042cb0fb39f389f20afc9a');

			            /** @var  $value : loops through each record that has not been sent to CM. */
			            $result = $wrap->add(array(
				            'Name' => User::full_name($last_id),
				            'EmailAddress' => User::users_email($last_id),
				            "CustomFields" => array(
					            array(
						            'Key' => 'iAm',
						            'Value' => ucfirst($User->user_i_am($last_id))
					            ),
					            array(
						            'Key' => 'signUpDate',
						            'Value' => date("m-d-Y", time())
					            ),
					            array(
						            'Key' => 'ActivitesCompleted',
						            'Value' => $Courses->get_total_clicked_activities($last_id)
					            ),
					            array(
						            'Key' => 'TotalForumPosts',
						            'Value' => $ForumQuestions->totalApprovedQuestions($last_id)
					            ),
					            array(
						            'Key' => 'TotalForumPostsFollowing',
						            'Value' => $FollowedPost->getTotalPostUserIsFollowing($last_id, 3)
					            ),
					            array(
						            'Key' => 'TotalJournalPosts',
						            'Value' => $Journal->total_journal_post($last_id)
					            ),
					            array(
						            'Key' => 'userId',
						            'Value' => $last_id
					            )
				            )
			            ));

			            /* Check if user's row was updated to sent to campaign monitor.*/
			            if($Admin->recordUpdateStatus($last_id) == true):
				            /*echo "Recorded in Database. \n";*/

			            else:
				            echo "Failed to Recorded in Database. \n";
				            Debug::to_file( $Admin->recordUpdateStatus( $last_id ), 'signupCMErrorLog.txt');

			            endif;

		            if($result->was_successful()) {
			            /*echo "Recorded to Campaign Monitor. \n";*/

		            } else {
			            Debug::to_file('Failed with code '.$result->http_status_code."\n<br />", 'signupCMErrorLog.txt');
			           /* var_dump($result->response);
			            echo '</pre>';
			            error_log("Campaign Monitor :  failed!" .$result->http_status_code. "errors: ".$result->response , 0);*/
		            }

	            }

	            sendToCampaignMonitor($last_id);

	            /** Set Username Value */
	            switch(strtolower($data['username'])) :
		            case 'full_name' :
			            $build_username = $full_name;
	                break;
		            case 'first_l' :
			            $build_username = $first_l;
		            break;
		            default :
			            /** Increment the "i_am" qty for the username */
			            $this->increment_username($data['i_am']);

			            /* Get the qty for the "i_am" to add to the username */
			            $sql = $db->prepare("SELECT qty FROM `i_am` WHERE `id` = ?");
			            $sql->execute(array($data['i_am']));
			            $i_am_qty = $sql->fetchColumn();

			            $build_username = $this->User->user_i_am($data['i_am']) . $i_am_qty;
	                break;
	            endswitch;

	            /** Set the username */
	            $sql = $db->prepare("update `user_list` SET `username` = ? WHERE `id` = ?");
	            $sql->execute(array($build_username,$last_id));

               /* Set the session values for the user*/
                $session->set('user-id', $last_id);
                $session->set('logged_in', 1);
                $session->set('user_username', $build_username);

                /* Log User Online */
                $this->User->log_user_online($last_id);

                if(!empty($data['profile_img_path'])) :
                    $general->move_file(RELATIVE_PATH_NO_END_SLASH .'/' . $data['profile_img_path'],'users' . '/user-' .$last_id . '/' . $data['profile_img_path']);
                    /* Update image path to new path in database */
                    $sql = $db->prepare("UPDATE `user_list` SET `profile_img` = ? WHERE `id` = ? ");
                    $sql->execute(array(
                        'users' . '/user-' .$last_id . '/' . 'profile.jpg',
                        $last_id
                    ));
                endif;
	            echo "0";
                else :
	                echo 'failed to create user at data entry';

	                Debug::data( $sql->errorInfo());
	                Debug::data($data);
            endif;

        else :
            /* Email already exists */
            echo "1";
        endif;
    }
    public function process_entry_form($data){
        $db = new parent();
        $session = new Sessions();
        $General = new General();

        $token = $session->get('session_token');
        date_default_timezone_set('America/New_York');
        if(isset($token) && $token != ''){

            /** Post is to be save as draft */
            $jsonData = array();
            /** Update draft is post id exists and belongs to the logged in user. */
            if($data['postId'] != 'false'){

	            include_once(CLASSES.'Journal.php');
	            $Journal = new Journal();

	            /** Check if the user owns draft post */
	            if($Journal->journal_ownership($data['postId']) == true){

		            /** Update  draft of the post */
		            if(!isset($data['publishPost']) ):
			            $sql = $db->prepare(" UPDATE `journal_entries` SET user_id = ?, created_entry = ?, title = ?,content = ?,anxiety = ?,isolation = ?,happiness = ?,status = ?,ip =  ? WHERE id = ?");
			            $sql->execute(array(
				            $session->get('user-id'),
				            time(),
				            $data['entry_title'],
				            $data['form_content'],
				            serialize($data['entry_anxiety']),
				            serialize($data['entry_isolation']),
				            serialize($data['entry_happiness']),
				            $data['status'],
				            $General->getUserIP(),
				            $data['postId']
			            ));

			            $jsonData['type'] =  'Updated';
		            else:
			            $sql = $db->prepare("UPDATE journal_entries SET status = ?  WHERE id = ?");
			            $sql->execute(array($data['status'],$data['postId']));


			            $jsonData['type'] =  'Published';
		            endif;


		            $jsonData['postId'] = $data['postId'];
		            $jsonData['time'] = date("j F Y H:i",time());
		            $jsonData['status'] =  'Success';
	            }

            }
            else{
                /** Store new draft of the post */
	            $sql = $db->prepare("INSERT INTO `journal_entries` (user_id, created_entry, title,content,anxiety,isolation,happiness,status,ip) 
VALUES (?,?,?,?,?,?,?,?,?)");
	            $sql->execute(array(
		            $session->get('user-id'),
		            time(),
		            $data['entry_title'],
		            $data['form_content'],
		            serialize($data['entry_anxiety']),
		            serialize($data['entry_isolation']),
		            serialize($data['entry_happiness']),
		            $data['status'],
		            $General->getUserIP()
	            ));
	            $jsonData['type'] =  'Created';
	            $jsonData['postId'] =  $db->lastInsertId();
	            $jsonData['time'] = date("j F Y H:i",time());
	            $jsonData['status'] =  'Success';

	            if($data['status'] == 1){
		             $jsonData['test'] =  $data['status'];
		            $sql = $db->prepare("UPDATE `journal_entries` SET status = ?  WHERE id = ?");
		            $sql->execute(array($data['status'], $db->lastInsertId()));
	            }

            }

            echo json_encode($jsonData);

        }
    }
    private function compare_password($user_id,$password){
        $db = new parent();

        $sql = $db->prepare("SELECT id FROM user_list WHERE id = ? AND password = ?");
        $sql->execute(array(
            $user_id,
            md5($password)
        ));

        if($sql->rowCount() > 0){
            return true;
        }

    }
    public function replace_profile_img($fname, $img_path){
        $db = new Database();
        $General = new General();
        $Session = new Sessions();
        $General->move_file($img_path,'users' . '/user-' .$Session->get('user-id') . '/' . $img_path);
        /* Update image path to new path in database */
	    Debug::to_file( $img_path, 'test333.php' );
        $sql = $db->prepare("UPDATE `user_list` SET `profile_img` = ? WHERE `id` = ? ");
        $sql->execute(array(
            'users' . '/user-' .$Session->get('user-id') . '/' . 'profile.jpg',
            $Session->get('user-id')
        ));
    }
    public function user_settings($data){

        $data_out = array();
        /* Convert serialized data to array */
        $params = array();
        parse_str($data, $params);
        $db = new parent();
        $Session = new Sessions();
        $General = new General();
        $user_id = $Session->get('user-id');

        /* Update Profile Image */
        $this->replace_profile_img($params['fname'], $params['img_path']);
        $data_out['updated'] =  true;

        $sql = $db->prepare("UPDATE `user_list` SET fname = ?, lname = ?, username = ?, i_am_a = ?, concerned_about = ?, in_type = ?, ip = ? WHERE id = ?");
        $sql->execute(array(
            $params['fname'],
            $params['lname'],
            $params['username'],
            $params['i_am'],
            $params['concerned_for'],
            $params['in_status'],
            $General->getUserIP(),
            (int)$user_id
        ));
        if($sql->rowCount() > 0){

            $data_out['updated'] =  true;
            $last_id = $Session->get('user-id');
            /* Set username for those who choose "first l" as username */
            if(strtolower($params['username']) == 'first_l'){
                $build_username = strtolower($params['fname']).strtoupper($params['lname'][0]).$last_id;

                $sql = $db->prepare("update `user_list` SET `username` = ? WHERE `id` = ?");
                $sql->execute(array($build_username,$last_id));
            }else{
                /* Check if username has a qty */
                if(preg_match('/.+_.+/',$params['username']) === 1){
                    $i_am_id = explode('_', $params['username']);

                    /* Build username for user selecting to be a "I am" */
                    $sql = $db->prepare("SELECT qty FROM `i_am` WHERE `id` = ?");
                    $sql->execute(array($i_am_id[0]));

                    $this->increment_username($i_am_id[0]);

                    $i_am_qty = $sql->fetchColumn();

                    $build_username = $this->User->user_i_am($i_am_id[0]) . $i_am_qty;

                    $sql = $db->prepare("update `user_list` SET `username` = ? WHERE `id` = ?");
                    $sql->execute(array($build_username,$last_id));
                }
            }

        }
       if($this->compare_password($user_id,$params['current_pass']) == true){
                        $sql = $db->prepare("UPDATE user_list SET password = ? WHERE id = ?");
            $sql->execute(array(
                md5($params['password']),
                $user_id)
            );
            if($sql->rowCount() > 0){
                $data_out['password_updated'] = true ;
            }else{
                $data_out['password_updated'] = false;
            }

        }

        echo json_encode($data_out);

    }
    public function password_ajax_check($data){

        $Session = new Sessions();

        $isAvailable = $this->compare_password($Session->get('user-id'),$data['current_pass']);

        echo json_encode(array(
            'valid' => $isAvailable,
            'data' => $_POST
        ));
    }
    public function settings_feedback($data){
        $db = new Database();
        $General = new General();
        $Session = new Sessions();
        $data_back = array();
        $data_back['sent'] = 'Failed';

        $params = array();
        parse_str($data, $params);

        // Required field names
        $required = array('found_out_about', 'features', 'change', 'general');

        // Loop over field names, make sure each one exists and is not empty
        $empty = array();
        foreach($required as $field) {
            if (!empty($params[$field])) {
                $empty[] = true;
            }
        }
        if (count($empty) > 0) {
            $sql = $db->prepare("INSERT INTO `settings_feedback` (sender_user_id, ip, found_portal, features_to_add, changes, general) VALUE(?,?,?,?,?,?)");
            $sql->execute(array(
                $Session->get('user-id'),
                $General->getUserIP(),
                $params['found_out_about'],
                $params['features'],
                $params['change'],
                $params['general']
            ));
            if($sql->rowCount() > 0){
                $data_back['sent'] = 'Success';
            }
        }
        echo json_encode($data_back);
    }

}