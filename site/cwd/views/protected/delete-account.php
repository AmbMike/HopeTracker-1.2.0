<?php
/**
 * File For: HopeTracker.com
 * File Name: footer.php.
 * Author: Mike Giammattei / Paul Giammattei
 * Created On: 12/10/2017, 12:28 PM
 */
?>

<?php
$showDeleteForm = true;
if($_POST['submit']){
	require_once( CLASSES . 'class.DeleteUser.php' );
	if($DeleteUser = new DeleteUser()){
		$showDeleteForm = false;
	}

}
$Page = new \Page_Attr\Page();
$Page->header(array(
	'Title' => 'Disable Account',
	'Description' => 'If for any reason you\'d like to Disable your account, simply confirm your decision to Disable your account.',
));

?>

<div class="con main" >
	<div class="row">
		<div class="col-md-8" id="delete-user-account">
			<main>
                <section class="box-one">
                    <?php if($showDeleteForm): ?>
                    <div class="inside-box">
                        <h1 class="blk-heading-main">Disable Account</h1>
                        <p>IMPORTANT - Once your account is deleted you will no longer have access to the Hopetracker member features. </p>

                        <form method="post" onsubmit='return confirm("Confirm you would like to delete your account by clicking Ok, or click cancel if you do not want to delete your account.")'>
                            <p><input name="submit" type="submit" value="Disable My Account" class="btn btn-primary danger"></p>
                        </form>
                    </div>
                    <?php else: ?>
                        <div class="inside-box">
                            <h1 class="blk-heading-main">Account Disabled Successfully!</h1>
                        </div>
                    <?php endif; ?>
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