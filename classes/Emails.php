<?php

/**
 * File For: HopeTracker.com
 * File Name: Emails.php.
 * Author: Mike Giammattei
 * Created On: 7/14/2017, 12:21 PM
 */
if (!defined('ABSPATH')) {
    define('ABSPATH', $_SERVER['DOCUMENT_ROOT'] . '/hopetracker');
}
include_once(ABSPATH.'/config/constants.php');
include_once(CLASSES . 'Database.php');
include_once(CLASSES . 'Sessions.php');
include_once(CLASSES . 'General.php');
include_once(CLASSES . 'User.php');
include_once(CLASSES . 'Email.php');


class Emails{
    public function upload_chat_emails($data){
        $db = new Database();
        $Session = new Sessions();
        $General = new General();

        $sql = $db->prepare("INSERT INTO emails_from_chat (sender_user_id, receiver_user_id, message, ip) VALUES (?,?,?,?)");
        $sql->execute(array(
            $Session->get('user-id'),
            $data['receiver_id'],
            $data['message'],
            $General->getUserIP()
        ));
    }
    public function update_sent_chat_emails($sent_status,$id){
        $db = new Database();
        $sql = $db->prepare("UPDATE emails_from_chat SET sent_status = ? WHERE id = ?  ");
        $sql->execute(array($sent_status,$id));
        return $sql->fetchAll();
    }
    public function get_non_sent_chat_emails(){
        $db = new Database();
        $sql = $db->prepare("SELECT * FROM emails_from_chat WHERE sent_status = 0 ORDER BY id ASC ");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();
        return $sql->fetchAll();
    }
    public function send_chat_emails(){
        $User = new User();
        $Email = new Email();

        /* Put email data list into a grouped array */
        $grouped_emails = array();
        foreach($this->get_non_sent_chat_emails() as $type){
            $grouped_emails[$type['receiver_user_id']][] = $type;
        }

        /* Format email with users information */
        $email_formatted = array();

        $grouped_emails = array_values($grouped_emails);
        foreach($grouped_emails as $index => $format_email){

            foreach ($format_email as $index2 => $email_item) {
                $email_formatted[$index][$index2]['msg_id'] = $format_email[$index2]['id'];
                $email_formatted[$index][$index2]['receiver_user_id'] = $format_email[$index2]['receiver_user_id'];
                $email_formatted[$index][$index2]['receiver_email'] = $User->user_info('email',$format_email[$index2]['receiver_user_id']);
                $email_formatted[$index][$index2]['timestamp'] = date("F j, Y, g:i a",strtotime($email_item['TIMESTAMP']));
                $email_formatted[$index][$index2]['senders_fname'] = $User->user_info('fname',$email_item['sender_user_id']);
                $email_formatted[$index][$index2]['senders_lname'] = $User->user_info('lname',$email_item['sender_user_id']);
                $email_formatted[$index][$index2]['senders_email'] = $User->user_info('email',$email_item['sender_user_id']);
                $email_formatted[$index][$index2]['message'] = $email_item['message'];
            }

        }


        $messages_box = array();
        $delete_msg_ids = array();
        foreach ($email_formatted as $index => $send_email){
            $messages = array();
            $senders_name = $send_email[0]['senders_fname'];
            $senders_email = $send_email[0]['senders_email'];
            $receivers_name = $User->user_info('fname',$send_email[0]['receiver_user_id']);
            $receivers_email = $send_email[0]['receiver_email'];

            foreach($send_email as $index2 => $email_data){
                $delete_msg_ids[] = $email_data['msg_id'];
                $senders_name = $email_data['senders_fname'];
                $senders_email = $email_data['senders_email'];
                $receivers_name = $User->user_info('fname',$email_data['receiver_user_id']);
                $receivers_email = $email_data['receiver_email'];
                $subject = 'New Chat Message From ' . $senders_name . ' on HopeTrack.com';

                $messages[$index2]['message'] = $email_data['message'];
                $messages[$index2]['date_time'] = $email_data['timestamp'];

            }
            /* covert the messages array into a string to be compatible with the mailer. */
            $msg_str = '';
            foreach ($messages as $message) : ?>
            <?php $msg_str .='<tr><td><strong>'.$message['date_time'].'</strong><br>'.$message['message'].'<hr></td></tr>';
            endforeach;
                $Email->send_general_email($receivers_email,$senders_name,$senders_email,$subject,$receivers_name,$msg_str);
                sleep(1);
        }
        /* Update all sent messages to be updated as sent value 1 */
        foreach ($delete_msg_ids as $delete_msg_id) {
            $this->update_sent_chat_emails(1,$delete_msg_id);
        }
    }

    public function sendInitialPostEmail($id,$userId,$question,$subcategory,$dateCreated,$category){
        error_reporting(3);
        date_default_timezone_set("America/New_York");

        @$Email = new Email();
        $User = new User();
        $General = new General();

        $linkToPost = BASE_URL.'/' . 'forum/' .  $General->url_safe_string( $subcategory). '/'. $id . '/' .$General->url_safe_string( $question);

        $receivers_email = 'mjgseb@gmail.com';
        $senders_name = 'Hope Tracker';
        $senders_email = 'sendhopetracker@gmail.com';
        $subject = 'New Question Posted Recently';
        $receivers_name = 'Hope Tracker';
        $msg_str =  '<h2>'.User::full_name($userId) . ' has asked a question. </h2>';
        $msg_str .= '<p>View and reply to the comment here: <a href="' . $linkToPost . '">'.$linkToPost.'</a></p>';
        $msg_str .=  '<br>';
        $msg_str .=  '<p><b>Timestamp of submission:</b> '. date("F j, Y, g:i a",$dateCreated) .'</p>';

        $Email->send_general_email('Wellness@ambrosiatc.com',User::full_name($userId),User::users_email($userId),$subject,$receivers_name,$msg_str,'initiated-forum-post');
        $Email->send_general_email('mgiammattei@ambrosiatc.com',$senders_name,$senders_email,$subject,$receivers_name,$msg_str,'initiated-forum-post');

        require_once(CLASSES . 'class.ForumQuestions.php');
        $ForumQuestions = new ForumQuestions();

        $ForumQuestions->markAsEmailed($id);
    }
}