
<div class="step-8-info">
    <div class="step-name">
        <h2>Confirm & Pay</h2>
    </div>
    <div class="step-detail col2-set">
        <div class="col-1" style="width: 300px;float: left;">
            <p>
                Register here to setup an account to inspect, bid, buy... Complete the below. Register here to setup an account to inspect, bid, buy... Complete the below. Register here to setup an account to inspect, bid, buy... Complete the below..
            </p>
            <br/>
            <p>
                Please complete payment *
            </p>
        </div>
        <div class="col-2 bg-f7f7f7" style="width: 600px;float: right;">
			<!--BEGIN FORM-->
            <input type="hidden" name="hid_payment_money" id="hid_payment_money" value="{$payment_money}" />

            <div id="panel_payment" style="">
            	{$payment_template}
            </div>

            <!--END FORM-->
		   <script type="text/javascript">
		   {literal}
		   
		   {/literal}
           </script>
        </div>
        <div class="clearthis"></div>
    </div>
</div>

