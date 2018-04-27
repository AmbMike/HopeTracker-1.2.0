/**
 * File For: HopeTracker.com
 * File Name: .
 * Author: Mike Giammattei
 * Created On: 5/3/2017, 10:27 AM
 */

/* TinyMCE
tinymce.init({
    selector : 'textarea.text-features',
    menubar:false,
    statusbar: false,
    plugins: 'placeholder',
    browser_spellcheck : true
});
*/

/*$('#sidebar').on('click',function () {
   $.get(RELATIVE_PATH +'/ajax-loads/newly-posted-journal.php',function (response) {
       var html = response;
       $('#journal-entries').prepend(html);
   });
});*/

/* Range */
$('input[type=range]').on('input', function(e){
    var min = e.target.min,
        max = e.target.max,
        val = e.target.value;

    $(e.target).css({
        'backgroundSize': (val - min) * 100 / (max - min) + '% 100%'
    });
}).trigger('input');

if($('#journal-entry').length > 0){
    journal_entry_from();

    function journal_entry_from() {
        'use strict';

        var obj = {
            form_id : '#journal-entry',
            form_btn : '#journal-entry .save-btn',
            error_check : $('.input-box')
        };



        /* Validate input fields */
        $(obj.form_id).mg_validate({
            auto_complete : false
        });


        $(obj.form_id + ' input[name="title"]').mg_validate({
            form_id : 'journal-entry',
            submit_btn : obj.form_btn,
            require : true,
            max_length : 200,
            min_length : 2
        });


        /* Auto save when user stops typing */
        var typingTimer;
        var doneTypingInterval = 1000;
        var $input = $(obj.form_id + ' .title').add(obj.form_id + ' .text-features').not('.save-btn');

        // start the countdown
        $input.on('keyup', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });

        // clear the countdown
        $input.on('keydown', function () {
            clearTimeout(typingTimer);
        });

        /** Save draft when user changes ranges */
        $(obj.form_id + ' #range-box .range').on('mouseup',function () {
            doneTyping ();
        });

        //user is "finished typing," do something
        function doneTyping () {
            var content = $(obj.form_id + ' .text-features').val();
            var draftPostId = false;

            /** Check if the draft is new or exsiting */
            if($(obj.form_id).attr('data-post-draft-id')){
                draftPostId = $(obj.form_id).attr('data-post-draft-id');
            }

            var title = $(obj.form_id + ' input[name="title"]').val()
            /* Process the from */
            if(!obj.error_check.hasClass('error') && title !== '') {
                $.ajax({
                    type: 'POST',
                    url: RELATIVE_PATH + '/config/processing.php',
                    dataType : 'json',
                    cache : false,
                    data: {
                        form_content: content,
                        form: 'Journal Entry',
                        status : 2,
                        postId : draftPostId,
                        entry_title: $(obj.form_id + ' input[name="title"]').val(),
                        entry_anxiety: {
                            size: $(obj.form_id + ' #anxiety').css("background-size"),
                            value: $(obj.form_id + ' #anxiety').val()
                        },
                        entry_isolation: {
                            size: $(obj.form_id + ' #isolation').css("background-size"),
                            value: $(obj.form_id + ' #isolation').val()
                        },
                        entry_happiness: {
                            size: $(obj.form_id + ' #happiness').css("background-size"),
                            value: $(obj.form_id + ' #happiness').val()
                        },
                        //feeling: $(obj.form_id + ' select[name="feeling"]').val()
                    },

                    success: function (response) {
                        console.log(response);
                        if(response.status === 'Success'){
                            /** Update time after the post has been save */
                            $(obj.form_id + ' .updater').html('Draft saved <time itemprop="dateCreated" class="human-time date" datetime="'+response.time+'">'+response.time+'</time>');
                            $(obj.form_id + ' .updater-box').slideDown(500);
                            $(obj.form_id).attr('data-post-draft-id',response.postId);
                            $('time.human-time').timeago();

                        }
                    }
                });
            }

        }

        $(obj.form_id + ' input[name="submit"]').on('click',function (event) {
            event.preventDefault();
            var $thisSubmitInput = $(this);
           /* var tinyMCE_error_box = 'div #tinyMCE-body';

            if($(tinyMCE_error_box).length === 0){
                var content = tinyMCE.activeEditor.getContent();
                if( content === ""){
                    //tinyMCE_good = 'fail';
                    $(obj.form_id).find(obj.error_check).append('<div class="error-box center" id="tinyMCE-body" style="display: none;">To create an entry, you must enter content below: </div>');
                    $(tinyMCE_error_box).slideDown(400);
                }
            }else{
                var content = tinyMCE.activeEditor.getContent();
                if($(tinyMCE_error_box).length > 0 && content !== "") {
                    $(tinyMCE_error_box).remove();
                    //tinyMCE_good = 'success';
                }
            }*/

            var content = $(obj.form_id + ' .text-features').val();
            var title = $(obj.form_id + ' input[name="title"]').val()
            /* Process the from */
            if(!obj.error_check.hasClass('error') && title !== '') {

                var draftPostId = false;

                /** Check if the draft is new or exsiting */
                if($(obj.form_id).attr('data-post-draft-id')){
                    draftPostId = $(obj.form_id).attr('data-post-draft-id');
                }
                $thisSubmitInput.prop('disabled', true);

                $.ajax({
                    type: 'POST',
                    url: RELATIVE_PATH + '/config/processing.php',
                    dataType : 'json',
                    cache : false,
                    data: {
                        form_content: content,
                        form: 'Journal Entry',
                        publishPost : true,
                        postId : draftPostId,
                        status : 1,
                        dataType : 'json',
                        entry_title: title,
                        entry_anxiety: {
                            size: $(obj.form_id + ' #anxiety').css("background-size"),
                            value: $(obj.form_id + ' #anxiety').val()
                        },
                        entry_isolation: {
                            size: $(obj.form_id + ' #isolation').css("background-size"),
                            value: $(obj.form_id + ' #isolation').val()
                        },
                        entry_happiness: {
                            size: $(obj.form_id + ' #happiness').css("background-size"),
                            value: $(obj.form_id + ' #happiness').val()
                        },
                        //feeling: $(obj.form_id + ' select[name="feeling"]').val()
                    },
                    success: function (response) {
                        console.log(response);
                        if(response.status === 'Success'){
                            //$(obj.form_id)[0].reset();

                            /** stop the loop from sending out draft to database */
                            clearTimeout(typingTimer);


                            $(obj.form_id).removeAttr('data-post-draft-id');

                             $('#related-post-out').load(location.href+ ' #related-post',function () {
                                 /** Initiate the "more text" script. */
                                 //moreText();

                               /** reset the input fields */
                               $(obj.form_id + ' .text-features').val('');
                               $(obj.form_id + ' input[name="title"]').val('');

                               $(obj.form_id + ' .updater-box').slideUp(500);

                               $(obj.form_id).parent().find('.alert-success').slideDown(600,function () {
                                   // Enable submit button.
                                   $thisSubmitInput.prop('disabled', false);
                               });


                                 /** Reset the form ranges. */
                               /*  $(obj.form_id + ' .range').each(function () {
                                     var $this = $(this);
                                     $this.css({'background-size' : '50% 100%'});
                                 });*/

                                 /** Remove validation icons */
                                 $('.input-box').removeClass('valid');

                             });

                        }
                    }
                });
            }

        });

    }
}
/* Show Comments */
journal_show_comments();

/* Show full text of entry */
//show_full_entry();

function journal_show_comments() {
    var obj = {
        parent : '.entry-box',
        comments_box : '.other-comments',
        show_comments_btn : '.show-more'
    };

    /* Capture Text */
    window.content_text_box_min_height = [];
    window.content_text_box_full_height = [];
    window.content_origin_height = [];
    window.content_text = [];
    window.content_text_cut = [];

    //$(obj.comments_box).css({'display' : 'none'});

    // /* Set height of .entry-box */
    // setTimeout(function () {
    //     $('.entry-box').each(function () {
    //         $(this).find('.content').css({'height' : $(this).find('.content').innerHeight() + 'px'});
    //     });

    //     $('.entry-box').each(function () {
    //         content_origin_height.push($(this).find('.content').outerHeight());
    //     });
    // },600);


    $('body').on('click',obj.show_comments_btn,function () {

        var clicked_position = $(this).closest('.entry-box').index();

        /* Show all entry */
        if($(this).hasClass('on')){
            $('.entry-box').eq(clicked_position).find('.content').html( window.content_text_cut[clicked_position]);
            $('.entry-box').eq(clicked_position).find('.content').css({'height' :  content_origin_height[clicked_position] + 'px'});

        }else{
            $(this).parent().parent().parent().parent().parent().find('.content').html(window.content_text[clicked_position]);
            $('.entry-box').eq(clicked_position).find('.content').css({'height' :  'auto'});
        }

        $(this).toggleClass('on');

        /* Show comments etc. */
        //$(this).parent().siblings().find(obj.comments_box).stop().slideToggle(500);
    });
}

function show_full_entry() {
    var obj = {
        parent_id : '#journal-posts',
        content : '.content',
        text_limit : 130
    }



    $(obj.parent_id + ' ' + obj.content).each(function(i){
        content_text.push($(this).html());
        content_text_box_full_height.push($(this).outerHeight());
    });
    $(obj.parent_id + ' ' + obj.content).each(function(i){
        var len = $(this).text().length;
        if(len>parseInt(obj.text_limit)) {
            $(this).text($(this).text().substr(0,parseInt(obj.text_limit))+'...');
            content_text_box_min_height.push($(this).outerHeight());
            content_text_cut.push($(this).html());
        }
    });

}

if($('#journal-posts').length > 0){
    new Clipboard('.copy-btn');

    $('.copy-btn').protipSet({
        trigger: 'click'
    });


    /* Like Function */
    like_journal_entry();
    function like_journal_entry() {
        obj = {
           parent_id : '#journal-posts',
           like_btn : '#interact .like',
            active_color : $('nav').css('background-color')
        };

        $('body').on('click',obj.parent_id + ' ' + obj.like_btn,function () {
            var $this = $(this);

            /* Set icon */
            var icon_html = $this.html();

            //$this.html('<i class="fa fa-cog fa-spin fa-3x fa-fw" aria-hidden="true"></i>');


            $this.toggleClass('liked');

            if($this.hasClass('liked')){
                var like_status = 'liked';
            }else{
                var like_status = 'unlike';
            }

            /* Process like */
            $.ajax({
                url : '/config/processing.php',
                type : 'POST',
                data : {
                    form : 'Like Journal Entry',
                    like_status : like_status,
                    journal_id : $this.data('journal-id')
                },
                success : function (response) {

                    /** Reset journal likes in sidebar */
                    $('#like-count').load(" #like-count");

                    /* Put back like html value */
                    //$this.html(icon_html);

                    if(response === 'Not Logged In'){
                        $this.removeClass('liked');

                        $this.tooltip('hide')
                            .attr('data-original-title', 'Must be logged in to like this journal entry.')
                            .tooltip('show');
                    }else {
                        $this.tooltip('hide')
                            .attr('data-original-title', '')
                            .tooltip('show');
                    }
                }
            });
        });
    }

    /* Comment Function */
    journal_entry_comment();
    function journal_entry_comment() {
      var  obj = {
            parent_id : '#journal-posts',
            containers : '.entry-box',
            form_id : '#journal-entry-form',
            comment_editor : '.comment-editor',
            comment_btn : '#interact .comment',
            error_check : '.input-box',
            comment_input : 'input[name="comment"]',
            comment_form_btn : 'input[name="comment_btn"]',
            comments_box : '.other-comments',
        };

        $(obj.comments_box).slideUp(1);

        /* Show the comment editor when user clicks the comment button */

        $('body').on('click',obj.comment_btn,function () {
            $this = $(this);
            if(!$this.hasClass('on')){
                $this.addClass('on');

                $this.parent().parent().find('#journal-entry-form').eq(0).css({'display' : 'block'});

                $this.parent().parent().find(obj.comments_box).stop().slideToggle(400,function () {
                    $this.parent().parent().find('.show-all-comment').css({'display' : 'inline-block'});
                       $this.parent().parent().find(obj.comments_box).find('.level-one-comment').stop().toggleClass('opacity-full');
                    $this.removeClass('on');
                });
            }

        });

        /* Process comment */
        $('body').on('click',obj.comment_form_btn,function () {
            event.preventDefault();

            var $this = $(this);
            var entry_index = $(this).closest('.entry-box').index();
            var comment_input = $this.parent().parent().find(obj.comment_input);
            var icon_html = $this.html();

            /* Loading Gear */
            $this.html('<i class="fa fa-cog fa-spin fa-3x fa-fw" aria-hidden="true"></i>');

            /* validate input comment */
            if( comment_input.val() === " " || comment_input.val().length < 10){
                var error_container = $this.parent().parent().find(obj.error_check);
                if(error_container.find('.error-box').length < 1){

                    error_container.prepend('<div class="error-box center" id="comment-error" style=" clear:both; display: none;">Must be at least 10 characters long.  </div>');
                    error_container.find('.error-box').slideDown(400);
                }
            }else{
                $(obj.parent_id + ' .error-box').remove();

                /* Check if this data attr has data comment-of-comment-journal ='s true */
                var opt_data = {};
                if($this.attr('data-comment-of-comment-journal')){
                    var form_process_name = 'Journal Comment of Comment';
                    opt_data.parent_comment_id = $this.data('parent-comment-id');
                    opt_data.parent_comment_user_id = $this.data('parent-comment-user-id');
                }else{
                    var form_process_name = 'Journal Entry Comment';
                }

                /* Process comments */
                $.ajax({
                    url : '/config/processing.php',
                    type : 'POST',
                    data : {
                        form : form_process_name,
                        comment : comment_input.val(),
                        journal_id : $this.data('journal-id'),
                        optional_data : opt_data

                    },
                    success : function (response) {
                        /* Put back like html value */
                        $this.html(icon_html);

                        if(response === 'Not Logged In'){

                        }else {

                            /* Comment Input Html For Refresh */
                            var form_update  = $this.parent().parent().find('#comment-editor-' + entry_index);
                            var form_html = $(form_update).html();

                            /* Comment Button Html For Refresh */
                            var btn_update  = $this.parent().parent().find('#comment-btn-' + entry_index);
                            var btn_html = $(btn_update).html();

                            $('#comment-qty-' + entry_index).load(window.location.href + ' #comment-qty-' + entry_index);
                            $('#input-box-' + entry_index).load(window.location.href + ' #input-box-' + entry_index,function () {
                                $('.comment-of-comment form').css({'display' : 'none'});
                                console.log($this.parent().parent().parent().parent().parent().parent().parent().parent().parent().find('.main-comment-box').find('.level-one-comment').attr('class'));
                                $('.level-one-comment').removeClass('opacity-none').addClass('opacity-full');
                            });

                            //form_update.find('.input-box').html();
                            /*$('#comment-btn-' + entry_index).find('.btn').prop('disabled', true);
                            form_update.find('.input-box').html('<div id="close-msg-comment" data-dismiss="alert" style="width:97%;margin-left:1%;" class="alert alert-success"> <span class="close" data-dismiss="alert">x</span> <strong>Success!</strong> Comment was add. </div>');
                            $('body').on('click','#close-msg-comment',function () {
                                form_update.html(form_html);
                                btn_update.html(btn_html);
                            });*/


                        }
                    }
                });
            }
        });
    }

    /* Share Journal
    share_journal();
    function share_journal() {
        var  obj = {
            journal_position : '#journal-position-',
            share_btn : '.share-btn'
        };

        $(obj.share_btn).on('click',function () {
           console.log($(this).data('journal-position'));
        });

    } */

    /* Handle the page anchor when user shares post */
    anchor_page_jump()
    function anchor_page_jump() {
        if(window.location.hash) {
            var hash = window.location.hash.substring(1);
            setTimeout(function () {
                $('#' + hash).find('.show-more').trigger('click');
            },1300);
        }
    }

    /* Like Entry post comment by user */
    like_comment();
    function like_comment() {
        var obj = {
          parent : '.entry-box',
          share_btn : '.like-comment'
        };

        $('body').on('click',obj.parent + ' ' + obj.share_btn,function () {
            event.preventDefault();
            var $this = $(this);
            /* Set icon */
            var icon_html = $this.html();
           // $this.html('<i class="fa fa-cog fa-spin fa-3x fa-fw" aria-hidden="true"></i>');

            $this.toggleClass('liked');

            if($this.hasClass('liked')){
                var like_status = 'liked';
            }else{
                var like_status = 'unlike';
            }
            $.ajax({
                type : 'POST',
                url : '/config/processing.php',
                data : {
                    form : 'Liked Comment',
                    parent_post_id : $this.data('parent-entry-id'),
                    like_status : like_status,
                    comment_owner_id : $this.data('comment-user-id'),
                    comment_id : $this.data('comment-id')
                },
                success : function (response) {

                    if(response === 'Not Logged In'){
                        $this.removeClass('liked');

                        $this.tooltip('hide')
                            .attr('data-original-title', 'Must be logged in to like this journal entry.')
                            .tooltip('show');
                        /* Put back like html value */
                        //$this.html(icon_html);

                    }else {
                        /* Put back like html value */
                        //$this.html(icon_html);

                    }
                }
            });
        })
    }

    /* Like Entry post comment by user */
    reply_to_comment();
    function reply_to_comment() {
        var obj = {
            parent : '.entry-box',
            reply_box : '.reply-box',
            comment_editor : '.comment-editor',
            form : '#journal-entry-form',
            reply_btn : '.reply-btn',

        };

        /* Hide reply input */
        $(obj.comment_editor + ' ' + obj.form).css({'display' : 'none'});

        /* Show reply box input field when user clicks reply */
        $('body').on('click','.reply-btn',function () {
            event.preventDefault();
            var $this = $(this);
            $this.parent().parent().parent().parent().parent().find('.comment-of-comment').find('#journal-entry-form').stop().slideToggle(450);
        });

    }

    c_to_c_pagination();
    function c_to_c_pagination() {
        $('body').on('click','.c2c-count a' ,function (e) {
            e.preventDefault();

            var $this = $(this);

            if(!$($this).hasClass('disabled')){

                $this.addClass("disabled");

                $.ajax({
                    url : '/config/pagination.php',
                    type : 'POST',
                    data : {
                        function : 'C To C Pagination',
                        page_val : $this.text(),
                        parent_post_id : $this.closest('ul').data('parent-post-id'),
                        parent_comment_id : $this.closest('ul').data('parent-comment-id'),
                        parent_comment_user_id : $this.closest('ul').data('parent-comment-user-id')
                    },
                    dataType : 'json',
                    success : function (response) {
                        console.log(response);
                        $this.parent().parent().parent().parent().parent().parent().find('.c2c-box').html('');
                        $.each(response,function (index, value) {
                            $this.parent().parent().parent().parent().parent().parent().find('.c2c-box').prepend('<div class="comment-editor"> <div class="table"> <div class="cell person"> <div class="box"> <img src="/'+value.profile_img+'" class="Profile center-block"> <span class="blue-text-sm "><strong>'+value.fname+'</strong></span> </div> </div> <div class="cel comment"> '+ value.comment +'</div> </div> </div>');
                            //$this.append("<li>"+value.comment+"</li>")
                        });
                        setTimeout(function () {
                            $this.removeClass("disabled");
                        },1000);
                    }

                });
            }

        })
    }

    show_all_comments();
    function show_all_comments() {
       /* */$('#comments-section .show-all-comment').css({'display' : 'none'});

        $('body').on('click','#comments-section .show-all-comment',function (e) {
            e.preventDefault();

            var $this = $(this);
            if(!$(this).hasClass('on')) {
                $this.addClass('on');
                /* Clear code from div */
                $('#input-box-'+ $this.data('input-box-id')).html('');

                /* Transition */
                $('#input-box-'+ $this.data('input-box-id')).animate({'opacity' : '0'},500);
                $.get( "../all-journal-comments.php", {
                    index : $this.data('index'),
                    entry_id : $this.data('entry-id'),
                    show_less : $this.data('show-less'),
                    //comment: value.comment

                } )
                    .done(function( data ) {
                        $('#input-box-'+ $this.data('input-box-id')).append( data );
                        setTimeout(function () {
                            $this.find('form').css({'display' : 'none'});
                            $('#input-box-'+ $this.data('input-box-id')).animate({'opacity' : '1'},500);
                        },300);
                    });


                $this.removeClass('on');

            }

        });
    }
}
/* Follow User From User Journal Page */
follow_user_from_journal();
function follow_user_from_journal() {
    $('body').on('click','[data-followUser]',function () {
        var $this = $(this),
            followers_username_val = $this.attr('data-followUser');

        $.ajax({
            url: RELATIVE_PATH + '/config/processing.php',
            type: 'POST',
            data: {
                form: 'Follow User From Journal Profile',
                followers_username: followers_username_val
            },
            success: function (response) {
                console.log(response);
                if(response === 'Following'){
                    $this.addClass('following');
                }else if(response === 'Un-followed'){
                    $this.removeClass('following');
                }
            }
        });

    });
}


