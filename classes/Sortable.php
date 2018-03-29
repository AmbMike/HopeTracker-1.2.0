<?php

/**
 * File For: HopeTracker.com
 * File Name: Sortable.php.
 * Author: Mike Giammattei
 * Created On: 5/19/2017, 10:09 AM
 */
class Sortable{
    protected $db;

    function __construct(){
        $this->db = new Database();
    }

    public function sort_forum_categories($data){
        $outputs = array();
        $outputs_formatted = array();
        $i = 0;
        $out = array();

        $list = parse_str($data['list'], $outputs);

        foreach ($outputs as $key => $output) {

            $outputs_formatted[$key]['id'] = $output[0];
            $outputs_formatted[$key]['position'] = $i;
            $i++;

        }

        foreach ($outputs_formatted as $update_cat){
            $sql = $this->db->prepare("UPDATE `forum_categories` SET `position` = ? WHERE id = ? ");
            $sql->execute(array($update_cat['position'],$update_cat['id']));
        }


        //$out['rows'] = $sql->rowCount();
        //echo json_encode($data);

    }

}