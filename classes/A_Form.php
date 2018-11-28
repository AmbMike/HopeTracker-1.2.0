<?php

/**
 * File For: HopeTracker.com
 * File Name: A_Form.php.
 * Author: Mike Giammattei
 * Created On: 5/17/2017, 9:30 AM
 */

include_once(CLASSES.'Admin.php'); // Admin Class

class A_Form extends Database {
    protected $db,$Session,$From,$Admin,$User;

    function __construct(){
        $this->db = new Database();
        $this->Session = new Sessions();
        $this->From = new Forms();
        $this->Admin = new Admin();
        $this->User = new User();
    }

    public function admin_sign_in($data){
        $data_out = array();

        if($this->From->check_email($data['email']) === 1){
            $sql = $this->db->prepare("SELECT * FROM `user_list` WHERE `email` = ? AND `password` = md5(?)");
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $sql->execute(array(strtolower($data['email']), $data['password']));
            $data_out = $sql->fetch();

            if($sql->rowCount() > 0) {
                $this->Session->set('logged_in',1);
                $this->Session->set('user-id',$data_out['id']);
                $this->Session->set('user-fname',$data_out['fname']);
                $this->Session->set('user-username',$data_out['username']);

                /* Login in user to database */
                $this->User->log_user_online($data_out['id']);

                if($this->Admin->user_role($data_out['id']) == 1 || $this->Admin->user_role($data_out['id']) == 2){
                    $ajax_out['result'] = 'granted';
                    $this->Session->set('Admin Logged',1);

                }else{
                    $ajax_out['result'] = 'not admin';
                }
                echo json_encode($ajax_out);
            }else{
                $ajax_out['result'] = 'error';
                $ajax_out['fields']['password'] = 'The password is incorrect';
                echo json_encode($ajax_out);
            }
        }else{
            $ajax_out['result'] = 'error';
            $ajax_out['fields']['email'] = 'The email provided does not exist';
            echo json_encode($ajax_out);
        }
    }
}