{literal}
<script type="text/javascript">

</script>
<style type="text/css">
#uniform-state, #uniform-country {
	background-image: url("/modules/general/templates/images/sprite-disabled.png");
    background-repeat: no-repeat;
}
#uniform-state span, #uniform-country span{
	background-image: url("/modules/general/templates/images/sprite-disabled.png");
    background-repeat: no-repeat;
}
</style>
{/literal}
<div class="step-5-info">
    <div class="step-name">
        <h2>{localize translate="Personal Details"}</h2>
    </div>
    <div class="step-detail col2-set">
        <div class="col-1">
            <p style="text-align: justify">
                Please complete all fields on this page.
                To post your property you need to complete all details to ensure you experience a smooth, efficient and effective process in managing the auction of your property.
            </p>
            <br/>
            <p style="text-align: justify">
                We request that you enter your lawyer (or Conveyancer) details, for the same reasons.
            </p>
        </div>
        <div class="col-2 bg-f7f7f7">
            <div class="col22-set">
                {if strlen($message)>0}
                    <div class="message-box all-step-message-box">{$message}</div>
                {/if}
            
            	<form name="frmProperty" id="frmProperty" method="post" action="{$form_action}" onsubmit="return pro.isSubmit('#frmProperty')">
                {if !in_array($authentic.type,array('agent','theblock'))}
                <div class="col-11">
                    <ul class="form-list form-property">
                        <li class="wide">
                            <label>
                                <strong id="notify_fullname">{localize translate="Name"} <span >*</span></strong>
                            </label>
                            <div class="input-box">
                                <input type="text" name="fields[agent][fullname]" id="fullname"  value="{$form_data.agent.fullname}" class="input-text validate-require" />
                            </div>
                        </li>
                        <li class="wide">
                            <label>
                                <strong id="notify_titlename">{localize translate="Name on title"} <span >*</span></strong>
                            </label>
                            <div class="input-box">
                                <input type="text" name="fields[agent][titlename]" id="titlename"  value="{$form_data.agent.titlename}" class="input-text validate-require" />
                            </div>
                        </li>
                        <li class="wide">
                            <label>
                                <strong id="notify_street">{localize translate="Address"} <span >*</span></strong>
                            </label>
                            <div class="input-box">
                                <input type="text" name="fields[agent][street]" id="street"   value="{$form_data.agent.street}" class="input-text validate-require" />
                            </div>
                        </li>
                        <li class="wide">
                            <label>
                                <strong id="notify_suburb">{localize translate="Suburb"} <span >*</span></strong>
                            </label>
                            <div class="input-box">
                                <input type="text" name="fields[agent][suburb]" id="suburb"   value="{$form_data.agent.suburb}" class="input-text validate-require validate-letter"/>
                            </div>
                        </li>
                        <li class="wide">
                            <label>
                                <strong id="notify_postcode">{localize translate="Post code"} <span >*</span></strong>
                            </label>
                            <div class="input-box">
                                <input type="text" name="fields[agent][postcode]" id="postcode"   value="{$form_data.agent.postcode}" class="input-text validate-require validate-number" onchange="Common.validRegion(frmProperty.suburb,frmProperty.state,frmProperty.postcode)"/>
                            </div>
                        </li>
                        <li class="wide">
                            <label>
                                <strong id="notify_state">{localize translate="State"} <span >*</span></strong>
                            </label>
                            <div class="input-box">
                            	{if $form_data.agent.other_state != ''}
                                	<input type="text" name="fields[agent][other_state]" id="other_state"   value="{$form_data.agent.other_state}" class="input-text validate-require" />
                                {else}
                                    <select name="fields[agent][state]" id="state" class="input-select validate-number-gtzero"   onchange="Common.validRegion(frmProperty.suburb,this,frmProperty.postcode)" style="background-image: url('../images/sprite-disabled.png');">
                                        {html_options options = $options_state selected = $form_data.agent.state}
                                    </select>
                                {/if}                                
                            </div>
                        </li>
                        <li class="wide">
                            <label>
                                <strong id="notify_country">{localize translate="Country"} <span >*</span></strong>
                            </label>
                            <div class="input-box">
                            {if $form_data.agent.country != 17}
                                <select name="fields[agent][country]" id="country" class="input-select select-disabled validate-number-gtzero"   onchange="Common.changeCountry('/modules/general/action.php?action=get_states',this,'state')">
                                    {html_options options = $options_country selected = $form_data.agent.country}
                                </select>
                            {else}
                                <input type="text" name="fields[agent][other_country]" id="other_country"   value="{$form_data.agent.other_country}" class="input-text validate-require" />
                            {/if}
                             </div>
                        </li>
                        <li class="wide">
                            <label>
                                <strong id="notify_telephone">{localize translate="Telephone"}</strong>
                            </label>
                            <div class="input-box">
                                <input type="text" name="fields[agent][telephone]" id="telephone"   value="{$form_data.agent.telephone}" class="input-text validate-digits" />
                            </div>
                        </li>
                        <li class="wide">
                            <label>
                                <strong id="notify_mobilephone">{localize translate="Mobilephone"}</strong>
                            </label>
                            <div class="input-box">
                                <input type="text" name="fields[agent][mobilephone]" id="mobilephone"   value="{$form_data.agent.mobilephone}" class="input-text validate-digits" />
                            </div>
                        </li>
                        <li class="wide">
                            <label>
                                <strong id="notify_email_address">{localize translate="Email"} <span >*</span></strong>
                            </label>
                            <div class="input-box">
                                <input type="text" name="fields[agent][email_address]" id="email_address"   value="{$form_data.agent.email_address}" class="input-text validate-require validate-email" />
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-22">
                    <ul class="form-list form-property">
                        <li class="wide">
                            <label>
                                <strong id="notify_lawyer_name">{localize translate="Lawyer name"}{*<span >*</span>*}</strong>
                            </label>
                            <div class="input-box">
                                <input type="text" name="fields[lawyer][name]" id ="lawyer_name"   value="{$form_data.lawyer.name}" class="input-text"/>
                            </div>
                        </li>
                        <li class="wide">
                            <label>
                                <strong id="notify_lawyer_address">{localize translate="Lawyer address"} {*<span >*</span>*}</strong>
                            </label>
                            <div class="input-box">
                                <input type="text" name="fields[lawyer][address]" id="lawyer_address"   value="{$form_data.lawyer.address}" class="input-text"/>
                            </div>
                        </li>
                        <li class="wide">
                            <label>
                                <strong id="notify_lawyer_telephone">{localize translate="Lawyer phone"} {*<span >*</span>*}</strong>
                            </label>
                            <div class="input-box">
                                <input type="text" name="fields[lawyer][telephone]" id="lawyer_telephone"   value="{$form_data.lawyer.telephone}" class="input-text "/>
                            </div>
                        </li>
                        <li class="wide">
                            <label>
                                <strong id="notify_lawyer_company">{localize translate="Contact name"}</strong>
                            </label>
                            <div class="input-box">
                                <input type="text" name="fields[lawyer][company]" id="lawyer_company"   value="{$form_data.lawyer.company}" class="input-text" />
                            </div>
                        </li>
                        
                        <li class="wide">
                            <label>
                                <strong id="notify_allow_vendor_contact">{localize translate="Are you contactable?"} <span >*</span></strong>
                            </label>
                            <div class="input-box">
                                <select name="fields[agent][allow_vendor_contact]" id="allow_vendor_contact" class="input-select validate-number-gtzero">
                                    {html_options options = $options_contactable selected = $form_data.agent.allow_vendor_contact}
                                </select>                            
                            </div>
                        </li>
                        <li class="wide">
                            <label>
                                <strong id="notify_preferred_contact_method">{localize translate="Preferred contact (email/mobile/phone)"} <span >*</span></strong>
                            </label>
                            <div class="input-box">
                                <select name="fields[agent][preferred_contact_method]" id="preferred_contact_method" class="input-select validate-number-gtzero">
                                    {html_options options = $options_contact_method selected = $form_data.agent.preferred_contact_method}
                                </select>                   
                            </div>
                        </li>
                        <li class="wide">
                            <label>
                                <strong id="notify_license_number">{localize translate="Drivers License Number/Medicare Card No."}</strong>
                            </label>
                            <div class="input-box">
                                <input type="text" name="fields[agent][license_number]" id="license_number"   value="{$form_data.agent.license_number}" class="input-text" />
                            </div>
                        </li>
                    </ul>
                </div>
                {else}
                    {include file="property.register.step1.agent.tpl"}
                {/if}
                    <input type="hidden" name="fields[package_id]" value="{$form_data.package_id}"/>
                	<input type="hidden" name="track" id="track" value="0"/>
                    <input type="hidden" name="is_submit2" id="is_submit2" value="0"/>
                </form>
                <div class="clearthis"></div>
                <script type="text/javascript">pro.is_submit = 'is_submit2';</script>
            </div>
            <div class="buttons-set">
                <button class="btn-red btn-red-personal-details" onclick="pro.submit('#frmProperty',true)">
                    <span><span>{localize translate=""}Save</span></span>
                </button>
                 <button class="btn-red btn-red-personal-details" onclick="pro.submit('#frmProperty')">
                    <span><span>{localize translate=""}Next</span></span>
                </button>
            </div>
        </div>
        <div class="clearthis">
        </div>
    </div>
</div>
