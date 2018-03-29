<?php
/**
 * File For: HopeTracker.com
 * File Name: latest-entry.php.
 * Author: Mike Giammattei
 * Created On: 3/20/2017, 1:18 PM
 */

include_once(CLASSES . 'class.ForumPosts.php');
include_once(CLASSES . 'class.JournalPosts.php');
include_once(CLASSES . 'Journal.php');
include_once(CLASSES . 'General.php');
include_once(CLASSES . 'Forum.php');
include_once(CLASSES . 'Comments.php');
include_once(CLASSES . 'class.ForumQuestions.php');
include_once(CLASSES . 'class.FollowedPost.php');
include_once(CLASSES . 'class.ForumAnswers.php');
include_once(CLASSES . 'class.LikePost.php');
include_once(CLASSES . 'class.UserProfile.php');

/** @vars : Initialize Classes */
$ForumPosts = new ForumPosts();
$Journal = new Journal();
$JournalPosts = new JournalPosts();
$Forum = new Forum();
$General = new General();
$Comments = new Comments();
$ForumQuestion = new ForumQuestions();
$FollowedPost = new FollowedPost();
$Session = new Sessions();
$ForumAnswers = new ForumAnswers();
$User = new User();
$UserProfile = new UserProfile();


/** @var  $latestJournal : Gets the latest journal post */
$latestJournal = $JournalPosts->getLatestPosts(1)[0];

/** @var  $latestForum : Gets the latest journal post */
$latestForum = $ForumPosts->getLatestPosts(1)[0];

/** @var  $latestForum : Gets the latest journal post */
$latestForumQuestion = $ForumQuestion->getLatestPost()[0];

/** OLD SECTION TO GET NEWEST POST FORUM/JOURNAL */
/** Check if journal or forum post is newer */
//if($latestJournal['created_entry'] > $latestForum['TIMESTAMP'] ){
//	/** If most recent post is a journal */
//	$post_type = 'Journal';
//	$post_title = $latestJournal['title'];
//	$post_content = $latestJournal['content'];
//	$post_id = $latestJournal['id'];
//	$post_user_id = $latestJournal['user_id'];
//	$follow_post = ($Journal->check_if_liked('journal_likes',$post_id)) == true ? 'liked' : '';
//	$total_post_likes = $Journal->total_journal_post_likes($post_id);
//	$post_path = '/journal/' . $post_id . '/' . $General->url_safe_string($post_title);
//	$see_more_post_path = '/families-of-drug-addicts/';
//	$post_comments_level_1 = $Journal->get_journal_comments($post_id,false,false,3);
//	$contentSyntax = 'comment';
//
//}else{
//    /** If most recent post is a forum */
//    $post_type = 'Forum';
//	$post_title = $latestForum['title'];
//	$post_content = $latestForum['content'];
//	$post_id = $latestForum['id'];
//	$post_user_id = $latestForum['created_user_id'];
//	$follow_post = ($Forum->liked_forum($post_id)) == true ? 'liked' : '';
//	$total_post_likes = $Forum->total_forum_post_likes($post_id);
//	$post_subcategory_name =  $Forum->get_sub_category_forum($latestForum['sub_category_id'])['sub_category'];
//	$post_path = '/forum/'. $General->url_safe_string($post_subcategory_name) . '-' . $post_id . '/' . $General->url_safe_string($post_title);
//	$see_more_post_path = '/family-of-drug-abuser/';
//	$post_comments_level_1 = $Forum->get_forum_replies_limit($post_id, 3);
//	$contentSyntax = 'message';
//}

/** @var  $post_type : see post_types table for reference */
$post_type = 3;

$post_title = $latestForumQuestion['question'];
$post_content = $latestForumQuestion['description'];
$post_id = $latestForumQuestion['id'];
$post_user_id = $latestForumQuestion['user_id'];

/** Check if the latest post is followed by the user.  */
if($Session->get('logged_in') == 1){
	$follow_post = (in_array( $post_id,$FollowedPost->getUsersFollowedPostIds())) ? 'liked' : '';
}

$total_post_likes = $FollowedPost->GetTotalFollowersForAPost($post_id);
$post_subcategory_name =  $latestForumQuestion['subcategory'];
$post_path = '/' . RELATIVE_PATH. 'forum/'. $General->url_safe_string($post_subcategory_name) . '/' . $post_id . '/' . $General->url_safe_string($post_title);
$see_more_post_path = '/' . RELATIVE_PATH. 'family-of-drug-abuser/';
$post_comments_level_1 = $Forum->get_forum_replies_limit($post_id, 3);
$contentSyntax = 'message';

/** Reverse comments to show last comment at the bottom of list. */


/** Answers/comments if not post type 3 */
$answersComments = array_reverse($post_comments_level_1);

if($post_type == 3){
	/** @var $post_answers : the answers to the latest question.*/
	$post_answers = $ForumAnswers->getAnswers( false, $post_id, true, 3 );
	$post_answers = array_reverse( $post_answers );

	/** Answers/comments */
	$answersComments = $post_answers;
}
?>
<?php if(!empty($post_title)) : ?>
<section class="box-one sidebar right-sidebar" id="sidebar">
    <div class="inside-box xs-padding latest-box">
        <div class="row" id="latest-entries">
            <div class="col-xs-6 no-p">
                <p class="simple-heading latest-title">Latest Question</p>
            </div>
            <div class="invite-box">
                <a href="<?php echo $see_more_post_path; ?>" class="more blk-heading-md">See All</a>
            </div>
            <hr>
            <div class="col-xs-12 no-p">

                <div id="user-post" class="table">
                    <div class="cell">
                        <a class="wrap" <?php echo $UserProfile->profile($post_user_id); ?> ><img src="/<?php echo $User->get_user_profile_img(false,$post_user_id); ?>" class="img-circle profile-img "></a>
                    </div>
                    <div class="cell">
                        <div class="user-text">
                            <div class="simple-heading user-name">
                                <a class="wrap" <?php echo $UserProfile->profile($post_user_id); ?> > <?php echo User::user_info('username',$post_user_id); ?></a>
                            </div>
                            <div class="post-title">
                                <?php echo $General->trim_text($post_title,100); ?>
                            </div>
                        </div>
                        <div id="like-count" class="like-count">
                            <nobr><i id="like-count-value" class="fa fa-star" aria-hidden="true"></i><span class="num"><?php echo $total_post_likes; ?></span></nobr>
                        </div>
                    </div>
                </div>
            </div>

            <div class="post-text">
                <?php echo $General->trim_text($post_content,100); ?>
            </div>
            <hr>
            <div  <?php echo 'class="action-btns ' . $follow_post; ?>">
                <div data-bound-follow-post="btn" data-post-user-id="<?php echo $post_user_id; ?>" data-post-id="<?php echo $post_id; ?>" data-post-type="<?php echo $post_type; ?>"  class="simple-heading post-like tooltip-mg" <?php echo ($Session->get('logged_in') == 0) ? 'data-pt-title="You must be signed in to like the post"  disabled' : ' '; ?> data-pt-gravity="top" data-pt-animate="jello" data-pt-scheme="black" data-pt-size="small"  data-user-id="<?php echo ($Session->get('user-id')) ? : '' ?>">
                    <i class="fa fa-star" aria-hidden="true"></i> <span><?php echo ($follow_post == 'liked') ? 'Follow' : 'Follow'; ?></span>
                </div>
                <div class="simple-heading comment" id="comment-btn-level-1" data-toggle="collapse" data-target="#sidebar-comment-box">
                    <i class="fa fa-comments-o" aria-hidden="true"></i> <span>Answer</span>
                </div>
                <div class="clearfix"></div>
                <div class="simple-heading read-more">
                    <a href="<?php echo $post_path; ?>"><i class="fa fa-caret-right" aria-hidden="true"></i> <span>Read More</span></a>
                </div>
            </div>
            <?php /* Chat Area */ ?>
            <div id="sidebar-comment-box" class="comment-box collapse">
                <div class="chat-output-level-1" data-post-type="<?php echo $post_type; ?>" data-post-id="<?php echo $post_id; ?>">
	                <?php
	                /** Loop through the comment for the post */;
	                if(count($answersComments) > 0):
	                foreach($answersComments as $post) : ?>
                    <div class="mg-flex">
                        <div class="flex-primary">
                            <img <?php echo $UserProfile->profile($post['user_id']); ?> class="chat-profile profile-img cir xs" src="/<?php echo $User->get_user_profile_img(false, $post['user_id']); ?>">
                        </div>
                        <div class="flex-sub-item">
                            <div class="output-text">
                               <?php //echo $post[$contentSyntax]; ?>
                               <?php echo $post['answer']; ?>
                                <div class="actions" data-post-id="<?php echo $post_id; ?>" data-comment-id="<?php echo $post['id']; ?>" data-comment-user-id="<?php echo $post['user_id']; ?>" data-post-user-id="<?php echo $post['user_id']; ?>">
                                    <?php
                                        /** Generate like result */
                                        $like_class = '';
                                        switch ($post_type) :
                                            case 'Journal' :
	                                            $like_class =  ($Comments->check_if_comments_liked($post['user_id'],$post_id,$post['id'])) ? 'liked' : '';
                                            break;
                                            case 'Forum' :
	                                            $like_class =  ($Forum->liked_forum_post($post_id,$post['id'],$post['user_id']) == true) ? 'liked' : '';
                                            break;
	                                        case 3 :
	                                            $LikedPost = new LikePost($post['id'],4,$post['user_id']);
		                                        $like_class =  ($LikedPost->checkLikedQuestion() == true) ? 'liked' : '';
		                                        break;
                                        endswitch;
                                    ?>

                                    <div class="like-btn <?php echo $like_class; ?>">
                                        <i class="fa fa-thumbs-o-up " aria-hidden="true"></i> Like
                                    </div>
                                    <div class="reply-btn">
                                        <?php /*<i class="fa fa-comment-o"></i> Comment */ ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="clearfix"></div>
	            <?php /* Chat Entry Level One */ ?>
                <?php if($Session->get('logged_in') == 1) : ?>
                <div class="answer-box">
                    <div class="table" >
                        <div class="cell">
                            <img <?php echo $UserProfile->profile($Session->get('user-id')); ?> class="chat-profile profile-img cir xs" src="/<?php echo $User->get_user_profile_img($Session->get('user-id')) ?>">
                        </div>
                        <div class="cell">
                            <input data-post-id="<?php echo $post_id; ?>" data-post-type="<?php echo $post_type;  ?>" data-post-user-id="<?php echo $post_user_id; ?>" class="comment-box" id="comment-level-1" placeholder="Add your comment">
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
