{literal}
<script src="modules/agent/templates/js/checkcountry_register_fast.js" type="text/javascript"></script>
<script type="text/javascript" src="modules/agent/templates/js/checkimage.js"></script>
<script type="text/javascript">

jQuery(document).ready(function(){
    onLoad('postal');
    $('#postal_country').bind('change',function(){
        onLoad('postal');
    })
});
            var search_overlay = new Search();
                    search_overlay._frm = '#frmAgent';
                    search_overlay._text_search = '#postal_suburb';
                    search_overlay._text_obj_1 = '#postal_state';
                    search_overlay._text_obj_2 = '#postal_postcode';
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
						 jQuery(search_overlay._text_search).removeClass('search_loading');
                    }

                    search_overlay._getValue = function(data){
                         var info = jQuery.parseJSON(data);
                         jQuery(search_overlay._text_obj_1).val(info[0]);
                          $('#uniform-postal_state span').html($(search_overlay._text_obj_1+" option:selected").text());
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
</script>
{/literal}
<div>
    <ul class="form-list form-register">
        <form name="frmAgent" id="frmAgent" method="post" action="{$form_action}" enctype="multipart/form-data">
        {if isset($message) and strlen($message)>0}
            <div class="message-box message-box-v-ie">{$message}</div>
        {/if}
            <h2>Extra Company Information </h2>
            <hr/>
            <li class="wide">
                <label>
                    <strong id="notify_contact_name">Company Or Bussiness Register Number <span>*</span></strong>
                </label>

                <div class="input-box">
                    <input type="text" name="register_number" id="register_number" value="{$form_data.register_number}"
                           class="input-text validate-digits"/>
                </div>
            </li>

            <li class="wide">
                <label>
                    <strong id="notify_contact_address">Postal Address <span>*</span></strong>
                </label>

                <div class="input-box">
                    <input type="text" name="postal_address" id="postal_address" value="{$form_data.postal_address}"
                           class="input-text validate-require"/>
                </div>
            </li>
             <li class="fields">
                <div class="field">
                    <label>
                        <strong id="notify_postal_suburb">Suburb <span>*</span></strong>
                    </label>

                    <div class="input-box">
                        <input type="text" name="postal_suburb" id="postal_suburb" value="{$form_data.postal_suburb}"
                               onclick="search_overlay.getData(this)" onkeyup="search_overlay.moveByKey(event)"
                               class="input-text validate-require validate-letter" autocomplete="off"/>
                        <ul>
                            <div id="search_overlay" class="search_overlay"
                                 style="display:none; position: absolute;"></div>
                        </ul>
                    </div>
                </div>


                <div class="field" style="float:right">
                    <label>
                        <strong id="notify_postal_postcode">Postcode <span>*</span></strong>
                    </label>

                    <div class="input-box">
                        <input type="text" name="postal_postcode" id="postal_postcode"
                               value="{$form_data.postal_postcode}"
                               class="input-text validate-require validate-postcode"
                               onkeyup="Common.validRegion('/modules/property/action.php?action=validate-property','#postal_suburb','#postal_state','#postal_postcode','#frmAgent','#postal_country')"
                               autocomplete="off"/>
                    </div>
                </div>

                <div class="clearthis">
                </div>

            </li>
            <li class="fields">
                <div class="field">
                    <label>
                        <strong id="notify_postal_state">State</strong>
                    </label>

                    <div class="input-box input-select">
                        <div id="inactive_postal_state">
                            <select id="postal_state" name="postal_state"
                                    class="input-select"
                                    onchange="Common.validRegion('/modules/property/action.php?action=validate-property','#postal_suburb','#postal_state','#postal_postcode','#frmAgent')">
                            {html_options options = $options_state selected = $form_data.postal_state}
                            </select>
                        </div>
                    <input type="text" id="postal_other_state" class="input-text" name="postal_other_state" value="{$form_data.postal_other_state}"/>
                    </div>
                </div>
                <div class="field" style="float:right">
                    <label>
                        <strong id="notify_postal_country">Country <span>*</span></strong>
                    </label>

                    <div class="input-box">
                        <select name="postal_country" id="postal_country" class="input-select validate-number-gtzero">
                        {html_options options = $options_country selected = $form_data.postal_country}
                        </select>
                    </div>
                </div>
                <div class="clearthis">
                </div>
            </li>


        {if $form_data.partner_logo != ''}
            <li class="wide">
                <label>
                    <strong id="notify_contact_address">Logo Image <span>*</span></strong>
                </label>

                <div class="input-box" style="margin-left:0px;">

                    <img src="{$MEDIAURL}/store/uploads/banner/images/partner/{$form_data.partner_logo}"
                         alt="{$form_data.partner_logo}" style="max-width:185px; max-height:154px;"/>

                    <div class="clearthis"></div>
                </div>
            </li>
        {/if}
            <li class="wide">
                <div class="field">
                    <label>
                        <strong id="notify_contact_suburb"> Logo <span>*</span></strong>
                    </label>

                    <div class="input-box">
                    {if $form_data.partner_logo != ''}
                        <input type="file" name="image_file" id="image_file" onchange="return validFileParner()"
                               class="" value="{$form_data.partner_logo}"/>
                        {else}
                        <input type="file" name="image_file" id="image_file" onchange="return validFileParner()"
                               class="input-text validate-require" value="{$form_data.partner_logo}"/>
                    {/if}
                    </div>
                    <div>
                        You must upload with one of the following extensions: jpg, jpeg, gif, png <br/>
                        Width or height image max size 185, 154!
                    </div>
                </div>

                <div class="clearthis">
                </div>
            </li>

            <li class="wide">
                <label>
                    <strong id="notify_contact_address">Description <span>*</span></strong>
                </label>

                <div class="input-box">
                    <textarea rows="6" cols="43" name="description" id="description"
                              class="validate-require">{$form_data.description}</textarea>
                </div>
            </li>
        </form>
    </ul>
    <div class="buttons-set">
        <button class="btn-blue" onclick="agent.step('#frmAgent')">
            <span><span>Next</span></span>
        </button>
    </div>
</div>
<!-- END AGENT REGISTER IS PARTNER -->
