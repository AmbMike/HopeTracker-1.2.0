<?php

/**
 * File For: HopeTracker.com
 * File Name: Database.php.
 * Author: Mike Giammattei
 * Created On: 3/29/2017, 5:05 PM
 */

class Database extends PDO{
    public function __construct(){
        parent::__construct(DB_TYPE.':host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PASS);
    }
}