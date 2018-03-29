$.fn.extend({
    readmore: function(options) {
        var $this = $(this);
        var container_height = $this.outerHeight();

        var defaults = {
            height: 300,
            margin_bottom: 15,
            btn_class : '.show-more'

           };

        var settings = $.extend( {}, defaults, options );

        toggle_container();
        function toggle_container() {

            $('body').on('click',options.btn_class,function () {
                var $this_readmore_btn = $(this);
                var active_readmore_container = $(this).closest(options.parent_container_class).find($this);

                if(!$(this).hasClass('on')){

                  active_readmore_container.css({'height' : 'auto'});

                  var this_height = active_readmore_container.outerHeight();
                  active_readmore_container.css({'height' : options.height +'px'});
                  active_readmore_container.stop().animate({'height' : this_height +'px'},400,function () {
                      $this_readmore_btn.addClass('on');
                  });
              }else{
                  active_readmore_container.stop().animate({'height' : options.height +'px'},400,function () {
                      $this_readmore_btn.removeClass('on');
                  });
              }

            });
        }
        return this.each(function() {
            set_height();
            function set_height() {
                $this.css({'height' : settings.height + 'px', 'overflow' : 'hidden','margin-bottom' : options.margin_bottom +'px'});
            }
        });





    }
});
