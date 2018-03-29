<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/hopetracker/config/constants.php');
include_once(CLASSES . 'class.Inspirations.php');

$Inspirations = new Inspirations();

    /** Get image controllers */
    if(isset($_GET['imgFilter'])):
	    $filter = $_GET['imgFilter'];
    else:
	    $filter = false;
    endif;
?>

<?php foreach ($Inspirations->getInspirations($filter) as $index => $inspiration) : ?>
	<!-- --><?php /*if($index < 3):  */?>
	<img data-like-count="<?php echo $inspiration['likeCount']; ?>" data-liked-status="<?php echo ($inspiration['liked'] == 1) ? 'liked' : 'no'; ?>" src="<?php echo IMAGES . $inspiration['imagePath']; ?>" class="img-responsive">
	<!-- <?php /*else: */?>
            <img data-liked-status="<?php /*echo ($inspiration['liked'] == 1) ? 'liked' : 'no'; */?>" data-img-src="/site/public/images/<?php /*echo $inspiration['imagePath']; */?>" class="img-responsive">
        --><?php /*endif; */?>
<?php endforeach; ?>

