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
require_once( CLASSES . 'User.php' );

$User = new User();
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

//$forum_answers_arr = $ForumAnswers->getAnswers(false,$_GET['data']['questionId'],true, (int) $_GET['data']['paginationLimit'],(int) $startLimit);
$forum_answers_arr = $ForumAnswers->getAnswersByMostLiked($_GET['data']['questionId'],(int) $_GET['data']['paginationLimit'],(int) $startLimit);
?>
<?php $topLikedAnswerID = $ForumAnswers->totalLikesForAnswer($_GET['data']['questionId']); ?>
<?php foreach ( $forum_answers_arr as $index => $forum_answer) : ?>
    <div itemscope itemtype="http://schema.org/Answer" <?php echo ($topLikedAnswerID == $forum_answer['id']) ? 'itemprop="acceptedAnswer"' : 'itemprop="suggestedAnswer"'; ?> class="answer-container" data-answers="container" data-answer-id="<?php echo $forum_answer['id']; ?>" data-answer-post-type="<?php echo $forum_answer['post_type']; ?>">
        <div class="answer-data-container">
            <a itemprop="url" style="display: table-cell; cursor: text" href="<?php echo $_SERVER['REQUEST_URI'] . '#answer-' . $index; ?>" id="answer-<?php echo $index; ?>" class="author-img-box cell">
                <img <?php echo PageLinks::userProfile($forum_answer['user_id']); ?> src="/<?php echo $User->get_user_profile_img( false, $forum_answer['user_id']); ?>" alt="<?php echo ucwords(User::user_info('username',$forum_answer['user_id'])); ?>'s Profile Image" class="img-circle profile-img">
            </a>
            <?php
            $LikePost= new LikePost($forum_answer['id'], $forum_answer['post_type'],$forum_answer['user_id']);
            ?>
            <span style="display: none;" itemprop="upvoteCount"><?php echo $LikePost->getTotalLikes()?></span>
            <div class="post-text-box cell">
                <div class="quote-box" itemprop="author" itemscope itemtype="http://schema.org/Person">
                    <span <?php echo PageLinks::userProfile($forum_answer['user_id']); ?>  itemprop="name"  <?php echo PageLinks::userProfile($forum_answer['user_id']); ?>><?php echo User::Username($forum_answer['user_id']); ?></span>
                </div>
                <div class="user-count-container">
                    <?php $answer_user_question_count = $ForumQuestions->totalApprovedQuestions($forum_answer['user_id']) ?>
                    <?php $answer_user_answer_count = $ForumAnswers->countAnswers(true, false,  $_GET['data']['questionId']) ?>
                    <span><data value="<?php echo $answer_user_question_count; ?>" class="user-questions"><?php echo $answer_user_question_count; ?></data> Questions <data value="<?php echo $answer_user_answer_count; ?>" class="user-answers"><?php echo $answer_user_answer_count; ?></data> Answers</span>
                    <div class="asked-about-box">
                        <span class="dot">
                            <i class="fa fa-circle" aria-hidden="true"></i>
                        </span>
                        Asked <time itemprop="dateCreated"  class="human-time" datetime="<?php echo date("j F Y H:i",$forum_answer['date_created']) ?>"><?php echo date("j F Y H:i",$forum_answer['date_created']) ?></time>
                    </div>
                </div>
                <div class="author-text-box">
                    <div itemprop="text" class="author-text dont-break-out"><?php echo $forum_answer['answer']; ?></div>
                </div>
                <div class="tracker-box">

                    <?php if($Session->get('logged_in')== 1) : ?>
                        <?php
                        $LikePost = new LikePost($forum_answer['id'],4,$forum_answer['user_id']);
                        ?>
                        <div class="question-liked-box">
                            <i class="fa fa-thumbs-o-up like-count-icon updated-txt-false" role="button" data-bound-post-like="btn" data-post-id="<?php echo $forum_answer['id']; ?>" data-post-type="4" data-post-user-id="<?php echo $forum_answer['user_id']; ?>"></i>
                            <data data-like-post-count-updater value="<?php echo $LikePost->getTotalLikes()?>" class="question-liked-text"><?php echo $LikePost->getTotalLikes()?></data>
                        </div>
                        <span role="button" data-toggle="collapse" data-target=".answer-comment-<?php echo $index; ?>" class="comment-access-btn">Comment</span>
                        <?php if($FlagPost->checkIfUserFlaggedPost($forum_answer['id'],$forum_answer['post_type']) == false) : ?>
                            <span class="flag-box" data-question="flag-btn" role="button" >
                                                                                        <span class="flag-tooltip-text">
                                                                                            Click here to report this post as inappropriate.
                                                                                            <a class="alt-flag">flag</a>
                                                                                        </span>
                                                                                        <i class="fa fa-flag" aria-hidden="true"></i>
                                                                                    </span>
                        <?php else: ?>
                            <span class="flag-box error-text tooltip-mg" data-question="flag-btn" data-pt-title="Flag being processed" data-pt-gravity="top" data-pt-animate="jello" data-pt-scheme="black" data-pt-size="small">
                                                                                        <i class="fa fa-flag" aria-hidden="true"></i>
                                                                                    </span>
                        <?php endif; // Look at the flag after like is clicked End if if user has not flagged the post. ?>
                    <?php endif; // End if user is logged in.  ?>
                </div>
                <div class="comment-fill"></div>

                <?php

                include_once(CLASSES . 'class.ForumAnswerComment.php');
                $ForumAnswerComment = new ForumAnswerComment();
                $comments = $ForumAnswerComment->getAnswerComment($forum_answer['id']);
                if(!empty($comments)):
                    foreach ($comments as $comment) :
                        ?>
                        <div class="comment-fill collapse answer-comment-<?php echo $index; ?>">
                            <hr>
                            <div class="clearfix">
                                <div class="table">
                                    <div class="author-img-box cell">
                                        <img <?php echo PageLinks::userProfile($comment['post_user_id']); ?> src="/<?php echo $User->get_user_profile_img( false, $comment['post_user_id']); ?>" alt="<?php echo ucwords(User::user_info('username',$comment['post_user_id'])); ?>'s Profile Image" class="img-circle profile-img">
                                    </div>
                                    <div class="post-text-box cell">
                                        <div class="quote-box" itemprop="author" itemscope="" itemtype="http://schema.org/Person">
                                            <span <?php echo PageLinks::userProfile($comment['post_user_id']); ?>  role="button" itemprop="name"><?php echo User::Username($comment['post_user_id']); ?></span>
                                        </div>
                                        <div class="user-count-container">
                                            <div class="asked-about-box">
                                                <span><!--<i class="fa fa-circle" aria-hidden="true"></i>--></span> Asked
                                                <time itemprop="dateCreated" class="human-time" datetime="<?php echo date("j F Y H:i",$comment['timestamp']) ?>" title="<?php echo date("j F Y H:i",$comment['timestamp']) ?>"></time>
                                            </div>
                                        </div>
                                        <div class="author-text-box">
                                            <span itemprop="text" class="author-text"><?php echo$comment['content']; ?></span>
                                        </div>
                                        <div class="tracker-box">
                                            <div class="question-liked-box"> <i class="fa fa-thumbs-o-up like-count-icon updated-txt-false" style="margin-right: 5px;" role="button" data-bound-post-like="btn" data-post-id="<?php echo $comment['id']; ?>" data-post-type="7" data-post-user-id="<?php echo $comment['post_user_id']; ?>"></i>
                                                <?php $LikePost = new LikePost($comment['id'],7,$comment['post_user_id']); ?>
                                                <data data-like-post-count-updater="" value="<?php echo $LikePost->getTotalLikes()?>" class="question-liked-text"><?php echo $LikePost->getTotalLikes()?></data>
                                            </div>
                                            <?php if($FlagPost->checkIfUserFlaggedPost($comment['id'],7) == false) : ?>
                                                <span class="flag-box is-comment" data-question="flag-btn" data-comment-id="<?php echo $comment['id']; ?>" data-post-type="7" role="button">
                                                                                                        <span class="flag-tooltip-text">Click here to report this post as inappropriate.<a class="alt-flag">flag</a></span>
                                                                                                        <i class="fa fa-flag" aria-hidden="true"></i>
                                                                                                    </span>
                                            <?php else: ?>
                                                <span class="flag-box error-text tooltip-mg" data-question="flag-btn" data-pt-title="Flag being processed" data-pt-gravity="top" data-pt-animate="jello" data-pt-scheme="black" data-pt-size="small">
                                                                                                            <i class="fa fa-flag" aria-hidden="true"></i>
                                                                                                        </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div data-toggle-box="answer-comment" id="answer-comment-<?php echo $index; ?>" class="visitor-response collapse answer-comment-<?php echo $index; ?>">
            <a class="wrap" <?php echo PageLinks::userProfile($user_id); ?>><img src="/<?php echo $User->get_user_profile_img(false,$user_id); ?>" alt="<?php echo ucwords(User::user_info('username',$user_id)); ?>'s Profile Image" class="img-circle profile-img sm"></a>
            <div class="textarea-box">
                <textarea data-comment-journal-id=""  rows="1" data-autoresize  class="text-features active" name="entry_content" placeholder="Share your advice and experience"></textarea>
                <div class="comment-btn-box">
                    <button data-answer-id="<?php echo $forum_answer['id']; ?>" class="save-btn blue">Comment</button>
                </div>
            </div>
        </div>
        <hr>
    </div>
<?php endforeach; ?>

