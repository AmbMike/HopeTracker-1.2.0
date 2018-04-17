<?php
/**
 * File For: HopeTracker.com
 * File Name: logged-in.php.
 * Author: Mike Giammattei
 * Created On: 3/22/2017, 2:21 PM
 */;
?>
<?php


/** Link path for users profile/journal page */
$user_profile_path = RELATIVE_PATH . "/profile/";

?>

<?php
include_once(CLASSES . 'Nav.php');
include_once(CLASSES . 'User.php');
include_once(CLASSES . 'Sessions.php');
include_once(CLASSES . 'class.UserProfile.php');

$General = new General();
$User = new User();
$Sessions = new Sessions();
$UserProfile = new UserProfile();

error_reporting( 3 );
?>

<ul class="logged-in">
    <li <?php echo $UserProfile->profile($Sessions->get('user-id')); ?>><img src="/<?php echo $User->get_user_profile_img(false,$Sessions->get('user-id')); ?>" class="profile-img menu-one-trigger">
		<?php /*  <ul class="dropdown-menu text-center">
	      <li class="clicker"><a href="/protected/settings/">Settings</a> </li>
            <li class="clicker" id="sign-out">Sign Out </li>
        </ul>*/ ?>
    </li>
    <li <?php echo $UserProfile->profile($Sessions->get('user-id')); ?> class="menu-one-trigger"><span class="target"><?php echo User::user_info('username'); ?></span><?php echo (Nav::show_active($active_link,'Profile') ? : ''); ?></li>
    <li><a href="/<?php echo RELATIVE_PATH; ?>protected/course/">University</a><?php echo (Nav::show_active($active_link,'University') ? : ''); ?></li>
    <li><a href="/<?php echo RELATIVE_PATH; ?>families-of-drug-addicts/">Community</a><?php echo (Nav::show_active($active_link,'Community') ? : ''); ?></li>
	<?php /* <li><a href="/inspiration/">Inspiration</a> <?php echo (Nav::show_active($active_link,'Inspiration') ? : ''); ?></li> */ ?>
    <li><a href="/<?php echo RELATIVE_PATH; ?>family-of-drug-abuser/">Forums</a><?php echo (Nav::show_active($active_link,'Forums') ? : ''); ?></li>
    <li class="form-btn">Insurance Checker
        <ul id="form-help-nav" class="insurance-form-ul ">
            <li class="insurance-form-li">
				<?php //include_once(FORMS . 'get-help-now.php'); ?>
				<?php include_once(FORMS . 'insurance-form.php'); ?>
            </li>
        </ul>
    </li>
</ul>
