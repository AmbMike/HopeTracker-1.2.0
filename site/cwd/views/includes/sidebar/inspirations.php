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
include_once(CLASSES . 'class.DailyQuote.php');
require_once(CLASSES . 'class.DailySelfHelp.php');

$InspirationSlide = new InspirationSlide();
$General = new General();
$Inspiration = new Inspiration();
?>
<?php

$DailyQuote = new DailyQuote();
$DailySelfHelp = new DailySelfHelp();

?>
<section class="box-one sidebar right-sidebar id="sidebar">
    <div class="inside-box no-p xs-padding">
        <div class="row" id="inspiration-box">
            <div class="col-sm-12">
                <p class="simple-heading inspiration-title">Daily Inspiration</p>
                <div class="img-quote">
                    <a class="wrap" href="/<?php echo RELATIVE_PATH; ?>addiction-quotes/<?php echo $DailyQuote->imageDirectory; ?>/<?php echo $DailyQuote->currentImgPath; ?>"> <img src="<?php echo IMAGES . $DailyQuote->imageDirectory . '/'. $DailyQuote->currentImgPath; ?>" alt="Inspirational Quote" class="img-responsive"></a>
                </div>
                <?php /*
                <div class="img-self-help">
                    <a class="wrap" href="/<?php echo RELATIVE_PATH; ?>addiction-quotes/self-help/<?php echo $DailySelfHelp->currentImgPath; ?>"><img src="<?php echo IMAGES . 'self-help/'. $DailySelfHelp->currentImgPath; ?>" class="img-responsive"></a>
                </div>
                    */ ?>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</section>



