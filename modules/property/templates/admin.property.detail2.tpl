<table width="100%" cellspacing="10">
	<tr>
    	<td width="19%">
        	<strong id="notify_agent_id">Agent <span class="require">*</span></strong>
        </td>
        <td width="30%">
            <select name="fields[agent_id]" id="agent_id" class="input-select validate-number-gtzero" style="width:100%" onchange="A_change(this)">
                {html_options options = $agent_options selected = $form_data.agent_id}
            </select>
        </td>
        <td width="19%"></td>
        <td width="30%"></td>
    </tr>

	<tr>
    	<td>
        	<strong id="notify_auction_sale">Auction or Private Sale? <span class="require">*</span></strong>
        </td>
        <td>
            <select name="fields[auction_sale]" id="auction_sale" class="input-select validate-number-gtzero" style="width:100%">
                {html_options options = $auction_sales selected = $form_data.auction_sale}
            </select>
        </td>
    </tr>    
    
	<tr>
    	<td>
            <strong id="notify_type">Property Type <span class="require">*</span></strong>
        </td>
        <td>
            <select name="fields[type]" id="type" class="input-select validate-number-gtzero" style="width:100%">
                {html_options options = $property_types selected = $form_data.type}
            </select>
        </td>
    </tr>    

	<tr>
    	<td>
	        <strong id="notify_address">Address <span class="require">*</span></strong>
        </td>
        <td>
        	<input type="text" name="fields[address]" id="address" value="{$form_data.address}" class="input-text validate-require disable-auto-complete" style="width:100%"/>
        </td>
<td align="right">
            <strong id="notify_suburb">Suburb <span class="require">*</span></strong>
        </td>
        <td>
	        <input type="text" name="fields[suburb]" id="suburb" value="{$form_data.suburb}" class="input-text validate-require validate-letter disable-auto-complete" style="width:100%"/>
        </td>
    </tr>  

	<tr>
    	<td>
            <strong id="notify_state">State <span class="require">*</span></strong>
        </td>
        <td>
            <select name="fields[state]" id="state" class="input-select validate-number-gtzero" style="width:100%">
                {html_options options = $states selected = $form_data.state}
            </select>
        </td>
<td align="right">
            <strong id="notify_postcode">Post code <span class="require">*</span></strong>
        </td>
        <td>
        	<input type="text" name="fields[postcode]" id="postcode" value="{$form_data.postcode}" class="input-text validate-postcode disable-auto-complete" style="width:100%"/>
        </td>
    </tr>       

	<tr>
    	<td>
        	<strong id="notify_country">Country <span class="require">*</span></strong>
        </td>
        <td>
            <select name="fields[country]" id="country" class="input-select validate-number-gtzero" onchange="Common.changeCountry('/modules/general/action.php?action=get_states',this,'state')" style="width:100%">
                {html_options options = $countries selected = $form_data.country}
            </select>
        
        </td>
    </tr>
    
    </tr>
    	<td valign="top">
            <strong id="notify_price">Price <span class="require">*</span></strong>
        </td>
        <td>
            <input type="text" name="fields[price]" id="price" value="{$form_data.price}" class="input-text validate-money disable-auto-complete" style="width:100%"/>
            <br/>
            <span style="font-size: 10px;margin-top:5px">your current price requirement, can change 5 days</span>
        </td>
       
    </tr>    

    
    <tr>
    	<td>
        	<strong id="notify_bedroom">Bedrooms <span class="require">*</span></strong>
        </td>
        <td>
            <select name="fields[bedroom]" id="bedroom" class="input-select validate-number-gtzero" style="width:100%">
                {html_options options = $bedrooms selected = $form_data.bedroom}
            </select>
        </td>
<td align="right">
        	<strong id="notify_bathroom">Bathrooms <span class="require">*</span></strong>
        </td>
        <td>
            <select name="fields[bathroom]" id="bathroom" class="input-select validate-number-gtzero" style="width:100%">
                {html_options options = $bathrooms selected = $form_data.bathroom}
            </select>
        </td>
    </tr> 
    
    <tr>
    	<td>
        	<strong id="notify_land_size">Land size <span class="require">*</span></strong>
        </td>
        <td>
            <select name="fields[land_size]" id="land_size" class="input-select validate-number-gtzero" style="width:100%">
                {html_options options = $land_sizes selected = $form_data.land_size}
            </select>
        </td>
<td align="right">
	        <strong id="notify_car_space">Car spaces <span class="require">*</span></strong>
        </td>
        <td>
            <select name="fields[car_space]" id="car_space" class="input-select validate-number-gtzero" style="width:100%">
                {html_options options = $car_spaces selected = $form_data.car_space}
            </select>
        </td>
    </tr>
   
   <tr>
   		<td>
        	<strong id="notify_car_port">Garage / Carport <span class="require">*</span></strong>
        </td>
        <td>
            <select name="fields[car_port]" id="car_port" class="input-select validate-number-gtzero" style="width:100%">
                {html_options options = $car_ports selected = $form_data.car_port}
            </select>
        </td>
   </tr>
    
	
    <tr>
    	<td valign="top">
        	<strong id="notify_description">Description <span class="require">*</span></strong>
        </td>
        <td colspan=3>
        	<textarea name="fields[description]" id="description" class="input-select validate-require" style="width:100%;height:150px">{$form_data.description}</textarea>
        </td>
    </tr>
	{if $property_id > 0}
    <tr>
    	<td valign="top">
        	<strong id="">Pay status</strong>
        </td>
        <td colspan=3>{$form_data.pay_status}</td>
    </tr>
	{/if}

   <tr>
   		<td>
        	
        </td>
        <td colspan=3>
           <div style="margin-top:5px">
            	<div style="float:left;width:30%;" title="It was actived by admin">
                    <label for="focus">
                        {assign var = 'chked' value = ''}
                        {if $form_data.focus==1}
                            {assign var = 'chked' value = 'checked'}
                        {/if}
                    
                        <input type="checkbox" name="fields[focus]" id="focus" {$chked}/>
                        <strong><u>Set focus</u></strong>
                    </label>
                    <br/>
                    <label for="feature">
                        {assign var = 'chked' value = ''}
                        {if $form_data.feature == 1}
                            {assign var = 'chked' value = 'checked'}
                        {/if}
                    
                        <input type="checkbox" name="fields[feature]" id="feature" {$chked}/>
                        <strong><u>Set feature</u></strong>
                    </label>
                    <br/>
                    <label for="open_for_inspection">
                        {assign var = 'chked' value = ''}
                        {if $form_data.open_for_inspection == 1}
                            {assign var = 'chked' value = 'checked'}
                        {/if}
                        <input type="checkbox" name="fields[open_for_inspection]" id="open_for_inspection" {$chked}/>
                        <strong><u>Open for inspection?</u></strong>
                    </label>  
                    
                </div>
                <div style="float:left;width:30%">
                    <label for="auction_blog">
                        {assign var = 'chked' value = ''}
                        {if $form_data.auction_blog == 1}
                            {assign var = 'chked' value = 'checked'}
                        {/if}
                    
                        <input type="checkbox" name="fields[auction_blog]" id="auction_blog" {$chked}/>
                        <strong>Auction blog?</strong>
                    </label>
                    <br/>
                    <label for="contact_by_bidder">
                        {assign var = 'chked' value = ''}
                        {if $form_data.contact_by_bidder == 1}
                            {assign var = 'chked' value = 'checked'}
                        {/if}
                    
                        <input type="checkbox" name="fields[contact_by_bidder]" id="contact_by_bidder" {$chked}/>
                        <strong>Contact by bidder?</strong>
                    </label>
                </div>    
                <div style="float:left;width:30%">

                    <label for="active">
                        {assign var = 'chked' value = ''}
                        {if $form_data.active == 1}
                            {assign var = 'chked' value = 'checked'}
                        {/if}
                    
                        <input type="checkbox" name="fields[active]" id="active" {$chked}/>
                        <strong>Is active?</strong>
                    </label>
                    <br/>
                
                    <label for="open_time">
                        {assign var = 'chked' value = ''}
                        {if $form_data.open_time == 1}
                            {assign var = 'chked' value = 'checked'}
                        {/if}
                    
                        <input type="checkbox" name="fields[open_time]" id="open_time" {$chked}/>
                        <strong>Open times?</strong>
                    </label>
                    <br/>   
                     <label for="set_jump">
                            {assign var = 'chked' value = ''}
                            {if $form_data.set_jump == 1}
                                {assign var = 'chked' value = 'checked'}
                            {/if}
                        
                            <input type="checkbox" name="fields[set_jump]" id="set_jump" {$chked}/>
                            <strong>Set change home page </strong>
                        </label>
                        <br/>                 
                    </div>
            </div>
         </td>
   </tr>


	<tr>
    	<td colspan="4" align="right">
        	<hr/>
            <input type="hidden" name="next" id="next" value="0"/>
			<input type="button" class="button" value="Save" onclick="pro.submit()"/>
            <input type="button" class="button" value="Save & Next" onclick="pro.submit(true)"/>
        </td>
    </tr>
    
</table>

{literal}
<script type="text/javascript">
	/*
    var temp = document.getElementById("cmb-time").innerHTML;
    function update(obj){
        if (obj.value == "{/literal}{$private_sale}{literal}"){
            document.getElementById("cmb-time").innerHTML = "";
        }else {
            document.getElementById("cmb-time").innerHTML = temp;
        }
    }

    $(document).ready(function() {
        update(document.getElementById("auction_sale"));
    });
	*/
	/*
	function saveProperty(next) {
		pro.flushCallback();
		pro.callback_func.push(function(){ return Common.checkPriceRange('#price','#price_from','#price_to'); });
		
		if (next == true) {
			pro.submit();
		} else {
			pro.submit(true);
		}
	}
	*/
	
	function A_change(obj) {
		var agent_id = jQuery(obj).val();
		var token = jQuery('#token').val();
		document.location = '?module=property&action=add&agent_id='+agent_id+'&token='+token;
	}
</script>
{/literal}