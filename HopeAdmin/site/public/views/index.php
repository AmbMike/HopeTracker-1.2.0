<?php
/**
 * File For: HopeTracker.com
 * File Name: index.php.
 * Author: Mike Giammattei
 * Created On: 5/17/2017, 3:42 PM
 */;
 ?> <?php
    $Admin = new Admin();
    $User = new User();
?><div class="content-wrapper"><section class="content-header"><h1>Dashboard <small>admin user</small></h1><ol class="breadcrumb"><li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li><li class="active">Dashboard</li></ol></section><section id="index-content" class="content"> <?php include_once (VIEWS . 'dashboard.php'); ?></section></div>