<div id="pack_basic">
<table width="100%" cellspacing="10" class="edit-table">
	<tr>
    	<td width = "22%">
        	<strong id="notify_home">Home <span class="require">*</span></strong>
        </td>
        <td>
		    <input type="text"  value="{$form_data.show_home}" class="input-text disable-auto-complete" onblur="this.value=format_price(this.value,'#home','#pack_basic','cent')" style="width:50%"/>
            ($AU)
            <input type="hidden" name = "home" id = "home" value="{$form_data.home}" class="input-text validate-require validate-money disable-auto-complete" style="width:50%"/>
        </td>
    </tr>
	<tr>
    	<td width = "22%">
        	<strong id="notify_focus">Focus <span class="require">*</span></strong>
        </td>
        <td>
			<input type="text"  value="{$form_data.show_focus}" class="input-text disable-auto-complete" onblur="this.value=format_price(this.value,'#focus','#pack_basic','cent')" style="width:50%"/>
            ($AU)
            <input type="hidden" name = "focus" id = "focus" value="{$form_data.focus}" class="input-text validate-require validate-money disable-auto-complete" style="width:50%"/>
        </td>
    </tr>

	<tr>
    	<td width = "22%" valign="top">
        	<strong id="notify_bid">Bid / Make an offer<span class="require">*</span></strong>
        </td>
        <td>
			<input type="text"  value="{$form_data.show_bid}" class="input-text disable-auto-complete" onblur="this.value=format_price(this.value,'#bid','#pack_basic')" style="width:50%"/>
            ($AU)
            <input type="hidden" name = "bid" id = "bid" value="{$form_data.bid}" class="input-text validate-require validate-money disable-auto-complete" style="width:50%"/>
            <br /><i>only pay when bidding / offering the first time per property</i>        
        </td>
    </tr>

	<tr>
    	<td width = "22%" valign="top">
        	<strong id="notify_bid_block">Bid for Block<span class="require">*</span></strong>
        </td>
        <td>
			<input type="text"  value="{$form_data.show_bid_block}" class="input-text disable-auto-complete" onblur="this.value=format_price(this.value,'#bid_block','#pack_basic')" style="width:50%"/>
            ($AU)
            <input type="hidden" name = "bid_block" id = "bid_block" value="{$form_data.bid_block}" class="input-text validate-require validate-money disable-auto-complete" style="width:50%"/>
            <br /><i>only pay when bidding the first time per property</i>        
        </td>
    </tr>

    
	<tr>
    	<td width = "22%" valign="top">
        	<strong id="notify_banner_notification_email">Banner notification email<span class="require">*</span></strong>
        </td>
        <td>
			<input type="text"  value="{$form_data.show_banner_notification_email}" class="input-text disable-auto-complete" onblur="this.value=format_price(this.value,'#banner_notification_email','#pack_basic','cent')" style="width:50%"/>
            ($AU)
            <input type="hidden" name = "banner_notification_email" id = "banner_notification_email" value="{$form_data.banner_notification_email}" class="input-text validate-require validate-money disable-auto-complete" style="width:50%"/>
        </td>
    </tr>
    
	<!--
	<tr>
    	<td width = "22%" valign="top">
        	<strong id="notify_make_an_offer">Make an offer <span class="require">*</span></strong>
        </td>
        <td>
			$<input type="text" name = "make_an_offer" id = "make_an_offer" value="{$form_data.make_an_offer}" class="input-text validate-require" style="width:50%"/>
			<br /><i>only pay when offering the first time per property</i>                     
        </td>
    </tr>
	-->
	<tr>
    	<td colspan="2" align="right">
        	<hr/>
			<input type="button" class="button" value="Save" onclick="package.submit()"/>
        </td>
    </tr>
</table>
</div>