<?php

error_reporting(E_ALL);

/**
 * Creates an object of a link and bulds a dynamic link.
 * You can also access parts of the link through the variables.
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-2--56a3602c:15ec92073bc:-8000:0000000000000B45-includes begin
error_reporting(0);
// section -64--88-0-2--56a3602c:15ec92073bc:-8000:0000000000000B45-includes end

/* user defined constants */
// section -64--88-0-2--56a3602c:15ec92073bc:-8000:0000000000000B45-constants begin
// section -64--88-0-2--56a3602c:15ec92073bc:-8000:0000000000000B45-constants end

/**
 * Creates an object of a link and bulds a dynamic link.
 * You can also access parts of the link through the variables.
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class Link
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * href value for the link
     *
     * @access public
     * @var String
     */
    public static $href = null;

    /**
     * the link value that is seen by user's
     *
     * @access public
     * @var String
     */
    public static $value = null;

    /**
     * options to include inside the link such as: classes, id, attrubutes.
     *
     * @access public
     * @var array
     */
    public static $options = array();

    // --- OPERATIONS ---

    /**
     * Short description of method __construct
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  href
     * @param  value
     * @param  options
     * @return mixed
     */
    public function __construct($href, $value, $options)
    {
        // section -64--88-0-2--56a3602c:15ec92073bc:-8000:0000000000000B55 begin
        $this::$href = $href;
        $this::$value = $value;
        $this::$options = $options;

        // section -64--88-0-2--56a3602c:15ec92073bc:-8000:0000000000000B55 end
    }

    /**
     * Builds the link including the HTML to return to the client.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return String
     */
    public function buildLink()
    {
        $returnValue = null;

        // section -64--88-0-2--56a3602c:15ec92073bc:-8000:0000000000000B5A begin

        /**
         * Check if the link has options such as links class to add to the link.
         * @return String : of options.
         */
        $optionValues = null;
        if(self::$options != null){
            foreach (self::$options as $key => $option) {
                $optionValues .= $key . '="' . $option . '" ';
            }
        }

        $returnValue = '<a href="/'. RELATIVE_PATH_NO_END_SLASH . self::$href . ' " ' . $optionValues . ' >' . self::$value . '</a>';
        // section -64--88-0-2--56a3602c:15ec92073bc:-8000:0000000000000B5A end

        return $returnValue;
    }

} /* end of class Link */

?>