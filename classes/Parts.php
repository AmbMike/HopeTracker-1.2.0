<?php

/**
 * File For: HopeTracker.com
 * File Name: Parts.php.
 * Author: Mike Giammattei
 * Created On: 3/22/2017, 2:38 PM
 */
class Parts extends Sessions {

    public static function nav($controller, $active_link){
        if($controller !== 'No'){
            $user = new User();
            if($user->is_logged_in() == 1){
                $active_link = $active_link;
                return include_once(HEADERS .'logged-in.php');
            }else{
                return include_once(HEADERS .'logged-out.php');
            }
        }
    }
    public function widget_exists()
    {
        if (isset($_GET['widget_page'])) :
            if (!file_exists(WIDGETS . $_GET['page_url'] . '/' . $_GET['widget_page'] . '.php')) :
                return 'Not Found';
            endif;
        endif;
        return false;
    }
}