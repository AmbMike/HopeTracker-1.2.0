/*
 * Copyright (c) 2018.
 */

/** If the follow user button is on the page allow access to follow the user */
if($('[data-follow-user-id]').length > 0){
    followUser();

}
function followUser() {
    'use strict';
    var btn = $('[data-follow-user-id]');

    $(btn).on('click', function () {

        var $this = $(this);
        var followedUserId = $this.data('follow-user-id');

        var ajaxData = {
            form : 'Follow User',
            followedUserId :  followedUserId
        };
        $this.html('<i class="fa fa-gear fa-spin"></i> Processing');

        $.post(RELATIVE_PATH + '/config/processing.php',ajaxData,function (response) {
            console.log(response);
            if(response.status === 'Following'){
                $this.html('<i class="fa fa-user-times"></i> Un-Friend');
            }else if(response.status === 'Unfollowed'){
                $this.html('<i class="fa fa-user-plus"></i> Add Friend');
            }
        },'json');
    });
}