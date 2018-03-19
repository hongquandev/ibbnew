</div>

<div style="height:29px; background-color:#01aef0">
	<div class="h-bottom1">
    	<a href=""><img src="/modules/general/templates/images/fb-icon.png"/> <span>Follow Us</span></a>
    </div>
</div>

<div style="height:286px; background-color:#373d4b">
    <div class="h-bottom2">
 		<div class="f-c" style="height: 246px; width: 923px;">
            <div class="f-blocks" style="min-height: 194px;max-height: 195px;">
                 {$footer_menu}
            </div>
        </div>
    </div>	
</div>
<div style="height:32px;border-top:1px solid #777d89; background-color:#373d4b">
	<div class="h-bottom3">
        <a href="/" target="_blank" >Powered by inspectBid.com</a>
    </div>
</div>



    {if $st_frontend.google_analytics_enable}
        {*$st_frontend.google_analytics_api*}
    {/if}
	
    <script type="text/javascript" charset="utf-8">
		var json_secure_url_scanned = '';
		{if $json_secure_url_scanned}
			json_secure_url_scanned = {$json_secure_url_scanned} ;
		{/if}
		{literal}
		function isSecureUrl(link) {
			if (json_secure_url_scanned.length > 0) {
				for (var i = 0; i < json_secure_url_scanned.length; i++) {
                    try
                    {
                        if (link.indexOf(json_secure_url_scanned[i]) >= 0 ) {
                            return true;
                        }
                    }
                    catch(err){}
				}
			}
			return false;
		}

		function toSSL(link) {
           
			if (link.indexOf('https') >= 0) {
				return link;
			} else if (link.indexOf('http') >= 0) {
                		return link.replace('http','https');
			} else {
				if (link.indexOf('/') != 0) {
					link = '/' + link;
				}
				return 'https://' + window.location.hostname + link;
			}
		}
        function CheckValidUrl(strUrl)
        {
            var RegexUrl = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
            return RegexUrl.test(strUrl);
        }
		
		$(function(){
                /**/
                Common.checkSub();
                Common.remindPayment();
                $("select").uniform();
				$("select").show();
				jQuery('a').each(function(){
					var href = jQuery(this).attr('href');
                   
					if (isSecureUrl(href)) {
						jQuery(this).attr('href', toSSL(href));
					}
				});
				jQuery('form').each(function(){
					var action = jQuery(this).attr('action');
					if (isSecureUrl(action)) {
						jQuery(this).attr('action', toSSL(action));
					}
				});
        });
		{/literal}
    </script>
    <script type="text/javascript" src="/modules/general/templates/js/fb-tw.js" ></script>
    <script type="text/javascript" src="/modules/general/templates/js/tourguide.js" ></script>
    <script type="text/javascript">
        {$runFuncJs};
    </script>
    </div>
    <div id="wrap-left"
        {if isset($bg_data) and count($bg_data) > 0 and $bg_data.right_config != ''}
            style="{if $bg_data.right_config.fixed == 1}position:fixed;{/if}
                   {if $bg_data.right_config.background_color != ''}background-color:{$bg_data.right_config.background_color};{/if}
                   {if $bg_data.right_config.repeat == 1 && $bg_data.right != ''}background:url({$bg_data.right}) repeat;{/if}"
        {/if}
    >
        {if isset($bg_data) and count($bg_data) > 0 and $bg_data.right != ''}
            <img src="{$bg_data.right}" title="ibb" alt="ibb" class="img-right"/>
        {/if}
    </div>
	{$newrelic_footer}
    {literal}
    <script type="text/javascript">
        jQuery(document).ready(function(){
            var doc = $(document).width();
            var wrapper = $('.wrapper').width();
            if ($('#wrap-left img').length > 0 || $('#wrap-right img').length > 0){
                var width = (doc - wrapper)/2;
                if ($('#wrap-left img').width() > width){
                    $('#wrap-left img').width(width);
                }
                if ($('#wrap-right img').width() > width){
                    $('#wrap-right img').width(width);
                }
            }
            $('#wrap-left, #wrap-right').height($(document).height());
        })
    </script>
    {/literal}

    {if isset($is_active) && $is_active == 0}
    <script type="text/javascript" src="/modules/property/templates/js/property.js"></script>
    <script type="text/javascript">
        {literal}
            $(document).ready(function(){
                showMess('Your account is not activated yet. Please check your email and click on the activation link to activate your account. Thank you !');
            });
        {/literal}
    </script>
    {/if}

    </body>
</html>

