<div id="pack_group">
<table width="100%" cellspacing="10" class="edit-table">
	<tr>
    	<td width = "22%">
        	<strong id="notify_name">Title <span class="require">*</span></strong>
        </td>
        <td>
			<input type="text" name="name" id="name" value="{$form_data.name}" class="input-text validate-require disable-auto-complete" style="width:100%"/>
        </td>
    </tr>

    <tr>
        <td width = "22%">
            <strong id="notify_extra_group">Is Extra Group <span class="require">*</span></strong>
        </td>
        <td>
            {assign var = 'chked' value = ''}
            {if $form_data.is_extra_group == 1}
                {assign var = 'chked' value = 'selected'}
            {/if}
            <label for="is_extra_group" >
                <select name="is_extra_group" id="is_extra_group">
                    <option value="0"> No </option>
                    <option value="1" {$chked}> Yes </option>
                </select>
            </label>
        </td>
    </tr>

	<tr>
    	<td width = "22%">
        	<strong id="notify_order">Order<span class="require">*</span></strong>
        </td>
        <td >
			<input type="text" name = "order" id = "order" value="{$form_data.order}" class="input-text validate-digits disable-auto-complete" style="width:50%"/>
        </td>
    </tr>

	<tr>
    	<td width = "22%">
        </td>
        <td>
            {assign var = 'chked' value = ''}
            {if $form_data.is_active == 1}
                {assign var = 'chked' value = 'checked'}
            {/if}
            <label for="is_active" >
			<input type="checkbox" name="is_active" id="is_active" value="1" {$chked}/>
            Active
            </label>
        </td>
    </tr>
</table>
</div>
{include file="admin.package.group.list.tpl"}