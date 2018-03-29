<?php $page_user_id = ($_GET['user_id']) ? $_GET['user_id'] : null; ?>

<?php /** users profile page code */
    if($page_user_id == null):
        $user_id = $Sessions->get( 'user-id' );

    else :
	    $user_id = $page_user_id;
    endif;

    $User = new User();
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
                A <?php echo $User->user_i_am($User->user_info('i_am_a',$user_id)); ?> from <?php echo strtoupper(User::user_info('state',$user_id)); ?> concerned about <?php echo $User->him_or_her($user_id); ?> <?php echo $User->user_concerned_about($User->user_info('concerned_about',$user_id)); ?> › <a class="wrap" href="/<?php echo RELATIVE_PATH; ?>protected/settings">Edit</a> • <i id="sign-out" class="fa fa-sign-out" aria-hidden="true"></i>
                <!--<span class="user-questions">0</span> Questions <span class="user-answers">0</span>
                Answers-->
            </div>
        </div>
    </div>
</section>