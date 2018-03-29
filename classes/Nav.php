<?php

/**
 * File For: HopeTracker.com
 * File Name: nav.php.
 * Author: Mike Giammattei
 * Created On: 4/17/2017, 1:15 PM
 */
class Nav{
    public static function show_active($page_name, $link_name){
        if($page_name === $link_name){
            $value = '<div class="active"></div>';
            return $value;
        }
    }
}