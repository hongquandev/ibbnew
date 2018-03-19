<script type="text/javascript" src="modules/general/templates/js/confirm.js"></script>
<script type="text/javascript" src="modules/property/templates/js/property.js"></script>
<script type="text/javascript">
var pro = new Property();
var emailalert = new EmailAlert('#frmProperty');
var id = {$agent_id};
{literal}
    $(document).ready(function(){
        emailalert.view_email('/modules/emailalert/action.php?action=view-email&agent_id='+id);
    });
var search_overlay = new Search();
        search_overlay._frm = '#frmProperty';
        search_overlay._text_search = '#suburb';
        search_overlay._overlay_container = '#search_overlay';
        search_overlay._url_suff = '&type=suburb1';

        search_overlay._success = function(data) {
            var info = jQuery.parseJSON(data);
            var content_str = "";
            var id = 0;
            if (info.length > 0) {
                search_overlay._total = info.length;
                for (i = 0; i < info.length; i++) {
                    var id = 'sitem_' + i;
                    content_str +="<li onclick='search_overlay.set2SearchText(this)' id='"+id+"'>"+info[i]+"</li>";
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
};
    document.onclick = function() {search_overlay.closeOverlay()};

    function ActionDeterminator(){
		document.frmProperty.action = '?module=property&action=search';
		return document.frmProperty.submit();
		/*var auction = $('#auction_sale').val();
		if(auction == 9) {
			document.frmProperty.action = '?module=property&action=search-auction';
		}else {
			document.frmProperty.action = '?module=property&action=search-sale';
		}
		return document.frmProperty.submit();*/
	}
</script>

{/literal}
<div class="content-box content-box-email-alert">
    <div class="bar-title">
        <h2>{localize translate="MY EMAIL ALERTS"}</h2>
    </div>
<div class="step-1-info">
    <div class="step-detail col2-set">
        <div class="col-1">
           
        </div>

        <div class="col-2 bg-f7f7f7">
            {if isset($message) and strlen($message) > 0}
            	<div class="message-box message-box-add">{$message}</div>
                <div style="*height:24px;"></div>
            {/if}
            <form name="frmProperty" id="frmProperty" method="post" action="{$form_action}" onsubmit="">
            
            <div class="col22-set">
{*                <div class="col-11">*}
                    <ul class="form-list">
                        <li class="wide">
                            <label>
                                <strong id="notify_address">{localize translate="Name Email Alert"}  <span >*</span></strong>
                            </label>
                            <div class="input-box">
                                <input type="text" name="search[name_email]" id="name_email"  class="input-text validate-require" value="{$form_data.name_email}" />
                            </div>
                        </li>
                        <li class="wide">
                            <ul id="form-child-email" class="f-left form-child">
                                <li class="fields">
                                    <div class="field">
                                        <label>
                                            <strong id="notify_auction_sale">{localize translate="Auction/Private Sale?"} <span >*</span></strong>
                                        </label>
                                        <div class="input-box input-select">
                                            <select name="search[auction_sale]" id="auction_sale" class="input-select validate-number-gtzero">
                                                {html_options options = $auction_sales selected = $form_data.auction_sale}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="clearthis"></div>
                                </li>

                                <li class="fields">
                                    <div class="field">
                                        <label>
                                            <strong id="notify_kine">{localize translate="Property Kind"}</strong>
                                        </label>
                                        <div class="input-box input-select">
                                            <select name="search[property_kind]" id="property_kind" class="input-select " onchange="pro.getKind('/modules/property/action.php?action=get_property_type& search=1', this, 'property_type'), pro.onChangeKind(this, new Array(), new Array('#p_kind2'))">
                                                {html_options options = $property_kinds selected = $form_data.property_kind}
                                            </select>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <label>
                                            <strong id="notify_type">{localize translate="Property Type"} <span ></span></strong>
                                        </label>
                                        <div class="input-box input-select">
                                            <select name="search[property_type]" id="property_type" class="input-select">
                                                {html_options options = $property_types selected = $form_data.property_type}
                                            </select>
                                        </div>
                                    </div>

                                    <div class="clearthis"></div>
                                </li>

                                <li class="fields">
                                    <div class="field">
                                        <label>
                                            <strong id="notify_suburb">{localize translate="Suburb"} <span ></span></strong>
                                        </label>
                                        <div class="input-box">
                                            <input type="text" name="search[suburb]" id="suburb" value="{$form_data.suburb}" class="input-text disable-auto-complete" onclick="search_overlay.getData(this)" onkeyup="search_overlay.moveByKey(event)"/>
                                             <ul style="list-style:none;">
                                                <div id="search_overlay" class="search_overlay" style="display:none;"></div>
                                            </ul>

                                        </div>
                                    </div>

                                    <div class="field">
                                        <label>
                                            <strong id="notify_postcode">{localize translate="Postcode"} <span ></span></strong>
                                        </label>
                                        <div class="input-box">
                                            <input type="text" name="search[postcode]" id="postcode" value="{$form_data.postcode}" class="input-text" />

                                        </div>
                                    </div>
                                    <div class="clearthis">
                                    </div>
                                </li>

                                <li class="fields">
                                     <div class="field field-e-ie" >
                                        <label>
                                            <strong id="notify_state">{localize translate="State"} <span ></span></strong>
                                        </label>
                                        <div class="input-box">
                                            <select name="search[state]" id="state" class="input-select input-select2">
                                                  {html_options options=$search_data.state selected =$form_data.state}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label>
                                            <strong id="notify_country">{localize translate="Country"} <span >*</span></strong>
                                        </label>
                                        <div class="input-box input-select">
                                            <select name="search[country]" id="country" class="input-select validate-number-gtzero" onchange="Common.changeCountry('/modules/general/action.php?action=get_states',this,'suburb')" >
                                                {html_options options = $countries selected = $form_data.country}
                                            </select>
                                        </div>
                                    </div>

                                    <div class="clearthis">
                                    </div>
                                </li>
                                <li class="wide">
                                    <div class="field">
                                        <label>
                                            <strong id="notify_schedule">{localize translate="Schedule"} <span ></span></strong>
                                        </label>
                                        <div class="input-box input-select">
                                            <select name="search[schedule]" id="schedule" class="input-select">
                                                {html_options options=$schedule selected =$form_data.schedule}
                                            </select>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <ul style="margin-right: 0px;" class="f-left form-child">
                                <li class="fields">
                                <div class="field">
                                    <label>
                                        <strong>{localize translate="Min.price"}</strong>
                                    </label>
                                    <div class="input-box input-select">
                                        <select name="search[minprice]" id="minprice" class="input-select">
                                            {html_options options=$search_data.min_price selected =$form_data.minprice}
                                        </select>
                                    </div>
                                </div>
                                <div class="field">
                                    <label>
                                        <strong>{localize translate="Max.price"}</strong>
                                    </label>
                                    <div class="input-box input-select">
                                        <select name="search[maxprice]" id="maxprice" class="input-select">
                                            {html_options options=$search_data.max_price selected =$form_data.maxprice}
                                        </select>
                                    </div>
                                </div>
                                <div class="clearthis">
                                </div>
                        </li>
                        <li class="fields" id="p_kind2">
                            <div class="field">
                                <label>
                                    <strong id="notify_bedroom">{localize translate="Bedrooms"} <span ></span></strong>
                                </label>
                                <div class="input-box input-select">

                                    <select name="search[bedroom]" id="bedroom" class="input-select" >
                                    	<option value="0">{localize translate="Any"} </option>
                                        {html_options options = $bedrooms selected = $form_data.bedroom}
                                    </select>
                                </div>
                            </div>
                            <div class="field">
                                <label>
                                    <strong id="notify_bathroom">{localize translate="Bathrooms"} <span ></span></strong>
                                </label>
                                <div class="input-box input-select">
                                    <select name="search[bathroom]" id="bathroom" class="input-select" >
                                    	<option value="0">{localize translate="Any"} </option>
                                        {html_options options = $bathrooms selected = $form_data.bathroom}
                                    </select>
                                </div>
                            </div>
                            <div class="clearthis">
                            </div>
                        </li>
                        <li class="fields">
                           <div class="field" style="width:33%">
                                <label>
                                    <strong id="notify_parking">{localize translate="Parking"} <span ></span></strong>
                                </label>
                                <div class="input-box">
                                    <select name="search[parking]" id="parking" class="input-select" onchange="pro.onChangeKind(this, new Array(), new Array('#p_parking1_1','#p_parking1_2'), 0)">
                                        {html_options options = $parking selected = $form_data.parking}
                                    </select>
                                </div>
                           </div>

                           <div class="field" style="width:33%" id="p_parking1_1">
                                <label>
                                    <strong id="notify_car_space">{localize translate="Car spaces"} <span ></span></strong>
                                </label>
                                <div class="input-box">
                                    <select name="search[car_space]" id="car_space" class="input-select">
                                    	<option value="0">{localize translate="Any"} </option>
                                        {html_options options = $car_spaces selected = $form_data.car_space}
                                    </select>
                                </div>
                           </div>
                           <div class="field" style="width:33.9%" id="p_parking1_2">
                                <label>
                                    <strong id="notify_car_port">{localize translate="Car Parking"}<span ></span></strong>
                                </label>
                                <div class="input-box">
                                    <select name="search[car_port]" id="car_port" class="input-select">
                                        <option value="0">{localize translate="Any"} </option>
                                        {html_options options = $car_ports selected = $form_data.car_port}
                                    </select>
                                </div>
                           </div>
                            <div class="clearthis">
                            </div>
                        </li>

                        <li class="fields">
                             <div class="field" style="width:33%;">
                                    <label><strong>{localize translate="Min.Landsize"}</strong></label>
                                    <div class="input-box">
                                        <select name="search[land_size_min]" id="land_size_min" class="input-select">
                                            {html_options options=$search_data.land_size selected =$form_data.land_size_min}
                                        </select>
                                    </div>
                             </div>

                             <div class="field" style="width:33%;">
                                    <label><strong>{localize translate="Max.Landsize"}</strong></label>
                                    <div class="input-box">
                                        <select name="search[land_size_max]" id="land_size_max" class="input-select">
                                            {html_options options=$search_data.land_size selected =$form_data.land_size_max}
                                        </select>
                                    </div>
                                </div>

                            <div class="field" style="width:33.9%;">
                                    <label><strong>{localize translate="Unit"}</strong></label>
                                    <div class="input-box">
                                        <select name="search[unit]" id="unit" class="input-select">
                                            {html_options options=$search_data.unit selected =$form_data.unit}
                                        </select>
                                    </div>
                            </div>
                            <div class="clearthis"></div>
                        </li>

                        {*<li class="wide">
                            <div class="field">
                                <label>
                                    <strong >Sold<span ></span></strong>
                                </label>
                                <div class="input-box input-select">
                                    <select name="search[confirm_sold]" id="confirm_sold" class="input-select">
                                        {html_options options = $sold_options selected = $form_data.confirm_sold}
                                    </select>
                                </div>
                            </div>
                        </li>*}

                    </ul>
                        </li>
                        <li class="wide">
                            <label>
                                <strong>{localize translate="Notes"} <span></span></strong>
                            </label>

                            <div class="input-box">
                                <textarea name="search[description]" id="description"
                                          style="height:135px">{$form_data.description}</textarea>
                            </div>
                        </li>
                    </ul>
            </div>
            <input type="hidden" name="track" id="track" value="0"/>
            <input type="hidden" name="search[email_id]" id="email_id" value="{$form_data.email_id}"/>
           
             </form>
            <div class="buttons-set">
              <div style="" class="dbt2-1">
                   <button class="btn-black" name="rgalert" id="rgalert" onclick="emailalert.submit();">
                            <span><span>{if $action == 'edit-email'}{localize translate=""}{localize translate=""}Update{else}{localize translate="Save"}{/if}</span></span>
                   </button>

                  {if $action == 'edit-email'}
                   <button class="btn-black" name="cancel" id="cancel" onclick="window.location = ROOTURL + '/?module=emailalert&action=add-email';">
                            <span><span>{localize translate="Cancel"}</span></span>
                   </button>
                  {/if}
                    <!-- document.location = '/ibb?module=property&action=search' -->
                    <button class="btn-black" type="submit" name="search" id="search" onclick="return ActionDeterminator();">
                            <span><span>{localize translate="Search"}</span> </span>
                    </button>
               </div>
            </div>
        </div>
        <div class="clearthis"></div>
    </div>
    
</div>
</div>

<!-- Show Information My Email Alert -->
<div class="popup_container_eadd">
	<div id="contact-wrapper">
    	<div class="title bar-filter">
        	<h2 style="float:left">{localize translate="My Email Alerts"} </h2>

            <div style="width:60px;float:right">
                 <select name="len" id="len" onchange="emailalert.view_email('/modules/emailalert/action.php?action=view-email&agent_id='+{$agent_id},this)" style="width:65px;background: white">
                        {html_options options = $len_ar selected = 12}
                 </select>
            </div>
        </div>

        <div id="bh_container" class="content" style="width: 98%;">
            <div id="content" class="myaccount ma-messages mb-20px">
            </div>
        </div>
	</div> 
</div>
<script>
	pro.onChangeKind('#parking', new Array(), new Array('#p_parking1_1','#p_parking1_2'), 0);
</script>

