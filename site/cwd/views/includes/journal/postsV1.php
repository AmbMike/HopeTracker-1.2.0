<?php
/**
 * Copyright (c) 2018.
 */

    /** Includes */
    include_once($_SERVER['DOCUMENT_ROOT'].'/hopetracker/config/constants.php');
    include_once( CLASSES . 'class.JournalPosts.php' );
    include_once( CLASSES . 'User.php' );
    include_once( CLASSES . 'Sessions.php' );
    include_once( CLASSES . 'General.php' );
    include_once( CLASSES . 'Journal.php' );
    include_once( CLASSES . 'class.LikePost.php' );
    include_once( ARRAYS . 'states.php' );
    include_once(CLASSES . 'class.JournalPostFilter.php');
    include_once( CLASSES . 'class.UserProfile.php' );

    $UserProfile = new UserProfile();
    $JournalPostsFilter = new JournalPostFilter();
    $User = new User();
    /** Initialize Classes */
    $Sessions = new Sessions();
    $JournalPosts = new JournalPosts();
    $General = new General();
    $Journal = new Journal();

    /** Variables  */
    $logged_in = false;

    /** If user is logged in. */
    if($Sessions->get('logged_in') == 1 && !isset($_GET['userId'])):
	    $user_id = $Sessions->get( 'user-id' );
	    $logged_in = true;
    elseif(isset($_GET['userId'])):
	    $user_id = $_GET['userId'];
    endif;

    /** Number of post to show. Variable over to the include below*/
    $totalPostToShow = 3;

    /** Total post for query if no filters are set */
    $posts_qty = $totalPostToShow;

    /** Total post for query if filters are set */
    $data['endPost'] = $totalPostToShow;

    /** Set for incoming ajax calls */
    $post_out_array = array();
    if(!isset($_GET['ajaxPost'])){

        /* If the GET journal id is in the url, then get just the one journal.  Else get all the journals per normal */
        if(isset($_GET['journal_id'])):
	        $post_out_array =  $JournalPosts->getSinglePost($_GET['journal_id']);

        else:
	        $post_out_array  = $JournalPosts->getLatestPosts($posts_qty);
        endif;
    }else if($_GET['ajaxPost'] == 'by name'){


        /** Searched users name */
	    $data['name'] = $_GET['name'];

	    /** Total posts to show */
	    $ajaxData['startPost'] = $totalPostToShow;

	    /** @var Get the post like users name */
        $posts_array = $JournalPostsFilter->getPosts($data);
        $post_out_array = $posts_array['posts'];


    }else if($_GET['ajaxPost'] == 'by filters'){
        $ajaxData = $_GET['data'] ;

	    /** Total posts to show */
	    $ajaxData['startPost'] = 0;

	    $posts_array = $JournalPostsFilter->getPosts($ajaxData);
	    $post_out_array = $posts_array['posts'];

    }
    else if($_GET['ajaxPost'] == 'order by'){

	    /** Total posts to show */
	    $ajaxData['startPost'] = $totalPostToShow;
        $ajaxData = $_GET['data'] ;

	    $posts_array = $JournalPostsFilter->getPosts($ajaxData);
	    $post_out_array = $posts_array['posts'];
    }
    else if($_GET['ajaxPost'] == 'more posts'){
	    /** Total posts to show */
	    $ajaxData['startPost'] = (int)$_GET['startPost'];
	    $ajaxData['endPost'] = (int)$totalPostToShow;
	    $ajaxData = $_GET['data'] ;
	    $posts_array = $JournalPostsFilter->getPosts($ajaxData);
	    $post_out_array = $posts_array['posts'];
    }


    /** show users  journals if on on users journal/profile. */
    if(isset($usersJournal) == true){
	    $post_out_array  = $JournalPosts->getLatestPosts($posts_qty, $user_id);
	    $posts_array['posts_user_ids'] = $user_id;
    }

    ?>
<div <?php echo (isset($posts_array['posts_user_ids'])) ? 'data-post-user-ids="'.$posts_array['posts_user_ids'].'"' : '' ?> id="journal-postV1" data-post-start="0" data-postV1="parent">
    <?php /** Loop through most recent journal posts !IMPORTANT - the variables below come in from the file that's including this file */ ?>
    <?php if(count($post_out_array) > 0): ?>
	    <?php
            /** Set the index taking the ajax posts when called */
            if(!isset($posts_array['scrolled_posts'])){
	            $index = 0;
            }else{
	            $index = $posts_array['scrolled_posts'];
            }
        ?>
	    <?php

        foreach ($post_out_array  as $latest_post) :
        ?>
        <?php $latest_post = (isset($_GET['journal_id'])) ? $post_out_array  : $latest_post; ?>
        <section <?php echo (isset($_GET['journal_id'])) ? 'data-no-lazy-load-posts ' : ''; ?>  data-post-parent="post" class="box-one no-p">
            <ul class="post">
                <!--<li class="user-ellipsis">
                    <div>
                        <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                    </div>
                </li>-->
                <li>
                    <a class="wrap" <?php echo  $UserProfile->profile($latest_post['user_id']); ?>><img src="/<?php echo $User->get_user_profile_img(false, $latest_post['user_id']); ?>" class="img-circle profile-img sm"></a>
                </li>
                <li>
                    <div class="simple-heading user-name">
                        <a class="wrap" <?php echo  $UserProfile->profile($latest_post['user_id']); ?>> <?php echo User::Username($latest_post['user_id']); ?></a>
                        <div class="author-info-box">
                            <time itemprop="dateCreated" class="human-time date" datetime="<?php echo date("j F Y H:i",$latest_post['created_entry']) ?>"><?php echo date("j F Y H:i",$latest_post['created_entry']) ?> </time> <i class="fa fa-circle" aria-hidden="true"></i><span class="author-local"> <?php echo $state_list[strtoupper(user::user_info('state',$latest_post['user_id']))]; ?>, <?php echo user::user_info('zip',$latest_post['user_id']); ?> </span>
                        </div>
                    </div>
                </li>
                <div id="user-edit-dropdown" class="dropdown pull-right margin-sides">
                    <button class="btn btn-white dropdown-toggle <?php echo ($Session->get('logged_in') == 0) ? 'tooltip-mg gray' : ''; ?>" <?php echo ($Session->get('logged_in') == 0) ? 'data-pt-title="Login to enable this functionality" data-pt-gravity="top" data-pt-animate="jello" data-pt-scheme="black" data-pt-size="small" disabled' : ''; ?> type="button" data-toggle="dropdown">
                        <span id="edit-label"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></span>
                    </button>
                    <ul id="edit-box" class="dropdown-menu">
                        <li data-filter-value="newest">
                            <a class="cursor-pointer first" ><i class="fa fa-pencil" aria-hidden="true"></i>edit</a>
                        </li>
                        <li data-filter-value="liked">
                            <a class="cursor-pointer second"><i class="fa fa-trash" aria-hidden="true"></i>delete</a>
                        </li>
                    </ul>
                </div>
                <li class="comment-content">
                    <?php echo ($latest_post['title']) ? '<h5>' . $latest_post['title'] . '</h5>' : ''; ?>
                    <div class="text-content">
                        <?php if($latest_post['anxiety'] != null): ?>
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
                                <div id="postV1-ranges">
                                     <div class="row">
                                        <div class="col-xs-4">
                                            <?php $a_arr = unserialize($latest_post['anxiety']); ?>
                                            <label for="anxiety">Anxiety</label>
                                            <input id="anxiety" class="range" style="background-size:<?php echo $a_arr['size']; ?>" disabled type="range" min="0" max="100" value="<?php echo $a_arr['value']; ?>" />
                                        </div>
                                        <div class="col-xs-4">
                                            <?php $a_arr = unserialize($latest_post['isolation']); ?>
                                            <label for="isolation">Isolation</label>
                                            <input id="isolation" class="range" style="background-size:<?php echo $a_arr['size']; ?>" disabled type="range" min="0" max="100" value="<?php echo $a_arr['value']; ?>" />
                                        </div>
                                        <div class="col-xs-4">
                                            <?php $a_arr = unserialize($latest_post['happiness']); ?>
                                            <label for="happiness">Happiness</label>
                                            <input id="happiness" class="range" disabled type="range" min="0" max="100" style="background-size:<?php echo $a_arr['size']; ?>" value="<?php echo $a_arr['value']; ?>" />
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <span class="btn btn-primary sm" data-moreText="less">Show less</span>
                            </span>
                        </div>
                        <?php else: ?>
	                        <?php echo $latest_post['content'];  ?>
                        <?php endif; ?>
                    </div>
                </li>
                <hr>
                <?php $LikePosts = new LikePost($latest_post['id'],'2',$latest_post['user_id']); ?>
                <?php if($LikePosts->checkLikedQuestion() == true): ?>
                    <li>
                        <span class="like-box"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <span role="button" data-bound-post-like="btn" data-post-user-id="<?php echo $latest_post['user_id'];  ?>" data-post-id="<?php echo $latest_post['id'];  ?>" data-post-type="2">Liked </span>
                           <?php /* Remove comment when backend is complete
                            <i class="fa fa-circle dot"aria-hidden="true"></i>
                            <div class="question-liked-box">
                                <i class="fa fa-thumbs-up"></i>
                                <span class="question-liked-text">23</span>
                            </div>
                            */ ?>
                        </span>
                    </li>
                <?php else: ?>
                    <li>
                        <span class="like-box">
                            <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> <span role="button" data-bound-post-like="btn" data-post-user-id="<?php echo $latest_post['user_id'];  ?>" data-post-id="<?php echo $latest_post['id'];  ?>" data-post-type="2">Like </span><i class="fa fa-circle dot"aria-hidden="true"></i>
                            <?php /* Remove comment when backend is complete
                            <div class="question-liked-box">
                                <i class="fa fa-thumbs-up"></i>
                                <span class="question-liked-text">23</span>
                            </div>
                            */ ?>
                        </span>
                    </li>
                <?php endif; ?>
                <li data-toggle="collapse" role="button" data-target="#post-commentV1-<?php echo $index; ?>"><span class="comment-box"><i class="fa fa-comments-o" aria-hidden="true"></i> Comment</span></li>
                <span class="flag-box" data-question="flag-btn" role="button" >
                        <span class="flag-tooltip-text">
                                Click here to report this post as inappropriate.
                            <a class="alt-flag">
                                flag
                            </a>
                        </span>
                        <i class="fa fa-flag" aria-hidden="true"></i>
                    </span>
                <?php /* Remove comment when backend is complete.
                    <span class="flag-box error-text tooltip-mg" data-question="flag-btn" data-pt-title="Flag being processed" data-pt-gravity="top" data-pt-animate="jello" data-pt-scheme="black" data-pt-size="small"><i class="fa fa-flag" aria-hidden="true"></i></span>
                <?php // End if if user has not flagged the post. */ ?>
            </ul>
            <?php /* Post Reply Box - collapse */ ?>
            <div  id="post-commentV1-<?php echo $index; ?>" class="reply-box <?php echo (!isset($_GET['journal_id'])) ? 'collapse' : ' in'; ?> ">
                <div class="reply-liked-box">
                    <i class="fa fa-heart" aria-hidden="true"></i>
                    <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                    <span id="post-like-count-<?php echo $index; ?>" data-post="like journal" class="liked-count"><?php echo $LikePosts->getTotalLikes(); ?></span>
                </div>
                <div class="clearfix"></div>
                <div class="comment-replies">
                    <?php /* Loop through comments for the post */ ?>
                    <?php foreach ($Journal->get_journal_comments($latest_post['id'],false,false,5) as $comment): ?>
                        <ul class="post-reply">
                            <hr>
                            <li class="reply-user-img">
                                <a class="wrap" href="/families-of-drug-addicts/user-<?php echo $comment['user_id'];  ?>/<?php echo User::Username($comment['user_id']); ?>"><img src="/<?php echo $User->get_user_profile_img(false, $comment['user_id']); ?>" class="img-circle profile-img sm"></a>
                            </li>
                            <li>
                                <div class="reply-user-name">
                                    <a class="wrap simple-heading " href="<?php echo $user_profile_path; ?>"> <?php echo User::user_info('username',$post_user_id); ?></a> <?php echo $comment['comment']; ?>
                                    <div class="reply-user-info-box">
                                        <time itemprop="dateCreated"  class="human-time date" datetime="<?php echo date("j F Y H:i",$comment['created_on']) ?>"><?php echo date("j F Y H:i",$comment['created_on']) ?></time> <i class="fa fa-circle" aria-hidden="true"></i><span class="author-local"> <?php echo $state_list[strtoupper(user::user_info('state',$comment['user_id']))]; ?></span>
                                        <?php /* Check if the logged in user liked the post already*/ ?>
                                        <?php if($logged_in == true): ?>
                                            <?php $LikeComment = new LikePost($comment['id'],'5',$comment['user_id']); ?>
                                            <?php if($LikeComment->checkLikedQuestion() == true): ?>
                                                <span class="like-btn"><span role="button" data-post-btn="like comment" data-bound-post-like="btn" data-post-user-id="<?php echo $comment['user_id'];  ?>" data-post-id="<?php echo $comment['id'];  ?>" data-post-type="5">Liked</span> <i class="fa fa-thumbs-up" aria-hidden="true"></i> </span>
                                            <?php else: ?>
                                                <span class="like-btn liked"><span data-post-btn="like comment" role="button" data-bound-post-like="btn" data-post-user-id="<?php echo $comment['user_id'];  ?>" data-post-id="<?php echo $comment['id'];  ?>" data-post-type="5">Like</span> <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> </span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    <?php endforeach; ?>
                </div>
                <div class="comment-input">
                    <div class="table">
                        <div class="cell image-cell">
                            <div class="user-img">
                                <a class="wrap" <?php echo  $UserProfile->profile($user_id); ?>> <img src="/<?php echo $User->get_user_profile_img( false, $user_id); ?>" class="img-circle profile-img sm"></a>
                            </div>
                        </div>
                        <div class="cell">
                            <div class="input-box">
                                <div class="textarea-box">
                                    <textarea data-comment-journal-id="<?php echo $latest_post['id']; ?>"  rows="1" data-autoresize data-postV1="comment-input" class="text-features active" name="entry_content" placeholder="Begin typing here..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
		    <?php $index++ ?>
		    <?php if(isset($_GET['journal_id'])){
		      break;
            } ?>
        <?php endforeach; ?>
    <?php elseif (!isset($posts_array['endPosts'])): ?>

    <?php if(isset($_GET['userId'])): ?>
            <div class="box-one no-search-found">
                <h3>This user has not posted a Journal yet. </h3>

            </div>
    <?php else: ?>
            <div class="box-one no-search-found">
                <h3>No one in the community (yet) matches your search. If you were searching a name, check the spelling. Otherwise, try again limiting to just one filter option — see examples below.</h3>
                <ul><li>Search for "Long-Term Recovery" to get inspired. </li>
                    <li>Enter your Zip to find people near you to meet offline. </li>
                    <li>Search for "A Better Place," if you're also grieving. </li>
                    <li>Search for "Early Addiction" to offer support. </li>
                    <li>Search for "Son" <i>and</i> "Daughter" to find others with addicted parents. </li>
                </ul>
            </div>
    <?php endif; ?>

    <?php elseif (isset($posts_array['endPosts'])): ?>
        <span data-stop-post-query=""></span>
    <?php endif; ?>
</div>
