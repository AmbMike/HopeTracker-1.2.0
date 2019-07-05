<?php
/**
 * File For: HopeTracker.com
 * File Name: forum.php.
 * Author: Mike Giammattei Paul Giammattei
 * Created On: 5/12/2017, 9:21 AM
 */;

require_once( CLASSES . 'class.SingleQuestion.php' );
require_once(CLASSES . 'class.ForumAnswers.php');
require_once(CLASSES . 'class.ForumQuestions.php');
require_once(CLASSES . 'class.FlagPost.php');
require_once(CLASSES . 'class.ViewedPost.php');
require_once(CLASSES . 'class.LikePost.php');
require_once(CLASSES . 'class.FollowPost.php');
require_once(CLASSES . 'Admin/Editor.php');


$Question = new SingleQuestion($questionId, $_GET['pageIdentifier']);
$Session = new Sessions();
$ForumAnswers = new ForumAnswers();
$ForumQuestions = new ForumQuestions();
$FlagPost = new FlagPost();
$User = new User();
$General = new General();
$Page = new \Page_Attr\Page();
$AdminEditor = new \Admin\Editor();

/** @var $questionId : the id of the question for the page.  */
$pageIdentifier = $_GET['pageIdentifier'];
$questionId = $ForumQuestions->getPostIdByPageIdentifier($pageIdentifier);

/** @var  $Question : the object that generates the question data into a class variables.  */

$Page->header(array(
	'Title' => ucwords(substr($Question->question, 0, 46)) . ' | HopeTracker (Forum)',
	'Description' => $General->trim_text($Question->description, 160, true),
	'Show Nav' => false,
	'Active Link' => 'Forums',
	'OG Image'  => OG_IMAGES  . 'ht-forum.jpg',
	'OG Title'  => 'Family of Drug Abuser Forum'
));



/** @var  $FollowPost : follow the question initial data for the main question.  */
$FollowPost = new FollowPost($questionId,3,$Question->questionUsersId);



/** Set the forum post as viewed."2 for "forum" as the post type */
/** @var  $ViewedPost */
$ViewedPost =  new ViewedPost();

$ViewedPost->setViewedPost($questionId, 3);

/** Answer Pagination : number of answers to show for pagination */
$answers_to_show = 3;

/** @var  $total_user_forums : the total number of
 * forums/questions created by the user.
 */
$total_user_questions =  $ForumQuestions->totalApprovedQuestions($Question->questionUsersId);

/** @var  $total_user_answers : total number of replies/answers by the user */
$total_user_answers = $ForumAnswers->countAnswers(true,$Question->questionUsersId);

/** Logged in  values and variables */
if($Session->get('logged_in') == 1) {
	/** @var  $user_id */
	$user_id = $Session->get( 'user-id' );
}

$showEditorTools = true;
if(isset($_GET['hide_tools'])){
    $showEditorTools = false;
}
?>

<div class="con main" data-questions-parent="true">
    <div class="row">
        <div class="col-md-8" id="forum-single">
            <main>
                <div class="header-box">
                    <h2 class="green-heading-lg">Addiction Forum Question</h2>
                    <div class="insurance-treatment-box">
                        <a href="/<?php echo RELATIVE_PATH . 'family-of-drug-abuser/'. $General->url_safe_string($Question->category); ?>"><?php echo  $Question->category; ?></a>
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                        <a href="/<?php echo RELATIVE_PATH . 'family-of-drug-abuser/'. $General->url_safe_string($Question->category) . '/' . $General->url_safe_string($Question->subcategory); ?>"><?php echo  $Question->subcategory; ?></a>
                    </div>
                </div>
                <div id="c-single-forum">
                    <div class="panel panel-default" id="i-main-question-panel">
                        <div class="panel-heading">
                            <div class="s-table">
                                <div class="s-cell">
                                    <span class="s-title">Forum Question</span>
                                </div>
                                <div class="s-cell text-right">
                                   <span class='s-notification -i-new-comments'>
                                       <?php $totalAnswers =  $ForumAnswers->totalAnswersByQuestionId($Question->postId); ?>
                                      <data value="<?php echo $totalAnswers; ?>"><?php echo $totalAnswers; ?> </data>
                                       <span class="s-mobile""> <i class="fa fa-comment"></i></span>
                                      <span class="s-desktop"><?php echo ($totalAnswers > 1) ? 'Comments' : 'Comment'; ?> </span>
                                   </span>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div id="main-question">
                                <div class="s-table i-author">
                                    <div class="s-cell i-profile-img">
                                        <div class="s-profile-img" style="background-image: url('/<?php echo $User->get_user_profile_img( false, $Question->questionUsersId); ?>');">
                                        </div>
                                    </div>
                                    <div class="s-cell">
                                        <span class="s-username"><?php echo ucwords(User::user_info('username',$Question->questionUsersId)); ?></span>
                                        <span class="s-who">A <?php echo ucwords($User->user_i_am($User->user_info('i_am_a',$Question->questionUsersId))); ?> From <?php echo strtoupper(User::user_info('state',$Question->questionUsersId)); ?></span>
                                    </div>
                                </div>
                                <div class="i-question">
                                    <?php echo $AdminEditor->postEditor($Question->postId,$Question->postType,$showEditorTools); ?>
                                    <h1 class="i-header"><?php echo $Question->question; ?></h1>
                                    <div class="s-description">
                                        <?php echo $Question->description; ?>
                                    </div>
                                </div>
                            </div>
                            <div id="single-forum-answers">

                                <div class="s-table i-replier">
                                    <div class="s-cell i-input-container">
                                        <?php if($Session->get('logged_in')): ?>
                                        <div class="s-table i-input-section">
                                            <div class="s-cell i-user">
                                                <div class="s-profile-img" id="logged-in-user-id" style="background-image: url('/<?php echo $User->get_user_profile_img(false,$user_id); ?>');">
                                                </div>
                                            </div>
                                            <div class='s-cell i-input'>

                                                <form data-logged-in-username="<?php echo User::Username($user_id); ?>" id="forum-answer-question-form-1" data-question-id="<?php echo $Question->postId; ?>">
                                                    <textarea id="answer-trigger" rows="1"  name="answer-msg" placeholder="Share your advice, experience or support."></textarea>
                                                </form>

                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="s-cell i-action text-right">
                                        <?php if($Session->get('logged_in')): ?>
                                            <button data-bound-follow-post="btn" data-follow-type="relate" data-post-user-id="<?php echo $Question->questionUsersId; ?>" data-post-id="<?php echo $Question->postId; ?>" data-post-type="<?php echo $Question->postType; ?>" class="like-box liked"><div class="s-cir-i"><i class="fa fa-heart"></i></div> <span class="divider">|</span> <span class="relate-text">Relate</span> <span class="-i-total-questions-relates"><?php echo $FollowPost->totalPostFollows; ?></span></button>
                                        <?php else: ?>
                                            <button data-btn="home-sign-in" data-show-notification="1" class="like-box liked"><div class="s-cir-i"><i class="fa fa-heart"></i></div> <span class="divider">|</span> <span class="relate-text">Relate</span> <span class="-i-total-questions-relates"><?php echo $FollowPost->totalPostFollows; ?></span></button>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="s-table i-replies-container">
                                    <?php /** Answer output area */ ?>
                                    <?php $forum_answers = $ForumAnswers->getAnswersByMostLiked($Question->postId,200);  ?>
                                    <?php foreach ( $forum_answers as $index => $forum_answer) :  ?>
                                    <div class="s-table i-replies">
                                        <div class="s-cell i-replier-level-2 s-v-top">
                                            <div class="s-user-profile" style="background-image: url('/<?php echo $User->get_user_profile_img( false, $forum_answer['user_id']); ?>');">
                                            </div>
                                        </div>
                                        <div class="s-cell i-msg">
                                            <div class="s-content">
                                                <span class="s-username"><?php echo User::Username($forum_answer['user_id']); ?></span> <?php echo $forum_answer['answer']; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php $relatedQuestions = $ForumQuestions->getQuestionsBySubcategory($Question->subcategory, $Question->postId); ?>

                <?php if(!empty($relatedQuestions)): ?>
                    <div class="panel panel-default" id="i-related-questions-panel">
                        <div class="panel-heading">
                            <div class="s-table">
                                <div class="s-cell">
                                    <span class="s-title">Related Questions</span>
                                </div>
                                <div class="s-cell text-right">
                                    <button class="t-ask-question <?php echo ($Session->get('logged_in') == 0) ? 'tooltip-mg' : '';?>" <?php echo ($Session->get('logged_in') == 0) ? '' : 'data-toggle="modal" data-target="#ask-question-modal"';?><?php echo ($Session->get('logged_in') == 0) ? 'data-btn="home-sign-in" data-show-notification="1" data-pt-title="You must be logged in to to ask a question" data-pt-gravity="top" data-pt-animate="jello" data-pt-scheme="black" data-pt-size="small" ' : ''; ?>><i class="fa fa-pencil-square-o"></i> Ask Your Own Question </button>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <?php foreach ( $relatedQuestions as $index => $relatedQuestion) : ?>
                            <?php if($index == 0 || $index % 2 == 0): ?>

                            <div class="i-related-question-container">
                                <div class="row">
                            <?php endif ?>
                                    <div class="col-md-6 i-related-question-item">
                                        <div class="s-table">
                                            <div class="s-cell i-profile-img" role="button" onclick="location.href='/<?php echo RELATIVE_PATH; ?>forum/<?php echo $General->url_safe_string( $relatedQuestion['pageIdentifier']); ?>/'">
                                                <div class="s-user-profile" style="background-image: url('/<?php echo $User->get_user_profile_img( false, $relatedQuestion['user_id']); ?>');">
                                                </div>
                                            </div>
                                            <div class="s-cell i-question-section">
                                                <span role="button" onclick="location.href='/<?php echo RELATIVE_PATH; ?>forum/<?php echo $General->url_safe_string( $relatedQuestion['pageIdentifier']); ?>/'" class="s-username"><?php echo User::Username($relatedQuestion['user_id']); ?></span>
                                                <?php $forum_title_url = $General->url_safe_string($relatedQuestion['question']) ; ?>
                                                <a href="/<?php echo RELATIVE_PATH; ?>forum/<?php echo $General->url_safe_string( $relatedQuestion['pageIdentifier']); ?>/" class="s-question"><?php echo $relatedQuestion['question']; ?></a>
                                            </div>
                                        </div>
                                    </div>
                            <?php if($index == count($relatedQuestions) - 1  || $index % 2 != 0 && $index != 0): ?>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                </div>
        </main>
    </div>
    <div class="col-md-4 sidebar-box">
        <aside>
			<?php include(SIDEBAR);?>
        </aside>
    </div>
	<?php include_once(MODALS . 'forum-ask-question-form.php'); ?>
	<?php include_once(MODALS . 'forum-answer-form.php'); ?>
</div>
</div>