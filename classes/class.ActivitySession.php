<?php

error_reporting(E_ALL);

/**
 * The main  class for the activity sessions.
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-19--2a004ef2:161724d4927:-8000:0000000000000FA8-includes begin
error_reporting( 0 );
require_once(CLASSES . 'class.ActivitySessionItems.php');
require_once(CLASSES . 'class.ActivitySessionSkipped.php');

// section -64--88-0-19--2a004ef2:161724d4927:-8000:0000000000000FA8-includes end

/* user defined constants */
// section -64--88-0-19--2a004ef2:161724d4927:-8000:0000000000000FA8-constants begin
// section -64--88-0-19--2a004ef2:161724d4927:-8000:0000000000000FA8-constants end

/**
 * The main  class for the activity sessions.
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class ActivitySession
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * Total number of activity sessions.
     *
     * @access public
     * @var Integer
     */
    public $totalSessions = null;

    /**
     * An array of the session folders.
     *
     * @access public
     * @var array
     */
    public $sessionFolders = array();

    /**
     * Short description of attribute currentSession
     *
     * @access public
     * @var Integer
     */
    public $currentSession = null;

    /**
     * The general class.
     *
     * @access private
     * @var class
     */
    private $Database = null;

    /**
     * The General class.
     *
     * @access public
     * @var class
     */
    public $Sessions = null;

    /**
     * The logged in user's id.
     *
     * @access public
     * @var Integer
     */
    public $userId = null;

    /**
     * The ActivitySessionItems class.
     *
     * @access public
     * @var class
     */
    public $ActivityItems = null;

    /**
     * Short description of attribute General
     *
     * @access public
     * @var class
     */
    public $General = null;

    /**
     * the session skip class.
     *
     * @access public
     * @var class
     */
    public $SessionSkip = null;

    // --- OPERATIONS ---

    /**
     * Constructs the class.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return mixed
     */
    public function __construct()
    {
        // section -64--88-0-19--2a004ef2:161724d4927:-8000:0000000000000FB4 begin

	    $this->Sessions = new Sessions();
	    $this->General = new General();
	    $this->SessionSkip = new ActivitySessionSkipped();

	    if($this->Sessions->get('logged_in') == 1){
		    $this->userId = $this->Sessions->get( 'user-id' );
	    }else{
		    $this->userId = 0;
	    }
	    $this->ActivityItems = new ActivitySessionItems();
	    $this-> initializeUsersSession();
	    $this->sessionFolders = $this->getSessionsFolders();
	    $this->totalSessions = count($this->sessionFolders);
	    $this->currentSession = $this->getCurrentSession();

	    
        // section -64--88-0-19--2a004ef2:161724d4927:-8000:0000000000000FB4 end
    }

    /**
     * Gets the session folders and puts them into an array.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return array
     */
    public function getSessionsFolders()
    {
        $returnValue = array();

        // section -64--88-0-19--2a004ef2:161724d4927:-8000:0000000000000FB7 begin
	    $directory = ABSOLUTE_PATH_NO_END_SLASH . "/site/cwd/views/includes/course/";
	    $scanned_directory = array_diff(scandir($directory), array('..', '.','index.php','notes.txt'));

	    //$returnValue = array_values($scanned_directory);

	    /** Order array buy session number */
	    $orderedSessions = array();
	    foreach ($scanned_directory as $index => $session):
		    /** Separate the session from the session number.  */
		    $folderName = explode('-', $session);

			$orderedSessions[$index]['folder-name'] = $session;
			$orderedSessions[$index]['session-number'] = $folderName[1];
	    endforeach;

	    /** Sort array by array value */
	    if (!function_exists('sortByOrder')) {
		    function sortByOrder($a, $b) {
			    return $a['session-number'] - $b['session-number'];
		    }
	    }

	    usort($orderedSessions, 'sortByOrder');

	    $returnValue = $orderedSessions;
        // section -64--88-0-19--2a004ef2:161724d4927:-8000:0000000000000FB7 end

        return (array) $returnValue;
    }

    /**
     * Get the total number of activities for the provied session.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  session
     * @return Integer
     */
    public function getActivityCountPerSession($session)
    {
        $returnValue = null;

        // section -64--88-0-19-6f78336d:1617611e1c5:-8000:0000000000000FB8 begin

	    /** Path to the provided session directory.  */
	    $directory = ABSOLUTE_PATH_NO_END_SLASH . "/site/cwd/views/includes/course/" . $session;
	    $scanned_directory = array_diff(scandir($directory), array('..', '.','index.php','variables.php'));
	    $returnValue = count($scanned_directory );
        // section -64--88-0-19-6f78336d:1617611e1c5:-8000:0000000000000FB8 end

        return $returnValue;
    }

    /**
     * Updates the current session
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  updateValue
     * @return Boolean
     */
    public function updatedCurrentSession($updateValue)
    {
        $returnValue = null;

        // section -64--88-0-19-6f78336d:1617611e1c5:-8000:0000000000000FF4 begin
	    $this->Database = new Database();

	    /** Check if user's session has already been initialized.  */
	    $sql = $this->Database->prepare( "UPDATE activity_session SET current_session = ? WHERE userId = ?" );
	    $sql->execute(array(
	    	$updateValue,
	    	$this->userId
	    ));
	    if($sql->rowCount() > 0){
		    return true;
	    }
        // section -64--88-0-19-6f78336d:1617611e1c5:-8000:0000000000000FF4 end

        return $returnValue;
    }

    /**
     * Check if the session is complete, by checking if all the activities are
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  session
     * @return Boolean
     */
    public function isSessionComplete($session)
    {
        $returnValue = null;

        // section -64--88-0-19-6f78336d:1617611e1c5:-8000:0000000000000FEC begin

	    $currentSessionFolder = 'session-' . $this->getCurrentSession();

	    if($this->getActivityCountPerSession($currentSessionFolder) == $this->ActivityItems->totalCompleteActivitiesPerSession($session)):

		    $updatedSessionValue = $this->getCurrentSession() + 1;
		    $this->updatedCurrentSession($updatedSessionValue);
		    $returnValue = true;
	    else:
		    $returnValue = false;
	    endif;

        // section -64--88-0-19-6f78336d:1617611e1c5:-8000:0000000000000FEC end

        return $returnValue;
    }

    /**
     * Starts the users session if it has not already been set.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return mixed
     */
    public function initializeUsersSession()
    {
        // section -64--88-0-19-6f78336d:1617611e1c5:-8000:0000000000000FE7 begin
	    $this->Database = new Database();

	    /** Check if user's session has already been initialized.  */
	    $sql = $this->Database->prepare( "SELECT id FROM activity_session WHERE userId = ? " );
	    $sql->execute(array( $this->userId));

	    /**  Create the first session for the user. */
	    if($sql->rowCount() == 0):
		    $sql = $this->Database->prepare( "INSERT INTO activity_session (userId, last_updated) VALUES(?,?)" );
		    $sql->execute(array(
			    $this->userId,
			    time()
		    ));
		    else:

		    /** Check if the current session has been skipped */

		        /** Get the current session  number */
			    $sql = $this->Database->prepare( "SELECT current_session FROM activity_session WHERE userId = ?" );
			    $sql->execute(array($this->userId));
			    $currentSession = $sql->fetchColumn();

			    /** Check if it's been skipped */
			    if($this->SessionSkip->isSessionSkipped( $currentSession ) == true){

			    	/** Get the latest skipped session and increment up 1 to set next session after last skipped session. */
			    	$latestSkippedSession = $this->SessionSkip->getAllSkippedSessions();
				    $highestSession = max($latestSkippedSession);
				    $highestSession++;


				    /** updated the session */
				    $this->updatedCurrentSession( $highestSession );
			    }
	    endif;

	    /** Updated current session if all activities are complete for the provided session. */
	    $this->isSessionComplete($this->getCurrentSession());


        // section -64--88-0-19-6f78336d:1617611e1c5:-8000:0000000000000FE7 end
    }

    /**
     * Resets the provided user's session and completed tasks.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  userId
     * @return mixed
     */
    public function resetSession($userId)
    {
        // section -64--88-0-19--66c49ab2:1617b8e0c32:-8000:0000000000001007 begin
	    require_once(CLASSES . 'Admin.php');
	   $Admin  = new Admin();
	    if($Admin->is_admin($userId) == true){

		    if($this->updatedCurrentSession(1) == true && $this->ActivityItems->deleteActivities() == true && $this->SessionSkip->deleteSkippedSessions() == true){
			    return true;
		    }


	    }
        // section -64--88-0-19--66c49ab2:1617b8e0c32:-8000:0000000000001007 end
    }

    /**
     * Get the session status for the logged in user. NOTE: 1 = current
     * 2 = skipped, 3 = complete session.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return Integer
     */
    public function sessionStatus()
    {
        $returnValue = null;

        // section -64--88-0-19-62acb0f1:1618a8e2f28:-8000:0000000000001015 begin
	    $this->Database = new Database();

	    $sql = $this->Database->prepare( "SELECT status FROM activity_session WHERE userId = ? " );
	    $sql->execute(array( $this->userId));

	    $returnValue = $sql->fetchColumn();
        // section -64--88-0-19-62acb0f1:1618a8e2f28:-8000:0000000000001015 end

        return $returnValue;
    }

    /**
     * Updated the logged in user's session status.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  statusValue
     * @return Boolean
     */
    public function updateSessionStatus($statusValue = false)
    {
        $returnValue = null;

        // section -64--88-0-19-62acb0f1:1618a8e2f28:-8000:0000000000001018 begin
	    $this->Database = new Database();

	    /** Updated the session status */
	    $sql = $this->Database->prepare( "UPDATE activity_session SET status = ? WHERE userId = ? " );
	    $sql->execute(array( $statusValue,$this->userId));

	    /** Updated the current session data. */
	    if($statusValue == 2){
	    	$this->currentSession++;

		    $sql = $this->Database->prepare( "UPDATE activity_session SET current_session = ? WHERE userId = ? " );
		    $sql->execute(array( $this->currentSession,$this->userId));
	    }

	    if($sql->rowCount() > 0){
		    $returnValue = true;
	    }

        // section -64--88-0-19-62acb0f1:1618a8e2f28:-8000:0000000000001018 end

        return $returnValue;
    }

    /**
     * Gets the current session number the user is on.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return Integer
     */
    public function getCurrentSession()
    {
        $returnValue = null;

        // section -64--88-0-19-6f78336d:1617611e1c5:-8000:0000000000000FD8 begin
	    $this->Database = new Database();

	    $sql = $this->Database->prepare( "SELECT current_session FROM activity_session WHERE userId = ?" );
	    $sql->execute(array($this->userId));

	    $returnValue = $sql->fetchColumn();
        // section -64--88-0-19-6f78336d:1617611e1c5:-8000:0000000000000FD8 end

        return $returnValue;
    }

} /* end of class ActivitySession */

?>