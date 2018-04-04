<?php
    include_once(CLASSES . 'Journal.php');
    include_once(CLASSES . 'class.JournalPosts.php');
    $JournalPost = new  JournalPosts();
    $Journal = new  Journal();

    $draftedPost = $JournalPost->getDraftJournal();

    if(!isset($_GET['entry_type'])){
	    $entry_title = (isset($draftedPost['title'])) ? $draftedPost['title'] : '';
    }
    $draftedContent = (isset($draftedPost['content'])) ? $draftedPost['content'] : '';
    $draftedId = (isset($draftedPost['id'])) ? $draftedPost['id'] : '';
    $draftedSavedDate = (isset($draftedPost['created_entry'])) ? $draftedPost['created_entry'] : null;
    $anxiety = (isset($draftedPost['anxiety'])) ? unserialize($draftedPost['anxiety']) : null;
    $isolation = (isset($draftedPost['isolation'])) ? unserialize($draftedPost['isolation']) : null;
    $happiness = (isset($draftedPost['happiness'])) ? unserialize($draftedPost['happiness']) : null;

?>


<section id="post-form" class="box-one">
    <div class="alert alert-success text-center col-centered" style="display: none;" id="entry-success-box">
        <h3>Your post has been created <strong>Successfully!</strong></h3>
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    </div>
    <form <?php echo ($draftedId != '') ? 'data-post-draft-id="'.$draftedId.'"' : ''; ?> id="journal-entry" method="post">
        <div id="title-entries" class="title-container">
            <div class="input-box">
                <input type="text" placeholder="Entry Title" <?php echo (isset($_GET['entry_type'])) ? 'disabled' : ''; ?> value="<?php echo $entry_title; ?>" id="title" class="title" name="title">
            </div>
            <div class="entry-count-box">
                <span class="count-num"><?php echo $Journal->total_journal_post($Sessions->get('user-id')); ?></span> Entries
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="icon-date-box">
            <i class="fa fa-calendar-o" aria-hidden="true"></i>
            <span class="date"><?php echo date('D. n/j/Y'); ?></span>
        </div>
        <div class="textarea-box">
            <textarea data-autoresize class="text-features active" name="entry_content" placeholder="<?php echo $placeholder_content; ?>"><?php echo $draftedContent; ?></textarea>
        </div>
        <div class="inside-box" id="range-box">
            <div class="row">
                <div class="col-sm-12 no-p">
                    <hr>
                </div>
                <div class="col-sm-3">
                    <label for="anxiety">Anxiety</label>
                    <?php if($anxiety == null): ?>
                    <input class="range" id="anxiety" type="range" min="0" max="100" />
                    <?php else: ?>
                    <input class="range" id="anxiety" type="range" min="0" max="100" value="<?php echo $anxiety['value']; ?>" style="background-size: <?php echo $anxiety['size']; ?>;" />
                    <?php endif; ?>
                </div>
                <div class="col-sm-3">
                    <label for="isolation">Isolation</label>
	                <?php if($isolation == null): ?>
                    <input class="range" id="isolation" type="range" min="0" max="100" value="50" />
	                <?php else: ?>
                    <input class="range" id="isolation" type="range" min="0" max="100" value="<?php echo $isolation['value']; ?>" style="background-size: <?php echo $isolation['size'];?>"  />
	                <?php endif; ?>
                </div>
                <div class="col-sm-3">
                    <label for="happiness">Happiness</label>
	                <?php if($happiness == null): ?>
                    <input class="range" id="happiness" type="range" min="0" max="100" value="50" />
	                <?php else: ?>
                    <input class="range" id="happiness" type="range" min="0" max="100" value="<?php echo $happiness['value']; ?>" style="background-size: <?php echo $happiness['size'];?>" />
	                <?php endif; ?>

                </div>
                <div class="col-sm-3 drop-status-col">

                    <div class="clearfix"></div>
                    <div class="save-btn-box">
                        <i class="fa fa-check" aria-hidden="true"></i>
                        <input type="submit" name="submit" value="Publish" class="save-btn blue">
                    </div>

                   <!-- <select name="feeling">
                        <option value="Positive">Positive</option>
                        <option value="Neutral">Neutral</option>
                        <option value="Negative">Negative</option>
                    </select>-->
                </div>
            </div>
        </div>
            <?php if($draftedId != '') : ?>
        <div class="updater-box" style="display: block">
            <span data-draft-post="updater" class="updater">Draft saved <time itemprop="dateCreated" class="human-time date" datetime="<?php echo date("j F Y H:i",$draftedSavedDate); ?>"></time></span>
	        <?php else: ?>
            <div class="updater-box">
                <span data-draft-post="updater" class="updater"></span>
            <?php endif; ?>
        </div>
    </form>
</section>