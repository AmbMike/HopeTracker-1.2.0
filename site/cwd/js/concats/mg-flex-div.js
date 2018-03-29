/*
 * Copyright (c) 2017.
 */

$(document).ready(function(){
    'use strict';
    mgDivFlex();
});

$(window).resize(function(){
    'use strict';
    mgDivFlex();
});

function mgDivFlex(parentId){
    'use strict';
    var parent = '.mg-flex';

    /** Set overflow for parent */
    $(parent).css({'overflow': 'auto'});

    /** Run loop on all instances of the flex box */
    $(parent).each(function(){
        var primaryBox = $(this).find('.flex-primary');
        var subBox =   $(this).find('.flex-sub-item');

        var parentWidth = $(this).outerWidth();
        var sub_box_original_width = $(this).find(primaryBox).children().outerWidth() + 15;

        /** align sub box in the middle of parent height*/
        if($(this).attr('data-pg-align-middle') === 'true'){
            var parentHeight = $(this).outerHeight();
            var subBoxHeight = subBox.outerHeight();
            var subBoxHeightAdjustment = subBoxHeight / 8;
            var setSubBoxPosition = (parentHeight / 2) - subBoxHeight;

            /** Set the middle position */
            subBox.css({'position' : 'relative', 'top' : setSubBoxPosition + 'px','margin-top' : '-' + subBoxHeightAdjustment + 'px'});;
        }


        /** Set both divs to have left property */
        $(this).find(primaryBox).css({'float' : 'left'});
        $(this).find(subBox).css({'float' : 'left'});

        var primaryBox_generated_width = parentWidth - sub_box_original_width;

        $(this).find(subBox).css({'width' :  primaryBox_generated_width + 'px'});

    });

}
