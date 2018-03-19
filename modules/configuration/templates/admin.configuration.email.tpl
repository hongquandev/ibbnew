 <!-- Call JavaScrip Editor Tiny_MCE -->
{literal}
	<script type="text/javascript" src="../editor/jscripts/tiny_mce/tiny_mce.js"></script>
{/literal}

<!-- Call Tiny -->

{literal}

<script type="text/javascript">
    var my_ed = null;
	tinyMCE.init({
		mode : "specific_textareas",
        editor_selector : "editor",
        height : "350",
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

		theme_advanced_buttons1 : "mylistbox,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect,|,forecolor,backcolor,|,bullist,numlist",
		theme_advanced_buttons2 : "outdent,indent,blockquote,|,undo,redo,|,link,unlink,image,cleanup,|,removeformat,unsubscribe,|,code,|,ROOTURL,Popup",
        theme_advanced_buttons3 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		/*content_css : "css/content.css",*/

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
		},
        setup : function(ed) {
            my_ed = ed;
                ed.addButton('unsubscribe', {
                    title : 'Unsubscribe',
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

                ed.addButton('Popup', {
                    title : 'Popup',
                    image : location.protocol + '//' + location.host+'/modules/general/templates/images/url-editor.png',
                    onclick : function() {
                        tinyMCE.activeEditor.windowManager.open({
                            // here come parameters for the popup window itself
                            file : location.protocol + '//' + location.host+"/content-variable.html",
                            width : 420,  // Your dimensions may differ - toy around with them!
                            height : 400,
                            resizable : "yes",
                            inline : "yes",  // This parameter only has an effect if you use the inlinepopups plugin!
                            close_previous : "no" // mind the missing comma here (because it's the last argument)
                        }, {
                            // here come parameters which get transferred to tinyMCEPopup and can be retrieved via tinyMCEPopup.getWindowArg("argName_here")
                            window : window, // here is the reference to your "opener" window
                            someOtherParam : "someOtherValue" // mind the missing comma here (because it's the last argument)
                        });
                    }
                });

            }

	});
</script>
<!-- /TinyMCE -->

{/literal}

 {literal}
 <style type="text/css">
         /******* MENU REGISTER BID POPUP *******/
     .email-tabs-clear{
         clear: both;
         height: 0;
         visibility: hidden;
         display: block;
     }
     container-register-bid{
         /*margin: 7em auto;
        width: 400px;*/
     }
     .email-tabs-child ul{
         list-style: none;
         list-style-position: outside;
     }
     .email-tabs-child ul li{
         float: left;
         margin-right: 5px;
         margin-bottom: -1px;
     }
     .email-tabs-child ul li{
         font-weight: 700;
         display: block;
         padding: 5px 10px 5px 10px;
         background: #efefef;
         border: 1px solid #d0ccc9;
         border-width: 1px 1px 0 1px;
         position: relative;
         color: #898989;
         cursor: pointer;
         margin-bottom:-2px;

     }
     .email-tabs-child ul li.active{
         background: #fff;
         top: 1px;
         /*border-bottom: 0;*/
         border-bottom: 1px solid white;
         color: #5f95ef;
     }
         /******* /MENU *******/
     .tabs-content
     {
         border: 1px solid #D0CCC9;
         clear: both;
         width: auto;
         margin-top: 2px;


     }
     .tabs-content textarea.input-text {
         height: 200px !important;
     }
     table strong{
         font-weight: bold;
     }

 </style>
 {/literal}


<div id="email-tabs" class="email-tabs">
    <div id="email-tabs-" class="email-tabs-">
        <div id="email-tabs-child" class="email-tabs-child">
            <ul id="email-tabs-child-ul" class="email-tabs-child-ul">
                <li id="tab-system-email" class="tab-system-email active">
                    System Emails
                </li>
                <li id="tab-service-email" class="tab-service-email">
                    Service Provider Emails
                </li>
                <li id="tab-user-email" class="tab-user-email">
                    User Notifications
                </li>
                {php}
                    if($_GET['show_all_email_template'] == 1){
                        $this->_tpl_vars['show_all_email_template'] = 1;
                    }
                {/php}
                {if $show_all_email_template == 1}
                <li id="tab-reg" class="tab-reg">
                    Account
                </li>
                <li id="tab-notify" class="tab-notify">
                    Notification
                </li>
                <li id="tab-watchlist-offer" class="tab-notify">
                    Watchlist&Offer
                </li>
                {/if}
                <li id="tab-other">
                    Signature Template
                </li>
            </ul>

            <div class="email-tabs-clear"></div>

            <div class="tab-system-email-content tabs-content" id="tab-system-email-content">
                <table width="100%" cellspacing="10" class="edit-table">
                    {*------------------------------------BEGIN NEW EMAIL: system_service_purchased------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>When a service is purchased ( by anyone, buyer/vendor or Agent)</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0; margin-bottom: 0;">Subject : </label>
                            <input type="text" id="email_system_service_purchased_subject" value="{$form_data.email_system_service_purchased_subject}" name="fields[email_system_service_purchased_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_system_service_purchased_description]" id = "email_system_service_purchased_description" class="input-text" style="width:100%;height:50px">{$form_data.email_system_service_purchased_description}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: system_property_posted------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>When a property is posted to bidRhino (to be reviewed)</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_system_property_posted_subject" value="{$form_data.email_system_property_posted_subject}" name="fields[email_system_property_posted_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_system_property_posted_description]" id = "email_system_property_posted_description" class="input-text" style="width:100%;height:50px">{$form_data.email_system_property_posted_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_system_property_posted_content]" id = "email_system_property_posted_content" class="input-text" style="width:100%;height:50px">{$form_data.email_system_property_posted_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: system_property_posted_to_live------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>When a property is posted to live site</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_system_property_posted_to_live_subject" value="{$form_data.email_system_property_posted_to_live_subject}" name="fields[email_system_property_posted_to_live_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_system_property_posted_to_live_description]" id = "email_system_property_posted_to_live_description" class="input-text" style="width:100%;height:50px">{$form_data.email_system_property_posted_to_live_description}</textarea>
                        </td>
                    </tr>

                    {*------------------------------------BEGIN NEW EMAIL: system_property_changed------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>If a change is made to a property</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_system_property_changed_subject" value="{$form_data.email_system_property_changed_subject}" name="fields[email_system_property_changed_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_system_property_changed_description]" id = "email_system_property_changed_description" class="input-text" style="width:100%;height:50px">{$form_data.email_system_property_changed_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_system_property_changed_content]" id = "email_system_property_changed_content" class="input-text editor" style="width:100%;height:50px">{$form_data.email_system_property_changed_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: system_property_registered_bid------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>When a bidder registers to bid on a property</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_system_property_registered_bid_subject" value="{$form_data.email_system_property_registered_bid_subject}" name="fields[email_system_property_registered_bid_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_system_property_registered_bid_description]" id = "email_system_property_registered_bid_description" class="input-text" style="width:100%;height:50px">{$form_data.email_system_property_registered_bid_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_system_property_registered_bid_content]" id = "email_system_property_registered_bid_content" class="input-text editor" style="width:100%;height:50px">{$form_data.email_system_property_registered_bid_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: system_property_approved_bid------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>When a bidder is approved to bid on a property</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_system_property_approved_bid_subject" value="{$form_data.email_system_property_approved_bid_subject}" name="fields[email_system_property_approved_bid_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_system_property_approved_bid_description]" id = "email_system_property_approved_bid_description" class="input-text" style="width:100%;height:50px">{$form_data.email_system_property_approved_bid_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_system_property_approved_bid_content]" id = "email_system_property_approved_bid_content" class="input-text editor" style="width:100%;height:50px">{$form_data.email_system_property_approved_bid_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: system_property_72hours_before_live------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>72 hours before an auction going live</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_system_property_72hours_before_live_subject" value="{$form_data.email_system_property_72hours_before_live_subject}" name="fields[email_system_property_72hours_before_live_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_system_property_72hours_before_live_description]" id = "email_system_property_72hours_before_live_description" class="input-text" style="width:100%;height:50px">{$form_data.email_system_property_72hours_before_live_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_system_property_72hours_before_live_content]" id = "email_system_property_72hours_before_live_content" class="input-text  editor" style="width:100%;height:50px">{$form_data.email_system_property_72hours_before_live_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: system_property_extended_due_to_bid_final_5_minutes------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>When an auction is extended due to bid in final 5 minutes</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_system_property_extended_due_to_bid_final_5_minutes_subject" value="{$form_data.email_system_property_extended_due_to_bid_final_5_minutes_subject}" name="fields[email_system_property_extended_due_to_bid_final_5_minutes_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_system_property_extended_due_to_bid_final_5_minutes_description]" id = "email_system_property_extended_due_to_bid_final_5_minutes_description" class="input-text" style="width:100%;height:50px">{$form_data.email_system_property_extended_due_to_bid_final_5_minutes_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_system_property_extended_due_to_bid_final_5_minutes_content]" id = "email_system_property_extended_due_to_bid_final_5_minutes_content" class="input-text editor" style="width:100%;height:50px">{$form_data.email_system_property_extended_due_to_bid_final_5_minutes_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: system_property_sold_or_leased------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>If a property is sold or leased</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_system_property_sold_or_leased_subject" value="{$form_data.email_system_property_sold_or_leased_subject}" name="fields[email_system_property_sold_or_leased_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_system_property_sold_or_leased_description]" id = "email_system_property_sold_or_leased_description" class="input-text" style="width:100%;height:50px">{$form_data.email_system_property_sold_or_leased_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_system_property_sold_or_leased_content]" id = "email_system_property_sold_or_leased_content" class="input-text editor" style="width:100%;height:50px">{$form_data.email_system_property_sold_or_leased_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: system_property_passed_in------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>If a property is passed in</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_system_property_passed_in_subject" value="{$form_data.email_system_property_passed_in_subject}" name="fields[email_system_property_passed_in_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_system_property_passed_in_description]" id = "email_system_property_passed_in_description" class="input-text" style="width:100%;height:50px">{$form_data.email_system_property_passed_in_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_system_property_passed_in_content]" id = "email_system_property_passed_in_content" class="input-text editor" style="width:100%;height:50px">{$form_data.email_system_property_passed_in_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: system_property_closed_or_disabled------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>if a property is closed, disabled by vendor</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_system_property_closed_or_disabled_subject" value="{$form_data.email_system_property_closed_or_disabled_subject}" name="fields[email_system_property_closed_or_disabled_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_system_property_closed_or_disabled_description]" id = "email_system_property_closed_or_disabled_description" class="input-text" style="width:100%;height:50px">{$form_data.email_system_property_closed_or_disabled_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_system_property_closed_or_disabled_content]" id = "email_system_property_closed_or_disabled_content" class="input-text editor" style="width:100%;height:50px">{$form_data.email_system_property_closed_or_disabled_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BUTTON------------------------------------*}
                    <tr>
                        <td colspan="2" align="right">
                            <hr/>
                            <input type="submit" class="button" value="Save"/>
                        </td>
                    </tr>

                </table>
            </div>

            <div class="tab-service-email-content tabs-content" id="tab-service-email-content">
                <table width="100%" cellspacing="10" class="edit-table">
                    {*------------------------------------BEGIN NEW EMAIL: user_post_property_service------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>User selects post my property service</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_post_property_service_subject" value="{$form_data.email_user_post_property_service_subject}" name="fields[email_user_post_property_service_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_user_post_property_service_description]" id = "email_user_post_property_service_description" class="input-text" style="width:100%;height:50px">{$form_data.email_user_post_property_service_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_post_property_service_content]" id = "email_user_post_property_service_content" class="input-text  editor" style="width:100%;height:50px">{$form_data.email_user_post_property_service_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: service_provider_user_post_property_service------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>User selects post my property service</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_service_provider_user_post_property_service_subject" value="{$form_data.email_service_provider_user_post_property_service_subject}" name="fields[email_service_provider_user_post_property_service_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_post_property_service_description]" id = "email_service_provider_user_post_property_service_description" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_post_property_service_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_post_property_service_content]" id = "email_service_provider_user_post_property_service_content" class="input-text editor" style="width:100%;height:50px">{$form_data.email_service_provider_user_post_property_service_content}</textarea>
                        </td>
                    </tr>

                    {*------------------------------------BEGIN NEW EMAIL: service_provider_user_review_property_listing------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>A user has selected Review property listing</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_service_provider_user_review_property_listing_subject" value="{$form_data.email_service_provider_user_review_property_listing_subject}" name="fields[email_service_provider_user_review_property_listing_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_review_property_listing_description]" id = "email_service_provider_user_review_property_listing_description" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_review_property_listing_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_review_property_listing_content]" id = "email_service_provider_user_review_property_listing_content" class="input-text editor" style="width:100%;height:50px">{$form_data.email_service_provider_user_review_property_listing_content}</textarea>
                        </td>
                    </tr>

                    {*------------------------------------BEGIN NEW EMAIL: service_provider_user_bidder_assessment------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>A user has selected bidder assessment</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_service_provider_user_bidder_assessment_subject" value="{$form_data.email_service_provider_user_bidder_assessment_subject}" name="fields[email_service_provider_user_bidder_assessment_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_bidder_assessment_description]" id = "email_service_provider_user_bidder_assessment_description" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_bidder_assessment_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_bidder_assessment_content]" id = "email_service_provider_user_bidder_assessment_content" class="input-text editor" style="width:100%;height:50px">{$form_data.email_service_provider_user_bidder_assessment_content}</textarea>
                        </td>
                    </tr>

                    {*------------------------------------BEGIN NEW EMAIL: service_provider_user_select_buyer_co-ordination------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>A user has selected buyer co-ordination</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_service_provider_user_select_buyer_co-ordination_subject" value="{$form_data.email_service_provider_user_select_buyer_co-ordination_subject}" name="fields[email_service_provider_user_select_buyer_co-ordination_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_select_buyer_co-ordination_description]" id = "email_service_provider_user_select_buyer_co-ordination_description" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_select_buyer_co-ordination_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_select_buyer_co-ordination_content]" id = "email_service_provider_user_select_buyer_co-ordination_content" class="input-text editor" style="width:100%;height:50px">{$form_data.email_service_provider_user_select_buyer_co-ordination_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: service_provider_user_selected_settlement_services------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>A user has selected settlement services</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_service_provider_user_selected_settlement_services_subject" value="{$form_data.email_service_provider_user_selected_settlement_services_subject}" name="fields[email_service_provider_user_selected_settlement_services_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_settlement_services_description]" id = "email_service_provider_user_selected_settlement_services_description" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_settlement_services_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_settlement_services_content]" id = "email_service_provider_user_selected_settlement_services_content" class="input-text editor" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_settlement_services_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: service_provider_user_selected_photography_service------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>User has selected property photography service</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_service_provider_user_selected_photography_service_subject" value="{$form_data.email_service_provider_user_selected_photography_service_subject}" name="fields[email_service_provider_user_selected_photography_service_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_photography_service_description]" id = "email_service_provider_user_selected_photography_service_description" class="input-text editor" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_photography_service_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_photography_service_content]" id = "email_service_provider_user_selected_photography_service_content" class="input-text editor" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_photography_service_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: service_provider_user_selected_video_service------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>User has selected property video service</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_service_provider_user_selected_video_service_subject" value="{$form_data.email_service_provider_user_selected_video_service_subject}" name="fields[email_service_provider_user_selected_video_service_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_video_service_description]" id = "email_service_provider_user_selected_video_service_description" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_video_service_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_video_service_content]" id = "email_service_provider_user_selected_video_service_content" class="input-text editor" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_video_service_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: service_provider_user_selected_copywriting_service------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>A user has selected property copywriting service</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_service_provider_user_selected_copywriting_service_subject" value="{$form_data.email_service_provider_user_selected_copywriting_service_subject}" name="fields[email_service_provider_user_selected_copywriting_service_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_copywriting_service_description]" id = "email_service_provider_user_selected_copywriting_service_description" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_copywriting_service_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_copywriting_service_content]" id = "email_service_provider_user_selected_copywriting_service_content" class="input-text  editor" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_copywriting_service_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: service_provider_user_selected_floorplan_service------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>A user has selected property floorplan service</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_service_provider_user_selected_floorplan_service_subject" value="{$form_data.email_service_provider_user_selected_floorplan_service_subject}" name="fields[email_service_provider_user_selected_floorplan_service_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_floorplan_service_description]" id = "email_service_provider_user_selected_floorplan_service_description" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_floorplan_service_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_floorplan_service_content]" id = "email_service_provider_user_selected_floorplan_service_content" class="input-text editor" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_floorplan_service_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: service_provider_user_selected_floorplan_service------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>A user has selected property floorplan service</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_service_provider_user_selected_floorplan_service_subject" value="{$form_data.email_service_provider_user_selected_floorplan_service_subject}" name="fields[email_service_provider_user_selected_floorplan_service_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_floorplan_service_description]" id = "email_service_provider_user_selected_floorplan_service_description" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_floorplan_service_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_floorplan_service_content]" id = "email_service_provider_user_selected_floorplan_service_content" class="input-text  editor" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_floorplan_service_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: service_provider_user_selected_designer_service------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>A user has selected property designer service</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_service_provider_user_selected_designer_service_subject" value="{$form_data.email_service_provider_user_selected_designer_service_subject}" name="fields[email_service_provider_user_selected_designer_service_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_designer_service_description]" id = "email_service_provider_user_selected_designer_service_description" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_designer_service_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_designer_service_content]" id = "email_service_provider_user_selected_designer_service_content" class="input-text editor" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_designer_service_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: service_provider_user_selected_full_valuation_service------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>A user has selected property full valuation service</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_service_provider_user_selected_full_valuation_service_subject" value="{$form_data.email_service_provider_user_selected_full_valuation_service_subject}" name="fields[email_service_provider_user_selected_full_valuation_service_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_full_valuation_service_description]" id = "email_service_provider_user_selected_full_valuation_service_description" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_full_valuation_service_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_full_valuation_service_content]" id = "email_service_provider_user_selected_full_valuation_service_content" class="input-text editor" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_full_valuation_service_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: service_provider_user_selected_desktop_valuation_service------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>A user has selected property desktop valuation service</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_service_provider_user_selected_desktop_valuation_service_subject" value="{$form_data.email_service_provider_user_selected_desktop_valuation_service_subject}" name="fields[email_service_provider_user_selected_desktop_valuation_service_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_desktop_valuation_service_description]" id = "email_service_provider_user_selected_desktop_valuation_service_description" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_desktop_valuation_service_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_desktop_valuation_service_content]" id = "email_service_provider_user_selected_desktop_valuation_service_content" class="input-text editor" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_desktop_valuation_service_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: service_provider_user_selected_report_service------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>bidRhino - a user has selected property report service</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_service_provider_user_selected_report_service_subject" value="{$form_data.email_service_provider_user_selected_report_service_subject}" name="fields[email_service_provider_user_selected_report_service_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_report_service_description]" id = "email_service_provider_user_selected_report_service_description" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_report_service_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_report_service_content]" id = "email_service_provider_user_selected_report_service_content" class="input-text editor" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_report_service_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: service_provider_user_selected_report_service------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>bidRhino - a user has selected property report service</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_service_provider_user_selected_report_service_subject" value="{$form_data.email_service_provider_user_selected_report_service_subject}" name="fields[email_service_provider_user_selected_report_service_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_report_service_description]" id = "email_service_provider_user_selected_report_service_description" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_report_service_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_report_service_content]" id = "email_service_provider_user_selected_report_service_content" class="input-text editor" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_report_service_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: service_provider_user_selected_suburb_report_service------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>bidRhino - a user has selected suburb report service</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_service_provider_user_selected_suburb_report_service_subject" value="{$form_data.email_service_provider_user_selected_suburb_report_service_subject}" name="fields[email_service_provider_user_selected_suburb_report_service_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_suburb_report_service_description]" id = "email_service_provider_user_selected_suburb_report_service_description" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_suburb_report_service_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_suburb_report_service_content]" id = "email_service_provider_user_selected_suburb_report_service_content" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_suburb_report_service_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: service_provider_user_selected_building_inspection_service------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>bidRhino - a user has selected building inspection service</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_service_provider_user_selected_building_inspection_service_subject" value="{$form_data.email_service_provider_user_selected_building_inspection_service_subject}" name="fields[email_service_provider_user_selected_building_inspection_service_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_building_inspection_service_description]" id = "email_service_provider_user_selected_building_inspection_service_description" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_building_inspection_service_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_building_inspection_service_content]" id = "email_service_provider_user_selected_building_inspection_service_content" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_building_inspection_service_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: service_provider_user_selected_marketing_plan_1_domain_service------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>bidRhino - a user has selected marketing plan 1 Domain service</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_service_provider_user_selected_marketing_plan_1_domain_service_subject" value="{$form_data.email_service_provider_user_selected_marketing_plan_1_domain_service_subject}" name="fields[email_service_provider_user_selected_marketing_plan_1_domain_service_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_marketing_plan_1_domain_service_description]" id = "email_service_provider_user_selected_marketing_plan_1_domain_service_description" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_marketing_plan_1_domain_service_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_marketing_plan_1_domain_service_content]" id = "email_service_provider_user_selected_marketing_plan_1_domain_service_content" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_marketing_plan_1_domain_service_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: service_provider_user_selected_marketing_plan_2_rea_service------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>bidRhino - a user has selected marketing plan 2 REA service</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_service_provider_user_selected_marketing_plan_2_rea_service_subject" value="{$form_data.email_service_provider_user_selected_marketing_plan_2_rea_service_subject}" name="fields[email_service_provider_user_selected_marketing_plan_2_rea_service_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_marketing_plan_2_rea_service_description]" id = "email_service_provider_user_selected_marketing_plan_2_rea_service_description" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_marketing_plan_2_rea_service_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_marketing_plan_2_rea_service_content]" id = "email_service_provider_user_selected_marketing_plan_2_rea_service_content" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_marketing_plan_2_rea_service_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: service_provider_user_selected_marketing_plan_3_all_service------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>bidRhino - a user has selected marketing plan 3 All service</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_service_provider_user_selected_marketing_plan_3_all_service_subject" value="{$form_data.email_service_provider_user_selected_marketing_plan_3_all_service_subject}" name="fields[email_service_provider_user_selected_marketing_plan_3_all_service_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_marketing_plan_3_all_service_description]" id = "email_service_provider_user_selected_marketing_plan_3_all_service_description" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_marketing_plan_3_all_service_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_marketing_plan_3_all_service_content]" id = "email_service_provider_user_selected_marketing_plan_3_all_service_content" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_marketing_plan_3_all_service_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: service_provider_user_selected_marketing_plan_4_rental_domain_services------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>bidRhino - a user has selected marketing plan 4 Rental Domain Services</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_service_provider_user_selected_marketing_plan_4_rental_domain_services_subject" value="{$form_data.email_service_provider_user_selected_marketing_plan_4_rental_domain_services_subject}" name="fields[email_service_provider_user_selected_marketing_plan_4_rental_domain_services_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_marketing_plan_4_rental_domain_services_description]" id = "email_service_provider_user_selected_marketing_plan_4_rental_domain_services_description" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_marketing_plan_4_rental_domain_services_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_marketing_plan_4_rental_domain_services_content]" id = "email_service_provider_user_selected_marketing_plan_4_rental_domain_services_content" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_marketing_plan_4_rental_domain_services_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: service_provider_user_selected_marketing_plan_5_rental_REA_service------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>bidRhino - a user has selected marketing plan 5 Rental REA Service</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_service_provider_user_selected_marketing_plan_5_rental_REA_service_subject" value="{$form_data.email_service_provider_user_selected_marketing_plan_5_rental_REA_service_subject}" name="fields[email_service_provider_user_selected_marketing_plan_5_rental_REA_service_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_marketing_plan_5_rental_REA_service_description]" id = "email_service_provider_user_selected_marketing_plan_5_rental_REA_service_description" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_marketing_plan_5_rental_REA_service_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_marketing_plan_5_rental_REA_service_content]" id = "email_service_provider_user_selected_marketing_plan_5_rental_REA_service_content" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_marketing_plan_5_rental_REA_service_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: service_provider_user_selected_marketing_plan_6_rental_REA_service------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>bidRhino - a user has selected marketing plan 6 Rental All service</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_service_provider_user_selected_marketing_plan_6_rental_REA_service_subject" value="{$form_data.email_service_provider_user_selected_marketing_plan_6_rental_REA_service_subject}" name="fields[email_service_provider_user_selected_marketing_plan_6_rental_REA_service_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_marketing_plan_6_rental_REA_service_description]" id = "email_service_provider_user_selected_marketing_plan_6_rental_REA_service_description" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_marketing_plan_6_rental_REA_service_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_marketing_plan_6_rental_REA_service_content]" id = "email_service_provider_user_selected_marketing_plan_6_rental_REA_service_content" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_marketing_plan_6_rental_REA_service_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: service_provider_user_selected_HelloRE_Option_2_Open_service------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>bidRhino - a user has selected HelloRE Option 2 Open service</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_service_provider_user_selected_HelloRE_Option_2_Open_service_subject" value="{$form_data.email_service_provider_user_selected_HelloRE_Option_2_Open_service_subject}" name="fields[email_service_provider_user_selected_HelloRE_Option_2_Open_service_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_HelloRE_Option_2_Open_service_description]" id = "email_service_provider_user_selected_HelloRE_Option_2_Open_service_description" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_HelloRE_Option_2_Open_service_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_HelloRE_Option_2_Open_service_content]" id = "email_service_provider_user_selected_HelloRE_Option_2_Open_service_content" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_HelloRE_Option_2_Open_service_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: service_provider_user_selected_HelloRE_Option_3_service------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>bidRhino - a user has selected Hello RE Option 3 service</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_service_provider_user_selected_HelloRE_Option_3_service_subject" value="{$form_data.email_service_provider_user_selected_HelloRE_Option_3_service_subject}" name="fields[email_service_provider_user_selected_HelloRE_Option_3_service_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_HelloRE_Option_3_service_description]" id = "email_service_provider_user_selected_HelloRE_Option_3_service_description" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_HelloRE_Option_3_service_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_HelloRE_Option_3_service_content]" id = "email_service_provider_user_selected_HelloRE_Option_3_service_content" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_HelloRE_Option_3_service_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: service_provider_user_selected_HelloRE_Option_4_service------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>bidRhino - a user has selected Hello RE Option 4 service</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_service_provider_user_selected_HelloRE_Option_4_service_subject" value="{$form_data.email_service_provider_user_selected_HelloRE_Option_4_service_subject}" name="fields[email_service_provider_user_selected_HelloRE_Option_4_service_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_HelloRE_Option_4_service_description]" id = "email_service_provider_user_selected_HelloRE_Option_4_service_description" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_HelloRE_Option_4_service_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_HelloRE_Option_4_service_content]" id = "email_service_provider_user_selected_HelloRE_Option_4_service_content" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_HelloRE_Option_4_service_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: service_provider_user_selected_an_AVR------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>bidRhino - a user has selected an AVR (corelogic)</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_service_provider_user_selected_an_AVR_subject" value="{$form_data.email_service_provider_user_selected_an_AVR_subject}" name="fields[email_service_provider_user_selected_an_AVR_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Description
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_an_AVR_description]" id = "email_service_provider_user_selected_an_AVR_description" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_an_AVR_description}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_user_selected_an_AVR_content]" id = "email_service_provider_user_selected_an_AVR_content" class="input-text" style="width:100%;height:50px">{$form_data.email_service_provider_user_selected_an_AVR_content}</textarea>
                        </td>
                    </tr>

                    {*------------------------------------BUTTON------------------------------------*}
                    <tr>
                        <td colspan="2" align="right">
                            <hr/>
                            <input type="submit" class="button" value="Save"/>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="tab-user-email-content tabs-content" id="tab-user-email-content">
                <table width="100%" cellspacing="10" class="edit-table">
                    {*------------------------------------BEGIN NEW EMAIL:  user_finished_account------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>Register as a user - confirmation and verification link</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: User email</strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_finished_account_subject" value="{$form_data.email_user_finished_account_subject}" name="fields[email_user_finished_account_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                        </td>
                        <td>
                            <textarea name = "fields[email_user_finished_account_content]" id = "email_user_finished_account_content" class="input-text editor" style="width:100%;height:100px">{$form_data.email_user_finished_account_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_finished_account_sms_content]" id = "email_user_finished_account_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_finished_account_sms_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: ------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>Forgot Password</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: User email</strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_forgot_password_subject" value="{$form_data.email_forgot_password_subject}" name="fields[email_forgot_password_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                        </td>
                        <td>
                            <textarea name = "fields[email_forgot_password_msg]" id = "email_forgot_password_msg" class="input-text editor" style="width:100%;height:100px">{$form_data.email_forgot_password_msg}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: ------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>Change a New Password</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: User email</strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_new_password_subject" value="{$form_data.email_new_password_subject}" name="fields[email_new_password_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                        </td>
                        <td>
                            <textarea name = "fields[email_new_password_msg]" id = "email_new_password_msg" class="input-text editor" style="width:100%;height:100px">{$form_data.email_new_password_msg}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: user_select_any_purchase------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>When a user selects any purchase - property listing or added service</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: user email
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_select_any_purchase_subject" value="{$form_data.email_user_select_any_purchase_subject}" name="fields[email_user_select_any_purchase_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_select_any_purchase_content]" id = "email_user_select_any_purchase_content" class="input-text editor" style="width:100%;height:50px">{$form_data.email_user_select_any_purchase_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: user_vendor_approved_and_posted_to_live------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>When a vendor (agent) property is approved (by bidRhino) and posted to live web</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: Vendor, Landlord, Agent
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_vendor_approved_and_posted_to_live_subject" value="{$form_data.email_user_vendor_approved_and_posted_to_live_subject}" name="fields[email_user_vendor_approved_and_posted_to_live_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_vendor_approved_and_posted_to_live_content]" id = "email_user_vendor_approved_and_posted_to_live_content" class="input-text editor" style="width:100%;height:50px">{$form_data.email_user_vendor_approved_and_posted_to_live_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_vendor_approved_and_posted_to_live_sms_content]" id = "email_user_vendor_approved_and_posted_to_live_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_vendor_approved_and_posted_to_live_sms_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: user_bidder_register_to_bid------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>When a bidder registers to bid on a property</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: Vendor, Landlord, Agent
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_bidder_register_to_bid_subject" value="{$form_data.email_user_bidder_register_to_bid_subject}" name="fields[email_user_bidder_register_to_bid_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_bidder_register_to_bid_content]" id = "email_user_bidder_register_to_bid_content" class="input-text editor" style="width:100%;height:50px">{$form_data.email_user_bidder_register_to_bid_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_bidder_register_to_bid_sms_content]" id = "email_user_bidder_register_to_bid_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_bidder_register_to_bid_sms_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: user_bidder_register_to_bid_bidder------------------------------------*}
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: Bidder
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_bidder_register_to_bid_bidder_subject" value="{$form_data.email_user_bidder_register_to_bid_bidder_subject}" name="fields[email_user_bidder_register_to_bid_bidder_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_bidder_register_to_bid_bidder_content]" id = "email_user_bidder_register_to_bid_bidder_content" class="input-text editor" style="width:100%;height:50px">{$form_data.email_user_bidder_register_to_bid_bidder_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_bidder_register_to_bid_bidder_sms_content]" id = "email_user_bidder_register_to_bid_bidder_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_bidder_register_to_bid_bidder_sms_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: user_bidder_approved_vendor_agent_to_bid------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>When a bidder is approved by Vendor/Agent to bid on a property</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: Bidder
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_bidder_approved_vendor_agent_to_bid_subject" value="{$form_data.email_user_bidder_approved_vendor_agent_to_bid_subject}" name="fields[email_user_bidder_approved_vendor_agent_to_bid_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_bidder_approved_vendor_agent_to_bid_content]" id = "email_user_bidder_approved_vendor_agent_to_bid_content" class="input-text editor" style="width:100%;height:50px">{$form_data.email_user_bidder_approved_vendor_agent_to_bid_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_bidder_approved_vendor_agent_to_bid_sms_content]" id = "email_user_bidder_approved_vendor_agent_to_bid_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_bidder_approved_vendor_agent_to_bid_sms_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: user_bidder_approved_vendor_agent_to_bid_vendor------------------------------------*}
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: Vendor, Landlord, Agent
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_bidder_approved_vendor_agent_to_bid_vendor_subject" value="{$form_data.email_user_bidder_approved_vendor_agent_to_bid_vendor_subject}" name="fields[email_user_bidder_approved_vendor_agent_to_bid_vendor_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_bidder_approved_vendor_agent_to_bid_vendor_content]" id = "email_user_bidder_approved_vendor_agent_to_bid_vendor_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_bidder_approved_vendor_agent_to_bid_vendor_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_bidder_approved_vendor_agent_to_bid_vendor_sms_content]" id = "email_user_bidder_approved_vendor_agent_to_bid_vendor_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_bidder_approved_vendor_agent_to_bid_vendor_sms_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: user_added_to_a_watchlist------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>When a property is added to a watchlist</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: Vendor, Landlord, Agent
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_added_to_a_watchlist_subject" value="{$form_data.email_user_added_to_a_watchlist_subject}" name="fields[email_user_added_to_a_watchlist_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_added_to_a_watchlist_content]" id = "email_user_added_to_a_watchlist_content" class="input-text editor" style="width:100%;height:50px">{$form_data.email_user_added_to_a_watchlist_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_added_to_a_watchlist_sms_content]" id = "email_user_added_to_a_watchlist_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_added_to_a_watchlist_sms_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: User
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_added_to_a_watchlist_user_subject" value="{$form_data.email_user_added_to_a_watchlist_user_subject}" name="fields[email_user_added_to_a_watchlist_user_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_added_to_a_watchlist_user_content]" id = "email_user_added_to_a_watchlist_user_content" class="input-text editor" style="width:100%;height:50px">{$form_data.email_user_added_to_a_watchlist_user_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_added_to_a_watchlist_user_sms_content]" id = "email_user_added_to_a_watchlist_user_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_added_to_a_watchlist_user_sms_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: user_property_changed------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>A property is changed</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: Vendor, Landlord, Agent
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_property_changed_subject" value="{$form_data.email_user_property_changed_subject}" name="fields[email_user_property_changed_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_property_changed_content]" id = "email_user_property_changed_content" class="input-text editor" style="width:100%;height:50px">{$form_data.email_user_property_changed_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_property_changed_sms_content]" id = "email_user_property_changed_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_property_changed_sms_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: bidder
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_property_changed_bidder_subject" value="{$form_data.email_user_property_changed_bidder_subject}" name="fields[email_user_property_changed_bidder_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_property_changed_bidder_content]" id = "email_user_property_changed_bidder_content" class="input-text editor" style="width:100%;height:50px">{$form_data.email_user_property_changed_bidder_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_property_changed_bidder_sms_content]" id = "email_user_property_changed_bidder_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_property_changed_bidder_sms_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: user (with property in watch list)
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_property_changed_user_in_watch_list_subject" value="{$form_data.email_user_property_changed_user_in_watch_list_subject}" name="fields[email_user_property_changed_user_in_watch_list_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_property_changed_user_in_watch_list_content]" id = "email_user_property_changed_user_in_watch_list_content" class="input-text editor" style="width:100%;height:50px">{$form_data.email_user_property_changed_user_in_watch_list_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_property_changed_user_in_watch_list_sms_content]" id = "email_user_property_changed_user_in_watch_list_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_property_changed_user_in_watch_list_sms_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: user_4_days_before_auction_starts------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>4 days before auction starts</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: Vendor, Landlord, Agent
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_4_days_before_auction_starts_subject" value="{$form_data.email_user_4_days_before_auction_starts_subject}" name="fields[email_user_4_days_before_auction_starts_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_4_days_before_auction_starts_content]" id = "email_user_4_days_before_auction_starts_content" class="input-text  editor" style="width:100%;height:50px">{$form_data.email_user_4_days_before_auction_starts_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_4_days_before_auction_starts_sms_content]" id = "email_user_4_days_before_auction_starts_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_4_days_before_auction_starts_sms_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: user_24_hours_before_auction_starts------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>24 hours before auction starts</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: Vendor, Landlord, Agent
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_24_hours_before_auction_starts_subject" value="{$form_data.email_user_24_hours_before_auction_starts_subject}" name="fields[email_user_24_hours_before_auction_starts_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_24_hours_before_auction_starts_content]" id = "email_user_24_hours_before_auction_starts_content" class="input-text  editor" style="width:100%;height:50px">{$form_data.email_user_24_hours_before_auction_starts_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_24_hours_before_auction_starts_sms_content]" id = "email_user_24_hours_before_auction_starts_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_24_hours_before_auction_starts_sms_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: Bidder
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_24_hours_before_auction_starts_bidder_subject" value="{$form_data.email_user_24_hours_before_auction_starts_bidder_subject}" name="fields[email_user_24_hours_before_auction_starts_bidder_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_24_hours_before_auction_starts_bidder_content]" id = "email_user_24_hours_before_auction_starts_bidder_content" class="input-text editor" style="width:100%;height:50px">{$form_data.email_user_24_hours_before_auction_starts_bidder_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_24_hours_before_auction_starts_bidder_sms_content]" id = "email_user_24_hours_before_auction_starts_bidder_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_24_hours_before_auction_starts_bidder_sms_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: user (with property in watch list)
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_24_hours_before_auction_starts_user_in_watchlist_subject" value="{$form_data.email_user_24_hours_before_auction_starts_user_in_watchlist_subject}" name="fields[email_user_24_hours_before_auction_starts_user_in_watchlist_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_24_hours_before_auction_starts_user_in_watchlist_content]" id = "email_user_24_hours_before_auction_starts_user_in_watchlist_content" class="input-text  editor" style="width:100%;height:50px">{$form_data.email_user_24_hours_before_auction_starts_user_in_watchlist_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_24_hours_before_auction_starts_user_in_watchlist_sms_content]" id = "email_user_24_hours_before_auction_starts_user_in_watchlist_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_24_hours_before_auction_starts_user_in_watchlist_sms_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: user_auction_go_to_start------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>When auction go to starts 1 day</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: Vendor, Landlord, Agent
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_auction_go_to_start_subject" value="{$form_data.email_user_auction_go_to_start_subject}" name="fields[email_user_auction_go_to_start_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_auction_go_to_start_content]" id = "email_user_auction_go_to_start_content" class="input-text  editor" style="width:100%;height:50px">{$form_data.email_user_auction_go_to_start_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_auction_go_to_start_sms_content]" id = "email_user_auction_go_to_start_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_auction_go_to_start_sms_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: all registered bidders
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_user_auction_go_to_start_bidder_subject" value="{$form_data.email_user_user_auction_go_to_start_bidder_subject}" name="fields[email_user_user_auction_go_to_start_bidder_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_auction_go_to_start_registered_bidder_content]" id = "email_user_auction_go_to_start_registered_bidder_content" class="input-text editor" style="width:100%;height:50px">{$form_data.email_user_auction_go_to_start_registered_bidder_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_auction_go_to_start_registered_bidder_sms_content]" id = "email_user_auction_go_to_start_registered_bidder_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_auction_go_to_start_registered_bidder_sms_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: Users with property in watch list
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_auction_go_to_start_user_in_watchlist_subject" value="{$form_data.email_user_auction_go_to_start_user_in_watchlist_subject}" name="fields[email_user_auction_go_to_start_user_in_watchlist_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_auction_go_to_start_user_in_watchlist_content]" id = "email_user_auction_go_to_start_user_in_watchlist_content" class="input-text  editor" style="width:100%;height:50px">{$form_data.email_user_auction_go_to_start_user_in_watchlist_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_auction_go_to_start_in_watchlist_sms_content]" id = "email_user_auction_go_to_start_in_watchlist_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_auction_go_to_start_in_watchlist_sms_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: user_property_go_to_release------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>When property go to release 30'</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: Vendor, Landlord, Agent
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="user_property_go_to_release_subject" value="{$form_data.email_user_property_go_to_release_subject}" name="fields[email_user_property_go_to_release_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_property_go_to_release_content]" id = "email_user_property_go_to_release_content" class="input-text  editor" style="width:100%;height:50px">{$form_data.email_user_property_go_to_release_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_property_go_to_release_sms_content]" id = "email_user_property_go_to_release_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_property_go_to_release_sms_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: all registered bidders
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_user_property_go_to_release_bidder_subject" value="{$form_data.email_user_user_property_go_to_release_bidder_subject}" name="fields[email_user_user_property_go_to_release_bidder_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_property_go_to_release_registered_bidder_content]" id = "email_user_property_go_to_release_registered_bidder_content" class="input-text editor" style="width:100%;height:50px">{$form_data.email_user_property_go_to_release_registered_bidder_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_property_go_to_release_registered_bidder_sms_content]" id = "email_user_property_go_to_release_registered_bidder_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_property_go_to_release_registered_bidder_sms_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: Users with property in watch list
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_property_go_to_release_user_in_watchlist_subject" value="{$form_data.email_user_property_go_to_release_user_in_watchlist_subject}" name="fields[email_user_property_go_to_release_user_in_watchlist_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_property_go_to_release_user_in_watchlist_content]" id = "email_user_property_go_to_release_user_in_watchlist_content" class="input-text  editor" style="width:100%;height:50px">{$form_data.email_user_property_go_to_release_user_in_watchlist_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_property_go_to_release_in_watchlist_sms_content]" id = "email_user_property_go_to_release_in_watchlist_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_property_go_to_release_in_watchlist_sms_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: user_auction_start------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>When auction starts</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: Vendor, Landlord, Agent
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_auction_start_subject" value="{$form_data.email_user_auction_start_subject}" name="fields[email_user_auction_start_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_auction_start_content]" id = "email_user_auction_start_content" class="input-text  editor" style="width:100%;height:50px">{$form_data.email_user_auction_start_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_auction_start_sms_content]" id = "email_user_auction_start_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_auction_start_sms_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: all registered bidders
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_auction_start_registered_bidder_subject" value="{$form_data.email_user_auction_start_registered_bidder_subject}" name="fields[email_user_auction_start_registered_bidder_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_auction_start_registered_bidder_content]" id = "email_user_auction_start_registered_bidder_content" class="input-text editor" style="width:100%;height:50px">{$form_data.email_user_auction_start_registered_bidder_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_auction_start_registered_bidder_sms_content]" id = "email_user_auction_start_registered_bidder_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_auction_start_registered_bidder_sms_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: Users with property in watch list
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_auction_start_user_in_watchlist_subject" value="{$form_data.email_user_auction_start_user_in_watchlist_subject}" name="fields[email_user_auction_start_user_in_watchlist_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_auction_start_user_in_watchlist_content]" id = "email_user_auction_start_user_in_watchlist_content" class="input-text  editor" style="width:100%;height:50px">{$form_data.email_user_auction_start_user_in_watchlist_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_auction_start_user_in_watchlist_sms_content]" id = "email_user_auction_start_user_in_watchlist_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_auction_start_user_in_watchlist_sms_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: user_bid_placed_in_an_auction------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>When a bid is placed in an auction</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: Vendor, Landlord, Agent
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_bid_placed_in_an_auction_subject" value="{$form_data.email_user_bid_placed_in_an_auction_subject}" name="fields[email_user_bid_placed_in_an_auction_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_bid_placed_in_an_auction_content]" id = "email_user_bid_placed_in_an_auction_content" class="input-text  editor" style="width:100%;height:50px">{$form_data.email_user_bid_placed_in_an_auction_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_bid_placed_in_an_auction_sms_content]" id = "email_user_bid_placed_in_an_auction_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_bid_placed_in_an_auction_sms_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: All registered bidders
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_bid_placed_in_an_auction_registered_bidders_subject" value="{$form_data.email_user_bid_placed_in_an_auction_registered_bidders_subject}" name="fields[email_user_bid_placed_in_an_auction_registered_bidders_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_bid_placed_in_an_auction_registered_bidders_content]" id = "email_user_bid_placed_in_an_auction_registered_bidders_content" class="input-text editor" style="width:100%;height:50px">{$form_data.email_user_bid_placed_in_an_auction_registered_bidders_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_bid_placed_in_an_auction_registered_bidders_sms_content]" id = "email_user_bid_placed_in_an_auction_registered_bidders_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_bid_placed_in_an_auction_registered_bidders_sms_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: users with property in watch list
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_bid_placed_in_an_auction_user_in_watchlist_subject" value="{$form_data.email_user_bid_placed_in_an_auction_user_in_watchlist_subject}" name="fields[email_user_bid_placed_in_an_auction_user_in_watchlist_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_bid_placed_in_an_auction_user_in_watchlist_content]" id = "email_user_bid_placed_in_an_auction_user_in_watchlist_content" class="input-text  editor" style="width:100%;height:50px">{$form_data.email_user_bid_placed_in_an_auction_user_in_watchlist_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_bid_placed_in_an_auction_user_in_watchlist_sms_content]" id = "email_user_bid_placed_in_an_auction_user_in_watchlist_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_bid_placed_in_an_auction_user_in_watchlist_sms_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: previous highest bidder
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_bid_placed_in_an_auction_previous_highest_bidder_subject" value="{$form_data.email_user_bid_placed_in_an_auction_previous_highest_bidder_subject}" name="fields[email_user_bid_placed_in_an_auction_previous_highest_bidder_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_bid_placed_in_an_auction_previous_highest_bidder_content]" id = "email_user_bid_placed_in_an_auction_previous_highest_bidder_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_bid_placed_in_an_auction_previous_highest_bidder_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_bid_placed_in_an_auction_previous_highest_bidder_sms_content]" id = "email_user_bid_placed_in_an_auction_previous_highest_bidder_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_bid_placed_in_an_auction_previous_highest_bidder_sms_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: user_2_hours_before_auction_end------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>Notifications before auction ends </legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: Vendor, Landlord, Agent
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_2_hours_before_auction_end_subject" value="{$form_data.email_user_2_hours_before_auction_end_subject}" name="fields[email_user_2_hours_before_auction_end_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_2_hours_before_auction_end_content]" id = "email_user_2_hours_before_auction_end_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_2_hours_before_auction_end_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_2_hours_before_auction_end_sms_content]" id = "email_user_2_hours_before_auction_end_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_2_hours_before_auction_end_sms_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: all registered bidders
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_2_hours_before_auction_end_all_register_bidders_subject" value="{$form_data.email_user_2_hours_before_auction_end_all_register_bidders_subject}" name="fields[email_user_2_hours_before_auction_end_all_register_bidders_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_2_hours_before_auction_end_all_register_bidders_content]" id = "email_user_2_hours_before_auction_end_all_register_bidders_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_2_hours_before_auction_end_all_register_bidders_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_2_hours_before_auction_end_all_register_bidders_sms_content]" id = "email_user_2_hours_before_auction_end_all_register_bidders_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_2_hours_before_auction_end_all_register_bidders_sms_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: all bidders
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_2_hours_before_auction_end_all_has_bidders_subject" value="{$form_data.email_user_2_hours_before_auction_end_all_has_bidders_subject}" name="fields[email_user_2_hours_before_auction_end_all_has_bidders_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_2_hours_before_auction_end_all_has_bidders_content]" id = "email_user_2_hours_before_auction_end_all_has_bidders_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_2_hours_before_auction_end_all_has_bidders_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_2_hours_before_auction_end_all_has_bidders_sms_content]" id = "email_user_2_hours_before_auction_end_all_has_bidders_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_2_hours_before_auction_end_all_has_bidders_sms_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: users with property in watch list
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_2_hours_before_auction_end_user_in_watchlist_subject" value="{$form_data.email_user_2_hours_before_auction_end_user_in_watchlist_subject}" name="fields[email_user_2_hours_before_auction_end_user_in_watchlist_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_2_hours_before_auction_end_user_in_watchlist_content]" id = "email_user_2_hours_before_auction_end_user_in_watchlist_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_2_hours_before_auction_end_user_in_watchlist_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_2_hours_before_auction_end_user_in_watchlist_sms_content]" id = "email_user_2_hours_before_auction_end_user_in_watchlist_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_2_hours_before_auction_end_user_in_watchlist_sms_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: user_extended_due_to_bid_in_final_5_minutes------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>When an auction is extended due to bid in final 5 minutes</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: Vendor, Landlord, Agent
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_extended_due_to_bid_in_final_5_minutes_subject" value="{$form_data.email_user_extended_due_to_bid_in_final_5_minutes_subject}" name="fields[email_user_extended_due_to_bid_in_final_5_minutes_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_extended_due_to_bid_in_final_5_minutes_content]" id = "email_user_extended_due_to_bid_in_final_5_minutes_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_extended_due_to_bid_in_final_5_minutes_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_extended_due_to_bid_in_final_5_minutes_sms_content]" id = "email_user_extended_due_to_bid_in_final_5_minutes_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_extended_due_to_bid_in_final_5_minutes_sms_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: all registered bidders
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_extended_due_to_bid_in_final_5_minutes_all_registered_bidders_subject" value="{$form_data.email_user_extended_due_to_bid_in_final_5_minutes_all_registered_bidders_subject}" name="fields[email_user_extended_due_to_bid_in_final_5_minutes_all_registered_bidders_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_extended_due_to_bid_in_final_5_minutes_all_registered_bidders_content]" id = "email_user_extended_due_to_bid_in_final_5_minutes_all_registered_bidders_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_extended_due_to_bid_in_final_5_minutes_all_registered_bidders_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_extended_due_to_bid_in_final_5_minutes_all_registered_bidders_sms_content]" id = "email_user_extended_due_to_bid_in_final_5_minutes_all_registered_bidders_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_extended_due_to_bid_in_final_5_minutes_all_registered_bidders_sms_content}</textarea>
                        </td>
                    </tr>

                    {*------------------------------------BEGIN NEW EMAIL: user_accept_offer------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>Message was send when Accepting offer for a Property</legend>
                            </fieldset>
                        </td>
                    </tr>

                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To Agent</strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_accept_offer_subject" value="{$form_data.email_user_accept_offer_subject}" name="fields[email_user_accept_offer_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                        </td>
                        <td>
                            <textarea name = "fields[email_user_accept_offer_content]" id = "email_offer_vendor" class="input-text editor" style="width:100%;height:100px">{$form_data.email_user_accept_offer_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_accept_offer_sms_content]" id = "email_user_accept_offer_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_accept_offer_sms_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To Buyer</strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_accept_offer_buyer_subject" value="{$form_data.email_user_accept_offer_buyer_subject}" name="fields[email_user_accept_offer_buyer_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_accept_offer_buyer_content]" id = "email_user_accept_offer_buyer_content" class="input-text editor" style="width:100%;height:100px">{$form_data.email_user_accept_offer_buyer_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_accept_offer_buyer_sms_content]" id = "email_user_accept_offer_buyer_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_accept_offer_buyer_sms_content}</textarea>
                        </td>
                    </tr>
                    {*<tr>
                        <td width = "19%" valign="top">
                            <strong>To Bidder and Watcher</strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_offer_bidder_watcher_subject" value="{$form_data.email_offer_bidder_watcher_subject}" name="fields[email_offer_bidder_watcher_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                        </td>
                        <td>
                            <textarea name = "fields[email_user_accept_offer_content]" id = "email_offer_bidder_watcher" class="input-text editor" style="width:100%;height:100px">{$form_data.email_offer_bidder_watcher}</textarea>
                        </td>
                    </tr>*}
                    {*------------------------------------BEGIN NEW EMAIL: user_refused_offer_buyer------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>Message was send when Refused offer for a Property</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To Buyer</strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_refused_offer_buyer_subject" value="{$form_data.email_user_refused_offer_buyer_subject}" name="fields[email_user_refused_offer_buyer_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_refused_offer_buyer_content]" id = "email_user_refused_offer_buyer_content" class="input-text" style="width:100%;height:100px">{$form_data.email_user_refused_offer_buyer_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_refused_offer_buyer_sms_content]" id = "email_user_refused_offer_buyer_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_refused_offer_buyer_sms_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To Agent</strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_refused_offer_vendor_subject" value="{$form_data.email_user_refused_offer_vendor_subject}" name="fields[email_user_refused_offer_vendor_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_refused_offer_vendor_content]" id = "email_user_refused_offer_vendor_content" class="input-text" style="width:100%;height:100px">{$form_data.email_user_refused_offer_vendor_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_refused_offer_vendor_sms_content]" id = "email_user_refused_offer_vendor_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_refused_offer_vendor_sms_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: user_sold_or_leased------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>When a property is Sold/Leased</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: Vendor, Landlord, Agent, Lawyer
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_sold_or_leased_subject" value="{$form_data.email_user_sold_or_leased_subject}" name="fields[email_user_sold_or_leased_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_sold_or_leased_content]" id = "email_user_sold_or_leased_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_sold_or_leased_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_sold_or_leased_sms_content]" id = "email_user_sold_or_leased_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_sold_or_leased_sms_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: buyer (successful bidder)
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_sold_or_leased_buyer_subject" value="{$form_data.email_user_sold_or_leased_buyer_subject}" name="fields[email_user_sold_or_leased_buyer_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_sold_or_leased_buyer_content]" id = "email_user_sold_or_leased_buyer_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_sold_or_leased_buyer_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_sold_or_leased_buyer_sms_content]" id = "email_user_sold_or_leased_buyer_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_sold_or_leased_buyer_sms_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: all registered bidders
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_sold_or_leased_buyer_all_registered_bidders_subject" value="{$form_data.email_user_sold_or_leased_buyer_all_registered_bidders_subject}" name="fields[email_user_sold_or_leased_buyer_all_registered_bidders_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_sold_or_leased_buyer_all_registered_bidders_content]" id = "email_user_sold_or_leased_buyer_all_registered_bidders_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_sold_or_leased_buyer_all_registered_bidders_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_sold_or_leased_buyer_all_registered_bidders_sms_content]" id = "email_user_sold_or_leased_buyer_all_registered_bidders_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_sold_or_leased_buyer_all_registered_bidders_sms_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: users with property in watch list
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_sold_or_leased_buyer_user_in_watchlist_subject" value="{$form_data.email_user_sold_or_leased_buyer_user_in_watchlist_subject}" name="fields[email_user_sold_or_leased_buyer_user_in_watchlist_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_sold_or_leased_buyer_user_in_watchlist_content]" id = "email_user_sold_or_leased_buyer_user_in_watchlist_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_sold_or_leased_buyer_user_in_watchlist_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_sold_or_leased_buyer_user_in_watchlist_sms_content]" id = "email_user_sold_or_leased_buyer_user_in_watchlist_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_sold_or_leased_buyer_user_in_watchlist_sms_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: user_passed_in------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>When a property is passed in</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: Vendor, Landlord, Agent, Lawye
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_passed_in_subject" value="{$form_data.email_user_passed_in_subject}" name="fields[email_user_passed_in_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_passed_in_content]" id = "email_user_passed_in_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_passed_in_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_passed_in_sms_content]" id = "email_user_passed_in_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_passed_in_sms_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: all registered bidders
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_passed_in_all_registered_bidders_subject" value="{$form_data.email_user_passed_in_all_registered_bidders_subject}" name="fields[email_user_passed_in_all_registered_bidders_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_passed_in_all_registered_bidders_content]" id = "email_user_passed_in_all_registered_bidders_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_passed_in_all_registered_bidders_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_passed_in_all_registered_bidders_sms_content]" id = "email_user_passed_in_all_registered_bidders_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_passed_in_all_registered_bidders_sms_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: users with property in watch list
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_user_passed_in_user_watchlist_subject" value="{$form_data.email_user_passed_in_user_watchlist_subject}" name="fields[email_user_passed_in_user_watchlist_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_passed_in_user_watchlist_content]" id = "email_user_passed_in_user_watchlist_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_passed_in_user_watchlist_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_user_passed_in_user_watchlist_sms_content]" id = "email_user_passed_in_user_watchlist_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_user_passed_in_user_watchlist_sms_content}</textarea>
                        </td>
                    </tr>
                    {*------------------------------------BEGIN NEW EMAIL: xxx------------------------------------*}
                    {*<tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend></legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To: concierge@bidrhino.com
                            </strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_xxx_subject" value="{$form_data.email_xxx_subject}" name="fields[email_xxx_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            Email Content
                        </td>
                        <td>
                            <textarea name = "fields[email_xxx_content]" id = "email_xxx_content" class="input-text" style="width:100%;height:50px">{$form_data.email_xxx_content}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            SMS Content
                        </td>
                        <td>
                            <textarea name = "fields[email_xxx_sms_content]" id = "email_xxx_sms_content" class="input-text" style="width:100%;height:50px">{$form_data.email_xxx_sms_content}</textarea>
                        </td>
                    </tr>*}
                    {*------------------------------------BUTTON------------------------------------*}
                    <tr>
                        <td colspan="2" align="right">
                            <hr/>
                            <input type="submit" class="button" value="Save"/>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="tab-reg-content tabs-content" id="tab-reg-content">
                <table width="100%" cellspacing="10" class="edit-table">
                    {*------------------------------------subject------------------------------------*}
                        <tr>
                            <td colspan="2" align="center">
                                <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                    <legend>Email Account</legend>
                                </fieldset>
                            </td>
                        </tr>

                        <tr>
                            <td width = "19%" valign="top">
                                <strong>To finished account</strong>
                            </td>
                            <td>
                                <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                                <input type="text" id="email_finished_account_subject" value="{$form_data.email_finished_account_subject}" name="fields[email_finished_account_subject]" style="width: 100%">
                            </td>
                        </tr>
                        <tr>
                            <td width = "19%" valign="top">
                            </td>
                            <td>
                                <textarea name = "fields[email_finished_account_msg]" id = "email_finished_account_msg" class="input-text editor" style="width:100%;height:100px">{$form_data.email_finished_account_msg}</textarea>
                            </td>
                        </tr>

                    {*------------------------------------subject------------------------------------*}

                        <tr>
                            <td width = "19%" valign="top">
                                <strong>Forgot Password</strong>
                            </td>
                            <td>
                                <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                                <input type="text" id="email_forgot_password_subject" value="{$form_data.email_forgot_password_subject}" name="fields[email_forgot_password_subject]" style="width: 100%">
                            </td>
                        </tr>
                        <tr>
                            <td width = "19%" valign="top">
                            </td>
                            <td>
                                <textarea name = "fields[email_forgot_password_msg]" id = "email_forgot_password_msg" class="input-text editor" style="width:100%;height:100px">{$form_data.email_forgot_password_msg}</textarea>
                            </td>
                        </tr>


                    {*------------------------------------subject------------------------------------*}

                        <tr>
                            <td width = "19%" valign="top">
                                <strong>Change a New Password</strong>
                            </td>
                            <td>
                                <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                                <input type="text" id="email_new_password_subject" value="{$form_data.email_new_password_subject}" name="fields[email_new_password_subject]" style="width: 100%">
                            </td>
                        </tr>
                        <tr>
                            <td width = "19%" valign="top">
                            </td>
                            <td>
                                <textarea name = "fields[email_new_password_msg]" id = "email_new_password_msg" class="input-text editor" style="width:100%;height:100px">{$form_data.email_new_password_msg}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="right">
                                <hr/>
                                <input type="submit" class="button" value="Save"/>
                            </td>
                        </tr>
                </table>
            </div>

            <div id="tab-notify-content" class="tabs-content">
                <table width="100%" cellspacing="10" class="edit-table">
                {*------------------------------------subject------------------------------------*}

                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>Message prompt to bidder when property will be end</legend>
                            </fieldset>
                        </td>
                    </tr>

                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To Bidder</strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_bidder_prompt_msg_subject" value="{$form_data.email_bidder_prompt_msg_subject}" name="fields[email_bidder_prompt_msg_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                        </td>
                        <td>
                            <textarea name = "fields[email_bidder_prompt_msg]" id = "email_bidder_prompt_msg" class="input-text editor" style="width:100%;height:100px">{$form_data.email_bidder_prompt_msg}</textarea>
                        </td>
                    </tr>

                {*------------------------------------subject------------------------------------*}

                <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>Message prompt to bidder when property is sold</legend>
                            </fieldset>
                        </td>
                    </tr>

                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To Admin</strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_admin_sold_msg_subject" value="{$form_data.email_admin_sold_msg_subject}" name="fields[email_admin_sold_msg_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                        </td>
                        <td>
                            <textarea name = "fields[email_admin_sold_msg]" id = "email_admin_sold_msg" class="input-text editor" style="width:100%;height:100px">{$form_data.email_admin_sold_msg}</textarea>
                        </td>
                    </tr>

                {*------------------------------------subject------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>Message prompt to agent the the Inspect end time will be end</legend>
                            </fieldset>
                        </td>
                    </tr>

                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To Agent</strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_inspecttime_prompt_msg_subject" value="{$form_data.email_inspecttime_prompt_msg_subject}" name="fields[email_inspecttime_prompt_msg_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                        </td>
                        <td>
                            <textarea name = "fields[email_inspecttime_prompt_msg]" id = "email_inspecttime_prompt_msg" class="input-text editor" style="width:100%;height:100px">{$form_data.email_inspecttime_prompt_msg}</textarea>
                        </td>
                    </tr>

                {*------------------------------------subject------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>Message was sent when stop bid on one property.</legend>
                            </fieldset>
                        </td>
                    </tr>

                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To Agent</strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_vendor_stop_bid_msg_subject" value="{$form_data.email_vendor_stop_bid_msg_subject}" name="fields[email_vendor_stop_bid_msg_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                        </td>
                        <td>
                            <textarea name = "fields[email_vendor_stop_bid_msg]" id = "email_vendor_stop_bid_msg" class="input-text editor" style="width:100%;height:100px">{$form_data.email_vendor_stop_bid_msg}</textarea>
                        </td>
                    </tr>

                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To Lawyer</strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_lawyer_stop_bid_msg_subject" value="{$form_data.email_lawyer_stop_bid_msg_subject}" name="fields[email_lawyer_stop_bid_msg_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                        </td>
                        <td>
                            <textarea name = "fields[email_lawyer_stop_bid_msg]" id = "email_lawyer_stop_bid_msg" class="input-text editor" style="width:100%;height:100px">{$form_data.email_lawyer_stop_bid_msg}</textarea>
                        </td>
                    </tr>

                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To Winner</strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_winner_stop_bid_msg_subject" value="{$form_data.email_winner_stop_bid_msg_subject}" name="fields[email_winner_stop_bid_msg_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                        </td>
                        <td>
                            <textarea name = "fields[email_winner_stop_bid_msg]" id = "email_winner_stop_bid_msg" class="input-text editor" style="width:100%;height:100px">{$form_data.email_winner_stop_bid_msg}</textarea>
                        </td>
                    </tr>

                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To People who bidded or in watchlist</strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_agent_stop_bid_msg_subject" value="{$form_data.email_agent_stop_bid_msg_subject}" name="fields[email_agent_stop_bid_msg_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                        </td>
                        <td>
                            <textarea name = "fields[email_agent_stop_bid_msg]" id = "email_agent_stop_bid_msg" class="input-text editor" style="width:100%;height:100px">{$form_data.email_agent_stop_bid_msg}</textarea>
                        </td>
                    </tr>

                    {* Message prompt to admin when users register to bid on a property *}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>Message prompt to admin when users register to bid on a property</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To Admin when users register to bid on a property</strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0; margin-bottom: 0;">Subject : </label>
                            <input type="text" id="email_agent_register_bid" value="{$form_data.email_admin_register_bid_subject}" name="fields[email_admin_register_bid_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                        </td>
                        <td>
                            <textarea name = "fields[email_admin_register_bid_msg]" id = "email_admin_register_bid_msg" class="input-text editor" style="width:100%;height:100px">{$form_data.email_admin_register_bid_msg}</textarea>
                        </td>
                    </tr>
                    {* End Message prompt to admin when users register to bid on a property *}

                    {* Message prompt to Vendor when users register to bid on their property *}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>Message prompt to Vendor when users register to bid on their property</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To Vendor when users register to bid on their property</strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0; margin-bottom: 0;">Subject : </label>
                            <input type="text" id="email_vendor_register_bid" value="{$form_data.email_vendor_register_bid_subject}" name="fields[email_vendor_register_bid_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                        </td>
                        <td>
                            <textarea name = "fields[email_vendor_register_bid_msg]" id = "email_vendor_register_bid_msg" class="input-text editor" style="width:100%;height:100px">{$form_data.email_vendor_register_bid_msg}</textarea>
                        </td>
                    </tr>
                    {* End Message prompt to admin when users register to bid on a property *}

                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>Message prompt to agent when users register to bid on their property</legend>
                            </fieldset>
                        </td>
                    </tr>

                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To Agent when users register to bid on their property</strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0; margin-bottom: 0;">Subject : </label>
                            <input type="text" id="email_agent_register_bid" value="{$form_data.email_agent_register_bid_subject}" name="fields[email_agent_register_bid_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                        </td>
                        <td>
                            <textarea name="fields[email_agent_register_bid_msg]" id = "email_agent_register_bid_msg" class="input-text editor" style="width:100%;height:100px">{$form_data.email_agent_register_bid_msg}</textarea>
                        </td>
                    </tr>

                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To Agent when users register to bid on their property (with authentication form)</strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0; margin-bottom: 0;">Subject : </label>
                            <input type="text" id="email_agent_register_bid_with_form" value="{$form_data.email_agent_register_bid_with_form_subject}" name="fields[email_agent_register_bid_with_form_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                        </td>
                        <td>
                            <textarea name = "fields[email_agent_register_bid_with_form_msg]" id = "email_agent_register_bid_with_form_msg" class="input-text editor" style="width:100%;height:100px">{$form_data.email_agent_register_bid_with_form_msg}</textarea>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>Message was send when bid on property</legend>
                            </fieldset>
                        </td>
                    </tr>

                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To Agent</strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0; margin-bottom: 0;">Subject : </label>
                            <input type="text" id="email_agent_bid_success" value="{$form_data.email_agent_bid_success_subject}" name="fields[email_agent_bid_success_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                        </td>
                        <td>
                            <textarea name = "fields[email_agent_bid_success_msg]" id = "email_agent_bid_success_msg" class="input-text editor" style="width:100%;height:100px">{$form_data.email_agent_bid_success_msg}</textarea>
                        </td>
                    </tr>

                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To Last Bidder</strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0; margin-bottom: 0;">Subject : </label>
                            <input type="text" id="email_bid_confirm_subject" value="{$form_data.email_bid_confirm_subject}" name="fields[email_bid_confirm_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                        </td>
                        <td>
                            <textarea name = "fields[email_bid_confirm_msg]" id = "email_bid_confirm_msg" class="input-text editor" style="width:100%;height:100px">{$form_data.email_bid_confirm_msg}</textarea>
                        </td>
                    </tr>

                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To All Bidder</strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0; margin-bottom: 0;">Subject : </label>
                            <input type="text" id="email_bidder_subject" value="{$form_data.email_bid_confirm_subject}" name="fields[email_bidder_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                        </td>
                        <td>
                            <textarea name = "fields[email_bidder_msg]" id="email_bidder_msg" class="input-text editor" style="width:100%;height:100px">{$form_data.email_bidder_msg}</textarea>
                        </td>
                    </tr>
                {*------------------------------------subject------------------------------------*}
                {*
                <tr>
                    <td colspan="2" align="center">
                        <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                            <legend>Email alert</legend>
                        </fieldset>
                    </td>
                </tr>

                <tr>
                    <td width = "19%" valign="top">
                        <strong>To Member</strong>
                    </td>
                    <td>
                        <input type="text" id="email_member_alert_msg_subject" value="{$form_data.email_member_alert_msg_subject}" name="fields[email_member_alert_msg_subject]" style="width: 100%">
                    </td>
                </tr>
                <tr>
                    <td width = "19%" valign="top">
                    </td>
                    <td>
                        <textarea name = "fields[email_member_alert_msg]" id = "email_member_alert_msg" class="input-text editor" style="width:100%;height:100px">{$form_data.email_member_alert_msg}</textarea>
                    </td>
                </tr>*}

                {*------------------------------------subject------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>Message prompt to bidder 1 day before a Forthcoming Auction becomes a Live Auction</legend>
                            </fieldset>
                        </td>
                    </tr>

                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To Bidder</strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_bidder_remind_msg_subject" value="{$form_data.email_bidder_remind_msg_subject}" name="fields[email_bidder_remind_msg_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                        </td>
                        <td>
                            <textarea name = "fields[email_bidder_remind_msg]" id = "email_bidder_remind_msg" class="input-text editor" style="width:100%;height:100px">{$form_data.email_bidder_remind_msg}</textarea>
                        </td>
                    </tr>
                    <!-- -->
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>Message prompt to Service Provider</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To Service Provider</strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_service_provider_msg_subject" value="{$form_data.email_service_provider_msg_subject}" name="fields[email_service_provider_msg_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                        </td>
                        <td>
                            <textarea name = "fields[email_service_provider_msg]" id = "email_service_provider_msg" class="input-text editor" style="width:100%;height:100px">{$form_data.email_service_provider_msg}</textarea>
                        </td>
                    </tr>
                    {*Property had been posted to live*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>Message prompt: Property had been posted to live</legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To Vendor</strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_vendor_property_posted_to_live_subject" value="{$form_data.email_vendor_property_posted_to_live_subject}" name="fields[email_vendor_property_posted_to_live_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                        </td>
                        <td>
                            <textarea name = "fields[email_vendor_property_posted_to_live_msg]" id = "email_vendor_property_posted_to_live_msg" class="input-text editor" style="width:100%;height:100px">{$form_data.email_vendor_property_posted_to_live_msg}</textarea>
                        </td>
                    </tr>
                    {**}
                    <tr>
                        <td colspan="2" align="right">
                            <hr/>
                            <input type="submit" class="button" value="Save"/>
                        </td>
                    </tr>
                </table>
            </div>

            <div id="tab-watchlist-offer-content" class="tabs-content">
                <table width="100%" cellspacing="10" class="edit-table">
                {*------------------------------------subject------------------------------------*}
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>Message was send when one people add a property to your watchlist</legend>
                            </fieldset>
                        </td>
                    </tr>

                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To Agent</strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_watchlist_vendor_subject" value="{$form_data.email_watchlist_vendor_subject}" name="fields[email_watchlist_vendor_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                        </td>
                        <td>
                            <textarea name = "fields[email_watchlist_vendor]" id = "email_watchlist_vendor" class="input-text editor" style="width:100%;height:100px">{$form_data.email_watchlist_vendor}</textarea>
                        </td>
                    </tr>

                    <tr>
                        <td width = "19%" valign="top">
                            <strong>To People who in watchlist</strong>
                        </td>
                        <td>
                            <label style="font-weight: bold; font-size: 13px; margin-right: 0px; margin-bottom: 0px;">Subject : </label>
                            <input type="text" id="email_watchlist_agent_subject" value="{$form_data.email_watchlist_agent_subject}" name="fields[email_watchlist_agent_subject]" style="width: 100%">
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                        </td>
                        <td>
                            <textarea name = "fields[email_watchlist_agent]" id = "email_watchlist_agent" class="input-text editor" style="width:100%;height:100px">{$form_data.email_watchlist_agent}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong> Variable</strong>
                        </td>
                        <td>
                            <div style="display: inline;">
                                <input type="button" id="buyer_name" value="Buyer Name" onclick="tinyMCE.execCommand('mceInsertContent',false,'[buyer_name]');return false;" >
                            </div>
                            <div style="display: inline;">
                                <input type="button" id="vendor_name" value="Agent Name" onclick="tinyMCE.execCommand('mceInsertContent',false,'[agent_name]');return false;" >
                            </div>
                            <div style="display: inline;">
                                <input type="button" id="buyer_email" value="Buyer Email" onclick="tinyMCE.execCommand('mceInsertContent',false,'[buyer_email]');return false;" >
                            </div>
                            <div style="display: inline;">
                                <input type="button" id="vendor_email" value="Agent Email" onclick="tinyMCE.execCommand('mceInsertContent',false,'[agent_email]');return false;" >
                            </div>
                            <div style="display: inline;">
                                <input type="button" id="pro_id" value="Property ID" onclick="tinyMCE.execCommand('mceInsertContent',false,'[ID]');return false;" >
                            </div>
                            <div style="display: inline;">
                                <input type="button" id="root_url" value="Root URL" onclick="tinyMCE.execCommand('mceInsertContent',false,'[rooturl]');return false;" >
                            </div>
                            <div style="display: inline;">
                                <input type="button" id="offer_price" value="Offer Price" onclick="tinyMCE.execCommand('mceInsertContent',false,'[offer_price]');return false;" >
                            </div>
                        </td>
                    </tr>
                {*END *}
                    <tr>
                        <td colspan="2" align="right">
                            <hr/>
                            <input type="submit" class="button" value="Save"/>
                        </td>
                    </tr>
                </table>

            </div>

            <div id="tab-other-content" class="tabs-content">
                <table width="100%" cellspacing="10" class="edit-table">
                    <tr>
                        <td colspan="2" align="center">
                            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                                <legend>Another configuration</small></legend>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%" valign="top">
                            <strong>Signature:</strong>
                            <br>
                            <small>(appended at the end of all outgoing messages)</small>
                        </td>
                        <td>
                            <textarea class="editor" name=fields[email_sign] id ="email_sign" style="width:100%">{$form_data.email_sign}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right">
                            <hr/>
                            <input type="submit" class="button" value="Save"/>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

{literal}
 <script type="text/javascript">
     $('.email-tabs-child-ul li').click(function(){
         switch_tabs($(this));
     });

     switch_tabs($('.email-tabs-child-ul li.active'));

     function switch_tabs(obj) {
         var id = obj.attr("id");
         $('.tabs-content').hide();
         $('.email-tabs-child-ul li').removeClass("active");
         jQuery('#'+ id + '-content').show();
         obj.addClass("active");
     }

     function func2(id){
         insertAtText(id,'[username]');
     }
     function changeid(id) {
         //alert(id);
         // var fun = "insertAtText('"+ id + "','[username]')";
         //jQuery('#username').attr('onclick',fun);
         jQuery('#buyer_name').unbind("click");
         jQuery('#buyer_name').click(function () {
             insertAtText(id, '[buyer_name]');
         });
         jQuery('#vendor_name').unbind("click");
         jQuery('#vendor_name').click(function () {
             insertAtText(id, '[agent_name]');
         });
         jQuery('#buyer_email').unbind("click");
         jQuery('#buyer_email').click(function () {
             insertAtText(id, '[buyer_email]');
         });
         jQuery('#vendor_email').unbind("click");
         jQuery('#vendor_email').click(function () {
             insertAtText(id, '[agent_email]');
         });
         jQuery('#pro_id').unbind("click");
         jQuery('#pro_id').click(function () {
             insertAtText(id, '[ID]');
         });
         jQuery('#root_url').unbind("click");
         jQuery('#root_url').click(function () {
             insertAtText(id, '[ROOTURL]');
         });

         jQuery('#offer_price').unbind("click");
         jQuery('#offer_price').click(function () {
             insertAtText(id, '[offer_price]');
         });
         //jQuery('#username').onclick = insertAtText(id,'[username]');

         /*jQuery('#username').onclick = function(){
             insertAtText(id,'[username]');
         };*/
         /*var user = jQuery('#username');
          if (window.addEventListener) { 	// Mozilla, Netscape, Firefox
            user.addEventListener('click', func2(id), true);
         }
         else {	// IE
            user.attachEvent('onClick', func2(id));
         }*/
     }
 </script>
 {/literal}