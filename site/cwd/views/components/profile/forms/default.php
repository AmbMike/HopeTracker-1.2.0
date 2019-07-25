<?php
/**
 * FileName: session-1.php
 * Description:
 *
 * Created by: Ambrosia Digital Team.
 * Author: Michael Giammattei
 * Date: 7/9/2019
 */

include_once(CLASSES . 'Profile/CommunityUpdate.php');
include_once(CLASSES . 'class.FollowedPost.php');
include_once(CLASSES . 'class.LikePost.php');
include_once(CLASSES . 'Profile/NewComments.php');
$FollowedPost = new FollowedPost();
$CommunityUpdate = new Profile\CommunityUpdate();
$courseSession = 0;

?>

<div class="panel panel-default i-default-journal-panel" id="i-default-journal-panel">
    <div class="panel-heading tooltip-mg" data-pt-title="Post to the community for support and encouragement or on Facebook to remind those around you that they're not alone" data-pt-gravity="top" data-pt-animate="jello" data-pt-scheme="black" data-pt-size="small" role="button" data-toggle="collapse" data-target="#i-journal-panel-default">
        <div class="s-table">
            <div class="s-cell">
                <span class="s-title">Community Updates</span>
            </div>
            <?php if($CommunityUpdate->totalComments): ?>
            <div class="s-cell text-right">
                <?php $newCommentTotal = $CommunityUpdate->totalComments; ?>
                <div class="s-notification"><data value="<?php echo $newCommentTotal; ?>"><?php echo $newCommentTotal; ?></data> <span id="i-new-comment-notifier-text"><?php echo ($newCommentTotal == 1) ? ' New Comment' : ' New Comments'; ?></span></div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div id="i-journal-panel-default" class="panel-body s-no-lp collapse <?php echo (!$SectionHandler->hasHandler) ? 'in' : ''; ?>">
        <div id="journal-session-2" class="s-panel-body">
            <div class="s-table i-author s-sub-lp">
                <div class="s-cell i-profile-img s-v-top">
                    <?php include(VIEWS . 'components/profile/user-data.php'); ?>
                </div>
                <div class="s-cell">
                    <form id="i-f-default-edit" data-session-type="0" onsubmit="return processFormSession1(event,this.id);" class="s-default-form">
                        <div class="form-group">
                            <textarea rows="1" class="s-single" placeholder="What's on your mind?"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-xs-offset-6 text-right">
                                <button class="s-btn btn-lg">Done</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php /** Don't Remove div below */ ?>
            <div id="fill-journals"></div>

            <?php if(count($CommunityUpdate->allPosts) > 0): ?>
            <?php foreach ($CommunityUpdate->allPosts as $index => $thePost): ?>
                <!-- Update Component -->
                <div class="i-journal-post" data-post-type="2" data-post-id="<?php echo $thePost['id']; ?>">
                        <div class="s-table i-author s-sub-lp i-update-post">
                            <div class="s-cell i-profile-img s-v-top">
                                <div class="s-profile-img" style="background-image: url('/<?php echo $User->get_user_profile_img(false,$thePost['user_id']); ?>');">
                                </div>
                                <span class="s-date"><?php echo strtoupper(date("M d",$thePost['created_entry'])); ?></span>
                            </div>
                            <div class="s-cell">
                                <form onkeydown="journal_active_edit(this.id);" id="i-f-default-edit-<?php echo $index; ?>" data-post-id="<?php echo $thePost['id']; ?>" class="s-default-form" data-session-type="2" onsubmit="return processFormSession1(event,this.id);">
                                    <div class="form-group">
                                        <textarea class="s-single"><?php echo $thePost['content']; ?></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-6 col-xs-offset-6 text-right">
                                            <?php
                                            $LikedPost = new LikePost($thePost['id'],2,$thePost['user_id']);
                                            ?>
                                            <i class="fa fa-heart i-like-icon"></i> <data value="<?php echo $LikedPost->getTotalLikes(); ?>"><?php echo $LikedPost->getTotalLikes(); ?></data>
                                            <button class="s-btn btn-lg">Edit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="i-single-forum-answers">
                            <div class="s-table i-replies-container">
                                <?php
                                include_once( CLASSES . 'Journal.php' );
                                $Journal = new Journal();
                                ?>
                                <?php $NewComments = new Profile\NewComments(); ?>
                                <?php if($NewComments->hasComment($thePost['id'])): ?>
                                <?php foreach ($Journal->get_journal_comments($thePost['id'],false,false,500) as $key => $comment): ?>
                                    <div class="s-table i-replies">
                                        <div class="s-cell i-replier-level-2 s-v-top
                                        <?php $notViewedArr = $NewComments->checkIfNotViewed($comment['id']); ?>
                                            <?php if ($notViewedArr['status']):
                                                echo ' s-new-chat" ';
                                                echo ' title="Click to mark as viewed" ';
                                                echo ' role="button" ';
                                                echo ' id="i-comment-action-'. $key .'" ';
                                                echo ' onclick="updateNotViewedPost('.$notViewedArr['post_id'].',id) ';
                                            endif; ?> ">
                                            <div class="s-user-profile" style="background-image: url('/<?php echo $User->get_user_profile_img(false,$comment['user_id']); ?>');">
                                            </div>
                                        </div>
                                        <div class="s-cell i-msg">
                                            <div class="s-content">
                                                <span class="s-username"><?php echo User::Username($comment['user_id']); ?></span> <?php echo $comment['comment']; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <!-- End Of Update Component -->
                    </div>
            <?php if(count($CommunityUpdate->allPosts) > 1): ?>
                <hr style="margin-bottom: 10px">
            <?php endif; ?>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

