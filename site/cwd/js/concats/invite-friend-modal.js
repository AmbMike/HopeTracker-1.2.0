/*
 * Copyright (c) 2017.
 */

/**
 * File For: HopeTracker.com
 * File Name: .
 * Author: Mike Giammattei
 * Created On: 10/18/2017, 1:02 PM
 */
$(document).ready(function () {
    "use strict";
    inviteFriendModal();
});

function inviteFriendModal() {
    "use strict";

    /** @var the modal's id */
    var modal_id = "#sidebar-share-modal";
    var form = modal_id + " form";
    var thisFormId = '#sidebar-share-form';

    /** If user is logged in run form */
    if($('.logged-in').length >  0) {
        $(thisFormId).bootstrapValidator({
            message: 'This value is not valid',
            fields: {
                senders_name: {
                    message: 'Your first name is invalid',
                    validators: {
                        notEmpty: {
                            message: 'Your first name is required'
                        },
                        stringLength: {
                            min: 2,
                            max: 30,
                            message: 'Your first name must be more than 2 and less than 30 characters long'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9_]+$/,
                            message: 'Your first name can only consist of alphabetical, number and underscore'
                        }
                    }
                },
                recipients_name: {
                    validators: {
                        notEmpty: {
                            message: 'Your recipients\'s name is required'
                        },
                        stringLength: {
                            min: 2,
                            max: 30,
                            message: 'Your recipients\'s name must be more than 2 and less than 30 characters long'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9_\s]+$/,
                            message: 'Your recipients\'s name can only consist of alphabetical, number and underscore'
                        }
                    }
                },
                recipients_email: {
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
                            regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                            message: 'The value is not a valid email address'
                        },
                        remote: {
                            message: "You\'ve already invited this friend.",
                            url: RELATIVE_PATH + "/config/processing.php",
                            type: "POST",
                            data: {
                                form: "Sidebar Invite Friend Check"
                            }
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
                    form : 'Sidebar Invite Friend',
                    data : {
                        recipients_name: $('#sidebar-share-form #recipients_name').val() ,
                        recipients_email: $('#sidebar-share-form #recipients_email').val()
                    }
                },
                dataType : 'json'
            }).done(function(response){

                if(response.status === "Successful"){

                    $(thisFormId).data('bootstrapValidator').resetForm();
                    $(thisFormId).slideUp(500,function () {
                        $(modal_id).find('.modal-header p').html('An invite has been sent to: <br><u>' + $('#sidebar-share-form #recipients_name').val() + "</u>");
                        $(modal_id).find('.modal-header p').addClass('success-msg-sm sm-txt');
                        $(modal_id).find('.modal-header p').removeClass('blk-heading-md');
                        $(modal_id).find('.modal-header p').eq(0).prepend('<i class="fa fa-check-square-o" aria-hidden="true"></i> <br>');
                    });

                    $.get(RELATIVE_PATH +  '/ajax-gets/campaignMonitor/pushNewInvite.php',{userId: response.userId },function (response) {
                        console.log(response);
                    },'json');
                }
            });
        });
    }

}