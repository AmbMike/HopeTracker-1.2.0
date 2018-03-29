/*
 * Copyright (c) 2018.
 */

if($('#inspiration-v1').length > 0){
    inspirationSlides();
}

function inspirationSlides() {
    'use strict';
    var imageContainerId = '#inspiration-images';

    $(imageContainerId).slick(getSliderSettings());

    /** Current slide position */
    var dataId = $('.slick-current').attr("data-slick-index");

    /** Current slide element*/
    var currentImg = $('#inspiration-images img').eq(dataId).next();

    /** Current slide like value */
    var currentImgLikeStatus = currentImg.attr('data-liked-status');

    /** Current slide like value */
    var currentImgLikeCount = currentImg.attr('data-like-count');

    /** Image link button */
    var likeBtn = $('#inspiration-container .like-box');

    /** Get the current image path */
    var currentImagePath = $('#inspiration-images img').eq(dataId).next().attr('src');

    /** Get the file name of the current image. */
    var fileNameIndex = currentImagePath.lastIndexOf("/") + 1;
    var filename = currentImagePath.substr(fileNameIndex);

    var is_self_help_folder = currentImagePath.search(/self-help/i);

    /** Search if image is in the "quotes" folder */
    var is_quotes_folder = currentImagePath.search(/quotes/i);

    var current_img_folder;

    /** if is in the "self-help" folder */
    if(is_self_help_folder > 0){
        current_img_folder =   'self-help';
    }else if(is_quotes_folder > 0){
        current_img_folder = 'quotes';
    }

    /** Updated like button on load */
    if(currentImgLikeStatus === 'liked'){
        likeBtn.addClass('liked').html('<i class="fa fa-thumbs-up" aria-hidden="true"></i> Like');
    }


    /** Set the start count  of likes for the current image */
    var currentImageLikeCountEl =  $('[data-slider-el="container"] .like-count data.num');
    currentImageLikeCountEl.val(currentImgLikeCount);
    currentImageLikeCountEl.text(currentImgLikeCount);


    /** Set share values on load */
    $('#inspiration-container .action-btns-box .share-link').attr('href', 'https://www.facebook.com/sharer/sharer.php?u=http%3A//hopetracker.com/open-graph/?og_img=/site/public/images/'+current_img_folder+'/'+filename);

    /** Update the slide when it changes to have it's properties. */
    $(imageContainerId).on('afterChange', function() {

        /** Current slide position */
        var dataId = $(imageContainerId).slick("slickCurrentSlide");

        /** Current slide element*/
        var currentImg = $('#inspiration-images img').eq(dataId).next();

        /** Get the current image path */
        var currentImagePath = $('#inspiration-images img').eq(dataId).next().attr('src');

        /** Get the file name of the current image. */
        var fileNameIndex = currentImagePath.lastIndexOf("/") + 1;
        var filename = currentImagePath.substr(fileNameIndex);

        var is_self_help_folder = currentImagePath.search(/self-help/i);

        /** Search if image is in the "quotes" folder */
        var is_quotes_folder = currentImagePath.search(/quotes/i);

        var current_img_folder;

        /** if is in the "self-help" folder */
        if(is_self_help_folder > 0){
            current_img_folder =   'self-help';
        }else if(is_quotes_folder > 0){
            current_img_folder = 'quotes';
        }

        /** Close comment box */
        var commentContainer = $('[data-slider-el="container"]');
        if(commentContainer.hasClass('in')){
            commentContainer.slideUp(400,function () {
                commentContainer.removeClass('in').removeAttr('style');

                /** Reset comment container on change of the slides to make way for new comments*/
                $('#inspiration-container [data-comment-btn="show"]').addClass('collapsed');
                $('#inspiration-container [ data-inspiration="comment fill"]').html('');

            });
        }


        /** Current slide like value */
        var currentImgLikeStatus = currentImg.attr('data-liked-status');

        if(currentImgLikeStatus === 'liked'){
            likeBtn.addClass('liked').html('<i class="fa fa-thumbs-up" aria-hidden="true"></i> Like');
        }else{
            likeBtn.removeClass('liked').html('<i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Like');
        }

        /** Set the start count  of likes for the current image */
        var currentImgLikeCount = currentImg.attr('data-like-count');
        var currentImageLikeCountEl =  $('[data-slider-el="container"] .like-count data.num');
        currentImageLikeCountEl.val(currentImgLikeCount);
        currentImageLikeCountEl.text(currentImgLikeCount);

        /** updated current share link value */
        $('#inspiration-container .action-btns-box .share-link').attr('href', 'https://www.facebook.com/sharer/sharer.php?u=http%3A//hopetracker.com/open-graph/?og_img=/site/public/images/'+current_img_folder+'/'+filename);
    });

    $('#inspiration-container .like-box').on('click', function () {

        var $thisLikeBox = $(this);

        var currentSlideData = getCurrentSlideData();
        var ajaxData = {
          form : 'Like Inspiration',
          folder : currentSlideData.folder,
          filename : currentSlideData.filename,
          fullFilePath : currentSlideData.fullFilePath
        };

        $.post(RELATIVE_PATH + '/config/processing.php',ajaxData,function (response) {
            console.log(response);

            /** Update the like count */
            var currentImageLikeCountEl =  $('[data-slider-el="container"] .like-count data.num');
            var currentImageLikeCount =  $('[data-slider-el="container"] .like-count data.num').val();

            if(response.status === 'Liked'){

                /** Update the image like status */
                $('#inspiration-images img').eq(currentSlideData.currentSlideIndex).attr('data-liked-status', 'liked');

                currentImageLikeCount++;
                currentImageLikeCountEl.val(currentImageLikeCount);
                currentImageLikeCountEl.text(currentImageLikeCount);

                $thisLikeBox.addClass('liked').html('<i class="fa fa-thumbs-up" aria-hidden="true"></i> Like');
            }else if(response.status === 'unliked'){

                currentImageLikeCount--;
                currentImageLikeCountEl.val(currentImageLikeCount);
                currentImageLikeCountEl.text(currentImageLikeCount);
                $thisLikeBox.removeClass('liked').html('<i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Like');
            }
        },'json');
    });

    /** The function that gets the current slides filename and folder name. */
    function getCurrentSlideData()
    {
        /** Get the index position of the current slide. */
        var dataId = $('.slick-current').attr("data-slick-index");

        /** Get the current image path */
        var currentImagePath = $('#inspiration-images img').eq(dataId).next().attr('src');

        /** Get the file name of the current image. */
        var fileNameIndex = currentImagePath.lastIndexOf("/") + 1;
        var filename = currentImagePath.substr(fileNameIndex);


        /** Search if image is in the "self-help" folder */
        var is_self_help_folder = currentImagePath.search(/self-help/i);

        /** Search if image is in the "quotes" folder */
        var is_quotes_folder = currentImagePath.search(/quotes/i);

        var current_img_folder;

        /** if is in the "self-help" folder */
        if(is_self_help_folder > 0){
            current_img_folder =   'self-help';
        }else if(is_quotes_folder > 0){
            current_img_folder = 'quotes';
        }

        var currentPathInfo = {
            folder : current_img_folder,
            filename : filename,
            fullFilePath : currentImagePath,
            currentSlideIndex : dataId + 1
        };
       return currentPathInfo;
    }


    /** Get Comments */
    $('#inspiration-container [data-comment-btn="show"]').on('click', function () {

        /** The current index position of the active slide */
        var dataId = $(imageContainerId).slick("slickCurrentSlide");

        /** Get the current image path */
        var currentImagePath = $('#inspiration-images img').eq(dataId).next().attr('src');

        /** Get the file name of the current image. */
        var fileNameIndex = currentImagePath.lastIndexOf("/") + 1;
        var filename = currentImagePath.substr(fileNameIndex);


        /** Search if image is in the "self-help" folder */
        var is_self_help_folder = currentImagePath.search(/self-help/i);

        /** Search if image is in the "quotes" folder */
        var is_quotes_folder = currentImagePath.search(/quotes/i);

        var current_img_folder;

        /** if is in the "self-help" folder */
        if(is_self_help_folder > 0){
            current_img_folder =   'self-help';
        }else if(is_quotes_folder > 0){
            current_img_folder = 'quotes';
        }

        var $this = $(this);
        /** Get Comments for the inspiration post if the box is collapsed. */
        if($this.hasClass('collapsed')){
            var ajaxData = {
                form :'Get Inspiration Comments',
                folder : current_img_folder,
                filename : filename
            };
            $.post(RELATIVE_PATH + '/config/processing.php', ajaxData,function (response) {
                console.log(response);
                if(response.status === 'Has comments'){
                    $.each(response.data, function(index, data) {
                        $('#inspiration-container [ data-inspiration="comment fill"]').append(buildInspirationComment(data.userImage,data.username,data.comment,data.created_date,data.profileLink,data.userId,data.Id,data.likedPosts,data.totalLikes,data.loggedIn));
                    });
                    $('time.human-time').timeago();
                }
                /** Show comments */
                $('#inspiration-container [data-slider-el="container"]').slideDown(700).addClass('in');

                $this.removeClass('collapsed');
            },'json');


        }else {
            $('#inspiration-container [data-slider-el="container"]').slideUp(700,function () {
                $('#inspiration-container [ data-inspiration="comment fill"]').html('');
                $this.removeClass('in').addClass('collapsed');
            });

        }

    });

    /** Process comment inputs */
    $('body').on('keyup','#inspiration-container .comment-box textarea',function(e){
        /** The current index position of the active slide */
        var dataId = $(imageContainerId).slick("slickCurrentSlide");

        /** Get the current image path */
        var currentImagePath = $('#inspiration-images img').eq(dataId).next().attr('src');

        /** Get the file name of the current image. */
        var fileNameIndex = currentImagePath.lastIndexOf("/") + 1;
        var filename = currentImagePath.substr(fileNameIndex);


        /** Search if image is in the "self-help" folder */
        var is_self_help_folder = currentImagePath.search(/self-help/i);

        /** Search if image is in the "quotes" folder */
        var is_quotes_folder = currentImagePath.search(/quotes/i);

        var current_img_folder;

        /** if is in the "self-help" folder */
        if(is_self_help_folder > 0){
            current_img_folder =   'self-help';
        }else if(is_quotes_folder > 0){
            current_img_folder = 'quotes';
        }

        if(e.which === 13) {
            var $this = $(this);
            var inputText = $this.val();
            var ajaxData = {
                form :'Set Inspiration Comment',
                folder : current_img_folder,
                filename : filename,
                imagePath : currentImagePath,
                comment : inputText
            };

            $.post(RELATIVE_PATH + '/config/processing.php', ajaxData,function (response) {
                console.log(response.data);
                if(response.status === 'Stored'){
                    $this.val('').removeAttr('style');
                    $('#inspiration-container [ data-inspiration="comment fill"]').append(buildInspirationComment(response.data.userImage,response.data.username,response.data.comment,response.data.created_date,response.data.profileLink,response.data.userId,response.data.Id,response.data.loggedIn));
                    $('time.human-time').timeago();
                }
            },'json');
        }
    });

    function buildInspirationComment(userProfileImage,username,comment,created_date,profileLink,userId,Id,likedPost,totalLikes,loggedIn) {

        /** Set the liked values for liked text and class name */
        var likeValue,likeClass;
        if(likedPost === true){
            likeValue = 'Liked';
            likeClass  = 'liked';
        }else{
            likeValue = 'Like';
            likeClass  = '';
        }
        var likeData = '';
        if(loggedIn === true){
            likeData = '<a class="like-btn '+likeValue+'" role="button" data-bound-post-like="btn" data-post-user-id="'+userId+'" data-post-id="'+Id+'" data-post-type="6">'+likeValue+'</a>\n' +
            '                    <i class="fa fa-circle first-circle" aria-hidden="true"></i>\n';
        }else{
            likeData = '<a class="like-btn">Likes</a>\n' +
                '                    <i class="fa fa-circle first-circle" aria-hidden="true"></i>\n';
        }

        var html = '<div class="table inspiration-post">\n' +
            '    <div data-slider-el="comments">\n' +
            '        <div class="cell user-img">\n' +
            '            <img '+ profileLink +' src="/'+ userProfileImage +'" class="img-circle profile-img sm ">\n' +
            '        </div>\n' +
            '        <div class="cell">\n' +
            '            <div class="post-content-box">\n' +
            '\n' +
            '                <div '+ profileLink +' class="user-name">\n' +
            '                    '+ username +
            '                </div>\n' +
            '                <div class="asked-about-user">\n' +
            '                    - ' +
            '                </div>\n' +
            '                <div class="post-text-box">\n' +
            '                    <span>'+comment+'</span>\n' +
            '                </div>\n' +
            '                <div class="post-like-count-box">\n' +
            likeData +
            '                    <data data-like-post-count-updater="bind" value="0" class="num">0</data>\n' +
            '                    <i class="fa fa-circle second-circle" aria-hidden="true"></i>\n' +
            '                     <time itemprop="dateCreated"  class="human-time date" datetime="'+created_date+'">'+created_date+'</time>\n' +
            '                </div>\n' +
            '            </div>\n' +
            '        </div>\n' +
            '    </div>\n' +
            '</div> ';

        return html;
    }

    /** Image Filter */

    var dropMenuId = '#inspiration-filter';

    $(dropMenuId + ' li').on('click',function () {
        var $thisMenuBtn = $(this);
        var $thisBtnValue = $thisMenuBtn.data('filter-value');

        /** Hold slider height during transition. */
        var holdImgBox = $('#inspiration-images-outside');
        var holdImgBoxHeight = holdImgBox.outerHeight();

        holdImgBox.css({'height' : holdImgBoxHeight + 'px'});


        /** Unset and remove previous images before new images from filter are uploaded. */
        $(imageContainerId).slick('unslick'); /* ONLY remove the classes and handlers added on initialize */
        $(imageContainerId + ' img').remove(); /* Remove current slides elements, in case that you want to show new slides. */

        $.get(RELATIVE_PATH + '/site/cwd/views/includes/inspirations/get-images.php',{imgFilter : $thisBtnValue},function (response) {
            $('#inspiration-images').html(response);
            $(document).ajaxComplete(function(){
                $(imageContainerId).slick(getSliderSettings()); /* Initialize the slick again */

                holdImgBox.css({'height' :  'auto'});
            });
        },'html');

    });

    /** The settings for the slider */
    function getSliderSettings()
    {
        return {
            dots: false,
            infinite: true,
            speed: 300,
            slidesToScroll: 1,
            autoplay: false,
            autoplaySpeed: 4000,
            slidesToShow: 1,
            adaptiveHeight: true,
            nextArrow: $('.inspiration-box .prev'),
            prevArrow: $('.inspiration-box .next')
        };
    }

}
