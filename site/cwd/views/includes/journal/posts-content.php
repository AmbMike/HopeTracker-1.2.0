<?php
/**
 * File For: HopeTracker.com
 * File Name: journal.php.
 * Author: Mike Giammattei Paul Giammattei
 * Created On: 4/18/2017, 1:17 PM
 */;
?>
<?php
    include_once(CLASSES  . 'class.JournalPosts.php');
    $JournalPost = new JournalPosts();

    /** Get the page post user id if either the user is logged in or the user Id is in the URL */
    if(isset($_GET['user_id'])){
	    $postUserId = $_GET['user_id'];
    }else if($Sessions->get('logged_in') == 1 && !isset($_GET['user_id'])){
	    $postUserId = $Sessions->get( 'user-id' );
    }else{
        $postUserId = false;
    }
?>
<?php if(count($JournalPost->getLatestPosts(3,$postUserId)) > 0): ?>
<section id="journal-posts" class="box-one">
    <div class="posts-title-box">
        <img src="/site/public/images/main/icon.jpg" class="img-circle profile-img">
        <span class="posts-title">Journal Posts</span>
    </div>
    <hr>
    <div id="post-load-out">
        <div id="post-load-in">
	        <?php foreach ( $JournalPost->getLatestPosts(3,$postUserId) as $latest_post ) : ?>
                <div class="post-content">
                    <div id="post-author-text" class="text_exposed_root">
                        <div class="quote-box"><?php echo $latest_post['title']; ?></div>
                        <div class="more-box">
					        <?php $content = strip_tags($latest_post['content']) ?>
					        <?php if(strlen($content) < 150) : ?>
                            <?php echo $content; ?> <button data-moreText="more" role="button" class="btn btn-primary sm">View more</button>
					        <?php else: ?>
                            <?php echo rtrim(substr($content, 0, 150)); ?><span class="remover"></span> <span class="dots">...</span> <button role="button" class="btn btn-primary sm" data-moreText="more">View more</button>
					        <?php endif; ?>
                            <span class="more-text">
                                <?php echo rtrim(substr($content, 150, 1000000)); ?>
                                <hr>
                                <div class="row">
                                    <div class="col-xs-4">
                                        <?php $a_arr = unserialize($latest_post['anxiety']); ?>
                                        <label for="anxiety">Anxiety</label>
                                        <input id="anxiety" class="range" disabled type="range" min="0" max="100" value="<?php echo $a_arr['value']; ?>" />
                                    </div>
                                    <div class="col-xs-4">
                                        <?php $a_arr = unserialize($latest_post['isolation']); ?>
                                        <label for="isolation">Isolation</label>
                                        <input id="isolation" class="range" disabled type="range" min="0" max="100" value="<?php echo $a_arr['value']; ?>" />
                                    </div>
                                    <div class="col-xs-4">
                                        <?php $a_arr = unserialize($latest_post['happiness']); ?>
                                        <label for="happiness">Happiness</label>
                                        <input id="happiness" class="range" disabled type="range" min="0" max="100" value="<?php echo $a_arr['value']; ?>" />
                                    </div>
                                </div>
                                <br>
                                <span class="btn btn-primary sm" data-moreText="less">Show less</span>
                            </span>
                        </div>
                    </div>
                    <div class="tracker-box">
                        <div class="like-box">
                            <span class="like">Like</span>
                        </div>
                        <span class="comment-box">
                            <span class="dot"><i class="fa fa-circle" aria-hidden="true"></i></span>
                            <span class="comment">Comment</span>
                        </span>
                        <span class="comment-count-box">
                            <span class="dot"><i class="fa fa-circle" aria-hidden="true"></i></span>
                            <i class="fa fa-comment-o" aria-hidden="true"></i><span class="comment-count">12</span>
                        </span>
                        <div class="liked-count-box">
                            <span class="dot"><i class="fa fa-circle" aria-hidden="true"></i></span>
                                <?php if($Journal->check_if_liked('journal_likes',$latest_post['id']) == true): ?>
                                <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                <?php else: ?>
                                <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                                <?php endif; ?>
                                <data class="liked-count"><?php echo $Journal->total_journal_post_likes($latest_post['id']); ?></data>
                        </div>
                        <span class="date-time-box">
                            <span class="dot"><i class="fa fa-circle" aria-hidden="true"></i></span>
                            <time itemprop="dateCreated" class="human-time" datetime="<?php echo date("j F Y H:i",$latest_post['created_entry']) ?>"><?php echo date("j F Y H:i",$latest_post['created_entry']) ?></time>
                        </span>
                    </div>
                </div>
                <hr>
	        <?php endforeach; ?>
        </div>
    </div>

</section>
<?php endif; ?>