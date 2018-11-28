<?php
/**
 * File For: HopeTracker.com
 * File Name: user-list.php.
 * Author: Mike Giammattei
 * Created On: 7/11/2017, 3:14 PM
 */;
 ?>
<?php
include_once(CLASSES . 'class.FlagPost.php');
include_once(CLASSES . 'class.PostsType.php');
include_once(CLASSES . 'class.Post.php');
$Admin = new Admin();
$User = new User();
$FlaggedQuestions = new FlagPost();
$PostType = new PostType();
$Post = new Post();
$General = new General();
?>
<style>
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
        vertical-align: middle;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">

        <h1>
            Flagged
            <small> Posts</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Security</a></li>
            <li class="active">Flagged Post</li>
        </ol>
    </section>

    <!-- Main content -->
    <section id="index-content" class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Post Table</h3>

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
            <div class="box-body table-responsive no-padding" >
                <div class="box-body" style="display: none;" id="flagged-action-success">

                </div>
                <table class="table table-hover">
                    <tbody><tr>
                        <th>#</th>
                        <th>Action</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Post Type</th>
                        <th>Post</th>
                        <th>Created Date</th>
                        <th>Flagers IP</th>
                    </tr>
                    <?php $users = $Admin->all_users();
                    //Debug::data($FlaggedQuestions->getFlaggedPosts()); ?>
                    <?php foreach ($FlaggedQuestions->getFlaggedPosts() as $index => $flaggedPost) : ?>
                    <tr>
                        <td><?php echo $index; ?></td>
                        <td><button type="button" data-delete-flag-id="<?php echo $flaggedPost['id']; ?>" data-delete-flag-post-type="<?php echo $flaggedPost['post_type']; ?>" data-delete-flag-post-id="<?php echo $flaggedPost['flagged_post_id']; ?>" class="btn btn-block btn-warning btn-xs flagged-action-btn" style="width: 50px;">Delete</button></td>
                        <td><?php echo $User::Username($flaggedPost['flaggers_id']); ?></td>
                        <td><?php echo $User::full_name($flaggedPost['flaggers_id']); ?></td>
                        <td><?php echo ucfirst($PostType->getPostType($flaggedPost['post_type'])); ?></td>
                        <td style="width:400px;">
                            <div class="box box-widget collapsed-box" style="max-width:400px; box-shadow:none; margin-bottom: 0;">
                                <div class="box-header ">
                                    <?php $postData = $Post->get($flaggedPost['post_type'],$flaggedPost['flagged_post_id']); ?>
                                    <p style="margin-bottom: 0;">
                                        <?php if(strlen($postData) > 40):
                                           echo substr($postData, 0, 40) . '...';
                                        else:
                                            echo $postData;
                                        endif; ?>
                                    </p>
                                    <?php if(strlen($postData) > 40): ?>
                                        <div class="box-tools">
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="box-body"  style="display: none;">
                                    <?php if(strlen($postData) > 40):
                                        echo substr($postData, 0);
                                    endif; ?>
                                </div>
                            </div>
                        </td>
                        <td><?php echo date("m-d-Y", $flaggedPost['date_flagged']); ?> </td>
                        <td><?php echo $flaggedPost['flaggers_ip']; ?></td>
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