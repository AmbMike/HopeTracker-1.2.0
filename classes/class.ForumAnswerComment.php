<?php

error_reporting( 3 );
require_once( CLASSES . 'Database.php' );
require_once( CLASSES . 'Sessions.php' );
require_once( CLASSES . 'General.php' );
include_once(CLASSES .'class.Notifications.php');
include_once(CLASSES . 'User.php');

class ForumAnswerComment{
    private $Session;
    private $userId;
    private $General;
    private $Database;
    private $user;

    public function __construct()
    {
        $this->Session = new Sessions();
        $this->General = new General();
        $this->user = new User();

        /** Run methods if user is logged in */
        if($this->Session->get('logged_in') ==  1):
            $this->userId = $this->Session->get( 'user-id' );
        endif;
    }

    public function storeComment($data)
    {
        $returnValue = array();

        // section -64--88-0-17--e38ad68:1602d4487e4:-8000:0000000000000DA0 begin
        $Notifications = new Notifications();
        $this->Database = new Database();

        if (!empty($data['content'])) {
            $sql = $this->Database->prepare("INSERT INTO comments (post_type, parent_post_type, parent_post_id, post_user_id, ip, content, `timestamp`) VALUES(?,?,?,?,?,?,?)");
            $sql->execute(array(
                $data['post_type'],
                $data['parent_post_type'],
                $data['parent_post_id'],
                $this->userId,
                $this->General->getUserIP(),
                $data['content'],
                time()
            ));

            $lastInsertedID = $this->Database->lastInsertId();

            include_once(CLASSES . 'class.JournalPosts.php');
            $JournalPost = new JournalPosts();

            $thePostArr = $JournalPost->getSinglePost($data['parent_post_id']);

            $sql = $this->Database->prepare("INSERT INTO unviewed_posts (post_Type, post_id, user_id, ip, notify_user_id ) VALUES(?,?,?,?,?)");
            $sql->execute(array(
                $data['post_type'],
                $lastInsertedID,
                $this->userId,
                $this->General->getUserIP(),
                $thePostArr['user_id'],

            ));

            if($sql->rowCount() > 0){
                $returnValue['status'] = 'Success';
                $returnValue['userId'] = $this->userId;
                $returnValue['usernameUrl'] = $this->General->url_safe_string(User::Username($this->userId));
                $returnValue['usernameFormatted'] = User::Username($this->userId);
                $returnValue['entryDate'] = date('j F Y H:i', time());
                $returnValue['state'] = User::user_info('state', $this->userId);
                $returnValue['zip'] = User::user_info('zip', $this->userId);
                $returnValue['postId'] = $this->Database->lastInsertId();;
                $returnValue['userProfile'] = $this->user->get_user_profile_img( false, $this->userId );

            }else {
                $returnValue['status'] = 'Failed';
            }
            echo json_encode($returnValue);
        }

        // section -64--88-0-17--e38ad68:1602d4487e4:-8000:0000000000000DA0 end

        return (array) $returnValue;
    }
    public function getAnswerComment($parentPostId = false){
        $returnValue = array();
        $this->Database = new Database();
        if($parentPostId != false){
            $sql = $this->Database->prepare("SELECT * FROM comments WHERE parent_post_id = ? ORDER BY id ASC");
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $sql->execute(array(
                $parentPostId
            ));
            if($sql->rowCount() > 0){
                $returnValue = $sql->fetchAll();
            }
        }

        return $returnValue;
    }
}