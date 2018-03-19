{literal} 
	<script type="text/javascript" src="../editor/jscripts/tiny_mce/tiny_mce.js"></script>
    <script type="text/javascript" src="../modules/newsletter/js/newletter.js"></script> 
 
{/literal}
<!-- Call Tiny -->

{literal}
<script type="text/javascript">
    var letter = new NewsLetter('#frmLetter');
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code",
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
		],

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
     var select = new SelectedBox();
        select.text = '#mail_to';
        select.container = '#select-box';
        select.selectbox = '#select-div';
     jQuery(document).ready(function(){
         //document.onclick = function() {select.hideBox()};
     });
</script>
{/literal}
<div style="width:100%;">
<table width="1140px"  align="center" border="0" cellspacing="0" cellpadding="0">
    <tr >
        	<td colspan="2" align="center"></td>
    </tr>
    <tr>
            <td colspan="2">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center" valign="middle" style="padding:3px" bgcolor="#000000" class="bold12white">
                                        Newsletter - Send email
                        </td>
                    </tr>
                </table>
            </td>
    </tr>
    <tr>
            <td colspan="2">

                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="1" bgcolor="#CCCCCC"></td>
                        <td align="left" valign="top" class="padding1">
                            <table width="100%" cellspacing="15">
                                <tr>
                                    <td width="20%" valign="top" class="bar" id="myaccount-nav">
                                    <!--bar-->

                                    </td>
                                    <td valign="top">
                                        {if isset($message) and strlen($message) > 0}
                                            <div class="message-box">{$message}</div>
                                        {/if}
                                        <form id="frmLetter" method="post" action="/admin/?module=newsletter&action=emailtemplate&token={$token}" enctype="multipart/form-data">
                                        <table width="100%" cellspacing="0" class="box">
                                            <tr>
                                                <td class="box-title">
                                                   <label>Email detail</label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="box-content">
                                                     <table class="edit-table" cellspacing="10" width="100%">
                                                        <tr>
                                                            <td width="19%" align="right" >Subject:</td>
                                                            <td>
                                                                <input type="text" name="title" style="width:348px;" class="validate-require input-text" value="{$form_data.title}"/>
                                                            </td>
                                                        </tr>

                                                        <tr style="padding-top:5px;">
                                                            <td align="right">Content:</td>
                                                            <td >
                                                                <textarea name="content" id="textareas" style="width:100%" mce_editable ='true'  cols="140" rows="20" class="" value="{$form_data.content}"></textarea>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td align="right">Send mail to:</td>
                                                            <td>

                                                                <div id="select-div" style="float:left" class="select-box select-box-close" onkeyup="select.moveByKey(event)" >
                                                                   <div id="mail_to" style="width:100px;" onclick="select.changeStatus();"> Emaill All</div>

                                                                            <div class="search_overlay" style="display:none; overflow: auto; width: 98px;position: absolute;top: 465px;*top: 445px;" id="select-box">
                                                                                <ul>
                                                                                    {foreach from = $option_mail key=k item = option}
                                                                                        <li id="{$k}" onclick="select.getText(this)">{$option}</li>
                                                                                    {/foreach}
                                                                                </ul>
                                                                            </div>

                                                                </div>
                                                                <input type="hidden" name="user" value=""/>
                                                                <input type="hidden" name="suburb" value=""/>
                                                                <input type="hidden" name="state" value=""/>
                                                                <input type="hidden" name="other_state" value=""/>
                                                                <input type="hidden" name="country" value=""/>
                                                                <input type="hidden" name="mail_to" value="item_0"/>
                                                                <input type="hidden" name="token" id="token" value="{$token}"/>
                                                                </form>

                                                                <input type="button" class="button" style="float:right;" onclick="letter.isSubmit();" value="Send"/>


                                                            </td>
                                                        </tr>
                                                     </table>
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

            </td>
    </tr>
    <tr>
        <td>
                   <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="12" align="left" valign="top"><img src="{$templatesPath}/images/left_bot.jpg" width="16" height="16" /></td>
                            <td background="{$templatesPath}/images/bgd_bot.jpg">&nbsp;</td>
                            <td width="12" align="right" valign="top"><img src="{$templatesPath}/images/right_bot.jpg" width="16" height="16" /></td>
                        </tr>
                   </table>
        </td>
    </tr>
</table>
</div>
