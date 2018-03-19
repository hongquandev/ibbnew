<script type="text/javascript" src="{$ROOTURL}/modules/general/templates/js/image-lightbox/imagelightbox.js"></script>
<link rel="stylesheet" href="{$ROOTURL}/modules/general/templates/js/image-lightbox/style.css">
{*	<script type="text/javascript" src="/modules/general/templates/shadowbox/shadowbox.js"></script>
	<script type="text/javascript" src="/modules/general/templates/shadowbox/demo.js"></script>
{literal}
	<script type="text/javascript">
        Shadowbox.init({
            overlayOpacity: 0.8
        }, setupDemos);
    </script>
	<script type="text/javascript">
            replaceCufon('lightbox-cufon');
    </script>
{/literal}*}
{*<h2  class="lightbox-cufon lightbox-vm-h2">Photos</h2>*}
<div class="lightbox-vmm-ing">
		<ul class="gallery photos">
            {if isset($info.photo) and count($info.photo) > 0}
                 {foreach from = $info.photo key = k item = row}
                        <li class="li-media lightbox-vmm-li">
                           <a data-imagelightbox="photo" href="{$MEDIAURL}/{$row.overlay_file_name}">
                                <img class="border img-media" src="{$MEDIAURL}/{$row.file_name}" />
                           </a>
                        </li>
                {/foreach}
            {elseif count($info.photo) == 0}
             	<span>No content provided.</span>
            {/if}
		</ul>
</div>
<div class="clearthis"></div>
{literal}
<script type="text/javascript">
    //jQuery(document).ready(function() {

        var activityIndicatorOn = function() {
            $('<div id="imagelightbox-loading"><div></div></div>').appendTo('body');
        },
                activityIndicatorOff = function() {
                    $('#imagelightbox-loading').remove();
                },

                overlayOn = function() {
                    $('<div id="imagelightbox-overlay"></div>').appendTo('body');
                },
                overlayOff = function() {
                    $('#imagelightbox-overlay').remove();
                },

                closeButtonOn = function(instance) {
                    $('<a href="#" id="imagelightbox-close">Close</a>').appendTo('body').on('click touchend', function() {
                        $(this).remove();
                        instance.quitImageLightbox();
                        return false;
                    });
                },
                closeButtonOff = function() {
                    $('#imagelightbox-close').remove();
                },

                captionOn = function() {
                    var description = $('a[href="' + $('#imagelightbox').attr('src') + '"] img').attr('alt');
                    if (description.length > 0)
                        $('<div id="imagelightbox-caption">' + description + '</div>').appendTo('body');
                },
                captionOff = function() {
                    $('#imagelightbox-caption').remove();
                },

                navigationOn = function(instance, selector) {
                    var images = $(selector);
                    if (images.length) {
                        var nav = $('<div id="imagelightbox-nav"></div>');
                        for (var i = 0; i < images.length; i++)
                            nav.append('<a href="#"></a>');

                        nav.appendTo('body');
                        nav.on('click touchend', function() {
                            return false;
                        });

                        var navItems = nav.find('a');
                        navItems.on('click touchend', function() {
                            var $this = $(this);
                            if (images.eq($this.index()).attr('href') != $('#imagelightbox').attr('src'))
                                instance.switchImageLightbox($this.index());

                            navItems.removeClass('active');
                            navItems.eq($this.index()).addClass('active');

                            return false;
                        })
                                .on('touchend', function() {
                                    return false;
                                });
                    }
                },
                navigationUpdate = function(selector) {
                    var items = $('#imagelightbox-nav a');
                    items.removeClass('active');
                    items.eq($(selector).filter('[href="' + $('#imagelightbox').attr('src') + '"]').index(selector)).addClass('active');
                },
                navigationOff = function() {
                    $('#imagelightbox-nav').remove();
                };

        jQuery('a[data-imagelightbox="photo"]').imageLightbox(
                {
                    onStart:      function() {
                        overlayOn();
                    },
                    onEnd:          function() {
                        overlayOff();
                        activityIndicatorOff();
                    },
                    onLoadStart: function() {
                        activityIndicatorOn();
                    },
                    onLoadEnd:     function() {
                        activityIndicatorOff();
                    }
                });
    //});
</script>
{/literal}

