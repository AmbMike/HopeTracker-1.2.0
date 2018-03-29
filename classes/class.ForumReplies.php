<?php

error_reporting(E_ALL);

/**
 * Creates an object of replys's that are on a forum post.
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
	die('This file was generated for PHP 5');
}

/**
 * Get the forums posts the user is following.
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
require_once('class.FollowingForumPosts.php');

/* user defined includes */
// section -64--88-0-2--6e7e7407:15eb987c747:-8000:0000000000000BF0-includes begin
error_reporting(0);
require_once(CLASSES . 'Database.php');
require_once(CLASSES . 'class.ForumPosts.php');
require_once(CLASSES . 'class.FollowingForumPosts.php');
// section -64--88-0-2--6e7e7407:15eb987c747:-8000:0000000000000BF0-includes end

/* user defined constants */
// section -64--88-0-2--6e7e7407:15eb987c747:-8000:0000000000000BF0-constants begin
// section -64--88-0-2--6e7e7407:15eb987c747:-8000:0000000000000BF0-constants end

/**
 * Creates an object of replys's that are on a forum post.
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class ForumReplies
{
	// --- ASSOCIATIONS ---
	// generateAssociationEnd : FollowingForums    // generateAssociationEnd :     // generateAssociationEnd :     // generateAssociationEnd :     // generateAssociationEnd :     // generateAssociationEnd :

	// --- ATTRIBUTES ---

	/**
	 * Users Id.
	 *
	 * @access private
	 * @var String
	 */
	private $userId = null;

	/**
	 * Post Id.
	 *
	 * @access private
	 * @var String
	 */
	private $forumId = null;

	/**
	 * Reply Id.
	 *
	 * @access private
	 * @var String
	 */
	private $replyId = null;

	/**
	 * Database connection object.
	 *
	 * @access private
	 * @var String
	 */
	private $db = null;

	/**
	 * Variable of the PARENT which is an array of all the forum post the user
	 * currently following.
	 *
	 * @access private
	 * @var FollowingForumPosts
	 */
	private $followingForums = null;

	/**
	 * Stores the id of forums the user is currently following.
	 *
	 * @access public
	 * @var array
	 */
	public $followingForumsId = array();

	// --- OPERATIONS ---

	/**
	 * Sets the class variable for followingForumsId.
	 *
	 * @access public
	 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
	 * @param  userId
	 * @return mixed
	 */
	public function setFollowingForumIds($userId)
	{
		// section -64--88-0-2--1b6ff850:15ec3d3fb4f:-8000:0000000000000B01 begin
		$this->followingForums = new FollowingForumPosts($userId);
		$this->followingForumsId = $this->followingForums->getFollowedPostsIds();
		// section -64--88-0-2--1b6ff850:15ec3d3fb4f:-8000:0000000000000B01 end
	}

	/**
	 * Short description of method __construct
	 *
	 * @access public
	 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
	 * @param  userId
	 * @return mixed
	 */
	public function __construct($userId)
	{
		// section -64--88-0-2-788d36ed:15eba7d38ee:-8000:0000000000000AA5 begin
		$this->userId = $userId;
		$this->followingForums = new FollowingForumPosts($userId);
		$this->setFollowingForumIds($userId);
		// section -64--88-0-2-788d36ed:15eba7d38ee:-8000:0000000000000AA5 end
	}

	/**
	 * Get an array of all replys the user is following.
	 *
	 * @access public
	 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
	 * @param  forumIds
	 * @return String
	 */
	public function getReplies($forumIds)
	{
		$returnValue = null;

		// section -64--88-0-2--6e0b139d:15ebf750ae5:-8000:0000000000000AE6 begin
		$this->db = new Database();

		$sql = $this->db->prepare("SELECT * FROM forum_fol_sub_cat_post WHERE sub_cat_id_post = ? ");
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		$sql->execute(array(
			$forumIds
		));
		if($sql->rowCount() > 0){
			$returnValue = $sql->fetchAll();
		}else{
			$returnValue = false;
		}
		// section -64--88-0-2--6e0b139d:15ebf750ae5:-8000:0000000000000AE6 end

		return $returnValue;
	}

	/**
	 * Check if the user is following the the forum post by checking the user's
	 * and Forum Id.
	 *
	 * @access public
	 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
	 * @param  forumId
	 * @param  userId
	 * @return Boolean
	 */
	public function isFollowingForumPost($forumId, $userId)
	{
		$returnValue = null;

		// section -64--88-0-2--6e7e7407:15eb987c747:-8000:0000000000000BF7 begin
		$this->db = new Database();

		$sql = $this->db->prepare("SELECT id FROM forum_fol_sub_cat_post WHERE sub_cat_id_post = ? AND user_id = ? ");
		$sql->execute(array(
			$forumId,
			$userId
		));
		if($sql->rowCount() > 0){
			$returnValue = true;
		}else{
			$returnValue = false;
		}
		// section -64--88-0-2--6e7e7407:15eb987c747:-8000:0000000000000BF7 end

		return $returnValue;
	}

	/**
	 * : Sets the reply as viewed in the database, when the user has viewd the
	 *
	 * @access public
	 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
	 * @param  userId
	 * @param  replyId
	 * @return mixed
	 */
	public function setReplyToViewed($userId, $replyId)
	{
		// section -64--88-0-2--1b6ff850:15ec3d3fb4f:-8000:0000000000000B07 begin
		// section -64--88-0-2--1b6ff850:15ec3d3fb4f:-8000:0000000000000B07 end
	}

	/**
	 * Check if the user has already viewed the forum reply by checking if the
	 * repy timestamp is after the timstamp the user began following the forum
	 *
	 * @access public
	 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
	 * @param  userId
	 * @param  replyId
	 * @param  beganFollowingTimestamp : The timestamp of when the user began following the forum post.
	 * @return Boolean
	 */
	public function isNewReply($userId, $replyId, $beganFollowingTimestamp)
	{
		$returnValue = null;

		// section -64--88-0-2--6e7e7407:15eb987c747:-8000:0000000000000BF9 begin
		$this->db = new Database();
		$sql = $this->db->prepare("SELECT id FROM new_forum_reply WHERE user_id = ? AND reply_id = ? AND TIMESTAMP > ? ");
		$sql->execute(array($userId,$replyId));
		if($sql->rowCount()){
			$returnValue = true;
		}else{
			$returnValue = false;
		}
		// section -64--88-0-2--6e7e7407:15eb987c747:-8000:0000000000000BF9 end

		return $returnValue;
	}

	/**
	 * Gets the timestamp from when the user begain following the forum post.
	 *
	 * @access public
	 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
	 * @param  forumId
	 * @param  userId
	 * @return String
	 */
	public function getFollowedForumTimestamp($forumId, $userId)
	{
		$returnValue = null;

		// section -64--88-0-2--6e7e7407:15eb987c747:-8000:0000000000000C09 begin
		$this->db = new Database();
		$sql = $this->db->prepare("SELECT TIMESTAMP FROM forum_fol_sub_cat_post WHERE user_id = ? AND sub_cat_id_post = ?");
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		$sql->execute(array(
			$userId,
			$forumId
		));

		$returnValue = $sql->fetchColumn();
		// section -64--88-0-2--6e7e7407:15eb987c747:-8000:0000000000000C09 end

		return $returnValue;
	}

	/**
	 * Gets the reply message.
	 *
	 * @access public
	 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
	 * @param  replyId
	 * @return String
	 */
	public function getReplyData($replyId)
	{
		$returnValue = null;

		// section -64--88-0-2--6e7e7407:15eb987c747:-8000:0000000000000C0C begin
		$this->db = new Database();
		$sql = $this->db->prepare("SELECT * FROM forum_replies WHERE id = ? ");
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		$sql->execute(array($replyId));

		$returnValue = $sql->fetchAll();
		// section -64--88-0-2--6e7e7407:15eb987c747:-8000:0000000000000C0C end

		return $returnValue;
	}

	/**
	 * Gets the user Id who posted the reply.
	 *
	 * @access public
	 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
	 * @param  replyId
	 * @return String
	 */
	public function getReplyUserId($replyId)
	{
		$returnValue = null;

		// section -64--88-0-2--6e7e7407:15eb987c747:-8000:0000000000000C0F begin
		$this->db = new Database();
		$sql = $this->db->prepare("SELECT user_id FROM forum_replies WHERE id = ? ");
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		$sql->execute(array($replyId));

		$returnValue = $sql->fetchColumn();
		// section -64--88-0-2--6e7e7407:15eb987c747:-8000:0000000000000C0F end

		return $returnValue;
	}

	/**
	 * Gets the the followers Id from the repy using the posts id.
	 *
	 * @access public
	 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
	 * @param  replyId
	 */
	public function getFollowersId($replyId)
	{
		// section -64--88-0-2--6e7e7407:15eb987c747:-8000:0000000000000C12 begin
		return $this->followingForums->getFollowingPosts();
		// section -64--88-0-2--6e7e7407:15eb987c747:-8000:0000000000000C12 end
	}

	/**
	 * Short description of method getNewReplies
	 *
	 * @access public
	 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
	 * @return array
	 */
	public function getNewReplies()
	{
		$returnValue = array();

		// section -64--88-0-2-1135e4b1:15ebf8d84cd:-8000:0000000000000B01 begin
		// section -64--88-0-2-1135e4b1:15ebf8d84cd:-8000:0000000000000B01 end

		return (array) $returnValue;
	}

	/**
	 * Short description of method getAllReplies
	 *
	 * @access public
	 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
	 * @return array
	 */
	public function getAllReplies()
	{
		$returnValue = array();

		// section -64--88-0-2-1135e4b1:15ebf8d84cd:-8000:0000000000000B04 begin
		$this->db = new Database();
		$sql = $this->db->prepare("SELECT * FROM forum_replies ");
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		$sql->execute();

		$returnValue = $sql->fetchAll();
		// section -64--88-0-2-1135e4b1:15ebf8d84cd:-8000:0000000000000B04 end

		return (array) $returnValue;
	}

	/**
	 * Short description of method getFollowedReplies
	 *
	 * @access public
	 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
	 * @return array
	 */
	public function getFollowedReplies()
	{
		$returnValue = array();

		// section -64--88-0-2-1135e4b1:15ebf8d84cd:-8000:0000000000000B07 begin
		$this->db = new Database();

		$followedForumPostIds = implode(',',$this->followingForumsId);
		Debug::data($this->followingForumsId);
		$sql = $this->db->prepare("SELECT * FROM forum_replies WHERE post_id IN(" . $followedForumPostIds .")");
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		$sql->execute();

		$returnValue = $sql->fetchAll();
		// section -64--88-0-2-1135e4b1:15ebf8d84cd:-8000:0000000000000B07 end

		return (array) $returnValue;
	}

	/**
	 * Get the total of replies on a forum post by the post's id.
	 *
	 * @access public
	 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
	 * @param  postId
	 * @return String
	 */
	public function getTotalPostReplies($postId)
	{
		$returnValue = null;

		// section -64--88-0-2--39fad00d:15f3572eac9:-8000:0000000000000BE6 begin
		$this->db = new Database();
		$sql = $this->db->prepare("SELECT count(*) FROM forum_replies WHERE post_id = ? " );
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		$sql->execute(array($postId));
		$returnValue = $sql->fetchColumn();
		// section -64--88-0-2--39fad00d:15f3572eac9:-8000:0000000000000BE6 end

		return $returnValue;
	}

} /* end of class ForumReplies */

?>