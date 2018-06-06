<?php

/**
 * File For: HopeTracker.com
 * File Name: processing.php.
 * Author: Mike Giammattei
 * Created On: 3/28/2017, 4:34 PM
 */
    include_once(dirname(dirname(__FILE__)).'/config/constants.php');
    include_once(CLASSES.'Forms.php');
    include_once(CLASSES.'User.php');
    include_once(CLASSES.'Journal.php');
    include_once(CLASSES.'Comments.php');
    include_once(CLASSES.'Forum.php');
    include_once(CLASSES.'Chat.php');
    include_once(CLASSES.'Emails.php');
    include_once(CLASSES.'Inspiration.php');

    error_reporting(E_ALL); ini_set('display_errors',1);
    $Forms = new Forms();
    $User = new User();
    $Journal = new Journal();
    $Comments = new Comments();
    $Forum = new Forum();
    $Chat = new Chat();
    $Emails = new Emails();
    $Inspiration = new Inspiration();



    switch ($_POST['form']){
	    case 'Sign Up' :
		     $Forms->process_sign_up($_POST);
		    break;
	    case 'Sign Out' :
		    $User->sign_out();
		    break;
	    case 'Sign In' :
		    $User->sign_in($_POST);
		    break;
	    case 'Forgot Password' :
		    User::forgot_password($_POST['email']);
		    break;
	    case 'Emailed Password Reset' :
		    $User->email_reset_password($_POST['data']);
		    break;
	    case 'Reset Password' :
		    $User->reset_password($_POST);
		    break;
	    case 'Get Help Now Form' :
		    include_once(CLASSES . 'class.GetHelpNow.php');
		    $GetHelpNow = new GetHelpNow();
		    $GetHelpNow->storeFormData($_POST['data']);
		    break;
	    case 'Journal Entry' :
		    $User->journal_entry_form($_POST);
		    break;
	    case 'Name Suggestions' :
		    include_once(CLASSES . 'class.JournalPostFilter.php');
		    $JournalPostFilter = new JournalPostFilter();
		    $JournalPostFilter->suggestUserNames($_POST['name']);
		    break;
	    case 'Journal Search Post By Name' :
		    include_once(CLASSES . 'class.JournalPostFilter.php');
		    $JournalPostFilter = new JournalPostFilter();
		    $JournalPostFilter->getPosts($_POST['data']);
		    break;
	    case 'Journal Entry Lite' :
		    include_once(CLASSES . 'class.JournalPosts.php');
		    $JournalPost = new JournalPosts();
		    $JournalPost->storePostLite($_POST['content']);
		    break;
	    case 'Like Journal Entry' :
		    $Journal->set_like_status($_POST);
		    break;
	    case 'Journal Entry Comment' :
		    $Journal->entry_comment($_POST);
		    break;
		case 'Show More Online Users' :
			error_reporting( 3 );
			include_once(CLASSES . 'User.php');
		   	$chat_users = $User->users_online_plus_moderators(true, (int)$_POST['start'],  (int)$_POST['qty']);
		   	echo json_encode($chat_users);
		    break;

	    case 'Journal Entry Comment Sidebar' :
		    $Journal->entry_comment_sidebar($_POST);
		    break;
	    case 'Liked Comment' :
		    $Comments->like_comment($_POST);
		    break;
	    case 'Journal Comment of Comment' :
		    $Comments->comment_of_comment($_POST);
		    break;
	    case 'Update User Online Status' :
		    $User->update_online_timestamp();
		    break;
	    case 'Update User Settings' :
		    $Forms->user_settings($_POST['data']);
		    break;
	    case 'Password Check' :
		    $Forms->password_ajax_check($_POST);
		    break;
//        case 'Replace Profile Image' :
//            $Forms->replace_profile_img($_POST['data']);
//        break;
	case 'Settings Feedback' :
		$Forms->settings_feedback($_POST['data']);
		break;
	case 'Insurance Form' :
		include_once( CLASSES . 'class.InsuranceForm.php' );
		$InsuranceForm = new InsuranceForm();
		$InsuranceForm->setFormData($_POST['data']);
		break;
	case 'Page Logger' :
		include_once( CLASSES . 'class.PageLogger.php' );
		$PageLogger = new PageLogger($_POST['page']);
		break;

	case 'Follow User' :
		include_once( CLASSES . 'class.FollowUser.php' );
		$FollowUser = new FollowUser($_POST['followedUserId']);
		echo json_encode( $FollowUser->setFollowUser() );
		break;

	/* Sidebar */
	case 'Sidebar Invite Friend' :
		include_once(CLASSES.'class.InviteFriend.php');
		$InviteFriend = new InviteFriend();
		$InviteFriend->setInvitation($_POST['data']);
		break;
	case 'Sidebar Invite Friend Check' :
		include_once(CLASSES.'class.InviteFriend.php');
		$InviteFriend = new InviteFriend();
		$InviteFriend->AlreadyInvitedCheck($_POST);
		break;

	/* Inspiration */
	case 'Save Inspiration' :
		$Inspiration->save_img($_POST);
		break;
	case 'Inspiration Img Shared' :
		$Inspiration->shared_img($_POST['data']);
		break;
	case 'Inspiration Sidebar Saved Arr' :
		echo json_encode($Inspiration->get_saved_img_id_arr());
		break;
	case 'Like Inspiration' :
		include_once(CLASSES . 'class.likeInspiration.php');
		$Inspirations  = new likeInspiration($_POST['folder'],$_POST['filename']);
		echo json_encode($Inspirations->setLikeAction($_POST['fullFilePath']));
		break;
	case 'Set Inspiration Comment' :
		include_once(CLASSES . 'class.InspirationComments.php');
		$InspirationComments  = new InspirationComments();
		echo json_encode($InspirationComments->storeComment($_POST['folder'],$_POST['filename'],$_POST['imagePath'],$_POST['comment']));
		break;
	case 'Get Inspiration Comments' :
		include_once(CLASSES . 'class.InspirationComments.php');
		$InspirationComments  = new InspirationComments();
		echo json_encode($InspirationComments->getComments($_POST['folder'],$_POST['filename']));
		break;

	/* Chat App */
	case 'Request Chat' :
		$Chat->chat_request($_POST['requested_user_id']);
		break;
	case 'Chat Request Notification' :
		$Chat->chat_request_alert($_POST['return_type']);
		break;
	case 'Request Chat Action' :
		$Chat->request_chat_action($_POST);
		break;
	case 'Build User Chat Box' :
		$Chat->build_user_chat_box();
		break;
	case 'Delete Chatroom' :
		$Chat->delete_chat_room($_POST);
		break;

	/* Emails */
	case 'Chat Email Upload' :
		$Emails->upload_chat_emails($_POST['data']);
		break;

	/* Courses */
	case 'Course Session Action' :
		include_once(CLASSES.'Courses.php');
		$Courses = new Courses();
		$Courses->set_course_session_status($_POST['data']);
		break;
	case 'Course Intro Marked Viewed' :
		include_once(CLASSES.'Courses.php');
		$Courses = new Courses();
		$Sessions = new Sessions();
		$Courses->viewed_course_page($Sessions->get('user-id'),'/protected/course/');
		$Sessions->set( 'viewed_course', true );
		break;
	case 'Get Activity Counts' :
		include_once(CLASSES.'Courses.php');
		$Courses = new Courses();
		$Sessions = new Sessions();
		$returnValue = array();

		$returnValue['completedActivities'] = $Courses->get_total_clicked_activities($Sessions->get('user-id'));

		echo json_encode($returnValue);
		break;
	case 'Grouped User Journal By Week':
		include_once(CLASSES.'Courses.php');
		$Courses = new Courses();
		echo json_encode( $Courses->weekday_array());
		break;
	case 'Grouped User Logins By Week':
		include_once(CLASSES.'Courses.php');
		$Courses = new Courses();
		echo json_encode( $Courses->get_tracked_login_by_week_name());
		break;

	/* Admin Processes */
	case 'Admin Sign In' :
		include_once(CLASSES.'A_Form.php'); // Admin Class
		$A_Form = new A_Form(); // Admin Form Class
		$A_Form->admin_sign_in($_POST);
		break;

	/* Forum Category */
	case 'Forum Add Category' :
		$Forum->add_categories($_POST);
		break;
	case 'Forum Delete Category' :
		$Forum->delete_category($_POST['id']);
		break;
	case 'Edit Forum Category' :
		$Forum->edit_categories($_POST['form_data']);
		break;

	/* ------- Sortable */
	case 'Sort Forum Categories' :
		include_once(CLASSES.'Sortable.php'); // Admin Class
		$Sortable = new Sortable(); // Admin Form Class
		$Sortable->sort_forum_categories($_POST);
		break;
	/* Forum Subcategory */
	case 'Forum Add Subcategory' :
		$Forum->add_subcategories($_POST['data']);
		break;
	case 'Forum Delete Subcategory' :
		$Forum->delete_sub_category($_POST['id']);
		break;
	case 'Forum Add Post' :
		$Forum->add_post_to_category($_POST['data']);
		break;
	case 'Show All Journal Comments by Id' :
		$Journal->get_journal_comments($_POST['post_id'], true, true);
		break;
	case 'Follow User From Journal Profile' :
		$Journal->follow_user($_POST['followers_username']);
		break;
	case 'Follow Forum Sub Category' :
		$Forum->follow_sub_cat($_POST['sub_cat_id']);
		break;
	case 'Follow Forum Sub Category Post' :
		$Forum->follow_sub_cat_post($_POST['sub_cat_id_post'], true);
		break;

	/* Forum Single */
	case 'Forum Reply' :
		$Forum->forum_reply($_POST['data']);
		break;
	case 'Like Forum Reply' :
		$Forum->like_forum_reply($_POST['data']);
		break;
	case 'Like Forum' :
		$Forum->like_forum($_POST['data']);
		break;

	/** v2 Forum Processes */
	case 'Get Subcategory List' :
		echo json_encode($Forum->subcategory_list_by_cat_value($_POST['category']));
		break;
	case 'Ask Question Forum' :
		include_once( CLASSES . 'class.AskQuestionForum.php' );
		$AskQuestionForum = new AskQuestionForum();
		$AskQuestionForum->storeFormData($_POST['data']);
		break;
	case 'Answer Question Forum' :
		include_once( CLASSES . 'class.ForumAnswers.php' );
		$ForumAnswers = new ForumAnswers();
		$ForumAnswers->storeAnswer($_POST['data']);
		break;

	/** Like Post */
	case 'Like Post' :
		include_once( CLASSES . 'class.LikePost.php' );
		$LikePost = new LikePost($_POST['post_id'],$_POST['post_type'],$_POST['post_user_id']);

		echo json_encode($LikePost->likeQuestion());
		break;

	/** Follow Post */
	case 'Follow Post' :
		include_once( CLASSES . 'class.FollowPost.php' );
		$FollowPost = new FollowPost($_POST['post_id'],$_POST['post_type'],$_POST['post_user_id']);

		echo json_encode($FollowPost->followPost());
		break;

	/** Flag Post */
	case 'Flag Post' :
		include_once( CLASSES . 'class.FlagPost.php' );
		$FlagPost = new FlagPost;
		echo json_encode($FlagPost->flagPost($_POST['post_id'],$_POST['post_type'] ));
		break;
	default : echo 'No Good';
}