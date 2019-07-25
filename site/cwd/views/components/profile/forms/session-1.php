<?php
/**
 * FileName: session-1.php
 * Description:
 *
 * Created by: Ambrosia Digital Team.
 * Author: Michael Giammattei
 * Date: 7/9/2019
 */

include_once(CLASSES . 'Profile/ProfileForm.php');

$ProfileForm = new ProfileForm(1);
$placeholder_content = "Tell the whole story of your ". ucfirst($User->user_concerned_about(User::user_info('concerned_about'))) ."'s addiction. How do you feel? - Let it out ";
$currentPost = $ProfileForm->getSessionFormData();
$courseSession = 1;
?>

<div class="panel panel-default i-default-journal-panel" id="i-journal-panel-1">
    <div class="panel-heading" <?php echo (!isset($_GET['entry_type'])) ? ' role="button"  data-toggle="collapse" data-target="#i-journal-panel-session-1"' : ''; ?>>
        <div class="s-table">
            <div class="s-cell">
                <span class="s-title">My Story Journal</span>
            </div>
        </div>
    </div>
    <div class="panel-body s-no-lp collapse  <?php echo ($SectionHandler->courseValue == $courseSession) ? 'in' : ''; ?>" id="i-journal-panel-session-1">
        <div id="main-journal" class="s-panel-body">
            <div class="s-table i-author s-sub-lp">
                <div class="s-cell i-profile-img s-v-top">
                    <div class="s-profile-img" style="background-image: url('/<?php echo $User->get_user_profile_img(false,$Sessions->get('user-id')); ?>');">
                    </div>
                    <span class="s-date"><?php echo strtoupper(date("M d",$currentPost['date_created'])); ?></span>
                </div>
                <div class="s-cell">
                    <div class="alert alert-success success-notification" style="display: none; margin-bottom: 15px">
                        <h4 style="margin: 0;"><i class="icon fa fa-check"></i> Posted Successfully!</h4>
                    </div>
                    <form id="i-f-journal-1" data-session-type="<?php echo $courseSession; ?>" data-post-id="<?php echo $currentPost[0]['id']; ?>"  onsubmit="return processFormSession1(event,this.id);" class="s-default-form">
                        <div class="form-group">
                            <?php if(empty($currentPost)): ?>
                            <textarea class="s-full" placeholder="<?php echo $placeholder_content; ?>"></textarea>
                            <?php else:  ?>
                            <textarea class="s-full" placeholder="<?php echo $placeholder_content; ?>"><?php echo $currentPost[0]['content']; ?></textarea>
                            <?php endif;  ?>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="s-menu-box">
                                    <ul class="s-default-dropdown i-show-options">
                                        <li class="i-select-one">

                                            <span class="on">
                                                <?php switch ($currentPost[0]['visibility']):
                                                    case 1 : echo 'Save Private'; break;
                                                    case 2 : echo 'Post To Community'; break;
                                                    case 3 : echo 'Share On Facebook'; break;
                                                    default : echo '-- Select One --';
                                                    endswitch;
                                                ?>
                                            </span>
                                            <ul class="i-submenu" data-post-visibility="<?php echo(empty($currentPost[0]['visibility'])) ? 0 : $currentPost[0]['visibility']; ?>" id="i-visibility-select">
                                                <li data-post-visibility="1" <?php echo ($currentPost[0]['visibility'] == 1)? "class='on'" :''; ?>><span>Save Private</span></li>
                                                <li data-post-visibility="2" <?php echo ($currentPost[0]['visibility'] == 2)? "class='on'" :''; ?>><span>Post To Community</span></li>
                                                <li data-post-visibility="3" <?php echo ($currentPost[0]['visibility'] == 3)? "class='on'" :''; ?>><span>Share On Facebook</span></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <i class="fa fa-question i-info-action" role="button"></i>
                            </div>
                            <div class="col-xs-6 text-right">
                                <button class="s-btn btn-lg"><?php echo (empty($currentPost)) ? 'Done' : 'Edit'; ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
