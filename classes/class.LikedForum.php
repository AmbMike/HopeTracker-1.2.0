<?php

error_reporting(E_ALL);

/**
 * Handles the forum post.
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-2--39fad00d:15f3572eac9:-8000:0000000000000C2B-includes begin
error_reporting(0);
require_once(CLASSES . 'Database.php');
require_once(CLASSES . 'Sessions.php');
// section -64--88-0-2--39fad00d:15f3572eac9:-8000:0000000000000C2B-includes end

/* user defined constants */
// section -64--88-0-2--39fad00d:15f3572eac9:-8000:0000000000000C2B-constants begin
// section -64--88-0-2--39fad00d:15f3572eac9:-8000:0000000000000C2B-constants end

/**
 * Handles the forum post.
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class LikedForum
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * Short description of attribute Database
     *
     * @access private
     * @var array
     */
    private $Database = array();

    /**
     * Short description of attribute Session
     *
     * @access private
     * @var array
     */
    private $Session = array();

    /**
     * Short description of attribute userId
     *
     * @access private
     * @var Integer
     */
    private $userId = null;

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
        // section -64--88-0-2--39fad00d:15f3572eac9:-8000:0000000000000C3A begin
        $this->Session = new Sessions();
        $this->userId = $this->Session->get('user-id');

        // section -64--88-0-2--39fad00d:15f3572eac9:-8000:0000000000000C3A end
    }

    /**
     * Get a list of forum ids the user liked.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return array
     */
    public function getLikedPostsIds()
    {
        $returnValue = array();

        // section -64--88-0-2--39fad00d:15f3572eac9:-8000:0000000000000C30 begin
        $this->Database = new Database();
        $sql = $this->Database->prepare("SELECT forum_id,TIMESTAMP FROM hopetrac_main.forum_likes WHERE likers_user_id = ? ");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array(
            $this->userId
        ));

       /* foreach ($sql->fetchAll() as $item) {
            $returnValue[] = $item['forum_id'];
        }*/
        $returnValue = $sql->fetchAll();

        // section -64--88-0-2--39fad00d:15f3572eac9:-8000:0000000000000C30 end

        return (array) $returnValue;
    }

    /**
     * Gets a list of forum post replies the where the user is following the
     * post.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return array
     */
    public function getFollowedPostsReplies()
    {
        $returnValue = array();

        // section -64--88-0-2--39fad00d:15f3572eac9:-8000:0000000000000C40 begin
        $this->Database = new Database();
        $thePostIds = (array) $this->getLikedPostsIds();
        foreach ($thePostIds as $likedPostsId) {
            $sql = $this->Database->prepare("SELECT * FROM forum_replies WHERE post_id = :ids AND TIMESTAMP > :beganFollowing ORDER BY id DESC ");
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $sql->bindParam('ids',$likedPostsId['forum_id'],PDO::PARAM_INT);
            $sql->bindParam('beganFollowing',$likedPostsId['TIMESTAMP'],PDO::PARAM_STR);
            $sql->execute();
            $returnValue[] = $sql->fetchAll();
        }

        $returnValue = array_filter($returnValue);
        $returnValue = array_map('current',$returnValue);
        // section -64--88-0-2--39fad00d:15f3572eac9:-8000:0000000000000C40 end

        return (array) $returnValue;
    }

} /* end of class LikedForum */
