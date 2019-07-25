<?php
/**
 * FileName: session-3.php
 * Description:
 *
 * Created by: Ambrosia Digital Team.
 * Author: Michael Giammattei
 * Date: 7/17/2019
 */

include_once(CLASSES . 'Profile/Boundaries.php');
$Boundaries = new \Profile\Boundaries();
$courseSession = 3;
?>

<div class="panel panel-default i-default-journal-panel" id="i-journal-panel-3">
    <div class="panel-heading" <?php echo (!isset($_GET['entry_type'])) ? ' role="button"  data-toggle="collapse" data-target="#i-journal-panel-session-3"' : ''; ?>>
        <div class="s-table">
            <div class="s-cell">
                <span class="s-title">Boundaries Journal</span>
            </div>
        </div>
    </div>
    <div class="panel-body s-no-lp collapse <?php echo ($SectionHandler->courseValue == $courseSession) ? 'in' : ''; ?>" id="i-journal-panel-session-3">
        <div id="main-journal-3" class="s-panel-body">
            <div class="s-table i-author s-sub-lp">
                <div class="s-cell i-profile-img s-v-top">
                    <div class="s-profile-img" style="background-image: url('/<?php echo $User->get_user_profile_img(false,$Sessions->get('user-id')); ?>');">
                    </div>
                    <span class="s-date"><?php echo strtoupper(date("M d",$Boundaries->thePost['date_created'])); ?></span>
                </div>
                <div class="s-cell">
                    <div class="alert alert-success success-notification" style="display: none; margin-bottom: 15px">
                        <h4 style="margin: 0;"><i class="icon fa fa-check"></i> Posted Successfully!</h4>
                    </div>
                    <form id="i-f-journal-3" data-session-type="<?php echo $courseSession; ?>" data-post-id="<?php echo $Boundaries->thePost['id']; ?>"  onsubmit="return processFormSession1(event,this.id);" class="s-default-form">
                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <textarea class="s-half" id="tolerance6" placeholder="What I will no longer do or tolerate."><?php echo ($Boundaries->postContentObj->tolerance6 && $Boundaries->hasPost) ? $Boundaries->postContentObj->tolerance6 : ''; ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <textarea class="s-half" id="willDo6" placeholder="What I will do."><?php echo ($Boundaries->postContentObj->willDo6 && $Boundaries->hasPost) ? $Boundaries->postContentObj->willDo6 : ''; ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea id="boundary12" placeholder="How I plan to commute the boundary."><?php echo ($Boundaries->postContentObj->boundary12 && $Boundaries->hasPost) ? $Boundaries->postContentObj->boundary12 : ''; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <textarea id="broken12" placeholder="How I will keep myself following through if boundaries are broken."><?php echo ($Boundaries->postContentObj->broken12 && $Boundaries->hasPost) ? $Boundaries->postContentObj->broken12 : ''; ?></textarea>
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
