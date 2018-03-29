<?php
/**
 * File For: HopeTracker.com
 * File Name: ForumPostStatus.php.
 * Author: Mike Giammattei
 * Created On: 9/21/2017, 12:41 PM
 */
include_once(CLASSES .'Sessions.php');
include_once(CLASSES .'Database.php');

class ForumPostStatus
{
    private $postId;
    private $Session;
    private $userId;
    private $postStatus;
    private $db;
    private $General;

    public $runCount;


    /**
     * ForumPostStatus constructor.
     * @param $postId

     */
    public function __construct($postId)
    {
        $this->postId = $postId;
        $this->Session = new Sessions();
        $this->General = new General();
        $this->runCount = 0;
    }

    /**
     * @return mixed
     */
    private function getUserId()
    {
        if($this->Session->get('logged_in') == 1){
            $this->userId = $this->Session->get('user-id');
        }else{
            $this->userId = false;
        }
        return $this->userId;
    }

    /**
     * Check if the post has been viewed by
     * the user.
     * @return boolean
     */
    private function getPostStatus()
    {
        $this->db = new Database();
        $sql = $this->db->prepare("SELECT id FROM new_forum WHERE forum_id = ? AND user_id = ?");
        $sql->execute(array($this->postId, $this->getUserId()));

        if($sql->rowCount() > 0){
            $this->postStatus = true;
        }else{
            $this->postStatus = false;
        }
        return $this->postStatus;
    }
    /**
     * Sets the post as viewed if the has
     * seen the post for the first time.
     */
    public function setPostStatus()
    {
        if($this->getPostStatus() == false){
            $this->db = new Database();
            $sql = $this->db->prepare("INSERT INTO new_forum (forum_id, user_id, ip, date_view) VALUES (?,?,?,?)");
            $sql->execute(array(
                $this->postId,
                $this->getUserId(),
                $this->General->getUserIP(),
                time()
            ));
        }
        return null;
    }


    /**
     * Main function that returns any forum post
     * the user is following that has not been viewed.
     * @return null
     */
    public function main()
    {
        $this->setPostStatus();
    }

}