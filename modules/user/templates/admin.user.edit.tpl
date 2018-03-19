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
        	{if $user_id > 0}
            	{assign var = req value = ''}
                {assign var = cls value = ''}    
            {else}
            	{assign var = req value = '<span class="require">*</span>'}
                {assign var = cls value = 'validate-require'}    
            {/if}
        	<strong id="notify_password">Password {$req}</strong>
        </td>
        <td >
        	<input type="text" name="password" id="password" value="" class="input-text {$cls} disable-auto-complete" style="width:100%"/>
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
        	<strong id="notify_role_id">Role<span class="require">*</span></strong>
        </td>
        <td >
        	<select name="role_id" id="role_id" class="input-select" style="width:50%">
            	{html_options options=$options_role selected =$form_data.role_id}
            </select>
            <div style="margin-top:5px">
                {assign var = 'chk' value = ''}
                {if $form_data.active > 0}
                    {assign var = 'chk' value = 'checked'}
                {/if}
            
                <label for="notify_active">
                    <input type="checkbox" name="active" id="notify_active" value="1" {$chk}/> Active
                </label>
            </div>
            
        </td>
    </tr>

    
	<tr>
    	<td colspan="2" align="right">
        	<hr/>
            <input type="hidden" name="next" id="next" value="0"/>
            <input type="button" class="button" value="Reset" onclick="user.reset('?module=user&action=add')"/>
			<input type="button" class="button" value="Save" onclick="user.submit()"/>
            <input type="button" class="button" value="Save & Next" onclick="user.submit(true)"/>
        </td>
    </tr>
    
</table>

