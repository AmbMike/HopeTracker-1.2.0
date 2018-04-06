<?php
/**
 * File For: HopeTracker.com
 * File Name: inspiration.php.
 * Author: Mike Giammattei
 * Created On: 7/20/2017, 10:51 AM
 */
?>

<?php
/**
 * File For: HopeTracker.com
 * File Name: journal.php.
 * Author: Mike Giammattei
 * Created On: 4/18/2017, 1:17 PM
 */;
?>
<?php
include_once(CLASSES .'/Debug.php');
include_once(CLASSES .'/General.php');
//include_once(CLASSES .'/Inspiration.php');
include_once(CLASSES .'/Sessions.php');
include_once(CLASSES .'/class.Inspirations.php');



$User = new User();
$General = new General();
//$Inspiration = new Inspiration();
$Session = new Sessions();

$Page = new \Page_Attr\Page();
$Page->header(array(
    'Title' => 'Addiction Quotes for Families | HopeTracker',
    'Description' => 'Worry won\'t cure anyone of addiction. You deserve happiness! As hard as it seems, take time each day to focus on yourself and the positive things in life.',
    'Active Link' => 'Inspiration',
    'OG Image' => $_GET['og_img'],
    'OG URL' => 'inspiration/?og_img='.$_GET['og_img']
));

/** Hides the sidebar inspiration sliders.  */
$hide_side_inspiration = true;

?>
<div class="con main">
    <div class="row">
        <div class="col-md-8" id="inspiration-v1">
            <main>
                <div class="main-title-box">
                    <span class="h1-addon">45 Quotes & Tips</span>
                    <h1 class="green-heading-lg main-title">Quick Inspirations</h1>
                    <p>Our thoughts obsess over our loved one, too often leaving no time for ourselves. You deserve happiness! Worrying has never cured anyone of addiction. As hard as it seems, take time each day to focus on yourself and the positive things in your life. </p>
                </div>
                <section class="box-one inspiration-content-box">
                    <span class="slider-title-text">Your life matters, and there is always hope.</span>
                    <div class="dropdown pull-right margin-sides">
                        <button class="btn btn-white dropdown-toggle <?php echo ($Session->get('logged_in') == 0) ? 'tooltip-mg gray' : ''; ?>" <?php echo ($Session->get('logged_in') == 0) ? 'data-pt-title="Login to enable this functionality" data-pt-gravity="top" data-pt-animate="jello" data-pt-scheme="black" data-pt-size="small" disabled' : ''; ?> type="button" data-toggle="dropdown">
                            <span id="filter-label"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></span>
                        </button>
                        <ul id="inspiration-filter" class="dropdown-menu">
                            <li data-filter-value="newest"><a class="cursor-pointer first" ><i class="fa fa-bookmark" aria-hidden="true"></i>latest</a></li>
                            <li data-filter-value="liked"><a class="cursor-pointer second"><i class="fa fa-window-close" aria-hidden="true"></i>liked</a></li>
                            <li data-filter-value="random"><a class="cursor-pointer third"><i class="fa fa-random" aria-hidden="true"></i>random</a></li>
                            <hr>
                            <li data-filter-value="quotes"><a class="cursor-pointer"><i class="fa fa-globe" aria-hidden="true"></i>quotes only</a></li>
                            <li data-filter-value="self-help"><a class="cursor-pointer"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>self help tips only</a></li>
                        </ul>
                    </div>
                    <hr>
                    <div class="slider-box" id="inspiration-container">
                        <div class="inspiration-box">
                            <div id="inspiration-images-outside">
                                <div id="inspiration-images">
	                                <?php if(isset($_GET['folder']) && isset($_GET['filename'])): ?>
		                                <?php
		                                include_once(CLASSES .'/class.likeInspiration.php');
		                                $likeInspiration = new likeInspiration($_GET['folder'],$_GET['filename']);

		                                ?>
                                        <img data-like-count="<?php echo $likeInspiration->totalLikes(); ?>" data-liked-status="<?php echo ($likeInspiration->checkLikedImage() == 1) ? 'liked' : 'no'; ?>" src="<?php echo IMAGES .  $_GET['folder'] . '/' . $_GET['filename']; ?>" class="img-responsive">
		                                <?php include_once(VIEWS . 'includes/inspirations/get-images.php'); ?>

	                                <?php else: ?>
		                                <?php include_once(VIEWS .'includes/inspirations/get-images.php'); ?>
	                                <?php endif; ?>
                                </div>
                            </div>
                            <div class="action-btns-box">
                                <?php if($Session->get('logged_in') == 1): ?>
                                <div class="like-box" role="button"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>Like</div>
                                <?php endif; ?>
                                <div role="button" data-comment-btn="show" class="comment-box collapsed"><i class="fa fa-comment-o" aria-hidden="true"></i>Comment</div>
                                <a target="_blank" class="share-link" href=""><div class="share-box"><i class="fa fa-share action-btn" aria-hidden="true"></i>Share</div></a>
                                <div class="nav-btn-box nav-first">
                                    <i class="fa fa-angle-double-left next" role="button" aria-hidden="true"></i>
                                    <i class="fa fa-angle-double-right prev" role="button" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                        <div data-slider-el="container" class="collapse" >
                            <hr>
                            <div id="like-count" class="like-count">
                                <i class="fa fa-circle" aria-hidden="true"></i>
                                <data value="" class="num">1</data>
                            </div>
                            <hr>
                            <div data-inspiration="comment fill">
                               <!-- <div class="table inspiration-post">
                                    <div data-slider-el="comments">
                                        <div class="cell user-img">
                                            <img src="/users/user-32/profile.jpg" class="img-circle profile-img sm ">
                                        </div>
                                        <div class="cell">
                                            <div class="post-content-box">

                                                <div class="user-name">
                                                    John Smith
                                                </div>
                                                <div class="asked-about-user">
                                                    Steven Ford
                                                </div>
                                                <div class="post-text-box">
                                                    <span>didn't understand the concept underlining the obvious concern.</span>
                                                </div>
                                                <div class="post-like-count-box">
                                                    <a class="like-btn">Like</a>
                                                    <i class="fa fa-circle first-circle" aria-hidden="true"></i>
                                                    <span class="num">5</span>
                                                    <i class="fa fa-circle second-circle" aria-hidden="true"></i>
                                                    <span class="time-stamp">16 hrs</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>-->
                            </div>
                            <div class="clearfix"></div>
	                        <?php if($Session->get('logged_in') == 1) : ?>
                                <div class="comment-box add-chat">
                                    <div class="table">
                                        <div class="cell image-cell">
                                            <div class="user-img">
                                                <a class="wrap" href="<?php echo $user_profile_path; ?>"> <img src="/<?php echo $User->get_user_profile_img($Session->get('user-id'),$Session->get('user-id')); ?>" class="img-circle profile-img sm"></a>
                                            </div>
                                        </div>
                                        <div class="cell">
                                            <div class="input-box">
                                                <div class="textarea-box">
                                                    <textarea data-comment-journal-id=""  rows="1" data-autoresize data-postV1="comment-input" class="text-features active" name="entry_content" placeholder="Begin typing here..."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
	                        <?php endif; ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
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

