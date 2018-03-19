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
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
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
</script>
<!-- /TinyMCE -->

<!-- Ajax Submit -->

<style type="text/css">

label { display: inline-block; }
legend { padding: 0.5em; }
fieldset fieldset label { display: block; }


#frmCreate #title
{
	width: 400px;
}

#frmCreate p
{
	margin-top:15px; margin-bottom:15px;
}
#frmCreate #gosPos
{
	float:right;
	margin-top:7px;
} 
</style>

{/literal}



<div style="width:100%">

<form method="post" action="index.php?module=contentfaq&action=add" class="cmxform" name="frmCreate" id="frmCreate" enctype="multipart/form-data" >
    <table width="90%" align="center" border="0" cellspacing="0" cellpadding="0">
        <tr > 
        	<td colspan=2 align="center"><font color="#FF0000"></font></td>    
        </tr> 
        <tr> 
            <td colspan=2 >
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center" valign="middle" style="padding:3px" bgcolor="#000000" class="bold12white">                            
                            Content Faq Information                       
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
                                	{include file = 'admin.contentfaq.bar.tpl'}
                                </td>
                                <td valign="top">
                                    {if isset($message) and strlen($message) > 0}
                                        <div class="message-box">{$message}</div>
                                    {/if}
                                    <table width="100%" cellspacing="0" class="box">
                                        <tr>
                                            <td class="box-title">
                                               <label>Content Faq detail</label>
                                            </td>
                                        </tr> 
                                        
                                        <tr>
                                        	<td class="box-content">
                                                {if isset($action)}
                                                  		 <table  align="center" cellpadding="5">
                                                              

                                                                <tr>
                                                                    <td class="labelName"  id="gosPos" ><strong id="notify_title">Parent <span class="require">*</span></strong> </td>
                                                                  <td width="75%" class="value"><select id="pos" name="pos"  style="width:20%"  > {$pos} </select> </td>
                                                                </tr>
                                                                 <tr>
                                                                    <td class="labelName"  id="gosPos" style="margin-top:130px;" ><label for="Content"> Content Question : </label> </td>
                                                                   <td width="75%" class="value">	<textarea  name="content" rows="15" cols="80" style="width:100%"  id="textareas" > </textarea> </td>
                                                                </tr>
                                                                  <tr>
                                                                    <td class="labelName"  id="gosPos" style="margin-top:130px;" ><label for="Content"> Content Answer : </label> </td>
                                                                   <td width="75%" class="value">	<textarea  name="content" rows="15" cols="80" style="width:100%"  id="textareas" > </textarea> </td>
                                                                </tr>
                                                              <tr > 
                                                                    <td width="25%" ></td>
                                                                    <td width="75%"> 
                                               <script type="text/javascript">
											   	var contentfaq = new ContenFaq();										
											   </script>
                                         <input type="button" class="button"  value="Create Page" onClick="contentfaq.submit('#frmCreate');" />
                                     
                                          <input type="button" class="button" value="Back" onClick="window.location='?module=contentfaq'" />
                                          <input type="hidden" name="subadd" />
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

</form>

</div>



