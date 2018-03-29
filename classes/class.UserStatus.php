<?php

error_reporting(E_ALL);

/**
 * untitledModel - class.UserStatus.php
 *
 * $Id$
 *
 * This file is part of untitledModel.
 *
 * Automatically generated on 30.10.2017, 12:44:43 with ArgoUML PHP module 
 * (last revised $Date: 2010-01-12 20:14:42 +0100 (Tue, 12 Jan 2010) $)
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-2--7414f810:15f5f15e7e4:-8000:0000000000000C57-includes begin
error_reporting(0);
include_once(CLASSES . 'Database.php');
include_once(CLASSES . 'Forum.php');
include_once(CLASSES . 'Journal.php');
include_once(CLASSES . 'User.php');


// section -64--88-0-2--7414f810:15f5f15e7e4:-8000:0000000000000C57-includes end

/* user defined constants */
// section -64--88-0-2--7414f810:15f5f15e7e4:-8000:0000000000000C57-constants begin
// section -64--88-0-2--7414f810:15f5f15e7e4:-8000:0000000000000C57-constants end

/**
 * Short description of class UserStatus
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class UserStatus
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * Short description of attribute total_days_signed_up
     *
     * @access public
     * @var String
     */
    public $total_days_signed_up = null;

    /**
     * Short description of attribute total_logged_hours
     *
     * @access public
     * @var String
     */
    public $total_logged_hours = null;

    /**
     * Short description of attribute total_logged_hours_week
     *
     * @access public
     * @var String
     */
    public $total_logged_hours_week = null;

    /**
     * Short description of attribute total_logged_hours_weekly_average
     *
     * @access public
     * @var Integer
     */
    public $total_logged_hours_weekly_average = null;

    /**
     * Short description of attribute total_members_following_user
     *
     * @access public
     * @var Integer
     */
    public $total_members_following_user = null;

    /**
     * Short description of attribute total_members_users_following
     *
     * @access public
     * @var Integer
     */
    public $total_members_users_following = null;

    /**
     * Short description of attribute total_journal_post
     *
     * @access public
     * @var Integer
     */
    public $total_journal_post = null;

    /**
     * Short description of attribute total_forum_post
     *
     * @access public
     * @var Integer
     */
    public $total_forum_post = null;

    /**
     * Short description of attribute total_chat_sessions
     *
     * @access public
     * @var Integer
     */
    public $total_chat_sessions = null;

    /**
     * Short description of attribute userId
     *
     * @access private
     * @var Integer
     */
    private $userId = null;

    // --- OPERATIONS ---

    /**
     * Short description of method __construct
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  userId
     * @return mixed
     */
    public function __construct($userId)
    {
        // section -64--88-0-2--7414f810:15f5f15e7e4:-8000:0000000000000C7A begin
        $this->userId = $userId;

        $this->total_forum_post = $this->getTotalUserForums($this->userId);
        $this->total_journal_post = $this->getTotalUserJournals($this->userId);
        $this->total_days_signed_up = $this->getTotalDaysSinceSignup($this->userId);
        $this->total_members_following_user = $this->getTotalMembersUserFollowing($this->userId);
        $this->total_members_users_following = $this->getTotalMembersUserIsFollowing($this->userId);
        $this->total_chat_sessions = $this->getUsersTotalChatSessions($this->userId);
        // section -64--88-0-2--7414f810:15f5f15e7e4:-8000:0000000000000C7A end
    }

    /**
     * Short description of method getTotalUserJournals
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  userId
     * @return Integer
     */
    public function getTotalUserJournals($userId)
    {
        $returnValue = null;

        // section -64--88-0-2--7414f810:15f5f15e7e4:-8000:0000000000000C7D begin
        $Journal = new Journal();
        $returnValue =  $Journal->total_journal_post($userId);

        // section -64--88-0-2--7414f810:15f5f15e7e4:-8000:0000000000000C7D end

        return $returnValue;
    }

    /**
     * Short description of method getTotalUserForums
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  userId
     * @return Integer
     */
    public function getTotalUserForums($userId)
    {
        $returnValue = null;

        // section -64--88-0-2--35c3d20f:15f68a7be67:-8000:0000000000000C7C begin
        $Forum = new Forum();

        $returnValue =  $Forum->total_forums($userId);
        // section -64--88-0-2--35c3d20f:15f68a7be67:-8000:0000000000000C7C end

        return $returnValue;
    }

    /**
     * Short description of method getTotalDaysSinceSignup
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  userId
     * @return Integer
     */
    public function getTotalDaysSinceSignup($userId)
    {
        $returnValue = null;

        // section -64--88-0-2--35c3d20f:15f68a7be67:-8000:0000000000000C7F begin

        $start_date = User::user_info('created_on', $userId);
        $end_date = time();
        $diff_in_min = ($end_date - $start_date) / 60;
        $diff_in_hours = $diff_in_min / 60;
        $diff_in_days = $diff_in_hours / 24;
        $returnValue =  round($diff_in_days);

        // section -64--88-0-2--35c3d20f:15f68a7be67:-8000:0000000000000C7F end

        return $returnValue;
    }

    /**
     * Short description of method getTotalMembersUserFollowing
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  userId
     * @return Integer
     */
    public function getTotalMembersUserFollowing($userId)
    {
        $returnValue = null;

        // section -64--88-0-2--35c3d20f:15f68a7be67:-8000:0000000000000C82 begin
        $Database = new Database();
        $sql = $Database->prepare("SELECT count(*) FROM follow_user WHERE follow_user_id = ?");
        $sql->execute(array($userId));

        $returnValue = $sql->fetchColumn();
        // section -64--88-0-2--35c3d20f:15f68a7be67:-8000:0000000000000C82 end

        return $returnValue;
    }

    /**
     * Short description of method getTotalMembersUserIsFollowing
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  userId
     * @return Integer
     */
    public function getTotalMembersUserIsFollowing($userId)
    {
        $returnValue = null;

        // section -64--88-0-2--35c3d20f:15f68a7be67:-8000:0000000000000C85 begin
        $Database = new Database();
        $sql = $Database->prepare("SELECT count(*) FROM follow_user WHERE followers_id = ?");
        $sql->execute(array($userId));

        $returnValue = $sql->fetchColumn();
        // section -64--88-0-2--35c3d20f:15f68a7be67:-8000:0000000000000C85 end

        return $returnValue;
    }

    /**
     * Short description of method getUsersTotalChatSessions
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  userId
     * @return Integer
     */
    public function getUsersTotalChatSessions($userId)
    {
        $returnValue = null;

        // section -64--88-0-2--35c3d20f:15f68a7be67:-8000:0000000000000C88 begin
        $Database = new Database();
        $sql = $Database->prepare("SELECT count(*) FROM users_had_chat WHERE user_id = ? OR requested_user_id = ?");
        $sql->execute(array($userId,$userId));

        $returnValue = $sql->fetchColumn();
        // section -64--88-0-2--35c3d20f:15f68a7be67:-8000:0000000000000C88 end

        return $returnValue;
    }

} /* end of class UserStatus */

?>