<?php

error_reporting(E_ALL);

/**
 * The class that handles flagging all post from question, answers, to journal
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000F14-includes begin
error_reporting(1);
include_once(CLASSES .'Sessions.php');
include_once(CLASSES .'Database.php');
include_once(CLASSES .'class.Post.php');
// section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000F14-includes end

/* user defined constants */
// section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000F14-constants begin
// section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000F14-constants end

/**
 * The class that handles flagging all post from question, answers, to journal
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class FlagPost
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * Databse object.
     *
     * @access private
     * @var object
     */
    private $Database = null;

    /**
     * Session object.
     *
     * @access public
     * @var object
     */
    public $Session = null;

    /**
     * Post id for the post that is being flagged.
     *
     * @access public
     * @var Integer
     */
    public $postId = null;

    /**
     * User id for the user who is flagging the post.
     *
     * @access public
     * @var Integer
     */
    public $userId = null;

    /**
     * General Class Object.
     *
     * @access public
     * @var object
     */
    public $General = null;


    public $Post = null;


    // --- OPERATIONS ---

    /**
     * contstruct the class.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return mixed
     */
    public function __construct()
    {
        // section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000F24 begin
	    $this->Session = new Sessions();
	    $this->General = new General();
	    $this->Post = new Post();

	    if($this->Session->get('logged_in') == 1){
		    $this->userId = $this->Session->get( 'user-id' );
	    }
        // section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000F24 end
    }

    /**
     * Check if the user had flagged the post.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  postId
     * @param  postType
     * @return Boolean
     */
    public function checkIfUserFlaggedPost($postId, $postType)
    {
        $returnValue = null;

        // section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000F3B begin
	    $Database = new Database();
	    $sql = $Database->prepare("SELECT id FROM flagged_post WHERE flaggers_id = ? AND flagged_post_id = ?  AND post_type = ?");
	    $sql->execute(array(
		    $this->userId,
		    $postId,
		    $postType
	    ));
	    if($sql->rowCount() > 0){
		    $returnValue = true;
	    }else{
		    $returnValue = false;
	    }
        // section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000F3B end

        return $returnValue;
    }

    /**
     * Process the post that is being flagged by the user.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  postId
     * @param  postType
     * @return array
     */
    public function flagPost($postId, $postType)
    {
        $returnValue = array();

        // section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000F2E begin
	    /** If the user has not already flagged the post then flag the post */
	    if($this->Session->get('logged_in') == 1){
            if($this->checkIfUserFlaggedPost($postId, $postType) == false){
                $Database = new Database();
                $sql = $Database->prepare("INSERT INTO flagged_post (flaggers_id, flagged_post_id, post_type, flaggers_ip, date_flagged) VALUES(?,?,?,?,?)");
                $sql->execute(array(
                    $this->userId,
                    $postId,
                    $postType,
                    $this->General->getUserIP(),
                    time()
                ));
                if($sql->rowCount() > 0){
                    $returnValue['status'] = 'flagged';

                    /* Send email */
                    function emailer($to, $to_name, $title, $htmlcontent, $content){
                        define('ABSPATH', $_SERVER['DOCUMENT_ROOT'] . '/hopetracker');
                        include_once(ABSPATH.'/libs/PHPMailer/PHPMailerAutoload.php');
                        $mail = new PHPMailer;

                        //$mail->SMTPDebug = 3;                               // Enable verbose debug output
                        $mail->isSMTP();                                      // Set mailer to use SMTP
                        $mail->Username = 'sendhopetracker@gmail.com';
                        $mail->Password = 'X?{,O._(U@w0';
                        $mail->From = "sendhopetracker@gmail.com";
                        $mail->FromName = 'Hope Tracker';                         // SMTP password
                        $mail->SMTPAuth = true;
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPSecure = 'ssl';
                        $mail->Port = '465';                               // TCP port to connect to
                        $mail->addAddress($to, $to_name);     // Add a recipient
                        $mail->addReplyTo('webmaster@ambrosiatc.com', 'Information');
                        $mail->isHTML(true);                                  // Set email format to HTML

                        $mail->Subject = $title;
                        $mail->Body    = $htmlcontent;
                        $mail->AltBody = $content;



                        if(!$mail->send()) {
                            $returnValue['error'] = $mail->ErrorInfo;
                        } else {
                            $returnValue['sent'] =  'Message has been sent';
                        }
                    }

                    $template = VIEWS .'emails/flaggedPosts.php';
                    $senders_name = User::full_name($this->userId);
                    $the_post = $this->Post->get($postType, $postId);
                    $senders_email = User::users_email($this->userId);
                    $sent_msg = "<h3>The Post</h3>";
                    $sent_msg .= "<p>$the_post</p>";
                    $sent_msg .= "<hr>";
                    $sent_msg .= "<h3>Take Action</h3>";
                    $sent_msg .= "<p>See flagged posts details and make necessary changes on here: " . DYNAMIC_URL.'admin/flagged</p>';

                    ob_start();
                    require $template;
                    $template = ob_get_clean();

                    emailer('digital@ambrosiatc.com', "Admin", "A Post Was Flagged By A User", $template, "this is the content");
                    emailer('mgiammattei@ambrosiatc.com', "Admin", "A Post Was Flagged By A User", $template, "this is the content");

                }else{
                    $returnValue['status'] = 'failed flag query';
                }
            }else{
                /** If the user already flagged the post */
                $returnValue['status'] = 'already flagged';
            }
        }



        // section -64--88-0-2-189b15d9:1604cc00e9e:-8000:0000000000000F2E end

        return (array) $returnValue;
    }

    public function getFlaggedPosts(){
        $this->Database = new Database();
        $returnValue = array();
        $sql = $this->Database->prepare("SELECT * FROM flagged_post");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();

        return $sql->fetchAll();
    }
    public function delete($flagId){
        $this->Database = new Database();
        $sql = $this->Database->prepare("DELETE FROM flagged_post WHERE id = ?");
        $sql->execute(array($flagId));

        if($sql->rowCount() > 0){
            $returnValue['status'] = "Success";
            return true;
        }else{
            $returnValue['status'] = "Failed";
            return false;
        }
        echo json_encode($returnValue);
    }

} /* end of class FlagPost */

?>