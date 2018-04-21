<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/hopetracker/config/constants.php');
require_once(CLASSES .'Email.php');
require_once(CLASSES .'class.InsuranceForm.php');
require_once(CLASSES .'User.php');
require_once(CLASSES .'Database.php');

$DB = new Database();
error_reporting( 3 );
@$Email = new Email();

$InsuranceForm = new  InsuranceForm();

foreach ( $InsuranceForm->getUnsentData() as $unsent_data ) :

	$userEmail = User::users_email($unsent_data['user_id']);
	date_default_timezone_set('America/New_York');

	$htmlcontent =
		'<h3>User Information</h3>' .
		'User\'s Name: ' . User::full_name($unsent_data['user_id']) . '<br>'.
		'User\'s Email: ' . $userEmail . '<br>'.
		'User\'s Phone: ' . $unsent_data['phone'] . '<hr>'.
		'<h3>Loved One\'s Information</h3>' .
		'Loved One\'s Name: ' . $unsent_data['lovedOneName'] . '<br>'.
		'Loved One\'s DOB: ' . $unsent_data['lovedOneDOB'] . '<br>'.
		'Loved One\'s  Zip: ' . $unsent_data['lovedOneZip'] . '<br>'.
		'Loved One\'s  Insurance: ' . $unsent_data['lovedOneInsurance'] . '<br>'.
		'Loved One\'s  Insurance Id: ' . $unsent_data['lovedOneInsuranceId'] . '<br>'.
		'Loved One\'s  Policy Holder Name: ' . $unsent_data['policyHolderName'] . '<br>'.
		'Loved One\'s  Drug of Choice: ' . $unsent_data['drugOfChoice'] . '<hr>'.
		'<h3>General Information</h3>' .
		'Referral: ' .'ORG HOPETRACKER<br>'.
		'Submitted URL: ' . $unsent_data['submitted_url'] . '<br>'.
		'IP Address : ' . $unsent_data['ip'] . '<br>'.
		'Inserted Date : ' . date('F j, Y, g:i a',$unsent_data['insert_time']);

	//$Email->send_general_email('michaelgiammattei@gmail.com','Admissions' ,'sendhopetracker@gmail.com','Insurance Form Submission From HopeTracker.com',$unsent_data['lovedOneName'] ,$htmlcontent,'insurance-data');
	$Email->send_general_email('tracking@ambrosiatc.com','Admissions' ,'sendhopetracker@gmail.com','Insurance Form Submission From HopeTracker.com',$unsent_data['lovedOneName'] ,$htmlcontent,'insurance-data');
	$sql = $DB->prepare("UPDATE insurance_form SET sent = ? WHERE id = ? ");
	$sql->execute(array(1,$unsent_data['id']));

	/** Send data to Campaign Monitor */
	require_once $_SERVER['DOCUMENT_ROOT'].'/hopetracker/campaign-monitor-api/csrest_campaigns.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/hopetracker/campaign-monitor-api/csrest_general.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/hopetracker/campaign-monitor-api/csrest_clients.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/hopetracker/campaign-monitor-api/csrest_subscribers.php';

	function add_user_insurance_data_campaign_monitor($users_name,$users_email){
		/* Add the user's insurance data to Campaign Monitor*/
		/** @object  $wrap : core object for campaign monitor */
		$wrap = new CS_REST_Subscribers('ef09e30b574a124140d81737674618b3', '29a644cdec042cb0fb39f389f20afc9a');

		/** @var  $value : loops through each record that has not been sent to CM. */
		$result = $wrap->add(array(
			'Name' => $users_name,
			'EmailAddress' => $users_email,
			"CustomFields" => array(
				array(
					'Key' => 'Platform',
					'Value' => 'Hopetracker'
				),

			)
		));

		if($result->was_successful()) {
			echo "Recorded to Campaign Monitor. \n";

		} else {
			echo 'Failed with code '.$result->http_status_code."\n<br /><pre>";
			var_dump($result->response);
			echo '</pre>';
			Debug::to_file($result->response,$_SERVER['DOCUMENT_ROOT']. '/errors/insurance-form-cm.txt');
			error_log("Campaign Monitor : insurance failed!" .$result->http_status_code. "errors: ".$result->response , 0);
		}

		echo "------------- \n \n";

		unset( $result );
	}
	add_user_insurance_data_campaign_monitor(User::full_name($unsent_data['user_id']) ,$userEmail);


	sleep( 2 );

endforeach;
