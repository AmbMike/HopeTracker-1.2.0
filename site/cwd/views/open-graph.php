<?php
/**
 * File For: HopeTracker.com
 * File Name: open-graph.php.
 * Author: Mike Giammattei
 * Created On: 7/25/2017, 8:25 PM
 */;
?>

<?php

$Page = new \Page_Attr\Page();
$Page->header(array(
    'Title' => 'Inspiration | HopeTracker',
    'Description' => 'Get inspired everyday with great quotes found everyday. ',
    'Active Link' => 'Inspiration',
    'OG Image' => $_GET['og_img'],
    'OG URL' => 'inspiration',
));

?>
<img src="<?php echo $_GET['og_img']; ?>" style="width: 400px; height: auto; display: block; margin: auto;" alt="HopeTracker">

