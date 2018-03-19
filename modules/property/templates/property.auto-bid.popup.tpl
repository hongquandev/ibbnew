<div class="popup_container popup_container_auto popup_container2" id="autobid_{$property_id}" style="display:none">
    <div id="contact-wrapper"  style="padding-bottom:0px;">
		<div class="title"><h2 style="text-align:left">AUTO BID SETTINGS<span onclick="pro.closeAutoBidForm('#autobid_{$property_id}')"  id="fridx" style="color:#ffffff">Close X</span></h2> </div>
        <div class="ma-messages messages-auto-bid" id="fridmess">
        	<form name="frmAutoBid_{$property_id}" id="frmAutoBid_{$property_id}" style="width:236px;margin:4px;">
            	<!--
                <table style="width:100%">
                	<tr>
                    	<td style="width:50%;text-align:left"><b>Auction increment:</b></td>
                        <td style="width:50%;text-align:left"><b>Maximum bid:</b></td>
                    </tr>
                	<tr>
                    	<td style="text-align:left">
							<font style="font-size:11px;font-weight:bold;">AU</font>
                            <input type="text" value="{$agent_auction_step_show}" class="" onkeyup="this.value=format_price(this.value,'#agent_auction_step','#frmAutoBid_{$property_id}')" onkeypress="auto_bid_change()" style="width:80%"/>

                            <input type="hidden" id="agent_auction_step" name="agent_auction_step" value="{$agent_auction_step}" class="validate-digits" onchange="pro.changeValue(this,{$step_init})" style="width:80%"/>
                        </td>
                        <td style="text-align:left">
							<font style="font-size:11px;font-weight:bold;">AU</font>
                            <input type="text" value="{$agent_maximum_bid_show}" class="" onkeyup="this.value=format_price(this.value,'#agent_maximum_bid','#frmAutoBid_{$property_id}')" style="width:80%"/>

                            <input type="hidden" id="agent_maximum_bid" name="agent_maximum_bid" value="{$agent_maximum_bid}" class="validate-digits" style="width:80%"/>

                        </td>
                    </tr>
                </table>
                -->
                <table style="width:100%">
                	<tr>
                    	<td style="width:50%;text-align:left">
                            <div class="input-box">
                            	<label><strong>Auction increment:</strong></label>
                            </div>    
                        </td>
                        <td style="width:50%;text-align:left">
                    	    <div class="input-box">
                    			<label><strong>Maximum bid:</strong></label>
                            </div>    
                        </td>
                    </tr>
                	<tr>
                    	<td style="width:50%;text-align:left">
							<font style="font-size:11px;font-weight:bold;color:#2e3540">AU</font>
                            <input type="text" value="{$agent_auction_step_show}" class="input-text" onkeyup="this.value=format_price(this.value,'#agent_auction_step','#frmAutoBid_{$property_id}')" onkeypress="auto_bid_change()" style="width:70%"/>

                            <input type="hidden" id="agent_auction_step" name="agent_auction_step" value="{$agent_auction_step}" class="validate-digits" onchange="pro.changeValue(this,{$step_init})" style="width:70%"/>
                        </td>
                        <td style="width:50%;text-align:left">
							<font style="font-size:11px;font-weight:bold;color:#2e3540">AU</font>
                            <input type="text" value="{$agent_maximum_bid_show}" class="input-text" onkeyup="this.value=format_price(this.value,'#agent_maximum_bid','#frmAutoBid_{$property_id}')" style="width:70%"/>

                            <input type="hidden" id="agent_maximum_bid" name="agent_maximum_bid" value="{$agent_maximum_bid}" class="validate-digits" style="width:70%"/>

                        </td>
                    </tr>
                </table>
                
                <input type="hidden" name="is_autobid" id="is_autobid" value="{$is_autobid}"/>
            </form>
             <div class="div-button-autobid">
             	 <div id="autobid_msg_{$property_id}" style="text-align:left;color:#FF0000;margin: 0px 5px;"></div>
                 
                 <p style="margin:6px 0px 2px 0px;border:0px;border-bottom:1px solid #F0F0F0;"></p>
				<!--
                 <button style="{if $is_autobid == 0}display: inline;{else}display: none;{/if}" id = "reg_autobid_accept_btn_{$property_id}" class="btn-red btn-red-auto-bid" name="submit" onClick="pro.acceptBid('#frmAutoBid_{$property_id}','{$property_id}','#autobid_{$property_id}')">
                    <span><span id="reg_autobid_accept_lbl">Accept</span></span>
                 </button>

                 <button style="display: none;"  id = "reg_autobid_close_btn_{$property_id}" class="btn-red btn-red-auto-bid" name="submit" onClick="pro.closeAutoBidForm('#autobid_{$property_id}')">
                    <span><span id="reg_autobid_close_lbl">Close</span></span>
                 </button>

                 <button id = "reg_autobid_cancel_btn_{$property_id}" class="btn-red btn-red-auto-bid" name="submit" onClick="pro.cancelBid('#frmAutoBid_{$property_id}','{$property_id}','#autobid_{$property_id}')" style="{if $is_autobid != 1}display:none{/if}">
                    <span><span id="reg_autobid_cancel_lbl">Cancel</span></span>
                 </button>
                 -->
                 <button style="{if $is_autobid == 0}display: inline;{else}display: none;{/if}" id = "reg_autobid_accept_btn_{$property_id}" class="btn-blue" name="submit" onClick="pro.acceptBid('#frmAutoBid_{$property_id}','{$property_id}','#autobid_{$property_id}')">
                    <span><span id="reg_autobid_accept_lbl">Accept</span></span>
                 </button>

                 <button style="display: none;"  id = "reg_autobid_close_btn_{$property_id}" class="btn-blue" name="submit" onClick="pro.closeAutoBidForm('#autobid_{$property_id}')">
                    <span><span id="reg_autobid_close_lbl">Close</span></span>
                 </button>

                 <button id = "reg_autobid_cancel_btn_{$property_id}" class="btn-gray" name="submit" onClick="pro.cancelBid('#frmAutoBid_{$property_id}','{$property_id}','#autobid_{$property_id}')" style="{if $is_autobid != 1}display:none{/if}">
                    <span><span id="reg_autobid_cancel_lbl">Cancel</span></span>
                 </button>
                 
                 <div id="abs_loading_{$property_id}" style="display:inline;">
                    <img src="/modules/general/templates/images/loading.gif" alt="" style="height:30px;"/>
                 </div>
            </div>
        </div>
    </div>
</div>

{literal}
<script type="text/javascript">
    function auto_bid_change(){
        jQuery('#autobid_msg').hide();
        jQuery('#reg_autobid_accept_btn').show();
        jQuery('#reg_autobid_close_btn').hide();
    };
</script>
{/literal}