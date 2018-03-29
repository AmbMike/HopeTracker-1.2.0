<?php

error_reporting(E_ALL);

/**
 * Gets usernames as the user is typeing.
 *
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/* user defined includes */
// section -64--88-0-19--cd56f47:160ff96a03b:-8000:0000000000000F00-includes begin
error_reporting( 0 );
include_once( CLASSES . 'Database.php' );
include_once( CLASSES . 'Sessions.php' );
include_once( CLASSES . 'General.php' );
include_once( CLASSES . 'User.php' );
// section -64--88-0-19--cd56f47:160ff96a03b:-8000:0000000000000F00-includes end

/* user defined constants */
// section -64--88-0-19--cd56f47:160ff96a03b:-8000:0000000000000F00-constants begin
// section -64--88-0-19--cd56f47:160ff96a03b:-8000:0000000000000F00-constants end

/**
 * Gets usernames as the user is typeing.
 *
 * @access public
 * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
 */
class JournalPostFilter
{
    // --- ASSOCIATIONS ---


    // --- ATTRIBUTES ---

    /**
     * Short description of attribute Database
     *
     * @access private
     * @var object
     */
    private $Database = null;

    /**
     * Short description of attribute Session
     *
     * @access public
     * @var object
     */
    public $Session = null;

    /**
     * Short description of attribute General
     *
     * @access public
     * @var object
     */
    public $General = null;

    /**
     * User class.
     *
     * @access private
     * @var object
     */
    private $User = null;

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
        // section -64--88-0-19--cd56f47:160ff96a03b:-8000:0000000000000F0A begin
	    $this->General = new General();
	    $this->User = new User();
        // section -64--88-0-19--cd56f47:160ff96a03b:-8000:0000000000000F0A end
    }

    /**
     * Get posts by the selected filters
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  data
     * @return array
     */
    public function getPostByFilter($data)
    {
        $returnValue = array();

        // section -64--88-0-19-6a9e1b7:1610abe8005:-8000:0000000000000F15 begin
        // section -64--88-0-19-6a9e1b7:1610abe8005:-8000:0000000000000F15 end

        return (array) $returnValue;
    }

    /**
     * Get total number of post for every user in list user id list.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  userIds
     * @return intger
     */
    public function getTotalPostForUsers($userIds)
    {
        $returnValue = '';

        // section -64--88-0-19-7698f97a:16129e6eb59:-8000:0000000000000F1B begin
	    $this->Database = new Database();
	    $userIdArray = explode( ',', $userIds );
	    $postCountArr = array();
	    if(count($userIdArray) > 0){
		    foreach ( $userIdArray as $userId ) {
			    $sql = $this->Database->prepare("SELECT count(*) FROM journal_entries WHERE user_id = ? ");
			    $sql->execute(array($userId));
			    $postCountArr[] =  $sql->fetchColumn();
		    }

	    }else{
		    $sql = $this->Database->prepare("SELECT count(*) FROM journal_entries WHERE user_id = ? ");
		    $sql->execute(array($userIdArray));
		    $postCountArr[] = $sql->fetchColumn();
	    }
	    $returnValue = array_sum($postCountArr);
        // section -64--88-0-19-7698f97a:16129e6eb59:-8000:0000000000000F1B end

        return $returnValue;
    }

    /**
     * Short description of method getPosts
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  data
     * @param  order
     * @return array
     */
    public function getPosts($data, $order = 'DESC')
    {
        $returnValue = array();

        // section -64--88-0-19--cd56f47:160ff96a03b:-8000:0000000000000F0C begin

	    $this->Database = new Database();
	    $User = new User();

	    /** Default Post Per Call */
	    if(!isset($data['startPost']) ){
		   $startPost = 0;
	    }else{
		    $startPost =  (int)$data['startPost'];
	    }
	    if(!isset($data['endPost'])){
		    $endPost = 3;
	    }else{
		    $endPost = (int)$data['endPost'];
	    }

	    /** User searching for users names */
	    if(isset($data['name'])){

		    $userIds = $User->get_user_id_by_name( $data['name'] );
		    $userIds = array_map( 'current', $userIds );

		    $userIdList = implode( ',', $userIds );

		    $sql = $this->Database->prepare("SELECT * FROM journal_entries WHERE  status = 1 AND user_id IN (" . $userIdList.") ORDER BY timestamp ".$order . " LIMIT :startLimit, :maxlimit");
		    $sql->setFetchMode( PDO::FETCH_ASSOC );
		    $sql->bindParam('startLimit',$startPost, PDO::PARAM_INT);
		    $sql->bindParam('maxlimit',$endPost, PDO::PARAM_INT);
		    $sql->execute();

		    /** Return data */
		    $returnValue['posts'] = $sql->fetchAll();
		    $returnValue['posts_user_ids'] = $userIdList;

	    }

	    /** User searching for with filters */
	    if($data['type'] == 'by filters'){

	    	$filterData = $_GET['data'];

	    	/** Set inputs whether selected or not */
	    	$selectState = ($filterData['state'] != 'hide') ? true : false;
	    	$selectZip = (trim($filterData['zip']) != '') ? true : false;
	    	$selectRoles = (isset($filterData['roles'])) ? true : false;
		    $selectConcernedAbout = (isset($filterData['concerned_about'])) ? true : false;
		    $selectStatus = (isset($filterData['status'])) ? true : false;
	    	$selectShowAs = (isset($filterData['show_as'])) ? true : false;

	    	/** Filter arrays */
		    $filter_ids = array();

	    	/** Only State */
	    	if($selectState == true && $selectZip == false){

			    $state =  $filterData['state'];
			    /** Get user Ids from users buy selected state */
			    $filter_ids[] =  $this->User->get_users_ids_by_state($state);

		    }
		    /** Only Zip */
		    if($selectState == false && $selectZip == true){
			   $zip  = $filterData['zip'];
			    /** Get user Ids from users buy selected zip */
			    $filter_ids[] =  $this->User->get_users_ids_by_zip($zip);
		    }
		    /** State And Zip */
		    if($selectState == true && $selectZip == true){
			    $state =  $filterData['state'];
			    $zip  = $filterData['zip'];

			    /** Get user Ids from users buy selected state */
			    $state_user_ids =  $this->User->get_users_ids_by_state($state, $zip);

			    /** Get user Ids from users buy selected zip */
			    $zip_user_ids =  $this->User->get_users_ids_by_zip($zip,$state);

			    $filter_ids[] = array_merge($state_user_ids, $zip_user_ids);

		    }
		    /** Selected Roles */
		    if($selectRoles == true){

		    	/** Get user ids by i_am */
		    	$roles = $data['roles'];
			    $filter_ids[] =  $this->User->get_users_ids_by_i_am($roles);


		    }
		    /** Selected Concerned About */
		    if(isset($filterData['concerned_about'])){
		    	$concerned_about  = $filterData['concerned_about'];
			    $filter_ids[] =  $this->User->get_users_ids_by_concerned_about($concerned_about);
		    }
		    /** Selected Status */
		    if(isset($filterData['status'])){
			    $status  = $filterData['status'];
			    $filter_ids[] =  $this->User->get_users_ids_by_status($status);
		    }
		    /** Selected Show As */
		    if(isset($filterData['show_as'])){

			    $returnValue['show_as'] = $filterData['show_as'];
		    }


		    /** Check if filter has matches */
		    if(count($filter_ids) > 1){
			    /** Match filtered user ids to get result */
			    $returnValueIds =  call_user_func_array('array_intersect',$filter_ids);

		    }else{
			    $returnValueIds = $filter_ids[0];
		    }

		    /** Get users journal entry by users ids */
		    $user_ids = implode( ',', $returnValueIds );
		    //$startPost = 0;

		    $sql = $this->Database->prepare("SELECT * FROM journal_entries WHERE  status = 1 AND user_id IN (".$user_ids.") ORDER BY timestamp ".$order . " LIMIT :startLimit, :maxlimit");
		    $sql->setFetchMode( PDO::FETCH_ASSOC );
		    $sql->bindParam('startLimit',$startPost, PDO::PARAM_INT);
		    $sql->bindParam('maxlimit',$endPost, PDO::PARAM_INT);
		    $sql->execute();

		    /** Return posts array */
		    $returnValue['posts'] = $sql->fetchAll();
		   // Debug::data( $returnValue);

		    /** Return posts query  */
		    $returnValue['posts_user_ids'] = $user_ids;
	    }

	    /** User ordering posts order by*/
	    if($data['type'] == 'order by'){
		  $current_post_ids = $data['postIds'];
		  $order_type =  $data['orderType'];

		  $this->Database = new Database();

		  /** If not filters have been added to the posts */

		  	switch ($order_type):
			    case 'newest' :
			    	$sql =  $this->Database->prepare("SELECT * FROM journal_entries  status = 1 ORDER BY timestamp DESC LIMIT :startLimit, :maxlimit" );
				    $sql->setFetchMode( PDO::FETCH_ASSOC );
				    $sql->bindParam('startLimit',$startPost, PDO::PARAM_INT);
				    $sql->bindParam('maxlimit',$endPost, PDO::PARAM_INT);
				    $sql->execute();
				    $returnValue['posts'] = $sql->fetchAll();
			    	break;
			    case 'oldest' :
				    $sql =  $this->Database->prepare("SELECT * FROM journal_entries  status = 1  ORDER BY timestamp ASC LIMIT :startLimit, :maxlimit" );
				    $sql->setFetchMode( PDO::FETCH_ASSOC );
				    $sql->bindParam('startLimit',$startPost, PDO::PARAM_INT);
				    $sql->bindParam('maxlimit',$endPost, PDO::PARAM_INT);
				    $sql->execute();
				    $returnValue['posts'] = $sql->fetchAll();
				    break;
			    case 'most liked' :

			    	include_once(CLASSES . 'Journal.php');
			    	$Journal = new Journal();

				    $journal_arr = array();
				    foreach ($Journal->group_journals_by_likes() as $index => $journal_post):
					    $sql = $this->Database->prepare('SELECT * FROM journal_entries WHERE  status = 1 AND id = :id LIMIT :startLimit, :maxlimit');
					    $sql->bindParam('id',$journal_post,PDO::PARAM_INT);
					    $sql->bindParam('startLimit',$startPost, PDO::PARAM_INT);
					    $sql->bindParam('maxlimit',$endPost, PDO::PARAM_INT);
					    $sql->execute();
					    $journal_arr[] = $sql->fetchAll();
				    endforeach;
				    $journal_arr = call_user_func_array('array_merge',$journal_arr);

				    $returnValue['posts'] = $journal_arr;

				    break;
			    case 'most commented' :
				    include_once(CLASSES . 'Journal.php');
				    $Journal = new Journal();

				    foreach ($Journal->group_journal_comments() as $index => $journal_post):
					    $sql = $this->Database->prepare('SELECT * FROM journal_entries WHERE id = :id AND  status = 1');
					    $sql->bindParam('id',$journal_post,PDO::PARAM_INT);
					    $sql->execute();
					    $journal_arr[] = $sql->fetchAll();
				    endforeach;
				    $journal_arr = call_user_func_array('array_merge',$journal_arr);

				    $returnValue['posts'] = $journal_arr;
			    	break;
		    endswitch;

		    /** Get all the user ids from the ordered posts*/
		    $ordered_user_ids = array();
		    foreach ($journal_arr as $posts):
			    $ordered_user_ids[] = $posts['user_id'];
		    endforeach;

	    }

	    /** Get post by limit index */
	    if($data['type'] == 'no filter scroll'){

	    	/** Get full row count */
		    $sql = $this->Database->prepare("SELECT count(*) FROM journal_entries  WHERE  status = 1");
		    $sql->execute();
		    $totalRows = $sql->fetchColumn();

		    /** Send back value telling the php page the post are from scrolled post */
		    $returnValue['scrolled_posts'] = $startPost;

		    /** Check if there are more posts to serve to the user on scroll. */
		    if($totalRows > $startPost){
			    $sql = $this->Database->prepare("SELECT * FROM journal_entries WHERE  status = 1 ORDER BY id DESC LIMIT :startLimit, :maxlimit ");
			    $sql->setFetchMode(PDO::FETCH_ASSOC);
			    $sql->bindParam('startLimit',$startPost, PDO::PARAM_INT);
			    $sql->bindParam('maxlimit',$endPost, PDO::PARAM_INT);
			    $sql->execute();
			    // Debug::data( $sql->fetchAll());
			    /** Return data */
			    $returnValue['posts'] = $sql->fetchAll();
		    }else{
		    	/** Stop query when the scrolled reached the end of the post */
		    	$returnValue['endPosts'] = true;
		    }
	    }
	    /** Get post by limit index */
	    if($data['type'] == 'filter scroll'){
	    	$user_ids = $data['postUserIds'];

		    $totalPosts = $this->getTotalPostForUsers($user_ids);

		    /** Send back value telling the php page the post are from scrolled post */
		    $returnValue['scrolled_posts'] = $startPost;

		    /** Check if there are more posts to serve to the user on scroll. */
		    if($totalPosts > $startPost && $totalPosts > 2){
			    $sql = $this->Database->prepare("SELECT * FROM journal_entries WHERE  status = 1 AND user_id IN (".$user_ids.") ORDER BY id DESC LIMIT :startLimit, :maxlimit ");
			    $sql->setFetchMode(PDO::FETCH_ASSOC);
			    $sql->bindParam('startLimit',$startPost, PDO::PARAM_INT);
			    $sql->bindParam('maxlimit',$endPost, PDO::PARAM_INT);
			    $sql->execute();
			    /** Return data */
			    $returnValue['posts'] = $sql->fetchAll();
		    }else{
			    /** Stop query when the scrolled reached the end of the post */
			    $returnValue['endPosts'] = true;
		    }
	    }
        // section -64--88-0-19--cd56f47:160ff96a03b:-8000:0000000000000F0C end

        return (array) $returnValue;
    }

    /**
     * Get the suggested users names.
     *
     * @access public
     * @author Michael Giammattei, <mgiamattei@ambrosiatc.com>
     * @param  name
     * @return array
     */
    public function suggestUserNames($name)
    {
        $returnValue = array();

        // section -64--88-0-19--cd56f47:160ff96a03b:-8000:0000000000000F10 begin
	    $this->Database = new Database();

	    $names = $this->General->split_name( $name );

	    if(trim($name) != ''):
		    $sql = $this->Database->prepare("SELECT fname, lname FROM `user_list` WHERE fname LIKE :fname AND lname LIKE :lname LIMIT 10");

		    $fname = "%".$names[0]."%";
		    $lname = "%".$names[1]."%";

		    $sql->bindParam(':fname', $fname, PDO::PARAM_STR);
		    $sql->bindParam(':lname', $lname, PDO::PARAM_STR);
		    $sql->setFetchMode( PDO::FETCH_ASSOC );
		    $sql->execute();

		    $arr = $sql->fetchAll();

		    echo json_encode($arr);
	    endif;

        // section -64--88-0-19--cd56f47:160ff96a03b:-8000:0000000000000F10 end

        return (array) $returnValue;
    }

} /* end of class JournalPostFilter */

?>