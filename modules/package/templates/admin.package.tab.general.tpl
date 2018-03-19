<script type="text/javascript" src="../modules/package/templates/js/colorpicker/colorpicker.js"></script>
<link rel="stylesheet" type="text/css" href="../modules/package/templates/js/colorpicker/colorpicker.css" />
<div class="pack_option">
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
        	<strong id="notify_order">Order<span class="require">*</span></strong>
        </td>
        <td >
			<input type="text" name="order" id="order" value="{$form_data.order}" class="input-text disable-auto-complete" style="width:50%"/>
        </td>
    </tr>

    <tr>
    	<td width = "22%">
        	<strong id="notify_color">Color<span class="require">*</span></strong>
        </td>
        <td>
            <div id="colorSelector"><div style="background-color: {$form_data.color};"></div></div>
			<input type="hidden" name="color" id="color" value="{$form_data.color}"/>
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
{literal}
<script type="text/javascript">
    jQuery(document).ready(function(){
        $('#colorSelector').ColorPicker({
            color: '#0000ff',
            onShow: function (colpkr) {
                $(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                $(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
                $('#colorSelector div').css('backgroundColor', '#' + hex);
                $('#color').val('#' + hex);
            }
        });
    });
</script>
{/literal}