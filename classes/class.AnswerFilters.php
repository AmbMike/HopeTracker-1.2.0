<?php

error_reporting(E_ALL);

/**
 * untitledModel - class.AnswerFilters.php
 *
 * $Id$
 *
 * This file is part of untitledModel.
 *
 * Automatically generated on 26.12.2017, 17:55:27 with ArgoUML PHP module 
 * (last revised $Date: 2010-01-12 20:14:42 +0100 (Tue, 12 Jan 2010) $)
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/**
 * include ForumAnswers
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
require_once('class.ForumAnswers.php');

/* user defined includes */
// section -64--88-0-2-66d49434:160937b2759:-8000:0000000000000EC2-includes begin
error_reporting(0);
// section -64--88-0-2-66d49434:160937b2759:-8000:0000000000000EC2-includes end

/* user defined constants */
// section -64--88-0-2-66d49434:160937b2759:-8000:0000000000000EC2-constants begin
// section -64--88-0-2-66d49434:160937b2759:-8000:0000000000000EC2-constants end

/**
 * Short description of class AnswerFilters
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class AnswerFilters
    extends ForumAnswers
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * Short description of attribute postId
     *
     * @access public
     * @var Integer
     */
    public $postId = null;

    // --- OPERATIONS ---

    /**
     * Short description of method _construct
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return mixed
     */
    public function _construct()
    {
        // section -64--88-0-2-66d49434:160937b2759:-8000:0000000000000ECA begin
	    parent::__construct();
        // section -64--88-0-2-66d49434:160937b2759:-8000:0000000000000ECA end
    }

    /**
     * Gets all the question ids that the user has answered.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  postId
     * @return Array
     */
    public function getUserQuestionIds($postId = false)
    {
        $returnValue = null;

        // section -64--88-0-2-66d49434:160937b2759:-8000:0000000000000ED3 begin
	        $this->Database = new Database();

		    $sql = $this->Database->prepare("SELECT DISTINCT question_id FROM answers_forum WHERE user_id = ?");
		    $sql->setFetchMode( PDO::FETCH_COLUMN);
		    $sql->execute(array($this->userId));

	        $returnValue = $sql->fetchAll(PDO::FETCH_COLUMN, 0);

        // section -64--88-0-2-66d49434:160937b2759:-8000:0000000000000ED3 end

        return $returnValue;
    }

    /**
     * Gets all the answers categories the user has answered a question to.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  postId
     * @return array
     */
    public function getAnswersCategory($postId = false)
    {
        $returnValue = array();

        // section -64--88-0-2-66d49434:160937b2759:-8000:0000000000000ECD begin
	    $this->Database = new Database();

	    if ( $postId == false ) {
		    foreach($this->getUserQuestionIds() as $category){

			    $sql = $this->Database->prepare("SELECT DISTINCT category FROM ask_question_forum WHERE id = ?");
			    $sql->setFetchMode( PDO::FETCH_ASSOC );
			    $sql->execute(array($category));

			    $returnValue[] = $sql->fetchAll(PDO::FETCH_COLUMN,0);
		    }
	    }else{
		    $sql = $this->Database->prepare("SELECT DISTINCT category FROM ask_question_forum WHERE id = ?");
		    $sql->setFetchMode( PDO::FETCH_ASSOC );
		    $sql->execute(array($postId));

		    $returnValue = $sql->fetchAll();
	    }



	    /** Make a single array */
	    $returnValue = array_map('current', $returnValue );

	    /** Remove duplicate categories.  */
	    $returnValue = array_unique( $returnValue );

        // section -64--88-0-2-66d49434:160937b2759:-8000:0000000000000ECD end

        return (array) $returnValue;
    }

    /**
     * Get the subcategories the user's answers blong to.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  postId
     * @return array
     */
    public function getSubcategoriesOfUsersAnswers($postId = false)
    {
        $returnValue = array();

        // section -64--88-0-2-66d49434:160937b2759:-8000:0000000000000EDE begin
	    $this->Database = new Database();

	    if($postId == false):
		    $sql = $this->Database->prepare("SELECT DISTINCT subcategory FROM ask_question_forum WHERE user_id = ?");
		    $sql->setFetchMode( PDO::FETCH_ASSOC );
		    $sql->execute(array($this->userId));

		    else:
			    $sql = $this->Database->prepare("SELECT DISTINCT subcategory FROM ask_question_forum WHERE id = ?");
			    $sql->setFetchMode( PDO::FETCH_ASSOC );
			    $sql->execute(array($postId));
	     endif;


	    $returnValue = $sql->fetchAll(PDO::FETCH_COLUMN, 0);
        // section -64--88-0-2-66d49434:160937b2759:-8000:0000000000000EDE end

        return (array) $returnValue;
    }

} /* end of class AnswerFilters */

?>