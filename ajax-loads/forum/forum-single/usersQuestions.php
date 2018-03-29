<?php
/**
 * Copyright (c) 2017.
 */

/**
 * File For: HopeTracker.com
 * File Name: forum.php.
 * Author: Mike Giammattei Paul Giammattei
 * Created On: 5/12/2017, 9:21 AM
 */;

include_once(CLASSES . 'Forum.php');
include_once(CLASSES . 'class.ForumReplies.php');
include_once(CLASSES . 'class.ViewedPost.php');

/** New Includes */
include_once(CLASSES . 'class.ForumAnswers.php');
include_once(CLASSES . 'class.ForumQuestions.php');
include_once(CLASSES . 'class.FollowPost.php');
include_once(CLASSES . 'class.FollowedPost.php');

$Forum = new Forum();
$User = new User();
$Session = new Sessions();
$General = new General();
$ForumReplies = new ForumReplies($Session->get('user-id'));
$ForumAnswers = new ForumAnswers();
$ViewedPost = new ViewedPost();
$ForumQuestions = new ForumQuestions();

/** Logged in  values and variables */
if($Session->get('logged_in') == 1){

	/** @var  $user_id */
	$user_id = $Session->get('user-id');

	/** @var  $total_questions : total number of questions asked by all users */
	$total_questions =  $ForumQuestions->totalApprovedQuestions;

	/** @var  $total_user_forums : the total number of
	 * forums/questions created by the user.
	 */
	$total_user_forums =  $ForumQuestions->totalApprovedQuestions($user_id);

	/** @var  $total_user_answers : total number of replies/answers by the user */
	$total_user_answers = $ForumAnswers->countAnswers(true,$user_id);

	/** Answer Pagination : number of answers to show for pagination */
	$answers_to_show = 3;

	/** Get logged in user total followed post count.  */
	$FollowedPosts = new FollowedPost();

}

?>
 <section id="categories">
	<?php /** Start loop for forum categories  */ ?>
	<?php $count = 0; foreach ( $Forum->get_category_list() as $category) : ?>
		<?php $category_name = preg_replace('/[^a-zA-Z0-9-_\.]/','', $category['category']); ?>
        <div class="panel-group category"  data-category="<?php echo ucwords($category['category']); ?>">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#<?php echo $category_name; ?>-categories">
                            <h3 class="heading">
                                <i class="fa fa-plus-square" aria-hidden="true"></i>
                                <span class="category-text"><?php echo $category_name; ?></span>
                            </h3>
                            <div id="moderator-container">
                                <div class="moderator-text-box">
                                <span class="title">
                                    Moderated by:
                                </span>
                                <span <?php echo PageLinks::userProfile($category['moderator_id']); ?> class="moderator">
                                   <?php echo User::Username($category['moderator_id']); ?>
                                </span>
                                </div>
                                <div class="moderator-img">
                                    <img <?php echo PageLinks::userProfile($category['moderator_id']); ?> src="/<?php echo (User::user_info('profile_img',$category['moderator_id'])) ? : DEFAULT_PROFILE_IMG; ?>" alt="<?php echo User::Username($category['moderator_id']); ?>" class="img-circle profile-img">
                                </div>
                            </div>
                        </a>
                    </h4>
                </div>
                <div id="<?php echo $category_name; ?>-categories" class="panel-collapse collapse">
					<?php /** Replies/Answers to the category post/question.  */ ?>
					<?php $subcategories = $Forum->subcategory_list_by_cat_id($category['id']); ?>
					<?php foreach ($subcategories as $index => $subcategory) :?>
                        <div class="panel-group subcategory" data-subcategory="<?php echo ucwords($subcategory['sub_category']); ?>">
                            <div class="panel sub-panel panel-default">
                                <div class="panel-heading sub-heading">
                                    <h4 class="panel-title sub-title">
                                        <a data-toggle="collapse" href="#<?php echo $category_name; ?>-sub-accordion-<?php echo $index; ?>">
                                            <h3 class="heading">
                                                <span class="sub-category-text"><?php echo $subcategory['sub_category']; ?></span>
                                            </h3>
                                            <div id="questions-count-container">
                                                <div class="questions-count-box">
                                            <span class="questions-count">
                                                <?php /** Start of subcategory answer section */ ?>
                                                <?php $forum_questions = $ForumQuestions->getQuestionsBySubcategory($subcategory['sub_category']);  ?>
                                                <?php echo count($forum_questions); ?>
                                            </span>
                                                    <span class="questions-count-text">
                                                 Questions
                                             </span>
                                                </div>
                                            </div>
                                        </a>
                                    </h4>
                                </div>
								<?php if(count($forum_questions) > 0): ?>
                                    <div id="<?php echo $category_name; ?>-sub-accordion-<?php echo $index; ?>" class="panel-collapse collapse">
                                        <div class="panel-body">
											<?php /** Subcategory filter section  */ ?>
                                            <ul data-top-filter="container" class="body-nav-box">
                                                <li data-filter="most recent" class="most-recent-box active">Most Recent</li>
                                                <li data-filter="top question" class="top-questions-box">Top Questions</li>
                                                <li data-filter="unanswered" class="unanswered-box">Unanswered</li>
                                            </ul>
                                            <div data-questions="container">
                                                <?php /** Replies/Answers to the category post/question.  */ ?>
                                                <?php foreach ($forum_questions as $forum_question) : ?>
                                                    <div itemscope itemtype="http://schema.org/Question" <?php echo ($ForumAnswers->userAnswered($user_id, $forum_question['id']) == true) ? 'data-user-answered="true"' : ''; ?>  data-question-body="true" <?php echo ($forum_question['user_id'] == $user_id) ? 'data-users-question="true"' : ''; ?> data-question-id="<?php echo $forum_question['id']; ?>" data-question-user-id="<?php echo $forum_question['user_id']; ?>" class="table answer-box">
                                                        <div class="row no-margins">
                                                            <div class="cell question-title-text">
                                                                <div  class="quote-box">
		                                                            <?php $forum_title_url = $General->url_safe_string($forum_question['question']) ; ?>
                                                                    <a class="link-title" href="/<?php echo RELATIVE_PATH; ?>forum/<?php echo $General->url_safe_string( $subcategory['sub_category']); ?>-<?php echo $forum_question['id']; ?>/<?php echo $forum_title_url; ?>">"<span data-question="text" itemprop="name"><?php echo $forum_question['question']; ?></span>"</a>
                                                                </div >
                                                                <div class="insurance-treatment-box">
                                                                <span class="insurance">
                                                                  <?php echo $category_name; ?>
                                                                </span>
                                                                    <span class="dot">
                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                </span>
                                                                    <span class="treatment">&nbsp;<?php echo $subcategory['sub_category']; ?></span>
                                                                </div>
                                                                <div class="tracker-box">
                                                                    <div data-show-answers-btn="true" class="answers-box">
			                                                            <?php
			                                                            /** @var  $total_answers : total number of answers for the question.  */
			                                                            $total_answers = $ForumAnswers->countAnswers(true,false,$forum_question['id']);
			                                                            ?>
                                                                        <data itemprop="answerCount" value="<?php echo $total_answers; ?>" class="answers-count"><?php echo $total_answers; ?></data>
                                                                        <span class="answers">Answers</span>
                                                                    </div>
                                                                    <span class="dot">
                                                                        <i class="fa fa-circle" aria-hidden="true"></i>&nbsp;
                                                                    </span>
                                                                    <span class="asked-about">
                                                                        Asked <span class="asked-when"><time itemprop="dateCreated"  class="human-time" datetime="<?php echo date("j F Y H:i",$forum_question['date_created']) ?>"><?php echo date("j F Y H:i",$forum_question['date_created']) ?></time></span>
                                                                    </span>
                                                                        <?php if(!empty($forum_question['updated_time'])) :  ?>
                                                                    <span class="dot">
                                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                                    </span>
                                                                    <span class="updated">
                                                                        Updated <span class="updated-when"><time class="human-time" datetime="<?php echo date("j F Y H:i",$forum_question['updated_time']) ?>"><?php echo date("j F Y H:i",$forum_question['date_created']) ?></time></span>
                                                                    </span>
		                                                            <?php endif; ?>
                                                                </div>
                                                            </div>
                                                            <div class="cell img-cell">
                                                                <div class="author-box">
                                                                    <span itemprop="author" itemscope itemtype="http://schema.org/Person" class="hidden"> <span  itemprop="name"></span><?php echo User::Username($forum_question['created_user_id']); ?></span> </span>
                                                                    <img <?php echo PageLinks::userProfile($forum_question['user_id']); ?> src="/<?php echo (User::user_info('profile_img',$forum_question['user_id'])) ? : DEFAULT_PROFILE_IMG; ?>" alt="<?php echo User::Username($category['moderator_id']); ?>"  class="img-circle profile-img">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div itemprop="suggestedAnswer" itemscope itemtype="http://schema.org/Answer" data-answers="container" class="question-answer-box">
                                                            <?php /** Answer output area */ ?>
                                                            <?php $forum_answers = $ForumAnswers->getAnswers(false,$forum_question['id'],'1',$answers_to_show); ?>
                                                            <div data-answer="tables">
	                                                            <?php foreach ( $forum_answers as $forum_answer) :  ?>
                                                                    <div class="table">
                                                                        <div class="cell">
                                                                            <img <?php echo PageLinks::userProfile($forum_answer['user_id']); ?> <?php echo PageLinks::userProfile($forum_answer['user_id']); ?> src="/<?php echo (User::user_info('profile_img',$forum_answer['user_id'])) ? : DEFAULT_PROFILE_IMG; ?>" alt="<?php echo User::Username($forum_answer['user_id']); ?>"  class="img-circle profile-img ">
                                                                        </div>
                                                                        <div class="cell">
                                                                            <div class="user-info">
                                                                                <span itemprop="author" itemscope itemtype="http://schema.org/Person" class="username"><span <?php echo PageLinks::userProfile($forum_answer['user_id']); ?>  itemprop="name"  <?php echo PageLinks::userProfile($forum_answer['user_id']); ?>><?php echo User::Username($forum_answer['user_id']); ?></span></span>
                                                                                <span itemprop="text" class="answer"><?php echo $forum_answer['answer']; ?></span>
                                                                                <time itemprop="dateCreated"  class="human-time" datetime="<?php echo date("j F Y H:i",$forum_answer['date_created']) ?>"><?php echo date("j F Y H:i",$forum_answer['date_created']) ?></time>
                                                                            </div>
                                                                        </div>
                                                                    </div>
	                                                            <?php endforeach; ?>
                                                            </div>
                                                            <?php if($total_answers > 3) : ?>
                                                            <div data-answer-pagination="box-forum" data-question-pagination-limit="<?php echo $answers_to_show; ?>" data-question-id="<?php echo $forum_question['id']; ?>" class="answer-pagination">
                                                                View more answers:
                                                                <?php
                                                                $show_btns =  $forum_answer['total'] / $answers_to_show;
                                                                for ( $i = 0; $i < ceil( $show_btns ); $i ++ ) : ?>
                                                                    <span class="btns <?php echo ($i == 0) ? 'active' : ''; ?>" data-pagination-number="<?php echo $i + 1; ?>"><?php echo $i + 1; ?></span>
                                                                <?php endfor; ?>
                                                            </div>
                                                            <?php endif; ?>
                                                            <button data-answers="question" data-answer-page="main-question" data-question-id="<?php echo $forum_question['id']; ?>" <?php echo ($Session->get('logged_in') == 0) ? '' : 'data-toggle="modal" data-target="#answer-question-modal"';?>  class="btn btn-primary <?php echo ($Session->get('logged_in') == 0) ? 'tooltip-mg' : '';?>" <?php echo ($Session->get('logged_in') == 0) ? 'data-pt-title="You must be signed in to chat" data-pt-gravity="top" data-pt-animate="jello" data-pt-scheme="black" data-pt-size="small" disabled' : ''; ?>>Submit your answer</button>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
								<?php endif; ?>
                            </div>
                        </div>
					<?php endforeach;?>
                </div>
            </div>
        </div>
		<?php $count++; ?>
	<?php endforeach; // End loop for forum categories ?>
</section>
