<script type="text/javascript" src="/modules/general/templates/js/helper.js"></script>
<script type="text/javascript" src="/modules/agent/templates/js/agent.js"></script>
<script type="text/javascript" src="/modules/note/templates/mobile/js/note.js"></script>
<script type="text/javascript" src="/modules/property/templates/mobile/js/property.js"></script>
<script type="text/javascript" src="/modules/general/templates/mobile/js/term.popup.js"></script>
<script type="text/javascript" src="/modules/general/templates/mobile/js/confirm.js"></script>
<link href="/modules/agent/templates/mobile/style/styles.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript" src="/editor/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" language="javascript" src="/modules/agent/templates/js/loginpopup.js" ></script>
{literal}
<script type="text/javascript">
    tinyMCE.init({
        mode : "specific_textareas",
        editor_selector : "content",
        theme:"advanced",
        height:"300",
        width:'99%',
        plugins : "ibrowser,autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,link,unlink,sub,sup,|,hr,removeformat,,charmap",
        theme_advanced_buttons2 : "",
        theme_advanced_buttons3 : "",

        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        /*theme_advanced_resizing_min_width: 393,*/
        /*theme_advanced_source_editor_width:500,*/
        theme_advanced_resizing : true,

        content_css : "css/content.css",

        template_external_list_url : "lists/template_list.js",
        external_link_list_url : "lists/link_list.js",
        external_image_list_url : "lists/image_list.js",
        media_external_list_url : "lists/media_list.js",

        style_formats : [
            {title : 'Bold text', inline : 'b'},
            {title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
            {title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
            {title : 'Example 1', inline : 'span', classes : 'example1'},
            {title : 'Example 2', inline : 'span', classes : 'example2'},
            {title : 'Table styles'},
            {title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
        ],
        template_replace_values : {
            username : "Some User",
            staffid : "991234"
        }
    });
</script>
{/literal}
{if $action == 'landing'}
     {include file = "`$ROOTPATH`/modules/cms/templates/cms.landing.tpl"}
{elseif in_array($action,array('register-vendor','register-buyer','register-partner','register-agent'))}
     {include file="`$module`.register.tpl"}
{elseif $action == 'finish-register'}
     {include file="`$module`.finish_register.tpl"}
{elseif $action == 'confirm'}     
     {include file="`$module`.confirm.tpl"}
{elseif in_array($action,array('login','logout','forgot'))}
	{include file="`$module`.`$action`.tpl"}
{elseif $action == 'view-report-banner-detail'}
    {include file="`$module`.report.banner.tpl"}
{elseif eregi('^(view-|edit-|add-|delete-)',$action)}
	{include file="`$module`.view.tpl"}
{elseif eregi('^(list-)',$action)}    
	{include file="`$module`.list.tpl"}
{elseif $action == 'add-info'}     
     {include file="`$module`.information.tpl"}
{else}
    {include file="`$module`.`$action`.tpl"}
{/if}