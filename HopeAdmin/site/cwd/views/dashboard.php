<?php
/**
 * File For: HopeTracker.com
 * File Name: dashboard.php.
 * Author: Mike Giammattei
 * Created On: 5/17/2017, 3:42 PM
 */;
?>
<?php
$Admin = new Admin();
$User = new User();

?>
<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="ion ion-ios-people"></i></span>

            <a href="/<?php echo  RELATIVE_PATH; ?>/admin/user-list"><div class="info-box-content">
                    <span class="info-box-text">Total Users</span>
                    <span class="info-box-number"><?php echo $Admin->total_users(); ?></span>
                </div>
            </a>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion ion-android-cloud-done"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Users Online</span>
                <span class="info-box-number"><?php echo $Admin->total_users_online(); ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-bookmark"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Forum Categories</span>
                <span class="info-box-number"><?php echo $Admin->total_forum_categories(); ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>

    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>

    <div class="col-md-3 col-sm-6 col-xs-12">

    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">

    </div>
    <!-- /.col -->
</div>


