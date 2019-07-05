<?php
/**
 * File For: HopeTracker.com
 * File Name: forum.php.
 * Author: Mike Giammattei
 * Created On: 5/18/2017, 12:37 PM
 */;
?>
<?php include_once(CLASSES . 'class.Post.php'); ?>
<?php
    define('ABSPATH', $_SERVER['DOCUMENT_ROOT']);
    define('VIEWS', ABSPATH.'/'.'HopeAdmin/site/public/views/');

    $Post = new Post();

    $post_id = $_GET['post_id'];
    $post_type = $_GET['post_type'];

    $thePost = $Post->get($post_type, $post_id,true);

?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Post
            <small>Editor</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class="active">Post</li>
        </ol>
    </section>

    <!-- Main content -->
    <section id="index-content" class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title" >Editor -  <u><small class="text-primary" onclick="location.href='/hopetracker/forum/<?php echo $thePost['pageIdentifier'] ?>'" role="button">View Question Live</small></u></h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form id="admin-post-editor" data-post-id="<?php echo $thePost['id']; ?>" data-post-type="<?php echo $thePost['post_type']; ?>" onsubmit="return edit_forum_post(event);" method="post" role="form">
                        <div class="box-body">
                            <div class="alert alert-success" style="display: none;">
                                <button type="button" class="close" aria-hidden="true">×</button>
                                <h4><i class="icon fa fa-check"></i> Saved Successfully!</h4>
                                Your changes have been updated and are now visible on the live site.
                            </div>
                            <div class="input-group">
                                <label for="question">Post Question</label><br>
                                <textarea rows="3" class="form-control" id="question" name="question"><?php echo $thePost['question']; ?></textarea>
                            </div>
                            <br>
                            <div class="input-group">
                                <label for="description">Post Description</label><br>
                                <textarea rows="5" class="form-control" id="description" name="description"><?php echo $thePost['description']; ?></textarea>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" id="save-post-change" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

