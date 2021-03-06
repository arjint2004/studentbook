(function ($) {
    $.fn.jwSlider = function (b) {
        var c = {
            speed: 1000,
            pause: 2000,
            transition: 'fade'
        }, b = $.extend(c, b);
        if (b.pause <= b.speed) b.pause = b.speed + 100;
        return this.each(function () {
            var a = $(this);
            a.wrap('<div class="slider-wrap" />');
            a.css({
                'width': '99999px',
                'position': 'relative',
                'padding': 0
            });
            if (b.transition === 'slide') {
                a.children().css({
                    'float': 'left',
                    'list-style': 'none'
                });
                $('.slider-wrap').css({
                    'width': a.children().width(),
                    'overflow': 'hidden',
                    'float' : 'left',
                    'margin-left' : '13%'
                })
            }

            if (b.transition === 'fade') {
                a.children().css({
                    'width': a.children().width(),
                    'position': 'absolute',
                    'left': 0
                });
                for (var i = a.children().length, y = 0; i > 0; i--, y++) {
                    a.children().eq(y).css('zIndex', i + 99999)
                }
                fade()
            }
            if (b.transition === 'random') {
                 a.children().css({
                    'float': 'left',
                    'list-style': 'none'
                });
                $('.slider-wrap').css({
                    'width': a.children().width(),
                    'overflow': 'hidden',
                    'float' : 'left',
                    'margin-left' : '13%'
                })
                for (var i = a.children().length, y = 0; i > 0; i--, y++) {
                    a.children().eq(y).css('zIndex', i + 99999)
                }
                fade()
            }
            if (b.transition === 'slide') slide();

            function slide() {
                setInterval(function () {
                    a.animate({
                        'left': '-' + a.parent().width()
                    }, b.speed, function () {
                        a.css('left', 0).children(':first').appendTo(a)
                    })
                }, b.pause)
            }

            function random() {
                setInterval(function () {
                    a.animate({
                        'random': '-' + a.parent().width()
                    }, b.speed, function () {
                        a.css('random', 0).children(':first').appendTo(a)
                    })
                }, b.pause)
            }

            function fade() {
                setInterval(function () {
                    a.children(':first').animate({
                        'opacity': 0
                    }, b.speed, function () {
                        a.children(':first').css('opacity', 1).css('zIndex', a.children(':last').css('zIndex') - 1).appendTo(a)
                    })
                }, b.pause)
            }
        })
    }
})(jQuery);