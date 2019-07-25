<?php

/**
 * FileName: QuestionFilter.php
 * Description:
 *
 * Created by: Ambrosia Digital Team.
 * Author: Michael Giammattei
 * Date: 7/8/2019
 */

include_once(CLASSES .'Sessions.php');
include_once(CLASSES .'Database.php');
include_once(CLASSES .'General.php');


class QuestionFilter
{

    private $Sessions, $Database, $General;

    public function __construct(){
        $this->Sessions = new Sessions();
        $this->General = new General();
        $this->Database = new Database();
    }

    private function incrementTotalPostField($data){
        $returnValue = array();

        foreach ($data as $key => $item) {

            if(isset($returnValue[$item['post_id']])){
                $postTotal = $returnValue[$item['totalPost']];
                $returnValue[$item['post_id']] = ($item['totalPost'] + $postTotal);
            }else{
                $returnValue[$item['post_id']] = ($item['totalPost']);
            }

        }
        arsort($returnValue);
        return $returnValue;
    }
    public function TopQuestions(){
        $sql = $this->Database->prepare("
            SELECT post_id, COUNT(post_id) as totalPost FROM followed_posts WHERE post_type <> '' GROUP BY post_id
            UNION
            SELECT question_id, COUNT(question_id) as totalPost FROM answers_forum WHERE question_id <> '' GROUP BY question_id");

        $sql->setFetchMode(PDO::FETCH_COLUMN);
        $sql->execute();

        return $this->incrementTotalPostField($sql->fetchAll());
    }

}