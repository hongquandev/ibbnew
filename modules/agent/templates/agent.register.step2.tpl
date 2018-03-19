<div class="step-2-info">
    <div class="step-name">
        {if in_array($type,array('vendor','buyer'))}
            <h2>{localize translate="Legal Contacts"}</h2>
        {elseif $type == 'partner'}
            <h2>{localize translate="Extra Company Information"}</h2>
        {elseif $type == 'agent'}
            <h2>{localize translate="Company Information"}</h2>
        {/if}
        
        {if in_array($type,array('vendor','buyer'))}
            <p style="text-align: justify">
                Please complete all fields on this page.  We request that you enter your lawyer (or conveyancor) details to ensure a speedy and efficient and effective process for future transactions. (you can complete your lawyers details at a later date if you choose but must complete before any bidding or posting of a property), but it will make registering to bid or post a property a faster and more efficient process for you.
            </p>
        {elseif $type == 'partner'}
            <p style="text-align: justify">
                To register as an advertiser on www.bidRhino.com, please complete all fields on this page.                </p>
        {elseif $type == 'agent'}
            <p style="text-align: justify">
                Please complete all your company information for your office.  </p>
            <br/>
            <p>Each Real Estate Agency will need an account per office, with 5 accounts enabled per office.</p>
        {/if}        
    </div>
    <div class="step-detail col2-set">

        {if in_array($type,array('vendor','buyer'))} <!-- CHECK AGENT REGISTER IS NOT PARTNER -->
        {literal}
            <script src="modules/agent/templates/js/checkcountry_register_vendor_buyer_step2.js" type="text/javascript"> </script>
            <script type="text/javascript">
            var search_overlay = new Search();
                    search_overlay._frm = '#frmAgent';
                    search_overlay._text_search = '#lawyer_suburb';
                    search_overlay._text_obj_1 = '#lawyer_state';
                    search_overlay._text_obj_2 = '#lawyer_postcode';
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
                          $('#uniform-lawyer_state span').html($(search_overlay._text_obj_1+" option:selected").text());



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
            var search_contact = new Search();
                    search_contact._frm = '#frmAgent';
                    search_contact._text_search = '#contact_suburb';
                    search_contact._text_obj_1 = '#contact_state';
                    search_contact._text_obj_2 = '#contact_postcodes';
                    search_contact._overlay_container = '#search_contact';
                    search_contact._url_suff = '&type=suburb';
                    search_contact._name_id = 'item_';

                    search_contact._success = function(data) {
                        var info = jQuery.parseJSON(data);
                        var content_str = "<div style='position:relative'>";
                        var id = 0;
                        if (info.length > 0) {
                            search_contact._total = info.length;
                            for (i = 0; i < info.length; i++) {
                                var id = 'item_' + i;
                                content_str +="<li onclick='search_contact.setValue(this)' id="+id+">"+info[i]+"</li>";
                                search_contact._item.push(id);
                         }
                        content_str +="</div>";
                    }

                    search_contact._getValue = function(data){
                         var info = jQuery.parseJSON(data);

                         jQuery(search_contact._text_obj_1).val(info[0]);
                            $('#uniform-contact_state span').html($(search_contact._text_obj_1+" option:selected").text());
                    };
                if (content_str.length > 0) {

                    jQuery(search_contact._overlay_container).html(content_str);
                    jQuery(search_contact._overlay_container).show();
                    jQuery(search_contact._overlay_container).width(jQuery(search_contact._text_search).width());
                } else {
                    jQuery(search_contact._overlay_container).hide();
                }
				jQuery(search_contact._text_search).removeClass('search_loading');
            };
            document.onclick = function() {search_overlay.closeOverlay();search_contact.closeOverlay();};
            jQuery('#lawyer_suburb').keyup(function(){
                jQuery('#search_overlay').scroll();
            });
            </script>
        {/literal}
        <div class="">
                   
            <ul class="form-list form-register">
            	<form name = "frmAgent" id= "frmAgent" method = "post" action ="{$form_action}" >
                {if isset($message) and strlen($message)>0}
                	<div class="message-box message-box-v-ie">{$message}</div>
                {/if}
                <h2>{localize translate="Lawyer information"}</h2>
                <hr/>
                <li class="wide">
                    <label>
                        <strong id="notify_lawyer_name">{localize translate="Lawyer Name"}</strong>
                    </label>
                    <div class="input-box">
                        <input type="text" name="lawyer[name]" id="lawyer_name" value="{$form_data.lawyer.name}" class="input-text"/>
                    </div>
                </li>
                <li class="wide">
                    <label>
                        <strong id="notify_lawyer_company">{localize translate="Company Name"}</strong>
                    </label>
                    <div class="input-box">
                        <input type="text" name="lawyer[company]" id="lawyer_company" value="{$form_data.lawyer.company}" class="input-text"/>
                    </div>
                </li>
                
                <li class="wide">
                    <label>
                        <strong id="notify_lawyer_address">{localize translate="Address"}</strong>
                    </label>
                    <div class="input-box">
                        <input type="text" name="lawyer[address]" id="lawyer_address" value="{$form_data.lawyer.address}" class="input-text" />
                    </div>
                </li>
                 <li class="fields">

                   <div class="field">
                        <label>
                            <strong id="notify_lawyer_suburb">{localize translate="Suburb"}</strong>
                        </label>
                        <div class="input-box">
							<input type="text" name="lawyer[suburb]" id="lawyer_suburb" value="{$form_data.lawyer.suburb}" onclick="search_overlay.getData(this)" onkeyup="search_overlay.moveByKey(event)" class="input-text validate-letter" autocomplete="off"/>
							<ul>
                                    <div id="search_overlay" class="search_overlay" style="display:none; position: absolute;"></div>
                            </ul>
 						</div>
                    </div>


                    <div class="field" style="float:right">
                        <label>
                            <strong id="notify_lawyer_postcode">{localize translate="Postcode"}</strong>
                        </label>
                        <div class="input-box">
                            <input type="text" name="lawyer[postcode]" id="lawyer_postcode" value="{$form_data.lawyer.postcode}" class="input-text validate-postcode" onkeyup="Common.validRegion('/modules/property/action.php?action=validate-property','#lawyer_suburb','#lawyer_state','#lawyer_postcode','#frmAgent','#lawyer_country')" autocomplete="off"/>
                        </div>
                    </div>

                    <div class="clearthis">
                    </div>

                </li>
                <li class="fields">
                     <div class="field" id="inactive_state3">
                        <label>
                            <strong id="notify_state">{localize translate="State"}</strong>
                        </label>
                        <div class="input-box">
                         {if $form_data.lawyer.other_state != '' or $form_data.lawyer.other_state == ''}
                                <select name="lawyer[state]" id="lawyer_state"  class="input-select" onchange="Common.validRegion('/modules/property/action.php?action=validate-property','#lawyer_suburb','#lawyer_state','#lawyer_postcode','#frmAgent')">
                                    {html_options options = $subState selected = $form_data.lawyer.state}
                                </select>
                           {else}
                                <select name="lawyer[state]" id="lawyer_state"  class="input-select" onchange="Common.validRegion('/modules/property/action.php?action=validate-property','#lawyer_suburb','#lawyer_state','#lawyer_postcode','#frmAgent')">
                                    {html_options options = $options_state selected = $form_data.lawyer.state}
                                </select>
                         {/if}   
                        </div>
                    </div>

                      <!-- Change Text Suburb With Country is not Australia -->
                       <div class="field" id="active_state3" style="display:none;">
                        <label>
                            <strong id="notify_state">{localize translate="State"}</strong>
                        </label>
                        <div class="input-box">
                        	{if $form_data.lawyer.other_state == ''}

                            	 <input type="text" id="other_state" name="lawyer[other_state]" class="input-text" value="" />
                            {else}
                                 <input type="text" id="other_state" name="lawyer[other_state]" class="input-text" value="{$form_data.lawyer.other_state}" />
                            {/if}

                        </div>
                    </div>
                    <!-- End Change Text Suburb With Country is not Australia -->
                        <div class="field" style="float:right">
                        <label>
                            <strong id="notify_lawyer_country">{localize translate="Country"}</strong>
                        </label>
                        <div class="input-box">
                           {* onchange="Common.changeCountry('/modules/general/action.php?action=get_states',this,'lawyer_state','#frmAgent')" *}
                            
                             <select name="lawyer[country]" id="lawyer_country"  class="input-select" onchange="onReloadCountryLawyer(this.form)" >
                                {html_options options = $options_country selected = $form_data.lawyer.country}
                            </select>
                            
                        </div>
                    </div>
                    <div class="clearthis">
                    </div>
                </li>
                
                <li class="wide" style="display:none">
                <!-- Change Country if Country is choose Other -->
                    <div class="field" id="active_country3">
                        <label>
                            <strong id="notify_country">{localize translate="Country Name"}</strong>
                        </label>
                        <div class="input-box">
                            <input type="text" id="other_country" name="lawyer[other_country]" value="{$form_data.lawyer.other_country}" class="input-text" />                       
                        </div>
                    </div>
                
                </li>
                <!-- End Change Country is choose Other -->
                <li class="fields">
                    <div class="field">
                        <label>
                            <strong id="notify_lawyer_telephone">{localize translate="Telephone"} {*<span >*</span>*}</strong>
                        </label>
                        <div class="input-box">
                            <input type="text" name="lawyer[telephone]" id="lawyer_telephones" value="{$form_data.lawyer.telephone}" class="input-text {*validate-require*} {*validate-telephone*}" />
                        </div>
                    </div>
                    <div class="field" style="float:right">
                        <label>
                            <strong id="notify_lawyer_mobilephone">{localize translate="Mobile Phone"}  {*<span >*</span>*}</strong>
                        </label>
                        <div class="input-box">
                            <input type="text" name="lawyer[mobilephone]" id="lawyer_mobilephones" value="{$form_data.lawyer.mobilephone}" class="input-text {* validate-require *}{*validate-telephone*}" />
                        </div>
                    </div>
                    <div class="clearthis">
                    </div>
                </li>
                <li class="wide">
                    <label>
                        <strong id="notify_lawyer_email">{localize translate="Email"} <span >*</span></strong>
                    </label>
                    <div class="input-box">
                        <input type="text" name="lawyer[email]" id="lawyer_email" value="{$form_data.lawyer.email}" class="input-text validate-email" autocomplete="off"/>
                    </div>
                </li>
                
				<h2>Contact information</h2>
                <hr/>
                <li class="wide">
                    <label>
                        <strong id="notify_contact_name">{localize translate=""}Contact Name <span >*</span></strong>
                    </label>
                    <div class="input-box">
                        <input type="text" name="contact[name]" id="contact_name" value="{$form_data.contact.name}" class="input-text validate-require"/>
                    </div>
                </li>
                
                <li class="wide">
                    <label>
                        <strong id="notify_contact_address">{localize translate="Address"} <span >*</span></strong>
                    </label>
                    <div class="input-box">
                        <input type="text" name="contact[address]" id="contact_address" value="{$form_data.contact.address}" class="input-text validate-require" />
                    </div>
                </li>
                <li class="fields">

                    <div class="field">
                        <label>
                            <strong id="notify_contact_suburb">{localize translate="Suburb"} <span >*</span></strong>
                        </label>
                        <div class="input-box">
							<input type="text" name="contact[suburb]" id="contact_suburb" value="{$form_data.contact.suburb}" class="input-text validate-require validate-letter" onclick="search_contact.getData(this)" onkeyup="search_contact.moveByKey(event)" class="input-text validate-require validate-letter" autocomplete="off"/>
							<ul>
                                    <div id="search_contact" class="search_overlay" style="display:none; position: absolute;"></div>
                            </ul>
                    	</div>
                    </div>

                    <div class="field" style="float:right">
                        <label>
                            <strong id="notify_contact_postcode">{localize translate="Postcode"} <span >*</span></strong>
                        </label>
                        <div class="input-box">
                            <input type="text" name="contact[postcode]" id="contact_postcodes" value="{$form_data.contact.postcode}" class="input-text validate-require validate-postcode" onkeyup="Common.validRegion('/modules/property/action.php?action=validate-property','#contact_suburb','#contact_state','#contact_postcodes',this.form,'#contact_country')" autocomplete="off" />
                        </div>
                    </div>

                    <div class="clearthis">
                    </div>

                </li>
                <li class="fields">
                     <div class="field" id="inactive_state2">
                        <label>
                            <strong id="notify_contact_state">{localize translate="State"} <span >*</span></strong>
                        </label>
                        <div class="input-box">
                          {if $form_data.contact.other_state != '' or $form_data.contact.other_state == ''}
                                <select name="contact[state]" id="contact_state"  class="input-select validate-number-gtzero" onchange="Common.validRegion('/modules/property/action.php?action=validate-property','#contact_suburb','#contact_state','#contact_postcode','#frmAgent')">
                                    {html_options options = $subState selected = $form_data.contact.state}
                                </select>
                             {else}
                                <select name="contact[state]" id="contact_state"  class="input-select validate-number-gtzero" onchange="Common.validRegion('/modules/property/action.php?action=validate-property','#contact_suburb','#contact_state','#contact_postcode','#frmAgent')">
                                    {html_options options = $options_state selected = $form_data.contact.state}
                                </select>
                          {/if}
                        </div>
                    </div>

                     <!-- Change Text Suburb With Country is not Australia -->
                       <div class="field" id="active_state2" style="display:none;">
                        <label>
                            <strong id="notify_state">{localize translate="State"} <span >*</span></strong>
                        </label>
                        <div class="input-box">
                        	{if $form_data.contact.other_state == ''}

                            	 <input type="text" id="other_state2" name="contact[other_state]" class="input-text" value="" />
                            {else}
                                 <input type="text" id="other_state2" name="contact[other_state]" class="input-text" value="{$form_data.contact.other_state}" />
                            {/if}

                        </div>
                    </div>
                    <!-- End Change Text Suburb With Country is not Australia -->
                    <div class="field" id="inactive_country2" style="float:right">
                        <label>
                            <strong id="notify_contact_country">{localize translate="Country"} <span >*</span></strong>
                        </label>
                        <div class="input-box">
                        {* Common.changeCountry('/modules/general/action.php?action=get_states',this,'contact_state') *}
                            <select name="contact[country]" id="contact_country"  class="input-select validate-number-gtzero" onchange="onReloadCountryContact(this.form,'')">
                                {html_options options = $options_country selected = $form_data.contact.country}
                            </select>
                        </div>
                    </div>
                    <div class="clearthis">
                    </div>
                </li>
                
                  <li class="wide" style="display:none">
                <!-- Change Country if Country is choose Other -->
                    <div class="field" id="active_country2">
                        <label>
                            <strong id="notify_country">{localize translate="Country Name"} <span >*</span></strong>
                        </label>
                        <div class="input-box">
                            <input type="text" id="other_countrys" name="contact[other_country]" value="{$form_data.contact.other_country}" class="input-text" />                       
                        </div>
                    </div>
                
                </li>
                <!-- End Change Country is choose Other -->
                <li class="fields">
                    <div class="field">
                        <label>
                            <strong id="notify_contact_telephone">{localize translate="Telephone"} {*<span >*</span>*}</strong>
                        </label>
                        <div class="input-box">
                            <input type="text" name="contact[telephone]" id="contact_telephones" value="{$form_data.contact.telephone}" class="input-text {*validate-telephone*}" />
                        </div>
                    </div>
                    <div class="field" style="float:right">
                        <label>
                            <strong id="notify_contact_mobilephone">{localize translate="Mobile Phone"}  {*<span >*</span>*}</strong>
                        </label>
                        <div class="input-box">
                            <input type="text" name="contact[mobilephone]" id="contact_mobilephones" value="{$form_data.contact.mobilephone}" class="input-text {*validate-telephone*}" />
                        </div>
                    </div>
                    <div class="clearthis"></div>
                </li>
                <li class="wide">
                    <label>
                        <strong id="notify_contact_email">{localize translate="Email"} <span >*</span></strong>
                    </label>
                    <div class="input-box">
                        <input type="text" name="contact[email]" id="contact_email" value="{$form_data.contact.email}" class="input-text validate-require validate-email" autocomplete="off"/>
                    </div>
                </li>                
                </form>
            </ul>
            <div class="clearthis"></div>
            <div class="buttons-set">
            	<!--
                <button class="btn-red btn-red-re-buyer" onclick="agent.step('#frmAgent')">
                    <span><span>Next</span></span>
                </button>
                -->
                <button class="btn-blue" onclick="agent.step('#frmAgent')">
                    <span><span>{localize translate="Next"}</span></span>
                </button>
            </div>
        </div>
        {literal}
            <script type="text/javascript">
                onReloadCountryLawyer(document.getElementById("frmAgent"));
                onReloadCountryContact(document.getElementById("frmAgent"));
            </script>
        {/literal}
    {elseif $type == 'partner'} <!-- IF AGENT REGISTER IS PARTNER -->
           	{include file="agent.register.partner.step2.tpl"}
    {else}
            {include file="agent.auction.register.step2.tpl"}
    {/if} <!-- END CHECK AGENT REGISTER IS NOT PARTNER -->
        <div class="clearthis">
        </div>
    </div>
</div>
{literal}
<SCRIPT TYPE="text/javascript">
	<!--
	function submitenter(myfield,e)
	{
	var keycode;
	if (window.event) keycode = window.event.keyCode;
	else if (e) keycode = e.which;
	else return true;
	
	if (keycode == 13)
	   {
	   myfield.form.submit();
	   return false;
	   }
	else
	   return true;
	}
	//-->
</SCRIPT>
{/literal}


