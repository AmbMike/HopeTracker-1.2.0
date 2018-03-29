/*
 * Copyright (c) 2017.
 */

/**
 * File For: HopeTracker.com
 * File Name: .
 * Author: Mike Giammattei
 * Created On: 10/20/2017, 3:54 PM
 */

get_help_now_form();
function get_help_now_form() {
    'use strict';

    var nav = 'header nav .logged-in';
    var dropdownBtn = nav + ' .form-btn';
    var formUl = nav + ' #form-help-nav';
    var form = nav + ' #get-help-now-form';
    var closeBtn = nav + ' .close-btn-help';
    var overlay ='.overlay';

    /** Drop in form section */
    $(dropdownBtn).on('click', function () {
        if(!$(this).hasClass('on')) {
            $(dropdownBtn).addClass('on');
            $(overlay).fadeIn(300);
            $(formUl).stop().slideDown(400);
        }
    });

    /** Slide up form section */
    /** IMPORTANT - the click overlay is controlled in the shared js
     * for the main sign up form.
     */
    $(closeBtn).add(overlay).add('.close').on('click', function () {
        $(overlay).stop().fadeOut(300);
        $(formUl).slideUp(400,function () {
            $(dropdownBtn).removeClass('on');
        });

        /** if form has been submitted. */
        if($(formUl + ' .success-msg-sm').length > 0) {
            setTimeout(function () {
                $(form).fadeIn(700,function () {
                    $(formUl + ' .success-msg-sm').remove();
                });
            }, 500);

        }
    });

    $(form).bootstrapValidator({
        message: 'This value is not valid',
        fields: {
            fullname: {
                validators: {
                    notEmpty: {
                        message: 'Your full name is required'
                    },
                    stringLength: {
                        min: 2,
                        max: 30,
                        message: 'Your full name must be more than 2 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_\s]+$/,
                        message: 'Your full name can only consist of alphabetical, number and underscore'
                    }
                }
            },
          email: {
                validators: {
                    notEmpty: {
                        message: 'Your email is required'
                    },
                    regexp: {
                        regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                        message: 'The value is not a valid email address'
                    },
                }
            },
            phone: {
                validators: {
                    notEmpty: {
                        message: 'Your phone number is required'
                    },
                    phone: {
                        country: 'US',
                        message: 'The value is not valid %s phone number'
                    }
                }
            },

        }
    }).on('success.form.bv',function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            cache : false,
            url: RELATIVE_PATH + '/config/processing.php',
            data: {
                form : 'Get Help Now Form',
                data : {
                    fullname:  $(form).find('input[name="fullname"]').val(),
                    email: $(form).find('input[name="email"]').val(),
                    phone: $(form).find('input[name="phone"]').val(),
                    help_for: $(form).find('input[name="help_for"]:checked').val(),
                    insurance: $(form).find('input[name="insurance"]:checked').val(),
                    comments: $(form).find('textarea[name="comments"]').val()
                }
            }
        }).done(function(response){
            $(form).data('bootstrapValidator').resetForm();

            if(response === "Successful"){
                $(form)[0].reset();
                $(form).slideUp(700,function () {
                    $(formUl).append('<div class="success-msg-sm"> <p>Your message has been sent successfully</p></div>')
                });
            }
        });
    });
}