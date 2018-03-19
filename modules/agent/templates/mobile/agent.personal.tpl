<link href="/utils/ajax-upload/fileuploader.css" rel="stylesheet" type="text/css"/>
<link href="/modules/property/templates/style/ajax-upload.css" rel="stylesheet" type="text/css"/>
<script src="modules/agent/templates/js/checkcountry_register_fast.js" type="text/javascript"></script>
<script type="text/javascript" src="/utils/ajax-upload/fileuploader.js"></script>
<script type="text/javascript" src="/modules/property/templates/js/upload.js"></script>
{literal}
<script type="text/javascript">
    var editor = document.getElementById("mce_editor_0");
    if (editor) {
        editor.style.width = 1000;
    }
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
            search_overlay._current = -1;
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
    jQuery(document).ready(function () {
        onLoad('personal');
    });

</script>
{/literal}
<div class="bar-title">
{if $authentic.type == 'partner'}
    <h2>MY COMPANY DETAILS</h2>
    {else}
    <h2>MY PERSONAL INFORMATION</h2>
{/if}
</div>
{if isset($message) and strlen($message)>0}
<div class="message-box message-box-ie">
    {$message}
</div>
<div class="clearthis"></div>
{/if}
<div id="message_content" class="message-box message-box-ie" style="display: none;"></div>
{if $authentic.type != 'partner'} <!-- CHECK IF AGENT IS NOT PARTNER -->
    <ul class="form-list form-company" id="form-lper">
        <form name="frmAgent" id="frmAgent" method="post" action="{$form_action}">
            <li class="fields">
        <div class="field">
            <label>
                <strong>First Name <span id="notify_firstname">*</span></strong>
            </label>

            <div class="input-box">
                <input type="text" name="field[firstname]" id="firstname" value="{$form_data.personal.firstname}"
                       class="input-text validate-require"/>
            </div>
        </div>
        <div class="field">
            <label>
                <strong>Last Name <span id="notify_lastname">*</span></strong>
            </label>

            <div class="input-box">
                <input type="text" name="field[lastname]" id="lastname" value="{$form_data.personal.lastname}"
                       class="input-text validate-require"/>
            </div>
        </div>
        <div class="clearthis">
        </div>
    </li>
        {if in_array($authentic.type,array('vendor','buyer'))}
            <li class="wide">
                <label>
                    <strong>Address <span id="notify_street">*</span></strong>
                </label>

                <div class="input-box">
                    <input type="text" name="field[street]" id="street" value="{$form_data.personal.street}"
                           class="input-text validate-require"/>
                </div>
            </li>
            <li class="fields">
                <div class="field">
                    <label>
                        <strong>Suburb <span id="notify_suburb">*</span></strong>
                    </label>

                    <div class="input-box">
                        <input type="text" name="field[suburb]" id="personal_suburb" value="{$form_data.personal.suburb}"
                               class="input-text validate-require validate-letter" onclick="search_overlay.getData(this)"
                               onkeyup="search_overlay.moveByKey(event)" autocomplete="off"/>
                        <ul>
                            <div id="search_overlay" class="search_overlay" style="display:none; position: absolute;"></div>
                        </ul>
                    </div>
                </div>
                <div class="field">
                    <label>
                        <strong>Postcode <span id="notify_postcode">*</span></strong>
                    </label>

                    <div class="input-box">
                        <input type="text" name="field[postcode]" id="personal_postcode" value="{$form_data.personal.postcode}"
                               class="input-text validate-require validate-postcode"
                               onkeyup="Common.validRegion('/modules/property/action.php?action=validate-property','#personal_suburb','#personal_state','#personal_postcode','#frmAgent')"
                               autocomplete="off"/>
                    </div>
                </div>
            </li>
            <li class="fields">
                <div class="field">
                    <label>
                        <strong id="notify_personal_state">State <span>*</span></strong>
                    </label>

                    <div class="input-box input-select">
                        <div id="inactive_personal_state">
                            <select name="field[state]" id="personal_state" class="input-select validate-number-gtzero"
                                    onchange="Common.validRegion('/modules/property/action.php?action=validate-property','#personal_suburb','#personal_state','#personal_postcode','#frmAgent')">
                                {html_options options = $subState selected = $form_data.personal.state}
                            </select>
                        </div>
                        <input type="text" id="personal_other_state" name="field[other_state]" class="input-text"
                               style="width:97%"
                               value="{$form_data.personal.other_state}"/>
                    </div>
                </div>
                <div class="field">
                    <label>
                        <strong>Country <span id="notify_country">*</span></strong>
                    </label>

                    <div class="input-box input-select input-select-new">
                        <select name="field[country]" id="personal_country" class="input-select validate-number-gtzero"
                                onchange="onLoad('personal')">
                            {html_options options = $options_country selected = $form_data.personal.country}
                        </select>
                    </div>
                </div>
                <div class="clearthis">
                </div>
            </li>
            <li class="fields">
                <div class="field">
                    <label>
                        <strong>Telephone</strong>
                    </label>

                    <div class="input-box">
                        <input type="text" name="field[telephone]" id="personal_telephone"
                               value="{$form_data.personal.telephone}"
                               class="input-text validate-telephone"/>
                    </div>
                </div>
                <div class="field">
                    <label>
                        <strong>Mobile phone</strong>
                    </label>

                    <div class="input-box">
                        <input type="text" name="field[mobilephone]" id="personal_mobilephone"
                               value="{$form_data.personal.mobilephone}"
                               class="input-text validate-telephone"/>
                    </div>
                </div>
                <div class="clearthis">
                </div>
            </li>
            <li class="fields">
                <div class="field">
                    <label>
                        <strong>Email <span id="notify_email_address">*</span></strong>
                    </label>

                    <div class="input-box">
                        <input type="text" name="field[email_address]" id="email_address"
                               value="{$form_data.personal.email_address}"
                               class="input-text validate-require validate-email"
                               onkeyup="Common.existEmail('/modules/{$module}/action.php?action=exist_email&agent_id={$form_data.agent_id}',this)"
                               autocomplete="off"/>
                    </div>
                </div>
                <div class="field">
                    <label>
                        <strong>Drivers License Number/Medicare Card No.</strong>
                    </label>

                    <div class="input-box">
                        <input type="text" name="field[license_number]" id="personal_license_number"
                               value="{$form_data.personal.license_number}"
                               class="input-text validate-license"/>
                    </div>
                </div>
                <div class="clearthis">
                </div>
            </li>
        {else}
            {if $authentic.parent_id > 0}
            <li class="wide">
                <label>
                    <strong>Office Address <span id="notify_address">*</span></strong>
                </label>

                <div class="input-box">
                    <input type="text" name="company[address]" id="address" value="{$form_data.company.address}"
                           class="input-text validate-require"/>
                </div>
            </li>
            <li class="fields">
                <div class="field">
                    <label>
                        <strong>Suburb <span id="notify_suburb">*</span></strong>
                    </label>

                    <div class="input-box">
                        <input type="text" name="company[suburb]" id="personal_suburb" value="{$form_data.company.suburb}"
                               class="input-text validate-require validate-letter" onclick="search_overlay.getData(this)"
                               onkeyup="search_overlay.moveByKey(event)" autocomplete="off"/>
                        <ul>
                            <div id="search_overlay" class="search_overlay" style="display:none; position: absolute;"></div>
                        </ul>
                    </div>
                </div>
                <div class="field">
                    <label>
                        <strong>Postcode <span id="notify_postcode">*</span></strong>
                    </label>

                    <div class="input-box">
                        <input type="text" name="company[postcode]" id="personal_postcode"
                               value="{$form_data.company.postcode}"
                               class="input-text validate-require validate-postcode"
                               onkeyup="Common.validRegion('/modules/property/action.php?action=validate-property','#personal_suburb','#personal_state','#personal_postcode','#frmAgent')"
                               autocomplete="off"/>
                    </div>
                </div>
            </li>
            <li class="fields">
                <div class="field">
                    <label>
                        <strong id="notify_personal_state">State <span>*</span></strong>
                    </label>

                    <div class="input-box input-select">
                        <div id="inactive_personal_state">
                            <select name="company[state]" id="personal_state" class="input-select validate-number-gtzero"
                                    onchange="Common.validRegion('/modules/property/action.php?action=validate-property','#personal_suburb','#personal_state','#personal_postcode','#frmAgent')">
                                {html_options options = $subState selected = $form_data.company.state}
                            </select>
                        </div>
                        <input type="text" id="personal_other_state" name="company[other_state]" class="input-text"
                               style="width:97%"
                               value="{$form_data.company.other_state}"/>
                    </div>
                </div>

                <div class="field">
                    <label>
                        <strong>Country <span id="notify_country">*</span></strong>
                    </label>

                    <div class="input-box input-select input-select-new">
                        <select name="company[country]" id="personal_country" class="input-select validate-number-gtzero"
                                onchange="onLoad('personal')">
                            {html_options options = $options_country selected = $form_data.company.country}
                        </select>
                    </div>
                </div>
                <div class="clearthis">
                </div>
            </li>
            <li class="fields">
                <div class="field">
                    <label>
                        <strong>Telephone <span id="notify_personal_telephone">*</span></strong>
                    </label>

                    <div class="input-box">
                        <input type="text" name="company[telephone]" id="personal_telephone"
                               value="{$form_data.company.telephone}"
                               class="input-text validate-require validate-telephone"/>
                    </div>
                </div>
                <div class="field">
                    <label>
                        <strong>Website</strong>
                    </label>

                    <div class="input-box">
                        <input type="text" name="company[website]" id="website" value="{$form_data.company.website}"
                               class="input-text validate-url"/>
                    </div>
                </div>
                <div class="clearthis">
                </div>
            </li>
        {/if}
            <li class="fields">
                <div class="field">
                    <label>
                        <strong>Telephone</strong>
                    </label>

                    <div class="input-box">
                        <input type="text" name="field[telephone]" id="personal_telephone"
                               value="{$form_data.personal.telephone}"
                               class="input-text validate-telephone"/>
                    </div>
                </div>
                <div class="field">
                    <label>
                        <strong>Mobile phone</strong>
                    </label>

                    <div class="input-box">
                        <input type="text" name="field[mobilephone]" id="personal_mobilephone"
                               value="{$form_data.personal.mobilephone}"
                               class="input-text validate-telephone"/>
                    </div>
                </div>
                <div class="clearthis">
                </div>
            </li>
            <li class="fields">
                <div class="field">
                    <label>
                        <strong>Email <span id="notify_email_address">*</span></strong>
                    </label>
                    <div class="input-box">
                        <input type="text" name="field[email_address]" id="email_address"
                               value="{$form_data.personal.email_address}"
                               class="input-text validate-require validate-email"
                               onkeyup="Common.existEmail('/modules/{$module}/action.php?action=exist_email&agent_id={$form_data.agent_id}',this)"
                               autocomplete="off"/>
                    </div>
                </div>
                {if $authentic.parent_id > 0}
                    <div class="field">
                        <label>
                            <strong>Contact Email</strong>
                        </label>

                        <div class="input-box">
                            <input type="text" name="company[email_address]" id="email"
                                   value="{$form_data.company.email_address}"
                                   class="input-text validate-email"/>
                        </div>
                    </div>
                {/if}
                <div class="clearthis">
                </div>
            </li>
        {/if}
        {if in_array($authentic.type,array('vendor','buyer'))}
            <li class="control" id="stie7">
                {assign var = 'allow' value = ''}
                {if $form_data.personal.allow_vendor_contact>0}
                    {assign var = 'allow' value = 'checked'}
                {/if}

                <label for="allow_vendor_contact">
                    <input type="checkbox" name="field[allow_vendor_contact]" id="allow_vendor_contact" {$allow}/>
                    <strong>Can agents contact you?</strong>
                </label>
            </li>
            <li class="fields">
                <div class="field">
                    <label>
                        <strong>Preferred contact method <span
                                id="notify_preferred_contact_method">*</span></strong>
                    </label>

                    <div class="input-box input-select input-select-new">
                        <select name="field[preferred_contact_method]" id="preferred_contact_method"
                                class="input-select validate-number-gtzero">
                            {html_options options = $options_method selected = $form_data.personal.preferred_contact_method}
                        </select>
                    </div>
                </div>
                <div class="field">
                    <label>
                        <strong id="notify_security_question">Security question <span>*</span></strong>
                    </label>

                    <div class="input-box input-select input-select-new">
                        <select name="field[security_question]" id="security_question"
                                class="input-select validate-number-gtzero">
                            {html_options options = $options_question selected = $form_data.personal.security_question}
                        </select>
                    </div>
                </div>

                <div class="clearthis">
                </div>
            </li>
            <li class="wide">
                <label>
                    <strong id="notify_security_answer">Security Answer <span>*</span></strong>
                </label>

                <div class="input-box">
                    <input type="text" name="field[security_answer]" id="security_answer"
                           value="{$form_data.personal.security_answer}"
                           class="input-text validate-require"/>
                </div>
            </li>
        {else}
            <li class="fields">
                <div class="field">
                    <label id="notify_security_question">
                        <strong>Security question <span>*</span></strong>
                    </label>

                    <div class="input-box input-select input-select-new">
                        <select name="field[security_question]" id="security_question"
                                class="input-select validate-number-gtzero">
                            {html_options options = $options_question selected = $form_data.personal.security_question}
                        </select>
                    </div>
                </div>
                <div class="field">
                    <label id="notify_security_answer">
                        <strong>Security Answer <span>*</span></strong>
                    </label>

                    <div class="input-box">
                        <input type="text" name="field[security_answer]" id="security_answer"
                               value="{$form_data.personal.security_answer}"
                               class="input-text validate-require"/>
                    </div>
                </div>
                <div class="clearthis">
                </div>
            </li>
            <li class="wide">
                <label>
                    <strong>Description <span id="notify_description"></span></strong>
                </label>

                <div class="input-box">
                    <textarea class="content" rows="7" cols="" name="company[description]"
                              id="description">{$form_data.company.description}</textarea>
                </div>
            </li>
        {/if}
        {if $authentic.type == 'agent'}
            <li class="wide">
                <label>
                    <strong>Your username ?<span id="notify_site"></span></strong>
                </label>
                {php}
                    //print_r($this->_tpl_vars['form_data']['personal']);
                {/php}
                <div class="input-box">
                    <input class="validate-require" style="width:47%" type="text" value="{$form_data.personal.site}" name="field[site]" id="site" {if $form_data.personal.site != '' && !$error} readonly="readonly" {/if}/>
                </div>
            </li>
            <li class="wide">
                <div class="des">
                    {$description}
                </div>
            </li>
        {/if}
    </form>
    </ul>
{else} <!-- IS PARTNER -->
    {include file="`$ROOTPATH`/modules/agent/templates/agent.company-detail.tpl"}
{/if}
<div id="button-set-myacc" class="buttons-set buttons-set-a">
    <button class="btn-red f-right btn-red-a" onclick="agent.submit('#frmAgent')">
        <span><span>Save</span></span>
    </button>
    {if $authentic.type == 'agent'}
        <button style="margin-right:10px" class="btn-red f-right btn-red-a"
                onclick="document.location='{seo}?module=agent&action=view-detail-agent&uid={$authentic.id}{/seo}'">
            <span><span>View</span></span>
        </button>
    {/if}

    <div class="clearthis"></div>
</div>
<script type="text/javascript">
    {if $form_data.personal.site != '' && !$error}
        agent.init('site','{$form_data.personal.site_id}','lock');
    {else}
        agent.init('site','{$form_data.personal.site_id}');
    {/if}
</script>
