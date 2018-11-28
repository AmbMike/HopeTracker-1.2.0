<?php

include_once(CLASSES . 'Database.php');
class PostType{
    private $database;

    public function getPostType($postTypeId = false){
        $this->database = new Database();

        if ($postTypeId != false) {
            $sql = $this->database->prepare("SELECT post_Type FROM post_types WHERE id = ?");
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $sql->execute(array($postTypeId));

            return $sql->fetchColumn();
        }

    }
}