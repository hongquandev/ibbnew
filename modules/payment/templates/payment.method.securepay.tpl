<div>
    <ul class="form-list" style="padding-top:0px;padding-bottom:0px">
        <li class="wide">
            <span>
                <input type="radio" name="payment[]" id="payment_method_securepay" value="securepay"/ style="margin-right:10px" onclick="payment_click(this)" />
                <strong>Securepay payment</strong>
            </span>
        </li>
    </ul>
</div>

<div id="container_securepay" style="display:none;margin-left:30px">
    <ul class="form-list">
        <li class="wide">
            <span>
                <strong>Select your Credit Card</strong>
            </span>
            <div class="input-box" style="width:50%">
                <select name="fields[creditcard]" id="credit_card"  class="input-select" onchange="CC_click(this)">
                    {html_options options = $options_creditcard selected = $form_data.creditcard}
                </select>
            </div>
        </li>
    </ul>
    
    <ul class="form-list" id="cc_container2" style="margin-top:-10px;padding-top:0px;">
        <li class="wide">
            <label>
                <strong id="notify_card_type">Card type <span >*</span></strong>
            </label>
            <div class="input-box" style="width:50%">
                <select name="fields[card_type]" id="card_type"  class="input-select validate-require">
                {html_options options = $options_card_type selected = $form_data.card_type}
                </select>
            </div>
        </li>
        <li class="wide">
            <label>
                <strong id="notify_card_name">Name on card <span >*</span></strong>
            </label>
            <div class="input-box" style="width:50%">
                <input type="text" name="fields[card_name]" id="card_name" value="{$form_data.card_name}" class="input-text validate-require" />
            </div>
        </li>
        <li class="wide">
            <label>
                <strong id="notify_card_number">Credit card number <span >*</span></strong>
            </label>
            <div class="input-box" style="width:50%">
                <input type="text" name="fields[card_number]" id="card_number" value="{$form_data.card_number}" class="input-text validate-require validate-digits" />
            </div>
        </li>
        <li class="wide">
            <label>
                <strong id="notify_expiration_date">Expiration date <span>*</span></strong>
            </label>
            <div class="input-box">
                <div style="width:30%;float:left">
                    <select name="fields[expiration_month]" id="expiration_month"  class="input-select validate-require">
                    {html_options options = $options_month selected = $form_data.expiration_month}
                    </select>
                </div>
                <div style="width:20%;float:left">
                    <select name="fields[expiration_year]" id="expiration_year"  class="input-select validate-require">
                    {html_options options = $options_year selected = $form_data.expiration_year}
                    </select>
                </div>
            </div>
        </li>
        <br clear="all"/> 
    </ul>
    <ul class="form-list" id="cc_container3" style="margin-top:-10px;padding-top:0px;">    
        <li class="wide">
            <label>
                <strong id="notify_card_verification_value">Card Verification Value <span >*</span></strong>
            </label>
            <div class="input-box" style="width:50%">
                <input type="text" name="fields[card_verification_value]" id="card_verification_value" value="{$form_data.card_verification_value}" class="input-text validate-cvv" />
            </div>
        </li>           
    </ul>
</div>

{if $pay_require > 0}
    <script type="text/javascript">
        jQuery('#payment_step8').show();
    </script>
{/if}
{if $pay_require > 0}
    <input type="hidden" name="rq" id="rq" value="add"/>
{else}
    <input type="hidden" name="rq" id="rq" value="update"/>
{/if}


<script type="text/javascript">
{literal}
	var _html = jQuery('#cc_container2').html();
	
	function expirationDate() {
		var month = jQuery('#expiration_month').val();
		var year = jQuery('#expiration_year').val();
		if ((month*year) == 0){
			jQuery('#notify_expiration_date').css({"color":"#ff0000"});
			return false;
		}
		jQuery('#notify_expiration_date').css({"color":""});
		return true;
	}
	
	function validCVV() {
		var cvv = jQuery('#card_verification_value').val();
		var ok = false;
		var vl = new Validation('#frmProperty');
		if (cvv.length == 3 && vl['validate-digits'](jQuery('#card_verification_value'))) {
			ok = true;
		}
		Common.warningObject('#card_verification_value',ok);
		return ok;
	}
	
	
	function CC_refresh(first) {
		pro.callback_func = [];
		if (jQuery('#creditcard','#frmProperty').val() > 0) {
			jQuery('#cc_container2').html('');
		} else {
			if (first == false) {
				//UPDATE COMBO'S STYLE	
				$("#expiration_month").uniform();
				$("#expiration_year").uniform();
				$("#card_type").uniform();
			}
			pro.addCallbackFnc('valid',function(){return expirationDate();});
		}
		pro.addCallbackFnc('valid',function(){return validCVV();});	
	}
	
	function CC_click(obj) {
		var val = jQuery(obj).val();
		
		if (val == 0) {
			jQuery('#cc_container2').show();
			jQuery('#cc_container2').html(_html);
			pro.addCallbackFnc('valid',function(){return expirationDate();});
		} else {
			jQuery('#cc_container2').hide();
			jQuery('#cc_container2').html('');
			pro.callback_func = [];
		}
		CC_refresh(false);
	}
	
	CC_refresh(true);

{/literal}
</script>  