<?php

error_reporting(E_ALL);

/**
 * Follow the user class. Gives the logged in user the control to follow or
 * a user.
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-19-3d5b9cc5:161b8d6a9c4:-8000:000000000000108C-includes begin
error_reporting( 0 );
include_once( CLASSES . 'Sessions.php' );
// section -64--88-0-19-3d5b9cc5:161b8d6a9c4:-8000:000000000000108C-includes end

/* user defined constants */
// section -64--88-0-19-3d5b9cc5:161b8d6a9c4:-8000:000000000000108C-constants begin
// section -64--88-0-19-3d5b9cc5:161b8d6a9c4:-8000:000000000000108C-constants end

/**
 * Follow the user class. Gives the logged in user the control to follow or
 * a user.
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class FollowUser
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * The user who is requesting to follow a user.
     *
     * @access public
     * @var Integer
     */
    public $FollowersUserId = null;

    /**
     * The user who is being followed by the logged in user.
     *
     * @access public
     * @var Integer
     */
    public $FollowedUserId = null;

    /**
     * The session class.
     *
     * @access public
     * @var class
     */
    public $Session = null;

    /**
     * The logged in user's id.
     *
     * @access public
     * @var Integer
     */
    public $userId = null;

    /**
     * The database class.
     *
     * @access private
     * @var class
     */
    private $Database = null;

    /**
     * The General Class.
     *
     * @access public
     * @var class
     */
    public $General = null;

    // --- OPERATIONS ---

    /**
     * Construct the class.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  followingUserId
     * @return mixed
     */
    public function __construct($followingUserId)
    {
        // section -64--88-0-19-3d5b9cc5:161b8d6a9c4:-8000:0000000000001099 begin
	    $this->Session = new Sessions();
	    $this->General = new General();

	    if($this->Session->get('logged_in') == 1){
		    $this->userId = $this->Session->get( 'user-id' );
	    }else{
	    	$this->userId = 0;
	    }

	    $this->FollowedUserId = $followingUserId;
        // section -64--88-0-19-3d5b9cc5:161b8d6a9c4:-8000:0000000000001099 end
    }

    /**
     * Check if the logged in user is already following the other user.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  Unfollowed
     * @return Boolean
     */
    public function isFollowingUser($Unfollowed = false)
    {
        $returnValue = null;

        // section -64--88-0-19-3d5b9cc5:161b8d6a9c4:-8000:0000000000001093 begin
	    $this->Database = new Database();
	    if($Unfollowed == false):
		    $sql = $this->Database->prepare("SELECT id FROM follow_user WHERE follow_user_id = ? AND followers_id = ? AND status = 1");
		    $sql->execute( array(
			    $this->FollowedUserId,
			    $this->userId
		    ) );

		    if($sql->rowCount() > 0){
			    $returnValue = true;
		    }else{
			    $returnValue = false;
		    }
	    else :
		    $sql = $this->Database->prepare("SELECT id FROM follow_user WHERE follow_user_id = ? AND followers_id = ? AND status = 0");
		    $sql->execute( array(
			    $this->FollowedUserId,
			    $this->userId
		    ) );

		    if($sql->rowCount() > 0){
			    $returnValue = true;
		    }else{
			    $returnValue = false;
		    }
	    endif;

        // section -64--88-0-19-3d5b9cc5:161b8d6a9c4:-8000:0000000000001093 end

        return $returnValue;
    }

    /**
     * Un follow the user requested by the logged in user.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return Boolean
     */
    public function unFollowUser()
    {
        $returnValue = null;

        // section -64--88-0-19-3d5b9cc5:161b8d6a9c4:-8000:0000000000001095 begin
	    $this->Database = new Database();
	    $sql = $this->Database->prepare("UPDATE follow_user SET status = 0, TIMESTAMP = ? WHERE follow_user_id = ? AND followers_id = ?");
	    $sql->execute( array(
		    date("Y-m-d H:i:s", time()),
		    $this->FollowedUserId,
		    $this->userId
	    ) );

	    if($sql->rowCount() > 0){
		    $returnValue = true;
	    }else{
		    $returnValue = false;
	    }
        // section -64--88-0-19-3d5b9cc5:161b8d6a9c4:-8000:0000000000001095 end

        return $returnValue;
    }

    /**
     * Follow the provied user by the logged in user.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return array
     */
    public function setFollowUser()
    {
        $returnValue = array();

        // section -64--88-0-19-3d5b9cc5:161b8d6a9c4:-8000:0000000000001097 begin
	    if($this->isFollowingUser() == true):
		    if($this->unFollowUser() == true):

			        $returnValue['status'] = 'Un-followed';
			    else:

				    $returnValue['status'] = 'Failed to Un-follow';
		    endif;

	    else:
		    $this->Database = new Database();

	    /** Check if the user has already followed or un-followed user.  */
	    if($this->isFollowingUser(true) == true):
		    $sql = $this->Database->prepare("UPDATE follow_user SET status = 1, TIMESTAMP = ? WHERE follow_user_id = ? AND followers_id = ?");
		    $sql->execute( array(
			    date("Y-m-d H:i:s", time()),
			    $this->FollowedUserId,
			    $this->userId
		    ) );
	    else:
		    $sql = $this->Database->prepare("INSERT INTO follow_user (follow_user_id, followers_id, ip) VALUES (?,?,?)");
		    $sql->execute( array(
			    $this->FollowedUserId,
			    $this->userId,
			    $this->General->getUserIP()
		    ) );
	    endif;

		    if($sql->rowCount() > 0){
			    $returnValue['status'] = 'Following';
		    }else{
			    $returnValue['status'] = 'Failed to Follow';
		    }

	    endif;
        // section -64--88-0-19-3d5b9cc5:161b8d6a9c4:-8000:0000000000001097 end

        return (array) $returnValue;
    }

} /* end of class FollowUser */

?>