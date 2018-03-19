<table width="100%" cellspacing="10" class="edit-table">

	<tr>
    	<td width = "22%">
        	<strong id="notify_title">Title <span class="require">*</span></strong>
        </td>
        <td >
        	<input type="text" name="title" id="title" value="{$form_data.title}" class="input-text validate-require disable-auto-complete" style="width:100%"/>
        </td>
    </tr>

	<tr>
    	<td width = "22%" valign="top">
        	<strong id="notify_description">Description <span class="require">*</span></strong>
        </td>
        <td >
            <textarea name="description" id="description" class="input-text validate-require" style="width:100%;height:150px">{$form_data.description}</textarea>
        </td>
    </tr>

	<tr>
    	<td width = "22%" valign="top">
        	<strong id="notify_order">Order <span class="require">*</span></strong>
        </td>
        <td >
        	<input type="text" name="order" id="order" value="{$form_data.order}" class="input-text validate-require disable-auto-complete" style="width:50%"/>
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
            <script type="text/javascript">
			var role = new Role('#frmRole');
			</script>
            <input type="hidden" name="next" id="next" value="0"/>
            <input type="button" class="button" value="Reset" onclick="role.reset('?module=role&action=add')"/>
			<input type="button" class="button" value="Save" onclick="role.submit()"/>
            <input type="button" class="button" value="Save & Next" onclick="role.submit(true)"/>
        </td>
    </tr>
    
</table>

