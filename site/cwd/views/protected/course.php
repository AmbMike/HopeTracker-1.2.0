<?php
/**
 * Copyright (c) 2018.
 */

/**
 * File For: HopeTracker.com
 * File Name: course.php.
 * Author: Mike Giammattei
 * Created On: 4/13/2017, 1:45 PM
 */;

?>
<?php
include_once(CLASSES.'Courses.php');
include_once(CLASSES.'class.UserStatus.php');
include_once(CLASSES.'General.php');
include_once(CLASSES.'class.ActivitySessionSkipped.php');
//include_once(CLASSES.'class.ActivitySession.php');
?>
<?php

$Page = new \Page_Attr\Page();
$Page->header(array(
	'Title' => 'My Course Page Title',
	'Description' => 'The course page displays an overview of the course and the current status that are in. ',
	'Active Link' => 'University'
));


$back_button = true;
$Session = new Sessions();
$User = new User();
$Courses = new Courses();
$UserStatus = new UserStatus($Session->get('user-id'));
$ActivitySessionSkipped = new ActivitySessionSkipped();
$total_complete_activities = $Courses->get_total_clicked_activities($Session->get('user-id'));

$General = new General();

include_once(CLASSES.'class.ActivitySessionItems.php');
$ActivitySessionItems = new ActivitySessionItems();

/** @var  $totalActivities : total number of all activities. */
$totalActivities = $ActivitySessionItems->totalActivities;

/** @var  $totalActivities : total number of all completed activities. */
$totalCompleteActivities = $ActivitySessionItems->totalCompleteActivities;

/* Reset intro status to review intro section by selecting the option in the debug panel.  */

?>
<div class="con main" id="courses" data-show-intro="<?php echo ($Session->get('viewed_course') != true) ? 'yes' : 'no'; ?>">
	<div class="row">
		<div class="col-md-8">
			<main>
				<section  class="box-one main-title-box" >
					<span class="h1-addon">10-Session</span>
					<h1 class="green-heading-lg top">Addiction University</h1>
					<p class="heading-text">
						Created by industry-leading therapists in collaboration with a team of moms, you'll "graduate" with a better understanding of addiction and your role in supporting recovery. It's a lot, but don't be overwhelmed. Commit to Session 1!
                    </p>
				</section>
				<section class="box-one main-title-box session-container">
					<?php include_once(VIEWS . 'includes/course/index.php'); ?>
				</section>
				<section id="step4" class="box-one gray progress-container">
					<div class="inside-box no-top no-bottom-p">
						<div class="row" id="progress-box">
							<div id="heading" class="col-md-12">
								<h3 class="simple-heading progress-title">My Achievement</h3>
								<div class="invite-box">
									<a data-toggle="modal" role="button" data-target="#stats-modal"><i class="fa fa-line-chart"></i> View My Stats</a>
								</div>
							</div>
						</div>
						<div id="progress-details">
							<?php
							$current_level_number = $Courses->get_current_level_number($Session->get('user-id'));
							?>
							<img src="<?php echo IMAGES .'course/award-' . $current_level_number . '.png'; ?>" width="100" alt="Award">
							<div class="progress">
								<?php $currentProgress = ($totalCompleteActivities/$totalActivities ) * 100 ;  ?>
								<div id="course-progress-bar" class="progress-bar progress-bar-striped active green" role="progressbar"
								     aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo floor($currentProgress); ?>%">
								</div>
							</div>
							<div class="status">
								<p><span class="total-complete-activities"><?php echo $totalCompleteActivities; ?></span>/<span class="total-activities"><?php echo $totalActivities; ?></span></p>
								<?php $totalSkipped  = ($ActivitySessionSkipped->getAllSkippedSessions() > 0) ? count($ActivitySessionSkipped->getAllSkippedSessions()) : 0; ?>
                                <p>(<data value="<?php echo $totalSkipped; ?>" data-skipped-course><?php echo $totalSkipped;  ?></data>  skipped)</p>
							</div>
							<div class="content">
								<?php
								/** The text for the progress section is located
								 * at: /site/public/json-data/course-progress/level-1.json' v
								 */

								/** @Var gets the current level's content array from the json file.  */
								$progress_content = $Courses->get_progress_content($Session->get('user-id'));
								?>
								<h4><?php echo $progress_content['title']; ?></h4>
								<div class="progress-body">
									<?php echo $progress_content['bodyText']; ?>
								</div>
							</div>
						</div>
					</div>
				</section>
			</main>
		</div>
		<div class="modal fade" id="stats-modal" tabindex="-1"  role="dialog" aria-labelledby="stats-modalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header ">
						<h5 class="modal-title" id="stats-modalLabel">Your Stats</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="member-stamp-container">Member since <span class="member-date">Jan 1, 2016</span></div>
						<div class="table" id="stat-table">
							<div class="count-info">
								<div class="box">
									<div class="stat-container">
										<span class="value blk-heading-main"><?php echo $UserStatus->total_days_signed_up; ?></span>
										<span class="value-text"><?php echo ($UserStatus->total_days_signed_up == 1) ? 'Day' : 'Days'; ?></span>
									</div>
									<div class="stat-container">
										<span class="value blk-heading-main"><?php echo $UserStatus->total_journal_post; ?></span>
										<span class="value-text">Journal Posts</span>
									</div>
									<div class="dotted-border-gray"></div>
									<div class="stat-container">
										<span class="value blk-heading-main"><?php echo $UserStatus->total_forum_post; ?></span>
										<span class="value-text">Forum Posts</span>
									</div>
									<div class="stat-container">
										<span class="value blk-heading-main"><?php echo $UserStatus->total_members_users_following; ?></span>
										<span class="value-text">Following</span>
									</div>
									<div class="dotted-border-gray"></div>
									<div class="stat-container">
										<span class="value blk-heading-main"><?php echo $UserStatus->total_members_following_user; ?></span>
										<span class="value-text">Following You</span>
									</div>
                                    <?php /*
									<div class="stat-container">
										<span class="value blk-heading-main"><?php echo $UserStatus->total_chat_sessions; ?></span>
										<span class="value-text">Chat Sessions</span>
									</div>
                                    <?php */ ?>
								</div>
							</div>
							<div class="chart-group">
								<div class="journal-weekly">
									<div class="box">
										<div class="chart-container" style="position: relative;">
											<canvas id="lineChart"></canvas>
										</div>
									</div>
								</div>
								<div class="day-bar">
									<div class="box">
										<div class="chart-container" style="position: relative;">
											<canvas id="myBarChart"></canvas>
										</div>
									</div>
								</div>
								<div class="day-pie">
									<div class="box">
										<div class="chart-container" style="position: relative;">
											<canvas id="myChart"></canvas>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4 sidebar-box">
			<aside>
				<?php include(SIDEBAR); ?>
			</aside>
		</div>
	</div>
</div>