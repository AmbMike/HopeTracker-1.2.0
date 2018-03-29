<?php
/**
 * File For: HopeTracker.com
 * File Name: forum.php.
 * Author: Mike Giammattei
 * Created On: 5/18/2017, 12:37 PM
 */;
?>
<?php include_once(CLASSES . 'Forum.php'); ?>
<?php
    define('ABSPATH', $_SERVER['DOCUMENT_ROOT']);
    define('VIEWS', ABSPATH.'/'.'HopeAdmin/site/public/views/');
    define('WIDGETS', VIEWS . 'widgets');

$Forum = new Forum();
?>
<div class="content-wrapper">
    <?php
    if(isset($_GET['widget_page'])){
        include_once(WIDGETS .'/forum/' . $_GET['widget_page'] .'.php');
    }
    ?>
</div>

