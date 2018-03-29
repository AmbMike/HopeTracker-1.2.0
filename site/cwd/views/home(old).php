<?php
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
    'Title' => 'Home Page Title',
    'Description' => 'This is the Home Page',
    'Show Nav' => true,
    'Active Link' => ''
));
?>
<div class="con main" id="home">
    <div class="row">
        <div class="col-md-8">
            <main>
                <section class="box-one bg-img" style="background-image: url('<?php echo IMAGES; ?>home/people-img.jpg');">
                    <h1 class="green-heading-lg top">There is hope.</h1>
                    <p class="blue-text-sm top">For anyone who loves someone struggling with alcohol or drugs.</p>
                </section>
                <section class="box-one info-web">
                    <p><strong>A Community To Support You Forever!</strong> This is where the new verbiage will go. Please disregard this verbiage, its sole purpose is to act as a place holder for the official. Therefore, the view can see what the webpage will look like with actual text on the screen.</p>
                    <img src="<?php echo IMAGES; ?>demos/home-mapping.jpg" alt="Demo" class="img-responsive">
                </section>
                <section class="box-one no-t-padd">
                    <div class="inside-box no-t-b-padd">
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
                </section>
            </main>
        </div>
        <div class="col-md-4 sidebar-box">
            <aside>
                <?php include(SIDEBAR); ?>
            </aside>
        </div>
    </div>
</div>
