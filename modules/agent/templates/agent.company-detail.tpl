<link href="/utils/ajax-upload/fileuploader.css" rel="stylesheet" type="text/css" />
<link href="modules/property/templates/style/ajax-upload.css" rel="stylesheet" type="text/css" />
{*<script type="text/javascript" src="/modules/agent/templates/js/checkimage.js"></script>*}
<script type="text/javascript" src="/utils/ajax-upload/fileuploader.js"></script>
<script type="text/javascript" src="/modules/property/templates/js/upload.js"></script>
<script type="text/javascript">
    var search = new Search();
    search._frm = '#frmAgent';
    search._text_search = '#postal_suburb';
    search._text_obj_1 = '#postal_state';
    search._text_obj_2 = '#postal_postcode';
    search._overlay_container = '#search';
    search._url_suff = '&' + 'type=suburb';
    {literal}
    search._success = function (data) {
        var info = jQuery.parseJSON(data);
        var content_str = "";
        var id = 0;
        if (info.length > 0) {
            search._total = info.length;
            search._current = -1;
            for (i = 0; i < info.length; i++) {
                var id = 'sitem_' + i;
                content_str += "<li onclick='search.setValue(this)' id=" + id + ">" + info[i] + "</li>";
                search._item.push(id);
            }
        }
        search._getValue = function (data) {
            var info = jQuery.parseJSON(data);
            jQuery(search._text_obj_1).val(info[0]);
            $('#uniform-postal_state span').html($(search._text_obj_1 + " option:selected").text());
        };
        if (content_str.length > 0) {
            jQuery(search._overlay_container).html(content_str);
            jQuery(search._overlay_container).show();
            jQuery(search._overlay_container).width(jQuery(search._text_search).width());
        } else {
            jQuery(search._overlay_container).hide();
        }
		jQuery(search._text_search).removeClass('search_loading');
    };
    document.onclick = function () {
        search.closeOverlay();
    };
    jQuery(document).ready(function(){
        onLoad('postal');
    });
    {/literal}
</script>
<ul class="form-list form-company" id="form-lper">
    <form name="frmAgent" id="frmAgent" method="post" action="{$form_action}">
        <li class="wide">
            <div class="field">
                <label>
                    <strong>Company Name <span id="notify_firstname">*</span></strong>
                </label>

                <div class="input-box">
                    <input type="text" name="field[firstname]" id="firstname" value="{$form_data.personal.firstname}"
                           class="input-text validate-require"/>
                </div>
            </div>
        </li>
        <li class="wide">
            <label>
                <strong>ABN / ACN <span>*</span></strong>
            </label>

            <div class="input-box">
                <input type="text" name="partner[register_number]" id="register_number" value="{$form_data.partner.register_number}"
                       class="input-text validate-require validate-number"/>
            </div>
        </li>
        <li class="fields">
            <div class="field">
                <label><strong>Company Address <span>*</span></strong></label>

                <div class="input-box">
                    <input type="text" name="field[street]" id="street" value="{$form_data.personal.street}"
                           class="input-text validate-require"/>
                </div>
            </div>
            <div class="field">
                <label><strong>Postal Address <span>*</span></strong></label>

                <div class="input-box">
                    <input type="text" name="partner[postal_address]" id="postal_address" value="{$form_data.partner.postal_address}"
                           class="input-text validate-require"/>
                </div>
            </div>
        </li>
        <li class="fields">
            <div class="field">
                <label>
                    <strong>Suburb <span>*</span></strong>
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
                    <strong>Suburb <span>*</span></strong>
                </label>

                <div class="input-box">
                    <input type="text" name="partner[postal_suburb]" id="postal_suburb" value="{$form_data.partner.postal_suburb}"
                           class="input-text validate-require validate-letter" onclick="search.getData(this)"
                           onkeyup="search.moveByKey(event)" autocomplete="off"/>
                    <ul>
                        <div id="search" class="search_overlay" style="display:none; position: absolute;"></div>
                    </ul>
                </div>
            </div>
        </li>
        <li class="fields">
            <div class="field">
                <label>
                    <strong>Postcode <span>*</span></strong>
                </label>

                <div class="input-box">
                    <input type="text" name="field[postcode]" id="personal_postcode" value="{$form_data.personal.postcode}"
                           class="input-text validate-require validate-postcode"
                           onchange="Common.validRegion('/modules/property/action.php?action=validate-property','#personal_suburb','#personal_state',this,'#frmAgent')"
                           autocomplete="off"/>
                </div>
            </div>

             <div class="field">
                <label>
                    <strong>Postcode <span>*</span></strong>
                </label>

                <div class="input-box">
                    <input type="text" name="partner[postal_postcode]" id="postal_postcode" value="{$form_data.partner.postal_postcode}"
                           class="input-text validate-require validate-postcode"
                           onchange="Common.validRegion('/modules/property/action.php?action=validate-property','#postal_suburb','#postal_state',this,'#frmAgent')"
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
                    <div id="inactive_personal_state" class="input-select">
                        <select name="field[state]" id="personal_state" class="input-select validate-number-gtzero"
                                onchange="Common.validRegion('/modules/property/action.php?action=validate-property','#personal_suburb','#personal_state','#personal_postcode','#frmAgent')">
                        {html_options options = $subState selected = $form_data.personal.state}
                        </select>
                    </div>
                    <input type="text" id="personal_other_state" name="field[other_state]" class="input-text"
                           value="{$form_data.personal.other_state}"/>
                </div>
            </div>
            <div class="field">
                <label>
                    <strong>State <span>*</span></strong>
                </label>

                <div class="input-box">
                    <div id="inactive_postal_state" class="input-select">
                        <select name="partner[postal_state]" id="postal_state" class="input-select validate-number-gtzero"
                                onchange="Common.validRegion('/modules/property/action.php?action=validate-property','#postal_suburb','#postal_state','#postal_postcode','#frmAgent')">
                        {html_options options = $subState selected = $form_data.partner.postal_state}
                        </select>
                    </div>
                    <input type="text" id="postal_other_state" name="partner[postal_other_state]" class="input-text"
                           value="{$form_data.partner.postal_other_state}"/>
                </div>
            </div>
        </li>

        <li class="fields">
            <div class="field">
                <label>
                    <strong>Country <span id="notify_country">*</span></strong>
                </label>

                <div class="input-box input-select" >
                    <select name="field[country]" id="personal_country" class="input-select validate-number-gtzero"
                            onchange="onLoad('personal')">
                    {html_options options = $options_country selected = $form_data.personal.country}
                    </select>
                </div>
            </div>

            <div class="field">
                <label>
                    <strong>Country <span>*</span></strong>
                </label>

                <div class="input-box input-select">
                    <select name="partner[postal_country]" id="postal_country" class="input-select validate-number-gtzero"
                            onchange="onLoad('postal')">
                    {html_options options = $options_country selected = $form_data.partner.postal_country}
                    </select>
                </div>
            </div>
        </li>

        <li class="wide">
                <label>
                    <strong>Website</strong>
                </label>

                <div class="input-box">
                    <input type="text" name="field[website_partner]" id="website_partner" value="{$form_data.personal.website_partner}"
                           class="input-text validate-url"/>
                </div>
        </li>
        <li class="fields">
            <div class="field">
                <label>
                    <strong>Telephone <span id="notify_telephone">*</span></strong>
                </label>

                <div class="input-box">
                    <input type="text" name="field[telephone]" id="personal_telephone" value="{$form_data.personal.telephone}"
                           class="input-text validate-require validate-telephone"/>
                </div>
            </div>
            <div class="field">
                <label>
                    <strong>Company Email <span>*</span></strong>
                </label>

                <div class="input-box">
                    <input type="text" name="field[general_contact_partner]" id="general_contact_partner" value="{$form_data.personal.general_contact_partner}"
                           class="input-text validate-require validate-email"/>
                </div>
            </div>
        </li>

        {if $form_data.partner.partner_logo != ''}
        <li class="wide">
            <label>
                <strong>Logo File <span>*</span></strong>
            </label>

            <div class="input-box">
                <div id="container-logo">
                    <img src="{$MEDIAURL}/store/uploads/banner/images/partner/{$form_data.partner.partner_logo}"
                         alt="{$form_data.partner.partner_logo}" style="max-width:185px; max-height:154px;"/>

                    <div class="clearthis"></div>
                </div>
            </div>
        </li>
        {/if}
        <li class="wide" id="upload-logo">
            <label>
                <strong>Upload Logo File <span id="notify_street">*</span></strong>
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
							photo.uploader('btn_photo','logo','/modules/agent/action.php?action=upload_logo&container=container-logo');
                        </script>
                </div>
                <br style="margin-top:5px;" />
                <i> You must upload with one of the following extensions: jpg, jpeg, gif, png. </i> <br
                    style="margin-bottom:5px;" />
                <i> Max size: 2Mb.</i>
            </div>
        </li>

        <li class="wide">
            <label>
                <strong>Description <span>*</span></strong>
            </label>

            <div class="input-box">
                <textarea class="input-text validate-require" rows="8" cols="15" id="desc"
                          name="partner[description]">{$form_data.partner.description}</textarea>
            </div>
        </li>
    </form>
</ul>
