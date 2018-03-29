<?php

error_reporting(E_ALL);

/**
 * Link path to be displayed to the user when he or she is logged in.
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-13-19055709:15fc16a18f5:-8000:0000000000000CA9-includes begin
error_reporting( 0 );
include_once( CLASSES . 'Sessions.php' );
// section -64--88-0-13-19055709:15fc16a18f5:-8000:0000000000000CA9-includes end

/* user defined constants */
// section -64--88-0-13-19055709:15fc16a18f5:-8000:0000000000000CA9-constants begin
// section -64--88-0-13-19055709:15fc16a18f5:-8000:0000000000000CA9-constants end

/**
 * Link path to be displayed to the user when he or she is logged in.
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class SignUpBtn
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * Sessions Object
     *
     * @access private
     * @var Array
     */
    private $Sessions = null;

    /**
     * Text to be displayed to the user when he or she is logged out.
     *
     * @access public
     * @var string
     */
    public $btnOutText = '';

    /**
     * Action code for user according to logged in or not.
     *
     * @access public
     * @var string
     */
    public $btnActionHTML = '';

    // --- OPERATIONS ---

    /**
     * Construct the class
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  loggedInAction
     * @param  loggedInHTML
     * @param  loggedOutHTML
     * @param  array
     * @return mixed
     */
    public function __construct($loggedInAction, $loggedInHTML, $loggedOutHTML, $array = array())
    {
        // section -64--88-0-13-19055709:15fc16a18f5:-8000:0000000000000CAE begin
	    $this->Sessions = new Sessions();
	    $this->setStartedController($loggedInAction, $loggedInHTML, $loggedOutHTML, $array = array());
        // section -64--88-0-13-19055709:15fc16a18f5:-8000:0000000000000CAE end
    }

    /**
     * Sets the values for the sign up button to be avalible to the object.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  loggedInAction
     * @param  loggedInHTML
     * @param  loggedOutHTML
     * @param  array
     * @return mixed
     */
    public function setStartedController($loggedInAction, $loggedInHTML, $loggedOutHTML, $array)
    {
        // section -64--88-0-13-19055709:15fc16a18f5:-8000:0000000000000CB1 begin
	    if($this->Sessions->get('logged_in') == 1){

		    /** Set the actions for the button. */
		    $this->btnActionHTML = ' onclick="location.href=\'/'.RELATIVE_PATH_NO_END_SLASH.$loggedInAction.'\'"';
		    $this->btnOutText  = $loggedInHTML;
	    }else{
		    $this->btnActionHTML = 'data-btn="home-sign-in"';
		    $this->btnOutText  = $loggedOutHTML;
	    }
        // section -64--88-0-13-19055709:15fc16a18f5:-8000:0000000000000CB1 end
    }

    /**
     * Add Optional text to show on sign up button.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  optionText
     * @param  array
     * @return String
     */
    public function optionBtnText($optionText, $array = array())
    {
        $returnValue = null;

        // section -64--88-0-13-19055709:15fc16a18f5:-8000:0000000000000CD1 begin
	    if($this->Sessions->get('logged_in') == 1 && !isset($array['footer'])){
	    	$returnValue = $this->btnOutText;
	    }else{
	    	$returnValue = $optionText;
	    }
        // section -64--88-0-13-19055709:15fc16a18f5:-8000:0000000000000CD1 end

        return $returnValue;
    }

} /* end of class SignUpBtn */

?>