<?php
/**
 * File For: HopeTracker.com
 * File Name: chat.php.
 * Author: Mike Giammattei
 * Created On: 6/9/2017, 3:17 PM
 */;
?>
<?php
$Page = new \Page_Attr\Page();
$Page->header(array(
    'Title' => 'Chat',
    'Description' => 'Chat with other members of the site.',
    'Show Nav' => true,
    'Active Link' => ''
));

include_once(CLASSES .'Chat.php');
$User = new User();
$Chat = new Chat();
$Sessions = new Sessions();

$users_online = $User->users_online();

?>
<div class="con main ">
    <div class="row">
        <div class="col-sm-8">
            <main>
                <section class="box-one ">
                    <div class="inside-box">
                        <h1 class="green-heading-lg top">Chatroom </h1>
                        <ul id="online-user-list" class="online-user-list user-list-one">
                        <?php foreach ( $users_online as $index => $user_online) :  ?>
                            <?php if($user_online['user_id'] != $Sessions->get('user-id')) :?>
                            <?php

                                if($Chat->users_in_chatroom($user_online['user_id']) == true){
                                    $request_status = 'Users Chatting';
                                }else{
                                    /* Get chat request status value */
                                    $request_status = $Chat->chat_request_status($user_online['user_id'],true);
                                }
                                /* Disable Chat Request Conditions */
                                $disabled = '';
                                $status_class = 'green';
                                switch ($request_status):
                                    case 'Users Chatting' :
                                        $disabled = 'disabled';
                                        $status_class = 'gray';
                                    break;
                                    case 'Busy' :
                                        $disabled = 'disabled';
                                        $status_class = 'gray';
                                    break;
                                    case 'Blocked' :
                                        $disabled = 'disabled';
                                        $status_class = 'gray';
                                    break;
                                    case 'Denied' :
                                        $disabled = 'disabled';
                                        $status_class = 'gray';
                                    break;
                                    case 'Awaiting Response' :
                                        $disabled = 'disabled';
                                        $status_class = 'gray';
                                    break;
                                endswitch;
                            ?>
                            <li>
                                <img src="/<?php echo $User->get_user_profile_img( false, $user_online['user_id']); ?>" class="img-circle profile-img pull-left">
                                <span class="username"><?php echo $User->user_info('username',$user_online['user_id']); ?></span>
                                <a id="chat-request-<?php echo $index; ?>" href="#" data-requested-user-id="<?php echo $user_online['user_id']; ?>" class="btn btn-default <?php echo $status_class; ?> sm " <?php echo ($User->is_logged_in()) == 0 ? 'data-toggle="tooltip" title="You must be signed in to chat"' : ''; ?> <?php echo ($Chat->check_if_user_requested_chat($user_online['user_id']) == 1) ? 'data-toggle="tooltip" title=""' : ''; ?><?php echo $disabled; ?> tabindex="0"><?php echo $request_status; ?></a>
                            </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php
                    //include_once(VIEWS . 'chat-mods/chat-box.php'); ?>
                </section>
            </main>
        </div>
        <div class="col-sm-4 sidebar-box">
            <aside>
                <?php include(SIDEBAR); ?>
            </aside>
        </div>
    </div>
</div>

