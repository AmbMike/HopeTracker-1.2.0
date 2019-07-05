/**
 * File For: HopeTracker.com
 * File Name: .
 * Author: Mike Giammattei
 * Created On: 3/16/2017, 5:40 PM
 */

/* Browser Detection */
var browser = function() {
    // Return cached result if avalible, else get result then cache it.
    if (browser.prototype._cachedResult)
        return browser.prototype._cachedResult;

    // Opera 8.0+
    var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;

    // Firefox 1.0+
    var isFirefox = typeof InstallTrigger !== 'undefined';

    // Safari 3.0+ "[object HTMLElementConstructor]"
    var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || safari.pushNotification);

    // Internet Explorer 6-11
    var isIE = /*@cc_on!@*/false || !!document.documentMode;

    // Edge 20+
    var isEdge = !isIE && !!window.StyleMedia;

    // Chrome 1+
    var isChrome = !!window.chrome && !!window.chrome.webstore;

    // Blink engine detection
    var isBlink = (isChrome || isOpera) && !!window.CSS;

    return browser.prototype._cachedResult =
        isOpera ? 'Opera' :
            isFirefox ? 'Firefox' :
                isSafari ? 'Safari' :
                    isChrome ? 'Chrome' :
                        isIE ? 'IE' :
                            isEdge ? 'Edge' :
                                "Don't know";
};
/* Sticky sidebar

 if(browser() == "Chrome"){
 var resizeTimer;
 $(window).on('resize', function(e) {
 clearTimeout(resizeTimer);
 resizeTimer = setTimeout(function() {
 if($('.sidebar').length > 0){
 mg_sticky_sidebar('.sidebar');
 }
 }, 250);

 });
 $(document).ready(function () {
 if($('.sidebar').length > 0) {
 mg_sticky_sidebar('.sidebar');
 }
 });
 }else {
 if($('.sidebar').length > 0) {
 $("#sidebar").stick_in_parent({});
 }
 }
 */
/* Signup Cropping */
$(document).ready(function () {
    sign_up_crop();
    function sign_up_crop() {
        var
            modal =  $('#cropContainerModal'),

            crop = {
                el : modal,
                pre_img :  $('.pre-profile'),
                start_width :     modal.width(),
                start_height :    modal.height(),
                remove_btn     : '.cropControlRemoveCroppedImage'
            };

        /* Reset box height if re-clicked upload button */
        $('#imgCrop').on('click',function () {
            crop.el.css({'width' : crop.start_width + 'px', 'height' : crop.start_height + 'px'});
        });
        crop.el.css({'display' : 'none'});
        $('body').on('click',crop.remove_btn,function () {
            crop.el.fadeOut(600,function () {
                crop.el.css({'width' : crop.start_width + 'px', 'height' : crop.start_height + 'px'});
                crop.pre_img.fadeIn(600);
                $('#upload-btn-box').fadeIn(600);
            });
        });



        var croppicContainerModalOptions = {
            uploadUrl: '/hopetracker/img_save_to_file.php',
            cropUrl: '/hopetracker/img_crop_to_file.php',
            outputUrlId: 'imgPath',
            modal:true,
            onReset: function(){
                crop.el.fadeOut(600,function () {
                    crop.el.css({'width' : crop.start_width + 'px', 'height' : crop.start_height + 'px'});
                    crop.pre_img.fadeIn(600);
                });
            },
            imgEyecandyOpacity:0.4,
            loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
            customUploadButtonId:'imgCrop',
            onAfterImgCrop:		function(){
                $('.pre-profile,#upload-btn-box').css({'display' : 'none'});
                crop.el.fadeIn(600).css({'width' : '93px', 'height' : '89px'});
            },
            onError:function(errormessage){}
        }
        var cropContainerModal = new Croppic('cropContainerModal', croppicContainerModalOptions);
    }

    /* Nave Form Menu */
    nav_form();
    function nav_form() {
        var obj = {
            btn: $('[data-btn="home-sign-in"]'),
            el : $('#form-one'),
            img : $('#form-one .form-img '),
            cover : $('.overlay'),
            close_btn : $('#form-one .close-btn')
        };
        var form_height = obj.el.outerHeight();

        obj.img.css({'display' : 'none'});
        obj.el.css({'display' : 'none'});

        if($('.footer-form-btn').length > 0){
            if($(window).outerWidth() < 767 ){
                $('.footer-form-btn').on('click',function () {
                    $('.mobile-nav-box').toggleClass('on');
                    $('.nav-box nav > ul').stop().slideToggle(500);
                    $('.overlay').fadeToggle(500);
                });
            }
        }

        /** Clicked Sign Up Btn Action */
        obj.btn.on('click',function () {

            if($(this).data('show-notification')){
                $('[data-signup-notifcation="1"]').slideDown(400);
            }
            /** Set the page's position on click. */
            window.pagedClickedPosition = $(document).scrollTop();

            /** Add active class to menu button */
            $('.menu-btn').addClass('sign-up-form');

            /** Scroll the page to the top */
            $('html, body').animate({
                scrollTop: 0
            }, 1000);

            /** Processed action if click button does not have an an ".on" class */
            if(!$(this).hasClass('on')){
                obj.btn.addClass('on');

                /** Action for mobile */
                if($(window).width() < 768){

                    $('.mobile-nav-box').addClass('on');
                    $('.nav-box nav > ul').slideDown(500);
                    $('nav').addClass('on');
                }

                obj.cover.fadeIn(300);
                obj.el.stop().slideDown(500,function () {
                    setTimeout(function () {
                        obj.img.fadeIn(500);
                    },100);
                });
            }
        });

        obj.close_btn.add(obj.cover).on('click',function () {
            $('nav').removeClass('on');
            $('.menu-btn').removeClass('on');
            $('[data-signup-notifcation="1"]').slideUp(400);
            obj.img.fadeOut(200);
            obj.el.stop().slideUp(300,function () {
                obj.cover.fadeOut(300);
                obj.btn.removeClass('on');
                if(('.close-btn-help').length > 0) {
                    $('.form-btn').removeClass('on');
                }
                $('.mobile-nav-box.on').removeClass('on');
                if($(window).outerWidth() < 768){
                    $('.nav-box nav > ul').stop().slideUp(500);
                }

                /** Scroll page back to position when user clicked button. */
                $('html, body').animate({
                    scrollTop:  pagedClickedPosition
                }, 1000);
            });
        });

    }
});

/* General Functions */
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

/* Screen Load */
$(document).ready(function() {
    if($('[data-show-page-loader]').data('show-page-loader') === 'Yes'){
        screen_loader();
    }
});
function screen_loader() {
    'use strict';
    var string =   '   <div id="loader-wrapper"> '  +
        '       <div id="loader"></div>'  +
        '       <div class="loader-section section-left"></div>  '  +
        '       <div class="loader-section section-right"></div>  '  +
        '  </div>  ' ;

    $('head').append('<link href="'+ RELATIVE_PATH +'/widgets/loader/style.css" type="text/css" rel="stylesheet" />');
    $('body').append(string);

    setTimeout(function(){
        $('#loader-wrapper').remove();
        $('body').addClass('loaded');

        /** Run intro if courses page has not been viewed by user yet */
        if($('#courses').length > 0 && $('#courses').attr('data-show-intro') === 'yes') {
            setTimeout(function () {
                course_intro();
            }, 750);
        }
    }, 400);
}

/** IntroJS for course Page */
function course_intro() {
    if(window.location.pathname === '/protected/course/' && $('.logged-in').length > 0){
        $.getJSON("/site/public/json-data/course-intro-text/text.json", function(data) {
            introJs().addSteps([{
                element: document.querySelectorAll('#step1')[0],
                intro: data['step 1'],
                position: 'top'
            },{  element: document.querySelectorAll('#step2')[0],
                intro: data['step 2'],
                position: 'top'
            },{  element: document.querySelectorAll('#step3')[0],
                intro: data['step 3'],
                position: 'top'
            },{  element: document.querySelectorAll('#step4')[0],
                intro: data['step 4'],
                position: 'top'
            },{  element: document.querySelectorAll('#courses #step5')[0],
                intro: data['step 5'],
                position: 'top'
            },{  element: document.querySelectorAll('#courses #inspiration-box')[0],
                intro: data['step 61'],
                position: 'top'
            }]).setOption(
                'showBullets', false,
                'scrollPadding', 400
            ).start().onbeforeexit(function() {

                /** Adjust divs to allow for show more link btn */
                $('#step3 a').addClass('pull-right');

                var replace_show_more_link = $('#step3').html();
                $( "#step3" ).replaceWith(replace_show_more_link);
                $( "#step3" ).replaceWith(replace_show_more_link);

                /** Set the course page as viewed in the database to only show intro once  */
                $.post(RELATIVE_PATH + '/config/processing.php',{form : 'Course Intro Marked Viewed'},function (data) {


                });
            });

        });

    }
}


equalheight = function(container){
    var currentTallest = 0,
        currentRowStart = 0,
        rowDivs = new Array(),
        $el,
        topPosition = 0;
    $(container).each(function() {
        $el = $(this);
        $($el).height('auto')
        topPostion = $el.position().top;

        if (currentRowStart != topPostion) {
            for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
                rowDivs[currentDiv].height(currentTallest);
            }
            rowDivs.length = 0; // empty the array
            currentRowStart = topPostion;
            currentTallest = $el.height();
            rowDivs.push($el);
        } else {
            rowDivs.push($el);
            currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
        }
        for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
            rowDivs[currentDiv].height(currentTallest);
        }
    });
};

equalWidth = function(container){
    var currentTallest = 0,
        currentRowStart = 0,
        rowDivs = new Array(),
        $el,
        topPosition = 0;
    $(container).each(function() {
        $el = $(this);
        $($el).width('auto')
        topPostion = $el.position().top;

        if (currentRowStart !== topPostion) {
            for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
                rowDivs[currentDiv].width(currentTallest);
            }
            rowDivs.length = 0; // empty the array
            currentRowStart = topPostion;
            currentTallest = $el.width();
            rowDivs.push($el);
        } else {
            rowDivs.push($el);
            currentTallest = (currentTallest < $el.width()) ? ($el.width()) : (currentTallest);
        }
        for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
            rowDivs[currentDiv].width(currentTallest);
        }
    });
};

/** Equal Height for the homepage FAQs */
equalheight('.faq-divider dt');
/** END ### Equal Height for the homepage FAQs */


/* Show more live user in chat sidebar */


/* Updated Users Logged in Status */
$(document).ready(function () {

    /** Format time globally */
    $('time.human-time').timeago();

   /* if($('#user-logger').length > 0) {
        $.ajax({
            url: RELATIVE_PATH + '/config/processing.php',
            cache : false,
            type: 'POST',
            data: {
                form: 'Update User Online Status'
            },
            success: function (response) {
                if (response === 'Logged Out User') {
                    setTimeout(function () {
                        location.href = '/home';
                        $('#user-logger').remove();
                        response = '';
                    },1000);

                }
            }

        });
    }*/
});

/*$( function() {
    $( "#chatWidget" ).draggable({
        containment: "window", scroll: false,
        cancel: "#chatWidget .panel-primary",
        axis : "x"

    });
} );*/

/* Load chat.js and chat functions */
/*$.getScript("/chatroom/chat.js", function(){

       /!* Create Chat Box If User Is In Chatroom *!/
    if($('#chatWidget').length === 0){

        var loop_chat_box = setInterval(build_user_chat_box,5000);

        function build_user_chat_box() {
            if($('#chatWidget').length === 0) {
                $('#load-chat-box').load(location.href + " #chat-box-main",function () {
                    instanse = false;
                    updateChat();
                });
            }else{
                clearInterval(loop_chat_box);
                setInterval(updateChat,1000);
            }
        }
    }

    window.chat_interval =setInterval(updateChat,1000);

    // ask user for name with popup prompt
    var name = 'Create Name';

    // kick off chat
    var chat =  new Chat();
    $(function() {

        chat.getState();
        // watch textarea for release of key press
        $(document).on('keyup', '#btn-input', function (event) {
            var key = event.which;
            if(key == 13){

                if($('.moderator-offline').length > 0){
                    upload_chat_email();
                }
                send_msg();
            }
        });

        $(document).on('click','#btn-chat', function(e) {
            send_msg();
            window.send_msg = send_msg();
        });
        /!* Close chat box confirmation *!/
        $('body').on('click','.chat-box-close button', function () {
            var button_type = $(this).data('btn-value');
            if(button_type === 'ok'){
                $('#btn-input').val("I have left the chat");
                send_msg();
                $('#load-chat-box').css({'display': 'none'});
                setTimeout(function () {
                    $('#load-chat-box').css({'display': 'block'});
                },1500);

                setTimeout(function () {
                    $.post(RELATIVE_PATH + '/config/processing.php',  {
                            form: "Delete Chatroom",
                            chat_token: $('#chat-box-main').data('chatroom'),
                            chat_requested_id: $('#chat-box-main').data('chat-request-id')
                        },
                        function(data, status){
                            $('#chat-box-main').remove();
                            var loop_chat_box = setInterval(build_user_chat_box,5000);
                            function build_user_chat_box() {
                                if($('#chatWidget').length === 0) {
                                    $('#load-chat-box').load(location.href + " #chat-box-main",function () {
                                        instanse = false;
                                        updateChat();
                                        //location.reload();
                                    });
                                }else{
                                    clearInterval(loop_chat_box);
                                    setInterval(updateChat,1000);
                                }
                            }
                        }
                    );
                },1000);
            }
        });
        function send_msg() {
            var text = $('#btn-input').val();
            var maxLength = $('#btn-input').attr("maxlength");
            var length = text.length;
            // send
            if (length <= maxLength + 1 && length !== 0) {
                chat.send(text, name);
                $('#btn-input').val("");

            } else {
                $('#btn-input').val(text.substring(0, maxLength));

            }
        }
    });

});*/

/* Upload Email for offline Moderator */
/*$('body').on('click','.moderator-offline',function () {
    upload_chat_email();
});
function upload_chat_email() {
    $.ajax({
        url : '/config/processing.php',
        type : 'POST',
        data : {
            form : 'Chat Email Upload',
            data : {
                message : $('#btn-input').val(),
                receiver_id : $('#chat-box-main').data('chat-request-id')
            }
        },
        //dataType : 'json',
        success : function (response) {

        }

    });
}*/

/* Chat request notification */
/*if($('nav > ul').hasClass('logged-in')){
    setInterval(chat_request_notification,5000);
}*/
function chat_request_notification() {
    if($('.chat-notify').length > 0) {
        var chat_notify = $('.chat-notify');
        $.ajax({
            type: 'POST',
            url: RELATIVE_PATH + '/config/processing.php',
            data: {
                form: 'Chat Request Notification',
                return_type: 'json'
            },
            dataType: 'json',
            success: function (response) {
                update_notifications(response);
            }
        });

        function update_notifications(response) {

            var chat_notify_length = chat_notify.length;

            if(response.length > chat_notify_length){
                $('#chat-notify-con').load(location.href+ " #chat-notify-con",function () {
                    $('.chat-notify').css({'opacity' : '1'});
                });

            }
        }
    }else{
        $('#refresh-notify').load(location.href+ " #refresh-notify",function () {chat_notifications();
            //$('.chat-notify').css({'opacity' : '1'});
        });
    }
}


/* Request Chat With Online User */
//chat_request();
function chat_request() {
    $('body').on('click', '#sidebar .chat-link-ACTION',function (e) {
        e.preventDefault();
        var
            $this  = $(this),
            $this_id = $this.attr('id'),
            $requested_user_id = $this.data('requested-user-id');
        ;
        /* If user is logged in */
        if($this.hasClass('green') && $requested_user_id !== ''){
            var btn_container_id = $this.parent().parent().attr('id');
            var btn_parent_id = $this.parent().attr('id');
            var this_id = $this.attr('id');

            $('#'+$this_id).text('Processing...');
            $.ajax({
                type : 'POST',
                url : '/config/processing.php',
                data : {
                    form : 'Request Chat',
                    requested_user_id : $requested_user_id
                },
                dataType : 'json',
                success : function (response) {
                    if(response.status === 'Moderator Offline'){
                        $('#'+this_id).text('Offline');
                    }else{
                        /* Reload button for status update */
                        $('#'+btn_container_id).load(location.href+ ' #'+btn_parent_id,function () {
                            if(response === "User is Busy"){
                                $('#'+this_id).text('User is Chatting');
                            }
                        });
                        $('#'+$this_id).removeClass('green');
                    }
                }
            });
        }else if($('.logged-in').length === 0){
            /* If user is not logged in, alert message to login or join */
            if($('#no-chat-alert').length === 0){
                /*var chat_alert_box_id = 'no-chat-alert';

                $(this).parent().append("<div style='display: none;' id="+ chat_alert_box_id +" class='custom-tooltip alert alert-danger'>You must be signed in for this feature. If you don\'t have an account, you can create one for free. </div>");
                $('#'+chat_alert_box_id).slideDown(600);
                setTimeout(function () {
                    $('#'+chat_alert_box_id).slideUp(600,function () {
                        $('#'+chat_alert_box_id).remove();
                    });
                },3000);*/
            }
        }

    });
}
/* Chat Notifications */
//chat_notifications();
function chat_notifications(){
    if($('.chat-notify').length > 0){

        /* Show Notifications */
        var speed = 1000;
        var timer = setInterval(animate_notifications, speed);
        var notifications =  $('.chat-notify');
        var length = notifications.length;
        var index = 0;

        function animate_notifications() {
            notifications.eq(index).addClass('bounceInRight');

            index++;

            // remove timer after integrating through all notifications
            if (index >= length) {
                clearInterval(timer);
            }
        }

        /* Close Animations */
        $('body').on('click','.chat-notify .close',function () {
            $(this).closest('.chat-notify').addClass('bounceOutRight');
            $(this).closest('.chat-notify').removeAttr('style');

        });
    }

}
/* Accept Chat Request */
//accept_chat_request();
function accept_chat_request(){

    $('body').on('click','.chat-notify .btn',function (e) {

        /* If user is logged in, grant access to request chat */
        if($('.logged-in').length > 0){
            e.preventDefault();
            var $this = $(this);
            var btn_type =  $this.data('btn');
            var requested_users_id =  $this.parent().data('requested-users-id');
            var requested_id =  $this.parent().data('request-id');
            $this.text('Processing...');
            $.ajax({
                type : 'POST',
                cache : false,
                url : '/config/processing.php',
                data : {
                    form : 'Request Chat Action',
                    btn_type : btn_type,
                    request_users_id : requested_users_id,
                    request_id : requested_id
                },

                success : function (response) {
                    //window.open("http://hopetracker.com/chat-mods/chat-box/", "", "width=300,height=350");
                    $this.closest('.chat-notify').remove();
                }
            });
        }

    });
}

/* Minimize Chat Window */
//minimize_chat_window();
function minimize_chat_window(){
    $('body').on('click','#chatWidget .menu',function () {
        $('#chatWidget .panel-primary').slideToggle(700)
    });
}


/* Close Chat Box Modal */
$('body').on('click','#chatWidget .close',function () {
    $('#confirm-modal').addClass('chat-box-close');
    $("#confirm-modal.chat-box-close .modal-body").text('Are you sure you would like to close the chat box');
});


/* Validator for the settings form */
$(document).ready(function() {

    $('input[name="current_pass"]').on('click', function () {
        if( $('.updated-pass').length > 0) {
            $('.updated-pass').remove();
        }
    });
    if($('.crop-img-btn').length > 0){

        /*$('#img-crop-btn').on('click',function () {*/
        var
            modal =  $('#settings-croppic'),
            crop = {
                el : modal,
                pre_img :  $('.pre-profile'),
                start_width :     400,
                start_height :    400,
                remove_btn     : '.cropControlRemoveCroppedImage'
            };
        crop.el.css({'display' : 'none'});

        /* Reset box height if re-clicked upload button */
        $('#img-crop-btn').on('click',function () {
            crop.el.css({'width' : crop.start_width + 'px', 'height' : crop.start_height + 'px'});
        });

        var croppicContainerModalOptions = {
            uploadUrl:'/hopetracker/img_save_to_file.php',
            cropUrl:'/hopetracker/img_crop_to_file.php',
            outputUrlId: 'imgPath',
            modal:true,
            onReset: function(){
                crop.el.fadeOut(600,function () {
                    crop.el.css({'width' : crop.start_width + 'px', 'height' : crop.start_height + 'px'});
                    crop.pre_img.fadeIn(600);
                });
            },
            imgEyecandyOpacity:0.4,
            loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
            customUploadButtonId:'img-crop-btn',
            onAfterImgCrop:		function(){
                var image_path = $('.croppedImg').attr('src');

                $('.cropControlRemoveCroppedImage').remove();

                if($('header .logged-in').length > 0){
                    var userId = $('header .logged-in').data('loggedin-user-id');

                    $('.profile-img').each(function () {
                        var $thisImg = $(this);

                        if ($thisImg.attr('src').indexOf('/user-' + userId + '/') > -1) {
                            $thisImg.attr('src',image_path);
                        }
                    });
                }
                $('.pre-profile').css({'display' : 'none'});
                $('.croppedImg').addClass('img-responsive').addClass('img-circle').addClass('green-border').addClass('pre-profile');
                crop.el.fadeIn(600).css({'width' : '100%', 'height' : 'auto'});
            },
            onError:function(errormessage){ }
        };
        var settings_croppic = new Croppic('settings-croppic', croppicContainerModalOptions);


        /* });*/
    }
    $('#settings-form').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        button: {
            selector: '#i360-server-form-submit',
            disabled: 'disabled'
        },
        fields: {
            fname: {
                message: 'The first name is not valid',
                validators: {
                    notEmpty: {
                        message: 'The first name is required'
                    },
                    stringLength: {
                        min: 2,
                        max: 30,
                        message: 'The first name must be more than 2 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_]+$/,
                        message: 'The first name can only consist of alphabetical, number and underscore'
                    }
                }
            },
            lname: {
                message: 'The last name is not valid',
                validators: {
                    notEmpty: {
                        message: 'The last name is required'
                    },
                    stringLength: {
                        min: 2,
                        max: 30,
                        message: 'The last name must be more than 2 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_]+$/,
                        message: 'The last name can only consist of alphabetical, number and underscore'
                    }
                }
            },
            current_pass:{
                trigger : 'blur',
                validators: {
                    // The validator will create an Ajax request
                    // sending { username: 'its value' } to the back-end
                    remote: {
                        message: 'Password Incorrect',
                        url: RELATIVE_PATH + '/config/processing.php',
                        type: 'POST',
                        cache: false,
                        data : {
                            form : 'Password Check'
                        }
                    }
                }
            },
            password: {
                trigger : 'blur',
                /* Validate add new password only if the user enters a current password. */
                validators: {
                    callback: {
                        message: 'Enter new password',
                        callback: function(value, validator, $field) {
                            var channel = $('#settings-form').find('[name="current_pass"]').val();
                            return (channel === '') ? true : (value !== '');
                        }
                    }
                }
            },
            confirmPassword: {
                trigger : 'keyup',
                validators: {
                    /* Validate if password field is not empty */
                    callback: {
                        message : "Confirm password",
                        callback: function(value, validator, $field) {
                            var password = $('#settings-form').find('[name="password"]').val();
                            return (password === '') ? true : (value !== '');
                        }
                    },
                    identical: {
                        field: 'password',
                        message: 'The password and its confirm are not the same'
                    }
                }
            }
        }
        /* Initialize the new password validation if the user fill in the current password field */
    }).on('change', '[name="current_pass"]', function(e) {
        $('#settings-form').bootstrapValidator('revalidateField', 'password');
    }).on('success.field.bv', function(e, data) {
        if (data.field === 'password') {
            var channel = $('#settings-form').find('[name="current_pass"]').val();
            // User choose given channel
            if (channel === '') {
                // Remove the success class from the container
                data.element.closest('.form-group').removeClass('has-success');
            }
        }
        /* Initialize validation on the confirm password if the password field is filled in */
    }).on('change', '[name="password"]', function(e) {
        $('#settings-form').bootstrapValidator('revalidateField', 'confirmPassword');
    }).on('success.field.bv', function(e, data) {
        if (data.field === 'confirmPassword') {
            var password = $('#settings-form').find('[name="password"]').val();
            // User choose given channel
            if (password === '') {
                // Remove the success class from the container
                data.element.closest('.form-group').removeClass('has-success');
            }
        }
    }).on('success.form.bv',function(e){
        e.preventDefault();
        var cropped_img = $('.croppedImg').attr('src');
        $('#img-path').val(cropped_img);
        var post_data = $(this).serialize();
        var alert_box = $('#settings-form .alert-box');

        alert_box.on('click',function () {
            $(this).slideUp();
            return;
        });

        $.ajax({
            type: 'POST',
            url: RELATIVE_PATH + '/config/processing.php',
            cache : false,
            data: {
                form : 'Update User Settings',
                data : post_data
            },
            dataType : 'json',
        }).done(function(result){
console.log(result);
            if(result.updated === true){
                alert_box.slideDown();

                return;
            }
            if(result.password_updated === true){
                var el_color = $('.green-heading-lg').css('color');
                $('input[name="current_pass"]').before("<span class='updated-pass' style='color :"+el_color+"; display: block; font-size: 14px;'>Password Updated!</span>");
                $('input[name="current_pass"]').val('');
                $('input[name="password"]').val('');
                $('input[name="confirmPassword"]').val('');
                return;
            }else{
                $('.updated-pass').remove();
            }
        });
    });
});

/* Close alert-box */
$('body').on('click','.alert-box',function () {
    $(this).slideToggle(600);
});
/* Settings Page */
if($('#settings-feedback-form').length > 0){
    settings_form();
    function settings_form() {
        var form_id = '#settings-feedback-form';
        var alert_box = $(form_id + ' .alert-box');

        $(form_id).bootstrapValidator({
            message: 'This value is not valid',
            fields: {

            }
            /* Initialize the new password validation if the user fill in the current password field */
        }).on('success.form.bv',function(e){
            e.preventDefault();

            var post_data = $(this).serialize();
            alert_box.slideUp(600);

            $.ajax({
                type: 'POST',
                cache: false,
                url: RELATIVE_PATH + '/config/processing.php',
                data: {
                    form : 'Settings Feedback',
                    data : post_data
                },
                dataType : 'json'
            }).done(function(response){
                if(response.sent === 'Success'){
                    $(form_id).bootstrapValidator('resetForm', true);
                    $(form_id).trigger('reset');
                    alert_box.slideDown(600);
                }
            });
            $(form_id).bootstrapValidator('resetForm', true);
        });
    }

}

/* Inspiration Page */
$(document).ready(function () {
    inspiration_page();

});

function inspiration_page() {
    var slider_id = '#inspiration-page-box';

    var $status = $('.pagingInfo');
    var $slickElement = $('#inspiration-page-box .slider');

    $slickElement.on('init reInit afterChange', function(event, slick, currentSlide, nextSlide){
        //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
        var i = (currentSlide ? currentSlide : 0) + 1;
        $status.html('<span class="current-slide">' + i + '</span>/' + slick.slideCount);

    });
    $slickElement.slick({
        arrows: true,
        nextArrow: '<i class="fa right fa-angle-double-right"></i>',
        prevArrow: '<i class="fa left fa-angle-double-left"></i>',
        autoplay: true,
        autoplaySpeed: 5000,
        lazyLoad: 'progressive',
    });

}
save_inspiration();
function save_inspiration() {

    $('body').on('click','[data-btn="save-inspiration"]',function () {
        var
            $this = $(this),
            status = 'Save',
            image_id = $(this).data('img-id');
        ;
        if($this.hasClass('star')){
            status = 'Un-save'
        }

        $.ajax({
            url  : '/config/processing.php',
            type : 'POST',
            cache: false,
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

                    $this.replaceWith('<i data-img-id="'+ image_id +'" data-btn="save-inspiration" class="fa fa-star blue-color" aria-hidden="true"></i>');
                }else if(response.status === 'Unsaved'){
                    $this.replaceWith('<button data-img-id="'+ image_id +'" data-btn="save-inspiration" class="save-btn gray md blue-color">Save</button>');
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
/* Filter Menu */
inspiration_filter();
function inspiration_filter() {
    /* Slider Filters */
    $('#inspiration-filter a').on('click', function (e) {
        e.preventDefault();

        var $this = $(this),
            load_inspiration_path = '/ajax-loads/inspiration-all.php';

        var $status = $('.pagingInfo');
        var $slickElement = $('#inspiration-page-box .slider');

        $('.slider-outer .loading').css({'opacity' : '1'});

        /* Set Height On Slider */
        if($('#no-inspiration-images').length < 1){
            $('.slider-outer').css({'height' : $slickElement.outerHeight() + 'px'});
        }

        $('#filter-label').text($this.text());

        $slickElement.removeClass("slick-initialized slick-slider");
        $slickElement.animate({'opacity' : '0'},700,function () {

            //$slickElement.slick("unslick");

            /* Check what inspirations to pull */
            if($this.text() === 'Saved'){
                load_inspiration_path = '/ajax-loads/saved-inspirations.php?page_val=saved';
                $this.text('Show All');
            }else if($this.text() === 'Show All'){
                load_inspiration_path = '/ajax-loads/inspiration-all.php';
                $this.text('Saved');
            }else if($this.text() === 'Random'){
                load_inspiration_path = '/ajax-loads/saved-inspirations.php?page_val=random';
            }else if($this.text() === 'Most Shared'){
                load_inspiration_path = '/ajax-loads/saved-inspirations.php?page_val=most_shared';
            }

            $.ajax({
                url : load_inspiration_path,
                type : 'POST',
                cache : false,
                dataType : 'html',
                success : function (response) {
                    $('.slider-outer .loading').css({'opacity' : '0'});
                    $slickElement.html(response).promise().done(function(){
                        $slickElement.slick({
                            arrows: true,
                            nextArrow: '<i class="fa right fa-angle-double-right"></i>',
                            prevArrow: '<i class="fa left fa-angle-double-left"></i>',
                            autoplay: true,
                            autoplaySpeed: 5000,
                            lazyLoad: 'progressive'
                        });

                    });
                    setTimeout(function () {
                        $slickElement.animate({'opacity': '1'}, 500);
                    },500);

                }
            });
        });

    });

    /* Share Icons */
    $('body').on('click','.share-box-slider .share-icon',function () {
        var $this = $(this);

        /* Update Save Count On Screen */
        var count_update = $this.parent().find('.white-box span').text();
        count_update++;
        $this.parent().find('.white-box span').text(count_update);
        $.ajax({
            url: RELATIVE_PATH + '/config/processing.php',
            type: 'POST',
            cache: false,
            data: {
                form: 'Inspiration Img Shared',
                data: {
                    shared_img_id : $this.data('img-id'),
                    shared_to : $this.data('shared-to')
                }
            },
            success: function (response) {

            }
        });
    });
}


/* Start Tooltip */
$(document).ready(function() {
    $.protip({
        selector: '.tooltip-mg',
        gravity: true
    });
});


/* Courses Video Modal */
$('.launch-modal').on('click', function(e){
    e.preventDefault();
    $( '#' + $(this).data('modal-id') ).modal();
});

/* Courses action tracker */
course_action_tracker();
function course_action_tracker() {
    $('body').on('click','[data-session-item]',function(){
        var $this = $(this);
        var session_number = $this.closest('.display-box').data('session-number');
        if(!$this.hasClass('pre-complete')){
            $.ajax({
                url: RELATIVE_PATH + '/config/processing.php',
                type: 'post',
                cache: false,
                data: {
                    form : 'Course Session Action',
                    data:{
                        session_num : $(this).parent().parent().data('session-num'),
                        session_item : $(this).data('session-item'),
                        session_number : session_number
                    }
                },
                success : function (response) {
                    if(response === 'success'){
                        $this.addClass('pre-complete');

                        $('#course-outer').load(location.href + ' #course-inner');
                        $this.find('[data-show-course="btn"] .text').text('');
                    }
                }
            });
        }
    });
}

/** Run functions for the progress section. */
$(document).ready(function () {
    'use strict';

    /** Check if on the courses page */
    if($('.session-title').length > 0) {
        /** Get and set the total sessions on the courses page */
        /* total_course_sessions();*/

        /** Get and set the total activities */
        /*  set_total_activities();*/

        /** Set the total incomplete activities. */
        total_incomplete_activities();


        /** Adjust the course page progress bar according to activity status */
        /*set_course_progress_bar();*/

        /** Hide active activities. */
        hide_course_activity();
    }
});

/** Adjust the course page progress bar according to activity status */
function set_course_progress_bar() {
    'use strict';
    var bar_id = '#course-progress-bar';
    var number1 =  $('.total-complete-activities').text();
    var number2 = $('p[data-session-item]').length;

    var complete_percentage = Math.floor((number1 / number2) * 100);

    $(bar_id).css('width', complete_percentage+'%').attr('aria-valuenow', complete_percentage);

}

/** Get and set the total sessions on the courses page */
function total_course_sessions() {
    'use strict';
    var total_sessions = $('.session-title').length;
    $('.total-sessions').text(total_sessions);

}

/** Get and set the total activities */
function set_total_activities() {
    'use strict';
    var total_activities = $('p[data-session-item]').length;
    $('.total-activities').text(total_activities);

    $.post(RELATIVE_PATH +'/crons/set-total-course-count.php',{total : total_activities});

}
/** Set the total incomplete activities. */
function  total_incomplete_activities() {
    'use strict';
    var total_activities = $('.total-activities').text();
    var total_complete_activities = $('.total-complete-activities').text();
    var total_incomplete_tasks = total_activities - total_complete_activities;
    var progress_body = $('.progress-body').text();

    set_course_json_variables(progress_body,'<--INCOMPLETE TASKS-->',total_incomplete_tasks);


}
function set_course_json_variables(progress_body,pattern,replace_with) {
    'use strict';
    var replace = progress_body.replace(pattern,replace_with );

    /** replace the pattern in the progress body */
    $('.progress-body').text(replace);
}

/* Show Hide Course Activities. */
function hide_course_activity() {
    'use strict';

    var parent_class = '.session-container';
    var button_text = 'Hide Completed';
    var original_button_text = "Show Completed";
    var start_button_text = "Unpause";
    var skip_button_text = "Skip";

    /** Hide all completed activities when page loads
     $('.content-item').each(function(){
        if($(this).find('p').hasClass("pre-complete")){
            $(this).css({'display' : 'none'});
        }
    });*/

    /** Show completed activities.
     $('body').on('click','.show-complete',function () {
        var $this = $(this);

        $(this).closest('.content').find('.content-item').each(function () {

            var $this_content_item = $(this);
            var match_classes =  $(this).find('p').attr('class');
            $this_content_item.slideDown();
            if(match_classes === 'heading pre-complete launch-modal ' || match_classes === 'heading pre-complete ') {

                $this.removeClass('show-complete').addClass('hide-complete');
                $this.find('.text').text(button_text);
            }
        });
    });*/


    $('body').on('click','.hide-complete',function () {
        var $this = $(this);

        $(this).closest('.content').find('.content-item').each(function () {
            var match_classes =  $(this).find('p').attr('class').trim();
            if(match_classes === 'heading pre-complete launch-modal' || match_classes === 'heading pre-complete'){
                $(this).slideUp();
                $this.removeClass('hide-complete').addClass('show-complete');
            }

            $this.find('.text').text(original_button_text);
        });
    });
    /** Show completed activities. */

    $('body').on('click', parent_class + ' .skip',function () {
        var $this = $(this);
        var $skipStatus = $this.data('skip-status');
        var sessionSubHeader = '.session-sub-heading';
        var sessionTitle = $($this).closest('.display-box').find('.header-container .session-sub-title').data('session-title');
        var sessionNumber = $($this).closest('.display-box').data('session-number');

        var ajaxValue = {
            cache : false,
            ajaxCase : 'Skip Session',
            skippedSession : sessionNumber
        };

        $.get(RELATIVE_PATH +'/ajax-gets/index.php',ajaxValue, function (response) {
            console.log(response);
            if(response.updateStatus === 'Skipped'){
                $this.find('.text').text('Un-skip');
                $($this).closest('.display-box').find('.content').slideUp(500);
                $($this).closest('.display-box').find('.header-container').addClass('skipped');
                $($this).closest('.display-box').find('.header-container .session-sub-title').html('<button class="btn btn-primary" data-revisit-session="'+sessionNumber+'" >Revisit Session</button>');
                $('[data-skipped-course]').text(response.totalSkippedSessions);
                $('#course-outer').load(location.href + ' #course-inner');
            }else{
                $this.find('.text').text('Skip');
                $($this).closest('.display-box').find('.header-container').removeClass('skipped');
                $($this).closest('.display-box').find('.header-container .session-sub-title').text(sessionTitle);
                $('[data-skipped-course]').text(response.totalSkippedSessions);

            }
        },'json');

    });
    $('body').on('click', parent_class + ' [data-revisit-session]',function () {
        var $this = $(this);
        var $skipStatus = $this.data('skip-status');
        var sessionSubHeader = '.session-sub-heading';
        var sessionNumber = $($this).closest('.display-box').data('session-number');

        var sessionTitle = $($this).closest('.display-box').find('.header-container .session-sub-title').data('session-title');

        var ajaxValue = {
            cache : false,
            ajaxCase : 'Skip Session',
            skippedSession : sessionNumber
        };

        $.get(RELATIVE_PATH +'/ajax-gets/index.php',ajaxValue, function (response) {
            $this.closest('.display-box').find('.show-complete .text').html('Hide Completed <i class="fa fa-angle-double-right"></i>');
            $this.closest('.display-box').find('.show-complete').removeClass('show-complete').addClass('hide-complete');
            $this.closest('.display-box').find('.content').slideDown(500);
            $this.closest('.display-box').find('.skip .text').text('Skip');
            $this.closest('.display-box').find('.header-container').removeClass('skipped');
            $this.closest('.display-box').find('.header-container .session-sub-title').text(sessionTitle);
            $('[data-skipped-course]').text(response.totalSkippedSessions);

        },'json');

    });
}

/* Custom Select Button */
customized_select_menu();
function customized_select_menu() {
    var slide_speed = 400;

    $('.customized-select-box .customized-select').on('click',function () {
        var $this = new $(this);
        var drop_box = $this.parent().find('.custom-drop-box');
        window.filter_li = drop_box.find('li');


        /* Slide down dropdown box */
        drop_box.css({'width' : $this.parent().width() + 'px'});
        drop_box.slideToggle(slide_speed);
    });

    $('.customized-select-box li').on('click','',function () {
        /* Activate Selected Filter */
        var $this_li = $(this);

        $this_li.closest('.custom-drop-box').find('li').removeClass('active');
        $this_li.toggleClass('active');
        $this_li.closest('.custom-drop-box').slideUp(slide_speed);
        $this_li.closest('.customized-select-box').find('.customized-select span').text($this_li.text());

        $.get(RELATIVE_PATH +'/ajax-loads/filtered-journal.php?filter='+$this_li.text(), function (response){
            $('#journal-entries').html(response)
            $('.readmore-content').readmore({
                parent_container_class : '.inside-box', // The class for the parent container for both the box to toggle and button
                height : 80, // Height in px,
                margin_bottom : 20, // Margin bottom of element
                btn_class : '#journal #comments-section .show-more-content' // Class name for button that toggles container
            });
            $('.other-comments').css({'display': 'none'});
            $('.reply-box .comment-editor form').css({'display': 'none'});
        });
    });
}
if($('.readmore-content').length > 0 && !$('.readmore-content').hasClass('active')){
    $('.readmore-content').readmore({
        parent_container_class : '.inside-box', // The class for the parent container for both the box to toggle and button
        height : 80, // Height in px,
        margin_bottom : 20, // Margin bottom of element
        btn_class : '#journal #comments-section .show-more-content' // Class name for button that toggles container
    });
}else{
    $('.show-more-content').hide();
}

/** Log each page the user visits */
pageLogger();
function pageLogger() {
    'use strict';
    var pathname = window.location.pathname;
    $.post(RELATIVE_PATH + '/config/processing.php',{form : 'Page Logger', page : pathname});
}
/* Enable chat bubble to initiate chat window
$(document).on('click', '.bubble-alert', function () {
    $this = $(this);
    window.open("http://hopetracker.com/chat-mods/chat-box/", "", "width=300,height=350");
    $this.remove();
});
*/

/** Run interval on all time elements */
setInterval(function () {
    $('time.human-time').timeago();
},60000 );
