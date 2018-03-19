<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link rel="shortcut icon" href="/favicon.ico" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    {*<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>*}

    <title>eBidda.com.au - Content Management System</title>
    <link rel="stylesheet" type="text/css" href="{$templatesPath}/style/admin.css" />
    <link rel="stylesheet" type="text/css" href="{$templatesPath}/style/menu.css" />
    <link rel="stylesheet" type="text/css" href="{$templatesPath}/style/anylink.css" /></head>
    <!--[if  IE 7]>
    <link rel="stylesheet" type="text/css" href="/modules/general/templates/style/admin-ie7.css" />
    <![endif]-->
    <!--[if  IE 8]>
    <link rel="stylesheet" type="text/css" href="/modules/general/templates/style/admin.css-ie8.css" />
    <![endif]-->
    {if !($module == 'help_center' AND $action == 'popup')}
        <link rel="stylesheet" type="text/css" href="resources/css/ext-all.css" />
    {/if}
    
    <link rel="stylesheet" type="text/css" href="/modules/general/templates/style/jquery-ui.css" />
    
    <script type="text/javascript" src="js/wow.js"></script>
    <script type="text/javascript" src="js/anylink.js"></script>
    <script type="text/javascript" src="js/utility.js"></script>
    <script type="text/javascript" src="js/popup.js"></script>
    <script type="text/javascript" src="/admin/ajax/js/Ajax.js"></script>
    <script type="text/javascript" src="/admin/ajax/js/Post.js"></script>
    <script type="text/javascript" src="/modules/general/templates/js/helper.js"></script>
    <script type="text/javascript" src="/modules/general/templates/js/common.js" ></script>
    <script type="text/javascript" src="/modules/general/templates/js/admin.js"></script>
    <script type="text/javascript" src="/modules/general/templates/js/jquery.min.js"></script>
    <script type="text/javascript" src="/modules/general/templates/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/modules/general/templates/js/validate.js"></script>
    <script type="text/javascript" src="/modules/general/templates/js/menu.js"></script>
    <script type="text/javascript" src="/modules/general/templates/js/underscore-min.js"></script>
    <script type="text/javascript" src="/modules/general/templates/js/cufon/cufon-yui.js"></script>
    <script type="text/javascript" src="/modules/general/templates/js/cufon/Neutra_Text_500-Neutra_Text_700.font.js"></script>
    <script type="text/javascript" src="/modules/general/templates/js/cufon/gos-api.js"></script>
    <script type="text/javascript" src="/modules/general/templates/js/gos_api.js"></script>
    {literal}
    <style type="text/css"> 
    .popup {
        position:absolute;
        visibility:hidden;
        width:600px;
        border: 1px solid black;
        padding:3px;
        background: #f9f9f9 ;
        /*background-image:url(../modules/general/templates/images/bg.png)*/ 
    }
    
    .popupSmall {
        position:absolute;
        visibility:hidden;
        width:400px;
        border: 1px solid black;
        padding:3px;
        background: #f9f9f9 ;
        /*background-image:url(../modules/general/templates/images/bg.png)*/ 
    }
    -->
    /*------------------------Header-Top---------------------------*/
    .header-top .logo {
        float: left;
        margin: 5px 20px 5px 0px;
    }
    .header-right {
        color: #FFFFFF;
        padding: 15px 25px 0 15px;
    }
    .header-right .super {
        float: right;
        line-height: 1.8em;
        margin-bottom: 14px;
        margin-right:-23px;
    }
    .separator {
        font-size: 0.9em;
        padding: 0 6px;
    }
    .super{ color:#000000;}
    </style>
</head>
 
{/literal}
<body>
{if $Admin.Logged && $showHeader}

{include file="admin.top_menu.tpl"}

<table width="1140px" style="margin-top:5px;margin-bottom:10px;" align="center" border="0" cellspacing="0"
       cellpadding="0">
    <tr valign="top">
        <td>
            <div class="header-top">
                <a href="/admin/?token={$token}"><img class="logo" alt="Logo"
                                                      src="{$templatesPath}/images/logo.jpg"/></a>

                <div class="header-right">
                    <p class="super">
                        Logged in as {$rows.username}
                        <span class="separator">|</span>
                        {$date}
                        <span class="separator">|</span>
                        <a href="index.php?action=logout">Logout</a>
                    </p>
                </div>
            </div>
        </td>
    </tr>
    {*<tr>
        <td align="right" bgcolor="#000" style="padding:3px; color:#FFFFFF">
            {$top_menu}
        </td>
    </tr>*}
</table>
{/if}
