{literal}

<style type="text/css">
.col22-set .col-22 {
    float: right;
    margin-top: 50px;
    width: 48.55%;
}

</style>
<script type="text/javascript">
var search_overlay = new Search();
        search_overlay._frm = '#frmProperty';
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
			}

    if (content_str.length > 0) {
        jQuery(search_overlay._overlay_container).html(content_str);
        jQuery(search_overlay._overlay_container).show();
        jQuery(search_overlay._overlay_container).width(jQuery(search_overlay._text_search).width());
    } else {
        jQuery(search_overlay._overlay_container).hide();
    }
}
    document.onclick = function() {search_overlay.closeOverlay()};


</script>

{/literal}
<div class="content-box">
    <div class="bar-title">
        <h2>UPDATE EMAIL ALERT</h2>
    </div>
<div class="step-1-info">
    <div class="step-detail col2-set">
        <div class="col-1">     
        </div>	
        <div class="col-2 bg-f7f7f7">
            {if isset($messageup) and strlen($messageup) > 0}
            	<div class="message-box message-box-update">{$messageup}</div>
            {/if}
            
        	<form name="frmProperty" id="frmProperty" method="post" action="?module=emailalert&action=edit-email&id={$rowexecute.email_id}">
              
            <div class="col22-set">
                <div class="col-11">
                    <ul class="form-list">
                        <li class="wide">
                            <label>
                                <strong id="notify_address">Name Email Alert  <span >*</span></strong>
                            </label>
                            <div class="input-box">
                                <input type="text" style="width:605px;" name="fields[name_email]" id="address"  value="{$rowexecute.name_email}" class="input-text validate-require" />
                            </div>
                        </li>
                         
                        <li class="fields"  style="margin-top:11px;" >
                            <div class="field">
                                <label>
                                    <strong id="notify_auction_sale">Auction/Private Sale? <span >*</span></strong>
                                </label>
                                <div class="input-box">
                                    <select name="search[auction_sale]" id="auction_sale" class="input-select validate-number-gtzero">
                                        {html_options options = $auction_sales selected = $rowexecute.auction_sale}
                                    </select>
                                </div>
                            </div>
                            <div class="field">
                                <label>
                                    <strong id="notify_type">Property Type <span ></span></strong>
                                </label>
                                <div class="input-box">
                                    <select name="search[property_type]" id="property_type" class="input-select">
                                        <option value="0"> Any </option>
                                        {html_options options = $property_types selected = $rowexecute.property_type}
                                    </select>
                                </div>
                            </div>
                            <div class="clearthis"></div>
                        </li>
                        <li class="fields">
                            <div class="field">
                                <label>
                                    <strong id="notify_suburb">Suburb <span ></span></strong>
                                </label>
                                <div class="input-box">
                                    <input type="text" name="search[suburb]" id="suburb" value="{$rowexecute.suburb}" class="input-text" onclick="search_overlay.getData(this)" onkeyup="search_overlay.moveByKey(event)" />
                                     <ul style="list-style:none;">
                                        <div id="search_overlay" class="search_overlay" style="display:none;"></div>
                                    </ul>

                                </div>
                            </div>

                            <div class="field">
                                <label>
                                    <strong id="notify_postcode">Postcode <span ></span></strong>
                                </label>
                                <div class="input-box">
                                    <input type="text" name="search[postcode]" id="postcode" value="{$rowexecute.postcode}" class="input-text"/>


                                </div>
                            </div>
                            <div class="clearthis">
                            </div>
                        </li>
                                                
                        <li class="fields" style="margin-top:-5px;" >
                             <div class="field field-e-ie" >
                                <label>
                                    <strong id="notify_state">State <span ></span></strong>
                                </label>
                                <div class="input-box">
                                    <select name="search[state]" id="state" class="input-select input-select2">
                                          {html_options options=$search_data.state selected =$rowexecute.state}
                                    </select>
                                </div>
                            </div>
                            <div class="field">
                                <label>
                                    <strong id="notify_country">Country <span >*</span></strong>
                                </label>
                                <div class="input-box">
                                    <select name="search[country]" id="country" class="input-select validate-number-gtzero" onchange="Common.changeCountry('/modules/general/action.php?action=get_states',this,'suburb')">
                                        {html_options options = $countries selected = $rowexecute.country}
                                    </select>
                                </div>
                            </div>
                          
                            <div class="clearthis">
                            </div>
                        </li>

                        
                        <li class="wide">
                                <label>
                                    <strong id="notify_schedule">Schedule <span ></span></strong>
                                </label>
                                <div class="input-box">
                                     <select name="fields[schedule]" id="schedule" class="input-select">
                                     	{html_options options=$schedule selected=$rowexecute.schedule}
                                     </select>
                                </div>
                        </li> 
                        <li>
                            <div class="field" style="margin-top:50px;">
                                 <label>
                               		 <strong id="">Notes <span ></span></strong>
                           		 </label>
                                <div class="input-box">
                                    <textarea name="fields[description]" id="description" class="input-select " style="width:208%;height:150px;">{$rowexecute.description}</textarea>
                                </div>
                            </div>  
                            <div class="clearthis">
                            </div>
                                                  
                        </li>
                    </ul>
                </div>
                <div class="col-22">
                    <ul class="form-list">
                                      
                        <li class="fields">
                                <div class="field">
                                    <label>
                                        <strong>Min.price</strong>
                                    </label>
                                    <div class="input-box">
                                        <select name="fields[minprice]" id="minprice" class="input-select">
                                            {html_options options=$search_data.min_price selected =$rowexecute.minprice}
                                        </select>
                                    </div>
                                </div>
                                <div class="field">
                                    <label>
                                        <strong>Max.price</strong>
                                    </label>
                                    <div class="input-box">
                                        <select name="fields[maxprice]" id="maxprice" class="input-select">
                                            {html_options options=$search_data.max_price selected =$rowexecute.maxprice}
                                        </select>
                                    </div>
                                </div>
                                <div class="clearthis">
                                </div>
                        </li>            
                        <li class="fields">
                            <div class="field">
                                <label>
                                    <strong id="notify_bedroom">Bedrooms <span ></span></strong>
                                </label>
                                <div class="input-box">
                                
                                    <select name="fields[bedroom]" id="bedroom" class="input-select" >
                                    	<option value="0"> Any </option>
                                        {html_options options = $bedrooms selected = $rowexecute.bedroom}
                                    </select>
                                </div>
                            </div>
                            <div class="field">
                                <label>
                                    <strong id="notify_bathroom">Bathrooms <span ></span></strong>
                                </label>
                                <div class="input-box">
                                    <select name="fields[bathroom]" id="bathroom" class="input-select" >
                                    	<option value="0"> Any </option>
                                        {html_options options = $bathrooms selected = $rowexecute.bathroom}
                                    </select>
                                </div>
                            </div>
                            <div class="clearthis">
                            </div>
                        </li>
                        <li class="fields">
                            
                            <div class="field">
                                <label>
                                    <strong id="notify_car_space">Car spaces <span ></span></strong>
                                </label>
                                <div class="input-box">
                                    <select name="fields[car_space]" id="car_space" class="input-select">
                                    	<option value="0"> Any </option>
                                        {html_options options = $car_spaces selected = $rowexecute.car_space}
                                    </select>
                                </div>
                            </div>
                            <div class="field">
                                <label>
                                    <strong id="notify_car_port">Garage / Carport <span ></span></strong>
                                </label>
                                <div class="input-box">
                                    <select name="fields[car_port]" id="car_port" class="input-select">
                                        <option value="0"> Any </option>
                                        {html_options options = $car_ports selected = $rowexecute.car_port}
                                    </select>
                                </div>
                            </div>
                            <div class="clearthis">
                            </div>
                        </li>
                        
                         <li class="fields">
                             <div class="field" style="width:40%;">
                                    <label><strong>Min.Landsize</strong></label>
                                    <div class="input-box">
                                        <select name="search[land_size_min]" id="land_size_min" class="input-select">
                                            {html_options options=$search_data.land_size selected =$rowexecute.land_size_min}
                                        </select>
                                    </div>
                             </div>

                             <div class="field" style="width:40%;">
                                    <label><strong>Max.Landsize</strong></label>
                                    <div class="input-box">
                                        <select name="search[land_size_max]" id="land_size_max" class="input-select">
                                            {html_options options=$search_data.land_size selected =$rowexecute.land_size_max}
                                        </select>
                                    </div>
                                </div>

                            <div class="field" style="width:20%;">
                                    <label><strong>Unit</strong></label>
                                    <div class="input-box">
                                        <select name="search[unit]" id="unit" class="input-select">
                                            {html_options options=$search_data.unit selected =$rowexecute.unit}
                                        </select>
                                    </div>
                            </div>
                            <div class="clearthis"></div>
                        </li>
                        
                    </ul>
                </div>
                <div class="clearthis">
                </div>
            </div>
            <input type="hidden" name="track" id="track" value="0"/>
           
           
            </form>
            <div class="buttons-set">
            	{literal}
               		 <script  type="text/javascript">
						var pro = new Property('#frmProperty');
			
						function step2Next() {
							//document.getElementById('frmProperty').submit('#frmProperty');
							pro.submit('#frmProperty');
							
						}
						function ActionDeterminator()
						{				
						    document.frmProperty.action = '?module=property&action=search';
							return document.frmProperty.submit();
						}
					</script> 
                {/literal}
              <div style="" class="dbt2">
                     <button class="btn-red" name="rgalert" id="rgalert" onclick="step2Next()">
                        <span><span>Updates&nbsp;&nbsp; </span></span>
                    </button>
              		 <button class="btn-black" name="rgalert" id="rgalert" onclick="document.location='?module=emailalert&action=add-email';">
                        <span><span>Back&nbsp;&nbsp; </span></span>
                    </button>
               </div>
            </div>
        </div>
        <div class="clearthis">
        </div>
    </div>
    
</div>
</div>

<!-- Show Information My Email Alert -->

{literal}
<style type="text/css">
.popup_container {
    background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #8A0000;
    position: relative !important;
    z-index: 101;
}
</style>
{/literal}