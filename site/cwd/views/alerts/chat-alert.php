<?php
/**
 * File For: HopeTracker.com
 * File Name: chat-alert.php.
 * Author: Mike Giammattei
 * Created On: 6/16/2017, 12:54 PM
 */;
?>
<?php
    include_once(CLASSES .'Chat.php');
    $User = new User();
    $Chat = new Chat();

?>
<div id="chat-notify-con" class="chat-notify-con">
<?php
    $chat_requests = $Chat->chat_request_alert();
    if($chat_requests):
    foreach ($chat_requests as $chat_request) :

    if($chat_request['status'] == 0) :
?>
    <div class="chat-notify">
        <ul class="user-list-one">
            <li data-requested-users-id="<?php echo $chat_request['user_id']; ?>" data-request-id="<?php echo $chat_request['id']; ?>">
                <i class="fa fa-times pull-right close" aria-hidden="true"></i>
                <img src="/<?php echo $User->get_user_profile_img( false, $chat_request['user_id']); ?>" class="img-circle profile-img pull-left">
                <span class="username"><?php echo $User->user_info('username',$chat_request['user_id']); ?></span><br>
                <a data-btn="Accept" href="#" class="btn btn-default green sm">Accept</a>
                <a data-btn="Deny" href="#" class="btn btn-default sm ">Deny</a>
                <a data-btn="Block" href="#" class="btn btn-danger sm ">Block</a>
            </li>
        </ul>
    </div>
        <?php endif; ?>
    <?php endforeach; ?>
    <?php endif; ?>
</div>
