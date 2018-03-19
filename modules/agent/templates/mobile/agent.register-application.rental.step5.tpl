<div class="register-application-title">
    <h1>Step 5. User Declaration</h1>
</div>
<div class="register-application-content">
    <form name="frmAgentTransact" id="frmAgentTransact" method="post" action="{$form_action_transact}" enctype="multipart/form-data">
        <input type="hidden" id="transact_agent_id" name="transact_agent_id" value="{$transact_agent_id}"/>
        <p>I acknowledge that by submitting this application, I am applying to lease this property</p>
        <p>I acknowledge and accept that my application is subject to the approval of the Owner (Landlord) of the property, and the availability of the property.</p>
        <p>I acknowledge that no action will be taken against the Agent, or the Owner if this application is not successful.</p>
        <p>I declare that all information contained and provided in this application is true and correct to the best of my knowledge and has been provided by me freely.</p>
        <p>If the successful applicant, I hereby offer to rent the property from the owner under a lease to be prepared by the Agent pursuant to the relevant local tenancies Act.</p>
        <p>I declare that I have inspected the property and am satisfied that the premises are in a reasonable and clean condition and I accept the premises as is.</p>
        <p>I authorise the Agent/Property Manager to obtain details of my rental references, my credit worthiness from the agent or landlord of my current and or previous residences, references from my current and previous employers, my personal and professional referees, and check any record, listing or database of defaults.</p>
        <p>
            <input id="accepted" type="checkbox" name="accepted"><label  style="display: none; color: red;margin-left: 20px" id="notify_accepted">Please check here. Thanks</label>
        </p>
        <p>I have read and accepted the above declaration.</p>
        <button type="button" class="btn-blue-transact" onclick="saveApplication('#frmAgentTransact')">
            <span><span>Save Application<span> (to edit and submit later)</span></span></span>
        </button>
        <br/>
        <br/>
        <div>
            <div class="clearthis"></div>
            <button type="button" class="btn-green-transact" onclick="submitApplication('#frmAgentTransact')">
                <span><span>Submit Application</span></span>
            </button>
        </div>
        <p>By submitting this application, you consent to all the information you have provided, including your personal information being collected, used, held and disclosed by bidRhino.com Pty Ltd in accordance with its Privacy Policy.</p>
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
function saveApplication(frm){
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
        var url = ROOTURL + '/modules/agent/action.php?action=save_application';
        jQuery.post(url,{agent_id: agent_id},function(data){
            closeLoadingPopup();
            var result = jQuery.parseJSON(data);
            if(result.success){
                showMess__('Save application successful. Please wait 3s to redirect. Thanks');
                setTimeout(function(){
                    document.location = result.redirect_link;
                },3000);
            }else{
                showMess__(result.message);
            }
        },'html');
    }
}
{/literal}
</script>