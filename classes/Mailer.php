<?php

/**
 * File For: HopeTracker.com
 * File Name: Mailer.php.
 * Author: Mike Giammattei
 * Created On: 4/6/2017, 4:11 PM
 */
class Mailer{
    protected  $mailer;
    public function __construct($mailer){
        $this->mailer = $mailer;
    }
    public function send($template, $data, $callback){
        $message = new Message($this->mailer);

        extract($data);
        ob_start();
        require $template;
        $template = ob_get_clean();
       //ob_end_clean();

        $message->body($template);

        call_user_func($callback,$message);

        $this->mailer->send();
    }
}