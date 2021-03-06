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


/** @var $questionId : the id of the question for the page.  */
$questionId = $_GET['forum_id'];

/** @var  $Question : the object that generates the question data into a class variables.  */
$Question = new SingleQuestion($questionId);

$User = new User();
$General = new General();

$Page = new \Page_Attr\Page(); 
$Page->header(array(
	'Title' => ucwords(substr($Question->question, 0, 46)) . ' | HopeTracker (Forum)',
	'Description' => $General->trim_text($Question->description, 160, true),
	'Show Nav' => false,
	'Active Link' => 'Forums',
	'OG Image'  => OG_IMAGES  . 'ht-forum.jpg',
	'OG Title'  => 'Family of Drug Abuser Forum'
));

$Session = new Sessions();

$ForumAnswers = new ForumAnswers();
$ForumQuestions = new ForumQuestions();
$FlagPost = new FlagPost();


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
error_reporting(3);

?>

<div class="con main" data-questions-parent="true">
    <div class="row">
        <div class="col-md-8" id="forum-single">
            <main>
                <div class="header-box">
                    <h1 class="green-heading-lg">Addiction Forum Question</h1>
                    <div class="insurance-treatment-box">
                        <a href="/<?php echo RELATIVE_PATH . 'family-of-drug-abuser/'. $General->url_safe_string($Question->category); ?>"><?php echo  $Question->category; ?></a>
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                        <a href="/<?php echo RELATIVE_PATH . 'family-of-drug-abuser/'. $General->url_safe_string($Question->category) . '/' . $General->url_safe_string($Question->subcategory); ?>"><?php echo  $Question->subcategory; ?></a>
                    </div>
                </div>

                <section class="box-one no-p">
                    <div id="post-single" class="table question-container">
                        <div class="row author-post-container"  itemscope itemtype="http://schema.org/Question" <?php echo ($ForumAnswers->userAnswered($user_id, $questionId) == true) ? 'data-user-answered="true"' : ''; ?>  data-question-body="true" data-question-id="<?php echo $questionId; ?>" data-question-user-id="<?php echo $Question->questionUsersId; ?>" data-post-type-id="<?php echo $Question->postType; ?>">
                            <div class="author-img-box cell">
                                <img <?php echo PageLinks::userProfile($Question->questionUsersId); ?> src="/<?php echo $User->get_user_profile_img( false, $Question->questionUsersId); ?>" alt="<?php echo ucwords(User::user_info('username',$Question->questionUsersId)); ?>'s Profile Image" class="img-circle profile-img">
                            </div>
                            <div class="post-text-box cell">
                                <div class="quote-box" data-question="question" data-question="text">
                                    "<?php echo $Question->question; ?>"
                                </div>
                                <div class="tracker-box">
                                    <?php if($Session->get('logged_in')== 1) : ?>
                                        <?php if($FollowPost->checkFollowedPost() == true) : ?>
                                            <span role="button" data-bound-follow-post="btn" data-post-user-id="<?php echo $Question->questionUsersId; ?>" data-post-id="<?php echo $Question->postId; ?>" data-post-type="<?php echo $Question->postType; ?>" class="like-box liked"><i class="fa fa-star" aria-hidden="true"></i> <span>Following</span></span>
                                        <?php else : ?>
                                            <span role="button" data-bound-follow-post="btn" data-post-user-id="<?php echo $Question->questionUsersId; ?>" data-post-id="<?php echo $Question->postId; ?>" data-post-type="<?php echo $Question->postType; ?>" class="like-box"><i class="fa fa-star" aria-hidden="true"></i> <span>Follow</span></span>
                                        <?php endif; ?>
                                    <?php endif; // End if user is logged in.  ?>
                                    <div class="forum-details">
                                        <span class="asked-about-box">
                                            Asked <time itemprop="dateCreated" class="human-time" datetime="<?php echo date("j F Y H:i",$Question->dateCreated) ?>"><?php echo date("j F Y H:i",$Question->dateCreated) ?></time> by
                                        </span>
                                        <span class="liked-by-box">
                                           <span class="liked-by"  <?php echo PageLinks::userProfile($Question->questionUsersId); ?>><?php echo User::Username($Question->questionUsersId); ?></span>
                                        </span>
                                            <span class="seen-count-box">
                                            <i class="fa fa-circle dot" aria-hidden="true"></i>
                                            Seen by <data value="<?php echo $ViewedPost->countPostViews(3,$Question->postId) ?>" class="seen-count"><?php echo $ViewedPost->countPostViews(3,$Question->postId) ?></data>
                                        </span>
                                    </div>
                                </div>
                                <div class="author-text-box" data-question="description">
									<?php echo  $Question->description; ?>
                                    <?php if($FlagPost->checkIfUserFlaggedPost($questionId,$Question->postType) == false) : ?>
                                        <span class="flag-box" data-question="flag-btn" role="button" >
                                                <span class="flag-tooltip-text">
                                                        Click here to report this post as inappropriate.
                                                    <a class="alt-flag">
                                                        flag
                                                    </a>
                                                </span>
                                                <i class="fa fa-flag" aria-hidden="true"></i>
                                            </span>
                                    <?php else: ?>
                                        <span class="flag-box error-text tooltip-mg" data-question="flag-btn" data-pt-title="Flag being processed" data-pt-gravity="top" data-pt-animate="jello" data-pt-scheme="black" data-pt-size="small"><i class="fa fa-flag" aria-hidden="true"></i></span>
                                    <?php endif; // End if if user has not flagged the post. ?>
                                </div>
                            </div>
                        </div>
                        <?php if($Session->get('logged_in') == 1) : ?>
                        <div class="visitor-response">
                            <a class="wrap" <?php echo PageLinks::userProfile($user_id); ?>><img src="/<?php echo $User->get_user_profile_img(false,$user_id); ?>" alt="<?php echo ucwords(User::user_info('username',$user_id)); ?>'s Profile Image" class="img-circle profile-img sm"></a>
                            <div class="textarea-box">
                                <div class="success-box" style="display: none">
                                    <div class="modal-header">
                                        <span class="green-text-md">Submitted Successfully!</span>
                                    </div>
                                    <p>Your answer is very valuable to the entire Hopetracker community. </p>
                                </div>
                                <form class="pre-form-content" id="forum-answer-question-form-1" date-question-id="<?php echo $questionId; ?>">
                                    <textarea  rows="1" data-autoresize class="text-features" name="answer" placeholder="Share your advice and experience"></textarea>
                                    <div class="comment-btn-box">
                                        <input type="submit" name="submit" value="Post" class="save-btn blue">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php endif ?>
                        <div class="panel-group sub-posts">
                            <div class="panel panel-default">
                                <div class="panel-heading more-answers-box">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" href="#collapse1">
                                            <h3>
                                                <span class="more-answers"><i class="fa fa-caret-down" aria-hidden="true"></i> Answers</span>
                                            </h3>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse1" class="panel-collapse collapse in">
									<?php /** Answer output area */ ?>
									<?php $forum_answers = $ForumAnswers->getAnswers(false,$Question->postId,'1',$answers_to_show); ?>
                                    <div class="panel-body question-answer-box="true" itemprop="suggestedAnswer" itemscope itemtype="http://schema.org/Answer" data-answers="container">
                                    <div  class="table">
                                        <div class="row author-post-container">
											<?php if(count($forum_answers) > 0): ?>
                                                <div class="thick-border-box"></div>
                                                <div class="body-nav-box">
                                                    <span data-answer-filter="recent" role="button" class="recent-answers-box active">
                                                        Recent Answers
                                                    </span>
                                                    <span data-answer-filter="top answered" role="button" class="top-answers-box">
                                                       Top Answers
                                                    </span>
                                                </div>
                                                <hr>
											<?php endif; ?>
                                            <div id="answerOuter" data-questions="container" data-answer="output boxes">
                                                <div id="answerInner">
                                                    <div data-answer="tables">
														<?php foreach ( $forum_answers as $index => $forum_answer) :  ?>
                                                            <div class="answer-container" data-answers="container" data-answer-id="<?php echo $forum_answer['id']; ?>" data-answer-post-type="<?php echo $forum_answer['post_type']; ?>">
                                                                <div class="answer-data-container">
                                                                    <div class="author-img-box cell">
                                                                        <img <?php echo PageLinks::userProfile($forum_answer['user_id']); ?> src="/<?php echo $User->get_user_profile_img( false, $forum_answer['user_id']); ?>" alt="<?php echo ucwords(User::user_info('username',$forum_answer['user_id'])); ?>'s Profile Image" class="img-circle profile-img">
                                                                    </div>
                                                                    <div class="post-text-box cell">
                                                                        <div class="quote-box" itemprop="author" itemscope itemtype="http://schema.org/Person">
                                                                            <span <?php echo PageLinks::userProfile($forum_answer['user_id']); ?>  itemprop="name"  <?php echo PageLinks::userProfile($forum_answer['user_id']); ?>><?php echo User::Username($forum_answer['user_id']); ?></span>
                                                                        </div>
                                                                        <div class="user-count-container">
                                                                            <?php $answer_user_question_count = $ForumQuestions->totalApprovedQuestions($forum_answer['user_id']) ?>
                                                                            <?php $answer_user_answer_count = $ForumAnswers->countAnswers(true,$forum_answer['user_id']) ?>
                                                                            <span><data value="<?php echo $answer_user_question_count; ?>" class="user-questions"><?php echo $answer_user_question_count; ?></data> Questions <data value="<?php echo $answer_user_answer_count; ?>" class="user-answers"><?php echo $answer_user_answer_count; ?></data> Answers</span>
                                                                            <div class="asked-about-box">
                                                                            <span class="dot">
                                                                                <i class="fa fa-circle" aria-hidden="true"></i>
                                                                            </span>
                                                                                Asked <time itemprop="dateCreated"  class="human-time" datetime="<?php echo date("j F Y H:i",$forum_answer['date_created']) ?>"><?php echo date("j F Y H:i",$forum_answer['date_created']) ?></time>
                                                                            </div>
                                                                        </div>
                                                                        <div class="author-text-box">
                                                                            <span itemprop="text" class="author-text"><?php echo $forum_answer['answer']; ?></span>
                                                                        </div>
                                                                        <div class="tracker-box">
                                                                            <?php
                                                                            $LikePost= new LikePost($forum_answer['id'], $forum_answer['post_type'],$forum_answer['user_id']);
                                                                            ?>
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
                                                    </div>
													<?php if($answer_user_answer_count > 3) : ?>
                                                        <div data-answer-pagination="box-single" data-question-pagination-limit="<?php echo $answers_to_show; ?>" data-question-id="<?php echo $Question->postId; ?>" class="answer-pagination">
                                                            View more answers:
															<?php
															$show_btns =  $forum_answer['total'] / $answers_to_show;
															for ( $i = 0; $i < ceil( $show_btns ); $i ++ ) : ?>
                                                            <span class="btns <?php echo ($i == 0) ? 'active' : ''; ?>" data-pagination-number="<?php echo $i + 1; ?>"><?php echo $i + 1; ?></span>
															<?php endfor; ?>
                                                        </div>
													<?php endif; ?>
                                                    <?php /* Remove when textarea comment section is complete
                                                    <button data-answers="question" data-answer-page="single-question" data-question-id="<?php echo $Question->postId; ?>" <?php echo ($Session->get('logged_in') == 0) ? '' : 'data-toggle="modal" data-target="#answer-question-modal"';?>  class="btn btn-primary <?php echo ($Session->get('logged_in') == 0) ? 'tooltip-mg' : '';?>" <?php echo ($Session->get('logged_in') == 0) ? 'data-pt-title="You must be signed in to chat" data-pt-gravity="top" data-pt-animate="jello" data-pt-scheme="black" data-pt-size="small" disabled' : ''; ?>>Submit your answer</button>
                                                    */?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                        $relatedQuestions = $ForumQuestions->getQuestionsBySubcategory($Question->subcategory);

                        if(!empty($relatedQuestions)):
                   ?>
                        <div id="related-questions" class="panel-group sub-posts">
                            <div class="panel panel-default">
                                <div class="panel-heading more-answers-box">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" href="#collapse-related">
                                            <h3>
                                                <span class="more-answers"><i class="fa fa-caret-down" aria-hidden="true"></i> Related Questions</span>
                                            </h3>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse-related" class="panel-collapse collapse in">
                                    <?php /** Related questions output area requires backend before launch */ ?>
                                    <div class="panel-body">
                                        <div  class="table">
                                            <div id="relatedOuter">
                                                <div id="relatedInner">
                                                    <div class="related-content">
                                                        <?php Debug::out($relatedQuestions); foreach ( $relatedQuestions as $relatedQuestion) : ?>
                                                        <div class="related-question-item">
                                                            <div class="table">
                                                                <div class="cell">
                                                                    <img <?php echo PageLinks::userProfile($relatedQuestion['user_id']); ?> src="/<?php echo $User->get_user_profile_img( false, $relatedQuestion['user_id']); ?>" alt="<?php echo ucwords(User::user_info('username',$relatedQuestion['user_id'])); ?>'s Profile Image" class="img-circle profile-img xxs">
                                                                </div>
                                                                <div class="cell">
                                                                    <?php $forum_title_url = $General->url_safe_string($relatedQuestion['question']) ; ?>
                                                                    <a href="/<?php echo RELATIVE_PATH; ?>forum/<?php echo $General->url_safe_string( $relatedQuestion['subcategory']); ?>/<?php echo $relatedQuestion['id']; ?>/<?php echo $forum_title_url; ?>"><?php echo $relatedQuestion['question']; ?></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php endforeach; ?>
                                                       <!-- <p>
                                                            <span class="related-qa-image" style="background-image: url('/hopetracker/site/public/images/testimonials/GIRLFRIEND.png')"></span> What if I find rolling paper in my car and my son used it last?
                                                        </p>
                                                        <p>
                                                            <span class="related-qa-image" style="background-image: url('/hopetracker/site/public/images/testimonials/GIRLFRIEND.png')"></span> What if I find rolling paper in my car and my son used it last?
                                                        </p>-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
            <section class="box-one main-box">
                <div class="row no-margins">
                    <div class="col-sm-9 no-p">
                        <div id="user-title" class="user-title-box">
                            <div class="img-box">
<!--                                <img <?php /*echo PageLinks::userProfile($Question->questionUsersId); */?> src="/<?php /*echo $User->get_user_profile_img( false, $Question->questionUsersId); */?>"  class="img-circle profile-img">
-->                                <img src="<?php echo IMAGES ?>main/icon.jpg" alt="Hopetracker Icon" class="img-circle profile-img">
                            </div>
                            <div class="find-answer-title">
                                Did you find your answer?
                                <?php /* Remove this code when change is final

                                        <span <?php echo PageLinks::userProfile($Question->questionUsersId); ?> class="simple-heading user-name">
                                            <?php echo User::Username($Question->questionUsersId); ?>
                                        </span>
                                */ ?>
                                <div class="find-answer-text">
                                    We hope you did, but feel free to ask everyone a question of your own.
                                    <?php /* Remove this code when change is final
                                    <span><data class="user-questions" value="<?php echo $total_user_questions; ?>"><?php echo $total_user_questions; ?></data> Questions • <data  value="<?php echo $total_user_answers; ?>" class="user-answers"><?php echo $total_user_answers; ?></data> Answers</span>
                                    */ ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 no-p text-center">
                        <div class="invite-box">
                            <a href="#" <?php echo ($Session->get('logged_in') == 0) ? '' : 'data-toggle="modal" data-target="#ask-question-modal"';?>  class="<?php echo ($Session->get('logged_in') == 0) ? 'tooltip-mg' : '';?>" <?php echo ($Session->get('logged_in') == 0) ? 'data-pt-title="You must be signed in to chat" data-pt-gravity="top" data-pt-animate="jello" data-pt-scheme="black" data-pt-size="small" disabled' : ''; ?>><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ask a Question</a>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </section>
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