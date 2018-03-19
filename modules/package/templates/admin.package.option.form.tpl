<div id="pack_option">
<table width="100%" cellspacing="10" class="edit-table">
	<tr>
    	<td width = "22%">
        	<strong id="notify_name">Title <span class="require">*</span></strong>
        </td>
        <td>
			<input type="text" name="option_name" id="option_name" value="" class="input-text disable-auto-complete _validate-require" style="width:50%"/>
        </td>
    </tr>
    <tr>
    	<td width = "22%">
        	<strong id="notify_code">Code <span class="require">*</span></strong>
        </td>
        <td>
			<input type="text" name="option_code" id="option_code" value="" class="input-text disable-auto-complete disable-element _validate-require" style="width:50%"/>
        </td>
    </tr>
    <tr>
    	<td width = "22%">
        	<strong id="notify_title">Type<span class="require">*</span></strong>
        </td>
        <td>
            <select name="option_type" id="option_type" class="input-select disable-element _validate-require" style="width:50%">
                {html_options options=$options_type selected = $form_data.option_type}
            </select>
        </td>
    </tr>
    <tr id="select_option">
        <td width = "22%">
        	<strong id="notify_select_option">Select Options<span class="require">*</span></strong>
        </td>
        <td>
            {include file="admin.select.tpl"}
        </td>
    </tr>
    <tr>
    	<td width = "22%">
        	<strong id="notify_is_required">Values Required<span class="require">*</span></strong>
        </td>
        <td>
            <select name="option_is_required" id="option_is_required" class="input-select" style="width:50%">
                {html_options options=$options_yes_no selected = $form_data.option_yes_no}
            </select>
        </td>
    </tr>

    <tr>
    	<td width = "22%">
        	<strong id="notify_show_in_frontend">Show In Frontend</strong>
        </td>
        <td>
            <select name="option_show_in_frontend" id="option_show_in_frontend" class="input-select" style="width:50%">
                {html_options options=$options_yes_no selected = 1}
            </select>
        </td>
    </tr>

    <tr>
    	<td width = "22%">
        	<strong id="notify_has_unit">Has Unit</strong>
        </td>
        <td>
            <select name="option_has_unit" id="option_has_unit" class="input-select" style="width:50%">
                {html_options options=$options_yes_no selected = 0}
            </select>
        </td>
    </tr>

    <tr>
    	<td width = "22%">
        	<strong id="notify_unit">Unit</strong>
        </td>
        <td>
            <input type="text" name="option_unit" id="option_unit" value="" class="input-text disable-auto-complete" style="width:50%"/>
        </td>
    </tr>

    <tr>
        <td width = "22%">
            <strong id="notify_order">Price{*<span class="require">*</span>*}</strong>
        </td>
        <td >
            <input type="text" name="price" id="option_price" value="0" class="input-text disable-auto-complete" style="width:50%"/>
        </td>
    </tr>

    <tr>
        <td width = "22%">
            <strong id="notify_order">Description</strong>
        </td>
        <td >
            <textarea name="option_description" id="option_description" class="" style="width:50%;height: 100px"></textarea>
        </td>
    </tr>

	<tr>
    	<td width = "22%">
        	<strong id="notify_order">Order<span class="require">*</span></strong>
        </td>
        <td >
			<input type="text" name="option_order" id="option_order" value="" class="input-text disable-auto-complete _validate-require" style="width:50%"/>
        </td>
    </tr>

	<tr>
    	<td width = "22%">
        </td>
        <td>
            {assign var = 'chked' value = ''}
            {if $form_data.option_is_active == 1}
                {assign var = 'chked' value = 'checked'}
            {/if}
            <label for="option_is_active" >
			<input type="checkbox" name="option_is_active" id="option_is_active" value="1" {$chked}/>
            Active
            </label>
        </td>
    </tr>


	<tr>
    	<td colspan="2" align="right">
        	<hr/>
            <input type="hidden" name="option_is_system" id="option_is_system"/>
            <input type="button" class="button" value="Reset" name="reset"/>
			<input type="button" class="button" value="Save" name="save"/>
        </td>
    </tr>
</table>
</div>