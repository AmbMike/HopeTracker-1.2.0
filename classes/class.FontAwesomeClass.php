<?php

error_reporting(E_ALL);

/**
 * Stores the font Awesome icon classes.
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-2--150a2353:15ec50fe66f:-8000:0000000000000B21-includes begin
error_reporting(0);
// section -64--88-0-2--150a2353:15ec50fe66f:-8000:0000000000000B21-includes end

/* user defined constants */
// section -64--88-0-2--150a2353:15ec50fe66f:-8000:0000000000000B21-constants begin
// section -64--88-0-2--150a2353:15ec50fe66f:-8000:0000000000000B21-constants end

/**
 * Stores the font Awesome icon classes.
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class FontAwesomeClass
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * Thumbs up no fill color.
     *
     * @access public
     * @var String
     */
    public $thumbsUp = null;

    /**
     * Thumbs up with fill color.
     *
     * @access public
     * @var String
     */
    public $thumbsUpSolid = null;

    /**
     * Comment bubble no fill color.
     *
     * @access public
     * @var String
     */
    public $comment = null;

    /**
     * Sad face no fill color.
     *
     * @access public
     * @var String
     */
    public $frown = null;

    /**
     * Medical breif case with fill color.
     *
     * @access public
     * @var String
     */
    public $medkitSolid = null;

    /**
     * Question mark in circle no fill color.
     *
     * @access public
     * @var String
     */
    public $questionCircle = null;

    /**
     * Question mark in circle with fill color.
     *
     * @access public
     * @var String
     */
    public $questionCircleSolid = null;

    /**
     * Star no fill color
     *
     * @access public
     * @var String
     */
    public $star = null;

    /**
     * Star with fill color
     *
     * @access public
     * @var String
     */
    public $starSolid = null;

    /**
     * Short description of attribute solidEye
     *
     * @access public
     * @var String
     */
    public $solidEye = null;

    /**
     * Short description of attribute solidCheckmark
     *
     * @access public
     * @var String
     */
    public $solidCheckmark = null;

    // --- OPERATIONS ---

    /**
     * Short description of method __construct
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return mixed
     */
    public function __construct()
    {
        // section -64--88-0-2--150a2353:15ec50fe66f:-8000:0000000000000B25 begin
        $this->thumbsUp = 'fa-thumbs-o-up';
        $this->thumbsUpSolid = 'fa-thumbs-up';
        $this->comment = 'fa-comment-o';
        $this->frown = 'fa-frown-o';
        $this->medkitSolid = 'fa-medkit ';
        $this->questionCircle = 'fa-question-circle-o';
        $this->questionCircleSolid = 'fa-question-circle';
        $this->star = 'fa-star-o';
        $this->starSolid = 'fa-star';
        $this->solidEye = 'fa-eye';
        $this->solidCheckmark = 'fa-check';
        // section -64--88-0-2--150a2353:15ec50fe66f:-8000:0000000000000B25 end
    }

} /* end of class FontAwesomeClass */

?>