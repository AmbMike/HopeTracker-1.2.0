<?php

error_reporting(E_ALL);

/**
 * Handles the users general global data.
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-2-3801fad4:15f2a911f28:-8000:0000000000000BB0-includes begin
error_reporting(0);
include_once(CLASSES . 'Database.php');
include_once(CLASSES . 'Sessions.php');
// section -64--88-0-2-3801fad4:15f2a911f28:-8000:0000000000000BB0-includes end

/* user defined constants */
// section -64--88-0-2-3801fad4:15f2a911f28:-8000:0000000000000BB0-constants begin
// section -64--88-0-2-3801fad4:15f2a911f28:-8000:0000000000000BB0-constants end

/**
 * Handles the users general global data.
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class GlobalUserData
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * Short description of attribute Database
     *
     * @access private
     * @var array
     */
    private $Database = array();

    /**
     * Short description of attribute Sessions
     *
     * @access private
     * @var array
     */
    private $Sessions = array();

    // --- OPERATIONS ---

    /**
     * Contruct
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return mixed
     */
    public function __construct()
    {
        // section -64--88-0-2-3801fad4:15f2a911f28:-8000:0000000000000BBB begin
        $this->Sessions = new Sessions();
        // section -64--88-0-2-3801fad4:15f2a911f28:-8000:0000000000000BBB end
    }

    /**
     * Check if the user has just started a new session on the app.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return mixed
     */
    public function checkSession()
    {
        // section -64--88-0-2-3801fad4:15f2a911f28:-8000:0000000000000BB4 begin
       
        // section -64--88-0-2-3801fad4:15f2a911f28:-8000:0000000000000BB4 end
    }

} /* end of class GlobalUserData */

?>