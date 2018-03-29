<?php
/**
 * File For: HopeTracker.com
 * File Name: forum.php.
 * Author: Mike Giammattei
 * Created On: 5/12/2017, 9:21 AM
 */;

$Page = new \Page_Attr\Page();
$Page->header(array(
    'Title' => 'Hope Tracker Forum',
    'Description' => 'Joint in on discussions regarding areas you may be interested in. And gain new perspective you can use in your journey. ',
    'Show Nav' => false,
    'Active Link' => 'Forums'
));
include_once(CLASSES . 'Forum.php');
include_once(CLASSES . 'class.ForumReplies.php');
include_once(CLASSES . 'class.ViewedPost.php');
$Forum = new Forum();
$User = new User();
$Session = new Sessions();
$General = new General();
$ForumReplies = new ForumReplies($Session->get('user-id'));
$ViewedPost = new ViewedPost();
?>
<div class="con main" id="forum">
    <div class="row">
        <div class="col-md-8">
            <main>
                <section class="box-one">
                    <div class="table">
                        <div class="cell">
                            <h1 class="blk-heading-main">Community Forum</h1>
                        </div>
                        <div id="total-forums" class="cell text-right">
                            <p><strong><?php echo $Forum->total_forums(); ?> Forums</strong></p>
                        </div>
                    </div>
                    <?php $count = 0; foreach ( $Forum->get_category_list() as $category) : ?>
                        <?php $category_name = preg_replace('/[^a-zA-Z0-9-_\.]/','', $category['category']); ?>
                    <div class="col-md-12">
                        <div class="panel-group" id="accordion">
                            <div class="panel">
                                <div class="panel-heading cursor-pointer blue">
                                    <div class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $category_name; ?>-categories">
                                        <div class="table">
                                            <div class="cell">
                                                <h3 class="heading"><i class="fa fa-file-text-o" aria-hidden="true"></i> <?php echo $category_name; ?></h3>
                                            </div>
                                            <div class="cell text-right">
                                                <div class="text-left pull-right">
                                                    <div class="heading category">
                                                        <div class="pull-right">
                                                            <img src="/<?php echo (User::user_info('profile_img',$category['moderator_id'])) ? : DEFAULT_PROFILE_IMG; ?>" class="profile-img cir sm">
                                                        </div>
                                                        <div class="pull-right text-right">
                                                            <span>Monitored By:</span>
                                                            <?php echo (ucfirst(User::user_info('fname', $category['moderator_id']) .' ' . User::user_info('lname', $category['moderator_id']))); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php /* Inside <?php echo $category_name; ?> accordion */ ?>
                                <div id="<?php echo $category_name; ?>-categories" class="panel-collapse collapse <?php echo ($count == 0) ? 'in' : ''; ?>">
                                    <div class="panel-body sub-cat">
                                        <?php /* Sub Categories */ ?>
                                        <?php $subcategories = $Forum->subcategory_list_by_cat_id($category['id']); ?>
                                        <?php foreach ($subcategories as $index => $subcategory) :?>
                                        <div class="panel-group" id="<?php echo $category_name; ?>-accordion-<?php echo $index; ?>">
                                            <div class="panel">
                                                <div class="panel-heading">
                                                    <div class="panel-title cursor-pointer collapsed" data-toggle="collapse" data-parent="#<?php echo $category_name; ?>-accordion-<?php echo $index; ?>" href="#<?php echo $category_name; ?>-sub-accordion-<?php echo $index; ?>">
                                                        <div class="table">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="subject-posts-group">
                                                                        <div class="cell">
                                                                            <div class="cat-heading">
                                                                                <p><?php echo $subcategory['sub_category']; ?></p>
                                                                                <span class="cub-cat-count"><?php echo ($Forum->total_sub_cat_forums($subcategory['id'])) ? : 0; ?></span>
                                                                            </div>
                                                                        </div>
                                                                        <?php $latest_sub_cat_post = $Forum->latest_post_by_sub_id($subcategory['id']); ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="feature-forum-box">
                                                                        <div class="cell">
                                                                            <?php if(!empty($latest_sub_cat_post)) : ?>
                                                                                <div class="featured-forum">
                                                                                    <div class="table">
                                                                                        <div class="cell">
                                                                                            <i data-forumSubCat="<?php echo $subcategory['id']; ?>" class="fa fa-star inline-block star <?php echo ($Forum->following_sub_cat($subcategory['id'],$Session->get('user-id'))) ? 'following' : ''; ?>" aria-hidden="true"></i>
                                                                                        </div>
                                                                                        <div class="cell">
                                                                                            <div class="links inline-block">
                                                                                                <a onclick="location.href='/user-forum/<?php echo $General->url_safe_string( $subcategory['sub_category']); ?>-<?php echo $latest_sub_cat_post['id']; ?>/<?php echo $General->url_safe_string($latest_sub_cat_post['title']); ?>'" class="title tooltip-mg" data-pt-title="<?php echo $latest_sub_cat_post['title']; ?>" data-pt-gravity="top" data-pt-animate="jello" data-pt-scheme="black" data-pt-size="small"><span class="title-label">Latest:</span> <?php echo $latest_sub_cat_post['title']; ?> </a>
                                                                                                <a onclick="location.href='/user-forum/<?php echo $General->url_safe_string( $subcategory['sub_category']); ?>-<?php echo $latest_sub_cat_post['id']; ?>/<?php echo $General->url_safe_string($latest_sub_cat_post['title']); ?>'" class="username tooltip-mg" data-pt-title="<?php echo date('F d, Y',$latest_sub_cat_post['create_date']); ?>" data-pt-gravity="top" data-pt-animate="jello" data-pt-scheme="black" data-pt-size="small"><?php echo ucfirst(User::user_info('fname',$latest_sub_cat_post['created_user_id']).' '.User::user_info('lname',$latest_sub_cat_post['created_user_id'])); ?>  | <span class="date"><?php echo date('F d, Y',$latest_sub_cat_post['create_date']); ?></span> </a>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="cell">
                                                                                            <i class="fa fa-chevron-circle-down down" aria-hidden="true"></i>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php /* Sub accordion drop content */ ?>
                                                <div id="<?php echo $category_name; ?>-sub-accordion-<?php echo $index; ?>" class="panel-collapse collapse">
                                                    <div class="panel-body sub-cat-posts">
                                                        <?php $form_posts = $Forum->get_post_for_sub_category($subcategory['id']); ?>
                                                        <?php if(count($form_posts) > 0): ?>
                                                            <table id="responsive-example-table" class="large-only responsive-example-table" cellspacing="0">
                                                                <tbody>
                                                                    <tr class="responsive-tr-first" align="left">
                                                                        <th width="50%" class="responsive-th-first"></th>
                                                                        <th width="14%">Posted By</th>
                                                                        <th width="14%">Comments</th>
                                                                        <th width="11%">Views</th>
                                                                        <th width="11%">Updated</th>
                                                                    </tr>
                                                                    <?php if(!empty($form_posts)) : ?>
                                                                    <?php foreach ($form_posts as $form_post) : ?>
                                                                    <tr class="responsive-tr-second">
                                                                        <td width="56%" class="responsive-td">
                                                                            <div class="row">
                                                                                <div class="col-xs-12 like">
                                                                                    <i data-subCatForumPost="<?php echo $form_post['id']; ?>" class="fa fa-star star <?php echo ($Forum->following_sub_cat_post($form_post['id'],$Session->get('user-id'))) ? 'following' : ''; ?>" aria-hidden="true"></i>
                                                                                    <?php $forum_title_url = $General->url_safe_string($form_post['title']) ; ?>
                                                                                    <a class="link-title" href="/user-forum/<?php echo $General->url_safe_string( $subcategory['sub_category']); ?>-<?php echo $form_post['id']; ?>/<?php echo $forum_title_url; ?>"><?php echo $form_post['title']; ?></a>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td width="11%" class="responsive-th-second"><?php echo ucwords(User::user_info('fname',$form_post['created_user_id'])) . ' ' . ucwords(User::user_info('lname',$form_post['created_user_id']))[0]; ?></td>
                                                                        <td width="11%"><?php echo $ForumReplies->getTotalPostReplies($form_post['id']); ?></td>
                                                                        <td width="11%"><?php echo $ViewedPost->countPostViews(2,$form_post['id']); ?></td>
                                                                        <td width="11%"><nobr><?php echo date("M j, Y", $form_post['create_date']); ?></nobr></td>
                                                                    </tr>
                                                                    <?php endforeach; ?>
                                                                    <?php endif; ?>
                                                                </tbody>
                                                        </table>
                                                        <?php else: ?>
                                                            <div class="box-one text-center">
                                                                <p>There are no posts for the "<?php echo $subcategory['sub_category']; ?>" subcategory at this time. </p>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="text-center save-btn-bpadd">
                                                        <button class="save-btn blue add-forum-pre-box" data-refresh-id="<?php echo $category_name; ?>-accordion-<?php echo $index; ?>" data-sub-cat-id="<?php echo $subcategory['id'];  ?>" data-toggle="modal" data-target="#add-forum-post-<?php echo $count; ?>" id="add-forum-pre-box-<?php echo $count; ?>">Add Your Post Here</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                            <div id="add-forum-post-<?php echo $count; ?>" class="modal fade modal-form" role="dialog">
                                                <div class="modal-dialog" id="forum-post-entry">
                                                    <div class="modal-content">
                                                        <div class="modal-header text-center">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Add Your Discussion</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="forum-post-form-<?php echo $count; ?>" method="post">
                                                                <div class="input-box">
                                                                    <div class="form-group">
                                                                        <input type="text" placeholder="Entry Title" id="title" class="title" name="title">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <textarea name="content" id="content" class="text-features" placeholder="Begin tying here..."></textarea>
                                                                </div>
                                                                <div class="inside-box" id="range-box">
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <hr>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <label for="anxiety">Anxiety</label>
                                                                            <input id="anxiety" type="range" min="0" max="100" value="50" />
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <label for="isolation">Isolation</label>
                                                                            <input id="isolation" type="range" min="0" max="100" value="50" />
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <label for="happiness">Happiness</label>
                                                                            <input id="happiness" type="range" min="0" max="100" value="50" />
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <select name="feeling">
                                                                                <option value="Positive">Positive</option>
                                                                                <option value="Neutral">Neutral</option>
                                                                                <option value="Negative">Negative</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer text-center">
                                                                    <input type="submit" id="submit-forum-post" <?php echo ($Session->get('logged_in') == 0) ? '  data-toggle="tooltip" title="Must be logged in."' : ''; ?> data-sub-cat-id="<?php echo $subcategory['id'];  ?>" name="submit" value="Submit" class="save-btn blue submit-forum-post <?php echo ($Session->get('logged_in') == 0) ? 'disabled' : ''; ?>" >
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $count++; ?>
                    <?php endforeach; ?>
                </section>
            </main>
        </div>
        <div class="col-md-4 sidebar-box">
            <aside>
                <?php include(SIDEBAR); ?>
            </aside>
        </div>
    </div>
</div>
