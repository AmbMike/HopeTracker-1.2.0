<?php

error_reporting(E_ALL);

/**
 * Handles the invite a freind form.
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '4')) {
    die('This file was generated for PHP 4');
}

/* user defined includes */
// section -64--88-0-2-3801fad4:15f2a911f28:-8000:0000000000000BBF-includes begin
// section -64--88-0-2-3801fad4:15f2a911f28:-8000:0000000000000BBF-includes end

/* user defined constants */
// section -64--88-0-2-3801fad4:15f2a911f28:-8000:0000000000000BBF-constants begin
// section -64--88-0-2-3801fad4:15f2a911f28:-8000:0000000000000BBF-constants end

/**
 * Handles the invite a freind form.
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class InviteFriend
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * Short description of attribute userId
     *
     * @access private
     * @var Integer
     */
    var $_userId = null;

    /**
     * Short description of attribute database
     *
     * @access private
     * @var array
     */
    var $_database = array();

    /**
     * Sessions Class.
     *
     * @access private
     * @var array
     */
    var $_Sessions = array();

    /**
     * General Class.
     *
     * @access private
     * @var array
     */
    var $_General = array();

    /**
     * User Class.
     *
     * @access private
     * @var array
     */
    var $_User = array();

    // --- OPERATIONS ---

    /**
     * Construct the class vars.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return mixed
     */
    function __construct()
    {
        // section -64--88-0-2-3801fad4:15f2a911f28:-8000:0000000000000BD0 begin
        // section -64--88-0-2-3801fad4:15f2a911f28:-8000:0000000000000BD0 end
    }

    /**
     * Check if the user's email has already been invited by the user.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  userId : The senders user Id.
     * @param  recipients_email Recipients email to crosscheck the database.
     * @return Boolean
     */
    function AlreadyInvited($userId, $recipients_email)
    {
        $returnValue = null;

        // section -64--88-0-2-3801fad4:15f2a911f28:-8000:0000000000000BCA begin
        // section -64--88-0-2-3801fad4:15f2a911f28:-8000:0000000000000BCA end

        return $returnValue;
    }

    /**
     * Validation Ajax Check if the user has already been invited by the user.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  recipientsEmail
     * @return Boolean
     */
    function AlreadyInvitedCheck($recipientsEmail)
    {
        $returnValue = null;

        // section -64--88-0-2-3801fad4:15f2a911f28:-8000:0000000000000BE5 begin
        // section -64--88-0-2-3801fad4:15f2a911f28:-8000:0000000000000BE5 end

        return $returnValue;
    }

    /**
     * Sets the invitation in the database.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  data Input data from the user to the recipients.
     * @return mixed
     */
    function setInvitation($data)
    {
        // section -64--88-0-2-3801fad4:15f2a911f28:-8000:0000000000000BC3 begin
        // section -64--88-0-2-3801fad4:15f2a911f28:-8000:0000000000000BC3 end
    }

    /**
     * Short description of method getDataForCampaignMonitor
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  userId
     * @return array
     */
    function getDataForCampaignMonitor($userId = false)
    {
        $returnValue = array();

        // section -64--88-0-13--63342b69:15f83a8c430:-8000:0000000000000C8B begin
        // section -64--88-0-13--63342b69:15f83a8c430:-8000:0000000000000C8B end

        return (array) $returnValue;
    }

    /**
     * Set the invite record as sent.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  sentRecordId
     * @return mixed
     */
    function setInviteAsSent($sentRecordId)
    {
        // section -64--88-0-13--63342b69:15f83a8c430:-8000:0000000000000C8E begin
        // section -64--88-0-13--63342b69:15f83a8c430:-8000:0000000000000C8E end
    }

} /* end of class InviteFriend */

?>