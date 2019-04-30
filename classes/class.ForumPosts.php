<?php

error_reporting(E_ALL);

/**
 * untitledModel - class.ForumPosts.php
 *
 * $Id$
 *
 * This file is part of untitledModel.
 *
 * Automatically generated on 17.10.2017, 10:51:12 with ArgoUML PHP module 
 * (last revised $Date: 2010-01-12 20:14:42 +0100 (Tue, 12 Jan 2010) $)
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-2-1135e4b1:15ebf8d84cd:-8000:0000000000000AEB-includes begin
error_reporting(0);
require_once(CLASSES . 'Database.php');
// section -64--88-0-2-1135e4b1:15ebf8d84cd:-8000:0000000000000AEB-includes end

/* user defined constants */
// section -64--88-0-2-1135e4b1:15ebf8d84cd:-8000:0000000000000AEB-constants begin
// section -64--88-0-2-1135e4b1:15ebf8d84cd:-8000:0000000000000AEB-constants end

/**
 * Short description of class ForumPosts
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class ForumPosts
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * Short description of attribute dbConnection
     *
     * @access private
     * @var String
     */
    private $dbConnection = null;

    // --- OPERATIONS ---

    /**
     * Get an array of all the forum posts.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return array
     */
    public function getForumPosts()
    {
        $returnValue = array();

        // section -64--88-0-2-1135e4b1:15ebf8d84cd:-8000:0000000000000AEC begin
        $this->dbConnection = new Database();

        $sql = $this->dbConnection->prepare("SELECT * FROM hopetrac_main.forum_post");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($this->userId));
        // section -64--88-0-2-1135e4b1:15ebf8d84cd:-8000:0000000000000AEC end

        return (array) $returnValue;
    }

    /**
     * Gets the latest forum post.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  qty Number of post to get from the database.
     * @return array
     */
    public function getLatestPosts($qty = 10)
    {
        $returnValue = array();

        // section -64--88-0-2-3801fad4:15f2a911f28:-8000:0000000000000BA8 begin
        $this->dbConnection = new Database();
        $sql = $this->dbConnection->prepare("SELECT * FROM hopetrac_main.forum_post ORDER BY id DESC LIMIT 0, :rows");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->bindParam(':rows', $qty, PDO::PARAM_INT);
        $sql->execute();
        $returnValue = $sql->fetchAll();

        // section -64--88-0-2-3801fad4:15f2a911f28:-8000:0000000000000BA8 end

        return (array) $returnValue;
    }

} /* end of class ForumPosts */

?>