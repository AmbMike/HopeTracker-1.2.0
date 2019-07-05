<?php
/**
 * File For: HopeTracker.com
 * File Name: sidebar-live-now.php.
 * Author: Mike Giammattei / Paul Giammattei
 * Created On: 3/16/2017, 5:20 PM
 */
?>

<?php
include_once(CLASSES .'Chat.php');
$User = new User();
/** Disabled Chat - */
$Chat = new Chat();
$users_online = $User->users_online();
$chat_users = $User->users_online_plus_moderators(true, 0,  4);

include_once(CLASSES . 'class.UserProfile.php');
$UserProfile = new UserProfile();
?>
<?php if(!empty($users_online)) : ?>
    <section class="box-one sidebar right-sidebar" id="sidebar">
        <div class="inside-side xs-padding">
            <div id="sidebar-live-now" class="live-now-container">

                <div class="simple-heading live-now-title">
                    Do you know other families in addiction?
                </div>
                <div class="invite-box">
                    <a href="#" data-toggle="modal" style="opacity: 0" data-target="#sidebar-share-modal"><i class="fa fa-envelope"></i> Invite a Friend</a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </section>
    <div id="sidebar-share-modal" class="modal modal-message fade " style="display: none;" aria-hidden="true">
        <div class="modal-dialog" style="opacity: 0;">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="blk-heading-md">Invite a Friend</p>
                </div>
                <div class="modal-title">

                </div>
                <div class="modal-body">
                    <form id="sidebar-share-form" action="/" >

                    <?php if($Sessions->get('logged_in')): ?>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Your Full Name" name="senders_name" disabled value="<?php echo User::full_name($Sessions->get('user-id')); ?>">
                        </div>
                        <div class="form-group">
                            <input type="hidden" class="form-control" placeholder="Your Email" value="random@random.com" name="senders_email">
                        </div>
                    <?php else: ?>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Your Full Name" name="senders_name">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Your Email" name="senders_email">
                        </div>
                    <?php endif; ?>
                        <input type="hidden" name="users_name" value="<?php echo User::full_name($Sessions->get('user-id')); ?>">

                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Recipients Full Name" id="recipients_name" name="recipients_name">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Recipients Email" id="recipients_email" name="recipients_email">
                        </div>
                        <?php if($Session->get('logged_in') === 0): ?>
                        <div class="form-group captcha-fail-msg" style="display: none;">
                            <div class="alert alert-danger">
                                <strong>Captcha Required</strong> <br>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="g-recaptcha" data-callback="recaptchaCallback" data-sitekey="6LewyasUAAAAAP_CTF6IDSfOanIlnA64R1-3VQnl"></div>
                        </div>
                        <?php endif; ?>
                        <button type="submit"  class="btn btn-primary">Send</button>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>