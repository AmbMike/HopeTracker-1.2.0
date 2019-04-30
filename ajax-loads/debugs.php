<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/hopetracker/config/constants.php');
require_once(CLASSES . 'Sessions.php');
require_once(CLASSES . 'Admin.php');

$Sessions = new Sessions();
$Admin = new Admin();

if($Sessions->get('logged_in') == 1){
	$userId = $Sessions->get( 'user-id' );

	if($Admin->is_admin($userId) == true){
		switch ($_GET['debug']):
			case 'resetCourseSession' :
				require_once(CLASSES . 'class.ActivitySession.php');
				$ActivitySession = new ActivitySession();
				if($ActivitySession->resetSession($userId) == true):
					echo 'Session Reset Successfully!';

					else:
						echo 'Failed to Reset.';
				endif;
			break;
			case 'resetCourseIntro' :
				require_once(CLASSES . 'Debug.php');
				$Debug = new Debug();
				if($Debug::clearCourseIntro() == true):
					echo 'Session Reset Successfully! -- To review the intro section, just refresh your page when your ready.';
				else:
					echo 'Failed to Reset.';
				endif;
				break;
            case 'shadowAccount' :
                require_once(CLASSES . 'Admin/AccountDebug.php');
                 $AccountDebug = new AccountDebug($_GET);
                 echo $AccountDebug->accessUserId;
                break;
			default : die('No Go!');
		endswitch;
	}else{
		echo 'You don\'t have Admin permissions. ';
	}
}else{
	echo 'You must be logged in. ';
}

