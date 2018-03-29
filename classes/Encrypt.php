<?php

/**
 * File For: HopeTracker.com
 * File Name: Encrypt.php.
 * Author: Mike Giammattei
 * Created On: 4/7/2017, 9:51 AM
 */
class Encrypt{

    public function hash($input){
        return crypt($input);
    }
    public function validate($password, $hash){

        return crypt($password, $hash)==$hash;
    }

    public function mask_get_var($data){
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');

    }
    public function un_mask_get_var($data){
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }
}