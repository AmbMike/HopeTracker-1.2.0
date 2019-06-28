<?php

error_reporting(E_ALL);

/**
 * Handles the forum questions.
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-17--e38ad68:1602d4487e4:-8000:0000000000000D50-includes begin
error_reporting(0);
include_once(CLASSES .'Sessions.php');
include_once(CLASSES .'Database.php');
include_once(CLASSES .'General.php');
// section -64--88-0-17--e38ad68:1602d4487e4:-8000:0000000000000D50-includes end

/* user defined constants */
// section -64--88-0-17--e38ad68:1602d4487e4:-8000:0000000000000D50-constants begin
// section -64--88-0-17--e38ad68:1602d4487e4:-8000:0000000000000D50-constants end

/**
 * Handles the forum questions.
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class ForumQuestions
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

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
     * Sesson Object.
     *
     * @access private
     * @var array
     */
    private $Session = array();

    /**
     * User's Id.
     *
     * @access public
     * @var Integer
     */
    public $userId = null;

    /**
     * Total number of approved questions by all users.
     *
     * @access public
     * @var Integer
     */
    public $totalApprovedQuestions = null;

    /**
     * Total number of approved questions user id.
     *
     * @access public
     * @var Integer
     */
    public $totalUsersApprovedQuestions = null;

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
        // section -64--88-0-17--e38ad68:1602d4487e4:-8000:0000000000000D5E begin
		$this->Session = new Sessions();
		$this->General = new General();

		/** @var  $this->totalQuestions : total questions from all users.   */
		$this->totalApprovedQuestions = $this->totalApprovedQuestions();


		if($this->Session->get('logged_in') == 1){
			$this->userId = $this->Session->get( 'user-id' );
		}
        // section -64--88-0-17--e38ad68:1602d4487e4:-8000:0000000000000D5E end
    }

    /**
     * Gets the question that are associated with a subcategory
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  subcategory
     * @return array
     */
    public function getQuestionsBySubcategory($subcategory, $questionID = false)
    {
        $returnValue = array();

        // section -64--88-0-17--e38ad68:1602d4487e4:-8000:0000000000000D61 begin
		$this->Database = new Database();

		if(!$questionID){
            $sql = $this->Database->prepare("SELECT * FROM ask_question_forum WHERE subcategory = ? ORDER BY id DESC");
            $sql->setFetchMode( PDO::FETCH_ASSOC );
            $sql->execute(array($subcategory));
        }else{
            $sql = $this->Database->prepare("SELECT * FROM ask_question_forum WHERE subcategory = ? && id <> ? ORDER BY id DESC  ");
            $sql->setFetchMode( PDO::FETCH_ASSOC );
            $sql->execute(array($subcategory,$questionID));
        }


		$returnValue = $sql->fetchAll();


        // section -64--88-0-17--e38ad68:1602d4487e4:-8000:0000000000000D61 end

        return (array) $returnValue;
    }

    /**
     * Checks if question id belongs to a subcategory.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  questionId
     * @param  subcategory
     * @return Boolean
     */
    public function questionIdsForSubcategory($questionId, $subcategory)
    {
        $returnValue = null;

        // section -64--88-0-2--355fd3c7:16046affd99:-8000:0000000000000DB5 begin
	    $this->Database = new Database();

	    $sql = $this->Database->prepare("SELECT id FROM ask_question_forum WHERE id IN(" . $questionId. ") AND subcategory = ? ");
	    $sql->setFetchMode( PDO::FETCH_ASSOC );
	    $sql->execute(array($subcategory));

	    if($sql->rowCount() > 0){
		    $returnValue = true;
	    }else{
		    $returnValue = false;
	    }
        // section -64--88-0-2--355fd3c7:16046affd99:-8000:0000000000000DB5 end

        return $returnValue;
    }

    /**
     * Get the total number of approved questions either by user id or all
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  userId
     * @return Integer
     */
    public function totalApprovedQuestions($userId = false)
    {
        $returnValue = null;

        // section -64--88-0-17--e38ad68:1602d4487e4:-8000:0000000000000D82 begin
		$this->Database = new Database();

		if($userId != false):
			$sql = $this->Database->prepare("SELECT count(*) FROM ask_question_forum WHERE user_id = ? AND approved = 1");
			$sql->setFetchMode( PDO::FETCH_ASSOC );
			$sql->execute(array($userId));

		else:
			$sql = $this->Database->prepare("SELECT count(*) FROM ask_question_forum WHERE approved = 1");
			$sql->setFetchMode( PDO::FETCH_ASSOC );
			$sql->execute(array($userId));
		endif;

		$returnValue = $sql->fetchColumn();
        // section -64--88-0-17--e38ad68:1602d4487e4:-8000:0000000000000D82 end

        return $returnValue;
    }

    /**
     * Returns a list of question ids.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  subcategory
     * @return array
     */
    public function idListBySubcategory($subcategory)
    {
        $returnValue = array();

        // section -64--88-0-17-1ae5945a:16037f3f6d2:-8000:0000000000000DB6 begin
	    $this->Database = new Database();

	    $sql = $this->Database->prepare("SELECT id FROM ask_question_forum WHERE subcategory = ?");
	    $sql->setFetchMode( PDO::FETCH_ASSOC );
	    $sql->execute(array($subcategory));

	    $questionsIds = array();
	    foreach ($sql->fetchAll() as $questionsId ) {
		    $questionsIds[] = $questionsId['id'];
	    }

	    $returnValue = $questionsIds;
        // section -64--88-0-17-1ae5945a:16037f3f6d2:-8000:0000000000000DB6 end

        return (array) $returnValue;
    }

    /**
     * Returns an array of question ids that have been grouped by total answers
     * with question.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return array
     */
    public function groupedQuestions()
    {
        $returnValue = array();

        // section -64--88-0-17-1ae5945a:16037f3f6d2:-8000:0000000000000DB1 begin
	    /** Get list of question ids with number of times they've been answered.  */
	    $sql = $this->Database->prepare("SELECT answers_forum.question_id, count(*) as NUM FROM answers_forum GROUP BY question_id  ORDER BY NUM DESC");
	    $sql->setFetchMode( PDO::FETCH_ASSOC );
	    $sql->execute();

	    /** converts array into a CSV of question ids from most answered. */
	    $questionsIds = array();
	    foreach ($sql->fetchAll() as $questionsId ) {
		    $questionsIds[] = $questionsId['question_id'];
	    }
	    $returnValue = $questionsIds;
        // section -64--88-0-17-1ae5945a:16037f3f6d2:-8000:0000000000000DB1 end

        return (array) $returnValue;
    }

    /**
     * return list of question idsin a CSV
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  subcategory
     * @param  revers
     * @return array
     */
    public function mostAnswered($subcategory, $revers = false)
    {
        $returnValue = array();

        // section -64--88-0-17-1ae5945a:16037f3f6d2:-8000:0000000000000DAA begin
		$this->Database = new Database();

		/** Get question ids that have been answered from most to least. */
		$mostAnsweredIdList = $this->groupedQuestions();

	    /** Get all question ids including ones that have not been answered.  */
	    $allQuestionIds = $this->idListBySubcategory($subcategory);

	    /** Merge all question ids together */
	    $mergedQuestionIds = array_merge($mostAnsweredIdList, $allQuestionIds);

	    /** Extract duplicated question ids from the list and keep the original position. */
	    $questionsIds = array();
	    foreach ( $mergedQuestionIds as $mergedQuestionId ) {

	    	if(!in_array($mergedQuestionId,$questionsIds) && $this->questionIdsForSubcategory($mergedQuestionId, $subcategory) == true){
			    $questionsIds[] = $mergedQuestionId;
		    }
	    }

	    if($revers == true){
	    	$questionsIds = array_reverse($questionsIds);
	    }
	    $questionIdList= implode( ',', $questionsIds );

		/** Gets questions from most answered.  */
		$sql = $this->Database->prepare("SELECT * FROM ask_question_forum WHERE subcategory = ? AND id IN(" . $questionIdList .") ORDER BY FIELD(id," . $questionIdList .")");
		$sql->setFetchMode( PDO::FETCH_ASSOC );
		$sql->execute(array($subcategory));

		$returnValue =  $sql->fetchAll();

        // section -64--88-0-17-1ae5945a:16037f3f6d2:-8000:0000000000000DAA end

        return (array) $returnValue;
    }

    /**
     * Get an array of the categories that have questions associated with.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  UsersId
     * @return array
     */
    public function categoriesOfQuestions($UsersId = false)
    {
        $returnValue = array();

        // section -64--88-0-2-66e50275:1607f74241b:-8000:0000000000000EA4 begin
	    $this->Database = new Database();

	    if($UsersId == false){
		    $sql = $this->Database->prepare("SELECT DISTINCT category FROM ask_question_forum");
		    $sql->setFetchMode( PDO::FETCH_ASSOC );
		    $sql->execute();
	    }else {
		    $sql = $this->Database->prepare("SELECT DISTINCT category FROM ask_question_forum WHERE user_id = ?");
		    $sql->setFetchMode( PDO::FETCH_ASSOC );
		    $sql->execute(array($UsersId));
	    }

	    $returnValue = $sql->fetchAll(PDO::FETCH_COLUMN, 0);

        // section -64--88-0-2-66e50275:1607f74241b:-8000:0000000000000EA4 end

        return (array) $returnValue;
    }

    /**
     * Get an array of the subcategories that have questions associated with.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  UsersId
     * @return array
     */
    public function subcategoriesOfQuestions($UsersId = false)
    {
        $returnValue = array();

        // section -64--88-0-2-66e50275:1607f74241b:-8000:0000000000000EAE begin
	    $this->Database = new Database();

	    if($UsersId == false){
		    $sql = $this->Database->prepare("SELECT DISTINCT subcategory FROM ask_question_forum");
		    $sql->setFetchMode( PDO::FETCH_ASSOC );
		    $sql->execute();
	    }else {
		    $sql = $this->Database->prepare("SELECT DISTINCT subcategory FROM ask_question_forum WHERE user_id = ?");
		    $sql->setFetchMode( PDO::FETCH_ASSOC );
		    $sql->execute(array($UsersId));
	    }

	    $returnValue = $sql->fetchAll(PDO::FETCH_COLUMN, 0);
        // section -64--88-0-2-66e50275:1607f74241b:-8000:0000000000000EAE end

        return (array) $returnValue;
    }

    /**
     * Get the Category for the the question id.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  questionId
     * @return String
     */
    public function getCategoryByQuestionId($questionId)
    {
        $returnValue = null;

        // section -64--88-0-2-66e50275:1607f74241b:-8000:0000000000000ED4 begin
	    $this->Database = new Database();

	    $sql = $this->Database->prepare("SELECT DISTINCT category FROM ask_question_forum");
	    $sql->setFetchMode( PDO::FETCH_ASSOC);
	    $sql->execute(array($questionId));

	    $returnValue = $sql->fetchAll(PDO::FETCH_COLUMN, 0);
	    //$returnValue = $returnValue[0];
        // section -64--88-0-2-66e50275:1607f74241b:-8000:0000000000000ED4 end

        return $returnValue;
    }

    /**
     * Get the latest entered question.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return array
     */
    public function getLatestPost($qty = 1)
    {
        $returnValue = array();

        // section -64--88-0-2-6e345230:1609e7c7132:-8000:0000000000000EDB begin
	    $this->Database = new Database();

	    $sql = $this->Database->prepare("SELECT * FROM ask_question_forum ORDER BY id DESC LIMIT 0, :rows");
	    $sql->setFetchMode( PDO::FETCH_ASSOC);
        $sql->bindParam(':rows', $qty, PDO::PARAM_INT);
	    $sql->execute();

	    $returnValue = $sql->fetchAll();
        // section -64--88-0-2-6e345230:1609e7c7132:-8000:0000000000000EDB end

        return (array) $returnValue;
    }

    /**
     * Short description of method getQuestionByQuestionId
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  questionId
     * @return array
     */
    public function getQuestionByQuestionId($questionId)
    {
        $returnValue = array();

        // section -64--88-0-19-359969c0:161e3016d5d:-8000:00000000000010EF begin
	    $this->Database = new Database();

	    $sql = $this->Database->prepare("SELECT * FROM ask_question_forum WHERE id = ?");
	    $sql->setFetchMode( PDO::FETCH_ASSOC);
	    $sql->execute(array($questionId));

	    $returnValue = $sql->fetchAll();
	    $returnValue = $returnValue[0];
        //Debug::data($returnValue);
        // section -64--88-0-19-359969c0:161e3016d5d:-8000:00000000000010EF end

        return (array) $returnValue;
    }

    /**
     * Short description of method getQuestions
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return array
     */
    public function getQuestions($notEmailed = false)
    {
        $returnValue = array();

        // section -64--88-0-2--76d41c60:162689e6b70:-8000:0000000000001100 begin

	    $this->Database = new Database();

	    if($notEmailed == false):
            $sql = $this->Database->prepare("SELECT * FROM ask_question_forum ORDER BY id DESC ");
            $sql->setFetchMode( PDO::FETCH_ASSOC);
            $sql->execute();
        else:
            $sql = $this->Database->prepare("SELECT * FROM ask_question_forum WHERE emailed = 0");
            $sql->setFetchMode( PDO::FETCH_ASSOC);
            $sql->execute();
        endif;

	    $returnValue = $sql->fetchAll();
        // section -64--88-0-2--76d41c60:162689e6b70:-8000:0000000000001100 end

        return (array) $returnValue;
    }
    function markAsEmailed($id){
        $this->Database = new Database();

        $sql = $this->Database->prepare("UPDATE ask_question_forum SET emailed = 1  WHERE  id=?");
        $sql->execute(array($id));

        if($sql->rowCount() > 0){
            return  "Updated: " . $id;
        }else{
            return  "Failed to update: " . $id;
        }
    }
    function mostPopular($qty = 5)
    {
        include_once(CLASSES . 'class.ForumAnswers.php');

        $ForumAnswer = new ForumAnswers();
        $this->Database = new Database();

        $ids = $ForumAnswer->popularQuestionIds($qty);
        $questionCSV = implode(',',$ids);

        $sql = $this->Database->prepare("SELECT * FROM ask_question_forum WHERE id IN(" . $questionCSV .")");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();

        return $sql->fetchAll();
    }
    public function totalPostPerCategory($category){
        $this->Database = new Database();

        $sql = $this->Database->prepare("SELECT count(*) FROM ask_question_forum WHERE category = ?");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($category));

        return $sql->fetchColumn();
    }
    public function getPostIdByPageIdentifier($pageIdentifier){
        $this->Database = new Database();

        $sql = $this->Database->prepare("SELECT id FROM ask_question_forum WHERE pageIdentifier = ?");
        $sql->setFetchMode( PDO::FETCH_ASSOC);
        $sql->execute(array($pageIdentifier));

        $returnValue = $sql->fetchAll(PDO::FETCH_COLUMN, 0);
        return $returnValue[0];
    }

} /* end of class ForumQuestions */

?>