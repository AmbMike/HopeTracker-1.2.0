<?php
$Page = new \Page_Attr\Page();
$Page->header(array(
        'Title' => 'Admin Login | HopeTracker',
        'Description' => 'If you have admin privileges, use this page to sign in to the admin panel.  ',
        'Show Nav' => false,
        'Show Header' => 'No',
        'Active Link' => ''
    ));
?>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="/HopeAdmin/index2.html"><b>HopeTracker</b>Admin</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">You must be an admin to sign in</p>
        <form id="sign-in-admin" method="post">
            <div id="error-box" style="display: none;" class="callout callout-danger">
                <h4>Access Denied</h4>
                <p>Your account does not grant Admin access.</p>
            </div>
            <div class="form-group has-feedback">
                <input type="email" name="email" class="form-control" placeholder="Email">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox"> Remember Me
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" id="admin-login-btn" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <?php /* <a href="#">I forgot my password</a><br> */ ?>

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->


