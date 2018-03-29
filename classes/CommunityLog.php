<?php
/**
 * File For: HopeTracker.com
 * File Name: CommunityLog.php.
 * Author: Mike Giammattei
 * Created On: 8/18/2017, 1:09 PM
 */

include_once(CLASSES. 'Journal.php');

class CommunityLog extends Journal {
    public function content($user_id){
        $Journal = new Journal();

        return $Journal->users_journal_likes($user_id);
    }
    public function user_liked_commented_on_journal(){
        $db = new Database();
        $Session = new Sessions();

        /* Get a list of the users journal ids */
       $owned_journals = parent::journal_owner_id($Session->get('user-id'),['journal_id']);
       $user_journal_ids = array_map('current',$owned_journals);

       $journal_ids = implode(',',$user_journal_ids);
       $sql = $db->prepare("SELECT * FROM journal_comments WHERE journal_id in (".$journal_ids.")");
       $sql->setFetchMode(PDO::FETCH_ASSOC);
       $sql->execute();

       return $sql->fetchAll();
    }
    public function users_following(){
        $db = new Database();
        $Session = new Sessions();

        $sql = $db->prepare("SELECT * FROM follow_user WHERE followers_id = ? AND status = 1");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($Session->get('user-id')));

        return $sql->fetchAll();
    }
    public function new_journals_from_followed_users(){

        $Journal = new parent();
        $new_journals = array();
        $new_journal_out = array();
        $Session = new Sessions();

        /* Get array of users the user is following */
        foreach ($this->users_following() as $followed_user) {
            $new_journals[] =  $Journal->journal_by_user_id($followed_user['follow_user_id']);

        }

        $flattenArray = [];
        foreach ($new_journals as $childArray) {
            foreach ($childArray as $value) {
                $flattenArray[] = $value;
            }
        }
        /* Get journals that have not already been vied by the user */
        foreach ($flattenArray as $index => $journals) {
            if($Journal->new_journal($journals['id']) == false){

                /* Get Journals that have been created after a user began following the user */
                $date1 = new DateTime($Journal->began_following_user($followed_user['follow_user_id'],$Session->get('user-id')));
                $date2 = new DateTime( $Journal->journal_by_journal_id($journals['id'])['timestamp']);

                if ($date1->getTimestamp() < $date2->getTimestamp()) {

                	/** set journals array to match if the user is following or has un-followed user.  */
                    $followed_users_ids = $this->users_following();

                    $new_journal_out[] = $journals;

                }
            }
        }

       return $new_journal_out;
    }
    public function new_forum_from_followed_users(){

        $Forum = new Forum();
        $new_forums = array();


        /* Get array of users the user is following */
        foreach ($this->users_following() as $followed_user) {
            $new_forums[] =  $Forum->get_followed_user_forum_by_user_id($followed_user['follow_user_id'],$followed_user['TIMESTAMP']);
        }
        $flattenArray = [];
        foreach ($new_forums as $childArray) {
            foreach ($childArray as $value) {
                $flattenArray[] = $value;
            }
        }



       return $flattenArray;
    }
    public function new_forum_post_on_sub_cat(){
        $Forum = new Forum();;

        /* Get array of sub cats user is following */
        $following_sub_cats = $Forum->get_sub_cats_following();

        /* Put subcategories in an array */
        $data_arr = array();
        foreach ($following_sub_cats as $index => $following_sub_cat):
            $data_arr[$index]['sub_category'] =  $Forum->get_sub_category_forum($following_sub_cat['sub_cat_id'])['sub_category'];
            $data_arr[$index]['parent_category'] =  $Forum->get_parent_category($Forum->get_sub_category_forum($following_sub_cat['sub_cat_id'])['parent_category_id']);
            $data_arr[$index]['sub_category_id'] =  $following_sub_cat['sub_cat_id'];
            $data_arr[$index]['started_following_sub_category'] =  $following_sub_cat['TIMESTAMP'];
        endforeach;

        /* get all post for each of the followed subcategories */
        $post_data = array();
        unset($index);
        foreach ($data_arr as $index => $data) {
            $post_data[$index]['post_data'] = $data;

            /* Check to see if the forum post was created after the user started following the subcategory */

            $post_data[$index]['post_arr'] = $Forum->new_post_for_sub($data['sub_category_id']);

           /* foreach ($Forum->get_post_for_sub_category($data['sub_category_id']) as $item) {
                $post_data[$index]['started_following'] = $Forum->started_following_sub_cat($item['sub_category_id']);
            }*/

        }


        return $post_data;
    }


}