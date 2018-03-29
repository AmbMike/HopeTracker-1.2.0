<?php
/**
 * Copyright (c) 2017.
 */

error_reporting(E_ALL);

/**
 * Generate the SelfHelp for the day.
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
	die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-2--5acc9b5c:15fdac0d930:-8000:0000000000000CC7-includes begin
error_reporting( 0 );
require_once(CLASSES . 'Database.php');
// section -64--88-0-2--5acc9b5c:15fdac0d930:-8000:0000000000000CC7-includes end

/* user defined constants */
// section -64--88-0-2--5acc9b5c:15fdac0d930:-8000:0000000000000CC7-constants begin
// section -64--88-0-2--5acc9b5c:15fdac0d930:-8000:0000000000000CC7-constants end

/**
 * Generate the SelfHelp for the day.
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class DailySelfHelp
{
	// --- ASSOCIATIONS ---


	// --- ATTRIBUTES ---

	/**
	 * The total number of images stored in the  folder.
	 *
	 * @access public
	 * @var Integer
	 */
	public $SelfHelpQty = null;

	/**
	 * Short description of attribute currentTimeStampDb
	 *
	 * @access public
	 * @var Integer
	 */
	public $currentTimeStampDb = null;

	/**
	 * The current count for the SelfHelp to be shown for the day.
	 *
	 * @access public
	 * @var Integer
	 */
	public $currentSelfHelpCount = null;

	/**
	 * Stores the database object.
	 *
	 * @access private
	 * @var Array
	 */
	private $Database = null;

	/**
	 * Image path to the current SelfHelp image.
	 *
	 * @access public
	 * @var string
	 */
	public $currentImgPath = '';

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
		// section -64--88-0-2--5acc9b5c:15fdac0d930:-8000:0000000000000CD1 begin
		$this->SelfHelpQty = $this->setCount( '/site/public/images/self-help/');
		$this->currentTimeStampDb = $this->setCurrentTimeStampDb()['last_update_time'];
		$this->currentSelfHelpCount = $this->setCurrentTimeStampDb()['current_count'];
		$this->currentImgPath = $this->getCurrentImagePath('/site/public/images/self-help/');
		$this->setCurrentCount();

		// section -64--88-0-2--5acc9b5c:15fdac0d930:-8000:0000000000000CD1 end
	}

	/**
	 * Gets the last updated timestamp from the database.
	 *
	 * @access public
	 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
	 * @return Integer
	 */
	public function setCurrentTimeStampDb()
	{
		$returnValue = null;

		// section -64--88-0-2--5acc9b5c:15fdac0d930:-8000:0000000000000CEB begin
		$this->Database = new Database();

		$sql = $this->Database->prepare('SELECT last_update_time, current_count FROM daily_self_help  WHERE id = 1');
		$sql->setFetchMode( PDO::FETCH_ASSOC );
		$sql->execute(array(time()));

		/** @var  $returnValue : returns the time when the table was updated last */

		$returnValue = $sql->fetchAll()[0];


		// section -64--88-0-2--5acc9b5c:15fdac0d930:-8000:0000000000000CEB end

		return $returnValue;
	}

	/**
	 * Set the total count of images in the directory of the path proved in the
	 *
	 * @access public
	 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
	 * @param  dirPathToImages
	 * @return Integer
	 */
	public function setCount($dirPathToImages)
	{
		$returnValue = null;

		// section -64--88-0-2--5acc9b5c:15fdac0d930:-8000:0000000000000CD8 begin
		$SelfHelp_path = ABSPATH . $dirPathToImages;
		$SelfHelp_files = scandir($SelfHelp_path);
		$SelfHelp_files = array_diff(scandir($SelfHelp_path), array('.', '..'));

		$returnValue = count($SelfHelp_files);
		// section -64--88-0-2--5acc9b5c:15fdac0d930:-8000:0000000000000CD8 end

		return $returnValue;
	}

	/**
	 * Sets the current for the count for the category by the folder path. The
	 * that is currently being shown to the users.
	 *
	 * @access public
	 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
	 * @return Integer
	 */
	public function setCurrentCount()
	{
		$returnValue = null;

		// section -64--88-0-2--5acc9b5c:15fdac0d930:-8000:0000000000000CDA begin
		$this->Database = new Database();

		$now = $this->currentTimeStampDb;
		$fullDay = 86400;
		//$fullDay = 5;
		$timeDif = time() - $now;


		/** Increment the SelfHelp count if its' been more then a 24 hours. */
		if($timeDif > $fullDay){
			$sql = $this->Database->prepare('UPDATE daily_self_help SET last_update_time = ?,  current_count = current_count + 1 WHERE id = 1');
			$sql->execute(array(time()));
		}

		/** Update the current count in the database if the days lap over the total qty of SelfHelp images */
		if( $this->setCurrentTimeStampDb()['current_count'] >= $this->SelfHelpQty){
			$sql = $this->Database->prepare('UPDATE daily_self_help SET current_count = 0  WHERE id = 1');
			$sql->execute();
		}

		$returnValue = '';

		// section -64--88-0-2--5acc9b5c:15fdac0d930:-8000:0000000000000CDA end

		return $returnValue;
	}

	/**
	 * Gets the path to the current image.
	 *
	 * @access public
	 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
	 * @param  imgDirPath
	 * @return string
	 */
	public function getCurrentImagePath($imgDirPath)
	{
		$returnValue = (string) '';

		// section -64--88-0-2--5acc9b5c:15fdac0d930:-8000:0000000000000CEE begin
		$SelfHelp_path = ABSPATH . $imgDirPath;
		$SelfHelp_files = scandir($SelfHelp_path);
		$SelfHelp_files = array_diff(scandir($SelfHelp_path), array('.', '..'));

		$SelfHelp_files = array_values(array_filter($SelfHelp_files));

		$returnValue = $SelfHelp_files[$this->currentSelfHelpCount];

		// section -64--88-0-2--5acc9b5c:15fdac0d930:-8000:0000000000000CEE end

		return (string) $returnValue;
	}

} /* end of class DailySelfHelp */

?>