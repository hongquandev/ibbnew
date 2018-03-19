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
     {*-----------------------------date to lock The Block properties--------------------------------*}
    <tr>
    	<td colspan="2" align="center">
            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
            	<legend><small>Property Settings</small></legend>
            </fieldset>
        </td>
    </tr
    ><tr>
    	<td width = "19%" valign="top">
        	<strong>Date to lock The Block properties</strong>
           {* <br />
            <small>lock The Block properties down so only registered bidders for that property can see the auction and property.</small>*}
        </td>
        <td>
			<input type="text" name = "fields[date_lock]" id="date_lock" value="{$form_data.date_lock}" class="input-text validate-require disable-auto-complete" style="width:50%"/>
            <i>Day(s)</i>
        </td>
    </tr>

    <tr>
    	<td width = "19%" valign="top">
        	<strong>Show on the Homepage</strong>
        </td>
        <td>
             <select name="fields[theblock_show_homepage]" id="theblock_show_homepage" class="input-select" style="width:50%">
                {html_options options=$options_yes_no selected =$form_data.theblock_show_homepage}
            </select>
        </td>
    </tr>

    <tr>
    	<td width = "19%" valign="top">
        	<strong>Show on the Focus</strong>
        </td>
        <td>
             <select name="fields[theblock_show_focus]" id="theblock_show_focus" class="input-select" style="width:50%">
                {html_options options=$options_yes_no selected =$form_data.theblock_show_focus}
            </select>
        </td>
    </tr>


    <tr>
    	<td colspan="2" align="center">
            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
            	<legend><small>Status Settings</small></legend>
            </fieldset>
        </td>
    </tr

    ><tr>
    	<td width = "19%" valign="top">
        	<strong>Status</strong>
        	<br />
            <small>Unlock/lock the block properties after the auctions.</small>
        </td>
        <td>
             <select name="fields[theblock_status]" id="theblock_status" class="input-select" style="width:50%">
                {html_options options=$options_lock_unlock selected =$form_data.theblock_status}
            </select>
        </td>
    </tr>

    <tr rel="unlock" style="display:none">
    	<td width = "19%" valign="top">
        	<strong>Day to unlock properties</strong>
        </td>
        <td>
            <input type="text" name="fields[theblock_date_lock]" id="theblock_date_lock" value="{$form_data.theblock_date_lock}" class="input-text validate-require disable-auto-complete" style="width:50%"/>
        </td>
    </tr>
    <tr rel="unlock" style="display:none">
    	<td width = "19%" valign="top">
        	<strong>Show</strong>
        </td>
        <td>
            <select name="fields[theblock_show_type_properties][]" id="theblock_show_type_properties" class="input-select" style="width:50%" multiple>
                {html_options options=$options_type_property selected=$form_data.theblock_show_type_properties}
            </select>
        </td>
    </tr>
    
    <tr>
    	<td colspan="2" align="center">
            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
            	<legend><small>Welcome block Settings</small></legend>
            </fieldset>
        </td>
    </tr>    
    <tr>
        <td width="19%">
            <strong>Welcome block 1</strong>
            <br/>
            <small>displays on homepage</small>
        </td>
        <td>
            <textarea class="editor" name="fields[welcome_block_1]">{$form_data.welcome_block_1}</textarea>
        </td>
    </tr>
    <tr>
        <td width="19%">
            <strong>Welcome block 1 (Chinese)</strong>
            <br/>
            <small>displays on homepage</small>
        </td>
        <td>
            <textarea class="editor" name="fields[welcome_block_1_chinese]">{$form_data.welcome_block_1_chinese}</textarea>
        </td>
    </tr>
    
    <tr>
        <td width="19%">
            <strong>Welcome block 2</strong>
            <br/>
            <small>displays on CMS page</small>
            
        </td>
        <td>
            <textarea class="editor" name="fields[welcome_block_2]">{$form_data.welcome_block_2}</textarea>
        </td>
    </tr>

    <tr>
        <td width="19%">
            <strong>Welcome block 2 (Chinese)</strong>
            <br/>
            <small>displays on CMS page</small>

        </td>
        <td>
            <textarea class="editor" name="fields[welcome_block_2_chinese]">{$form_data.welcome_block_2_chinese}</textarea>
        </td>
    </tr>
    

    <!--------------------------------->

    <tr>
              <td colspan="2" align="right">
                  <hr/>
                  <input type="submit" class="button" value="Save"/>
              </td>
    </tr>

</table>
<script src="{$ROOTURL}/modules/general/templates/calendar/js/jscal2.js"></script>
<script src="{$ROOTURL}/modules/general/templates/calendar/js/lang/en.js"></script>
<link rel="stylesheet" type="text/css" href="{$ROOTURL}/modules/general/templates/calendar/css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="{$ROOTURL}/modules/general/templates/calendar/css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="{$ROOTURL}/modules/general/templates/calendar/css/steel/steel.css" />
<script type="text/javascript">
    {literal}
        jQuery(document).ready(function(){
            showDateLock();
            $('#theblock_status').bind('click',function(){
                showDateLock();
            });
            Calendar.setup({
					inputField : 'theblock_date_lock',
					trigger    : 'theblock_date_lock',
					onSelect   : function() { this.hide() },
					showTime   : true,
					dateFormat : "%Y-%m-%d %H:%M:%S"
		    });
        });

        function showDateLock(){
            if ($('#theblock_status').val() == 0){
                $.each($('tr'),function(){
                    if ($(this).attr('rel') == 'unlock'){
                        $(this).show();
                    }
                });
            }else{
               $.each($('tr'),function(){
                    if ($(this).attr('rel') == 'unlock'){
                        $(this).hide();
                    }
                });
            }
        }

    {/literal}
</script>
