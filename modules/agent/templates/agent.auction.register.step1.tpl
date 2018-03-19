{literal}
<script type="text/javascript">
    $(function() {
        $('#tooltip_reg').tipsy({gravity: 's',html: true,fallback: "<div style='text-align: justify;padding: 5px;'>Basic registration allows you to log in and maintain a watch list of properties you like. To post a property for sale, register to bid or communicate with Agents / vendors, you will need to complete the full registration process.<div>"});
    });
</script>
{/literal}
<div>
<ul class="form-list form-register">
<form name="frmAgent" id="frmAgent" method="post" action="{$form_action}">
{if isset($message) and strlen($message)>0}
<div class="message-box message-box-v-ie">
    {$message}
</div>
{/if}
{$package_tpl}
<li class="fields">
    <div class="field">
        <label><strong id="notify_firstname">First Name <span>*</span></strong></label>

        <div class="input-box">
            <input type="text" name="firstname" id="firstname" value="{$form_datas.firstname}"
                   class="input-text validate-require" autocomplete="off"/>
        </div>
    </div>
    <div class="field" style="float:right">
        <label><strong id="notify_lastname">Surname<span>*</span></strong></label>
        <div class="input-box">
            <input type="text" name="lastname" id="lastname" value="{$form_datas.lastname}"
                   class="input-text validate-require" autocomplete="off"/>
        </div>
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
        <strong id="notify_security_question">Security question <span></span></strong>
    </label>

    <div class="input-box">
        <select name="security_question" id="security_question" class="input-select">
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
        <strong id="notify_asecurity_answer">Answer <span></span></strong>
    </label>

    <div class="input-box">
        <input type="text" name="security_answer" id="security_answer" value="{$form_datas.security_answer}"
               class="input-text" onKeyPress="return submitenter(this,event)" autocomplete="off"/>
        <input type="hidden" name="sign" id="sign" value=""/>

    {if $captcha_enable == 1}
        {*<center>
            <div id="captcha_step1">
                {$captcha_form}
            </div>
        </center>*}
    {literal}
        <script type="text/javascript">
            var verifyCallback = function(response) {
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
        <center>
            <div id="html_element"></div>
        </center>
        <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
                async defer>
        </script>
    {/if}
    </div>
</li>
</form>
</ul>
<div class="buttons-set" style="padding-right: 38px;">
    <button class="btn-blue" onclick="agent.step('#frmAgent')">
        <span><span>Next</span></span>
    </button>
    <div class="clearthis"></div>
</div>
</div>
<script type="text/javascript">
    {literal}
    function checkPackage() {
        var ok = false;
        jQuery('input[id^=package_id]').each(function(){
            if (jQuery(this).attr('checked')) {
                ok = true;
            }
        });
        if (ok) {
            Common.warningObject('#notify_package',true);
            return true;
        } else {
            Common.warningObject('#notify_package',false);
            return false;
        }
    }
    agent.flushCallback();
    if(jQuery('input[id^=package_id]').length > 0)
    agent.addCallbackFnc('valid',function(){return checkPackage();});
    {/literal}
</script>