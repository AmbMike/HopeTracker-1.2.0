<?php

error_reporting(E_ALL);

/**
 * untitledModel - class.InsuranceForm.php
 *
 * $Id$
 *
 * This file is part of untitledModel.
 *
 * Automatically generated on 19.02.2018, 08:46:35 with ArgoUML PHP module 
 * (last revised $Date: 2010-01-12 20:14:42 +0100 (Tue, 12 Jan 2010) $)
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-2-60f6d02c:160092e8bd9:-8000:0000000000000CED-includes begin
error_reporting( 0 );
require_once(CLASSES . 'Database.php');
require_once(CLASSES . 'General.php');
require_once(CLASSES . 'Sessions.php');

// section -64--88-0-2-60f6d02c:160092e8bd9:-8000:0000000000000CED-includes end

/* user defined constants */
// section -64--88-0-2-60f6d02c:160092e8bd9:-8000:0000000000000CED-constants begin
// section -64--88-0-2-60f6d02c:160092e8bd9:-8000:0000000000000CED-constants end

/**
 * Short description of class InsuranceForm
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class InsuranceForm
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * The user's id.
     *
     * @access private
     * @var string
     */
    private $userId = '';

    /**
     * Database object.
     *
     * @access private
     * @var array
     */
    private $Database = array();

    /**
     * Genral Class Object.
     *
     * @access private
     * @var array
     */
    private $General = array();

    /**
     * Session Object.
     *
     * @access private
     * @var array
     */
    private $Session = array();

    // --- OPERATIONS ---

    /**
     * Construct the class.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return mixed
     */
    public function __construct()
    {
        // section -64--88-0-2-60f6d02c:160092e8bd9:-8000:0000000000000CFE begin
	    $this->Session = new Sessions();
	    $this->General = new General();
	    $this->userId = $this->Session->get('user-id');

        // section -64--88-0-2-60f6d02c:160092e8bd9:-8000:0000000000000CFE end
    }

    /**
     * Store the user input data to the database.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  data
     * @return array
     */
    public function setFormData($data)
    {
        $returnValue = array();

        // section -64--88-0-2-60f6d02c:160092e8bd9:-8000:0000000000000CF4 begin
	    $this->Database = new Database();

	    $formData = array();
	    parse_str($data, $formData);

	    $sql = $this->Database->prepare("INSERT INTO insurance_form (user_id, phone, lovedOneName, lovedOneDOB, lovedOneZip, lovedOneInsurance, lovedOneInsuranceId, policyHolderName, drugOfChoice, insert_time, submitted_url, ip) VALUES(?,?,?,?,?,?,?,?,?,?,?,?) ");
	    $sql->execute( array(
	    	$this->userId,
		    $formData['phone'],
		    $formData['lovedOneName'],
		    $formData['lovedOneDOB'],
		    $formData['lovedOneZip'],
		    $formData['lovedOneInsurance'],
		    $formData['lovedOneInsuranceId'],
		    $formData['policyHolderName'],
		    $formData['drugOfChoice'],
		    time(),
		    $formData['submitted_url'],
		    $this->General->getUserIP()
	    ));

	    if($sql->rowCount() > 0){
		    $returnValue['status'] = 'Success';
	    }else{
		    $returnValue['status'] =  $this->Database->errorInfo();
	    }

	    /** Send json back via ajax */
	    echo json_encode($returnValue);

        // section -64--88-0-2-60f6d02c:160092e8bd9:-8000:0000000000000CF4 end

        return (array) $returnValue;
    }

    /**
     * Get the form data that has not been sent.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return array
     */
    public function getUnsentData()
    {
        $returnValue = array();

        // section -64--88-0-19-71c088a2:161ae4b3d84:-8000:0000000000001042 begin
	    $this->Database = new Database();
	    $sql = $this->Database->prepare("SELECT * FROM insurance_form WHERE sent = 0");
	    $sql->setFetchMode( PDO::FETCH_ASSOC );
	    $sql->execute();

	    $returnValue = $sql->fetchAll();

	    // section -64--88-0-19-71c088a2:161ae4b3d84:-8000:0000000000001042 end

        return (array) $returnValue;
    }

    /**
     * Set the provided id data as set.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  id
     * @return Boolean
     */
    public function setAsSent($id)
    {
        $returnValue = null;

        // section -64--88-0-19-71c088a2:161ae4b3d84:-8000:0000000000001044 begin
	    $this->Database = new Database();
	    $sql = $this->Database->prepare("UPDATE insurance_form SET sent = 1 WHERE id = ?");
	    $sql->execute(array($id));

	    if($sql->rowCount() > 0){
		    $returnValue = true;
	    }


	    // section -64--88-0-19-71c088a2:161ae4b3d84:-8000:0000000000001044 end

        return $returnValue;
    }

} /* end of class InsuranceForm */

?>