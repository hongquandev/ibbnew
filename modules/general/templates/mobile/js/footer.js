jQuery(document).ready(function () {
    var wrapper_height = $('.wrapper').height();
    var window_height = $(window).height();
    var footer_height = $('.footer.f-l').height();
    if (wrapper_height + footer_height < window_height) {
        $('.wrapper').css('min-height', $(window).height() + 'px');
        $('.footer').css({
            'position': 'absolute',
            'bottom': '0',
            'width': '100%'
        });
    }
});

