/*
 * Copyright (c) 2017.
 */

/** NOTE : Some methods are dependent on function is the forum-v2.js */

$(document).ready(function () {
    'use strict';

    flag_single_forum_question();

    flag_single_forum_answer();

    like_post_bound();

    single_forum_pagination();

    answer_filters();

    follow_post_bound();
});

function flag_single_forum_question() {
    'use strict';

    var pageParent = '[data-questions-parent="true"]';
    var answerParent = pageParent + ' [data-question-body]';
    var flagBtn = answerParent + ' [data-question="flag-btn"]';

    $('body').on('click',flagBtn,function () {

        var $thisFlagBtn = $(this);

        /** The question id associated with the like btn */
        var questionId = $thisFlagBtn.closest('[data-question-body]').data('question-id');

        /** Id for the question */
        var postTypeId = $thisFlagBtn.closest('[data-question-body]').data('post-type-id');


        var ajaxObject = {
            form : 'Flag Post',
            post_id : questionId,
            post_type : postTypeId
        };
        /** Process the like btn */

        $.post(RELATIVE_PATH + '/config/processing.php',ajaxObject,function (response) {
            console.log(response);
            if( response.status === 'flagged'){
                $thisFlagBtn.addClass('error-text').html('Flagged');
            }
        },'json');
    });
}
function flag_single_forum_answer() {
    'use strict';

    var pageParent = '[data-questions-parent="true"]';
    var answerParent = pageParent + ' [data-answers="container"]';
    var flagBtn = answerParent + ' [data-question="flag-btn"]';

    $('body').on('click',flagBtn,function () {

        var $thisFlagBtn = $(this);

        /** The question id associated with the like btn */
        var answerId = $thisFlagBtn.closest('[data-answers="container"]').data('answer-id');

        /** Id for the question */
        var postTypeId = $thisFlagBtn.closest('[data-answers="container"]').data('answer-post-type');

        var ajaxObject = {
            form : 'Flag Post',
            post_id : answerId,
            post_type : postTypeId
        };
        /** Process the like btn */

        $.post(RELATIVE_PATH + '/config/processing.php',ajaxObject,function (response) {
            console.log(response);
            if( response.status === 'flagged'){
                $thisFlagBtn.addClass('error-text').html('Flagged');
            }
        },'json');
    });
}
function like_post_bound() {
    'use strict';
    var likeBtn = '[data-bound-post-like="btn"]';

    $('body').on('click',likeBtn,function () {

        var $thisLikeBtn = $(this);

        /** Id for the post being liked.  */
        var postId = $thisLikeBtn.data('post-id');

        /** The post type id for the liked post */
        var postType = $thisLikeBtn.data('post-type');

        /** The user's Id who owns the question. */
        var postUserId = $thisLikeBtn.data('post-user-id');


        var ajaxObject = {
            form : 'Like Post',
            post_id : postId,
            post_type : postType,
            post_user_id : postUserId
        };
        /** Process the like btn */

        $.post(RELATIVE_PATH + '/config/processing.php',ajaxObject,function (response) {
            console.log(response);
            /** Bind a constant count value for output */
            var countBinderEl = $thisLikeBtn.parent().find('[data-like-post-count-updater]');
            var countBinder = countBinderEl.val();
            var newCountValue;


            if( response.status === 'unliked'){

                $thisLikeBtn.removeClass('liked');
                $thisLikeBtn.text('Like');

                /** Update constant count value for output */
                if(countBinder){
                    countBinder--;
                    countBinderEl.val(countBinder);
                    countBinderEl.text(countBinder);
                }

            }else if(response.status === 'liked'){

                $thisLikeBtn.addClass('liked');
                $thisLikeBtn.text('Liked');

                /** Update constant count value for output */
                if( countBinder){
                    countBinder++;
                    countBinderEl.val(countBinder);
                    countBinderEl.text(countBinder);
                }
            }
        },'json');
    });
}
function follow_post_bound() {
    'use strict';
    var followBtn = '[data-bound-follow-post="btn"]';

    $('body').on('click',followBtn,function () {

        var $thisFollowBtn = $(this);

        /** Id for the post being liked.  */
        var postId = $thisFollowBtn.data('post-id');

        /** The post type id for the liked post */
        var postType = $thisFollowBtn.data('post-type');

        /** The user's Id who owns the question. */
        var postUserId = $thisFollowBtn.data('post-user-id');


        var ajaxObject = {
            form : 'Follow Post',
            post_id : postId,
            post_type : postType,
            post_user_id : postUserId,
            cache : false
        };
        /** Process the like btn */
        $.post(RELATIVE_PATH + '/config/processing.php',ajaxObject,function (response) {
            console.log(response);
            if( response.status === 'unfollowed'){

                $thisFollowBtn.removeClass('liked');
                $thisFollowBtn.find('span').text('Follow');

            }else if(response.status === 'following'){

                $thisFollowBtn.addClass('liked');
                $thisFollowBtn.find('span').text('Following');
            }
        },'json');
    });
}
function single_forum_pagination() {
    'use strict';

    var pageParent = '#forum-single ';

    /** Answer Pagination */
    var answerPaginationBox = '[data-answer-pagination="box-single"]'

    /** Answer pagination button */
    var answerPaginationBtn = pageParent + ' ' + answerPaginationBox + ' [data-pagination-number]';

     $('body').on('click', answerPaginationBtn,function () {
       var $this = $(this);

       /** Process the clicked pagination */
       if(!$this.hasClass('active')){


           /** the id for the question associated with the answers. */
           var questionId = $this.parent().data('question-id');

           /** The limit of answers to show. */
           var paginationLimit = $this.parent().data('question-pagination-limit');

           /** The number value for the pagination button clicked. */
           var paginationNumber = $this.data('pagination-number');

           /** The Container that hold all the tables. */
           var answerTables = $this.closest('[data-answers="container"]').find('[data-answer="tables"]');

           var ajaxData = {
               form : 'Forum Answer Pagination',
               data : {
                   questionId : questionId,
                   paginationNumber : paginationNumber,
                   paginationLimit : paginationLimit
               }
           };

           /** switch active class around */
           $(answerPaginationBtn).removeClass('active');
           $this.addClass('active');

           /** get the pagination data */
           $.get(RELATIVE_PATH +'/ajax-loads/forum/forum-single/recent-answers.php',ajaxData,function (response) {

               console.log(response);
               answerTables.html(response);
           });

       }

   });

}
function answer_filters() {
    'use strict';

    var pageId = '[data-questions-parent="true"]';
    var topFilters = pageId +  ' [data-answer-filter]';

    $(topFilters).on('click', function () {
        var $thisFilter = $(this);

        var questionsContainer = $thisFilter.parent().parent().find('[data-questions="container"]');

        /** Json object for the clicked filters. */
        var jsonObject = {
            category : $thisFilter.closest('.category').data('category'),
            subcategory : $thisFilter.closest('.subcategory').data('subcategory'),
        };
        var ajaxFile;

        $thisFilter.siblings().removeClass('active');
        $thisFilter.addClass('active');

        switch ($thisFilter.data('filter')){
            case 'most recent':
                ajaxFile = 'getMostRecentQuestions';
                break;
            case 'top question':
                ajaxFile = 'getTopQuestions';
                break;
            case 'unanswered':
                ajaxFile = 'getBottomQuestions';
                break;
            default:
        }

        $.get(RELATIVE_PATH +'/ajax-loads/forum/' + ajaxFile +'.php', jsonObject, function (response) {

            /** File the area with the new questions */
            questionsContainer.html(response);

            /** Reset the answer section once the new question load. */
            answerQuestion();

            /** Run human time */
            $('time.human-time').timeago();
        });

    });
}
