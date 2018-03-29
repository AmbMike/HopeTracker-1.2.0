/*
 * Copyright (c) 2018.
 */

if($('[data-activity-filter]').length > 0){
    $('[data-activity-filter] li').on('click',function () {

        'use strict';

        var $this = $(this);
        var thisFilter = $this.data('activity-item');
        var thisFilterName = $this.find('.filter-name').text();
        var userId = $this.parent().data('userid');
        var ajaxData = {
            cache: false,
            activityType : thisFilter,
            userId : userId
        };

        $.get(RELATIVE_PATH + '/ajax-gets/activityFilter.php', ajaxData,function (response) {
            console.log(response);
            $this.closest('.dropdown').find('#filter-label').text(thisFilterName);
            $('#activity-notification-inner').html(response);
        });
    });
}