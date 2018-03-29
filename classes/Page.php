<?php
/**
 * File For: HopeTracker.com
 * File Name: Page.php.
 * Author: Mike Giammattei
 * Created On: 3/10/2017, 12:42 PM
 */

namespace Page_Attr {
include_once(CLASSES .'Sessions.php');
include_once(CLASSES .'Database.php');
    class Page {

        public function if_check($value,$else_string = false){
            if(isset($value)){
                return $value;
            }else{
                return '';
            }
        }
        public function header($array){
            $URL = new \URL();
            $Sessions = new \Sessions();

            $session = new \Sessions();
            $page_title = ($array['Title']) ? : '';
            $page_description = ($array['Description']) ? : '';
            $show_nav = ($array['Show Nav']) ? : '';
            $show_header = ($array['Show Header']) ? : '';
            $active_link = ($array['Active Link']);
            $canonical_url = ($array['Canonical URL']) ? : '';
            $no_index = ($array['No Index']);
            $custom_stylesheet = ($array['Custom Stylesheet']) ? : '';
            $no_min_height = ($array['No Min Height']) ? : '';
            $no_footer = ($array['No Footer']) ? 'Yes' : 'No';
            $og_img = ($array['OG Image']) ? : '';
            $og_url = ($array['OG URL']) ? : '';
            $og_title = ($array['OG Title']) ? : '';

            include_once(VIEWS . 'head.php');
            include_once(VIEWS . 'header.php');


        }

    }
    class Format{
        static public function phone($data){
            if(preg_match( '/^(\d{3})(\d{3})(\d{4})$/', $data,  $matches )){
                $result = '('.$matches[1] . ') ' .$matches[2] . '-' . $matches[3];
                return $result;
            }
            return  'testings';
        }
    }
    class Checks extends \Sessions{

        public function is_a_user(){
            $db = new \Database();

            $username_value = $_GET['user_id'];

            if(isset($username_value)){
                $sql = $db->prepare("SELECT id FROM `user_list` WHERE `id` = ?");
                $sql->execute(array($username_value));
                if($sql->rowCount() > 0){
                    return true;
                }else{
                    return false;
                }
            }
        }

    }
}

