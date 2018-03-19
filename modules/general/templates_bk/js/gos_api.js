/***************************/
//@Author: TUONG NGUYEN - GOS Viet Nam
//@website: www.gos.com.vn
//@email: tuong@gos.com.vn
//@license: Feel free to use it, but keep this credits please!					
/***************************/


var gosPopup = {
    popupStatus: 0,
    
    'loadPopup': function(id){
        if (gosPopup.popupStatus == 0) {
            $("#backgroundPopup").css({
                "opacity": "0.7"
            });
            $("#backgroundPopup").fadeIn("slow");
            $(id).fadeIn("slow");
            gosPopup.popupStatus = 1;
        }
    },
    
    'disablePopup': function(id){
        if (gosPopup.popupStatus == 1) {
            $("#backgroundPopup").fadeOut("slow");
            $(id).fadeOut("slow");
            gosPopup.popupStatus = 0;
        }
    },
    
    'centerPopup': function(id){
        //request data for centering
        var windowWidth = document.documentElement.clientWidth;
        var windowHeight = document.documentElement.clientHeight;
        var popupHeight = $(id).height();
        var popupWidth = $(id).width();
        //centering
        $(id).css({
            "position": "absolute",
            "top": windowHeight / 2 - popupHeight / 2,
            "left": windowWidth / 2 - popupWidth / 2
        });
        //only need force for IE6
        
        $("#backgroundPopup").css({
            "height": windowHeight
        });
    },
    
    'show': function(id){
        gosPopup.centerPopup(id);
        //load popup
        gosPopup.loadPopup(id);
    },
    'hide': function(id){
        gosPopup.disablePopup(id);
    }
}

var gosMenu = {
    'onhover': function(id){
        var ele = document.getElementById(id);
        if( ele == null){return true;}
        if (ele.style.display == 'none') {
            ele.style.display = '';
			var el = $('#' + id);
			var p = el.offset();
			var right = el.width() + p.left;

            if ($.browser.msie && parseFloat($.browser.version) == 7){
                var sp = 24;
            }else{
                var sp = 23;
            }

			var win_width = $(window).width();
			var web_bound = 960;
			var limit = web_bound + parseInt((win_width - web_bound) / 2 );
			if (right > limit) {
				var left = p.left - (right - limit);
				el.offset({top: el.top, left: left - sp});
			}
        }
        else {
            ele.style.display = 'none';
        }
        
    }
}

function replaceCufon()
{
	if (window['Cufon'] != undefined || document['Cufon'] != undefined)
		{
			//Cufon.replace('.cufon, .quicksearch-title, .bar-title h2, .feature-box h3, .cms h3, .title h3, h2, .ma-hello h3, h4, .user-register h1', {hover:true, fontFamily: 'Neutra Text' });
		}
};


