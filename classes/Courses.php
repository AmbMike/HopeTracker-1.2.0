<?php
/**
 * File For: HopeTracker.com
 * File Name: Courses.php.
 * Author: Mike Giammattei
 * Created On: 8/4/2017, 3:48 PM
 */

include_once(CLASSES.'Sessions.php');

class Courses{
    public function set_course_session_status($data){
        $db = new Database();
        $Session = new Sessions();
        $General = new General();

        $sql = $db->prepare("INSERT INTO course_sessions (course_id, session_pos, user_id, started_on, ip, status,session_number) VALUES (?,?,?,?,?,?,?)");
        $sql->execute(array(
           $data['session_num'],
           $data['session_item'],
           $Session->get('user-id'),
           time(),
           $General->getUserIP(),
            1,
	        $data['session_number']
        ));
        if($sql->rowCount() > 0){
            echo 'success';
        }else{
            echo 'failed';
        }
    }
    public function session_status($session_num,$session_pos){
        $db = new Database();
        $Session = new Sessions();
        $sql = $db->prepare("SELECT id FROM course_sessions WHERE user_id = ? AND course_id = ? AND session_pos = ?");
        $sql->execute(array(
            $Session->get('user-id'),
            $session_num,
            $session_pos
        ));
        if($sql->rowCount() > 0){
            return true;
        }
    }
    public function session_status_check($session_num){
        $db = new Database();
        $Session = new Sessions();
        $sql = $db->prepare("SELECT id FROM course_sessions WHERE course_id = ? AND user_id = ?");
        $sql->execute(array(
            $session_num,
            $Session->get('user-id')
        ));
        if($sql->rowCount() > 0){
            return true;
        }
    }

    public function get_total_clicked_activities($userId){
        $Database = new Database();

        $sql = $Database->prepare("SELECT count(*) FROM hopetrac_main.course_sessions WHERE user_id = ?");
        $sql->execute(array($userId));

        return $sql->fetchColumn();
    }
    public function get_progress_content($userId){

        /** @var  $level : gets the total number of complete/clicked activities.
         * Controls what level json file will be pulled. */
        $level = $this->get_total_clicked_activities($userId);

        /** @var  $level_file : file ID to sever the user the json file for the current level.*/
        $level_file = 1;

        switch (TRUE) {
            case ($level < 10) :
                $level_file = 1;
                break;
            case ($level < 20) :
                $level_file = 2;
                break;
            case ($level < 37) :
                $level_file = 3;
                break;
            case ($level >= 37) :
                $level_file = 4;
                break;

            default : $level_file = 1;
        }


        /** @var  $data : the path to the json file containing the level content */
        $data = file_get_contents(BASE_URL . '/site/public/json-data/course-progress/level-' . $level_file . '.json');
        $json = json_decode($data, true);

        return $json;
    }
    public function get_current_level_number($userId){

        /** @var  $level : gets the total number of complete/clicked activities.
         * Controls what level json file will be pulled. */
        $level = $this->get_total_clicked_activities($userId);

        /** @var  $level_file : file ID to sever the user the json file for the current level.*/
        $level_number = 1;

        switch (TRUE) {
            case ($level < 10) :
                $level_number = 1;
                break;
            case ($level < 20) :
                $level_number = 2;
                break;
            case ($level < 37) :
                $level_number = 3;
                break;
            case ($level >= 37 ):
                $level_number = 4;
                break;

            default : $level_number = 1;
        }

        return $level_number;
    }
    public function getJournalsByDayOfWeek($userId = false){
        $db = new Database();
       if ($userId == false) {
           $sql = $db->prepare("SELECT DATE_FORMAT(timestamp,\"%a\") AS ForDate,
            COUNT(*) AS NumPosts
            FROM   journal_entries
            GROUP BY DATE_FORMAT(created_entry,\"%a\")
            ORDER BY ForDate");
           $sql->setFetchMode(PDO::FETCH_ASSOC);
           $sql->execute();
       }else{
           $sql = $db->prepare("SELECT DATE_FORMAT(timestamp,\"%a\") AS ForDate,
            COUNT(*) AS NumPosts
            FROM   journal_entries
            WHERE user_id = ?
            GROUP BY DATE_FORMAT(created_entry,\"%a\")
            ORDER BY ForDate");
           $sql->setFetchMode(PDO::FETCH_ASSOC);
           $sql->execute(array($userId));
       }

       return $sql->fetchAll();
    }

    public function weekday_array(){
       $Session = new Sessions();
        $usersJournalWeekdayArr = $this->getJournalsByDayOfWeek($Session->get('user-id'));

        $returnValue = array(
            'Mon' => 0,
            'Tue' => 0,
            'Wed' => 0,
            'Thur' => 0,
            'Fri' => 0,
            'Sat' => 0,
            'Sun' => 0
        );

        foreach ($usersJournalWeekdayArr as $usersJournalWeekday) {
            $returnValue[$usersJournalWeekday['ForDate']] = (int)$usersJournalWeekday['NumPosts'];
        }
        return $returnValue;
    }

    public function get_tracked_login_by_week($userId){
        $Database = new Database();

        $sql = $Database->prepare("SELECT DATE_FORMAT(TIMESTAMP ,\"%a\") AS ForDate,
            COUNT(*) AS NumLogins
            FROM   login_archive
            WHERE user_id = ?
            GROUP BY DATE_FORMAT(TIMESTAMP,\"%a\")
            ORDER BY ForDate");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($userId));

        return $sql->fetchAll();
    }

    public function get_tracked_login_by_week_name(){
        $Session = new Sessions();
        $usersLoginWeekdayArr = $this->get_tracked_login_by_week($Session->get('user-id'));

        $returnValue = array(
            'Mon' => 0,
            'Tue' => 0,
            'Wed' => 0,
            'Thur' => 0,
            'Fri' => 0,
            'Sat' => 0,
            'Sun' => 0
        );

        foreach ($usersLoginWeekdayArr as $usersLoginWeekday) {
            $returnValue[$usersLoginWeekday['ForDate']] = (int)$usersLoginWeekday['NumLogins'];
        }
        return $returnValue;
    }
	public function viewed_course_page($userId,$page){
		$Database = new Database();
		$General = new General();

		$sql = $Database->prepare("INSERT INTO intro_log (user_id, user_ip, page) VALUES(?,?,?)");
		$sql->execute( array(
			$userId,
			$General->getUserIP(),
			$page
		) );
	}
	public function has_viewed_courses($userId){
		$Database = new Database();
		$sql = $Database->prepare( "SELECT id FROM intro_log WHERE user_id = ?" );
		$sql->execute( array(
			$userId
		));

		if ( $sql->rowCount() > 0 ) {
			return true;
		}
	}
	public function set_total_courses(){

		/** @var $totalActivities : total number of activities available to the user.
		 * Called from an ajax call associated with the course page and pull from the
		 * a cron job file.
		 */
		$totalActivities = $_POST['total'];

		$Database = new Database();

		$sql = $Database->prepare("UPDATE activity_total SET total = ? WHERE id = 1");
		$sql->execute( array($totalActivities) );
	}
	public function get_total_courses(){

		$Database = new Database();

		$sql = $Database->prepare("SELECT total FROM  activity_total  WHERE id = 1");
		$sql->setFetchMode( PDO::PARAM_STR );
		$sql->execute();

		return $sql->fetchColumn();
	}
}