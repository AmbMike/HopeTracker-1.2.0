<?php
/**
 * Copyright (c) 2017.
 */

/**
 * File For: HopeTracker.com
 * File Name: getAnswers.php.
 * Author: Mike Giammattei
 * Created On: 12/7/2017, 3:37 PM
 */;
?>
<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/hopetracker/config/constants.php');
include_once( CLASSES . 'class.ForumAnswers.php' );

$ForumAnswers = new ForumAnswers();
/** @var  $startLimit : calculate where the limit needs to start. */
$startLimit = ($_GET['data']['paginationNumber'] * $_GET['data']['paginationLimit']) - $_GET['data']['paginationLimit'];

$forum_answers_arr = $ForumAnswers->getAnswers(false,$_GET['data']['questionId'],true, (int) $_GET['data']['paginationLimit'],(int) $startLimit);


?>
<div data-answer="tables">
<?php foreach ( $forum_answers_arr as $forum_answer) :  ?>
	<div class="table">
		<div class="cell">
			<img src="/<?php echo RELATIVE_PATH . (User::user_info('profile_img',$forum_answer['user_id'])) ? : DEFAULT_PROFILE_IMG; ?>" alt="<?php echo User::Username($forum_answer['user_id']); ?>"  class="img-circle profile-img ">
		</div>
		<div class="cell">
			<div class="user-info">
				<span itemprop="author" itemscope itemtype="http://schema.org/Person" class="username"><span itemprop="name"><?php echo User::Username($forum_answer['user_id']); ?></span></span>
				<span itemprop="text" class="answer"><?php echo $forum_answer['answer']; ?></span>
				<time itemprop="dateCreated"  class="human-time" datetime="<?php echo date("j F Y H:i",$forum_answer['date_created']) ?>"><?php echo date("j F Y H:i",$forum_answer['date_created']) ?></time>
			</div>
		</div>
	</div>
</div>
<?php endforeach; ?>
