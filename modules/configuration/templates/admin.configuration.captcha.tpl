<table width="100%" cellspacing="10" class="edit-table">
	<tr>
    	<td width = "19%">
        	<strong>Enable</strong>
        </td>
        <td>
             <select name="fields[captcha_enable]" id="captcha_enable" class="input-select" style="width:50%">
                {html_options options=$options_yes_no selected =$form_data.captcha_enable}
            </select>
                   
        </td>
    </tr>

	<tr>
    	<td width = "19%" valign="top">
        	<strong>Public Key</strong>
        </td>
        <td>
			<input type="text" name = "fields[captcha_public_key]" id = "captcha_public_key" value="{$form_data.captcha_public_key}" class="input-text validate-require disable-auto-complete" style="width:100%"/>
            <i>Use this in the JavaScript code that is served to your users</i>       
        </td>
    </tr>

	<tr>
    	<td width = "19%" valign="top">
        	<strong>Private Key</strong>
        </td>
        <td>
			<input type="text" name = "fields[captcha_private_key]" id = "captcha_private_key" value="{$form_data.captcha_private_key}" class="input-text validate-require disable-auto-complete" style="width:100%"/>
            <i>Use this when communicating between your server and captcha server. Be sure to keep it a secret.</i>        
        </td>
    </tr>
    
    
	<tr>
    	<td colspan="2" align="right">
        	<hr/>
			<input type="submit" class="button" value="Save"/>
        </td>
    </tr>
    
</table>
