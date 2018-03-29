<?php
/**
 * Created by PhpStorm.
 * User: JUNI
 * Date: 6/9/2017
 * Time: 1:46 AM
 */
?>
<?php
\Page_Attr\Page::header(array(
    'Title' => 'Settings page',
    'Description' => 'This is the Settings',
    'Show Nav' => true,
    'Active Link' => ''
));
?>
<div class="con main">
    <div class="row">
        <div class="col-sm-8">
            <main>
                <section class="box-one">
                    <h1 class="green-heading-lg top">Settings</h1>
                    <p>Change your profile photo, update your loved one's status or, most importantly, change how you display on the site. If you're looking to be anonymous, use the "Show As" drop down and hit save. </p>

                    <form class="settings-form" action="#">
                        <div class="form-fields-container">
                                <div class="col-sm-9">
                                        <div class="fields-row">
                                            <div class="field first-name input-box">
                                                <input type="text" placeholder="First name"/>
                                            </div>
                                            <div class="field last-name input-box">
                                                <input type="text" placeholder="Last name"/>
                                            </div>
                                            <div class="field dropdown input-box">
                                                Show as:
                                                <select>
                                                    <option value="first-last">First L.</option>
                                                    <option value="mom128">Mom128</option>
                                                </select>
                                                <i data-toggle="tooltip" title="lorem ipsum" class="fa fa-question-circle-o"></i>
                                            </div>
                                        </div>

                                        <div class="fields-row">
                                            <div class="field first-name">
                                                <input type="email" placeholder="Email"/>
                                            </div>
                                            <div class="field last-name">
                                                <input type="text" placeholder="Zip"/>
                                            </div>
                                            <div class="field dropdown">
                                                <select>
                                                    <option value="first-last">State</option>
                                                    <option value="mom128">Mom128</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="fields-row">
                                            <div class="field dropdown">
                                                I am a:
                                                <select>
                                                    <option value="first-last">Mom</option>
                                                    <option value="mom128">Mom128</option>
                                                </select>
                                            </div>
                                            <div class="field dropdown">
                                                Concerned about my:
                                                <select>
                                                    <option value="first-last">Son</option>
                                                    <option value="mom128">Mom128</option>
                                                </select>
                                            </div>
                                            <div class="field dropdown">
                                                In:
                                                <select>
                                                    <option value="first-last">Active addiction</option>
                                                    <option value="mom128">Mom128</option>
                                                </select>
                                            </div>
                                        </div>

                                    <div class="fields-row">
                                        <div class="field">
                                            Change Password
                                            <input type="password" placeholder="Current Password"/>
                                            <i data-toggle="tooltip" title="lorem ipsum" class="fa fa-question-circle-o"></i>
                                        </div>
                                    </div>
                                    <div class="fields-row">
                                        <div class="field">
                                            <input type="password" placeholder="New Password"/>
                                        </div>
                                        <div class="field">
                                            <input type="password" placeholder="New Password(confirm)"/>
                                            <i data-toggle="tooltip" title="lorem ipsum" class="fa fa-question-circle-o"></i>
                                        </div>
                                    </div>
                                    <div class="fields-row">
                                        <div class="field">
                                            <a class="save-btn blue" href="#">Save Changes</a>
                                        </div>
                                    </div>
                                </div>
                            <div class="col-sm-3">
                                <div class="pull-right" style="max-width: 128px">
                                    <img src="#" alt="photo-thumb"/><i data-toggle="tooltip" title="lorem ipsum" class="fa fa-question-circle-o"></i>
                                    <a class="save-btn blue" href="#">Replace</a>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                        <div class="form-fields-container">
                            <h2>Give Feedback</h2>
                            <div class="row">
                                <div class="col-sm-6">
                                    <p>How did you find out about the portal?</p>
                                    <input type="text" /><br/>
                                    <p>How would you rate your experince with the portal?</p>
                                    <input id="ex1" data-slider-id='ex1Slider' type="text" data-slider-min="0" data-slider-max="20" data-slider-step="1" data-slider-value="14"/>

                                </div>
                                <div class="col-sm-6">
                                    <p>What features can we add to make the portal more useful?</p>
                                    <textarea name="addfeatures" id="features" cols="20" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </section>
            </main>
        </div>
        <div class="col-sm-4">
            <aside>
                <?php include(SIDEBAR); ?>
            </aside>
        </div>
    </div>
</div>
