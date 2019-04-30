<?php

error_reporting(E_ALL);

/**
 * Generate the quote for the day.
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
require_once(CLASSES . 'class.DailySelfHelp.php');
// section -64--88-0-2--5acc9b5c:15fdac0d930:-8000:0000000000000CC7-includes end

/* user defined constants */
// section -64--88-0-2--5acc9b5c:15fdac0d930:-8000:0000000000000CC7-constants begin
// section -64--88-0-2--5acc9b5c:15fdac0d930:-8000:0000000000000CC7-constants end

/**
 * Generate the quote for the day.
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class DailyQuote
{
	// --- ASSOCIATIONS ---


	// --- ATTRIBUTES ---

	/**
	 * The total number of images stored in the  folder.
	 *
	 * @access public
	 * @var Integer
	 */
	public $quoteQty = null;

	/**
	 * Short description of attribute currentTimeStampDb
	 *
	 * @access public
	 * @var Integer
	 */
	public $currentTimeStampDb = null;

	/**
	 * The current count for the quote to be shown for the day.
	 *
	 * @access public
	 * @var Integer
	 */
	public $currentQuoteCount = null;

	/**
	 * Stores the database object.
	 *
	 * @access private
	 * @var Array
	 */
	private $Database = null;

	/**
	 * Image path to the current quote image.
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

	/** Var to hold the Daily Self Help class */
	public $DailySelfHelp = '';

    public $imageDirectory = 'quotes';

	public function __construct()
	{
		// section -64--88-0-2--5acc9b5c:15fdac0d930:-8000:0000000000000CD1 begin

        $this->DailySelfHelp = new DailySelfHelp();
		$this->quoteQty = $this->setCount( '/site/public/images/quotes/');
		$this->currentTimeStampDb = $this->setCurrentTimeStampDb()['last_update_time'];
		$this->currentQuoteCount = $this->setCurrentTimeStampDb()['current_count'];
        $this->setImageDirectory();
		$this->currentImgPath = $this->getCurrentImagePath('/site/public/images/' . $this->imageDirectory . '/');
		$this->setCurrentCount();

		// section -64--88-0-2--5acc9b5c:15fdac0d930:-8000:0000000000000CD1 end
	}

	/** Set the value for the image directory according to wither the count is over total image in the quote directory */
	public function setImageDirectory(){
	    if($this->quoteQty > $this->currentQuoteCount){
            $this->imageDirectory = 'quotes';

        }elseif($this->DailySelfHelp->SelfHelpQty > $this->currentQuoteCount - $this->quoteQty){
            $this->imageDirectory = 'self-help';
            $this->currentQuoteCount = $this->currentQuoteCount - $this->quoteQty;
        }

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

		$sql = $this->Database->prepare('SELECT last_update_time, current_count FROM daily_quote  WHERE id = 1');
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
		$quote_path = ABSPATH . $dirPathToImages;
		$quote_files = scandir($quote_path);
		$quote_files = array_diff(scandir($quote_path), array('.', '..'));

		$returnValue = count($quote_files);
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
		$timeDif = time() - $now;


		/** Increment the quote count if its' been more then a 24 hours. */
		if($timeDif > $fullDay){
			$sql = $this->Database->prepare('UPDATE daily_quote SET last_update_time = ?,  current_count = current_count + 1 WHERE id = 1');
			$sql->execute(array(time()));
		}

		/** Update the current count in the database if the days lap over the total qty of quote images */
		/** If the count is more than the total images in the daily-quote folder, start showing images from the daily-self-help folder */
		if( $this->setCurrentTimeStampDb()['current_count'] >= $this->quoteQty + $this->DailySelfHelp->SelfHelpQty){
			$sql = $this->Database->prepare('UPDATE daily_quote SET current_count = 0  WHERE id = 1');
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
		$quote_path = ABSPATH . $imgDirPath;
		$quote_files = array_diff(scandir($quote_path), array('.', '..'));

		$quote_files = array_values(array_filter($quote_files));
		$returnValue = $quote_files[$this->currentQuoteCount];

		// section -64--88-0-2--5acc9b5c:15fdac0d930:-8000:0000000000000CEE end
		return (string) $returnValue;
	}

} /* end of class DailyQuote */

?>