<?php
/**
 * File For: HopeTracker.com
 * File Name: ForumNewObj.php.
 * Author: Mike Giammattei
 * Created On: 9/20/2017, 4:01 PM
 */
include_once(CLASSES .'Forum.php');
include_once(CLASSES .'ForumPostStatus.php');

class ForumFollowedCategory
{
    private $user_id, $Session, $User,$db,$Forum,$viewedPostIds;

    public $newPosts = array();

    /**
     * ForumFollowedCategory constructor.
     * @Sessions the user's Session class
     * @User the user's User Class
     */
    public function __construct()
    {
        $this->Session = new Sessions();
        $this->User = new User();
        $this->Forum = new Forum();
        $this->viewedPostIds = array();

    }

    /**
     * Gets the user id
     * @return user id
     */
    private function getUserId(){
        $this->user_id =  $this->Session->get('user-id');
        return $this->user_id;
    }
    /**
     * Get an array of forum categories "sub_cat_id"
     * and the timestamp the user began following the
     * subcategory.
     * @return array of forum posts sub_cat_id and timestamp
     */
    private function getFollowedCategoriesData(){
        $this->db = new Database();
        $sql = $this->db->prepare("SELECT sub_cat_id, TIMESTAMP FROM forum_fol_sub_cat WHERE user_id = ?");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($this->getUserId()));
        return $sql->fetchAll();
    }
    /**
     * Gets the subcategory ids from the Forum Class
     * @param $subcategoryId
     * @return mixed
     */
    private function getSubCategoryArr($subcategoryId){
        return $this->Forum->get_sub_category_forum($subcategoryId);
    }
    /**
     * @return array of viewed posts ids
     */
    public function getFollowedPostIds(){
        $this->db = new Database();
        $sql = $this->db->prepare("SELECT forum_id FROM new_forum WHERE  user_id = ?");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array( $this->getUserId()));

        $this->viewedPostIds = array_map('current', $sql->fetchAll());
        return $this->viewedPostIds;
    }

    /**
     * Pull forum post from followed subcategories
     * posted after the user began following the subcategory
     * @param $subcategoryIds
     * @return Forum->posts
     */
    private function getNewPost($subcategoryIds, $timestamp){

        /** @var $alreadyViewedPostIds array of forum post already viewed by the user. */
        $alreadyViewedPostIds = implode(',',$this->getFollowedPostIds());

        $this->db = new Database();
        if(!empty($alreadyViewedPostIds)){
            $sql = $this->db->prepare("SELECT * FROM forum_post WHERE sub_category_id = ? AND TIMESTAMP > ? AND id NOT IN (".$alreadyViewedPostIds.")");
        }else{
            $sql = $this->db->prepare("SELECT * FROM forum_post WHERE sub_category_id = ? AND TIMESTAMP > ?");
        }

        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($subcategoryIds, $timestamp));
        return $sql->fetchAll();
    }

    /**
     * Serves the user the new forum post or
     * returns nothing back.
     * @return array|bool
     */
    public function newForumPost(){

        if($this->Session->get('logged_in') == true){
            /**
             * Put the followed subcategory names into
             * an array.
             */
            $followedCategory = $this->getFollowedCategoriesData();

            foreach ($followedCategory as $index => $categoryData) {
                /**
                 * Get the list of category names by category id
                 */
                $subcategoryArr = $this->getSubCategoryArr($categoryData['sub_cat_id']);

                /* Subcategory name */
                $this->newPosts[$index]['SubCategoryName'] = $subcategoryArr['sub_category'];

                /* Timestamp of when the user began following the subcategory */
                $this->newPosts[$index]['FollowedTimestamp'] = $categoryData['TIMESTAMP'];

                $this->newPosts[$index]['parent_category'] =  $this->Forum->get_parent_category($this->Forum->get_sub_category_forum($categoryData['sub_cat_id'])['parent_category_id']);
                /* An array of the forum post that are new to the user */
                $this->newPosts[$index]['Posts'] = $this->getNewPost($categoryData['sub_cat_id'], $categoryData['TIMESTAMP']);

            }
            /**
             * Return the followed forum post array with
             * the subcategory name and forum post data.
             */
            return $this->newPosts;


        }else{
            return false;
        }
    }


}