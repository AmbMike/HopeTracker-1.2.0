<?php
if (!defined('ABSPATH')) {
    define('ABSPATH', $_SERVER['DOCUMENT_ROOT'] . '/hopetracker/');
}
require_once(ABSPATH . 'config/constants.php');

require_once(CLASSES . 'Emails.php');

require_once(CLASSES . 'class.ForumQuestions.php');
$ForumQuestions = new ForumQuestions();
$Emails = new Emails();
if(count($ForumQuestions->getQuestions(true) )){
    foreach($ForumQuestions->getQuestions(true) as $question){
        $Emails->sendInitialPostEmail($question['id'],$question['user_id'],$question['question'],$question['subcategory'],$question['date_created'],$question['category']);
        sleep(3);
    }
}

//$Emails->sendInitialPostEmail();
