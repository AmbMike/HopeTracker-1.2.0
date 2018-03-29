<?php
    $page_user_id = ($_GET['userId']) ? : null;
    $user_id = $page_user_id;
    $User = new User();

    include_once(CLASSES . 'class.FollowUser.php');
    $FollowUser = new FollowUser( $page_user_id );
?>
<section id="user-header-title" class="box-one main-box">
    <div id="user-title" class="user-title-box">
        <div class="img-box">
            <img src="/<?php echo $User->get_user_profile_img( false, $user_id); ?>" class="img-circle profile-img">
        </div>
        <div class="user-text-box">
            <span class="green-text-md user-name">
               <?php echo ucwords(User::user_info('username',$user_id)); ?>
            </span>
            <div class="user-count-container">
                A <?php echo $User->user_i_am($User->user_info('i_am_a',$user_id)); ?> from <?php echo strtoupper(User::user_info('state',$user_id)); ?> concerned about <?php echo $User->him_or_her($user_id); ?> <?php echo $User->user_concerned_about($User->user_info('concerned_about',$user_id)); ?>  <button data-follow-user-id="<?php echo $user_id; ?>" class="btn btn-primary sm"><?php echo ($FollowUser->isFollowingUser() == true) ? '<i class="fa fa-user-times"></i>  Un-Friend' : '<i class="fa fa-user-plus"></i>  Add Friend'; ?></button>  <!--<span class="user-questions">0</span> Questions <span class="user-answers">0</span>
                Answers-->
            </div>
        </div>
    </div>
</section>