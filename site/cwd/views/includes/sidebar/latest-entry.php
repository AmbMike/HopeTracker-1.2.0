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
$latestJournal = $JournalPosts->getLatestPosts(5);

/** @var  $latestForum : Gets the latest journal post */
$latestForum = $ForumPosts->getLatestPosts(5);

/** @var  $latestForum : Gets the latest journal post */
$latestForumQuestion = $ForumQuestion->getLatestPost(5);


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

/** Check if the latest post is followed by the user.  */
if($Session->get('logged_in') == 1){
    $follow_post = (in_array( $post_id,$FollowedPost->getUsersFollowedPostIds())) ? 'liked' : '';
}
/** @var  $post_type : see post_types table for reference */
$post_type = 3;


$contentSyntax = 'message';

/** Answers/comments if not post type 3 */
/*$answersComments = array_reverse($post_comments_level_1);*/

if($post_type == 3){
    /** @var $post_answers : the answers to the latest question.*/
    /*$post_answers = $ForumAnswers->getAnswers( false, $post_id, true, 3 );
    $post_answers = array_reverse( $post_answers );*/

    /** Answers/comments */
    /*$answersComments = $post_answers;*/
}
?>
<?php if(!empty($latestForumQuestion)) : ?>
    <section class="box-one sidebar right-sidebar" id="sidebar">
        <div class="inside-box xs-padding latest-box">
            <div class="row" id="latest-entries">
                <div class="col-xs-12 no-p">
                    <p class="simple-heading latest-title">Questions from Other Families</p>
                </div>

                <hr>
                <div class="col-xs-12 no-p">
                    <?php foreach ($latestForumQuestion as $question) : ?>

                    <?php

                    $post_title = $question['question'];
                    $post_content = $question['description'];
                    $post_id = $question['id'];
                    $post_user_id = $question['user_id'];

                    $total_post_likes = $FollowedPost->GetTotalFollowersForAPost($post_id);
                    $post_subcategory_name =  $question['subcategory'];
                    $post_path = '/' . RELATIVE_PATH. 'forum/'. $General->url_safe_string($post_subcategory_name) . '/' . $post_id . '/' . $General->url_safe_string($post_title);
                    $see_more_post_path = '/' . RELATIVE_PATH. 'family-of-drug-abuser/';
                    $post_comments_level_1 = $Forum->get_forum_replies_limit($post_id, 3);

                    ?>
                        <div id="user-post" class="table ">
                            <div class="cell">
                                <a class="wrap" href="<?php echo $post_path; ?>"><img alt="<?php echo ucwords(User::user_info('username',$post_user_id)); ?>'s Profile Image" src="/<?php echo $User->get_user_profile_img(false,$post_user_id); ?>" class="img-circle profile-img"></a>
                            </div>
                            <div class="cell">
                                <div class="user-text">
                                    <div class="simple-heading user-name">
                                        <a class="wrap" href="<?php echo $post_path; ?>"> <?php echo User::user_info('username',$post_user_id); ?></a>
                                    </div>
                                    <a class="post-title" href="<?php echo $post_path; ?>">
                                        <?php echo $General->trim_text($post_title,100); ?>
                                    </a>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
                <hr>
                <div>
                    <a href="<?php echo $see_more_post_path; ?>" class="more blk-heading-md">See All</a>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
