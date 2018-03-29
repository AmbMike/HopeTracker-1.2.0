<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/hopetracker/config/constants.php');

/** The switch variable for the ajax get. */
$ajaxCase = $_GET['ajaxCase'];

switch ($ajaxCase) :
	case 'Skip Session'  :
		include_once( CLASSES . 'class.ActivitySession.php' );
		include_once( CLASSES . 'class.ActivitySessionSkipped.php' );
		$ActivitySession = new ActivitySession();
		$ActivitySessionSkipped = new ActivitySessionSkipped();

		$updatedStatus = array();

		if((int)$ActivitySessionSkipped->isSessionSkipped($_GET['skippedSession']) == true){
			$ActivitySessionSkipped->unSkipSession($_GET['skippedSession']);
			$updatedStatus['updateStatus'] = 'Un-Skipped';
			$updatedStatus['totalSkippedSessions'] = count($ActivitySessionSkipped->getAllSkippedSessions());
		}else{

			/** Get current session to update */
			$ActivitySessionSkipped->skipSession($_GET['skippedSession']);
			$updatedStatus['updateStatus'] = 'Skipped';
			$updatedStatus['totalSkippedSessions'] = count($ActivitySessionSkipped->getAllSkippedSessions());

		}

		echo json_encode( $updatedStatus);

		break;
	default :
		json_encode( $updatedStatus );
endswitch;