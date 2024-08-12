(function(window, $) {

    // USE STRICT
    "use strict";

    var newsomaticClass = $(".newsomatic-news-ticker")[0];
    var rtl = newsomaticClass.getAttribute('data-rtl-type');

    $('.newsomatic-news-ticker-marquee').AcmeTicker({
        type: 'marquee',
        direction: (rtl == 'rtl' ? 'right' : 'left'),
        speed: 0.05
    });

    $('.newsomatic-news-ticker-horizontal').AcmeTicker({
        type: 'horizontal',
        direction: (rtl == 'rtl' ? 'left' : 'right'),
        speed: 1000
    });

    $('.newsomatic-news-ticker-typewriter').AcmeTicker({
        type: 'typewriter',
        direction: 'left',
        speed: 50
    });

    $('.newsomatic-news-ticker-vertical').AcmeTicker({
        type: 'vertical',
        direction: 'right',
        speed: 600
    });

})(window, jQuery);