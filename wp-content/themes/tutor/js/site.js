
(function($) {
    // here $ would be point to jQuery object
    $(document).ready(function() {
        if ($('.widget_wpfb_catlistwidget').length > 0) {
            $('.widget_wpfb_catlistwidget > ul > li > a').removeAttr('href');
            $('.widget_wpfb_catlistwidget > ul > li > ul').hide();

            $('.widget_wpfb_catlistwidget > ul > li > a').click(function() {
                $(this).toggleClass('expanded').toggleClass('collapsed').parent().find('> ul').slideToggle('fast');
            });

            $('.widget_wpfb_catlistwidget > ul > li > a:first').click();
        }


        if ($('#statistics').length > 0) {
            $('#statistics .st-online').html($('#statistics .st-online').html() + getRandomInt(10, 20));
            $('#statistics .st-today').html($('#statistics .st-online').html() + getRandomInt(50, 100));
            $('#statistics .st-yesterday').html($('#statistics .st-online').html() + getRandomInt(500, 1000));
            $('#statistics .st-last-week').html($('#statistics .st-online').html() + getRandomInt(500, 1000));
            $('#statistics .st-last-month').html($('#statistics .st-online').html() + getRandomInt(1000, 1500));
            $('#statistics .st-all').html($('#statistics .st-online').html() + getRandomInt(10000, 50000));
        }

        function getRandomInt(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }
    });
})(jQuery);
