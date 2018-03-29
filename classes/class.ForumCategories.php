<?php

error_reporting(E_ALL);

/**
 * Handles the forum Catagories.
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-2-443ef2c5:15f39ed6002:-8000:0000000000000C35-includes begin
error_reporting(0);
require_once(CLASSES . 'Database.php');
// section -64--88-0-2-443ef2c5:15f39ed6002:-8000:0000000000000C35-includes end

/* user defined constants */
// section -64--88-0-2-443ef2c5:15f39ed6002:-8000:0000000000000C35-constants begin
// section -64--88-0-2-443ef2c5:15f39ed6002:-8000:0000000000000C35-constants end

/**
 * Handles the forum Catagories.
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class ForumCategories
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * Database Class
     *
     * @access private
     * @var array
     */
    private $Database = array();

    // --- OPERATIONS ---

    /**
     * Get the count of post for the givien subcategory name.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  subcategory
     * @return Integer
     */
    public function getPostCountForSubcategory($subcategory)
    {
        $returnValue = null;

        // section -64--88-0-2-443ef2c5:15f39ed6002:-8000:0000000000000C36 begin
        $this->Database = new Database();

        $sql = $this->Database->prepare("SELECT count(*) FROM forum_post WHERE sub_category_id = ?");
        $sql->execute(array(
            $subcategory
        ));

        $returnValue = $sql->fetchColumn();
        // section -64--88-0-2-443ef2c5:15f39ed6002:-8000:0000000000000C36 end

        return $returnValue;
    }

} /* end of class ForumCategories */

?>