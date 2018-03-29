<?php
/**
 * File For: HopeTracker.com
 * File Name: style-guide.php.
 * Author: Mike Giammattei
 * Created On: 3/10/2017, 2:16 PM
 */
?>
<?php
$Page = new \Page_Attr\Page();
$Page->header(array(
    'Title' => 'Global Site Style Guide',
    'Description' => 'All styles for the web application are displayed on this page.',
));
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <section class="box-one">
                <p class="green-heading-lg">Global Styles</p>
            </section>
            <section class="box-one">
                <a href="tel:<?php echo MAIN_PHONE ?>" class="phone-style"><?php echo \Page_Attr\Format::phone(MAIN_PHONE) ?></a>
            </section>
            <section class="box-one">
                <h4 class="blue-text-sm">Theme Colors</h4>
                <div class="inside-box no-top">
                    <div class="col-sm-3 square-one"></div>
                    <div class="col-sm-3 square-one"></div>
                    <div class="col-sm-3 square-one"></div>
                    <div class="col-sm-3 square-one"></div>
                    <div class="col-sm-3 square-one"></div>
                </div>
            </section>
            <section class="box-one">
                <p class="green-text-md">Medium Green Text</p>
            </section>
            <section class="box-one">
                <h5  class="blue-text-sm">Icon Classes</h5>
                <br>
                <div class="inside-box">
                    <span class="i-dot"></span>
                </div>
            </section>
            <section class="box-one">
                <p class="blue-text-sm">Blue Text SM</p>
            </section>
            <section class="box-one">
                <p class="blue-text-md">Blue Text MD</p>
            </section>
            <section class="box-one">
                <a href="#" class="btn btn-default green">Green Button</a>
                <a href="#" class="btn btn-default gray">Gray Button</a>
                <a href="#" class="btn btn-default gray sm">Gray Button Small</a>
                <a href="#" class="save-btn">Save</a>
                <a class="save-btn gray md">Save</a>
                <a class="save-btn blue" href="">Blue Style Button</a>
                <a class="save-btn blue disabled" href="">Disabled Blue</a>
            </section>
            <section class="box-one">
                <p class="simple-heading">Simple Heading</p>
                <p class="simple-heading-sub">Simple Sub Heading</p>
                <p class="blk-heading-main">Main Black Heading</p>
                <p class="blk-heading-md">Medium Black Heading</p>
            </section>
            <section class="box-one">
                <div class="inside-box">
                    <a class="save-btn">Save</a>
                    <i class="fa fa-facebook media-icon"></i>
                    <i class="fa fa-pinterest-p media-icon"></i>
                    <i class="fa fa-envelope media-icon email"></i>
                </div>
            </section>
            <section class="box-one">
                <p>Links</p>
                <a href="#" class="more">More Link</a>
            </section>
            <section class="box-one blue-bg">
                <p class="white-text-md">White Text Large</p>
            </section>
            <section class="box-one">
                <div class="close-btn"></div>
            </section>
            <section class="box-one gray">
                <div class="row">
                    <div id="heading" class="col-md-12">
                        <h3 class="white-heading-one-md">White MD Heading Style Two</h3>
                    </div>
                </div>
            </section>
            <section class="box-one">
                <p class="blue-text-md">Progress Bars</p>
                <div class="inside-box">
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="70"
                             aria-valuemin="0" aria-valuemax="100" style="width:60%">
                            <span class="sr-only">60% Complete</span>
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar green" role="progressbar" aria-valuenow="70"
                             aria-valuemin="0" aria-valuemax="100" style="width:70%">
                            <span class="sr-only">70% Complete</span>
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped active green" role="progressbar"
                             aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:50%">
                            40%
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

