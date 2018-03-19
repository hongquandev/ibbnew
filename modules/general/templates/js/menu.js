var hs = hs || {};
hs.c = new Object();

var dashboard=dashboard?dashboard:{};
dashboard.topLevelMenuItems=$([]);
dashboard.updateMenuItemActive=function(a){
	dashboard.topLevelMenuItems.removeClass("active").filter("._"+a).addClass("active")
};
dashboard.init=function(){

	dashboard.topLevelMenuItems=$("._bottomNav ._bottomNavMenu ._links a");
	//_.defer(resizeUpdate);
	$("a[href='#']").bind("click",function(a){a.preventDefault()});
	var b,c=function(a){b&&clearTimeout(b);typeof a=="undefined"&&(a=true);
	dashboard.toggleLaunchSidebar(a)};
	$("._bottomNav").bind("mouseenter",
		function(){b&&clearTimeout(b);b=setTimeout(function(){dashboard.toggleLaunchSidebar();},275)}).bind("mouseleave",function(){c()}).bind("click",function(){c("hide")});
	$("._bottomNav ._noclose").bind("click",function(a){a.stopImmediatePropagation();return false});
	var d=$(" ._bottomNav ._bottomNavMenu ._links a");
	d.bind("click",function(){d.removeClass("active");
	$(this).addClass("active")});

};
dashboard.toggleLaunchSidebar=function(a,b){

    var c=$("._bottomNavMenu"),d=c.closest("._bottomNav");$("#dashboard");$([]);
	var e='100%',f=d.hasClass("hover")&&d.width()==e;

    if(a||!f){if(a){
		if(d.removeClass("hover menuOpen"),e=43,a=="hide"){
			c.stop(true).css("width",43);
			$.isFunction(b)&&b();return
		}
	}else{
        d.addClass("hover");
        $.each($('.globalNav li div.navSubMenu'),function(){
            var position = $(this).outerHeight()/2;
            $(this).css('bottom','-'+position+'px');
            var l = $('.hover.menuOpen').width();
            $(this).css('left',l+'px');
        });
    }
        if (!hs.pendingAdReload && $("#adFrame").length > 0)
            setTimeout(function() {
                $("#adFrame")[0].contentWindow.location.reload();
                hs.pendingAdReload = false
            }, 5E4),hs.pendingAdReload = true;
        _.defer(function() {
            c.stop(true, true).animate({width:e}, {duration:100,complete:function() {
                        d.removeClass("menuOpen");
                        a || (d.addClass("menuOpen"),c.css("overflow", ""));
                        var l = $('.hover.menuOpen').width();
                        $('.globalNav li div.navSubMenu').css('left',l+'px');
                        $.isFunction(b) && b()
                    }})
        })
    }
};