<?php

error_reporting(E_ALL);

/**
 * The class that handles all the post follows. NOTE: FollowingForumPosts Class
 * be delete at end.
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-2-d87318e:1607ab5cd5f:-8000:0000000000000E60-includes begin
error_reporting(0);
include_once(CLASSES .'Sessions.php');
include_once(CLASSES .'Database.php');
include_once(CLASSES .'General.php');
include_once(CLASSES .'class.Notifications.php');
// section -64--88-0-2-d87318e:1607ab5cd5f:-8000:0000000000000E60-includes end

/* user defined constants */
// section -64--88-0-2-d87318e:1607ab5cd5f:-8000:0000000000000E60-constants begin
// section -64--88-0-2-d87318e:1607ab5cd5f:-8000:0000000000000E60-constants end

/**
 * The class that handles all the post follows. NOTE: FollowingForumPosts Class
 * be delete at end.
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class FollowPost
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

    /**
     * The post type id for the post that is being followed by the user.
     *
     * @access public
     * @var Integer
     */
    public $postType = null;

    /**
     * The user's id who is following the post.
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
        // section -64--88-0-2-d87318e:1607ab5cd5f:-8000:0000000000000E76 begin
	    $this->postId = $postId;
	    $this->postType = $postType;
	    $this->postsUserId = $postUserId;

	    $this->Database = new Database();
	    $this->Session = new Sessions();
	    $this->General = new General();

	    $this->userId = $this->Session->get( 'user-id' );
        // section -64--88-0-2-d87318e:1607ab5cd5f:-8000:0000000000000E76 end
    }

    /**
     * check if a post is folled.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return Boolean
     */
    public function checkFollowedPost()
    {
        $returnValue = null;

        // section -64--88-0-2-d87318e:1607ab5cd5f:-8000:0000000000000E7B begin
	    $this->Database = new Database();
	    $sql =  $this->Database->prepare("SELECT * FROM followed_posts WHERE post_id = ? AND follows_user_id = ? AND post_type = ?");
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
        // section -64--88-0-2-d87318e:1607ab5cd5f:-8000:0000000000000E7B end

        return $returnValue;
    }

    /**
     * Unfollow the post if it's being followed aready.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return Boolean
     */
    public function unfollowPost()
    {
        $returnValue = null;

        // section -64--88-0-2-d87318e:1607ab5cd5f:-8000:0000000000000E7D begin
	    $sql =  $this->Database->prepare("DELETE FROM followed_posts WHERE post_id = ? AND follows_user_id = ? AND post_type= ?");
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
        // section -64--88-0-2-d87318e:1607ab5cd5f:-8000:0000000000000E7D end

        return $returnValue;
    }

    /**
     * Follow post.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return array
     */
    public function followPost()
    {
        $returnValue = array();

        // section -64--88-0-2-d87318e:1607ab5cd5f:-8000:0000000000000E7F begin
	    $this->Database = new Database();
	    $Notifications = new Notifications();

	    /** If post has not already been followed by the user then follow it.  */
	    if($this->checkFollowedPost() == false):
		    /** Run query to set the follow for the post   by the user.  */
		    $sql =  $this->Database->prepare("INSERT INTO followed_posts (follows_user_id, post_user_id, post_id, post_type, ip, date_created) VALUES(?,?,?,?,?,?)");
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
			    $returnValue['status'] = 'following';
			    $Notifications->setNotification($this->postsUserId,$this->postId,$this->postType,0,1);
		    }else{
			    $returnValue['status'] = 'failed follow query';
		    }

	    else:
		    /** Un Follow post by user if the user already following the post */
		    if($this->unfollowPost() == true){
			    $returnValue['status'] = 'unfollowed';
			    $Notifications->setNotification($this->postsUserId,$this->postId,$this->postType,0,2);
		    }else{
			    $returnValue['status'] = 'failed unfollow query';
		    }
	    endif;
        // section -64--88-0-2-d87318e:1607ab5cd5f:-8000:0000000000000E7F end

        return (array) $returnValue;
    }

} /* end of class FollowPost */

?>