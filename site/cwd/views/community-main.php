<?php
/**
 * File For: HopeTracker.com
 * File Name: community-main.php.
 * Author: Mike Giammattei
 * Created On: 7/25/2019
 */;


$User = new User();
$General = new General();
$Page = new \Page_Attr\Page();
$Admin = new Admin();

$Page->header(array(
    'Title' => 'Families of Drug Addicts | HopeTracker',
    'Description' => 'Follow real-time stories of parent, spouses, grandparents or siblings going through the emotions of addiction. A community of support and understanding.',
    'OG Image'  => OG_IMAGES  . 'community-pg.jpg',
    'OG Title'  => 'Families of Drug Addicts',
    'Active Link' => 'Community'
));

?>

<div class="con main" data-questions-parent="true">
    <div class="row">
        <div class="col-md-8" id="community-main">
            <main>
                <div class="header-box">
                    <span class="h1-addon"><data value="<?php echo $Admin->total_users(); ?> " class="total-members"><?php echo $Admin->total_users(); ?></data> Members</span>
                    <h1 class="green-heading-lg top">Your Not Alone</h1>
                </div>
                <div class="i-post-single-v2">
                    <section id="c-single-forum">
                        <div class="panel panel-default" id="i-main-question-panel">
                            <div class="panel-heading">
                                <div class="s-table">
                                    <div class="s-cell">
                                        <span class="s-title">Forum Question</span>
                                    </div>
                                    <div class="s-cell text-right">
                                   <span class="s-notification -i-new-comments">
                                                                             <data value="0">2</data>
                                       <span class="s-mobile" "=""> <i class="fa fa-comment"></i></span>
                                        <span class="s-desktop">Comment </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div id="main-question">
                                    <div class="s-table i-author">
                                        <div class="s-cell i-profile-img">
                                            <div class="s-profile-img" style="background-image: url('/hopetracker/users/user-1/profile.jpg?cache=603');">
                                            </div>
                                        </div>
                                        <div class="s-cell">
                                            <span class="s-username">MikesG1</span>
                                            <span class="s-who">A Dad From FL</span>
                                        </div>
                                    </div>
                                    <div class="i-question">
                                        <div class="alert alert-info i-admin-tools" style="margin-top: 10px;">
                                            <strong>Editor's Options:</strong>
                                            <a style="margin: 0;" href="/hopetracker/admin/post-editor/?post_id=137&amp;post_type=3">Edit Question</a>
                                        </div>                                    <h1 class="i-header">Testing the end of the  update when it goes away?</h1>
                                        <div class="s-description">
                                            This is a description of the new update what do you think? I don't know it's just happening?                                    </div>
                                    </div>
                                </div>
                                <div id="single-forum-answers">

                                    <div class="s-table i-replier">
                                        <div class="s-cell i-input-container">
                                            <div class="s-table i-input-section">
                                                <div class="s-cell i-user">
                                                    <div class="s-profile-img" id="logged-in-user-id" style="background-image: url('/hopetracker/users/user-1/profile.jpg?cache=498');">
                                                    </div>
                                                </div>
                                                <div class="s-cell i-input">

                                                    <form data-logged-in-username="MikesG1" id="forum-answer-question-form-1" data-question-id="137">
                                                        <textarea id="answer-trigger" rows="1" name="answer-msg" placeholder="Share your advice, experience or support." spellcheck="false"></textarea>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="s-cell i-action text-right">
                                            <button data-bound-follow-post="btn" data-follow-type="relate" data-post-user-id="1" data-post-id="137" data-post-type="3" class="like-box liked"><div class="s-cir-i"><i class="fa fa-heart"></i></div> <span class="divider">|</span> <span class="relate-text">Relate</span> <span class="-i-total-questions-relates">1</span></button>
                                        </div>
                                    </div>

                                    <div class="s-table i-replies-container"><div class="s-table i-replies">
                                            <div class="s-cell i-replier-level-2 s-v-top">
                                                <div class="s-user-profile" style="background-image: url(http://hopetracker.com/hopetracker/users/user-1/profile.jpg?cache=498);">
                                                </div>
                                            </div>
                                            <div class="s-cell i-msg">
                                                <div class="s-content">
                                                    <span class="s-username">MikesG1</span> What do you think?
                                                </div>
                                            </div>
                                        </div><div class="s-table i-replies">
                                            <div class="s-cell i-replier-level-2 s-v-top">
                                                <div class="s-user-profile" style="background-image: url(http://hopetracker.com/hopetracker/users/user-1/profile.jpg?cache=498);">
                                                </div>
                                            </div>
                                            <div class="s-cell i-msg">
                                                <div class="s-content">
                                                    <span class="s-username">MikesG1</span> This is some advice
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

        </main>
    </div>
    <div class="col-md-4 sidebar-box">
        <aside>
			<?php include(SIDEBAR);?>
        </aside>
    </div>
</div>
</div>