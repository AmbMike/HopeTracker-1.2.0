<?php

error_reporting(E_ALL);

/**
 * Controls the activity notification filters.
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-19-15e7d721:161c304f503:-8000:00000000000010BD-includes begin
error_reporting( 3 );
require_once( CLASSES . 'Database.php' );
require_once( CLASSES . 'Sessions.php' );
require_once(CLASSES .'class.Link.php');
require_once(CLASSES .'User.php');
require_once(CLASSES .'class.FontAwesomeClass.php');

// section -64--88-0-19-15e7d721:161c304f503:-8000:00000000000010BD-includes end

/* user defined constants */
// section -64--88-0-19-15e7d721:161c304f503:-8000:00000000000010BD-constants begin
// section -64--88-0-19-15e7d721:161c304f503:-8000:00000000000010BD-constants end

/**
 * Controls the activity notification filters.
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class ActivityFilter
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * Short description of attribute filterType
     *
     * @access public
     * @var String
     */
    public $filterType = null;

    /**
     * Short description of attribute Database
     *
     * @access private
     * @var Class
     */
    private $Database = null;

    /**
     * Short description of attribute Session
     *
     * @access private
     * @var Class
     */
    private $Session = null;

    /**
     * Short description of attribute userId
     *
     * @access private
     * @var Integer
     */
    private $userId = null;

    /**
     * Short description of attribute General
     *
     * @access public
     * @var array
     */
    public $General = array();

    /**
     * Short description of attribute Icons
     *
     * @access public
     * @var array
     */
    public $Icons = array();

    // --- OPERATIONS ---

    /**
     * Short description of method __construct
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  activityFilter
     * @param  showUserId
     * @return mixed
     */
    public function __construct($activityFilter, $showUserId)
    {
        // section -64--88-0-19-15e7d721:161c304f503:-8000:00000000000010CB begin
	    $this->filterType = $activityFilter;
	    $this->Session = new Sessions();
	    $this->General = new General();
	    $this->Icons = new FontAwesomeClass();
	    $this->userId = $showUserId;
        // section -64--88-0-19-15e7d721:161c304f503:-8000:00000000000010CB end
    }

    /**
     * Short description of method newJournalComments
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return array
     */
    public function newJournalComments()
    {
        $returnValue = array();

        // section -64--88-0-19-15e7d721:161c304f503:-8000:00000000000010CD begin
	    include_once(CLASSES .'class.newComment.php');
	    $newComments = New newComment($this->userId);
	    $returnValue = $newComments->newComments();
        // section -64--88-0-19-15e7d721:161c304f503:-8000:00000000000010CD end

        return (array) $returnValue;
    }

    /**
     * Likes on answers the user has answered.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return array
     */
    public function newLikesOnUserAnswers()
    {
        $returnValue = array();

        // section -64--88-0-19-359969c0:161e3016d5d:-8000:00000000000010F9 begin
	    require_once(CLASSES . 'class.ForumAnswers.php');
	    $ForumAnswers= new ForumAnswers();
	    $returnValue = $ForumAnswers->getLikedAnswersOwnedByUser($this->userId);
        // section -64--88-0-19-359969c0:161e3016d5d:-8000:00000000000010F9 end

        return (array) $returnValue;
    }

    /**
     * Answers to questions the provided user owns.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return array
     */
    public function newFormAnswer()
    {
        $returnValue = array();

        // section -64--88-0-19-359969c0:161e3016d5d:-8000:00000000000010F6 begin
	    include_once(CLASSES . 'class.ForumAnswers.php');
	    include_once(CLASSES . 'class.AskQuestionForum.php');

	    $AskQuestionForum = new AskQuestionForum();
	    $ForumAnswers = new ForumAnswers();

	    /** Run a loop on all question ids the user owns */
	    foreach ($AskQuestionForum->getPostIdOwnedByUser() as $userJournalId):

		    /** Put all  answers to question the user owns */
		    if(count($ForumAnswers->getAnswers(false,$userJournalId)) > 0){
			    $returnValue[] =  $ForumAnswers->getAnswers(false,$userJournalId);
		    }

	    endforeach;
        // section -64--88-0-19-359969c0:161e3016d5d:-8000:00000000000010F6 end

        return (array) $returnValue;
    }

    /**
     * Short description of method newLikedInspiration
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return array
     */
    public function newLikedInspiration()
    {
        $returnValue = array();

        // section -64--88-0-19-6a079614:161dcc70c7f:-8000:00000000000010EA begin
	    $Database = new Database();

	    $sql = $Database->prepare("SELECT * FROM liked_inspiration WHERE user_id = ?");
	    $sql->setFetchMode( PDO::FETCH_ASSOC );
	    $sql->execute( array(
		    $this->userId
	    ) );
	    $returnValue = $sql->fetchAll();
        // section -64--88-0-19-6a079614:161dcc70c7f:-8000:00000000000010EA end

        return (array) $returnValue;
    }

    /**
     * Get new journal posts from user that are being followed.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return array
     */
    public function newAnswerForFollowedQuestion()
    {
        $returnValue = array();

        // section -64--88-0-19-359969c0:161e3016d5d:-8000:00000000000010E1 begin
	    require_once(CLASSES . 'class.FollowedPost.php');
	    $FollowedPost = new FollowedPost();

	    require_once(CLASSES . 'class.ForumAnswers.php');
	    $ForumAnswers= new ForumAnswers();

	    $questionIds = $FollowedPost->getUsersFollowedPostIds($this->userId);

	    $AnswersArr = array();
	    foreach ($questionIds as $question_id):
		    $AnswersArr[] = $ForumAnswers->getAnswersByQuestionId($question_id);
	    endforeach;
	    $flattenArray = array();
	    foreach ($AnswersArr as $childArray) {
		    foreach ($childArray as $value) {
			    $flattenArray[] = $value;
		    }
	    }
	    $returnValue = $flattenArray;
        // section -64--88-0-19-359969c0:161e3016d5d:-8000:00000000000010E1 end

        return (array) $returnValue;
    }

    /**
     * Short description of method newJournalFromFollowedUser
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return array
     */
    public function newJournalFromFollowedUser()
    {
        $returnValue = array();

        // section -64--88-0-19-6a079614:161dcc70c7f:-8000:00000000000010ED begin
	    require_once(CLASSES .'CommunityLog.php');
	    $NewJournalFromFollowedUser = new CommunityLog();
	    $returnValue = $NewJournalFromFollowedUser->new_journals_from_followed_users();
        // section -64--88-0-19-6a079614:161dcc70c7f:-8000:00000000000010ED end

        return (array) $returnValue;
    }

    /**
     * Short description of method newJournalLike
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return array
     */
    public function newJournalLike()
    {
        $returnValue = array();

        // section -64--88-0-19-15e7d721:161c304f503:-8000:00000000000010D1 begin
	    require_once( CLASSES . 'CommunityLog.php' );
	    $CommunityLog = new CommunityLog();

	    foreach ($CommunityLog->content($this->userId) as $postData) {
		    $returnValue[] = $postData;
	    }
        // section -64--88-0-19-15e7d721:161c304f503:-8000:00000000000010D1 end

        return (array) $returnValue;
    }

    /**
     * Short description of method newFollowedUser
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return array
     */
    public function newFollowedUser()
    {
        $returnValue = array();

        // section -64--88-0-19-36c462b:161d39d78d6:-8000:00000000000010E6 begin
	    $Database = new Database();

	    $sql = $Database->prepare("SELECT * FROM follow_user WHERE followers_id = ? OR  follow_user_id = ?");
	    $sql->setFetchMode( PDO::FETCH_ASSOC );
	    $sql->execute( array(
		    $this->userId,
		    $this->userId
	    ) );
	    $returnValue = $sql->fetchAll();
        // section -64--88-0-19-36c462b:161d39d78d6:-8000:00000000000010E6 end

        return (array) $returnValue;
    }

    /**
     * Short description of method buildNotificationOutput
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  timestamp
     * @param  icon
     * @param  textValue
     * @param  likedUserId
     * @param  extra
     * @return array
     */
    public function buildNotificationOutput($timestamp, $icon, $textValue, $likedUserId, $extra = false)
    {
        $returnValue = array();

        // section -64--88-0-19-15e7d721:161c304f503:-8000:00000000000010D5 begin
	    /**
	     * The timestamp of when the user first liked the journal.
	     * @var:LikedTimestamp.
	     */
	    $returnValue['LikedTimestamp'] = $timestamp;

	    /**
	     * The Icon for the notification.
	     * @var FontAwesomeClass : Icon
	     */
	    $returnValue['Icon'] = $icon;

	    /**
	     * Text value for the notification.
	     * Includes the @var:title from the journal post that was liked.
	     * @var: TextValue
	     */
	    $returnValue['TextValue'] = $textValue;

	    /**
	     * The id of the user who liked the journal.
	     * @var:liked_by_user_id
	     */
	    $returnValue['liked_by_user_id'] = $likedUserId;

	    if($extra != false){
		    $returnValue['extraData'] = $extra;
	    }
        // section -64--88-0-19-15e7d721:161c304f503:-8000:00000000000010D5 end

        return (array) $returnValue;
    }

    /**
     * Short description of method buildNotifications
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  filterType
     * @return array
     */
    public function buildNotifications($filterType)
    {
        $returnValue = array();

        // section -64--88-0-19-15e7d721:161c304f503:-8000:00000000000010DB begin

	    /**
	     * Keeps track of array count through all foreach loops.
	     * Each notification function gets put into an array by
	     * running a foreach loop.
	     * @var $arrayCount
	     */
	    $arrayCount = 0;


	    switch ($filterType):
		    case 'myJournals':

			    /**
			     * array of notifications when a user likes the users Journal
			     * @return array : Liked Journals.
			     */
			    foreach ($this->newJournalLike() as $index => $function) {
				    /**
				     * Build the link for the @var:TextValue by using the Link call and
				     * adding the link properties.
				     * @var $notificationLink
				     */
				    $href = '/families-of-drug-addicts/journal-' . $function['liked_journal'][0]['id'] . '/' . $this->General->url_safe_string($function['liked_journal'][0]['title']) . '/';
				    $linkValue = $function['liked_journal'][0]['title'];
				    $options = array(
					    'class' => 'notification-link'
				    );
				    $Link = new Link($href,$linkValue,$options);
				    $notificationLink = $Link->buildLink();

				    /**
				     * Puts the notification values into the array.
				     */
				    $returnValue[$arrayCount][$index] = $this->buildNotificationOutput(
					    $function['liked_timestamp'],
					    $this->Icons->thumbsUp,
					    'Your Journal '. $notificationLink . ' received a like.',
					    $function['liked_by_user_id']
				    );
			    }
			    $arrayCount++;
			    foreach ($this->newJournalComments() as $function) {
				    /** @var  $journalTitle : Journal title by the journal's ID */
				    $journalTitle = $function['comment'];
				    /**
				     * Build the link for the @var:TextValue by using the Link call and
				     * adding the link properties.
				     * @var $notificationLink
				     */

				    $href = '/families-of-drug-addicts/journal-' .  $function['journal_id'] .'/' .$this->General->url_safe_string($function['comment']);
				    $linkValue = $journalTitle;
				    $options = array(
					    'class' => 'notification-link'
				    );
				    $Link = new Link($href,$linkValue,$options);
				    $notificationLink = $Link->buildLink();

				    /**
				     * Puts the notification values into the array.
				     */
				    $returnValue[$arrayCount][$index] = $this->buildNotificationOutput(
					    $function['timestamp'],
					    $this->Icons->comment,
					    'Your Journal '. $notificationLink . ' received a comment.',
					    $function['user_id']
				    );

				    /**
				     * Increments the index where the previous foreach has left off.
				     * This is done to continue building the array off the last array.
				     */
				    $index++;
			    }
			    /**
			     * Increment the arrayCount to keep track of each notifications' array.
			     */
			    $arrayCount++;
		    break;

			 case 'inspirations':
				 foreach ($this->newLikedInspiration()  as $index => $function) {

					 /** @var  $journalTitle : Journal title by the journal's ID */
					 $journalTitle = 'View Inspiration';
					 /**
					  * Build the link for the @var:TextValue by using the Link call and
					  * adding the link properties.
					  * @var $notificationLink
					  */

					 $href = '/addiction-quotes/' .$function['folder']  .'/' . $function['file_name'] . '/';
					 $linkValue = $journalTitle;
					 $options = array(
						 'class' => 'notification-link'
					 );
					 $Link = new Link($href,$linkValue,$options);
					 $notificationLink = $Link->buildLink();

					 $extraData = array();
					 $extraData['folder'] = $function['folder'];
					 $extraData['filename'] = $function['file_name'];
					 $extraData['fullPath'] = $function['img_full_path'];

					 /**
					  * Puts the notification values into the array.
					  */
					 $returnValue[$arrayCount][$index] = $this->buildNotificationOutput(
						 $function['TIMESTAMP'],
						 $this->Icons->solidEye,
						 'You recently liked a '. ucfirst($function['folder']) . ' image.' . $notificationLink,
						 false,
						 $extraData

					 );

					 /**
					  * Increments the index where the previous foreach has left off.
					  * This is done to continue building the array off the last array.
					  */
					 $index++;
				 }
		    break;
			 case 'askQuestionForum':
				 include_once(CLASSES . 'class.AskQuestionForum.php');
				 $AskQuestionForum = new AskQuestionForum();
				 foreach ($this->newAnswerForFollowedQuestion() as $index => $function) {
					 /** @var  $journalTitle : Journal title by the journal's ID */

					 $answer = $this->General->trim_text($function['answer'],100,true,true);
					 $linkURLString = $this->General->trim_text($function['answer'],50,true,true);
					 /**
					  * Build the link for the @var:TextValue by using the Link call and
					  * adding the link properties.
					  * @var $notificationLink
					  */
					 $href = '/forum/'. $this->General->url_safe_string($AskQuestionForum->getQuestionSubcategory( $function['question_id'] )).'/' .  $function['question_id'] .'/' .$this->General->url_safe_string($linkURLString);
					 $linkValue = $answer;
					 $options = array(
						 'class' => 'notification-link'
					 );
					 $Link = new Link($href,$linkValue,$options);
					 $notificationLink = $Link->buildLink();

					 /**
					  * Puts the notification values into the array.
					  */
					 $returnValue[$arrayCount][$index] = $this->buildNotificationOutput(
						 $function['TIMESTAMP'],
						 $this->Icons->questionCircle,
						 'A question you\'re following received an answer:  '. $notificationLink,
						 $function['user_id']
					 );

					 /**
					  * Increments the index where the previous foreach has left off.
					  * This is done to continue building the array off the last array.
					  */
					 $index++;
				 }
				 /**
				  * Increment the arrayCount to keep track of each notifications' array.
				  */
				 $arrayCount++;
		    break;
		    case 'likedMyAnswers':
			    /**
			     * Increment the arrayCount to keep track of each notifications' array.
			     */
			    $arrayCount++;

			    include_once(CLASSES . 'class.AskQuestionForum.php');
			    $AskQuestionForum = new AskQuestionForum();

			    foreach ($this->newLikesOnUserAnswers() as $index => $function) {
				    require_once(CLASSES . 'class.ForumAnswers.php');
				    $ForumAnswers= new ForumAnswers();

				    /** The Answer's Data.   */
				    $AnswerArr = $ForumAnswers->getAnswersQuestionId($function['post_id']);
				    /** The Answer's question id.   */
				    $AnswersQuestionId = $AnswerArr['question_id'];

				    $answer = $this->General->trim_text($AnswerArr['answer'],80,true,true);
				    $linkURLString = $this->General->trim_text($AnswerArr['answer'],50,true,true);
				    /**
				     * Build the link for the @var:TextValue by using the Link call and
				     * adding the link properties.
				     * @var $notificationLink
				     */
				    $href = '/forum/'. $this->General->url_safe_string($AskQuestionForum->getQuestionSubcategory($AnswersQuestionId)).'/' .  $AnswersQuestionId .'/' .$this->General->url_safe_string($linkURLString);
				    $linkValue = $answer;
				    $options = array(
					    'class' => 'notification-link'
				    );
				    $Link = new Link($href,$linkValue,$options);
				    $notificationLink = $Link->buildLink();

				    /**
				     * Puts the notification values into the array.
				     */
				    $returnValue[$arrayCount][$index] = $this->buildNotificationOutput(
					    $function['TIMESTAMP'],
					    $this->Icons->thumbsUpSolid,
					    'Your answer:  '. $notificationLink . ' has recently received a like!',
					    $function['likers_user_id']
				    );

				    /**
				     * Increments the index where the previous foreach has left off.
				     * This is done to continue building the array off the last array.
				     */
				    $index++;
			    }
		    break;

		    case 'answeredQuestions':
			    /**
			     * Increment the arrayCount to keep track of each notifications' array.
			     */
			    $arrayCount++;

			    include_once(CLASSES . 'class.AskQuestionForum.php');
			    $AskQuestionForum = new AskQuestionForum();
			    $this->newFormAnswer();

			    foreach ($this->newFormAnswer() as $index =>$function) {

				    /** The */
				    $journalTitle = $function[0]['answer'];

				    /** Get the question's subcategory name  for the link. */
				    $subcategory =  $AskQuestionForum->getQuestionSubcategory( $function[0]['question_id'] );

				    /**
				     * Build the link for the @var:TextValue by using the Link call and
				     * adding the link properties.
				     * @var $notificationLink
				     */
				    $href = '/forum/' . $this->General->url_safe_string($subcategory) . '/' . $function[0]['question_id'] . '/' .$journalTitle;
				    $linkValue = $journalTitle;
				    $options = array(
					    'class' => 'notification-link'
				    );
				    $Link = new Link($href,$linkValue,$options);
				    $notificationLink = $Link->buildLink();

				    /**
				     * Puts the notification values into the array.
				     */
				    $returnValue[$arrayCount][$index] = $this->buildNotificationOutput(
					    $function[0]['TIMESTAMP'],
					    $this->Icons->solidCheckmark,
					    'Your Question received an answer: ' . $notificationLink ,
					    $function[0]['user_id']
				    );

				    /**
				     * Increments the index where the previous foreach has left off.
				     * This is done to continue building the array off the last array.
				     */
				    $index++;
			    }

			    break;
		   case 'followedUserJournal':
			   $arrayCount++;
			   /**
			    * array of new Journals post from users the user is following.
			    * @return array : journal post data.
			    */
			   foreach ($this->newJournalFromFollowedUser() as $index => $function) {

				   /**
				    * If the subcategory has more then one post then run this function,
				    * which will put put the second level posts into the first level returned
				    * array including the names above.
				    */

				   /**
				    * Create the outbound link.
				    */
				   $linkContent = (!empty($function['title'])) ? $function['title'] : substr($function['content'],0,50);
				   $href = '/families-of-drug-addicts/journal-' .  $function['id'] .'/' .$this->General->url_safe_string($linkContent);
				   $linkValue = $linkContent;
				   $options = array(
					   'class' => 'notification-link'
				   );

				   $Link = new Link($href,$linkValue,$options);
				   $notificationLink = $Link->buildLink();

				   $returnValue[$arrayCount][$index] = $this->buildNotificationOutput(
					   $function['timestamp'],
					   $this->Icons->comment,
					   'New journal '. $notificationLink . ' from a user your following.',
					   $function['user_id']
				   );


			   }
		    break;

		    case  'followedUsers':
			    $arrayCount++;
			    foreach ($this->newFollowedUser() as $index => $function) {

				    /** If the logged in user is the person who followed a user generate data here.  */
				    if($function['followers_id'] == $this->userId):

					    /** The user Id of the person who is the other user. */
					    $thisUserId = $function['follow_user_id'];

					    $LinkContent = User::Username( $thisUserId);

					    $href = '/profile/user-'.$thisUserId.'/'.$LinkContent.'/';
					    $linkValue = $LinkContent;
					    $options = array(
						    'class' => 'notification-link'
					    );
					    $Link = new Link($href,$linkValue,$options);

				    /** If the logged in user was the user being followed generate the data here */
				    else:
					    /** The user Id of the person who is the other user. */
					    $thisUserId = $function['followers_id'];

					    $LinkContent = User::Username( $thisUserId );

					    $href = '/profile/user-'.$thisUserId.'/'.$LinkContent.'/';
					    $linkValue = $LinkContent;
					    $options = array(
						    'class' => 'notification-link'
					    );
					    $Link = new Link($href,$linkValue,$options);
				    endif;

				    $notificationLink = $Link->buildLink();


				    /** If the logged in user is the person who followed a user generate data here.  */
				    if($function['followers_id'] == $this->userId):

					    if($function['status'] == 1):
						    $textValue = "You have recently began following " . $notificationLink;
					    elseif($function['status'] == 0) :
						    $textValue = "You have recently un-followed " . $notificationLink;
					    endif;

				    /** If the logged in user was the user being followed generate the data here */
				    else:

					    if($function['status'] == 1):
						    $textValue = "A user named: " .$notificationLink . ' has recently started following you.';
					    elseif($function['status'] == 0) :
						    $textValue = "A user named: " .$notificationLink . ' has recently un-followed you.';
					    endif;
				    endif;

				    /**
				     * Puts the notification values into the array.
				     */
				    $returnValue[$arrayCount][$index] = $this->buildNotificationOutput(
					    $function['TIMESTAMP'],
					    $this->Icons->starSolid,
					    $textValue,
					    $thisUserId
				    );

				    /**
				     * Increments the index where the previous foreach has left off.
				     * This is done to continue building the array off the last array.
				     */
				    $index++;
			    }

			    /**
			     * Increment the arrayCount to keep track of each notifications' array.
			     */
			    $arrayCount++;
	        break;
	    endswitch;


        // section -64--88-0-19-15e7d721:161c304f503:-8000:00000000000010DB end

        return (array) $returnValue;
    }

} /* end of class ActivityFilter */

?>