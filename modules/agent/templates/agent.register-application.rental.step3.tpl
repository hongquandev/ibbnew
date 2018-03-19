{literal}
<style type="text/css">
</style>
{/literal}
<div class="register-application-title">
    <h1>Step 3. Rental Application</h1>
</div>
<div id="register-application-step3" class="register-application-content">
    <form name="frmAgentTransact" id="frmAgentTransact" method="post" action="{$form_action_transact}" enctype="multipart/form-data">
        <input type="hidden" id="step" name="step"/>
        <input type="hidden" id="continue" name="continue" value="0"/>
        <p>To apply to rent a property you MUST complete a rental application.</p>
        <p>This application is an online application and links to your application will be sent to the Property Manager to view (or print) only, this is to enable them to be able to review and check your application and then confir with the Landlord.</p>
        <p>You may use our Online Rental Application form, or upload a scanned copy of the Agents rental application form (please note in some cases Property Managers will only allow for their Form, and not use our online application form, please check with the property manager for their preference)</p>
        <p>The more information you provide the Property Manager the easier your application can be processed</p>
        <p>Please Note : This property may be subject to an online Rental auction, depending on demand and offers, this is managed by the Managing Agent and Landlord.</p>
        <p>Before proceeding please acknowledge that you have read and accept the bidRhino terms and conditions by ticking the box
            <input style="margin-left: 5px; top:2px;position: relative" id="accepted" type="checkbox" name="accepted"><label  style="display: none; color: red;margin-left: 20px" id="notify_accepted">Please ticking the box here. Thanks</label></p>
        <label><strong>Online Application</strong></label><br/><br/>
        <button type="button" class="btn-blue-transact" onclick="editApplicationForm('#frmAgentTransact','{$link_application_form}')">
            <span><span>Open / Edit Online Application Form</span></span>
        </button>
        <br/>
        <br/>
        <label><strong>Application Form<span></span></strong></label><br/><br/>
        <div class="file-box">
            <span class="file"><input type="file" id="file_application" name="file_application"/></span>
            <span class="file-name">{$file_application}</span>
            <span class="file-action">{if $file_application}Delete{else}No file{/if}</span>
            <input class="file-delete" type="hidden" value="0" name="files_deleted[file_application]"/>
        </div>
        <br/><br/>
        <div>
            <div class="clearthis"></div>
            <button type="button" class="btn-green-transact" onclick="continueTransact('#frmAgentTransact',{$transact_step})">
                <span><span>Continue</span></span>
            </button>
        </div>
    </form>
</div>
<script type="text/javascript">
{literal}
function continueTransact(frm,transact_step){
    var isSubmit = true;
    jQuery('input[type=checkbox]',frm).each(function(){
        if(jQuery(this).attr('checked') != 'checked'){
            jQuery('#notify_'+jQuery(this).attr('id')).show();
            isSubmit = false;
        }else{
            jQuery('#notify_'+jQuery(this).attr('id')).hide();
        }
    });
    /*jQuery('input[type=file]',frm).each(function(){
        if(jQuery(this).closest('.file-box').find(".file-name").text() == ''){
            jQuery(this).closest('.file-box').find(".file-name").addClass('file-validation-fail');
            isSubmit = false;
        }else{
            jQuery(this).closest('.file-box').find(".file-name").removeClass('file-validation-fail');
        }
    });*/
    if(isSubmit){
        jQuery('#step',frm).val(transact_step);
        jQuery('#continue',frm).val(1);
        jQuery(frm).submit();
    }
}
function editApplicationForm(frm,link){
    var isSubmit = true;
    jQuery('input[type=checkbox]',frm).each(function(){
        if(jQuery(this).attr('checked') != 'checked'){
            jQuery('#notify_'+jQuery(this).attr('id')).show();
            isSubmit = false;
        }else{
            jQuery('#notify_'+jQuery(this).attr('id')).hide();
        }
    });
    if(isSubmit){
        document.location = link;
    }
}
{/literal}
</script>

