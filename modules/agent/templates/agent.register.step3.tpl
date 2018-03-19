<div class="step-4-info">
    <div class="step-name">
        <h2>{localize translate="T&C Rules<"}/h2>
        <p style="padding: 0px 10px 10px 0px; text-align: justify;">
            Please read the Terms and Conditions of the site <b>www.bidRhino.com </b>  and all associated rules and policies thoroughly. Once you are happy to accept and be bound by these terms, conditions, rules and policies, please accept to continue.
        </p>
        
    </div>
    <div class="step-detail">
        <div class="">
        
            <div style="padding: 10px 0px 0px 0px;">
                <span style="font-size: 14px;">{localize translate="T&C Rules"}</span>
            </div>
            <form name="frmAgent" id="frmAgent" method="post" action = "{$form_action}">
                <div class="srrules rules" style="max-height: 480px; overflow-y: scroll;">
                    {$tandcrules}
                </div>
                <div style="padding: 10px 0px 0px 0px;">
                    <span style="font-size: 14px; ">{localize translate="Bidrhino Rules"}</span>
                </div>
                <div class="rules" style="max-height: 480px; overflow-y: scroll;">
                    {$ibbrules}
                </div>

                <div class="sragree" style="margin:0px; padding:10px 10px 10px 0px;">
                    <label for="allow_vendor_contact">
                        <input type="checkbox" name="allow_next" id="allow_next" checked="checked" onclick="agreeClick(this)"/>
                        <strong>{localize translate="I Agree"}</strong>
                    </label>
                </div>
            </form>
            <div class="clearthis"></div>
            <div class="buttons-set">
            	<!--
                <button id ="sub4" class="btn-red btn-red-re-buyer" onclick="step4Next()">
                    <span><span>Next</span></span>
                </button>
                -->
                <button id ="sub4" class="btn-blue" onclick="step4Next()">
                    <span><span>{localize translate="Next"}</span></span>
                </button>
            </div>
        </div>
    </div>
</div>
{literal}
<script type="text/javascript">
    agreeClick('#allow_next');
    function agreeClick(obj) {
        if (jQuery(obj).is(':checked')) {
            jQuery('#sub4').removeClass('btn-gray').addClass('btn-blue');
        } else {
            jQuery('#sub4').removeClass('btn-blue').addClass('btn-gray');
        }
    }

    function step4Next() {
        if (jQuery('#allow_next').is(':checked')) {
            agent.step('#frmAgent');
        }
    }
</script>
{/literal}
