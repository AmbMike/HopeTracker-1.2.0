<?php
/**
 * File For: HopeTracker.com
 * File Name: preview-chat-slider.php.
 * Author: Mike Giammattei
 * Created On: 3/16/2017, 5:20 PM
 */
?>
<?php
include_once(CLASSES .'Chat.php');
$User = new User();
$Chat = new Chat();
$users_online = $User->users_online();
$chat_users = $User->users_online_plus_moderators();

?>
<div class="row no-margins" id="headings">
    <div class="col-sm-8 no-p">
        <p class="blk-heading-md heading">Live Now</p>
    </div>
    <div class="col-sm-4 no-p">
        <p class="live-count"><span class="live-user">10</span> / 2203</p>
    </div>
</div>
<hr>
<div id="chat-box">
    <div id="step5" class="chat-box">
        <div class="inner">
            <div class="slider online-user-list">
            <?php foreach ( $chat_users as $index => $user_online) :  ?>
                    <?php if($user_online['user_id'] != $Sessions->get('user-id')) :?>

                        <div id="box-holder" class="box-holder">
                            <div class="left">
                                <img src="/<?php echo $User->get_user_profile_img( false, $user_online['user_id']); ?>" class="img-circle profile-img">
                            </div>
                            <div class="right">
                                    <p><strong class="text-uppercase"><?php echo $User->user_info('username',$user_online['user_id']); ?></strong>
                                        <span class="accent">A <?php echo strtolower($User->user_i_am($User->user_info('i_am_a',$user_online['user_id']))); ?> <!--from St. Louis, MO--> is concerned about <?php echo $User->him_or_her($user_online['user_id']); ?> <?php echo $User->user_concerned_about($User->user_info('i_am_a',$user_online['user_id'])); ?>.</span></p>
                                    <!--<a href="#" class="btn btn-default gray sm" data-toggle="tooltip" title="You must be signed in to chat" disabled>Chat</a>-->
                                <div id="chat-status-<?php echo $index; ?>">
                                    <div id="status-inside-<?php echo $index; ?>">
                                        <?php
                                        if($Chat->users_in_chatroom($user_online['user_id']) == true){
                                            $request_status = 'Users Chatting';
                                        }else{
                                            /* Get chat request status value */
                                            $request_status = $Chat->chat_request_status($user_online['user_id'],true);
                                        }

                                        /* if user is in chat, disable user to one chat instance */
                                        if($Chat->busy_in_single_chat($Sessions->get('user-id')) == true && $request_status != 'Users Chatting'){
                                            $request_status = "One Chat at a time";
                                        }

                                        $chat_disabled = '';
                                        $chat_class = 'green';
                                        $chat_status_arr = $Chat->chat_button_status($request_status);
                                        $chat_disabled = $chat_status_arr['disabled'];
                                        $chat_class = $chat_status_arr['status_class'];

                                        if($Sessions->get('logged_in') == 0){
                                            $chat_disabled = 'disabled';
                                            $chat_class = 'gray';
                                        }
                                        /* Condition for moderator logged in or out
                                        if($User->is_user_still_logged_in($user_online['user_id']) == 0){
                                            $chat_disabled = 'disabled';
                                            $request_status = 'Offline';
                                            $moderators_id = $user_online['user_id'];
                                        }*/
                                        ?>
                                        <a id="chat-request-<?php echo $index; ?>" href="#" data-requested-user-id="<?php echo $user_online['user_id']; ?>" class="<?php echo ($Session->get('logged_in') == 0) ? 'tooltip-mg' : '';?> btn btn-default <?php echo $chat_class; ?> sm  margin-sides-bottom" <?php echo ($Session->get('logged_in') == 0) ? 'tooltip-mg' : ''; ?>" <?php echo ($Session->get('logged_in') == 0) ? 'data-pt-title="You must be signed in to chat" data-pt-gravity="top" data-pt-animate="jello" data-pt-scheme="black" data-pt-size="small" disabled' : ''; ?><?php echo $chat_disabled; ?> tabindex="0"><?php echo $request_status; ?></a>
                                        <?php /* If moderator is logged out show */ ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
    <a href="#" <?php echo ($Session->get('logged_in') == 0) ? '' : 'data-toggle="modal" data-target="#sidebar-share-modal"';?>  class="btn btn-default green block <?php echo ($Session->get('logged_in') == 0) ? 'tooltip-mg' : '';?>" <?php echo ($Session->get('logged_in') == 0) ? 'data-pt-title="You must be signed in to chat" data-pt-gravity="top" data-pt-animate="jello" data-pt-scheme="black" data-pt-size="small" disabled' : ''; ?>>Invite a friend</a>
    <div id="sidebar-share-modal" class="modal modal-message fade " style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="blk-heading-md">Invite a Friend</p>
                </div>
                <div class="modal-title">

                </div>
                <div class="modal-body">
                    <form id="sidebar-share-form" action="/" >
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Your Full Name" name="senders_name" disabled value="<?php echo User::full_name($Sessions->get('user-id')); ?>">
                            <input type="hidden" name="users_name" value="<?php echo User::full_name($Sessions->get('user-id')); ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Recipients Full Name" id="recipients_name" name="recipients_name">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Recipients Email" id="recipients_email" name="recipients_email">
                        </div>
                        <button type="submit"  class="btn btn-primary">Send</button>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
</div>
