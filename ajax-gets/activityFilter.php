<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/hopetracker/config/constants.php');
require_once(CLASSES . 'class.ActivityFilter.php');
require_once(CLASSES . 'Sessions.php');
include_once( CLASSES . 'class.UserProfile.php' );
include_once( CLASSES . 'User.php' );

$UserProfile = new UserProfile();
$User = new User();
$Session = new Sessions();

/** Define the user's id to show related notifications */
$showUserId = $_GET['userId'];

$filterType = $_GET['activityType'];
$ActivityFilter = new ActivityFilter($filterType,$showUserId);

	switch ($filterType) :

		case 'myJournals':
			$ActivityFilterArray = $ActivityFilter->buildNotifications('myJournals');
		break;
		case 'chronological':
			require_once(CLASSES .'class.CommunityNotification.php');
			$CommunityNotification = new CommunityNotification($showUserId);
			$ActivityFilterArray = $CommunityNotification->buildNotifications();
		break;
		case 'followedUsers':
			$ActivityFilterArray = $ActivityFilter->buildNotifications('followedUsers');
		break;
		case 'inspirations':
			$ActivityFilterArray = $ActivityFilter->buildNotifications('inspirations');
		break;
		case 'followedUserJournal':
			$ActivityFilterArray = $ActivityFilter->buildNotifications('followedUserJournal');
		break;
		case 'askQuestionForum':
			$ActivityFilterArray = $ActivityFilter->buildNotifications('askQuestionForum');
		break;
		case 'answeredQuestions':
			$ActivityFilterArray = $ActivityFilter->buildNotifications('answeredQuestions');
		break;
		case 'likedMyAnswers':
			$ActivityFilterArray = $ActivityFilter->buildNotifications('likedMyAnswers');
		break;

	endswitch;
	if(count($ActivityFilterArray) > 0) :

	    /** Flatten out the notification array. */
	    $flattenNotificationArray = array();

	    /** Notification Array */
	    $notificationArr = $ActivityFilterArray;

	    foreach ($notificationArr as $childArray) {
	        foreach ($childArray as $value) {
	            $flattenNotificationArray[] = $value;
	        }
	    }

	    $sortedData = array();
	    foreach ($flattenNotificationArray  as $element) {
	        $timestamp = strtotime($element['LikedTimestamp']);
	        $date = date("d.m.Y", $timestamp); //truncate hours:minutes:seconds
	        if ( ! isSet($sortedData[$date]) ) { //first entry of that day
	            $sortedData[$date] = array($element);
	        } else { //just push current element onto existing array
	            $sortedData[$date][] = $element;
	        }
	    }
	    $today =  date("d.m.Y", time());

	    /** Revers notification array */
	    $sortedData = array_reverse( $sortedData );

	    /** Create date in array */
	    $datedArr = array();
	    $countUp = 0;
	    foreach ($sortedData as $key => $data) :
	        $datedArr[ $countUp ]['date'] = $key;
	        $datedArr[ $countUp ]['data'] = $data ;
	        $countUp++;

	    endforeach;

	    function date_compare($a, $b)
	    {
	        $t1 = strtotime($a['date']);
	        $t2 = strtotime($b['date']);
	        return $t1 - $t2;
	    }
	    usort($datedArr, 'date_compare');

	    /** Revers notification array */
	    $datedArr = array_reverse( $datedArr );
	    /**
	     * Run loop on all notifications constructed in the @class CommunityNotification.
	     */
	    foreach ($datedArr  as $key => $buildNotification) :
	            if($buildNotification['date'] == $today) :
	                echo '<span class="notification-date">' .  'Today' . '</span>';
	            else :
	                $strToTime = strtotime($buildNotification['date']);
	                $timeFormatted = date('F d',$strToTime);

	                echo '<span class="notification-date">' . $timeFormatted . '</span>';
	            endif;

	            echo '<div class="dotted-border-gray"></div>';

	        /** @var $buildNotification $item : gets into each type of notification array */
	        foreach ( $buildNotification['data'] as $notification) : ?>
                <div class="row-content">
	                    <!--<div class="col-md-12">
	                        <div class="dotted-border-gray"></div>
	                    </div>-->
	                    <div class="comments-container">
	                        <div class="table comments-table">
	                            <div class="cell">
	                               <!-- <p class="date"><?php /*echo date("M d, Y",strtotime($notification['LikedTimestamp']));*/?></p>-->
	                            </div>
	                            <div class="cell">
	                                <i class="fa <?php echo $notification['Icon']; ?> "></i>
	                            </div>
	                            <div class="cell">
	                                <?php echo $notification['TextValue']; ?>
	                            </div>
	                            <div class="cell" id="link-box">
	                                <div class="table background-transparent">
	                                    <div class="cell">
	                                        <?php
	                                        /** Generate image element if the item is an image not a username.  */
	                                        $imgPath =  $notification['liked_by_user_id'];
	                                        if(isset($notification['extraData']['folder'])):
	                                            ?>
	                                            <img src="<?php echo $notification['extraData']['fullPath']; ?>" class="inspiration-thumbnail">
	                                        <?php else:  ?>
	                                            <div class="contact-user text-right">
	                                                <a <?php echo $UserProfile->profile($notification['liked_by_user_id']); ?> <u><?php echo ucfirst(User::user_info('fname',$notification['liked_by_user_id'])); ?> <?php echo ucfirst(User::user_info('lname',$notification['liked_by_user_id'])); ?></u></a>
	                                            </div>
	                                        <?php endif; ?>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	        <?php endforeach; ?>
	    <?php endforeach; ?>
	<?php else: ?>
        No Results.
	<?php endif; ?>
