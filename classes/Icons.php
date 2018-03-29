<?php

/**
 * File For: HopeTracker.com
 * File Name: icons.php.
 * Author: Mike Giammattei
 * Created On: 5/5/2017, 10:03 AM
 */
class Icons extends Database {
    public function feeling_icons($identifier){
        $db = new parent();

        $sql = $db->prepare('SELECT `icon` FROM `feeling_icons` WHERE `identifier` = ?');
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($identifier));

        return $sql->fetchColumn();
    }
}