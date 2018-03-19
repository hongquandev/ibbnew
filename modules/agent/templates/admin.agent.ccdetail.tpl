<table width="100%" cellspacing="10" class="edit-table">
	<tr>
    	<td width="22%">
        	<strong id="notify_card_type">Card type <span class="require">*</span></strong>
        </td>
        <td>
            <select name="card_type" id="card_type"  class="input-select validate-require" style="width:50%">
                {html_options options = $options_card_type selected = $form_data.card_type}
            </select>
        </td>
    </tr>

	<tr>
    	<td width = "22%">
        	<strong id="notify_card_name">Name on card <span class="require">*</span></strong>
        </td>
        <td>
			<input type="text" name = "card_name" id = "card_name" value="{$form_data.card_name}" class="input-text validate-require" style="width:100%" autocomplete="off"/>        
        </td>
    </tr>

	<tr>
    	<td width = "22%">
        	<strong id="notify_card_number">Credit card number <span class="require">*</span></strong>
        </td>
        <td >
			<input type="text" name = "card_number" id = "card_number" value="{$form_data.card_number}" class="input-text validate-require validate-digits" style="width:100%" autocomplete="off"/>
        </td>
    </tr>
    
	<tr>
    	<td width="22%">
        	<strong id="notify_expiration_date">Expiration date <span class="require">*</span></strong>
        </td>
        <td>
            <select name="expiration_month" id="expiration_month"  class="input-select validate-number-gtzero" style="width:30%">
                {html_options options = $options_month selected = $form_data.expiration_month}
            </select>
            
            <select name="expiration_year" id="expiration_year"  class="input-select validate-number-gtzero" style="width:20%">
                {html_options options = $options_year selected = $form_data.expiration_year}
            </select>
            
        </td>
    </tr>

	<tr>
    	<td colspan="2" align="right">
        	<script type="text/javascript">
			{literal}
			function expirationDate() {
				var month = jQuery('#expiration_month').val();
				var year = jQuery('#expiration_year').val();
				if ((month*year) == 0){
					jQuery('#notify_expiration_date').css({"color":"#ff0000"});
					return false;
				}
				jQuery('#notify_expiration_date').css({"color":""});
				//return true;
			}
			agent.callback_func.push(function() {return expirationDate();});
			{/literal}
			</script>
        	<hr/>
            <input type="hidden" name="next" id="next" value="0"/>
            <input type="hidden" name="cc_id" id="cc_id" value="{$cc_id}"/>
            <input type="button" class="button" value="Reset" onclick="agent.reset('','cc')"/>
			<input type="button" class="button" value="Save" onclick="agent.submit()"/>
            <input type="button" class="button" value="Save & Next" onclick="agent.submit(true)"/>
        </td>
    </tr>
    <tr>
    	<td colspan="2">
            {if isset($cc_ar) and is_array($cc_ar) and count($cc_ar) > 0}
                <div class="edit-table" style="max-height:400px">
                    <table width="100%" class="grid-table" cellspacing="1">
                        <tr class="title">
                            <td width="30px"></td>
                            <td align="center" style="font-weight:bold;color:#fff;">Card type</td>
                            <td align="center" style="font-weight:bold;color:#fff;">Card name</td>
                            <td align="center" style="font-weight:bold;color:#fff;">Card number</td>
                            <td align="center" style="font-weight:bold;color:#fff;">Expiration date</td>
                            <td align="center" style="font-weight:bold;color:#fff;">Action</td>
                        </tr>
                        {assign var = i value = 0}
                        {foreach from = $cc_ar key = k item = cc}
                        {assign var = i value = $i+1}
                        <tr class="item{if $i%2==0}1{else}2{/if}">
                            <td align="center">{$i}</td>
                            <td><span style="margin-left:4px;">{$cc.name}</span></td>
                            <td><span style="margin-left:4px;">{$cc.card_name}</span></td>
                            <td><span style="margin-left:4px;">{$cc.card_number}</span></td>
                            <td><span style="margin-left:4px;">{$cc.expiration_date}</span></td>
                            <td width="70px" align="center">
                              <a href="{$cc.edit_link}" style="color:#0000FF">edit</a> | 
                              <a href="javascript:void(0)" onclick ="deleteItem2('{$cc.delete_link}')" style="color:#0000FF">delete</a>
                            </td>
                        </tr>
                        {/foreach}
                    </table>
                </div>
            {/if}
        </td>
    </tr>
    
</table>

