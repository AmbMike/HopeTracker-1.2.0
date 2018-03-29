<?php
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
$total_complete_activities = $Courses->get_total_clicked_activities($Session->get('user-id'));
$UserStatus = new UserStatus($Session->get('user-id'));

$General = new General();

/* Uncomment out the line below to show the intro.  */
Debug::clearCourseIntro();

?>
<div class="con main" id="courses" data-show-intro="<?php echo ($Session->get('viewed_course') != true) ? 'yes' : 'no'; ?>">
    <div class="row">
        <div class="col-md-8">
            <main>
                <section style="background-image: url('<?php //echo IMAGES; ?>home/people-img.jpg');" class="box-one main-title-box" >
                    <span class="h1-addon"><span class=" total-sessions"></span> Session</span>
                    <h1 class="green-heading-lg top">Addiction University</h1>
                    <p class="heading-text">
                        Created by industry-leading therapists in collaboration with a team of moms, you'll "graduate" with a better understanding of addiction and your role in supporting recovery. It's a lot, but don't be overwhelmed!
                    </p>
                </section>
                <section class="box-one main-title-box session-container">
                    <div id="step1"class="display-box">
                        <div class="row no-margins">
                            <div class="col-md-12 header-container">
                                <p><span class="blue-text-loud-md session-title">Session 1</span> covers the basics.</p>
                                <div class="timer-clock">
                                    <i class="fa fa-clock-o"></i>
                                    <span class="timer-text"><?php echo "25 min" ?></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div id="step2" data-session-num="1" class="content">
                                    <div class="content-item">
                                        <p data-session-item="1" <?php /*data-modal-id="modal-video"*/?> onClick="window.open('https://www.ambrosiatc.com/addiction/drug-addiction-disease/?fromHopeTracker&nav=no')" class="heading <?php echo ($Courses->session_status(1,1) == true) ? 'pre-complete' : '' ; ?> launch-modal ">
                                            Start with "Addiction 101"
                                        </p>
                                        <p class="line-2">Get answers to questions like "How did this happen?" and "Why can't they stop?"</p>
                                        <div class="modal video fade" id="modal-video" tabindex="-1" role="dialog" aria-labelledby="modal-video-label">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="modal-video">
                                                            <div class="embed-responsive embed-responsive-16by9">
                                                                <!-- Load Facebook SDK for JavaScript -->
                                                                <div id="fb-root"></div>
                                                                <script>(function(d, s, id) {
                                                                        var js, fjs = d.getElementsByTagName(s)[0];
                                                                        if (d.getElementById(id)) return;
                                                                        js = d.createElement(s); js.id = id;
                                                                        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6";
                                                                        fjs.parentNode.insertBefore(js, fjs);
                                                                    }(document, 'script', 'facebook-jssdk'));</script>

                                                                <!-- Your embedded video player code -->
                                                                <div class="fb-video" data-href="https://www.facebook.com/facebook/videos/1342628522502911/" data-width="500" data-show-text="false">
                                                                    <div class="fb-xfbml-parse-ignore">
                                                                        <blockquote cite="https://www.facebook.com/facebook/videos/1342628522502911/">
                                                                            <a href="https://www.facebook.com/facebook/videos/1342628522502911/">How to Share With Just Friends</a>
                                                                            <p>How to share with just friends.</p>
                                                                            Posted by <a href="https://www.facebook.com/facebook/">Facebook</a> on Friday, December 5, 2014
                                                                        </blockquote>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="content-item">
                                        <p data-session-item="2" onclick="location.href='<?php echo "/families-of-drug-addicts/user-". User::user_info("id")."/course/journalOutlet"; ?>'" class="heading <?php echo ($Courses->session_status(1,2) == true) ? 'pre-complete' : '' ; ?> ">
                                            Express Your Feelings & Story                                        </p>
                                        <p class="line-2">Journaling is an outlet to process emotions and increase self-awareness, while allowing you to track your growth.</p>
                                    </div>
                                    <div class="content-item">
                                        <p data-session-item="3" onclick="location.href='<?php echo "/family-of-drug-abuser"; ?>'" class="heading <?php echo ($Courses->session_status(1,3) == true) ? 'pre-complete' : '' ; ?> ">
                                            Post a Forum Question or Reply
                                        </p>
                                        <p class="line-2">Get and give direct answers, guidance and reassurance on any addiction-related topic.</p>
                                    </div>
                                    <?php if($Session->get('viewed_course') != true): ?>
                                    <div id="step3" class="text-right">
                                    <?php endif; ?>
                                        <a class="show-skip show-complete <?php echo ($Session->get('viewed_course') != true) ? : 'pull-right'; ?>"><?php echo ($Courses->session_status_check(1) == true) ? 'Show Completed <i class="fa fa-angle-double-right"></i>' : 'Skip <i class="fa fa-angle-double-right"></i>'?></a>
                                    <?php if($Session->get('viewed_course') != true): ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="display-box">
                        <div class="row no-margins">
                            <div class="col-md-12 header-container">
                                <p><span class="blue-text-loud-md session-title">Session 2</span> connects you with a community.</p>
                                <div class="timer-clock">
                                    <i class="fa fa-clock-o"></i>
                                    <span class="timer-text"><?php echo "20 min" ?></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div data-session-num="2" class="content">
                                    <div class="content-item">
                                        <p data-session-item="1" onClick="window.open('https://www.ambrosiatc.com/addiction/meetings-for-family-of-addicts/?fromHopeTracker&nav=no');" class="heading <?php echo ($Courses->session_status(2,1) == true) ? 'pre-complete' : '' ; ?> ">
                                            Learn What You Should be Doing
                                        </p>
                                        <p class="line-2">While there are a lot of things you shouldn't do to help, you absolutely do need to be proactive and stay supported. Here's how.</p>
                                    </div>
                                    <div class="content-item">
                                        <p data-session-item="2" class="heading <?php echo ($Courses->session_status(2,2) == true) ? 'pre-complete' : '' ; ?>">
                                            Add Support Groups to Your Calendar
                                        </p>
                                        <p class="line-2">Family conflict and deep-seeded anger, denial, hopelessness and anxiety are side effects of addiction. Don't go through it alone.</p>
                                    </div>
                                    <div class="content-item">
                                    <p data-session-item="3" onclick="location.href='/journal/'" class="heading <?php echo ($Courses->session_status(2,3) == true) ? 'pre-complete' : '' ; ?> ">
                                        Find People to Follow
                                    </p>
                                    <p class="line-2">
                                        You're not alone. Read, comment and follow others in your same situation. See their future updates on the community page.
                                    </p>
                                    </div>
                                    <div class="content-item">
                                        <p data-session-item="5" class="heading <?php echo ($Courses->session_status(2,5) == true) ? 'pre-complete' : '' ; ?>">
                                            Actually Attend a Support Group
                                        </p>
                                        <p class="line-2">Wait to mark this activity until you've attended a support group. (Past meetings don't count).</p>
                                    </div>
                                    <a class="pull-right show-skip show-complete"><?php echo ($Courses->session_status_check(2) == true) ? 'Show Completed <i class="fa fa-angle-double-right"></i>' : 'Skip <i class="fa fa-angle-double-right"></i>'?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="display-box">
                        <div class="row no-margins">
                            <div class="col-md-12 header-container">
                                <p><span class="blue-text-loud-md session-title">Session 3</span> identifies "helping" that's not helpful.</p>
                                <div class="timer-clock">
                                    <i class="fa fa-clock-o"></i>
                                    <span class="timer-text"><?php echo "25 min" ?></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div data-session-num="3" class="content">
                                    <div class="content-item">
                                        <p data-session-item="1" onClick="window.open('https://www.ambrosiatc.com/addiction/drug-addiction-and-families/?fromHopeTracker&nav=no')" class="heading <?php echo ($Courses->session_status(3,1) == true) ? 'pre-complete' : '' ; ?> ">
                                            Understand Enabling
                                        </p>
                                        <p class="line-2">Behaviors that feel like "the right thing to do" may be keeping your <span><?php echo ucfirst($User->user_concerned_about(User::user_info('concerned_about'))); ?></span> too comfortable in addiction.</p>
                                    </div>
                                    <div class="content-item">
                                        <p data-session-item="2" onclick="location.href='<?php echo "/families-of-drug-addicts/user-". User::user_info("id")."/course/stop_enabling"; ?>'" class="heading <?php echo ($Courses->session_status(3,2) == true) ? 'pre-complete' : '' ; ?> ">
                                            Recognize Your Own Enabling
                                        </p>
                                        <p class="line-2">Take an honest look at your "helping." Is it helping your <span><?php echo ucfirst($User->user_concerned_about(User::user_info('concerned_about'))); ?></span> live in addiction or avoid the consequences?</p>
                                    </div>
                                    <a class="pull-right show-skip show-complete"><?php echo ($Courses->session_status_check(3) == true) ? 'Show Completed <i class="fa fa-angle-double-right"></i>' : 'Skip <i class="fa fa-angle-double-right"></i>'?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="display-box">
                        <div class="row no-margins">
                            <div class="col-md-12 header-container">
                                <p><span class="blue-text-loud-md session-title">Session 4</span> teaches boundaries & communication.</p>
                                <div class="timer-clock">
                                    <i class="fa fa-clock-o"></i>
                                    <span class="timer-text"><?php echo "25 min" ?></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div data-session-num="4" class="content">
                                    <div class="content-item">
                                        <p data-session-item="1" onClick="window.open('https://www.ambrosiatc.com/addiction/living-with-an-addict/?fromHopeTracker&nav=no')" class="heading <?php echo ($Courses->session_status(4,1) == true) ? 'pre-complete' : '' ; ?> ">
                                            Learn to Stand Your Ground
                                        </p>
                                        <p class="line-2">Boundaries and communication are keys to healthy relationships; even when your loved one isn’t healthy.</p>
                                    </div>
                                    <div class="content-item">
                                        <p data-session-item="2" onclick="location.href='<?php echo "/families-of-drug-addicts/user-". User::user_info("id")."/course/my_boundaries";  ?>'" class="heading <?php echo ($Courses->session_status(4,2) == true) ? 'pre-complete' : '' ; ?>  ">
                                            Define Your Boundaries
                                        </p>
                                        <p class="line-2">What behaviors are unacceptable? What are the consequences? Be clear.</p>
                                    </div>
                                    <div class="content-item">
                                        <p data-session-item="3" class="heading <?php echo ($Courses->session_status(4,3) == true) ? 'pre-complete' : '' ; ?>">
                                            Actually Discuss the Boundaries
                                        </p>
                                        <p class="line-2">Wait to mark this activity until you've actually communicated these boundaries to your <span><?php echo ucfirst($User->user_concerned_about(User::user_info('concerned_about'))); ?></span>.</p>
                                    </div>
                                    <a class="pull-right show-skip show-complete"><?php echo ($Courses->session_status_check(4) == true) ? 'Show Completed <i class="fa fa-angle-double-right"></i>' : 'Skip <i class="fa fa-angle-double-right"></i>'?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="display-box">
                        <div class="row no-margins">
                            <div class="col-md-12 header-container">
                                <p><span class="blue-text-loud-md session-title">Session 5</span> is about addiction treatment.</p>
                                <div class="timer-clock">
                                    <i class="fa fa-clock-o"></i>
                                    <span class="timer-text"><?php echo "15 min" ?></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div data-session-num="5" class="content">
                                    <div class="content-item">
                                        <p data-session-item="1" onClick="window.open('https://www.ambrosiatc.com/addiction/addiction-recovery/?fromHopeTracker&nav=no')" class="heading <?php echo ($Courses->session_status(5,1) == true) ? 'pre-complete' : '' ; ?> ">
                                            Understand Treatment Options
                                        </p>
                                        <p class="line-2">The change you're looking for comes with quality treatment. Understand your options, costs and medications.</p>
                                    </div>
                                    <div class="content-item">
                                        <p data-session-item="2" class="heading <?php echo ($Courses->session_status(5,2) == true) ? 'pre-complete' : '' ; ?>">
                                            Actually Contact a Facility
                                        </p>
                                        <p class="line-2">Wait to mark this activity until you've talked with at least one treatment center.</p>
                                    </div>
                                    <a class="pull-right show-skip show-complete"><?php echo ($Courses->session_status_check(5) == true) ? 'Show Completed <i class="fa fa-angle-double-right"></i>' : 'Skip <i class="fa fa-angle-double-right"></i>'?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="display-box">
                        <div class="row no-margins">
                            <div class="col-md-12 header-container">
                                <p><span class="blue-text-loud-md session-title">Session 6</span> helps get your loved one to treatment.</p>
                                <div class="timer-clock">
                                    <i class="fa fa-clock-o"></i>
                                    <span class="timer-text"><?php echo "25 min" ?></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div data-session-num="6" class="content">
                                    <div class="content-item">
                                        <p data-session-item="1" onClick="window.open('https://www.ambrosiatc.com/addiction/interventions-for-alcoholism-drugs/?fromHopeTracker&nav=no')" class="heading <?php echo ($Courses->session_status(6,1) == true) ? 'pre-complete' : '' ; ?> ">
                                            Get Your <?php echo ucfirst($User->user_concerned_about(User::user_info('concerned_about'))); ?> to Treatment
                                        </p>
                                        <p class="line-2">You know where to turn and what to expect, now how do you get your <span><?php echo ucfirst($User->user_concerned_about(User::user_info('concerned_about'))); ?></span> to actually go?</p>
                                    </div>
                                    <div class="content-item">
                                        <p data-session-item="2" onclick="location.href='<?php echo "/families-of-drug-addicts/user-". User::user_info("id")."/course/my_intervention";  ?>'" class="heading <?php echo ($Courses->session_status(6,2) == true) ? 'pre-complete' : '' ; ?>  ">
                                            Write Your Plans for Intervention
                                        </p>
                                        <p class="line-2">Planning helps conversations go smoother and increases the chance of success.</p>
                                    </div>

                                    <div class="content-item">
                                        <p data-session-item="3" class="heading  <?php echo ($Courses->session_status(6,3) == true) ? 'pre-complete' : '' ; ?>">
                                            Actually Have the Conversation
                                        </p>
                                        <p class="line-2">Wait to mark this activity until you've completed an intervention.</p>
                                    </div>
                                    <a class="pull-right show-skip show-complete"><?php echo ($Courses->session_status_check(6) == true) ? 'Show Completed <i class="fa fa-angle-double-right"></i>' : 'Skip <i class="fa fa-angle-double-right"></i>'?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="display-box">
                        <div class="row no-margins">
                            <div class="col-md-12 header-container">
                                <p><span class="blue-text-loud-md session-title">Session 7</span> explains what to do if treatment is refused.</p>
                                <div class="timer-clock">
                                    <i class="fa fa-clock-o"></i>
                                    <span class="timer-text"><?php echo "15 min" ?></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div data-session-num="7" class="content">
                                    <div class="content-item">
                                        <p data-session-item="1" onClick="window.open('https://www.ambrosiatc.com/addiction/detachment-with-love/?fromHopeTracker&nav=no')" class="heading <?php echo ($Courses->session_status(7,1) == true) ? 'pre-complete' : '' ; ?> ">
                                            Assess Next Steps Now
                                        </p>
                                        <p class="line-2">What do you do if your <span><?php echo ucfirst($User->user_concerned_about(User::user_info('concerned_about'))); ?></span> chooses addiction? Learn about next steps in tough situations.</p>
                                    </div>
                                    <div class="content-item">
                                        <p data-session-item="2" onclick="location.href='<?php echo "/families-of-drug-addicts/user-". User::user_info("id")."/course/refused_treatment"; ?>'" class="heading <?php echo ($Courses->session_status(7,2) == true) ? 'pre-complete' : '' ; ?>  ">
                                            Write About How You Feel
                                        </p>
                                        <p class="line-2">When a loved one refuses treatment, it's heartbreaking. Use the journal as an outlet for your feelings.</p>
                                    </div>
                                    <a class="pull-right show-skip show-complete"><?php echo ($Courses->session_status_check(7) == true) ? 'Show Completed <i class="fa fa-angle-double-right"></i>' : 'Skip <i class="fa fa-angle-double-right"></i>'?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="display-box">
                        <div class="row no-margins">
                            <div class="col-md-12 header-container">
                                <p><span class="blue-text-loud-md session-title">Session 8</span> is for healing after treatment.</p>
                                <div class="timer-clock">
                                    <i class="fa fa-clock-o"></i>
                                    <span class="timer-text"><?php echo "10 min" ?></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div data-session-num="8" class="content">
                                    <div class="content-item">
                                        <p data-session-item="1" onclick="window.open('https://www.ambrosiatc.com/addiction/life-after-rehab/?fromHopeTracker&nav=no')" class="heading  <?php echo ($Courses->session_status(8,1) == true) ? 'pre-complete' : '' ; ?>">
                                            Rebuild, But Watch for Red Flags
                                        </p>
                                        <p class="line-2">Understand when you should be taking more action and when you should be working toward rebuilding your relationship.</p>
                                    </div>
                                    <a class="pull-right show-skip show-complete"><?php echo ($Courses->session_status_check(8) == true) ? 'Show Completed <i class="fa fa-angle-double-right"></i>' : 'Skip <i class="fa fa-angle-double-right"></i>'?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="display-box">
                        <div class="row no-margins">
                            <div class="col-md-12 header-container">
                                <p><span class="blue-text-loud-md session-title">Session 9</span> is about staying positive.</p>
                                <div class="timer-clock">
                                    <i class="fa fa-clock-o"></i>
                                    <span class="timer-text"><?php echo "20 min" ?></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div data-session-num="9" class="content">
                                    <div class="content-item">
                                        <p data-session-item="1" onClick="window.open('https://www.ambrosiatc.com/addiction/staying-positive/?fromHopeTracker&nav=no')" class="heading <?php echo ($Courses->session_status(9,1) == true) ? 'pre-complete' : '' ; ?> ">
                                            Learn to be More Positive
                                        </p>
                                        <p class="line-2">There are things you can be doing every day to take control of your thoughts, your stress and your attitude.</p>
                                    </div>
                                    <div class="content-item">
                                        <p data-session-item="2" onclick="location.href='<?php echo "/families-of-drug-addicts/user-". User::user_info("id")."/course/be_Proactive"; ?>'" class="heading <?php echo ($Courses->session_status(9,2) == true) ? 'pre-complete' : '' ; ?>  ">
                                            Make a Plan for Positivity
                                        </p>
                                        <p class="line-2">After reading about different tools, what are you specifically going to incorporate into your life to be proactive against negativity?</p>
                                    </div>
                                    <div class="content-item">
                                        <p data-session-item="3" onclick="location.href='<?php echo "/families-of-drug-addicts/user-". User::user_info("id")."/course/be_Proactive"; ?>'" class="heading <?php echo ($Courses->session_status(9,2) == true) ? 'pre-complete' : '' ; ?>  ">
                                            View & Save Inspirational Quotes
                                        </p>
                                        <p class="line-2">A place to come anytime for a quick pick-me-up.</p>
                                    </div>
                                    <div class="content-item">
                                        <p data-session-item="4" onclick="location.href='<?php echo "/journal"; ?>'" class="heading <?php echo ($Courses->session_status(9,2) == true) ? 'pre-complete' : '' ; ?>  ">
                                            Read Stories of Recovery
                                        </p>
                                        <p class="line-2">People in recovery are everywhere, doing amazing things. No matter how bad your situation is, remember recovery is possible!</p>
                                    </div>
                                    <a class="pull-right show-skip show-complete"><?php echo ($Courses->session_status_check(9) == true) ? 'Show Completed <i class="fa fa-angle-double-right"></i>' : 'Skip <i class="fa fa-angle-double-right"></i>'?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="display-box">
                        <div class="row no-margins">
                            <div class="col-md-12 header-container">
                                <p><span class="blue-text-loud-md session-title">Session 10</span> reviews your progress.</p>
                                <div class="timer-clock">
                                    <i class="fa fa-clock-o"></i>
                                    <span class="timer-text"><?php echo "10 min" ?></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div data-session-num="10" class="content">
                                    <div class="content-item">
                                        <p data-session-item="1" class="heading <?php echo ($Courses->session_status(10,1) == true) ? 'pre-complete' : '' ; ?> " data-toggle="modal" data-target="#stats-modal">
                                                Review your progress
                                        </p>
                                        <p class="line-2">You've made a real effort to understand addiction and the role you play. Congratulations! See your charts and numbers.</p>
                                    </div>
                                    <div class="content-item">
                                        <p data-session-item="2" onClick="window.open('https://www.ambrosiatc.com/addiction/information-addiction/?fromHopeTracker&nav=no')" class="heading <?php echo ($Courses->session_status(10,2) == true) ? 'pre-complete' : '' ; ?>  ">
                                            Test Your Knowledge
                                        </p>
                                        <p class="line-2">See how much you've learned. Take the quiz.</p>
                                    </div>
                                    <div class="content-item">
                                        <p data-session-item="3" onclick="location.href='<?php echo "/families-of-drug-addicts/user-". User::user_info("id")."/course/my_progress"; ?>'" class="heading <?php echo ($Courses->session_status(10,3) == true) ? 'pre-complete' : '' ; ?>  ">
                                            Write About Your New Outlook
                                        </p>
                                        <p class="line-2">A lot has changed since you first started. Maybe not with your <span><?php echo ucfirst($User->user_concerned_about(User::user_info('concerned_about'))); ?></span>, but reflect on your progress.</p>
                                    </div>
                                    <div class="content-item">
                                        <p data-session-item="4" onclick="location.href='/journal/'" class="heading <?php echo ($Courses->session_status(10,4) == true) ? 'pre-complete' : '' ; ?>  ">
                                            Offer Support to Someone Else
                                        </p>
                                        <p class="line-2">Put your story and knowledge to use.</p>
                                    </div>
                                    <div class="content-item">
                                        <p data-session-item="5" onclick="location.href='/protected/settings/feedback'" class="heading <?php echo ($Courses->session_status(10,5) == true) ? 'pre-complete' : '' ; ?>  ">
                                            Provide Feedback
                                        </p>
                                        <p class="line-2">Is there anything we could do better? Let us know!</p>
                                    </div>
                                    <a class="pull-right show-skip show-complete"><?php echo ($Courses->session_status_check(10) == true) ? 'Show Completed <i class="fa fa-angle-double-right"></i>' : 'Skip <i class="fa fa-angle-double-right"></i>'?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section id="step4" class="box-one gray progress-container">
                    <div class="inside-box no-top no-bottom-p">
                        <div class="row" id="progress-box">
                            <div id="heading" class="col-md-12">
                                <h3 class="simple-heading progress-title">My Achievement</h3>
                                <div class="invite-box">
                                    <a data-toggle="modal" data-target="#stats-modal"><i class="fa fa-line-chart"></i> View My Stats</a>
                                </div>
                            </div>
                        </div>
                        <div id="progress-details">
                            <?php
                                $current_level_number = $Courses->get_current_level_number($Session->get('user-id'));
                            ?>
                            <img src="<?php echo IMAGES .'course/award-' . $current_level_number . '.png'; ?>" width="100" alt="Award">
                            <div class="progress">
                                <div id="course-progress-bar" class="progress-bar progress-bar-striped active green" role="progressbar"
                                     aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:70%">
                                </div>
                            </div>
                            <div class="status">
                                <p><span class="total-complete-activities"><?php echo $total_complete_activities; ?></span>/<span class="total-activities"> </span></p>
                                <p>(0 skipped)</p>
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
                                    <div class="stat-container">
                                        <span class="value blk-heading-main"><?php echo $UserStatus->total_chat_sessions; ?></span>
                                        <span class="value-text">Chat Sessions</span>
                                    </div>
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















