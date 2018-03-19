<div id=admin_property_provideremail>
<table width="100%" cellspacing="10">
	<tr>
    	<td width="19%">
        	<strong id="notify_agent_id"> Email <span class="require"></span></strong>
        </td>
        <td width="30%">
            <input type="text" name="fields[provider_email]" id="provider_email" value="{$form_data.provider_email}" class="input-text validate-email disable-auto-complete" style="width:98%"/>
            
        </td>
        <td width="19%"></td>
        <td width="30%"></td>
    </tr>
	<tr>
    	<td colspan="4" align="right">
        	<hr/>
            <input type="hidden" name="next" id="next" value="0"/>
            {*<input type="hidden" name="_package" value="{$form_data.package_id}"/>*}
			<input type="button" class="button" value="Save" onclick="pro.submit()"/>
            <input type="button" class="button" value="Save & Next" onclick="pro.submit(true)"/>
        </td>
    </tr>
    
</table>
</div>
<div id="error" style="display:none">{$error}</div>
