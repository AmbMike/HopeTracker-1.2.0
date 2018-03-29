<?php
/**
 * File For: HopeTracker.com
 * File Name: inspiration.php.
 * Author: Mike Giammattei
 * Created On: 7/20/2017, 10:51 AM
 */
?>

<?php
/**
 * File For: HopeTracker.com
 * File Name: journal.php.
 * Author: Mike Giammattei
 * Created On: 4/18/2017, 1:17 PM
 */;
?>
<?php
include_once(CLASSES .'/Debug.php');
include_once(CLASSES .'/General.php');
include_once(CLASSES .'/Inspiration.php');
include_once(CLASSES .'/Sessions.php');


$user = new User();
$General = new General();
$Inspiration = new Inspiration();
$Session = new Sessions();

$Page = new \Page_Attr\Page();
$Page->header(array(
    'Title' => 'Addiction Quotes for Families | HopeTracker',
    'Description' => 'Worry won\'t cure anyone of addiction. You deserve happiness! As hard as it seems, take time each day to focus on yourself and the positive things in life.',
    'Active Link' => 'Inspiration',
    'OG Image' => $_GET['og_img'],
    'OG URL' => 'inspiration/?og_img='.$_GET['og_img']
));
$hide_side_inspiration = true;
?>
<div class="con main" id="inspiration">
    <div class="row">
        <div class="col-md-8">
            <main>
                <section class="box-one">
                    <div class="inside-box inspire-box">
                        <div class="clearfix"></div>
                        <div class="table">
                            <div class="cell">
                                <h1 class="simple-heading">Quick Inspirations</h1>
                            </div>
                            <div class="cell table-ft-group">
                                <div class="dropdown pull-right margin-sides">
                                    <button class="btn btn-white dropdown-toggle <?php echo ($Session->get('logged_in') == 0) ? 'tooltip-mg gray' : ''; ?>" <?php echo ($Session->get('logged_in') == 0) ? 'data-pt-title="Login to enable this functionality" data-pt-gravity="top" data-pt-animate="jello" data-pt-scheme="black" data-pt-size="small" disabled' : ''; ?> type="button" data-toggle="dropdown"><span id="filter-label">Latest</span>
                                         <span class="caret"></span></button>
                                    <ul id="inspiration-filter" class="dropdown-menu">
                                        <li><a class="cursor-pointer">Saved</a></li>
                                        <li><a class="cursor-pointer" >Random</a></li>
                                        <li><a class="cursor-pointer" >Most Shared</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <h2 class="simple-heading-sub">Self-Care Tips</h2>
                        <p>Too often, our thoughts obsess over our loved one, leaving no time for ourselves. But, you deserve happiness. Worrying has never cured anyone of addiction. As hard as it seems, take time each day to focus on yourself and the positive things in your life. As you practice these simple, quick coping tools, apply the ones that work best for you to your life any time you feel stressed.</p>

                        <div class="slider-box" id="inspiration-page-box">
                            <div class="col-lg-8 col-lg-offset-2 col-sm-10 col-sm-offset-1">
                                <div class="slider-outer">
                                    <i class="fa fa-refresh fa-spin fa-3x fa-fw loading"></i>
                                    <div class="slider">
                                       <?php include_once(ABSOLUTE_PATH_NO_END_SLASH. '/ajax-loads/inspiration-all.php'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                    </div>
                </section>
            </main>
        </div>
        <div class="col-md-4 sidebar-box">
            <aside>
                <?php include(SIDEBAR); ?>
            </aside>
        </div>
    </div>
</div>

