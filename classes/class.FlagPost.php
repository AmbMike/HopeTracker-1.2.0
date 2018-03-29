<?php

error_reporting(E_ALL);

/**
 * The class that handles flagging all post from question, answers, to journal
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000F14-includes begin
error_reporting(1);
include_once(CLASSES .'Sessions.php');
include_once(CLASSES .'Database.php');
// section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000F14-includes end

/* user defined constants */
// section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000F14-constants begin
// section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000F14-constants end

/**
 * The class that handles flagging all post from question, answers, to journal
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class FlagPost
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * Databse object.
     *
     * @access private
     * @var object
     */
    private $Database = null;

    /**
     * Session object.
     *
     * @access public
     * @var object
     */
    public $Session = null;

    /**
     * Post id for the post that is being flagged.
     *
     * @access public
     * @var Integer
     */
    public $postId = null;

    /**
     * User id for the user who is flagging the post.
     *
     * @access public
     * @var Integer
     */
    public $userId = null;

    /**
     * General Class Object.
     *
     * @access public
     * @var object
     */
    public $General = null;

    // --- OPERATIONS ---

    /**
     * contstruct the class.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return mixed
     */
    public function __construct()
    {
        // section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000F24 begin
	    $this->Session = new Sessions();
	    $this->General = new General();

	    if($this->Session->get('logged_in') == 1){
		    $this->userId = $this->Session->get( 'user-id' );
	    }
        // section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000F24 end
    }

    /**
     * Check if the user had flagged the post.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  postId
     * @param  postType
     * @return Boolean
     */
    public function checkIfUserFlaggedPost($postId, $postType)
    {
        $returnValue = null;

        // section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000F3B begin
	    $Database = new Database();
	    $sql = $Database->prepare("SELECT id FROM flagged_post WHERE flaggers_id = ? AND flagged_post_id = ?  AND post_type = ?");
	    $sql->execute(array(
		    $this->userId,
		    $postId,
		    $postType
	    ));
	    if($sql->rowCount() > 0){
		    $returnValue = true;
	    }else{
		    $returnValue = false;
	    }
        // section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000F3B end

        return $returnValue;
    }

    /**
     * Process the post that is being flagged by the user.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  postId
     * @param  postType
     * @return array
     */
    public function flagPost($postId, $postType)
    {
        $returnValue = array();

        // section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000F2E begin

	    /** If the user has not already flagged the post then flag the post */
	    if($this->checkIfUserFlaggedPost($postId, $postType) == false){
		    $Database = new Database();
		    $sql = $Database->prepare("INSERT INTO flagged_post (flaggers_id, flagged_post_id, post_type, flaggers_ip, date_flagged) VALUES(?,?,?,?,?)");
		    $sql->execute(array(
			    $this->userId,
			    $postId,
			    $postType,
			    $this->General->getUserIP(),
			    time()
		    ));
		    if($sql->rowCount() > 0){
			    $returnValue['status'] = 'flagged';
		    }else{
			    $returnValue['status'] = 'failed flag query';
		    }
	    }else{
	    	/** If the user already flagged the post */
		    $returnValue['status'] = 'already flagged';
	    }


        // section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000F2E end

        return (array) $returnValue;
    }

} /* end of class FlagPost */

?>