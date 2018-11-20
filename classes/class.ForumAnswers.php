<?php

error_reporting(E_ALL);

/**
 * untitledModel - class.ForumAnswers.php
 *
 * $Id$
 *
 * This file is part of untitledModel.
 *
 * Automatically generated on 27.03.2018, 17:04:56 with ArgoUML PHP module 
 * (last revised $Date: 2010-01-12 20:14:42 +0100 (Tue, 12 Jan 2010) $)
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-17--e38ad68:1602d4487e4:-8000:0000000000000D8C-includes begin
error_reporting( 0 );
require_once( CLASSES . 'Database.php' );
require_once( CLASSES . 'Sessions.php' );
require_once( CLASSES . 'Forum.php' );
require_once( CLASSES . 'class.ForumQuestions.php' );
include_once(CLASSES .'class.Notifications.php');
// section -64--88-0-17--e38ad68:1602d4487e4:-8000:0000000000000D8C-includes end

/* user defined constants */
// section -64--88-0-17--e38ad68:1602d4487e4:-8000:0000000000000D8C-constants begin
// section -64--88-0-17--e38ad68:1602d4487e4:-8000:0000000000000D8C-constants end

/**
 * Short description of class ForumAnswers
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class ForumAnswers
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * User's Id.
     *
     * @access public
     * @var Integer
     */
    public $userId = null;

    /**
     * General Object.
     *
     * @access public
     * @var array
     */
    public $General = array();

    /**
     * Database Object.
     *
     * @access public
     * @var array
     */
    public $Database = array();

    /**
     * Sesson Object.
     *
     * @access public
     * @var array
     */
    public $Session = array();

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
        // section -64--88-0-17--e38ad68:1602d4487e4:-8000:0000000000000D99 begin
	    $this->Session = new Sessions();
	    $this->General = new General();

	    /** Run methods if user is logged in */
	    if($this->Session->get('logged_in') ==  1):
		    $this->userId = $this->Session->get( 'user-id' );
	    endif;
        // section -64--88-0-17--e38ad68:1602d4487e4:-8000:0000000000000D99 end
    }

    /**
     * Stores the answer to the database.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  data
     * @return array
     */
    public function storeAnswer($data)
    {
        $returnValue = array();

        // section -64--88-0-17--e38ad68:1602d4487e4:-8000:0000000000000DA0 begin
        $this->Database = new Database();
	    $Notifications = new Notifications();

	    /** Default Answer Approval - Set to 1 for auto approve and 0 for manual approve */
	    $approval = 1;

	    /** @var  $post_type_id : set the post type id from the post_type table : represents "forum answer" */
	    $post_type_id = 4;

        $sql = $this->Database->prepare("INSERT INTO answers_forum (user_id, question_id, answer, ip, date_created,post_type,approved) VALUES(?,?,?,?,?,?,?)");
        $sql->execute(array(
           $this->userId,
           $data['question_id'],
           $data['answer'],
            $this->General->getUserIP(),
            time(),
	        $post_type_id,
	        $approval
        ));

	    if($sql->rowCount() > 0){
		    $returnValue['status'] = 'Success';
		    $returnValue['comment_user_id'] = $this->userId;
		    $returnValue['comment_id'] = $this->Database->lastInsertId();
		    $Notifications->setNotification($this->userId,$this->Database->lastInsertId(),4,0,0,$data['question_id']);

	    }else {
		    $returnValue['status'] = 'Failed';
	    }

	    echo json_encode($returnValue);
        // section -64--88-0-17--e38ad68:1602d4487e4:-8000:0000000000000DA0 end

        return (array) $returnValue;
    }

    /**
     * Get the count of answers from all uers or by user id or question id.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  approved
     * @param  userId
     * @param  questionId
     * @return Integer
     */
    public function countAnswers($approved = true, $userId = false, $questionId = false)
    {
        $returnValue = null;

        // section -64--88-0-17--e38ad68:1602d4487e4:-8000:0000000000000DA4 begin
	    $this->Database = new Database();

	    /** Get count for approved answers. */
	    if($approved == true){

	    	/** Get count for answers */
	    	if($userId == false && $questionId == false){
			    $sql = $this->Database->prepare("SELECT count(*) FROM answers_forum WHERE approved = 1");
			    $sql->execute();
		    }
		    /** Get count for answers */
		    if($questionId != false && $userId == false){
			    $sql = $this->Database->prepare("SELECT count(*) FROM answers_forum WHERE question_id = ? AND approved = 1");
			    $sql->execute(array($questionId));
		    }
		    /** Get count for answers */
		    if($userId != false && $questionId == false){

		        /** Test
                $sql = $this->Database->prepare("SELECT * FROM answers_forum WHERE user_id = ? AND approved = 1");
                $sql->execute(array($userId));

                Debug::out($sql->fetchAll());
                unset($sql);*/
			    $sql = $this->Database->prepare("SELECT count(*) FROM answers_forum WHERE user_id = ? AND approved = 1");
			    $sql->execute(array($userId));


		    }

		    $returnValue = $sql->fetchColumn();

	    }

        // section -64--88-0-17--e38ad68:1602d4487e4:-8000:0000000000000DA4 end

        return $returnValue;
    }

    /**
     * Get answers by either all, by user, by subcategory, by approved
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  userId
     * @param  questionId
     * @param  approved
     * @param  maxLimit
     * @param  startLimit
     * @return array
     */
    public function getAnswers($userId = false, $questionId = false, $approved = true, $maxLimit = 3, $startLimit = 0)
    {
        $returnValue = array();

        // section -64--88-0-17--e38ad68:1602d4487e4:-8000:0000000000000DC2 begin
	    if($approved == true){

		    $this->Database = new Database();

		    /** Get all answers. */
		    if($userId == false && $questionId == false){
			    $sql = $this->Database->prepare("SELECT *, (select count(*) FROM answers_forum WHERE approved = 1) AS total FROM answers_forum WHERE approved = 1 ORDER BY id DESC LIMIT :startLimit, :maxlimit");
			    $sql->setFetchMode( PDO::FETCH_ASSOC );
			    $sql->bindParam('startLimit',$startLimit, PDO::PARAM_INT);
			    $sql->bindParam('maxlimit',$maxLimit, PDO::PARAM_INT);
			    $sql->execute();

		    }

		    /** Get answers for user id. */
		    if($userId != false && $questionId == false){
			    $sql = $this->Database->prepare("SELECT *, (select count(*) FROM answers_forum WHERE user_id = :userId AND  approved = 1 ) AS total  FROM answers_forum WHERE user_id = :userId AND approved = 1 ORDER BY id DESC LIMIT :startLimit, :maxlimit");
			    $sql->setFetchMode( PDO::FETCH_ASSOC );
			    $sql->bindParam('startLimit',$startLimit, PDO::PARAM_INT);
			    $sql->bindParam('maxlimit',$maxLimit, PDO::PARAM_INT);
			    $sql->bindParam('userId',$userId, PDO::PARAM_STR);
			    $sql->execute();
		    }

		    /** Get  answers for question id. */
		    if($questionId != false && $userId == false){
			    $sql = $this->Database->prepare("SELECT *, (select count(*) FROM answers_forum WHERE question_id = :questionId AND  approved = 1 ) AS total  FROM answers_forum WHERE question_id = :questionId AND approved = 1 ORDER BY id DESC LIMIT :startLimit, :maxlimit");
			    $sql->setFetchMode( PDO::FETCH_ASSOC );
			    $sql->bindParam('startLimit',$startLimit, PDO::PARAM_INT);
			    $sql->bindParam('maxlimit',$maxLimit, PDO::PARAM_INT);
			    $sql->bindParam('questionId',$questionId, PDO::PARAM_STR);
			    $sql->execute();
		    }

		    /** Get  answers for question id. */
		    if($questionId == false && $userId != false){
			    $sql = $this->Database->prepare("SELECT * FROM answers_forum WHERE question_id = :questionId AND approved = 1");
			    $sql->setFetchMode( PDO::FETCH_ASSOC );
			    $sql->bindParam('questionId',$questionId, PDO::PARAM_STR);
			    $sql->execute();
		    }

		    $returnValue = $sql->fetchAll();

	    }
        // section -64--88-0-17--e38ad68:1602d4487e4:-8000:0000000000000DC2 end

        return (array) $returnValue;
    }

    /**
     * Check if the user answered a question by the question id.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  userId
     * @param  questionId
     * @return Boolean
     */
    public function userAnswered($userId, $questionId)
    {
        $returnValue = null;

        // section -64--88-0-17-1ae5945a:16037f3f6d2:-8000:0000000000000DA3 begin
	    $this->Database = new Database();

	    $sql = $this->Database->prepare("SELECT id FROM answers_forum WHERE user_id = ? and question_id = ?");
	    $sql->execute(array(
		    (int) $userId,
		    (int) $questionId
	    ));
	    if($sql->rowCount() > 0){
	    	$returnValue = true;
	    }else{
	    	$returnValue = false;
	    }
        // section -64--88-0-17-1ae5945a:16037f3f6d2:-8000:0000000000000DA3 end

        return $returnValue;
    }

    /**
     * Gets all answers for the provided question Id.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  questionId
     * @return array
     */
    public function getAnswersByQuestionId($questionId)
    {
        $returnValue = array();

        // section -64--88-0-19-6a079614:161dcc70c7f:-8000:00000000000010F3 begin
	    $this->Database = new Database();

	    $sql = $this->Database->prepare("SELECT * FROM answers_forum WHERE question_id = ?");
	    $sql->setFetchMode(PDO::FETCH_ASSOC);
	    $sql->execute(array(
		    (int) $questionId
	    ));
	    $returnValue = $sql->fetchAll();
        // section -64--88-0-19-6a079614:161dcc70c7f:-8000:00000000000010F3 end

        return (array) $returnValue;
    }

    /**
     * Get liked answers  for provided user.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  userId
     * @return array
     */
    public function getLikedAnswersOwnedByUser($userId)
    {
        $returnValue = array();

        // section -64--88-0-19-359969c0:161e3016d5d:-8000:00000000000010E7 begin
	    $this->Database = new Database();

	    $sql = $this->Database->prepare("SELECT * FROM liked_posts WHERE post_type = 4 AND post_user_id = ?");
	    $sql->setFetchMode(PDO::FETCH_ASSOC);
	    $sql->execute(array(
		    (int) $userId
	    ));
	   
	    $returnValue = $sql->fetchAll();
        // section -64--88-0-19-359969c0:161e3016d5d:-8000:00000000000010E7 end

        return (array) $returnValue;
    }

    /**
     * Get the question Id for the provided answer Id.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  answerId
     * @return Integer
     */
    public function getAnswersQuestionId($answerId)
    {
        $returnValue = null;

        // section -64--88-0-19-359969c0:161e3016d5d:-8000:00000000000010EB begin
	    $this->Database = new Database();

	    $sql = $this->Database->prepare("SELECT * FROM answers_forum WHERE  id = ?");
	    $sql->setFetchMode(PDO::FETCH_ASSOC);
	    $sql->execute(array(
		    (int) $answerId
	    ));

	    $returnValue = $sql->fetchAll();

	    $returnValue = $returnValue[0];
        // section -64--88-0-19-359969c0:161e3016d5d:-8000:00000000000010EB end

        return $returnValue;
    }

    /**
     * Short description of method totalAnswersByQuestionId
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  questionId
     * @return Integer
     */
    public function totalAnswersByQuestionId($questionId)
    {
        $returnValue = null;

        // section -64--88-0-2--76d41c60:162689e6b70:-8000:0000000000001104 begin
	    $this->Database = new Database();

	    $sql = $this->Database->prepare("SELECT count(*) FROM answers_forum WHERE  question_id = ?");
	    $sql->setFetchMode(PDO::FETCH_ASSOC);
	    $sql->execute(array(
		    (int) $questionId
	    ));
	    $returnValue = $returnValue = $sql->fetchColumn();
        // section -64--88-0-2--76d41c60:162689e6b70:-8000:0000000000001104 end

        return $returnValue;
    }
    public function popularQuestionIds($qty = 5)
    {
        $returnValue = null;

        // section -64--88-0-2--76d41c60:162689e6b70:-8000:0000000000001104 begin
	    $this->Database = new Database();

	    $sql = $this->Database->prepare("SELECT COUNT(id) as qty, question_id FROM answers_forum WHERE question_id != '' GROUP BY question_id ORDER BY qty DESC LIMIT 0, :qty");
	    $sql->bindParam('qty', $qty, PDO::PARAM_INT);
	    $sql->setFetchMode(PDO::FETCH_ASSOC);
	    $sql->execute();
	    $questionData= $returnValue = $sql->fetchAll();

	    $questionIds = array();

	    foreach ($questionData as $question){
	        $questionIds[] = $question['question_id'];
        }
        $returnValue = $questionIds;

        // section -64--88-0-2--76d41c60:162689e6b70:-8000:0000000000001104 end

        return $returnValue;
    }

} /* end of class ForumAnswers */

?>