<table width="100%" cellspacing="10" class="edit-table">
    <tr>
    	<td colspan="2" align="center">
            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
            	<legend>Secure Pay</legend>
            </fieldset>
        </td>
    </tr>

	<tr>
    	<td width = "19%"><strong>Enable</strong></td>
        <td>
             <select name="fields[payment_securepay_enable]" id="payment_securepay_enable" class="input-select" style="width:50%">
                {html_options options=$options_yes_no selected =$form_data.payment_securepay_enable}
            </select>
        </td>
    </tr>

   	<tr>
    	<td width = "19%"><strong>Title</strong></td>
        <td>
			<input type="text" name = "fields[payment_securepay_title]" id = "payment_securepay_title" value="{$form_data.payment_securepay_title}" class="input-text validate-require disable-auto-complete" style="width:100%"/>
        </td>
    </tr>

   	<tr>
    	<td width = "19%"><strong>Merchant ID</strong></td>
        <td>
			<input type="text" name = "fields[payment_securepay_merchant_id]" id = "payment_securepay_merchant_id" value="{$form_data.payment_securepay_merchant_id}" class="input-text validate-require disable-auto-complete" style="width:100%"/>
        </td>
    </tr>

	<tr>
    	<td width = "19%"><strong>Transaction Password</strong></td>
        <td>
			<input type="text" name = "fields[payment_securepay_transaction_password]" id = "payment_securepay_transaction_password" value="{$form_data.payment_securepay_transaction_password}" class="input-text validate-require disable-auto-complete" style="width:100%"/>
        </td>
    </tr>
    
   	<tr>
    	<td width = "19%"><strong>Gateway URL</strong></td>
        <td>
             <select name="fields[payment_securepay_gateway_url]" id="payment_securepay_gateway_url" class="input-select" style="width:50%">
                {html_options options = $options_securepay_gateway_url selected = $form_data.payment_securepay_gateway_url}
            </select>
        </td>
    </tr>
    
    <tr>
    	<td colspan="2" align="center">
            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
            	<legend>Paypal</legend>
            </fieldset>
        </td>
    </tr>

	<tr>
    	<td width = "19%"><strong>Enable</strong></td>
        <td>
             <select name="fields[payment_paypal_enable]" id="payment_paypal_enable" class="input-select" style="width:50%">
                {html_options options=$options_yes_no selected =$form_data.payment_paypal_enable}
            </select>
        </td>
    </tr>

   	<tr>
    	<td width = "19%"><strong>Title</strong></td>
        <td>
			<input type="text" name = "fields[payment_paypal_title]" id = "payment_paypal_title" value="{$form_data.payment_paypal_title}" class="input-text validate-require disable-auto-complete" style="width:100%"/>
        </td>
    </tr>

	<tr>
    	<td width = "19%" valign="top"><strong>Merchant Email</strong></td>
        <td>
			<input type="text" name = "fields[payment_paypal_merchant_email]" id = "payment_paypal_merchant_email" value="{$form_data.payment_paypal_merchant_email}" class="input-text validate-require disable-auto-complete" style="width:100%"/>
            <i>Email Associated with PayPal Merchant Account</i>       
        </td>
    </tr>

	<tr>
    	<td width = "19%"><strong>Return Success</strong></td>
        <td>
			<input type="text" name = "fields[payment_paypal_return_success]" id = "payment_paypal_return_success" value="{$form_data.payment_paypal_return_success}" class="input-text validate-require disable-auto-complete" style="width:100%"/>
        </td>
    </tr>

	<tr>
    	<td width = "19%"><strong>Return Cancel</strong></td>
        <td>
			<input type="text" name = "fields[payment_paypal_return_cancel]" id = "payment_paypal_return_cancel" value="{$form_data.payment_paypal_return_cancel}" class="input-text validate-require disable-auto-complete" style="width:100%"/>
        </td>
    </tr>

	<tr>
    	<td width = "19%"><strong>Notify Url</strong></td>
        <td>
			<input type="text" name = "fields[payment_paypal_return_notify]" id = "payment_paypal_return_notify" value="{$form_data.payment_paypal_return_notify}" class="input-text validate-require disable-auto-complete" style="width:100%"/>
        </td>
    </tr>

	<tr>
    	<td width = "19%"><strong>Sandbox Mode</strong></td>
        <td>
             <select name="fields[payment_paypal_sandbox_enable]" id="payment_paypal_sandbox_enable" class="input-select" style="width:50%">
                {html_options options=$options_yes_no selected =$form_data.payment_paypal_sandbox_enable}
            </select>
        </td>
    </tr>

    
	<tr>
    	<td colspan="2" align="right">
        	<hr/>
			<input type="submit" class="button" value="Save"/>
        </td>
    </tr>
</table>
