<?php

/**
 * File For: HopeTracker.com
 * File Name: Chat.php.
 * Author: Mike Giammattei
 * Created On: 6/15/2017, 10:50 AM
 */
include_once(CLASSES . 'Email.php');

class Chat extends User {
    public function display_user($name_field){
       return $this->user_info($name_field);
    }
    public function show_live_users(){
       return $this->users_online();
    }
    public function delete_chat_request($request_id){
       $db = new Database();

       $sql = $db->prepare("DELETE FROM chat_request WHERE id = ?");
       $sql->execute(array($request_id));
    }
    public function involved_in_chat_request($user_id){
       $db = new Database();
       $id2 = $user_id;

       $sql = $db->prepare("SELECT id FROM `chat_request` WHERE user_id = ? OR requested_user_id = ?");
       $sql->execute(array(
               (int)$user_id,
               (int)$id2
           )
       );
       if($sql->rowCount() > 0){
           return true;
       }else {
           return false;
       }
    }
    public function  users_in_chatroom($user_id){
        $db = new Database();
        $Sessions = new Sessions();

        $sql = $db->prepare("select * from `chatrooms` where `chat_room_token` in (
          select `chat_room_token` from `chatrooms`
            WHERE `user_id` = ? OR `user_id` = ?
          group by `chat_room_token` having count(*) > 1
      )");

        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($user_id,$Sessions->get('user-id')));

        if($sql->rowCount() > 1){
            return true;
        }else{
            return false;
        }


    }
    public function chat_request_update($status, $user_id, $requested_user_id){
        $db = new Database();

        $sql = $db->prepare("UPDATE chat_request SET status = ? WHERE user_id = ? AND requested_user_id = ?");
        $sql->execute(array($status,$user_id,$requested_user_id));

    }
    public function chat_request_status($requested_user_id, $show_values = false){
        $db = new Database();
        $Session = new Sessions();

        if($this->busy_in_single_chat($requested_user_id) == 0){
            $sql = $db->prepare("SELECT status FROM chat_request ");
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $sql->execute();
            $data = $sql->fetchColumn();

            if($show_values == true){
                switch ($data) :
                    case '' :
                        return '<i class="fa fa-comment request-chat-i" aria-hidden="true"></i>';
                        break;
                    case 0 :
                        return "Awaiting Response";
                        break;
                    case 1 :
                        return "Accepted";
                        break;
                    case 2 :
                        return "Denied";
                        break;
                    case 3 :
                        return "Blocked";
                        break;
                    case 'Users Chatting' :
                        return 'Users Chatting';
                        break;
                endswitch;
            }
        }else{
            return "Busy";
        }

    }
    public function check_if_user_requested_chat($requested_id){
       $db = new Database();
       $Session = new Sessions();

       $sql = $db->prepare("SELECT id FROM chat_request WHERE requested_user_id = ? AND user_id = ?");
       $sql->execute(array(
               $requested_id,
               $Session->get('user-id')
           )
       );
       if($sql->rowCount() > 0){
           return true;
       }else{
           return false;
       }
    }
    public function chat_request_alert($return_type = false){
       $Session = new Sessions();
       $db = new Database();

       if($Session->get('logged_in') == 1){

           $sql = $db->prepare("SELECT * FROM chat_request WHERE requested_user_id = ?");
           $sql->setFetchMode(PDO::FETCH_ASSOC);
           $sql->execute(array(
                   $Session->get('user-id')
               )
           );

           if($return_type == false) :
                return $sql->fetchAll();
           else:
               echo json_encode($sql->fetchAll());
           endif;
       }
    }
    function present_chat_room_token($chat_room_token_value){
       $db = new Database();
       $sql = $db->prepare("SELECT id FROM chatrooms WHERE chat_room_token = ?");
       $sql->execute(array($chat_room_token_value));

       return $sql->rowCount();
    }
    public function record_user_chat_session($requested_user_id){
        $db = new Database();
        $Session = new Sessions();
        $General = new General();

        $sql = $db->prepare("INSERT INTO users_had_chat (user_id, ip,requested_user_id) VALUES (?,?,?)");
        $sql->execute(array(
            $Session->get('user-id'),
            $General->getUserIP(),
            $requested_user_id,
        ));
    }
    public function request_chat_action($data){
       $db = new Database();
       $Session = new Sessions();
       $General = new General();
       $count = 0;
       $chat_room_token = $General->random_string();

       /* Check Token for duplicates and retry if needed*/
       while($this->present_chat_room_token($chat_room_token) > 0) :
           $chat_room_token = $General->random_string();
           $count++;
       endwhile;

       switch ($data['btn_type']) :
           case 'Accept' :
               $sql = $db->prepare("INSERT INTO chatrooms (user_id, created_time, ip, chat_room_token,request_id) VALUES (?,?,?,?,?),(?,?,?,?,?)");
               $sql->execute(array(
                   $Session->get('user-id'),
                   time(),
                   $General->getUserIP(),
                   $chat_room_token,
                   $data['request_id'],
                   $data['request_users_id'],
                   time(),
                   $General->getUserIP(),
                   $chat_room_token,
                   $data['request_id']
               ));
               if($sql->rowCount() > 0){
                   $this->chat_request_update(1,$data['request_users_id'],$Session->get('user-id') );
                   $this->record_user_chat_session($data['request_users_id']);
                   echo 'Accepted';
               }else{
                   echo 'failed now';
               }



           break;
           case 'Deny' :echo 'Denied';
               $this->chat_request_update(2, $data['request_users_id'], $Session->get('user-id'));


           break;
           case 'Block' :
               $this->chat_request_update(3, $data['request_users_id'],$Session->get('user-id'));
               echo 'Blocked';
           break;
       endswitch;
    }
    public function get_chatroom(){
        $db = new Database();
        $Session = new Sessions();

       $sql = $db->prepare("SELECT * FROM chatrooms WHERE user_id = ?");
       $sql->setFetchMode(PDO::FETCH_ASSOC);
       $sql->execute(array($Session->get('user-id')));

       return $sql->fetchAll();
    }
    public function user_in_chatroom(){
       $db = new Database();
       $Session = new Sessions();

       $sql = $db->prepare("SELECT * FROM chatrooms WHERE user_id = ? ");
       $sql->setFetchMode(PDO::FETCH_ASSOC);
       $sql->execute(array(
           $Session->get('user-id')
       ));

       return $sql->fetchAll();
    }
    public function get_all_users_in_chatroom($chat_room_token){
       $db = new Database();

       $sql = $db->prepare("SELECT * FROM chatrooms WHERE chat_room_token = ? ");
       $sql->setFetchMode(PDO::FETCH_ASSOC);
       $sql->execute(array(
           $chat_room_token
       ));

       return $sql->fetchAll();
    }
    public function busy_in_single_chat($user_id){
       $db = new Database();

       $sql = $db->prepare("SELECT * FROM chatrooms WHERE user_id = ? ");
       $sql->setFetchMode(PDO::FETCH_ASSOC);
       $sql->execute(array(
           $user_id
       ));
       return $sql->rowCount();
    }
    public function build_user_chat_box(){
       if($this->user_in_chatroom() > 0){
           echo 'yes';
       }else{
           echo 'no';
       }
    }
    public function delete_chat_room($data){
       $db = new Database();

       $sql = $db->prepare("DELETE FROM chatrooms WHERE chat_room_token = ?  AND request_id = ?");
       $sql->execute(array(
           $data['chat_token'],
           $data['chat_requested_id']
       ));
       if($sql->rowCount() > 0){
           $this->delete_chat_request($data['chat_requested_id']);
           echo "Deleted";
       }else{
           echo "Failed";
       }
    }
    public function chat_button_status($request_status){
       $data_out = array();

       switch ($request_status):
           case 'Users Chatting' :
               $data_out['disabled'] = 'disabled';
               $data_out['status_class']  = 'gray';
               break;
           case 'Busy' :
               $data_out['disabled']  = 'disabled';
               $data_out['status_class'] = 'gray';
               break;
           case 'Blocked' :
               $data_out['disabled']  = 'disabled';
               $data_out['status_class'] = 'gray';
               break;
           case 'Denied' :
               $data_out['disabled']  = 'disabled';
               $data_out['status_class'] = 'gray';
               break;
           case 'Awaiting Response' :
               $data_out['disabled']  = 'disabled';
               $data_out['status_class'] = 'gray';
               break;
           case 'One Chat at a time' :
               $data_out['disabled']  = 'disabled';
               $data_out['status_class'] = 'gray';
               break;
           default :
               $data_out['disabled']  = '';
               $data_out['status_class'] = 'green';

       endswitch;

       return $data_out;
    }
    public function chat_request($requested_id){
        $db = new Database();
        $Session = new Sessions();
        $User = new parent();
        $General = new General();
        $data_out = array();

        /* Offline moderator condition */
        if($User->is_a_moderator($requested_id) == true && $User->is_user_still_logged_in($requested_id) == false){
            $data_out['status'] = 'Moderator Offline';
            $count = 0;
            $chat_room_token = $General->random_string();

            /* Check Token for duplicates and retry if needed*/
            while($this->present_chat_room_token($chat_room_token) > 0) :
                $chat_room_token = $General->random_string();
                $count++;
            endwhile;

            $sql = $db->prepare("INSERT INTO chatrooms (user_id, created_time,chat_room_token, ip,request_id) VALUES (?,?,?,?,?)");
            $sql->execute(array(
                $Session->get('user-id'),
                time(),
                $chat_room_token,
                $General->getUserIP(),
                $requested_id,
            ));
        }else{
            /* Do if user is not currently in another chat */
            if($this->involved_in_chat_request($requested_id) != true){

                $sql = $db->prepare("INSERT INTO chat_request (user_id, requested_user_id, request_time) VALUES(?,?,?)");
                $sql->execute(array(
                        $Session->get('user-id'),
                        $requested_id,
                        time()
                    )
                );
                if($sql->rowCount() > 0){
                    return 1;
                }else{
                    return 0;
                }
            }else{
                echo 'User is Busy';
            }
        }

        echo json_encode($data_out);
    }
    public function send_chat_email(){
        $Email = new Email();
        $Email->send_general_email('mjgseb@gmail.com','Testing the email','Mike','http://hopetracker.com');
    }
}