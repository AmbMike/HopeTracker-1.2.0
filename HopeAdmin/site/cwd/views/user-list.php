<?php
/**
 * File For: HopeTracker.com
 * File Name: user-list.php.
 * Author: Mike Giammattei
 * Created On: 7/11/2017, 3:14 PM
 */;
 ?>
<?php
$Admin = new Admin();
$User = new User();
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            User List
            <small> current</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Level</a></li>
            <li class="active">User List</li>
        </ol>
    </section>

    <!-- Main content -->
    <section id="index-content" class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Master List</h3>

                <div class="box-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tbody><tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created Date</th>
                        <th>Moderator</th>
                        <th>IP</th>
                    </tr>
                    <?php $users = $Admin->all_users(); ?>
                    <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['fname'] . ' ' . $user['lname']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo date("m-d-Y", $user['created_on']); ?> </td>
                        <td><?php echo ($Admin->is_moderator($user['id']) == true) ? '<span class="label label-primary">Moderator</span>': ''; ?>
                        </td>
                        <td><?php echo $user['ip']; ?></td>
                    </tr>
                    <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </section>
    <!-- /.content -->
</div>