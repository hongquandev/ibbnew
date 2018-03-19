<table width="100%" cellspacing="10" class="edit-table">
	<tr>
    	<td width = "19%">
        	<strong>Google Analytics Enable</strong>
        </td>
        <td>
             <select name="fields[google_analytics_enable]" id="google_analytics_enable" class="input-select" style="width:50%">
                {html_options options = $options_yes_no selected = $form_data.google_analytics_enable}
            </select>
        </td>
    </tr>

   	<tr>
    	<td width = "19%" valign="top">
        	<strong>Google Analytics Api</strong>
            <small>for site</small>
        </td>
        <td>
        	<textarea name="fields[google_analytics_api_site]" id="google_analytics_api_bidRhino_com" style="height:200px" class="input-text">{$form_data.google_analytics_api_site}</textarea>
        </td>
    </tr>
    
	<tr>
    	<td colspan="2" align="right">
        	<hr/>
			<input type="submit" class="button" value="Save"/>
        </td>
    </tr>
    
</table>
