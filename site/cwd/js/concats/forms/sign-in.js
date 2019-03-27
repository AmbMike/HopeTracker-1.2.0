/**
 * File For: HopeTracker.com
 * File Name: .
 * Author: Mike Giammattei
 * Created On: 4/5/2017, 9:22 AM
 */

/* Mike's tooltip */
$.fn.mg_tooltip = function(options) {
    var settings = $.extend({
        /* These are the defaults */
        form_id : null,
        element : $(this),
        error_msg : '',
        clear : false,
        success : false

    }, options);
    /* returned variable */
    var controller = {};
    var $this = $(this);
    var success = '';

    var obj = {
        org_width : $this.outerWidth() / $this.parent().innerWidth() * 100
    }
    if(settings.success === true){
        success = ' success';
    }
    if(settings.clear === true){
        /* Resets tooltip */
        reset();
        $('html').on('click',function () {
            reset();
        });

    }else{
        $this.wrap('<div style="width: ' + obj.org_width + '%; float: left; margin: 0 1%" class="errors"></div>');
        $this.css({'width' : '100%'});
        $this.parent().append('<div class="error-drop ' + success + '" style="width: ' + $this.outerWidth() + 'px">' + settings.error_msg +'</div>');
        $('.error-drop').stop().slideDown(400);
        $(this).focus();
    }


    /* things to do to for plugin */
    return this.each( function() {

    });

    /* Local Functions */
    function reset() {
        $(settings.form_id + ' input').each(function () {
            if($(this).parent().hasClass('errors')){
                /* Clear old errors */
                $(this).parent().find('.error-drop').remove().unwrap().removeAttr('style');
                $(this).unwrap().removeAttr('style');
                $(this).focus();
            }
        });
    }
}

$(document).ready(function () {
    sign_in();
    function sign_in() {

        var obj = {
            form : '#sign-in',
            email : $('#sign-in input[name="email"]'),
            pass : $('#sign-in input[name="password"]'),
            cur_url : $('#sign-in input[name="cur_url"]')
        };


        $(obj.form).on('submit',function (event) {

            event.preventDefault();
            /* Clear old errors */
            $(obj.form).mg_tooltip({
                form_id : '#sign-in',
                clear : true
            });

            var form_data = $(obj.form).serialize();

            $.ajax({
                type: 'POST',
                cache : false,
                url: RELATIVE_PATH + '/config/processing.php',
                data: form_data
            }).done(function(response) {
                if(response === 'Email and Password Match'){
                    /** Send user when logged in */
                    location.href= RELATIVE_PATH + "/protected/course/?logged_in";
                }else if(response === 'No Email Found'){

                    /* Email Not Found */
                    obj.email.mg_tooltip({
                        error_msg : '<b><u>Email Not Found</b></u><br>Check spelling, <br> try another email <br>or sign up</a>.'
                    });

                }else if(response === 'Password Not Correct'){

                    /* Password Validation */
                    obj.pass.mg_tooltip({
                        error_msg : '<b><u>Wrong Password</u></b><br>Try again<br />or click below to<br><a href="" class="reset-password"> reset password</a>'
                    });
                }
            });
        });

        $(obj.form).on('click','a',function(event) {
            event.preventDefault();
            $.ajax({
                type : "POST",
                url : RELATIVE_PATH + '/config/processing.php',
                data : {
                    form : 'Forgot Password',
                    email : $(obj.form  + ' input[name="email"]').val()
                }
            }).done(function (response) {
                if(response === 'Sent'){

                    obj.pass.mg_tooltip({
                        success : true,
                        error_msg : '<b><u>Email Sent</u></b><br>Check your inbox <br> to reset password.'
                    });
                }else if(response === 'Wait'){
                    obj.pass.mg_tooltip({
                        error_msg : 'Email Sent. <br>Please wait 5 min.. <br> to reset again.'
                    });
                }
            });
        });
    }
});


