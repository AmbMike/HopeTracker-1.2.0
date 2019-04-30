<?php
/**
 * File For: HopeTracker.com
 * File Name: sidebar-live-now.php.
 * Author: Mike Giammattei / Paul Giammattei
 * Created On: 3/16/2017, 5:20 PM
 */
?>

<?php
include_once(CLASSES .'Chat.php');
$User = new User();
/** Disabled Chat - */
$Chat = new Chat();
$users_online = $User->users_online();
$chat_users = $User->users_online_plus_moderators(true, 0,  4);

include_once(CLASSES . 'class.UserProfile.php');
$UserProfile = new UserProfile();
?>

<?php if(!empty($users_online)) : ?>
    <section class="box-one sidebar right-sidebar" id="sidebar">
        <div class="inside-side xs-padding">
            <div id="sidebar-live-now" class="live-now-container">
                <div class="simple-heading live-now-title">
                    Live Now
                </div>
				<?php if($Session->get('logged_in') != 0): ?>
                    <div class="invite-box">
                        <a href="#" data-toggle="modal" data-target="#sidebar-share-modal"><i class="fa fa-envelope"></i> Invite a Friend</a>
                    </div>
				<?php endif; ?>
                <div class="clearfix"></div>
				<?php
				$live_users = $chat_users;

				/*foreach ( $chat_users as $chat_user ) {
					if($chat_user['user_id'] != $Sessions->get('user-id')){
						$live_users [] = $chat_user;
					}
				}*/
				?>
				<?php foreach ( $live_users as $index33 => $user_online) :  ?>
					<?php /** Hide chat users after first 3  */ ?>
					<?php if($index33 == 3) : ?>
                        <div id="show-more-live-users" class="collapse">
					<?php endif; ?>
                    <div id="live-update-box" class="table">
                        <div class="row">
                            <div class="live-update-container">
                                <div class="cell">
                                    <div class="user-img">
                                        <a class="wrap" <?php echo $UserProfile->profile($user_online['user_id']); ?>> <img src="/<?php echo $User->get_user_profile_img( false, $user_online['user_id']); ?>" class="img-circle profile-img"></a>
                                    </div>
                                </div>
                                <div class="cell">
                                    <div class="simple-heading quote-text">
                                        <a class="wrap" <?php echo $UserProfile->profile($user_online['user_id']); ?>><span class="simple-heading user-name"><?php echo $User->user_info('username',$user_online['user_id']); ?></span></a>
                                        <div class="simple-heading chat-now-btn">
                                            <div id="chat-status-<?php echo $index33; ?>"  style="display: inline-block; width: auto;">
                                                <div id="status-inside-<?php echo $index33; ?>"  style="display: inline-block; width: auto;">
													<?php
													if($Chat->users_in_chatroom($user_online['user_id']) == true):
														$request_status = 'Users Chatting';
													else:
														/* Get chat request status value */
														$request_status = $Chat->chat_request_status($user_online['user_id'],true);
													endif;

													/* if user is in chat, disable user to one chat instance */
													if($Chat->busy_in_single_chat($Sessions->get('user-id')) == true && $request_status != 'Users Chatting'):
														$request_status = "One Chat at a time";
													endif;

													$chat_disabled = '';
													$chat_class = 'green';
													$chat_status_arr = $Chat->chat_button_status($request_status);
													$chat_disabled = $chat_status_arr['disabled'];
													$chat_class = $chat_status_arr['status_class'];

													if($Sessions->get('logged_in') == 0):
														$chat_disabled = 'disabled';
														$chat_class = 'gray';
													endif;
													?>
                                                </div>
												<?php /** Disabled Chat Button */ ?>
												<?php /**<span class="tooltip-mg <?php echo $chat_class; ?> chat-link-ACTION" <?php echo ($Session->get('logged_in') == 0) ? 'data-pt-title="You must be signed in to chat" ' : 'data-pt-title="Request Chat"'; ?>  data-pt-gravity="top" data-pt-animate="jello" data-pt-scheme="black" data-pt-size="small" id="chat-request-<?php echo $index33; ?>" data-requested-user-id="<?php echo $user_online['user_id']; ?>"><nobr> <?php echo $request_status; ?></nobr></span> */ ?>
                                            </div>
                                        </div> <span class="accent">A <?php echo strtolower($User->user_i_am($User->user_info('i_am_a',$user_online['user_id']))); ?> <!--from St. Louis, MO--> concerned about <?php echo $User->him_or_her($user_online['user_id']); ?> <?php echo $User->user_concerned_about($User->user_info('concerned_about',$user_online['user_id'])); ?></span>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					<?php if($index33 >= 3 && $index33 == count($live_users) - 1 ) : ?>
                        </div>
					<?php endif; ?>

					<?php /** show See more link */  ?>
					<?php if($index33 >= 3 && $index33 == count($live_users) - 1) : ?>
                        <div onClick="showMoreOnlineUsers();" class="simple-heading see-more collapsed" data-toggle="collapse"  data-target="#show-more-live-users">
                            <span class="text1">See More</span>
                            <span class="text2">See Less</span>
                        </div>
					<?php endif; ?>
				<?php endforeach; ?>

            </div>
        </div>
    </section>
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
<?php endif; ?>