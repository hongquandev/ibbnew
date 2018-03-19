<table width="100%" cellspacing="10" class="edit-table">

    <tr>
        <td colspan="2" align="center">
            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
                <legend>Email Account</legend>
            </fieldset>
        </td>
    </tr>

	<tr>
    	<td width = "19%">
        	<strong>Enable</strong>
        </td>
        <td>
             <select name="documents[sms_enable]" id="sms_enable" class="input-select" style="width:50%">
                {html_options options=$options_yes_no selected =$form_data.sms_enable}
            </select>
                   
        </td>
    </tr>

	<tr>
    	<td width = "19%">
        	<strong>Username</strong>
        </td>
        <td>
			<input type="text" name = "fields[sms_username]" id = "sms_username" value="{$form_data.sms_username}" class="input-text validate-require disable-auto-complete" style="width:100%"/>
                   
        </td>
    </tr>

	<tr>
    	<td width = "19%">
        	<strong>Password</strong>
        </td>
        <td>
			<input type="text" name = "fields[sms_password]" id = "sms_password" value="{$form_data.sms_password}" class="input-text validate-require disable-auto-complete" style="width:100%"/>        
        </td>
    </tr>
	<tr>
    	<td width = "19%">
        	<strong>Sender Id</strong>
        </td>
        <td>
			<input type="text" name = "fields[sms_sender_id]" id = "sms_sender_id" value="{$form_data.sms_sender_id}" class="input-text validate-require disable-auto-complete" style="width:100%"/>
        </td>
    </tr>

	<tr>
    	<td width = "19%">
        	<strong>Gateway Url</strong>
        </td>
        <td>
			<input type="text" name = "fields[sms_gateway_url]" id = "sms_gateway_url" value="{$form_data.sms_gateway_url}" class="input-text validate-require disable-auto-complete" style="width:100%"/>
        </td>
    </tr>

	<tr>
    	<td width = "19%" valign="top">
        	<strong>Contact</strong>
        </td>
        <td>
			<input type="text" name = "fields[sms_contact]" id = "sms_contact" value="{$form_data.sms_contact}" class="input-text validate-require" style="width:100%" autocomplete="off"/>  
            <br/><i>Send to admin when happen issuer on server</i>
                 
        </td>
    </tr>


    <tr>

   {* <tr>
>>>>>>> .r106913
    	<td colspan="2" align="center">
            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
            	<legend>Message was sent on each bid</legend>
            </fieldset>
        </td>
    </tr>
	
	<tr>
    	<td width = "19%" valign="top">
        	<strong>To Vendor</strong>
        </td>
        <td>
            <textarea name = "fields[sms_vendor_msg]" id = "sms_vendor_msg" class="input-text" style="width:100%;height:100px">{$form_data.sms_vendor_msg}</textarea>     
        </td>
    </tr>

	<tr>
    	<td width = "19%" valign="top">
        	<strong>To Bidder</strong>
        </td>
        <td>
            <textarea name = "fields[sms_bidder_msg]" id = "sms_bidder_msg" class="input-text" style="width:100%;height:100px">{$form_data.sms_bidder_msg}</textarea>     
        </td>
    </tr>
    *}
    <tr>
    	<td colspan="2" align="center">
            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
            	<legend>Message was sent when stop bid on one property</legend>
            </fieldset>
        </td>
    </tr>
	
	<tr>
    	<td width = "19%" valign="top">
        	<strong>To Vendor</strong>
        </td>
        <td>
            <textarea name = "fields[sms_vendor_stop_bid_msg]" id = "sms_vendor_stop_bid_msg" class="input-text" style="width:100%;height:100px">{$form_data.sms_vendor_stop_bid_msg}</textarea>     
        </td>
    </tr>

	<tr>
    	<td width = "19%" valign="top">
        	<strong>To Winner</strong>
        </td>
        <td>
            <textarea name = "fields[sms_winner_stop_bid_msg]" id = "sms_winner_stop_bid_msg" class="input-text" style="width:100%;height:100px">{$form_data.sms_winner_stop_bid_msg}</textarea>     
        </td>
    </tr>
    
	<tr>
    	<td width = "19%" valign="top">
        	<strong>To People who bidded or in watchlist</strong>
        </td>
        <td>
            <textarea name = "fields[sms_agent_stop_bid_msg]" id = "sms_agent_stop_bid_msg" class="input-text" style="width:100%;height:100px">{$form_data.sms_agent_stop_bid_msg}</textarea>     
        </td>
    </tr>    

    <tr>
    	<td colspan="2" align="center">
            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
            	<legend>Message prompt to bidder when property will be end</legend>
            </fieldset>
        </td>
    </tr>
	
	<tr>
    	<td width = "19%" valign="top">
        	<strong>To Bidder</strong>
        </td>
        <td>
            <textarea name = "fields[sms_bidder_prompt_msg]" id = "sms_bidder_prompt_msg" class="input-text" style="width:100%;height:100px">{$form_data.sms_bidder_prompt_msg}</textarea>     
        </td>
    </tr>
        
    
    <tr>
    	<td colspan="2" align="center">
            <fieldset style="border:0px;border-top:1px solid #D1D1D1;padding-left:20px;">
            	<legend>Message prompt to agent to notification when property is live (Reminder function for Forthcoming Auctions)</legend>
            </fieldset>
        </td>
    </tr>
	
	<tr>
    	<td width = "19%" valign="top">
        	<strong>To Bidder</strong>
        </td>
        <td>
            <textarea name = "fields[sms_bidder_remind_msg]" id = "sms_bidder_remind_msg" class="input-text" style="width:100%;height:100px">{$form_data.sms_bidder_remind_msg}</textarea>     
        </td>
    </tr>
    
	<tr>
    	<td colspan="2" align="right">
        	<hr/>
			<input type="submit" class="button" value="Save"/>
        </td>
    </tr>
    
</table>
