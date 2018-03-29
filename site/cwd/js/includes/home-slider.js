$(document).ready(function(){
    'use strict';
    // mg_3d_slider();
    slide_dmg();
});
var resizeTimer;

// Store the window width
var windowWidth = $(window).width();

$(window).on('resize', function(e) {
    'use strict';

    // Check window width has actually changed and it's not just iOS triggering a resize event on scroll
    if ($(window).width() != windowWidth) {

        // Update the window width for next time
        windowWidth = $(window).width();

        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            $('#testimonials').load(location.href + ' #mg-slider',function () {

                slide_dmg();


            });


        }, 250);


    }

});
function slide_dmg(){
    'use strict';

    var parentBox = '.mg-3d-slider';
    var sliderBox = '.slide-box';
    var slider = '.slider';
    var items = '.slide-item';
    var prevBtn = '.mg-3d-slider .navigation .left-x';
    var nextBtn = '.mg-3d-slider .navigation .right-x';
    var totalItems = $(items).length;
    var clickCount = 0;

    var parent = {
        height: $(parentBox).outerHeight(),
        width: $(parentBox).outerWidth()
    }

    var parentSlider = {
        height: $(sliderBox).outerHeight(),
        width: $(sliderBox).outerWidth()
    };

    var itemWidth;
    var itemWidthActive;
    var setParentWidth;

    /* Set the prev arrow to off */
    $(prevBtn).css({'opacity' : '.6'});
    /* Responsive updates */
    if($(window).outerWidth() > 1100){

        /* set Width of items */
         itemWidth = parent.width * .31;
         itemWidthActive = parentSlider.width * .38;

        /* set Width of item parent */
         setParentWidth = (itemWidth * 2) + itemWidthActive;
    }else{
         itemWidth = parent.width;
         itemWidthActive = itemWidth;

        /* set Width of item parent */
        setParentWidth = (itemWidth );
    }


    /* Outside box set to hide inner parent div for the items */
    $(parentBox).css({'width' : setParentWidth + 'px'});

    /* Sets the items width after the page has loaded. */
    setItemProperties();
    function setItemProperties(){
        /** set all items to same width */
        $(items).css({'width' : itemWidth + 'px'});
        $(items).eq(1).css({'width' : itemWidthActive + 'px'});

        /* add width of all items and then add the extra width from the active item width. */
        /* once the div set by percentage, now get width of items*/
        var itemSetWidth = $(items).outerWidth();

        /* once the div set by percentage, now get width of Active items*/
        var ActiveItemSetWidth = $(items + '.active').outerWidth();

        var itemsParentWidth = (itemWidth * totalItems) + (ActiveItemSetWidth - itemSetWidth);
        /* Expand slider to float items left */
        $(slider).css({'width' : itemsParentWidth + 'px'});

    }
    /** Set the slider box height */
    setTimeout(function () {
        var updatedSliderHeight = $('.slide-box').height();
        $(sliderBox).css({ 'height' : updatedSliderHeight + 'px'});

    },1000);


    /* Holds the limit to show slides per screen size */
    var clickCountResponsive;

    $(nextBtn).on('click', function(){
        /* Responsive updates total slides clicks */
        if($(window).outerWidth() > 1100){
            clickCountResponsive = totalItems -2 ;
        }else{
            clickCountResponsive = totalItems -1;
        }

        if(clickCount < clickCountResponsive && !$(sliderBox).hasClass('moving')){


            /** Add class to stop moving if in motion */
            $(sliderBox).addClass('moving');

           // var slide_animate_width = itemWidth;
            $(items).stop().animate({left:  '-=' + itemWidth + 'px'},1,function () {
                /** Remove class to allow  moving of item again */
                setTimeout(function(){$(sliderBox).removeClass('moving'); },500);
            });

            /** get the active items position */
            var activeItem = $('.active').index();

            /** get the active items width */
            var activeItemWidth = $('.active').outerWidth();

            /* Remove old active item */
            $(items).eq(activeItem).removeClass('active');

            /* Reset old active item width*/
            $(items).eq(activeItem).css({'width' : itemWidth + 'px'});

            /* add the active settings to the new active item in the middle */
            $(items).eq(activeItem).next().addClass('active').css({'width' : activeItemWidth + 'px'});

            clickCount++;

            /* Enable next btn color */
            if(clickCount === clickCountResponsive  ){
                $(nextBtn).css({'opacity' : '.6'});
            }

            /* Enable next btn color */
            if(clickCount !== 0){$(prevBtn).css({'opacity' : '1'});}


        }


    });

    $(prevBtn).on('click', function(){

        if(clickCount !== 0 || clickCount > totalItems -1 ){


            if(!$(sliderBox).hasClass('moving')){
                /** Add class to stop moving if in motion */
                $(sliderBox).addClass('moving');

                //var slide_animate_width = itemWidth;
                $(items).stop().animate({left:  '+=' + itemWidth + 'px'},1, function () {
                    /** Remove class to allow  moving of item again */
                    setTimeout(function(){$(sliderBox).removeClass('moving'); },600);
                });

                /** get the active items position */
                var activeItem = $('.active').index();

                /** get the active items width */
                var activeItemWidth = $('.active').outerWidth();

                /* Remove old active item */
                $(items).eq(activeItem).removeClass('active');

                /* Reset old active item width*/
                $(items).eq(activeItem).css({'width' : itemWidth + 'px'});

                /* add the active settings to the new active item in the middle */
                $(items).eq(activeItem).prev().addClass('active').css({'width' : activeItemWidth + 'px'});

                clickCount--;

                /* Enable next btn color */
                if(clickCount === 0){$(prevBtn).css({'opacity' : '.6'});}

                /* Enable next btn color */
                if(clickCount < clickCountResponsive  ){
                    $(nextBtn).css({'opacity' : '1'});
                }
            }
        }
    });

}
