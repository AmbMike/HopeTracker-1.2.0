<?php
/**
 * File For: HopeTracker.com
 * File Name: inspiration-all.php.
 * Author: Mike Giammattei
 * Created On: 7/26/2017, 5:12 PM
 */;
?>
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/config/constants.php');
include_once (CLASSES. 'Inspiration.php');

$Session = new Sessions();
$Inspiration = new Inspiration();

$inspiration_slides = $Inspiration->get_quote_images();

foreach ($inspiration_slides as $inspiration_slide) :
    ?>
    <div class="box-one-content">
        <img data-img-id="<?php echo $inspiration_slide['id']; ?>" src="<?php echo IMAGES; ?>quotes/<?php echo $inspiration_slide['img_path']; ?>" alt="<?php echo $inspiration_slide['category']; ?>" class="lazy" >
        <div class="table gray-accent-box">
            <div class="cell">
                <span class="pagingInfo pull-left accent-text"></span>
            </div>
            <div class="cell text-right">
                <div class="share-box-slider">
                    <span class="share-text">Share</span>
                    <a class="share-icon" data-img-id="<?php echo $inspiration_slide['id']; ?>" data-shared-to="facebook" onclick="window.open(this.href,'targetWindow', 'toolbar=no, location=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=525, height=436'); return false;" href="http://www.facebook.com/sharer.php?u=<?php echo BASE_URL; ?>/inspiration/?og_img=<?php echo IMAGES; ?>quotes/<?php echo $inspiration_slide['img_path'];?>" target="_blank" style="color: #3b5998;" title="" data-toggle="tooltip" data-placement="top" data-original-title="Share on Facebook">
                        <i class="fa fa-facebook media-icon"></i>
                    </a>
                    <a class="share-icon" data-img-id="<?php echo $inspiration_slide['id']; ?>" data-shared-to="pinterest" onclick="window.open(this.href,'targetWindow', 'toolbar=no, location=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=525, height=436'); return false;" href="https://pinterest.com/pin/create/button/?url=<?php echo BASE_URL; ?>/inspiration/?og_img=<?php echo IMAGES; ?>quotes/<?php echo $inspiration_slide['img_path'];?>&media=<?php echo BASE_URL; ?><?php echo IMAGES; ?>quotes/<?php echo $inspiration_slide['img_path'];?>" target="_blank" style="color: #3b5998;" title="" data-toggle="tooltip" data-placement="top" data-original-title="Share on Pinterest">
                        <i class="fa fa-pinterest-p media-icon"></i>
                    </a>
                    <a class="share-icon" data-img-id="<?php echo $inspiration_slide['id']; ?>" data-shared-to="twitter" onclick="window.open(this.href,'targetWindow', 'toolbar=no, location=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=525, height=436'); return false;" href="https://twitter.com/home?status=<?php echo BASE_URL; ?>/inspiration/?og_img=<?php echo IMAGES; ?>quotes/<?php echo $inspiration_slide['img_path'];?>" target="_blank" style="color: #3b5998;" title="" data-toggle="tooltip" data-placement="top" data-original-title="Share on Twitter">
                        <i class="fa fa-twitter media-icon email"></i>
                    </a>

                    <div class="white-box">
                        <span id="save-count"><?php echo $Inspiration->saved_plus_shares($inspiration_slide['id']); ?></span>
                    </div>
                    <?php if($Inspiration->saved($inspiration_slide['id'],$Session->get('user-id')) != true): ?>
                        <button data-img-id="<?php echo $inspiration_slide['id'] ?>" class="<?php echo ($Session->get('logged_in') == 0) ? 'tooltip-mg' : '';?> save-btn gray md blue-color" <?php echo ($Session->get('logged_in') == 0) ? 'data-pt-title="You must be logged in to use this feature" data-pt-gravity="top" data-pt-animate="jello" data-pt-scheme="black" data-pt-size="small" ' : ''; ?> data-btn="save-inspiration">Save</button>
                    <?php else: ?>
                        <i data-img-id="<?php echo $inspiration_slide['id'] ?>" data-btn="save-inspiration" class="fa fa-star blue-color" aria-hidden="true"></i>
                    <?php endif; ?>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
<?php endforeach; ?>
