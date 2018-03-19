{literal}
<script type="text/javascript">
    function tinyMCEinit() {
        tinyMCE.init({
            mode:"specific_textareas",
            editor_selector:"content-adduser",
            theme:"advanced",
            height:"300",
            width:'397',
            plugins:"ibrowser,autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",
            theme_advanced_buttons1:"bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist",
            theme_advanced_buttons2:"",
            theme_advanced_buttons3:"",
            theme_advanced_toolbar_location:"top",
            theme_advanced_toolbar_align:"left",
            theme_advanced_statusbar_location:"bottom",
            /*theme_advanced_resizing_min_width: 393,*/
            /*theme_advanced_source_editor_width:500,*/
            theme_advanced_resizing:true,
            content_css:"css/content.css",
            template_external_list_url:"lists/template_list.js",
            external_link_list_url:"lists/link_list.js",
            external_image_list_url:"lists/image_list.js",
            media_external_list_url:"lists/media_list.js",

            style_formats:[
                {title:'Bold text', inline:'b'},
                {title:'Red text', inline:'span', styles:{color:'#ff0000'}},
                {title:'Red header', block:'h1', styles:{color:'#ff0000'}},
                {title:'Example 1', inline:'span', classes:'example1'},
                {title:'Example 2', inline:'span', classes:'example2'},
                {title:'Table styles'},
                {title:'Table row 1', selector:'tr', classes:'tablerow1'}
            ]
        });
    }
    var myEditor = null;
    function YUIEditor() {
        myEditor = new YAHOO.widget.SimpleEditor('description', {
            height: '300px',
            width: '397px',
            dompath: true,
            toolbar: {
                titlebar: '',
                buttons: [
                    { group: 'textstyle', label: 'Font Style',
                        buttons: [
                            { type: 'push', label: 'Bold', value: 'bold' },
                            { type: 'push', label: 'Italic', value: 'italic' },
                            { type: 'push', label: 'Underline', value: 'underline' },
                            { type: 'separator' },
                            { type: 'select', label: 'Arial', value: 'fontname', disabled: true,
                                menu: [
                                    { text: 'Arial', checked: true },
                                    { text: 'Arial Black' },
                                    { text: 'Comic Sans MS' },
                                    { text: 'Courier New' },
                                    { text: 'Lucida Console' },
                                    { text: 'Tahoma' },
                                    { text: 'Times New Roman' },
                                    { text: 'Trebuchet MS' },
                                    { text: 'Verdana' }
                                ]
                            },
                            { type: 'spin', label: '13', value: 'fontsize', range: [ 9, 75 ], disabled: true },
                            { type: 'separator' },
                            { type: 'color', label: 'Font Color', value: 'forecolor', disabled: true },
                            { type: 'color', label: 'Background Color', value: 'backcolor', disabled: true }
                        ]
                    }
                ]
            }
        });
        myEditor.render();
    }
    tinyMCEinit();
</script>
{/literal}
<script src="modules/agent/templates/js/checkcountry_register_fast.js" type="text/javascript"></script>
<link href="/utils/ajax-upload/fileuploader.css" rel="stylesheet" type="text/css" />
<link href="/modules/property/templates/style/ajax-upload.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/utils/ajax-upload/fileuploader.js"></script>
<script type="text/javascript" src="/modules/property/templates/js/upload.js"></script>
{literal}
<script type="text/javascript">
var RecaptchaOptions = {
    theme : 'white'
};
var agent = new Agent();
var search_overlay = new Search();
    search_overlay._frm = '#frmAgent';
    search_overlay._text_search = '#personal_suburb';
    search_overlay._text_obj_1 = '#personal_state';
    search_overlay._text_obj_2 = '#personal_postcode';
    search_overlay._overlay_container = '#search_overlay';
    search_overlay._url_suff = '&' + 'type=suburb';

search_overlay._success = function(data) {
    var info = jQuery.parseJSON(data);
    var content_str = "";
    var id = '';
    if (info.length > 0) {
        search_overlay._total = info.length;
        for (i = 0; i < info.length; i++) {
            var id = 'sitem_' + i;
            content_str += "<li onclick='search_overlay.setValue(this)' id=" + id + ">" + info[i] + "</li>";
            search_overlay._item.push(id);
        }
    }
    search_overlay._getValue = function(data) {
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
document.onclick = function() {
    search_overlay.closeOverlay();
};
</script>
{/literal}

<div class="bar-title">
    <h2>REGISTER {$agent_type} USER</h2>
</div>
<form name="frmAgent" id="frmAgent" method="post" action="{$form_action}">
<div class="ma-info mb-20px ma-info-partner yui-skin-sam">
    <div class="partner-set mb-20px">
        <div class="step-2-info">
             {if isset($message) and strlen($message)>0}
                  <div class="message-box  message-box-ie">{$message}</div>
             {/if}
             <div id="message_content" class="message-box message-box-ie" style="display: none;">
             </div>
		<div class="clearthis"></div>
        <div class="step-name step-name-ip-partner step-name-user-detail">
                <h2>USER DETAIL</h2>
        </div>
            <div class="step-detail partner-set">
                <div class="col1">
                    Register here to setup an account to inspect, bid, buy... Complete the below...
                    Please complete all the fields marked *
                </div>
                <div class="col2 bg-f7f7f7">
                    <ul class="form-list">
                        <li class="fields">
                            <div class="field">
                                <label>
                                    <strong id="notify_firstname">First Name <span>*</span></strong>
                                </label>

                                <div class="input-box">
                                    <input type="text" name="field[firstname]" id="personal_firstname" value="{$form_datas.personal.firstname}"
                                           class="input-text validate-require" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="field">
                                <label>
                                    <strong id="notify_lastname">Last Name <span>*</span></strong>
                                </label>

                                <div class="input-box">
                                    <input type="text" name="field[lastname]" id="personal_lastname" value="{$form_datas.personal.lastname}"
                                           class="input-text validate-require" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="clearthis"></div>
                        </li>

                        {*{if $authentic.type == 'theblock'}
                        <li class="wide">
                            <label>
                                <strong id="notify_street">Address <span>*</span></strong>
                            </label>

                            <div class="input-box">
                                <input type="text" name="field[street]" id="street" value="{$form_datas.personal.street}" class="input-text validate-require"
                                       autocomplete="off"/>
                            </div>
                        </li>

                        <li class="fields">
                            <div class="field">
                                <label>
                                    <strong id="notify_suburb">Suburb <span>*</span></strong>
                                </label>

                                <div class="input-box">
                                    <input type="text" name="field[suburb]" id="personal_suburb" value="{$form_datas.personal.suburb}"
                                           class="input-text validate-require validate-letter" onclick="search_overlay.getData(this)"
                                           onkeyup="search_overlay.moveByKey(event)" autocomplete="off"/>
                                           <div id="search_overlay" class="search_overlay" style="display:none; position: absolute;*left: 212px;*margin-top: 24px;"></div>
                                </div>
                            </div>

                            <div class="field">
                                <label>
                                    <strong id="notify_postcode">Postcode <span>*</span></strong>
                                </label>

                                <div class="input-box">
                                    <input type="text" name="field[postcode]" id="personal_postcode" value="{$form_datas.personal.postcode}"
                                           class="input-text validate-require validate-postcode"
                                           onkeyup="Common.validRegion('/modules/property/action.php?action=validate-property','#suburb','#state','#postcode','#frmAgent')"
                                           autocomplete="off"/>
                                </div>
                            </div>
                        </li>

                        <li class="fields">
                            <div class="field">
                                <label>
                                    <strong id="notify_state">State <span>*</span></strong>
                                </label>

                                <div class="input-box">
                                    <div id="inactive_personal_state">
                                        <select name="field[state]" id="personal_state" class="input-select validate-number-gtzero"
                                                onchange="Common.validRegion('/modules/property/action.php?action=validate-property','#personal_suburb','#personal_state','#personal_postcode','#frmAgent')">
                                            {html_options options=$subState selected =$form_datas.personal.state}
                                        </select>
                                    </div>
                                    <input type="text" id="personal_other_state" name="field[other_state]" class="input-text"
                                           value="{$form_datas.personal.other_state}"/>
                                </div>
                            </div>
                             <div class="field" id="inactive_country">
                                <label>
                                    <strong id="notify_country">Country <span>*</span></strong>
                                </label>

                                <div class="input-box">
                                    <select name="field[country]" id="personal_country" class="input-select validate-number-gtzero"
                                            onchange="onLoad('personal')">
                                        {html_options options = $options_country selected = $form_datas.personal.country}
                                    </select>

                                </div>
                            </div>
                            <div class="clearthis">
                            </div>
                        </li>


                        <li class="fields">
                            <div class="field">
                                <label>
                                    <strong id="notify_telephone">Telephone <span>*</span></strong>
                                </label>

                                <div class="input-box">
                                    <input type="text" name="field[telephone]" id="personal_telephone" value="{$form_datas.personal.telephone}"
                                           class="input-text validate-require validate-telephone" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="field">
                                <label>
                                    <strong id="notify_mobilephone">Mobile Phone <span>*</span></strong>
                                </label>

                                <div class="input-box">
                                    <input type="text" name="field[mobilephone]" id="personal_mobilephone" value="{$form_datas.personal.mobilephone}"
                                           class="input-text validate-require validate-telephone" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="clearthis">
                            </div>
                        </li>
                        {else}*}
                        <li class="wide">
                            <label>
                                <strong id="notify_address">Office Address <span>*</span></strong>
                            </label>

                            <div class="input-box">
                                <input type="text" name="company[address]" id="address" value="{$form_datas.company.address}" class="input-text validate-require"
                                       autocomplete="off"/>
                            </div>
                        </li>
                        <li class="fields">
                            <div class="field">
                                <label>
                                    <strong id="notify_personal_suburb">Suburb <span>*</span></strong>
                                </label>
                                <div class="input-box">
                                    <input type="text" name="company[suburb]" id="personal_suburb" value="{$form_datas.company.suburb}"
                                           class="input-text validate-require validate-letter" onclick="search_overlay.getData(this)"
                                           onkeyup="search_overlay.moveByKey(event)" autocomplete="off"/>
                                           <div id="search_overlay" class="search_overlay" style="display:none; position: absolute;*left: 212px;*margin-top: 24px;"></div>
                                </div>
                            </div>
                            <div class="field">
                                <label>
                                    <strong id="notify_personal_postcode">Postcode <span>*</span></strong>
                                </label>

                                <div class="input-box">
                                    <input type="text" name="company[postcode]" id="personal_postcode" value="{$form_datas.company.postcode}"
                                           class="input-text validate-require validate-postcode"
                                           onkeyup="Common.validRegion('/modules/property/action.php?action=validate-property','#suburb','#state','#postcode','#frmAgent')"
                                           autocomplete="off"/>
                                </div>
                            </div>
                        </li>
                        <li class="fields">
                            <div class="field">
                                <label>
                                    <strong id="notify_personal_state">State <span>*</span></strong>
                                </label>
                                <div class="input-box">
                                    <div id="inactive_personal_state">
                                        <select name="company[state]" id="personal_state" class="input-select validate-number-gtzero"
                                                onchange="Common.validRegion('/modules/property/action.php?action=validate-property','#personal_suburb','#personal_state','#personal_postcode','#frmAgent')">
                                            {html_options options=$subState selected =$form_datas.company.state}
                                        </select>
                                    </div>
                                    <input type="text" id="personal_other_state" name="company[other_state]" class="input-text"
                                           value="{$form_datas.company.other_state}"/>
                                </div>
                            </div>
                            <div class="field" id="inactive_personal_country">
                               <label>
                                   <strong id="notify_personal_country">Country <span>*</span></strong>
                               </label>

                               <div class="input-box">
                                   <select name="company[country]" id="personal_country" class="input-select validate-number-gtzero"
                                           onchange="onLoad('personal')">
                                       {html_options options = $options_country selected = $form_datas.company.country}
                                   </select>
                               </div>
                           </div>
                            <div class="clearthis">
                            </div>
                        </li>
                        <li class="fields">
                            <div class="field">
                                <label>
                                    <strong id="notify_personal_telephone">Telephone <span>*</span></strong>
                                </label>

                                <div class="input-box">
                                    <input type="text" name="company[telephone]" id="personal_telephone" value="{$form_datas.company.telephone}"
                                           class="input-text validate-require validate-telephone" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="field">
                                <label>
                                    <strong id="notify_website">Website</strong>
                                </label>

                                <div class="input-box">
                                    <input type="text" name="company[website]" id="website" value="{$form_datas.company.website}"
                                           class="input-text validate-url" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="clearthis">
                            </div>
                        </li>
                        {*{/if}*}
                        <li class="wide">
                            <label>
                                <strong id="notify_email_address">Email <span>*</span></strong>
                            </label>
                            <div class="input-box">
                                <input type="text" name="field[email_address]" id="email_address" value="{$form_datas.personal.email_address}"
                                       class="input-text validate-require validate-email"
                                       onkeyup="Common.existEmail('/modules/{$module}/action.php?action=exist_email',this,{$form_datas.agent_id})"
                                       autocomplete="off"/>
                            </div>
                        </li>
                        <!-- Confirm Email -->
                        {if $form_datas.agent_id == 0}
                        <li class="wide">
                            <label>
                                <strong id="notify_confirm_email_address">Confirm Email <span>*</span></strong>
                            </label>
                            <div class="input-box">
                                <input type="text" name="field[confirm_email_address]" id="confirm_email_address" value=""
                                       class="input-text validate-require validate-email"
                                       autocomplete="off"/>
                            </div>
                        </li>
                        {/if}
                        {if $form_datas.personal.logo != ''}
                        <li class="wide">
                            <label>
                                <strong>Logo</strong>
                            </label>
                            <div class="input-box">
                                <div id="logo">
                                    <img src="{$MEDIAURL}/{$form_datas.personal.logo}"
                                         alt="{$form_datas.personal.logo}"/>
                                    <div class="clearthis"></div>
                                </div>
                            </div>
                        </li>
                        {/if}
                        <li class="wide" id="upload-logo">
                            <label>
                                <strong>Upload Logo Of {$agent_type}</strong>
                            </label>
                            <div class="input-box">
                                <div class="input-box file-upload">
                                        <div id="btn_photo" style="float:left"></div>
                                        <ul id="lst_photo" style="float:left;margin-left:10px" class="qq-upload-list">
                                                No file chosen
                                        </ul>
                                        <br clear="all"/>
                                        <script type="text/javascript">
                                            var photo = new Media();
                                            photo.uploader('btn_photo','logo','/modules/agent/action.php?action=upload_logo_block&id={$form_datas.agent_id}');
                                        </script>
                                </div>
                                <i> You must upload with one of the following extensions: jpg, jpeg, gif, png. </i> <br
                                    style="margin-bottom:5px;" />
                                <i> Max size: 2Mb.</i>
                            </div>
                        </li>
                        {if $authentic.type == 'agent'}
                            <li class="wide">
                                 <label>
                                    <strong id="notify_description">Description <span>*</span></strong>
                                </label>
                                <textarea rows="6" cols="" name="company[description]" id="description" class="content-adduser" style="width:397px;height: 300px">{$form_datas.company.description}</textarea>
                            </li>
                        {/if}
                        <li class="wide">
                            {if $captcha_enable == 1}
                                <center>
                                    {$captcha_form}
                                </center>
                            {/if}
                        </li>
                    </ul>
                    <div class="clearthis"></div>
                    <div class="buttons-set buttons-set-ipartner" id="buttons-set-iuser">
                        <button type="button" class="btn-red btn-red-s-use" onclick="_submitSave('{$authentic.type}')">
                            <span><span>Save</span></span>
                        </button>
                        {*<button class="btn-red btn-red-a-user" onclick="document.location='index.php?module=agent&action=add-user'">
                            <span><span>Add New User</span></span>
                        </button>*}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
{literal}
<SCRIPT TYPE="text/javascript">
	function disableEnterKey(e){
         var key;
         if(window.event) key = window.event.keyCode;
         else key = e.which;
         return (key != 13);
    }
    jQuery(document).ready(function(){
        onLoad('personal');
        $('input').bind('keypress',function(event){
            return disableEnterKey(event);
        });
    });
    function _submitSave(type){
        if(type == 'agent')
        {
            if(typeof tinyMCE.get('description') != 'undefined'){
                var editorContent = tinyMCE.get('description').getContent();
            }else
            {
                var editorContent = jQuery('#description').val();
            }
            if(editorContent == '')
            {
                jQuery('#message_content').show();
                jQuery('#message_content').html('Please input Company description.');
            }else
            {
                jQuery('#message_content').hide();
                agent.submit('#frmAgent');
            }
        }else
        {
            agent.submit('#frmAgent');
        }
    }
</SCRIPT>
{/literal}

