<?php
/**
 * FileName: session-3.php
 * Description:
 *
 * Created by: Ambrosia Digital Team.
 * Author: Michael Giammattei
 * Date: 7/17/2019
 */

include_once(CLASSES . 'Profile/Intervention.php');
$Intervention = new \Profile\Intervention();
$courseSession = 4;
?>

<div class="panel panel-default i-default-journal-panel" id="i-journal-panel-3">
    <div class="panel-heading" <?php echo (!isset($_GET['entry_type'])) ? ' role="button"  data-toggle="collapse" data-target="#i-journal-panel-session-4"' : ''; ?>>
        <div class="s-table">
            <div class="s-cell">
                <span class="s-title">Intervention Journal </span>
            </div>
        </div>
    </div>
    <div class="panel-body s-no-lp collapse <?php echo ($SectionHandler->courseValue == $courseSession) ? 'in' : ''; ?>" id="i-journal-panel-session-4">
        <div id="main-journal-3" class="s-panel-body">
            <div class="s-table i-author s-sub-lp">
                <div class="s-cell i-profile-img s-v-top">
                    <div class="s-profile-img" style="background-image: url('/<?php echo $User->get_user_profile_img(false,$Sessions->get('user-id')); ?>');">
                    </div>
                    <?php $postDateSes = ($Intervention->hasPost) ? $Intervention->thePost['date_created'] : time(); ?>
                    <span class="s-date"><?php echo strtoupper(date("M d",$postDateSes)); ?></span>
                </div>
                <div class="s-cell">
                    <div class="alert alert-success success-notification" style="display: none; margin-bottom: 15px">
                        <h4 style="margin: 0;"><i class="icon fa fa-check"></i> Posted Successfully!</h4>
                    </div>
                    <form id="i-f-journal-4" data-session-type="<?php echo $courseSession; ?>" data-post-id="<?php echo $Intervention->thePost['id']; ?>"  onsubmit="return processFormSession1(event,this.id);" class="s-default-form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <textarea class="s-half s-one-line" id="sesIntOne6" placeholder="Which 5-6 people will you include."><?php echo ($Intervention->postContentObj->sesIntOne6 && $Intervention->hasPost) ? $Intervention->postContentObj->sesIntOne6 : ''; ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <textarea class="s-half s-one-line" id="sesIntTwo6" placeholder="Where and when will you meet?"><?php echo ($Intervention->postContentObj->sesIntTwo6 && $Intervention->hasPost) ? $Intervention->postContentObj->sesIntTwo6 : ''; ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea id="sesIntThree12" placeholder="How will you get your <?php echo $User->user_concerned_about(User::user_info('concerned_about', $Sessions->get('user-id'))); ?> there?"><?php echo ($Intervention->postContentObj->sesIntThree12 && $Intervention->hasPost) ? $Intervention->postContentObj->sesIntThree12 : ''; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <textarea id="sesIntFour12" placeholder="What specific behaviors and incidents will you talk about to show the seriousness of the issue?"><?php echo ($Intervention->postContentObj->seIntsFour12 && $Intervention->hasPost) ? $Intervention->postContentObj->sesIntFour12 : ''; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <textarea id="sesIntFive12" placeholder="What will be your <?php echo $User->user_concerned_about(User::user_info('concerned_about', $Sessions->get('user-id'))); ?>'s biggest excuse? How will you overcome it?"><?php echo ($Intervention->postContentObj->sesIntFive12 && $Intervention->hasPost) ? $Intervention->postContentObj->sesFive12 : ''; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <textarea id="sesIntSix12" placeholder="What treatment option have you selected and why?"><?php echo ($Intervention->postContentObj->seIntsSix12 && $Intervention->hasPost) ? $Intervention->postContentObj->sesIntSix12 : ''; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <textarea id="sesIntSeven12" placeholder="What consequences are you prepared to enforce, if it comes to that?"><?php echo ($Intervention->postContentObj->sesIntSeven12 && $Intervention->hasPost) ? $Intervention->postContentObj->sesIntSeven12 : ''; ?></textarea>
                                </div>
                            </div>
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
