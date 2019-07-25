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
$ProfileForm = new ProfileForm($courseSession);


?>

<div class="panel panel-default i-default-journal-panel" id="i-main-journal-panel">
    <div class="panel-heading">
        <div class="s-table">
            <div class="s-cell">
                <span class="s-title">Session 1 Journal</span>
            </div>
        </div>
    </div>
    <div class="panel-body s-no-lp">
        <div id="main-journal">
            <div class="s-table i-author s-sub-lp">
                <div class="s-cell i-profile-img s-v-top">
                    <?php include_once(VIEWS . 'components/profile/user-data.php'); ?>
                </div>
                <div class="s-cell">
                    <form id="i-f-journal-1" data-session-type="<?php echo $courseSession; ?>" onsubmit="return processFormSession1(event);" class="s-default-form">
                        <div class="form-group">
                            <textarea class="s-full" placeholder="<?php echo $placeholder_content; ?>"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="s-menu-box">
                                    <ul class="s-default-dropdown i-show-options">
                                        <li class="i-select-one"><span class="on">-- Select One --</span>
                                            <ul class="i-submenu" data-post-visibility="0" id="i-visibility-select">
                                                <li data-post-visibility="1"><span>Save Private</span></li>
                                                <li data-post-visibility="2"><span>Post To Community</span></li>
                                                <li data-post-visibility="3"><span>Share On Facebook</span></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>

                                <i class="fa fa-question i-info-action" role="button"></i>

                            </div>
                            <div class="col-xs-6 text-right">
                                <button class="s-btn btn-lg">Done</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
