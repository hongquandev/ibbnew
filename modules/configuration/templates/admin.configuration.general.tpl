<table width="100%" cellspacing="10" class="edit-table">
	<tr>
    	<td width = "19%">
        	<strong>Contact name</strong>
        </td>
        <td>
			<input type="text" name = "fields[general_contact_name]" id = "general_contact_name" value="{$form_data.general_contact_name}" class="input-text validate-require disable-auto-complete" style="width:50%"/>
        </td>
    </tr>

	<tr>
    	<td width = "19%">
        	<strong>Contact Email</strong>
        </td>
        <td>
			<input type="text" name = "fields[general_contact_email]" id = "general_contact_email" value="{$form_data.general_contact_email}" class="input-text validate-require disable-auto-complete" style="width:50%"/>
        </td>
    </tr>

    <tr>
    	<td width = "19%" valign="top">
        	<strong>System Email Additional 1</strong>
        </td>
        <td>
			<input type="text" name = "fields[general_contact1_name]" id = "general_contact1_name" value="{$form_data.general_contact1_name}" class="input-text validate-require disable-auto-complete" style="width:50%"/>
            <br/>
        </td>
    </tr>

    <tr>
        <td width = "19%" valign="top">
            <strong>System Email Additional 2</strong>
        </td>
        <td>
            <input type="text" name = "fields[general_contact2_name]" id = "general_contact2_name" value="{$form_data.general_alert_post_email}" class="input-text validate-require disable-auto-complete" style="width:50%"/>
            <br/>
        </td>
    </tr>

    <tr>
        <td width = "19%" valign="top">
            <strong>Alert post email</strong>
        </td>
        <td>
            <input type="text" name = "fields[general_alert_post_email]" id = "general_alert_post_email" value="{$form_data.general_alert_post_email}" class="input-text validate-require disable-auto-complete" style="width:50%"/>
            <br/>
            <i>it will be used when agent pay successful (on their post ).</i>
        </td>
    </tr>
    
    <tr>
        <td width = "19%" valign="top">
            <strong>Printer email address</strong>
        </td>
        <td>
            <input type="text" name = "fields[general_printer_email]" id = "general_printer_email" value="{$form_data.general_printer_email}" class="input-text validate-require disable-auto-complete" style="width:50%"/>
            <br/>
            <i>it will be used after the property is approved to be listed on the site.</i>
        </td>
    </tr>
    
    <tr>
        <td width = "19%" valign="top">
            <strong>Service Provider email</strong>
        </td>
        <td>
            <input type="text" name = "fields[general_service_provider_email]" id = "general_service_provider_email" value="{$form_data.general_service_provider_email}" class="input-text validate-require disable-auto-complete" style="width:50%"/>
            <br/>
            <i></i>
        </td>
    </tr>

    <tr>
        <td width = "19%" valign="top">
            <strong>Enquiry Email</strong>
        </td>
        <td>
            <input type="text" name = "fields[general_enquiry_email]" id = "general_enquiry_email" value="{$form_data.general_enquiry_email}" class="input-text validate-require disable-auto-complete" style="width:50%"/>
            <br/>
            <i></i>
        </td>
    </tr>

    <tr>
    	<td colspan="2" align="center">
        	<div style="border-top:1px solid #D1D1D1"></div>
        </td>
    </tr>
    <tr>
    	<td width = "19%">
        	<strong> SMTP Mail Enable </strong>
        </td>
        <td>
             <select name="fields[general_smtp_enable]" id="general_smtp_enable" class="input-select" style="width:50%" onchange="onChange_Smtp('#general_smtp_enable','#smtp_settings')">
                    {html_options options=$options_yes_no selected = $form_data.general_smtp_enable}
             </select>
        </td>
    </tr>

    
        <tr>
            <td>
                <table id= "smtp_settings" cellspacing="10" class="edit-table" style="display: {if $form_data.general_smtp_enable == 1}block{else}none{/if};width: 515%;text-align: left;" >

                    <tr>
                        <td width = "19%">
                            <strong>Host SMTP Server Mail</strong>
                        </td>
                        <td>
                            <input type="text" name = "fields[general_mail_host_smtp]" id = "general_mail_host_smtp" value="{$form_data.general_mail_host_smtp}" class="input-text validate-require disable-auto-complete" style="width:53%"/>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%">
                            <strong>Username SMTP Server Mail</strong>
                        </td>
                        <td>
                            <input type="text" name = "fields[general_mail_username_smtp]" id = "general_mail_username_smtp" value="{$form_data.general_mail_username_smtp}" class="input-text validate-require disable-auto-complete" style="width:53%"/>
                        </td>
                    </tr>
                    <tr>
                        <td width = "19%">
                            <strong>Password SMTP Server Mail</strong>
                        </td>
                        <td>
                            <input type="text" name = "fields[general_mail_password_smtp]" id = "general_mail_password_smtp" value="{$form_data.general_mail_password_smtp}" class="input-text validate-require disable-auto-complete" style="width:53%"/>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    <tr>
    	<td colspan="2" align="center">
        	<div style="border-top:1px solid #D1D1D1"></div>
        </td>
    </tr>
    

	<tr>
    	<td width = "19%" valign="top">
        	<strong>Site off</strong>
        </td>
        <td>
             <select name="fields[general_site_off]" id="general_site_off" class="input-select" style="width:50%">
                {html_options options=$options_yes_no selected =$form_data.general_site_off}
            </select>
        </td>
    </tr>
 
 	<tr>
    	<td width = "19%" valign="top">
        	<strong>Offline Message</strong>
        </td>
        <td>
            <textarea name = "fields[general_site_off_msg]" id = "general_site_off_msg" class="input-text" style="width:50%;height:100px">{$form_data.general_site_off_msg}</textarea>     
        </td>
    </tr>
    
	<tr>
    	<td width = "19%" valign="top">
        	<strong>Use Secure URLs</strong>
        </td>
        <td>
             <select name="fields[general_secure_url_enable]" id="general_secure_url_enable" class="input-select" style="width:50%">
                {html_options options=$options_yes_no selected =$form_data.general_secure_url_enable}
            </select>
        </td>
    </tr>
    
	<tr>
    	<td width = "19%" valign="top">
        	<strong>URL will be scanned for Secure</strong>
        </td>
        <td>
            <textarea name = "fields[general_secure_url_scanned]" id = "general_secure_url_scanned" class="input-text" style="width:50%;height:100px">{$form_data.general_secure_url_scanned}</textarea>     
        </td>
    </tr>

	<tr>
    	<td width = "19%" valign="top">
        	<strong>Enable <b>www</b> on url</strong>
        </td>
        <td>
             <select name="fields[general_www_url_enable]" id="general_www_url_enable" class="input-select" style="width:50%">
                {html_options options=$options_yes_no selected =$form_data.general_www_url_enable}
            </select>
        </td>
    </tr>


    <tr>
    	<td colspan="2" align="center">
        	<div style="border-top:1px solid #D1D1D1"></div>
        </td>
    </tr>

	<tr>
    	<td width = "19%" valign="top">
        	<strong>Date format</strong>
        </td>
        <td>
             <select name="fields[general_date_format]" id="general_date_format" class="input-select" style="width:50%">
                {html_options options=$options_date_format selected =$form_data.general_date_format}
            </select>
        </td>
    </tr>
    
	<tr>
    	<td width = "19%" valign="top">
        	<strong>Items per page</strong>
        </td>
        <td>
			<input type="text" name = "fields[general_item_per_page]" id = "general_item_per_page" value="{$form_data.general_item_per_page}" class="input-text validate-require disable-auto-complete" style="width:50%"/>
            <i>Seperate by comma</i>       
        </td>
    </tr>
    
    <tr>
    	<td colspan="2" align="center">
        	<div style="border-top:1px solid #D1D1D1"></div>
        </td>
    </tr>

 	<tr>
    	<td width = "19%" valign="top">
        	<strong>Meta Key</strong>
        </td>
        <td>
            <textarea name = "fields[general_meta_key]" id = "general_meta_key" class="input-text" style="width:50%;height:100px">{$form_data.general_meta_key}</textarea>     
        </td>
    </tr>


 	<tr>
    	<td width = "19%" valign="top">
        	<strong>Meta Description</strong>
        </td>
        <td>
            <textarea name = "fields[general_meta_description]" id = "general_meta_description" class="input-text" style="width:50%;height:100px">{$form_data.general_meta_description}</textarea>     
        </td>
    </tr>


    <tr>
    	<td colspan="2" align="center">
        	<div style="border-top:1px solid #D1D1D1"></div>
        </td>
    </tr>

	<tr>
    	<td width = "19%" valign="top">
        	<strong>Customer password's length</strong>
        </td>
        <td>
			<input type="text" name = "fields[general_customer_password_length]" id = "general_customer_password_length" value="{$form_data.general_customer_password_length}" class="input-text validate-require disable-auto-complete" style="width:50%"/>
        </td>
    </tr>

	<tr>
    	<td width = "19%" valign="top">
        	<strong>Ban from Country</strong>
        </td>
        <td>
            <select name="fields[general_ban_from_country][]" id="general_ban_from_country" class="input-select multiselect" style="width:50%;height:200px" multiple="multiple">
                {html_options options=$options_country selected =$form_data.general_ban_from_country}
            </select>
        </td>
    </tr>


 	<tr>
    	<td width = "19%" valign="top">
        	<strong>Ban ip</strong>
        </td>
        <td>
            <textarea name = "fields[general_ban_ip]" id = "general_ban_ip" class="input-text" style="width:50%;height:100px">{$form_data.general_ban_ip}</textarea> 
            <i>ip seperate by comma. Ex: 127.0.0.1, 10.0.0.1</i>    
        </td>
    </tr>

 	<tr>
    	<td width = "19%" valign="top">
        	<strong>Banned message</strong>
        </td>
        <td>
            <textarea name = "fields[general_ban_msg]" id = "general_ban_msg" class="input-text" style="width:50%;height:100px">{$form_data.general_ban_msg}</textarea> 
        </td>
    </tr>


 	<tr>
    	<td width = "19%" valign="top">
        	<strong><font style="color:#FF0000;font-weight:bold;font-size:20px">Allow ips access to admin</font></strong>
        </td>
        <td>
            <textarea name = "fields[general_allow_ip_admin]" id = "general_allow_ip_admin" class="input-text" style="width:50%;height:100px">{$form_data.general_allow_ip_admin}</textarea>     
            <i>ip seperate by comma. Ex: 127.0.0.1, 10.0.0.1</i>
        </td>
    </tr>

 	<tr>
    	<td width = "19%" valign="top">
        	<strong>Country default</strong>
        </td>
        <td>
            <select name="fields[general_country_default]" id="general_country_default" class="input-select" style="width:50%">
                {html_options options=$options_country selected =$form_data.general_country_default}
            </select>

			{*html_options name="fields[general_country_default]" options=$options_country selected=$form_data.general_country_default*}            
        </td>
    </tr>
    <tr>
    	<td colspan="2" align="center">
        	<div style="border-top:1px solid #D1D1D1"></div>
        </td>
    </tr>
	<!--
	<tr>
    	<td width = "19%" valign="top">
        	<strong>Auto bid time</strong>
        </td>
        <td>
			<input type="text" name = "fields[general_autobid_time]" id = "general_autobid_time" value="{$form_data.general_autobid_time}" class="input-text validate-require" style="width:50%"/>
            <i>Second(s)</i>       
        </td>
    </tr>
	-->
	{*<tr>
    	<td width = "19%" valign="top">
        	<strong>Active auto bid</strong>
        </td>
        <td>
			<input type="text" name = "fields[general_active_autobid_time]" id = "general_active_autobid_time" value="{$form_data.general_active_autobid_time}" class="input-text validate-require" style="width:50%"/>
            <i>Second(s)</i>
        </td>
    </tr>
	<tr>
    	<td width = "19%" valign="top">
        	<strong>Loop time</strong>
        </td>
        <td>
			<input type="text" name = "fields[general_loop_bid_time]" id = "general_loop_bid_time" value="{$form_data.general_loop_bid_time}" class="input-text validate-require" style="width:50%"/>
            <i>Second(s)</i>
        </td>
    </tr>*}
	{if $autobid}
	<tr>
    	<td width = "19%" valign="top">
        	<strong>Print auto bid</strong>
        </td>
        <td>
			<input type="text" name = "fields[general_print_autobid]" id = "general_print_autobid" value="{$form_data.general_print_autobid}" class="input-text validate-require" style="width:50%" autocomplete="off"/> 
                
        </td>
    </tr>
    
	<tr>
    	<td width = "19%" valign="top">
        	<strong>Break auto bid</strong>
        </td>
        <td>
			<input type="text" name = "fields[general_break_autobid]" id = "general_break_autobid" value="{$form_data.general_break_autobid}" class="input-text validate-require" style="width:50%" autocomplete="off"/> 
                
        </td>
    </tr>
	{/if}

    <tr>
    	<td colspan="2" align="center">
        	<div style="border-top:1px solid #D1D1D1"></div>
        </td>
    </tr>

    <tr>
    	<td width = "19%" valign="top">
        	<strong>Site Title</strong>
        </td>
        <td>
            <input type="text" name = "fields[site_title]" id="site_title" class="input-text" style="width:50%;" value="{$form_data.site_title}"/>
        </td>
    </tr>

 	<tr>
    	<td width = "19%" valign="top">
        	<strong>Base Url</strong>
        </td>
        <td>
            <input type="text" name = "fields[footer_base_url]" id = "footer_base_url" class="input-text" style="width:50%;" value="{$form_data.footer_base_url}"/>
        </td>
    </tr>


 	<tr>
    	<td width = "19%" valign="top">
        	<strong>Copyright</strong>
        </td>
        <td>
            <textarea name = "fields[footer_copyright]" id = "footer_copyright" class="input-text" style="width:50%;height:100px">{$form_data.footer_copyright}</textarea>
        </td>
    </tr>

    <tr>
    	<td width = "19%" valign="top">
        	<strong>Google Site Verification Key</strong>
        </td>
        <td>
            <input type="text" name = "fields[google_site_verification]" id="google_site_verification" class="input-text" style="width:50%;" value="{$form_data.google_site_verification}"/>
        </td>
    </tr>
    
	<tr>
    	<td colspan="2" align="right">
        	<hr/>
			<input type="submit" class="button" value="Save"/>
        </td>
    </tr>
    
</table>
{literal}
    <script type="text/javascript">
        function onChange_Smtp(id,id_){
             if(jQuery(id).val() == 1)
             {
                 jQuery(id_).show();
             }
             else
             {
                 jQuery(id_).hide();
             }
        }
    </script>
{/literal}