<script language="javascript" src="../modules/package/templates/js/check_display.js"></script>
<script type="text/javascript">
    var token = '{$token}';
    {literal}
    function loadList(url){
        $.post(url,{},function(data){
                $('#tbody').html(data);
               },'html');
    }
    $(document).ready(function(){
        var url = '../modules/package/action.admin.php?action=loadList&token='+token;
        loadList(url);
    });
</script>
{/literal}
<div id="pack_banner">
<table width="100%" cellspacing="10" class="edit-table">

	<tr>
    	<td width = "22%">
        	<strong id="notify_price">Price <span class="require">*</span></strong>
        </td>
        <td>

            <input type="text"  value="{$form_data.show_price}" class="input-text validate-require disable-auto-complete" onblur="this.value=format_price(this.value,'#price','#pack_banner','cent')" style="width:50%"/>
            ($AU)
            <input type="hidden" name = "price" id = "price" value="{$form_data.price}" class="input-text validate-require validate-money disable-auto-complete" style="width:50%"/>
        </td>
    </tr>

	<tr>
    	<td width = "22%">
        	<strong id="notify_property_type_id">Property type<span class="require">*</span></strong>
        </td>
        <td>
            <select name="property_type_id" id="property_type_id" class="input-select" style="width:50%">
                {html_options options=$options_property_subtype selected = $form_data.property_type_id}
            </select>
        </td>
    </tr>

	<tr>
    	<td width = "22%">
        	<strong id="notify_area">Display Area<span class="require">*</span></strong>
        </td>
        <td>
            <select name="area" id="area" class="input-select" style="width:50%" ><!--onchange="onReloadDisplay(this.form)"-->>
                {html_options options=$options_area selected = $form_data.area}
            </select>
        </td>
    </tr>
    <!--
	<tr id="postion_display">
    	<td width = "22%">
        	<strong id="notify_position">Position<span class="require">*</span></strong>
        </td>
        <td>
            <select name="position" id="position" class="input-select" style="width:50%">
                {html_options options=$options_position selected = $form_data.position}
            </select>
        </td>
    </tr>
    
	<tr>
    	<td width = "22%" valign="top">
        	<strong id="notify_page_id">Page </strong>
        </td>
        <td>
            <select name="page_id" id="page_id" class="input-select" style="width:50%;">
                {html_options options=$options_page selected = $form_data.page_id}
            </select>
            
        </td>
    </tr>
	
	<tr>
    	<td width = "22%" valign="top">
        	<strong id="notify_page_id">Page type</strong>
        </td>
        <td>
            <select name="page_id" id="page_id" class="input-select" style="width:50%;">
                {html_options options=$options_page selected = $form_data.page_id}
            </select>
            
        </td>
    </tr>
	-->
	<tr>
    	<td width = "22%">
        	<strong id="notify_country_id">Country<span class="require">*</span></strong>
        </td>
        <td>
            <select name="country_id" id="country_id" class="input-select validate-number-gtzero" style="width:50%" disabled="disabled" >
                {html_options options=$options_country selected = $form_data.country_id}
            </select>
            <input type="hidden" name="country_id" value="{$form_data.country_id}"/>
        </td>
    </tr>

	<tr>
    	<td width = "22%">
        	<strong id="notify_state_id">State<span class="require">*</span></strong>
        </td>
        <td>
            <select name="state_id" id="state_id" class="input-select" style="width:50%">
                {html_options options=$options_status selected = $form_data.state_id}
            </select>
        </td>
    </tr>
	<!--
	<tr>
    	<td width = "22%">
        	<strong id="notify_order">Order</strong>
        </td>
        <td >
			<input type="text" name = "order" id = "order" value="{$form_data.order}" class="input-text" style="width:50%"/>
        </td>
    </tr>
    -->
	<tr>
    	<td width = "22%"></td>
        <td>
            {assign var = 'chked' value = ''}
            {if $form_data.active == 1}
                {assign var = 'chked' value = 'checked'}
            {/if}
            <label for="active" ><input style="margin-right:5px;" type="checkbox" name="active" id="active" value="1" {$chked}/> Active</label>
        </td>
    </tr>
    <tr><td></td><td>Note: Price will be processed on each page.</td></tr>
	<tr>
    	<td colspan="2" align="right">
        	<hr/>
            <input type="hidden" name="next" id="next" value="0"/>
            <input type="button" class="button" value="Reset" onclick="package.reset('?module=package&action=save-{$action_ar[1]}&token={$token}')"/>
			<input type="button" class="button" value="Save" onclick="package.submit()"/>
            <input type="button" class="button" value="Save & Next" onclick="package.submit(true)"/>
        </td>
    </tr>
</table>
</div>
{literal}
<script type="text/javascript">
	//onReloadDisplay(document.getElementById("frmPackage"));
</script>
{/literal}