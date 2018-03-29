<?php

error_reporting(E_ALL);

/**
 * untitledModel - class.Notifications.php
 *
 * $Id$
 *
 * This file is part of untitledModel.
 *
 * Automatically generated on 20.02.2018, 10:04:22 with ArgoUML PHP module 
 * (last revised $Date: 2010-01-12 20:14:42 +0100 (Tue, 12 Jan 2010) $)
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-19-71c088a2:161ae4b3d84:-8000:0000000000001049-includes begin
require_once(CLASSES . 'Database.php');
require_once(CLASSES . 'General.php');
require_once(CLASSES . 'Sessions.php');
// section -64--88-0-19-71c088a2:161ae4b3d84:-8000:0000000000001049-includes end

/* user defined constants */
// section -64--88-0-19-71c088a2:161ae4b3d84:-8000:0000000000001049-constants begin
error_reporting( 0 );
// section -64--88-0-19-71c088a2:161ae4b3d84:-8000:0000000000001049-constants end

/**
 * Short description of class Notifications
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class Notifications
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * Short description of attribute Database
     *
     * @access private
     * @var class
     */
    private $Database = null;

    /**
     * Short description of attribute userId
     *
     * @access public
     * @var Integer
     */
    public $userId = null;

    /**
     * Short description of attribute Sessions
     *
     * @access public
     * @var class
     */
    public $Sessions = null;

    /**
     * Short description of attribute General
     *
     * @access public
     * @var class
     */
    public $General = null;

    // --- OPERATIONS ---

    /**
     * Construct Class
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return mixed
     */
    public function __construct()
    {
        // section -64--88-0-19-71c088a2:161ae4b3d84:-8000:0000000000001054 begin
	    $this->Sessions = new Sessions();
	    $this->General = new General();

	    if($this->Sessions->get('logged_in') == 1){
		    $this->userId = $this->Sessions->get( 'user-id' );
	    }else{
	    	$this->userId = 0;
	    }

        // section -64--88-0-19-71c088a2:161ae4b3d84:-8000:0000000000001054 end
    }

    /**
     * Set the notification for the logged in user.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  initiatedUserId : The user id for the user who has been initiated by the user liking/following etc the user posts etc.
     * @param  postId The post id for the post the user has made action on.
     * @param  postType The post type of the post the user made action on.
     * @param  like
     * @param  follow
     * @param  parentPostId The parent post id for the post the user has made action on. Example would be a user liked a answer to a question the user has created.
     * @return mixed
     */
    public function setNotification($initiatedUserId, $postId = false, $postType = false, $like = 0, $follow = 0, $parentPostId = 0)
    {
        // section -64--88-0-19-71c088a2:161ae4b3d84:-8000:0000000000001057 begin
	    $this->Database = new Database();

	    $sql = $this->Database->prepare("INSERT INTO notifications (initiatorUserId, initiatedUserId, postType, postId, last_updated, ip,likePost,followPost,parentPostId) VALUES (?,?,?,?,?,?,?,?,?)");
	    $sql->execute(array(
	    	$this->userId,
		    $initiatedUserId,
		    $postType,
		    $postId,
		    time(),
		    $this->General->getUserIP(),
		    $like,
		    $follow,
		    $parentPostId
		    ));
        // section -64--88-0-19-71c088a2:161ae4b3d84:-8000:0000000000001057 end
    }

    /**
     * Get the notifications for the logged in user. Get the notification by
     * if the param is provided.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  type
     * @return array
     */
    public function GetNotification($type = false)
    {
        $returnValue = array();

        // section -64--88-0-19-71c088a2:161ae4b3d84:-8000:0000000000001059 begin
	    $this->Database = new Database();

	    $sql = $this->Database->prepare("SELECT * FROM notifications WHERE initiatedUserId = ? AND notified = 0 ");
	    $sql->setFetchMode( PDO::FETCH_ASSOC );
	    $sql->execute(array($this->userId ));

	    $returnValue = $sql->fetchAll();
        // section -64--88-0-19-71c088a2:161ae4b3d84:-8000:0000000000001059 end

        return (array) $returnValue;
    }

} /* end of class Notifications */

?>