<?php
/**
 * File For: HopeTracker.com
 * File Name: footer.php.
 * Author: Mike Giammattei / Paul Giammattei
 * Created On: 12/10/2017, 12:28 PM
 */
?>

<?php

if($_POST['submit']){

	require_once( CLASSES . 'class.DeleteUser.php' );
	$DeleteUser = new DeleteUser();

}

$Page = new \Page_Attr\Page();
$Page->header(array(
	'Title' => 'Delete Account',
	'Description' => 'If for any reason you\'d like to delete your account, simply confirm your decision to delete your account.',
));

?>

<div class="con main" >
	<div class="row">
		<div class="col-md-8" id="delete-user-account">
			<main>
                <section class="box-one">
                    <div class="inside-box">
                        <h1 class="blk-heading-main">Delete Account</h1>
                        <p>IMPORTANT - Once your account is deleted you will no longer have access to the Hopetracker member features. </p>

                        <form method="post" onsubmit='return confirm("Confirm you would like to delete your account by clicking Ok, or click cancel if you do not want to delete your account.")'>
                            <p><input name="submit" type="submit" value="Delete My Account" class="btn btn-primary danger"></p>
                        </form>
                    </div>
                </section>
			</main>
		</div>
		<div class="col-md-4 sidebar-box">
			<aside>
				<?php include(SIDEBAR); ?>
			</aside>
		</div>
	</div>
</div>