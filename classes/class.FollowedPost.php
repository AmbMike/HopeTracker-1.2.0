<?php

error_reporting(E_ALL);

/**
 * untitledModel - class.FollowedPost.php
 *
 * $Id$
 *
 * This file is part of untitledModel.
 *
 * Automatically generated on 27.03.2018, 14:11:19 with ArgoUML PHP module 
 * (last revised $Date: 2010-01-12 20:14:42 +0100 (Tue, 12 Jan 2010) $)
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-2-d87318e:1607ab5cd5f:-8000:0000000000000E8C-includes begin
error_reporting(0);
include_once(CLASSES .'Sessions.php');
include_once(CLASSES .'Database.php');
include_once(CLASSES .'class.AnswerFilters.php');
// section -64--88-0-2-d87318e:1607ab5cd5f:-8000:0000000000000E8C-includes end

/* user defined constants */
// section -64--88-0-2-d87318e:1607ab5cd5f:-8000:0000000000000E8C-constants begin
// section -64--88-0-2-d87318e:1607ab5cd5f:-8000:0000000000000E8C-constants end

/**
 * Short description of class FollowedPost
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class FollowedPost
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * The users id who owns the post that is being followed.
     *
     * @access public
     * @var Integer
     */
    public $postUserId = null;

    /**
     * The id of the user is is following the post.
     *
     * @access public
     * @var Integer
     */
    public $followersUserId = null;

    /**
     * Database object.
     *
     * @access private
     * @var object
     */
    private $Database = null;

    /**
     * Session object.
     *
     * @access private
     * @var object
     */
    private $Session = null;

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
        // section -64--88-0-2-d87318e:1607ab5cd5f:-8000:0000000000000E98 begin
	    $this->Session = new Sessions();
        // section -64--88-0-2-d87318e:1607ab5cd5f:-8000:0000000000000E98 end
    }

    /**
     * Get the total count of user following a users id.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  postUsersId
     * @return Integer
     */
    public function getTotalUsersLikingUserPost($postUsersId)
    {
        $returnValue = null;

        // section -64--88-0-2-d87318e:1607ab5cd5f:-8000:0000000000000E9A begin
	    $this->Database = new Database();
	    $sql =  $this->Database->prepare("SELECT count(*) FROM followed_posts WHERE post_user_id = ?");
	    $sql->execute(array(
		    $postUsersId
	    ));

	    $returnValue = $sql->fetchColumn();
        // section -64--88-0-2-d87318e:1607ab5cd5f:-8000:0000000000000E9A end

        return $returnValue;
    }

    /**
     * Get all the ids of post the user is following.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  userId
     * @return array
     */
    public function getUsersFollowedPostIds($userId = false)
    {
        $returnValue = array();

        // section -64--88-0-2-66d49434:160937b2759:-8000:0000000000000EFA begin

	    $this->Database = new Database();
	    if($userId == false){
		    $sql =  $this->Database->prepare("SELECT post_id FROM followed_posts WHERE follows_user_id = ?");
		    $sql->setFetchMode( PDO::FETCH_ASSOC );
		    $sql->execute(array( $this->Session->get('user-id') ));
		    $returnValue = $sql->fetchAll(PDO::FETCH_COLUMN,0);
	    }else{
		    $sql =  $this->Database->prepare("SELECT post_id FROM followed_posts WHERE follows_user_id = ?");
		    $sql->setFetchMode( PDO::FETCH_ASSOC );
		    $sql->execute(array( $userId ));
		    $returnValue = $sql->fetchAll(PDO::FETCH_COLUMN,0);
	    }

        // section -64--88-0-2-66d49434:160937b2759:-8000:0000000000000EFA end

        return (array) $returnValue;
    }

    /**
     * Gets the total number of posts the user is following.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  userId
     * @param  postType
     * @return Integer
     */
    public function getTotalPostUserIsFollowing($userId = false, $postType = false)
    {
        $returnValue = null;

        // section -64--88-0-2-66d49434:160937b2759:-8000:0000000000000EE3 begin
	    $this->Database = new Database();

	    /** Set the user id if not provided */
	    if($userId != false):
		    $userId = $this->Session->get('user-id');
	    endif;


	    /** Set if post type is set, get followed post only from the chosen type. */
	    if($postType == false):
		    $sql =  $this->Database->prepare("SELECT count(*) FROM followed_posts WHERE follows_user_id = ?");
		    $sql->execute(array(
			    $userId
		    ));

	    else:
		    $sql =  $this->Database->prepare("SELECT count(*) FROM followed_posts WHERE follows_user_id = ? AND post_type = ?");
		    $sql->execute(array(
			    $userId,
			    $postType
		    ));
	    endif;

	    $returnValue = $sql->fetchColumn();
        // section -64--88-0-2-66d49434:160937b2759:-8000:0000000000000EE3 end

        return $returnValue;
    }

    /**
     * Get the categories the followed user's answer post belongs to.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  postId
     * @return array
     */
    public function getFollowedUserAnswerCategories($postId = false)
    {
        $returnValue = array();

        // section -64--88-0-2-66d49434:160937b2759:-8000:0000000000000EE6 begin
	    $AnswerFilters = new AnswerFilters();
	    foreach ($this->getUsersFollowedPostIds() as $postIds){
		    $returnValue[] =  $AnswerFilters->getAnswersCategory($postIds);
	    }

	    $returnValue = array_map( 'current', $returnValue );

	    $returnValue = array_unique( $returnValue );

        // section -64--88-0-2-66d49434:160937b2759:-8000:0000000000000EE6 end

        return (array) $returnValue;
    }

    /**
     * Get the subcategories the followed user's answer post belongs to.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  postId
     * @return array
     */
    public function getFollowedUserAnswerSubcategories($postId = false)
    {
        $returnValue = array();

        // section -64--88-0-2-66d49434:160937b2759:-8000:0000000000000EFF begin
	    $AnswerFilters = new AnswerFilters();
	    foreach ($this->getUsersFollowedPostIds() as $postIds){
		    $returnValue[] =  $AnswerFilters->getSubcategoriesOfUsersAnswers($postIds);
	    }

	    $returnValue = array_map( 'current', $returnValue );

	    $returnValue = array_unique( $returnValue );
        // section -64--88-0-2-66d49434:160937b2759:-8000:0000000000000EFF end

        return (array) $returnValue;
    }

    /**
     * Get the total number of users following a post by the posts id.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  postId
     * @return Integer
     */
    public function GetTotalFollowersForAPost($postId)
    {
        $returnValue = null;

        // section -64--88-0-2-6e345230:1609e7c7132:-8000:0000000000000EDE begin
	    $this->Database = new Database();
	    $sql =  $this->Database->prepare("SELECT count(*) FROM followed_posts WHERE post_id = ?");
	    $sql->execute(array(
		    $postId
	    ));
	    $returnValue = $sql->fetchColumn();
        // section -64--88-0-2-6e345230:1609e7c7132:-8000:0000000000000EDE end

        return $returnValue;
    }

} /* end of class FollowedPost */

?>