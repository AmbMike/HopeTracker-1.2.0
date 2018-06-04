<?php
/**
 * File For: HopeTracker.com
 * File Name: footer.php.
 * Author: Mike Giammattei / Paul Giammattei
 * Created On: 3/10/2017, 12:28 PM
 */
?>

</div> <?php /* End of wrapper div */ ?>
<?php if($no_footer == false) : ?>

<?php
if(!isset($SignUpBtn)){
	$SignUpBtn = new SignUpBtn('https://www.ambrosiatc.com/?ambTRK=HOPETRACKER','Ambrosia','Join Now <small>(It\'s free)</small>');
}
?>
<footer>
    <div id="footer-content">
        <div class="inside-box">
            <div class="con">
                <div class="row">
                    <div class="col-sm-7">
                        <div class="footer-title">
                            You're not alone.
                        </div>
                        <div class="footer-text">
                            The worry. The obsession. The guilt. The anger. <strong class="green-text-md">It's real.</strong>
                        </div>
                    </div>
                    <div class="col-sm-5 text-right">
                        <button  <?php echo $SignUpBtn->btnActionHTML; ?>  class="btn btn-default green footer-form-btn">
				            <?php  echo $SignUpBtn->optionBtnText('Get Hope', $data['footer']); ?>
                        </button>
                    </div>
                    <div class="col-xs-12">
                        <div class="legal-box">
                            <span class="legal-text">&COPY; 2017 Ambrosia Treatment Center  </span>
                            <?php /** Post Launch Update */ ?>
                            <a class="copyright-footer" href="http://www.ambrosiatc.com/terms-privacy/"> <i class="fa fa-circle" aria-hidden="true"></i> Terms & Privacy</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php endif; ?>
<div id="modal-success" class="modal modal-message modal-success fade" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fa fa-thumbs-up"></i>
            </div>
            <div class="modal-title">Success</div>
            <div class="modal-body">Your from was submitted! </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
<div id="confirm-modal" class="modal modal-message modal-success fade" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <p class="blk-heading-md">Confirm</p>
            </div>
            <div class="modal-title"></div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-btn-value="ok" data-dismiss="modal">OK</button>
                <button type="button" class="btn btn-success" data-btn-value="cancel" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<?php
    /* HomeVar switch - set logic for showing overlay - See jquery to show in the footer*/
    $home_var = ($_GET['homeVar']) ? $_GET['homeVar'] : null;
    switch ($home_var) :
        case null :
              echo '<div class="overlay"></div>';
        break;
	    case 'deleted-account' :
		    echo '<div id="modal-deleted" class="modal modal-message modal-success" >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <i class="fa fa-thumbs-up"></i>
                        </div>
                        <div class="modal-body">Your account has been successfully disabled. </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>';
        break;
        default:  echo '<div class="overlay"></div>';
    endswitch;
?>
<?php
/** Set a cookie that allows the Hopetracker back button to be
 * displayed when a user arrive from the HT site. */
if(isset($_GET['fromHopeTracker'])){
    setcookie('fromHopeTracker', true,  time()+86400);
}
/** Back Button */
/*if(isset($_COOKIE['fromHopeTracker']) || isset($_GET['fromHopeTracker'])){ */?><!--
    <a href="<?php /*echo BASE_URL; */?>protected/course/" class="btn btn-default nohover" style="max-width:250px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;position:fixed;z-index:100;bottom:15px;left:15px;background:rgba(146,146,146,.81);font-size:14px;font-weight:600"><i class="fa fa-chevron-circle-left" style="font-size: 27px; float:left; margin:-3px 13px 3px 0px; position: relative; top: 3px; display:inline-block;" aria-hidden="true"></i>  <span style="position: relative; top: 4px;">Go back to HopeTracker</span></a>
--><?php /*} */?>

<?php if($_SESSION['logged_in'] == 1): ?>
    <div id="refresh-notify">
        <?php include_once(VIEWS . 'alerts/chat-alert.php'); ?>
    </div>
<?php endif; ?>

<?php
include_once(CLASSES . 'Chat.php');
$Chat = new Chat();
$users_chatroom = $Chat->user_in_chatroom();
?>
<div id="load-chat-box">
    <div id="chat-box-main" data-chat-request-id="<?php echo ($users_chatroom[0]['request_id']) ? : ''; ?>" data-chatroom="<?php echo ($users_chatroom[0]['chat_room_token']) ? : ''; ?>">
        <?php
        /* Load Chat Box */
        if($users_chatroom == true){
            include_once(VIEWS .'chat-mods/chat-box.php');
        }
        ?>
    </div>
</div>

<?php if(ENV == 'dev' || 'live footer'): ?>
    <?php /* remove when running production grunt */

    function script_dev_version($directory){

        $path = $_SERVER["DOCUMENT_ROOT"].'/'. RELATIVE_PATH .'site/cwd/js/'.$directory;

        /* Exclude files */
        $files = array_diff(scandir($path), array('.', '..','jquery-3-1-1.js','a.validation.js','bootstrap.js'));

        foreach ($files as $index => $file) {
            if ($file != ".") {
                if(is_file($path.'/'.$file)) {
                    echo '<script type="text/javascript" src="/'. RELATIVE_PATH .'site/cwd/js/'.$directory.'/' . $file . '"></script>' . PHP_EOL;
                }
            }
        }
    }
    /* Main Jquery Lib */
	echo '<script type="text/javascript" src="/'. RELATIVE_PATH .'site/cwd/js/global-variables.js"></script>' . PHP_EOL;
    echo '<script type="text/javascript" src="/'. RELATIVE_PATH .'site/cwd/js/jquery-3-1-1.js"></script>' . PHP_EOL;
    echo '<script type="text/javascript" src="/'. RELATIVE_PATH .'site/cwd/js/bootstrap/bootstrap.min.js"></script>' . PHP_EOL;

    ?>
    <script src="<?php echo TINYMCE; ?>" type="text/javascript"></script>
    <script src="/<?php echo RELATIVE_PATH; ?>mod/croppic/croppic.js" type="text/javascript"></script>
    <script src="/<?php echo RELATIVE_PATH; ?>site/cwd/js/concats/a.validation.js" type="text/javascript"></script>
    <?php
    script_dev_version('concats');
    script_dev_version('concats/plugs');
    script_dev_version('concats/forms');
    script_dev_version('concats/widgets');
    ?>
    <script src="/<?php echo RELATIVE_PATH; ?>site/cwd/js/shared.js" type="text/javascript"></script>
<?php else: ?>
    <script src="<?php echo TINYMCE; ?>" type="text/javascript"></script>

    <script src="<?php echo MAIN_JS; ?>" type="text/javascript"></script>
<?php endif; ?>

<?php if(isset($text_left)) : ?>
    <script src="<?php echo JS . 'includes/text-left.js'; ?>" type="text/javascript"></script>
    <script src="<?php echo JS . 'includes/home-slider.js'; ?>" type="text/javascript"></script>
<?php endif; ?>

<?php if($home_var == 'deleted-account'): ?>
    <script>
        $('#modal-deleted').modal('show');
    </script>
<?php endif; ?>

</body>
</html>