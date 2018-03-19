<table  width="100%" cellspacing="10">
    {if is_array($options) and count($options)>0}
        {foreach from = $options key = k item = v}
            <tr>
                <td width="20%"><strong>{$v.title}</strong></td>
                <td>
                {*<input type="text" name="fields[option][{$k}]" id="option_{$k}" value="{$form_data[$k]}" class="input-text" style="width:100%"/>*}
                <select name="fields[option][{$k}]" id="option_{$k}">
                {html_options options = $options_ selected = $form_data[$k]}
                </select>
                </td>
            </tr>
        {/foreach}
    {/if}
    
    <tr>
    	<td colspan="2" align="right">
        	<hr/>
            <input type="hidden" name="next" id="next" value="0"/>
        	<input type="button" class="button" value="Save" onclick="pro.submit()"/>
            <input type="button" class="button" value="Save & Next" onclick="pro.submit(true)"/>
        </td>
    </tr>
</table>