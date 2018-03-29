<?php

error_reporting(E_ALL);

/**
 * Logs the each page the user visits.
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-13--73185eb3:15f93400dc6:-8000:0000000000000C92-includes begin
error_reporting( 0 );
include_once( CLASSES . 'Database.php' );
include_once( CLASSES . 'Sessions.php' );
include_once( CLASSES . 'General.php' );
// section -64--88-0-13--73185eb3:15f93400dc6:-8000:0000000000000C92-includes end

/* user defined constants */
// section -64--88-0-13--73185eb3:15f93400dc6:-8000:0000000000000C92-constants begin
// section -64--88-0-13--73185eb3:15f93400dc6:-8000:0000000000000C92-constants end

/**
 * Logs the each page the user visits.
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class PageLogger
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * Short description of attribute userId
     *
     * @access private
     * @var Integer
     */
    private $userId = null;

    /**
     * Short description of attribute pageUrl
     *
     * @access private
     * @var String
     */
    private $pageUrl = null;

    /**
     * Short description of attribute Database
     *
     * @access private
     * @var Array
     */
    private $Database = null;

    /**
     * Short description of attribute Session
     *
     * @access private
     * @var Integer
     */
    private $Session = null;

    /**
     * Short description of attribute page
     *
     * @access public
     * @var String
     */
    public $page = null;

    // --- OPERATIONS ---

    /**
     * Short description of method __construct
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  page
     * @return mixed
     */
    public function __construct($page)
    {
        // section -64--88-0-13--73185eb3:15f93400dc6:-8000:0000000000000C9F begin
	    $this->Session = new Sessions();
	    $this->page = $page;

	    if($this->Session->get('logged_in') == 1){
		    $this->userId = $this->Session->get( 'user-id' );

	    	$this->setPageAsLogged();
	    }
        // section -64--88-0-13--73185eb3:15f93400dc6:-8000:0000000000000C9F end
    }

    /**
     * Sets the log  of page with the users id.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return mixed
     */
    public function setPageAsLogged()
    {
        // section -64--88-0-13--73185eb3:15f93400dc6:-8000:0000000000000CA1 begin
	    $this->Database = new Database();
	    $General = new General();
	    $sql = $this->Database->prepare("INSERT INTO page_logger (user_id, user_ip, page) VALUES(?,?,?)");
	    $sql->execute(array(
	    	$this->userId,
		    $General->getUserIP(),
		    $this->page
	    ));


	    switch ($this->page):
		    case '/protected/course/' :
			    include_once( CLASSES . 'Courses.php' );
			    $Courses = new Courses();

			    if($this->Session->check('viewed_course') == false){
				    $Courses->viewed_course_page($this->userId,$this->page);
			    }
	        break;
	    endswitch;

        // section -64--88-0-13--73185eb3:15f93400dc6:-8000:0000000000000CA1 end
    }

} /* end of class PageLogger */

?>