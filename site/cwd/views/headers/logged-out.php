<?php
/**
 * File For: HopeTracker.com
 * File Name: logged-out.php.
 * Author: Mike Giammattei
 * Created On: 3/22/2017, 2:20 PM
 */
?>
<?php
    include_once(CLASSES . '/URL.php');
    $URL = new URL();
?>

<?php Forms::sign_up($_POST); ?>

<ul>
    <li class="sign-title-text">Sign In</li>
    <li class="form">
        <form id="sign-in" method="post">
            <input class="form-control" name="email" type="text" placeholder="Email">
            <input class="form-control" name="password" type="password" placeholder="Password">
            <input type="hidden" name="token" id="session_token" value="<?php echo $_SESSION['session_token']; ?>">
            <input type="hidden" name="cur_url" id="cur_url" value="<?php echo $URL->current_url(); ?>">
            <input type="hidden" name="form" value="Sign In">
            <input class="form-control btn btn-default gray" type="submit"  value="Go">
        </form>
    </li>
    <li id="sign-up-btn" data-btn="home-sign-in" class="form-btn">Sign Up Now
        <ul id="form-one">
            <li>
                <?php include_once(FORMS . 'form-one.php'); ?>
            </li>
        </ul>
    </li>
</ul>
