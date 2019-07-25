<?php
/**
 * FileName: session-3.php
 * Description:
 *
 * Created by: Ambrosia Digital Team.
 * Author: Michael Giammattei
 * Date: 7/17/2019
 */

include_once(CLASSES . 'Profile/Detachment.php');
$Detachment = new \Profile\Detachment();
$courseSession = 5;
?>

<div class="panel panel-default i-default-journal-panel" id="i-journal-panel-3">
    <div class="panel-heading" <?php echo (!isset($_GET['entry_type'])) ? ' role="button"  data-toggle="collapse" data-target="#i-journal-panel-session-5"' : ''; ?>>
        <div class="s-table">
            <div class="s-cell">
                <span class="s-title">Detachment Journal </span>
            </div>
        </div>
    </div>
    <div class="panel-body s-no-lp collapse <?php echo ($SectionHandler->courseValue == $courseSession) ? 'in' : ''; ?>" id="i-journal-panel-session-5">
        <div id="main-journal-3" class="s-panel-body">
            <div class="s-table i-author s-sub-lp">
                <div class="s-cell i-profile-img s-v-top">
                    <div class="s-profile-img" style="background-image: url('/<?php echo $User->get_user_profile_img(false,$Sessions->get('user-id')); ?>');">
                    </div>
                    <span class="s-date"><?php echo strtoupper(date("M d",$Detachment->thePost['date_created'])); ?></span>
                </div>
                <div class="s-cell">
                    <div class="alert alert-success success-notification" style="display: none; margin-bottom: 15px">
                        <h4 style="margin: 0;"><i class="icon fa fa-check"></i> Posted Successfully!</h4>
                    </div>
                    <form id="i-f-journal-5" data-session-type="<?php echo $courseSession; ?>" data-post-id="<?php echo $Detachment->thePost['id']; ?>"  onsubmit="return processFormSession1(event,this.id);" class="s-default-form">
                        <div class="form-group">
                            <textarea id="sesOne12" placeholder="How does your <?php echo $User->user_concerned_about(User::user_info('concerned_about', $Sessions->get('user-id'))); ?> refusal of treatment make you feel?"><?php echo ($Detachment->postContentObj->sesOne12 && $Detachment->hasPost) ? $Detachment->postContentObj->sesOne12 : ''; ?></textarea>
                        </div>
                        <div class="form-group">
                            <textarea id="sesTwo12" placeholder="What is causing those feelings at a deeper level?"><?php echo ($Detachment->postContentObj->sesTwo12 && $Detachment->hasPost) ? $Detachment->postContentObj->sesTwo12 : ''; ?></textarea>
                        </div>
                        <div class="form-group">
                            <textarea id="sesThree12" placeholder="What can you do (or not do) to feel better?"><?php echo ($Detachment->postContentObj->sesThree12 && $Detachment->hasPost) ? $Detachment->postContentObj->sesThree12 : ''; ?></textarea>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-xs-offset-6 text-right">
                                <button class="s-btn btn-lg"><?php echo (empty($currentPost)) ? 'Done' : 'Edit'; ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
