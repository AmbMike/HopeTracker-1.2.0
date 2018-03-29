/*
 * Copyright (c) 2017.
 */

mgInsuranceForm();
function mgInsuranceForm() {
    'use strict';

    var parentId = '#insurance-form';
    var form = {
        parentId : parentId,
        id : parentId + ' #insuranceForm',
        btn :  parentId + ' #form-btn',
        step :  parentId + ' .step',
        formPart : parentId + ' .form-part',
        formElements : parentId + ' .form-elements',
        successMsg : parentId + ' .success-msg-box',
        elHeader : parentId + ' [data-element="heading"]'
    };

    /** Heading for after form submission on success.  */
    var elHeader = $(form.parentId + ' [data-element="heading"]').data('after-submission-text');

    /** Part One Vars */
    var part1BtnText = $(form.btn).text();

    /** Part Two Vars */
    var part2BtnText = $(form.btn).data('step-two-text');

    /** Hide all form parts */
    $(form.formPart).css({'opacity' : '0', 'display' : 'none'});

    /** Show first part of form */
    $(form.formPart).eq(0).css({'opacity' : '1','display' : 'block'});


    /** Change form when user "clicks form button" */
    $(form.btn).on('click',function () {
        /** Submit Form */
        if( $(form.parentId).hasClass('two')){
            submitForm();
        }
        toggleFormPart2();

    });

    /** Change form when user "clicks step 1" */
    $(form.step).eq(0).on('click',function () {
        $(form.parentId).removeClass('two');
        toggleFormPart1();
    });

    function toggleFormPart1() {

        $(form.formPart).eq(1).animate({'opacity' : '0'},300,function () {
            $(form.formPart).eq(1).css({'display' : 'none'});
            $(form.formPart).eq(0).css({'display': 'block'}).animate({'opacity' : '1'},300,function () {
                /** Change form button text */
                $(form.btn).text(part1BtnText);
            });
        });
    }

    function toggleFormPart2() {

        /** Fire validation on input fields  */
        $(form.formPart).eq(0).find('input').each(function () {
            $(this).trigger('input');
        });

        /** Check if any errors on first part */
        var error = false;

        $(form.formPart).eq(0).find('input').each(function () {

          if($(this).parent().hasClass('has-error')){
              error = true;
          }
        });
        if(error === false){
            /** change step nav status when user clicks following page btn*/
            $(form.parentId).addClass('two');
            $(form.formPart).eq(0).animate({'opacity' : '0'},300,function () {
                $(form.formPart).eq(0).css({'display' : 'none'});
                $(form.formPart).eq(1).css({'display': 'block'}).animate({'opacity' : '1'},300,function () {
                    /** Change form button text */
                    $(form.btn).text(part2BtnText);
                });
            });
        }
    }

    /** If user is logged in run form */
    if($(form.id).length >  0) {
        $(form.id).bootstrapValidator({
            feedbackIcons: {
                valid: 'fa fa-check',
                invalid: 'fa fa-times',
                validating: 'fa fa-refresh'
            },

            fields: {
                phone: {
                    validators: {
                        notEmpty: {
                            message: ' '
                        },

                        regexp: {
                            regexp: /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/,
                            message: ' '
                        }
                    }
                },
                lovedOneName: {
                    validators: {
                        notEmpty: {
                            message: ' '
                        },
                        stringLength: {
                            min: 2,
                            max: 30,
                            message: ' '
                        }
                    }
                },
                lovedOneDOB: {
                    validators: {
                        notEmpty: {
                            message: ' '
                        },
                        regexp: {
                            regexp: /^(0?[1-9]|1[012])[\/](0?[1-9]|[12][0-9]|3[01])[\/]\d{4}$/,
                            message: ' '
                        }
                    }
                },
                lovedOneZip: {
                    validators: {
                        notEmpty: {
                            message: ' '
                        },
                        regexp: {
                            regexp: /(^\d{5}$)|(^\d{5}-\d{4}$)/,
                            message: ' '
                        }
                    }
                },
                lovedOneInsurance: {
                    validators: {
                        notEmpty: {
                            message: ' '
                        },
                        stringLength: {
                            min: 2,
                            max: 200,
                            message: ' '
                        }
                    }
                },
                lovedOneInsuranceId: {
                    validators: {
                        notEmpty: {
                            message: ' '
                        },
                        stringLength: {
                            min: 2,
                            max: 200,
                            message: ' '
                        }
                    }
                },
                policyHolderName: {
                    validators: {
                        notEmpty: {
                            message: ' '
                        },
                        stringLength: {
                            min: 2,
                            max: 200,
                            message: ' '
                        }
                    }
                },
                drugOfChoice: {
                    validators: {
                        notEmpty: {
                            message: ' '
                        },
                        stringLength: {
                            min: 2,
                            max: 200,
                            message: ' '
                        }
                    }
                }
            }
        }).on('success.form.bv',function(e){
            e.preventDefault();
           /* $.ajax({
                type: 'POST',
                url: RELATIVE_PATH + '/config/processing.php',
                data: {
                    form : 'Sidebar Invite Friend',
                    data : {
                        recipients_name: $('#sidebar-share-form #recipients_name').val() ,
                        recipients_email: $('#sidebar-share-form #recipients_email').val()
                    }
                }
            }).done(function(response){

                if(response === "Successful"){

                    $(formId).data('bootstrapValidator').resetForm();


                }
            });*/
        });
    }

    function submitForm() {
        /** Fire validation on input fields  */
        $(form.formPart).eq(1).find('input').each(function () {
            $(this).trigger('input');
        });

        /** Check if any errors on first part */
        var error2 = false;
        $(form.formPart).eq(1).find('input').each(function () {

            if($(this).parent().hasClass('has-error')){
                error2 = true;
            }
        });

        if(error2 === false){
           var formData = $(form.id).serialize();

           /** Show success message and hide form elements */


           /** Object to send out via ajax */
            var ajaxObject = {
                cache :  false,
                form : 'Insurance Form',
                data : formData
            };

            /** Send data to the database via ajax */
            $.post(RELATIVE_PATH + '/config/processing.php',ajaxObject,function (response) {
                if(response.status === 'Success'){
                    successMsg();
                    $(form.id).data('bootstrapValidator').resetForm();
                    $(form.id)[0].reset();
                }
            },'json');
        }
    }
    
    function successMsg() {

        /** hide form elements upon successful form submission */
        $(form.formElements).animate({'opacity' : '0'},300,function () {
           $(this).slideUp(300);
        });

        /** Show success message */
        $(form.successMsg).slideDown(300);

        /** Change element's heading text */
        $(form.elHeader).text(elHeader);
    }

}