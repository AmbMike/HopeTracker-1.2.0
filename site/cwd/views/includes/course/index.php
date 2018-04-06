<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/hopetracker/config/constants.php');

include_once(CLASSES.'Courses.php');
$Courses = new Courses();

include_once(CLASSES.'class.ActivitySession.php');
include_once(CLASSES.'class.ActivitySessionItems.php');
include_once(CLASSES.'class.ActivitySessionSkipped.php');

$ActivitySession = new ActivitySession();
$ActivitySessionItems = new ActivitySessionItems();
$ActivitySessionSkipped = new ActivitySessionSkipped();
/* Uncomment out the line below to show the intro.  */
//Debug::clearCourseIntro();

$Page->header(array(
	'Title' => 'My Course Page Title',
	'Description' => 'The course page displays an overview of the course and the current status that are in. ',
	'Active Link' => 'University'
));
?>
<div id="course-outer">
    <div id="course-inner">

        <?php foreach ( $ActivitySession->sessionFolders as $index => $session_arr ): ?>
    <?php
        /** Get the session specific variables */
        include_once(realpath(dirname(__FILE__)) . '/' .  $session_arr['folder-name'] .  '/variables.php');
    ?>
    <?php $index++; ?>
    <div class="display-box" data-session-number="<?php echo $session_arr['session-number']; ?>">
        <div class="row no-margins">
            <?php
            $activeClass = '';
            if($ActivitySession->currentSession == $index):
                $activeClass = 'active';
            endif; ?>
            <?php if($ActivitySessionSkipped->isSessionSkipped($session_arr['session-number']) == false) : ?>
            <div class="col-md-12 header-container <?php echo $activeClass; ?>">
                <p><span class="blue-text-loud-md session-title">Session <?php echo $session_arr['session-number']; ?></span> <span data-session-title="<?php echo $_SESSION_TITLE; ?>" class="session-sub-title"><?php echo $_SESSION_TITLE; ?></span> </p>
                <?php else : ?>
            <div class="col-md-12 header-container skipped">
                <p><span class="blue-text-loud-md session-title">Session <?php echo $session_arr['session-number']; ?></span> <span data-session-title="<?php echo $_SESSION_TITLE; ?>" class="session-sub-title" role="button"><button class="btn btn-primary" data-revisit-session="<?php echo $session_arr['session-number']; ?>" >Revisit Session</button></span>  </p>
                <?php endif; ?>
                <div class="timer-clock">
                    <i class="fa fa-clock-o"></i>
                    <span class="timer-text"><?php echo $_SESSION_DURATION; ?> min</span>
                </div>
            </div>
            <div class="col-md-12 no-padd-xs">
                <?php if($ActivitySession->currentSession == $index): ?>
                <div id="step2" data-session-num="<?php echo $session_arr['session-number']; ?>" class="content current-session" <?php echo ($ActivitySessionSkipped->isSessionSkipped($session_arr['session-number']) == true) ? 'style="display: none;"' : ''; ?>>
                <?php else: ?>
                <div  id="step2" data-session-num="<?php echo $session_arr['session-number']; ?>" class="content" <?php echo ($ActivitySessionSkipped->isSessionSkipped($session_arr['session-number']) == true || $ActivitySession->currentSession != $session_arr['session-number']) ? 'style="display: none;"' : ''; ?>>
                <?php endif;?>
                    <?php include_once(realpath(dirname(__FILE__)) . '/' .  $session_arr['folder-name'] .  '/index.php');  ?>
	                <?php if($Session->get('viewed_course') != true): ?>
                    <div id="step3" class="text-right">
                    <?php endif; ?>
                        <div class="text-right">
                            <?php if($ActivitySessionItems->totalCompleteActivitiesPerSession($session_arr['session-number'])  > 0): ?>
                            <a class="show-complete" data-show-course="btn" role="button"><span class="text"><?php echo ($Courses->session_status_check(1) == true) ? 'Show Completed <i class="fa fa-angle-double-right"></i>' : ''; ?></span> </a>
                           <?php endif; ?>
                            <a class="skip" skip-status="<?php echo ($ActivitySession->sessionStatus() == 1) ? 'skip ' : 'un-skipped'; ?>" role="button"><span class="text"><?php echo ($ActivitySession->sessionStatus() == 1) ? 'Skip ' : 'Un-skip'; ?></span>  <i class="fa fa-angle-double-right"></i></a>
                        </div>
                    <?php if($Session->get('viewed_course') != true): ?>
                    </div>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php
        /** Stop the loop to only show the completed sessions.
        if($index  == $ActivitySession->currentSession){
        break;
        }  */?>
    <?php endforeach; ?>
    </div>
</div>