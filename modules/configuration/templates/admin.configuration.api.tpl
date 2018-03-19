<table width="100%" cellspacing="10" class="edit-table">
	<tr>
    	<td width = "19%">
        	<strong>Enable</strong>
        </td>
        <td>
            <select name="fields[api_enable]" id="api_enable" class="input-select" style="width:50%">
                {html_options options=$options_yes_no selected =$form_data.api_enable}
            </select>
        </td>
    </tr>
    
	<tr>
    	<td width = "19%">
        	<strong>Key</strong>
        </td>
        <td>
			<input type="text" name = "fields[api_key]" id = "api_key" value="{$form_data.api_key}" class="input-text validate-require" style="width:50%"/>
                   
        </td>
    </tr>
    

	<tr>
    	<td colspan="2" align="right">
        	<hr/>
			<input type="submit" class="button" value="Save"/>
        </td>
    </tr>
</table>