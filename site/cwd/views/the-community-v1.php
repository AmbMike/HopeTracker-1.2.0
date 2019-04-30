<?php
/**
 * File For: HopeTracker.com
 * File Name: footer.php.
 * Author: Mike Giammattei / Paul Giammattei
 * Created On: 12/10/2017, 12:28 PM
 */
?>

<?php
include_once(ARRAYS . 'states.php');
include_once(CLASSES . 'class.UserProfile.php');
include_once(CLASSES . 'Admin.php');
$UserProfile = new UserProfile();
$Page = new \Page_Attr\Page();
$Forms = new Forms();;
$Session = new Sessions();
$General = new General();
$User = new User();
$Admin = new Admin();

$Page->header(array(
	'Title' => 'Families of Drug Addicts | HopeTracker',
	'Description' => 'Follow real-time stories of parent, spouses, grandparents or siblings going through the emotions of addiction. A community of support and understanding.',
	'OG Image'  => OG_IMAGES  . 'community-pg.jpg',
	'OG Title'  => 'Families of Drug Addicts',
	'Active Link' => 'Community'
));
//Debug::data($CommunityLog->new_forum_from_followed_users());
?>
<?php
/*
#Notes
The second tier post comments require a submit comment button.
Make a post button should not close the text able area in any situation.
Clicking on comment should not only drop and show responded comments but also bring the user to the text area with the most recent response comment above it.
Clicking on thumbs up icon should activate like with all comments and sub comments.
Filters are not dropping at smaller screen sizes.
Search filter drop down fix smoothness.
Search filter drop down container bottom margin.

*/

if(isset($_GET['user_id'])){
	$post_user_id = $_GET['user_id'];
}else if($Session->get('logged_in') == 1){
	$post_user_id = $Session->get('user-id');
}else{
	$post_user_id = false;
}
?>
<div class="con main" data-community-post="page">
    <div class="row">
        <div class="col-md-8" id="the-community">
            <main>
                <div class="header-box">
                    <span class="h1-addon"><data value="<?php echo $Admin->total_users(); ?> " class="total-members"><?php echo $Admin->total_users(); ?></data> Members</span>
                    <h1 class="green-heading-lg top">The Community</h1>
                </div>
                <section class="box-one no-p">
                    <div class="filter-navigation">
                        <ul id="community-nav">
							<?php if($Session->get('logged_in') == 1): ?>
                                <li <?php /* Remove this class class="on" */ ?> data-toggle-btn="member-posts"><a class="simple-heading make-post"><i class="fa fa-pencil" aria-hidden="true"></i><span> Make Post</span></a></li>
							<?php endif; ?>
                            <li data-toggle-btn="member-search" data-search="dropdown-btn"><a class="simple-heading search-members"><i class="fa fa-address-book-o" aria-hidden="true"></i> Search Members</a></li>
                            <li data-toggle-btn="member-order" class="newest-drop-box"><a class="simple-heading newest-text"><i class="fa fa-sort-amount-asc" aria-hidden="true"></i>  <span data-order-val="newest">Newest</span> <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                            </li>
                        </ul>
                        <div data-toggle-box="member-search" id="member-filter" data-search="filter-container" class="filter-container">
                            <form class="form-horizontal by-name" id="search-by-name">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <h3>Find Someone Specific</h3>
                                    </div>
                                    <div class="col-lg-5 col-md-5 name-col" data-filter-box="username">
                                        <input type="text" autocomplete="off"  class="form-control username" id="name" name="username" placeholder="Enter name">
                                        <div class="suggested-names"></div>
                                    </div>
                                    <div class="col-md-7">
                                        <button type="submit" class="btn green btn-default">Search by Name</button>
                                    </div>
                                </div>
                            </form>
                            <form class="form-horizontal" id="search-filter">
                                <h3>Find Someone Like You</h3>
                                <div class="form-group">
                                    <div id="check-filters">
                                        <div data-search-filter="box">
                                            <div class="col-sm-6 role-col">
                                                <div class="filters">
                                                    <span role="button" data-toggle="collapse" data-target="#role-filter" class="title">They are a:</span>
                                                    <div id="role-filter" class="checkboxes in">
                                                        <div class="list-container">
															<?php  $Forms->generate_checkbox_label_list('i_am'); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6"  style="display:none;">
                                                <div class="filters">
                                                    <span role="button" data-toggle="collapse" data-target="#loved-ones" class="title">Concerned About Their</span>
                                                    <div id="loved-ones" class="checkboxes in">
                                                        <div class="list-container">
															<?php  $Forms->generate_checkbox_label_list('concerned_about'); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div id="stage" class="filters">
                                                    <span role="button" data-toggle="collapse" data-target="#stage-filter" class="title">Their loved one is in:</span>
                                                    <div id="stage-filter" class="checkboxes in">
                                                        <div class="list-container">
															<?php  $Forms->generate_checkbox_label_list('status'); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h3>They live in:</h3>
                                                <div class="row">
                                                    <div class="col-md-6 col-xs-6">
                                                        <select name="state" class="form-control" data-toggle="tooltip" title="State Required">
                                                            <option value="hide">-- State --</option>
															<?php echo FORMS::get_states(); ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 col-xs-6">
                                                        <input type="text" class="form-control" name="zip" id="zip" placeholder="Enter zip">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 text-center">
                                                        <button type="submit" class="btn green btn-default filter-search-btn">Search by Filters</button></div></div>
                                            </div>
											<?php /** Add section in database to incorporate this filter. */ ?>
											<?php /*
                                            <div class="col-sm-6">
                                                <div id="showing-as" class="filters">
                                                    <span role="button" data-toggle="collapse" data-target="#show-as-filter" class="title">Showing As</span>
                                                    <div id="show-as-filter" class="checkboxes in">
                                                        <label><input type="checkbox" value="Not Anonymous">Not Anonymous</label>
                                                        <label><input type="checkbox" value="Hide Photo">Hide Photo</label>
                                                    </div>
                                                </div>
                                            </div>
                                            */ ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </form>
                        </div>
						<?php if($Session->get('logged_in') == 1): ?>
                            <div data-toggle-box="member-posts" id="community-user-title">
                                <div class="table">
                                    <div class="cell user-img-container">
                                        <a class="wrap" <?php echo $UserProfile->profile($post_user_id); ?>><img alt="<?php echo ucwords(User::user_info('username',$post_user_id)); ?>'s Profile Image" src="/<?php echo $User->get_user_profile_img(false,$post_user_id); ?>" class="img-circle profile-img sm"></a>
                                    </div>
                                    <div class="cell">
                                        <div class="textarea-box">
                                            <textarea data-comment-journal-id=""  rows="1" data-autoresize data-postV1="comment-input" class="text-features active" name="entry_content" placeholder="What's on your mind?"></textarea>
                                        </div>
                                        <!--<div class="post-btn-box">
											<input type="submit" name="submit" value="Post" class="save-btn blue">
										</div>-->
                                    </div>
                                </div>
                                <!--  <li><a class="wrap" href="<?php /*echo $user_profile_path; */?>"><img src="/<?php /*echo (User::user_info('profile_img',$post_user_id)) ? : DEFAULT_PROFILE_IMG; */?>" class="img-circle profile-img sm"></a></li>
                            <li>
                                <div class="simple-heading user-name">
                                    <a class="wrap" href="<?php /*echo $user_profile_path; */?>"> <?php /*echo User::user_info('username',$post_user_id); */?></a>
                                </div>
                            </li>
                            <li class="user-content">
                                <div class="textarea-box">
                                    <textarea data-comment-journal-id=""  rows="1" data-autoresize data-postV1="comment-input" class="text-features active" name="entry_content" placeholder="What's on your mind?."></textarea>
                                </div>
                            </li>-->
                            </div>
						<?php endif; ?>
                        <div data-toggle-box="member-order" data-search="order-container" class="member-order-box" id="member-order">
                            <h4>How would you like to order the posts?</h4>
                            <div data-order-checkbox="newest">
                                <label class="container">Newest
                                    <input value="newest" type="radio" name="orderBy" checked="checked">
                                    <span class="checkmark"></span>
                                </label>
                                <label class="container">Oldest
                                    <input value="oldest" type="radio" name="orderBy">
                                    <span class="checkmark"></span>
                                </label>
                                <label class="container">Most liked
                                    <input value="most liked" type="radio" name="orderBy">
                                    <span class="checkmark"></span>
                                </label>
                                <label class="container">Most Commented
                                    <input value="most commented" type="radio" name="orderBy" ">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </section>
                <div id="related-post">
					<?php include_once(VIEWS . 'includes/journal/postsV1.php'); ?>
                </div>
                <div id="post-feeder"></div>
            </main>
        </div>
        <div class="col-md-4 sidebar-box">
            <aside>
				<?php include(SIDEBAR); ?>
            </aside>
        </div>
    </div>
</div>