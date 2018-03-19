{literal}
<script type="text/javascript">
    $(function() {
        $('#tooltip_reg_basic').tipsy({gravity: 's',html: true,fallback: "<div style='text-align: justify;padding: 5px;'>Basic registration allows you to log in and maintain a watch list of properties you like. To post a property for sale, register to bid or communicate with Agents / vendors, you will need to complete the full registration process.<div>"});
    });
</script>
{/literal}
<div class="register-partner">
<ul class="form-list form-register">
<form name="frmAgent" id="frmAgent" method="post" action="{$form_action}">
    {if isset($message) and strlen($message)>0}
    <div class="message-box message-box-v-ie">
        {$message}
    </div>
    {/if}

<li class="wide">

    <label>
        <strong id="notify_firstname">Company Name <span>*</span></strong>
    </label>

    <div class="input-box">
        <input type="text" name="firstname" id="firstname" value="{$form_datas.firstname}"
               class="input-text validate-require" autocomplete="off"/>
    </div>

    <div class="clearthis">
    </div>
</li>
<li class="wide">
    <label>
        <strong id="notify_street"> Company Address <span>*</span></strong>
    </label>

    <div class="input-box">
        <input type="text" name="street" id="street" value="{$form_datas.street}" class="input-text validate-require"
               autocomplete="off"/>
    </div>
</li>
<!--add new General contact and Website-->
<li class="fields">

    <div class="field">
        <label>
            <strong id="notify_suburb">Suburb <span>*</span></strong>
        </label>

        <div class="input-box">
            <input type="text" name="suburb" id="personal_suburb" value="{$form_datas.suburb}"
                   class="input-text validate-require validate-letter" onclick="search_overlay.getData(this)"
                   onkeyup="search_overlay.moveByKey(event)" autocomplete="off"/>
            <ul>
                <div id="search_overlay" class="search_overlay" style="display:none; position: absolute;"></div>
            </ul>
        </div>
    </div>

    <div class="field" style="float:right">
        <label>
            <strong id="notify_postcode">Postcode <span>*</span></strong>
        </label>

        <div class="input-box">
            <input type="text" name="postcode" id="personal_postcode" value="{$form_datas.postcode}"
                   class="input-text validate-require validate-postcode"
                   onchange="Common.validRegion('/modules/property/action.php?action=validate-property','#personal_suburb','#personal_state',this,'#frmAgent','#personal_country')"
                   autocomplete="off"/>
        </div>
    </div>


</li>
<!--end add new General contact and Website-->
<li class="fields">
    <div class="field" id="inactive_state">
        <label>
            <strong id="notify_state">State <span>*</span></strong>
        </label>

        <div class="input-box input-select">
            <div id="inactive_personal_state">
                <select id="personal_state" name="state"
                        class="input-select"
                        onchange="Common.validRegion('/modules/property/action.php?action=validate-property','#personal_suburb','#personal_state','#personal_postcode','#frmAgent')">
                    {html_options options = $options_state selected = $form_datas.state}
                </select>
            </div>
            <input type="text" id="personal_other_state" class="input-text" name="other_state"
                   value="{$form_datas.other_state}"/>
        </div>
    </div>
    <div class="field" style="float:right">
        <label>
            <strong id="notify_country">Country <span>*</span></strong>
        </label>

        <div class="input-box">
            <select name="country" id="personal_country" class="input-select validate-number-gtzero"
                    onchange="onReloadPartner(this.form)">
                {html_options options = $options_country selected = $form_datas.country}
            </select>
        </div>
    </div>
    <div class="clearthis">
    </div>
</li>
<li class="wide" style="padding-top: 10px;">

    <label>
        <strong id="notify_telephone">Company Telephone <span>*</span></strong>
    </label>

    <div class="input-box">
        <!-- <input type="text" name="telephone" id="" value="{$form_datas.telephone}" class="input-text validate-require validate-telephone" autocomplete="off"/> -->
        <input type="text" name="telephone" id="personal_telephone" value="{$form_datas.telephone}"
               class="input-text validate-require validate-telephone" autocomplete="off"/>
    </div>

    <div class="clearthis">
    </div>
</li>
<li class="wide">
    <label>
        <strong id="notify_email_address">Contact Email Address <span>*</span></strong>
    </label>

    <div class="input-box">
        <input type="text" name="email_address" id="email_address" value="{$form_datas.email_address}"
               class="input-text validate-require validate-email"
               onkeyup="Common.existEmail('/modules/{$module}/action.php?action=exist_email',this)" autocomplete="off"/>
    </div>
</li>
<!-- Confirm Email -->
<li class="wide">
    <label>
        <strong id="notify_confirm_email_address">Confirm Email Address <span>*</span></strong>
    </label>

    <div class="input-box">
        <input type="text" name="confirm_email_address" id="confirm_email_address" value=""
               class="input-text validate-require validate-email"
               autocomplete="off"/>
    </div>
</li>

<li class="wide">
    <label>
        <strong id="notify_general_contact_partner">Company Email</strong>
    </label>

    <div class="input-box">
        <input type="text" name="general_contact_partner" id="general_contact_partner" value="{$form_datas.general_contact_partner}" class="input-text validate-email"
               autocomplete="off"/>
    </div>
</li>
<li class="wide">
    <label>
        <strong id="notify_website_partner">Website</strong>
    </label>

    <div class="input-box">
        <input type="text" name="website_partner" id="website_partner" value="{$form_datas.website_partner}" class="input-text validate-url"
               autocomplete="off"/>
    </div>
</li>

<li class="fields">
    <div class="field">
        <label>
            <strong id="notify_password">Password <span>*</span></strong>
        </label>

        <div class="input-box">
            <input type="password" name="password" id="password" value="{$form_datas.password}"
                   class="input-text validate-require" AUTOCOMPLETE="off"/>
        </div>
    </div>
    <div class="field" style="float:right">
        <label>
            <strong id="notify_password2">Verify password <span>*</span></strong>
        </label>

        <div class="input-box">
            <input type="password" name="password2" id="password2" value="{$form_datas.password2}"
                   class="input-text validate-require" AUTOCOMPLETE="off"/>
        </div>
    </div>
    <div class="clearthis">
    </div>
</li>
<li class="wide">
    <label>
        <strong id="notify_security_question">Security question <span>*</span></strong>
    </label>

    <div class="input-box">
        <select name="security_question" id="security_question" class="input-select validate-number-gtzero">
            {html_options options = $options_question selected = $form_datas.security_question}
        </select>
        <a href="javascript:void(0)" style="float:right;margin: 3px 0px;" onclick="agent.showSQ()">Add new question</a>

        <div id="question_container" style="display:none">
            <div id="msg_question" style="color:#FF0000"></div>
            <input type="text" name="new_question" id="new_question" class="input-text"/>
            <input type="button" value="Save" onclick="agent.saveSQ()" style="margin-top: 3px;padding: 2px 3px;"/><span
                id="loading_question" style="display:none;">loading...</span>
        </div>

    </div>
</li>
<li class="wide">
    <label>
        <strong id="notify_asecurity_answer">Answer <span>*</span></strong>
    </label>

    <div class="input-box">
        <input type="text" name="security_answer" id="security_answer" value="{$form_datas.security_answer}"
               class="input-text validate-require" onKeyPress="return submitenter(this,event)" autocomplete="off"/>
        <input type="hidden" name="sign" id="sign" value=""/>

        {if $captcha_enable == 1}
            <center>
                <div id="captcha_step1">
                    {$captcha_form}
                </div>
            </center>
        {/if}
    </div>
</li>
</form>
</ul>

<div class="clearthis"></div>
<div class="buttons-set" style="padding-right: 38px;">
    <button class="btn-gray" onclick="agent.step('#frmAgent','finish')" style="position:relative;">
        <span><span>Finish basic registration</span></span>
    </button>

    <button class="btn-blue" onclick="agent.step('#frmAgent')" style="position:relative;left:1px;">
        <span><span>Next for full registration</span></span>
    </button>
    <div class="clearthis"></div>
</div>
</div>