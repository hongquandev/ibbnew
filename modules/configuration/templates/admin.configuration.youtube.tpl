<table width="100%" cellspacing="10" class="edit-table">
	<tr>
    	<td width = "19%">
        	<strong>Enable</strong>
        </td>
        <td>
             <select name="fields[youtube_enable]" id="youtube_enable" class="input-select" style="width:50%">
                {html_options options=$options_yes_no selected =$form_data.youtube_enable}
            </select>
        </td>
    </tr>

   	<tr>
    	<td width = "19%">
        	<strong>Email</strong>
        </td>
        <td>
			<input type="text" name = "fields[youtube_email]" id = "youtube_email" value="{$form_data.youtube_email}" class="input-text validate-require" style="width:100%" autocomplete="off"/>        
        </td>
    </tr>
    
   	<tr>
    	<td width = "19%">
        	<strong>Password</strong>
        </td>
        <td>
			<input type="password" name = "fields[youtube_password]" id = "youtube_password" value="{$form_data.youtube_password}" class="input-text validate-require" style="width:100%" autocomplete="off"/>        
        </td>
    </tr>

   	<tr>
    	<td width = "19%">
        	<strong>Application key</strong>
        </td>
        <td>
			<input type="text" name = "fields[youtube_application_key]" id = "youtube_application_key" value="{$form_data.youtube_application_key}" class="input-text validate-require" style="width:100%" autocomplete="off"/>        
        </td>
    </tr>
   
   	<tr>
    	<td width = "19%">
        	<strong>Application source</strong>
        </td>
        <td>
			<input type="text" name = "fields[youtube_application_source]" id = "youtube_application_source" value="{$form_data.youtube_application_source}" class="input-text validate-require" style="width:100%" autocomplete="off"/>        
        </td>
    </tr>
    
	<tr>
    	<td colspan="2" align="right">
        	<hr/>
			<input type="submit" class="button" value="Save"/>
        </td>
    </tr>
    
</table>