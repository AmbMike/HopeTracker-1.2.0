<?php
/**
 * File For: HopeTracker.com
 * File Name: journal.php.
 * Author: Mike Giammattei
 * Created On: 4/18/2017, 1:17 PM
 */;
?>
<?php
include_once(CLASSES .'/Journal.php');
include_once(CLASSES .'/Icons.php');
include_once(CLASSES .'/Comments.php');
include_once(CLASSES .'/Sessions.php');

$Journal = new Journal();
$User = new User();
$Icon = new Icons();
$URL = new URL();
$Comments = new Comments();
$Session = new Sessions();

/** @var $ActiveLinkName : Set the active link value for line under link in nav*/
$ActiveLinkName = ( isset( $_GET['user_id'] ) ) ? 'Profile' : 'Community';

$Page = new \Page_Attr\Page();
$Page->header(array(
    'Title' => $Journal->user_profile( 'My Profile', ' Profile'),
    'Description' => 'Keep a journal and interact with other users about situations that happens in your life. ',
    'Active Link' => $ActiveLinkName
));

/* Entry Title Text */
$entry_title = ($_GET['entry_type']) ? : '';
$placeholder_content = 'Begin tying here...';
switch ($entry_title):

    case 'journalOutlet' :
        $entry_title = "My ". ucfirst($User->user_concerned_about(User::user_info('concerned_about'))) ."'s Situation & How I Feel";
        $placeholder_content = "Tell the whole story of your ". ucfirst($User->user_concerned_about(User::user_info('concerned_about'))) ."'s addiction. How do you feel? - Let it out ";
    break;
    case 'stop_enabling' :
        $entry_title = 'I\'m Going to Stop Enabling My '. ucfirst($User->user_concerned_about(User::user_info('concerned_about')));
        $placeholder_content = "What have you done that was clearly (or probably) enabling? Are there behaviors you'll change moving forward? - Be Honest";
    break;
    case 'my_boundaries' :
        $entry_title = 'My Boundaries: What\'s Not Acceptable';
        $placeholder_content = "What behaviors bother you most? What will you do if those behaviors continue? - Set Boundaries";
    break;
    case 'my_intervention' :
        $entry_title = 'My Intervention Plan | Date, People, Rehab, Counter-Points';
        $placeholder_content = "Where? When? Who should be there? What are you going to say? How can you respond to your ".ucfirst($User->user_concerned_about(User::user_info('concerned_about')))."'s push-back? - Be Prepared ";
    break;
    case 'grateful_for' :
        $entry_title = "10 Things I'm Grateful for in Life";
        $placeholder_content = "What are you grateful for in life? - Stay Positive";
    break;
    case 'refused_treatment' :
        $entry_title = 'How I Feel After My '.ucfirst($User->user_concerned_about(User::user_info('concerned_about'))).' Refused Treatment';
        $placeholder_content = "What are you feeling? What is causing those feelings (at a deeper level)? What can you do (and not do) to help feel better? - Move toward Happiness";
    break;
    case 'be_Proactive' :
        $entry_title = '10 Things I\'m Grateful For & A Plan for Positivity';
        $placeholder_content = "What are 10 things you're grateful for? What changes are you going to be more positive? - Be Proactive";
    break;
    case 'my_progress' :
        $entry_title = 'My Progress so Far';
        $placeholder_content = "How do you feel differently now that you know more about addiction? How are you feeling? - Update";
    break;
    default : $entry_title = '';
endswitch;
?>
<div class="con main">
    <div class="row">
        <div class="col-md-8"  id="journal">
            <?php if(!isset($_GET['user_id'])): ?>
                <main>
                    <section class="box-one">
                        <div class="inside-box">
                            <div class="row">
                                <div class="col-md-7">
                                    <h1 class="green-heading-lg main-title">Member Stories</h1>
                                </div>
                                <div class="col-md-5">
                                    <div class="customized-select-box">
                                        <div class="customized-select"><span>Newest</span></div>
                                        <div class="custom-drop-box">
                                            <ul class="checkbox">
                                                <li>Oldest</li>
                                                <li>Positive</li>
                                                <li>Negative</li>
                                                <li>Most Liked</li>
                                                <li>Most Commended</li>
                                                <?php /*<li>Followed</li>*/?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <?php
                        /* Pull journals if no user id is provided. If journal id is provided, serve that post first */
                        if(isset($_GET['journal_id'])):
                            $featured_journal = $Journal->journal_by_journal_id($_GET['journal_id']);
                            $entries[] = $featured_journal[0];
                            //$entries = $Journal->user_journal_entries(false,true,4);

                        /* Check if post is new and set as viewed if users first time viewing post */
                        $Journal->new_journal_check($_GET['journal_id']);
                        else:
                            $entries = $Journal->user_journal_entries(false,true,5);
                        endif;
                        ?>
                </main>
            <?php else: ?>
                <main>
                    <section id="profile-section" class="box-one">
                        <div class="inside-box">
                            <div class="table">
                                <div class="cell dis-blk">
                                    <div class="img-box">
                                        <img src="/<?php echo $Journal->entry_profile_img(); ?>" class="img-circle lg">
                                        <?php if(User::user_info('id',$Session->get('user-id')) != $_GET['user_id']): ?>
                                            <i data-followUser="<?php echo $_GET['user_id']; ?>" class="fa fa-star inline-block star tooltip-mg <?php echo ($Journal->following_user($_GET['user_id'],$Session->get('user-id')) == true) ? ' following': ''; ?>" <?php echo ($Session->get('logged_in') == 0) ? 'data-pt-title="You must be signed in to follow users"  disabled' : ' '; ?> data-pt-gravity="top" data-pt-animate="jello" data-pt-scheme="black" data-pt-size="small" aria-hidden="true"></i>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="cell dis-blk">
                                    <h1 class="green-heading-lg sub"><?php echo $Journal->user_profile( '', ' Profile'); ?></h1>
                                    <p class="blue-text-sm sub">When you translate feelings into language, you free yourself mentally. <?php echo ($Session->get('logged_in') == 1 ) ? '<a class="no-margins" href="/protected/settings/"><strong><u>settings </u></strong></a> | <i id="sign-out" class="fa fa-sign-out sign-out-btn" aria-hidden="true"></i>' : ''; ?> </p>
                                </div>
                            </div>
                        </div>
                    </section>
                    <?php if($Journal->is_user() === true) : ?>
                        <div class="alert alert-success text-center col-centered" style="display: none;" id="entry-success-box">
                            <h3>Your has been created <strong>Successfully!</strong></h3>
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        </div>
                        <section class="box-one">
                            <form id="journal-entry" method="post">
                                <div id="title-entries" class="table">
                                    <div class="cell">
                                        <div class="input-box">
                                            <input type="text" placeholder="Entry Title" value="<?php echo $entry_title; ?>" id="title" class="title" name="title">
                                        </div>
                                    </div>
                                    <div class="cell">
                                        <div class="entry-count-box">
                                            <span class="count-num">4</span> Entries
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="icon-date-box">
                                    <i class="fa fa-calendar-o" aria-hidden="true"></i>
                                    <span class="date">Mon. 2/13/2017</span>
                                </div>
                                <textarea rows="12" name="entry_content" class="text-features" placeholder="<?php echo $placeholder_content; ?>">
                                </textarea>

                                <div class="inside-box" id="range-box">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <hr>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="anxiety">Anxiety</label>
                                            <input id="anxiety" type="range" min="0" max="100" value="50" />
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="isolation">Isolation</label>
                                            <input id="isolation" type="range" min="0" max="100" value="50" />
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="happiness">Happiness</label>
                                            <input id="happiness" type="range" min="0" max="100" value="50" />
                                        </div>
                                        <div class="col-sm-3 drop-status-col">
                                            <select name="feeling">
                                                <option value="Positive">Positive</option>
                                                <option value="Neutral">Neutral</option>
                                                <option value="Negative">Negative</option>
                                            </select>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="save-btn-box">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                            <input type="submit" name="submit" value="Save Now" class="save-btn blue">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </section>
                    <?php endif; ?>
                    <div id="entry-container">
                        <?php $entries = $Journal->user_journal_entries($_GET['user_id']); ?>
                    </div>
                </main>
            <?php endif; ?>
            <section id="journal-entries" class="entries">
                <?php foreach ($entries as $index => $entry) : ?>
                    <div class="box-one entry-box" id="journal-position-<?php echo $index; ?>">
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
                                    <div class="content readmore-content <?php echo ($entry['id'] == $_GET['journal_id']) ? ' active' : ''?>">
                                        <?php echo $entry['content']; ?>
                                        <div class="inside-box" id="range-box">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <hr>
                                                </div>
                                                <div class="col-sm-3">
                                                    <?php  $a_arr = unserialize($entry['anxiety']); ?>
                                                    <label for="anxiety">Anxiety</label>
                                                    <input id="anxiety" disabled type="range" min="0" max="100" value="<?php echo $a_arr['value']; ?>" />
                                                </div>
                                                <div class="col-sm-3">
                                                    <?php  $a_arr = unserialize($entry['isolation']); ?>
                                                    <label for="isolation">Isolation</label>
                                                    <input id="isolation" disabled type="range" min="0" max="100" value="<?php echo $a_arr['value']; ?>" />
                                                </div>
                                                <div class="col-sm-3">
                                                    <?php  $a_arr = unserialize($entry['happiness']); ?>
                                                    <label for="happiness">Happiness</label>
                                                    <input id="happiness" disabled type="range" min="0" max="100" value="<?php echo $a_arr['value']; ?>" />
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
                                        <a data-journal-id="<?php echo $entry['id']; ?>" class="like <?php echo ($Journal->check_if_liked('journal_likes',$entry['id'])) == true ? 'liked' : ''; ?>">
                                            <i class="fa fa-thumbs-up action-btn" aria-hidden="true"></i> <span class="hidden-xs">Like </span>
                                        </a>
                                        <a id="comment-qty-<?php echo $index; ?>" data-journal-id="<?php echo $entry['id']; ?>" class="comment">
                                            <i class="fa fa-comment-o action-btn" aria-hidden="true"></i> <span class="hidden-xs"><?php echo ($Journal->get_journal_comments($entry['id'])) ? $Journal->journal_comment_count($entry['id']): ''; ?> Comments</span>
                                        </a>
                                        <a class="share-btn" data-toggle="collapse" data-target="#share-link-<?php echo $index; ?>" data-journal-position="<?php echo $index; ?>">
                                            <i class="fa fa-share action-btn" aria-hidden="true"></i> <span class="hidden-xs"><?php echo ($Journal->is_user())  ? 'Share' : 'Share' ; ?></span>
                                        </a>
                                        <div id="share-link-<?php echo $index; ?>" class="collapse">
                                            <!-- Trigger -->
                                            <form class="navbar-form input-submit">
                                                <div class="input-group add-on">
                                                    <input type="text" id="copy-share-<?php echo $index; ?>" value="<?php echo $URL->current_url(); ?>#journal-position-<?php echo $index; ?>" class="form-control" placeholder="Search">
                                                    <div class="input-group-btn">
                                                        <button data-pt-title="Copied!" data-pt-gravity="top" data-pt-animate="jello" data-pt-scheme="black" data-pt-size="small" class="copy-btn btn-default click-tooltip" data-clipboard-target="#copy-share-<?php echo $index; ?>" type="button"><i alt="Copy to clipboard" class="fa fa-clipboard" aria-hidden="true"></i></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <i class="fa fa-chevron-circle-down show-more-content" aria-hidden="true"></i>
                                    </div>
                                    <div class="clearfix"></div>

                                    <div id="input-box-<?php echo $index; ?>">
                                        <?php if(!empty($Journal->get_journal_comments($entry['id']))): ?>
                                            <?php $count = 0 ?>
                                            <?php foreach ( $Journal->get_journal_comments($entry['id']) as $comment_data) : ?>
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
                                                                                <input id="comment" type="text" <?php echo ($User->is_logged_in() == 0) ? 'disabled' : ''; ?> class="form-control" name="comment" placeholder="Enter Comment...">
                                                                            </div>
                                                                        </div>
                                                                        <div class="cell" id="comment-btn-<?php echo $index; ?>">
                                                                            <input data-journal-id="<?php echo $entry['id']; ?>" type="submit" <?php echo ($User->is_logged_in() == 0) ? 'disabled' : ''; ?> class="btn btn-default green block" name="comment_btn" value="Comment">
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div class="comments-container">
                                                            <div class="main-comment-box">
                                                                <div class="table level-one-comment opacity-none">
                                                                    <div class="cell person">
                                                                        <div class="table">
                                                                            <div class="cell">
                                                                                <img src="/<?php echo ($User->get_user_profile_img(false, $comment_data['user_id'])) ? : DEFAULT_PROFILE_IMG; ?>" class="Profile">
                                                                            </div>
                                                                            <div class="cell name text-center">
                                                                                <?php echo (ucfirst(User::user_info('fname',$comment_data['user_id']))) ? : ''; ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="cell comment">
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
                                                                                                <input id="comment" type="text" <?php echo ($User->is_logged_in() == 0) ? 'disabled' : ''; ?> class="form-control" name="comment" placeholder="Enter Comment for comment.">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="cell" id="comment-btn-<?php echo $index; ?>">
                                                                                            <input data-journal-id="<?php echo $entry['id']; ?>" type="submit" <?php echo ($User->is_logged_in() == 0) ? 'disabled' : ''; ?> class="btn btn-default green block" name="comment_btn" value="Comment" data-comment-of-comment-journal="true" data-parent-comment-user-id="<?php echo $comment_data['user_id']; ?>" data-parent-comment-id="<?php echo $comment_data['id']; ?>">
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                            <?php /* Show Comments for comments of comments */ ?>
                                                                            <?php $comments_of_comment  = $Comments->show_comment_of_comment($entry['id'], $comment_data['id'],$comment_data['user_id'], 0,3); ?>
                                                                            <?php if(!empty($comments_of_comment['comments'])) : ?>
                                                                                <div class="c2c-box">
                                                                                    <?php foreach ($comments_of_comment['comments'] as $comment_of_comment) : ?>
                                                                                        <div class="comment-editor comment-response-box">
                                                                                            <div class="table">
                                                                                                <div class="cell person">
                                                                                                    <div class="box">
                                                                                                        <img src="/<?php echo ($User->get_user_profile_img(false, $comment_of_comment['child_comment_user_id'])) ? : DEFAULT_PROFILE_IMG; ?>" class="Profile center-block">
                                                                                                        <span  class="blue-text-sm "><strong><?php echo (ucfirst(User::user_info('fname',$comment_of_comment['child_comment_user_id']))) ? : ''; ?></strong></span>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="cell comment reply-comment">
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
                                                </div>
                                                <?php $count++; ?>
                                            <?php endforeach; ?>
                                            <?php if($Journal->journal_comment_count($entry['id']) > 5) :?>
                                            <div class="col-md-12 text-center">
                                                <a class="btn btn-default blue show-all-comment"  data-show-less="0" data-entry-id="<?php echo $entry['id']; ?>" data-index="<?php echo $index; ?>" data-input-box-id="<?php echo $index; ?>" data-post-id="<?php echo $entry['id']; ?>">See All</a>
                                            </div>
                                            <?php endif; ?>
                                            <?php else: ?>
                                        <div class="col-md-12">
                                            <div class="other-comments">
                                            <div class="comment-editor">
                                                <div class="table">
                                                    <form id="journal-entry-form" data-journal-id="<?php echo $entry['id']; ?>">
                                                        <div class="cell">
                                                            <img src="/<?php echo (User::user_info('profile_img')) ? : DEFAULT_PROFILE_IMG; ?>" class="Profile">
                                                        </div>
                                                        <div class="cell" id="comment-editor-<?php echo $index; ?>">
                                                            <div class="input-box <?php echo ($Session->get('logged_in') == 0) ? 'tooltip-mg' : '';?>" <?php echo ($Session->get('logged_in') == 0) ? 'data-pt-title="Must be logged in to use this feature" data-pt-gravity="top" data-pt-animate="jello" data-pt-scheme="black" data-pt-size="small"' : ''; ?>>
                                                                <input id="comment" type="text" <?php echo ($User->is_logged_in() == 0) ? 'disabled' : ''; ?> class="form-control" name="comment" placeholder="Enter Comment...">
                                                            </div>
                                                        </div>
                                                        <div class="cell" id="comment-btn-<?php echo $index; ?>">
                                                            <input data-journal-id="<?php echo $entry['id']; ?>" type="submit" <?php echo ($User->is_logged_in() == 0) ? 'disabled' : ''; ?> class="btn btn-default green block" name="comment_btn" value="Comment">
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if(isset($entries) && count($entries) > 5) : ?>
                <div class="box-one">
                    <div class="col-md-12 text-center">
                        <a href="#" class="btn btn-default blue lg  see-more">See More</a>
                    </div>
                </div>
                <?php endif; ?>
            </section>
        </div>
        <div class="col-md-4 sidebar-box">
            <aside>
                <?php include(SIDEBAR);?>
            </aside>
        </div>
    </div>
</div>

