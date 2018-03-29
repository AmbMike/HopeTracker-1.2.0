<?php

error_reporting(E_ALL);

/**
 * Id of the user who created the question.
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/**
 * Handles the forum questions.
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
require_once('class.ForumQuestions.php');

/* user defined includes */
// section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000EB8-includes begin
error_reporting(1);
// section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000EB8-includes end

/* user defined constants */
// section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000EB8-constants begin
// section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000EB8-constants end

/**
 * Id of the user who created the question.
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class SingleQuestion
    extends ForumQuestions
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * The question id.
     *
     * @access private
     * @var Integer
     */
    private $questionId = null;

    /**
     * The database object.
     *
     * @access private
     * @var object
     */
    private $Database = null;

    /**
     * Short description of attribute General
     *
     * @access private
     * @var array
     */
    private $General = array();

    /**
     * The session object.
     *
     * @access private
     * @var object
     */
    private $Session = null;

    /**
     * The user's id who owns the question.
     *
     * @access public
     * @var Integer
     */
    public $userId = null;

    /**
     * The question text.
     *
     * @access public
     * @var string
     */
    public $question = '';

    /**
     * The description text.
     *
     * @access public
     * @var string
     */
    public $description = '';

    /**
     * Date the user created the id
     *
     * @access public
     * @var integer
     */
    public $dateCreated = null;

    /**
     * Short description of attribute questionUsersId
     *
     * @access public
     * @var Integer
     */
    public $questionUsersId = null;

    /**
     * The category name the question is associated with.
     *
     * @access public
     * @var string
     */
    public $category = '';

    /**
     * The subcategory name the question is associated with.
     *
     * @access public
     * @var string
     */
    public $subcategory = '';

    /**
     * the post type id for the question.
     *
     * @access public
     * @var Integer
     */
    public $postType = null;

    /**
     * The id for the question.
     *
     * @access public
     * @var Integer
     */
    public $postId = null;

    // --- OPERATIONS ---

    /**
     * Construct the class by geting the question date from the question's id.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  questionId
     * @return mixed
     */
    public function __construct($questionId)
    {
        // section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000ED2 begin
	    parent::__construct();

	    /** Initialize the class variables.  */
	    $this->questionId = $questionId;
	    $this->Session = new Sessions();
	    $this->General = new General();

	    /** run the function that gets the question data */
	    $this->getQuestionData();

        // section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000ED2 end
    }

    /**
     * Gets the data for the question by the question id. This data populates
     * class's variables.
     *
     * @access private
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  approved
     * @return mixed
     */
    private function getQuestionData($approved = true)
    {
        // section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000ED6 begin
	    $this->Database = new Database();

	    if($approved == true){
		    $sql = $this->Database->prepare("SELECT * FROM ask_question_forum WHERE id = ? AND approved = 1");
	    }

	    $sql->setFetchMode( PDO::FETCH_ASSOC );
	    $sql->execute( array(
	    	$this->questionId
	    ) );
	    $questionData = $sql->fetchAll();

	    /** Set Class Variables */
	    $this->questionUsersId = $questionData[0]['user_id'];
	    $this->category = $questionData[0]['category'];
	    $this->subcategory = $questionData[0]['subcategory'];
	    $this->question = $questionData[0]['question'];
	    $this->description = $questionData[0]['description'];
	    $this->dateCreated = $questionData[0]['date_created'];
	    $this->postType = $questionData[0]['post_type'];
	    $this->postId = $questionData[0]['id'];
        // section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000ED6 end
    }

    /**
     * Gets the questions user id.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return Integer
     */
    public function getQuestionUserId()
    {
        $returnValue = null;

        // section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000F0B begin
	    $Database = new Database();

	    $sql = $Database->prepare("SELECT user_id FROM ask_question_forum WHERE id = ?");
	    $sql->execute(array(
		    $this->questionId
	    ));

	    $returnValue = $sql->fetchColumn();

        // section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000F0B end

        return $returnValue;
    }

} /* end of class SingleQuestion */
