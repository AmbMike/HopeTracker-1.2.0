<?php
/**
 * Copyright (c) 2017.
 */

/**
 * File For: HopeTracker.com
 * File Name: get-help-now.php.
 * Author: Mike Giammattei
 * Created On: 10/20/2017, 3:43 PM
 */;


$forms = new Forms();
$Session = new Sessions();
?>
<div class="close-btn-help"></div>
<div class="heading">
    <p class="white-heading-one-md">Get Help Now</p>
</div>
<form method="POST" id="get-help-now-form">

    <div class="form-group">
        <div class="input-box full">
            <label for="fname">Full Name</label>
            <input type="text" data-toggle="tooltip" title=" Name Required" id="fullname" name="fullname" value="<?php echo (User::full_name($Session->get('user-id'))) ? :''; ?>" placeholder="Enter Name" >
        </div>
    </div>
    <div class="form-group">
        <div class="input-box full">
            <label for="fname">Email</label>
            <input type="text" data-toggle="tooltip" title="Email Required" id="email" value="<?php echo strtolower((User::users_email($Session->get('user-id'))) ? :''); ?>" name="email" placeholder="Enter Email" >
        </div>
    </div>
    <div class="form-group">
        <div class="input-box full">
            <label for="fname">Phone</label>
            <input type="text" data-toggle="tooltip" title="Phone Required" id="phone" name="phone" placeholder="Enter Phone" >
        </div>
    </div>
   <p class="label">Are you helping yourself or a loved one? </p>
    <div class="row">
        <div class="col-xs-3">
            <div class="radio radio-primary">
                <input type="radio" name="help_for" id="radio1" value="Myself">
                <label for="radio1">
                    Myself
                </label>
            </div>
        </div>
        <div class="col-xs-8">
            <div class="radio radio-primary">
                <input type="radio" name="help_for" id="radio2" value="A Loved One">
                <label for="radio2">
                    A Loved One
                </label>
            </div>
        </div>
    </div>
    <p class="label">Do you have health insurance? </p>
    <div class="row">
        <div class="col-xs-3">
            <div class="radio radio-primary">
                <input type="radio" name="insurance" id="insurance1" value="Yes">
                <label for="insurance1">
                    Yes
                </label>
            </div>
        </div>
        <div class="col-xs-8">
            <div class="radio radio-primary">
                <input type="radio" name="insurance" id="insurance2" value="No">
                <label for="insurance2">
                    No
                </label>
            </div>
        </div>
    </div>
    <div class="input-box full">
        <label for="fname">Comments</label>
        <textarea type="text" data-toggle="tooltip" id="comments" name="comments" placeholder="Enter Comments" ></textarea>
    </div>
    <div class="clearfix"></div>

    <input type="hidden" name="form" value="Sign Up">
    <input type="hidden" name="token" id="session_token" value="<?php echo $_SESSION['session_token']; ?>">
    <input type="submit" class="btn btn-default green" value="Submit">
</form>
