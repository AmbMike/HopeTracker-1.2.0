<?php

error_reporting(E_ALL);

/**
 * untitledModel - class.ViewedPost.php
 *
 * $Id$
 *
 * This file is part of untitledModel.
 *
 * Automatically generated on 19.10.2017, 15:59:03 with ArgoUML PHP module 
 * (last revised $Date: 2010-01-12 20:14:42 +0100 (Tue, 12 Jan 2010) $)
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-2--39fad00d:15f3572eac9:-8000:0000000000000BF3-includes begin
error_reporting(3);
include_once(CLASSES . 'Database.php');
include_once(CLASSES . 'Sessions.php');
include_once(CLASSES . 'General.php');
// section -64--88-0-2--39fad00d:15f3572eac9:-8000:0000000000000BF3-includes end

/* user defined constants */
// section -64--88-0-2--39fad00d:15f3572eac9:-8000:0000000000000BF3-constants begin
// section -64--88-0-2--39fad00d:15f3572eac9:-8000:0000000000000BF3-constants end

/**
 * Short description of class ViewedPost
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class ViewedPost
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * The logged in users Id.
     *
     * @access private
     * @var Integer
     */
    private $userId = null;

    /**
     * The post id.
     *
     * @access private
     * @var Integer
     */
    private $postId = null;

    /**
     * The type of post it its. cold be a forum, forumReply, Journal, etc.
     *
     * @access private
     * @var Integer
     */
    private $postType = null;

    /**
     * Short description of attribute Session
     *
     * @access private
     * @var array
     */
    private $Session = array();

    /**
     * Short description of attribute Database
     *
     * @access private
     * @var Integer
     */
    private $Database = null;

    /**
     * General Class
     *
     * @access private
     * @var array
     */
    private $General = array();

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
        // section -64--88-0-2--39fad00d:15f3572eac9:-8000:0000000000000C02 begin
        $this->Session = new Sessions();
        $this->userId = ($this->Session->get('user-id')) ? : $this->Session->get('session_token');
        $this->General = new General();
        // section -64--88-0-2--39fad00d:15f3572eac9:-8000:0000000000000C02 end
    }

    /**
     * Sets the post as viewed by the logged in user.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  postId
     * @param  postType
     * @return mixed
     */
    public function setViewedPost($postId, $postType)
    {
        // section -64--88-0-2--39fad00d:15f3572eac9:-8000:0000000000000C07 begin

        $this->Database = new Database();
        $this->postId = $postId;
        $this->postType = $postType;

        if ($this->Session->get('logged_in') == 1 && $this->Session->checkViewedPost($this->postId,$this->userId,$this->postType) == false) {

            $sql = $this->Database->prepare("INSERT INTO viewed_post (post_Type,post_id, user_id, user_ip) VALUES (?,?,?,?)");
            $sql->execute(array(
                $this->postType,
                $this->postId,
                $this->userId,
                $this->General->getUserIP()
            ));
        }else if($this->Session->checkViewedPost($this->postId,$this->userId,$this->postType) == false){
            $sql = $this->Database->prepare("INSERT INTO viewed_post (post_Type,post_id, non_user_token, user_ip) VALUES (?,?,?,?)");
            $sql->execute(array(
                $this->postType,
                $this->postId,
                $this->userId,
                $this->General->getUserIP()
            ));
        }

        /** Set the session to show the user has viewed the post */
        $this->Session->setViewedPost($this->postId,$this->userId,$this->postType);

        // section -64--88-0-2--39fad00d:15f3572eac9:-8000:0000000000000C07 end
    }

    /**
     * Returns the number of times a post has been viewed.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  postType The number value of the type of post it is. Note: 1 for journal, 2 for forum.
     * @param  postId The id for the post.
     * @return String
     */
    public function countPostViews($postType, $postId)
    {
        $returnValue = null;

        // section -64--88-0-2--39fad00d:15f3572eac9:-8000:0000000000000C21 begin
        $this->Database = new Database();

        $sql = $this->Database->prepare("SELECT count(*) FROM viewed_post WHERE post_Type = ? AND post_id = ?");
        $sql->execute(array($postType,$postId));

        $returnValue = $sql->fetchColumn();
        // section -64--88-0-2--39fad00d:15f3572eac9:-8000:0000000000000C21 end

        return $returnValue;
    }

} /* end of class ViewedPost */
