<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:og="http://ogp.me/ns#">
<head>
    <link rel="shortcut icon" href="/favicon.ico"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    {if $google_site_verification}
    <meta name="google-site-verification" content="{$google_site_verification}" />
    {/if}

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
    <link rel="stylesheet" type="text/css" href="/modules/general/templates/style/style.php"/>
{*End Combine css*}
    <!--[if lt IE 10]>
    <script type="text/javascript" src="/modules/general/templates/js/PIE/PIE.js" charset="UTF-8"></script>
    <![endif]-->
{* Begin Combine Javascript*}
    <script type="text/javascript" src="/modules/general/templates/js/javascript.php"></script>
    <script src="/modules/general/templates/js/codaslider/js/coda-slider.1.1.1.js"></script>
{* End Combine Javascript*}
    <script type="text/javascript">var ROOTURL2 = '{$ROOTURL2}';var ROOTURLS = '{$ROOTURLS}';var ROOTURL = '{$ROOTURL}';var fb_logout = '{$fb.logout_url}';var psite = new Object();psite.action = '{$action}';psite.module = '{$module}';var _action = '{$action}';var pro_type = '{$pro_type_}';var pro_id = '{$property_data.info.property_id}';var authentic_id = '{$authentic.id}';</script><script type="text/javascript" src="/modules/general/templates/js/header.js"></script>
    {literal}
        <script type="text/javascript">
             /*(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                 (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                 m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
             })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
             ga('create', 'UA-57297314-1', 'auto');
             ga('send', 'pageview');*/
	    </script>
    {/literal}
</head>

<body class="{$module}-{$action} {$module}-page-cls language_{php}echo $_SESSION['language_current']{/php} {$user_viewer}"  {if $bg_data.left_config || $bg_data.right_config}
        style="{if $bg_data.left_config.background_color != ''}background-color:{$bg_data.left_config.background_color};{/if}{if $bg_data.right_config.background_color != ''}background-color:{$bg_data.right_config.background_color};{/if}"{/if}>
{*For feedback to JIRA*}
{*<script type="text/javascript" src="https://gosdev.jira.com/s/en_US89cgpe/767/92/1.1/_/download/batch/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector.js?collectorId=c8a1f1bd"></script>*}
<div id="wrap-right"{if isset($bg_data) && count($bg_data) > 0 && $bg_data.left_config != ''} style="{if $bg_data.left_config.fixed == 1}position:fixed;{/if}{if $bg_data.left_config.background_color != ''}background-color:{$bg_data.left_config.background_color};{/if}{if $bg_data.left_config.repeat == 1 && $bg_data.left != ''}background:url({$bg_data.left}) repeat;{/if}"{/if}>
{if isset($bg_data) and count($bg_data) > 0 and $bg_data.left != ''}	<img src="{$bg_data.left}" title="bidrhino" alt="bidrhino" class="img-left" />{/if}
</div>
<div class="wrapper custom-theme1">
    <div id="language-switcher-bar" class="language-switcher-bar" style="background-color:{if $bg_data && $bg_data.top_background != ''}{$bg_data.top_background}{else}#2e3440{/if}">
        {*Language Switcher*}
        <div class="language-switcher" style="width:942px;margin:0 auto">
            <a href="javascript:void(0)" onclick="langSwitch('en')" class="english-flag"><span class="english-flag-icon">English</span></a>
            <a href="javascript:void(0)" onclick="langSwitch('cn')" class="chinese-flag"><span class="chinese-flag-icon">Chinese</span></a>
        </div>
    </div>
	<div style="height:119px; background-color:{if $bg_data && $bg_data.top_background != ''}{$bg_data.top_background}{else}#2e3440{/if}">
    	<div style="width:942px;margin:0 auto">
            <div class="header">
                <div class="logo-box">
                    {if $bg_data and count($bg_data) > 0 and $bg_data.top != ''}<a href="{seo}?module=agent&action=view-detail-agency&uid={$bg_data.agent_id}{/seo}"><img src="{$bg_data.top}" alt="logo" title="House and Rural Properties for sale or purchase Australia wide" /></a>{else}<a href="{$ROOTURL}"><img src="/modules/general/templates/images/ibb-logo.png" alt="logo" title="House and Rural Properties for sale or purchase Australia wide" /></a>{/if}
                </div>
                <div>

                {*TWITTER*}
                {if $tw.enable == 1}{if $authentic.login == false || !isset($authentic)}
					<div class="block-twitter"><a href="javascript:void(0)" class="tw"><div></div></a></div>
					<script type="text/javascript">var tw_url = '{$tw.url}';</script>
                {/if}{/if}
                {*FACEBOOK*}
				<div id="fb-root"></div>
					<script type="text/javascript">var fb_url = '{$fb.url}';var fb_id = '{$fb.id}';</script>
                    {if ($fb.enable == 1)}{if $authentic.login == false || !isset($authentic)}
					    <a class="fb"><div></div></a>
                    {/if}{/if}
					<div class="clearthis"></div>
					<form name="frmLogin" id="frmLogin" method="post" action="/?module=agent&action=login" onsubmit="SubmitLogin();return false;">
                        {if isset($authentic) and is_array($authentic) and count($authentic)>0 and $authentic.id > 0}{include file="bar.myaccount.tpl"}{else}
                            <div id="login-box-confirm" class="login-box">
                                <div class="username-field">
                                    <select name="fields[instance]" id="instance">
                                        {html_options options=$account_instances selected=""}
                                    </select>
                                    <input class="txt-username input-text" type="text" value="email" name="fields[username]" id="username" onfocus="onFocusBlur(this,'focus')" onblur="onFocusBlur(this,'blur')"/>
                                </div>
                                <div class="password-field">
                                    <input class="txt-password input-text disable-auto-complete" type="password" value="password" name="fields[password]" id="password" onfocus="onFocusBlur(this,'focus')" onblur="onFocusBlur(this,'blur')"/>
                                </div>
                                <div class="button-field">
                                    <input class="btn-login" type="submit" value="login >"/>
                                    {*<input class="btn-register" type="button" value="register" onclick="document.location='/index.php?module=agent&action=landing'"/>*}
                                    <input class="btn-register" type="button" value="register" onclick="document.location='{$ROOTURL}/?module=agent&action=register-buyer'"/>
                                </div>
                            </div>
                        {/if}{if $action == 'login'}
						    <input type="hidden" id="dlgindex" name="dlgindex" value="1"/>
                        {/if}
						<input type="hidden" id="dindex" name="dindex" value="1"/>
							{if $bg_data and $bg_data.top != ''}{*<a href="{$ROOTURL}/home"><img src="/modules/general/templates/images/ibb-logo.png" alt="logo" class="ibb-logo" title="House and Rural Properties for sale or purchase Australia wide" /></a>*}{/if}
					</form>
                    <input type="hidden" name="email" id="email_address"{if $agent_email} value="{$agent_email}"{else} value="{$authentic.email_address}"{/if}/>
                    <input type="hidden" name="login" id="login" value="{$authentic.login}"/>
                </div>
            </div>        	
        </div>
    </div>
	<div class="menu-wrapper {if $bg_data && $bg_data.top_background != ''}menu-wrapper-agent{else}{/if}" style="height:35px;{if $bg_data && $bg_data.top_background != ''}background-color:{$bg_data.top_background}{else}{/if}">
        <div class="menu" style="z-index:90;position:relative;width:942px;margin:0 auto">
            {$top_menufrontend}
        </div>    
        <div class="clearthis"></div>
    </div>
    {if $include_def_header_msg == 1}
    <!--76px-->
    <div class="wel-block" style="height:auto; background-color:#e0e1dc;/*text-align:center*/">
        <div class="co-part1" style="height:auto;">
            <!--<span><i>Welcome to the new & exciting way to <b>buy</b> and <b>sell</b> property.</i></span>-->
            {$welcome_block_1}
        </div>
    </div>
	{/if}
    {if $include_def_header_msg2 == 1}<!--100px-->
    <div style="height:auto;">
        <div class="co-part2" style="width:708px;/*text-align:center;*/height:auto;">
            <!--<span><i>Welcome to the new & exciting way to <b>buy</b> and <b>sell</b> property.</i></span>-->
            {$welcome_block_2}
        </div>
    </div>
	{/if}

    <div style="background-color:#FFFFFF">
    	{if $include_def_search == 1}
        <div class="search-part1">
        {include file ="quicksearch2.tpl"}
        </div>
        {/if}
