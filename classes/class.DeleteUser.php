<?php

error_reporting(E_ALL);

/**
 * untitledModel - class.DeleteUser.php
 *
 * $Id$
 *
 * This file is part of untitledModel.
 *
 * Automatically generated on 30.04.2018, 21:54:12 with ArgoUML PHP module 
 * (last revised $Date: 2010-01-12 20:14:42 +0100 (Tue, 12 Jan 2010) $)
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/**
 * include UserSettings
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
require_once('class.UserSettings.php');

/* user defined includes */
// section -64--88-0-2--137fbda7:1631728b918:-8000:0000000000001124-includes begin
error_reporting( 0 );
// section -64--88-0-2--137fbda7:1631728b918:-8000:0000000000001124-includes end

/* user defined constants */
// section -64--88-0-2--137fbda7:1631728b918:-8000:0000000000001124-constants begin
// section -64--88-0-2--137fbda7:1631728b918:-8000:0000000000001124-constants end

/**
 * Short description of class DeleteUser
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class DeleteUser
    extends UserSettings
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * Defines if all the processes went through successfully.
     *
     * @access public
     * @var Boolean
     */
    public $processStatus = null;

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
        // section -64--88-0-2--137fbda7:1631728b918:-8000:0000000000001129 begin
	    parent::__construct();

	    Debug::data($this->archiveUser());
        // section -64--88-0-2--137fbda7:1631728b918:-8000:0000000000001129 end
    }

    /**
     * Move user data to the deleted users-list.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return Boolean
     */
    public function archiveUser()
    {
        $returnValue = null;

        // section -64--88-0-2--137fbda7:1631728b918:-8000:000000000000112B begin
	    $this->Database = new Database();
	    $sql = $this->Database->prepare( "SELECT * FROM user_list WHERE id = ?" );
	    $sql->setFetchMode( PDO::FETCH_ASSOC );
	    $sql->execute( array( $this->user_id ) );

	    $userData =  $sql->fetchAll();
	    $userData = $userData[0];

	    $userFirstName = $userData['fname'];
	    $userLastName = $userData['lname'];
	    $userEmail = $userData['email'];


	    if($sql->rowCount() > 0){
	    	$sql = $this->Database->prepare("INSERT INTO deleted_user_list (fname, lname, email, password, last_updated, created_on, state, zip, profile_img, i_am_a, concerned_about, in_type, time_check, username, ip,role,timestamp,user_id,deleted_date,user_ip_when_deleted) VALUE (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
		    $sql->execute( array(
			    $userFirstName,
			    $userLastName,
			    $userEmail,
			    $userData['password'],
			    $userData['last_updated'],
			    $userData['created_on'],
			    $userData['state'],
			    $userData['zip'],
			    $userData['profile_image'],
			    $userData['i_am_a'],
			    $userData['concerned_about'],
			    $userData['in_type'],
			    $userData['time_check'],
			    $userData['username'],
			    $userData['ip'],
			    $userData['role'],
			    $userData['timestamp'],
			    $userData['id'],
			    time(),
			    $this->General->getUserIP(),
		    ) );

		    if ( $sql->rowCount() > 0 ) {

		    	/** Replacement user data for deleted user. Data that is now displayed in place of the deleted user's name for their post etc. */
			    $FirstName = 'Former';
			    $LastName = 'User';
			    $UserName = 'FormerUser';
			    $Email = 'FormerUser@hopetracker.com';
			    $profileImage = 'site/public/images/main/profile.jpg';

			    unset( $sql );
			    $sql  = $this->Database->prepare('UPDATE user_list SET active = 0, fname = ?, lname = ?, email = ?, profile_img = ?, username = ? WHERE id = ?');
			    $sql->execute(array(
			    	$FirstName,
			    	$LastName,
				    $Email,
				    $profileImage,
			    	$UserName,
			    	(int)$userData['id']
				    )
			    );


			    if($sql->rowCount() > 0){
			    	/** Data to send to Campaign Monitor. */
				    $user_data =  array(
					    'userFullName' => ucfirst($userFirstName) . ' ' . ucfirst($userLastName),
					    'userEmail' => $userEmail
				    );
				    $this->AddUserToCampaignMonitor( $user_data );
				    $returnValue['Deleted'] = 'True';

				    $this->User->sign_out();
				    $this->User->log_user_offline($this->user_id);
				    header('Location: /' . RELATIVE_PATH . 'home/deleted-account');
			    }else{
				    $returnValue['Deleted'] = 'False';
				    Debug::data( $sql->errorInfo() );
			    }

		    }else{
			    $returnValue['Deleted'] = 'False';
		    }
	    }

        // section -64--88-0-2--137fbda7:1631728b918:-8000:000000000000112B end

        return $returnValue;
    }

    /**
     * Delete the users data from the user-list table.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return Boolean
     */
    public function deleteUseUserList()
    {
        $returnValue = null;

        // section -64--88-0-2--137fbda7:1631728b918:-8000:000000000000112D begin
        // section -64--88-0-2--137fbda7:1631728b918:-8000:000000000000112D end

        return $returnValue;
    }

    /**
     * Change the user's Journal ownership to Former Users.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return Boolean
     */
    public function updateJournalEntry()
    {
        $returnValue = null;

        // section -64--88-0-2--137fbda7:1631728b918:-8000:0000000000001130 begin
        // section -64--88-0-2--137fbda7:1631728b918:-8000:0000000000001130 end

        return $returnValue;
    }

    /**
     * Change the user's Journal Comments data to "Former User".
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return Boolean
     */
    public function updateJournalComments()
    {
        $returnValue = null;

        // section -64--88-0-2--137fbda7:1631728b918:-8000:0000000000001134 begin
        // section -64--88-0-2--137fbda7:1631728b918:-8000:0000000000001134 end

        return $returnValue;
    }

    /**
     * Change the user's Journal Likes data to "Former User".
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return Boolean
     */
    public function updateJournalLikes()
    {
        $returnValue = null;

        // section -64--88-0-2--137fbda7:1631728b918:-8000:0000000000001136 begin
        // section -64--88-0-2--137fbda7:1631728b918:-8000:0000000000001136 end

        return $returnValue;
    }

    /**
     * Change the user's Former Questions data to "Former User".
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return Boolean
     */
    public function updateForumQuestions()
    {
        $returnValue = null;

        // section -64--88-0-2--137fbda7:1631728b918:-8000:0000000000001138 begin
        // section -64--88-0-2--137fbda7:1631728b918:-8000:0000000000001138 end

        return $returnValue;
    }

    /**
     * Change the user's Former Answers data to "Former User".
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return Boolean
     */
    public function updateForumAnswers()
    {
        $returnValue = null;

        // section -64--88-0-2--137fbda7:1631728b918:-8000:000000000000113A begin
        // section -64--88-0-2--137fbda7:1631728b918:-8000:000000000000113A end

        return $returnValue;
    }

    /**
     * Change the user's Former Likes data to "Former User".
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return Boolean
     */
    public function updateForumLikes()
    {
        $returnValue = null;

        // section -64--88-0-2--137fbda7:1631728b918:-8000:000000000000113C begin
        // section -64--88-0-2--137fbda7:1631728b918:-8000:000000000000113C end

        return $returnValue;
    }

    /**
     * Sends the user's data to Campaign Monitor.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  user_data
     * @return mixed
     */
    public function AddUserToCampaignMonitor($user_data)
    {
        // section -64--88-0-2--137fbda7:1631728b918:-8000:000000000000115C begin
	    require_once ABSPATH . '/campaign-monitor-api/csrest_campaigns.php';
	    require_once ABSPATH . '/campaign-monitor-api/csrest_general.php';
	    require_once ABSPATH . '/campaign-monitor-api/csrest_clients.php';
	    require_once ABSPATH . '/campaign-monitor-api/csrest_subscribers.php';


	    $wrap = new CS_REST_Subscribers('24eb9414bd07dd60844e8cae93ac1435', '29a644cdec042cb0fb39f389f20afc9a');

	    $result = $wrap->add(array(
		    'Name' => $user_data['userFullName'],
		    'EmailAddress' => $user_data['userEmail'],
	    ));

	    if($result->was_successful()) {
		    return true;

	    } else {
	    	Debug::to_file('Failed with code '.$result->http_status_code."\n<br />", 'deleteAccountCM.txt');
	    	return false;


	    }

        // section -64--88-0-2--137fbda7:1631728b918:-8000:000000000000115C end
    }

} /* end of class DeleteUser */

?>