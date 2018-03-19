<table width="100%" cellspacing="10" class="edit-table">
	<tr>
    	<td width = "22%">
        	<strong id="notify_lawyer_name">Lawyer Name <span class="require">*</span></strong>
        </td>
        <td >
        	<input type="text" name="lawyer_name" id="lawyer_name" value="{$form_data.lawyer_name}" class="input-text validate-require" style="width:100%" autocomplete="off"/>
        </td>
    </tr>

	<tr>
    	<td width = "22%">
        	<strong id="notify_street">Address <span class="require">*</span></strong>
        </td>
        <td >
        	<input type="text" name="street" id="street" value="{$form_data.street}" class="input-text validate-require" style="width:100%" autocomplete="off"/>
        </td>
    </tr>

	<tr>
    	<td width = "22%">
        	<strong id="notify_suburb">Suburb <span class="require">*</span></strong>
        </td>
        <td >
        	<input type="text" name="suburb" id="suburb" value="{$form_data.suburb}" class="input-text validate-require" style="width:100%" autocomplete="off"/> 
        </td>
    </tr>

	<tr>
    	<td width = "22%">
        	<strong id="notify_state">State <span class="require">*</span></strong>
        </td>
        <td >
            <select name="state" id="state"  class="input-select validate-number-gtzero" style="width:50%">
                {html_options options = $options_state selected = $form_data.state}
            </select>
        </td>
    </tr>

	<tr>
    	<td width = "22%">
			<strong id="notify_postcode">Postcode <span class="require">*</span></strong>
        </td>
        <td >
        	<input type="text" name="postcode" id="postcode" value="{$form_data.postcode}" class="input-text validate-require validate-postcode" style="width:50%" autocomplete="off"/>
        </td>
    </tr>

	<tr>
    	<td width = "22%">
			<strong id="notify_country">Country <span class="require">*</span></strong>
        </td>
        <td >
            <select name="country" id="country"  class="input-select validate-number-gtzero" onchange="Common.changeCountry('/modules/general/action.php?action=get_states',this,'state')" style="width:50%">
                {html_options options = $options_country selected = $form_data.country}
            </select>
        </td>
    </tr>

	<tr>
    	<td width = "22%">
			<strong id="notify_telephone">Telephone <span class="require">*</span></strong>
        </td>
        <td >
        	<input type="text" name="telephone" id="telephone" value="{$form_data.telephone}" class="input-text validate-require validate-telephone" style="width:50%" autocomplete="off"/>
        </td>
    </tr>

	<tr>
    	<td width = "22%">
			<strong id="notify_mobiphone">Mobile Phone  <span class="require">*</span></strong>
        </td>
        <td >
        	<input type="text" name="mobilephone" id="mobilephone" value="{$form_data.mobilephone}" class="input-text validate-require validate-mobiphone" style="width:50%" autocomplete="off"/>
        </td>
    </tr>

	<tr>
    	<td width = "22%">
			<strong id="notify_email_address">Email <span class="require">*</span></strong>
        </td>
        <td >
        	<input type="text" name="email_address" id="email_address" value="{$form_data.email_address}" class="input-text validate-require validate-email" autocomplete="off" style="width:100%"/>
        </td>
    </tr>

	<tr>
    	<td width = "22%">
			<strong id="notify_contact_name">Contact name <span class="require">*</span></strong>
        </td>
        <td >
        	<input type="text" name="contact_name" id="contact_name" value="{$form_data.contact_name}" class="input-text validate-require" style="width:100%" autocomplete="off"/>
        </td>
    </tr>

	<tr>
    	<td colspan="2" align="right">
        	<hr/>
            <input type="hidden" name="next" id="next" value="0"/>
            <input type="hidden" name="lawyer_id" id="lawyer_id" value="{$lawyer_id}"/>
			<input type="button" class="button" value="Save" onclick="agent.submit()"/>
            <input type="button" class="button" value="Save & Next" onclick="agent.submit(true)"/>
        </td>
    </tr>
    
</table>

