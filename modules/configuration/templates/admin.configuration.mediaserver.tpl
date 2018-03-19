<table width="100%" cellspacing="10" class="edit-table">
	<tr>
    	<td width = "19%">
        	<strong>Host</strong>
        </td>
        <td>
			<input type="text" name = "fields[mediaserver_host]" id = "mediaserver_host" value="{$form_data.mediaserver_host}" class="input-text validate-require disable-auto-complete" style="width:50%"/>
        </td>
    </tr>

	<tr>
    	<td width = "19%">
        	<strong>User</strong>
        </td>
        <td>
			<input type="text" name = "fields[mediaserver_user]" id = "mediaserver_user" value="{$form_data.mediaserver_user}" class="input-text validate-require disable-auto-complete" style="width:50%"/>
        </td>
    </tr>

	<tr>
    	<td width = "19%" valign="top">
        	<strong>Pass</strong>
        </td>
        <td>
			<input type="password" name = "fields[mediaserver_pass]" id = "mediaserver_pass" value="{$form_data.mediaserver_pass}" class="input-text validate-require" style="width:50%"/>
        </td>
    </tr>
    
	<tr>
    	<td width = "19%" valign="top">
        	<strong>Port</strong>
        </td>
        <td>
			<input type="text" name = "fields[mediaserver_port]" id = "mediaserver_port" value="{$form_data.mediaserver_port}" class="input-text validate-require" style="width:50%"/>
        </td>
    </tr>

    <tr>
    	<td width = "19%" valign="top">
        	<strong>Path</strong>
        </td>
        <td>
			<input type="text" name = "fields[mediaserver_path]" id = "mediaserver_path" value="{$form_data.mediaserver_path}" class="input-text validate-require" style="width:50%"/>
        </td>
    </tr>

	<tr>
    	<td colspan="2" align="right">
        	<hr/>
			<input type="submit" class="button" value="Save"/>
        </td>
    </tr>
</table>
