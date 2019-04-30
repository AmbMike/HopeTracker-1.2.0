/**
 * File For: HopeTracker.com
 * File Name: .
 * Author: Mike Giammattei
 * Created On: 3/21/2017, 3:49 PM
 */

$(document).ready(function () {
    /*Inspiration Slider */
    $('#inspiration-box .slider').slick({
        arrows: true,
        dots: false,
        autoplay: true,
        autoplaySpeed: 6000,
        prevArrow: $('.quotes-prev'),
        nextArrow: $('.quotes-next')


    });
    /*Chat Slider */
   /* $('#chat-box .slider').slick({
        autoplay: true,
        autoplaySpeed: 5000
    });*/
    /* Entry Box */
    /*$('#entry-box .slider').slick({});*/

    /* Sidebar journal and forum post switcher */
    sidebar_post_switch();

    /* Sidebar Facebook Share Function */
    sidebar_share_quote();

});

function mg_sticky_sidebar(sidebar) {
    window.start = 0;
    window.start1 = 0;
    var scroll_position = $(window).scrollTop();
    var win= $(window);
    var obj = {
        main : $('main'),
        aside : $('aside'),
        wrapper : $('.wrapper'),
        sidebar : {
            el : $(sidebar),
            child : $(sidebar).children(),
            top : $(sidebar).offset().top
        },
        header : $('header'),
        window : {
            height : win.innerHeight(),
            width : win.width()
        },
        stopper : $('footer')
    };

    window.sidebar_width = obj.sidebar.el.outerWidth();

    /* Allow function if side is smaller than main */
    if(obj.main.height() > obj.aside.height()){
        $(document).on('scroll',function () {
            scroll_position = $(window).scrollTop();
            if(window.start == 0){
                window.start = 1;
                /* Set spot START STICK */
                window.scroll_point = win.height() - obj.header.outerHeight();
                window.scroll_point = obj.sidebar.el.outerHeight() - scroll_point  ;
                /* Set Top Stick Position */
                window.top_stick = obj.sidebar.el.outerHeight() - win.height();
                /* Set Sidebar width */
                window.side_width = obj.sidebar.el.outerWidth();
                /* Set Sidebar Height */
                window.side_height = obj.sidebar.el.outerHeight();
            }

            if(scroll_position > scroll_point && $('footer').isOnScreen() === false){
                $('.sidebar').css({'position' : 'fixed', 'top' : '-' + top_stick + 'px',  'width' : side_width + 'px', 'height': side_height + 'px'});
            }else if(scroll_position < scroll_point && $('footer').isOnScreen() === false){
                obj.sidebar.el.removeAttr('style');
                reset_sliders();
            }

            if($('footer').isOnScreen() === true){
                if(start1 == 0){

                    /* Set Stick Postion */
                    window.side_position = obj.sidebar.el.offset().top - obj.header.height() - 100;
                    console.log(side_position);
                    window.start1 =1;
                }
                obj.sidebar.el.css({'position' : 'absolute', 'top' :  side_position + 'px',  'width' : sidebar_width + 'px'});
            }
        });
    }

    function reset_sliders() {
        $('#chat-box .slider').slick('setPosition');
        $('#inspiration-box .slider').slick('setPosition');
        $('#entry-box .slider').slick('setPosition');
    }

}
function sidebar_post_switch() {
    "use strict";
    var slider_boxes = '#sidebar .entry-box .slider-box',
        forum_post = '.forum-slides',
        journal_post = '.forum-slides';


    /** Hide all post slides */
    $(slider_boxes).css({'display': 'none'});

    /** Shows first post slide */
    $(slider_boxes).eq(0).css({'display': 'block'});


    /**
     * The click functionality for the journal and forum switcher
     * @return null : adds an active class to the clicked button.
     */
    sidebar_entry_menu();
    function sidebar_entry_menu() {
        var
            slider_boxes = '#sidebar .entry-box .slider-box',
            obj = {
            menu : $('.sidebar .menu'),
            li : $('.sidebar .menu ul li')
        };
        $(obj.li).on('click',function () {
            obj.li.removeClass('active');
            $(this).addClass('active');


            /** The position of the clicked button position. */
            var button_position = $(this).index();

            /** Toggles the posts view according to selection */
            $(slider_boxes).animate({opacity : '0'},500,function () {
                $(this).css({'display': 'none'});
                $(slider_boxes).eq(button_position).css({'display': 'block'});
                $('#entry-box .slider').slick('reinit');
                $(slider_boxes).eq(button_position).animate({opacity : '1'},500);
            });

        });
    }

}
function sidebar_share_quote(){
    "use strict";

    /** @var slider selector */
    var slider = '#inspiration-box .slider';

    var domain = location.protocol + "//"+ location.host;

    /** @var Save Image button */
    var save_img_btn = '.share-box .save-btn';

    /** @var slide selector */
    var img = '#inspiration-box .slider .slick-track .slick-slide';

    /** @var facebook share link */
    var facebook_link = "#inspiration-box .share-box .facebook ";

    /** @var pintrest share link */
    var pintrest_link = "#inspiration-box .share-box .pintrest ";

    /** @var current_slide : set the position of the current slide */
    var current_slide = 1;

    /** @Var img_src :  path of the current slide image. */
    var img_src = $(img).eq(current_slide).attr('src');

    /** @var link_img_id : the current slide image's id */
    var current_img_id = $(img).eq(current_slide).attr("data-quote-id");

    /** @var href_value : the path for the facebook share. */
    var facebook_href_value = "http://www.facebook.com/sharer.php?u=" + domain + "/inspiration/?og_img=";

    /** Sets the facebook link with the current slide values. */
    set_link(facebook_link,current_img_id,facebook_href_value,img_src);

    /** Sets the pintrest link with the current slide values. */
    build_pintrest_link(img_src,domain);



    /** Generates the current slide on change and resets the share link values */
    $(slider).on('afterChange', function(event, slick, currentSlide){

        /** @Var img_src :  path of the current slide image. */
        img_src = $(img).eq(currentSlide+1).attr('src');

        /** @var link_img_id : the current slide image's id */
        current_img_id = $(img).eq(currentSlide+1).attr("data-quote-id");

        /** Change image id on on the save button to that of the current image id */
        $(save_img_btn).attr('data-img-id', current_img_id);

        /** Set Facebook link */
        set_link(facebook_link,current_img_id,facebook_href_value,img_src);

        /** Sets the pintrest link with the current slide values. */
        build_pintrest_link(img_src,domain);

        /** Checks the current img id with an array of image ids the user has saved.
         * Then sets the value of the button accordingly.
         */
        check_set_save_inspirations(current_img_id,save_img_btn);

    });


    /**
     * Sets the data for the current share link - Facebook
     */
    function set_link(facebook_link,current_img_id,facebook_href_value,img_src) {
        $(facebook_link).attr('data-img-id',current_img_id);
        $(facebook_link).attr('href',facebook_href_value + img_src);

    }

    /** Build the pintrest href link */
    function build_pintrest_link(img_src,domain) {

       // https://pinterest.com/pin/create/button/?url=http://hopetracker.com/inspiration/?og_img=/site/public/images/quotes/quote.choosing_peace.jpg&media=http://hopetracker.com/site/public/images/quotes/quote.choosing_peace.jpg
        /** base part of the pintrest share url */
        var returnValue = "https://pinterest.com/pin/create/button/?url=" + domain + "/inspiration/?og_img=";

        /** add the current image slide to the share link*/
        returnValue += img_src;

        /** add final part of the pintrest url */
        returnValue += "&media=" + domain + "/" + img_src;

        /** Sets the pintrest share link value */
        $(pintrest_link).attr('href',returnValue);

    }


    /** Get the array of inspiration ids to check if the current image has been saved or not */
    function check_set_save_inspirations(current_img_id,save_img_btn)  {
        $.post(RELATIVE_PATH + '/config/processing.php',{form : 'Inspiration Sidebar Saved Arr'}, function(data) {
          // alert(current_img_id);
            if ($.inArray(current_img_id, data) !== -1)
            {
                $(save_img_btn).text('Saved');
            }else{
                $(save_img_btn).text('Save');
            }
        },'json');
    }

   /** Save Inspiration Image */
   save_inspiration(save_img_btn);
    function save_inspiration(save_img_btn) {

        $(document).on('click','#sidebar-save[data-btn="save-inspiration-sidebar"]',function () {
            var
                $this = $(this),
                status = 'Save',
                image_id = $(this).attr('data-img-id');
            if($this.text() === 'Saved'){
                status = 'Un-save';
            }

            $.ajax({
                url  : RELATIVE_PATH + '/config/processing.php',
                cache : false,
                type : 'POST',
                data : {
                    form : 'Save Inspiration',
                    status : status,
                    img_id : image_id
                },
                dataType : 'json',
                success : function (response) {

                    if(response.status === "Saved"){
                        /* Update Save Count On Screen */
                        update_share_count();
                        $this.text('Saved');
                    }else if(response.status === 'Unsaved'){
                       $this.text('Save');
                    }

                    function update_share_count() {
                        var count_update = $this.parent().find('.white-box span').text();
                        count_update++;
                        $this.parent().find('.white-box span').text(count_update);
                    }
                }
            });

        });
    }
}

sidebar_like_journal();
function sidebar_like_journal() {
    'use strict';

    var obj = {
        parent_id : '#sidebar .action-btns',
        like_btn : '#sidebar .post-like'
    };
    $('body').on('click',obj.like_btn,function () {
        var $this = $(this);

        /* Set icon */
        var icon_html = $this.html();

        //$this.html('<i class="fa fa-cog fa-spin fa-3x fa-fw" aria-hidden="true"></i>');


        $this.parent().toggleClass('liked');

        if($this.parent().hasClass('liked')){
            window.like_status = 'liked';
        }else{
            window.like_status = 'unlike';
        }

        /** Build data for ajax depended on if post is a journal or a forum */
        var ajax_data;
        if( $this.data('post-type') === 'Journal'){
             ajax_data = {
                form : 'Like Journal Entry',
                 like_status : like_status,
                 journal_id : $this.data('post-id')

            };
        }else if($this.data('post-type') === 'Forum'){
            ajax_data = {
                form : 'Like Forum',
                data : {
                    forum_id : $this.data('post-id'),
                    forum_user_id : $this.data('user-id')
                }

            };
        }

        $.ajax({
            url : RELATIVE_PATH + '/config/processing.php',
            type : 'POST',
            data : ajax_data,
            cache : false,

            success : function (response) {

                console.log(response);
                /** Reset journal likes in sidebar */
                $('#like-count').load(" #like-count");

                if(response === 'Not Logged In'){
                    $this.parent().removeClass('liked');

                    $this.parent().tooltip('hide')
                        .attr('data-original-title', 'Must be logged in to like this journal entry.')
                        .tooltip('show');
                }else {
                    $this.parent().tooltip('hide')
                        .attr('data-original-title', '')
                        .tooltip('show');
                }
            }
        });

    });
}

$(document).ready(function () {
    'use strict';
    /* Chat Function */
    sidebar_chat_level_1();
});

function sidebar_chat_level_1() {
    'use strict';

    /** Chat In Elements */
    var masterParent = '#sidebar';
    var chatInParent = masterParent + ' .answer-box';
    var input = chatInParent + ' input';
    var chat_output_box = '.chat-output-level-1';
    var show_chat_btn = masterParent + " #comment-btn-level-1";
    var show_comments_box = '#sidebar-comment-box';
    var likeBtn = show_comments_box + ' .like-btn';
    var chatItem = chat_output_box + ' .mg-flex';

    /** Data values */
    var postType = $(chat_output_box).data('post-type');

    /** Chat Out Elements */
    var chatOutParent= '#sidebar .chat-output-level-1';

    /** Hide all comments */
    $(chatOutParent).css({'opacity' : '0'});

    /** Preload Elements */
    var primaryHtml = $(chatInParent).find('.cell:first-child').html();

    /** Run flex div method and show comments after comment button has been clicked. */
    $(show_comments_box).on('shown.bs.collapse', function() {
        mgDivFlex();
        $(chatOutParent).animate({'opacity' : '1'},500);
    });

    /** Submit the comment when user presses enter */
    $(input).on('keydown',function (e) {

        /** Process comment if user presses enter */
        if (e.keyCode === 13) {
            var $thisInput =  $(this);
            var inputText = $thisInput.val();
            var postType = $thisInput.data('post-type');
            var postId = $thisInput.data('post-id');
            var ajaxData;
            var post_user_id = $thisInput.data('post-user-id');
            var postUserId;

            /** Add Comment To Database */
            if(postType === 'Journal'){
                 ajaxData = {
                    form : 'Journal Entry Comment Sidebar',
                    comment : inputText,
                    journal_id : postId
                };

                 /** Set to none : used when the entry is associated with forum */
                postUserId = '';

            }else if(postType === 'Forum'){
                 ajaxData = {
                    form : 'Forum Reply',
                     data : {
                         forum_id : postId,
                         textarea : inputText,
                         forum_user_id : post_user_id,
                         json : true
                     }

                };

                /** Set to none : used when the entry is associated with forum */
                postUserId = $thisInput.data('post-user-id');
            }
            else if(postType === 3){
                ajaxData = {
                    form : 'Answer Question Forum',
                    data : {
                        question_id : postId,
                        answer : inputText,
                        json : true
                    }

                };

                /** Set to none : used when the entry is associated with forum */
                postUserId = $thisInput.data('post-user-id');
            }
            $.post(RELATIVE_PATH + '/config/processing.php',ajaxData,function (response) {
                if(response.status === 'Success'){
                    /** Remove the first chat to make room for new chat */
                    if( $(chatItem).length >= 3){
                        $(chatItem).eq(0).remove();
                    }
                    /** add the new chat data to the sidebar */
                    $(chatOutParent).append(build_new_chat_div(primaryHtml,inputText,postId,response.comment_id, response.comment_user_id, postUserId));

                    /** Reset input box after */
                    $thisInput.val('');

                    /** run the mg-flex function to reset the flex properties */
                    mgDivFlex();
                }
            },'json');

        }
    });

    /** Process comment on click "like btn" : add to database */
    $('body').on('click',likeBtn, function () {
        var $thisLikeBtn = $(this);
        var likeStatus;

        var likeBtnHtml = $thisLikeBtn.html();

        if($thisLikeBtn.hasClass('liked')){
            likeStatus = 'unlike';
        }else{
            likeStatus = 'liked';
        }

        /** Pending Message */
        $thisLikeBtn.html('Processing...')

        /** If Journal */
       var  ajaxData;
        if(postType === 'Journal'){
            /** Store comment in database */
            ajaxData = {
              form : 'Liked Comment',
                parent_post_id : $thisLikeBtn.parent().data('post-id'),
                comment_id : $thisLikeBtn.parent().data('comment-id'),
                comment_owner_id : $thisLikeBtn.parent().data('comment-user-id'),
                like_status : likeStatus
            };

        }else if(postType === 'Forum'){
             ajaxData = {
                form : 'Like Forum Reply',
                data : {
                    post_id : $thisLikeBtn.parent().data('post-id'),
                    data_forum_reply_id : $thisLikeBtn.parent().data('comment-id'),
                    post_reply_user_id : $thisLikeBtn.parent().data('comment-user-id'),
                    post_user_id : $thisLikeBtn.parent().data('post-user-id'),
                    like_status : likeStatus,
                    json : true
                }

            };
        }else if(postType === 3){
            ajaxData = {
                form : 'Like Post',
                post_id : $thisLikeBtn.parent().data('comment-id'),
                post_type :4,
                post_user_id : $thisLikeBtn.parent().data('post-user-id')
            };
        }
        /** Make the ajax call to process the like */
        setTimeout(function () {
            $.post(RELATIVE_PATH + '/config/processing.php',ajaxData,function (response) {
                console.log(response);
                $thisLikeBtn.html(likeBtnHtml);
                if(response.status === 'liked'){
                    if($thisLikeBtn.hasClass('liked')){
                        $thisLikeBtn.removeClass('liked');
                    }else{
                        $thisLikeBtn.addClass('liked');
                    }
                }else{
                    $thisLikeBtn.removeClass('liked');
                }
            },'json');
        },700);
    });
}
/** used to build the html structure for an instance mg_flex_div */
function build_new_chat_div(primaryData, subData,postId,commentId, commentUserId,postUserId) {
    'use strict';
    return ''+
    '<div class="answer-box " >' +
        '<div class="table mg-flex">'+
        '<div class="cell">' + primaryData + '</div>' +
        '<div class="cell"> <div class="output-text">' + subData + ' ' +
        '<div data-post-id="' + postId + '" data-comment-id="' + commentId + '" data-comment-user-id="' + commentUserId + '" data-post-user-id="' + postUserId + '"  class="actions">\n' +
        '<div class="like-btn">\n' +
        '<i class="fa fa-thumbs-o-up " aria-hidden="true"></i> Like\n' +
        '</div>\n' +
        '<div class="reply-btn">\n' +
      /*  '<i class="fa fa-comment-o"></i> Comment\n' +*/
        '</div>\n' +
        '</div></div></div></div>' +
    '</div>'+
    '<div class="clearfix></div>"';
}


function showMoreOnlineUsers() {

    var ajaxData = {
        form : 'Show More Online Users',
        start: parseInt(4),
        qty: parseInt(4000)
    };
    $.post(RELATIVE_PATH  + '/config/processing.php', ajaxData, function (res) {
        console.table(res);

        $.each(res, function(index, value){
           //$('h1').append('<h3>'+value.user_id+'</h3>') 
        });
    },'json');
}
