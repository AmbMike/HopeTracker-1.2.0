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
	'Title' => 'Second',
	'Description' => 'This is the Home Page',
	'Show Nav' => true,
	'Active Link' => ''
));

/** Include Text Left JS */
$text_left = true;
?>
<main id="new-home">
	<section id="top-container">
		<div class="con">
			<div class="row">
				<div class="col-sm-5 col-md-6">
					<div class="heading-box">
						<h1 class="primary-header">Find <span class="text-left"></span> </h1>
						<hr>
						<p class="sub-heading">
							For anyone who loves someone struggling with alcohol or other drugs, there is hope.
						</p>
						<button class="btn">Sign Up Now <small>(free)</small></button>
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
				<p class="sub-heading">A 14 Session crash course on addiction and a social community to support you forever.</p>
			</div>
			<div class="part-two">
				<div class="row">
					<div class="col-md-6">
                        <div class="info-steps-box">
                            <p>Everything you ever needed to know about addiction and your specific situation, created by families for families. </p>
                            <ul>
                                <li>Feel better an more in control of the situation</li>
                                <li>Get friendship, advice and accountability</li>
                                <li>Rest easy, it's TOTALLY free with no catch</li>
                            </ul>
                        </div>
                        <div class="btn-box">
                            <button class="btn">
                                Join Now <small>It's Free</small>
                            </button>
                            <p><i class="fa fa-star"></i> 144 members and counting</p>
                        </div>
                    </div>
					<div class="col-md-6">
						<img src="<?php echo IMAGES; ?>home/ipad-display.jpg" class="img-responsive">
					</div>
					<div class="clearfix"></div>
					<hr>
				</div>
			</div>
			<div class="testimonials" id="testimonials">
				<h3>Testimonials</h3>
                <div class="mg-3d-slider" id="mg-slider">
                    <div class="slide-box">
                        <div class="slider">
                            <div class="slide-item">
                                <figure>
                                    <img src="<?php echo IMAGES . '/home/profiles/one.jpg'; ?>" class="img-responsive">
                                    <figcaption><span class="name">Sean D.</span>
                                        <small class="mg-sub-title">A father from CA </small>
                                    </figcaption>
                                    <i class="fa fa-quote-right"></i>
                                    <p class="text">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. </p>
                                </figure>
                            </div>
                            <div class="slide-item active">
                                <figure>
                                    <img src="<?php echo IMAGES . '/home/profiles/three.jpg'; ?>" class="img-responsive">
                                    <figcaption><span class="name">Albert E.</span>
                                        <small class="mg-sub-title">A father from GA </small>
                                    </figcaption>
                                    <i class="fa fa-quote-right"></i>
                                    <p class="text">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. </p>
                                </figure>
                            </div>
                            <div class="slide-item">
                                <figure>
                                    <img src="<?php echo IMAGES . '/home/profiles/two.jpg'; ?>" class="img-responsive">
                                    <figcaption><span class="name">Sally M.</span>
                                        <small class="mg-sub-title">A father from CT </small>
                                    </figcaption>
                                    <i class="fa fa-quote-right"></i>
                                    <p class="text">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. </p>
                                </figure>
                            </div>
                            <div class="slide-item">
                                <figure>
                                    <img src="<?php echo IMAGES . '/home/profiles/four.jpg'; ?>" class="img-responsive">
                                    <figcaption><span class="name">Sean D.</span>
                                        <small class="mg-sub-title">A father from CA </small>
                                    </figcaption>
                                    <i class="fa fa-quote-right"></i>
                                    <p class="text">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. </p>
                                </figure>
                            </div>
                            <div class="slide-item">
                                <figure>
                                    <img src="<?php echo IMAGES . '/home/profiles/six.jpg'; ?>" class="img-responsive">
                                    <figcaption><span class="name">Albert E.</span>
                                        <small class="mg-sub-title">A father from GA </small>
                                    </figcaption>
                                    <i class="fa fa-quote-right"></i>
                                    <p class="text">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. </p>
                                </figure>
                            </div>
                            <div class="slide-item">
                                <figure>
                                    <img src="<?php echo IMAGES . '/home/profiles/five.jpg'; ?>" class="img-responsive">
                                    <figcaption><span class="name">Sally M.</span>
                                        <small class="mg-sub-title">A father from CT </small>
                                    </figcaption>
                                    <i class="fa fa-quote-right"></i>
                                    <p class="text">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. </p>
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
                            <div class="col-md-6 no-r-p d-flex cus-l-padd">
					            <?php  FAQ::version_1(array(
						            'Question' => 'Is this the place you put the question?',
						            'Answer' => 'Yes, fore each question there is an answer and this is where you would put the text to answer the questions asked above. Give it a try and add a new question and answer below',
					            )) ?>
					            <?php  FAQ::version_1(array(
						            'Question' => 'Is this the place you put the question?',
						            'Answer' => 'Yes, fore each question there is an answer and this is where you would put the text to answer the questions asked above. Give it a try and add a new question and answer below',
					            )) ?>
                            </div>
                            <div class="col-md-6 d-flex cus-r-padd">
					            <?php  FAQ::version_1(array(
						            'Question' => 'Is this the place you put the question?',
						            'Answer' => 'Yes, fore each question there is an answer and this is where you would put the text to answer the questions asked above. Give it a try and add a new question and answer below',
					            )) ?>
					            <?php  FAQ::version_1(array(
						            'Question' => 'Is this the place you put the question?',
						            'Answer' => 'Yes, fore each question there is an answer and this is where you would put the text to answer the questions asked above. Give it a try and add a new question and answer below',
					            )) ?>
                            </div>
                        </div>

            </div>
		</div>
	</section>
</main>
