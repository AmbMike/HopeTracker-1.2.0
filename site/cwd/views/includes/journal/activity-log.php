<?php

include_once( CLASSES . 'class.Notifications.php' );

$Notifications = new  Notifications();


$sortedData = array();
foreach ($Notifications->GetNotification()  as $element) {
	$timestamp = strtotime($element['timestamp']);
	$date = date("d.m.Y", $timestamp); //truncate hours:minutes:seconds
	if ( ! isSet($sortedData[$date]) ) { //first entry of that day
		$sortedData[$date] = array($element);
	} else { //just push current element onto existing array
		$sortedData[$date][] = $element;
    }
}
$today =  date("d.m.Y", time());

foreach ($sortedData as $key => $data):
    if($key = $today) :
	    echo "Today";

    else :
	    $strToTime = strtotime($key);
	    $timeFormatted = date('F d',$strToTime);
	    echo $timeFormatted;
    endif;
endforeach;

?>

<section id="journal-activity-log" class="box-one">

    <div class="activity-title-box">
        <div class="table first-table">
            <div class="cell first">
                <img src="/site/public/images/main/icon.jpg" class="img-circle profile-img">
            </div>
            <div class="cell second">
                <span class="activity-title">Activity Log</span>
            </div>
            <div class="cell third">
                <span class="drop-text">Activity Chronological</span>
            </div>
        </div>
    </div>
    <div id="activity-content">
        <hr>
        <div class="table second-table">
            <div class="date">
                Today
            </div>
            <div class="cell first">
                <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
            </div>
            <div class="cell second">
                <div class="liked-text-box">Your journal post <span class="liked-activity-title">My thoughts about how to take care of me</span> recieved <span class="liked-count">2 likes</span></div>
            </div>
            <div class="cell third">
                <div class="user-list-box">
                    <span class="liked-user">MsVioletBrown</span>
                    <span class="liked-user">GregoryIsaacsDC</span>
                </div>
            </div>
        </div>
        <hr>
        <div class="table second-table">
            <div class="date">
                December 14
            </div>
            <div class="cell first">
                <div class="user-img-box">
                    <img src="/<?php echo (User::user_info('profile_img')) ? : DEFAULT_PROFILE_IMG; ?>" class="img-circle profile-img">
                </div>
            </div>
            <div class="cell second followed-by">
                <div class="simple-heading user-name">
                    <?php echo User::user_info('username'); ?>
                    <span class="following-text">is now following</span>
                    <span class="simple-heading followed-user"><?php echo User::user_info('username'); ?></span>
                </div>
            </div>
        </div>
        <div class="table second-table">
            <div class="cell first">
                <i class="fa fa-comment-o" aria-hidden="true"></i>
            </div>
            <div class="cell second">
                <div class="comment-text-box">Your journal post <span class="comment-activity-title">My thoughts about how to take care of me</span> recieved <span class="comment-count">a comment</span>
                </div>
            </div>
            <div class="cell third">
                <div class="user-list-box">
                    <span class="liked-user">MsVioletBrown</span>
                </div>
            </div>
        </div>
        <hr>
        <div class="table second-table">
            <div class="date">
                October 31
            </div>
            <div class="cell first">
                <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
            </div>
            <div class="cell second">
                <div class="inspired-text-box"><span class="simple-heading inspired-like-by"><?php echo User::user_info('username'); ?></span> and <span class="simple-heading inspired-like-by"><?php echo User::user_info('username'); ?></span> liked the<span class="inspired-daily"> Inspiration of the Day</span>
                </div>
            </div>
            <div class="cell third">
                <div class="inspired-img-box">
                    <a class="wrap" href="/inspiration/"> <img src="/site/public/images/quotes/self-care.forgive_yourself.jpg" class="img-responsive"></a>
                </div>
            </div>
        </div>
    </div>
</section>