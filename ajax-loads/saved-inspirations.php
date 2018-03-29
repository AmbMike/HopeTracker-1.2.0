<?php
/**
 * File For: HopeTracker.com
 * File Name: saved-inspirations.php.
 * Author: Mike Giammattei
 * Created On: 7/26/2017, 5:58 PM
 */;
?>
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/config/constants.php');
include_once(CLASSES.'Sessions.php');
include_once (CLASSES. 'Inspiration.php');

$Session = new Sessions();
$Inspiration = new Inspiration();

switch ($_GET['page_val']):
    case 'random' :
        $inspiration_slides = $Inspiration->get_quote_general($Session->get('user-id'),true);
        break;
    case 'most_shared' :
        $inspiration_slides = $Inspiration->most_viewed_img();
        $inspiration_slides = call_user_func_array('array_merge', $inspiration_slides);
        break;
    case 'saved' :
        $inspiration_slides = $Inspiration->get_quote_general($Session->get('user-id'));
        if(count($inspiration_slides) > 0){
            $inspiration_slides = call_user_func_array('array_merge', $inspiration_slides);
        }else{
            $not_saved_inspirations = true;
        }
    break;
endswitch;

if($not_saved_inspirations == true): ?>
<div class="alert alert-warning text-center" id="no-inspiration-images">
    <h3>No Images Saved at this time</h3>
</div>

<?php else:
foreach ($inspiration_slides as $inspiration_slide) : ?>
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
                        <button data-img-id="<?php echo $inspiration_slide['id'] ?>" class="<?php echo ($Session->get('logged_in') == 0) ? 'tooltip-mg' : '';?> save-btn gray md blue-color" <?php echo ($Session->get('logged_in') == 0) ? 'title="Must be logged in to save this image"' : '';?> data-btn="save-inspiration">Save</button>
                    <?php else: ?>
                        <i data-img-id="<?php echo $inspiration_slide['id'] ?>" data-btn="save-inspiration" class="fa fa-star blue-color" aria-hidden="true"></i>
                    <?php endif; ?>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
<?php endforeach; ?>

<?php endif; ?>

