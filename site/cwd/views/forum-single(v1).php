<?php
/**
 * Copyright (c) 2017.
 */

/**
 * File For: HopeTracker.com
 * File Name: forum-single.php.
 * Author: Mike Giammattei
 * Created On: 8/23/2017, 10:14 AM
 */;
?>
<?php
include_once(CLASSES . 'Forum.php');
include_once(CLASSES . 'ForumPostStatus.php');
include_once(CLASSES . 'class.ViewedPost.php');
include_once(CLASSES .'class.ForumCategories.php');


/** @var  $ForumCategories : Class object */
$ForumCategories = new ForumCategories();

/** @var  $Session */
$Session = new Sessions();

/** @var  $forum_id */
$forum_id = $_GET['forum_id'];
/** @var  $Forum object */
$Forum = new Forum();

/** @var  $ForumPostStatus object */
$ForumPostStatus = new ForumPostStatus($forum_id);

/**
 * Sets the forum as viewed for user's who follow the forum subcategory.
 */
$ForumPostStatus->main();

/** @var  $Page object */
$Page = new \Page_Attr\Page();

/** Page Header Information */
$Page->header(array(
    'Title' => 'Forum Title',
    'Description' => '',
    'Show Nav' => false,
    'Active Link' => 'Forums'
));

/** Set the forum post as viewed."2 for "forum" as the post type */
/** @var  $ViewedPost */
$ViewedPost =  new ViewedPost();

$ViewedPost->setViewedPost($_GET['forum_id'], 2);

/** @var  $forum_post */
$forum_post = $Forum->get_forum_by_id($forum_id);



if ($_GET['reply_id']) {
    echo $_GET['reply_id'];
}
?>
<div class="con" id="forum-single">
    <div class="row">
        <div class="col-md-8">
            <main>
                <section class="box-one">
                    <div class="post">
                        <div class="headings">
                            <ul>
                                <?php $forum_sub_cat_data = $Forum->get_sub_category_forum($forum_post['sub_category_id']); ?>
                                <li class="category" onclick="location.href='/family-of-drug-abuser'"><span class="li-label"><?php echo $Forum->get_category($forum_sub_cat_data['parent_category_id']); ?></span> </li>
                                <li class="subcategory"><span class="li-label"><?php echo $forum_sub_cat_data['sub_category']; ?></span></li>
                                <li class="post-count-moderator">
                                    <div class="post-count-label pull-left">
                                        <span class="count-box"><?php echo $ForumCategories->getPostCountForSubcategory($forum_sub_cat_data['id']); ?></span> Post
                                    </div>
                                    <div class="post-moderator">
                                        <div class="table">
                                            <div class="cell">
                                                <?php $moderator = $Forum->get_category($forum_sub_cat_data['parent_category_id'], true); ?>
                                                <img class="profile-img cir sm" src="/<?php echo (User::user_info('profile_img',$moderator)) ? : DEFAULT_PROFILE_IMG; ?>">
                                            </div>
                                            <div class="cell">
                                                <span class="moderator-label">Moderated By: </span>
                                                <span class="moderator-name"><?php echo (ucfirst(User::user_info('fname', $moderator) .' ' . User::user_info('lname', $moderator))); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row" id="main-post">
                        <div class="col-sm-12">
                            <div class="headings">
                                <i data-forum-user-id="<?php echo $forum_post['created_user_id'];  ?>"  data-forum-id="<?php echo $forum_post['id'];  ?>" class="fa fa-star star <?php echo ($Forum->liked_forum($forum_post['id']) == true) ? 'liked' : ''; ?>"></i>
                                <span class="title"><?php echo $forum_post['title']; ?></span>
                                <span class="edit-action">Edit</span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="created-date">
                                <span><?php echo date(' M n, Y', $forum_post['create_date']); ?></span>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="emotions"><?php; ?>
                                <span class="numbers"><?php echo $Forum->convert_emotions($forum_post['anxiety']); ?>:</span>
                                <span class="emotion-labels">Anxiety</span>
                                <span class="numbers"><?php echo $Forum->convert_emotions($forum_post['isolation']); ?>:</span>
                                <span class="emotion-labels">Isolation</span>
                                <span class="numbers"><?php echo $Forum->convert_emotions($forum_post['happiness']); ?>:</span>
                                <span class="emotion-labels">Happiness</span>
                            </div>
                        </div>
                        <div class="content">
                            <?php echo $forum_post['content']; ?>
                        </div>
                    </div>
                </section>
                <div id="reply-posts">
                    <?php foreach ( $Forum->get_forum_replies( $forum_post['id']) as $forum_reply) : ?>
                        <section class="box-one" id="user-action-post">
                            <div class="inside-box theme-gray ">
                                <div class="row ">
                                    <div class="col-sm-8">
                                        <div class="commenter">

                                            <img class="profile-img cir sm" src="/<?php echo (User::user_info('profile_img',$forum_reply['user_id'])) ? : DEFAULT_PROFILE_IMG; ?>">
                                            <p class="author">By: <span class="author-name"><?php echo (ucfirst(User::user_info('fname', $forum_reply['user_id']) .' ' . User::user_info('lname', $forum_reply['user_id']))); ?></span> | <span class="date"><?php echo date('M d, Y', $forum_reply['date_created']); ?></span> </p>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <p class="post-user-action "><span class="post-like <?php echo ($Forum->liked_forum_post($forum_post['id'],$forum_reply['id'],$forum_reply['user_id']) == true) ? 'liked' : ''; ?>" data-forum-post-id="<?php echo $forum_post['id']; ?>" data-forum-post-user-id="<?php echo $forum_post['created_user_id']; ?>" data-forum-reply-user-id="<?php echo $forum_reply['user_id']; ?>" data-forum-reply-id="<?php echo $forum_reply['id']; ?>">Like</span> | <span class="report-post">Report</span> </p>
                                    </div>
                                    <div class="col-md-12 ">
                                        <?php echo $forum_reply['message']; ?>
                                    </div>
                                </div>
                            </div>
                        </section>
                    <?php endforeach; ?>
                </div>

                <section class="box-one">
                    <div class="inside-box">
                        <div class="pagination-box">
                            <ul class="default-pagination">
                                <li>1</li>
                                <li>2</li>
                            </ul>
                        </div>
                    </div>
                </section>
                <section class="box-one" id="reply-box">
                    <div class="inside-box">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-box">
                                    <form class="form-horizontal" id="forum-comment" method="post" action="">
                                        <div class="alert alert-success success-box">Your reply has been added successfully!</div>
                                        <textarea data-empty-msg="Share your reply by writing your thoughts in the box above." class="form-control" name="message" placeholder="Offer your support or advice..."></textarea>
                                        <input type="submit" id="forum-comment-btn" data-forum-post-id="<?php echo $forum_post['id']; ?>" data-forum-post-user-id="<?php echo $forum_post['created_user_id']; ?>" class="btn blue <?php echo ($Session->get('logged_in') == 0) ? 'tooltip-mg' : '';?>" <?php echo ($Session->get('logged_in') == 0) ? 'data-pt-title="You must be signed in to reply to this post." data-pt-gravity="top" data-pt-animate="jello" data-pt-scheme="black" data-pt-size="small" ' : ''; ?> value="Reply">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </div>
        <div class="col-md-4 sidebar-box">
            <aside>
                <?php include(SIDEBAR); ?>
            </aside>
        </div>
    </div>
</div>