<?php

error_reporting(E_ALL);

/**
 * User logged in status.
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-17--63030576:1601305416e:-8000:0000000000000D0B-includes begin
error_reporting( 0 );
require_once(CLASSES . 'Sessions.php');
require_once(CLASSES . 'Courses.php');
// section -64--88-0-17--63030576:1601305416e:-8000:0000000000000D0B-includes end

/* user defined constants */
// section -64--88-0-17--63030576:1601305416e:-8000:0000000000000D0B-constants begin
// section -64--88-0-17--63030576:1601305416e:-8000:0000000000000D0B-constants end

/**
 * User logged in status.
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class Redirects
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * Sesson Object
     *
     * @access private
     * @var array
     */
    private $Session = array();

    /**
     * Path of to the page the user is currently on.
     *
     * @access private
     * @var string
     */
    private $pagePath = '';

    /**
     * Logged in user's id.
     *
     * @access private
     * @var Integer
     */
    private $userId = null;

    /**
     * Short description of attribute loggedIn
     *
     * @access private
     * @var Integer
     */
    private $loggedIn = null;

    // --- OPERATIONS ---

    /**
     * Construct the class object.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  pagePath
     * @return mixed
     */
    public function __construct($pagePath)
    {
        // section -64--88-0-17--63030576:1601305416e:-8000:0000000000000D16 begin
	    $this->Session = new Sessions();
	    $this->pagePath = $pagePath;
	    $this->loggedIn = $this->Session->get( 'logged_in' );

	    /** If user is logged in run the methods.  */
	    if($this->loggedIn == 1){
		    $this->userId = $this->Session->get('user-id');

		    /** If on homepage.  */
		    $this->homepage();
	    }

        // section -64--88-0-17--63030576:1601305416e:-8000:0000000000000D16 end
    }

    /**
     * Redirect users from the homepage.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return String
     */
    public function homepage()
    {
        $returnValue = null;

        // section -64--88-0-17--63030576:1601305416e:-8000:0000000000000D1C begin
	    if($this->pagePath == 'home'){
	    	$Course = new Courses();

	    	/** @var  $total_course : total number of courses/activities the user has complete */
		    $total_course_complete = $Course->get_total_clicked_activities( $this->userId );

		    /** @var  $total_courses : total amount of overall courses/activities. */
		    $total_courses = $Course->get_total_courses();

		    if($total_course_complete <  $total_courses){
			    header( 'Location: /'.RELATIVE_PATH.'protected/course/' );
		    }else{
			    header( 'Location: /'.RELATIVE_PATH.'families-of-drug-addicts/' );
		    }


	    }

        // section -64--88-0-17--63030576:1601305416e:-8000:0000000000000D1C end

        return $returnValue;
    }

} /* end of class Redirects */

?>