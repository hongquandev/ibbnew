<script type="text/javascript" src="/modules/general/templates/mobile/js/quicksearch.js"></script>
{*
{if in_array($action, array('search','search-auction','search-sale','search-ebiddar','search-agent-auction'))}
<div class="refine-search-box">
    <div class="title">
        <h3>Refine Search</h3>
    </div>
    <div class="form">
        <form name="frmSearch" id="frmSearch" method="post" action="/view-search-advance.html&rs=1&state_code={$state_code}&mode={$mode}" onsubmit="return false;">
        <ul class="form-list">
            <li class="wide">
                <label class="labelqsearch2">ID or Suburb or Postcode</label>
                <div class="input-box">
                    <input type="text" name="search[region]" id="region" value="{$form_data.region}" class="disable-auto-complete" onclick="search_overlay.getData(this)" onkeypress="search_overlay.keypress(event)" onkeyup="search_overlay.moveByKey(event)"/>
                    <div id="search_overlay" class="search_overlay quick_search_overlay" style="display:none;"></div>
                </div>
            </li>
            <li class="fields">
                <div class="field">
                    <label>Property Kind</label>
                    <div class="input-select">
                        <select name="search[property_kind]" id="property_kind" style="width:100%" onchange="pro.getKind('/modules/property/action.php?action=get_property_type& search=1', this, 'property_type'), pro.onChangeKind(this, new Array(), new Array('#p_kind2'))">
                            {html_options options = $search_data.kinds selected = $form_data.property_kind}
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label>Property Type</label>
                    <div class="input-select" >
                        <select name="search[property_type]" id="property_type" class="mg-left6">
                            {html_options options = $search_data.property_type selected = $form_data.property_type}
                        </select>
                    </div>
                </div>
                <div class="clearthis"></div>
            </li>
            <li class="fields" id="p_kind2">
                <div class="field">
                    <label class="labelqsearch3">Bedrooms</label>
                    <div class="input-box input-select">
                        <select name="search[bedroom]" id="bedroom">
                            {html_options options = $search_data.bedroom selected = $form_data.bedroom}
                        </select>
                    </div>
                </div>
                <div class="field">
                    <label>Bathrooms</label>
                    <div class="input-box input-select">
                        <select name="search[bathroom]" id="bathroom" class="mg-left6">
                            {html_options options = $search_data.bathroom selected = $form_data.bathroom}
                        </select>
                    </div>
                </div>
                <div class="clearthis"></div>
            </li>
            <li class="fields">
                <div class="field">
                    <label>Min.price</label>
                    <div class="input-box input-select">
                        <select name="search[minprice]" id="minprice" style="width:100%">
                            {html_options options=$search_data.min_price selected =$form_data.minprice}
                        </select>
                    </div>
                </div>
                <div class="field">
                    <label>Max.price</label>
                    <div class="input-box input-select">
                        <select name="search[maxprice]" id="maxprice" class="mg-left6">
                            {html_options options=$search_data.max_price selected =$form_data.maxprice}
                        </select>
                    </div>
                </div>
                <div class="clearthis"></div>
            </li>
            <li class="fields">
                <div class="field">
                    <label>Min.Landsize</label>
                    <div class="input-box">
                        <select name="search[land_size_min]" id="land_size_min" class="input-select">
                            {html_options options=$search_data.land_size selected =$form_data.land_size_min}
                        </select>
                    </div>
                </div>
                <div class="field">
                    <label>Max.Landsize</label>
                    <div class="input-box">
                        <select name="search[land_size_max]" id="land_size_max" class="input-select">
                            {html_options options=$search_data.land_size selected =$form_data.land_size_max}
                        </select>
                    </div>
                </div>

                <div class="clearthis"></div>
                <div>
                    <input type="hidden" name="search[auction_sale]" id="auction_sale" value="{$form_data.auction_sale}" />
                    <input type="hidden" name="search[mode]" id="mode" value="{$form_data.mode}" />
                    <input type="hidden" name="search[suburb]" id="suburb" value="{$form_data.suburb}" />
                    <input type="hidden" name="search[state]" id="state" value="{$form_data.state}" />
                    <input type="hidden" name="search[parking]" id="parking" value="{$form_data.parking}" />
                    <input type="hidden" name="search[postcode]" id="postcode" value="{$form_data.postcode}" />
                    <input type="hidden" name="search[car_port]" id="car_port" value="{$form_data.car_port}" />
                    <input type="hidden" name="search[car_space]" id="car_space" value="{$form_data.car_space}" />
                    <input type="hidden" name="search[address]" id="address" value="{$form_data.address}" />
                    <input type="hidden" name="search[order_by]" id="order_by" value="{$form_data.order_by}" />
                    <input type="hidden" name="search[state_code]" id="state_code" value="{$form_data.state_code}" />
                </div>
            </li>
            <li class="fields">
                <div class="field">
                    <label>Unit</label>
                    <div class="input-box">
                        <select name="search[unit]" id="unit" class="input-select">
                            {html_options options=$search_data.unit selected =$form_data.unit}
                        </select>
                    </div>
                </div>
                <div class="field">
                    <label>iBB Sustainability</label>
                    <div class="input-box input-select">
                       <select name="search[green_rating]" id="green_rating" class="mg-left6">
                           {html_options options = $search_data.rating selected = $form_data.green_rating}
                       </select>
                    </div>
                </div>
                <div class="clearthis"></div>
            </li>
            {if isset($authentic) and is_array($authentic) and count($authentic)>0 and $authentic.id > 0}
                <li class="control" style="display: none;"></li>
            {else}
                 <li class="control"><a href="/?module=agent&action=landing">REGISTER FOR EMAIL/SMS NOTIFICATIONS</a></li>
            {/if}
        </ul>
        </form>
        <div class="buttons-set">
            <button class="btn-red" onclick="document.getElementById('frmSearch').submit()">
                <span><span>Search</span></span>
            </button>
        </div>
    </div>
    <div class="bg-bottom"></div>
</div>
<br clear="all"/>
{else}
*}

<script src="/modules/general/templates/js/jquery.maphilight.min.js" type="text/javascript"></script>
<script src="/modules/general/templates/js/jquery.metadata.min.js" type="text/javascript"></script>

<div class="quicksearch-box">
    <div class="map-location">
        <img src="../../modules/general/templates/images/australia-map2.png" alt="Australia Locations" name="areaMap" class="mapAreasAU" border="0" usemap="#mapAreasAU" id="areaMap" />
    {literal}
        <map name="mapAreasAU" id="mapAreasAU">
            <area shape="poly" coords="101,34,110,147,103,151,96,151,92,153,88,158,85,163,80,164,76,165,72,165,68,165,65,167,62,169,58,173,54,176,50,175,46,175,42,174,38,172,38,167,38,161,39,155,39,147,36,151,34,147,31,145,30,142,28,138,24,134,21,131,21,127,17,124,20,120,18,116,15,110,13,106,14,102,12,96,18,91,26,85,29,81,39,78,42,75,48,74,53,72,57,69,58,64,62,60,62,56,62,51,65,49,66,53,67,55,69,58,70,54,70,50,69,47,71,45,75,45,75,41,75,38,79,38,81,36,84,32,88,30,90,27,93,29,96,32,100,35,108,107" href="javascript:search_overlay.fromMap('WA')" title="Western Australia" target="_blank" alt="WA" />
            <area shape="poly" coords="179,160,183,161,185,164,188,166,191,167,193,171,197,174,202,175,207,176,212,176,216,176,219,178,221,181,224,183,226,186,220,186,215,188,211,191,208,192,205,189,202,187,197,189,195,192,192,190,188,189,184,188,180,186,178,182" href="javascript:quicksearch_overlay.fromMap('VIC')" target="_blank" title="Victoria" alt="VIC" />
            <area shape="poly" coords="108,107,179,106,178,182,175,173,172,169,169,170,167,169,169,164,167,160,164,162,162,166,160,168,162,163,163,158,164,154,163,149,161,154,159,157,155,159,153,162,153,166,151,166,149,160,147,157,144,154,141,149,137,147,132,146,127,145,120,145,116,145,113,145,110,146" href="javascript:quicksearch_overlay.fromMap('SA')" target="_blank" title="South Australia" alt="SA" />
            <area shape="poly" coords="102,34,106,34,107,30,107,28,109,24,111,20,115,16,120,14,126,13,125,10,121,9,117,10,113,11,110,11,109,9,112,8,117,8,123,6,128,9,131,11,136,12,140,14,143,14,146,15,149,14,150,13,151,15,149,20,147,23,146,28,145,32,147,33,150,36,153,38,157,38,159,41,162,43,162,56,162,105,109,106" href="javascript:quicksearch_overlay.fromMap('NT')" target="_blank" title="Nothern Territory" alt="NT" />
            <area shape="poly" coords="163,44,168,46,172,49,175,51,179,48,183,39,186,32,185,21,186,11,189,4,192,11,194,16,196,24,198,29,202,27,207,32,208,38,209,44,212,50,213,57,217,61,226,67,231,74,232,81,235,84,238,83,240,88,243,92,247,99,250,104,253,122,252,126,245,126,241,129,237,129,232,126,227,126,221,127,205,127,188,126,180,126,181,106,163,105" href="javascript:quicksearch_overlay.fromMap('QLD')" target="_blank" title="Queensland" alt="QLD" />

            <area shape="poly" coords="204,158,225,156,224,171,203,171,204,159" href="javascript:quicksearch_overlay.fromMap('ACT')" title="Canberra" alt="ACT" />
            <area shape="poly" coords="191,200,196,201,199,204,202,205,206,203,209,202,212,201,213,205,214,209,212,213,209,216,205,219,203,223,199,224,197,220,195,216,194,209,193,205" href="javascript:quicksearch_overlay.fromMap('TAS')" title="Tasmania" alt="TAS"  />
            <area shape="poly" coords="180,127,197,127,225,127,233,126,237,129,241,130,245,126,250,126,253,127,251,134,248,138,249,141,246,145,244,150,240,154,236,159,234,167,230,174,229,180,227,184,222,182,217,176,206,175,199,174,193,171,188,166,184,161,180,160" href="javascript:quicksearch_overlay.fromMap('NSW')" alt="NSW" title="New South Wales"/>
        </map>
    {/literal}                
    </div>

    <div class="form-list">
    	<form name="frmSearch" id="frmSearch" method="post" action="/view-search-advance.html&rs=1" onsubmit="return false;">
            <ul class="form-list">
                <li class="wide">
                    <label>Property ID, Suburb or Postcode</label>
                    <div class="input-box">
                        <input type="text" name="search[region]" id="quick_region" value="{$form_data.region}" class="input-text disable-auto-complete" onclick="quicksearch_overlay.getData(this)" onkeyup="quicksearch_overlay.moveByKey(event)" onkeypress="return submitenter(this,event)" />
                        <div id="quick_search_overlay" class="search_overlay search_overlay_b" style="display:none;"></div>
                    </div>
                </li>
                <li class="wide">
		            {*<div class="field">
	                    <label>Property Kind</label>
	                    <div class="input-select">
	                        <select name="search[property_kind]" id="property_kind" onchange="pro.getKind('/modules/property/action.php?action=get_property_type& search=1', this, 'property_type'), pro.onChangeKind(this, new Array(), new Array('#p_kind2'))">
	                            {html_options options = $search_data.kinds selected = $form_data.property_kind}
	                        </select>
	                    </div>
		            </div>*}

                    {*<div class="field">*}
                        <label>Property Type</label>
                        <div class="input-box input-select">
                            <select name="search[property_type]" id="property_type" style="width:102%">
                                {html_options options = $search_data.property_type selected = $form_data.property_type}
                            </select>
                        </div>
                    {*</div>
                    <div class="clearthis"></div>*}
                </li>
                <li class="fields" id="p_kind2">
                    <div class="field">
                        <label>Bedrooms</label>
                        <div class="input-box input-select">
                            <select name="search[bedroom]" id="bedroom">
                                {html_options options = $search_data.bedroom selected = $form_data.bedroom}
                            </select>
                        </div>
                    </div>
                    <div class="field">
                        <label>Bathrooms</label>
                        <div class="input-box input-select">
                            <select name="search[bathroom]" id="bathroom">
                                {html_options options = $search_data.bathroom selected = $form_data.bathroom}
                            </select>
                        </div>
                    </div>
                    <div class="clearthis"></div>
                </li>
                <li class="fields">
                    <div class="field">
                        <label>Min.price</label>
                        <div class="input-box input-select">
                            <select name="search[minprice]" id="minprice" >
                                {html_options options=$search_data.min_price selected =$form_data.minprice}
                            </select>
                        </div>
                    </div>
                    <div class="field">
                        <label>Max.price</label>
                        <div class="input-box input-select">
                            <select name="search[maxprice]" id="maxprice" >
                                {html_options options=$search_data.max_price selected =$form_data.maxprice}
                            </select>
                        </div>
                    </div>
                    <div class="clearthis"></div>
                </li>
            </ul>
        </form>
    </div>
    <div class="actions">
        <button class="btn-search f-right" onclick="document.getElementById('frmSearch').submit()">
            <span><span>Search</span></span>
        </button>
    </div>
   <div class="clearthis"></div>
</div>
<br clear="all"/>
{*{/if}*}

