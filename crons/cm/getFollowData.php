<?php

if (!defined('ABSPATH')) {
    define('ABSPATH', $_SERVER['DOCUMENT_ROOT'] . '/hopetracker/');
}

require_once(ABSPATH . 'config/constants.php');
require_once(ABSPATH . 'classes/GetData/FollowData.php');
require_once ABSPATH . 'campaign-monitor-api/csrest_campaigns.php';
require_once ABSPATH . 'campaign-monitor-api/csrest_general.php';
require_once ABSPATH . 'campaign-monitor-api/csrest_clients.php';
require_once ABSPATH . 'campaign-monitor-api/csrest_subscribers.php';
require_once(CLASSES . 'User.php');
require_once(CLASSES . 'General.php');

$User = new User();
$General = new General();
$FollowData = new FollowData();
$AuthorFollowArr =  $FollowData->build();


//Debug::data( $FollowQuestionArr );
$FollowQuestionArr = $AuthorFollowArr;
/** Run loop on all users with a "recordedUpdated" status to 0,
 * meaning the user has either never been recorded in campaign monitor
 * or the user has updated their account.
 */

/* Add the user's data to Campaign Monitor*/
/** @object  $wrap : core object for campaign monitor */

$wrap = new CS_REST_Subscribers('da4bedec312b6e598a119950df0bac40', '29a644cdec042cb0fb39f389f20afc9a');
foreach ($FollowQuestionArr as $FollowQuestion):
    //Debug::data($FollowQuestion['Email address of follower']);
    /** Suppressed Emails */
    if($FollowQuestion['Email address of follower'] != 'Mjgseb@gmail.com'):
        /** @var  $value : loops through each record that has not been sent to CM. */
        $result = $wrap->add(array(
            'Name' => $FollowQuestion['Name of follower'],
            'EmailAddress' => $FollowQuestion['Email address of follower'],
            "CustomFields" => array(
                array(
                    'Key' => 'Dateoffirstquestionfollowed',
                    'Value' => $FollowQuestion['Date of first question followed']
                ),
                array(
                    'Key' => 'Firstquestionfollowed',
                    'Value' => $FollowQuestion['First question followed']
                ),
                array(
                    'Key' => 'Dateoffirstanswerforfirstquestionfollowed',
                    'Value' => $FollowQuestion['Date of first answer for first question followed']
                ),
                array(
                    'Key' => 'Authoroffirstanswerforfirstquestionfollowed',
                    'Value' => $FollowQuestion['Author of first answer for first question followed']
                ),
                array(
                    'Key' => 'Firstanswerforfirstquestionfollowed',
                    'Value' => $FollowQuestion['First answer for first question followed']
                ),
                array(
                    'Key' => 'URLtoquestionoffirstquestionfollowed',
                    'Value' => $FollowQuestion['URL to question of first question followed']
                ),
                array(
                    'Key' => 'Answercountoffirstquestionfollowed',
                    'Value' => $FollowQuestion['Answer count of first question followed']
                ),
                array(
                    'Key' => 'Authoroflatestansweroffirstquestionfollowed',
                    'Value' => $FollowQuestion['Author of latest answer of first question followed']
                ),
                array(
                    'Key' => 'Latestanswertextoffirstquestionasked',
                    'Value' => $FollowQuestion['Latest answer text of first question asked']
                ),
                array(
                    'Key' => 'DateofLatestquestionasked',
                    'Value' => $FollowQuestion['Date of Latest question asked']
                ),
                array(
                    'Key' => 'Latestquestionaskedtext',
                    'Value' => $FollowQuestion['Latest question asked text']
                ),
                array(
                    'Key' => 'Dateoffirstanswerforlatestquestionasked',
                    'Value' => $FollowQuestion['Date of first answer for latest question asked']
                ),
                array(
                    'Key' => 'Authoroffirstanswerforlatestquestionasked',
                    'Value' => $FollowQuestion['Author of first answer for latest question asked']
                ),
                array(
                    'Key' => 'Firstanswertextforlatestquestionasked',
                    'Value' => $FollowQuestion['First answer text for latest question asked']
                ),
                array(
                    'Key' => 'URLtolatestquestionasked',
                    'Value' => $FollowQuestion['URL to latest question asked']
                ),
                array(
                    'Key' => 'Answercountoflatestquestionasked',
                    'Value' => $FollowQuestion['Answer count of latest question asked']
                ),
                array(
                    'Key' => 'Authoroflatestansweroflatestquestionasked',
                    'Value' => $FollowQuestion['Author of latest answer of latest question asked']
                ),
                array(
                    'Key' => 'Latestanswertextoflatestquestionasked',
                    'Value' => $FollowQuestion['Latest answer text of latest question asked']
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
    endif;


endforeach;
