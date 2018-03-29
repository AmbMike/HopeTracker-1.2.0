<?php
/**
 * File For: HopeTracker.com
 * File Name: filtered-journal.php.
 * Author: Mike Giammattei
 * Created On: 8/15/2017, 10:52 AM
 */;
?>
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/config/constants.php');
include_once(CLASSES .'/Journal.php');
include_once(CLASSES .'/Icons.php');
include_once(CLASSES .'/Comments.php');
include_once(CLASSES .'/Sessions.php');
include_once(CLASSES .'/URL.php');

$journal = new Journal();
$user = new User();
$Icon = new Icons();
$URL = new URL();
$Comments = new Comments();
$Session = new Sessions();

?>
<?php $entries = $journal->journal_filter($_GET['filter']); ?>
<?php foreach ($entries as $index => $entry) : ?>
    <div class="box-one entry-box" id="journal-position-<? echo $index; ?>">
        <div class="inside-box" id="journal-posts">
            <div class="table">
                <div class="emotion cell">
                    <i class="fa <?php echo $Icon->feeling_icons($entry['feeling']); ?>" aria-hidden="true"></i>
                </div>
                <div class="content-box cell">
                    <div class="table">
                        <p class="title cell"><?php echo $entry['title']; ?></p>
                        <p class="date cell"><?php echo date('D',strtotime($entry['created_entry'])); ?> <?php echo date('d/m/Y',strtotime($entry['created_entry'])); ?> </p>
                    </div>
                    <div class="content readmore-content">
                        <?php echo $entry['content'];?>
                        <div class="inside-box" id="range-box">
                            <div class="row">
                                <div class="col-sm-12">
                                    <hr>
                                </div>
                                <div class="col-sm-3">
                                    <?php  $a_arr = unserialize($entry['anxiety']); ?>
                                    <label for="anxiety">Anxiety</label>
                                    <input id="anxiety" disabled type="range" min="0" max="100" style="background-size:<?php echo $a_arr['size']; ?>" value="<?php echo $a_arr['value']; ?>" />
                                </div>
                                <div class="col-sm-3">
                                    <?php  $a_arr = unserialize($entry['isolation']); ?>
                                    <label for="isolation">Isolation</label>
                                    <input id="isolation" disabled type="range" min="0" max="100" style="background-size:<?php echo $a_arr['size']; ?>" value="<?php echo $a_arr['value']; ?>" />
                                </div>
                                <div class="col-sm-3">
                                    <?php  $a_arr = unserialize($entry['happiness']); ?>
                                    <label for="happiness">Happiness</label>
                                    <input id="happiness" disabled type="range" min="0" max="100" style="background-size:<?php echo $a_arr['size']; ?>" value="<?php echo $a_arr['value']; ?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="comments-section">
                <div class="row">
                    <div class="col-md-12">
                        <hr>
                    </div>
                    <div class="col-xs-10" id="interact">
                        <a data-journal-id="<?php echo $entry['id']; ?>" class="like <?php echo ($journal->check_if_liked('journal_likes',$entry['id'])) == true ? 'liked' : ''; ?>">
                            <i class="fa fa-thumbs-up action-btn" aria-hidden="true"></i> <span class="hidden-xs">Like</span>
                        </a>
                        <a id="comment-qty-<?php echo $index; ?>" data-journal-id="<?php echo $entry['id']; ?>" class="comment">
                            <i class="fa fa-comment-o action-btn" aria-hidden="true"></i> <span class="hidden-xs"><?php echo ($journal->get_journal_comments($entry['id'])) ? $journal->journal_comment_count($entry['id']): ''; ?> Comments</span>
                        </a>
                        <a class="share-btn" data-toggle="collapse" data-target="#share-link-<?php echo $index; ?>" data-journal-position="<?php echo $index; ?>">
                            <i class="fa fa-share action-btn" aria-hidden="true"></i> <span class="hidden-xs"><?php echo ($journal->is_user())  ? 'Share' : 'Share' ; ?></span>
                        </a>
                        <div id="share-link-<?php echo $index; ?>" class="collapse">
                            <!-- Trigger -->
                            <form class="navbar-form input-submit">
                                <div class="input-group add-on">
                                    <input type="text" id="copy-share-<? echo $index; ?>" value="<?php echo $URL->current_url(); ?>#journal-position-<? echo $index; ?>" class="form-control" placeholder="Search">
                                    <div class="input-group-btn">
                                        <button data-pt-title="Copied!" data-pt-gravity="top" data-pt-animate="jello" data-pt-scheme="black" data-pt-size="small" class="copy-btn btn-default click-tooltip" data-clipboard-target="#copy-share-<? echo $index; ?>" type="button"><i alt="Copy to clipboard" class="fa fa-clipboard" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-xs-2">
                        <i class="fa fa-chevron-circle-down show-more-content " aria-hidden="true"></i>
                    </div>
                    <div class="clearfix"></div>

                    <div id="input-box-<?php echo $index; ?>">
                        <?php if(!empty($journal->get_journal_comments($entry['id']))): ?>
                            <?php $count = 0 ?>
                            <?php foreach ( $journal->get_journal_comments($entry['id']) as $comment_data) : ?>
                                <div class="col-md-12">
                                    <div class="other-comments">
                                        <?php if($count == 0) : ?>
                                            <div class="comment-editor">
                                                <div class="table">
                                                    <form id="journal-entry-form" data-journal-id="<?php echo $entry['id']; ?>">
                                                        <div class="cell">
                                                            <img src="/<?php echo (User::user_info('profile_img')) ? : DEFAULT_PROFILE_IMG; ?>" class="Profile">
                                                        </div>
                                                        <div class="cell" id="comment-editor-<?php echo $index; ?>">
                                                            <div class="input-box <?php echo ($Session->get('logged_in') == 0) ? 'tooltip-mg' : '';?>" <?php echo ($Session->get('logged_in') == 0) ? 'data-pt-title="Must be logged in to use this feature" data-pt-gravity="top" data-pt-animate="jello" data-pt-scheme="black" data-pt-size="small"' : ''; ?>>
                                                                <input id="comment" type="text" <?php echo ($user->is_logged_in() == 0) ? 'disabled' : ''; ?> class="form-control" name="comment" placeholder="Enter Comment...">
                                                            </div>
                                                        </div>
                                                        <div class="cell" id="comment-btn-<?php echo $index; ?>">
                                                            <input data-journal-id="<?php echo $entry['id']; ?>" type="submit" <?php echo ($user->is_logged_in() == 0) ? 'disabled' : ''; ?> class="btn btn-default green block" name="comment_btn" value="Comment">
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
                                                        <a class="like-comment <?php echo ($Comments->check_if_comments_liked($comment_data['user_id'],$entry['id'],$comment_data['id'])) == true ? 'liked' : ''; ?>" id="like" data-parent-entry-id="<?php echo $entry['id']; ?>" data-comment-user-id="<?php echo $comment_data['user_id']; ?>" data-comment-id="<?php echo $comment_data['id']; ?>">Like</a>
                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                        <a id="reply" <?php echo ($Session->get('logged_in') == 0) ? 'data-pt-title="Must be logged in to use this feature" data-pt-gravity="top" data-pt-animate="jello" data-pt-scheme="black" data-pt-size="small" disabled' : ''; ?>class="reply-btn <?php echo ($Session->get('logged_in') == 0) ? 'tooltip-mg' : '';?>" data-parent-entry-id="<?php echo $entry['id']; ?>" data-comment-user-id="<?php echo $comment_data['user_id']; ?>">Reply</a>
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
                                                                <form id="journal-entry-form"  data-journal-id="<?php echo $entry['id']; ?>">
                                                                    <div class="cell">
                                                                        <img src="/<?php echo (User::user_info('profile_img')) ? : DEFAULT_PROFILE_IMG; ?>" class="Profile">
                                                                    </div>
                                                                    <div class="cell" id="comment-editor-<?php echo $index; ?>">
                                                                        <div class="input-box <?php echo ($Session->get('logged_in') == 0) ? 'tooltip-mg' : '';?>"  <?php echo ($Session->get('logged_in') == 0) ? 'data-pt-title="Must be logged in to use this feature" data-pt-gravity="top" data-pt-animate="jello" data-pt-scheme="black" data-pt-size="small"' : ''; ?> >
                                                                            <input id="comment" type="text" <?php echo ($user->is_logged_in() == 0) ? 'disabled' : ''; ?> class="form-control" name="comment" placeholder="Enter Comment for comment.">
                                                                        </div>
                                                                    </div>
                                                                    <div class="cell" id="comment-btn-<?php echo $index; ?>">
                                                                        <input data-journal-id="<?php echo $entry['id']; ?>" type="submit" <?php echo ($user->is_logged_in() == 0) ? 'disabled' : ''; ?> class="btn btn-default green block" name="comment_btn" value="Comment" data-comment-of-comment-journal="true" data-parent-comment-user-id="<?php echo $comment_data['user_id']; ?>" data-parent-comment-id="<?php echo $comment_data['id']; ?>">
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <?php /* Show Comments for comments of comments */ ?>
                                                        <?php $comments_of_comment  = $Comments->show_comment_of_comment($entry['id'], $comment_data['id'],$comment_data['user_id'], 0,3); ?>
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
                                                            <div class="c2c-count">
                                                                <div class="pagination-box">
                                                                    <ul class="pagination pagination-sm" data-parent-post-id="<?php echo $entry['id'];  ?>" data-parent-comment-id="<?php echo $comment_data['id'];  ?>" data-parent-comment-user-id="<?php echo $comment_data['user_id'];  ?>">
                                                                        <?php $all_comments = $Comments->c_to_c_pagination_btns($comment_data['id'],3); ?>
                                                                        <?php if($all_comments > 1) :  ?>
                                                                            <?php for($i=1; $i <= $all_comments; $i++): ?>
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
                            <?php if($journal->journal_comment_count($entry['id']) > 5) :?>
                                <div class="col-md-12 text-center">
                                    <a class="btn btn-default blue show-all-comment"  data-show-less="0" data-entry-id="<?php echo $entry['id']; ?>" data-index="<?php echo $index; ?>" data-input-box-id="<?php echo $index; ?>" data-post-id="<?php echo $entry['id']; ?>">See All</a>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
