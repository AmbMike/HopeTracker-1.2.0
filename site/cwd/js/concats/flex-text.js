/**
 * File For: HopeTracker.com
 * File Name: .
 * Author: Mike Giammattei
 * Created On: 5/9/2017, 8:42 AM
 */



(function($) {
    $.fn.flexText = function(options) {

// Establish default settings/variables
// ====================================
        var settings = $.extend({
                maximum   : 9999,
                minimum   : 1,
                maxFont   : 9999,
                minFont   : 1,
                fontRatio : 35
            }, options),

// Do the magic math
// =================
            changes = function(el) {
                var $el = $(el),
                    elw = $el.width(),
                    width = elw > settings.maximum ? settings.maximum : elw < settings.minimum ? settings.minimum : elw,
                    fontBase = width / settings.fontRatio,
                    fontSize = fontBase > settings.maxFont ? settings.maxFont : fontBase < settings.minFont ? settings.minFont : fontBase;
                $el.css('font-size', fontSize + 'px');
            };

// Make the magic visible
// ======================
        return this.each(function() {
            // Context for resize callback
            var that = this;
            // Make changes upon resize
            $(window).resize(function(){changes(that);});
            // Set changes on load
            changes(this);
        });
    };
}(jQuery));

/*$('h1').flexText({
    minimum   : 500,
    maximum   : 1600,
    minFont : 24,
    fontRatio : 15
});*/
$('.blue-text-sm.sub').flexText({
    minimum   : 500,
    maximum   : 1600,
    minFont : 20,
    fontRatio : 25
});