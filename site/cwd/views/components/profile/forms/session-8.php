<?php
/**
 * FileName: session-3.php
 * Description:
 *
 * Created by: Ambrosia Digital Team.
 * Author: Michael Giammattei
 * Date: 7/17/2019
 */

include_once(CLASSES . 'Profile/Grateful.php');
$Grateful = new \Profile\Grateful();
$courseSession = 8;
?>

<div class="panel panel-default i-default-journal-panel" id="i-journal-panel-<?php echo $courseSession; ?>">
    <div class="panel-heading"  <?php echo (!isset($_GET['entry_type'])) ? ' role="button"  data-toggle="collapse" data-target="#i-journal-panel-session-'.$courseSession.'"' : ''; ?>>
        <div class="s-table">
            <div class="s-cell">
                <span class="s-title">Grateful Journal </span>
            </div>
        </div>
    </div>
    <div class="panel-body s-no-lp collapse <?php echo ($SectionHandler->courseValue == $courseSession) ? 'in' : ''; ?>" id="i-journal-panel-session-<?php echo $courseSession; ?>">
        <div id="main-journal-3" class="s-panel-body">
            <div class="s-table i-author s-sub-lp">
                <div class="s-cell i-profile-img s-v-top">
                    <div class="s-profile-img" style="background-image: url('/<?php echo $User->get_user_profile_img(false,$Sessions->get('user-id')); ?>');">
                    </div>
                    <?php $postDateSes = ($Grateful->hasPost) ? $Grateful->thePost['date_created'] : time(); ?>
                    <span class="s-date"><?php echo strtoupper(date("M d",$postDateSes)); ?></span>
                </div>
                <div class="s-cell">
                    <div class="alert alert-success success-notification" style="display: none; margin-bottom: 15px">
                        <h4 style="margin: 0;"><i class="icon fa fa-check"></i> Posted Successfully!</h4>
                    </div>
                    <form id="i-f-journal-<?php echo $courseSession; ?>" data-session-type="<?php echo $courseSession; ?>" data-post-id="<?php echo $Grateful->thePost['id']; ?>"  onsubmit="return processFormSession1(event,this.id);" class="s-default-form">
                        <div class="form-group">
                            <textarea class="s-one-line" id="sesOneEight12" placeholder="10 Things I'm Grateful for in Life"><?php echo ($Grateful->postContentObj->sesOneEight12 && $Grateful->hasPost) ? $Grateful->postContentObj->sesOneEight12 : ''; ?></textarea>
                        </div>
                        <div class="form-group">
                            <textarea class="s-half" id="sesTwoEight12" placeholder="What are you grateful for in life? - Stay Positive"><?php echo ($Grateful->postContentObj->sesTwoEight12 && $Grateful->hasPost) ? $Grateful->postContentObj->sesTwoEight12 : ''; ?></textarea>
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
