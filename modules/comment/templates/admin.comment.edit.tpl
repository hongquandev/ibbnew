<table width="100%" cellspacing="10" class="edit-table">

	<tr>
    	<td width = "22%">
        	<strong id="notify_title">Author name <span class="require"></span></strong>
        </td>
        <td >
        	{$form_data.name}
        </td>
    </tr>

	<tr>
    	<td width = "22%">
        	<strong id="notify_uri">Author email <span class="require"></span></strong>
        </td>
        <td >
        	{$form_data.email}
        </td>
    </tr>

	<tr>
    	<td width = "22%">
        	<strong id="notify_order">Title <span class="require"></span></strong>
        </td>
        <td >
        	{$form_data.title}
        </td>
    </tr>

	<tr>
    	<td width = "22%" valign="top">
        	<strong id="notify_parent_id">Content <span class="require"></span></strong>
        </td>
        <td >
			{$form_data.content}            
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
            <input type="hidden" name="delete" id="delete" value="0"/>
			<input type="button" class="button" value="Save" onclick="comment.submit()"/>
            <input type="button" class="button" value="Delete" onclick="comment.delete()"/>
        </td>
    </tr>
    
</table>

