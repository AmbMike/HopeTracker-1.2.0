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

	$htmlcontent =
		'User Name: ' . $unsent_data['lovedOneName'] . '<br>'.
		'User Zip: ' . $unsent_data['lovedOneZip'] . '<br>'.
		'User Email: ' . $userEmail . '<br>'.
		'Referral: ' .'ORG HOPETRACKER<br>'.
		'Submitted URL: ' . $unsent_data['submitted_url'] . '<br>'.
		'IP Address : ' . $unsent_data['ip'] . '<br>'.
		'Inserted Date : ' . date('l jS \of F Y h:i:s A',$unsent_data['insert_time']);

	$Email->send_general_email('tracking@ambrosiatc.com','Admissions' ,'sendhopetracker@gmail.com','Insurance Form Submission From HopeTracker.com',$unsent_data['lovedOneName'] ,$htmlcontent,'insurance-data');
	$sql = $DB->prepare("UPDATE insurance_form SET sent = ? WHERE id = ? ");
	$sql->execute(array(1,$unsent_data['id']));
	sleep( 10 );

endforeach;
