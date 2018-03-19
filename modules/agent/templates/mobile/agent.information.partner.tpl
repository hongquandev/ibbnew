<script type="text/javascript" src="modules/general/templates/js/confirm.js"></script>
<script type="text/javascript" src="modules/agent/templates/js/checkimage.js"></script>
<script src="modules/agent/templates/js/checkcountry_register_fast.js" type="text/javascript"> </script>
<link href="/utils/ajax-upload/fileuploader.css" rel="stylesheet" type="text/css" />
<link href="/modules/property/templates/style/ajax-upload.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/utils/ajax-upload/fileuploader.js"></script>
<script type="text/javascript" src="/modules/property/templates/js/upload.js"></script>
<script type="text/javascript">
    {literal}
    var search_personal = new Search();
        search_personal._frm = '#frmAgent';
        search_personal._text_search = '#personal_suburb';
        search_personal._text_obj_1 = '#personal_state';
        search_personal._text_obj_2 = '#personal_postcode';
        search_personal._overlay_container = '#search_personal';
        search_personal._url_suff = '&type=suburb';

        search_personal._success = function(data) {
            var info = jQuery.parseJSON(data);
            var content_str = "";
            var id = 0;
            if (info.length > 0) {
                search_personal._total = info.length;
                for (i = 0; i < info.length; i++) {
                    var id = 'sitem_' + i;
                    content_str +="<li onclick='search_personal.setValue(this)' id="+id+">"+info[i]+"</li>";
                    search_personal._item.push(id);
                }
            }
            if (content_str.length > 0) {
                jQuery(search_personal._overlay_container).html(content_str);
                jQuery(search_personal._overlay_container).show();
                jQuery(search_personal._overlay_container).width(jQuery(search_personal._text_search).width());
            } else {
                jQuery(search_personal._overlay_container).hide();
            }
        };
        search_personal._getValue = function(data){
             var info = jQuery.parseJSON(data);

             jQuery(search_personal._text_obj_1).val(info[0]);

             $('#uniform-personal_state span').html($(search_personal._text_obj_1+" option:selected").text());
        };
    var search_partner = new Search();
        search_partner._frm = '#frmAgent';
        search_partner._text_search = '#postal_suburb';
        search_partner._text_obj_1 = '#postal_state';
        search_partner._text_obj_2 = '#postal_postcode';
        search_partner._overlay_container = '#search_partner';
        search_partner._url_suff = '&type=suburb';

        search_partner._success = function(data) {
            var info = jQuery.parseJSON(data);
            var content_str = "";
            var id = 0;
            if (info.length > 0) {
                search_partner._total = info.length;
                for (i = 0; i < info.length; i++) {
                    var id = 'sitem_' + i;
                    content_str +="<li onclick='search_partner.setValue(this)' id="+id+">"+info[i]+"</li>";
                    search_partner._item.push(id);
                }
            }
            if (content_str.length > 0) {
                jQuery(search_partner._overlay_container).html(content_str);
                jQuery(search_partner._overlay_container).show();
                jQuery(search_partner._overlay_container).width(jQuery(search_partner._text_search).width());
            } else {
                jQuery(search_partner._overlay_container).hide();
            }
        };
        search_partner._getValue = function(data){
             var info = jQuery.parseJSON(data);

             jQuery(search_partner._text_obj_1).val(info[0]);

             $('#uniform-postal_state span').html($(search_partner._text_obj_1+" option:selected").text());
        };

    document.onclick = function() {search_partner.closeOverlay();search_personal.closeOverlay();};
     function cancel(){
        showConfirm('Do you really exit ?','/?module=agent&action=view-dashboard','','yes/no');
     }

    function getCC(){
        if (parseInt($('#expiration_month').val()) == 0 || parseInt($('#expiration_year').val()) == 0){
            $('#expiration_date').val(0);
        } else{
            $('#expiration_date').val(parseInt($('#expiration_month').val() + $('#expiration_year').val()));
        }
    }
    var agent = new Agent();
    {/literal}
</script>

<div class="bar-title">
    <!--<h2>ADDITIONAL INFORMATION</h2>-->
    <h2>ADDITIONAL INFORMATION</h2>
</div>

<div class="ma-info mb-20px ma-info-partner">

    <div class="partner-set mb-20px">
        <div class="step-2-info">
             {if isset($message) and strlen($message)>0}
                  <div class="message-box  message-box-ie">{$message}</div>
             {/if}
		<div class="clearthis"></div>
        <form class="frm-imfor-partner" name="frmAgent" id="frmAgent" method="post" enctype="multipart/form-data">

        {*COMPANY DETAIL*}
            <div class="step-name step-name-ip-partner">
                <h2>COMPANY DETAIL</h2>
            </div>
            <div class="step-detail partner-set">
                <div class="col1">
                    Please complete all the fields marked *
                </div>
                <div class="col2 bg-f7f7f7">
                    <ul class="form-list">
                        <li class="wide">
                            <label>
                                <strong id="notify_personal_firstname">Company Name <span >*</span></strong>
                            </label>
                            <div class="input-box">
                                <input type="text" name="personal[firstname]" id="personal_firstname" value="{$form_data.personal.firstname}" class="input-text validate-require"/>
                            </div>
                        </li>

                         <li class="wide">
                            <label>
                                <strong id="notify_partner_register_number">ABN <span >*</span></strong>
                            </label>
                            <div class="input-box">
                                <input type="text" name="partner[register_number]" id="partner_register_number" value="{$form_data.partner.register_number}" class="input-text validate-require validate-number" />
                            </div>
                        </li>

                        <li class="wide">
                            <label>
                                <strong id="notify_personal_street">Company Address <span >*</span></strong>
                            </label>
                            <div class="input-box">
                                <input type="text" name="personal[street]" id="personal_address" value="{$form_data.personal.street}" class="input-text validate-require" />
                            </div>
                        </li>

                        <li class="fields">
                             <div class="field">
                                <label>
                                    <strong id="notify_personal_suburb">Suburb <span >*</span></strong>
                                </label>
                                <div class="input-box">
							        <input type="text" name="personal[suburb]" id="personal_suburb" value="{$form_data.personal.suburb}" onclick="search_personal.getData(this)" onkeyup="search_personal.moveByKey(event)" class="input-text validate-require validate-letter" autocomplete="off"/>
                                    <ul>
                                        <div id="search_personal" class="search_overlay" style="display:none; position: absolute;"></div>
                                    </ul>
 						        </div>
                            </div>

                            <div class="field">
                                <label>
                                    <strong id="notify_personal_postcode">Postcode <span >*</span></strong>
                                </label>
                                <div class="input-box">
                                    <input type="text" name="personal[postcode]" id="personal_postcode" value="{$form_data.personal.postcode}" class="input-text validate-require validate-postcode" onkeyup="Common.validRegion('/modules/property/action.php?action=validate-property','#personal_suburb','#personal_state','#personal_postcode',this,'#frmAgent')" autocomplete="off"/>
                                </div>
                            </div>

                            <div class="clearthis"></div>
                        </li>

                        <li class="fields">
                            <div class="field">
                                <label>
                                    <strong id="notify_personal_state">State <span >*</span></strong>
                                </label>
                                <div class="input-box">
                                    <div id="inactive_personal_state">
                                        <select name="personal[state]" id="personal_state" class="input-select validate-number-gtzero" onchange="Common.validRegion('/modules/property/action.php?action=validate-property','#personal_suburb','#personal_state','#personal_postcode','#frmAgent')">
                                            {html_options options = $options_state selected = $form_data.personal.state}
                                        </select>
                                    </div>
                                    <input type="text" id="personal_other_state" name="personal[other_state]" class="input-text" value="{$form_data.personal.other_state}" />
                                </div>
                            </div>

                            <div class="field">
                                <label>
                                    <strong id="notify_personal_country">Country <span >*</span></strong>
                                </label>
                                <div class="input-box">
                                    <select name="personal[country]" id="personal_country"  class="input-select validate-number-gtzero" onchange="onLoad('personal')">
                                        {html_options options = $options_country selected = $form_data.personal.country}
                                    </select>
                                </div>
                            </div>

                            <div class="clearthis"></div>
                        </li>

                        <li class="wide">
                            <label>
                                <strong id="notify_partner_postal_address">Postal Address <span >*</span></strong>
                            </label>
                            <div class="input-box">
                                <input type="text" name="partner[postal_address]" id="partner_postal_address" value="{$form_data.partner.postal_address}" class="input-text validate-require" />
                            </div>
                        </li>

                        <li class="fields">
                            <div class="field">
                                <label>
                                    <strong id="notify_postal_state">State <span >*</span></strong>
                                </label>
                                <div class="input-box">
                                    <div id="inactive_postal_state">
                                        <select name="partner[postal_state]" id="postal_state" class="input-select validate-number-gtzero">
                                            {html_options options = $options_state selected = $form_data.partner.postal_state}
                                        </select>
                                    </div>
                                    <input type="text" id="postal_other_state" name="partner[postal_other_state]" class="input-text" value="{$form_data.partner.postal_other_state}" />
                                </div>
                            </div>
                            <div class="field">
                                <label>
                                    <strong id="notify_postal_country">Country <span >*</span></strong>
                                </label>
                                <div class="input-box">
                                    <select name="partner[postal_country]" id="postal_country"  class="input-select validate-number-gtzero" onchange="onLoad('postal')">
                                        {html_options options = $options_country selected = $form_data.partner.postal_country}
                                    </select>
                                </div>
                            </div>

                            <div class="clearthis"></div>
                        </li>


                        <li class="fields">
                             <div class="field">
                                <label>
                                    <strong id="notify_postal_suburb">Suburb <span >*</span></strong>
                                </label>
                                <div class="input-box">
							        <input type="text" name="partner[postal_suburb]" id="postal_suburb" value="{$form_data.partner.postal_suburb}" onclick="search_partner.getData(this)" onkeyup="search_partner.moveByKey(event)" class="input-text validate-require validate-letter" autocomplete="off"/>
                                    <ul>
                                        <div id="search_partner" class="search_overlay" style="display:none; position: absolute;"></div>
                                    </ul>
 						        </div>
                            </div>

                            <div class="field">
                                <label>
                                    <strong id="notify_postal_postcode">Postcode <span >*</span></strong>
                                </label>
                                <div class="input-box">
                                    <input type="text" name="partner[postal_postcode]" id="postal_postcode" value="{$form_data.partner.postal_postcode}" class="input-text validate-require validate-postcode" autocomplete="off"/>
                                </div>
                            </div>

                            <div class="clearthis"></div>
                        </li>

                        <li class="fields">
                            <div class="field">
                                <label>
                                    <strong id="notify_personal_telephone">Telephone <span >*</span></strong>
                                </label>
                                <div class="input-box">
                                    <input type="text" name="personal[telephone]" id="personal_telephone" value="{$form_data.personal.telephone}" class="input-text validate-require validate-telephone" />
                                </div>
                            </div>

                            <div class='clearthis'></div>
                        </li>

                        {if $form_data.partner.partner_logo != ''}
                        <li class="wide">
                            <label>
                                <strong>Logo File <span>*</span></strong>
                            </label>

                            <div class="input-box">
                                <div id="logo">
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
                                            photo.uploader('btn_photo','logo','/modules/agent/action.php?action=upload_logo');
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
                                <strong id="notify_partner_description">Description <span>*</span></strong>
                            </label>
                            <div class="input-box">
                                <textarea class="input-text validate-require" rows="4" cols="15" id="partner_description" name="partner[description]">{$form_data.partner.description}</textarea>
                            </div>
                        </li>


                    </ul>
                </div>
            </div>
            <div class="clearthis"></div>


            {*CONTACT*}
            <div class="step-name step-name-ip-partner2">
                <h2>ACCOUNT INFORMATION</h2>
            </div>
            <div class="step-detail partner-set partner-set-ip-partner2">
                <div class="col1">
                    Please complete all the fields marked *
                </div>
                <div class="col2 bg-f7f7f7">
                    <ul class="form-list">
                        <li class="wide">
                            <label>
                                <strong id="notify_personal_email_address">Email <span>*</span></strong>
                            </label>

                            <div class="input-box">
                                <input type="text" name="personal[email_address]" id="personal_email"
                                       value="{$form_data.personal.email_address}"
                                       class="input-text validate-require validate-email"
                                       onkeyup="Common.existEmail('/modules/agent/action.php?action=exist_email',this,{$agent_id})"
                                       autocomplete="off"/>
                            </div>
                        </li>


                        <li class="control">

{*
                            {if $form_data.partner.contact_references == 1}
                                  <input type="checkbox"name="partner[contact_references]" id="partner_contact_references" checked="checked" value="1"/>
                                    {else}
                                  <input type="checkbox" name="partner[contact_references]" id="partner_contact_references" value="0" />
                            {/if}
                            <label><strong>Contact references </strong></label>*}
{*

                             {if $form_data.partner.debit_card == 1}
                                <input type="checkbox" name="partner[debit_card]" id="partner_debit_card" checked="checked" value="1"/>
                                {else}
                                <input type="checkbox" name="partner[debit_card]" id="partner_debit_card" value="0" />
                             {/if}
                             <label><strong>Debit card </strong></label>
*}

                        </li>

                    </ul>
                </div>
            </div>
            <div class="clearthis"></div>

            {*CREDITCARD*}

            {*
                <div class="step-name step-name-ip-partner2">
                    <h2>CREDITCARD INFORMATION</h2>
                </div>
                <div class="step-detail partner-set">
                    <div class="col1">
                        Register here to setup an account to inspect, bid, buy... Complete the below...
                        Please complete all the fields marked *
                    </div>
                    <div class="col2 bg-f7f7f7">
                        <ul class="form-list">
                            <li class="wide">
                                <label>
                                    <strong id="notify_card_type">Card type <span >*</span></strong>
                                </label>
                                <div class="input-box">
                                    <select name="credit[card_type]" id="card_type"  class="input-select validate-require">
                                        {html_options options = $options_card_type selected = $form_data.credit.card_type}
                                    </select>
                                </div>
                            </li>

                            <li class="wide">
                                <label>
                                    <strong id="notify_card_name">Name on card <span >*</span></strong>
                                </label>
                                <div class="input-box">
                                    <input type="text" name = "credit[card_name]" id = "card_name" value="{$form_data.credit.card_name}" class="input-text validate-require" />
                                </div>
                            </li>

                            <li class="wide">
                                <label>
                                    <strong id="notify_card_number">Credit card number <span >*</span></strong>
                                </label>
                                <div class="input-box">
                                    <input type="text" name = "credit[card_number]" id = "card_number" value="{$form_data.credit.card_number}" class="input-text validate-require validate-digits" />
                                </div>
                            </li>

                            <li class="wide">
                                <label>
                                    <strong id="notify_expiration_date">Expiration date <span>*</span></strong>
                                     <input type="hidden" id="expiration_date" class="validate-number-gtzero" value="{$form_data.credit.expiration_month}{$form_data.credit.expiration_year}" />
                                </label>
                                <div class="input-box">
                                    <div style="width:60%;float:left">
                                        <select name="credit[expiration_month]" id="expiration_month"  onchange="getCC();" class="input-select validate-require">
                                        {html_options options = $options_month selected = $form_data.credit.expiration_month}
                                        </select>
                                    </div>
                                    <div style="width:40%;float:left">
                                        <select name="credit[expiration_year]" id="expiration_year"  onchange="getCC();" class="input-select validate-require">
                                        {html_options options = $options_year selected = $form_data.credit.expiration_year}
                                        </select>
                                    </div>
                                </div>
                            </li>
                            <li></li>
                        </ul>
                    </div>
                </div> <!-- ENd Credit Card -->
            *}

             </form>
            <div class="clearthis"></div>

             <div class="buttons-set buttons-set-ipartner">
                <button class="btn-red btn-red-re-buyer" onclick="agent.submit('#frmAgent');">
                    <span><span>Save</span></span>
                </button>
                <button class="btn-red btn-red-re-buyer" onclick="cancel();">
                    <span><span>Cancel</span></span>
                </button>
            </div>


        </div>
    </div>

</div>
{literal}
<script type="text/javascript">
    jQuery(document).ready(function(){
        onLoad('personal');
        onLoad('postal');
    });

</script>
{/literal}