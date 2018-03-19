{literal}
<script type="text/javascript" src="../editor/jscripts/tiny_mce/tiny_mce.js"></script>
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
<!-- /TinyMCE -->
<table width="100%" cellspacing="10" class="edit-table">
    {*------------------------------------AUTOBID------------------------------------*}
    <tr>
    	<td colspan="2" align="center">
            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
            	<legend><small>Autobid Settings</small></legend>
            </fieldset>
        </td>
    </tr>
    <tr>
    	<td width = "19%" valign="top">
        	<strong>Active auto bid</strong>
        </td>
        <td>
			<input type="text" name = "fields[general_active_autobid_time]" id = "general_active_autobid_time" value="{$form_data.general_active_autobid_time}" class="input-text validate-require disable-auto-complete" style="width:50%"/>
            <i>Second(s)</i>
        </td>
    </tr>
	<tr>
    	<td width = "19%" valign="top">
        	<strong>Loop time</strong>
        </td>
        <td>
			<input type="text" name = "fields[general_loop_bid_time]" id = "general_loop_bid_time" value="{$form_data.general_loop_bid_time}" class="input-text validate-require disable-auto-complete" style="width:50%"/>
            <i>Second(s)</i>
        </td>
    </tr>

    {*-----------------------------COUNT DOWN FOR AUCTION LIVE--------------------------------*}
    <tr>
    	<td colspan="2" align="center">
            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
            	<legend><small>Countdown Settings</small></legend>
            </fieldset>
        </td>
    </tr
    <tr>
    	<td width = "19%" valign="top">
        	<strong>Activate "Going Once"</strong>
        </td>
        <td>
			<input type="text" name = "fields[count_going_once]" id="count_going_once" value="{$form_data.count_going_once}" class="input-text validate-require disable-auto-complete" style="width:50%"/>
            <i>Second(s)</i>
        </td>
    </tr>
	<tr>
    	<td width = "19%" valign="top">
        	<strong>Activate "Going Twice"</strong>
        </td>
        <td>
			<input type="text" name = "fields[count_going_twice]" id="count_going_twice" value="{$form_data.count_going_twice}" class="input-text validate-require disable-auto-complete" style="width:50%"/>
            <i>Second(s)</i>
        </td>
    </tr>

    <tr>
    	<td width = "19%" valign="top">
        	<strong>Activate "Third and Final call"</strong>
        </td>
        <td>
			<input type="text" name = "fields[count_going_third]" id="count_going_third" value="{$form_data.count_going_third}" class="input-text validate-require disable-auto-complete" style="width:50%"/>
            <i>Second(s)</i>
        </td>
    </tr>

     {*-----------------------------date to lock The Block properties--------------------------------*}
    <tr>
    	<td colspan="2" align="center">
            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
            	<legend><small>No More Bids Settings</small></legend>
            </fieldset>
        </td>
    </tr
  
    <tr>
    	<td width = "19%" valign="top">
        	<strong>"No More Bids" message</strong>
            <br />
            <small>this message will show when a bidder click "No more bids" button.</small>
        </td>
        <td>
			<textarea rows="6" cols="" width="100%" name="fields[no_more_bids_msg]" id="no_more_bids_msg" class="input-text validate-require disable-auto-complete">{$form_data.no_more_bids_msg}</textarea>
        </td>
    </tr>

    <tr>
    	<td width = "19%" valign="top">
        	<strong>Auto Refresh Popup</strong>
        </td>
        <td>
			<input type="text" name = "fields[no_more_bids_refresh]" id="no_more_bids_refresh" value="{$form_data.no_more_bids_refresh}" class="input-text validate-require disable-auto-complete" style="width:50%"/>
        </td>
    </tr>


    <!--------------------------------->
    <tr>
    	<td colspan="2" align="center">
            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
            	<legend><small>General Bid Settings</small></legend>
            </fieldset>
        </td>
    </tr>
    <tr>
    	<td width = "19%" valign="top">
        	<strong>Terms Title</strong>
        </td>
        <td>
			<input type="text" name="fields[term_title]" id="term_title" value="{$form_data.term_title}" class="input-text validate-require disable-auto-complete" style="width:50%"/>
        </td>
    </tr>
    <tr>
    	<td width = "19%" valign="top">
        	<strong>Terms Content</strong>
        </td>
        <td>
			<textarea rows="20" cols="" width="100%" name="fields[term_bid]" id="term_bid" class="editor input-text validate-require disable-auto-complete">{$form_data.term_bid}</textarea>
        </td>
    </tr>

     <!--------------------------------->
    <tr>
    	<td colspan="2" align="center">
            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
            	<legend><small>Disable Bidder Settings</small></legend>
            </fieldset>
        </td>
    </tr>

    <tr>
    	<td width = "19%" valign="top">
        	<strong>Subject Disable Email</strong>
        </td>
        <td>
			<input type="text" name="fields[bidder_disable_subject]" id="bidder_disable_subject" value="{$form_data.bidder_disable_subject}" class="input-text validate-require disable-auto-complete" style="width:50%"/>
        </td>
    </tr>

    <tr>
    	<td width = "19%" valign="top">
        	<strong>Disable Content</strong>
        </td>
        <td>
			<textarea rows="20" cols="" width="100%" name="fields[bidder_disable_content]" id="bidder_disable_content" class="editor input-text validate-require disable-auto-complete">{$form_data.bidder_disable_content}</textarea>
        </td>
    </tr>

     <tr>
    	<td width = "19%" valign="top">
        	<strong>Subject Enable Email</strong>
        </td>
        <td>
			<input type="text" name="fields[bidder_enable_subject]" id="bidder_enable_subject" value="{$form_data.bidder_enable_subject}" class="input-text validate-require disable-auto-complete" style="width:50%"/>
        </td>
    </tr>

    <tr>
    	<td width = "19%" valign="top">
        	<strong>Content Enable Email</strong>
        </td>
        <td>
			<textarea rows="20" cols="" width="100%" name="fields[bidder_enable_content]" id="bidder_enable_content" class="editor input-text validate-require disable-auto-complete">{$form_data.bidder_enable_content}</textarea>
        </td>
    </tr>

    <tr>
        <td colspan="2" align="right">
            <hr/>
            <input type="submit" class="button" value="Save"/>
        </td>
    </tr>

</table>
