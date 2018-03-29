<?php

error_reporting(E_ALL);

/**
 * untitledModel - class.ActivitySessionSkipped.php
 *
 * $Id$
 *
 * This file is part of untitledModel.
 *
 * Automatically generated on 12.02.2018, 18:29:57 with ArgoUML PHP module 
 * (last revised $Date: 2010-01-12 20:14:42 +0100 (Tue, 12 Jan 2010) $)
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-19-62acb0f1:1618a8e2f28:-8000:000000000000102D-includes begin
error_reporting( 0 );
require_once( CLASSES . 'Database.php' );
// section -64--88-0-19-62acb0f1:1618a8e2f28:-8000:000000000000102D-includes end

/* user defined constants */
// section -64--88-0-19-62acb0f1:1618a8e2f28:-8000:000000000000102D-constants begin
// section -64--88-0-19-62acb0f1:1618a8e2f28:-8000:000000000000102D-constants end

/**
 * Short description of class ActivitySessionSkipped
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class ActivitySessionSkipped
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * Short description of attribute Database
     *
     * @access private
     * @var class
     */
    private $Database = null;

    /**
     * Short description of attribute userId
     *
     * @access public
     * @var Integer
     */
    public $userId = null;

    /**
     * Short description of attribute General
     *
     * @access public
     * @var class
     */
    public $General = null;

    /**
     * Short description of attribute Sessions
     *
     * @access public
     * @var class
     */
    public $Sessions = null;

    // --- OPERATIONS ---

    /**
     * Short description of method __construct
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return Boolean
     */
    public function __construct()
    {
        $returnValue = null;

        // section -64--88-0-19-62acb0f1:1618a8e2f28:-8000:0000000000001035 begin
	    $this->Sessions = new Sessions();
	    $this->General = new General();

	    if($this->Sessions->get('logged_in') == 1){
		    $this->userId = $this->Sessions->get( 'user-id' );
	    }else{
		    $this->userId = 0;
	    }
        // section -64--88-0-19-62acb0f1:1618a8e2f28:-8000:0000000000001035 end

        return $returnValue;
    }

    /**
     * Add the session to the skipped  table.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  sessionNumber
     * @return Boolean
     */
    public function skipSession($sessionNumber)
    {
        $returnValue = null;

        // section -64--88-0-19-62acb0f1:1618a8e2f28:-8000:0000000000001038 begin
	    $this->Database = new Database();

	    /** Updated the session status */
	    $sql = $this->Database->prepare( "INSERT INTO activity_session_skipped (userId, skippedSession, dateSkipped, ip) VALUES(?,?,?,?)" );
	    $sql->execute(array($this->userId,$sessionNumber,time(),$this->General->getUserIP()));
        // section -64--88-0-19-62acb0f1:1618a8e2f28:-8000:0000000000001038 end

        return $returnValue;
    }

    /**
     * Checks if the session has been skipped.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  sessionNumber
     * @return Boolean
     */
    public function isSessionSkipped($sessionNumber)
    {
        $returnValue = null;

        // section -64--88-0-19-62acb0f1:1618a8e2f28:-8000:000000000000103B begin
	    $this->Database = new Database();

	    /** Updated the session status */
	    $sql = $this->Database->prepare( "SELECT id FROM activity_session_skipped WHERE userId = ? AND skippedSession = ?" );
	    $sql->execute(array($this->userId, $sessionNumber));

	    if($sql->rowCount() > 0){
		    $returnValue = true;
	    }
        // section -64--88-0-19-62acb0f1:1618a8e2f28:-8000:000000000000103B end

        return $returnValue;
    }

    /**
     * Un skip the provided session.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  sessionNumber
     * @return Boolean
     */
    public function unSkipSession($sessionNumber)
    {
        $returnValue = null;

        // section -64--88-0-19-62acb0f1:1618a8e2f28:-8000:000000000000103E begin
	    $sql = $this->Database->prepare( "DELETE FROM activity_session_skipped WHERE userId = ? AND skippedSession = ?" );
	    $sql->execute(array($this->userId, $sessionNumber));

	    if($sql->rowCount() > 0){
		    $returnValue = true;
	    }
        // section -64--88-0-19-62acb0f1:1618a8e2f28:-8000:000000000000103E end

        return $returnValue;
    }

    /**
     * Gets all the session numbers for the session the user has skipped.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return array
     */
    public function getAllSkippedSessions()
    {
        $returnValue = array();

        // section -64--88-0-19-62acb0f1:1618a8e2f28:-8000:0000000000001049 begin
	    $this->Database = new Database();

	    /** Updated the session status */
	    $sql = $this->Database->prepare( "SELECT skippedSession FROM activity_session_skipped WHERE userId = ?" );
	    $sql->setFetchMode( PDO::FETCH_ASSOC );
	    $sql->execute(array($this->userId));

	    $returnValue = $sql->fetchAll();
	    $returnValue = array_map( 'current', $returnValue );

        // section -64--88-0-19-62acb0f1:1618a8e2f28:-8000:0000000000001049 end

        return (array) $returnValue;
    }

    /**
     * Deletes the logged in user's skipped sessions.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return Boolean
     */
    public function deleteSkippedSessions()
    {
        $returnValue = null;

        // section -64--88-0-19-62acb0f1:1618a8e2f28:-8000:0000000000001055 begin

	    $this->Database = new Database();

	    $sql = $this->Database->prepare( "DELETE FROM activity_session_skipped WHERE userId = ? " );
	    $sql->execute(array($this->userId));

	    if($sql->rowCount() > 0){
		    $returnValue = true;
	    }
        // section -64--88-0-19-62acb0f1:1618a8e2f28:-8000:0000000000001055 end

        return $returnValue;
    }

} /* end of class ActivitySessionSkipped */

?>