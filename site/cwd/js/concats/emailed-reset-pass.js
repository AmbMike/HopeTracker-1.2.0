/*
 * Copyright (c) 2017.
 */

emailed_password_reset();
/** If user is logged in run form */
function emailed_password_reset() {
    if($('.emailed-password-reset').length >  0) {

        var form_id = '#reset-password-form';

        $(form_id).bootstrapValidator({
            message: 'This value is not valid',
            fields: {
                password: {
                    trigger : 'keyup',
                    validators: {
                        notEmpty: {
                            message: 'Please enter a new password'
                        },
                        stringLength: {
                            min: 6,
                            max: 300,
                            message: 'Your new password must be at least 6 characters long'
                        },
                        callback: {
                            message: 'Enter new password',
                            callback: function(value, validator, $field) {
                                var channel = $('#confirmation_password').val();
                                return (channel === '') ? true : (value !== '');
                            }
                        }
                    }
                },

                confirmation_password: {
                    trigger : 'keyup',
                    validators: {
                        /* Validate if password field is not empty */
                        callback: {
                            message : "Confirm password",
                            callback: function(value, validator, $field) {
                                var password = $('#password').val();
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
        }).on('success.form.bv',function(e){
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: RELATIVE_PATH + '/config/processing.php',
                cache : false,
                data: {
                    form : 'Emailed Password Reset',
                    data : {
                        cur_url : window.location.href,
                        email: $(form_id).find('[name="email"]').val() ,
                        new_password:$(form_id).find('[name="password"]').val() ,
                        confirmation_password: $(form_id).find('[name="confirmation_password"]').val(),
                        validate_pass: $(form_id).find('[name="verify"]').val(),
                    }
                }
            }).done(function(response){

                if(response === 'Email and Password Match'){
                    location.href = RELATIVE_PATH + "/protected/course/";
                }else{
                    location.href = "/home/";
                }
            });
        });
    }
}
