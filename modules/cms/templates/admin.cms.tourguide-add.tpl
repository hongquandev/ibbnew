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
{/literal}

<div style="width:100%">
    <table width="1140px" align="center" border="0" cellspacing="0" cellpadding="0">
        <tr><td colspan="2" align="center"></td></tr> 
        <tr> 
            <td colspan="2">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center" valign="middle" style="padding:3px" bgcolor="#000000" class="bold12white">Tour Guide Information</td>
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
                                            <li class="title">Tour Guide information</li>
                                            <li class="select">Add new Tour Guide</li>
                                            <li class=""><a href="?module=cms&action=tourguide-list&token={$token}">Manage tour guide</a></li>
                                        </ul>
                                    </td>
                                    <td valign="top">
                                        {if isset($message) and strlen($message) > 0}
                                            <div class="message-box">{$message}</div>
                                        {/if}
                                        <table width="100%" cellspacing="0" class="box">
                                            <tr><td class="box-title"><label>Tour Guide Page</label></td></tr>
                                            <tr>
                                                <td class="box-content">
                                                    {if isset($action)}
                                                    <table class="edit-table" cellspacing="10" width="100%">

                                                        <tr>
                                                            <td width="19%"><strong id="notify_title">Page Title<span class="require">*</span></strong></td>
                                                            <td>
                                                                <input type="text" id="title" name="title" class="input-text validate-require" style="width:100%;" value="{$row.title}"/>
                                                            </td>
                                                        </tr>
                                                    
                                                        <tr>
                                                            <td width="19%"><strong id="notify_content">Content</strong></td>
                                                            <td>
                                                                <textarea name="content" rows="15" cols="80" style="width:100%" id="content" class="content">{$row.content}</textarea>
                                                            </td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td width="19%">
                                                                <strong id="notify_sort_order">Position<span class="require">*</span></strong>
                                                            </td>
                                                            <td>
                                                                <input id="sort_order" name="sort_order" type="text"  size="5" class="input-text validate-require" value="{$row.sort_order}"/> 
                                                            </td>
                                                        </tr>
                                                    
                                                        <tr>
                                                            <td align="right" colspan="4">
                                                                <hr />
                                                                {if $type == 'edit'}
                                                                    <input type="button" class="button" id="btncrt" value="Update Tour Guide Page" onClick="cms.submit('#frmCreate');"/>
                                                                {else}
                                                                    <input type="button" class="button" id="btncrt" value="Create Tour Guide Page" onClick="cms.submit('#frmCreate');"/>
                                                                {/if}
                                                                <input type="button" class="button" value="Back" onClick="window.location='?module=cms&action=tourguide-list&token={$token}'" />
                                                                <input type="hidden" name="page_id" id="page_id" value="{$page_id}"/>
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
