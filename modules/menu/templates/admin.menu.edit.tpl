<table width="100%" cellspacing="10" class="edit-table">

	<tr>
    	<td width = "22%">
        	<strong id="notify_title">Title <span class="require">*</span></strong>
        </td>
        <td>
			<input type="text" name = "title" id = "title" value="{$form_data.title}" class="input-text validate-require disable-auto-complete" style="width:50%"/>
        </td>
    </tr>
    
	<tr>
    	<td width = "22%">
        	<strong id="notify_url">Url</strong>
        </td>
        <td>
			<input type="text" name = "url" id = "url" value="{$form_data.url}" class="input-text" style="width:50%"/>
        </td>
    </tr>
    
	<tr>
    	<td width = "22%">
        	<strong id="notify_order">Order</strong>
        </td>
        <td>
			<input type="text" name = "order" id = "order" value="{$form_data.order}" class="input-text" style="width:50%"/>
        </td>
    </tr>
    
	<tr>
    	<td width = "22%" valign="top">
        	<strong id="notify_parent_id">Parent</strong>
        </td>
        <td>
            <select name="parent_id" id="parent_id" class="input-select" style="width:50%;">
                {html_options options = $options_menu selected = $form_data.parent_id}
            </select>
        </td>
    </tr>
    
	<tr>
    	<td width = "22%" valign="top">
        	<strong id="notify_area_id">Area</strong>
        </td>
        <td>
            <select name="area_ids[]" id="area_ids" class="input-select" style="width:50%;height:100px" multiple="multiple">
                {html_options options = $options_area selected = $form_data.area_ids}
            </select>
        </td>
    </tr>    

	<tr>
    	<td width = "22%" valign="top">
        	<strong id="notify_area_id">Banner Area</strong>
        </td>
        <td>
            <select name="banner_area_ids[]" id="banner_area_ids" class="input-select" style="width:50%;height:100px" multiple="multiple">
                {html_options options = $options_banner_area selected = $form_data.banner_area_ids}
            </select>
        </td>
    </tr>    

	<tr>
    	<td width = "22%" valign="top">
        	<strong id="notify_access">Access</strong>
        </td>
        <td>
            <select name="access[]" id="access" class="input-select" style="width:50%;height:100px" multiple="multiple">
                {html_options options = $options_access selected = $form_data.access}
            </select>
        </td>
    </tr>    

        
	<tr>
    	<td width = "22%">
        </td>
        <td>
            {assign var = 'chked' value = ''}
            {if $form_data.active == 1}
                {assign var = 'chked' value = 'checked'}
            {/if}
            <label for="active" ><input type="checkbox" name="active" id="active" value="1" {$chked}/>&nbsp;Active</label>
        </td>
    </tr>

    <tr>
    	<td width = "22%">
        </td>
        <td>
            {assign var = 'chked' value = ''}
            {if $form_data.show_mobile == 1}
                {assign var = 'chked' value = 'checked'}
            {/if}
            <label for="show_mobile" ><input type="checkbox" name="show_mobile" id="show_mobile" value="1" {$chked}/>&nbsp;Shown in mobile</label>
        </td>
    </tr>
    

	<tr>
    	<td colspan="2" align="right">
        	<hr/>
            <input type="hidden" name="next" id="next" value="0"/>
            <input type="button" class="button" value="Reset" onclick="menu.reset('?module=menu&action=save-{$action_ar[1]}&token={$token}')"/>
			<input type="button" class="button" value="Save" onclick="menu.submit()"/>
            <input type="button" class="button" value="Save & New" onclick="menu.submit(true)"/>
        </td>
    </tr>
</table>
