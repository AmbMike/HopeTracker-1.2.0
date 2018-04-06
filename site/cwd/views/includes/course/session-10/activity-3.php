<div data-session-item="3" onclick="location.href= RELATIVE_PATH + '<?php echo "/families-of-drug-addicts/user-". User::user_info("id")."/course/my_progress"; ?>'">
    <p class="heading <?php echo ($Courses->session_status(10,3) == true) ? 'pre-complete' : '' ; ?>  ">
        Write About Your New Outlook
    </p>
    <p class="line-2">A lot has changed since you first started. Maybe not with your <span><?php echo ucfirst($User->user_concerned_about(User::user_info('concerned_about'))); ?></span>, but reflect on your progress.</p>
</div>
