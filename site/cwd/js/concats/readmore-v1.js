/*
 * Copyright (c) 2017.
 */
/*
moreText();
function moreText(){
    'use strict'
    var box = '.more-box';
    var moreText = '.more-text';
    var btn = 'data-moreText';
    var transitionSpeed = 400;

    /!** Start app *!/
    $(moreText).css({'display' : 'none'});

    $('[' + btn + ']').on('click',function(){

        $this = $(this);

        /!** Show more button *!/
        if($this.attr(btn) == 'more'){
            $this.css({'display' : 'none'});
            $this.parent().find(moreText).slideDown(transitionSpeed).css({'display' : 'inline'});
        }

        /!** Show less button *!/
        if($this.attr(btn) == 'less'){

            /!** Current show more button *!/
            var currentMoreBtn = $this.closest(box).find('[' + btn + ']');

            $this.parent().slideUp(transitionSpeed, function(){

                /!** Reshow read more button *!/
                currentMoreBtn.fadeIn(500);
            });
        }

    });
}*/
