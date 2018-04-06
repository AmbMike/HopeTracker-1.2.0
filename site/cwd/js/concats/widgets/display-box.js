/**
 * File For: HopeTracker.com
 * File Name: .
 * Author: Mike Giammattei
 * Created On: 4/13/2017, 3:04 PM
 */

display_box();
function display_box() {
    'use strict';

    var obj = {
        el : ' .display-box',
        main_header : ' .header-container',
        content : ' .content'
    };

    /* Hide all content on page load if it's not the current session. */
    $(obj.el + obj.content).each(function () {
        if(!$(this).hasClass('current-session')){
            $(this).css({'display' : 'none'});
        }
    });

    $('body').on('click',obj.main_header,function () {

        var $this = $(this)

        /** toggle session time for clicked session */
        if(!$this.hasClass('active')){
           // $(obj.main_header).removeClass('active');
            $this.addClass('active');
        }else{
            $this.removeClass('active');
        }

        if(!$this.hasClass('skipped')){
            $this.parent().find(obj.content).stop().slideToggle(500);
        }

    });
}