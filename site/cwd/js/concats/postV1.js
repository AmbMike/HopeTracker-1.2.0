/*
 * Copyright (c) 2018.
 */

processPostV1Comments();
function processPostV1Comments() {
    'use strict';
    var elParent = '[data-postV1="parent"]';
    var commentInput = ' [data-postV1="comment-input"]';
    var commentInputText = '[data-postV1="comment-input-text"]';

    $('body').on('keyup',elParent + commentInput,function(e){
        if(e.which === 13) {
            var $this = $(this);
            var inputText = $this.val();

            var commentInput = $this.closest('.comment-input');
            var commentReplies = commentInput.parent().find('.comment-replies');

            /** The id of the journal that the user is commenting on. */
            var commentJournalId = $this.data('comment-journal-id');

            var jsonData = {
                form : 'Journal Entry Comment',
                type : 'Journal Comment',
                comment : inputText,
                journal_id : commentJournalId

            };

            $.post(RELATIVE_PATH + '/config/processing.php',jsonData,function (response) {

                if(response.status === 'Success'){
                    /** Add the newly posted comment to the list of comments on  the page. */
                    commentReplies.append(buildComment(response.userId,response.username,response['username-url-safe'],inputText,response.state,response.zip,response.time,response.post_id));
                    $('time.human-time').timeago();
                    /** Clear the input after the user's comment was processed. */
                    $this.val('');
                }else{
                    $this.val('');
                }

            },'json');
        }
    });
    function buildComment(postUserId,postUsername,urlUsername,inputText,state,zip,entryTime,postId) {
        var html = '<ul class="post-reply">\n' +
            '<hr>\n' +
            '<li class="reply-user-img">\n' +
            ' <a class="wrap" href="' + RELATIVE_PATH + '/families-of-drug-addicts/user-' + postUserId + '/' + urlUsername + '"><img src="' + RELATIVE_PATH + '/users/user-' + postUserId + '/profile.jpg" class="img-circle profile-img sm"></a>\n' +
            '</li>\n' +
            '<li>\n' +
            '    <div class="reply-user-name">\n' +
            '         <a class="wrap simple-heading " href="' + RELATIVE_PATH + '/families-of-drug-addicts/user-' + postUserId + '/' + urlUsername + '">' + postUsername + '</a> ' + inputText  + '<div class="reply-user-info-box">\n' +
            '         <time itemprop="dateCreated" class="human-time date" datetime="'+ entryTime +'" title="'+ entryTime +'">'+ entryTime +'</time> <i class="fa fa-circle" aria-hidden="true"></i> <span class="author-local"> '+ state + ' ' + zip  +' </span>\n' +
            '         <span class="like-btn"><span role="button" data-post-btn="like comment" data-bound-post-like="btn" data-post-user-id="' + postUserId + '" data-post-id="' + postId + '" data-post-type="5">Like </span> <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> </span>\n' +
            '     </div>\n' +
            '    </div>\n' +
            ' </li>\n' +
            ' </ul>';
        return html;
    }

    /** Scroll pagination for post */
    if($('#related-post').length > 0){

        var container = '#journal-postV1';
        var postFeeder = '#post-feeder';
        var ajaxData = {};
        var postIds;


        /** Value to start the post query from */
        var startPost = $(container).data('post-start');


        /** Switch for post with or without filters. */
        var hasFilters = false;


        /** Switch for if the scroll for more post is in effect */
        var inAction = false;

        if($('[data-no-lazy-load-posts]').length !== 1){
            /** Get more post when the user scrolls to the bottom of the posts */
            $(window).scroll(function(){

                /** Check if the posts have filters */
                if ($(container).attr('data-post-user-ids')) {
                    hasFilters = true;

                    var postUserIds  = $(container).attr('data-post-user-ids');

                }
                /** Check if the user has scrolled to the bottom of the post */
                if($(postFeeder).isOnScreen() === true && inAction === false){
                    if(hasFilters === true){
                        ajaxData = {
                            ajaxPost : 'more posts',
                            data  : {
                                type : 'filter scroll',
                                postUserIds : postUserIds,
                                startPost : $(container).attr('data-post-start')

                            },
                            cache: false
                        };
                    }else{
                        ajaxData = {
                            ajaxPost : 'more posts',
                            data  : {
                                type : 'no filter scroll',
                                startPost : $(container).attr('data-post-start'),
                            },
                            cache: false
                        };
                    }


                    if(inAction === false && !$('[data-stop-post-query]').length  > 0) {
                        inAction = true;
                        $.get(RELATIVE_PATH + '/site/cwd/views/includes/journal/postsV1.php',ajaxData,function (response) {

                            if(response !== ''){
                                $('#related-post').append(response);

                                /** Increment post per call count */
                                    // startPost = startPost + 3;

                                var updateCount = $(container).attr('data-post-start');
                                updateCount = parseInt(updateCount) + 3;
                                $(container).attr('data-post-start', updateCount);

                                $(container).attr('data-post-start');

                                moreText();

                                setTimeout(function () {
                                    inAction = false;
                                }, 1000);

                            }
                            // $('#related-post').html(response);


                        });
                    }
                }
            });
        }


    }


    $.fn.isOnScreen = function(){

        var win = $(window);

        var viewport = {
            top : win.scrollTop(),
            left : win.scrollLeft()
        };
        viewport.right = viewport.left + win.width();
        viewport.bottom = viewport.top + win.height();

        var bounds = this.offset();
        bounds.right = bounds.left + this.outerWidth();
        bounds.bottom = bounds.top + this.outerHeight();

        return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));

    };
}

