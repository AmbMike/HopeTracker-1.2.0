/**
 * File For: HopeTracker.com
 * File Name: .
 * Author: Mike Giammattei
 * Created On: 4/5/2017, 8:47 AM
 */
/* Mike's Global Functions */
$.fn.mg_validate = function(options) {
    var settings = $.extend({
        /* These are the defaults */
        form_id : '',
        submit_btn : false,
        letters_only : false,
        require : false,
        max_length : false,
        min_length : false,
        numbers_only : false,
        exact_char_length : false,
        email : false,
        match_it : false,
        no_match : false,
        auto_complete :true,
        duplicate_check : false,

    }, options);

    /* returned variable */
    var controller = {};
    var $this = $(this);
    window.dupliate = '';

    /* Stuff to do once */
    /* Check the input fields have been validated before form submits*/
    if(settings.submit_btn !== false){
        $(settings.submit_btn).on('click',function () {

            $('#' + settings.form_id + ' input').each(function () {
                $(this).trigger('keyup');
            });

            /* Don't Match*/
            if(settings.no_match !== false) {
                for(var i=0; $this.length > i; i++){
                    if($this.eq(i).text() === settings.no_match){
                        controller.no_match = false;
                        $this.eq(i).addClass('error-box');
                    }else{
                        controller.no_match = true;
                        $this.eq(i).removeClass('error-box');
                    }
                }
            }
            /* Check for duplicate settings*/
            if(settings.duplicate_check !== false && $('.error-box') > 0) {
                window.duplicate = $this.val();
            }
        });
    }
    /* Auto Complete*/
    if(settings.auto_complete !== true) {
        $('input').attr('autocomplete', 'off');
    }

    /* things to do to for plugin */
    return this.each( function() {

        /* Plugins to do tasks */
        $(this).on('keyup',function (){
            var errors = 0;
            /* check if value has only letters */
            if (settings.letters_only === true) {
                if(/^[a-zA-Z]+$/.test($(this).val())){
                    controller.letters_only = true;
                }else{

                    controller.letters_only = false;
                }
            }

            /* check if empty */
            if (settings.require === true) {
                if($(this).val().length === 0){
                    controller.require = false;
                }else{
                    controller.require = true;
                }
            }

            /* Check max char length */
            if(settings.max_length !== false) {
                if($(this).val().length > settings.max_length){
                    controller.max_length = false;
                }else{
                    controller.max_length = true;
                }
            }

            /* Check min char length */
            if(settings.min_length !== false) {
                if($(this).val().length < settings.min_length){
                    controller.min_length = false;
                }else{
                    controller.min_length = true;
                }
            }

            /* Check max char length */
            if(settings.numbers_only !== false) {
                if($.isNumeric($this.val()) === false){
                    controller.numbers_only = false;
                }else{
                    controller.numbers_only = true;
                }
            }

            /* Check max char length */
            if(settings.exact_char_length !== false) {
                if($this.val().length !== settings.exact_char_length){
                    controller.exact_char_length = false;
                }else{
                    controller.exact_char_length = true;
                }
            }

            /* Validate email */
            if(settings.email !== false) {
                /* custom */
                if($('.error-text').length > 0){

                    $('.error-text').remove();
                };
                /* end custom */

                var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                if(emailReg.test($(this).val()) !== true){
                    controller.email = false;
                }else{
                    if(window.duplicate === $this.val() && $('.error-text').length === 0){
                        controller.email = false;
                        $this.parent().prepend('<p class="error-text">Email already in use</p>');
                        $this.addClass('error-box');
                    }else{
                        $('.error-text').remove();
                        controller.email = true;
                        $this.removeClass('error-box');
                    }

                }
            }

            /* Match Field*/
            if(settings.match_it !== false) {
                var  match_field = $(settings.match_it).val();
                if($this.val() === match_field){
                    controller.match_it = true;
                }else{
                    controller.match_it = false;
                }
            }

            /* Loop through controller object to determine if it has a false boolean */
            $.each(controller, function( index, value ) {
                if(value === false){
                    errors ++;
                }
            });

            if(errors === 0 ){
                $this.parent().addClass('valid').removeClass('error');
            }else {
                $this.parent().removeClass('valid').addClass('error');
            }
        });

        $this.parent().find('li').on('click',function () {
            /* Don't Match*/
            if(settings.no_match !== false) {
                for(var i=0; $this.length > i; i++){
                    if($this.eq(i).text() === settings.no_match){
                        controller.no_match = false;
                        $this.eq(i).addClass('error-box');
                    }else{
                        controller.no_match = true;
                        $this.eq(i).removeClass('error-box');
                    }
                }
            }
        });
    });

}
