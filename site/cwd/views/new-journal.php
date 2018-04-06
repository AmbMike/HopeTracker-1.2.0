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

$Journal = new Journal();
$User = new User();
$Icon = new Icons();
$URL = new URL();
$Comments = new Comments();
$Session = new Sessions();

/** @var $ActiveLinkName : Set the active link value for line under link in nav*/
$ActiveLinkName = ( isset( $_GET['user_id'] ) ) ? 'Profile' : 'Community';

$Page = new \Page_Attr\Page();
$Page->header(array(
    'Title' => $Journal->user_profile( 'My Profile', ' Profile'),
    'Description' => 'Keep a journal and interact with other users about situations that happens in your life. ',
    'Active Link' => $ActiveLinkName
));

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
        <div class="col-md-8"  id="journal-new">
            <?php if(!isset($_GET['user_id'])): ?>
                <main>
                    <?php include_once (VIEWS . 'includes/journal/user-header.php'); ?>
                    <?php include_once (VIEWS . 'includes/journal/post-form.php'); ?>
                    <?php include_once (VIEWS . 'includes/journal/title-drop-menu.php'); ?>
                    <?php include_once (VIEWS . 'includes/journal/posts-content.php'); ?>
                    <?php include_once (VIEWS . 'includes/journal/activity-log.php'); ?>
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

