<?php

/**
 * File For: HopeTracker.com
 * File Name: pagination.php.
 * Author: Mike Giammattei
 * Created On: 5/26/2017, 3:56 PM
 */
include_once(CLASSES . 'Comments.php');

class Pagination{

    /* Get the count of items */
    public function btn_qty($item_count, $per_page){
        $num_of_btns = ceil($item_count / $per_page);
        return $num_of_btns;
    }
    public function update_c_to_c($data){
        $Comments = new Comments();

        /* Build the start and end points for limit */
        $start_point = $data['page_val'] * 3 - 3 ;
        $data_out = $Comments->show_comment_of_comment($data['parent_post_id'],$data['parent_comment_id'],$data['parent_comment_user_id'],$start_point,3, false,true);
        $reversed_data = array_reverse($data_out['comments']);
        echo json_encode($reversed_data);
    }

}