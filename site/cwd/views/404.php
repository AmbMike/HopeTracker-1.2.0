<?php
/**
 * File For: HopeTracker.com
 * File Name: journal.php.
 * Author: Mike Giammattei
 * Created On: 4/18/2017, 1:17 PM
 */;
?>
<?php
$Page = new \Page_Attr\Page();
$Page->header(array(
    'Title' => 'Page Not Found | 404',
    'Description' => '',
));
?>
<?php
include_once(CLASSES .'/Journal.php');
$journal = new Journal();
?>
<div class="con main" id="course">
    <div class="row">
        <div class="col-sm-8">
            <main>
                <section class="box-one ">
                    <h1 class="green-heading-lg sub">Page Not Found</h1>
                    <p class="blue-text-sm sub">The page you are looking for does not exist on our website.</p>
                </section>
            </main>
        </div>
        <div class="col-sm-4 sidebar-box">
            <aside>
                <?php include(SIDEBAR); ?>
            </aside>
        </div>
    </div>
</div>

