<?php
/**
 * File For: HopeTracker.com
 * File Name: header.php.
 * Author: Mike Giammattei
 * Created On: 3/10/2017, 12:25 PM
 */

?>
<?php if( $show_header != 'No') : ?>
<header>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-sm-1">
            </div>
            <div class="col-md-6 col-sm-6">
               <a href="<?php echo HOME_URL; ?>"><img src="<?php echo IMAGES; ?>main/hopetracker-logo.png" class="img-responsive logo" alt="HopeTracker.com"/></a>
                <div class="project-text">
                    <span><a href="https://www.ambrosiatc.com/" target="blank"><img src="<?php echo IMAGES; ?>main/amb-bird-icon-2016.png" class="img-responsive project"> An Ambrosia Project &rsaquo;</a></span>
                </div>
            </div>
            <div class="col-md-3 col-sm-5">
                <div class="box hidden-xs">
                    <p class="green-text-md">Ready to talk treatment?</p>
                    <a href="tel:<?php echo MAIN_PHONE ?>" class="phone-style"><?php echo \Page_Attr\Format::phone(MAIN_PHONE) ?></a>
                </div>
            </div>
        </div>
    </div>
    <div class="mobile-nav-box">
        <div class="menu-btn">
            <div class="nav-btn-box">
                <div class="nav-btn"></div>
                <div class="nav-btn1"></div>
                <div class="nav-btn2"></div>
            </div>
        </div>
        <div class="phone-btn">
            <a  href="tel:<?php echo MAIN_PHONE ?>"><i class="fa fa-phone" aria-hidden="true"></i></a>
        </div>
    </div>
    <div class="nav-box">
        <nav>
            <?php Parts::nav($show_nav, $active_link); ?>
        </nav>
    </div>
</header>
<?php endif; ?>
<div class="wrapper <?php echo ($no_min_height == true) ? ' no-min-height' : ''; ?>">
    <?php if(isset($_SESSION['logged_in'])){
        echo ($_SESSION['logged_in'] == 1) ? '<div id="user-logger" class="hide"></div>' : '';
    }  ?>
