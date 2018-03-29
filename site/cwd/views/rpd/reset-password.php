<?php
/**
 * File For: HopeTracker.com
 * File Name: reset-password.php.
 * Author: Mike Giammattei
 * Created On: 4/7/2017, 9:26 AM
 */;
?>

<?php
include_once(CLASSES . 'Encrypt.php');
include_once(CLASSES . 'URL.php');

$URL = new URL();
$encrypt = new Encrypt();
$email = $URL->get_url_variable('verifyE');
$pass_hash = $URL->get_url_variable('verify');
$Page = new \Page_Attr\Page();

$Page->header(array(
    'Title' => 'Home Page Title',
    'Description' => 'This is the Home Page',
    'Show Nav' => 'No'
));
/* Redirect offend visitor */
if(empty($email) || empty($pass_hash)){
    die();
}
?>

<div class="con main emailed-password-reset">
    <div class="row">
        <div class="col-sm-12">
            <h1 class="green-heading-lg text-center">Reset Password</h1>
            <form class="center-form" method="POST" id="reset-password-form">
                <div class="input-box">
                <input disabled type="text" value="<?php echo ($email) ? $encrypt->un_mask_get_var($email) : ''; ?>">
                </div>
                <input type="hidden" name="email" value="<?php echo ($email) ? $encrypt->un_mask_get_var($email) : ''; ?>">

                <div class="input-box">
                    <div class="form-group">
                        <input type="password" id="password" class="form-control" name="password" placeholder="New Password" autocomplete="off">
                    </div>
                </div>
                <div class="input-box">
                    <div class="form-group">
                        <input type="password" id="confirmation_password" class="form-control"  name="confirmation_password" placeholder="Re Enter Password">
                    </div>
                </div>
                <input type="hidden" name="verify" value="<?php echo ($pass_hash) ? $pass_hash : ''; ?>" >

                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        <input type="submit" class="btn btn-default green" value="Submit">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>