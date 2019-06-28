<?php

/**
 * File For: HopeTracker.com
 * File Name: General.php.
 * Author: Mike Giammattei
 * Created On: 3/22/2017, 2:14 PM
 */

include_once($_SERVER['DOCUMENT_ROOT'] . '/hopetracker/config/constants.php');

class General extends Sessions{
    public function url_safe_string($string){

        $returnValue =  preg_replace('/^-+|-+$/', '', strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $string)));
	    //$returnValue = preg_replace( '/\/', '-', $returnValue );
	    return $returnValue;
    }
    function sanitize_output($buffer) {

        $search = array(
            '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
            '/[^\S ]+\</s',     // strip whitespaces before tags, except space
            '/(\s)+/s',         // shorten multiple whitespace sequences
            '/<!--(.|\s)*?-->/' // Remove HTML comments
        );

        $replace = array(
            '>',
            '<',
            '\\1',
            ''
        );

        $buffer = preg_replace($search, $replace, $buffer);

        return $buffer;
    }
    public static function random_string(){
        $token = rand(1000,1000000);
        return uniqid($token);
    }
    public function move_file($old_path,$new_path){
            $OLD_PATH = explode('/',$old_path);
            $NEW_PATH = explode('/',$new_path);


            if (!is_dir(ABSOLUTE_PATH  .$NEW_PATH[0])) {
                mkdir(ABSOLUTE_PATH  .$NEW_PATH[0]);
            }
            if (!is_dir(ABSOLUTE_PATH  .$NEW_PATH[0] . '/'.$NEW_PATH[1])) {
                mkdir(ABSOLUTE_PATH  .$NEW_PATH[0].'/'.$NEW_PATH[1]);
            }

            $dest = ABSOLUTE_PATH  . $NEW_PATH[0].'/'.$NEW_PATH[1].'/profile.jpg';
            $source = $_SERVER['DOCUMENT_ROOT'] . '/' . $old_path;

	    if (!copy($source, $dest)) {
	    	$date = date("F j, Y, g:i a", time());
		    Debug::to_file( "failed to copy $source...\n failed to new $dest... $date \n ",'settings-img-err.php');
	    }
            unlink($source);
    }
    public function delete_files(){
        $sessions = new Sessions();
        if(!empty($sessions->get('session_array')) && count($sessions->get('session_array')) > 0){
            $count =  count($sessions->get('session_array'));
            $count = $count -  1;
            foreach ( $sessions->get('session_array') as $index => $item) {
                if($index != $count){
                    unlink(ABSOLUTE_PATHIVE_PATH  .$item);
                }
            }
           $sessions->delete('session_array');

        }
    }
    public  function set_time_check($email){
        $db = new Database();
        $now = time();

        $sql = $db->prepare("UPDATE `user_list` SET time_check = ? WHERE `email` = ?");
        $sql->execute(array($now,$email));

        return 0;
    }
    public  function time_check($email){
        $db = new Database();

        $sql = $db->prepare("SELECT `time_check` FROM  `user_list` WHERE email = ?");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($email));

        $data = $sql->fetch();

        $time = $data['time_check'];

        $curtime = time();

        if(($curtime-$time) > 300) {
            return 0;
        }else{
            return 1;
        }

    }
    function getUserIP(){
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }

        return $ip;
    }
    public function proper_parse_str($str) {
        # result array
        $arr = array();

        # split on outer delimiter
        $pairs = explode('&', $str);

        # loop through each pair
        foreach ($pairs as $i) {
            # split into name and value
            list($name,$value) = explode('=', $i, 2);

            # if name already exists
            if( isset($arr[$name]) ) {
                # stick multiple values into an array
                if( is_array($arr[$name]) ) {
                    $arr[$name][] = $value;
                }
                else {
                    $arr[$name] = array($arr[$name], $value);
                }
            }
            # otherwise, simply stick it in a scalar
            else {
                $arr[$name] = $value;
            }
        }

        # return result array
        return $arr;
    }
    public function uppercase_to_lowercase_rename($directory){
        $files = scandir($directory);
        foreach($files as $key=>$name){
            $oldName = $name;
            $newName = strtolower($name);
            rename("$directory/$oldName","$directory/$newName");
            sleep(1);
        }

    }
    public function file_name_to_string($fileName){

        $returnValue = '';

        $pattern = '/(jpg|JPG)/';
        $returnValue = preg_replace($pattern, ' ', $fileName);

        $pattern = '/[\.\-\_]/';
        $returnValue = preg_replace($pattern, ' ', $returnValue);

        return $returnValue;
    }
    function trim_text($input, $length, $ellipses = true, $strip_html = true) {
        //strip tags, if desired
        if ($strip_html) {
            $input = strip_tags($input);
        }

        //no need to trim, already shorter than trim length
        if (strlen($input) <= $length) {
            return $input;
        }

        //find last space within length
        $last_space = strrpos(substr($input, 0, $length), ' ');
        $trimmed_text = substr($input, 0, $last_space);

        //add ellipses (...)
        if ($ellipses) {
            $trimmed_text .= '...';
        }

        return $trimmed_text;
    }
    public function day_of_week($date)
    {


//Convert the date string into a unix timestamp.
        $unixTimestamp = strtotime($date);

//Get the day of the week using PHP's date function.
        $dayOfWeek = date("l", $unixTimestamp);

//Print out the day that our date fell on.
        echo $date . ' fell on a ' . $dayOfWeek;
    }
	public function split_name($name) {
		$name = trim($name);
		$last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
		$first_name = trim( preg_replace('#'.$last_name.'#', '', $name ) );
		return array($first_name, $last_name);
	}
	public function array_flatten($array) {
		if (!is_array($array)) {
			return FALSE;
		}
		$result = array();
		foreach ($array as $key => $value) {
			if (is_array($value)) {
				$result = array_merge($result,$this->array_flatten($value));
			}
			else {
				$result[$key] = $value;
			}
		}
		return $result;
	}

    function word_limiter($s, $limit=3,$appendValue = false) {
        $returnValue = preg_replace('/((\w+\W*){'.($limit-1).'}(\w+))(.*)/', '${1}', $s);

        if($appendValue){
            $returnValue .= $returnValue . $appendValue;
        }
        return $returnValue;
    }
}