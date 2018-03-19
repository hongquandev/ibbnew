<script type="text/javascript">
var pro = new Property();
</script>
{*
<script type="text/javascript" src="modules/agent/templates/js/spinners.js"></script>
<script type="text/javascript" src="modules/agent/templates/js/tipped.js"></script>
*}


<div class="step-8-info">
    <div class="step-name">
        <h2>Confirm & Pay</h2>
    </div>
    <div class="step-detail col2-set">
        <div class="col-1">
            <p>
                Register here to setup an account to inspect, bid, buy... Complete the below. Register here to setup an account to inspect, bid, buy... Complete the below. Register here to setup an account to inspect, bid, buy... Complete the below..
            </p>
            <br/>
            <p>
                Please complete all the fields marked *
            </p>
        </div>
        <div class="col-2 bg-f7f7f7">
            <div class="areg-item">
                <div class="item">
                    <div class="title">
                        <span class="f-left">{$review.info.title}</span>
                        <span class="f-right">{$review.info.price}</span>
                        <div class="clearthis">
                        </div>
                    </div>
                    <div class="f-left info">
                        <div class="desc">
                           {$review.info.full_address} {$review.info.description}
                        </div>
                        <div class="tbl-info">
                            <ul class="f-left col1">
                                <li>
                                    <span>{$review.info.bedroom_value} Bedroom{if $review.info.bedroom_value > 1}s{/if}</span>
                                     <div class="clearthis"></div>
                                </li>
                                <li>
                                    <span>{$review.info.bathroom_value} Bathroom{if $review.info.bathroom_value > 1}s{/if}</span>
                                     <div class="clearthis"></div>
                                </li>
                                <li>
                                    <span>{$review.info.carport_value} Car park{if $review.info.carport_value > 1}s{/if}</span>
                                     <div class="clearthis"></div>
                                </li>
                                <li id="focus_tooltip" class="tipped">
                                    <span>
                                    	<label for="set_focus">
                                        	{assign var = checked value = ''}
                                            {if $review.info.focus == 1}
                                            	{assign var = checked value = 'checked'}
                                            {/if}
                                            <input id="set_focus" type="checkbox" value="{$review.info.focus}" {$checked} name="set_focus" onclick="pro.setFocusHome('{$review.info.property_id}','focus')" />
                                            Set Focus <span id="set_focus_loading"></span>
                                        </label>                                
                                    </span>
                                    <div class="clearthis"></div>
                                </li>
                            </ul>
                            <ul class="f-left col2">
                                <li>
                                    <span>{$review.info.land_size}</span>
                                     <div class="clearthis"></div>
                                </li>
                                <li>
                                    <span class="title-star">Livability Rating</span><span  class="span-star"> {$review.info.livability_rating_mark}</span>
                                    <div class="clearthis clearthis-ie7"></div>
                                </li>
                                <li>
                                    <span class="title-star" >iBB Sustainability</span><span  class="span-star">{$review.info.green_rating_mark}</span>
                                    <div class="clearthis clearthis-ie7"></div>
                                </li>
                                <li id="homepage_tooltip" class="tipped">
                                    <span>
                                    	<label for="set_home">
                                        	{assign var = checked value = ''}
                                            {if $review.info.set_jump == 1}
                                            	{assign var = checked value = 'checked'}
                                            {/if}
                                        
                                            <input id="set_home" type="checkbox" value="{$review.info.set_jump}" {$checked} name="set_home" onclick="pro.setFocusHome('{$review.info.property_id}','home')" />
                                            Set Home page <span id="set_home_loading"></span>
                                        </label>                              
                                    </span>
                                    <div class="clearthis"></div>
                                </li>
                                
                            </ul>
                            <div class="clearthis">
                            </div>
                        </div>
                    </div>
                    <div class="f-right img">
                        <div>
                            <img src="{$review.photo}" alt="img" style="width:180px;height:130px;"/>
                        </div>
                    </div>
                    <div class="clearthis">
                    </div>
                </div>
                <div class="buttons-set">
                    <!-- <button class="btn-red step-eight-btn-red">
                        <span><span>Confirm & Checkout</span></span>
                    </button> -->
                </div>
            </div>
            {if $confirm_payment == 1}
                <script type="text/javascript"> showMess('You had been registration successful ! ','?module=agent&action=view-property')</script>
            {/if}
			<!--BEGIN FORM-->
            <input type="hidden" name="hid_payment_money" id="hid_payment_money" value="{$payment_money}" />
            <div id="panel_payment" style="display:none">
            	{$payment_template}
            </div>
            
            <div id="panel_nopayment" style="margin-left:15px;display:none">
	            <br clear="all"/>
            	<form method="post" action = "{$form_action}">
                	<button class="btn-red step-eight-btn-red2"><span><span>Submit</span></span></button>
                </form>
            </div>
            <!--END FORM-->
		   <script type="text/javascript">
		   {literal}
		   
		   function listenerPanel() {
		   		var payment_money = jQuery('#hid_payment_money').val();
				jQuery('#panel_payment').hide();
				jQuery('#panel_nopayment').hide();
				
				
				var _id = payment_money > 0 ? 'payment' : 'nopayment';				
				jQuery('#panel_' + _id).show();
		   }
		   
		   listenerPanel();
           /*
           {literal}
                jQuery(document).ready(function($) {
                    Tipped.create("#focus_tooltip", "If you want to set Focus your property on Homepage, you have to pay for using this function.", {
                        skin: 'dark',
                        maxWidth: 180,
                        closeButton: true,
                        hook: 'topleft'
                    });
                });
                jQuery(document).ready(function($) {
                    Tipped.create("#homepage_tooltip", "If you want to set your property on Homepage, you have to pay for using this function.", {
                        skin: 'dark',
                        maxWidth: 180,
                        closeButton: true,
                        hook: 'topleft'
                    });
                });
           
           */
		   {/literal}
           </script>
        </div>
        <div class="clearthis"></div>
    </div>
</div>

