<?php
/**
 * File For: HopeTracker.com
 * File Name: all-journal-comments.php.
 * Author: Mike Giammattei
 * Created On: 5/31/2017, 12:44 PM
 */;
?>

<?php
$journal = new Journal();
?>

<h1><?php echo $_GET['var1']; ?></h1>
    <?php if(!empty($journal->get_journal_comments($_GET['entry-id']))): ?>
        <?php $count = 0 ?>
        <?php foreach ( $journal->get_journal_comments($_GET['entry-id']) as $comment_data) : ?>
            <div class="col-md-12">
                <div class="other-comments">
                    <?php if($count == 0) : ?>
                        <div class="comment-editor">
                            <div class="table">
                                <form id="journal-entry-form" data-journal-id="<?php echo $_GET['entry-id']; ?>">
                                    <div class="cell">
                                        <img src="/<?php echo (User::user_info('profile_img')) ? : DEFAULT_PROFILE_IMG; ?>" class="Profile">
                                    </div>
                                    <div class="cell" id="comment-editor-<?php echo $_GET['index']; ?>">
                                        <div class="input-box"  <?php echo ($user->is_logged_in() == 0) ? 'data-toggle="tooltip" title="Must be logged in to leave comment."' : ''; ?> >
                                            <input id="comment" type="text" <?php echo ($user->is_logged_in() == 0) ? 'disabled' : ''; ?> class="form-control" name="comment" placeholder="Enter Comment...">
                                        </div>
                                    </div>
                                    <div class="cell" id="comment-btn-<?php echo $_GET['index']; ?>">
                                        <input data-journal-id="<?php echo $_GET['entry-id']; ?>" type="submit" <?php echo ($user->is_logged_in() == 0) ? 'disabled' : ''; ?> class="btn btn-default green block" name="comment_btn" value="Comment">
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="main-comment-box">
                        <div class="table level-one-comment opacity-none">
                            <div class="cell person">
                                <div class="table">
                                    <div class="cell">
                                        <img src="/<?php echo ($user->get_user_profile_img(false, $comment_data['user_id'])) ? : DEFAULT_PROFILE_IMG; ?>" class="Profile">
                                    </div>
                                    <div class="cell name text-center">
                                        <?php echo (ucfirst(User::user_info('fname',$comment_data['user_id']))) ? : ''; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="cel comment">
                                <?php echo $comment_data['comment']; ?>
                                <div id="like-share">
                                    <a class="like-comment <?php echo ($Comments->check_if_comments_liked($comment_data['user_id'],$_GET['entry-id'],$comment_data['id'])) == true ? 'liked' : ''; ?>" id="like" data-parent-entry-id="<?php echo $_GET['entry-id']; ?>" data-comment-user-id="<?php echo $comment_data['user_id']; ?>" data-comment-id="<?php echo $comment_data['id']; ?>">Like</a>
                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                    <a id="reply" <?php echo ($user->is_logged_in() == 0) ? 'disabled data-toggle="tooltip" title="Must be logged in to reply."' : ''; ?> class="reply-btn" data-parent-entry-id="<?php echo $_GET['entry-id']; ?>" data-comment-user-id="<?php echo $comment_data['user_id']; ?>">Reply</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="comment-of-comment">
                        <div class="row">
                            <div class="reply-box">
                                <div class="clearfix"></div>
                                <div class="col-md-12">
                                    <div class="comment-editor">
                                        <div class="table">
                                            <form id="journal-entry-form" data-journal-id="<?php echo $_GET['entry-id']; ?>">
                                                <div class="cell">
                                                    <img src="/<?php echo (User::user_info('profile_img')) ? : DEFAULT_PROFILE_IMG; ?>" class="Profile">
                                                </div>
                                                <div class="cell" id="comment-editor-<?php echo $_GET['index']; ?>">
                                                    <div class="input-box"  <?php echo ($user->is_logged_in() == 0) ? 'data-toggle="tooltip" title="Must be logged in to leave comment."' : ''; ?> >
                                                        <input id="comment" type="text" <?php echo ($user->is_logged_in() == 0) ? 'disabled' : ''; ?> class="form-control" name="comment" placeholder="Enter Comment for comment.">
                                                    </div>
                                                </div>
                                                <div class="cell" id="comment-btn-<?php echo $_GET['index']; ?>">
                                                    <input data-journal-id="<?php echo $_GET['entry-id']; ?>" type="submit" <?php echo ($user->is_logged_in() == 0) ? 'disabled' : ''; ?> class="btn btn-default green block" name="comment_btn" value="Comment" data-comment-of-comment-journal="true" data-parent-comment-user-id="<?php echo $comment_data['user_id']; ?>" data-parent-comment-id="<?php echo $comment_data['id']; ?>">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <?php /* Show Comments for comments of comments */ ?>
                                    <?php $comments_of_comment  = $Comments->show_comment_of_comment($_GET['entry-id'], $comment_data['id'],$comment_data['user_id'], 0,3); ?>
                                    <?php if(!empty($comments_of_comment['comments'])) : ?>
                                        <div class="c2c-box">
                                            <?php foreach ($comments_of_comment['comments'] as $comment_of_comment) : ?>
                                                <div class="comment-editor">
                                                    <div class="table">
                                                        <div class="cell person">
                                                            <div class="box">
                                                                <img src="/<?php echo ($user->get_user_profile_img(false, $comment_of_comment['child_comment_user_id'])) ? : DEFAULT_PROFILE_IMG; ?>" class="Profile center-block">
                                                                <span  class="blue-text-sm "><strong><?php echo (ucfirst(User::user_info('fname',$comment_of_comment['child_comment_user_id']))) ? : ''; ?></strong></span>
                                                            </div>
                                                        </div>
                                                        <div class="cel comment">
                                                            <?php echo $comment_of_comment['comment']; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <div class="text-right c2c-count">
                                            <div class="pagination-box">
                                                <ul class="pagination" data-parent-post-id="<?php echo $_GET['entry-id'];  ?>" data-parent-comment-id="<?php echo $comment_data['id'];  ?>" data-parent-comment-user-id="<?php echo $comment_data['user_id'];  ?>">
                                                    <?php if($Comments->c_to_c_pagination_btns($comment_data['id'],3)) :  ?>
                                                        <?php for($i=1; $i <= $Comments->c_to_c_pagination_btns($comment_data['id'],3); $i++): ?>
                                                            <li><a href=""><?php echo $i; ?></a></li>
                                                        <?php endfor; ?>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $count++; ?>
        <?php endforeach; ?>
        <?php if($journal->journal_comment_count($_GET['entry-id']) > 5) :?>
            <div class="col-md-12 text-center">
                <a class="btn btn-default blue show-all-comment" data-input-box-id="<?php echo $_GET['index']; ?>" data-post-id="<?php echo $_GET['entry-id']; ?>">See All</a>
            </div>
        <?php endif; ?>
    <?php endif; ?>
