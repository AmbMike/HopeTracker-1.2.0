<?php

/**
 * File For: HopeTracker.com
 * File Name: URL.php.
 * Author: Mike Giammattei
 * Created On: 4/7/2017, 11:37 AM
 */
class URL extends Sessions {

    public function get_url_variable($var_name){
        $url = $_SERVER['REQUEST_URI'];
        $GET_vars= substr($url, strpos($url, "?") + 1);
        $GET_var = explode('&', $GET_vars);


        if(count($GET_var) > 1){
            $url_param = array();
            foreach ($GET_var as $item){
                $val = explode('=', $item);
                $url_param[] = array($val[0] => $val[1]);
            }
            $params = call_user_func_array('array_merge', $url_param);

            return $params[$var_name];
        }else{
            $val = explode('=', $GET_var[0]);
            $url_param = array($val[0] => $val[1]);

            return $url_param[$var_name];
        }
    }
    public static function restricted_url($p_url){
        $Sessions = new parent();
        if(isset($_GET['protected']) && $_GET['protected'] == true){
            if($Sessions->get('logged_in') == 0){
	            header( 'Location: /'.RELATIVE_PATH_NO_END_SLASH.'/home/' );
               return 'home';
            }else{
                return 'protected/' . $p_url;
            }
        }else{
           return $p_url;
        }
    }
    public static function isPage(){
	    switch ( $_GET['page_url'] ) {

	    	/** Process 404 for the "Forum Page" */
		    case 'family-of-drug-abuser' :
		    	if(isset($_GET['category'])){
				    include_once(CLASSES . 'class.ForumPageProcessing.php');
				    $urlParameters = array();

				    /** Check if any parameters are set in the URL */
				    if (isset($_GET['category'])){
				    	/** Set the category value */
					    $urlParameters[] = $_GET['category'];

					    /** Set the subcategory value if there is one in the parameter */
					    if(isset($_GET['subcategory'])){
						    $urlParameters[] = $_GET['subcategory'];
					    }

					    $ForumPageProcessing = new ForumPageProcessing($urlParameters);

					    if($ForumPageProcessing->isPage){
						    return $_GET['page_url'];
					    } else{
						    return 404;
					    }
				    }
			    }else{
				    /** If the category parameter was not set return page url */
				    return $_GET['page_url'];
			    }

	        break;
		    default : return $_GET['page_url'];
	    }
    }
    public function current_url(){
        $current_URL = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        return $current_URL;
    }
}