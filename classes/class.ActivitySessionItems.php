<?php

error_reporting(E_ALL);

/**
 * Handles the activites for the course sessions.
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-19-6f78336d:1617611e1c5:-8000:0000000000000FBC-includes begin
error_reporting( 3 );
require_once('Sessions.php');
require_once('Database.php');
require_once('General.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/hopetracker/config/constants.php');
// section -64--88-0-19-6f78336d:1617611e1c5:-8000:0000000000000FBC-includes end

/* user defined constants */
// section -64--88-0-19-6f78336d:1617611e1c5:-8000:0000000000000FBC-constants begin
// section -64--88-0-19-6f78336d:1617611e1c5:-8000:0000000000000FBC-constants end

/**
 * Handles the activites for the course sessions.
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class ActivitySessionItems
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * The database class.
     *
     * @access private
     * @var class
     */
    private $Database = null;

    /**
     * The sessions class.
     *
     * @access public
     * @var class
     */
    public $Sessions = null;

    /**
     * The general class.
     *
     * @access public
     * @var class
     */
    public $General = null;

    /**
     * The logged in users id
     *
     * @access public
     * @var Integer
     */
    public $userId = null;

    /**
     * Total number of all activities.
     *
     * @access public
     * @var Integer
     */
    public $totalActivities = null;

    /**
     * Total number of all complete activities.
     *
     * @access public
     * @var Integer
     */
    public $totalCompleteActivities = null;

    /**
     * The Activitiy Session class.
     *
     * @access public
     * @var class
     */
    public $ActivitySession = null;

    // --- OPERATIONS ---

    /**
     * Short description of method __construct
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return mixed
     */
    public function __construct()
    {
        // section -64--88-0-19-6f78336d:1617611e1c5:-8000:0000000000000FBF begin

	    $this->Sessions = new Sessions();
	    $this->General = new General();

	    /** Set the user's id */
	    if($this->Sessions->get('logged_in') == 1){
		    $this->userId = $this->Sessions->get( 'user-id' );
	    }else{
		    $this->userId = 0;
	    }

	    $this->totalCompleteActivities = $this->getTotalActivities(true);
	    $this->totalActivities = $this->getTotalActivities();


        // section -64--88-0-19-6f78336d:1617611e1c5:-8000:0000000000000FBF end
    }

    /**
     * Gets the total number of complete activities for the provied session.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  session
     * @return Integer
     */
    public function totalCompleteActivitiesPerSession($session)
    {
        $returnValue = null;

        // section -64--88-0-19-6f78336d:1617611e1c5:-8000:0000000000000FC1 begin
	    $this->Database = new Database();
	    $sql = $this->Database->prepare("SELECT count(*) FROM course_sessions WHERE user_id = ? AND session_number = ? ");
	    $sql->execute(array(
	    	$this->userId,
		    $session
	    ));
	    $returnValue = $sql->fetchColumn();
        // section -64--88-0-19-6f78336d:1617611e1c5:-8000:0000000000000FC1 end

        return $returnValue;
    }

    /**
     * Get the total number of activities available to the user. OPTIONAL - add
     * to parameter to show all complete activities by the user.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  complete
     * @return Integer
     */
    public function getTotalActivities($complete = false)
    {
        $returnValue = null;

        // section -64--88-0-19-6f78336d:1617611e1c5:-8000:0000000000001004 begin
	    $this->Database = new Database();

	    if($complete == true):
		    $Database = new Database();

		    $sql = $Database->prepare("SELECT count(DISTINCT session_pos, course_id) FROM course_sessions WHERE user_id = ?");
		    $sql->execute(array($this->userId));

		    $returnValue = $sql->fetchColumn();

	    else:
		    /**
		     * Get all the folders for each session.
		     * Path to the provided session directory.
		     */
		    $directory = ABSOLUTE_PATH_NO_END_SLASH . "/site/public/views/includes/course/";
		    $scanned_directory = array_diff(scandir($directory), array('..', '.','index.php','notes.txt'));

		    /**
		     * Put all the sessions activities into an array.
		     */
		    foreach ($scanned_directory as $index => $session_directory):
			    $directory = ABSOLUTE_PATH_NO_END_SLASH . "/site/public/views/includes/course/" . $session_directory;
			    $scanned_activity_directory = array_diff(scandir($directory), array('..', '.','index.php','variables.php'));

			    $returnValue[$index] = $scanned_activity_directory;
		    endforeach;

		    $returnValue = array_values( $returnValue );

		    $returnValue = count($this->General->array_flatten($returnValue));


	    endif;

        // section -64--88-0-19-6f78336d:1617611e1c5:-8000:0000000000001004 end

        return $returnValue;
    }

    /**
     * Check if the provided activity is complete.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  session
     * @param  activityPosition
     * @return Boolean
     */
    public function isActivityComplete($session, $activityPosition)
    {
        $returnValue = null;

        // section -64--88-0-19--66c49ab2:1617b8e0c32:-8000:0000000000001002 begin
	    $this->Database = new Database();
	    $sql = $this->Database->prepare("SELECT count(*) FROM course_sessions WHERE user_id = ? AND session_number = ? AND session_pos = ? ");
	    $sql->execute(array(
		    $this->userId,
		    $session,
		    $activityPosition
	    ));
	    if($sql->fetchColumn() > 0){
		    $returnValue = true;
	    }else{
		    $returnValue = false;
	    }
	    //Debug::data($activityPosition);
        // section -64--88-0-19--66c49ab2:1617b8e0c32:-8000:0000000000001002 end

        return $returnValue;
    }

    /**
     * Delete all completed activities.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return mixed
     */
    public function deleteActivities()
    {
        // section -64--88-0-19--66c49ab2:1617b8e0c32:-8000:0000000000001010 begin
	    require_once(CLASSES .  'Admin.php');
	    $Admin = new Admin();

	    $this->Database = new Database();
	    if($Admin->is_admin($this->userId) == true){
	    	$sql = $this->Database->prepare("DELETE FROM course_sessions WHERE user_id = ?");
	    	$sql->execute(array($this->userId));

	    	if($sql->rowCount() > 0){
	    		return true;
		    }
	    }
        // section -64--88-0-19--66c49ab2:1617b8e0c32:-8000:0000000000001010 end
    }

} /* end of class ActivitySessionItems */

?>