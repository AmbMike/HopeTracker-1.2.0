$(document).ready(function () {
    'use strict';
    communitySearchPosts();
    journalFilterFrom();
});
function communitySearchPosts() {
    'use strict';

    var  master_container =  '[data-community-post="page"]';
    var container = master_container +  ' #community-nav';

    var search = {
        actionBtns : container + ' li'
    };

    /** Hide the search filter container. */
    var filterContainerEl = $(searchEl('filter-container'));

    /** Gets the url get value for showing filter when anchor is in the URL */
    var getValue = window.location.hash.substr(1);

    if(getValue !== 'community-nav'){
        filterContainerEl.css({'display' : 'none'});
    }

    /** Hide the search filter container. */
    $(searchEl('order-container')).css({'display' : 'none'});

    /** On click show the filter search element */
    var toggleBtn = master_container + ' [data-toggle-btn]';

    $(toggleBtn).on('click',function () {
        var $this = $(this);

        var $thisDataToggle = $this.data('toggle-btn');
        /** close open menus */
        $('[data-toggle-btn]').each(function () {

            /** Each toggle btn value */
            var $thisToggleBtn = $(this).attr('data-toggle-btn');

            if($(this).hasClass('on')){
                $('[data-toggle-box="' + $thisToggleBtn + '"]').stop().slideUp(700);
                $this.removeClass('on');
            }
        });

        /** Slide Down Selected Btn Box */
        $($this).toggleClass('on');
        $('[data-toggle-box="' + $thisDataToggle + '"]').stop().slideToggle(600);


    });

    /** Like Journal Post addendum */
    $('body').on('click','[data-bound-post-like="btn"]' ,function () {
        var $thisBtn = $(this);

        /** The post parent div */
        var postParent = '[data-post-parent="post"]';

        var likeCount = $thisBtn.closest(postParent).find('.liked-count');

        /** The total post likes before the user likes the post. */
        var postTotalLikes = likeCount.text();

        /** the class of the icon clicked. */
        var $thisBtnClass = $thisBtn.parent().find('i').attr('class');

        if($thisBtnClass === 'fa fa-thumbs-o-up'){
            $thisBtn.parent().find('i').removeClass('fa-thumbs-o-up').addClass('fa-thumbs-up');

            /** Increment the likes up 1 */

            /** if the clicked button is not for a comment then increment up */
            if(!$thisBtn.parent().find('[data-post-btn]')){
                postTotalLikes++;
                likeCount.text(postTotalLikes);
            }

        }else{
            $thisBtn.parent().find('i').removeClass('fa-thumbs-up').addClass('fa-thumbs-o-up');

            /** Increment the likes down 1 */
            if(!$thisBtn.parent().find('[data-post-btn]')) {
                postTotalLikes--;
                likeCount.text(postTotalLikes);
            }
        }



    });

    /** Order post section */
    $( '[data-toggle-box="member-order"] input[type="radio"]').on('change', function () {
        var orderByValue = $(this).val();

        /** Update the order by button text. */
        $(container + ' [data-order-val]').text(orderByValue);
        $(container + ' #filter-value').attr('data-order-val', orderByValue);

        /** Get the list of post ids if any have been selected from the filters*/
        var currentPostIds = false
        if($('[data-post-user-ids]').length > 0){
             currentPostIds = $('[data-post-user-ids]').attr('data-post-user-ids');
        }
        var ajaxDataOrder = {
            ajaxPost : 'order by',
            data  : {
                type : 'order by',
                postIds : currentPostIds,
                orderType : orderByValue
            }
        };
        $.get(RELATIVE_PATH + '/site/cwd/views/includes/journal/postsV1.php',ajaxDataOrder,function (response) {
            $('#related-post').html(response);
            $('[data-toggle-box]').stop().slideUp(700);
            $('[data-toggle-box]').removeClass('on');
            $('time.human-time').timeago();
        });

    });

    /** Builds the html data value for the search element by taking in the data-search[name]. */
    function searchEl(dataName) {
        return master_container + '  [data-search="' + dataName + '"]';
    }

    /** Parent container for post input */
    var postInputParent = '[data-toggle-box="member-posts"]';
    var postInput = postInputParent + ' textarea';

    /** Process post entry when user clicks enter on in the input section. */
    $(postInput).keypress(function(e) {
        if(e.which === 13) {

            var $thisInput = $(this);
            var $inputValue = $thisInput.val();

            var ajaxData = {
                form : 'Journal Entry Lite',
                content : $inputValue
            };
            $.post(RELATIVE_PATH + '/config/processing.php',ajaxData,function (response) {
                if(response.status === 'Successful'){
                    $thisInput.val('');

                    /** Add new  post to  the page */
                    $('[data-postv1="parent"]').prepend(buildPost(response.userId, response.usernameUrl, response.usernameFormatted, response.entryDate, response.state, response.zip, $inputValue, response.postId,response.userProfile));
                    $('time.human-time').timeago();
                }
            },'json');
        }
    });

    if($('[data-toggle-box="answer-comment"]').length > 0){
        answer_comment();
    }
    function answer_comment() {
        /** Parent container for post input */
        var postInputParent = '[data-toggle-box="answer-comment"] button ';
        $('body').on('click',postInputParent,function () {
            var $this = $(this);
            var answerId = $this.data("answer-id");
            var inputValue = $this.closest('.textarea-box').find('textarea').val();

            var ajaxData = {
                form : 'Answer Comment',
                cache: false,
                data : {
                    post_type: 7,
                    parent_post_type: 4,
                    parent_post_id: answerId,
                    content: inputValue
                }
            };
            $.post(RELATIVE_PATH + '/config/processing.php',ajaxData,function (response) {
                if(response.status === 'Success'){
                    $this.closest('.answer-container').find('.answer-data-container .comment-fill').append(buildComment(response.userId, response.usernameUrl, response.usernameFormatted, response.entryDate, response.state, response.zip, inputValue, response.postId,response.userProfile));
                    $('time.human-time').timeago();
                    $('textarea').val(' ');

                }
            },'json');

        });
    }

    function buildComment(userId,usernameUrl,usernameFormatted,entryDate,state,zip,content,postId,userProfile) {
        var html = "<hr>" +
            "<div class='clearfix'> " +
            "   <div class='table'>" +
            "       <div class=\"author-img-box cell\">\n" +
            "           <img onclick=\"window.location='"+RELATIVE_PATH + "/" + userProfile+"'\" role=\"button\" src='/"+userProfile+"' alt='"+usernameFormatted+"' class=\"img-circle profile-img\">\n" +
            "       </div>\n" +
            "       <div class=\"post-text-box cell\">\n" +
            "           <div class=\"quote-box\" itemprop=\"author\" itemscope=\"\" itemtype=\"http://schema.org/Person\">\n" +
            "                <span onclick=\"window.location='"+RELATIVE_PATH + "/" + userProfile+"'\" role=\"button\" itemprop=\"name\">"+usernameFormatted+"</span>\n" +
            "            </div>\n" +
            "           <div class=\"user-count-container\">\n" +
            /*"               <span><data value=\"2\" class=\"user-questions\">2</data> Questions <data value=\"24\" class=\"user-answers\">24</data> Answers</span>\n" +*/
            "               <div class=\"asked-about-box\">\n" +
            "                   <span><!--<i class=\"fa fa-circle\" aria-hidden=\"true\"></i>--></span> Asked <time itemprop=\"dateCreated\" class=\"human-time\" datetime='"+entryDate+"' title='"+entryDate+"'>"+entryDate+"</time>\n" +
            "               </div>\n" +
            "          </div>\n" +
            "          <div class=\"author-text-box\">\n" +
            "               <span itemprop=\"text\" class=\"author-text\">"+content+"</span>\n" +
            "          </div>\n" +
            "          <div class=\"tracker-box\">\n" +
            "               <div class=\"question-liked-box\">" +
            "                   <i class=\"fa fa-thumbs-o-up like-count-icon updated-txt-false\" style='margin-right: 5px;' role=\"button\" data-bound-post-like=\"btn\" data-post-id='"+postId+"' data-post-type='7' data-post-user-id=\"1\"></i><data data-like-post-count-updater=\"\" value=\"0\" class=\"question-liked-text\">0</data>\n" +
            "               </div> " +
            "               <span class=\"flag-box is-comment\" data-question=\"flag-btn\" data-comment-id=\" "+postId+"\" data-post-type=\"7\"  data-question=\"flag-btn\" role=\"button\">" +
            "                   <span class=\"flag-tooltip-text\">Click here to report this post as inappropriate.<a class=\"alt-flag\">flag</a></span>\n" +
            "                   <i class=\"fa fa-flag\" aria-hidden=\"true\"></i>" +
            "               \n" +
            "         </div>\n" +
            "      </div>" +
            "   </div>" +
            "</div>" ;
        return html;
    }

    function buildPost(userId,usernameUrl,usernameFormatted,entryDate,state,zip,content,postId,userProfile){
        var idNum = Math.floor(1000 + Math.random() * 9000);
        var html = '<section data-post-parent="post" class="box-one no-p">\n' +
            '            <ul class="post">\n' +
            '                <li>\n' +
            '                    <a class="wrap" href="' + RELATIVE_PATH + '/families-of-drug-addicts/user-'+userId+'/'+usernameUrl+'"><img src="/'+userProfile+'" class="img-circle profile-img sm"></a>\n' +
            '                </li>\n' +
            '                <li>\n' +
            '                    <div class="simple-heading user-name">\n' +
            '                        <a class="wrap" href="' + RELATIVE_PATH + '/families-of-drug-addicts/user-'+userId+'/'+usernameUrl+'">'+usernameFormatted+'</a>\n' +
            '                        <div class="author-info-box">\n' +
            '                            <time itemprop="dateCreated" class="human-time date" datetime="'+entryDate+'" title="'+entryDate+'"></time> <i class="fa fa-circle" aria-hidden="true"></i><span class="author-local"> '+state+', '+zip+' </span>\n' +
            '                        </div>\n' +
            '                    </div>\n' +
            '                </li>\n' +
            '                <li class="comment-content">\n' +
            '                                       <div class="text-content">\n' +
            '\t                   '+content+'                   </div>\n' +
            '                </li>\n' +
            '                <hr>\n' +
            '\n' +
            '                   <li>\n' +
            '                            <span class="like-box"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> <span data-post-btn="like comment" role="button" data-bound-post-like="btn" data-post-user-id="'+userId+'" data-post-id="'+postId+'" data-post-type="2">Like</span></span>\n' +
            '                        </li>\n' +
            '\t                                \n' +
            '                <li data-toggle="collapse" role="button" data-target="#post-commentV1-'+idNum+'" class="collapsed" aria-expanded="false"><span class="comment-box"><i class="fa fa-comment-o" aria-hidden="true"></i> Comment</span></li>\n' +
            '            </ul>\n' +
            '\t\t                <div id="post-commentV1-'+idNum+'" class="reply-box collapse" aria-expanded="false" style="height: 1px;">\n' +
            '                <div class="reply-liked-box">\n' +
            '                    <i class="fa fa-heart" aria-hidden="true"></i>\n' +
            '                    <i class="fa fa-thumbs-up" aria-hidden="true"></i>\n' +
            '                    <span id="post-like-count-0" data-post="like journal" class="liked-count">0</span>\n' +
            '                </div>\n' +
            '                <div class="clearfix"></div>\n' +
            '                <div class="comment-replies">\n' +
            '                                                    </div>\n' +
            '                <div class="comment-input">\n' +
            '                    <div class="table">\n' +
            '                        <div class="cell image-cell">\n' +
            '                            <div class="user-img">\n' +
            '                                <a class="wrap" href=""> <img src="/'+userProfile+'" class="img-circle profile-img sm"></a>\n' +
            '                            </div>\n' +
            '                        </div>\n' +
            '                        <div class="cell">\n' +
            '                            <div class="input-box">\n' +
            '                                <div class="textarea-box">\n' +
            '                                    <textarea data-comment-journal-id="'+postId+'" rows="1" data-postv1="comment-input" class="text-features active" name="entry_content" placeholder="Begin typing here..."></textarea>\n' +
            '                                </div>\n' +
            '                            </div>\n' +
            '                        </div>\n' +
            '                    </div>\n' +
            '                </div>\n' +
            '            </div>\n' +
            '        </section>';

        return html;
    }
}

function journalFilterFrom() {
    'use strict';
    var formId = '#search-by-name';

    var usernameInput = formId + ' input[name*="username"]';

    var usernameInputVal = $(usernameInput).val();

    var searchFiltersBox = formId + ' [data-search-filter="box"]';

    /** Make dropdown box the same width as the input. */
    $(window).on('resize',function () {
        if($('.suggested-usernames').length > 0) {
            var suggestedBoxWidth = $(formId + ' .username').outerWidth();
            $(formId + ' .suggested-usernames').css({'width' : suggestedBoxWidth + 'px'});
        }
    });

    /** Auto Suggest Search on Username */
    $('body').on('keyup',usernameInput,function () {
        var $thisUsername = $(this);
        var $thisParent = $(this).parent();
        $.post(RELATIVE_PATH + '/config/processing.php',{form : "Name Suggestions" , name : $thisUsername.val()},function (response) {
            var fillBox = $thisParent.find('.suggested-names');

            fillBox.html('');
            if(response.length > 0) {
                fillBox.append(buildNameList(response));

                /** Make dropdown box the same width as the input. */
                var suggestedBoxWidth = $(formId + ' .username').outerWidth();
                $(formId + ' .suggested-usernames').css({'width' : suggestedBoxWidth + 'px'});
            }
            function buildNameList(response) {
                var html = '<ul class="suggested-usernames">';
                $.each(response, function(value) {
                    html += "<li role='button'>"+response[value].fname+"  " + response[value].lname +"</li>";
                });
                html += '</ul>';
                return html;
            }

        },'json');
    });

    if($('.suggested-names').length > 0){
        $('body').on('mouseleave','.suggested-names',function () {
            $('.suggested-names').remove();
        });
    }

    /** Clicked suggested username */
    $('body').on('click','.suggested-usernames li',function () {
        var $thisClickedUsername = $(this);
        var $thisClickedUsernameVal = $(this).text();

        var usernameParent = $thisClickedUsername.closest('[data-filter-box="username"]');

        /** Fill username input with the clicked suggested username */
        usernameParent.find('input').val('');
        usernameParent.find('input').val($thisClickedUsernameVal);
        $('.suggested-names').html('');

    });

    /** Search by name form processing */
    $(formId).on('submit', function (e) {
        e.preventDefault();

        /** Reset post count for infinite scroll post on the "postV1.js" file. */
        $('#journal-postV1').data('post-start',3);

        var ajaxData = {
            name : $(formId + ' input[name*="name"]').val(),
            ajaxPost : 'by name'
        };

        $.get(RELATIVE_PATH + '/site/cwd/views/includes/journal/postsV1.php',ajaxData,function (response) {
            $('#related-post').html(response);
            $('.filter-container').slideUp(700,function () {
                $(formId)[0].reset();
                //$('#search-by-name-outer').load(location.href + ' #search-by-name');
            });
            moreText();
        });
    });


    var filterFormId = '#search-filter';
    $(filterFormId).on('submit', function (e) {
        e.preventDefault();

        /** Reset post count for infinite scroll post on the "postV1.js" file. */
        $('#journal-postV1').data('post-start',3);

        var ajaxData = {
            ajaxPost : 'by filters',
            data : {
                type : 'by filters',
                state : $(filterFormId + ' select[name*="state"]').val(),
                zip : $(filterFormId + ' input[name*="zip"]').val(),
                roles : checkboxData(filterFormId + ' #role-filter') ,
                concerned_about : checkboxData(filterFormId + ' #loved-ones'),
                status : checkboxData(filterFormId + ' #stage-filter'),
                show_as : checkboxData(filterFormId + ' #show-as-filter')
            }
        };


        $.get(RELATIVE_PATH + '/site/cwd/views/includes/journal/postsV1.php',ajaxData,function (response) {
            $('#related-post').html(response);
            moreText();
            $('.filter-container').slideUp(700,function () {
                $(formId)[0].reset();
                //$('#search-by-name-outer').load(location.href + ' #search-by-name');

            });
        });

        function checkboxData(id) {
            var returnValues = [];

            $(id).find('[type="checkbox"]').each(function () {
                var $thisCheckbox = $(this);

                if($thisCheckbox.is(":checked")){
                    returnValues.push($thisCheckbox.val());
                }
            });

            return returnValues;
        }
    });
}