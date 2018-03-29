<?php

error_reporting(E_ALL);

/**
 * Controls what images the inspirational slider displays.
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-2--2405a564:15f260ff61f:-8000:0000000000000B92-includes begin
error_reporting(0);
include_once(CLASSES . 'Database.php');

// section -64--88-0-2--2405a564:15f260ff61f:-8000:0000000000000B92-includes end

/* user defined constants */
// section -64--88-0-2--2405a564:15f260ff61f:-8000:0000000000000B92-constants begin
// section -64--88-0-2--2405a564:15f260ff61f:-8000:0000000000000B92-constants end

/**
 * Controls what images the inspirational slider displays.
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class InspirationSlide
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * Database Class.
     *
     * @access private
     * @var array
     */
    private $Database = array();

    // --- OPERATIONS ---

    /**
     * Gets the latest inspiration slides.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return array
     */
    public function getNewestSlides()
    {
        $returnValue = array();

        // section -64--88-0-2--2405a564:15f260ff61f:-8000:0000000000000B96 begin
        $this->Database = new Database();
        $sql = $this->Database->prepare("SELECT * FROM hopetrac_main.inspiration_quotes ORDER BY id DESC  LIMIT 0,10");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();

        $returnValue = $sql->fetchAll();
        // section -64--88-0-2--2405a564:15f260ff61f:-8000:0000000000000B96 end

        return (array) $returnValue;
    }

} /* end of class InspirationSlide */

?>