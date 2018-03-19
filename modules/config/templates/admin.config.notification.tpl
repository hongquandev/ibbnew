<table width="100%" cellspacing="10" class="edit-table">
	<tr>
    	<td width = "19%">
        	<strong>Schedule</strong>
        </td>
        <td>
             <select name="fields[notification_schedule]" id="notification_schedule" class="input-select">
                {html_options options=$options_notification_schedule selected =$form_data.notification_schedule}
            </select>
        </td>
    </tr>
	<tr>
    	<td colspan="2" align="right">
        	<hr/>
			<input type="submit" class="button" value="Save"/>
        </td>
    </tr>
    
</table>
