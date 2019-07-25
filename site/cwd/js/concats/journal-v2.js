/*
 * Copyright (c) 2018.
 */

$(document).ready(function () {
    'use strict';
    textAreaResize();
    inputResize()
});
function textAreaResize() {
    'use strict';
    if($('textarea[data-autoresize]').length > 0){
        $.each($('textarea[data-autoresize]'), function () {
            var offset = this.offsetHeight - this.clientHeight;

            var resizeTextarea = function (el) {
                $(el).css('height', 'auto').css('height', el.scrollHeight + offset);
            };
            $(this).on('keyup input', function () {
                resizeTextarea(this);
            }).removeAttr('data-autoresize');
        });
    }
}
function inputResize() {
    'use strict';
    if($('input[data-autoresize]').length > 0){
        $.each($('input[data-autoresize]'), function () {
            var offset = this.offsetHeight - this.clientHeight;

            var resizeTextarea = function (el) {
                $(el).css('height', 'auto').css('height', el.scrollHeight + offset);
            };
            $(this).on('keyup input', function () {
                resizeTextarea(this);
            }).removeAttr('data-autoresize');
        });
    }
}
var inputContainer, textareaSize, input;
var autoSize = function () {
    "use strict";
    if($('[data-resize-textarea="true"].active').length > 0) {
        textareaSize.innerHTML = input.value + '\n';
    }
};

document.addEventListener('DOMContentLoaded', function() {
    "use strict";
    if($('textarea.active').length > 0){
        $('textarea.active').focus();
    }
    if($('.textarea-box').length > 0) {

        inputContainer = document.querySelector('.textarea-box');
        textareaSize = inputContainer.querySelector('.textarea-resize');
        input = inputContainer.querySelector('textarea');

    autoSize();
    input.addEventListener('input', autoSize);

    }
});
moreText();
function moreText(){
    'use strict';
    var box = '.more-box';
    var moreText = '.more-text';
    var btn = 'data-moreText';
    var transitionSpeed = 400;

    /** Start app */
    $(moreText).css({'display' : 'none'});

    $('body').on('click','[' + btn + ']',function(){

       var  $this = $(this);

        $this.parent().toggleClass('on');

        /** Adjust read more text to the left to offset whitespace*/
        //$(box + ' .read-more-text').css({'position' : 'relative', 'left' :'-4px', 'color' : 'red'});

        /** Show more button */
        if($this.attr(btn) === 'more'){
            $this.css({'display' : 'none'});
            $this.closest('.more-box').addClass('on');
            $this.closest('.more-box').find('.dots').css({'display' : 'none'});
            $this.parent().find(moreText).slideDown(transitionSpeed).css({'display' : 'inline'});
        }

        /** Show less button */
        if($this.attr(btn) === 'less'){

            /** Current show more button */
            var currentMoreBtn = $this.closest(box).find('[' + btn + ']');

            $this.closest('.more-box').removeClass('on');
            $this.closest('.more-box').find('.dots').css({'display' : 'inline'});
            $this.parent().slideUp(transitionSpeed, function(){

                /** Reshow read more button */
                currentMoreBtn.fadeIn(500);
            });
        }

    });

}