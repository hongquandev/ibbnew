function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
function getOSName() {
    var OSName = 'unknownOS';
    if (navigator.appVersion.indexOf("Win") != -1) OSName = "Windows";
    if (navigator.appVersion.indexOf("Mac") != -1) OSName = "Mac";
    if (navigator.appVersion.indexOf("X11") != -1) OSName = "UNIX";
    if (navigator.appVersion.indexOf("Linux") != -1) OSName = "Linux";
    return 'OS_' + OSName;
}

function getBrowserName() {
    var name = "Unknown";
    if (navigator.userAgent.indexOf("MSIE") != -1) {
        name = "MSIE";
    }
    else if (navigator.userAgent.indexOf("Firefox") != -1) {
        name = "Firefox";
    }
    else if (navigator.userAgent.indexOf("Opera") != -1) {
        name = "Opera";
    }
    else if (navigator.userAgent.indexOf("Chrome") != -1) {
        name = "Chrome";
    }
    else if (navigator.userAgent.indexOf("Safari") != -1) {
        name = "Safari";
    }
    return 'BS_' + name;
}
/**/
function isSecureUrl(link) {
    if (json_secure_url_scanned.length > 0) {
        for (var i = 0; i < json_secure_url_scanned.length; i++) {
            try {
                if (link.indexOf(json_secure_url_scanned[i]) >= 0) {
                    return true;
                }
            } catch (err) {
            }
        }
    }
    return false;
}

function toSSL(link) {
    if (link.indexOf('https') >= 0) {
        return link;
    } else if (link.indexOf('http') >= 0) {
        return link.replace('http', 'https');
    } else {
        if (link.indexOf('/') != 0) {
            link = '/' + link;
        }
        return 'https://' + window.location.hostname + link;
    }
}

function CheckValidUrl(strUrl) {
    var RegexUrl = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
    return RegexUrl.test(strUrl);
}
jQuery(document).ready(function () {
    //makeAnOfferAccept();
    /**/
    Common.checkSub();
    Common.remindPayment();
    $("select").uniform();
    $("select").show();
    jQuery('a').each(function () {
        var href = jQuery(this).attr('href');

        if (isSecureUrl(href)) {
            jQuery(this).attr('href', toSSL(href));
        }
    });
    jQuery('form').each(function () {
        var action = jQuery(this).attr('action');
        if (isSecureUrl(action)) {
            jQuery(this).attr('action', toSSL(action));
        }
    });
    var doc = $(document).width();
    var wrapper = $('.wrapper-content').width();
    if ($('#wrap-left img').length > 0 || $('#wrap-right img').length > 0) {
        var width = (doc - wrapper) / 2;
        if ($('#wrap-left img').width() > width) {
            $('#wrap-left img').width(width);
        }

        if ($('#wrap-right img').width() > width) {
            $('#wrap-right img').width(width);
        }
        $('#wrap-left, #wrap-right').width(width - 10);
        var header = jQuery('.wrapper.custom-theme1>div:first-child>div:first-child');
        $(header).width(header.width() + 20);
        setTimeout(function () {
            $('#wrap-left, #wrap-right').height($(document).height());
        }, 3000)
    } else {
        $('#wrap-left, #wrap-right').hide();
    }

});
jQuery('body').addClass(getOSName()).addClass(getBrowserName()).addClass(getOSName() + '_' + getBrowserName());

