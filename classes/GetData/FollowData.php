<?php

error_reporting(3);
include_once($_SERVER['DOCUMENT_ROOT'].'/hopetracker/config/constants.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/hopetracker/classes/DebugMg.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/hopetracker/classes/User.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/hopetracker/classes/Database.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/hopetracker/classes/General.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/hopetracker/classes/class.ForumQuestions.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/hopetracker/classes/GetData/QuestionData.php');

    class FollowData extends DebugMg {

        public $Debug;
        public $General;
        public $ForumQuestions;
        public $QuestionData;
        private $User;
        protected $DB;

        public $follows;
        public $Information = array();
        public $Errors = array();
        public function __construct(){

            parent::__construct();
            $this->User = new User();
            $this->General = new General();
            $this->ForumQuestions = new ForumQuestions();
            $this->QuestionData = new QuestionData();
            $this->follows = $this->getUnsentCMFollowData();
        }
        public function getUnsentCMFollowData(){
            $this->DB = new Database();
            $sql = $this->DB->prepare("SELECT * FROM followed_posts  WHERE post_type = 3 GROUP BY follows_user_id");
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $sql->execute();

            return $sql->fetchAll();
        }
        public function followersQuestions($userId, $filter = false){
            $this->DB = new Database();

            switch ($filter):
                case 'first followed question' :
                    $sql = $this->DB->prepare("SELECT * FROM followed_posts WHERE follows_user_id = ? ORDER BY id ASC LIMIT 1");
                    $sql->setFetchMode(PDO::FETCH_ASSOC);
                    $sql->execute(array($userId));
                    return $sql->fetch();
                break;
                case 'latest followed question':
                    /** Check if user has multiple questions */
                    $sql = $this->DB->prepare("SELECT COUNT(*) FROM followed_posts WHERE follows_user_id = ?");
                    $sql->execute(array($userId));
                    $questionCount = $sql->fetch(PDO::FETCH_COLUMN);

                    if($questionCount > 1 ){
                        unset($sql);
                        $sql = $this->DB->prepare("SELECT * FROM followed_posts WHERE follows_user_id = ? ORDER BY id  DESC  LIMIT 1 ");
                        $sql->setFetchMode(PDO::FETCH_ASSOC);
                        $sql->execute(array($userId));

                        return $sql->fetch();
                    }else{
                        return false;
                    }

                default : return  null;
            endswitch;
        }

        public function build(){

            foreach ($this->follows as $index => $follower):
                $followerEmail = User::users_email($follower['follows_user_id']);

                /** Follower's first followed question pre post data */
                $firstQuestionFollowed = $this->followersQuestions($follower['follows_user_id'], 'first followed question');

                /** Follower's first question array */
                $firstFollowedQuestionArr = $this->ForumQuestions->getQuestionByQuestionId($follower['post_id']);

                /** First Answer array of author's first question */
                $firstAnswerToAuthorFirstQuestion = $this->QuestionData->answerToAuthorsQuestion($follower['post_id'],'first answer');

                /** URL to the first question */
                $firstQuestionURL = DYNAMIC_URL . 'forum/' .$this->General->url_safe_string( $firstFollowedQuestionArr['subcategory']). '/'. $firstFollowedQuestionArr['id']  . '/' .  $this->General->url_safe_string( $firstFollowedQuestionArr['question']);

                /** Total number of answers to the first question asked by the author*/
                $totalAnswersToFirstQuestionFollowed = $this->QuestionData->totalAnswersToQuestion($firstFollowedQuestionArr['id']);

                if(!empty($followerEmail)) {
                    /*$this->Information[$index]['id'] = $authorQuestions['id'];*/
                    $this->Information[$index]['Name of follower'] = User::full_name($follower['follows_user_id']);
                    $this->Information[$index]['Email address of follower'] = $followerEmail;
                    $this->Information[$index]['Date of first question followed'] = date('m/d/y', $firstQuestionFollowed['date_created']);
                    $this->Information[$index]['First question followed'] = $this->General->trim_text($firstFollowedQuestionArr['question'],'150');
                    $this->Information[$index]['Date of first answer for first question followed'] = date("m/d/y", $firstFollowedQuestionArr['date_created']);;
                    $this->Information[$index]['Author of first answer for first question followed'] = User::full_name($firstFollowedQuestionArr['user_id']);;
                    $this->Information[$index]['First answer for first question followed'] = $this->General->trim_text($firstAnswerToAuthorFirstQuestion['answer'],150);
                    $this->Information[$index]['URL to question of first question followed'] = $firstQuestionURL;
                    $this->Information[$index]['Answer count of first question followed'] = $totalAnswersToFirstQuestionFollowed;
                    /** Get latest answer if there are multiple answers. */
                    if($totalAnswersToFirstQuestionFollowed > 1){

                        /** Latest Answer array of author's first question */
                        $LatestAnswerToAuthorFirstQuestion = $this->QuestionData->answerToAuthorsQuestion($firstFollowedQuestionArr['id'],'latest answer');

                        $this->Information[$index]['Author of latest answer of first question followed'] = User::full_name($LatestAnswerToAuthorFirstQuestion['user_id']);
                        $this->Information[$index]['Latest answer text of first question asked'] =  $this->General->trim_text($LatestAnswerToAuthorFirstQuestion['answer'],150);

                    }

                    /** Follower's first followed question pre post data */
                    $LatestQuestionFollowed = $this->followersQuestions($follower['follows_user_id'], 'latest followed question');

                    /** Follower's first followed question pre post data */
                    $latestQuestionFollowed = $this->followersQuestions($follower['follows_user_id'], 'latest followed question');
                   // Debug::data($latestQuestionFollowed);
                    /** Follower's first question array */
                    $latestFollowedQuestionArr = $this->ForumQuestions->getQuestionByQuestionId($latestQuestionFollowed['post_id']);

                    /** Latest Question */
                    if(count($LatestQuestionFollowed) > 1){

                        /** Latest Answer array of author's first question */
                        $FirstAnswerToLatestFollowedQuestion = $this->QuestionData->answerToAuthorsQuestion($latestQuestionFollowed['post_id'],'first answer');

                        /** Latest Answer array of author's first question */
                        $LatestAnswerToAuthorLatestQuestion = $this->QuestionData->answerToAuthorsQuestion($latestQuestionFollowed['post_id'],'latest answer');

                        $this->Information[$index]['Date of Latest question asked'] = date('m/d/y',$latestFollowedQuestionArr['date_created']);
                        $this->Information[$index]['Latest question asked text'] = $this->General->trim_text($latestFollowedQuestionArr['question'],'150');

                        /** If the latest question has an answer, get data */
                        /** Total number of answers to the latest question asked by the author*/
                        $totalAnswersToLatestQuestion = $this->QuestionData->totalAnswersToQuestion($latestFollowedQuestionArr['id']);
                        if($totalAnswersToLatestQuestion > 0){
                            $this->Information[$index]['Date of first answer for latest question asked'] = date("m/d/y", $FirstAnswerToLatestFollowedQuestion['date_created']);
                            $this->Information[$index]['Author of first answer for latest question asked'] = User::full_name($FirstAnswerToLatestFollowedQuestion['user_id']);
                            $this->Information[$index]['First answer text for latest question asked'] = $this->General->trim_text($FirstAnswerToLatestFollowedQuestion['answer'],150);
                        }

                        /** URL to the latest question */
                        $latestQuestionURL = DYNAMIC_URL . 'forum/' .$this->General->url_safe_string( $latestFollowedQuestionArr['subcategory']). '/'. $latestFollowedQuestionArr['id']  . '/' .  $this->General->url_safe_string( $authorLatestQuestions['question']);
                        $this->Information[$index]['URL to latest question asked'] = $latestQuestionURL;

                        $this->Information[$index]['Answer count of latest question asked'] = $totalAnswersToLatestQuestion;

                        /** If the latest question has an answer, get data */
                        if($totalAnswersToLatestQuestion > 1) {
                           // Debug::data($LatestAnswerToAuthorLatestQuestion);
                            $this->Information[$index]['Author of latest answer of latest question asked'] = User::full_name($LatestAnswerToAuthorLatestQuestion['user_id']);
                            $this->Information[$index]['Latest answer text of latest question asked'] = $this->General->trim_text($LatestAnswerToAuthorLatestQuestion['answer'], 150);
                        }

                    }
                   //Debug::data($firstFollowedQuestionArr);
                }
            endforeach;

            //Debug::data($this->Information);
            //Debug::data($this->follows);

            return $this->Information;
        }
    }

/*$this->setError(array(
    'Type' => 'Form',
    'Sub Type' => 'Main Insurance Form',
    'Error' => "User's data did not get stored into Campaign Monitor"
));*/