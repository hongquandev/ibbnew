<script src="modules/agent/templates/js/checkcountry_register_fast.js" type="text/javascript"></script>
{literal}

<script type="text/javascript">
jQuery(document).ready(function(){
    onLoad('personal');
    $('#personal_country').bind('change',function(){
        onLoad('personal');
    })
});
var RecaptchaOptions = {
    theme:'white'
};

//$(function() {
    //$('#tooltip_reg').tipsy({gravity: 's',html: true,fallback: "<div style='text-align: justify;padding: 5px;'>Basic registration allows you to log in and maintain a watch list of properties you like. To post a property for sale, register to bid or communicate with Agents / vendors, you will need to complete the full registration process.<div>"});
//});

var search_overlay = new Search();
search_overlay._frm = '#frmAgent';
search_overlay._text_search = '#personal_suburb';
search_overlay._text_obj_1 = '#personal_state';
search_overlay._text_obj_2 = '#personal_postcode';
search_overlay._overlay_container = '#search_overlay';
search_overlay._url_suff = '&' + 'type=suburb';

search_overlay._success = function (data) {
    var info = jQuery.parseJSON(data);
    var content_str = "";
    var id = 0;
    if (info.length > 0) {
        search_overlay._total = info.length;
        for (i = 0; i < info.length; i++) {
            var id = 'sitem_' + i;
            content_str += "<li onclick='search_overlay.setValue(this)' id=" + id + ">" + info[i] + "</li>";
            search_overlay._item.push(id);
        }
    }

    search_overlay._getValue = function (data) {
        var info = jQuery.parseJSON(data);
        jQuery(search_overlay._text_obj_1).val(info[0]);
        $('#uniform-personal_state span').html($(search_overlay._text_obj_1 + " option:selected").text());


    };

    if (content_str.length > 0) {
        jQuery(search_overlay._overlay_container).html(content_str);
        jQuery(search_overlay._overlay_container).show();
        jQuery(search_overlay._overlay_container).width(jQuery(search_overlay._text_search).width());
    } else {
        jQuery(search_overlay._overlay_container).hide();
    }
	jQuery(search_overlay._text_search).removeClass('search_loading');
};

document.onclick = function () {
    search_overlay.closeOverlay()
};

{/literal}
</script>
 
<div class="step-1-info">
<div class="step-name">
    {if in_array($type,array('vendor','buyer'))}
        <h2>Personal Details</h2>
    {elseif $type == 'partner'}
        <h2>Company Details</h2>
    {elseif $type == 'agent'}
        <h2>Account Info</h2>
    {/if}
    {if in_array($type,array('vendor','buyer'))}
        <p class="p-jus-register">
            Please complete all fields on this page.
            We request all your contact details to ensure that all members are valid, and to enable the simplification of the process for you to register to bid or post properties on our site.
        </p>
    {elseif $type == 'partner'}
        <p class="p-jus-register">
            To register as an advertiser on bidRhino.com, please complete all fields on this page.
        </p>
    {elseif $type == 'agent'}
        <p style="text-align: justify">
            To register as an Agent, and use eBidda Agent, the online bidding service, please complete all details on this and the following pages.
        </p>
        <br/>
        <p>
            Each REA office requires to register an iBB account and can have 5 users per account.
        </p>
    {/if}
</div>
<div class="step-detail col2-set">
{if in_array($type,array('vendor','buyer'))} <!-- BEGIN CHECK AGENT REGISTER CHOOSE VENDOR OR BUYER OR PARTNER -->
<br/>
<div class="bg-f7f7f7">
<ul class="form-list form-register">
<form name="frmAgent" id="frmAgent" method="post" action="{$form_action}">
    {if isset($message) and strlen($message)>0}
    <div class="message-box message-box-v-ie">
        {$message}
    </div>
    {/if}

<li class="fields">
    <div class="field">
        <label>
            <strong id="notify_firstname">First Name <span>*</span></strong>
        </label>

        <div class="input-box">
            <input type="text" name="firstname" id="firstname" value="{$form_datas.firstname}"
                   class="input-text validate-require" autocomplete="off"/>
        </div>
    </div>
    <div class="field">
        <label>
            <strong id="notify_lastname">Surname<span>*</span></strong>
        </label>

        <div class="input-box">
            <input type="text" name="lastname" id="lastname" value="{$form_datas.lastname}"
                   class="input-text validate-require" autocomplete="off"/>
        </div>
    </div>
    <div class="clearthis">
    </div>
</li>
<li class="wide">
    <label>
        <strong id="notify_street">Street Address <span></span></strong>
    </label>

    <div class="input-box">
        <input type="text" name="street" id="street" value="{$form_datas.street}" class="input-text"
               autocomplete="off"/>
    </div>
</li>
<li class="fields">

    <div class="field">
        <label>
            <strong id="notify_suburb">Suburb <span></span></strong>
        </label>

        <div class="input-box">
            <input type="text" name="suburb" id="personal_suburb" value="{$form_datas.suburb}"
                   class="input-text" onclick="search_overlay.getData(this)"
                   onkeyup="search_overlay.moveByKey(event)" autocomplete="off"/>
            <ul>
                <div id="search_overlay" class="search_overlay" style="display:none; position: absolute;">
                </div>
            </ul>
        </div>
    </div>

    <div class="field">
        <label>
            <strong id="notify_postcode">Postcode <span></span></strong>
        </label>

        <div class="input-box">
            <input type="text" name="postcode" id="personal_postcode" value="{$form_datas.postcode}"
                   class="input-text"
                   onkeyup="Common.validRegion('/modules/property/action.php?action=validate-property','#personal_suburb','#personal_state','#personal_postcode','#frmAgent','#personal_country')"
                   autocomplete="off"/>
        </div>
    </div>

    <!-- Input -->


</li>
<li class="fields">
    <div class="field">
        <label>
            <strong id="notify_state">State <span></span></strong>
        </label>

        <div class="field">
            <div id="inactive_personal_state">
                <select id="personal_state" name="state" style="z-index:999;"
                        onchange="Common.validRegion('/modules/property/action.php?action=validate-property','#personal_suburb','#personal_state','#personal_postcode','#frmAgent')">
                    {html_options options = $options_state selected = $form_datas.state}
                </select>
            </div>
            <input type="text" id="personal_other_state" class="input-text" name="other_state"
                   value="{$form_datas.other_state}" style="display: none;  "/>
        </div>
    </div>
    <div class="field" id="inactive_country">
        <label>
            <strong id="notify_country">Country <span></span></strong>
        </label>

        <div class="input-box">
            <select name="country" id="personal_country" class="" style="z-index:999;">
                {html_options options = $options_country selected = $form_datas.country}
            </select>

        </div>
    </div>
    <div class="clearthis">
    </div>
</li>
<li class="fields">
    {*<div class="field">
        <label>
            <strong id="notify_telephone">Telephone</strong>
        </label>

        <div class="input-box">
            <input type="text" name="telephone" id="personal_telephone" value="{$form_datas.telephone}"
                   class="input-text validate-telephone" autocomplete="off"/>
        </div>
    </div>*}
    <div class="field">
        <label>
            <strong id="notify_mobilephone">Phone</strong>
        </label>

        <div class="input-box">
            <input type="text" name="mobilephone" id="personal_mobilephone" value="{$form_datas.mobilephone}"
                   class="input-text validate-telephone" autocomplete="off"/>
        </div>
    </div>
    <div class="clearthis">
    </div>
</li>
<li class="wide">
    <label>
        <strong id="notify_email_address">Email <span>*</span></strong>
    </label>

    <div class="input-box">
        <input type="text" name="email_address" id="email_address" style="text-transform:lowercase;" value="{$form_datas.email_address}"
               class="input-text validate-require validate-email"
               onkeyup="Common.existEmail('/modules/{$module}/action.php?action=exist_email',this,{$agent_id})"
               autocomplete="off"/>
    </div>
</li>
<!-- Confirm Email -->
<li class="wide">
    <label>
        <strong id="notify_confirm_email_address">Confirm Email <span>*</span></strong>
    </label>

    <div class="input-box">
        <input type="text" name="confirm_email_address" id="confirm_email_address"  style="text-transform:lowercase;" value=""
               class="input-text validate-require validate-email"
               autocomplete="off"/>
    </div>
</li>
{*<li class="wide">
    <label>
        <strong id="notify_license_number">Drivers License Number/Medicare Card No.</strong>
    </label>

    <div class="input-box">
        <input type="text" name="license_number" id="personal_license_number" value="{$form_datas.license_number}"
               class="input-text *}{*validate-require*}{* validate-license" autocomplete="off"/>
    </div>
    <small>*We accept only number, not character</small>
</li>*}
{*<li class="control">

    <label for="allow_vendor_contact">
        <strong>Can agents contact you?</strong>
    </label>

    <div class="input-box">
        <select name="allow_vendor_contact" id="allow_vendor_contact"  style="z-index:999;">
            {html_options options = $options_yes_no selected = $form_datas.allow_vendor_contact }
        </select>
    </div>
</li>*}

{*<li class="control">
    <label>
        <strong id="notify_preferred_contact_method">Preferred contact method <span>*</span></strong>
    </label>

    <div class="input-box">
        <select name="preferred_contact_method" id="preferred_contact_method"
                class="  validate-number-gtzero" style="z-index:999;">
            {html_options options = $options_method selected = $form_datas.preferred_contact_method }
        </select>
    </div>
</li>*}
<li class="wide">
    <div class="field">
        <label>
            <strong id="notify_password">Account Password <span>*</span></strong>
            <br>
            <small style="font-weight: bold; font-style: italic;"> (For logging in to your site account)</small>
        </label>

        <div class="input-box">
            <input type="password" name="password" id="password" value="{$form_datas.password}"
                   class="input-text validate-require" AUTOCOMPLETE="off"/>
        </div>
    </div>
</li>
<li class="wide">
    <div class="field" style="">
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

<li class="control">
    <label>
        <strong id="notify_security_question">Security question <span></span></strong>
    </label>

    <div class="input-box">
        <select name="security_question" id="security_question" style="z-index:999;" class="{*  validate-number-gtzero*}">
            {html_options options = $options_question selected = $form_datas.security_question}
        </select>
        <a href="javascript:void(0)" style="float:right;margin: 3px 5px;" onclick="agent.showSQ()">Add new question</a>

        <div id="question_container" style="display:none">
            <div id="msg_question" style="color:#FF0000"></div>
            <input type="text" name="new_question" id="new_question" class="input-text" style="width:80%; margin-top:10px;"/>
            <input style="margin-top: 3px;" type="button" value="Save" onclick="agent.saveSQ()"/><span
                id="loading_question" style="display:none;">loading...</span>

        </div>
    </div>
</li>
<li class="wide">
    <label>
        <strong id="notify_asecurity_answer">Answer <span></span></strong>
    </label>

    <div class="input-box">
        <input type="text" name="security_answer" id="security_answer" value="{$form_datas.security_answer}"
               class="input-text {*validate-require*}" onKeyPress="return submitenter(this,event)" autocomplete="off"/>
        <input type="hidden" name="sign" id="sign" value=""/>

    </div>
</li>
<li class="wide">
    {*{if $captcha_enable == 1}
        <center>
            {$captcha_form}
        </center>
    {/if}*}
    {literal}
        <script type="text/javascript">
            var verifyCallback = function(response) {
                //alert(response);
                jQuery('#response').val(response);
            };
            var onloadCallback = function() {
                grecaptcha.render('html_element', {
                    //'sitekey' : '6Lei0gcTAAAAAI3GKVkfmft1UkOzOxJ0RSeUXYGW',
                    //'sitekey' : '6LfMsBITAAAAAFFfNhYvNjegpW19iAT5l9MbtGiz',
                    'sitekey' : '{/literal}{$captcha_public_key}{literal}',
                    'callback' : verifyCallback
                });
            };
        </script>
    {/literal}
    <input type="hidden" name="response" value="" id="response">
    <input type="hidden" name="recaptcha_version" id="recaptcha_version" value="v2"/>
    <div id="html_element"></div>
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
            async defer>
    </script>
</li>
<li class="wide">
    {assign var="checked" value=""}
    {if $form_datas.auto_update_contact == 1}
        {assign var="checked" value="checked"}
    {/if}
    <input type="checkbox" name="auto_update_contact" {$checked}/>
    <label>
        <strong id=""> Auto update My Personal Details to My contact details <span> </span></strong>
    </label>
</li>
</form>
</ul>
     <div class="clearthis">
    </div>
<div class="buttons-set">
    <button class="btn-red f-right btn-red-register-step1" onclick="agent.step('#frmAgent')">
        <span><span>Next</span></span>
    </button>
    {assign var="title" value="<div style='text-align: justify;padding: 5px;'>Basic registration allows you to log in and maintain a watch list of properties you like. To post a property for sale, register to bid or communicate with Agents / vendors, you will need to complete the full registration process.<div>"}
     
        <button id="tooltip_reg" class="btn-gray f-right" style="margin-right:10px" onclick="agent.step('#frmAgent','finish')">
            <span><span>Finish Basic Registration</span></span>
        </button>
     
    <div class="clearthis">
    </div>
</div>
</div>

{elseif $type == 'partner'} <!-- IF REGISTER IS  PARTNER -->
    {include file='partner.register.step1.tpl'}
{elseif $type == 'agent'}
    {include file='agent.auction.register.step1.tpl'}
{/if}

<div class="clearthis">
</div>
</div>
</div>
{literal}
<script >  
      
           
    function submitenter(myfield, e) {
        /*var keycode;
        if (window.event) keycode = window.event.keyCode;
        else if (e) keycode = e.which;
        else return true;

        if (keycode == 13)
           {
               myfield.form.submit();
               return false;
           }
        else
        {
           return true;
        }*/

        return true;
    }
        
        
</script>

{/literal}
 
