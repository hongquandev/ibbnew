<div class="step-5-info">
<div class="step-name">
    <h2>{localize translate="Confirm"}</h2>
    <p style="padding: 0px 10px 10px 0px;text-align: justify">
        This page provides you a chance to review and confirm all the details you have just entered, to ensure it is correct and you have entered all required details, please review and confirm your details to complete your account registration.
    </p>
</div>
<div class="step-detail">
<div class="col-2 bg-f7f7f7">
{if in_array($type,array('vendor','buyer'))}
<div>
    <form name="frmAgent" id ="frmAgent" method = "post" action = "{$form_action}">

        {if isset($message) and strlen($message)>0}
            <div class="message-box">{$message}</div>
        {/if}
        <div class="confirm-box">
            <h4>{localize translate="PERSONAL DETAILS"}</h4>
            <div>
                {if isset($agent_row) and is_array($agent_row) and count($agent_row)>0}
                    <p><strong>{localize translate="Full name"}:</strong> {$agent_row.firstname} {$agent_row.lastname}</p>
                    <p><strong>{localize translate="Email"}:</strong> <a href="mailto:{$agent_row.email_address}">{$agent_row.email_address}</a></p>
                    <p><strong>{localize translate="Telephone"}:</strong> {$agent_row.telephone}</p>
                    <p><strong>{localize translate="Mobilephone"}:</strong> {$agent_row.mobilephone}</p>
                    <p><strong>{localize translate="Address"}:</strong> {$agent_row.street}, {$agent_row.suburb} {$agent_row.state_name} {$agent_row.postcode} {$agent_row.country_name}
                    </p>
                    <p><strong>{localize translate="Security question"}:</strong>
                        {if $agent_row.security_question == 0 } N/A{else} {$options_question[$agent_row.security_question]}{/if}
                        <i>{$agent_row.security_answer}</i>
                    </p>

                {/if}
            </div>
        </div>
        <div class="confirm-box">
            <h4>{localize translate="LAWYER DETAILS"}</h4>
            <div>
                {if isset($agent_lawyer_row) and is_array($agent_lawyer_row) and count($agent_lawyer_row)>0}
                    <p>
                        <strong>{localize translate="Full name"}:</strong> {$agent_lawyer_row.name}
                    </p>
                    <p>
                        <strong>{localize translate="Email"}:</strong> <a href="mailto:{$agent_lawyer_row.email}">{$agent_lawyer_row.email}</a>
                    </p>
                    <p>
                        <strong>{localize translate="Telephone"}:</strong> {$agent_lawyer_row.telephone}
                    </p>
                    <p>
                        <strong>{localize translate="Mobilephone"}:</strong> {$agent_lawyer_row.mobilephone}
                    </p>
                    <p>
                        <strong>{localize translate="Address"}:</strong> {$agent_lawyer_row.address}, {$agent_lawyer_row.suburb} {$agent_lawyer_row.state_name} {$agent_lawyer_row.postcode} {$agent_lawyer_row.country_name}
                    </p>
                {/if}
            </div>
        </div>
        <div class="confirm-box">
            <h4>{localize translate="CONTACT DETAILS"}</h4>
            <div>
                {if isset($agent_contact_row) and is_array($agent_contact_row) and count($agent_contact_row)>0}
                    <p>
                        <strong>{localize translate="Full name"}:</strong> {$agent_contact_row.name}
                    </p>
                    <p>
                        <strong>{localize translate="Email"}:</strong> <a href="mailto:{$agent_contact_row.email}">{$agent_contact_row.email}</a>
                    </p>
                    <p>
                        <strong>{localize translate="Telephone"}:</strong> {$agent_contact_row.telephone}
                    </p>
                    <p>
                        <strong>{localize translate="Mobilephone"}:</strong> {$agent_contact_row.mobilephone}
                    </p>
                    <p>
                        <strong>{localize translate="Address"}:</strong> {$agent_contact_row.address}, {$agent_contact_row.suburb} {$agent_contact_row.state_name} {$agent_contact_row.postcode} {$agent_contact_row.country_name}
                    </p>

                {/if}
            </div>
        </div>
{*        <div class="confirm-box" style="display: none;">*}
{*        {*<h4>CC DETAILS</h4>*}
{*            <div>*}
{*                {if isset($agent_creditcard_row) and is_array($agent_creditcard_row) and count($agent_creditcard_row)>0}*}
{*                    <p>*}
{*                        Card type: {$options_card_type[$agent_creditcard_row.card_type]}*}
{*                    </p>*}
{*                    <p>*}
{*                        Name on Card: {$agent_creditcard_row.card_name}*}
{*                    </p>*}
{*                {**}
{*                <p>*}
{*                    Billing address: {$agent_creditcard_row.billing_address}*}
{*                </p>*}
{*                *}
{*                    <p>*}
{*                        Credit card number: {$agent_creditcard_row.card_number}*}
{*                    </p>*}
{*                {**}
{*                <p>*}
{*                    Security code: {$agent_creditcard_row.security_code}*}
{*                </p>*}
{*                *}
{*                {/if}*}
{*            </div>*}
{*        </div>*}

    </form>
</div>
{elseif $type == 'partner' } <!-- IF AGENT REGISTER IS PARTNER -->
<div>
    <form name="frmAgent" id ="frmAgent" method = "post" action = "{$form_action}">
        {if isset($message) and strlen($message)>0}
            <div class="message-box">{$message}</div>
        {/if}
        <div class="confirm-box">
            <h4>{localize translate="COMPANY DETAILS"}</h4>
            <div>
                {if isset($agent_row) and is_array($agent_row) and count($agent_row)>0}
                    <p><strong>{localize translate="Company Name"}:</strong> {$agent_row.firstname}</p>
                    <p><strong>{localize translate="Website"}:</strong> <a href="{$agent_row.website_partner}" class="link" target="_blank">{$agent_row.website_partner}</a></p>
                    <p><strong>{localize translate="Company Address"}:</strong> {$agent_row.street}, {$agent_row.suburb} {$agent_row.state_name} {$agent_row.postcode} {$agent_row.country_name}</p>
                    <p><strong>{localize translate="Company Email"}:</strong> <a href="mailto:{$agent_row.general_contact_partner}">{$agent_row.general_contact_partner}</a></p>
                    <p><strong>{localize translate="Company Telephone"}:</strong> {$agent_row.telephone}</p>
                    <br />
                    <p><strong>{localize translate="Contact Email Address"}:</strong> <a href="mailto:{$agent_row.email_address}">{$agent_row.email_address}</a></p>
                    <p>
                        <strong>{localize translate="Security question"}:</strong> {$options_question[$agent_row.security_question]}
                        <i>({$agent_row.security_answer})</i>
                    </p>
                {/if}
            </div>
        </div>

        <div class="confirm-box">
            <h4>{localize translate="EXTRA COMPANY INFORMATION"} </h4>
            <div>
                {if isset($partner_row) and is_array($partner_row) and count($partner_row)>0}
                    <p><strong>{localize translate="Company Or Bussiness Register Number"}:</strong> {$partner_row.register_number}</p>

                    <p><strong>{localize translate="Postal Address"}:</strong> {$partner_row.postal_address}, {$partner_row.postal_suburb} {$partner_row.postal_state_code} {$partner_row.postal_postcode} {$partner_row.postal_country_name}</p>
                    <p><strong>{localize translate="Logo"}:</strong></p>
                    <img src="{$MEDIAURL}/store/uploads/banner/images/partner/{$partner_row.partner_logo}" alt="{$partner_row.partner_logo}"/>
                    <p><strong>{localize translate="Description"}:</strong></p>
                    <p>{$partner_row.description}</p>
                {/if}
            </div>
        </div>
{*        <div class="confirm-box">*}
{*            <h4>CC DETAILS</h4>*}
{*            <div>*}
{*                {if isset($agent_creditcard_row) and is_array($agent_creditcard_row) and count($agent_creditcard_row)>0}*}
{*                    <p>*}
{*                        Card type: {$options_card_type[$agent_creditcard_row.card_type]}*}
{*                    </p>*}
{*                    <p>*}
{*                        Name on Card: {$agent_creditcard_row.card_name}*}
{*                    </p>*}
{*                {**}
{*                <p>*}
{*                    Billing address: {$agent_creditcard_row.billing_address}*}
{*                </p>*}
{*                *}
{*                    <p>*}
{*                        Credit card number: {$agent_creditcard_row.card_number}*}
{*                    </p>*}
{*                {**}
{*                <p>*}
{*                    Security code: {$agent_creditcard_row.security_code}*}
{*                </p>*}
{*                *}
{*                {/if}*}
{*            </div>*}
{*        </div>*}

    </form>
</div>
{elseif $type == 'agent'}
<div>
    <form name="frmAgent" id="frmAgent" method="post" action="{$form_action}">
        {if isset($message) and strlen($message)>0}
            <div class="message-box">{$message}</div>
        {/if}
        <div class="confirm-box">
            <h4>{localize translate="ACCOUNT INFORMATION"}</h4>

            <div>
                {if isset($agent_row) and is_array($agent_row) and count($agent_row)>0}
                    <p><strong>{localize translate="Full Name"}:</strong> {$agent_row.firstname} {$agent_row.lastname}</p>
                    <p><strong>{localize translate="Contact Email Address"}:</strong>
                        <a href="mailto:{$agent_row.email_address}">{$agent_row.email_address}</a></p>
                    <p>
                        <strong>{localize translate="Security question"}:</strong>{if $agent_row.security_question == 0 } N/A{else} {$options_question[$agent_row.security_question]}{/if}
                        <i>{$agent_row.security_answer}</i>
                    </p>
                {/if}
            </div>
        </div>

        <div class="confirm-box">
            <h4>{localize translate="COMPANY INFORMATION"}</h4>
            <div>
                {if isset($company_row) and is_array($company_row) and count($company_row)>0}
                    <p><strong>{localize translate="Company Name"}:</strong> {$company_row.company_name}</p>
                    <p><strong>{localize translate="ABN / ACN"}:</strong> {$company_row.abn}</p>

                    <p><strong>{localize translate="Address"}:</strong> {$company_row.address}
                        , {$company_row.suburb} {$company_row.state_code} {$company_row.other_state} {$company_row.postcode} {$company_row.country_name}
                    </p>
                    <p><strong>{localize translate="Website"}:</strong>
                        {$company_row.website}
                    </p>
                    <p><strong>{localize translate="Company Email"}:</strong>
                        {$company_row.email_address}
                    </p>
                    <p><strong>{localize translate="Description"}:</strong></p>

                    <p>{$company_row.description}</p>
                {/if}
            </div>
        </div>

    </form>
</div>
{/if} <!-- IF AGENT REGISTER IS NOT PARTNER -->

<div class="clearthis"></div>
<div class="buttons-set">
    {if $type == 'agent'}
    	<!--
        <button class="btn-red btn-red-re-buyer2" onclick="agent.step('#frmAgent')">
            <span><span>Next</span></span>
        </button>
        -->
        <button class="btn-blue" onclick="agent.step('#frmAgent')">
            <span><span>{localize translate="Next"}</span></span>
        </button>
        
    {else}
    	<!--
        <button class="btn-red btn-red-re-buyer2" onclick="agent.step('#frmAgent')">
            <span><span>Finish</span></span>
        </button>
        -->
        <button class="btn-blue" onclick="agent.step('#frmAgent')">
            <span><span>{localize translate="Finish"}</span></span>
        </button>
        
    {/if}

</div>
</div>
<div class="clearthis"></div>
</div>
</div>