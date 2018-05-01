<?php

error_reporting(E_ALL);

/**
 * untitledModel - class.ReinstateUser.php
 *
 * $Id$
 *
 * This file is part of untitledModel.
 *
 * Automatically generated on 30.04.2018, 21:37:45 with ArgoUML PHP module 
 * (last revised $Date: 2010-01-12 20:14:42 +0100 (Tue, 12 Jan 2010) $)
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/**
 * include UserSettings
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
require_once('class.UserSettings.php');

/* user defined includes */
// section -64--88-0-2--137fbda7:1631728b918:-8000:000000000000114E-includes begin
// section -64--88-0-2--137fbda7:1631728b918:-8000:000000000000114E-includes end

/* user defined constants */
// section -64--88-0-2--137fbda7:1631728b918:-8000:000000000000114E-constants begin
// section -64--88-0-2--137fbda7:1631728b918:-8000:000000000000114E-constants end

/**
 * Short description of class ReinstateUser
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class ReinstateUser
    extends UserSettings
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * Short description of attribute user_id
     *
     * @access public
     * @var Integer
     */
    public $user_id = null;

    /**
     * Short description of attribute reinstate_user_id
     *
     * @access public
     * @var Integer
     */
    public $reinstate_user_id = null;

    // --- OPERATIONS ---

    /**
     * Short description of method __construct
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  reinstate_user_id
     * @return mixed
     */
    public function __construct($reinstate_user_id)
    {
        // section -64--88-0-2--137fbda7:1631728b918:-8000:0000000000001156 begin
	    $this->reinstate_user_id = $reinstate_user_id;
	    $this->reinstate();
        // section -64--88-0-2--137fbda7:1631728b918:-8000:0000000000001156 end
    }

    /**
     * Reinstate a delete users.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return Boolean
     */
    public function reinstate()
    {
        $returnValue = null;

        // section -64--88-0-2--137fbda7:1631728b918:-8000:0000000000001153 begin
	    $this->Database  = new Database();

	    $sql = $this->Database->prepare("SELECT * FROM deleted_user_list WHERE user_id = ?");
	    $sql->setFetchMode( PDO::FETCH_ASSOC );
	    $sql->execute(array($this->reinstate_user_id));

	    $reinstate_user_data = $sql->fetchAll();
	    $reinstate_user_data = $reinstate_user_data[0];


	    if($sql->rowCount() > 0){
		    unset( $sql );

	    }
        // section -64--88-0-2--137fbda7:1631728b918:-8000:0000000000001153 end

        return $returnValue;
    }

} /* end of class ReinstateUser */

?>