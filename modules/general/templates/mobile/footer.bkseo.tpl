</div>
<div style="height:29px; background-color:#01aef0;padding:2px 0 2px 10px">
    <div class="h-bottom1">
        <a target="_blank" href="http://www.facebook.com/bidRhino"><img src="/modules/general/templates/images/fb-icon.png"/></a>
        <a target="_blank" href="http://www.twitter.com/bidRhino"><img width="29px" height="29px" src="/modules/general/templates/images/social_twitter.png"/> </a>
        <a target="_blank" href="https://www.linkedin.com/company/4824801?trk=tyah&trkInfo=tarId%3A1418868668211%2Ctas%3AbidRh%2Cidx%3A1-1-1"><img width="29px" height="29px" src="/modules/general/templates/images/social_linkedin.png"/> </a>
        <a target="_blank" href="http://www.instagram.com/bidRhino"><img width="29px" height="29px" src="/modules/general/templates/images/social_instagram.png"/> </a>
        <a href="javascript:void(0)"><span style="color: #FFFFff;">Follow Us</span></a>
    </div>
</div>
<div class="footer f-l"  >
    <div class="footer f-r" >
        <div class="f-c"  >
            <!--div class="f-blocks"  > 
                 <div style="border-bottom: #B1720D solid 1px;position: relative;top: 16px;z-index: 0;width: 100%;"></div>
                <div class="line-logo-ibb"></div>
            </div-->
            <div class="clearthis"></div>

            <div class="footer-site" style="padding-top: 10px; text-align: center; font-size: 12.1px;">
                <a style="color: #ffffff;" href="{$footer.link}" target="_blank" >
                    {$footer.copyright}
                </a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    {literal}
        jQuery(document).ready(function(){
            var wrapper_height = $('.wrapper').height();
            var window_height = $(window).height();
            var footer_height = $('.footer.f-l').height();
            if (wrapper_height + footer_height < window_height){
                $('.wrapper').css('min-height',$(window).height()+'px');
                $('.footer').css({
                    'position':'absolute',
                    'bottom':'0',
                    'width':'100%'
                });
            }
            if($('#wrap-right').html() == ''){
                $('#wrap-right').hide();
            }
        });
    {/literal}
</script>
{if isset($is_active) && $is_active == 0}
<script type="text/javascript" src="/modules/property/templates/js/property.js"></script>
<script type="text/javascript">
        {literal}
        $(document).ready(function() {
            showMess('Your account is not activated yet. Please check your email and click on the activation link to activate your account. Thank you !');
        });
        {/literal}
</script>
{/if}
</body>
</html>