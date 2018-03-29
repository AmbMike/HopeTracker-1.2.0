/*
 * Copyright (c) 2017.
 */
(function($) {
    /*
     * Tranistions text by clipping to the left, then expanding to
     * reveal the next text.
     *
     * @example .slideTextLeft(word, [delay])
     * @param {String} a single word to transition to once
     * @param {Number} the time to wait before the transition
     *
     * @example .slideTextLeft(words, [delay])
     * @param {Array} multiple words to transition through in a loop
     * @param {Number} the time to wait before the transition
     *
     * @example .slideTextLeft(settings)
     * @param {Object} setting object with "words" & optionally "delay" members
     *
    */
    $.fn.slideTextLeft = function(words, delay) {
        var isSingleWord = false;

        // map arguments
        var opts = $.fn.slideTextLeft.defaults;

        if (typeof delay === "number") {
            opts.delay = delay;
        }

        if ($.isArray(words)) {
            opts.words = words;
        } else if (typeof words === "string") {
            opts.words = words;
            isSingleWord = true;
        } else if ($.isPlainObject(words)) {
            opts = $.extend({}, $.fn.slideTextLeft.defaults, words);
        }

        // iterate and reformat each matched element
        return this.each(function() {
            var $this = $(this);
            var initialText = $this.text();
            var o = $.meta ? $.extend({}, opts, $this.data()) : opts;
            var i = 0;

            if (!o.words.length) {
                return;
            }

            $this.css({
                "white-space": "nowrap",
                "overflow": "hidden",
                "vertical-align": "bottom",
                "padding": "15px",
                "margin": " 0 15px ",
            });

            if (!initialText.length || initialText === o.words[0]) {
                $this.text(o.words[0]);
                i = 1;
            }

            // start animation
            (function loop() {
                var word = isSingleWord ? o.words : o.words[i];
                var callback = isSingleWord ? null : loop;

                transitionText(word, $this, o.delay, callback);
                i = (i + 1) % o.words.length;
            })();
        });
    };

    function transitionText(text, $this, delay, callback) {
        $this.delay(delay)
            .animate({ "width": "toggle" }, $.proxy($this.text, $this, text))
            .animate({ "width": "toggle" }, callback)
        ;
    }

    // plugin defaults
    $.fn.slideTextLeft.defaults = {
        words: [],
        delay: 2000
    };
})($);
/** Page Code */
$('.text-left').slideTextLeft({
    words: ["Support", "Advice", "Friendship","Hope"], delay: 2000
});