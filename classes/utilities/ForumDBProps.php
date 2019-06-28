<?php
    /* Be sure to add a new field to the "ask_question_forum" table called, "pageIdentifier" */
?>

<?php

/**
 * FileName: ForumDBProps.php
 * Description:
 *
 * Created by: Ambrosia Digital Team.
 * Author: Michael Giammattei
 * Date: 4/30/2019
 */

/** Dependencies */
require_once(CLASSES . 'Database.php');
require_once(CLASSES . 'General.php');

class ForumDBProps
{
    private $DB;
    public $General;

    public function __construct(){
        $this->General = new General();
    }

    private function getPost($post_id){
        $this->DB = new Database();
        $sql = $this->DB->prepare("SELECT * FROM ask_question_forum WHERE id = ?");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($post_id));

        return $sql->fetch();

    }

    public function handleTableExistence($field){
        $this->DB = new Database();
        $sql = $this->DB->prepare("SHOW COLUMNS FROM ask_question_forum WHERE Field = ?");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($field));

        /** If field does not existed, create it */
        if(!$sql->fetch()){
            $sql = $this->DB->prepare("ALTER TABLE `ask_question_forum` ADD `pageIdentifier` VARCHAR(500) NOT NULL AFTER `id`");
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $sql->execute(array($field));
        }
    }

    private function updateURLIdentifier($postID, $updateValue = false){

        /** Create field if not exists */
        $this->handleTableExistence('pageIdentifier');

        $UrlIdentifierValue = null;

        if(!$updateValue){
            /** @var  $the_post : the post array*/
            $the_post = $this->getPost($postID);

            $UrlIdentifierValue = strtolower($the_post['question']);
            $UrlIdentifierValue = $this->General->word_limiter($UrlIdentifierValue,10);
            $UrlIdentifierValue = $this->General->url_safe_string($UrlIdentifierValue);
        }

        if(empty($the_post['pageIdentifier'])){
            $this->DB = new Database();
            $sql = $this->DB->prepare("UPDATE ask_question_forum SET pageIdentifier = ? WHERE id = ?");
            $sql->execute(array($UrlIdentifierValue, (int)$postID));
        }

        if($updateValue){
            $this->DB = new Database();
            $sql = $this->DB->prepare("UPDATE ask_question_forum SET pageIdentifier = ? WHERE id = ?");
            $sql->execute(array($updateValue, (int)$postID));
        }

    }


    private function duplicatePageIdentifiers(){

        $this->DB = new Database();
        $sql = $this->DB->prepare("SELECT `pageIdentifier`, COUNT(pageIdentifier) FROM ask_question_forum GROUP BY pageIdentifier HAVING COUNT(pageIdentifier) > 1 ");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();

        $resultDuplicate = $sql->fetchAll();

        /**
         * Loop through group of posts with same url value
         */
        foreach ($resultDuplicate as $index => $result):
            $sql = $this->DB->prepare("SELECT id FROM ask_question_forum WHERE `pageIdentifier` = ?");
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $sql->execute(array($result['pageIdentifier']));


            /**
             * Loop through each post group with same url value
             */
            $loopArr = $sql->fetchAll(PDO::FETCH_COLUMN);
            foreach ( $loopArr  as $index2 => $post_id) {

                /** Loop through duplicates and change pageIdentifier with new value */
                $updateValue = ($index2 != 0) ? $result['pageIdentifier'] . '-' . $index2 : $result['pageIdentifier'];
                $this->updateURLIdentifier($post_id,$updateValue);

            }
        endforeach;

    }

    private function postIDs(){
        $this->DB = new Database();
        $sql = $this->DB->prepare("SELECT id FROM ask_question_forum");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_COLUMN);
    }

    public function processUpdate(){
        /** Loop through all forum questions */
        foreach ($this->postIDs() as $postID) {

            /** Creates column and inserts the posts question as the page identifier. */
            $this->updateURLIdentifier($postID);
        }

        /** Appends a unique number to any post with duplicate questions */
        $this->duplicatePageIdentifiers();
    }

}