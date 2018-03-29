<?php
/**
 * File For: HopeTracker.com
 * File Name: Inspiration.php.
 * Author: Mike Giammattei
 * Created On: 7/20/2017, 2:52 PM
 */

include_once(CLASSES.'Forms.php');
include_once(CLASSES.'General.php');
include_once (CLASSES. 'Sessions.php');
include_once (CLASSES. 'Database.php');

class Inspiration{
    public function add_inspiration_images_from_dir(){
        $db = new Database();
        $Session = new Sessions();

        $dir    = ABSOLUTE_PATH_NO_END_SLASH.IMAGES . 'quotes';
        $scanned_directory = array_diff(scandir($dir), array('..', '.'));
    }
    public function duplicated_filename($value_check){
        $db = new Database();
        $sql = $db->prepare("SELECT id FROM inspiration_quotes WHERE img_path =?");
        $sql->execute(array($value_check));
        if($sql->rowCount() > 0){
            return true;
        }
    }
    public function put_images_into_database(){
        $db = new Database();
        $Session = new Sessions();

        /* Get quote directory files */
        $dir    = ABSOLUTE_PATH_NO_END_SLASH.IMAGES . 'quotes';
        $scanned_directory = array_diff(scandir($dir), array('..', '.'));
        $scanned_directory = array_values($scanned_directory);
        $matches = array();
        $database_arr = array();
        foreach ($scanned_directory as $index => $item) {

            /* Get Category name form first part of the file name */
           preg_match('/[^.]*/', $item, $match);
            $database_arr[$index]['category'] = $match[0];
            $database_arr[$index]['filename'] = $item;
        }

        /* Input images to the database */
        foreach ($database_arr as $input) {

            if($this->duplicated_filename($input['filename']) != true) :
                $sql = $db->prepare("INSERT INTO inspiration_quotes (created_user_id, create_date, img_path, category) VALUES(?,?,?,?)");
                $sql->execute(array(
                    $Session->get('user-id'),
                    time(),
                    $input['filename'],
                    $input['category']
                    )
                );

                sleep(.5);
            endif;
        }
    }
    public function get_quote_images($by_category = false, $show_per_query = 30, $where_claus = false){
        $db = new Database();
        if($by_category == false && $where_claus == false):
            $sql = $db->prepare("SELECT * FROM `inspiration_quotes` ORDER BY TIMESTAMP DESC LIMIT 0, :limit ");
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $sql->bindParam('limit', $show_per_query, PDO::PARAM_INT);
            $sql->execute();
            return $sql->fetchAll();
        endif;
    }
    public function most_viewed_img(){
        $db = new Database();

        $sql = $db->prepare("SELECT img_id, COUNT(*) AS 'num_saves' FROM inspiration_quotes_saved GROUP BY img_id ORDER BY num_saves DESC");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();

        $saved_image = array();
        $image_arr = $sql->fetchAll();
        foreach ($image_arr as $saved_img){

            $sql = $db->prepare("SELECT * FROM `inspiration_quotes` WHERE id = ? ");
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $sql->execute(array($saved_img['img_id']));

            $saved_image[] = $sql->fetchAll();
        }

        return $saved_image;
    }
    public function shared_img($data){
        $db = new Database();
        $Session = new Sessions();
        $General = new General();

        $sql = $db->prepare("INSERT INTO shared_inspirations (user_id, img_id, shared_to,ip) VALUES(?,?,?,?)");
        $sql->execute(array(
            $Session->get('user-id'),
            $data['shared_img_id'],
            $data['shared_to'],
            $General->getUserIP()
            ));
    }
    public function img_save_count($img_id){
        $db = new Database();

        $sql = $db->prepare("SELECT id FROM inspiration_quotes_saved WHERE img_id = ?");
        $sql->execute(array($img_id));

        if($sql->rowCount() == 0){
            return 1;
        }else{
            return $sql->rowCount();
        }
    }
    public function count_shares($img_id){
        $db = new Database();

        $sql = $db->prepare("SELECT id FROM shared_inspirations WHERE img_id = ?");
        $sql->execute(array($img_id));

        return $sql->rowCount();

    }
    public function saved_plus_shares($img_id){
       return $this->img_save_count($img_id) + $this->count_shares($img_id);
    }
    public function get_quote_general($user_id, $randomize = false){
        $db = new Database();
        $saved_images = array();

        if($randomize == false):
            $sql = $db->prepare("SELECT * FROM `inspiration_quotes_saved` WHERE user_id = ? ");
        else:
            $sql = $db->prepare("SELECT * FROM `inspiration_quotes_saved` WHERE user_id = ? ");
        endif;
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($user_id));

        $saved_img_arr = $sql->fetchAll();

        if($randomize == false):
            foreach ($saved_img_arr as $saved_img){
                $sql = $db->prepare("SELECT * FROM `inspiration_quotes` WHERE id = ? ");
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute(array($saved_img['img_id']));

                $saved_images[] = $sql->fetchAll();
            }
        else:
            $saved_img_ids = array();
            unset($saved_images);

            foreach ($saved_img_arr as $saved_img){
                $saved_img_ids[] = $saved_img['img_id'];
            }
            if(count($saved_img_ids) > 1):
                $saved_img_ids_list = implode(',',$saved_img_ids);
                $sql = $db->prepare("SELECT * FROM `inspiration_quotes` WHERE id NOT IN($saved_img_ids_list) ORDER BY RAND() ");

            else:
                $sql = $db->prepare("SELECT * FROM `inspiration_quotes` ORDER BY RAND() ");
            endif;


            $sql->setFetchMode(PDO::FETCH_ASSOC);
            $sql->execute();
            $saved_images = $sql->fetchAll();
        endif;
        return $saved_images;
    }
    public function saved($img_id, $user_id){
        $db = new Database();

        $sql = $db->prepare("SELECT id FROM inspiration_quotes_saved WHERE user_id = ? and img_id = ?");
        $sql->execute(array(
            $user_id,
            $img_id
        ));
        if($sql->rowCount() > 0){
            return true;
        }else{
            return false;
        }

    }
    public function save_img($data){
        $db = new Database();
        $Session = new Sessions();
        $General = new General();
        $data_out = array();

        if($Session->get('logged_in') != 0):
            /* Check if already saved */
            if($this->saved($data['img_id'], $Session->get('user-id')) == false){
                $sql = $db->prepare("INSERT INTO inspiration_quotes_saved (user_id, create_date, img_id, ip) VALUES (?,?,?,?)");
                $sql->execute(array(
                   $Session->get('user-id'),
                   time(),
                   $data['img_id'],
                   $General->getUserIP()
                ));

                if($sql->rowCount() > 0){
                    $data_out['status'] = 'Saved';
                }
            }else{
                $sql = $db->prepare(" DELETE FROM inspiration_quotes_saved WHERE img_id = ? AND user_id = ?");
                $sql->execute(array(
                    $data['img_id'],
                    $Session->get('user-id')
                ));
                $data_out['status'] = "Unsaved";
            }
            else:
                $data_out['status'] = 'Not Logged In';
        endif;
        echo json_encode($data_out);
    }
    public function get_saved_img_id_arr(){
        $db = new Database();
        $Session = new Sessions();
        $returnValue = array();

        $sql = $db->prepare("SELECT img_id FROM inspiration_quotes_saved WHERE user_id = ? ");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array(
            $Session->get("user-id")
        ));

        $returnValue = array_map('current',$sql->fetchAll());

        return $returnValue;
    }
}