<?php

if (!defined('ABSPATH')) {
    define('ABSPATH', $_SERVER['DOCUMENT_ROOT'] . '/hopetracker/');
}
require_once(ABSPATH . 'config/constants.php');
require_once(ABSPATH . 'classes/GetData/QuestionData.php');
require_once ABSPATH . 'campaign-monitor-api/csrest_campaigns.php';
require_once ABSPATH . 'campaign-monitor-api/csrest_general.php';
require_once ABSPATH . 'campaign-monitor-api/csrest_clients.php';
require_once ABSPATH . 'campaign-monitor-api/csrest_subscribers.php';
require_once(CLASSES . 'User.php');
require_once(CLASSES . 'General.php');

$User = new User();
$General = new General();
$QuestionData = new QuestionData();
$AuthorQuestionArr =  $QuestionData->build();


//Debug::data( $AuthorQuestionArr ); exit;

/** Run loop on all users with a "recordedUpdated" status to 0,
 * meaning the user has either never been recorded in campaign monitor
 * or the user has updated their account.
 */

/* Add the user's data to Campaign Monitor*/
/** @object  $wrap : core object for campaign monitor */

$wrap = new CS_REST_Subscribers('586deb4c4d517f0e35f7b701d0423bde', '29a644cdec042cb0fb39f389f20afc9a');
foreach ($AuthorQuestionArr as $AuthorQuestion):

    /** @var  $value : loops through each record that has not been sent to CM. */
    $result = $wrap->add(array(
        'Name' => $AuthorQuestion['Author Name'],
        'EmailAddress' => $AuthorQuestion['Author Email'],
        "CustomFields" => array(
            array(
                'Key' => 'Dateoffirstquestionasked',
                'Value' => $AuthorQuestion['Date of first question asked']
            ),
            array(
                'Key' => 'Firstquestionaskedtext',
                'Value' => $AuthorQuestion['First question asked text']
            ),
            array(
                'Key' => 'Dateoffirstanswerforfirstquestionasked',
                'Value' => $AuthorQuestion['Date of first answer for first question asked']
            ),
            array(
                'Key' => 'Authoroffirstanswerforfirstquestionasked',
                'Value' => $AuthorQuestion['Author of first answer for first question asked']
            ),
            array(
                'Key' => 'Firstanswertextforfirstquestionasked',
                'Value' => $AuthorQuestion['First answer text for first question asked']
            ),
            array(
                'Key' => 'URLtoquestionoffirstquestionasked',
                'Value' => $AuthorQuestion['URL to question of first question asked']
            ),
            array(
                'Key' => 'Answercountoffirstquestionasked',
                'Value' => $AuthorQuestion['Answer count of first question asked']
            ),
            array(
                'Key' => 'Authoroflatestanswerforfirstquestionasked',
                'Value' => $AuthorQuestion['Author of latest answer of first question asked']
            ),
            array(
                'Key' => 'Latestanswertextoffirstquestionasked',
                'Value' => $AuthorQuestion['Latest answer text of first question asked']
            ),
            array(
                'Key' => 'DateofLatestquestionasked',
                'Value' => $AuthorQuestion['Date of Latest question asked']
            ),
            array(
                'Key' => 'Latestquestionaskedtext',
                'Value' => $AuthorQuestion['Latest question asked text']
            ),
            array(
                'Key' => 'Dateoffirstanswerforlatestquestionasked',
                'Value' => $AuthorQuestion['Date of first answer for latest question asked']
            ),
            array(
                'Key' => 'Authoroffirstanswerforlatestquestionasked',
                'Value' => $AuthorQuestion['Author of first answer for latest question asked']
            ),
            array(
                'Key' => 'Firstanswertextforlatestquestionasked',
                'Value' => $AuthorQuestion['First answer text for latest question asked']
            ),
            array(
                'Key' => 'URLtolatestquestionasked',
                'Value' => $AuthorQuestion['URL to latest question asked']
            ),
            array(
                'Key' => 'Answercountoflatestquestionasked',
                'Value' => $AuthorQuestion['Answer count of latest question asked']
            ),
            array(
                'Key' => 'Authoroflatestansweroflatestquestionasked',
                'Value' => $AuthorQuestion['Author of latest answer of latest question asked']
            ),
            array(
                'Key' => 'Latestanswertextoflatestquestionasked',
                'Value' => $AuthorQuestion['Latest answer text of latest question asked']
            )
        ),


    ));
    if($result->was_successful()) {
        echo "Recorded to Campaign Monitor. \n";


    } else {
        echo 'Failed with code '.$result->http_status_code."\n<br /><pre>";
        var_dump($result->response);
        echo '</pre>';
        error_log("Campaign Monitor : invite friend failed!" .$result->http_status_code. "errors: ".$result->response , 0);
    }
endforeach;
