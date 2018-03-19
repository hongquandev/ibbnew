<script type="text/javascript" src="../editor/jscripts/tiny_mce/tiny_mce.js"></script>
{literal}
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "specific_textareas",
        editor_selector : "editor",

        //mode : "textareas",
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

		// Theme options
		theme_advanced_buttons1 : "mylistbox,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect,|,forecolor,backcolor,|,bullist,numlist",
		theme_advanced_buttons2 : "outdent,indent,blockquote,|,undo,redo,|,link,unlink,image,cleanup,|,removeformat,unsubscribe,|,code,|,ROOTURL",
        theme_advanced_buttons3 : "",
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
		},
        setup : function(ed) {
                // Add a button to unsubscribed
                ed.addButton('unsubscribe', {
                    title : 'Unsubscribe',
                    //image : '../../img/unsub.gif',
                    image : location.protocol + '//' + location.host+'/editor/jscripts/tiny_mce/themes/advanced/img/unsub.gif',
                    onclick : function() {
                        var text = ed.selection.getContent({format : 'text'});
                        ed.focus();
                        ed.selection.setContent('{unsubscribe}'+text+'{/unsubscribe}');
                    }
                });

                ed.addButton('ROOTURL', {
                    title : 'ROOTURL',
                    image : location.protocol + '//' + location.host+'/modules/general/templates/images/url-editor.png',

                    onclick : function() {
                        ed.focus();
                        ed.selection.setContent('[rooturl]');
                    }
                });
            }

	});
</script>
{/literal}
<table width="100%" cellspacing="10" class="edit-table">
    {*------------------------------------AUTOBID------------------------------------*}
    <tr>
    	<td colspan="2" align="center">
            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
            	<legend><small>Message Settings</small></legend>
            </fieldset>
        </td>
    </tr>
    <tr>
    	<td width = "19%" valign="top">
        	<strong>Restrict register property</strong>
        </td>
        <td>
			<textarea rows="5" cols="" width="100%" name="fields[restrict_property]" id="restrict_property" class="input-text validate-require disable-auto-complete">{$form_data.restrict_property}</textarea>
        </td>
    </tr>
    <tr>
    	<td colspan="2" align="center">
            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
            	<legend><small>Option Settings</small></legend>
            </fieldset>
        </td>
    </tr>

    <tr>
    	<td width = "19%" valign="top">
        	<strong>Restrict register property from area</strong>
        </td>
        <td>
			<select name="fields[restrict_area][]" id="restrict_area" class="input-select" multiple style="height:160px">
                {html_options options=$options_state selected=$form_data.restrict_area}
			</select>
        </td>
    </tr>

        <tr>
            <td colspan="2" align="center">
                <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                    <legend>
                        <small>Email Settings</small>
                    </legend>
                </fieldset>
            </td>
        </tr>
        <tr>
            <td width="19%">
                <strong>Remind</strong>
            </td>
            <td>
                <input type="text" name="fields[agent_remind_date]" value="{$form_data.agent_remind_date}" style="width:50%"><i>Day(s)</i>
            </td>
        </tr>

        <tr>
            <td width="19%">
                <strong>Email Subject</strong>
            </td>
            <td>
                <input type="text" name="fields[agent_email_subject]" value="{$form_data.agent_email_subject}" style="width:50%">
            </td>
        </tr>

        <tr>
            <td width="19%">
                <strong>Email Content</strong>
            </td>
            <td>
                <textarea class="editor" name="fields[agent_email_content]">{$form_data.agent_email_content}</textarea>
            </td>

        </tr>

        <tr>
            <td colspan="2" align="center">
                <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                    <legend><small>Description</small></legend>
                </fieldset>
            </td>
        </tr>

        <tr>
            <td width="19%">
                <strong>Agency site</strong>
            </td>
            <td>
                <textarea class="editor" name="fields[description_site_agency]">{$form_data.description_site_agency}</textarea>
            </td>
        </tr>

        <tr>
            <td width="19%">
                <strong>Agent site</strong>
            </td>
            <td>
                <textarea class="editor" name="fields[description_site_agent]">{$form_data.description_site_agent}</textarea>
            </td>
        </tr>


    <tr>
              <td colspan="2" align="right">
                  <hr/>
                  <input type="submit" class="button" value="Save"/>
              </td>
    </tr>

</table>
