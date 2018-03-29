<?php

error_reporting(E_ALL);

/**
 * Get the forums posts the user is following.
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/**
 * Creates an object of replys's that are on a forum post.
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
require_once('class.ForumReplies.php');

/* user defined includes */
// section -64--88-0-2--1f3b4b5f:15ebf28ef11:-8000:0000000000000D30-includes begin
error_reporting(0);
require_once(CLASSES . 'Database.php');

// section -64--88-0-2--1f3b4b5f:15ebf28ef11:-8000:0000000000000D30-includes end

/* user defined constants */
// section -64--88-0-2--1f3b4b5f:15ebf28ef11:-8000:0000000000000D30-constants begin
// section -64--88-0-2--1f3b4b5f:15ebf28ef11:-8000:0000000000000D30-constants end

/**
 * Get the forums posts the user is following.
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class FollowingForumPosts
{
    // --- ASSOCIATIONS ---
    // generateAssociationEnd :     // generateAssociationEnd :     // generateAssociationEnd :     // generateAssociationEnd :     // generateAssociationEnd :     // generateAssociationEnd :     // generateAssociationEnd : ForumReplies

    // --- ATTRIBUTES ---

    /**
     * Short description of attribute userId
     *
     * @access private
     * @var Integer
     */
    private $userId = null;

    /**
     * Short description of attribute FollowingPosts
     *
     * @access public
     * @var Array
     */
    public $FollowingPosts = null;

    /**
     * Short description of attribute dbConnection
     *
     * @access private
     * @var String
     */
    private $dbConnection = null;

    /**
     * : of the followed post ids.
     *
     * @access public
     * @var Array
     */
    public $FollowingPostsId = null;

    // --- OPERATIONS ---

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
        // section -64--88-0-2--1f3b4b5f:15ebf28ef11:-8000:0000000000000D38 begin
        $this->userId = $userId;
        // section -64--88-0-2--1f3b4b5f:15ebf28ef11:-8000:0000000000000D38 end
    }

    /**
     * Gets the array of forum post the user is currently following.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return array
     */
    public function getFollowingPosts()
    {
        $returnValue = array();

        // section -64--88-0-2--1f3b4b5f:15ebf28ef11:-8000:0000000000000D41 begin
        $this->dbConnection = new Database();

        $sql = $this->dbConnection->prepare("SELECT * FROM hopetrac_main.forum_fol_sub_cat_post WHERE user_id = ?");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($this->userId));

        if($sql->rowCount() > 0){
            $returnValue = $sql->fetchAll();
        }
        // section -64--88-0-2--1f3b4b5f:15ebf28ef11:-8000:0000000000000D41 end

        return (array) $returnValue;
    }

    /**
     * Gets the list of just the followed posts ids.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return array
     */
    public function getFollowedPostsIds()
    {
        $returnValue = array();

        // section -64--88-0-2-1135e4b1:15ebf8d84cd:-8000:0000000000000AF4 begin
        foreach ($this->getFollowingPosts() as $FollowedPostId){
            $this->FollowingPostsId[] = $FollowedPostId['sub_cat_id_post'];
        }
        $returnValue = $this->FollowingPostsId;
        // section -64--88-0-2-1135e4b1:15ebf8d84cd:-8000:0000000000000AF4 end

        return (array) $returnValue;
    }

} /* end of class FollowingForumPosts */

?>