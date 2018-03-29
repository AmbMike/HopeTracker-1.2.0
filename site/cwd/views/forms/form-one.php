<?php
/**
 * File For: HopeTracker.com
 * File Name: form-one.php.
 * Author: Mike Giammattei
 * Created On: 3/23/2017, 10:31 AM
 */;
?>
<?php $forms = new Forms(); ?>
<form method="POST" id="form-one">
    <div class="close-btn"></div>
    <div class="heading">
        <p class="white-heading-one-md">Start Feeling  Better</p>
    </div>
    <div class="input-box name">
        <label for="fname">Name</label>
    </div>
    <div class="input-box ">
        <label class="user-label" for="username">Display As: </label>
        <div class="select-box username">
            <select name="username" id="username">
                <option data-toggle="tooltip" title="Required" value="full_name">First Last</option>
                <option value="first_l">First L.</option>
                <option value="anonymous">Anonymous</option>
                <?php //$forms->generate_select_list('i_am', true); ?>
            </select>
        </div>
    </div>
    <div class="input-box">
        <input type="text" data-toggle="tooltip" title="First Name Required" id="fname" name="fname" placeholder="First" >
    </div>
    <div class="input-box">
        <input type="text" data-toggle="tooltip" title="Last Name Required" name="lname" placeholder="Last" >
    </div>
    <div class="input-box full">
        <input data-toggle="tooltip" title="Email Required" name="email" placeholder="Email">
    </div>
    <div class="input-box">
        <input data-toggle="tooltip" title="Password must be at least 6 characters long" type="password" name="password" autocomplete="off" placeholder="Password">
    </div>
    <div class="input-box">
        <input type="password" data-toggle="tooltip" title="Re-enter your password" name="re_password" autocomplete="off" placeholder="Re-Password">
    </div>
    <div class="clearfix"></div>
<hr />
    <div class="select-box">
        <label for="i-am">I'm a:</label>
        <select name="i_am" id="i-am">
            <option data-toggle="tooltip" title="Required" value="hide">-- Choose --</option>
            <?php $forms->generate_select_list('i_am'); ?>
        </select>
    </div>
    <div name="concerned_for" class="select-box">
        <label for="concerned-for">Concerned about my:</label>
        <select data-toggle="tooltip" title="Required" name="concerned_for" id="concerned-for">
            <option value="hide">-- Choose --</option>
            <?php $forms->generate_select_list('concerned_about'); ?>
        </select>
    </div>
    <div class="select-box">
        <label for="in">In:</label>
        <select data-toggle="tooltip" title="Required" name="in_status" id="in">
            <option value="hide">-- Choose --</option>
            <?php $forms->generate_select_list('status'); ?>
        </select>
    </div>
    <div class="input-box">
        <input  data-toggle="tooltip" title="Zip Code Required" type="text" name="zip" placeholder="Zip" >
    </div>
    <div class="input-box menu">
        <select name="state"  data-toggle="tooltip" title="State Required" id="state">
            <option value="hide">-- State --</option>
            <?php echo FORMS::get_states(); ?>
        </select>
    </div>

    <input type="hidden" name="profile_img_path" class="imgPath" id="imgPath">
    <div class="full-box" id="upload-btn-box">
        <label for="imgCrop">(Optional) A photo will help the community connect with you.</label>
        <a class="btn btn-default gray" id="imgCrop"><i class="fa fa-picture-o"></i> Upload Profile Image</a>
        <hr />
    </div>
    <div class="form-img">
        <div class="img-box">
            <img class="pre-profile" src="<?php echo IMAGES .'main/icon.jpg'; ?>">
            <div id="cropContainerModal"></div>
        </div>
    </div>
    <div class="clearfix"></div>
    <input type="hidden" name="form" value="Sign Up">
    <input type="hidden" name="token" <!--id="session_token"--> value="<?php echo $_SESSION['session_token']; ?>">
    <input type="submit" class="btn btn-default green" value="Join Now">
</form>
