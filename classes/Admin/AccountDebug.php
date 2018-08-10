<?php
require_once(CLASSES .  'User.php');
require_once(CLASSES .  'Sessions.php');

class AccountDebug{
    public $accessUserId;
    public $User;
    public $Sessions;

    public function __construct($data){
      $this->accessUserId = $data['accessAccountUserId'];
      $this->User  = new User();
      $this->Sessions  = new Sessions();
      $this->process();
    }
    public function process(){

        $this->Sessions->set('logged_in',1);
        $this->Sessions->set('user-id',$this->accessUserId);
        $this->Sessions->set('user-fname',User::user_info('fname',  $this->accessUserId));
        $this->Sessions->set('user-username',User::user_info('username',  $this->accessUserId));
        $this->Sessions->set('debugPanels',1);

    }
}