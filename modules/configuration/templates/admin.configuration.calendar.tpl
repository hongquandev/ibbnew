<table width="100%" cellspacing="10" class="edit-table">

	<tr>
    	<td width = "19%" valign="top">
        	<strong>Location</strong>
        </td>
        <td>
            <input type="text" name = "fields[calendar_location]" id = "calendar_location" class="input-text" style="width:100%;" value="{$form_data.calendar_location}">
        </td>
    </tr>
	
	<tr>
    	<td width = "19%" valign="top">
        	<strong>Summary</strong>
        </td>
        <td>
            <textarea name = "fields[calendar_summary]" id = "calendar_summary" class="input-text" style="width:100%;height:60px">{$form_data.calendar_summary}</textarea>     
        </td>
    </tr>

	<tr>
    	<td width = "19%" valign="top">
        	<strong>Description</strong>
        </td>
        <td>
            <textarea name = "fields[calendar_description]" id = "calendar_description" class="input-text" style="width:100%;height:100px">{$form_data.calendar_description}</textarea>     
        </td>
    </tr>
    
    
	<tr>
    	<td colspan="2" align="right">
        	<hr/>
			<input type="submit" class="button" value="Save"/>
        </td>
    </tr>
    
</table>
