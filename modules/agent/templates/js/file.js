jQuery(document).ready(function () {
    (function ($) {
        $.fn.customFileInput = function (options) {
            var settings = $.extend({
                'width': '108px', //width of button
                'height': '29px',  //height of text
                'btnText': 'Upload file' //text of the button
            }, options);
            this.each(function () {
                if (!$(this).hasClass('fileWrap')) {
                    $(this).addClass('fileWrap').css({width: settings.width})
                        .append("<input type='button' class='file-button' value='" + settings.btnText + "' style='height:" + settings.height + "' />")
                        .find("input[type='file']").css({
                        height: settings.height,
                        width: settings.width,
                        zIndex: '99',
                        position: 'absolute',
                        //right: '0',
                        left: '0',
                        top: ($(this).outerHeight() - settings.height) / 2 + 'px'
                    }).fadeTo(100, 0);
                }
            });
            $(".fileWrap input[type='file']").change(function () {
                var val = $(this).val().split('\\');
                var newVal = val[val.length-1];
                $(this).closest('.file-box').find(".file-name").text(newVal);
                $(this).closest('.file-box').find(".file-action").text('Delete');
                $(this).closest('.file-box').find(".file-delete").val('')
            })
        };
    })(jQuery);
    jQuery(".file").customFileInput({
        'btnText': 'Upload file' //text of the button
    });
    jQuery('span.file-action').click(function(){
        var deleted_obj = jQuery(this).closest('.file-box').find(".file-delete");
        if(deleted_obj.val() == 'deleted'){}else{
            deleted_obj.val('deleted');
            $(this).closest('.file-box').find(".file-name").text('');
            $(this).closest('.file-box').find(".file-action").text('No file');
        }
    });
});