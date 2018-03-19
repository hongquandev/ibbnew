var expDays = 1; // number of days the cookie should last

function GetCookie(name) {
    var arg = name + "=";
    var alen = arg.length;
    var clen = document.cookie.length;
    var i = 0;
    while (i < clen) {
        var j = i + alen;
        if (document.cookie.substring(i, j) == arg)
            return getCookieVal(j);
        i = document.cookie.indexOf(" ", i) + 1;
        if (i == 0) break;
    }
    return null;
}

function SetCookie(name, value) {
    var argv = SetCookie.arguments;
    var argc = SetCookie.arguments.length;
    var expires = (argc > 2) ? argv[2] : null;
    var path = (argc > 3) ? argv[3] : null;
    var domain = (argc > 4) ? argv[4] : null;
    var secure = (argc > 5) ? argv[5] : false;
    document.cookie = name + "=" + escape(value) +
        ((expires == null) ? "" : ("; expires=" + expires.toGMTString())) +
        ((path == null) ? "" : ("; path=" + path)) +
        ((domain == null) ? "" : ("; domain=" + domain)) +
        ((secure == true) ? "; secure" : "");
}

function DeleteCookie(name) {
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval = GetCookie(name);
    document.cookie = name + "=" + cval + "; expires=" + exp.toGMTString();
}

var exp = new Date();
exp.setTime(exp.getTime() + (expDays * 24 * 60 * 60 * 1000));

function amt() {
    var count = GetCookie('count');
    if (count == null) {
        SetCookie('count', '1');
        return 1
    } else {
        var newcount = parseInt(count) + 1;
        DeleteCookie('count');
        SetCookie('count', newcount, exp);
        return count
    }
}

function getCookieVal(offset) {
    var endstr = document.cookie.indexOf(";", offset);
    if (endstr == -1)
        endstr = document.cookie.length;
    return unescape(document.cookie.substring(offset, endstr));
}

function checkCount() {
    //DeleteCookie('count');
    var count = GetCookie('count');
    if (count == null) {
        count = 1;
        SetCookie('count', count, exp);
        //gosPopup.show('#guide-content');
        //TourGuideAjax();
    } else {
        count++;
        SetCookie('count', count, exp);
    }
}


var TourGuide = function () {
    this.prepare = null;
    this.finish = null;
    this.type_send = 'html';
}

TourGuide.prototype = {
    send:function (url) {

        if (this.prepare != null) {
            this.prepare();
        }

        if (this.finish != null) {
            jQuery.post(url, {}, this.finish, this.type_send);
        } else {
            jQuery.post(url, {}, this.onSend, this.type_send);
        }
    }, onSend:function (data) {
        var info = jQuery.parseJSON(data);
        if (info.data) {
            jQuery('#pvm-right').html(info.data);
        } else {
            alert('failure');
        }

    }
}

var tourguide = new TourGuide();
var tg_popup = null;

tourguide.prepare = function () {
    jQuery('#viewmore_loading').show();
};

tourguide.finish = function (data) {
    var info = jQuery.parseJSON(data);
    if (info.data) {
        jQuery('#pvm-right').html(info.data);
    } else {
        alert('failure');
    }
    jQuery('#viewmore_loading').hide();

};
//END
function showTourGuide() {
    tg_popup.show().toCenter();
}

function closeTourGuide() {
    jQuery('#pvm_loading').hide();
    jQuery(tg_popup.container).fadeOut('slow', function () {
        tg_popup.hide()
    });
}

function TourGuideAjax() {
    par = new Object();
    showLoadingPopup2();
    jQuery.post('/modules/general/action.php?action=tourguide-content', par,
        function (data) {
            closeLoadingPopup2();
            var data = jQuery.parseJSON(data);
            if (data.success) {
                tg_popup = new Popup();
                tg_popup.init({id:'tourguide_popup', className:'popup_overlay'});
                tg_popup.updateContainer('<div style="border: 2px solid #CC8C04" class="popup_container guide-content popup-container-vm popup-vm-container">' + data.html + '</div>');
                showTourGuide();
                //document.location = ROOTURL + '/landing-page.html';
                Cufon.replace('#guide_menu');
                Cufon.replace('.title_menu');
            }
        }
        , 'html')
}

function TourGuideShowContent(id) {
    jQuery('.content', '#content-right').each(function () {
        jQuery(this).hide();
    });
    jQuery('#content_' + id, '#content-right').show();
}
function guideNext(count) {
    target_id = 0;
    jQuery('.content', '#content-right').each(function () {
        if (jQuery(this).css('display') == 'block') {
            target_id = parseInt(jQuery(this).attr('id'));
        }
        jQuery(this).hide();
    });
    target_id = target_id + 1;
    if (target_id > count) {
        target_id = 0;
    }
    jQuery('#' + target_id, '#content-right').show();
}
function guidePrev(count) {
    target_id = 0;
    jQuery('.content', '#content-right').each(function () {
        if (jQuery(this).css('display') == 'block') {
            target_id = parseInt(jQuery(this).attr('id'));
        }
        jQuery(this).hide();
    });
    target_id = target_id - 1;
    if (target_id < 0) {
        target_id = count;
    }
    jQuery('#' + target_id, '#content-right').show();
}

window.onload = checkCount;
