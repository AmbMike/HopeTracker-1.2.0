<?php

error_reporting(E_ALL);

/**
 * untitledModel - class.InspirationComments.php
 *
 * $Id$
 *
 * This file is part of untitledModel.
 *
 * Automatically generated on 05.02.2018, 16:22:14 with ArgoUML PHP module 
 * (last revised $Date: 2010-01-12 20:14:42 +0100 (Tue, 12 Jan 2010) $)
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-19-1f35d2ba:1615716579e:-8000:0000000000000F5B-includes begin
error_reporting( 0 );
require_once(CLASSES . 'Database.php');
require_once(CLASSES . 'General.php');
require_once(CLASSES . 'Sessions.php');
require_once(CLASSES . 'User.php');
require_once(CLASSES . 'class.LikePost.php');
require_once(CLASSES . 'class.PageLinks.php');
// section -64--88-0-19-1f35d2ba:1615716579e:-8000:0000000000000F5B-includes end

/* user defined constants */
// section -64--88-0-19-1f35d2ba:1615716579e:-8000:0000000000000F5B-constants begin
// section -64--88-0-19-1f35d2ba:1615716579e:-8000:0000000000000F5B-constants end

/**
 * Short description of class InspirationComments
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class InspirationComments
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * The image folder name the user is commenting on.
     *
     * @access public
     * @var String
     */
    public $imageFolder = null;

    /**
     * The image filename the user is commenting on.
     *
     * @access public
     * @var String
     */
    public $imageFilename = null;

    /**
     * The full path to the image the user is commented on.
     *
     * @access public
     * @var String
     */
    public $imagePath = null;

    /**
     * Short description of attribute Sessions
     *
     * @access public
     * @var object
     */
    public $Sessions = null;

    /**
     * Short description of attribute Database
     *
     * @access private
     * @var object
     */
    private $Database = null;

    /**
     * Short description of attribute userId
     *
     * @access public
     * @var Integer
     */
    public $userId = null;

    /**
     * Short description of attribute General
     *
     * @access public
     * @var object
     */
    public $General = null;

    /**
     * Short description of attribute User
     *
     * @access public
     * @var object
     */
    public $User = null;

    /**
     * Short description of attribute PageLinks
     *
     * @access public
     * @var Object
     */
    public $PageLinks = null;

    /**
     * Short description of attribute LikePost
     *
     * @access public
     * @var object
     */
    public $LikePost = null;

    // --- OPERATIONS ---

    /**
     * Construct the class
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return mixed
     */
    public function __construct()
    {
        // section -64--88-0-19-1f35d2ba:1615716579e:-8000:0000000000000F71 begin
	    $this->Sessions = new Sessions();
	    $this->General = new General();
	    $this->General = new General();
	    $this->User = new User();
	    $this->PageLinks = new PageLinks();

	    if($this->Sessions->get('logged_in') == 1){
		    $this->userId = $this->Sessions->get( 'user-id' );
	    }else{
		    $this->userId = 0;
	    }

        // section -64--88-0-19-1f35d2ba:1615716579e:-8000:0000000000000F71 end
    }

    /**
     * Get comments for a given inspiration image.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  folder
     * @param  filename
     * @param  id
     * @return array
     */
    public function getComments($folder = false, $filename = false, $id = false)
    {
        $returnValue = array();

        // section -64--88-0-19-1f35d2ba:1615716579e:-8000:0000000000000F5F begin
	    $this->Database = new Database();
	    if($id == false){
		    $sql = $this->Database->prepare("SELECT * FROM  inspiration_comments WHERE folder = ? AND file_name = ?");
		    $sql->setFetchMode( PDO::FETCH_ASSOC );
		    $sql->execute( array(
			    $folder,
			    $filename
		    ));

		    if($sql->rowCount() > 0){


			    $returnValue['status'] = 'Has comments';
			    /** Create data to send back to post */
			    date_default_timezone_set('America/New_York');
			    foreach ($sql->fetchAll() as $index => $dataOut):

				    /** Check if post is liked. */
				    $this->LikePost = new LikePost( $dataOut['id'],6,$dataOut['user_id']);

				    $liked = $this->LikePost->checkLikedQuestion();

				    /** Get total likes if comment is liked. */
				    $total_Likes = 0;
				    if($liked == true){
					    $total_Likes = $this->LikePost->getTotalLikes();
					   
				    }

				    $returnValue['data'][ $index ]['totalLikes']= $total_Likes;
				    $returnValue['data'][ $index ]['Id']= $dataOut['id'];
				    $returnValue['data'][ $index ]['userId']= $dataOut['user_id'];
				    $returnValue['data'][ $index ]['userImage']= $this->User->get_user_profile_img($dataOut['user_id'],$dataOut['user_id']);
				    $returnValue['data'][ $index ]['username']= User::Username($dataOut['user_id']);
				    $returnValue['data'][ $index ]['comment']= $dataOut['comment'];
				    $returnValue['data'][ $index ]['created_date']= date('j F Y H:i', $dataOut['created_date']);
				    $returnValue['data'][ $index ]['folder']= $dataOut['folder'];
				    $returnValue['data'][ $index ]['imgPath']= $dataOut['imgPath'];
				    $returnValue['data'][ $index ]['profileLink'] = PageLinks::userProfile($dataOut['user_id']);
				    $returnValue['data'][ $index ]['likedPosts'] =  $liked;
				    $returnValue['data'][ $index ]['loggedIn'] =  ($this->userId != 0) ? true : false;
		    endforeach;
		    }else{
			    $returnValue['status'] = 'No comments';
		    }
	    }else{
		    $sql = $this->Database->prepare("SELECT * FROM  inspiration_comments WHERE id = ?");
		    $sql->setFetchMode( PDO::FETCH_ASSOC );
		    $sql->execute( array(
			    $id
		    ));
		    if($sql->rowCount() > 0){
			    /** Create data to send back to post */
			    date_default_timezone_set('America/New_York');
			    foreach ($sql->fetchAll() as $index => $dataOut):
				    /** Check if post is liked. */
				    $this->LikePost = new LikePost( $dataOut['id'],6,$dataOut['user_id']);
				    $liked = $this->LikePost->checkLikedQuestion();

				    /** Get total likes if comment is liked. */
				    $total_Likes = 0;
				    if($liked == true){
					    $total_Likes = $this->LikePost->getTotalLikes();
				    }

				    $returnValue['data'][ $index ]['totalLikes']= $total_Likes;
				    $returnValue['Id'] = $dataOut['id'];
				    $returnValue['userId'] = $dataOut['user_id'];;
				    $returnValue['userImage'] = $this->User->get_user_profile_img($dataOut['user_id'],$dataOut['user_id']);
				    $returnValue['username'] = User::Username($dataOut['user_id']);
				    $returnValue['comment'] = $dataOut['comment'];
				    $returnValue['created_date'] = date('j F Y H:i', $dataOut['created_date']);;
				    $returnValue['folder'] = $dataOut['folder'];
				    $returnValue['imgPath'] = $dataOut['imgPath'];
				    $returnValue['profileLink'] = PageLinks::userProfile($dataOut['user_id']);
				    $returnValue['data'][ $index ]['likedPosts'] = $liked;
				    $returnValue['data'][ $index ]['loggedIn'] =  ($this->userId != 0) ? true : false;
			    endforeach;
		    }else{
			    $returnValue['status'] = 'No comments';
		    }
	    }
        // section -64--88-0-19-1f35d2ba:1615716579e:-8000:0000000000000F5F end

        return (array) $returnValue;
    }

    /**
     * Store the comment for a image.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  folder
     * @param  filename
     * @param  imagePath
     * @param  comment
     * @return array
     */
    public function storeComment($folder, $filename, $imagePath, $comment)
    {
        $returnValue = array();

        // section -64--88-0-19-1f35d2ba:1615716579e:-8000:0000000000000F5C begin
	    $this->Database = new Database();
	    $sql = $this->Database->prepare("INSERT INTO inspiration_comments (imgPath, user_id, comment, created_date, file_name, folder, ip) VALUES (?,?,?,?,?,?,?)");
	    $sql->execute( array(
		    $imagePath,
		    $this->userId,
		    $comment,
		    time(),
		    $filename,
		    $folder,
		    $this->General->getUserIP()
	    ) );

	    if($sql->rowCount() > 0){
	    	$returnValue['status'] = 'Stored';
	    	$returnValue['data'] = $this->getComments(false,false,$this->Database->lastInsertId());
	    }else{
		    $returnValue['status'] = 'Failed to Store';
	    }

        // section -64--88-0-19-1f35d2ba:1615716579e:-8000:0000000000000F5C end

        return (array) $returnValue;
    }

} /* end of class InspirationComments */

?>