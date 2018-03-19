(function(jQuery) {
    jQuery.fn.tipsy = function(options) {

        options = jQuery.extend({}, jQuery.fn.tipsy.defaults, options);
        
        return this.each(function() {
            
            var opts = jQuery.fn.tipsy.elementOptions(this, options);
            
            jQuery(this).hover(function() {

                jQuery.data(this, 'cancel.tipsy', true);

                var tip = jQuery.data(this, 'active.tipsy');
                if (!tip) {
                    tip = jQuery('<div class="tipsy"><div class="tipsy-inner"/></div>');
                    tip.css({position: 'absolute', zIndex: 100000});
                    jQuery.data(this, 'active.tipsy', tip);
                }

                if (jQuery(this).attr('title') || typeof(jQuery(this).attr('original-title')) != 'string') {
                    jQuery(this).attr('original-title', jQuery(this).attr('title') || '').removeAttr('title');
                }

                var title;
                if (typeof opts.title == 'string') {
                    title = jQuery(this).attr(opts.title == 'title' ? 'original-title' : opts.title);
                } else if (typeof opts.title == 'function') {
                    title = opts.title.call(this);
                }

                tip.find('.tipsy-inner')[opts.html ? 'html' : 'text'](title || opts.fallback);

                var pos = jQuery.extend({}, jQuery(this).offset(), {width: this.offsetWidth, height: this.offsetHeight});
                tip.get(0).className = 'tipsy'; // reset classname in case of dynamic gravity
                tip.remove().css({top: 0, left: 0, visibility: 'hidden', display: 'block'}).appendTo(document.body);
                var actualWidth = tip[0].offsetWidth, actualHeight = tip[0].offsetHeight;
                var gravity = (typeof opts.gravity == 'function') ? opts.gravity.call(this) : opts.gravity;

                switch (gravity.charAt(0)) {
                    case 'n':
                        tip.css({top: pos.top + pos.height, left: pos.left + pos.width / 2 - actualWidth / 2}).addClass('tipsy-north');
                        break;
                    case 's':
                        tip.css({top: pos.top - actualHeight, left: pos.left + pos.width / 2 - actualWidth / 2}).addClass('tipsy-south');
                        break;
                    case 'e':
                        tip.css({top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left - actualWidth}).addClass('tipsy-east');
                        break;
                    case 'w':
                        tip.css({top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left + pos.width}).addClass('tipsy-west');
                        break;
                }

                if (opts.fade) {
                    tip.css({opacity: 0, display: 'block', visibility: 'visible'}).animate({opacity: 0.8});
                } else {
                    tip.css({visibility: 'visible'});
                }

            }, function() {
                jQuery.data(this, 'cancel.tipsy', false);
                var self = this;
                setTimeout(function() {
                    if (jQuery.data(this, 'cancel.tipsy')) return;
                    var tip = jQuery.data(self, 'active.tipsy');
                    if (opts.fade) {
                        tip.stop().fadeOut(function() { jQuery(this).remove(); });
                    } else {
                        tip.remove();
                    }
                }, 100);

            });
            
        });
        
    };
    
    // Overwrite this method to provide options on a per-element basis.
    // For example, you could store the gravity in a 'tipsy-gravity' attribute:
    // return jQuery.extend({}, options, {gravity: jQuery(ele).attr('tipsy-gravity') || 'n' });
    // (remember - do not modify 'options' in place!)
    jQuery.fn.tipsy.elementOptions = function(ele, options) {
        return jQuery.metadata ? jQuery.extend({}, options, jQuery(ele).metadata()) : options;
    };
    
    jQuery.fn.tipsy.defaults = {
        fade: false,
        fallback: '',
        gravity: 'n',
        html: false,
        title: 'title'
    };
    
    jQuery.fn.tipsy.autoNS = function() {
        return jQuery(this).offset().top > (jQuery(document).scrollTop() + jQuery(window).height() / 2) ? 's' : 'n';
    };
    
    jQuery.fn.tipsy.autoWE = function() {
        return jQuery(this).offset().left > (jQuery(document).scrollLeft() + jQuery(window).width() / 2) ? 'e' : 'w';
    };
    
})(jQuery);
