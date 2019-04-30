/**
 * File For: HopeTracker.com
 * File Name: .
 * Author: Mike Giammattei
 * Created On: 4/11/2017, 3:29 PM
 */

mobile_nav();
function  mobile_nav(){
    $('header .menu-btn').on('click',function(){

        $(this).toggleClass('on');
        $('.nav-btn').stop().toggleClass('nav-btn-1');
        $('.nav-btn1').stop().toggleClass('nav-btn-2');
        $('.nav-btn2').stop().toggleClass('nav-btn-3');

        $('.mobile-nav-box').toggleClass('on');
        $('.nav-box nav > ul').stop().slideToggle(500);

        if($('header .menu-btn.on').length > 0) {
            $('.overlay').fadeIn(500);
        }else{
            $('.overlay').fadeOut(500);
        }

        $('#form-one').removeAttr('style');
        $('header nav').add('.form-btn').removeClass('on');
    });

    $('.overlay').on('click',function () {
        toggle_off();
    });

    $(window).on('resize',function () {
        var resizeTimer;
        $(window).on('resize', function(e) {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                if($(window).width() > 768){
                    toggle_off();
                }
            }, 250);

        });
    });

    if($(window).outerWidth() < 767 ){

        $('header #form-one .close-btn').on('click',function () {
            toggle_off();
        });
    }

    /* Local Functions */
    function toggle_off() {
        $('.nav-btn').stop().removeClass('nav-btn-1');
        $('.nav-btn1').stop().removeClass('nav-btn-2');
        $('.nav-btn2').stop().removeClass('nav-btn-3');
        $('.nav-box nav > ul').add('.dropdown-menu').removeAttr('style');


        if($('header .menu-btn.on').length > 0) {
            $('.overlay').fadeOut(500);
        }
    }
}

log_out();
function log_out() {
    'use strict';
    var obj = {
        btn : 'nav .logged-in  .menu-one-trigger',
        overlay : '.overlay',
        menu : 'nav .logged-in .dropdown-menu'

    }
    $(obj.btn).add('.menu-one').on('click',function () {
        $(obj.overlay).stop().fadeToggle(200,function () {

        });$(obj.menu).stop().slideToggle();

    });
}