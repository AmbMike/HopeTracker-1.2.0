<?php

error_reporting(E_ALL);

/**
 * untitledModel - class.AskQuestionForum.php
 *
 * $Id$
 *
 * This file is part of untitledModel.
 *
 * Automatically generated on 20.02.2018, 17:41:40 with ArgoUML PHP module 
 * (last revised $Date: 2010-01-12 20:14:42 +0100 (Tue, 12 Jan 2010) $)
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-17--66a83ae2:1602c49e480:-8000:0000000000000D38-includes begin
error_reporting(0);
include_once(CLASSES .'Sessions.php');
include_once(CLASSES .'Database.php');
include_once(CLASSES .'General.php');
// section -64--88-0-17--66a83ae2:1602c49e480:-8000:0000000000000D38-includes end

/* user defined constants */
// section -64--88-0-17--66a83ae2:1602c49e480:-8000:0000000000000D38-constants begin
// section -64--88-0-17--66a83ae2:1602c49e480:-8000:0000000000000D38-constants end

/**
 * Short description of class AskQuestionForum
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class AskQuestionForum
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * User's Id
     *
     * @access private
     * @var Integer
     */
    private $userId = null;

    /**
     * Database Object.
     *
     * @access private
     * @var array
     */
    private $Database = array();

    /**
     * General Object.
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
        // section -64--88-0-17--66a83ae2:1602c49e480:-8000:0000000000000D45 begin
	    $this->Session = new Sessions();
	    $this->General = new General();

	    /** Run code if user is logged in.  */
	    if ( $this->Session->get( 'logged_in' ) == 1 ) {
		    $this->userId = $this->Session->get( 'user-id' );
	    }

        // section -64--88-0-17--66a83ae2:1602c49e480:-8000:0000000000000D45 end
    }

    /**
     * Store the form data to the database.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  data
     * @return array
     */
    public function storeFormData($data)
    {
        $returnValue = array();

        // section -64--88-0-17--66a83ae2:1602c49e480:-8000:0000000000000D4C begin
	    $this->Database = new Database();

	    /** @var  $post_type_id : set the post type id from the post_type table : represents "forum question"*/
	    $post_type_id = 3;

	    /** Default Question Approval - Set to 1 for auto approve and 0 for manual approve */
		$approval = 1;

	    if($this->Session->get('logged_in') == 1){
		    $sql =  $this->Database->prepare("INSERT INTO ask_question_forum (user_id, category, subcategory, question, description, ip, date_created,post_type,approved, CampaignMonitorError) VALUES (?,?,?,?,?,?,?,?,?, '')");
		    $sql->execute(array(
			    $this->userId,
			    $data['category'],
			    $data['subcategory'],
			    $data['question'],
			    $data['description'],
			    $this->General->getUserIP(),
			    time(),
			    $post_type_id,
			    $approval
		    ));

		    if($sql->rowCount() > 0){
			     $returnValue['status'] = 'Success';
		    }else{
			     $returnValue['status'] = $sql->errorInfo();
		    }
	    }else{
		     $returnValue['status'] = 'Not Logged In';
	    }

	    /** Return status via ajax. */
	    echo json_encode( $returnValue );

        // section -64--88-0-17--66a83ae2:1602c49e480:-8000:0000000000000D4C end

        return (array) $returnValue;
    }

    /**
     * Get list of post ids for post belonging to the logged in user.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return array
     */
    public function getPostIdOwnedByUser()
    {
        $returnValue = array();

        // section -64--88-0-19-342b32de:161b381bb64:-8000:0000000000001081 begin
	    $this->Database = new Database();
	    $sql = $this->Database->prepare("SELECT id FROM ask_question_forum WHERE user_id = ?");
	    $sql->setFetchMode( PDO::FETCH_ASSOC );
	    $sql->execute(array($this->userId));

	    /** Covert the array of ids into a list of ids.  */
	    $post_ids =  array_map('current', $sql->fetchAll());
	    //$post_ids = implode( ',', $post_ids);

	    $returnValue = $post_ids;

        // section -64--88-0-19-342b32de:161b381bb64:-8000:0000000000001081 end

        return (array) $returnValue;
    }

    /**
     * Get the subcategory name for the provided question id.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  questionId
     * @return String
     */
    public function getQuestionSubcategory($questionId)
    {
        $returnValue = null;

        // section -64--88-0-19-342b32de:161b381bb64:-8000:0000000000001084 begin
	    $this->Database = new Database();
	    $sql = $this->Database->prepare("SELECT subcategory FROM ask_question_forum WHERE id = ?");
	    $sql->setFetchMode( PDO::FETCH_ASSOC );
	    $sql->execute(array($questionId));

	    $returnValue = $sql->fetchColumn();
        // section -64--88-0-19-342b32de:161b381bb64:-8000:0000000000001084 end

        return $returnValue;
    }

} /* end of class AskQuestionForum */

?>