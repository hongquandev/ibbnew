<div class="step-4-info">
    <div class="step-name">
        <h2>T&C Rules</h2>
        <p style="padding: 0px 10px 10px 0px; text-align: justify;">
            Please read the Terms and Conditions of the site <b>www.bidRhino.com </b>  and all associated rules and policies thoroughly. Once you are happy to accept and be bound by these terms, conditions, rules and policies, please accept to continue.
        </p>
    </div>
    <div class="step-detail">
        <div class="bg-f7f7f7">
            <div style="padding: 10px 10px 0px 10px;">
                <span class="cufon" style="font-size: 14px;">T&C Rules</span>
            </div>
            <form name="frmAgent" id="frmAgent" method="post" action = "{$form_action}">
                <div class="srrules rules" style="max-height: 480px; overflow-y: scroll;">
                    {$tandcrules}
                    {*<p style="text-align: justify">
                    By accessing our website and using the services on our <b>www.bidRhino.com </b>, the user agrees and accepts the following terms and conditions (as they may be amended and changed from time to time), including any and all descriptions and instructions relating to the use of such services and of our website, participation in our auctions, and the sale and purchase of all products and items sold in our auctions or on our website.
                    </p>
                    <br/>
                    <p style="text-align: justify">
                    The user understands that any bidding advice, articles or other information posted on our website, such as under the How it Works section, are only suggestions, and are to be relied upon. BidRivals shall not be liable or responsible for any action taken by a user on our website or the action of any other person who may have read or been informed of any such information or other written material.
                    </p>
                    <br/>
                    <p style="text-align: justify">
                    BidRivals undertakes to comply with all applicable state sales and use tax laws in connection with its sales
                    </p>*}
                </div>
                <div style="padding: 10px 10px 0px 10px;">
                    <span class="cufon" style="font-size: 14px; ">Bidrhino Rules</span>
                </div>
                <div class="rules" style="max-height: 480px; overflow-y: scroll;">
                    {$ibbrules}
                    {*<p style="text-align: justify">
                    By accessing our website and using the services on our <b>www.bidRhino.com </b> website, the user agrees and accepts the following terms and conditions (as they may be amended and changed from time to time), including any and all descriptions and instructions relating to the use of such services and of our website, participation in our auctions, and the sale and purchase of all products and items sold in our auctions or on our website.
                    </p>
                    <br/>
                    <p style="text-align: justify">
                    The user understands that any bidding advice, articles or other information posted on our website, such as under the How it Works section, are only suggestions, and are to be relied upon. BidRivals shall not be liable or responsible for any action taken by a user on our website or the action of any other person who may have read or been informed of any such information or other written material.
                    </p>
                    <br/>
                    <p style="text-align: justify">
                    BidRivals undertakes to comply with all applicable state sales and use tax laws in connection with its sales
                    </p>*}

                </div>

                <div class="sragree" style="margin:0px; padding:10px;">
                    <label for="allow_vendor_contact">
                        <input type="checkbox" name="allow_next" id="allow_next" checked="checked" onclick="agreeClick(this)"/>
                        <strong> I Agree </strong>
                    </label>
                </div>
            </form>
            <div class="buttons-set">
                <button id ="sub4" class="btn-red btn-red-re-buyer" onclick="step4Next()">
                    <span><span>Next</span></span>
                </button>
            </div>

            {literal}
                <script type="text/javascript">
                    jQuery(document).ready(function(){
                        agreeClick('#allow_next');

                    });
                    function agreeClick(obj) { 
                            if (jQuery(obj).is(':checked')) {
                                jQuery('#sub4').removeClass('btn-gray').addClass('btn-red btn-red-re-buyer');
                            } else {
                                jQuery('#sub4').removeClass('btn-red btn-red-re-buyer').addClass('btn-gray');
                            }
                        }

                        function step4Next() {
                            if (jQuery('#allow_next').is(':checked')) {
                                agent.step('#frmAgent');
                            }
                        }
                </script>
            {/literal}

        </div>
    </div>
</div>