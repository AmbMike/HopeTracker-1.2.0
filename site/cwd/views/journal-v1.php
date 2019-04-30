<?php
/**
 * File For: HopeTracker.com
 * File Name: journal.php.
 * Author: Mike Giammattei Paul Giammattei
 * Created On: 4/18/2017, 1:17 PM
 */;
?>
<?php
include_once(CLASSES .'/Journal.php');
include_once(CLASSES .'/Icons.php');
include_once(CLASSES .'/Comments.php');
include_once(CLASSES .'/Sessions.php');
include_once(CLASSES .'class.CommunityNotification.php');

$Journal = new Journal();
$User = new User();
$Icon = new Icons();
$URL = new URL();
$Comments = new Comments();
$Session = new Sessions();

/** @var $ActiveLinkName : Set the active link value for line under link in nav*/
if(isset($_GET['profileActive'])){
	$ActiveLinkName = 'Profile';
}else{
	$ActiveLinkName = ( isset( $_GET['userId'] ) ) ? 'Profile' : 'Community';
}


$Page = new \Page_Attr\Page();
$Page->header(array(
    'Title' => $Journal->user_profile( 'My Profile', ' Profile'),
    'Description' => 'Keep a journal and interact with other users about situations that happens in your life. ',
    'Active Link' => $ActiveLinkName
));

$Notifications = new CommunityNotification($Session->get('user-id'));

/* Entry Title Text */
$entry_title = ($_GET['entry_type']) ? : '';
$placeholder_content = 'Begin typing here...';
switch ($entry_title):

    case 'journalOutlet' :
        $entry_title = "My ". ucfirst($User->user_concerned_about(User::user_info('concerned_about'))) ."'s Situation & How I Feel";
        $placeholder_content = "Tell the whole story of your ". ucfirst($User->user_concerned_about(User::user_info('concerned_about'))) ."'s addiction. How do you feel? - Let it out ";
        break;
    case 'stop_enabling' :
        $entry_title = 'I\'m Going to Stop Enabling My '. ucfirst($User->user_concerned_about(User::user_info('concerned_about')));
        $placeholder_content = "What have you done that was clearly (or probably) enabling? Are there behaviors you'll change moving forward? - Be Honest";
        break;
    case 'my_boundaries' :
        $entry_title = 'My Boundaries: What\'s Not Acceptable';
        $placeholder_content = "What behaviors bother you most? What will you do if those behaviors continue? - Set Boundaries";
        break;
    case 'my_intervention' :
        $entry_title = 'My Intervention Plan | Date, People, Rehab, Counter-Points';
        $placeholder_content = "Where? When? Who should be there? What are you going to say? How can you respond to your ".ucfirst($User->user_concerned_about(User::user_info('concerned_about')))."'s push-back? - Be Prepared ";
        break;
    case 'grateful_for' :
        $entry_title = "10 Things I'm Grateful for in Life";
        $placeholder_content = "What are you grateful for in life? - Stay Positive";
        break;
    case 'refused_treatment' :
        $entry_title = 'How I Feel After My '.ucfirst($User->user_concerned_about(User::user_info('concerned_about'))).' Refused Treatment';
        $placeholder_content = "What are you feeling? What is causing those feelings (at a deeper level)? What can you do (and not do) to help feel better? - Move toward Happiness";
        break;
    case 'be_Proactive' :
        $entry_title = '10 Things I\'m Grateful For & A Plan for Positivity';
        $placeholder_content = "What are 10 things you're grateful for? What changes are you going to be more positive? - Be Proactive";
        break;
    case 'my_progress' :
        $entry_title = 'My Progress so Far';
        $placeholder_content = "How do you feel differently now that you know more about addiction? How are you feeling? - Update";
        break;
    default : $entry_title = '';
endswitch;
?>
<div class="con main">
    <div class="row">
        <div class="col-md-8" id="journal-new">
            <?php if(!isset($_GET['journal_id'])) : ?>
            <main>
                <?php if($Session->get('logged_in') == 1) :

                        /** Show form and user header if is the user's profile */
                        if(!isset($_GET['userId']) || isset($_GET['entry_type'])):
                            include_once (VIEWS . 'includes/journal/user-header.php');
                            include_once (VIEWS . 'includes/journal/post-form.php');

                            /** Other user profile */
                            else:
                                include_once (VIEWS . 'includes/journal/non-user-header.php');
                        endif;
                    endif;
                ?>
                <?php //include_once (VIEWS . 'includes/journal/title-drop-menu.php'); ?>
                <?php //include_once (VIEWS . 'includes/journal/posts-content.php'); ?>
                <div id="related-post-out">
                    <div id="related-post" data-no-lazy-load-posts>
                        <?php $usersJournal = true; ?>
                        <?php include_once(VIEWS . 'includes/journal/postsV1.php'); ?>
                    </div>
                </div>
                <div id="post-feeder"></div>
                <?php if($Session->get('logged_in') == 1 ) : User::isAnonymousUser(1);
                    include_once (VIEWS . 'includes/journal/activity-log-v2.php');
                    endif;
                ?>
            </main>
            <?php else: ?>
            <main>
	            <?php include_once(VIEWS . 'includes/journal/postsV1.php'); ?>
            </main>
            <?php endif; ?>
        </div>
        <div class="col-md-4 sidebar-box">
            <aside>
                <?php include(SIDEBAR);?>
            </aside>
        </div>
    </div>
</div>