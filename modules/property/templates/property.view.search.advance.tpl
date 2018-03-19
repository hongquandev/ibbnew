{literal}
<style type="text/css">
.form-list li.fields .field .input-select {
    width: 100%;
}
</style>


<script type="text/javascript">
var search_overlay = new Search();
search_overlay._frm = '#frmAdvanceSearch';
search_overlay._text_search = '#address';
search_overlay._overlay_container = '#search_overlay';
search_overlay._url_suff = '&type=address';

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

    if (content_str.length > 0) {
        jQuery(search_overlay._overlay_container).html(content_str);
        jQuery(search_overlay._overlay_container).show();
        jQuery(search_overlay._overlay_container).width(jQuery(search_overlay._text_search).width());
    } else {
        jQuery(search_overlay._overlay_container).hide();
    }
    jQuery(search_overlay._text_search).removeClass('search_loading');
};


var suburb_overlay = new Search();
suburb_overlay._frm = '#frmAdvanceSearch';
suburb_overlay._text_search = '#suburb';
suburb_overlay._overlay_container = '#suburb_overlay';
suburb_overlay._url_suff = '&type=suburb1';

suburb_overlay._success = function(data) {
    var info = jQuery.parseJSON(data);
    var content_str = "";
    var id = 0;
    if (info.length > 0) {
        suburb_overlay._total = info.length;
        for (i = 0; i < info.length; i++) {
            var id = 'sitem_' + i;
            content_str +="<li onclick='suburb_overlay.set2SearchText(this)' id='"+id+"'>"+info[i]+"</li>";
            suburb_overlay._item.push(id);
        }
    }

    if (content_str.length > 0) {
        jQuery(suburb_overlay._overlay_container).html(content_str);
        jQuery(suburb_overlay._overlay_container).show();
        jQuery(suburb_overlay._overlay_container).width(jQuery(suburb_overlay._text_search).width());
    } else {
        jQuery(suburb_overlay._overlay_container).hide();
    }
    jQuery(suburb_overlay._text_search).removeClass('search_loading');
};
   /* window.onclick = function() { search_overlay.closeOverlay()}; */
   document.onclick = function() { search_overlay.closeOverlay();suburb_overlay.closeOverlay()};
</script>
{/literal}
<div class="content-box">
    <div class="bar-title">
        <h2>ADVANCED SEARCH</h2>
    </div>
    <div class="content-details">
        <div class="col2-set mb-20px">
            <div class="div-search-a div-search-advance">
                <form name="frmAdvanceSearch" id="frmAdvanceSearch" method="post" action="{$form_action}" onsubmit="return search_overlay.isSubmit();">
                    <div class="s-left" style="float:left;width:458px">
                        <ul class="form-list" style="padding:0px">
                            <li class="wide">
                                <label class="label-search">
                                    <strong>Address</strong>
                                </label>
                                <div class="input-box" style="">
                                    <input type="text" name="search[address]" id="address" value="{$form_data.address}" class="input-text disable-auto-complete" onclick="search_overlay.getData(this)" onkeyup="search_overlay.moveByKey(event)"/>
                                </div>
                                <div id="search_overlay" class="search_overlay" style="display:none; position: absolute;margin: 22px 0px 0px 97px;*margin-left: 50px;"></div>
                            </li>
                            
                             <li class="fields">
                                 <div class="field" style="width:218px">
                                    <label class="label-search">
                                        <strong>Property ID</strong>
                                    </label>
                                    <div style="" class="input-box">
                                       <input type="text" name="search[property_id]" id="property_id" value="{$form_data.property_id}" class="input-text disable-auto-complete" style="width:210px"/>
                                    </div>
                                </div>
                             
                                <div class="field" style="width:218px;float:right">
                                    <label>
                                        <strong>State</strong>
                                    </label>
                                    <div style="" class="input-box">
                                        <select name="search[state]" id="state" class="input-select" style="width:218px;">
                                            {html_options options=$search_data.state selected =$form_data.state}
                                        </select>
                                    </div>
                                </div>
                             
                             </li>
                             
                             <li class="fields">
                                 <div class="field" style="width:218px">
                                    <label>
                                        <strong>Property type</strong>
                                    </label>
                                    <div style="" class="input-box">
                                        <select name="search[property_type]" id="property_type" class="input-select" style="width:218px">
                                            {html_options options=$search_data.property_type selected =$form_data.property_type}
                                        </select>
                                    </div>
                                </div>
                             
                                <div class="field" style="width:218px;float:right">
                                    <label>
                                        <strong>Bedrooms</strong>
                                    </label>
                                    <div style="" class="input-box">
                                        <select name="search[bedroom]" id="bedroom" class="input-select" style="width:218px">
                                            {html_options options=$search_data.bedroom selected =$form_data.bedroom}
                                        </select>

                                    </div>
                                </div>
                             
                             </li>
                             
                             <li class="fields">
                                <div class="field" style="width:139px;margin-right:21px;">
                                    <label>
                                           <strong class="font-avsearch">Max.price</strong>
                                    </label>
                                    <div style="" class="input-box">
                                          <select name="search[maxprice]" id="maxprice" class="input-select" style="width:139px">
                                            {html_options options=$search_data.max_price selected =$form_data.maxprice}
                                          </select>
                                </div>
                                </div>
                                <div class="field" style="width:139px;">
                                    <label>
                                        <strong class="font-avsearch">Min.price</strong>
                                    </label>
                                    <div style="" class="input-box">
                                        <select name="search[minprice]" id="minprice" class="input-select" style="width:139px">
                                            {html_options options=$search_data.min_price selected =$form_data.minprice}
                                        </select>
                                    </div>
                                </div>
                                <div class="field" style="width:139px;float:right">
                                    <label>
                                        <strong class="font-avsearch">iBB Sustainability</strong>
                                    </label>
                                    <div style="" class="input-box">
                                         <select name="search[green_rating]" id="green_rating" class="input-select" style="width:139px">
                                            {html_options options=$search_data.rating selected =$form_data.green_rating}
                                        </select>
                                    </div>
                                </div>                                         
                             </li>
                             
                             <li class="fields">
                                <div class="field" style="width:139px;margin-right:21px;">
                                    <label>
                                        <strong>Min.Landsize</strong>
                                    </label>
                                    <div style="" class="input-box">
                                        <select name="search[land_size_min]" id="land_size_min" class="input-select" style="width:139px">
                                            {html_options options=$search_data.land_size selected =$form_data.land_size_min}
                                        </select>
                                    </div>
                                </div>
                                <div class="field" style="width:139px;">
                                    <label>
                                        <strong>Max.Landsize</strong>
                                    </label>
                                    <div style="" class="input-box">
                                        <select name="search[land_size_max]" id="land_size_max" class="input-select" style="width:139px">
                                            {html_options options=$search_data.land_size selected = $form_data.land_size_max}
                                        </select>
                                    </div>
                                </div>
                                <div class="field" style="width:139px;float:right">
                                    <label>
                                        <strong>Unit</strong>
                                    </label>
                                    <div style="" class="input-box">
                                        <select name="search[unit]" id="unit" class="input-select" style="width:139px">
                                            {html_options options=$search_data.unit selected =$form_data.unit}
                                        </select>
                                    </div>
                                </div>                                         
                             </li>
                             <li class="fields">
                                <label style="cursor:pointer;"><input {if $form_data.surround_suburb == 1} checked {/if} type="checkbox" name="search[surround_suburb]" id="surround_suburb" value="1" style="width:15px !important;" class="input-checkbox" /> Include surrounding suburbs</label>
                              
                             </li>
                        </ul>
                    </div>
                    <div class="s-right" style="float:right;width:460px;">
                        <ul class="form-list" style="padding:0px">
                            <li class="fields">
                                <div class="field" style="width:218px;">
                                    <label class="label-search">
                                        <strong>Suburb</strong>
                                    </label>
                                    <div style="" class="input-box">
                                        <input type="text" name="search[suburb]" id="suburb" value="{$form_data.suburb}" class="input-text disable-auto-complete" onclick="suburb_overlay.getData(this)" onkeyup="suburb_overlay.moveByKey(event)" style="width:210px"/>
                                        <ul>
                                            <div id="suburb_overlay" class="search_overlay" style="display:none; position: absolute;margin: 0px 0px 0px 3px;"></div>
                                        </ul>
                                    </div>
                                </div>
                                <div class="field" style="width:218px;float:right">
                                    <label class="label-search">
                                        <strong>Postcode</strong>
                                    </label>
                                    <div style="" class="input-box">
                                       <input type="text" name="search[postcode]" id="postcode" value="{$form_data.postcode}" class="input-text disable-auto-complete" style="width:210px"/>
                                    </div>
                                </div>
                            </li>
                            
                            <li class="fields">
                                <div class="field" style="width:218px">
                                    <label>
                                        <strong>Country</strong>
                                    </label>
                                    <div style="" class="input-box">
                                        <select name="search[country]" id="country" class="input-select" onchange="Common.changeCountry('/modules/general/action.php?action=get_states',this,'state')" style="width:218px">
                                           <!-- {html_options options=$search_data.country selected =$form_data.country} -->
                                            {html_options options = $countries selected = $form_data.country}
                                        </select>
                                    </div>
                                </div>
                                
                                 <div class="field" style="width:218px;float:right">
                                    <label>
                                        <strong>Property kind</strong>
                                    </label>
                                    <div style="" class="input-box">
                                        <select name="search[property_kind]" id="property_kind" class="input-select" onchange="pro.getKind('/modules/property/action.php?action=get_property_type& search=1', this, '#property_type'), pro.onChangeKind(this, new Array(), new Array('#p_kind2_1','#p_kind2_2'))"style="width:218px">
                                            {html_options options=$search_data.kinds selected =$form_data.property_kind}
                                        </select>
                                    </div>
                                </div>                                            
                            
                            </li> 
                            
                            <li class="fields" id="p_kind2_1">
                                <div class="field" style="width:218px">
                                    <label>
                                        <strong>Bathrooms</strong>
                                    </label>
                                    <div style="" class="input-box">
                                        <select name="search[bathroom]" id="bathroom" class="input-select" style="width:218px">
                                            {html_options options=$search_data.bathroom selected =$form_data.bathroom}
                                        </select>
                                    </div>
                                </div>
                            </li>

                            <li class="fields">
                                <div class="field" style="width:140px;margin-right:22px;">
                                    <label><strong>Parking</strong></label>
                                    <div style="" class="input-box">
                                        <select name="search[parking]" id="parking" class="input-select" onchange="pro.onChangeKind(this, new Array(), new Array('#p_parking1_1','#p_parking1_2') , 0)" style="width:140px">
                                            {html_options options = $search_data.parking selected = $form_data.parking}
                                        </select>
                                    </div>
                                </div>
                                <div class="field" style="width:140px;margin-right: 5px;" id="p_parking1_1">
                                    <label>
                                        <strong class="font-avsearch">Car Parking</strong>
                                    </label>
                                    <div style="" class="input-box">
                                         <select name="search[car_port]" id="car_port" class="input-select" style="width:140px">
                                            {html_options options=$search_data.car_port selected =$form_data.car_port}
                                        </select>
                                    </div>
                                </div>
                                <div class="field" style="width:140px;float: right;" id="p_parking1_2">
                                    <label>
                                        <strong class="font-avsearch">Carspaces</strong>
                                    </label>
                                    <div style="margin-right: 0px;" class="input-box">
                                         <select name="search[car_space]" id="car_space" class="input-select" style="width:140px">
                                            {html_options options=$search_data.car_spaces selected =$form_data.car_space}
                                        </select>
                                    </div>
                                </div>
                            </li> 
                            
                            <li class="fields">
                            	<div class="buttons-set">
                            		<input type="button" value="" class="btn-search" onclick="search_overlay.submit()"/>
                                </div>
                            </li>                                                                         	
                        </ul>
                    </div>
                    <input type="hidden" id="is_submit" name="is_submit" value="0"/>
                </form>
                <!--                                
                <div class="buttons-set">
                    <button class="btn-red f-right btn-red-search" onclick="search_overlay.submit()">
                        <span><span>Search</span></span>
                    </button>
                    
                    <div class="clearthis"></div>
                </div>
                -->
            </div>
         </div>    
    </div>
</div> 
<script src="/modules/property/templates/js/property.js"></script>
<script type="text/javascript">
	var pro = new Property();
	pro.onChangeKind('#property_kind');
    //pro.onChangeKind('#property_kind', new Array(), new Array('#p_kind2_1','#p_kind2_2'),0);
</script>
