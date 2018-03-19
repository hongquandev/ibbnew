<script src="modules/agent/templates/js/checkcountry_register_fast.js" type="text/javascript"></script>
{literal}
<script type="text/javascript">
    jQuery(document).ready(function(){
        onLoad('personal');
        $('#personal_country').bind('change',function(){
            onLoad('personal');
        })
    });
    var RecaptchaOptions = {theme:'white'};
    /*$(function() {
        $('#tooltip_reg').tipsy({gravity: 's',html: true,fallback: "<div style='text-align: justify;padding: 5px;'>Basic registration allows you to log in and maintain a watch list of properties you like. To post a property for sale, register to bid or communicate with Agents / vendors, you will need to complete the full registration process.<div>"});
    });*/
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
            <h2>{localize translate="Personal Details"}</h2>
        {elseif $type == 'partner'}
            <h2>{localize translate="Company Details"}</h2>
        {elseif $type == 'agent'}
            <h2>{localize translate="Account Info"}</h2>
        {/if}
        {if in_array($type,array('vendor','buyer'))}
            <p class="p-jus-register">
                Please complete all fields on this page.
                We request all your contact details to ensure that all members are valid, and to enable the simplification of the process for you to register to bid or post properties on our site.
            </p>
        {elseif $type == 'partner'}
            <p class="p-jus-register">
                To register as an advertiser on www.bidRhino.com, please complete all fields on this page.
            </p>
        {elseif $type == 'agent'}
            <p style="text-align: justify">
                To register as an Agent, and use bidRhino Agent, the online bidding service, please complete all details on this and the following pages.
            </p>
            <br/>
            <p>
                Each REA office requires to register an bidRhino account and can have 5 users per account.
            </p>
        {/if}
    </div>
    <div class="step-detail col2-set">
    {if in_array($type,array('vendor','buyer'))} <!-- BEGIN CHECK AGENT REGISTER CHOOSE VENDOR OR BUYER OR PARTNER -->
        <div>
            <form name="frmAgent" id="frmAgent" method="post" action="{$form_action}{$form_action_transact}" enctype="multipart/form-data">
                <input type="hidden" name="sign" id="sign" value=""/>
                <ul class="form-list form-register">
                    {if isset($message) and strlen($message)>0}
                    <div class="message-box message-box-v-ie">
                        {$message}
                    </div>
                    {/if}
                    <li class="wide">
                        <div class="field">
                            <label>
                                <strong id="notify_firstname">{localize translate="First Name"} <span>*</span></strong>
                            </label>
                            <div class="input-box">
                                <input type="text" name="firstname" id="firstname" value="{$form_datas.firstname}" class="input-text validate-require" autocomplete="off"/>
                            </div>
                        </div>
                    </li>
                    <li class="wide">
                        <div class="field">
                            <label>
                                <strong id="notify_lastname">{localize translate="Surname"} <span>*</span></strong>
                            </label>
                            <div class="input-box">
                                <input type="text" name="lastname" id="lastname" value="{$form_datas.lastname}" class="input-text validate-require" autocomplete="off"/>
                            </div>
                        </div>
                    </li>
                    <li class="wide">
                        <div>
                            <label>
                                <strong id="notify_mobilephone">{localize translate="Phone Number"}</strong>
                            </label>
                            <div class="input-box">
                                <input type="text" name="mobilephone" id="personal_mobilephone" value="{$form_datas.mobilephone}"
                                       class="input-text {*validate-telephone*}" autocomplete="off"/>
                            </div>
                        </div>
                    </li>
                    <li class="wide">
                        <label>
                            <strong id="notify_email_address">{localize translate="Email Address"}<span>*</span></strong>
                        </label>
                        <div class="input-box">
                            <input type="text" name="email_address" id="email_address" value="{$form_datas.email_address}"
                                   class="input-text validate-require validate-email"
                                   onkeyup="Common.existEmail('/modules/{$module}/action.php?action=exist_email',this,{$agent_id})"
                                   autocomplete="off"/>
                        </div>
                    </li>
                    <li class="wide">
                        <label>
                            <strong id="notify_confirm_email_address">{localize translate="Confirm Email Addess"}<span>*</span></strong>
                        </label>
                        <div class="input-box">
                            <input type="text" name="confirm_email_address" id="confirm_email_address" value="{$form_datas.email_address_confirm}"
                                   class="input-text validate-require validate-email"
                                   autocomplete="off"/>
                        </div>
                    </li>
                    <li class="wide">
                        <div class="field">
                            <label>
                                <strong id="notify_password">{localize translate="Account Password"}<span>*</span></strong>
                                <br>
                                <small style="font-weight: bold; font-style: italic;">{localize translate="(For logging in to your site account)"} </small>
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
                                <strong id="notify_password2">{localize translate="Verify Password"}<span>*</span></strong>
                            </label>
                            <div class="input-box">
                                <input type="password" name="password2" id="password2" value="{$form_datas.password2}"
                                       class="input-text validate-require" AUTOCOMPLETE="off"/>
                            </div>
                        </div>
                    </li>
                    {if $register_kind == 'transact' && $transact_step >= 2}
                        <li class="wide">
                            <label>
                                <strong id="notify_street">{localize translate="Street Address"} <span></span></strong>
                            </label>
                            <div class="input-box">
                                <input type="text" name="street" id="street" value="{$form_datas.street}" class="input-text" autocomplete="off"/>
                            </div>
                        </li>
                        <li class="fields">
                            <div class="field">
                                <label>
                                    <strong id="notify_suburb">{localize translate="Suburb"} <span></span></strong>
                                </label>
                                <div class="input-box">
                                    <input type="text" name="suburb" id="personal_suburb" value="{$form_datas.suburb}" class="input-text validate-letter" onclick="search_overlay.getData(this)" onkeyup="search_overlay.moveByKey(event)" autocomplete="off"/>
                                    <ul>
                                        <div id="search_overlay" class="search_overlay" style="display:none; position: absolute;">
                                        </div>
                                    </ul>
                                </div>
                            </div>
                            <div class="field">
                                <label>
                                    <strong id="notify_postcode">{localize translate="Postcode"} <span></span></strong>
                                </label>
                                <div class="input-box">
                                    <input type="text" name="postcode" id="personal_postcode" value="{$form_datas.postcode}" class="input-text {*validate-postcode*}"
                                           onkeyup="Common.validRegion('/modules/property/action.php?action=validate-property','#personal_suburb','#personal_state','#personal_postcode','#frmAgent','#personal_country')"
                                           autocomplete="off"/>
                                </div>
                            </div>
                        </li>
                        <li class="fields">
                            <div class="field">
                                <label>
                                    <strong id="notify_state">{localize translate="State"} <span></span></strong>
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
                            <div class="field" id="inactive_country">
                                <label>
                                    <strong id="notify_country">{localize translate="Country"}<span></span></strong>
                                </label>
                                <div class="input-box">
                                    <select name="country" id="personal_country" class="input-select validate-number-gtzero">
                                        {html_options options = $options_country selected = $form_datas.country}
                                    </select>
                                </div>
                            </div>
                            <div class="clearthis">
                            </div>
                        </li>
                    <li class="wide">
                        <label>
                            <strong id="notify_security_question">{localize translate="Security question"} <span></span></strong>
                        </label>
                        <div class="input-box">
                            <select name="security_question" id="security_question" class="input-select validate-number-gtzero">
                                {html_options options = $options_question selected = $form_datas.security_question}
                            </select>
                            <a href="javascript:void(0)" style="float:right;margin: 3px 0px;" onclick="agent.showSQ()">{localize translate="Add new question"}</a>
                            <div id="question_container" style="display:none">
                                <div id="msg_question" style="color:#FF0000"></div>
                                <input type="text" name="new_question" id="new_question" class="input-text"/>
                                <input style="margin-top: 3px;" type="button" value="Save" onclick="agent.saveSQ()"/><span
                                    id="loading_question" style="display:none;">{localize translate="loading..."}</span>
                            </div>
                        </div>
                    </li>
                    <li class="wide">
                        <label>
                            <strong id="notify_asecurity_answer">{localize translate="Answer"} <span></span></strong>
                        </label>
                        <div class="input-box">
                            <input type="text" name="security_answer" id="security_answer" value="{$form_datas.security_answer}"
                                   class="input-text" onKeyPress="return submitenter(this,event)" autocomplete="off"/>
                            <input type="hidden" name="sign" id="sign" value=""/>
                        </div>
                    </li>
                    <li class="wide">
                        <p style="margin: 15px 0; font-size: 14px;line-height: 20px">If you have not yet done so, you are required to upload photo ID for validation purposes (this will be saved in your account and only needs to be done once)</p>
                        <label>
                            <strong id="notify_file_drivers_license">{localize translate="Drivers Licence"}<span></span></strong>
                        </label>
                        <div class="file-box">
                            <span class="file"><input type="file" id="file_drivers_license" name="file_drivers_license"/></span>
                            <span class="file-name">{$file.file_drivers_license}</span>
                            <span class="file-action">{if $file.file_drivers_license}Delete{else}No file{/if}</span>
                            <input class="file-delete" type="hidden" value="0" name="files_deleted[file_drivers_license]"/>
                        </div>
                    </li>
                    <li class="wide">
                        <br/>
                        <label>
                            <strong id="notify_file_passport_birth">{localize translate="Passport / Birth Certificate"}<span></span></strong>
                        </label>
                        <div class="file-box">
                            <span class="file"><input type="file" id="file_passport_birth" name="file_passport_birth"/></span>
                            <span class="file-name">{$file.file_passport_birth}</span>
                            <span class="file-action">{if $file.file_passport_birth}Delete{else}No file{/if}</span>
                            <input class="file-delete" type="hidden" value="0" name="files_deleted[file_passport_birth]"/>
                        </div>
                    </li>
                    {/if}
                    {if $register_kind == 'transact'}
                    <li class="wide">
                        <br/>
                        {if $form_datas.checked_term == 1}
                            {assign var="checked_term" value="checked"}
                        {/if}
                        <input type="checkbox" id="checked_term" class="validate-number-gtzero" name="checked_term" {$checked_term}/>
                        <label>
                            <strong id="notify_checked_term" class="">I accept the <a style="text-decoration: underline;" href="javascript:void(0)" onclick="term.showPopup('{$registerToTransact_id}')">terms and conditions</a> *</strong>
                        </label>
                    </li>
                    {/if}
                    <li class="wide">
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
                    </li>
                    <li class="wide">
                        {assign var="checked" value=""}
                        {if $form_datas.auto_update_contact == 1}
                            {assign var="checked" value="checked"}
                        {/if}
                        <input type="checkbox" name="auto_update_contact" {$checked}/>
                        <label>
                            <strong>{localize translate="Auto update My Personal Details to My contact details"}</strong>
                        </label>
                    </li>
                </ul>
            </form>
            <div class="clearthis"></div>
            <p style="color: red; font-size: 13px; margin: 5px 0">“NOTE : Please check your JUNK email folder for your confirmation email”</p>
            <div class="buttons-set" style="margin-top: 15px">
                {assign var="title" value="<div style='text-align: justify;padding: 5px;'>Basic registration allows you to log in and maintain a watch list of properties you like. To post a property for sale, register to bid or communicate with Agents / vendors, you will need to complete the full registration process.<div>"}
                {if $register_kind == 'transact'}
                    {if $transact_step == 1}
                        <button class="btn-blue-transact" onclick="goToTransact('#frmAgent',2)" style="float:left">
                            <span><span>{localize translate="Register to transact"}</span></span>
                        </button>
                        <div class="clearthis"></div>
                        <button class="btn-green-transact" onclick="goToTransact('#frmAgent',2)     " style="float:left">
                            <span><span>{localize translate="Complete Transact Application"}</span></span>
                        </button>
                    {/if}
                    {if $transact_step >= 2}
                        <button class="btn-blue-transact" onclick="goToTransact('#frmAgent',3)" style="float:left">
                            <span><span>{localize translate="Complete User Transact"}</span></span>
                        </button>
                        <div class="clearthis"></div>
                        <button class="btn-green-transact" onclick="goToTransact('#frmAgent',3)" style="float:left">
                            <span><span>{localize translate="Complete Transact Application"}</span></span>
                        </button>
                    {/if}
                {else}
                    <button class="btn-gray" onclick="agent.step('#frmAgent','finish')" style="float:left">
                        <span><span>{localize translate="Finish Basic Registration"}</span></span>
                    </button>
                    <button class="btn-blue" onclick="agent.step('#frmAgent')" style="float:right">
                        <span><span>{localize translate="Next for full registration"}</span></span>
                    </button>
                {/if}
                <div class="clearthis"></div>
            </div>
        </div>
    {elseif $type == 'partner'}
        {include file='partner.register.step1.tpl'}
    {elseif $type == 'agent'}
        {include file='agent.auction.register.step1.tpl'}
    {/if}
        <div class="clearthis"></div>
    </div>
</div>
<script type="text/javascript">
    {literal}
    function goToTransact(frm,transact_step){
        var validation = new Validation(frm);
        if(validation.isValid()){
            var isSubmit = true;
            //VALID
            if(jQuery('#checked_term','#frmAgent').attr('checked') != 'checked'){
                jQuery('#notify_'+jQuery('#checked_term','#frmAgent').attr('id')).addClass('check-validation-fail');
                isSubmit = false;
            }else{
                jQuery('#notify_'+jQuery('#checked_term','#frmAgent').attr('id')).removeClass('check-validation-fail');
            }
            jQuery('input[type=file]',frm).each(function(){
                if(jQuery(this).closest('.file-box').find(".file-name").text() == ''){
                    jQuery(this).closest('.file-box').find(".file-name").addClass('file-validation-fail');
                    isSubmit = false;
                }else{
                    jQuery(this).closest('.file-box').find(".file-name").removeClass('file-validation-fail');
                }
            });
            if(isSubmit){
                var action = jQuery(frm).attr('action');
                action += '&transact_step='+transact_step;
                jQuery(frm).attr('action',action).submit();
            }
        }
    }
    var user_declaration_popup = new Popup();
    function showUserDeclarationPopup(content){
        user_declaration_popup.removeChild();
        user_declaration_popup.init({id:'user_declaration_popup',className:'popup_overlay'});
        user_declaration_popup.updateContainer('<div class="popup_container" style="width:850px;height: auto;min-height: 100px;"><div id="user_declaration_popup-wrapper">\
			 <div class="title"><h2>User Declaration<span id="btnclosex" class="btn-x" onclick="closeUserDeclarationPopup()">Close X</span></h2> </div>\
			 <div class="clearthis" style="clear:both;"></div>\
			 <div align="center" style="margin-bottom: 20px; margin-top: 20px;" class="content content-po" id="msg"> '+content+'</div>\
             <div style="text-align: center;margin: 20px;cursor: pointer" onclick="closeUserDeclarationPopup()">CLOSE X</div></div>\
			  </div></div></div>');
        user_declaration_popup.show().toCenter();
    }
    function closeUserDeclarationPopup(){
        user_declaration_popup.hide();
    }
    function showTransactApplication(agent_id){
        showLoadingPopup();
        var url = ROOTURL + '/modules/agent/action.php?action=transact_step_finish';
        jQuery.post(url,{agent_id: agent_id},function(data){
            closeLoadingPopup();
            var result = jQuery.parseJSON(data);
            if(result.success){
                showUserDeclarationPopup(result.html);
            }else{
                showMess__(result.message);
            }
        },'html');
    }
    function submitRegistration(agent_id){
        var isSubmit = true;
        jQuery('input[type=checkbox]','.user-declaration-content').each(function(){
            if(jQuery(this).attr('checked') != 'checked'){
                jQuery('#notify_'+jQuery(this).attr('id')).show();
                isSubmit = false;
            }else{
                jQuery('#notify_'+jQuery(this).attr('id')).hide();
            }
        });
        if(!isSubmit){return;}
        closeUserDeclarationPopup();
        showLoadingPopup();
        var url = ROOTURL + '/modules/agent/action.php?action=submit_application';
        jQuery.post(url,{agent_id: agent_id},function(data){
            //closeLoadingPopup();
            var result = jQuery.parseJSON(data);
            if(result.success){
                jQuery.post(result.redirect_link,{isAjax: true},function(data){
                    closeLoadingPopup();
                    var _data = jQuery.parseJSON(data);
                    showMess__('Register Success. Please wait 3s to redirect. Thanks');
                    setTimeout(function(){
                        document.location = _data.redirect_link;
                    },3000);
                });

            }else{
                showMess__(result.message);
            }
        },'html');
    }
    {/literal}
</script>

