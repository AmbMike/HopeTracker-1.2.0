

<?php
/**
 * Created by PhpStorm.
 * User: pauld
 * Date: 8/4/2017
 * Time: 12:35 PM
 */;
?>
<?php
include_once(CLASSES .'CommunityLog.php');
include_once(CLASSES .'Forum.php');
include_once(CLASSES .'ForumFollowedCategory.php');
include_once(CLASSES .'class.ForumReplies.php');
include_once(CLASSES .'class.CommunityNotification.php');
include_once(CLASSES .'class.newComment.php');
include_once(CLASSES .'class.LikedForum.php');

$Page = new \Page_Attr\Page();
$Forum = new Forum();
$CommunityLog = new CommunityLog();
$Session = new Sessions();
$General = new General();
$User = new User();
$ForumPost = new ForumFollowedCategory();
$ForumReplies = new ForumReplies($Session->get('user-id'));
$Notifications = new CommunityNotification($Session->get('user-id'));
$LikedForum = new LikedForum();
$NewComment = new newComment($Session->get('user-id'));

$Page->header(array(
    'Title' => 'Community-log',
    'Description' => 'Keep your information logged for better organization. ',
));

//Debug::data($CommunityLog->new_forum_from_followed_users());
?>
<div class="con main" id="community-log">
    <div class="row">
        <div class="col-md-8">
            <main>
                <section class="box-one">
                    <div class="inside-box">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="h1-box">
                                    <h1 class="green-heading-lg community-header">Community Log</h1>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="posts-dropdown-box">
                                    <span class="count-updates"><span class="count">140</span> Updates</span>
                                    <div class="customized-select-box">
                                        <div class="customized-select text-left"><span>Newest</span></div>
                                        <div class="custom-drop-box">
                                            <ul class="checkbox text-left">
                                                <li>My Journal</li>
                                                <li>Journals I Follow</li>
                                                <li>My Forums</li>
                                                <li>Forums I Follow</li>
                                                <li>Followers I Added</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if(count($Notifications->buildNotifications()) > 0) :
                        /**
                         * Run loop on all notifications constructed in the @class CommunityNotification.
                         */
                            foreach ($Notifications->buildNotifications() as $buildNotification) :

                                /** @var $buildNotification $item : gets into each type of notification array */
                                foreach ( $buildNotification as $notification) :  ?>
                                    <div class="row">
                                        <div class="row-content">
                                            <div class="col-md-12">
                                                <div class="dotted-border-gray"></div>
                                            </div>
                                            <div class="comments-container">
                                                <div class="table comments-table">
                                                    <div class="cell">
                                                        <p class="date"><?php echo date("M d, Y",strtotime($notification['LikedTimestamp']));?></p>
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
                                                                <span class="oval-icon"></span>
                                                            </div>
                                                            <div class="cell">
                                                                <div class="contact-user">
                                                                    <a><u><?php echo ucfirst(User::user_info('fname',$notification['liked_by_user_id'])); ?> <?php echo ucfirst(User::user_info('lname',$notification['liked_by_user_id'])); ?></u></a>
                                                                    <?php if($User->is_user_still_logged_in($notification['liked_by_user_id']) == true): ?>
                                                                        <a class="save-btn blue text-center">Chat</a>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                            <?php endforeach; ?>

                         <?php endif; ?>

                    </div>
                </section>
            </main>
        </div>
        <div class="col-md-4 sidebar-box">
            <aside>
                <?php include(SIDEBAR); ?>
            </aside>
        </div>
    </div>
</div>