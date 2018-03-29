/**
 * File For: HopeTracker.com
 * File Name: .
 * Author: Mike Giammattei
 * Created On: 3/23/2017, 10:39 AM
 */
form_one('select');
function form_one(selector) {
    $(selector).each(function(){
        var $this = $(this), numberOfOptions = $(this).children('option').length;

        $this.addClass('select-hidden');
        $this.wrap('<div class="select"></div>');
        $this.after('<div class="select-styled"></div>');

        var $styledSelect = $this.next('div.select-styled');
        $styledSelect.text($this.children('option').eq(0).text());

        var $list = $('<ul />', {
            'class': 'select-options'
        }).insertAfter($styledSelect);

        for (var i = 0; i < numberOfOptions; i++) {
            $('<li />', {
                text: $this.children('option').eq(i).text(),
                rel: $this.children('option').eq(i).val()
            }).appendTo($list);
        }

        var $listItems = $list.children('li');

        $styledSelect.click(function(e) {
            e.stopPropagation();
            $('div.select-styled.active').not(this).each(function(){
                $(this).removeClass('active').next('ul.select-options').hide();
            });
            $(this).toggleClass('active').next('ul.select-options').toggle();
        });

        $listItems.click(function(e) {
            e.stopPropagation();
            $styledSelect.text($(this).text()).removeClass('active');
            $this.val($(this).attr('rel'));
            $list.hide();
            //console.log($this.val());
        });

        $(document).click(function() {
            $styledSelect.removeClass('active');
            $list.hide();
        });

    });
}

/**
 * File For: HopeTracker.com
 * File Name: .
 * Author: Mike Giammattei
 * Created On: 4/5/2017, 8:54 AM
 */
sign_up_process();
function sign_up_process() {

    var obj = {
        form : $('form'),
        id : '#form-one',
        submit_btn : $('#form-one .btn'),
        error_check : $('.input-box')
    }

    /* Validate input fields */
    $(obj.id).mg_validate({
        auto_complete : false
    });
    /**/
    $(obj.id + ' input[name="fname"]').mg_validate({
        form_id : 'form-one',
        submit_btn : '#form-one .btn',
        require : true,
        letters_only : true,
        max_length : 20,
        min_length : 2
    });
    $(obj.id + ' input[name="lname"]').mg_validate({
        form_id : 'form-one',
        submit_btn : '#form-one .btn',
        require : true,
        letters_only : true,
        max_length : 20,
        min_length : 3
    });
    $(obj.id + ' input[name="zip"]').mg_validate({
        form_id : 'form-one',
        submit_btn : '#form-one .btn',
        require : true,
        exact_char_length : 5,
        numbers_only : true
    });
    $(obj.id + ' input[name="email"]').mg_validate({
        form_id : 'form-one',
        submit_btn : '#form-one .btn',
        require : true,
        email : true,
        duplicate_check : true
    });
    $(obj.id + ' input[name ="password"]').mg_validate({
        form_id : 'form-one',
        submit_btn : '#form-one .btn',
        require : true,
        min_length : 6,

    });
    $(obj.id + ' input[name ="re_password"]').mg_validate({
        form_id : 'form-one',
        submit_btn : '#form-one .btn',
        require : true,
        match_it : obj.id + ' input[name ="password"]'
    });
    $(obj.id + ' .select-box .select-styled').mg_validate({
        form_id : 'form-one',
        submit_btn : '#form-one .btn',
        no_match : '-- Choose --'
    });
    $('.input-box.menu .select-styled').mg_validate({
        form_id : 'form-one',
        submit_btn : '#form-one .btn',
        no_match : '-- State --'
    });

    $(obj.id).submit(function(event) {
        event.preventDefault();

        var formData = $('form' + obj.id).serialize();

        if(!obj.error_check.hasClass('error') && $('.error-text').length === 0){

            $.ajax({
                type: 'POST',
                url: RELATIVE_PATH + '/config/processing.php',
                cache : false,
                data: formData
            }).done(function(response) {
                console.log(response);
                if(response === '0'){
                    location.href=RELATIVE_PATH+"/protected/course/";
                }else if(response === '1'){
                    $(obj.id + ' input[name="email"]').parent().removeClass('valid');
                    $(obj.id + ' input[name="email"]').parent().prepend('<p class="error-text">Email already in use</p>');
                    $(obj.id + ' input[name="email"]').addClass('error-box');
                }
            })
        }
    });
}
