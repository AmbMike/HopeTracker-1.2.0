<?php
/**********************************Required Files***********************************/


define('ABSPATH', $_SERVER['DOCUMENT_ROOT'] . '/hopetracker/');
require_once ABSPATH . 'campaign-monitor-api/csrest_campaigns.php';
require_once ABSPATH . 'campaign-monitor-api/csrest_general.php';
require_once ABSPATH . 'campaign-monitor-api/csrest_clients.php';
require_once ABSPATH . 'campaign-monitor-api/csrest_subscribers.php';

/* Config Root */
include_once(ABSPATH.'config/constants.php');
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

//Debug::data( $userListStatus1 );

/** Run loop on all users with a "recordedUpdated" status to 0,
 * meaning the user has either never been recorded in campaign monitor
 * or the user has updated their account.
 */

/* Add the user's data to Campaign Monitor*/
/** @object  $wrap : core object for campaign monitor */
$wrap = new CS_REST_Subscribers('1abc19b3dcd7794d37363f6e8a9902ec', '29a644cdec042cb0fb39f389f20afc9a');
foreach ($userListStatus1 as $userRecord):

	/** @var  $value : loops through each record that has not been sent to CM. */
	$result = $wrap->add(array(
		'Name' => User::full_name($userRecord['id']),
		'EmailAddress' => User::users_email($userRecord['id']),
		"CustomFields" => array(
			array(
				'Key' => 'iAm',
				'Value' => ucfirst($User->user_i_am($userRecord['id']))
			),
			array(
				'Key' => 'signUpDate',
				'Value' => date("m-d-Y", $userRecord['created_on'])
			),
			array(
				'Key' => 'ActivitesCompleted',
				'Value' => $Courses->get_total_clicked_activities($userRecord['id'])
			),
			array(
				'Key' => 'TotalForumPosts',
				'Value' => $ForumQuestions->totalApprovedQuestions($userRecord['id'])
			),
			array(
				'Key' => 'TotalForumPostsFollowing',
				'Value' => $FollowedPost->getTotalPostUserIsFollowing($userRecord['id'], 3)
			),
			array(
				'Key' => 'TotalJournalPosts',
				'Value' => $Journal->total_journal_post($userRecord['id'])
			),
			array(
				'Key' => 'userId',
				'Value' => $userRecord['id']
			)
		)
	));

	/* Check if user's row was updated to sent to campaign monitor.*/
	if($Admin->recordUpdateStatus($userRecord['id']) == true):
		echo "Recorded in Database. \n";

	else:
		echo "Failed to Recorded in Database. \n";
		Debug::data( $Admin->recordUpdateStatus( $userRecord['id'] ) );

	endif;

endforeach;


if($result->was_successful()) {
	echo "Recorded to Campaign Monitor. \n";

	/* Check if user's row was updated to sent to campaign monitor.
	if($Admin->recordUpdateStatus($userRecord['id']) == true):
		echo "Recorded in Database. \n";

	else:
		echo "Failed to Recorded in Database. \n";
		Debug::data( $Admin->recordUpdateStatus( $userRecord['id'] ) );

	endif; */

} else {
	echo 'Failed with code '.$result->http_status_code."\n<br /><pre>";
	var_dump($result->response);
	echo '</pre>';
	error_log("Campaign Monitor : invite friend failed!" .$result->http_status_code. "errors: ".$result->response , 0);
}

echo "------------- \n \n";

unset( $result );


