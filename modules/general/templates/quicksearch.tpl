<script type="text/javascript" src="/modules/general/templates/js/quicksearch.js"></script>

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

    {literal}
    <script src="/modules/general/templates/js/jquery.maphilight.min.js" type="text/javascript"></script>
    <script src="/modules/general/templates/js/jquery.metadata.min.js" type="text/javascript"></script>
    {/literal}

    <div class="quicksearch-box">
        <div class="quicksearch-title">QUICK SEARCH</div>

        <div class="map-location">
            <img src="/modules/general/templates/images/australia-map.png" alt="Australia Locations" name="areaMap" class="mapAreasAU" border="0" usemap="#mapAreasAU" id="areaMap" /><a>Click on Location</a>
            <map name="mapAreasAU" id="mapAreasAU">
                <area shape="poly" id="area_WA"  coords="93,26,93,134,87,138,79,138,73,140,67,144,63,149,56,151,50,150,45,150,39,151,34,155,25,158,18,155,13,152,13,148,17,141,15,135,14,129,11,124,12,118,10,114,8,111,6,105,4,102,2,97,6,94,5,88,3,82,5,78,6,70,8,73,13,68,22,62,26,63,32,61,42,58,53,49,56,45,56,40,59,38,61,41,64,40,65,35,69,35,69,30,72,27,76,23,81,20,84,20,87,23" href="/wa/houses-for-sale/" alt="Western Australia" title="Western Australia"  />
                <area shape="poly" coords="155,88,155,38,161,44,166,41,169,36,171,32,171,24,171,17,171,12,173,5,177,4,180,11,182,20,186,24,190,26,192,32,193,38,196,42,198,50,203,55,207,59,214,59,215,66,217,71,223,72,226,78,229,84,235,89,239,92,238,102,233,103,226,100,218,104,206,105,173,105,173,89" href="/qld/houses-for-sale/" title="Queensland" alt="Queensland" />
                <area shape="poly" coords="220,168,209,168,204,162,195,160,186,151,173,149,173,181,180,185,186,181,195,185,200,186,207,179,218,178,220,176" href="/vic/houses-for-sale/" title="Victoria" alt="Victoria" />
                <area shape="poly" coords="188,199" href="#" alt=""/><area shape="poly" coords="200,204,210,201,213,211,211,217,209,223,203,224,197,223,191,218,191,212,188,204,188,200" href="/tas/houses-for-sale/" title="Tasmania" alt="Tasmania" />
                <area shape="poly" coords="94,89,154,89,154,38,150,36,147,34,144,32,140,31,137,27,133,25,136,21,136,16,140,14,142,10,140,7,137,9,133,9,127,8,122,7,120,9,115,3,118,9,110,10,104,11,102,16,99,21,100,26,94,26" href="/nt/houses-for-sale/" title="Nothern Territory" alt="Nothern Territory" />
                <area shape="rect" coords="196,142,225,156" href="/act/houses-for-sale/" alt="Canberra" title="Canberra" class="{strokeColor:'ebc26e',strokeWidth:1,fillColor:'121011',fillOpacity:0.2}" />
                <area shape="poly" coords="174,107,218,107,231,104,241,105,239,123,240,130,235,139,227,150,221,168,210,168,196,158,183,151,174,149" href="/nsw/houses-for-sale/" alt="New South Wales" />
                <area shape="poly" coords="94,89,172,89,171,182,166,181,162,177,160,165,154,162,152,159,151,155,149,145,145,148,140,151,137,157,133,154,131,149,129,145,125,139,121,137,117,136,110,134,94,134" href="/sa/houses-for-sale/" alt="South Australia" title="South Australia" />
            </map>
        </div>

        <div class="form-list">
            <form name="frmSearch" id="frmSearch" method="post" action="/view-search-advance.html&rs=1" onsubmit="return false;">
                <ul class="form-list">
                    <li class="wide">
                        <label>ID or Suburb or Postcode</label>
                        <div class="input-box">
                            <input type="text" name="search[region]" id="region" value="{$form_data.region}" class="input-text disable-auto-complete" onclick="search_overlay.getData(this)" onkeyup="search_overlay.moveByKey(event)"/>
                            <div id="search_overlay" class="search_overlay quick_search_overlay_b" style="display:none;"></div>
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
                            <div class="input-box input-select">
                                <select name="search[property_type]" id="property_type" style="width:100%">
                                    {html_options options = $search_data.property_type selected = $form_data.property_type}
                                </select>
                            </div>
                        </div>
                        <div class="clearthis"></div>
                    </li>
                    <li class="fields" id="p_kind2">
                        <div class="field">
                            <label>Bedrooms</label>
                            <div class="input-box input-select">
                                <select name="search[bedroom]" id="bedroom" style="width:100%">
                                    {html_options options = $search_data.bedroom selected = $form_data.bedroom}
                                </select>
                            </div>
                        </div>
                        <div class="field">
                            <label>Bathrooms</label>
                            <div class="input-box input-select">
                                <select name="search[bathroom]" id="bathroom" >
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
            <button class="btn-red btn-red-search" onclick="document.getElementById('frmSearch').submit()">
                <span><span>Search</span></span>
            </button>
        </div>
    </div>
    <br clear="all"/>
{/if}


