<link href="/utils/ajax-upload/fileuploader.css" rel="stylesheet" type="text/css" />
<link href="/modules/property/templates/style/ajax-upload.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/utils/ajax-upload/fileuploader.js"></script>
<script type="text/javascript" src="/modules/property/templates/js/upload.js"></script>
<div class="bar-title">
    <h2>{localize translate="MY COMPANY DETAILS"}</h2>
</div>

<div class="ma-info mb-20px">

    <div class="col2-set mb-20px">
        <div class="col">
            {if isset($message) and strlen($message)>0}
                <div class="message-box message-box-ie">
                    {$message}
                </div>
            {/if}
            <div id="message_content" class="message-box message-box-ie" style="display: none;">
            </div>
            {if $authentic && $authentic.type == 'agent'}
                <ul class="tabs">
                    <li><a href="/?module=agent&action=edit-company" class="defaulttab">{localize translate="Company Information"}</a></li>
                    <li><a href="/?module=agent&action=edit-site">{localize translate="Advanced Configurations"}</a></li>
                </ul>
            {/if}
        </div>

        <form name="frmAgent" id="frmAgent" method="post" action="{$form_action}">
        <ul class="form-list form-company" id="form-lper">
            <li class="fields">
                <div class="field">
                    <label>
                        <strong>{localize translate="Company name"}<span id="notify_firstname">*</span></strong>
                    </label>

                    <div class="input-box">
                        <input type="text" name="company_name" id="company_name" value="{$form_data.company_name}"
                               class="input-text validate-require"/>
                    </div>
                </div>
                <div class="field">
                    <label>
                        <strong>{localize translate="ABN / ACN"}<span id="notify_abn">*</span></strong>
                    </label>

                    <div class="input-box">
                        <input type="text" name="abn" id="abn" value="{$form_data.abn}"
                               class="input-text validate-require validate-digits"/>
                    </div>
                </div>

                <div class="clearthis">
                </div>
            </li>
            <li class="fields">
                <div class="field">
                    <label>
                        <strong>{localize translate="Telephone"} <span id="notify_telephone">*</span></strong>
                    </label>

                    <div class="input-box">
                        <input type="text" name="telephone" id="telephone" value="{$form_data.telephone}"
                               class="input-text validate-require {*validate-telephone*}"/>
                    </div>
                </div>
                <div class="field">
                    <label>
                        <strong>{localize translate="Address"} <span id="notify_street">*</span></strong>
                    </label>

                    <div class="input-box">
                        <input type="text" name="address" id="address" value="{$form_data.address}"
                               class="input-text validate-require"/>
                    </div>
                </div>
            </li>
            <li class="fields">
                <div class="field">
                    <label>
                        <strong>{localize translate="Suburb"} <span id="notify_suburb">*</span></strong>
                    </label>

                    <div class="input-box">
                        <input type="text" name="suburb" id="personal_suburb" value="{$form_data.suburb}"
                               class="input-text validate-require validate-letter"
                               onclick="search_overlay.getData(this)"
                               onkeyup="search_overlay.moveByKey(event)" autocomplete="off"/>
                        <ul>
                            <div id="search_overlay" class="search_overlay"
                                 style="display:none; position: absolute;"></div>
                        </ul>
                    </div>
                </div>
                <div class="field">
                    <label>
                        <strong id="notify_personal_state">{localize translate="State"} <span>*</span></strong>
                    </label>

                    <div class="input-box input-select">
                        <div id="inactive_personal_state">
                            <select name="state" id="personal_state" class="input-select validate-number-gtzero"
                                    onchange="Common.validRegion('/modules/property/action.php?action=validate-property','#personal_suburb','#personal_state','#personal_postcode','#frmAgent')">
                            {html_options options = $options_state selected = $form_data.state}
                            </select>
                        </div>
                        <input type="text" id="personal_other_state" name="other_state" class="input-text"
                               style="width:97%"
                               value="{$form_data.other_state}"/>
                    </div>
                </div>
            </li>

            <li class="fields">
                <div class="field">
                    <label>
                        <strong>{localize translate="Postcode"} <span id="notify_postcode">*</span></strong>
                    </label>

                    <div class="input-box">
                        <input type="text" name="postcode" id="personal_postcode" value="{$form_data.postcode}"
                               class="input-text validate-require validate-postcode"
                               onkeyup="Common.validRegion('/modules/property/action.php?action=validate-property','#personal_suburb','#personal_state','#personal_postcode','#frmAgent')"
                               autocomplete="off"/>
                    </div>
                </div>

                <div class="field">
                    <label>
                        <strong>{localize translate="Country"} <span id="notify_country">*</span></strong>
                    </label>

                    <div class="input-box input-select input-select-new">
                        <select name="country" id="personal_country" class="input-select validate-number-gtzero"
                                onchange="onLoad('personal')">
                        {html_options options = $options_country selected = $form_data.country}
                        </select>
                    </div>
                </div>
                <div class="clearthis">
                </div>
            </li>
            <li class="fields">
                <div class="field">
                    <label>
                        <strong>{localize translate="Company email"}</strong>
                    </label>

                    <div class="input-box">
                        <input type="text" name="email_address" id="email_address" value="{$form_data.email_address}"
                               class="input-text validate-email"/>
                    </div>
                </div>
                <div class="field">
                    <label>
                        <strong>{localize translate="Website"}</strong>
                    </label>

                    <div class="input-box">
                        <input type="text" name="website" id="website" value="{$form_data.website}"
                               class="input-text validate-url"/>
                    </div>
                </div>
                <div class="clearthis"></div>
            </li>
            
           {if $form_data.logo != ''}
                <li class="wide">
                    <label>
                        <strong>{localize translate="Banner"}</strong>
                    </label>

                    <div class="input-box">
                        <div id="container-logo">
                            <img src="{$MEDIAURL}/{$form_data.logo}"
                                 alt="{$form_data.logo}"/>

                            <div class="clearthis"></div>
                        </div>
                    </div>
                </li>
           {/if}
           <li class="wide" id="upload-logo">
                <label>
                    <strong>{localize translate="Upload Banner"}</strong>
                </label>

                <div class="input-box">
                    <div class="input-box file-upload">
                        <div id="btn_photo" style="float:left"></div>
                        <ul id="lst_photo" style="float:left;margin-left:10px" class="qq-upload-list">
                            {localize translate="No file chosen"}
                        </ul>
                        <br clear="all"/>
                        <script type="text/javascript">
                            var photo = new Media();
                            photo.uploader('btn_photo', 'logo', '/modules/agent/action.php?action=upload_banner_agent&container=container-logo');
                        </script>
                    </div>
                    <i> {localize translate="You must upload with one of the following extensions: jpg, jpeg, gif, png."} </i> <br
                        style="margin-bottom:5px;" />
                    <i> {localize translate="Max size: 2Mb."}</i>
                </div>
           </li>

           <li class="wide">
                <label>
                    <strong>{localize translate="Description"}<span id="notify_description">*</span></strong>
                </label>

                <div class="input-box">
                    <textarea rows="6" name="description" id="description" class="input-text content">{$form_data.description}</textarea>
                </div>
           </li>
        </ul>
        </form>
        <div id="button-set-myacc" class="buttons-set buttons-set-a">
            <button class="btn-red f-right btn-red-a" onclick="_submitSave()">
                <span><span>{localize translate="Save"}</span></span>
            </button>
            <div class="clearthis"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    {literal}
        jQuery(document).ready(function(){
            onLoad('personal');
            $('#personal_country').bind('change',function(){
                    onLoad('personal');
            });
        });
        function _submitSave(){
            if(typeof tinyMCE.get('description') != 'undefined'){
                var editorContent = tinyMCE.get('description').getContent();
            }else{
                var editorContent = jQuery('#description').val();
            }
            if(editorContent == '')
            {
                jQuery('#message_content').show();
                jQuery('#message_content').html('Please input Company description.');
            }
            else{
                jQuery('#message_content').hide();
                agent.submit('#frmAgent');
            }
        }
    {/literal}
</script>