<?php
/**
 * File For: HopeTracker.com
 * File Name: forum.php.
 * Author: Mike Giammattei Paul Giammattei
 * Created On: 5/12/2017, 9:21 AM
 */;

 /** PAGE NOTES
  * Check the URL class for redirects for url parameters that are not found.
  */

$Page = new \Page_Attr\Page();
$Page->header(array(
	'Title' => 'Family of Drug Abuser Forum | HopeTracker',
	'Description' => 'Ask any addiction-related question to get answers from experts and other families that have been there before. Helpful, direct guidance available now.',
	'Show Nav' => false,
	'Active Link' => 'Forums',
	'OG Image'  => OG_IMAGES  . 'ht-forum.jpg',
	'OG Title'  => 'Family of Drug Abuser Forum'
));
include_once(CLASSES . 'Forum.php');
include_once(CLASSES . 'class.ForumReplies.php');
include_once(CLASSES . 'class.ViewedPost.php');

/** New Includes */
include_once(CLASSES . 'class.ForumAnswers.php');
include_once(CLASSES . 'class.ForumQuestions.php');
include_once(CLASSES . 'class.FollowPost.php');
include_once(CLASSES . 'class.FollowedPost.php');
include_once(CLASSES . 'class.AnswerFilters.php');
include_once(CLASSES . 'class.UserProfile.php');


$Forum = new Forum();
$User = new User();
$Session = new Sessions();
$General = new General();
$ForumReplies = new ForumReplies($Session->get('user-id'));
$ForumAnswers = new ForumAnswers();
$ViewedPost = new ViewedPost();
$ForumQuestions = new ForumQuestions();
$UserProfile = new UserProfile();

/** @var  $total_questions : total number of questions asked by all users */
$total_questions =  $ForumQuestions->totalApprovedQuestions;

/** Logged in  values and variables */
if($Session->get('logged_in') == 1){

	/** @var  $user_id */
	$user_id = $Session->get('user-id');

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

	/** Get an array of categories the user has question in. */
	$categoriesOfUserQuestions = $ForumQuestions->categoriesOfQuestions($user_id);

	/** Get an array of subcategories the user has question in. */
	$subcategoriesOfQuestions = $ForumQuestions->subcategoriesOfQuestions($user_id);

	/** Logged in users categories to questions the've answered. */
	$AnswerFilters = new AnswerFilters();
	$AnsweredCategories = $AnswerFilters->getAnswersCategory();

	/** The logged in users  followed post categories */
	$FollowedPostCategories = $FollowedPosts->getFollowedUserAnswerCategories();

	/** The logged in users  followed post subcategories */
	$FollowedPostSubcategories = $FollowedPosts->getFollowedUserAnswerSubcategories();

	/** The logged in user's followed post ids */
	$FollowedPostIds = $FollowedPosts->getUsersFollowedPostIds();

}
    /** Page Jump Value */
    if(isset($_GET['category'])){

	    $categoryParam = preg_replace( '/\-/', ' ', $_GET['category'] );
	    $categoryParam = preg_replace( '/\s+/', '',$categoryParam );
        $pageJumpToId = $categoryParam;

	    $jumpData = 'data-page-jump-value="'.$pageJumpToId.'"';

        if(isset($_GET['subcategory'])){
	        $subcategoryParam = preg_replace( '/\-/', ' ', $_GET['subcategory'] );
	        $subcategoryParam = preg_replace( '/\s+/', '',$subcategoryParam );
	        $pageJumpToId = $subcategoryParam;

	        $jumpData = 'data-page-jump-value-subcategory="'.$pageJumpToId.'"';
        }


    }

?>
<div <?php echo $jumpData; ?> class="con main" data-questions-parent="true" id="new-forum" data-user-id="<?php echo $user_id; ?>">
    <div class="row">
        <div class="col-md-8">
            <main>
                <div class="header-box main-title-box">
                    <span class="h1-addon"><?php echo $total_questions; ?> Questions Asked</span>
                    <h1 class="green-heading-lg">Addiction Forum</h1>
                    <p class="header-content">Get advice from experts and other families — from "<i>What does heroin look like?</i>" to "<i>How do I know when they hit rock bottom?</i>."</p>
                </div>
				<?php if($Session->get('logged_in') == 1): ?>
                    <section class="box-one main-box">
                        <div class="row no-margins">
                            <div class="col-sm-8 no-p">
                                <div id="user-title" class="user-title-box">
                                    <div class="img-box">
                                        <img <?php echo $UserProfile->profile($user_id); ?>  src="/<?php echo $User->get_user_profile_img(false,$user_id); ?>" alt="<?php echo ucwords(User::user_info('username',$user_id)); ?>'s Profile Image" class="img-circle profile-img">
                                    </div>
                                    <div class="user-text-box">
                                    <span <?php echo $UserProfile->profile($user_id); ?> class="simple-heading user-name">
                                       <?php echo User::Username(); ?>
                                    </span>
                                        <div class="user-count-container">
                                            <span <?php echo ($total_user_forums == 0 ) ? ' data-pt-title="You haven\'t asked any questions yet." data-pt-gravity="top" data-pt-animate="jello" data-pt-scheme="black" data-pt-size="small"' : ''; ?> class="questions  <?php echo ($total_user_forums == 0 ) ? 'tooltip-mg' : ''; ?>"> <span data-profile="question"><data data-users-count="question" value="<?php echo $total_user_forums; ?>" class="user-questions"><?php echo $total_user_forums; ?></data> <span data-filter-text="Question">Questions </span></span> </span> <i class="fa fa-circle"></i>
                                            <span <?php echo ($total_user_answers == 0 ) ? ' data-pt-title="You haven\'t answered any questions yet." data-pt-gravity="top" data-pt-animate="jello" data-pt-scheme="black" data-pt-size="small"' : ''; ?> class="answers <?php echo ($total_user_answers == 0 ) ? 'tooltip-mg' : ''; ?>"> <span  data-profile="answers"><data data-users-count="answer" value="<?php echo $total_user_answers; ?>" class="user-answers"><?php echo $total_user_answers; ?></data> <span data-filter-text="Answers"> Answers </span></span> </span> <i class="fa fa-circle"></i>
                                            <span <?php echo ($FollowedPosts->getTotalPostUserIsFollowing() == 0 ) ? ' data-pt-title="You haven\'t followed any questions yet." data-pt-gravity="top" data-pt-animate="jello" data-pt-scheme="black" data-pt-size="small"' : ''; ?> role="button" class="following <?php echo ($FollowedPosts->getTotalPostUserIsFollowing() == 0 ) ? 'tooltip-mg' : ''; ?>"><span data-profile="following"><data value="<?php echo $FollowedPosts->getTotalPostUserIsFollowing(); ?>" class="user-answers"><?php echo $FollowedPosts->getTotalPostUserIsFollowing(); ?></data> <span data-filter-text="Following"> I Relate</span></span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 no-p text-center">
                                <div class="invite-box">
                                    <a  href="#" <?php echo ($Session->get('logged_in') == 0) ? '' : 'data-toggle="modal" data-target="#ask-question-modal"';?>  class="<?php echo ($Session->get('logged_in') == 0) ? 'tooltip-mg' : '';?>" <?php echo ($Session->get('logged_in') == 0) ? 'data-pt-title="You must be signed in to chat" data-pt-gravity="top" data-pt-animate="jello" data-pt-scheme="black" data-pt-size="small" disabled' : ''; ?>><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ask a Question</a>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </section>
				<?php endif; ?>
                <div id="category-fill-box">
                    <section id="categories">
                        <?php /** Start loop for popular question  */ ?>
                        <?php


                        ?>
                        <?php $count = 0; foreach (  $ForumQuestions->mostPopular() as $question) : ?>

                        <?php endforeach; ?>

						<?php /** Start loop for forum categories  */ ?>
						<?php $count = 0; foreach ( $Forum->get_category_list() as $category) : ?>
							<?php $category_name = preg_replace('/[^a-zA-Z0-9-_\.]/','', $category['category']); ?>
							<?php
							/** @var  $isUserPostInCategory :
							 * Check if the user has a post in  the category in the loop.
							 */
							$isUserPostInCategory = (in_array($category['category'] ,$categoriesOfUserQuestions)) ? 'Yes' : "No";

							/*if($Session->get('logged_in') == 1) :

								$isUserAnswerSubcategory = (in_array($subcategory['sub_category'] ,$AnswerFilters->getSubcategoriesOfUsersAnswers())) ? 'Yes' : "No";
							endif;*/

                            /** @var  $isUserPostInCategory :
                             * Check if the user has a post in  the category in the loop.
                             */
                            $userAnsweredCategory = (in_array($category['category'] ,$AnsweredCategories)) ? 'Yes' : "No";

                            /**
							 * Check if the user has a followed posts in the category.
							 */
							$userFollowedPostCategory = (in_array($category['category'] ,$FollowedPostCategories)) ? 'Yes' : "No";
							?>
                            <div class="panel-group category" data-followed-post-category="<?php echo $userFollowedPostCategory; ?>" data-user-answered-category="<?php echo $userAnsweredCategory; ?>" data-user-post-category="<?php echo $isUserPostInCategory; ?>"  data-category="<?php echo ucwords($category['category']); ?>">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <div class="main-collapse collapsed" data-toggle="collapse" href="#<?php echo $category_name; ?>-categories">
                                                <h3 class="heading">
                                                    <span class="category-text"><?php echo $category['category'];?></span>
                                                </h3>



                                                <div id="moderator-container">
                                                    <?php /* Updated js Category Count below before going live */ ?>
                                                    <span class="category-count-box h4"><?php echo $ForumQuestions->totalPostPerCategory( $category['category']); ?></span>

                                                </div>
                                            </div>
                                        </h4>
                                    </div>
                                    <?php
                                        /** Set values for jump to accordion functionality */
                                    if(isset($_GET['category'])) :

                                        /* The category set in the URL */
                                        $categoryMatchName = preg_replace( '/\-/', ' ', $_GET['category'] );
                                        $categoryMatchName = preg_replace( '/\s+/', '',$categoryMatchName );

                                        /* The loop category*/
                                        $loopCategory = preg_replace( '/\-/', ' ', $category_name );
                                        $loopCategory = preg_replace( '/\s+/', '',$loopCategory );
                                        $loopCategory = preg_replace( '/\//', '',$loopCategory );
                                        $loopCategory = preg_replace( '/\?/', '',$loopCategory );
                                        $loopCategory = strtolower( $loopCategory );

                                        if($categoryMatchName == strtolower($category_name)): ?>
                                             <div data-page-jump-to-href="<?php echo $loopCategory; ?>" id="<?php echo $category_name; ?>-categories" class="panel-collapse collapse in">
                                        <?php else: ?>
                                             <div data-page-jump-to-href="<?php echo $loopCategory; ?>" id="<?php echo $category_name; ?>-categories" class="panel-collapse collapse ">
                                         <?php endif; ?>

                                     <?php else: ?>
                                    <div id="<?php echo $category_name; ?>-categories" class="panel-collapse collapse">
                                    <?php endif; ?>

                                        <?php /** Replies/Answers to the category post/question.  */ ?>
										<?php $subcategories = $Forum->subcategory_list_by_cat_id($category['id']); ?>
										<?php foreach ($subcategories as $index => $subcategory) :?>
											<?php
											/** @var  $isUserPostInSubcategory :
											 * Check if the user has a post in  the category in the loop.
											 */
											$isUserPostInSubcategory = (in_array($subcategory['sub_category'] ,$subcategoriesOfQuestions)) ? 'Yes' : "No";

											if($Session->get('logged_in') == 1) :
												$isUserAnswerSubcategory = (in_array($subcategory['sub_category'] ,$AnswerFilters->getSubcategoriesOfUsersAnswers())) ? 'Yes' : "No";
											endif;

											$isUserFollowedPostSubcategory = (in_array($subcategory['sub_category'] ,$FollowedPostSubcategories)) ? 'Yes' : "No";

											?>
                                            <div class="panel-group subcategory" id="subcategory" data-followed-post-subcategory="<?php echo $isUserFollowedPostSubcategory; ?>" data-users-answer-subcategory="<?php echo $isUserAnswerSubcategory; ?>" data-users-answered="<?php echo $isUserPostInSubcategory; ?>" data-users-post-subcategory="<?php echo $isUserPostInSubcategory; ?>" data-subcategory="<?php echo ucwords($subcategory['sub_category']); ?>">
                                                <div class="panel sub-panel panel-default">
                                                    <div class="panel-heading sub-heading">
                                                        <h4 class="panel-title sub-title">
                                                            <div  class="sub-collapse collapsed" data-toggle="collapse" href="#<?php echo $category_name; ?>-sub-accordion-<?php echo $index; ?>">
                                                                <h3 class="heading category-heading">
                                                                    <span class="sub-category-text"><?php echo $subcategory['sub_category']; ?></span>
                                                                </h3>
                                                                <div id="questions-count-container">
                                                                    <div class="questions-count-box">
																		<?php /** Start of subcategory answer section */ ?>
																		<?php $forum_questions = $ForumQuestions->getQuestionsBySubcategory($subcategory['sub_category']);  ?>
                                                                        <data value="<?php echo count($forum_questions); ?>" class="questions-count"><?php echo count($forum_questions); ?></data>
                                                                        <span class="questions-count-text">
                                                                 Questions
                                                             </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </h4>
                                                    </div>
													<?php if(count($forum_questions) > 0): ?>
	                                                <?php
                                                        if(isset($_GET['subcategory'])) :

                                                        /* The category set in the URL */
                                                        $subcategoryMatchName = preg_replace( '/\-/', ' ', $_GET['subcategory'] );
                                                        $subcategoryMatchName = preg_replace( '/\s+/', '',$subcategoryMatchName );

                                                        /* The loop category*/
                                                        $loopSubcategory = preg_replace( '/\-/', ' ', $subcategory['sub_category'] );
                                                        $loopSubcategory = preg_replace( '/\s+/', '',$loopSubcategory );
                                                        $loopSubcategory = preg_replace( '/\//', '',$loopSubcategory );
                                                        $loopSubcategory = preg_replace( '/\?/', '',$loopSubcategory );
                                                        $loopSubcategory = strtolower( $loopSubcategory );

                                                            if($subcategoryMatchName == $loopSubcategory): ?>
                                                            <div data-page-jump-to-href="<?php echo $loopSubcategory; ?>" id="<?php echo $category_name; ?>-sub-accordion-<?php echo $index; ?>" class="panel-collapse collapse in">
                                                            <?php else: ?>
                                                            <div data-page-jump-to-href="<?php echo $loopSubcategory; ?>" id="<?php echo $category_name; ?>-sub-accordion-<?php echo $index; ?>" class="panel-collapse collapse">
                                                            <?php endif; ?>

                                                        <?php else: ?>
                                                            <div id="<?php echo $category_name; ?>-sub-accordion-<?php echo $index; ?>" class="panel-collapse collapse">
                                                        <?php endif; ?>
                                                            <div class="panel-body">
																<?php /** Subcategory filter section  */ ?>
                                                                <ul data-top-filter="container" class="body-nav-box">
                                                                    <li data-filter="most recent" class="most-recent-box active">Most Recent</li>
                                                                    <li data-filter="top question" class="top-questions-box">Top Questions</li>
                                                                </ul>
                                                                <div data-questions="container">
																	<?php /** Replies/Answers to the category post/question.  */ ?>
																	<?php foreach ($forum_questions as $forum_question) : ?>
																		<?php
																		/** Check if the user is answered the question */
																		if($Session->get('logged_in') == 1) :
																			$userAnsweredQuestion = (in_array($forum_question['id'],$AnswerFilters->getUserQuestionIds()) ? 'Yes' : 'No');
																		endif;
																		/** Check if the user is following the question */
																		$userFollowingQuestion = (in_array($forum_question['id'], $FollowedPostIds,true) ? 'Yes' : 'No');
																		?>
                                                                        <div itemscope itemtype="http://schema.org/Question" data-followed-post="<?php echo $userFollowingQuestion; ?>" <?php echo ($ForumAnswers->userAnswered($user_id, $forum_question['id']) == true) ? 'data-user-answered="Yes"' : 'No'; ?>  data-question-body="true" data-question-answered="<?php echo $userAnsweredQuestion; ?>" data-users-question="<?php echo ($forum_question['user_id'] == $user_id) ? 'Yes' : 'No'; ?>" data-question-id="<?php echo $forum_question['id']; ?>" data-question-user-id="<?php echo $forum_question['user_id']; ?>" class="table answer-box">
                                                                            <div class="row no-margins">
                                                                                <div class="cell question-title-text">
                                                                                    <div  class="quote-box">
																						<?php $forum_title_url = $General->url_safe_string($forum_question['question']) ; ?>
                                                                                        <a class="link-title" href="/<?php echo RELATIVE_PATH; ?>forum/<?php echo $General->url_safe_string( $forum_question['pageIdentifier']); ?>/"><span data-question="text" itemprop="name"><?php echo $forum_question['question']; ?></span></a>
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
                                                                                            <data data-users-answers-count="subcategory" itemprop="answerCount" value="<?php echo $total_answers; ?>" class="answers-count"><?php echo $total_answers; ?></data>
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
                                                                                        <img <?php echo $UserProfile->profile($forum_question['user_id']); ?> src="/<?php echo $User->get_user_profile_img(false, $forum_question['user_id']); ?>" alt="<?php echo User::Username($forum_question['user_id']); ?>'s Profile Image" class="img-circle profile-img">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div id="question-answer-box-<?php echo $forum_question['id']; ?>">
                                                                                <div itemprop="suggestedAnswer" id="question-answer-box-data-<?php echo $forum_question['id']; ?>" itemscope itemtype="http://schema.org/Answer" data-answers="container" class="question-answer-box">
																					<?php /** Answer output area */ ?>
																					<?php $forum_answers = $ForumAnswers->getAnswers(false,$forum_question['id'],'1',$answers_to_show); ?>
                                                                                    <div data-answer="tables">
																						<?php foreach ( $forum_answers as $forum_answer) :  ?>
                                                                                            <div class="table">
                                                                                                <div class="cell">
                                                                                                    <img <?php echo $UserProfile->profile($forum_answer['user_id']); ?> <?php echo PageLinks::userProfile($forum_answer['user_id']); ?> src="/<?php echo $User->get_user_profile_img(false,$forum_answer['user_id']); ?>" alt="<?php echo ucwords(User::user_info('username',$forum_answer['user_id'])); ?>'s Profile Image"  class="img-circle profile-img ">
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
                                                                        </div>
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
                </div>

				<?php include_once(MODALS . 'forum-ask-question-form.php'); ?>
				<?php include_once(MODALS . 'forum-answer-form.php'); ?>
            </main>
        </div>
        <div class="col-md-4 sidebar-box">
            <aside>
                <?php include(SIDEBAR_TOP_QUESTIONS);?>
            </aside>
        </div>
    </div>
</div>
