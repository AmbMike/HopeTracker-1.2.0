<p data-session-item="3" class="heading <?php echo ($Courses->session_status(4,3) == true) ? 'pre-complete' : '' ; ?>">
	Actually Discuss the Boundaries
</p>
<p class="line-2">Wait to mark this activity until you've actually communicated these boundaries to your <span><?php echo ucfirst($User->user_concerned_about(User::user_info('concerned_about'))); ?></span>.</p>
