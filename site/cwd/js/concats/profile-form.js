if($('#i-profile-journal').length > 0){

    $(document).ready(function(){

        journalUpdate1();
        function journalUpdate1(){

            /** Set the width of the select option */
            //showOptions();
            function showOptions(){
                if($('.i-show-options').length > 0 ){
                    var li = $('.i-show-options');
                    li.width(li.find('.i-submenu').outerWidth());
                }
            }
        }
        autosize($('textarea'));
        $("textarea").each(function(textarea) {
            $this.height( $this[0].scrollHeight );
        });


    });

    function journal_active_edit(id) {
        var formEl = $('#' + id);
        if(!formEl.find('.s-btn').hasClass('editing')){
            formEl.find('.s-btn').addClass('editing').text('Done');
        }
    }
    function processFormSession1(event,id){
        event.preventDefault();
        var formEl = $('#' + id);
        var selectEl = formEl.find('#i-visibility-select');
        var form = {
            textarea: formEl.find('textarea'),
            visibility: selectEl.attr('data-post-visibility'),
            btn: formEl.find('.s-btn')
        };
        var err = false;

        // Check textarea
        if(form.textarea.val() === '') {
            validateForm(form.textarea);
            form.textarea.focus();
            err = true;
            console.log('empty text');
        }
        // Check checkbox
       if( selectEl.attr('data-post-visibility') === '0'){
           validateForm(selectEl.closest('.i-select-one').find('.on'));
           err = true;
           console.log('empty vis');

       }

        var ajaxData = {
            form: "Journal Session 1",
            cache: false,
        };
        var tempObj = {};
        switch (formEl.data('session-type')) {

            case 0 :
                ajaxData.data = {
                    textarea: form.textarea.val(),
                    courseSession: formEl.data('session-type'),
                };

                break;
            case 1 :
                ajaxData.data = {
                    textarea: form.textarea.val(),
                    visibility: form.visibility,
                    courseSession: formEl.data('session-type'),
                };
                break;
            case 2 :
                ajaxData.data = {
                    textarea: form.textarea.val(),
                    courseSession: formEl.data('session-type'),
                    post_id: formEl.data('post-id')
                };
                break;
            case 3 :
                ajaxData.data = {
                    content: {
                        tolerance6: formEl.find('#tolerance6').val(),
                        willDo6: formEl.find('#willDo6').val(),
                        boundary12: formEl.find('#boundary12').val(),
                        broken12: formEl.find('#broken12').val()

                    },
                    courseSession: formEl.data('session-type'),
                    post_id: formEl.data('post-id')
                };
                break;
            case 4 :
                ajaxData.data = {
                    courseSession: formEl.data('session-type'),
                    post_id: formEl.data('post-id')
                };
                /** Loop through all textarea to build content value */
                formEl.find('textarea').each(function () {
                   var  $thisTextarea = $(this);
                    tempObj[$thisTextarea.attr('id')] = $thisTextarea.val();

                });

                /** Add built content obj to ajax array */
                ajaxData.data.content = tempObj;

                break;
            case 5 :
                ajaxData.data = {
                    courseSession: formEl.data('session-type'),
                    post_id: formEl.data('post-id')
                };
                /** Loop through all textarea to build content value */
                formEl.find('textarea').each(function () {
                    var  $thisTextarea = $(this);
                    tempObj[$thisTextarea.attr('id')] = $thisTextarea.val();

                });

                /** Add built content obj to ajax array */
                ajaxData.data.content = tempObj;

                break;
            case 6 :
                ajaxData.data = {
                    courseSession: formEl.data('session-type'),
                    visibility: form.visibility,
                    post_id: formEl.data('post-id')
                };
                /** Loop through all textarea to build content value */
                formEl.find('textarea').each(function () {
                    var  $thisTextarea = $(this);
                    tempObj[$thisTextarea.attr('id')] = $thisTextarea.val();

                });

                /** Add built content obj to ajax array */
                ajaxData.data.content = tempObj;

                break;
            case 7 :
                ajaxData.data = {
                    courseSession: formEl.data('session-type'),
                    post_id: formEl.data('post-id')
                };
                /** Loop through all textarea to build content value */
                formEl.find('textarea').each(function () {
                    var  $thisTextarea = $(this);
                    tempObj[$thisTextarea.attr('id')] = $thisTextarea.val();

                });

                /** Add built content obj to ajax array */
                ajaxData.data.content = tempObj;

                break;
            case 8 :
                ajaxData.data = {
                    courseSession: formEl.data('session-type'),
                    post_id: formEl.data('post-id')
                };
                /** Loop through all textarea to build content value */
                formEl.find('textarea').each(function () {
                    var  $thisTextarea = $(this);
                    tempObj[$thisTextarea.attr('id')] = $thisTextarea.val();

                });

                /** Add built content obj to ajax array */
                ajaxData.data.content = tempObj;

                break;
            case 9 :
                ajaxData.data = {
                    courseSession: formEl.data('session-type'),
                    post_id: formEl.data('post-id')
                };
                /** Loop through all textarea to build content value */
                formEl.find('textarea').each(function () {
                    var  $thisTextarea = $(this);
                    tempObj[$thisTextarea.attr('id')] = $thisTextarea.val();

                });

                /** Add built content obj to ajax array */
                ajaxData.data.content = tempObj;

                break;
        }

       if(!err){
           form.btn.text('Processing...');
           $.post(RELATIVE_PATH + "/config/processing.php", ajaxData, function(res) {
               if(res.status === 'success'){
                   successMsg(formEl);

                   switch (res.returnType) {
                       case 'new post':
                           $('#journal-session-2').find('#fill-journals').append(newPostJournal(res.date,res.postID,res.textarea));
                           formEl.find('textarea').val('').removeAttr('style');

                          setTimeout(function () {
                               form.btn.text('Done');
                           },1500);

                           break;
                       case 'edited':
                           setTimeout(function () {
                               form.btn.text('Updated');

                               setTimeout(function () {
                                   form.btn.text('Edit');

                                   if(res.postID !== ''){
                                       formEl.data('post-id', res.postID);
                                   }

                               },1500);
                           },2000);
                           break;

                       default : /** Session 1 response action  */
                           if(formEl.data('session-type') === 1){
                               $('[data-post-type="2"][data-post-id="'+formEl.data('post-id')+'"]').find('textarea').val(form.textarea.val());
                               formEl.find('.s-btn').text('Edit');
                           }
                   }
               }

               //$("time.human-time").timeago());
           }, "json");
       }
    }

    if($('#i-visibility-select').length > 0){
        getVisibilityValue();
    }
    function newPostJournal(date,postId,textarea) {
        var profileImg = $('.profile-nav img').attr('src');

        var html = '<div class="i-journal-post">\n' +
            '                    <div class="s-table i-author s-sub-lp i-update-post">\n' +
            '                        <div class="s-cell i-profile-img s-v-top">\n' +
            '                            <div class="s-profile-img" style="background-image: url('+profileImg+');">\n' +
            '                            </div>\n' +
            '                            <span class="s-date">'+date+'</span>\n' +
            '                        </div>\n' +
            '                        <div class="s-cell">\n' +
            '                            <form onkeydown="journal_active_edit(this.id);" id="i-f-default-edit-'+postId+'" data-post-id="'+postId+'" class="s-default-form" data-session-type="2" onsubmit="return processFormSession1(event,this.id);">\n' +
            '                                <div class="form-group">\n' +
            '                                    <textarea class="s-single">'+textarea+'</textarea>\n' +
            '                                </div>\n' +
            '                                <div class="row">\n' +
            '                                    <div class="col-xs-6 col-xs-offset-6 text-right">\n' +
            '                                        <i class="fa fa-heart i-like-icon"></i> <data value="0">0</data>\n' +
            '                                        <button class="s-btn btn-lg">Edit</button>\n' +
            '                                    </div>\n' +
            '                                </div>\n' +
            '                            </form>\n' +
            '                        </div>\n' +
            '                    </div>\n' +
            '                    <div class="i-single-forum-answers">\n' +
            '                        <div class="s-table i-replies-container">\n' +
            '                                                    </div>\n' +
            '                    </div>\n' +
            '                    <!-- End Of Update Component -->\n' +
            '                </div>';

            html += '<hr style="margin-bottom: 10px">';
        setTimeout(function () {
           $('#i-f-default-edit-'+postId).find('textarea').height( $('#i-f-default-edit-'+postId).find('textarea')[0].scrollHeight );
        },100);
        return html;

    }

    function getVisibilityValue() {
        var selectEl = $('#i-visibility-select');
        var obj = {
            selectVisibility: selectEl.find('li')
        };

        obj.selectVisibility.on('click',function () {
            var $thisLi = $(this);

            var li_obj = {
                text: $thisLi.text(),
                visibility: $thisLi.data('post-visibility'),
            };

            obj.selectVisibility.removeClass('s-active');

            $thisLi.addClass('s-active');

            // Set Active Value
            selectEl.closest('.i-select-one').find('.on').html( li_obj.text);

            // Set selected Visibility Value
            selectEl.attr('data-post-visibility',li_obj.visibility);
            selectEl.css({'pointer-events': 'none'});
            setTimeout(function () {
                selectEl.css({'pointer-events': 'all'});
            },500);

        })
    }

    function validateForm(element) {
        element.css({'background' : 'pink'});
        setTimeout(function () {
            element.css({ 'background-color': '#ffffff' });
        },2000);
    }

    function successMsg(formEl){
        formEl.parent().find('.success-notification').slideDown(500,function () {
           setTimeout(function () {
               $(formEl).parent().find('.success-notification').slideUp(500);
           },3000);
        });
    }

    window.commentJournalAction120 = true;
    function updateNotViewedPost(post_id,id) {

        if(commentJournalAction120){
            var $thisNotifcationId = $('#' + id);
            var obj = {
                commentQtyElCurrentValue: $('#i-default-journal-panel .s-notification data').val(),
                commentQtyEl : $('#i-default-journal-panel .s-notification data'),
                commentElText : $('#i-default-journal-panel .s-notification #i-new-comment-notifier-text')
            };

            /** output handler */
            var tempQty = parseInt(obj.commentQtyElCurrentValue) - 1;

            /** Update qty value */
            obj.commentQtyEl.text(tempQty).val(tempQty);

            switch(true){
                case tempQty === 1 :
                    obj.commentElText.text("New Comment");
                    break;
                case tempQty > 1 :

                    break;
                case tempQty <= 0:
                    obj.commentQtyEl.parent().remove();
                    window.commentJournalAction120 = false;
            };
            $.post(RELATIVE_PATH + '/config/processing.php',{form: 'Unviewed Posts Updater', post_id : post_id},function(res){
                if(res === 'Success'){
                    $thisNotifcationId.removeClass('s-new-chat');
                }
            });

        }

    }
}
