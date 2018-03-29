<?php
/**
 * File For: HopeTracker.com
 * File Name: chat-box.php.
 * Author: Mike Giammattei
 * Created On: 6/9/2017, 1:58 PM
 */;
?>
<?php
$Page = new \Page_Attr\Page();
$Page->header(array(
    'Title' => 'Chat',
    'Description' => 'Chat with other members of the site.',
    'Show Nav' => false,
    'Active Link' => '',
    'Show Header' => 'No',
    'No Min Height' => true,
    'No Footer' => true
));

include_once (CLASSES .'Chat.php');

$User = new User();
$Session = new Sessions();
$Chat = new Chat();

/* Conditional variables */
$moderator_class = '';

/* Get chat partners info */
$chatrooms_data = $Chat->user_in_chatroom();
$chat_room_token = $chatrooms_data[0]['chat_room_token'];

/* Get chat partners information */
$chatrooms_users = $Chat->get_all_users_in_chatroom($chat_room_token);
foreach ($chatrooms_users as $chatrooms_user){
    if($chatrooms_user['user_id'] != $Session->get('user-id')){
        $chat_partner_id = $chatrooms_user['user_id'];
    }
}

$moderator_offline = $User->moderator_offline($chat_partner_id);

?>
<div id="chatWidget" class="chat-widget-box">
    <div class="panel-heading">
        <div class="table">
            <div class=" cell menu">
                <i class="fa fa-ellipsis-v cursor-pointer minimizer" aria-hidden="true"></i>
            </div>
            <div class="cell">
                <h3>Chat with <?php echo ucfirst(User::user_info('fname',$chat_partner_id)); ?></h3>
            </div>
            <div class="cell">
                <i class="fa fa-close cursor-pointer close" data-toggle="modal" data-target="#confirm-modal"  aria-hidden="true"></i>
            </div>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-body" >
            <?php if($moderator_offline == true) : ?>
            <?php $moderator_class = 'moderator-offline'?>
                <div id="moderator-chat-email" class="alert alert-danger general-margin-bottom">
                    <?php echo ucfirst(User::user_info('fname',$chat_partner_id)); ?> is offline... Your message will send as an email. Your email address will be provided to <?php echo ucfirst(User::user_info('fname',$chat_partner_id)); ?> so you are able to get a response within 24 hours.
                </div>
            <?php endif; ?>
            <ul class="chat">
            </ul>
        </div>
        <div class="panel-footer">
            <div class="input-group">
                <input id="btn-input" type="text" maxlength="100" class="form-control input-sm" placeholder="Type your message here..." /> <span class="input-group-btn"> <button class="btn btn-warning btn-sm <?php echo $moderator_class; ?>" id="btn-chat"> Send</button> </span> </div>
        </div>
    </div>
</div>
