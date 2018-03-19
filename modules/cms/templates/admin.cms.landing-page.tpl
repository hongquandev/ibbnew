 <!-- Call JavaScrip Editor Tiny_MCE -->
{literal}
	<script type="text/javascript" src="../editor/jscripts/tiny_mce/tiny_mce.js"></script>
    <script type="text/javascript" src="../modules/cms/templates/js/checking_edit.js" ></script>
    <script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "specific_textareas",
        editor_selector : "content",
        theme:"advanced",
        height: "480px",
		plugins : "ibrowser,autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",
		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "ibrowser,cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft|insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",
		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",
		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],
		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
    var cms = new CMS();
</script>
<style type="text/css">

    .myaccount .tbl-messages {
        border: 1px solid #dadada;
        color: #333;
    }

        /*.myaccount .tbl-messages td { padding: 5px 5px; }*/
    .myaccount .tbl-messages thead {
    }

    .myaccount .tbl-messages thead tr {
    }

    .myaccount .tbl-messages thead tr td {
        padding: 4px 5px;
        border-left: 1px solid #dadada;
        border-right: 1px solid #fff;
        line-height: 15px;
        vertical-align: middle;
        font-weight: bold;
        background: url('/modules/general/templates/images/tbl-head.png') 0 0 repeat-x;
    }

    .myaccount .tbl-messages tbody {
    }

    .myaccount .tbl-messages tbody tr {
        /*height:24px;du duong gach bid history*/height: auto;
    }

    .myaccount .tbl-messages tbody tr:hover, .myaccount .tbl-messages tbody tr.read {
        background-color: #f0f0f0;
        cursor: pointer;
    }

    .myaccount .tbl-messages tbody tr td {
        color: #666;
        border-bottom: 1px solid #dadada;
        padding-top: 4px;padding-bottom: 4px;
    }
    .p-jus-register{text-align: justify; font-size: 13px; width: 186px;}
    .myaccount .tbl-messages tfoot tr {
        height:24px;
    }

    .myaccount .tbl-messages tfoot tr td {
        color: #666;
        font-weight: bold;
    }

    .myaccount .tbl-messages tfoot tr td a {
        color: #666;
        margin: 0px 10px;
    }

    .myaccount .tbl-messages td .selector {
        width: 40px;
        float: right;
    }
</style>
{/literal}

<div style="width:100%">
    <table width="1140px" align="center" border="0" cellspacing="0" cellpadding="0">
        <tr><td colspan="2" align="center"></td></tr> 
        <tr> 
            <td colspan="2">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center" valign="middle" style="padding:3px" bgcolor="#000000" class="bold12white">Landing Page Information</td>
                    </tr>
                </table>
            </td>    
        </tr>
        
        <tr>
            <td colspan="2">
                <form method="post" action="{$form_action}" name="frmCreate" id="frmCreate" enctype="multipart/form-data" >
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="1" bgcolor="#CCCCCC"></td>
                        <td align="left" valign="top" class="padding1">
                            <table width="100%" cellspacing="15">
                                <tr>
                                    <td width="20%" valign="top" class="bar" id="myaccount-nav">
                                    <!--bar-->
                                        <ul>
                                            <li class="title">Landing page information</li>
                                            <li class="select">Landing page</li>
                                            <li>
                                                <a href="{$ROOTURL}/?module=cms&action=view-landing-page" target="_blank">
                                                    Preview
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                    <td valign="top">
                                        {if isset($message) and strlen($message) > 0}
                                            <div class="message-box">{$message}</div>
                                        {/if}
                                        <table width="100%" cellspacing="0" class="box">
                                            <tr><td class="box-title"><label>Landing Page</label></td></tr>
                                            <tr>
                                                <td class="box-content">
                                                {if isset($action)}
                                                    <table class="edit-table" cellspacing="10" width="100%">
                                                        <tr>
                                                            <td width="10%"><strong id="notify_title">Page Title<span
                                                                    class="require">*</span></strong></td>
                                                            <td>
                                                                <input type="text" id="title" name="title"
                                                                       class="input-text validate-require"
                                                                       style="width:100%;" value="{$row.title}"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong id="notify_content">Text Content</strong>
                                                            </td>
                                                            <td>
                                                                <textarea name="content" rows="15" cols="80"
                                                                          style="width:100%" id="content"
                                                                          class="content">{$row.content}</textarea>
                                                            </td>
                                                        </tr>
                                                        <tr style="height: 10px;"></tr>
                                                        <tr >
                                                            <td>
                                                                <strong>
                                                                    Select Question
                                                                </strong>
                                                            </td>
                                                            <td class="myaccount">
                                                                <table class="tbl-messages"
                                                                       cellpadding="8" cellspacing="0">
                                                                    <colgroup>
                                                                        <col width="75px">
                                                                        <col width="122px">
                                                                        <col width="405px">
                                                                        <col width="130px">
                                                                    </colgroup>
                                                                    <thead>
                                                                    <tr>
                                                                        <td align="center">
                                                                            <input type="checkbox" name="all_chk"
                                                                                   value=""
                                                                                   onclick="Common.checkAll(this,'chk')"/>
                                                                        </td>
                                                                        <td align="center">
                                                                            ID
                                                                        </td>
                                                                        <td align="center">
                                                                            Question
                                                                        </td>
                                                                        <td align="center">
                                                                            Creation time
                                                                        </td>
                                                                    </tr>
                                                                    </thead>
                                                                    {if isset($faq_rows) and is_array($faq_rows) and count($faq_rows)>0}
                                                                        <tbody>
                                                                            {foreach from = $faq_rows key = k item = row}
                                                                            <tr onclick="select_chk('{$row.content_id}')">
                                                                                <td class="first" align="center">
                                                                                    <input type="checkbox" {if in_array($row.content_id,$chk_ar)} checked="checked" {/if}
                                                                                           name="chk[{$row.content_id}]"
                                                                                           id="chk_{$row.content_id}"
                                                                                           value="{$row.content_id}"/>
                                                                                </td>
                                                                                <td align="center">
                                                                                    {$row.content_id}
                                                                                </td>
                                                                                <td align="left" style="padding: 5px;">
                                                                                    {$row.question}
                                                                                </td>
                                                                                <td align="center">
                                                                                    {$row.create_time}
                                                                                </td>
                                                                            </tr>
                                                                            {/foreach}
                                                                        </tbody>
                                                                    {/if}
                                                                    <tfoot></tfoot>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        {* Button*}
                                                        <tr>
                                                            <td align="right" colspan="4">
                                                                <hr/>
                                                                <input type="button" class="button" id="btncrt"
                                                                       value="Update Landing Page"
                                                                       onClick="cms.submit('#frmCreate');"/>
                                                                <input type="button" class="button" value="Cancel"
                                                                       onClick="window.location='?module=cms&action=landing-page&token={$token}'"/>
                                                                <input type="hidden" name="page_id" id="page_id"
                                                                       value="{$page_id}"/>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    {else}
                                                    Can not find the template with this request.
                                                {/if}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width="1" bgcolor="#CCCCCC"></td>
                    </tr>
                </table>
            </form>
            </td>
        </tr>
        
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="12" align="left" valign="top"><img src="{$imagepart}left_bot.jpg" width="16" height="16" /></td>
                        <td background="{$imagepart}bgd_bot.jpg">&nbsp;</td>
                        <td width="12" align="right" valign="top"><img src="{$imagepart}right_bot.jpg" width="16" height="16" /></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
{literal}
    <script type="text/javascript">
        function select_chk(id){
            jQuery('#chk_' + id).attr('checked',!jQuery('#chk_' + id).attr('checked'));
        }
    </script>
{/literal}