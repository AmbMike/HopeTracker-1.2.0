<?php
/**********************************Required Files***********************************/
require_once 'csrest_campaigns.php';
require_once 'csrest_general.php';
require_once 'csrest_clients.php';
require_once 'csrest_subscribers.php';

define('ABSPATH', $_SERVER['DOCUMENT_ROOT']);

/* Config Root */
include_once(ABSPATH.'/config/constants.php');
require_once (CLASSES .'class.InviteFriend.php');
require_once (CLASSES .'User.php');


/** @array $sent_record_id : the list of record ids that have been successfully
 * sent to campaign monitor.
 */
$sent_record_id = array();

/** @var  $InviteFriend  : class that handles the invite info. */
$InviteFriend = new InviteFriend();

/** @array  $inviteDataToSend : the array of data for the invite users */
$inviteDataToSend = $InviteFriend->getDataForCampaignMonitor();



/** @object  $wrap : core object for campaign monitor */
$wrap = new CS_REST_Subscribers('e911df9c8c94d1ab50d64c42bac90677', '29a644cdec042cb0fb39f389f20afc9a');

/** @var  $value : loops through each record that has not been sent to CM. */

foreach ($inviteDataToSend as $value):

	$result = $wrap->add(array(
		'Name' => $value['recipients_name'],
		'EmailAddress' => $value['recipients_email'],
		"CustomFields" => array(
			array(
				'Key' => 'record_id',
				'Value' => $value['id']
			),
			array(
				'Key' => 'senders_id',
				'Value' => $value['senders_id']
			),
			array(
				'Key' => 'senders_name',
				'Value' => $value['senders_name']
			),
			array(
				'Key' => 'senders_email',
				'Value' => User::users_email($value['senders_id'])
			)
		)
	));
	if($result->was_successful()) {
		$InviteFriend->setInviteAsSent($value['id']);
	} else {
		echo 'Failed with code '.$result->http_status_code."\n<br /><pre>";
		var_dump($result->response);
		echo '</pre>';
		error_log("Campaign Monitor : invite friend failed!" .$result->http_status_code. "errors: ".$result->response , 0);
	}
endforeach;

