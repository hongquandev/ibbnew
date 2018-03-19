<div class="register-application-title">
    <h1>Step 3. Rental Application</h1>
</div>
<div id="register-application-step3" class="register-application-content">
    <form name="frmAgentTransact" id="frmAgentTransact" method="post" action="{$form_action_transact}" enctype="multipart/form-data">
        <input type="hidden" id="transact_agent_id" name="transact_agent_id" value="{$transact_agent_id}"/>
        <p>To register to transact on a property you MUST provide photo ID to comply with legal requirements.</p>
        <p>This registration is to enable you to transact online and links to your registration will be sent to the Agent to view (or print) only, this is to enable them to be able to review and validate your registration.</p>
        <p>I acknowledge that by submitting this registration, I am applying to be enabled to transact on this property
            This registration does not imply a commitment on my part to purchase this property.</p>
        <p>I acknowledge and accept that my registration is subject to the approval of the Managing Agent of the property, and the availability of the property.</p>
        <p>I acknowledge that no action will be taken against the Agent, or the Owner if this registration is not successful.</p>
        <p>I declare that all information contained and provided in this application is true and correct to the best of my knowledge and has been provided by me freely.</p>
        <p>I declare that I have inspected the property and am satisfied that the premises are in a reasonable and clean condition and I accept the premises as is.</p>
        <p>
            <input id="declared" type="checkbox" name="declared"><label style="display: none; color: red;margin-left: 20px" id="notify_declared">Please check here. Thanks</label>
        </p>
        <p>I have read and accepted the above declaration.</p>
        <p>
            <input id="accepted" type="checkbox" name="accepted"><label  style="display: none; color: red;margin-left: 20px" id="notify_accepted">Please check here. Thanks</label>
        </p>
        <div>
            <div class="clearthis"></div>
            <button type="button" class="btn-green-transact" onclick="submitApplication('#frmAgentTransact')">
                <span style="position: relative;left: auto;top: auto;"><span style="position: relative;left: auto;top: auto;">Submit Registration</span></span>
            </button>
        </div>
        <p>Before proceeding please acknowledge that you have read and accept the bidRhino terms and conditions  by ticking the box</p>
        By submitting this registration, you consent to all the information you have provided, including your personal information being collected, used, held and disclosed by bidRhino.com Pty Ltd in accordance with its Privacy Policy.
    </form>
</div>
<script type="text/javascript">
    {literal}
    function submitApplication(frm){
        var isSubmit = true;
        var agent_id = jQuery('#transact_agent_id',frm).val();
        jQuery('input[type=checkbox]',frm).each(function(){
            if(jQuery(this).attr('checked') != 'checked'){
                jQuery('#notify_'+jQuery(this).attr('id')).show();
                isSubmit = false;
            }else{
                jQuery('#notify_'+jQuery(this).attr('id')).hide();
            }
        });
        if(isSubmit){
            showLoadingPopup();
            var url = ROOTURL + '/modules/agent/action.php?action=submit_application';
            jQuery.post(url,{agent_id: agent_id},function(data){
                //closeLoadingPopup();
                var result = jQuery.parseJSON(data);
                if(result.success){
                    jQuery.post(result.redirect_link,{isAjax: true},function(data){
                        closeLoadingPopup();
                        var _data = jQuery.parseJSON(data);
                        showMess__('Register application successful. Please wait 3s to redirect. Thanks');
                        setTimeout(function(){
                            document.location = _data.redirect_link;
                        },3000);
                    });

                }else{
                    showMess__(result.message);
                }
            },'html');
        }
    }
    {/literal}
</script>
