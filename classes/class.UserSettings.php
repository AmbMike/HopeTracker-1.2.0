<?php

error_reporting(E_ALL);

/**
 * untitledModel - class.UserSettings.php
 *
 * $Id$
 *
 * This file is part of untitledModel.
 *
 * Automatically generated on 30.04.2018, 21:41:30 with ArgoUML PHP module 
 * (last revised $Date: 2010-01-12 20:14:42 +0100 (Tue, 12 Jan 2010) $)
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-2--137fbda7:1631728b918:-8000:0000000000001112-includes begin
require_once( CLASSES . 'Database.php' );
require_once( CLASSES . 'User.php' );
require_once( CLASSES . 'General.php' );
require_once( CLASSES . 'Sessions.php' );
error_reporting( 0 );

// section -64--88-0-2--137fbda7:1631728b918:-8000:0000000000001112-includes end

/* user defined constants */
// section -64--88-0-2--137fbda7:1631728b918:-8000:0000000000001112-constants begin
// section -64--88-0-2--137fbda7:1631728b918:-8000:0000000000001112-constants end

/**
 * Short description of class UserSettings
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class UserSettings
{
    // --- ASSOCIATIONS ---
    // generateAssociationEnd :     // generateAssociationEnd : 

    // --- ATTRIBUTES ---

    /**
     * Short description of attribute user_id
     *
     * @access public
     * @var Integer
     */
    public $user_id = null;

    /**
     * Short description of attribute Database
     *
     * @access public
     * @var object
     */
    public $Database = null;

    /**
     * Short description of attribute Sessions
     *
     * @access public
     * @var object
     */
    public $Sessions = null;

    /**
     * Short description of attribute General
     *
     * @access public
     * @var object
     */
    public $General = null;

    /**
     * Short description of attribute User
     *
     * @access public
     * @var object
     */
    public $User = null;

    // --- OPERATIONS ---

    /**
     * Short description of method __construct
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return mixed
     */
    public function __construct()
    {
        // section -64--88-0-2--137fbda7:1631728b918:-8000:000000000000111F begin
	    $this->Sessions = new Sessions();

	    if($this->Sessions->get('logged_in') == 1){
		    $this->user_id = $this->Sessions->get( 'user-id' );
		    $this->General = new General();
		    $this->User = new User();
	    }else{
	    	die('Nice Try!');
	    }
        // section -64--88-0-2--137fbda7:1631728b918:-8000:000000000000111F end
    }

    /**
     * Delete the users account by removing the user from the user-list and
     * their user data into the deleted-user-list. Updateting all of the user's
     * and likes to show as "Formuer User"
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return mixed
     */
    public function deleteUsersAccount()
    {
        // section -64--88-0-2--137fbda7:1631728b918:-8000:0000000000001121 begin
        // section -64--88-0-2--137fbda7:1631728b918:-8000:0000000000001121 end
    }

} /* end of class UserSettings */

?>