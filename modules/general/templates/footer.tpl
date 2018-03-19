</div>

<div class="clearthis"></div>
<div style="height:29px; background-color:#01aef0">
    <div class="h-bottom1">
        <a target="_blank" href="https://www.facebook.com/bidRhinoAuctions">
            <img width="29" height="29" src="{$ROOTURL}/modules/general/templates/images/fb_icon.png"/>
        </a>
        <a target="_blank" href="http://www.twitter.com/bidRhino">
            <img width="29" height="29" src="{$ROOTURL}/modules/general/templates/images/social_twitter.png"/>
        </a>
        <a target="_blank" href="https://www.linkedin.com/company/4824801?trk=tyah&trkInfo=tarId%3A1418868668211%2Ctas%3AbidRh%2Cidx%3A1-1-1">
            <img width="29" height="29" src="{$ROOTURL}/modules/general/templates/images/social_linkedin.png"/>
        </a>
        <a target="_blank" href="http://www.instagram.com/bidRhino">
            <img width="29" height="29" src="{$ROOTURL}/modules/general/templates/images/social_instagram.png"/>
        </a>
        <span>{localize translate="Follow Us"}</span>
    </div>
</div>

<div style="height:286px; background-color:#373d4b">
    <div class="h-bottom2">
        <div class="f-c" style="height: 246px; width: 100%;">
            <div class="f-blocks" style="min-height: 194px;max-height: 195px;">
                {$footer_menu}
            </div>
        </div>
    </div>
</div>
<div style="height:32px;border-top:1px solid #777d89; background-color:#373d4b">
    <div class="h-bottom3">
        <a href="/" target="_blank" >Powered by www.bidRhino.com</a>
    </div>
</div>



{if $st_frontend.google_analytics_enable}
{$st_frontend.google_analytics_api_site}
{/if}

<script type="text/javascript" charset="utf-8">
    var json_secure_url_scanned = '';
{if $json_secure_url_scanned}	json_secure_url_scanned = {$json_secure_url_scanned} ;{/if}
</script>
<script type="text/javascript" src="/modules/general/templates/js/footer.js" ></script>
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

