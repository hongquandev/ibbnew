<script type="text/javascript" src="../modules/homepage_slides/templates/js/admin.js"> </script> 
<!-- Call JavaScrip Editor Tiny_MCE -->
{literal}
	<script type="text/javascript" src="../editor/jscripts/tiny_mce/tiny_mce.js"></script>
{/literal}
<!-- Call Tiny -->
{literal}
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
        height : "200",
		plugins : "ibrowser,autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",
		// Theme options
		theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "ibrowser,cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,|,insertdate,inserttime,preview,|,forecolor,backcolor",
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
		]
	});
    var slide = new slide();
</script>
<!-- /TinyMCE -->
<!-- Ajax Submit -->
{/literal}
 <div style="width:100%">
    <table width="1140px" align="center" border="0" cellspacing="0" cellpadding="0">
        <tr > 
        	<td colspan=2 align="center"></td>
        </tr> 
        <tr> 
            <td colspan=2 >
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center" valign="middle" style="padding:3px" bgcolor="#000000" class="bold12white">                            
                            Slide Information
                        </td>
                    </tr>
                </table>
            </td>    
        </tr>  
        <tr>
            <td colspan="2" >
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="1" bgcolor="#CCCCCC"></td>
                        <td align="left" valign="top" class="padding1">
                            <table width="100%" cellspacing="15">
                                <tr>
                                    <td width="20%" valign="top" class="bar" id="myaccount-nav">
                                    <!--bar-->
                                        {include file = 'admin.homepage_slides.bar.tpl'}
                                    </td>
                                    <td valign="top">
                                        {if isset($message) and strlen($message) > 0}
                                            <div class="message-box">{$message}</div>
                                        {/if}
                                        <form method="post" action="{$form_action}" class="cmxform" name="frmCreate" id="frmCreate" enctype="multipart/form-data" >
                                        <table width="100%" cellspacing="0" class="box">
                                            <tr>
                                                <td class="box-title">
                                                   <label>ADD NEW SLIDE</label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="box-content">
                                                {if isset($action)}
                                                    <table class="edit-table" cellspacing="10" width="100%">
                                                        <tr>
                                                            <td width="19%">
                                                                <strong id="notify_title">Position<span class="require">*</span></strong>
                                                            </td>
                                                            <td width="30%">
                                                                <input id="position" name="fields[position]" style="width:100%" value="{$row.position}" class="validate-digits validate-require"/>
                                                            </td>
                                                            <td width="19%"></td>
                                                            <td width="30%"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong id="notify_image">Image<span class="require">*</span></strong></td>
                                                            <td colspan="3">
                                                                {if $row.image}
                                                                    <img src="{$ROOTURL}{$row.image}" width="50px" height="50px" />
                                                                {/if}
                                                               <input type="file" id="image" name="image_slide" style="width:100%" value="{$row.image}"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong id="notify_text">Text on slide</strong></td>
                                                            <td colspan="3">
                                                                <textarea id="text" name="fields[text]" rows="15" cols="80" style="width:100%" id="textareas" class="">{$row.text}</textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong id="notify_active">Active</strong></td>
                                                            <td colspan="3">
                                                                <select id="active" name="fields[active]">
                                                                    <option value="1" label="Active">Active</option>
                                                                    <option value="0" label="Inactive">Inactive</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" align="right">
                                                                <hr/>
                                                                <input type="hidden" name="next" id="next" value="0"/>
                                                                <input type="button"  class="button" value="{if $action == 'add'}Add New Slide{else}Update Slide{/if}" onclick="slide.submit('#frmCreate');"/>
                                                                <input type="button" class="button" value="Back" onclick="window.location='{$url.manager}'"/>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                {else}
                                                    Can not find the template with this request.
                                                {/if}
                                                </td>
                                            </tr>
                                        </table>
                                        </form>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width="1" bgcolor="#CCCCCC"></td>
                    </tr>
                </table>
            </td>
        </tr>       
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="12" align="left" valign="top"><img src="/modules/general/templates/images/left_bot.jpg" width="16" height="16" /></td>
                        <td background="/modules/general/templates/images/bgd_bot.jpg">&nbsp;</td>
                        <td width="12" align="right" valign="top"><img src="/modules/general/templates/images/right_bot.jpg" width="16" height="16" /></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>



