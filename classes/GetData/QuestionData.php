<?php

error_reporting(3);
include_once($_SERVER['DOCUMENT_ROOT'].'/hopetracker/config/constants.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/hopetracker/classes/DebugMg.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/hopetracker/classes/User.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/hopetracker/classes/Database.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/hopetracker/classes/General.php');

    class QuestionData extends DebugMg {

        public $Debug;
        public $General;
        private $User;
        protected $DB;

        public $questions;
        public $Information = array();
        public $Errors = array();
        public function __construct(){
            parent::__construct();
            $this->User = new User();
            $this->General = new General();
            $this->questions = $this->getUnsentCMQuestionData();
        }
        public function getUnsentCMQuestionData(){
            $this->DB = new Database();
            //$sql = $this->DB->prepare("SELECT DISTINCT user_id FROM ask_question_forum WHERE CampaignMonitor = 0");
            $sql = $this->DB->prepare("SELECT * FROM ask_question_forum  WHERE CampaignMonitor = 0 GROUP BY user_id");
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $sql->execute();

            return $sql->fetchAll();
        }
        public function authorQuestions($userId, $filter = false){
            $this->DB = new Database();

            switch ($filter):
                case 'first question' :
                    $sql = $this->DB->prepare("SELECT * FROM ask_question_forum WHERE user_id = ? ORDER BY id ASC LIMIT 1");
                    $sql->setFetchMode(PDO::FETCH_ASSOC);
                    $sql->execute(array($userId));
                    return $sql->fetch();
                break;
                case 'latest question':
                    /** Check if user has multiple questions */
                    $sql = $this->DB->prepare("SELECT COUNT(*) FROM ask_question_forum WHERE user_id = ?");
                    $sql->execute(array($userId));
                    $questionCount = $sql->fetch(PDO::FETCH_COLUMN);

                    if($questionCount > 1 ){
                        unset($sql);
                        $sql = $this->DB->prepare("SELECT * FROM ask_question_forum WHERE user_id = ? ORDER BY id  DESC  LIMIT 1 ");
                        $sql->setFetchMode(PDO::FETCH_ASSOC);
                        $sql->execute(array($userId));

                        return $sql->fetch();
                    }else{
                        return false;
                    }

                default : return  null;
            endswitch;
        }
        public function answerToAuthorsQuestion($questionId, $filter = false){

            $this->DB = new Database();

            switch ($filter):
                case 'first answer' :
                    $sql = $this->DB->prepare("SELECT * FROM answers_forum WHERE `question_id` = :questionId ORDER BY id ASC LIMIT 1");
                    $sql->setFetchMode(PDO::FETCH_ASSOC);
                    $sql->bindParam(':questionId', $questionId, PDO::PARAM_INT);
                    $sql->execute();
                    return $sql->fetch();
                    break;
                case 'latest answer':

                    /** Check if user has multiple questions */
                 /*   $sql = $this->DB->prepare("SELECT COUNT(*) FROM answers_forum WHERE question_id = ?");
                    $sql->execute(array($questionId));
                    $questionCount = $sql->fetch(PDO::FETCH_COLUMN);*/

                  /*  if($questionCount > 1){*/
                        $sql = $this->DB->prepare("SELECT * FROM answers_forum WHERE `question_id` = :questionId ORDER BY id DESC LIMIT 1");
                        $sql->setFetchMode(PDO::FETCH_ASSOC);
                        $sql->bindParam(':questionId', $questionId, PDO::PARAM_INT);
                        $sql->execute();
                        return $sql->fetch();
                   /* }else{
                        return false;
                    }*/

                default : return  null;
            endswitch;
        }
        public function totalAnswersToQuestion($answer_id){
            $this->DB = new Database();

            $sql = $this->DB->prepare("SELECT COUNT(*) FROM answers_forum WHERE `question_id` = :questionId");
            $sql->bindParam(':questionId', $answer_id, PDO::PARAM_INT);
            $sql->execute();

            return $sql->fetch(PDO::FETCH_COLUMN);

        }
        public function build(){
            foreach( $this->questions as $index => $question){
                $AuthorEmail = User::users_email($question['user_id']);

                /** Author's first question array */
                $authorQuestions = $this->authorQuestions($question['user_id'],'first question');

                /** Author's Latest question array - If author has multiple questions. */
                $authorLatestQuestions = $this->authorQuestions($question['user_id'],'latest question');

                /** First Answer array of author's first question */
                $firstAnswerToAuthorFirstQuestion = $this->answerToAuthorsQuestion($question['id'],'first answer');

                /** URL to the first question */
                $firstQuestionURL = DYNAMIC_URL . 'forum/' .$this->General->url_safe_string( $authorQuestions['subcategory']). '/'. $authorQuestions['id']  . '/' .  $this->General->url_safe_string( $authorQuestions['question']);

                /** Total number of answers to the first question asked by the author*/
                $totalAnswersToFirstQuestion = $this->totalAnswersToQuestion($question['id']);

                /** Latest Answer array of author's first question */
                $LatestAnswerToAuthorFirstQuestion = $this->answerToAuthorsQuestion($question['id'],'latest answer');
                //Debug::data($LatestAnswerToAuthorFirstQuestion);

                if(!empty($AuthorEmail)){
                        $this->Information[$index]['id'] = $authorQuestions['id'];
                        $this->Information[$index]['Author Email'] = $AuthorEmail;
                        $this->Information[$index]['Author Name'] = User::full_name($authorQuestions['user_id']);
                        $this->Information[$index]['Date of first question asked'] = date('m/d/y',$authorQuestions['date_created']);
                        $this->Information[$index]['First question asked text'] = $this->General->trim_text($authorQuestions['question'],'150');
                        $this->Information[$index]['Date of first answer for first question asked'] = date("m/d/y", $firstAnswerToAuthorFirstQuestion['date_created']);
                        $this->Information[$index]['Author of first answer for first question asked'] = User::full_name($firstAnswerToAuthorFirstQuestion['user_id']);
                        $this->Information[$index]['First answer text for first question asked'] = $this->General->trim_text($firstAnswerToAuthorFirstQuestion['answer'],150);
                        $this->Information[$index]['URL to question of first question asked'] = $firstQuestionURL;
                        $this->Information[$index]['Answer count of first question asked'] = $totalAnswersToFirstQuestion;

                        /** Get latest answer if there are multiple answers. */
                        if($totalAnswersToFirstQuestion > 1){

                            $this->Information[$index]['Author of latest answer of first question asked'] = User::full_name($LatestAnswerToAuthorFirstQuestion['user_id']);
                            $this->Information[$index]['Latest answer text of first question asked'] =  $this->General->trim_text($LatestAnswerToAuthorFirstQuestion['answer'],150);

                        }

                    /** Latest Question */
                    if(count($authorLatestQuestions) > 1){

                        /** Latest Answer array of author's first question */
                        $LatestAnswerToAuthorLatestQuestion = $this->answerToAuthorsQuestion($authorLatestQuestions['id'],'latest answer');

                        $this->Information[$index]['Date of Latest question asked'] = date('m/d/y',$authorLatestQuestions['date_created']);
                        $this->Information[$index]['Latest question asked text'] = $this->General->trim_text($authorLatestQuestions['question'],'150');

                        /** If the latest question has an answer, get data */
                        /** Total number of answers to the latest question asked by the author*/
                        $totalAnswersToLatestQuestion = $this->totalAnswersToQuestion($authorLatestQuestions['id']);
                        if($totalAnswersToLatestQuestion > 0){
                            $this->Information[$index]['Date of first answer for latest question asked'] = date("m/d/y", $LatestAnswerToAuthorLatestQuestion['date_created']);
                            $this->Information[$index]['Author of first answer for latest question asked'] = User::full_name($LatestAnswerToAuthorLatestQuestion['user_id']);
                            $this->Information[$index]['First answer text for latest question asked'] = $this->General->trim_text($LatestAnswerToAuthorLatestQuestion['answer'],150);
                        }

                        /** URL to the latest question */
                        $latestQuestionURL = DYNAMIC_URL . 'forum/' .$this->General->url_safe_string( $authorLatestQuestions['subcategory']). '/'. $authorLatestQuestions['id']  . '/' .  $this->General->url_safe_string( $authorLatestQuestions['question']);
                        $this->Information[$index]['URL to latest question asked'] = $latestQuestionURL;


                        $this->Information[$index]['Answer count of latest question asked'] = $totalAnswersToLatestQuestion;

                        /** If the latest question has an answer, get data */
                        if($totalAnswersToLatestQuestion > 1) {
                            Debug::data($LatestAnswerToAuthorLatestQuestion);
                            $this->Information[$index]['Author of latest answer of latest question asked'] = User::full_name($LatestAnswerToAuthorLatestQuestion['user_id']);
                            $this->Information[$index]['Latest answer text of latest question asked'] = $this->General->trim_text($LatestAnswerToAuthorLatestQuestion['answer'], 150);
                        }
                    }

                }

            }
           // Debug::data($this->Information);
            return $this->Information;
        }
    }

/*$this->setError(array(
    'Type' => 'Form',
    'Sub Type' => 'Main Insurance Form',
    'Error' => "User's data did not get stored into Campaign Monitor"
));*/