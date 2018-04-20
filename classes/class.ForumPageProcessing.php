<?php

error_reporting(E_ALL);

/**
 * Handles the incoming url parameters and desplays the page parts that should
 * served to the user.
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-2-e6f1a6:162e40cb4e6:-8000:00000000000010FB-includes begin
error_reporting(0);
require_once(CLASSES . 'Database.php');
// section -64--88-0-2-e6f1a6:162e40cb4e6:-8000:00000000000010FB-includes end

/* user defined constants */
// section -64--88-0-2-e6f1a6:162e40cb4e6:-8000:00000000000010FB-constants begin
// section -64--88-0-2-e6f1a6:162e40cb4e6:-8000:00000000000010FB-constants end

/**
 * Handles the incoming url parameters and desplays the page parts that should
 * served to the user.
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class ForumPageProcessing
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * Short description of attribute Database
     *
     * @access private
     * @var class
     */
    private $Database = null;

    /**
     * Short description of attribute urlParameters
     *
     * @access public
     * @var array
     */
    public $urlParameters = array();

    /**
     * Short description of attribute isPage
     *
     * @access public
     * @var boolean
     */
    public $isPage = false;

    // --- OPERATIONS ---

    /**
     * Short description of method __construct
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  paramArray
     * @return mixed
     */
    public function __construct($paramArray)
    {
        // section -64--88-0-2-e6f1a6:162e40cb4e6:-8000:00000000000010FC begin

	    /** Create the parameter value(s) */
	    $this->urlParameters = $paramArray;

	    Debug::out( $paramArray );

	    if(count($paramArray) == 1){
	    	if($this->isCategory($paramArray[0])){
			   return $this->isCategory( $paramArray[0] );
		    }
	    }else if(count($paramArray) == 2){
		    return $this->isSubcategory( $paramArray[1] );
	    }

        // section -64--88-0-2-e6f1a6:162e40cb4e6:-8000:00000000000010FC end
    }

    /**
     * Check if the parameter is a category.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  category
     * @return mixed
     */
    public function isCategory($category)
    {
        // section -64--88-0-2-e6f1a6:162e40cb4e6:-8000:00000000000010FF begin
	    $this->Database = new Database();

	    $category = preg_replace( '/\-/', ' ', $category );
	    $sql = $this->Database->prepare("SELECT id FROM forum_categories WHERE category = ? LIMIT 1");
	    $sql->execute(array($category));

	    if($sql->rowCount() > 0){
		    $this->isPage = true;
	    }
        // section -64--88-0-2-e6f1a6:162e40cb4e6:-8000:00000000000010FF end
    }

    /**
     * Check if the parameter is a subcategory.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  subcategory
     * @return mixed
     */
    public function isSubcategory($subcategory)
    {
        // section -64--88-0-2-e6f1a6:162e40cb4e6:-8000:0000000000001104 begin

	    $subcategoryMatch = false;

	    $subcategory = preg_replace('/\-/',' ', $subcategory);

	    $this->Database = new Database();
	    $sql = $this->Database->prepare("SELECT sub_category FROM forum_sub_categories");
	    $sql->setFetchMode( PDO::FETCH_ASSOC );
	    $sql->execute(array($subcategory));

	    $allSubcategories = $sql->fetchAll();


	    /** loop through subcategories to see if their is a match */
		foreach($allSubcategories as $subcategoryName){

			/** Escape spaces and  forwards slash from  subcategories database*/
			$subcategoryName = preg_replace('/\//','',$subcategoryName['sub_category']);
			$subcategoryNameSingle = preg_replace('/\s+/','',$subcategoryName);


			/** Escape spaces and  forwards slash from  sub categories client side*/
			$subcategory = preg_replace('/\//','',$subcategory);
			$subcategory = preg_replace('/\s+/','',$subcategory);


			if(strtolower($subcategoryNameSingle) == $subcategory){
				$subcategoryMatch = true;
			}
		}

	    $this->isPage = $subcategoryMatch;
	  /*
	    $sql = $this->Database->prepare("SELECT id FROM forum_sub_categories WHERE sub_category = ? LIMIT 1");
	    $sql->execute(array($subcategory));

	    if($sql->rowCount() > 0){
		    $this->isPage = true;
	    }*/
        // section -64--88-0-2-e6f1a6:162e40cb4e6:-8000:0000000000001104 end
    }

} /* end of class ForumPageProcessing */

?>