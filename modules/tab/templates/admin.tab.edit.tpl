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
    	<td width = "22%">
        	<strong id="notify_uri">Route <span class="require">*</span></strong>
        </td>
        <td >
        	<input type="text" name="uri" id="uri" value="{$form_data.uri}" class="input-text validate-require disable-auto-complete" style="width:100%"/>
        </td>
    </tr>
    <tr>
    	<td width = "22%">
        	<strong id="notify_icon">Icon <span class="require">*</span></strong>
        </td>
        <td >
        	<select name="img_path" id="img_path" class="input-select validate-require" style="width:50%">
                <option value="">Select icon</option>
                {html_options options=$icon selected=$form_data.img_path}
        	</select>
        </td>
    </tr>

	<tr>
    	<td width = "22%">
        	<strong id="notify_order">Order <span class="require">*</span></strong>
        </td>
        <td >
        	<input type="text" name="order" id="order" value="{$form_data.order}" class="input-text validate-require disable-auto-complete" style="width:50%" />
        </td>
    </tr>

	<tr>
    	<td width = "22%" valign="top">
        	<strong id="notify_parent_id">Parent <span class="require">*</span></strong>
        </td>
        <td >
             <select name="parent_id" id="parent_id" class="input-select" style="width:50%">
                {html_options options=$options_parent selected =$form_data.parent_id}
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
            <input type="button" class="button" value="Reset" onclick="tab.reset('?module=tab&action=add')"/>
			<input type="button" class="button" value="Save" onclick="tab.submit()"/>
            <input type="button" class="button" value="Save & Next" onclick="tab.submit(true)"/>
        </td>
    </tr>
    
</table>

