<?php
/**
 * File For: HopeTracker.com
 * File Name: UserObj.php.
 * Author: Mike Giammattei
 * Created On: 9/20/2017, 1:48 PM
 */
class UserObj
{
    private $db,$username,$fname,$lname,$user_id;

    /**
     * UserObj constructor.
     * @param $user_id
     */
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * Gets the database object
     * @return database object
     */
    public function getDb()
    {
        $this->db = new Database();
        return $this->db;
    }

    /**
     * Gets the username of from the users
     * list by the users user_id.
     * @return $this->username.
     */
    public function getUsername()
    {
        $sql = $this->getDb()->prepare("SELECT username FROM user_list WHERE id =?");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($this->user_id));
        $this->username = $sql->fetchColumn();
        return $this->username;
    }

    /**
     * Gets the first name of from the users
     * list by the users user_id.
     * @return $this->fname
     */
    public function getFname()
    {
        $sql = $this->getDb()->prepare("SELECT fname FROM user_list WHERE id =?");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($this->user_id));
        $this->fname = $sql->fetchColumn();
        return $this->fname;
    }

    /**
     * Gets the last name of from the users
     * list by the users user_id.
     * @return $this->lname
     */
    public function getLname()
    {
        $sql = $this->getDb()->prepare("SELECT lname FROM user_list WHERE id =?");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($this->user_id));
        $this->lname = $sql->fetchColumn();
        return $this->lname;
    }
}

