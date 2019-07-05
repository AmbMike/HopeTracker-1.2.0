<?php

error_reporting(E_ALL);

/**
 * Handles the invite a freind form.
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-2-3801fad4:15f2a911f28:-8000:0000000000000BBF-includes begin
error_reporting(0);
include_once(CLASSES . 'Database.php');
include_once(CLASSES . 'Sessions.php');
include_once(CLASSES . 'User.php');
include_once(CLASSES . 'General.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/hopetracker/classes/DebugMg.php');
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
    private $userId = null;

    /**
     * Short description of attribute database
     *
     * @access private
     * @var array
     */
    private $database = array();

    /**
     * Sessions Class.
     *
     * @access private
     * @var array
     */
    private $Sessions = array();

    /**
     * General Class.
     *
     * @access private
     * @var array
     */
    private $General = array();

    /**
     * User Class.
     *
     * @access private
     * @var array
     */
    private $User = array();


    public $DebugMg;
    // --- OPERATIONS ---

    /**
     * Construct the class vars.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return mixed
     */
    public function __construct()
    {
        // section -64--88-0-2-3801fad4:15f2a911f28:-8000:0000000000000BD0 begin
        $this->Sessions = new Sessions();
        $this->userId = $this->Sessions->get('user-id');
        $this->General = new General();
        $this->User = new User();
        $this->DebugMg = new DebugMg();
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
    public function AlreadyInvited($userId, $recipients_email)
    {
        $returnValue = null;

        // section -64--88-0-2-3801fad4:15f2a911f28:-8000:0000000000000BCA begin
        $this->database = new Database();
        $sql = $this->database->prepare("SELECT id FROM invite_friend WHERE recipients_email = ? AND senders_id = ?");
        $sql->execute(array($recipients_email,$userId));

        if($sql->rowCount() > 0){
            $returnValue = true;
        }else{
            $returnValue = false;
        }
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
    public function AlreadyInvitedCheck($recipientsEmail)
    {
        $returnValue = null;

        // section -64--88-0-2-3801fad4:15f2a911f28:-8000:0000000000000BE5 begin
        /** Reverse the return condition to accommodate the validation
         * function that requires a return true to validate field.
         */
        if($this->AlreadyInvited( $this->userId,$recipientsEmail['recipients_email']) == false){
            $isAvailable = true;
        }else{
            $isAvailable = false;
        }

        echo json_encode(array(
            'valid' => $isAvailable,
            'data' => $_POST
        ));
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
    public function setInvitation($data)
    {
        $params = array();
        parse_str($data['all'],$params);

        unset($data);
        $data = $params;

        // section -64--88-0-2-3801fad4:15f2a911f28:-8000:0000000000000BC3 begin
        if($this->AlreadyInvited($this->userId, $data['recipients_email']) == false) {

            /** Captcha Check */
            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $privateKey = '6LewyasUAAAAAOeEyektDmpfnMlFgy-Czpi5vJ_N';
            $response = file_get_contents($url . "?secret=" . $privateKey . "&response=" . $data['g-recaptcha-response']. "&remoteip=" . $_SERVER['REMOTE_ADDR']);

            $decodeResponse = json_decode($response, true);

            if($decodeResponse['success'] || $this->Sessions->get('logged_in')){
                $this->database = new Database();

                if($this->Sessions->get('logged_in')):
                    $sql = $this->database->prepare("INSERT INTO invite_friend (senders_id, senders_name,senders_email, recipients_name, recipients_email, senders_ip) VALUES (?,?,?,?,?,?)");
                    $sql->execute(array(
                        $this->userId,
                        User::full_name($this->userId),
                        User::users_email($this->userId),
                        $data['recipients_name'],
                        $data['recipients_email'],
                        $this->General->getUserIP()
                    ));
                else:
                    $sql = $this->database->prepare("INSERT INTO invite_friend (senders_id, senders_name,senders_email, recipients_name, recipients_email, senders_ip) VALUES (?,?,?,?,?,?)");
                    $sql->execute(array(
                        0,
                        $data['senders_name'],
                        $data['senders_email'],
                        $data['recipients_name'],
                        $data['recipients_email'],
                        $this->General->getUserIP()
                    ));
                endif;

                $array = array();

                if($sql->rowCount() > 0){
                    $array['status'] = 'Successful';
                    $array['userId'] = $this->userId;

                }else{

                    $array['status'] = 'Failed';
                    $this->DebugMg->setError(array(
                        'Type' => 'Invite Friend',
                        'Sub Type' => 'Sidebar Form',
                        'Error' => "Failed insert form data to the database for recipients name: " . $data['recipients_name'] . '  Email: '  . $data['recipients_email'] . ' senders id: ' . $this->userId
                    ));
                }
            }else{
                $array['status'] = 'captcha failed';
            }


        }else{
            $array['status'] = 'Already Invited User';
        }
        echo json_encode($array);
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
    public function getDataForCampaignMonitor($userId = false)
    {
        $returnValue = array();

        // section -64--88-0-13--63342b69:15f83a8c430:-8000:0000000000000C8B begin
	    $this->database = new Database();
	    if($userId == false){
		    $sql = $this->database->prepare( "SELECT * FROM invite_friend WHERE processed = 0 " );
		    $sql->setFetchMode( PDO::FETCH_ASSOC );
		    $sql->execute();

		    $returnValue = $sql->fetchAll();
	    }else{
		    $sql = $this->database->prepare( "SELECT * FROM invite_friend WHERE processed = 0 AND senders_id = ? " );
		    $sql->setFetchMode( PDO::FETCH_ASSOC );
		    $sql->execute(array($userId));
		    $returnValue = $sql->fetchAll();
		    $returnValue = $returnValue[0];

	    }
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
    public function setInviteAsSent($sentRecordId)
    {
        // section -64--88-0-13--63342b69:15f83a8c430:-8000:0000000000000C8E begin
	    $this->database = new Database();
	    $sql = $this->database->prepare("UPDATE invite_friend SET processed = 1 WHERE id = ?");
	    $sql->execute(array($sentRecordId));
        // section -64--88-0-13--63342b69:15f83a8c430:-8000:0000000000000C8E end
    }

    public function setFailedInvite($sentRecordId)
    {
        // section -64--88-0-13--63342b69:15f83a8c430:-8000:0000000000000C8E begin
        $this->database = new Database();
        $sql = $this->database->prepare("UPDATE invite_friend SET processed = 2 WHERE id = ?");
        $sql->execute(array($sentRecordId));
        // section -64--88-0-13--63342b69:15f83a8c430:-8000:0000000000000C8E end
    }

} /* end of class InviteFriend */

?>