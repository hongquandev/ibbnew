var search_overlay = new Search();
search_overlay._frm = '#frmSearch';
search_overlay._text_search = '#region';
search_overlay._overlay_container = '#search_overlay';
search_overlay._url_suff = '&'+'type=suburb';

search_overlay._success = function(data) {
    var info = jQuery.parseJSON(data);
    var content_str = "";
    var id = 0;
    if (info.length > 0) {
        search_overlay._total = info.length;
        for (i = 0; i < info.length; i++) {
            var id = 'sitem_' + i;
            content_str +="<li onclick='search_overlay.set2SearchText(this)' id='"+id+"'>"+info[i]+"</li>";
            search_overlay._item.push(id);
        }
    }

    if (content_str.length > 0) {
        jQuery(search_overlay._overlay_container).html(content_str);
        jQuery(search_overlay._overlay_container).show();
        jQuery(search_overlay._overlay_container).width(jQuery(search_overlay._text_search).width());
    } else {
        jQuery(search_overlay._overlay_container).hide();
    }
    jQuery(search_overlay._text_search).removeClass('search_loading');
};

document.onclick = function() {search_overlay.closeOverlay()};

/* function OrderChangeStateCode(combo,form_action,mode){
 document.getElementById('order_by').value = combo.value;
 document.getElementById('frmSearch').action = '/'+form_action+mode;
 return document.getElementById('frmSearch').submit();
 }*/

jQuery(document).ready(function(){
    $.fn.maphilight.defaults = {
        fill: true,
        fillColor: '017db9',
        fillOpacity: 0.6,
        stroke: true,
        strokeColor: '017db9',
        strokeOpacity: 1,
        strokeWidth: 0,
        fade: true,
        alwaysOn: false,
        neverOn: false,
        groupBy: false
    }
    $('.mapAreasAU').maphilight();
});


