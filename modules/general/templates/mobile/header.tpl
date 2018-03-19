<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#">
<head>
    <link rel="shortcut icon" href="/favicon.ico"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	{*{if $google_site_verification}
    <meta name="google-site-verification" content="{$google_site_verification}" />
    {/if}*}
	{$newrelic_header}

{if in_array($action,array('view-forthcoming-detail','view-auction-detail','view-sale-detail','view-detail')) && $module == 'property'}
    {if $property_data.info}
        <meta property="og:site_name" content="{$site_title_config}"/>
        <meta property="og:url" content="{$property_data.link}"/>
        <meta property="og:image" content="{$ROOTURL}{$property_data.info.photo_facebook}"/>
        <meta property="og:description" content="{$property_data.info.meta_description}"/>
    {else}
        <meta property="og:description" content="Only registered bidders for these properties can see this section. If you really care and want to join these auctions, feel free to contact us for support. Thanks!"/>
    {/if}
{else}
        <meta property="og:image" content="{$meta_photo}"/>
{/if}
    <meta name="description" content="{$meta_description}"/>
    <meta name="keywords" content="{$meta_key}"/>
    <meta name="robots" content="index, follow" />

    <title>{$site_title}</title>
{*Begin Combine css *}
    <link href="{$ROOTURL}/modules/general/templates/mobile/style/styles.css" rel="stylesheet" type="text/css" />
    <link href="{$ROOTURL}/modules/general/templates/mobile/style/menu.css" rel="stylesheet" type="text/css" />
    <link href="{$ROOTURL}/modules/general/templates/mobile/style/helveticaneue-condensed.css" rel="stylesheet" type="text/css" />
    {*<link rel="stylesheet" type="text/css" href="/modules/general/templates/style/style.php"/>*}

{* Begin Combine Javascript*}
    {*<script type="text/javascript" src="/modules/general/templates/js/jquery-1.8.3.js"></script>*}
    <script type="text/javascript" src="/modules/general/templates/js/javascript.php"></script>
    <script type="text/javascript" src="/modules/general/templates/mobile/js/header.js"></script>
    <script type="text/javascript" src="/modules/general/templates/mobile/js/lib/jRespond.js"></script>
    <script type="text/javascript" src="/modules/general/templates/mobile/js/lib/modernizr-2.6.1.min.js"></script>
    <script type="text/javascript" src="/modules/general/templates/mobile/js/lib/plugins.js"></script>
    <script type="text/javascript" src="/modules/general/templates/mobile/js/lib/respond.js"></script>
    <script type="text/javascript" src="/modules/general/templates/mobile/js/lib/jquery.jpanelmenu.min.js"></script>
    <script type="text/javascript" src="/modules/general/templates/mobile/js/overthrow.js"></script>
    <script type="text/javascript" src="/modules/general/templates/mobile/js/mobile-menu.js"></script>
    {*<script type="text/javascript" src="/modules/general/templates/mobile/js/lib/script.min.js"></script>*}
    {*<script type="text/javascript" src="/modules/general/templates/mobile/js/lib/library.js"></script>*}
    <script src="/modules/general/templates/js/codaslider/js/coda-slider.1.1.1.js"></script>
{* End Combine Javascript*}
    <!-- Move agent -->
    <script type="text/javascript">
        var ROOTURL2 = '{$ROOTURL2}';var ROOTURLS = '{$ROOTURLS}';var ROOTURL = '{$ROOTURL}';var fb_logout = '{$fb.logout_url}';
        /*var restrict = '{$restrict_register}';
         var redirect_dashboard = '{$redirect_dashboard}';*/
        var psite = new Object();
        psite.action = '{$action}';
        psite.module = '{$module}';
        {literal}
        replaceCufon();
        $(document).ready(function(){
            if ($('#email_address').val() == '' && $('#login').val() == true){
                confirmEmail('{/literal}{$authentic.id}{literal}');
            }
        });
        var check = new CheckBasic();
        if (document.getElementsByTagName) {
            var inputElements = document.getElementsByTagName("input");
            for (i = 0; inputElements[i]; i++) {
                if (inputElements[i].className && (inputElements[i].className.indexOf("disable-auto-complete") != -1)) {
                    inputElements[i].setAttribute("autocomplete", "off");
                }
            }
        }
    </script>
    {/literal}
</head>
<body class="{$module}-{$action} {$module}-page-cls">
<div class="top-line"></div>
<div id="wrap-right"></div>
<div class="wrapper">
    <header>
    <div class="header" {if $bg_data && $bg_data.top_background != ''}style="background-color: {$bg_data.top_background}"{/if}>
        <div class="logo-box f-right">
            {if $bg_data and count($bg_data) > 0 and $bg_data.top != ''}
                <img src="{$bg_data.top}" alt="logo iBB"/>
            {else}
                <a href="{$ROOTURL}"><img src="/modules/general/templates/images/ibb-logo.png" alt="logo iBB"/></a>
            {/if}
        </div>
        <div class="header-menu f-left">
            {include file = "top-menu.tpl"}
        </div>
        <input type="hidden" name="email" id="email_address" {if $agent_email}value="{$agent_email}"
               {else}value="{$authentic.email_address}"{/if}/>
        <input type="hidden" name="login" id="login" value="{$authentic.login}"/>
    </div>
    <div class="clearthis"></div>
    </header>
    {if $include_def_header_msg == 1}
        <div class="co-part1" style="background-color:#e0e1dc">
            {$welcome_block_1}
        </div>
	{/if}

    {if $include_def_header_msg2 == 1}
        <div class="co-part2" style="text-align:center">
            {$welcome_block_2}
        </div>
	{/if}
    {include file = "search.tpl"}
    {*<div class="main-content-border">*}
    {*<div class="main-content">*}
