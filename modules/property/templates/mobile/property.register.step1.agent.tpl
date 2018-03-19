<script src="modules/agent/templates/js/checkcountry_register_fast.js" type="text/javascript"></script>
<div class="col-11">
    <ul class="form-list form-property">
        <li class="wide">
            <label>
                <strong id="notify_fullname">{localize translate="Manager Name"} <span>*</span></strong>
            </label>

            <div class="input-box">
                <input type="text" name="fields[agent][fullname]" id="fullname"   
                       value="{$form_data.agent.firstname} {$form_data.agent.lastname}"
                       class="input-text validate-require"/>
            </div>
        </li>

        <li class="wide">
            <label>
                <strong id="notify_street">{localize translate="Office Address"} <span>*</span></strong>
            </label>

            <div class="input-box">
                <input type="text" name="fields[company][address]" id="address"   
                       value="{$form_data.company.address}" class="input-text validate-require"/>
            </div>
        </li>
        <li class="wide">
            <label>
                <strong id="notify_personal_suburb">{localize translate="Suburb"} <span>*</span></strong>
            </label>

            <div class="input-box">
                <input type="text" name="fields[company][suburb]" id="personal_suburb"   
                       value="{$form_data.company.suburb}" class="input-text validate-require validate-letter"/>
            </div>
        </li>

        <li class="wide">
            <label>
                <strong id="notify_state">{localize translate="State"} <span>*</span></strong>
            </label>

            <div class="input-box input-select">
                <div id="inactive_personal_state">
                    <select name="company[state]" id="personal_state" class="input-select validate-number-gtzero"    style="background-image: url('../images/sprite-disabled.png');"
                            onchange="Common.validRegion('/modules/property/action.php?action=validate-property','#personal_suburb','#personal_state','#personal_postcode','#frmAgent')">
                    {html_options options = $options_state selected = $form_data.company.state}
                    </select>
                </div>
                <input type="text" id="personal_other_state" name="company[other_state]" class="input-text"
                       value="{$form_data.company.other_state}"/>
            </div>
        </li>
        <li class="wide">
            <label>
                <strong id="notify_postcode">{localize translate="Post code"} <span>*</span></strong>
            </label>

            <div class="input-box">
                <input type="text" name="fields[company][postcode]" id="postcode"   
                       value="{$form_data.company.postcode}" class="input-text validate-require validate-number"/>
            </div>
        </li>
        <li class="wide">
            <label>
                <strong id="notify_personal_country">{localize translate="Country"} <span>*</span></strong>
            </label>
            <div class="input-box">
                <select name="fields[company][country]" id="personal_country" style="background-image: url('../images/sprite-disabled.png');"
                        class="input-select select-disabled validate-number-gtzero"   
                        onchange="Common.changeCountry('/modules/general/action.php?action=get_states',this,'state')">
                {html_options options = $options_country selected = $form_data.company.country}
                </select>
            </div>
        </li>
        <li class="wide">
            <label>
                <strong id="notify_telephone">{localize translate="Telephone"} <span>*</span></strong>
            </label>

            <div class="input-box">
                <input type="text" name="fields[agent][telephone]" id="telephone"
                       value="{$form_data.company.telephone}" class="input-text validate-require validate-digits"/>
            </div>
        </li>

        <li class="wide">
            <label>
                <strong id="notify_email_address">{localize translate="Contact email"}</strong>
            </label>

            <div class="input-box">
                <input type="text" name="fields[company][email_address]" id="email_address"   
                       value="{$form_data.company.email_address}" class="input-text validate-email"/>
            </div>
        </li>
    </ul>
</div>
<div class="col-22">
    <ul class="form-list form-property">
        <li class="wide">
            <label>
                <strong id="notify_lawyer_name">{localize translate="Company name"}<span >*</span></strong>
            </label>

            <div class="input-box">
                <input type="text" name="fields[company][company_name]" id="lawyer_name"   
                       value="{$form_data.parent.company_name}" class="input-text"/>
            </div>
        </li>
        <li class="wide">
            <label>
                <strong id="notify_lawyer_address">{localize translate="Address"} <span >*</span></strong>
            </label>

            <div class="input-box">
                <input type="text" name="fields[company][address]" id="lawyer_address"   
                       value="{$form_data.parent.address}" class="input-text"/>
            </div>
        </li>
        <li class="wide">
            <label>
                <strong id="notify_company_suburb">{localize translate="Suburb"} <span>*</span></strong>
            </label>

            <div class="input-box">
                <input type="text" name="fields[company][suburb]" id="company_suburb"   
                       value="{$form_data.parent.suburb}" class="input-text validate-require validate-letter"/>
            </div>
        </li>

        <li class="wide">
            <label>
                <strong id="notify_company_state">{localize translate="State"} <span>*</span></strong>
            </label>

            <div class="input-box input-select">
                <div id="inactive_company_state">
                    <select name="fields[company][state]" id="company_state"    class="input-select validate-number-gtzero" style="background-image: url('../images/sprite-disabled.png');"
                            onchange="Common.validRegion('/modules/property/action.php?action=validate-property','#personal_suburb','#personal_state','#personal_postcode','#frmAgent')">
                    {html_options options = $options_state selected = $form_data.parent.state}
                    </select>
                </div>
                <input type="text" id="company_other_state" name="fields[company][other_state]" class="input-text"
                       style="width:97%"
                       value="{$form_data.parent.other_state}"/>
            </div>
        </li>
        <li class="wide">
            <label>
                <strong id="notify_company_postcode">{localize translate="Post code"} <span>*</span></strong>
            </label>

            <div class="input-box">
                <input type="text" name="fields[company][postcode]" id="company_postcode"   
                       value="{$form_data.parent.postcode}" class="input-text validate-require validate-number"
                      />
            </div>
        </li>
        <li class="wide">
            <label>
                <strong id="notify_company_country">{localize translate="Country"} <span>*</span></strong>
            </label>

            <div class="input-box">
                <select name="fields[company][country]" id="company_country"
                        class="input-select select-disabled validate-number-gtzero"    style="background-image: url('../images/sprite-disabled.png');"
                        onchange="Common.changeCountry('/modules/general/action.php?action=get_states',this,'state')">
                {html_options options = $options_country selected = $form_data.parent.country}
                </select>
            </div>
        </li>
        <li class="wide">
            <label>
                <strong id="notify_email">{localize translate="Email"}</strong>
            </label>

            <div class="input-box">
                <input type="text" name="fields[company][email_address]" id="email"   
                       value="{$form_data.parent.email_address}" class="input-text validate-email"/>
            </div>
        </li>
        <li class="wide">
            <label>
                <strong id="notify_website">{localize translate="Website"}</strong>
            </label>

            <div class="input-box">
                <input type="text" name="fields[company][website]" id="website"   
                       value="{$form_data.parent.website}" class="input-text validate-url"/>
            </div>
        </li>
    </ul>
</div>
<script>
    {literal}
        onLoad('personal');
        onLoad('company');
    {/literal}
</script>