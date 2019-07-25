<?php
/**
 * FileName: session-3.php
 * Description:
 *
 * Created by: Ambrosia Digital Team.
 * Author: Michael Giammattei
 * Date: 7/17/2019
 */

include_once(CLASSES . 'Profile/Enabling.php');
$Enabling = new \Profile\Enabling();
$courseSession = 7;
?>

<div class="panel panel-default i-default-journal-panel" id="i-journal-panel-<?php echo $courseSession; ?>">
    <div class="panel-heading"  <?php echo (!isset($_GET['entry_type'])) ? ' role="button"  data-toggle="collapse" data-target="#i-journal-panel-session-'.$courseSession.'"' : ''; ?>>
        <div class="s-table">
            <div class="s-cell">
                <span class="s-title">Enabling Journal </span>
            </div>
        </div>
    </div>
    <div class="panel-body s-no-lp collapse <?php echo ($SectionHandler->courseValue == $courseSession) ? 'in' : ''; ?>" id="i-journal-panel-session-<?php echo $courseSession; ?>">
        <div id="main-journal-3" class="s-panel-body">
            <div class="s-table i-author s-sub-lp">
                <div class="s-cell i-profile-img s-v-top">
                    <div class="s-profile-img" style="background-image: url('/<?php echo $User->get_user_profile_img(false,$Sessions->get('user-id')); ?>');">
                    </div>
                    <span class="s-date"><?php echo strtoupper(date("M d",$Enabling->thePost['date_created'])); ?></span>
                </div>
                <div class="s-cell">
                    <div class="alert alert-success success-notification" style="display: none; margin-bottom: 15px">
                        <h4 style="margin: 0;"><i class="icon fa fa-check"></i> Posted Successfully!</h4>
                    </div>
                    <form id="i-f-journal-<?php echo $courseSession; ?>" data-session-type="<?php echo $courseSession; ?>" data-post-id="<?php echo $Enabling->thePost['id']; ?>"  onsubmit="return processFormSession1(event,this.id);" class="s-default-form">
                        <div class="form-group">
                            <textarea class="s-one-line" id="sesOneSev12" placeholder="I'm Going to Stop Enabling My <?php echo ucfirst($User->user_concerned_about(User::user_info('concerned_about', $Sessions->get('user-id')))); ?> "><?php echo ($Enabling->postContentObj->sesOneSev12 && $Enabling->hasPost) ? $Enabling->postContentObj->sesOneSev12 : ''; ?></textarea>
                        </div>
                        <div class="form-group">
                            <textarea class="s-half" id="sesTwoSev12" placeholder="What have you done that was clearly (or probably) enabling? Are there behaviors you'll change moving forward? - Be Honest"><?php echo ($Enabling->postContentObj->sesTwoSev12 && $Enabling->hasPost) ? $Enabling->postContentObj->sesTwoSev12 : ''; ?></textarea>
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
