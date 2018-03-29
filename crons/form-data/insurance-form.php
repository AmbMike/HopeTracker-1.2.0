<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/config/constants.php');
require_once(CLASSES .'Email.php');
require_once(CLASSES .'class.InsuranceForm.php');
require_once(CLASSES .'User.php');

error_reporting( 3 );
@$Email = new Email();

$InsuranceForm = new  InsuranceForm();

foreach ( $InsuranceForm->getUnsentData() as $unsent_data ) :

	$userEmail = User::users_email($unsent_data['user_id']);

	$htmlcontent =
		'User Name: ' . $unsent_data['lovedOneName'] . '<br>'.
		'User Zip: ' . $unsent_data['lovedOneZip'] . '<br>'.
		'User Email: ' . $userEmail . '<br>'.
		'Referral: ' .'ORG HOPETRACKER<br>'.
		'Submitted URL: ' . $unsent_data['submitted_url'] . '<br>'.
		'IP Address : ' . $unsent_data['ip'] . '<br>'.
		'Inserted Date : ' . date('l jS \of F Y h:i:s A',$unsent_data['insert_time']);

	$Email->send_general_email('michaelgiammattei@gmail.com','Admissions' ,'sendhopetracker@gmail.com','Insurance Form Submission From HopeTracker.com',$unsent_data['lovedOneName'] ,$htmlcontent,'insurance-data');
	//$Email->send_general_email('tracking@ambrosiatc.com','Admissions' ,'sendhopetracker@gmail.com','Insurance Form Submission From HopeTracker.com',$unsent_data['lovedOneName'] ,$htmlcontent,'insurance-data');

	sleep( 10 );

endforeach;
//Debug::data( $InsuranceForm->getUnsentData() );
//$Email->send_general_email('mjgseb@gmail.com', 'Hope Tracker','sendhopetracker@gmail.com','This is the subject for the test email.','Mike','This is the message for the email','insurance-data');