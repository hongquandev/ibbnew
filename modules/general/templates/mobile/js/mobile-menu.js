// @codekit-prepend lib/modernizr-2.6.1.min.js
// @codekit-prepend lib/respond.js
// @codekit-prepend lib/jRespond.js
// @codekit-prepend lib/highlight.min.js
// @codekit-prepend lib/jquery-1.9.0.js
// @codekit-prepend lib/jquery.jpanelmenu.min.js
// @codekit-prepend lib/plugins.js

var jPanelMenu = {};
jQuery(document).ready(function() {
	jPanelMenu = jQuery.jPanelMenu();
	var jR = jRespond([
		{
			label: 'small',
			enter: 0,
			exit: 800
		},{
			label: 'large',
			enter: 800,
			exit: 10000
		}
	]);

	jR.addFunc({
		breakpoint: 'small',
		enter: function() {
			jPanelMenu.on();
			jQuery(document).on('click',jPanelMenu.menu + ' li a',function(e){
				if ( jPanelMenu.isOpen() && jQuery(e.target).attr('href').substring(0,1) == '#' ) { jPanelMenu.close(); }
			});
		},
		exit: function() {
			jPanelMenu.off();
			jQuery(document).off('click',jPanelMenu.menu + ' li a');
		}
	});

    jQuery('#jPanelMenu-menu li').each(function(){
        if (jQuery(this).find('ul.sub-nav').length > 0){
            var that = jQuery(this);
            var href = jQuery(this).find('a').attr('href');
            var obj;
            if (href != 'javascript:void(0)'){
                obj = jQuery(this).find('.icon-nav');
            }else{
                obj = jQuery(this);
            }
            obj.bind('click',function(){
                 //that.find('ul.sub-nav').toggle();
                if (that.find('ul.sub-nav').is(":visible")){
                    that.find('ul.sub-nav').slideUp();
                    that.find('.icon-nav').html('+');
                    obj.removeClass('nav-show');
                }else{
                    that.find('ul.sub-nav').slideDown();
                    that.find('.icon-nav').html('-');
                    obj.addClass('nav-show');

                }
            });
        }
    })

    var DELAY = 2000,
            clicks = 0,
            timer = null;

    $('.menu-search').bind({
        click: function(e) {
            if (jQuery('.qs-box').is(':hidden')) {
                jQuery('.qs-box').slideDown();
            } else {
                jQuery('.qs-box').slideUp();
            }
        }
    });

    jQuery('.search-nav').bind('click', function() {
        jQuery('.qs-box').slideUp();
    })
});