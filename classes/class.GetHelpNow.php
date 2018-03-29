<?php

error_reporting(E_ALL);

/**
 * Class for the "Get Help Now" form in the header.
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-2-18ad9447:15f49cf5259:-8000:0000000000000C38-includes begin
error_reporting(0);
require_once(CLASSES . '/Database.php');
// section -64--88-0-2-18ad9447:15f49cf5259:-8000:0000000000000C38-includes end

/* user defined constants */
// section -64--88-0-2-18ad9447:15f49cf5259:-8000:0000000000000C38-constants begin
// section -64--88-0-2-18ad9447:15f49cf5259:-8000:0000000000000C38-constants end

/**
 * Class for the "Get Help Now" form in the header.
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class GetHelpNow
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * Form data.
     *
     * @access private
     * @var array
     */
    private $data = array();

    /**
     * Database class
     *
     * @access private
     * @var array
     */
    private $Database = array();

    /**
     * User Id
     *
     * @access private
     * @var integer
     */
    private $userId = null;

    /**
     * The General class.
     *
     * @access private
     * @var array
     */
    private $General = array();

    /**
     * Sessions Class
     *
     * @access private
     * @var array
     */
    private $Sessions = array();

    // --- OPERATIONS ---

    /**
     * Constuct the class.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @return mixed
     */
    public function __construct()
    {
        // section -64--88-0-2-18ad9447:15f49cf5259:-8000:0000000000000C39 begin
        $this->Sessions = new Sessions();
        $this->userId = $this->Sessions->get('user-id');
        $this->General = new General();
        // section -64--88-0-2-18ad9447:15f49cf5259:-8000:0000000000000C39 end
    }

    /**
     * Store form data in the database.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  data The form data.
     * @return Boolean
     */
    public function storeFormData($data)
    {
        $returnValue = null;
        // section -64--88-0-2-18ad9447:15f49cf5259:-8000:0000000000000C4B begin
        $this->data = $data;

        $this->data['help_for'] = isset($this->data['help_for']) ? $this->data['help_for'] : 'NA';
        $this->data['insurance'] = isset($this->data['insurance']) ? $this->data['insurance'] : 'NA';
        $this->data['comments'] = isset($this->data['comments']) ? $this->data['comments'] : 'NA';

        $this->Database = new Database();
        $sql = $this->Database->prepare("INSERT INTO gethelpnow (full_name, email, phone, help_for, has_insurance, comments, users_id, user_ip) VALUES (?,?,?,?,?,?,?,?) ");
        $sql->execute(array(
            $this->data['fullname'],
            $this->data['email'],
            $this->data['phone'],
            $this->data['help_for'],
            $this->data['insurance'],
            $this->data['comments'],
            $this->userId,
            $this->General->getUserIP()
        ));

        if($sql->rowCount() > 0){
            echo 'Successful';
        }else{
            echo "Failed";
        }
        // section -64--88-0-2-18ad9447:15f49cf5259:-8000:0000000000000C4B end

        return $returnValue;
    }

} /* end of class GetHelpNow */

?>