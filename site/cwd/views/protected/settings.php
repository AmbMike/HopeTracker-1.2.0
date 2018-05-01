<?php
/**
 * File For: HopeTracker.com
 * File Name: settings.php.
 * Author: Mike Giammattei
 * Created On: 7/6/2017, 12:47 PM
 */;

$Page = new \Page_Attr\Page();
$Page->header(array(
        'Title' => 'Settings page',
        'Description' => 'This is the Settings',
        'Show Nav' => true,
        'Active Link' => ''
    ));
?>
<?php
    /* Page Controller */
    switch ($_GET['page_controller']):
        case 'feedback' :
            $feedback_view = true;
        break;
        default : $feedback_view = false;
    endswitch;
?>
<?php
    $Forms = new Forms();
    $User = new User();
    $Sessions = new Sessions();
?>
<div class="con main" id="forum">
    <div class="row">
        <div class="col-sm-8">
            <main>
                <section class="box-one">
                    <div class="inside-box">
                        <?php if($feedback_view == false): ?>
                        <h1 class="green-heading-lg top">Settings</h1>
                        <p>Change how you display throughout the community. If you're looking to be anonymous, use the "show as" drop down and be sure to hit save.</p>
                        <form  method="post" id="settings-form" class="general">
                            <div class="col-md-9 no-p">
                                <div class="alert-box">
                                    <div class="alert alert-success alert-dismissable">
                                        <a href="#" class="close" >&times;</a>
                                        <strong>Updated Successfully!</strong>
                                    </div>
                                </div>
                                <div class="field-row">
                                    <div class="input-box col-md-4 no-p">
                                        <input class="default" type="text" placeholder="First Name" value="<?php echo ucfirst(User::user_info('fname')); ?>" name="fname" id="fname">
                                    </div>
                                    <div class="input-box col-md-4 no-p">
                                        <input class="default" type="text" placeholder="Last Name" value="<?php echo ucfirst(User::user_info('lname')); ?>" name="lname">
                                    </div>
                                    <div class="input-box col-md-4 no-p">
                                        <div class="table">
                                            <div class="cell text-right">
                                                <label>Show as:</label>
                                            </div>
                                            <div class="cell">
                                                <select name="username" id="username">
                                                    <option data-toggle="tooltip" title="Required" value="<?php echo User::user_info('username'); ?>"><?php echo ucfirst(User::user_info('username')); ?></option>
                                                    <option data-toggle="tooltip" title="Required" value="first_l">First L.</option>
                                                    <?php $Forms->generate_select_list('i_am', true); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="field-row">
                                    <div class="input-box col-md-4 no-p">
                                        <label for="i-am">I'm a:</label>
                                        <select name="i_am" id="i-am">
                                            <option data-toggle="tooltip" title="Required" value="<?php echo User::user_info('i_am_a'); ?>"><?php echo ucfirst($User->user_i_am(User::user_info('i_am_a'))); ?></option>
                                            <?php $Forms->generate_select_list('i_am',false, $User->user_i_am(User::user_info('i_am_a'))); ?>
                                        </select>
                                    </div>
                                    <div name="concerned_for" class="input-box col-md-4 no-p">
                                        <label for="concerned-for">Concerned about my:</label>
                                        <select data-toggle="tooltip" title="Required" name="concerned_for" id="concerned-for">
                                            <option value="<?php echo  User::user_info('concerned_about'); ?>"><?php echo  ucfirst($User->user_concerned_about(User::user_info('concerned_about'))); ?></option>
                                            <?php $Forms->generate_select_list('concerned_about',false,$User->user_concerned_about(User::user_info('concerned_about'))); ?>
                                        </select>
                                    </div>
                                    <div class="input-box col-md-4 no-p">
                                        <label for="in">In:</label>
                                        <select data-toggle="tooltip" title="Required" name="in_status" id="in">
                                            <option value="<?php echo User::user_info('in_type'); ?>"><?php echo ucfirst($User->user_in_type(User::user_info('in_type'))); ?></option>
                                            <?php $Forms->generate_select_list('status',false,$User->user_in_type(User::user_info('in_type'))); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="field-row">
                                    <div class="input-box col-md-4 no-p">

                                        <label>Change Password</label>
                                        <input class="default" autocomplete="off" name="current_pass" type="password" placeholder="Current Password"/>
                                        <!--<i data-toggle="tooltip" title="lorem ipsum" class="fa fa-question-circle-o"></i>-->
                                    </div>
                                </div>
                                <div class="field-row">
                                    <div class="input-box col-md-4">
                                        <input class="default" autocomplete="off" name="password" type="password" placeholder="New Password"/>
                                    </div>
                                    <div class="input-box col-md-4">
                                        <input class="default" autocomplete="off" name="confirmPassword" type="password" placeholder="New Password(confirm)"/>
                                    </div>
                                </div>
                                <div class="field-row">
                                    <input type="submit" class="save-btn blue" value="Save Changes">
                                </div>
                            </div>
                            <div class="col-md-3 no-p text-center">
                                <div class="img-box">
                                    <input type="hidden" value="" name="img_path" id="img-path">
                                    <img src="/<?php echo $User->get_user_profile_img(false,$Sessions->get('user-id')); ?>" class="img-responsive img-circle green-border pre-profile">
                                    <div id="settings-croppic"></div>
                                    <a class="save-btn blue crop-img-btn" id="img-crop-btn" href="#">Replace</a>
                                </div>
                            </div>
                        </form>
                        <?php endif; ?>
                        <form method="post" id="settings-feedback-form" class="general">
                            <h2 class="blk-heading-main" id="settings-form">Give Feedback</h2>
                            <div class="alert-box" style="display: none;">
                                <div class="alert alert-success margin-sides-bottom">
                                    <strong>Feedback Sent Successfully!</strong>
                                </div>
                            </div>
                            <div class="field-row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="field-row">
                                            <label>How did you find out about the portal?</label>
                                            <input class="default" type="text" name="found_out_about" />
                                        </div>
                                    </div>
                                    <div class="field-row">
                                        <label>How would you rate your experience with the portal?</label>
                                        <input class="ranges" type="range" min="0" max="100" value="50" />
                                    </div>
                                    <div class="field-row">
                                        <label>How easy is it to find what you want?</label>
                                        <input class="ranges" type="range" min="0" max="100" value="50" />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="field-row">
                                            <label>What features can we add to make the portal more useful?</label>
                                            <textarea name="features" id="features" cols="20" rows="10"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="field-row">
                                            <label>What is the one thing you would change?</label>
                                            <textarea name="change" id="change" cols="20" rows="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="field-row">
                                            <label>General comments/questions:</label>
                                            <textarea name="general" id="general" cols="20" rows="10"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="field-row">
                                            <input class="save-btn blue" type="submit" value="Send" id="settings-feedback">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <a class="pull-right gray-text" href="/<?php echo RELATIVE_PATH . 'protected/delete-account/'; ?>"><small>Delete Account</small></a>
                </section>
            </main>
        </div>
        <div class="col-sm-4 sidebar-box">
            <aside>
                <?php include(SIDEBAR); ?>
            </aside>
        </div>
    </div>
</div>