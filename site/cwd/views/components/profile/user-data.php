<?php
/**
 * FileName: user-data.php
 * Description:
 *
 * Created by: Ambrosia Digital Team.
 * Author: Michael Giammattei
 * Date: 7/15/2019
 */
?>

<div class="s-profile-img" style="background-image: url('/<?php echo $User->get_user_profile_img(false,$Sessions->get('user-id')); ?>');">
</div>
<span onclick="location.href='/<?php echo RELATIVE_PATH; ?>protected/settings/'" role="button" class="i-settings s-link">Settings</span>
