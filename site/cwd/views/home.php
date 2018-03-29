<?php
/**
 * Copyright (c) 2017.
 */

/**
 * File For: HopeTracker.com
 * File Name: home.php.
 * Author: Mike Giammattei
 * Created On: 3/10/2017, 11:19 AM
 */
?>
<?php
$Page = new \Page_Attr\Page();
$Page->header(array(
	'Title' => 'HopeTracker | Do You Love Someone Struggling with Addiction?',
	'Description' => 'Everything you need to know about drug and alcohol addiction and advice for your specific situation, created by families for families.',
	'Show Nav' => true,
	'Active Link' => '',
    'OG Image'  => OG_IMAGES  . 'main-pg.jpg',
    'OG Title'  => 'HopeTracker | Do You Love Someone Struggling with Addiction?'
));

/** Include Text Left JS */
$text_left = true;
$Users = new User();
$SignUpBtn = new SignUpBtn('/protected/course','Get Started','Join Now <small>(It\'s free)</small>');
?>
<main id="new-home">
	<section id="top-container">
		<div class="con">
			<div class="row">
				<div class="col-sm-5 col-md-6">
					<div class="heading-box">
						<h1 class="primary-header"><span class="heading-first">Find</span>  <span class="text-left"> </span> </h1>
						<hr>
						<p class="sub-heading">
							For anyone who loves someone struggling with alcohol or other drugs, there is hope.
						</p>
						<button <?php echo $SignUpBtn->btnActionHTML; ?>><?php echo $SignUpBtn->btnOutText; ?></button>
					</div>
				</div>
				<div class="col-sm-7 col-md-6">

				</div>
			</div>
		</div>
	</section>
	<section id="block2">
		<div class="con">
			<div class="part-one">
				<h2>What is HopeTracker?</h2>
				<p class="sub-heading">A 10-session crash course on addiction and a social community to support you forever.</p>
			</div>
			<div class="part-two">
				<div class="row">
					<div class="col-md-6">
                        <div class="info-steps-box">
                            <p>Everything you need to know about addiction and your specific situation, created by families for families.</p>
                            <ul>
                                <li>Feel better and more in control of the situation</li>
                                <li>Get friendship, advice and accountability </li>
                                <li>Rest easy, it's completely free with no catch</li>
                            </ul>
                        </div>
                        <div class="btn-box">
                            <button <?php echo $SignUpBtn->btnActionHTML; ?>>
                               <?php  echo $SignUpBtn->optionBtnText(' Sign Up Now'); ?>
                            </button>
                            <p><i class="fa fa-star"></i> Join <?php echo count($Users->all_users()); ?> Families</p>
                        </div>
                    </div>
					<div class="col-md-6">
						 <img src="<?php echo IMAGES; ?>home/hopetracker-home-bg.png" class="img-responsive">
					</div>
					<div class="clearfix"></div>
					<hr>
				</div>
			</div>
			<div class="testimonials" id="testimonials">
				<h3>The Community</h3>
                <div class="mg-3d-slider" id="mg-slider">
                    <div class="slide-box">
                        <div class="slider">
                            <div class="slide-item">
                                <figure>
                                    <img src="<?php echo IMAGES; ?>testimonials/FATHER.png" class="img-responsive">
                                    <figcaption><span class="name">Sean D.</span>
                                        <small class="mg-sub-title">A dad from MO </small>
                                    </figcaption>
                                    <i class="fa fa-quote-right"></i>
                                    <p class="text">My son was brought back to life after an overdose in my own house. Even that didn’t get him to stop. I didn’t know what else to do. HopeTracker gave me a new perspective and new connections that actually understood.</p>
                                </figure>
                            </div>
                            <div class="slide-item active">
                                <figure>
                                    <img src="<?php echo IMAGES; ?>testimonials/WIFE.png" class="img-responsive">
                                    <figcaption><span class="name">Debbie A.</span>
                                        <small class="mg-sub-title">A mom from NJ </small>
                                    </figcaption>
                                    <i class="fa fa-quote-right"></i>
                                    <p class="text">It wasn't until I started to write down in HopeTracker some of the stories of dealing with my daughter's addiction that I realized how crazy my own behavior was. You get sucked into their world and the HopeTracker brought me back.</p>
                                </figure>
                            </div>
                            <div class="slide-item">
                                <figure>
                                    <img src="<?php echo IMAGES; ?>testimonials/HUSBAND.png" class="img-responsive">
                                    <figcaption><span class="name">Luke K.</span>
                                        <small class="mg-sub-title">A husband from PA </small>
                                    </figcaption>
                                    <i class="fa fa-quote-right"></i>
                                    <p class="text">I didn't realize how much I didn't know about addiction before. The information on HopeTracker is actually helpful. Taylor now has six months in recovery, and I never thought I'd be able to say. </p>
                                </figure>
                            </div>
                            <div class="slide-item">
                                <figure>
                                    <img src="<?php echo IMAGES; ?>testimonials/MOTHER.png" class="img-responsive">
                                    <figcaption><span class="name">Joan B.</span>
                                        <small class="mg-sub-title">A mom from NY </small>
                                    </figcaption>
                                    <i class="fa fa-quote-right"></i>
                                    <p class="text">I kept hearing that I needed to go to support groups and get help for myself, but I felt like this was my son's problem, not mine. It wasn't until his second time in treatment that I signed up for HopeTracker, and I finally understood.</p>
                                </figure>
                            </div>
                            <div class="slide-item">
                                <figure>
                                    <img src="<?php echo IMAGES; ?>testimonials/GRANDMA.png" class="img-responsive">
                                    <figcaption><span class="name">Julie S.</span>
                                        <small class="mg-sub-title">A wife from GA </small>
                                    </figcaption>
                                    <i class="fa fa-quote-right"></i>
                                    <p class="text">I love my husband, but when does the disappointment end? I finally realized that if I wanted change so bad, then I'm the one that needs to change. It hasn't been easy, but at least I have a guide and a place to turn to. </p>
                                </figure>
                            </div>
                            <div class="slide-item">
                                <figure>
                                    <img src="<?php echo IMAGES; ?>testimonials/GIRLFRIEND.png" class="img-responsive">
                                    <figcaption><span class="name">Kelly M.</span>
                                        <small class="mg-sub-title">A mom from CT </small>
                                    </figcaption>
                                    <i class="fa fa-quote-right"></i>
                                    <p class="text">I didn't realize just how alone I really felt. I wasn't talking about it to anyone. It wasn't until HopeTracker that I could recognize addiction for the disease it is and finally connect with other moms that really got what I was going through. </p>
                                </figure>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="navigation">
                        <i class="fa fa-chevron-left left-x" aria-hidden="true"></i>
                        <i class="fa fa-chevron-right right-x" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
            <div class="faq-home">
                <div class="row">
                    <div class="col-md-6 no-r-p d-flex">
                      <?php  FAQ::version_1(array(
                        'Question' => 'There is no required time commitment.',
                        'Answer' => 'HopeTracker is meant to help you, not burden you.  You can move at your own pace and skip whole sessions as needed. Heck, you can sign up just to post one question on the forum.  However, you\'ll get the real benefit by taking the time to complete all 10 sessions and being an active member of the community.',
                      )) ?>
                      <?php  FAQ::version_1(array(
                        'Question' => 'You can be as anonymous as you want.',
                        'Answer' => 'While displaying your name and adding a real photo makes the community more personal, you may have reservations. You can choose to show as completely anonymous or with your first name last initial. These settings can be adjusted at any time.',
                      )) ?>
                    </div>
                    <div class="col-md-6 d-flex">
                      <?php  FAQ::version_1(array(
                        'Question' => 'HopeTracker is 100% free, forever.',
                        'Answer' => 'There\'s no catch. HopeTracker is proudly powered by Ambrosia Treatment Center. If it\'s appropriate for your loved one to come here, great! We hope you feel comfortable knowing we understand and are committed to the cause.  However, this resource is open to anyone. It\'s about giving hope to any family that feels helpless.',
                      )) ?>
                      <?php  FAQ::version_1(array(
                        'Question' => 'You need real support and advice.',
                        'Answer' => 'Most families that are desperate for change don\'t realize (or accept) that change can start with their own decisions. Even a small step forward is meaningful. Addiction is impossible to understand and navigate alone, so prepare yourself for the journey ahead with knowledge, support and accountability.',
                      )) ?>
                    </div>
                </div>
            </div>
		</div>
	</section>
</main>