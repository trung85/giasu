
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

        if ($('#account-bank').length > 0) {
            $("#account-bank").hide();

            $("#account-bank").parent().parent().addClass('account-bank');

            $('.account-bank').click(function() {
                $("#account-bank").removeAttr("style");
                $(this).toggleClass('expanded').toggleClass('collapsed').find('> div').slideToggle('fast');
            });
            $('.account-bank').click();
        }

        if ($('#statistics').length > 0) {
            $('#statistics .st-online').html($('#statistics .st-online').html() + getRandomInt(10, 20));
            $('#statistics .st-today').html($('#statistics .st-online').html() + getRandomInt(50, 100));
            $('#statistics .st-yesterday').html($('#statistics .st-online').html() + getRandomInt(500, 1000));
            $('#statistics .st-last-week').html($('#statistics .st-online').html() + getRandomInt(500, 1000));
            $('#statistics .st-last-month').html($('#statistics .st-online').html() + getRandomInt(1000, 1500));
            $('#statistics .st-all').html($('#statistics .st-online').html() + getRandomInt(10000, 50000));
        }

        if ($('#register_post_id').length > 0 && $('#your-class-id').length > 0) {
            $('#your-class-id').val($('#register_post_id').val());
            $('#your-class-name').val($('#register_post_title').val());
            $('#your-class-code').val($('#register_post_ma_so').val());
        }

        $('#category-list').DataTable({
            bFilter: false,
            bInfo: false,
            bLengthChange: false,
            bProcessing: true,
            sDom: '<"top"flp>rt<"bottom"i><"clear">',
            oLanguage: {
                oPaginate: {
                    sPrevious: "Trang Trước",
                    sNext: "Trang Sau",
                }
            }
        });
        $('#category-lopmoi').DataTable({
            bFilter: false,
            bInfo: false,
            bLengthChange: false,
            bProcessing: true,
            sDom: '<"top"flp>rt<"bottom"i><"clear">',
            oLanguage: {
                oPaginate: {
                    sPrevious: "Trang Trước",
                    sNext: "Trang Sau",
                }
            }
        });

        function getRandomInt(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }
    });
})(jQuery);
