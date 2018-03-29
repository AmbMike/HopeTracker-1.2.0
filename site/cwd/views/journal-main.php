<?php
/**
 * File For: HopeTracker.com
 * File Name: journal-main.php.
 * Author: Mike Giammattei
 * Created On: 8/3/2017, 9:33 AM
 */;
?>
<?php /* This needs to be on EVERY page */ ?>
<?php
$Page = new \Page_Attr\Page();
$Page->header(array(
    'Title' => 'This is the main journal page',
    'Description' => 'This is the description for the page',
    'Active Link' => 'Journal'
));
?>
<?php /* End of block */ ?>

<div id="journal-main">
    <div class="media">
        <img class="d-flex mr-3" src="..." alt="Generic placeholder image">
        <div class="media-body">
            <h5 class="mt-0">Media heading</h5>
            Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
        </div>
    </div>
</div>

