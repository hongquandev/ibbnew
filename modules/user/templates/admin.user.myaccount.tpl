<table width="100%" cellspacing="10" class="edit-table">

	<tr>
    	<td width = "22%">
        	<strong id="notify_firstname">First name <span class="require">*</span></strong>
        </td>
        <td >
        	<input type="text" name="firstname" id="firstname" value="{$form_data.firstname}" class="input-text validate-require disable-auto-complete" style="width:100%"/>
        </td>
    </tr>

	<tr>
    	<td width = "22%">
        	<strong id="notify_lastname">Last name <span class="require">*</span></strong>
        </td>
        <td >
        	<input type="text" name="lastname" id="lastname" value="{$form_data.lastname}" class="input-text validate-require disable-auto-complete" style="width:100%"/>
        </td>
    </tr>

	<tr>
    	<td width = "22%">
        	<strong id="notify_username">Username<span class="require">*</span></strong>
        </td>
        <td >
        	<input type="text" name="username" id="username" value="{$form_data.username}" class="input-text validate-require disable-auto-complete" style="width:100%"/>
        </td>
    </tr>

	<tr>
    	<td width = "22%">
        	<strong>Password</strong>
        </td>
        <td >
        	<input type="text" name="password" id="password" value="" class="input-text disable-auto-complete" style="width:100%"/>
        </td>
    </tr>

	<tr>
    	<td width = "22%">
        	<strong id="notify_email">Email<span class="require">*</span></strong>
        </td>
        <td >
        	<input type="text" name="email" id="email" value="{$form_data.email}" class="input-text validate-email disable-auto-complete" style="width:100%" />
        </td>
    </tr>

	<tr>
    	<td width = "22%" valign="top">
        	<strong >Role</strong>
        </td>
        <td>{$form_data.role_name}
        </td>
    </tr>

    
	<tr>
    	<td colspan="2" align="right">
        	<hr/>
			<input type="button" class="button" value="Save" onclick="user.submit()"/>
        </td>
    </tr>
    
</table>

