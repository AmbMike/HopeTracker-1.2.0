<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/hopetracker/config/constants.php'); ?>
<div data-session-item="3" onclick="location.href='/<?php echo RELATIVE_PATH . 'addiction-quotes/'; ?>'" role="button">
    <p class="heading <?php echo ($Courses->session_status(9,2) == true) ? 'pre-complete' : '' ; ?>  ">
        View & Save Inspirational Quotes
    </p>
    <p class="line-2">A place to come anytime for a quick pick-me-up.</p>
</div>
