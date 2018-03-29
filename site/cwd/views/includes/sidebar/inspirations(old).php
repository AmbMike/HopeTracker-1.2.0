<?php
/**
 * File For: HopeTracker.com
 * File Name: inspirations.php.
 * Author: Mike Giammattei
 * Created On: 3/17/2017, 10:19 AM
 */
?>
<?php
include_once(CLASSES . 'class.InspirationSlide.php');
include_once(CLASSES . 'Inspiration.php');
$InspirationSlide = new InspirationSlide();
$General = new General();
$Inspiration = new Inspiration();

?>
<?php

require_once(CLASSES . 'class.DailyQuote.php');

$DailyQuote = new DailyQuote();

?>
<section class="box-one sidebar right-sidebar id="sidebar">
    <div class="inside-box no-p xs-padding">
        <div class="row" id="inspiration-box">
            <div class="col-sm-12">
                <p class="simple-heading inspiration-title">Daily Inspiration</p>
                <div class="invite-box">
                    <a href="/inspiration/" class="btn btn-default green block no-p">View More</a>
                </div>
                <div class="slider">
                    <?php foreach ($InspirationSlide->getNewestSlides() as $slide) : ?>
                        <img data-quote-id="<?php echo $slide['id']; ?>" data-quote- src="<?php echo QUOTE_SLIDES . $slide['img_path'];  ?>" alt="<?php echo ucfirst($General->file_name_to_string($slide['img_path'])); ?>">
                    <?php endforeach; ?>
                </div>
                <div id="share-box" class="share-box">
                    <ul class="scale-box-first">
                        <li>
                            <i class="fa fa-angle-double-left quotes-prev" aria-hidden="true"></i>
                        </li>
                        <li>
                            <i class="fa fa-angle-double-right quotes-next" aria-hidden="true"></i>
                        </li>
                    </ul>
                    <ul class="scale-box-second">
                        <li>
                            <a class="save-btn" data-btn="save-inspiration-sidebar" id="sidebar-save"  data-img-id="<?php echo $slide['id']; ?>">Save</a>
                        </li>
                        <li>
                            <a class="share-icon facebook" data-img-id="<?php echo $slide['id']; ?>" data-shared-to="facebook" onclick="window.open(this.href,'targetWindow', 'toolbar=no, location=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=525, height=436'); return false;" href="http://www.facebook.com/sharer.php?u=<?php echo BASE_URL; ?>/inspiration/?og_img=<?php echo IMAGES; ?>quotes/<?php echo $slide['img_path'];?>" target="_blank" style="color: #3b5998;" title="" data-toggle="tooltip" data-placement="top" data-original-title="Share on Facebook">
                                <i class="fa fa-facebook media-icon"></i>
                            </a>
                        </li>
                        <li>
                            <a class="share-icon pintrest" data-img-id="<?php echo $slide['id']; ?>" data-shared-to="pinterest" onclick="window.open(this.href,'targetWindow', 'toolbar=no, location=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=525, height=436'); return false;" href="https://pinterest.com/pin/create/button/?url=<?php echo BASE_URL; ?>/inspiration/?og_img=<?php echo IMAGES; ?>quotes/<?php echo $slide['img_path'];?>&media=<?php echo BASE_URL; ?><?php echo IMAGES; ?>quotes/<?php echo $slide['img_path'];?>" target="_blank" style="color: #3b5998;" title="" data-toggle="tooltip" data-placement="top" data-original-title="Share on Pinterest">
                                <i class="fa fa-pinterest-p media-icon"></i>
                            </a>
                        </li>
                        <li>
                            <i class="fa fa-envelope media-icon blue email"></i>
                        </li>
                        <li>
                            <div class="clearfix">
                                <div class="white-box"><span class="save-count">15</span></div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</section>



