<?php

error_reporting(E_ALL);

/**
 * Controls the user profile path.
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
	die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-19-3d5b9cc5:161b8d6a9c4:-8000:000000000000107A-includes begin
error_reporting( 0 );
include_once( CLASSES . 'General.php' );
include_once( CLASSES . 'User.php' );
// section -64--88-0-19-3d5b9cc5:161b8d6a9c4:-8000:000000000000107A-includes end

/* user defined constants */
// section -64--88-0-19-3d5b9cc5:161b8d6a9c4:-8000:000000000000107A-constants begin
// section -64--88-0-19-3d5b9cc5:161b8d6a9c4:-8000:000000000000107A-constants end

/**
 * Controls the user profile path.
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class UserProfile
{
	// --- ASSOCIATIONS ---


	// --- ATTRIBUTES ---

	/**
	 * The user Class.
	 *
	 * @access public
	 * @var class
	 */
	public $User = null;

	/**
	 * The General Class.
	 *
	 * @access public
	 * @var class
	 */
	public $General = null;

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
		// section -64--88-0-19-3d5b9cc5:161b8d6a9c4:-8000:0000000000001081 begin
		$this->General = new General();
		$this->User = new User();
		// section -64--88-0-19-3d5b9cc5:161b8d6a9c4:-8000:0000000000001081 end
	}

	/**
	 * This function takes in the provided user id an creates an onclick
	 * to take the user to the provided user's profile page.
	 *
	 * @access public
	 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
	 * @param  userId
	 * @return String
	 */
	public function profile($userId)
	{
		$returnValue = null;

		// section -64--88-0-19-3d5b9cc5:161b8d6a9c4:-8000:0000000000001083 begin

		include_once(CLASSES . 'Sessions.php');
		$Sessions = new Sessions();

		if($userId == $Sessions->get('user-id')){
			/** User's profile page */
			$returnValue = 'onclick="window.location=\'/'.RELATIVE_PATH.'profile/\'" role="button"';


		}else{
			/** Not logged in user */
			$returnValue = 'onclick="window.location=\'/'.RELATIVE_PATH.'families-of-drug-addicts/user-'. $userId .'/'. $this->General->url_safe_string($this->User->Username($userId)).'\'" role="button"';

		}
		// $returnValue = 'onclick="window.location='.RELATIVE_PATH.'\'/profile/user-'. $userId .'/'. $this->General->url_safe_string($this->User->Username($userId)).'\'" role="button"';

		// section -64--88-0-19-3d5b9cc5:161b8d6a9c4:-8000:0000000000001083 end

		return $returnValue;
	}

} /* end of class UserProfile */

?>