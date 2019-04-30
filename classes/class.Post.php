<?php

include_once(CLASSES . 'Database.php');
class Post{
    private $database;

    public function get($postTypeId,$postId){
        $this->database = new Database();
        $sql = null;
        $returnValue = null;
        switch ($postTypeId){
            case 7 :
                $sql = $this->database->prepare("SELECT content FROM comments WHERE id = ?");
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute(array($postId));
                $returnValue = $sql->fetchColumn();
                break;
            case 4 :
                $sql = $this->database->prepare("SELECT answer FROM answers_forum WHERE id = ?");
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute(array($postId));
                $returnValue = $sql->fetchColumn();
                break;
            case 3 :
                $sql = $this->database->prepare("SELECT question,description FROM ask_question_forum WHERE id = ?");
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute(array($postId));
                $data = $sql->fetchAll();
                $returnValue = 'Question: ' . $data[0]['question'] . '<br>';
                $returnValue .= 'Description: ' . $data[0]['description'];
                break;
        }

        return $returnValue;
    }
    public function delete($data){
        $this->database = new Database();
        $sql = null;
        $returnValue = null;
        switch ($data['postType']){
            case 7 :
                $sql = $this->database->prepare("DELETE FROM comments WHERE id = ?");
                $sql->execute(array($data['postId']));
                break;
            case 4 :
                $sql = $this->database->prepare("DELETE FROM answers_forum WHERE id = ?");
                $sql->execute(array($data['postId']));
                break;
            case 3 :
                $sql = $this->database->prepare("DELETE FROM ask_question_forum WHERE id = ?");
                $sql->execute(array($data['postId']));
                break;
        }
        if($sql->rowCount() > 0){
            include_once(CLASSES.'class.FlagPost.php'); // Admin Class\
            $FlagPost= new FlagPost();

            if($FlagPost->delete($data['flagId']) == true){
                $returnValue['status'] = "Success";
            }


        }else{
            $returnValue['status'] = "Failed";
            return false;
        }
        echo json_encode($returnValue);

        return $returnValue;
    }
}