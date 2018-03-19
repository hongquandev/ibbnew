
<script type="text/javascript">

    {literal}
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

            if (content_str.length > 0) {
                jQuery(search_overlay._overlay_container).html(content_str);
                jQuery(search_overlay._overlay_container).show();
                jQuery(search_overlay._overlay_container).width(jQuery(search_overlay._text_search).width());
            } else {
                jQuery(search_overlay._overlay_container).hide();
            }
			jQuery(search_overlay._text_search).removeClass('search_loading');
        };
        search_overlay._getValue = function(data){
             var info = jQuery.parseJSON(data);
             jQuery(search_overlay._text_obj_1).val(info[0]);
             $('#uniform-lawyer_state span').html($(search_overlay._text_obj_1+" option:selected").text());
        };
    var search_contact = new Search();
        search_contact._frm = '#frmAgent';
        search_contact._text_search = '#contact_suburb';
        search_contact._text_obj_1 = '#contact_state';
        search_contact._text_obj_2 = '#contact_postcode';
        search_contact._overlay_container = '#search_contact';
        search_contact._url_suff = '&type=suburb';

        search_contact._success = function(data) {
            var info = jQuery.parseJSON(data);
            var content_str = "";
            var id = 0;
            if (info.length > 0) {
                search_contact._total = info.length;
                for (i = 0; i < info.length; i++) {
                    var id = 'sitem_' + i;
                    content_str +="<li onclick='search_contact.setValue(this)' id="+id+">"+info[i]+"</li>";
                    search_contact._item.push(id);
                }
            }
            if (content_str.length > 0) {
                jQuery(search_contact._overlay_container).html(content_str);
                jQuery(search_contact._overlay_container).show();
                jQuery(search_contact._overlay_container).width(jQuery(search_contact._text_search).width());
            } else {
                jQuery(search_contact._overlay_container).hide();
            }
			jQuery(search_contact._text_search).removeClass('search_loading');
        };
        search_contact._getValue = function(data){
             var info = jQuery.parseJSON(data);

             jQuery(search_contact._text_obj_1).val(info[0]);
            
             $('#uniform-contact_state span').html($(search_contact._text_obj_1+" option:selected").text());
        };
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
			jQuery(search_personal._text_search).removeClass('search_loading');
        };
		
		
        search_personal._getValue = function(data){
             var info = jQuery.parseJSON(data);

             jQuery(search_personal._text_obj_1).val(info[0]);

             $('#uniform-personal_state span').html($(search_personal._text_obj_1+" option:selected").text());
        };

    document.onclick = function() {search_overlay.closeOverlay();search_contact.closeOverlay();search_personal.closeOverlay();};
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

   $(document).ready(function(){
        onLoad('personal');
        onLoad('contact');
    });
    var agent = new Agent();
</script>
<script type="text/javascript" src="modules/general/templates/js/confirm.js"></script>
<script src="modules/agent/templates/js/checkcountry_register_fast.js" type="text/javascript"> </script>
{/literal}

<div class="bar-title">
    <h2>{localize translate="ADDITIONAL INFORMATION"} </h2>
</div>

<div class="ma-info mb-20px lawyer-main add-info-main">

    <div class="col2-set mb-20px">
        <div class="step-2-info">
             {if isset($message) and strlen($message)>0}
                  <div class="message-box  message-box-ie">{$message}</div>
             {/if}
            {*PERSONAL*}

        <form name="frmAgent" id="frmAgent" method="post">
            <div class="step-detail col2-set">
                <div class="col1">
                     <div class="step-name">
                        <h2>{localize translate="Personal Information"}</h2>
                    </div>

                    <div class="bg-f7f7f7">
                        <ul class="form-list form-child">
                            <li class="fields">
                                <div class="field">
                                    <label>
                                        <strong id="notify_personal_firts_name">{localize translate="First Name"} <span >*</span></strong>
                                    </label>
                                    <div class="input-box">
                                        <input type="text" name="personal[firstname]" id="personal_firstname" value="{$form_data.personal.firstname}" class="input-text validate-require"/>
                                    </div>
                                </div>
                                <div class="field">
                                    <label>
                                        <strong id="notify_personal_last_name">{localize translate="Last Name"} <span >*</span></strong>
                                    </label>
                                    <div class="input-box">
                                        <input type="text" name="personal[lastname]" id="personal_lastname" value="{$form_data.personal.lastname}" class="input-text validate-require"/>
                                    </div>
                                </div>
                            </li>

                            <li class="wide">
                                <label>
                                    <strong id="notify_personal_street">{localize translate="Address"} <span >*</span></strong>
                                </label>
                                <div class="input-box">
                                    <input type="text" name="personal[street]" id="personal_street" value="{$form_data.personal.street}" class="input-text validate-require" />
                                </div>
                            </li>
                            <li class="fields">

                             <div class="field">
                                    <label>
                                        <strong id="notify_personal_suburb">{localize translate="Suburb"} <span >*</span></strong>
                                    </label>
                                    <div class="input-box">
                                        <input type="text" name="personal[suburb]" id="personal_suburb" value="{$form_data.personal.suburb}" onclick="search_personal.getData(this)" onkeyup="search_personal.moveByKey(event)" class="input-text validate-require validate-letter" autocomplete="off"/>
                                        <ul id="dtr">
                                            <div id="search_personal" class="search_overlay" style="display:none; position: absolute;"></div>
                                        </ul>
                                    </div>
                                </div>

                                <div class="field">
                                    <label>
                                        <strong id="notify_personal_postcode">{localize translate="Postcode"} <span >*</span></strong>
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
                                        <strong id="notify_personal_state">{localize translate="State"} <span >*</span></strong>
                                    </label>
                                    <div class="input-box input-select">
                                        <div id="inactive_personal_state">
                                            <select name="personal[state]" id="personal_state"  class="input-select validate-number-gtzero" onchange="Common.validRegion('/modules/property/action.php?action=validate-property','#personal_suburb','#personal_state','#personal_postcode','#frmAgent')">
                                                    {html_options options = $subState selected = $form_data.personal.state}
                                            </select>
                                        </div>
                                        <input type="text" id="personal_other_state" name="personal[other_state]" class="input-text" value="{$form_data.personal.other_state}"/>
                                    </div>
                                </div>
                                 <div class="field">
                                    <label>
                                        <strong id="notify_personal_country">{localize translate="Country"} <span >*</span></strong>
                                    </label>
                                    <div class="input-box input-select">
                                        <select name="personal[country]" id="personal_country"  class="input-select validate-number-gtzero" onchange="onLoad('personal')">
                                            {html_options options = $options_country selected = $form_data.personal.country}
                                        </select>
                                    </div>
                                </div>
                                <div class="clearthis"></div>
                            </li>


                            <li class="fields">
                                <div class="field">
                                    <label>
                                        <strong id="notify_personal_telephone">{localize translate="Telephone"}</strong>
                                    </label>
                                    <div class="input-box">
                                        <input type="text" name="personal[telephone]" id="personal_telephone" value="{$form_data.personal.telephone}" class="input-text validate-require {*validate-telephone*}" />
                                    </div>
                                </div>
                                <div class="field">
                                    <label>
                                        <strong id="notify_personal_mobilephone">{localize translate="Mobile Phone"}</strong>
                                    </label>
                                    <div class="input-box">
                                        <input type="text" name="personal[mobilephone]" id="personal_mobilephone" value="{$form_data.personal.mobilephone}" class="input-text validate-require {*validate-telephone*}" />
                                    </div>
                                </div>
                                <div class="clearthis"></div>
                            </li>

                            <li class="wide">
                                <label>
                                    <strong id="notify_personal_email_address">{localize translate="Email"} <span >*</span></strong>
                                </label>
                                <div class="input-box">
                                    <input type="text" name="personal[email_address]" id="personal_email_address" value="{$form_data.personal.email_address}" class="input-text validate-require validate-email"
                                           onkeyup="Common.existEmail('/modules/agent/action.php?action=exist_email',this,{$agent_id})" autocomplete="off"/>
                                </div>
                            </li>
                            <li class="wide">
                                <label>
                                    <strong id="notify_personal_license_number">{localize translate="Drivers License Number/Medicare Card No."}</strong>
                                </label>
                                <div class="input-box">
                                    <input type="text" name="personal[license_number]" id="personal_license_number" value="{$form_data.personal.license_number}" class="input-text validate-require validate-license" autocomplete="off"/>
                                </div>
                            </li>
                            <li class="wide">
                                <label>
                                    <strong id="notify_security_question">{localize translate="Security question"} <span >*</span></strong>
                                </label>
                                <div class="input-box input-select">
                                    <select name="personal[security_question]" id="security_question" class="input-select validate-number-gtzero">
                                        {html_options options = $options_question selected = $form_data.personal.security_question}
                                    </select>
                                    <a href="javascript:void(0)" style="float:right;margin: 3px 0px;" onclick="agent.showSQ()">{localize translate="Add new question"}</a>

                                    <div id="question_container" style="display:none">
                                        <div id="msg_question" style="color:#FF0000"></div>
                                        <input type="text" name="personal[new_question]" id="new_question" class="input-text"/>
                                        <input type="button" value="Save" onclick="agent.saveSQ()" style="margin-top: 3px;padding: 2px 3px;"/><span id="loading_question" style="display:none;">loading...</span>
                                    </div>

                                </div>
                            </li>
                            <li class="wide">
                                <label>
                                    <strong id="notify_asecurity_answer">{localize translate="Answer"} <span >*</span></strong>
                                </label>
                                <div class="input-box">
                                    <input type="text" name="personal[security_answer]" id="security_answer" value="{$form_data.personal.security_answer}" class="input-text validate-require" autocomplete="off"/>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>


            {*LAWYER*}
              {*  <div class="col2">
                    <div class="step-name">
                        <h2>Lawyer Information</h2>
                    </div>

                    <div class="bg-f7f7f7">
                        <ul class="form-list">
                            <li class="wide">
                                <label>
                                    <strong id="notify_lawyer_name">Lawyer Name <span >*</span></strong>
                                </label>
                                <div class="input-box">
                                    <input type="text" name="lawyer[name]" id="lawyer_name" value="{$form_data.lawyer.name}" class="input-text validate-require"/>
                                </div>
                            </li>
                            <li class="wide">
                                <label>
                                    <strong id="notify_lawyer_company">Company Name <span >*</span></strong>
                                </label>
                                <div class="input-box">
                                    <input type="text" name="lawyer[company]" id="lawyer_company" value="{$form_data.lawyer.company}" class="input-text validate-require"/>
                                </div>
                            </li>

                            <li class="wide">
                                <label>
                                    <strong id="notify_lawyer_address">Address <span >*</span></strong>
                                </label>
                                <div class="input-box">
                                    <input type="text" name="lawyer[address]" id="lawyer_address" value="{$form_data.lawyer.address}" class="input-text validate-require" />
                                </div>
                            </li>
                            <li class="fields">
                            
                                 <div class="field">
                                    <label>
                                        <strong id="notify_lawyer_country">Country <span >*</span></strong>
                                    </label>
                                    <div class="input-box">
                                        <select name="lawyer[country]" id="lawyer_country"  class="input-select validate-number-gtzero" onchange="onReloadLawyer(this.form)">
                                            {html_options options = $options_country selected = $form_data.lawyer.country}
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="field"  id="inactive_state3" >
                                    <label>
                                        <strong id="notify_lawyer_state">State <span >*</span></strong>
                                    </label>
                                    <div class="input-box">
                                    
                                     {if $form_data.lawyer.other_state != '' or $form_data.lawyer.other_state == ''}
                                            <select name="lawyer[state]" id="lawyer_state"  class="input-select validate-number-gtzero" onchange="Common.validRegion('/modules/property/action.php?action=validate-property','#lawyer_suburb','#lawyer_state','#lawyer_postcode','#frmAgent')">
                                                {html_options options = $subState selected = $form_data.lawyer.state}
                                            </select>
                                        {else}
                                             <select name="lawyer[state]" id="lawyer_state"  class="input-select validate-number-gtzero" onchange="Common.validRegion('/modules/property/action.php?action=validate-property','#lawyer_suburb','#lawyer_state','#lawyer_postcode','#frmAgent')">
                                                {html_options options = $options_state selected = $form_data.lawyer.state}
                                            </select>
       	
                                     {/if}   
                                    </div>
                                </div>
                                
                                  <!-- Change Text Suburb With Country is not Australia -->
                                   <div class="field" id="active_state3" style="display:none;">
                                    <label>
                                        <strong id="notify_lawyer_state">State <span >*</span></strong>
                                    </label>
                                    <div class="input-box">    
                                        {if $form_data.lawyer.other_state == ''}
                                            
                                             <input type="text" id="other_state2" name="lawyer[other_state]" class="input-text" value="" />
                                        {else}
                                             <input type="text" id="other_state2" name="lawyer[other_state]" class="input-text" value="{$form_data.lawyer.other_state}" />
                                        {/if}       
                                       
                                    </div>
                                </div>
                                <!-- End Change Text Suburb With Country is not Australia -->
                                
                                <div class="clearthis"></div>
                            </li>
							
                             <li class="wide">
                            <!-- Change Country if Country is choose Other -->
                                <div class="field" id="active_country3" style="display:none">
                                    <label>
                                        <strong id="notify_country">Country Name <span >*</span></strong>
                                    </label>
                                    <div class="input-box">
                                        <input type="text" id="other_country2" name="lawyer[other_country]" value="{$form_data.lawyer.other_country}" class="input-text" />                       
                                    </div>
                                </div>
                            
                            </li>
                            <!-- End Change Country is choose Other -->   
                            
                            <li class="fields">
                            
                               <div class="field">
                                    <label>
                                        <strong id="notify_lawyer_suburb">Suburb <span >*</span></strong>
                                    </label>
                                    <div class="input-box">
                                        <input type="text" name="lawyer[suburb]" id="lawyer_suburb" value="{$form_data.lawyer.suburb}" onclick="search_overlay.getData(this)" onkeyup="search_overlay.moveByKey(event)" class="input-text validate-require validate-letter" autocomplete="off"/>
                                        <ul>
                                            <div id="search_overlay" class="search_overlay" style="display:none; position: absolute;"></div>
                                        </ul>
                                    </div>
                                </div>
                                
                                <div class="field">
                                    <label>
                                        <strong id="notify_lawyer_postcode">Postcode <span >*</span></strong>
                                    </label>
                                    <div class="input-box">
                                        <input type="text" name="lawyer[postcode]" id="lawyer_postcode" value="{$form_data.lawyer.postcode}" class="input-text validate-require validate-postcode" onkeyup="Common.validRegion('/modules/property/action.php?action=validate-property','#lawyer_suburb','#lawyer_state','#lawyer_postcode',this,'#frmAgent')" autocomplete="off"/>
                                    </div>
                                </div>

                                <div class="clearthis"></div>
                            </li>

                            <li class="fields">
                                <div class="field">
                                    <label>
                                        <strong id="notify_lawyer_telephone">Telephone <span >*</span></strong>
                                    </label>
                                    <div class="input-box">
                                        <input type="text" name="lawyer[telephone]" id="lawyer_telephones" value="{$form_data.lawyer.telephone}" class="input-text validate-require validate-telephone" />
                                    </div>
                                </div>
                                <div class="field">
                                    <label>
                                        <strong id="notify_lawyer_mobilephone">Mobile Phone  <span >*</span></strong>
                                    </label>
                                    <div class="input-box">
                                        <input type="text" name="lawyer[mobilephone]" id="lawyer_mobilephones" value="{$form_data.lawyer.mobilephone}" class="input-text validate-require validate-telephone" />
                                    </div>
                                </div>
                                <div class="clearthis"></div>
                            </li>

                            <li class="wide">
                                <label>
                                    <strong id="notify_lawyer_email">Email <span >*</span></strong>
                                </label>
                                <div class="input-box">
                                    <input type="text" name="lawyer[email]" id="lawyer_email" value="{$form_data.lawyer.email}" class="input-text validate-require validate-email" autocomplete="off"/>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="clearthis"></div>*}

           
            {*CONTACT*}

          {*  <div class="step-detail col2-set" style="margin-top:20px;">*}
                <div class="col2">
                    <div class="step-name">
                        <h2>{localize translate="Contact Information"}</h2>
                    </div>
                    <div class="bg-f7f7f7">
                        <ul class="form-list form-child">
                            <li class="wide">
                                <label>
                                    <strong id="notify_contact_name">{localize translate="Contact Name"} <span >*</span></strong>
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
                                
                                <div class="field">
                                    <label>
                                        <strong id="notify_contact_postcode">{localize translate="Postcode"} <span >*</span></strong>
                                    </label>
                                    <div class="input-box">
                                        <input type="text" name="contact[postcode]" id="contact_postcode" value="{$form_data.contact.postcode}" class="input-text validate-require validate-postcode" onkeyup="Common.validRegion('/modules/property/action.php?action=validate-property','#contact_suburb','#contact_state','#contact_postcode',this)" autocomplete="off" />
                                    </div>
                                </div>

                          
                                <div class="clearthis"></div>

                            </li>
                            <li class="fields">
                                <div class="field">
                                    <label>
                                        <strong id="notify_contact_state">{localize translate="State"} <span >*</span></strong>
                                    </label>
                                    <div class="input-box input-select">
                                        <div id="inactive_contact_state">
                                            <select name="contact[state]" id="contact_state"  class="input-select validate-number-gtzero" onchange="Common.validRegion('/modules/property/action.php?action=validate-property','#contact_suburb','#contact_state','#contact_postcode','#frmAgent')">
                                                {html_options options = $options_state selected = $form_data.contact.state}
                                            </select>
                                        </div>
                                        <input type="text" id="contact_other_state" name="contact[other_state]" class="input-text" value="{$form_data.contact.other_state}"/>
                                    </div>
                                </div>
                                 <div class="field" id="inactive_country2">
                                    <label>
                                        <strong id="notify_contact_country">{localize translate="Country"} <span >*</span></strong>
                                    </label>
                                    <div class="input-box input-select">
                                        <select name="contact[country]" id="contact_country"  class="input-select validate-number-gtzero" onchange="onLoad('contact')">
                                            {html_options options = $options_country selected = $form_data.contact.country}
                                        </select>
                                    </div>
                                </div>
                                <div class="clearthis"></div>
                            </li>
                            <li class="fields">
                                <div class="field">
                                    <label>
                                        <strong id="notify_contact_telephone">{localize translate="Telephone"}</strong>
                                    </label>
                                    <div class="input-box">
                                        <input type="text" name="contact[telephone]" id="contact_telephone" value="{$form_data.contact.telephone}" class="input-text validate-require validate-telephone" />
                                    </div>
                                </div>
                                <div class="field">
                                    <label>
                                        <strong id="notify_contact_mobilephone">{localize translate="Mobile Phone"}</strong>
                                    </label>
                                    <div class="input-box">
                                        <input type="text" name="contact[mobilephone]" id="contact_mobilephone" value="{$form_data.contact.mobilephone}" class="input-text validate-require validate-telephone" />
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
                        </ul>
                    </div>
              </div>


            {*CREDITCARD*}

               {* 
               <div class="col2">
                    <div class="step-name">
                        <h2>Creditcard Information</h2>
                    </div>
                    <div class="bg-f7f7f7" style="height:265px;">
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
                                    <input type="hidden" id="expiration_date" class="validate-number-gtzero" value="{$form_data.credit.expiration_month}{$form_data.credit.expiration_year}">
                                </label>
                                <div class="input-box">
                                    <div style="width:60%;float:left">
                                        <select name="credit[expiration_month]" id="expiration_month" class="input-select validate-number-gtzero" onchange="getCC();">
                                        {html_options options = $options_month selected = $form_data.credit.expiration_month}
                                        </select>
                                    </div>
                                    <div style="width:40%;float:left">
                                        <select name="credit[expiration_year]" id="expiration_year" onchange="getCC();" class="input-select validate-require">
                                        {html_options options = $options_year selected = $form_data.credit.expiration_year}
                                        </select>
                                    </div>
                                </div>
                            </li>
                            <li></li>
                        </ul>
                    </div>
                </div> <!-- End Close Col2 , Credit Card --> 
                *}
            </div>
            <div class="clearthis"></div>
            </form>

            <div class="buttons-set">
                <button class="btn-red btn-red-re-buyer" onclick="agent.submit('#frmAgent');">
                    <span><span>{localize translate="Save"}</span></span>
                </button>
                <button class="btn-red btn-red-re-buyer" onclick="cancel();">
                    <span><span>{localize translate="Cancel"}</span></span>
                </button>
            </div>


        </div>
    </div>

</div>
{literal}
<script type="text/javascript">
	/*onReloadPersonal(document.getElementById("frmAgent"));
	onReloadLawyer(document.getElementById("frmAgent"));
	onReloadContact(document.getElementById("frmAgent"));*/


</script>
{/literal}