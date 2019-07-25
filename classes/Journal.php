<?php

/**
 * File For: HopeTracker.com
 * File Name: Journal.php.
 * Author: Mike Giammattei
 * Created On: 4/20/2017, 9:25 AM
 */
include_once($_SERVER['DOCUMENT_ROOT'] . '/hopetracker/config/constants.php');
include_once(CLASSES .'User.php');
class Journal extends Sessions {
    public function check_user_with_url(){
        $session = new parent();
        if($session->get('logged_in') == 1 && $_GET['user_id'] == $session->get('user-id')){
            return true;
        }else{
            return false;
        }
    }
    public function user_profile($logged_in_str, $logged_out_str){
        $User = new User();

        if($this->check_user_with_url() === true){
            return ucwords($logged_in_str);
        }else{
            if(isset($_GET['user_id'])){
                return ucwords($User->Username($_GET['user_id']) ."'s " . $logged_out_str) ;
            }else{
                return ucwords("Hope Tracker Journal Entries ") ;
            }

        }
    }
    public function is_user(){
        if($this->check_user_with_url() === true){
            return true;
        }else{
            return false;
        }
    }
    public function entry_profile_img(){
        $user = new User();
        if(!empty($_GET['user_id'])){
            $img = $user->get_user_profile_img($_GET['user_id']);
            if(empty($img)){
                $img = DEFAULT_PROFILE_IMG;
            }
            return $img;
        }
    }
    public function user_journal_entries($user_id = true, $show_all = false, $limit = 5){
        $db = new Database();
        $User = new User();

        if($show_all === false && $user_id != false) :
            /* Get the user's id from the username */
            $user_id =  $user_id;

            /* Get the user's "Journal Entry" data */
            $sql = $db->prepare('SELECT * FROM journal_entries WHERE `user_id` = :id ORDER BY `id` DESC LIMIT :limit');
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $sql->bindValue('id', $user_id);
            $sql->bindValue('limit', $limit, PDO::PARAM_INT);
            $sql->execute();

            return $sql->fetchAll();

        else:

            /* Get all users entries */
            $sql = $db->prepare('SELECT * FROM journal_entries ORDER BY `id` DESC  LIMIT :limit');
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $sql->bindValue('limit', $limit, PDO::PARAM_INT);
            $sql->execute();
            return $sql->fetchAll();
        endif;
    }
    public function check_if_liked($table_name,$journal_id){
        $Session = new Sessions();

        if($Session->check('user-id') == true):
            $user_id = $Session->get('user-id');
            $db = new Database();
            $sql = $db->prepare("SELECT `id` FROM $table_name WHERE `user_id` = ? AND `journal_id` = ?");
            $sql->execute(array($user_id,$journal_id));

            if($sql->rowCount() > 0){
                return true;
            }else{
                return false;
            }
            else: return false;
        endif;
    }
    public function set_like_status($data){
        $db = new Database();
        $Session = new Sessions();
        $status = $data['like_status'];
        $journal_id = $data['journal_id'];

        /* Check if user is logged in */
        if($Session->check('user-id') == true) :
            $user_id = $Session->get('user-id');
            if($status == 'liked') :

                $sql = $db->prepare('INSERT INTO `journal_likes` (`user_id`, `journal_id`) VALUES(?,?)');
            else:
                $sql = $db->prepare('DELETE FROM `journal_likes` WHERE `user_id` = ? AND `journal_id` = ? ');
            endif;
            $sql->execute(array($user_id,$journal_id));

            if($sql->rowCount() > 0) :
                echo 'Success';
            endif;
        else:
            echo 'Not Logged In';
        endif;
    }
    public function entry_comment($data){
	    include_once( CLASSES . 'User.php' );
	    include_once( ARRAYS . 'states.php' );
	    include_once(CLASSES .'class.Notifications.php');
	    include_once(CLASSES .'class.JournalPosts.php');

	   global  $state_list;
        $db = new Database();
        $Session = new Sessions();
        $General = new General();
	    $JournalPosts = new JournalPosts();
	    $Notifications = new Notifications();

        $journal_id = $data['journal_id'];
        $ip = $Session->get('visitor_ip');

	    $user_id = $Session->get('user-id');
	    $comment = $data['comment'];

        /* Check if user is logged in */
        if($Session->check('user-id') == true && !isset($data['type'])):

            $sql = $db->prepare('INSERT INTO `journal_comments` (`user_id`, `journal_id`, `created_on`,`comment`,`ip`) VALUES(?,?,?,?,?)');
            $sql->execute(array($user_id,$journal_id,time(),$comment,$ip));

            if($sql->rowCount() > 0) :
                echo 'Success';

                $lastInsertedID = $db->lastInsertId();

                include_once(CLASSES . 'class.JournalPosts.php');
                $JournalPost = new JournalPosts();

                $thePostArr = $JournalPost->getSinglePost($data['parent_post_id']);

                $sql = $db->prepare("INSERT INTO unviewed_posts (post_Type, post_id, user_id, user_ip, notify_user_id ) VALUES(?,?,?,?,?)");
                $sql->execute(array(
                    5,
                    $lastInsertedID,
                    $user_id,
                    $General->getUserIP(),
                    $journal_id,
                ));
            else:
                $ip;
                print_r($sql->errorInfo());
                echo 'Failed';
            endif;
        endif;
        if($data['type'] == 'Journal Comment' ){

        	if($comment != ''):
		        $sql = $db->prepare('INSERT INTO `journal_comments` (`user_id`, `journal_id`, `created_on`,`comment`,`ip`) VALUES(?,?,?,?,?)');
		        $sql->execute(array($user_id,$journal_id,time(),$comment,$ip));
                $lastInsertedID = $db->lastInsertId();

		        $jsonOut = array();
		        $jsonOut['status'] = 'Success';
		        $jsonOut['userId'] = $user_id;
		        $jsonOut['post_id'] = $db->lastInsertId();
		        $jsonOut['username-url-safe'] = $General->url_safe_string(User::Username($user_id));
		        $jsonOut['username'] = User::Username($user_id);
		        $jsonOut['time'] = date("j F Y H:i",time());
		        $jsonOut['state'] = $state_list[strtoupper(User::user_info('state', $user_id))];
		        $jsonOut['zip'] = User::user_info('zip', $user_id);


		        /** The user's id who has wrote the post that the logged in user is commenting on. */
		        $journalUserId = $JournalPosts->getSinglePost($journal_id);

		        $journalUserId =  $journalUserId['user_id'];


		        $Notifications->setNotification($journalUserId,$jsonOut['post_id'],5,0,0,$journal_id);



                include_once(CLASSES . 'class.JournalPosts.php');
                $JournalPost = new JournalPosts();

                $thePostArr = $JournalPost->getSinglePost($journal_id);

                $sql = $db->prepare("INSERT INTO unviewed_posts (post_Type, post_id, user_id, user_ip, notify_user_id ) VALUES(?,?,?,?,?)");
                $sql->execute(array(
                    5,
                    $lastInsertedID,
                    $user_id,
                    $General->getUserIP(),
                    $thePostArr['user_id'],
                ));

		        else:
			        $jsonOut['status'] = 'Empty Input';

	        endif;

	        echo json_encode($jsonOut );
        }
    }
	public function entry_comment_sidebar($data){
		$db = new Database();
		$Session = new Sessions();
		$journal_id = $data['journal_id'];
		$ip = $Session->get('visitor_ip');
		$returnValues = array();

		/* Check if user is logged in */
		if($Session->check('user-id') == true):
			$user_id = $Session->get('user-id');
			$comment = $data['comment'];

			$sql = $db->prepare('INSERT INTO `journal_comments` (`user_id`, `journal_id`, `created_on`,`comment`,`ip`) VALUES(?,?,?,?,?)');
			$sql->execute(array($user_id,$journal_id,time(),$comment,$ip));


			if($sql->rowCount() > 0) :
				$returnValues['status'] = 'Success';
				$returnValues['comment_id'] = $db->lastInsertId();
				$returnValues['comment_user_id'] = $Session->get('user-id');
				echo json_encode( $returnValues );

			else:
				$returnValues['status'] = 'failed';
				$returnValues['error'] = $db->errorInfo();
				echo json_encode( $returnValues );
			endif;

		endif;
	}
    public function journal_comment_count($journal_id){
        $db = new Database();

        $sql = $db->prepare('SELECT * FROM `journal_comments` WHERE `journal_id` = ?  ');
        $sql->execute(array($journal_id));

        return $sql->rowCount();

    }
    public function get_journal_comments($journal_id, $show_all = false, $show_json = false, $limit = 5){
        $db = new Database();

        if($show_all == false) :
            $sql = $db->prepare('SELECT * FROM `journal_comments` WHERE `journal_id` = :journal_id ORDER BY `id` ASC LIMIT 0, :limit');
	        $sql->setFetchMode(PDO::FETCH_ASSOC);
	        $sql->bindParam( 'journal_id', $journal_id,PDO::PARAM_INT );
	        $sql->bindParam( 'limit', $limit,PDO::PARAM_INT );
	        $sql->execute();
        else :
            $sql = $db->prepare('SELECT * FROM `journal_comments` WHERE `journal_id` = ? ORDER BY `id` DESC');

            $sql->setFetchMode(PDO::FETCH_ASSOC);
	        $sql->execute(array($journal_id));
        endif;


        if($show_json == false) :
            if($sql->rowCount() > 0){
                $fetch = $sql->fetchAll();
                $fetch[0]['count'] = $sql->rowCount();
                return $fetch;
            }else{
                return '';
            }
        else :
            $fetch = $sql->fetchAll();

            echo json_encode($fetch);
        endif;
    }
    public function group_journals_by_likes(){
            $db = new Database();
            $post_id_arr = array();

            $sql = $db->prepare("SELECT post_id, count(*) as NUM FROM liked_posts WHERE post_type = 2 GROUP BY post_id ORDER BY NUM DESC ");
            $sql->execute();

            foreach ($sql->fetchAll() as  $data):
                $post_id_arr[] = $data['post_id'];
            endforeach;

            return $post_id_arr;
    }
    public function group_journal_comments(){
        $db = new Database();
        $post_id_arr = array();

        $sql = $db->prepare("SELECT journal_comments.journal_id, count(*) as NUM FROM journal_comments GROUP BY journal_id ORDER BY NUM DESC");
        $sql->execute();

        foreach ($sql->fetchAll() as  $data):
            $post_id_arr[] = $data['journal_id'];
        endforeach;

        return $post_id_arr;
    }
    public function journal_filter($filter){
        $filter = strtolower($filter);
        $db = new Database();

        switch($filter){
            case 'oldest' :
                $sql = $db->prepare('SELECT * FROM journal_entries ORDER BY id ASC ');
                $sql->execute();
                return $sql->fetchAll();
            break;
            case 'positive' :
                $sql = $db->prepare('SELECT * FROM journal_entries WHERE feeling = "positive" ORDER BY id DESC ');
                $sql->execute();
                return $sql->fetchAll();
            break;
            case 'negative' :
                $sql = $db->prepare('SELECT * FROM journal_entries WHERE feeling = "negative" ORDER BY id DESC ');
                $sql->execute();
                return $sql->fetchAll();
            break;
            case 'most liked' :
                $journal_arr = array();
                foreach ($this->group_journals_by_likes() as $index => $journal_post):
                    $sql = $db->prepare('SELECT * FROM journal_entries WHERE id = :id');
                    $sql->bindParam('id',$journal_post,PDO::PARAM_INT);
                    $sql->execute();
                    $journal_arr[] = $sql->fetchAll();
                endforeach;
                $journal_arr = call_user_func_array('array_merge',$journal_arr);
                return $journal_arr;
            break;
            case 'most commended' :
                $journal_arr = array();
                foreach ($this->group_journal_comments() as $index => $journal_post):
                    $sql = $db->prepare('SELECT * FROM journal_entries WHERE id = :id');
                    $sql->bindParam('id',$journal_post,PDO::PARAM_INT);
                    $sql->execute();
                    $journal_arr[] = $sql->fetchAll();
                endforeach;
                $journal_arr = call_user_func_array('array_merge',$journal_arr);
                return $journal_arr;

            break;
            case 'followed' :
                $sql = $db->prepare('SELECT * FROM journal_entries ORDER id BY DESC ');
            break;
            case 'single' :
	            $sql = $db->prepare('SELECT * FROM journal_entries ORDER BY id DESC ');
	            $sql->setFetchMode( PDO::FETCH_ASSOC );
	            $sql->execute();
	            return $sql->fetchAll()[0];
            break;
        }
    }
    public function journal_owner_id($user_id, $filter = array()){
        /* Get a list of journals where the user has create */
        $db = new Database();
        if(in_array('journal_id',$filter)){
            $sql = $db->prepare('SELECT id FROM journal_entries WHERE user_id = ? ');
        }else{
            $sql = $db->prepare('SELECT * FROM journal_entries WHERE user_id = ? ');
        }

        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($user_id));
        return $sql->fetchAll();
    }
    public function user_received_likes($journal_id){
        $db = new Database();
        $sql = $db->prepare('SELECT * FROM liked_posts WHERE post_id = ? AND post_type = 2 ');
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($journal_id));
        return $sql->fetchAll();
    }
    public function journal_by_journal_id($journal_id){
        $db = new Database();
        $sql = $db->prepare('SELECT * FROM journal_entries WHERE id = ? LIMIT 1 ');
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($journal_id));
        return $sql->fetchAll();
    }
    public function journal_by_user_id($user_id){
        $db = new Database();
        $sql = $db->prepare('SELECT * FROM journal_entries WHERE user_id = ? ');
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($user_id));

        return $sql->fetchAll();
    }
    public function new_journal($journal_id){
        $db = new Database();
        $Session = new Sessions();
        $sql = $db->prepare('SELECT id FROM new_journal WHERE user_id = ? AND journal_id = ? LIMIT 1 ');
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($Session->get('user-id'),$journal_id));

        if($sql->rowCount() > 0){
            return true;
        }
    }
    public function viewed_new_followed_user_journal($journal_user_id,$journal_id){
        $db = new Database();
        $Session = new Sessions();
        $General = new General();

        $sql = $db->prepare('INSERT INTO new_journal (journal_id, jounral_user_id, user_id, ip, date_view) VALUES (?,?,?,?,?)');
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array(
            $journal_id,
            $journal_user_id,
            $Session->get('user-id'),
            $General->getUserIP(),
            time()
        ));
    }
    public function new_journal_check($journal_id){
        $Session = new Sessions();
        $journal_user_id = $this->journal_by_journal_id($journal_id);

        if($this->new_journal($journal_id) == false && $Session->get('logged_in') == 1):
            $this->viewed_new_followed_user_journal($journal_user_id[0]['user_id'],$journal_id);
        endif;
    }
    public function users_journal_likes($user_id){
        $journal_likes_arr = array();

        /* Get the journals that have likes and put time into an array */

        foreach ( $this->journal_owner_id($user_id) as $liked_journals) {
            $received_like_on_journal = $this->user_received_likes($liked_journals['id']);


            if(count($received_like_on_journal) > 0){
                $journal_likes_arr[] = $received_like_on_journal;
            }


        }
        $journal_likes_arr = array_reduce($journal_likes_arr, 'array_merge', array());

        /* Get the user who liked the journal and get the title of the journal that was liked */

        $liked_journal_data = array();

        foreach ($journal_likes_arr as $index => $item) {
            $liked_journal_data[$index]['liked_timestamp'] = $item['TIMESTAMP'];
            $liked_journal_data[$index]['liked_by_fname'] = User::user_info('fname',$item['likers_user_id']);
            $liked_journal_data[$index]['liked_by_user_id'] = User::user_info('id',$item['likers_user_id']);
            $liked_journal_data[$index]['liked_journal'] = $this->journal_by_journal_id($item['post_id']);
        }

        return $liked_journal_data;
    }
    public function following_user($followed_user,$user_id){
        $db = new Database();

        $sql = $db->prepare("SELECT id FROM `follow_user` WHERE follow_user_id = ? AND followers_id = ? ");
        $sql->execute(array($followed_user,$user_id));

        if($sql->rowCount() > 0){
            return true;
        }
    }
    public function began_following_user($followed_user,$user_id){
        $db = new Database();

        $sql = $db->prepare("SELECT TIMESTAMP FROM `follow_user` WHERE follow_user_id = ? AND followers_id = ? ");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($followed_user,$user_id));

        if($sql->rowCount() > 0){
            return $sql->fetchColumn();
        }
    }
    public function unfollow_user($followed_user,$user_id){
        $db = new Database();
        $sql = $db->prepare("DELETE FROM `follow_user` WHERE follow_user_id = ? AND followers_id = ? ");
        $sql->execute(array($followed_user,$user_id));

        if($sql->rowCount() > 0){
            return true;
        }
    }
    public function follow_user($followers_username){
        $db = new Database();
        $Session = new Sessions();
        $General = new General();
        $User = new User();
        $followed_user_id = $User->get_user_id_by_username($followers_username);

        if($this->following_user($followed_user_id,$Session->get('user-id')) == true):
            $this->unfollow_user($followed_user_id,$Session->get('user-id'));
            echo  'Un-followed';
        else :
            $sql = $db->prepare('INSERT INTO follow_user (follow_user_id, followers_id, ip) VALUES (?,?,?)');
            $sql->execute(array($followed_user_id, $Session->get('user-id'),$General->getUserIP()));

            if($sql->rowCount() > 0):
                echo 'Following';
            endif;
        endif;
    }
    public function total_journal_post($userId = false){
        $returnValue = null;

        if($userId == false){

        }else{
            $db = new Database();

            $sql = $db->prepare("SELECT count(*) FROM `journal_entries` WHERE user_id = ?");
            $sql->execute(array($userId));
            $returnValue = $sql->fetchColumn();
        }
        return $returnValue;
    }
    public function total_journal_post_likes($journal_id){
    	$Database = new Database();

    	$sql = $Database->prepare('SELECT count(*) AS qty FROM journal_likes WHERE journal_id =  ?');
    	$sql->execute(array(
    		$journal_id
	    ));

	    return $sql->fetchColumn();
    }
    public function journal_ownership($journalId){
	    $Database = new Database();
	    $Sessions = new Sessions();

	    $sql = $Database->prepare("SELECT id FROM journal_entries WHERE id = ? AND user_id = ?");
	    $sql->execute( array( $journalId, $Sessions->get( 'user-id' ) ) );
	    if($sql->rowCount() > 0){
	    	return true;
	    }else{
	    	return false;
	    }
    }
}