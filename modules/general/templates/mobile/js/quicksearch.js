var quicksearch_overlay = new Search();
quicksearch_overlay._frm = '#frmSearch';
quicksearch_overlay._text_search = '#quick_region';
quicksearch_overlay._overlay_container = '#quick_search_overlay';
quicksearch_overlay._url_suff = '&'+'type=suburb';

quicksearch_overlay._success = function(data) {
    var info = jQuery.parseJSON(data);
    var content_str = "";
    var id = 0;
    if (info.length > 0) {
        quicksearch_overlay._total = info.length;
        for (i = 0; i < info.length; i++) {
            var id = 'sitem_' + i;
            content_str +="<li onclick='quicksearch_overlay.set2SearchText(this)' id='"+id+"'>"+info[i]+"</li>";
            quicksearch_overlay._item.push(id);
        }
    }
    
    if (content_str.length > 0) {
        jQuery(quicksearch_overlay._overlay_container).html(content_str);
        jQuery(quicksearch_overlay._overlay_container).show();
        jQuery(quicksearch_overlay._overlay_container).width(jQuery(quicksearch_overlay._text_search).width());
    } else {
        jQuery(quicksearch_overlay._overlay_container).hide();
    }
	jQuery(quicksearch_overlay._text_search).removeClass('search_loading');
};

document.onclick = function() {quicksearch_overlay.closeOverlay()};

    if(typeof maphilight == "function"){
        $('.mapAreasAU').maphilight();
        $.fn.maphilight.defaults = {
            fill: true,
            /* Change Effect Color 98051a, ff0000*/
            fillColor: 'e4ba64',
            fillOpacity: 0.6,
            stroke: true,
            strokeColor: 'ebc26e',
            strokeOpacity: 1,
            strokeWidth: 0,
            fade: true,
            alwaysOn: false,
            neverOn: false,
            groupBy: false
        }
    }


    jQuery(document).ready(function(){
        if(typeof pro == 'object'){
            pro.onChangeKind('#property_kind');
        }
    });

	function submitenter(myfield,e) {
		var keycode;
		if (window.event) keycode = window.event.keyCode;
		else if (e) keycode = e.which;
		else return true;
		
		if (keycode == 13) {
			   myfield.form.submit();
			   return false;
		} else
			return true;
	}

