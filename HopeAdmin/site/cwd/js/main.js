/**
 * File For: HopeTracker.com
 * File Name: .
 * Author: Mike Giammattei
 * Created On: 5/16/2017, 5:03 PM
 */
window.RELATIVE_PATH = '/hopetracker';
admin_login();
function admin_login() {
    var obj = {
        form_id : '#sign-in-admin'
    };

    $('input').focus(function () {
       $(this).parent().find('.form-control-feedback').hide();
    });

    $(obj.form_id).bootstrapValidator({
        live : 'enabled',
        submitButtons : $('#admin-login-btn'),
        message : 'General Message',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields : {
            email: {
                validators :{
                    notEmpty: {
                        message : "You must enter your email"
                    },
                    emailAddress: {
                        message: 'The email address is not valid'
                    },
                }
            },
            password: {
                validators :{
                    notEmpty: {
                        message : "You must provide your password"
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
                form : 'Admin Sign In',
                email : $(obj.form_id + ' input[name="email"]').val(),
                password : $(obj.form_id + ' input[name="password"]').val(),
            },
            dataType : 'json'
        }).done(function(response) {
            var $form = $(e.target);
            var bv = $form.data('bootstrapValidator');

            if (response.result === 'error') {
                for (var field in response.fields) {
                    bv.updateMessage(field, 'notEmpty', response.fields[field]);
                    bv.updateStatus(field, 'INVALID', 'notEmpty');
                }
            }else if(response.result === 'not admin'){
                $(obj.form_id).find('#error-box').slideDown(400);
            }
            else if(response.result === 'granted'){
                location.reload();
            }
        });
    });
}

$('#sign-out').on('click',function () {
    $.ajax({
        type: 'POST',
        url :RELATIVE_PATH +'/config/processing.php',
        cache : false,
        data : {
            form : 'Sign Out'
        },
    }).done(function (response) {
        location.reload();
    })
});

/* Updated Users Logged in Status
$(window).load(function () {
    if($('#user-logger').length > 0) {
        $.ajax({
            url: RELATIVE_PATH + '/config/processing.php',
            type: 'POST',
            cache : false,
            data: {
                form: 'Update User Online Status'
            },
            success: function (response) {
                console.log(response);
                if (response === 'Logged Out User') {
                    setTimeout(function () {
                        location.href = '/HopeAdmin';
                        $('#user-logger').remove();
                        response = '';
                    },1000);

                }
            }

        });
    }
});*/

/* Forum Add Categories Form */
forum_add_categories_form();
function forum_add_categories_form(){
    var form_id = '#add-categories';

    $(form_id).bootstrapValidator({
        live : 'enabled',
        submitButtons : $('#add-categories-btn'),
        message : 'General Message',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields : {
            category: {
                validators :{
                    notEmpty: {
                        message : "You did not add a category"
                    }
                }
            }
        }
    }).on('success.form.bv',function(e){
        e.preventDefault();


        $.ajax({
            url :RELATIVE_PATH + '/config/processing.php',
            type : 'POST',
            cache : false,
            data : {
                form : 'Forum Add Category',
                category : $(form_id + ' input[name="category"]').val(),
                moderator : $(form_id + ' select[name="moderator"]').val()
            },
            dataType : 'json',
            success : function (response) {
                console.log(response);
                var $form = $(e.target);
                var bv = $form.data('bootstrapValidator');

                if(response.result === 'Successful'){
                    $('#sort-cat').load(location.href + " #sort-cat>*","");

                    $(form_id).find('.alert-success').slideDown(400);
                    $(form_id).find('.alert-success').on('click',function () {
                        $(this).slideUp(400);
                        $(form_id).data('bootstrapValidator').resetForm();
                        $(form_id)[0].reset();
                    });
                }else{
                    bv.updateMessage('category', 'notEmpty', response.error);
                    bv.updateStatus('category', 'INVALID', 'notEmpty');
                }
            }
        });
    });
}

/* Sort Cat */
$(function () {
    var category_sort = $('#sort-cat').sortable();

    if($('.alert-success').length > 0){
        $('.alert-success').on('click',function () {
            $('.alert-success').slideUp(100);
        });
    }


    $('#save-category-position').on('click',function () {
        if($('.alert-success').length > 0){
            $('.alert-success').slideUp(100);
        }
        var post_data = category_sort.sortable('serialize');
        var $this = $(this);

        $this.parent().parent().prepend('<div class="overlay"> <i class="fa fa-refresh fa-spin"></i> </div>');
        $.ajax({
            url : RELATIVE_PATH + '/config/processing.php',
            type : 'POST',
            cache : false,
            data : {
                list : post_data,
                form : 'Sort Forum Categories'
            },
            success : function (response) {
                setTimeout(function () {
                    $this.parent().parent().find('.overlay').remove();
                    $this.parent().parent().find('.alert-success').slideDown(400);
                },700);
            }
        });
    });
    forum_sort_categories();
    function forum_sort_categories() {

    }

    delete_forum_category()
    function delete_forum_category() {
        var obj = {
            delete_btn : '.delete-cat'
        }
        $('body').on('click',obj.delete_btn,function (){
            var $this = $(this);
            var confirm_cat_msg = $this.data('category-name');
            if(confirm('Are you sure you want to delete the "' + confirm_cat_msg + '" category?')){

                $.ajax({
                    url : RELATIVE_PATH + '/config/processing.php',
                    type : 'POST',
                    cache : false,
                    data : {
                        form : 'Forum Delete Category',
                        id : $this.data('category-id')
                    },
                    //dataType : 'json',
                    success : function (response) {
                       $('#sort-cat').load(location.href + " #sort-cat>*","");
                    }

                });
            }
        });
    }
});

/* Forum Add Subcategories Form */
forum_add_subcategories_form();
function forum_add_subcategories_form(){
    var form_id = '#add-subcategories';

    $(".select2").select2();

    $(form_id).bootstrapValidator({
        live : 'enabled',
        submitButtons : $('#add-subcategories-btn'),
        message : 'General Message',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields : {
            subcategories: {
                validators :{
                    notEmpty: {
                        message : "You did not enter a subcategory"
                    }
                }
            },
            category: {
                validators :{
                    notEmpty: {
                        message : "You must choose at least one parent category"
                    }
                }
            }
        }
    }).on('success.form.bv',function(e){
        e.preventDefault();
                $.ajax({
            url : RELATIVE_PATH + '/config/processing.php',
            type : 'POST',
            cache : false,
            data : {
                form : 'Forum Add Subcategory',
                data : $( this ).serialize()
            },
            dataType : 'json',
            success : function (response) {

                var $form = $(e.target);
                var bv = $form.data('bootstrapValidator');

                $('#subcategory-list').load(location.href + " #subcategory-list>*","");

                $('#info-box-container').slideDown(400);

                $('.close-subcat-report').on('click',function () {
                    $('#info-box-container').slideUp(400,function () {
                        $(form_id).data('bootstrapValidator').resetForm();
                        $(form_id)[0].reset();
                    });

                });

                if (response.added){
                    $('#add-success').find('#count-success').text(response.added.length);
                }else{
                    $('#add-success').find('#count-success').text(0);
                }

                if (response.exists){
                    $('#add-failed').find('#count-failed').text(response.exists.length);
                }else{
                    $('#add-failed').find('#count-failed').text(0);
                }

            }
        });
    });

    delete_forum_sub_category()
    function delete_forum_sub_category() {
        var obj = {
            delete_btn : '.delete-sub-cat'
        }
        $('body').on('click',obj.delete_btn,function (){
            var $this = $(this);
            var confirm_cat_msg = $this.data('category-name');
            var refresh_num = $this.closest('.updater').index();
            var refresher_div = '#refresher-' + refresh_num;

            if(confirm('Are you sure you want to delete the "' + confirm_cat_msg + '" subcategory?')){

                $.ajax({
                    url : RELATIVE_PATH + '/config/processing.php',
                    cache : false,
                    type : 'POST',
                    data : {
                        form : 'Forum Delete Subcategory',
                        id : $this.data('category-id')
                    },
                    //dataType : 'json',
                    success : function (response) {
                        $(refresher_div).load(location.href + " " + refresher_div + ">*","");
                    }

                });
            }
        });
    }
}

/* Edit Subcategories */
edit_subcategories();
function edit_subcategories() {
    /* Show edit form for subcategories */
    $('body').on('click','.edit-cat',function () {
        var $this = $(this);

        $this.parent().parent().find('form').stop().slideToggle(600);
    });

    /* Save subcategory changes */
    $('body').on('click','.save-sub-cat-edit',function () {
        var $this = $(this);
        var new_cat_value = $this.closest('form').find('input[name="category"]').val();
        var new_moderator_value = $this.closest('form').find('select[name="moderator"]').val();

        $.ajax({
            url: RELATIVE_PATH + '/config/processing.php',
            type: 'POST',
            cache: false,
            data: {
                form: 'Edit Forum Category',
                form_data : {
                    category_id : $this.data('cat-id'),
                    category_value :new_cat_value,
                    moderator_value :new_moderator_value
                }
            },
            dataType: 'json',
            success: function (response) {
               if(response.status === 'Updated'){
                   $this.closest('form').parent().find('.category-name').text(response.category_name);
                   $this.closest('form').parent().find('.moderator-name').text(response.moderator_name);
                   $this.closest('form').slideUp(500);
               }
            }
        });


    })
}
//Initialize Select2 Elements
$('.select2').select2();