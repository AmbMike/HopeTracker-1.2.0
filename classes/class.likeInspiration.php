<?php

error_reporting(E_ALL);

/**
 * untitledModel - class.likeInspiration.php
 *
 * $Id$
 *
 * This file is part of untitledModel.
 *
 * Automatically generated on 06.02.2018, 12:12:39 with ArgoUML PHP module 
 * (last revised $Date: 2010-01-12 20:14:42 +0100 (Tue, 12 Jan 2010) $)
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-19--66235678:1614d8229ff:-8000:0000000000000F2F-includes begin
error_reporting( 0 );
require_once(CLASSES . 'Database.php');
require_once(CLASSES . 'General.php');
require_once(CLASSES . 'Sessions.php');
// section -64--88-0-19--66235678:1614d8229ff:-8000:0000000000000F2F-includes end

/* user defined constants */
// section -64--88-0-19--66235678:1614d8229ff:-8000:0000000000000F2F-constants begin
// section -64--88-0-19--66235678:1614d8229ff:-8000:0000000000000F2F-constants end

/**
 * Short description of class likeInspiration
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class likeInspiration
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * Session Class.
     *
     * @access public
     * @var object
     */
    public $Sessions = null;

    /**
     * General Class
     *
     * @access public
     * @var object
     */
    public $General = null;

    /**
     * Database Class
     *
     * @access private
     * @var object
     */
    private $Database = null;

    /**
     * name of the image filename that is being liked.
     *
     * @access public
     * @var string
     */
    public $filename = '';

    /**
     * the folder back from the image file name that the image belongs to.
     *
     * @access public
     * @var string
     */
    public $folder = '';

    /**
     * The user's id.
     *
     * @access public
     * @var Integer
     */
    public $userId = null;

    /**
     * The full path to the image.
     *
     * @access public
     * @var string
     */
    public $imageFullPath = '';

    // --- OPERATIONS ---

    /**
     * Construct the class.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  folder
     * @param  filename
     * @return mixed
     */
    public function __construct($folder, $filename)
    {
        // section -64--88-0-19--66235678:1614d8229ff:-8000:0000000000000F48 begin
	    $this->folder = $folder;
	    $this->filename = $filename;
	    $this->General = new General();
	    $this->Sessions = new Sessions();

	    if($this->Sessions->get('logged_in') == 1){
		    $this->userId = $this->Sessions->get( 'user-id' );
	    }else{
	    	$this->userId = 0;
	    }

        // section -64--88-0-19--66235678:1614d8229ff:-8000:0000000000000F48 end
    }

    /**
     * Check if the user has liked the image already.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return Boolean
     */
    public function checkLikedImage()
    {
        $returnValue = null;

        // section -64--88-0-19--66235678:1614d8229ff:-8000:0000000000000F4B begin
	    $this->Database = new Database();
	    $sql = $this->Database->prepare("SELECT id FROM liked_inspiration WHERE user_id = ? AND folder = ? AND file_name = ? ");
	    $sql->execute( array(
	    	$this->userId,
		    $this->folder,
		    $this->filename
	    ));
	    if($sql->rowCount() > 0){
	    	$returnValue = true;
	    }else{
	    	$returnValue = false;
	    }
        // section -64--88-0-19--66235678:1614d8229ff:-8000:0000000000000F4B end

        return $returnValue;
    }

    /**
     * Unset the image as liked.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return mixed
     */
    public function unsetLikedImage()
    {
        // section -64--88-0-19--66235678:1614d8229ff:-8000:0000000000000F53 begin
	    $this->Database = new Database();
	    $sql = $this->Database->prepare("DELETE FROM liked_inspiration WHERE user_id = ? AND folder = ? AND file_name = ? ");
	    $sql->execute( array(
		    $this->userId,
		    $this->folder,
		    $this->filename
	    ));
        // section -64--88-0-19--66235678:1614d8229ff:-8000:0000000000000F53 end
    }

    /**
     * Set the image to liked in the database.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  imageFullPath
     * @return array
     */
    public function setLikeAction($imageFullPath)
    {
        $returnValue = array();

        // section -64--88-0-19--66235678:1614d8229ff:-8000:0000000000000F4E begin

	    /** Like image if user has not already liked post */
	    if($this->checkLikedImage() == false){
		    $this->Database = new Database();
		    $sql = $this->Database->prepare("INSERT INTO liked_inspiration (img_full_path, user_id, created_date, file_name, folder, ip) VALUES (?,?,?,?,?,?) ");
		    $sql->execute( array(
			    $imageFullPath,
			    $this->userId,
			    time(),
			    $this->filename,
			    $this->folder,
			    $this->General->getUserIP()
		    ));

		    if($sql->rowCount() > 0){
			    $returnValue['status'] = "Liked";
		    }else{
			    $returnValue['status'] = 'Failed';
		    }

	    }else{
	    	/** Unlink the image*/
		   $this->unsetLikedImage();
		    $returnValue['status'] = 'unliked';
	    }
        // section -64--88-0-19--66235678:1614d8229ff:-8000:0000000000000F4E end

        return (array) $returnValue;
    }

    /**
     * Get the total likes for the given image.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return Integer
     */
    public function totalLikes()
    {
        $returnValue = null;

        // section -64--88-0-19--6e8967f1:16166d3057c:-8000:0000000000000F99 begin
	    $this->Database = new Database();
	    $sql = $this->Database->prepare("SELECT count(*) FROM liked_inspiration WHERE folder = ? AND file_name = ? ");
	    $sql->execute( array(
		    $this->folder,
		    $this->filename
	    ));
	    $returnValue = $sql->fetchColumn();

        // section -64--88-0-19--6e8967f1:16166d3057c:-8000:0000000000000F99 end

        return $returnValue;
    }

    /**
     * Gets the images the provided user liked.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  userId
     * @return array
     */
    public function likedImages($userId)
    {
        $returnValue = array();

        // section -64--88-0-19-7e49dca8:1616bfa9dd6:-8000:0000000000000FA2 begin
	    $this->Database = new Database();
	    $sql = $this->Database->prepare("SELECT * FROM liked_inspiration WHERE user_id = ?");
	    $sql->setFetchMode( PDO::FETCH_ASSOC );
	    $sql->execute( array(
		    $this->userId
	    ));
	    $returnValue = $sql->fetchAll();

        // section -64--88-0-19-7e49dca8:1616bfa9dd6:-8000:0000000000000FA2 end

        return (array) $returnValue;
    }

} /* end of class likeInspiration */

?>