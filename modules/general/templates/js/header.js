$(function () {
    if (window.PIE || document.PIE) {
        $('#pvm-right').each(function () {
            PIE.attach(this);
        });
    }
});
//replaceCufon();
function CvChar(str) {
    str = str.replace(/\\/g, '');
    str = str.replace(/\&lt;/g, '<');
    str = str.replace(/\&gt;/g, '>');
    str = str.replace(/\&amp;/g, '&');
    str = str.replace(/\&quot;/g, '"');
    str = str.replace(/\&\#039;/g, '\'');
    return str;
}
$(document).ready(function () {
    if ($('#email_address').val() == '' && $('#login').val() == true) {
        confirmEmail(authentic_id);
    }
    var location = window.location.href;
    var url = '/modules/general/action.php?action=load-background';
    $.post(url, {location: location, pro_type: pro_type, _action: _action, id: pro_id}, function (data) {
        var result = jQuery.parseJSON(data);
        if (result.url) {
            var link = CvChar(result.url);
            $('body').css({'background-image': 'url(' + link + ')',
                'background-position': 'top center'});
            if (result.repeat == 1)  $('body').css('background-repeat', 'repeat-x repeat y'); else $('body').css('background-repeat', 'no-repeat');
            if (result.fixed == 1)  $('body').css('background-attachment', 'fixed');
            if (result.color != '')  $('body').css('background-color', result.color);
        } else {
            /*$('body').css('background', 'white');*/
        }
    }, 'html');
});
var check = new CheckBasic();
if (document.getElementsByTagName) {
    var inputElements = document.getElementsByTagName("input");
    for (i = 0; inputElements[i]; i++) {
        if (inputElements[i].className && (inputElements[i].className.indexOf("disable-auto-complete") != -1)) {
            inputElements[i].setAttribute("autocomplete", "off");
        }
    }
}
function langSwitch(lang) {
    var url = ROOTURL + '?lang=' + lang + '&redirect_url=' + encodeURIComponent(document.URL);
    document.location = url;
}