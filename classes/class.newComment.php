<?php

error_reporting(E_ALL);

/**
 * untitledModel - class.newComment.php
 *
 * $Id$
 *
 * This file is part of untitledModel.
 *
 * Automatically generated on 06.10.2017, 13:05:12 with ArgoUML PHP module 
 * (last revised $Date: 2010-01-12 20:14:42 +0100 (Tue, 12 Jan 2010) $)
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-2--56a3602c:15ec92073bc:-8000:0000000000000B7A-includes begin
error_reporting(0);
// section -64--88-0-2--56a3602c:15ec92073bc:-8000:0000000000000B7A-includes end

/* user defined constants */
// section -64--88-0-2--56a3602c:15ec92073bc:-8000:0000000000000B7A-constants begin
// section -64--88-0-2--56a3602c:15ec92073bc:-8000:0000000000000B7A-constants end

/**
 * Short description of class newComment
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class newComment
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * Short description of attribute userId
     *
     * @access public
     * @var String
     */
    public $userId = null;

    /**
     * Short description of attribute Database
     *
     * @access private
     * @var String
     */
    private $Database = null;

    // --- OPERATIONS ---

    /**
     * Short description of method __construct
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  userId
     * @return mixed
     */
    public function __construct($userId)
    {
        // section -64--88-0-2--56a3602c:15ec92073bc:-8000:0000000000000B7E begin
        $this->userId = $userId;
        // section -64--88-0-2--56a3602c:15ec92073bc:-8000:0000000000000B7E end
    }

    /**
     * Gets an array of journal ids the user has created.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  userId
     * @return array
     */
    public function getUsersJournalIds($userId)
    {
        $returnValue = array();

        // section -64--88-0-2--56a3602c:15ec92073bc:-8000:0000000000000B91 begin
        $this->Database = new Database();
        $sql = $this->Database->prepare("SELECT id FROM hopetrac_main.journal_entries WHERE user_id = ?");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute(array($userId));
        $returnValue = array_map('current',$sql->fetchAll());
        // section -64--88-0-2--56a3602c:15ec92073bc:-8000:0000000000000B91 end

        return (array) $returnValue;
    }

    /**
     * Gets all the comments where the user had created.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return array
     */
    public function getComments()
    {
        $returnValue = array();

        // section -64--88-0-2--56a3602c:15ec92073bc:-8000:0000000000000B87 begin
        $this->Database = new Database();
        $usersJournalIds = implode(',',$this->getUsersJournalIds($this->userId));

        $sql = $this->Database->prepare("SELECT * FROM hopetrac_main.journal_comments WHERE `journal_id` IN( " .$usersJournalIds.") ");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();

        $returnValue = $sql->fetchAll();
        // section -64--88-0-2--56a3602c:15ec92073bc:-8000:0000000000000B87 end

        return (array) $returnValue;
    }

    /**
     * Get the comments that are associated with a journal the user had created.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return array
     */
    public function newComments()
    {
        $returnValue = array();

        // section -64--88-0-2--56a3602c:15ec92073bc:-8000:0000000000000B8B begin
        $returnValue = $this->getComments();
        // section -64--88-0-2--56a3602c:15ec92073bc:-8000:0000000000000B8B end

        return (array) $returnValue;
    }

} /* end of class newComment */

?>