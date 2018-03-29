/**
 * File For: HopeTracker.com
 * File Name: .
 * Author: Mike Giammattei
 * Created On: 3/31/2017, 11:21 AM
 */

var string =   '   <div id="loader-wrapper"> '  +

    '       <div id="loader"></div>'  +
    '       <div class="loader-section section-left"></div>  '  +
    '       <div class="loader-section section-right"></div>  '  +
    '  </div>  ' ;
$(document).ready(function() {
    $('head').append("<link href='/widgets/loader/style.css' type='text/css' rel='stylesheet' />");
    $('body').append(string);

    setTimeout(function(){
        $('body').addClass('loaded');
    }, 100);

});