{if strlen($message) > 0}
    <div class="message-box message-box-cc-ie message-box-payment">{$message}</div>
{/if}

{literal}
<script src="/modules/payment/templates/js/payment.js"></script>
<script type="text/javascript">
var payment = new Payment('#frmPayment','is_submit');
</script>
{/literal}
<div style="margin:20px 0px 0px 0px;font-size:18px;">
    <h2>Select Payment Methods</h2>
</div>
<form style="margin-top: 15px; margin-bottom: 15px;" name="frmPayment" id="frmPayment" method="post" action="{$form_action}" onsubmit="return payment.isSubmit()">
	{foreach from = $payment_method_ar key = k item = row}
        {include file = "`$ROOTPATH`/modules/payment/templates/payment.method.`$k`.tpl"}
    {/foreach}
    <input type="hidden" name="is_submit" id="is_submit" value="0"/>
</form>
<div class="buttons-set" style="padding-right:0px;">
    {$info}
    <!--
	<button class="btn-red pay-btn-red" onclick="payment.submit()">
		<span><span>Pay</span></span>
	</button>
    -->
	<button class="btn-blue" onclick="payment.submit()">
		<span><span>Pay</span></span>
	</button>
    
</div>    
{literal}
<script type="text/javascript">
/**
When clicking on option payment method
**/
function payment_click(obj) {
	jQuery('[id^=container_]').each(function() {
		jQuery(this).hide();
	});
	
	if (jQuery(obj).attr('checked')) {
		var val = jQuery(obj).val();	
		jQuery('#container_' + val).show();
	}
}

/**
Auto select when having only one payment method
**/
function autoSelect() {
	var count = 0;
	var def = '';
	jQuery('[id^=payment_method_]').each(function() {
		count++;
		def = jQuery(this).val();
	}); 
	
	if (count == 1 && def.length > 0) {
		jQuery('#payment_method_' + def).attr('checked',true);
		payment_click('#payment_method_' + def);
	}
}

autoSelect();
</script>
{/literal}