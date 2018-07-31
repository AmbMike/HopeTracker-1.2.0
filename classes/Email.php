<?php

/**
 * File For: HopeTracker.com
 * File Name: Email.php.
 * Author: Mike Giammattei
 * Created On: 4/6/2017, 10:47 AM
 */
if (!defined('ABSPATH')) {
    define('ABSPATH', $_SERVER['DOCUMENT_ROOT'] . '/hopetracker');
}
include_once(ABSPATH.'/config/constants.php');
include_once(LIBS . 'phpMailer/PHPMailerAutoload.php');
include_once(CLASSES . 'Debug.php');
include_once(CLASSES . 'Mailer.php');
include_once(CLASSES . 'Message.php');

$mailer = new PHPMailer;

$mailer->isSMTP();
$mailer->SMTPAuth = true;
$mailer->Host = 'smtp.gmail.com';
$mailer->SMTPSecure = 'ssl';
$mailer->Port = '465';
$mailer->Username = 'sendhopetracker@gmail.com';
$mailer->Password = 'X?{,O._(U@w0';
$mailer->From = "sendhopetracker@gmail.com";
$mailer->FromName = 'Hope Tracker';
$mailer->isHTML(true);


class Email extends Mailer {
    var $toMail = '';
    var $mailSubject = '';

    public function send_email($recipient_email,$subject,$name,$link){
        $this->toMail = $recipient_email;
        $this->mailSubject = $subject;

        include_once(ABSOLUTE_PATH_NO_END_SLASH.'/config/constants.php');
        include_once(LIBS . 'phpMailer/PHPMailerAutoload.php');
        include_once(CLASSES . 'Debug.php');
        include_once(CLASSES . 'Mailer.php');
        include_once(CLASSES . 'Message.php');

        $mailer = new PHPMailer;

        $mailer->isSMTP();
        $mailer->SMTPAuth = true;
        $mailer->Host = 'smtp.gmail.com';
        $mailer->SMTPSecure = 'ssl';
        $mailer->Port = '465';
        $mailer->Username = 'sendhopetracker@gmail.com';
        $mailer->Password = 'X?{,O._(U@w0';
        $mailer->From = "sendhopetracker@gmail.com";
        $mailer->FromName = 'Hope Tracker';
        $mailer->isHTML(true);

        $mail = new Mailer($mailer);
        $mail->send(VIEWS .'emails/reset-password.php',['name' => $name,'base_url' => BASE_URL,'target_url' => $link], function ($m){

            $m->to($this->toMail);
            $m->subject($this->mailSubject);
        });
    }
    public function send_general_email($receivers_email,$senders_name,$senders_email,$subject,$receivers_name,$messages,$template = false){
        $this->toMail = $receivers_email;
        $this->mailSubject = $subject;

        include_once(ABSOLUTE_PATH_NO_END_SLASH.'/config/constants.php');
        include_once(LIBS . 'phpMailer/PHPMailerAutoload.php');
        include_once(CLASSES . 'Debug.php');
        include_once(CLASSES . 'Mailer.php');
        include_once(CLASSES . 'Message.php');

        $mailer = new PHPMailer;

        $mailer->isSMTP();
        $mailer->SMTPAuth = true;
        $mailer->Host = 'smtp.gmail.com';
        $mailer->SMTPSecure = 'ssl';
        $mailer->Port = '465';
        $mailer->Username = 'sendhopetracker@gmail.com';
        $mailer->Password = 'X?{,O._(U@w0';
        $mailer->From = "sendhopetracker@gmail.com";
        $mailer->FromName = 'Hope Tracker';
        $mailer->isHTML(true);

        $mail = new Mailer($mailer);

        if($template == false) :
	        $mail->send(VIEWS .'emails/chat-email.php',['senders_name' => $senders_name,'senders_email' => $senders_email,'base_url' => BASE_URL,'sent_msg' => $messages], function ($m){

		        $m->to($this->toMail);
		        $m->subject($this->mailSubject);
	        });
        else:
	        $mail->send(VIEWS .'emails/'.$template.'.php',['senders_name' => $senders_name,'senders_email' => $senders_email,'base_url' => BASE_URL,'sent_msg' => $messages], function ($m){

		        $m->to($this->toMail);
		        $m->subject($this->mailSubject);
	        });
        endif;



    }
}