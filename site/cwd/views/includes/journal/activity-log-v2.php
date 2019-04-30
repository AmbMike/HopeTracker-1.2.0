

<?php
/**
 * Created by PhpStorm.
 * User: pauld
 * Date: 8/4/2017
 * Time: 12:35 PM
 */;
?>
<?php

include_once(CLASSES .'class.CommunityNotification.php');
include_once( CLASSES . 'class.UserProfile.php' );

$UserProfile = new UserProfile();

$Page = new \Page_Attr\Page();
$Session = new Sessions();
$General = new General();
$User = new User();

/** Define the user's id to show related notifications */
if(isset($_GET['userId'])){
	$showUserId = $_GET['userId'];
}else{
    $showUserId = $Session->get('user-id');
}
$Notifications = new CommunityNotification($showUserId);

$Page->header(array(
	'Title' => 'Community-log',
	'Description' => 'Keep your information logged for better organization. ',
));

?>
<div id="community-log">
    <section class="box-one">
        <div id="journal-activity-log" class="inside-box">
            <div class="activity-title-box">
                <div class="active-log-header">
                    <img src="<?php echo IMAGES; ?>main/icon.jpg" class="img-circle profile-img">
                    <span class="activity-title">Activity Log</span>
                    <div class="dropdown pull-right">
                        <button class="btn btn-white dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
                            <span id="filter-label">Activity Chronological</span>
                        </button>
                        <ul id="activity-filter" data-activity-filter class="dropdown-menu" data-userId="<?php echo $showUserId; ?>">
                            <li data-activity-item="chronological"><a class="cursor-pointer" ><i class="fa fa-bookmark" aria-hidden="true"></i> <span class="filter-name">Activity Chronological</span></a></li>
                            <li data-activity-item="myJournals"><a class="cursor-pointer" ><i class="fa fa-bookmark" aria-hidden="true"></i> <span class="filter-name">My Journals</span></a></li>
                            <li data-activity-item="followedUsers"><a class="cursor-pointer" ><i class="fa fa-bookmark" aria-hidden="true"></i> <span class="filter-name">Followed Users</span></a></li>
                            <li data-activity-item="inspirations"><a class="cursor-pointer" ><i class="fa fa-bookmark" aria-hidden="true"></i> <span class="filter-name">Inspirations</span></a></li>
                            <li data-activity-item="followedUserJournal"><a class="cursor-pointer" ><i class="fa fa-bookmark" aria-hidden="true"></i> <span class="filter-name">Followed User Journals</span></a></li>
                            <li data-activity-item="askQuestionForum"><a class="cursor-pointer" ><i class="fa fa-bookmark" aria-hidden="true"></i> <span class="filter-name">Answers to Followed Questions</span></a></li>
                            <li data-activity-item="answeredQuestions"><a class="cursor-pointer" ><i class="fa fa-bookmark" aria-hidden="true"></i> <span class="filter-name">My Answered Questions</span></a></li>
                            <li data-activity-item="likedMyAnswers"><a class="cursor-pointer" ><i class="fa fa-bookmark" aria-hidden="true"></i> <span class="filter-name">Likes on My Answers</span></a></li>
                        </ul>
                    </div>
                </div>

            </div>
            <div id="activity-notification-outer">
                <div id="activity-notification-inner">
	                <?php if(count($Notifications->buildNotifications()) > 0) :

		                /** Flatten out the notification array. */
		                $flattenNotificationArray = array();

		                /** Notification Array */
		                $notificationArr = $Notifications->buildNotifications();

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
                                                <?php
                                                /** Generate image element if the item is an image not a username.  */
                                                $imgPath =  $notification['liked_by_user_id'];
                                                if(isset($notification['extraData']['folder'])):
                                                    ?>
                                                    <img src="<?php echo $notification['extraData']['fullPath']; ?>" class="inspiration-thumbnail">
                                                <?php else:  ?>
                                                    <a <?php echo $UserProfile->profile($notification['liked_by_user_id']); ?> <u><?php echo (User::isAnonymousUser($notification['liked_by_user_id'])) ? 'Anonymous': User::Username($notification['liked_by_user_id']); ?> </u></a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
			                <?php endforeach; ?>
		                <?php endforeach; ?>
                        <?php else: ?>
                        No Results.
	                <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>