/**
 * File For: HopeTracker.com
 * File Name: .
 * Author: Mike Giammattei
 * Created On: 5/23/2017, 4:05 PM
 */

$(document).ready(function() {
    equal_h_w_infoBox();
    function equal_h_w_infoBox() {
        if($(window).width() < 769 && $('.info-box').length > 0){
            setTimeout(function () {
                equalheight('.info-box');
                equalWidth('.info-box');
            },4000);
        }else if($('.info-box').length > 0){
            $('.info-box').removeAttr('style');
        }
        if($('.cat-details').length > 0){
            setTimeout(function () {
                equalWidth('.cat-details')
            },2000);
        }
    }

    if($('.add-forum-pre-box').length > 0){
        forum_add_post();
    }
    function forum_add_post() {
        $('body').on('click','.add-forum-pre-box',function () {
            var sub_cat_id = $(this).data('sub-cat-id');
            $('.submit-forum-post').attr('data-sub-cat-id',sub_cat_id);

            window.refresh_div = $(this).data('refresh-id');
        });
        $('#forum form').on('submit',function (e) {
            e.preventDefault();

            var
                $this = $(this),
                form_id = '#' + $this.attr('id'),
                title = $(form_id).find('#title'),
                title_parent = $(form_id).find('#title').parent(),
                content = $(form_id).find('#content'),
                anxiety = $(form_id).find('#anxiety').css('background-size'),
                isolation = $(form_id).find('#isolation').css('background-size'),
                happiness = $(form_id).find('#happiness').css('background-size'),
                content_parent = $(form_id).find('#content').parent(),
                title_val = title.val(),
                content_val = content.val(),
                submit_btn = $(form_id).find('#submit-forum-post'),
                modal_id = '#' + $this.closest('.modal').attr('id');
            ;

            if(!submit_btn.hasClass('disabled')){
                /* Title Checks */
                if(title_val === '' && title_parent.find('.error-box').length === 0){
                    title_parent.prepend('<div class="error-box center" style="display: none;">A title is required. </div>');
                    title_parent.find('.error-box').slideDown();
                }else if(title_parent.find('.error-box').length > 0 && title_val !== ''){
                    title_parent.find('.error-box').slideUp(function () {
                        title_parent.find('.error-box').remove();
                    });

                }
                /* Content Checks */
                if( content_val === '' && content_parent.find('.error-box').length === 0){
                    content_parent.append('<div class="error-box center" style="display: none;">Content must be provided. </div>');
                    content_parent.find('.error-box').slideDown();
                }else if(content_val !== '' && content_parent.find('.error-box').length > 0){
                    content_parent.find('.error-box').slideUp(function () {
                        content_parent.find('.error-box').remove();
                    });
                }
                if(title_val !== '' && content_val !== '') {
                    $.ajax({
                        url : '/config/processing.php',
                        type : "POST",
                        cache : false,
                        data : {
                            form : 'Forum Add Post',
                            data : $(form_id).serialize() + "&sub_cat_id=" + submit_btn.data('sub-cat-id') + "&anxiety=" + clean_emotions(anxiety) + "&isolation=" + clean_emotions(isolation)  + "&happiness=" + clean_emotions(happiness)
                        },
                        //dataType : 'json',
                        success : function (response) {
                            //console.log(response);
                            $(form_id).trigger('reset');
                            $(modal_id).modal('hide');

                            $('#total-forums').load(location.href+ ' #total-forums>*', '');
                            $('#'+refresh_div).load(location.href+ ' #'+refresh_div+'>*', '');
                            setTimeout(function () {
                                $('#modal-success').modal('show');
                            },400);
                        }
                    });
                }
            }

        });
        function clean_emotions(value) {
            value = value.replace(/ /g, '');
            value = value.replace(/\%/g, '_');
            return value;
        }
    }
})

/**
 * stacktable.js
 * Author & copyright (c) 2012: John Polacek
 * CardTable by: Justin McNally (2015)
 * Dual MIT & GPL license
 *
 * Page: http://johnpolacek.github.com/stacktable.js
 * Repo: https://github.com/johnpolacek/stacktable.js/
 *
 * jQuery plugin for stacking tables on small screens
 * Requires jQuery version 1.7 or above
 *
 */
;(function($) {
    $.fn.cardtable = function(options) {
        var $tables = this,
            defaults = {headIndex:0},
            settings = $.extend({}, defaults, options),
            headIndex;

        // checking the "headIndex" option presence... or defaults it to 0
        if(options && options.headIndex)
            headIndex = options.headIndex;
        else
            headIndex = 0;

        return $tables.each(function() {
            var $table = $(this);
            if ($table.hasClass('stacktable')) {
                return;
            }
            var table_css = $(this).prop('class');
            var $stacktable = $('<div></div>');
            if (typeof settings.myClass !== 'undefined') $stacktable.addClass(settings.myClass);
            var markup = '';
            var $caption, $topRow, headMarkup, bodyMarkup, tr_class;

            $table.addClass('stacktable large-only');

            $caption = $table.find(">caption").clone();
            $topRow = $table.find('>thead>tr,>tbody>tr,>tfoot>tr,>tr').eq(0);

            // avoid duplication when paginating
            $table.siblings().filter('.small-only').remove();

            // using rowIndex and cellIndex in order to reduce ambiguity
            $table.find('>tbody>tr').each(function() {

                // declaring headMarkup and bodyMarkup, to be used for separately head and body of single records
                headMarkup = '';
                bodyMarkup = '';
                tr_class = $(this).prop('class');
                // for the first row, "headIndex" cell is the head of the table
                // for the other rows, put the "headIndex" cell as the head for that row
                // then iterate through the key/values
                $(this).find('>td,>th').each(function(cellIndex) {
                    if ($(this).html() !== ''){
                        bodyMarkup += '<tr class="' + tr_class +'">';
                        if ($topRow.find('>td,>th').eq(cellIndex).html()){
                            bodyMarkup += '<td class="st-key">'+$topRow.find('>td,>th').eq(cellIndex).html()+'</td>';
                        } else {
                            bodyMarkup += '<td class="st-key"></td>';
                        }
                        bodyMarkup += '<td class="st-val '+$(this).prop('class')  +'">'+$(this).html()+'</td>';
                        bodyMarkup += '</tr>';
                    }
                });

                markup += '<table class=" '+ table_css +' stacktable small-only"><tbody>' + headMarkup + bodyMarkup + '</tbody></table>';
            });

            $table.find('>tfoot>tr>td').each(function(rowIndex,value) {
                if ($.trim($(value).text()) !== '') {
                    markup += '<table class="'+ table_css + ' stacktable small-only"><tbody><tr><td>' + $(value).html() + '</td></tr></tbody></table>';
                }
            });

            $stacktable.prepend($caption);
            $stacktable.append($(markup));
            $table.before($stacktable);
        });
    };

    $.fn.stacktable = function(options) {
        var $tables = this,
            defaults = {headIndex:0,displayHeader:true},
            settings = $.extend({}, defaults, options),
            headIndex;

        // checking the "headIndex" option presence... or defaults it to 0
        if(options && options.headIndex)
            headIndex = options.headIndex;
        else
            headIndex = 0;

        return $tables.each(function() {
            var table_css = $(this).prop('class');
            var $stacktable = $('<table class="'+ table_css +' stacktable small-only"><tbody></tbody></table>');
            if (typeof settings.myClass !== 'undefined') $stacktable.addClass(settings.myClass);
            var markup = '';
            var $table, $caption, $topRow, headMarkup, bodyMarkup, tr_class, displayHeader;

            $table = $(this);
            $table.addClass('stacktable large-only');
            $caption = $table.find(">caption").clone();
            $topRow = $table.find('>thead>tr,>tbody>tr,>tfoot>tr').eq(0);

            displayHeader = $table.data('display-header') === undefined ? settings.displayHeader : $table.data('display-header');

            // using rowIndex and cellIndex in order to reduce ambiguity
            $table.find('>tbody>tr').each(function(rowIndex) {

                // declaring headMarkup and bodyMarkup, to be used for separately head and body of single records
                headMarkup = '';
                bodyMarkup = '';
                tr_class = $(this).prop('class');

                // for the first row, "headIndex" cell is the head of the table
                if (rowIndex === 0) {
                    // the main heading goes into the markup variable
                    if (displayHeader) {
                        markup += '<tr class=" '+tr_class +' "><th class="st-head-row st-head-row-main" colspan="2">'+$(this).find('>th,>td').eq(headIndex).html()+'</th></tr>';
                    }
                } else {
                    // for the other rows, put the "headIndex" cell as the head for that row
                    // then iterate through the key/values
                    $(this).find('>td,>th').each(function(cellIndex) {
                        if (cellIndex === headIndex) {
                            headMarkup = '<tr class="'+ tr_class+'"><th class="st-head-row" colspan="2">'+$(this).html()+'</th></tr>';
                        } else {
                            if ($(this).html() !== ''){
                                bodyMarkup += '<tr class="' + tr_class +'">';
                                if ($topRow.find('>td,>th').eq(cellIndex).html()){
                                    bodyMarkup += '<td class="st-key">'+$topRow.find('>td,>th').eq(cellIndex).html()+'</td>';
                                } else {
                                    bodyMarkup += '<td class="st-key"></td>';
                                }
                                bodyMarkup += '<td class="st-val '+$(this).prop('class')  +'">'+$(this).html()+'</td>';
                                bodyMarkup += '</tr>';
                            }
                        }
                    });

                    markup += headMarkup + bodyMarkup;
                }
            });

            $stacktable.prepend($caption);
            $stacktable.append($(markup));
            $table.before($stacktable);
        });
    };

    $.fn.stackcolumns = function(options) {
        var $tables = this,
            defaults = {},
            settings = $.extend({}, defaults, options);

        return $tables.each(function() {
            var $table = $(this);
            var $caption = $table.find(">caption").clone();
            var num_cols = $table.find('>thead>tr,>tbody>tr,>tfoot>tr').eq(0).find('>td,>th').length; //first table <tr> must not contain colspans, or add sum(colspan-1) here.
            if(num_cols<3) //stackcolumns has no effect on tables with less than 3 columns
                return;

            var $stackcolumns = $('<table class="stacktable small-only"></table>');
            if (typeof settings.myClass !== 'undefined') $stackcolumns.addClass(settings.myClass);
            $table.addClass('stacktable large-only');
            var tb = $('<tbody></tbody>');
            var col_i = 1; //col index starts at 0 -> start copy at second column.

            while (col_i < num_cols) {
                $table.find('>thead>tr,>tbody>tr,>tfoot>tr').each(function(index) {
                    var tem = $('<tr></tr>'); // todo opt. copy styles of $this; todo check if parent is thead or tfoot to handle accordingly
                    if(index === 0) tem.addClass("st-head-row st-head-row-main");
                    var first = $(this).find('>td,>th').eq(0).clone().addClass("st-key");
                    var target = col_i;
                    // if colspan apply, recompute target for second cell.
                    if ($(this).find("*[colspan]").length) {
                        var i =0;
                        $(this).find('>td,>th').each(function() {
                            var cs = $(this).attr("colspan");
                            if (cs) {
                                cs = parseInt(cs, 10);
                                target -= cs-1;
                                if ((i+cs) > (col_i)) //out of current bounds
                                    target += i + cs - col_i -1;
                                i += cs;
                            } else {
                                i++;
                            }

                            if (i > col_i)
                                return false; //target is set; break.
                        });
                    }
                    var second = $(this).find('>td,>th').eq(target).clone().addClass("st-val").removeAttr("colspan");
                    tem.append(first, second);
                    tb.append(tem);
                });
                ++col_i;
            }

            $stackcolumns.append($(tb));
            $stackcolumns.prepend($caption);
            $table.before($stackcolumns);
        });
    };

}(jQuery));

$('.responsive-example-table').stacktable();

/* Follow Forum Sub Category */
follow_sub_category();
function follow_sub_category() {
    $('body').on('click','[data-forumSubCat]',function () {
        var $this = $(this),
        sub_cat_id = $this.attr('data-forumSubCat');

        $.ajax({
           url: RELATIVE_PATH + '/config/processing.php',
           type: 'POST',
           data: {
               form: 'Follow Forum Sub Category',
               sub_cat_id: sub_cat_id
           },
           success: function (response) {
               if(response === 'Following'){
                   $this.addClass('following');
               }else if(response === 'Un-follow Subcategory'){
                   $this.removeClass('following');
               }
           }
        });

    });
}
/* Follow Forum Sub Category Post */
follow_sub_category_post();
function follow_sub_category_post() {
    $('body').on('click','[data-subCatForumPost]',function () {
        var $this = $(this),
            sub_cat_id_post = $this.attr('data-subCatForumPost');

        $.ajax({
           url: RELATIVE_PATH + '/config/processing.php',
           type: 'POST',
           data: {
               form: 'Follow Forum Sub Category Post',
               sub_cat_id_post: sub_cat_id_post
           },
           success: function (response) {
               console.log(response);
               if(response === 'Following'){
                   $this.addClass('following');
               }else if(response === 'Un-follow Subcategory'){
                   $this.removeClass('following');
               }
           }
        });

    });
}

/* Forum Reply Form */
forum_reply_forum();
function forum_reply_forum(){

    var form_id = '#forum-comment';
    $(form_id).bootstrapValidator({
        live : 'enabled',
        submitButtons : $('#forum-comment-btn'),
        message : 'General Message',
        fields : {
            message: {
                validators :{
                    notEmpty: {
                        message : $(form_id).find('textarea').data('empty-msg')
                    },
                }
            }
        }
    }).on('success.form.bv',function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: RELATIVE_PATH + '/config/processing.php',
            data: {
                form : 'Forum Reply',
                data :{
                    textarea : $(form_id + ' textarea').val(),
                    forum_id : $(form_id).find('#forum-comment-btn').data('forum-post-id'),
                    forum_user_id : $(form_id).find('#forum-comment-btn').data('forum-post-user-id')
                }
            },
            //dataType : 'json'
        }).done(function(response) {
            console.log(response);
            var $form = $(e.target);
            var bv = $form.data('bootstrapValidator');

            if(response === 'Success'){
                $(form_id).find('.success-box').slideDown(500,function () {
                    $(form_id).find('.success-box').addClass('on');
                    setTimeout(function () {
                        $(form_id).find('.success-box').slideUp(500);
                        $(form_id).find('.success-box').removeClass('on');
                    },3000);
                });
                $('#reply-posts').load(location.href + " #reply-posts ");
                $('form').bootstrapValidator('resetForm', true);
            }
        });
    });
}

/* Like Forum Posts */
like_forum_post();
function like_forum_post(){
    var like_btn = '.post-like';

    $(like_btn).on('click',function () {
       var $this = $(this);

       $.ajax({
           url : '/config/processing.php',
           type : 'POST',
           data : {
               form : 'Like Forum Reply',
               data : {
                   post_id : $this.data('forum-post-id'),
                   post_user_id : $this.data('forum-post-user-id'),
                   post_reply_user_id : $this.data('forum-reply-user-id'),
                   data_forum_reply_id : $this.data('forum-reply-id')
               }
           },
           success : function (response) {
              /* console.log(response);*/
               if(response === 'Liked'){
                   $this.addClass('liked');
               }else if(response === 'Unliked'){
                   $this.removeClass('liked');
               }
           }
       });
    });
}
/* Like Forum */
like_forum();
function like_forum(){
    var like_btn = '#main-post .star';

    $(like_btn).on('click',function () {
       var $this = $(this);

       $.ajax({
           url : '/config/processing.php',
           type : 'POST',
           data : {
               form : 'Like Forum',
               data : {
                   forum_id : $this.data('forum-id'),
                   forum_user_id : $this.data('forum-user-id')
               }
           },
           success : function (response) {
               console.log(response);
               if(response === 'Liked'){
                   $this.addClass('liked');
               }else if(response === 'Unliked'){
                   $this.removeClass('liked');
               }
           }
       });
    });
}
