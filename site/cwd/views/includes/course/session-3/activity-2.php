<div data-session-item="2" onclick="location.href= RELATIVE_PATH + '<?php echo "/families-of-drug-addicts/user-". User::user_info("id")."/course/stop_enabling"; ?>'">
    <p class="heading <?php echo ($Courses->session_status(3,2) == true) ? 'pre-complete' : '' ; ?> ">
        Recognize Your Own Enabling
    </p>
    <p class="line-2">Take an honest look at your "helping." Is it helping your <span><?php echo ucfirst($User->user_concerned_about(User::user_info('concerned_about'))); ?></span> live in addiction or avoid the consequences?</p>
</div>
