<?php

error_reporting(E_ALL);

/**
 * The class that handles all the post likes.-- Side Note - Remove old like type
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-2-431c6586:1605b7d1d7a:-8000:0000000000000E3E-includes begin
error_reporting(0);
include_once(CLASSES .'Sessions.php');
include_once(CLASSES .'Database.php');
include_once(CLASSES .'General.php');
include_once(CLASSES .'class.Notifications.php');
// section -64--88-0-2-431c6586:1605b7d1d7a:-8000:0000000000000E3E-includes end

/* user defined constants */
// section -64--88-0-2-431c6586:1605b7d1d7a:-8000:0000000000000E3E-constants begin
// section -64--88-0-2-431c6586:1605b7d1d7a:-8000:0000000000000E3E-constants end

/**
 * The class that handles all the post likes.-- Side Note - Remove old like type
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class LikePost
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * The post id for the post that is being liked.
     *
     * @access public
     * @var Integer
     */
    public $postId = null;

    /**
     * The post type id for the post that is being liked by the user.
     *
     * @access public
     * @var Integer
     */
    public $postType = null;

    /**
     * The user's id who is liking the post.
     *
     * @access public
     * @var Integer
     */
    public $userId = null;

    /**
     * The Database object.
     *
     * @access private
     * @var object
     */
    private $Database = null;

    /**
     * The Session object.
     *
     * @access private
     * @var object
     */
    private $Session = null;

    /**
     * The id of the user who owns the post.
     *
     * @access public
     * @var Integer
     */
    public $postsUserId = null;

    /**
     * The General class object.
     *
     * @access private
     * @var object
     */
    private $General = null;

    // --- OPERATIONS ---

    /**
     * Contruct the class.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  postId
     * @param  postType
     * @param  postUserId
     * @return mixed
     */
    public function __construct($postId, $postType, $postUserId)
    {
        // section -64--88-0-2-431c6586:1605b7d1d7a:-8000:0000000000000E4E begin
	    $this->postId = $postId;
	    $this->postType = $postType;
	    $this->postsUserId = $postUserId;

	    $this->Database = new Database();
	    $this->Session = new Sessions();
	    $this->General = new General();


	    if($this->Session->get('logged_in') == 1){
		    $this->userId = $this->Session->get( 'user-id' );
	    }else{
		   // $this->userId = 0;
	    }

        // section -64--88-0-2-431c6586:1605b7d1d7a:-8000:0000000000000E4E end
    }

    /**
     * check if a question is liked.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return Boolean
     */
    public function checkLikedQuestion()
    {
        $returnValue = null;

        // section -64--88-0-2-431c6586:1605b7d1d7a:-8000:0000000000000E58 begin
	    $this->Database = new Database();
	    $sql =  $this->Database->prepare("SELECT * FROM liked_posts WHERE post_id = ? AND likers_user_id = ? AND post_type = ?");
	    $sql->execute(array(
		     $this->postId,
		    $this->userId,
		    (int) $this->postType
	    ));
	    if($sql->rowCount() > 0){
		    $returnValue =  true;
	    }else{
		    $returnValue = false;
	    }
        // section -64--88-0-2-431c6586:1605b7d1d7a:-8000:0000000000000E58 end

        return $returnValue;
    }

    /**
     * Unlinke the question by the user.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return Boolean
     */
    public function unlikeQuestion()
    {
        $returnValue = null;

        // section -64--88-0-2-431c6586:1605b7d1d7a:-8000:0000000000000E5C begin
	    $sql =  $this->Database->prepare("DELETE FROM liked_posts WHERE post_id = ? AND likers_user_id = ? AND post_type= ?");
	    $sql->execute(array(
		    $this->postId,
		    $this->userId,
		    $this->postType
	    ));
	    if($sql->rowCount() > 0){
		    $returnValue =  true;
	    }else{
		    $returnValue = false;
	    }
        // section -64--88-0-2-431c6586:1605b7d1d7a:-8000:0000000000000E5C end

        return $returnValue;
    }

    /**
     * Process a like from a user for a question.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return array
     */
    public function likeQuestion()
    {
        $returnValue = array();

        // section -64--88-0-2-431c6586:1605b7d1d7a:-8000:0000000000000E62 begin
	     $this->Database = new Database();
	     $Notifications = new Notifications();

	    /** If question has not already been liked than like it.  */
	    if($this->checkLikedQuestion() == false):
		    /** Run query to set the like for the question by the user.  */
		    $sql =  $this->Database->prepare("INSERT INTO liked_posts (likers_user_id, post_user_id, post_id, post_type, ip, date_created) VALUES(?,?,?,?,?,?)");
		    $sql->execute(array(
			    $this->userId,
			    $this->postsUserId,
			    $this->postId,
			    $this->postType,
			    $this->General->getUserIP(),
			    time()
		    ));

		    /** Check query and set status for ajax */
		    if($sql->rowCount() > 0){
			    $returnValue['status'] = 'liked';
			    $Notifications->setNotification($this->postsUserId,$this->postId,$this->postType,1,0);
		    }else{
			    $returnValue['status'] = 'failed liked query';
		    }

	    else:
		    /** Un like question by user if the user already liked the question */
		    if($this->unlikeQuestion() == true){
			    $returnValue['status'] = 'unliked';
			    $Notifications->setNotification($this->postsUserId,$this->postId,$this->postType,2,0);
		    }else{
			    $returnValue['status'] = 'failed unliked query';
		    }
	    endif;
        // section -64--88-0-2-431c6586:1605b7d1d7a:-8000:0000000000000E62 end

        return (array) $returnValue;
    }

    /**
     * Short description of method getTotalLikes
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return Integer
     */
    public function getTotalLikes()
    {
        $returnValue = null;

        // section -64--88-0-19-152f3e04:160e7653485:-8000:0000000000000EE6 begin
	    $sql =  $this->Database->prepare("SELECT count(*) FROM liked_posts WHERE post_id = ? AND post_type= ?");
	    $sql->execute(array(
		    $this->postId,
		    $this->postType
	    ));
	    $sql->setFetchMode( PDO::FETCH_ASSOC );
	    $returnValue = $sql->fetchColumn();
        // section -64--88-0-19-152f3e04:160e7653485:-8000:0000000000000EE6 end

        return $returnValue;
    }

} /* end of class LikePost */

?>