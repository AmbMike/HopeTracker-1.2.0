<?php
/**
 * File For: HopeTracker.com
 * File Name: add-category.php.
 * Author: Mike Giammattei
 * Created On: 5/18/2017, 12:23 PM
 */;
?>
<?php
    $Admin = new Admin();
?>
<section class="content-header">
    <h1>
        Forum
        <small>Categories</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Category</li>
    </ol>
</section>

<!-- Main content -->
<section id="index-content" class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Category</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form id="add-categories" method="post" role="form">
                    <div class="box-body">
                        <div class="alert alert-success" style="display: none;">
                            <button type="button" class="close" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-check"></i> Add Successfully!</h4>
                            Your new category has been added to the database and is visible for users on the forum.
                        </div>
                        <div class="input-group">
                            <label for="category">Category Name</label>
                            <input type="text" class="form-control" id="category" name="category" placeholder="Enter Category">
                        </div>
                        <br>
                        <div class="input-group">
                            <label for="moderator">Mediator</label>
                            <select class="form-control select2 select2-hidden-accessible" name="moderator" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <?php foreach ($Admin->all_users() as $all_user) : ?>
                                    <option value="<?php echo ucfirst($all_user['id']); ?>"><?php echo ucfirst($all_user['fname']); ?> <?php echo ucfirst($all_user['lname']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" id="add-categories-btn" class="btn btn-primary">Add Category</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header ui-sortable-handle" style="cursor: move;">
                    <i class="ion ion-clipboard"></i>
                    <h3 class="box-title">Drag or Delete</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="alert alert-success" style="display: none;">
                        <button type="button" class="close" aria-hidden="true">×</button>
                        <p><i class="icon fa fa-check"></i> Sorted Successfully!</p>
                    </div>
                    <ul id="sort-cat" class="todo-list ui-sortable">
                        <?php  $categories = $Forum->get_category_list(); ?>
                        <?php foreach ($categories as $category) : ?>
                            <li id="<?php echo $category['category'] . '_' . $category['id'] ?>" class="">
                                <!-- drag handle -->
                                <span class="handle ui-sortable-handle">
                                <i class="fa fa-ellipsis-v"></i>
                                <i class="fa fa-ellipsis-v"></i>
                              </span>
                                <span class="text"><span class="category-name"><?php echo $category['category']; ?></span></span>
                                <span class="text">|</span>
                                <span class="text">Moderated By: <span class="moderator-name"><?php echo ucfirst(User::user_info('fname', $category['moderator_id'])); ?> <?php echo ucfirst(User::user_info('lname', $category['moderator_id'])); ?></span></span>
                                <div class="tools">
                                    <i data-category-name="<?php echo $category['category']; ?>" data-category-id="<?php echo $category['id']; ?>" class="fa  fa-edit edit-cat"></i>
                                    <i data-category-name="<?php echo $category['category']; ?>" data-category-id="<?php echo $category['id']; ?>" class="fa fa-trash-o delete-cat"></i>
                                </div>
                                <br>
                               <form class="form-horizontal edit-category">
                                   <div class="row">
                                       <div class="col-md-4">
                                           <div class="input-group">
                                               <label for="category">Category</label>
                                               <input name="category" class="form-control" value="<?php echo $category['category']; ?>">
                                           </div>
                                       </div>
                                       <div class="col-md-8">
                                           <div class="input-group">
                                               <label>Mediator</label>
                                               <select class="form-control select2 select2-hidden-accessible" name="moderator" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                                  <?php foreach ($Admin->all_users() as $all_user) : ?>
                                                      <option value="<?php echo ucfirst($all_user['id']); ?>"><?php echo ucfirst($all_user['fname']); ?> <?php echo ucfirst($all_user['lname']); ?></option>
                                                  <?php endforeach; ?>
                                               </select>
                                           </div>
                                       </div>
                                       <div class="col-md-12">
                                           <input class="btn btn-primary save-sub-cat-edit" data-cat-id="<?php echo $category['id']; ?>" value="Save Changes">
                                       </div>
                                   </div>
                               </form>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix no-border">
                    <button type="button" class="btn pull-left btn-primary" id="save-category-position">Save Position</button>
                </div>
            </div>
        </div>
    </div>
</section>
