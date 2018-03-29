<?php

/**
 * File For: HopeTracker.com
 * File Name: Message.php.
 * Author: Mike Giammattei
 * Created On: 4/6/2017, 4:29 PM
 */
class Message{
    protected $mailer;

    public function __construct($mailer){
        $this->mailer = $mailer;
    }
    public function to($address){
        $this->mailer->addAddress($address);
    }
    public function subject($subject){
        $this->mailer->Subject = $subject;
    }
    public function body($body){
        $this->mailer->Body = $body;
    }
}