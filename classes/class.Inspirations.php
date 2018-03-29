<?php

error_reporting(E_ALL);

/**
 * untitledModel - class.Inspirations.php
 *
 * $Id$
 *
 * This file is part of untitledModel.
 *
 * Automatically generated on 06.02.2018, 12:18:47 with ArgoUML PHP module
 * (last revised $Date: 2010-01-12 20:14:42 +0100 (Tue, 12 Jan 2010) $)
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
	die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-19--66235678:1614d8229ff:-8000:0000000000000F25-includes begin
error_reporting( 3 );
include_once( CLASSES . 'Sessions.php' );
// section -64--88-0-19--66235678:1614d8229ff:-8000:0000000000000F25-includes end

/* user defined constants */
// section -64--88-0-19--66235678:1614d8229ff:-8000:0000000000000F25-constants begin
// section -64--88-0-19--66235678:1614d8229ff:-8000:0000000000000F25-constants end

/**
 * Short description of class Inspirations
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class Inspirations
{
	// --- ASSOCIATIONS ---


	// --- ATTRIBUTES ---

	/**
	 * The class for the like status.
	 *
	 * @access public
	 * @var Obect
	 */
	public $LikeInspiration = null;

	/**
	 * The logged in users id.
	 *
	 * @access public
	 * @var Integer
	 */
	public $userId = null;

	/**
	 * The class variable.
	 *
	 * @access public
	 * @var class
	 */
	public $Sessions = null;

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
		// section -64--88-0-19-7e49dca8:1616bfa9dd6:-8000:0000000000000FAE begin
		$this->Sessions = new Sessions();

		if($this->Sessions->get('logged_in') == 1){
			$this->userId = $this->Sessions->get( 'user-id' );
		}else{
			$this->userId = 0;
		}

		// section -64--88-0-19-7e49dca8:1616bfa9dd6:-8000:0000000000000FAE end
	}

	/**
	 * Get quote files
	 *
	 * @access public
	 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
	 * @return array
	 */
	public function getQuotes()
	{
		$returnValue = array();

		// section -64--88-0-19--66235678:1614d8229ff:-8000:0000000000000F29 begin
		/**  $quote_path */
		$quote_path = ABSPATH . '/site/public/images/quotes/';
		$quote_files = scandir($quote_path);
		$quote_files = array_diff(scandir($quote_path), array('.', '..'));
		$quote_files = array_values(array_filter($quote_files));

		$returnValue = $quote_files;
		// section -64--88-0-19--66235678:1614d8229ff:-8000:0000000000000F29 end

		return (array) $returnValue;
	}

	/**
	 * Get self-help files
	 *
	 * @access public
	 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
	 * @return array
	 */
	public function getSelfHelp()
	{
		$returnValue = array();

		// section -64--88-0-19--66235678:1614d8229ff:-8000:0000000000000F2B begin


		/**  $quote_path */
		$self_help_path = ABSPATH . '/site/public/images/self-help/';
		$self_help_files = scandir($self_help_path);
		$self_help_files = array_diff(scandir($self_help_path), array('.', '..'));
		$self_help_files = array_values(array_filter($self_help_files));

		$returnValue = $self_help_files;
		// section -64--88-0-19--66235678:1614d8229ff:-8000:0000000000000F2B end

		return (array) $returnValue;
	}

	/**
	 * Get all the inspirations.
	 *
	 * @access public
	 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
	 * @param  filter
	 * @return array
	 */
	public function getInspirations($filter = false)
	{
		$returnValue = array();

		// section -64--88-0-19--66235678:1614d8229ff:-8000:0000000000000F26 begin

		/** @var  $quotes_out : the array of paths of quotes images */
		$quotes_out = array();
		if($filter  != 'self-help'):
			foreach ( $this->getQuotes() as $quote ) {
				$quotes_out[] = 'quotes/' . $quote;
			}
		endif;


		/** @var  $quotes_out : the array of paths of quotes images */
		$self_help_out = array();

		if($filter  != 'quotes'):
			foreach ( $this->getSelfHelp() as $self_help ) {
				$self_help_out[] = 'self-help/' . $self_help;
			}
		endif;

		/** @var  $all_inspirations  : an array of both the types of inspirations image paths*/
		$all_inspirations = array_merge($quotes_out,$self_help_out);


		/** Set the like status for each image */
		include_once(CLASSES . 'class.likeInspiration.php');

		$newArr = array();
		foreach($all_inspirations as $key => $inspiration){
			$pathArr = explode('/',$inspiration);

			$LikeInspirations = new likeInspiration($pathArr[0],$pathArr[1]);
			$newArr[$key]['liked'] = $LikeInspirations->checkLikedImage();
			$newArr[$key]['imagePath'] = $inspiration;
			$newArr[$key]['likeCount'] = $LikeInspirations->totalLikes();

			/** Get the modified date for each image. */
			$filename = $_SERVER['DOCUMENT_ROOT'].'/site/public/images/' . $inspiration;
			$newArr[$key]['uploadedDate'] =  filemtime($filename);
		}

		/** If the images are to be sorted by newest or oldest */
		if($filter != false ){
			function sortByOrder($a, $b) {
				return $a['uploadedDate'] - $b['uploadedDate'];
			}
			switch ($filter):
				case 'newest':
					usort($newArr, 'sortByOrder');
					$newArr =  array_reverse($newArr);
					break;
				case 'oldest':
					usort($newArr, 'sortByOrder');
					break;
				case 'random':
					shuffle ($newArr);
					break;
				case 'liked':
					$LikeInspirations = new likeInspiration(false,false);
					/** Rerun foreach to generate the out date for liked images by the user */
					$newArr = array();
					foreach($LikeInspirations->likedImages($this->userId) as $key => $inspiration):

						$LikeInspirations = new likeInspiration($inspiration['folder'],$inspiration['file_name']);
						$newArr[$key]['liked'] = $LikeInspirations->checkLikedImage();
						$newArr[$key]['imagePath'] = $inspiration['folder'] .'/'.$inspiration['file_name'];
						$newArr[$key]['likeCount'] = $LikeInspirations->totalLikes();

						/** Get the modified date for each image. */
						$filename = 'site/public/images/' . $inspiration['folder'] .'/'.$inspiration['file_name'];
						$newArr[$key]['uploadedDate'] =  filemtime($filename);
					endforeach;

					break;

			endswitch;
		}
		$returnValue = $newArr;

		// section -64--88-0-19--66235678:1614d8229ff:-8000:0000000000000F26 end

		return (array) $returnValue;
	}

} /* end of class Inspirations */

?>