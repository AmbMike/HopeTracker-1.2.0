<?php include_once(CLASSES . 'Forum.php'); ?>
<?php
    $Forum = new Forum();
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Blank
            <small>User: Admin</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
            <li class="active">Blank</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div id="sort-cat">
            <?php  $categories = $Forum->get_category_list(); ?>
            <?php foreach ($categories as $category) : ?>
                <div id="<?php echo $category['category'] . '_' . $category['id'] ?>"><?php echo $category['category']; ?></div>
            <?php endforeach; ?>
        </div>


    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->