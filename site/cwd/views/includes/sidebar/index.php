<?php
/**
 * File For: HopeTracker.com
 * File Name: sidebar.php.
 * Author: Mike Giammattei
 * Created On: 3/16/2017, 4:57 PM
 */
?>

<?php include_once(CLASSES.'Sessions.php');$Session = new Sessions(); ?>
<?php include(SIDEBAR_PATH . 'sidebar-live-now.php') ?>
<?php if($hide_side_inspiration != true) :
  include(SIDEBAR_PATH . 'inspirations.php');
endif; ?>
<?php include(SIDEBAR_PATH . 'latest-entry.php'); ?>



