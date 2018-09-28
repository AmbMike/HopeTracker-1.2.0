<?php
/**********************************Required Files***********************************/


define('ABSPATH', $_SERVER['DOCUMENT_ROOT'] . '/hopetracker/');
require_once ABSPATH . 'campaign-monitor-api/csrest_campaigns.php';
require_once ABSPATH . 'campaign-monitor-api/csrest_general.php';
require_once ABSPATH . 'campaign-monitor-api/csrest_clients.php';
require_once ABSPATH . 'campaign-monitor-api/csrest_subscribers.php';

/* Config Root */
include_once(ABSPATH.'config/constants.php');
require_once (CLASSES .'User.php');
require_once (CLASSES .'class.ForumQuestions.php');
require_once (CLASSES .'class.FollowedPost.php');
require_once (CLASSES .'class.ForumAnswers.php');
require_once (CLASSES .'General.php');


$User = new User();
$ForumQuestions = new ForumQuestions();
$ForumAnswers = new ForumAnswers();
$FollowedPost = new FollowedPost();
$General = new General();


$forumPosts = $ForumQuestions->getQuestions();

//Debug::data( $forumPosts );

/** Run loop on all users with a "recordedUpdated" status to 0,
 * meaning the user has either never been recorded in campaign monitor
 * or the user has updated their account.
 */

/* Add the user's data to Campaign Monitor*/
/** @object  $wrap : core object for campaign monitor */

$wrap = new CS_REST_Subscribers('b4ac39220d37331cb61459e658896cc6', '29a644cdec042cb0fb39f389f20afc9a');
Debug::data($forumPosts);
foreach ($forumPosts as $forumPost):

	/** @var  $value : loops through each record that has not been sent to CM. */
	$result = $wrap->add(array(
		'Name' => User::full_name($forumPost['user_id']),
		"CustomFields" => array(
			array(
				'Key' => 'postAuthorEmail',
				'Value' =>  User::users_email($forumPost['user_id']),
			),
			array(
				'Key' => 'title',
				'Value' => $forumPost['question']
			),
			array(
				'Key' => 'body',
				'Value' => $General->trim_text($forumPost['description'],100,true,true)
			),
			array(
				'Key' => 'totalReplies',
				'Value' => $ForumAnswers->totalAnswersByQuestionId($forumPost['id'])
			),
			array(
				'Key' => 'postURL',
				'Value' => BASE_URL . '/forum/'.$General->url_safe_string($forumPost['subcategory']).'/'.$forumPost['id'].'/'.$General->url_safe_string($forumPost['question'])
			),
			array(
				'Key' => 'dateCreated',
				'Value' => date("m-d-Y", $forumPost['date_created'])
			),
			array(
				'Key' => 'postId',
				'Value' => $forumPost['id']
			)
		),
		'EmailAddress' => 'forumId'.$forumPost['id'].'@ht.com',

	));
	if($result->was_successful()) {
		echo "Recorded to Campaign Monitor. \n";


	} else {
		echo 'Failed with code '.$result->http_status_code."\n<br /><pre>";
		var_dump($result->response);
		echo '</pre>';
		error_log("Campaign Monitor : Forum data failed!" .$result->http_status_code. "errors: ".$result->response , 0);
	}
endforeach;




