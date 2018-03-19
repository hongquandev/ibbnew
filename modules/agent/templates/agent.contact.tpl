{literal}

<script src="modules/agent/templates/js/checkcountry.js" type="text/javascript"> </script>

<script type="text/javascript">
var search_overlay = new Search();
        search_overlay._frm = '#frmAgent';
        search_overlay._text_search = '#suburb';
        search_overlay._text_obj_1 = '#state';
        search_overlay._text_obj_2 = '#postcode';
        search_overlay._overlay_container = '#search_overlay';
        search_overlay._url_suff = '&'+'type=suburb';

        search_overlay._success = function(data) {
            var info = jQuery.parseJSON(data);
            var content_str = "";
            var id = 0;
            if (info.length > 0) {
                search_overlay._total = info.length;
                for (i = 0; i < info.length; i++) {
                    var id = 'sitem_' + i;
                    content_str +="<li onclick='search_overlay.setValue(this)' id="+id+">"+info[i]+"</li>";
                    search_overlay._item.push(id);
             }
        }

        search_overlay._getValue = function(data){
             var info = jQuery.parseJSON(data);

             jQuery(search_overlay._text_obj_1).val(info[0]);
             $('#uniform-state span').html($(search_overlay._text_obj_1+" option:selected").text());



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

document.onclick = function() {search_overlay.closeOverlay()};
</script>
{/literal}
<div class="bar-title">
    <h2>{localize translate="MY CONTACT DETAILS"}</h2>
</div>
<div class="ma-info mb-20px contact-main">

    <div class="col2-set mb-20px">
        <div class="col">
            <div>
            {if isset($message) and strlen($message)>0}
                        <div class="message-box  message-box-ie">{$message}</div>
                        <div class="clearthis"></div>
            {/if}
                <ul class="form-list form-company">
                    <form name = "frmAgent" id= "frmAgent" method = "post" action ="{$form_action}" >
                    <li class="wide">
                        <label>
                            <strong>{localize translate="Contact name"} <span id="notify_name">*</span></strong>
                        </label>
                        <div class="input-box">
                            <input type="text" name="field[name]" id="name" value="{$form_data.name}" class="input-text validate-require" />
                        </div>
                    </li>
                    
                    <li class="wide">
                        <label>
                            <strong>{localize translate="Address"} <span id="notify_address">*</span></strong>
                        </label>
                                <ul>
                                    <div id="search_address" class="search_overlay" style="display:none; position: absolute;"></div>
                                </ul>
                        <div class="input-box">
                            <input type="text" name="field[address]" id="address" value="{$form_data.address}" class="input-text validate-require" />
                        </div>
                    </li>
                    <li class="fields">
                        <div class="field">
                            <label>
                                <strong>{localize translate="Suburb"} <span id="notify_suburb">*</span></strong>
                            </label>
                            <div class="input-box">
                                <input type="text" name="field[suburb]" id="suburb" value="{$form_data.suburb}" class="input-text validate-require validate-letter" onclick="search_overlay.getData(this)" onkeyup="search_overlay.moveByKey(event)" autocomplete="off"/>
                                 <ul>
                                    <div id="search_overlay" class="search_overlay" style="display:none; position: absolute;"></div>
                                </ul>
                            </div>
                        </div>

                        <div class="field">
                            <label>
                                <strong>{localize translate="Postcode"} <span id="notify_postcode">*</span></strong>
                            </label>
                            <div class="input-box">
                                <input type="text" name="field[postcode]" id="postcode" value="{$form_data.postcode}" class="input-text validate-require validate-postcode" onkeyup="Common.validRegion('/modules/property/action.php?action=validate-property','#suburb','#state','#postcode','#frmAgent')" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="clearthis">
                        </div>
                    </li>
                    
                   {* <li class="wide" id="active_country" style="display:none">
                        Change Country if Country is choose Other -->
                        <div class="field">
                            <label>
                                <strong id="notify_country">Country Name <span >*</span></strong>
                            </label>
                            <div class="input-box">
                                <input type="text" id="other_country" name="field[other_country]" value="{$form_data.other_country}" class="input-text" />                       
                            </div>
                        </div>
                      <!-- End Change Country is choose Other -->      
                   </li>*}
                   
                    <li class="fields">
                         <div class="field" id="inactive_state">
                            <label>
                                <strong>{localize translate="State"} <span id="notify_state">*</span></strong>
                            </label>
                            <div class="input-box contact-input-box input-select">

                             {if $form_data.other_state != '' or $form_data.other_state == ''}

                                <select name="field[state]" id="state"  class="input-select validate-number-gtzero" onchange="Common.validRegion('/modules/property/action.php?action=validate-property','#suburb','#state','#postcode','#frmAgent')">
                                    {html_options options = $subState selected = $form_data.state}
                                </select>

                                {else}

                                     <select name="field[state]" id="state"  class="input-select validate-number-gtzero" onchange="Common.validRegion('/modules/property/action.php?action=validate-property','#suburb','#state','#postcode','#frmAgent')">
                                    {html_options options = $options_state selected = $form_data.state}
                                </select>

                             {/if}   
                            </div>
                        </div>

                         <!-- Change Text Suburb With Country is not Australia -->
                           <div class="field" id="active_state" style="display:none;">
                            <label>
                                 <strong>{localize translate="State"} <span id="notify_state">*</span></strong>
                            </label>
                            <div class="input-box">
                                {if $form_data.other_state == ''}
                                     <input type="text" id="other_state" name="field[other_state]" class="input-text" value="" />
                                {else}
                                     <input type="text" id="other_state" name="field[other_state]" class="input-text" value="{$form_data.other_state}" />
                                {/if}

                            </div>
                        </div>
                        <!-- End Change Text Suburb With Country is not Australia -->
                     	<div class="field">
                            <label>
                                <strong>{localize translate="Country"} <span id="notify_country">*</span></strong>
                            </label>
                            <div class="input-box contact-input-box input-select">
                                <select name="field[country]" id="country"  class="input-select validate-number-gtzero" onchange="onReloadCountry(this.form,'')">
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
                                <strong>{localize translate="Telephone"}</strong>
                            </label>
                            <div class="input-box">
                                <input type="text" name="field[telephone]" id="telephones" value="{$form_data.telephone}" class="input-text validate-telephone" />
                            </div>
                        </div>
                        <div class="field">
                            <label>
                                <strong>{localize translate="Mobilephone"}</strong>
                            </label>
                            <div class="input-box">
                                <input type="text" name="field[mobilephone]" id="mobilephone" value="{$form_data.mobilephone}" class="input-text validate-telephone" />
                            </div>
                        </div>
                        <div class="clearthis">
                        </div>
                    </li>
                    <li class="wide">
                        <label>
                            <strong>{localize translate="Email"} <span id="notify_email">*</span></strong>
                        </label>
                        <div class="input-box">
                            <input type="text" name="field[email]" id="email" value="{$form_data.email}" class="input-text validate-require validate-email" autocomplete="off"/>
                        </div>
                    </li>
                    </form>
                </ul>
                <div class="buttons-set contact-buttons-set"  id="button-set-myacc">
                    <button class="btn-red" onclick="agent.submit('#frmAgent')">
                        <span><span>{localize translate="Save"}</span></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="input-box" style="display: none">
        <input type="text" name="field[license_number]" id="license_number" value="{$form_data.license_number}" class="input-text validate-require validate-license" />
    </div>
</div>

{literal}
<script type="text/javascript">
	onReloadCountry(document.getElementById("frmAgent"),'');
</script>
{/literal}