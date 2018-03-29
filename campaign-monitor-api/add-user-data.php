<?php
/**
 * Copyright (c) 2017.
 */

/**********************************Required Files***********************************/
require_once 'csrest_campaigns.php';
require_once 'csrest_general.php';
require_once 'csrest_clients.php';
require_once 'csrest_subscribers.php';

define('ABSPATH', $_SERVER['DOCUMENT_ROOT']);

/* Config Root */
include_once(ABSPATH.'/config/constants.php');
require_once (CLASSES .'User.php');



/** @object  $wrap : core object for campaign monitor */
$wrap = new CS_REST_Subscribers('f24613d7e2555b4d8bcca1fc46cfb1c2', '29a644cdec042cb0fb39f389f20afc9a');

/** @var  $value : loops through each record that has not been sent to CM. */


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
		/* Do when script failed sent successfully */

	} else {

		/* Do when message sent successfully */
		echo 'Failed with code '.$result->http_status_code."\n<br /><pre>";
		var_dump($result->response);
		echo '</pre>';
		error_log("Campaign Monitor : invite friend failed!" .$result->http_status_code. "errors: ".$result->response , 0);
	}


