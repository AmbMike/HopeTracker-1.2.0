<?php
/**
 * File For: HopeTracker.com
 * File Name: sidebar.php.
 * Author: Mike Giammattei
 * Created On: 5/17/2017, 4:40 PM
 */;
?>

<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/<?php echo  RELATIVE_PATH; ?>/<?php echo (User::user_info('profile_img')) ? : DEFAULT_PROFILE_IMG; ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo ucfirst(User::user_info('fname')); ?> <?php echo ucfirst(User::user_info('lname')); ?></p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="treeview"><a href="/admin"><i class="fa fa-cogs"></i> Dashboard</a></li>
            <li class="treeview"><a href="/<?php echo  RELATIVE_PATH; ?>admin/user-list"><i class="ion ion-person-stalker"></i>Users</a></li>
            <!-- Optionally, you can add icons to the links
            <li class="active"><a href="#"><i class="fa fa-link"></i> <span>Link</span></a></li>-->
            <li class="treeview">
                <a href="#"><i class="fa fa-link"></i> <span>Forum</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/<?php echo  RELATIVE_PATH; ?>admin/forum/categories">Categories</a></li>
                    <li><a href="/<?php echo  RELATIVE_PATH; ?>admin/forum/subcategories">Subcategories</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class="fa fa-link"></i> <span>Security</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/<?php echo  RELATIVE_PATH; ?>admin/flagged">Flagged Posts</a></li>
                </ul>
            </li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
