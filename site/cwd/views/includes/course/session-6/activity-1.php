<div  data-session-item="1" onClick="window.open('https://www.ambrosiatc.com/addiction/interventions-for-alcoholism-drugs/?fromHopeTracker&nav=no')">
    <p class="heading <?php echo ($Courses->session_status(6,1) == true) ? 'pre-complete' : '' ; ?> ">
        Get Your <?php echo ucfirst($User->user_concerned_about(User::user_info('concerned_about'))); ?> to Treatment
    </p>
    <p class="line-2">You know where to turn and what to expect, now how do you get your <span><?php echo ucfirst($User->user_concerned_about(User::user_info('concerned_about'))); ?></span> to actually go?</p>
</div>
