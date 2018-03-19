<table width="100%" cellspacing="10" class="edit-table">
	<tr>
    	<td width = "19%">
        	<strong>No.post per page</strong>
        </td>
        <td>
           <input type="text" name="fields[press_num_post]" id="press_num_post" value="{$form_data.press_num_post}" class="input-text validate-require disable-auto-complete" style="width:50%"/>
           <i>post(s)</i>
        </td>
    </tr>

   	<tr>
    	<td width = "19%" valign="top">
        	<strong>No.Recent posts</strong>
        </td>
        <td>
        	<input type="text" name="fields[press_num_recent]" id="press_num_recent" value="{$form_data.press_num_recent}" class="input-text validate-require disable-auto-complete" style="width:50%"/>
            <i>post(s)</i>
        </td>
    </tr>

	<tr>
    	<td colspan="2" align="right">
        	<hr/>
			<input type="submit" class="button" value="Save"/>
        </td>
    </tr>

</table>
