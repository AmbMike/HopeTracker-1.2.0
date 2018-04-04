<?php
/**
 * Copyright (c) 2017.
 */

/**
 * File For: HopeTracker.com
 * File Name: recent-answers.php.
 * Author: Mike Giammattei
 * Created On: 12/15/2017, 4:08 PM
 */;
?>
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/hopetracker/config/constants.php');
require_once(CLASSES . 'class.ForumAnswers.php');
require_once(CLASSES . 'class.ForumQuestions.php');
require_once(CLASSES . 'class.FlagPost.php');
require_once(CLASSES . 'class.LikePost.php');
require_once(CLASSES . 'class.PageLinks.php');
require_once( CLASSES . 'class.SingleQuestion.php' );

$Session = new Sessions();
$General = new General();
$ForumAnswers = new ForumAnswers();
$ForumQuestions = new ForumQuestions();
$FlagPost = new FlagPost();

/** @var $questionId : the id of the question for the page.  */
$questionId = $_GET['post_id'];


/** Answer Pagination : number of answers to show for pagination */
$answers_to_show = 3;

/** @var  $Question : the object that generates the question data into a class variables.  */
$Question = new SingleQuestion($questionId);

echo $questionId;
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

/** @var  $startLimit : calculate where the limit needs to start. */
$startLimit = ($_GET['data']['paginationNumber'] * $_GET['data']['paginationLimit']) - $_GET['data']['paginationLimit'];

$forum_answers_arr = $ForumAnswers->getAnswers(false,$_GET['data']['questionId'],true, (int) $_GET['data']['paginationLimit'],(int) $startLimit);

?>

<?php foreach ( $forum_answers_arr as $forum_answer) :  ?>
	<div data-answers="container" data-answer-id="<?php echo $forum_answer['id']; ?>" data-answer-post-type="<?php echo $forum_answer['post_type']; ?>">
		<div class="author-img-box cell">
			<img <?php echo PageLinks::userProfile($forum_answer['user_id']); ?> <?php echo PageLinks::userProfile($forum_answer['user_id']); ?> src="/<?php echo (User::user_info('profile_img',$forum_answer['user_id'])) ? : DEFAULT_PROFILE_IMG; ?>" alt="<?php echo User::Username($forum_answer['user_id']); ?>" class="img-circle profile-img">
		</div>
		<div class="post-text-box cell">
			<div class="quote-box" itemprop="author" itemscope itemtype="http://schema.org/Person">
				<span <?php echo PageLinks::userProfile($forum_answer['user_id']); ?>  itemprop="name"  <?php echo PageLinks::userProfile($forum_answer['user_id']); ?>><?php echo User::Username($forum_answer['user_id']); ?></span>
			</div>
			<div class="user-count-container">
				<?php $answer_user_question_count = $ForumQuestions->totalApprovedQuestions(true,$forum_answer['user_id']) ?>
				<?php $answer_user_answer_count = $ForumAnswers->countAnswers(true,$forum_answer['user_id']) ?>
				<span><data value="<?php echo $answer_user_question_count; ?>" class="user-questions"><?php echo $answer_user_question_count; ?></data> Questions <data value="<?php echo $answer_user_answer_count; ?>" class="user-answers"><?php echo $answer_user_answer_count; ?></data> Answers</span>
			</div>
			<div class="author-text-box">
				<span itemprop="text" class="author-text"><?php echo $forum_answer['answer']; ?></span>
			</div>
			<div class="tracker-box">
				<?php
				$LikePost= new LikePost($forum_answer['id'], $forum_answer['post_type'],$forum_answer['user_id']);
				?>
				<?php if($Session->get('logged_in')== 1) : ?>
					<?php if($LikePost->checkLikedQuestion() == true) : ?>
						<span role="button" data-bound-post-like="btn" data-post-user-id="<?php echo $forum_answer['user_id']; ?>" data-post-id="<?php echo $forum_answer['id']; ?>" data-post-type="<?php echo $forum_answer['post_type']; ?>"  class="like-box liked">Liked</span>
					<?php else : ?>
						<span role="button" data-bound-post-like="btn" data-post-user-id="<?php echo $forum_answer['user_id']; ?>" data-post-id="<?php echo $forum_answer['id']; ?>" data-post-type="<?php echo $forum_answer['post_type']; ?>" class="like-box">Like</span>
					<?php endif; ?>
					<i class="fa fa-circle dot"aria-hidden="true"></i>
					<?php if($FlagPost->checkIfUserFlaggedPost($forum_answer['id'],$forum_answer['post_type']) == false) : ?>
						<span class="flag-box" data-question="flag-btn" role="button" >Flag</span>
					<?php else: ?>
						<span class="flag-box error-text tooltip-mg" data-question="flag-btn" data-pt-title="Flag being processed" data-pt-gravity="top" data-pt-animate="jello" data-pt-scheme="black" data-pt-size="small">Flagged</span>
					<?php endif; // End if if user has not flagged the post. ?>
				<?php endif; // End if user is logged in.  ?>

				<div class="asked-about-box">
					<span class="dot"><i class="fa fa-circle" aria-hidden="true"></i></span>
					Asked about <time itemprop="dateCreated"  class="human-time" datetime="<?php echo date("j F Y H:i",$forum_answer['date_created']) ?>"><?php echo date("j F Y H:i",$forum_answer['date_created']) ?></time>
				</div>
			</div>
		</div>
		<hr>
	</div>
<?php endforeach; ?>
