<div>
    <ul class="form-list" style="padding-top:0px;padding-bottom:0px">
        <li class="wide">
            <span>
            	<input type="radio" name="payment[]" id="payment_method_paypal" value="paypal"/ style="margin-right:10px" onclick="payment_click(this)" />
                <strong>
                    <img src="https://fpdbs.paypal.com/dynamicimageweb?cmd=_dynamic-image&amp;buttontype=ecmark&amp;locale=en_AU"
                         alt="Acceptance Mark" class="v-middle"/>&nbsp;
                    <a style="text-decoration: none;"
                       href="https://www.paypal.com/au/cgi-bin/webscr?cmd=xpt/Marketing/popup/OLCWhatIsPayPal-outside"
                       onclick="javascript:window.open('https://www.paypal.com/au/cgi-bin/webscr?cmd=xpt/Marketing/popup/OLCWhatIsPayPal-outside','olcwhatispaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, ,left=0, top=0, width=400, height=350'); return false;">What
                        is PayPal?</a>
                    <div style="font-weight: bold;padding-left: 85px;">
                        <small>PayPal accepts credit card payments without being a PayPal member/user</small>
                    </div>
                </strong>
            </span>
        </li>
    </ul>
</div>

<div id="container_paypal" style="display: none">
    <ul class="form-list" style="padding-top:10px;padding-bottom:0px;margin-left:30px">
        <li class="wide">
            <div class="input-box" style="width:50%;font-weight: bold;">
                You will be redirected to the PayPal website.
            </div>
        </li>
    </ul>
</div>