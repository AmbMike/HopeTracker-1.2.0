<?php

error_reporting(E_ALL);

/**
 * Hands the journal post data.
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-2--2405a564:15f260ff61f:-8000:0000000000000B9E-includes begin
error_reporting(0);
include_once(CLASSES . 'Database.php');
include_once(CLASSES . 'Sessions.php');
include_once(CLASSES . 'User.php');

// section -64--88-0-2--2405a564:15f260ff61f:-8000:0000000000000B9E-includes end

/* user defined constants */
// section -64--88-0-2--2405a564:15f260ff61f:-8000:0000000000000B9E-constants begin
// section -64--88-0-2--2405a564:15f260ff61f:-8000:0000000000000B9E-constants end

/**
 * Hands the journal post data.
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class JournalPosts
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * Database Object
     *
     * @access private
     * @var array
     */
    private $Database = array();

    /**
     * Short description of attribute Sessions
     *
     * @access private
     * @var Integer
     */
    private $Sessions = null;

    /**
     * Short description of attribute userId
     *
     * @access private
     * @var Integer
     */
    private $userId = null;

    /**
     * General Class.
     *
     * @access public
     * @var array
     */
    public $General = array();

    // --- OPERATIONS ---

    /**
     * Construct the Class.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return mixed
     */
    public function __construct()
    {
        // section -64--88-0-19--cd56f47:160ff96a03b:-8000:0000000000000EF1 begin
	    $this->Sessions = new Sessions();
	    $this->General = new General();

	    if($this->Sessions->get('logged_in') == 1){
	        $this->userId = $this->Sessions->get( 'user-id' );
	    }

        // section -64--88-0-19--cd56f47:160ff96a03b:-8000:0000000000000EF1 end
    }

    /**
     * Get the most recent journals
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  qty Number of slides to display.
     * @param  userId
     * @return array
     */
    public function getLatestPosts($qty = 10, $userId = false)
    {
        $returnValue = array();

        // section -64--88-0-2--2405a564:15f260ff61f:-8000:0000000000000BA4 begin
        $this->Database = new Database();
        if($userId == false){
	        $sql = $this->Database->prepare("SELECT * FROM hopetrac_main.journal_entries WHERE status = 1 ORDER BY id DESC LIMIT 0, :rows");
	        $sql->setFetchMode(PDO::FETCH_ASSOC);
	        $sql->bindParam(':rows', $qty, PDO::PARAM_INT);
	        $sql->execute();
        }else{
	        $sql = $this->Database->prepare("SELECT * FROM hopetrac_main.journal_entries WHERE user_id = :userId AND status = 1 ORDER BY id DESC LIMIT 0, :rows");
	        $sql->setFetchMode(PDO::FETCH_ASSOC);
	        $sql->bindParam(':rows', $qty, PDO::PARAM_INT);
	        $sql->bindParam(':userId', $userId, PDO::PARAM_INT);
	        $sql->execute();
        }

        $returnValue = $sql->fetchAll();
        // section -64--88-0-2--2405a564:15f260ff61f:-8000:0000000000000BA4 end

        return (array) $returnValue;
    }

    /**
     * Get a single post.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  postId
     * @return array
     */
    public function getSinglePost($postId)
    {
        $returnValue = array();

        // section -64--88-0-19--cd56f47:160ff96a03b:-8000:0000000000000EFB begin

	    $this->Database = new Database();

	    
	    $sql = $this->Database->prepare("SELECT * FROM journal_entries WHERE id = ? ORDER BY id DESC LIMIT 1");
	    $sql->setFetchMode(PDO::FETCH_ASSOC);
	    $sql->execute(array($postId));

	    $returnValue = $sql->fetch();
        // section -64--88-0-19--cd56f47:160ff96a03b:-8000:0000000000000EFB end

        return (array) $returnValue;
    }

    /**
     * Store journal post with only text from user. Return json value.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  content
     * @return array
     */
    public function storePostLite($content)
    {
        $returnValue = array();

        // section -64--88-0-19--cd56f47:160ff96a03b:-8000:0000000000000EE7 begin
	    $this->Database = new Database();


	    $time =  time();
	    $sql = $this->Database->prepare("INSERT INTO journal_entries (user_id, created_entry, content, ip) VALUES (?,?,?,?)");
	    $sql->execute(array(
	    	$this->userId,
		    $time,
		    $content,
		    $this->General->getUserIP()

	    ));

	    $ajaxOut = array();

	    if($sql->rowCount() > 0){

		    include_once( CLASSES . 'User.php' );
		    $User = new User();

		    $postId = $this->Database->lastInsertId();

	    	$postData = $this->getSinglePost($postId);
		    date_default_timezone_set('America/New_York');
	        $ajaxOut['status'] = 'Successful';
	        $ajaxOut['userId'] = $this->userId;
	        $ajaxOut['usernameUrl'] = $this->General->url_safe_string(User::Username($this->userId));
	        $ajaxOut['usernameFormatted'] = User::Username($this->userId);
	        $ajaxOut['entryDate'] = date('j F Y H:i', $time);
	        $ajaxOut['state'] = User::user_info('state', $this->userId);
	        $ajaxOut['zip'] = User::user_info('zip', $this->userId);
	        $ajaxOut['postId'] = $postId;
		    $ajaxOut['userProfile'] = $User->get_user_profile_img( false, $this->userId );

	    }else{
		    $ajaxOut['status'] = 'Failed';
	    }

	    echo json_encode( $ajaxOut );
        // section -64--88-0-19--cd56f47:160ff96a03b:-8000:0000000000000EE7 end

        return (array) $returnValue;
    }

    /**
     * Check if the user has a drafted post.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return Boolean
     */
    public function hasDraftJournal()
    {
        $returnValue = null;

        // section -64--88-0-19--258c3043:16134469c36:-8000:0000000000000F22 begin
	    $this->Database = new Database();

	    $sql = $this->Database->prepare("SELECT id FROM journal_entries WHERE status = 2 AND user_id = ?");
	    $sql->execute(array($this->userId));

	    if($sql->rowCount() > 0){
	    	$returnValue = true;
	    }else{
	    	$returnValue = false;
	    }

        // section -64--88-0-19--258c3043:16134469c36:-8000:0000000000000F22 end

        return $returnValue;
    }

    /**
     * Get the drafted post data.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return array
     */
    public function getDraftJournal()
    {
        $returnValue = array();

        // section -64--88-0-19--258c3043:16134469c36:-8000:0000000000000F20 begin
	    $this->Database = new Database();

	    $sql = $this->Database->prepare("SELECT * FROM journal_entries WHERE status = 2 AND user_id = ? LIMIT 1");
	    $sql->setFetchMode( PDO::FETCH_ASSOC );
	    $sql->execute(array($this->userId));

	    $returnValue = $sql->fetch();
        // section -64--88-0-19--258c3043:16134469c36:-8000:0000000000000F20 end

        return (array) $returnValue;
    }

} /* end of class JournalPosts */

?>