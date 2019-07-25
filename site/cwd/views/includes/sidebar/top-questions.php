<?php
    include_once(CLASSES . 'QuestionFilter.php');
    include_once(CLASSES . 'class.SingleQuestion.php');
    include_once(CLASSES .'class.ForumQuestions.php');

    $QuestionFilter = new QuestionFilter();
    $ForumQuestions = new ForumQuestions();

    $topQuestionIds = $QuestionFilter->TopQuestions();
    $questionIteration = 0;

?>

<section class="box-one sidebar right-sidebar" id="sidebar">
    <div class="inside-box xs-padding latest-box">
        <div class="row default-sidebar" id="top-questions">
            <div class="col-xs-12 no-p">
                <p id="sidebar-feature-title" class="simple-heading latest-title" data-after-click-text="Newest Questions" data-initial-text="Top Questions" ></p>
            </div>
            <hr>
            <div id="sidebar-top-questions">
                <div class="col-xs-12 no-p">
                    <?php
                    foreach ($topQuestionIds as $key => $questionData){
                        if($questionIteration < 6):
                            $postID = $key;
                            $Question = new SingleQuestion($postID);
                            $post_path = '/' . RELATIVE_PATH. 'forum/'. $Question->pageIdentifier . '/';
                            ?>
                            <div id="user-post-<?php echo $questionIteration; ?>" class="table user-post-item">
                                <div class="cell">
                                    <a class="wrap" href="<?php echo $post_path; ?>"><img alt="<?php echo ucwords(User::user_info('username',$Question->questionUsersId)); ?>'s Profile Image" src="/<?php echo $User->get_user_profile_img(false,$Question->questionUsersId) ;?>" class="img-circle profile-img"></a>
                                </div>
                                <div class="cell">
                                    <div class="user-text">
                                        <div class="simple-heading user-name">
                                            <a class="wrap" href="<?php echo $post_path; ?>"><?php echo ucwords(User::user_info('username',$Question->questionUsersId)); ?></a>
                                        </div>
                                        <a class="post-title" href="<?php echo $post_path; ?>">
                                            <?php echo $General->trim_text($Question->question,100); ?>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        <?php else:
                            break;
                        endif;
                        $questionIteration++;
                    }
                    ?>
                </div>
            </div>
            <div id="sidebar-recent-questions">
                <?php foreach ($ForumQuestions->getLatestPost(6) as $index => $post) : ?>
                <?php  $post_path = '/' . RELATIVE_PATH. 'forum/'. $post['pageIdentifier'] . '/'; ?>
                    <div id="user-post-<?php echo $index; ?>" class="table user-post-item">
                        <div class="cell">
                            <a class="wrap" href="<?php echo $post_path; ?>"><img alt="<?php echo ucwords(User::user_info('username',$post['user_id'])); ?>'s Profile Image" src="/<?php echo $User->get_user_profile_img(false,$post['user_id']) ;?>" class="img-circle profile-img"></a>
                        </div>
                        <div class="cell">
                            <div class="user-text">
                                <div class="simple-heading user-name">
                                    <a class="wrap" href="<?php echo $post_path; ?>"><?php echo ucwords(User::user_info('username',$post['user_id'])); ?></a>
                                </div>
                                <a class="post-title" href="<?php echo $post_path; ?>">
                                    <?php echo $General->trim_text($post['question'],100); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <hr>
            <div class="text-center">
                <button data-initial-text="Show Newest" data-after-click-text="Show Top Questions" class="link"></button>
            </div>
        </div>
    </div>
</section>