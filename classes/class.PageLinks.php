<?php

error_reporting(E_ALL);

/**
 * Constant links for page specific locations.
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
	die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000EF0-includes begin
// section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000EF0-includes end

/* user defined constants */
// section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000EF0-constants begin
// section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000EF0-constants end

/**
 * Constant links for page specific locations.
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class PageLinks
{
	// --- ASSOCIATIONS ---


	// --- ATTRIBUTES ---

	/**
	 * The general class object.
	 *
	 * @access public
	 * @var object
	 */
	public static $General = null;

	/**
	 * The user class object.
	 *
	 * @access public
	 * @var object
	 */
	public static $User = null;

	// --- OPERATIONS ---

	/**
	 * Construct the class.
	 * \
	 *
	 * @access public
	 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
	 * @return mixed
	 */
	public function __construct()
	{
		// section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000EFD begin

		// section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000EFD end
	}

	/**
	 * Onclick function to take users to a the user's profile with user id
	 *
	 * @access public
	 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
	 * @param  userId
	 * @return String
	 */
	public static function userProfile($userId)
	{
		$returnValue = null;

		// section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000EF4 begin
		$User = new User();
		$General = new General();
		$returnValue = 'onclick="window.location=\'/'.RELATIVE_PATH.'families-of-drug-addicts/user-'. $userId .'/'. $General->url_safe_string($User->Username($userId)).'\'" role="button"';
		// section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000EF4 end

		return $returnValue;
	}

} /* end of class PageLinks */

?>