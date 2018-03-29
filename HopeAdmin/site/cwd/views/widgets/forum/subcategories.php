<?php
/**
 * File For: HopeTracker.com
 * File Name: subcategories.php.
 * Author: Mike Giammattei
 * Created On: 5/22/2017, 11:01 AM
 */;
?>
<?php
    $Forum = new Forum();
?>
<section class="content-header">
    <h1>
        Forum
        <small>Subcategory</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Subcategory</li>
    </ol>
</section>

<!-- Main content -->
<section id="index-content" class="content">
    <div class="row">
        <div class="col-md-6" id="add-subcategories-con">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Subcategory</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form id="add-subcategories" method="post" role="form">
                    <div class="box-body">
                        <div class="alert alert-success" style="display: none;">
                            <button type="button" class="close" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-check"></i> Added Successfully!</h4>
                            Your new Subcategory has been added to the database and is visible for users on the forum.
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="subcategories">Subcategory Name</label>
                                    <input name="subcategories" type="text" id="subcategories" class="form-control"  placeholder="Enter Subcategory">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Categories</label>
                                    <select name="category" class="form-control select2" multiple="multiple" data-placeholder="Select a Category" style="width: 100%;">
                                        <?php foreach ($Forum->get_category_list() as $category) : ?>
                                            <option value="<?php echo $category['id']; ?>"><?php echo $category['category']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="box box-warning"  style="display: none;" id="info-box-container">
                            <div class="box-header with-border">
                                <h3 class="box-title">Update Report</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool close-subcat-report"><i class="fa fa-times"></i></button>
                                </div>
                                <!-- /.box-tools -->
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="info-box bg-green" id="add-success">
                                    <span class="info-box-icon"><i class="ion ion-android-checkbox-outline"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Added!</span>
                                        <span class="info-box-number" id="count-success"></span>

                                        <span id="text" class="progress-description">

                                        </span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <div class="info-box bg-red" id="add-failed">
                                    <span class="info-box-icon"><i class="ion ion-android-close"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Failed</span>
                                        <span class="info-box-number" id="count-failed"></span>

                                        <span id="text" class="progress-description">

                                        </span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <button type="submit" id="add-subcategories-btn" class="btn btn-primary">Add Subcategory</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Subcategory</h3>
                </div>
                <div class="box-body" id="subcategory-list">
                    <div class="alert alert-success" style="display: none;">
                        <button type="button" class="close" aria-hidden="true">×</button>
                        <p><i class="icon fa fa-check"></i> Updated Successfully!</p>
                    </div>
                    <?php $count = 1; foreach ($Forum->get_category_list() as $category) : ?>
                        <div id="updater-<?php echo $count; ?>" class="box box-default collapsed-box box-solid updater">
                            <div class="box-header with-border">
                                <h3 class="box-title"><?php echo $category['category']; ?></h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                    </button>
                                </div>
                                <!-- /.box-tools -->
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body" id="refresher-<?php echo $count; ?>" style="display: none;">
                                <ul id="sort-sub-cat" class="todo-list ui-sortable">
                                    <?php  $sub_categories = $Forum->subcategory_list_by_cat_id($category['id']); ?>
                                    <?php if(!empty($sub_categories)) : ?>
                                        <?php foreach($sub_categories as $sub_category) : ?>
                                        <li id="<?php echo $sub_category['sub_category'] . '_' . $sub_category['id']; ?>" class="">
                                            <!-- drag handle
                                            <span class="handle ui-sortable-handle">
                                                <i class="fa fa-ellipsis-v"></i>
                                                <i class="fa fa-ellipsis-v"></i>
                                              </span> -->
                                            <span class="text"><?php echo urldecode($sub_category['sub_category']); ?></span>
                                            <div class="tools">
                                                <i data-category-name="<?php echo $sub_category['sub_category']; ?>" data-category-id="<?php echo $sub_category['id']; ?>" class="fa fa-trash-o delete-sub-cat"></i>
                                            </div>
                                        </li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p>There are no subcategories for the "<?php echo $category['category']; ?>" category at this time. </p>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <?php $count++; ?>
                    <?php endforeach; ?>
                </div>

            </div>
        </div>
    </div>
</section>
