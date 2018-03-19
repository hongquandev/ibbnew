{if in_array($action, array('search-agent'))}

<script src="/modules/agent/templates/js/checkcountry_register_fast.js" type="text/javascript"></script>
{literal}
<script type="text/javascript">
var search_overlay = new Search();
search_overlay._frm = '#frmSearch';
search_overlay._text_search = '#personal_suburb';
search_overlay._overlay_container = '#search_overlay';
search_overlay._url_suff = '&'+'type=suburb1';

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
};
jQuery(document).ready(function(){
        onLoad('personal');
});
document.onclick = function() {search_overlay.closeOverlay()};


</script>
{/literal}
<div class="refine-search-box">
    <div class="title">
        <h3>Refine Search</h3>
    </div>
    <div class="form">
    	<form name="frmSearch" id="frmSearch" method="post" action="{$form_action}" onsubmit="return false;">
            <ul class="form-list">
                 <li class="fields">
                    <div class="field">
                        <label>Agent name</label>
                        <div class="input-box input-select">
                             <input type="text" name="search[agent_name]" id="agent_name" value="{$form_data.agent_name}" class="input-text disable-auto-complete"/>
                        </div>
                    </div>
                    <div class="field">
                        <label>
                            Agency name
                        </label>
                        <div class="input-box input-select">
                            <input type="text" name="search[agency_name]" id="agency_name" value="{$form_data.agency_name}" class="input-text disable-auto-complete"/>
                        </div>
                    </div>
                    <div class="clearthis"></div>
                </li>
                <li class="fields">
                    <div class="field">
                        <label>Suburb</label>

                        <div class="input-box input-select">
                            <input type="text" name="search[suburb]" id="personal_suburb" value="{$form_data.suburb}" onclick="search_overlay.getData(this)" onkeyup="search_overlay.moveByKey(event)"
                                   class="input-text"/>
                            <ul>
                                <div id="search_overlay" class="search_overlay" style="display:none; position: absolute;"></div>
                            </ul>
                        </div>
                    </div>
                    <div class="field">
                        <label>Postcode</label>

                        <div class="input-box input-select">
                            <input type="text" name="search[postcode]" id="personal_postcode" value="{$form_data.postcode}"
                                   class="input-text"
                                  />
                        </div>
                    </div>
                </li>
                <li class="fields">
                    <div class="field">
                        <label>State</label>

                        <div class="input-box input-select">
                            <div id="inactive_personal_state">
                                <select name="search[state]" id="personal_state"
                                        class="input-select">
                                    {html_options options = $subState selected = $form_data.state}
                                </select>
                            </div>
                            <input type="text" id="personal_other_state" name="search[other_state]" class="input-text"
                                   value="{$form_data.other_state}"/>
                        </div>
                    </div>
                    

                    <div class="field">
                        <label>Country</label>

                        <div class="input-box input-select input-select-new">
                            <select name="search[country]" id="personal_country" class="input-select"
                                    onchange="onLoad('personal')">
                                {html_options options = $options_country selected = $form_data.country}
                            </select>
                        </div>
                    </div>
                    <div class="clearthis">
                    </div>
                </li>
                <li class="wide">
                    <label>List by</label>

                    <div class="input-box input-select input-select-new">
                        <select name="search[view]" id="view" class="input-select">
                            <option value="agent" {if $form_data.view == 'agent'}selected{/if}>Agent</option>
                            <option value="property" {if $form_data.view == 'property'}selected{/if}>Property</option>
                        </select>
                    </div>
                     {*   <input type="radio" name="search[view][]" value="agent" checked="checked" /> <label>List by agent</label>
                        <input type="radio" name="search[view][]" value="agency" /> <label>List by agency</label>
                        <input type="radio" name="search[view][]" value="property" /> <label>List by property</label>*}
                </li>
            </ul>
        <input type="hidden" name="search[order_by]" id="order_by" value="{$form_data.order_by}" />
        </form>
        <div class="buttons-set">
            <button class="btn-red" onclick="document.getElementById('frmSearch').submit()">
                <span><span>Search</span></span>
            </button>
        </div>
    </div>
    <div class="bg-bottom">
    </div>
</div>
<br clear="all"/>
{else}

<script src="/modules/agent/templates/js/checkcountry_register_fast.js" type="text/javascript"></script>
{literal}
<script type="text/javascript">
var search_overlay = new Search();
search_overlay._frm = '#frmSearch';
search_overlay._text_search = '#personal_suburb';
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
};
jQuery(document).ready(function(){
        onLoad('personal');
});
document.onclick = function() {search_overlay.closeOverlay()};


</script>
{/literal}
{literal}
	<script src="../../modules/general/templates/js/jquery.maphilight.min.js" type="text/javascript"></script>
   	<script src="../../modules/general/templates/js/jquery.metadata.min.js" type="text/javascript"></script>
	<script  type="text/javascript">$(function() {
		$('.mapAreasAU').maphilight();
		});
		$.fn.maphilight.defaults = {
			fill: true,
			/* Change Effect Color 98051a, ff0000 */
			fillColor: 'e4ba64',
			fillOpacity: 0.6,
			stroke: true,
			strokeColor: 'ebc26e',
			strokeOpacity: 1,
			strokeWidth: 0,
			fade: true,
			alwaysOn: false,
			neverOn: false,
			groupBy: false
	}
    </script>
{/literal}

<div class="quicksearch-box-partner">
	  <div class="quicksearch-title">
       		QUICK SEARCH
      </div>

      <div class="map-location">
            <img src="../../modules/general/templates/images/australia-map.png" alt="Australia Locations" name="areaMap" class="mapAreasAU" border="0" usemap="#mapAreasAU" id="areaMap" /><a>Click on Location</a>
{literal}
      <map name="mapAreasAU" id="mapAreasAU">


<area shape="poly" id="area_WA"  coords="93,26,93,134,87,138,79,138,73,140,67,144,63,149,56,151,50,150,45,150,39,151,34,155,25,158,18,155,13,152,13,148,17,141,15,135,14,129,11,124,12,118,10,114,8,111,6,105,4,102,2,97,6,94,5,88,3,82,5,78,6,70,8,73,13,68,22,62,26,63,32,61,42,58,53,49,56,45,56,40,59,38,61,41,64,40,65,35,69,35,69,30,72,27,76,23,81,20,84,20,87,23" href="javascript:search_overlay.fromMapAgent('WA')" alt="Western Australia" title="Western Australia"  />
<area shape="poly" coords="155,88,155,38,161,44,166,41,169,36,171,32,171,24,171,17,171,12,173,5,177,4,180,11,182,20,186,24,190,26,192,32,193,38,196,42,198,50,203,55,207,59,214,59,215,66,217,71,223,72,226,78,229,84,235,89,239,92,238,102,233,103,226,100,218,104,206,105,173,105,173,89" href="javascript:search_overlay.fromMapAgent('QLD')" title="Queensland" alt="Queensland" />
<area shape="poly" coords="220,168,209,168,204,162,195,160,186,151,173,149,173,181,180,185,186,181,195,185,200,186,207,179,218,178,220,176" href="javascript:search_overlay.fromMapAgent('VIC')" title="Victoria" alt="Victoria" />
<area shape="poly" coords="188,199" href="#" alt=""/><area shape="poly" coords="200,204,210,201,213,211,211,217,209,223,203,224,197,223,191,218,191,212,188,204,188,200" href="javascript:search_overlay.fromMapAgent('TAS')" title="Tasmania" alt="Tasmania" />
<area shape="poly" coords="94,89,154,89,154,38,150,36,147,34,144,32,140,31,137,27,133,25,136,21,136,16,140,14,142,10,140,7,137,9,133,9,127,8,122,7,120,9,115,3,118,9,110,10,104,11,102,16,99,21,100,26,94,26" href="javascript:search_overlay.fromMapAgent('NT')" title="Nothern Territory" alt="Nothern Territory" />
<area shape="rect" coords="196,142,225,156" href="javascript:search_overlay.fromMapAgent('ACT')" alt="Canberra" title="Canberra" class="{strokeColor:'ebc26e',strokeWidth:1,fillColor:'121011',fillOpacity:0.2}" />
<area shape="poly" coords="174,107,218,107,231,104,241,105,239,123,240,130,235,139,227,150,221,168,210,168,196,158,183,151,174,149" href="javascript:search_overlay.fromMapAgent('NSW')" alt="New South Wales" />

<area shape="poly" coords="94,89,172,89,171,182,166,181,162,177,160,165,154,162,152,159,151,155,149,145,145,148,140,151,137,157,133,154,131,149,129,145,125,139,121,137,117,136,110,134,94,134" href="javascript:search_overlay.fromMapAgent('SA')" alt="South Australia" title="South Australia" />
</map>
{/literal}


    </div>

    <div class="form-list">

    	<form name="frmSearch" id="frmSearch" method="post" action="{$form_action}" onsubmit="return false;">
            <ul class="form-list">
                <li class="wide">
                    <label>
                         Location
                    </label>
                    <div class="input-box">
                        <input type="text" name="search[location]" id="personal_suburb" value="{$form_data.location}" class="input-text disable-auto-complete" onclick="search_overlay.getData(this)" onkeyup="search_overlay.moveByKey(event)"/>
                        <div id="search_overlay" class="search_overlay quick_search_overlay_b" style="display:none;"></div>
                    </div>
                </li>

                <li class="fields">
                    <div class="field">
                        <label>Agent name</label>
                        <div class="input-box input-select">
                             <input type="text" name="search[agent_name]" id="agent_name" value="{$form_data.agent_name}" class="input-text disable-auto-complete"/>
                        </div>
                    </div>
                    <div class="field">
                        <label>
                            Agency name
                        </label>
                        <div class="input-box input-select">
                            <input type="text" name="search[agency_name]" id="agency_name" value="{$form_data.agency_name}" class="input-text disable-auto-complete"/>
                        </div>
                    </div>
                    <div class="clearthis"></div>
                </li>
                {*<li class="wide">
                        <input type="radio" name="search[view][]" value="agent" checked="checked" /> <label>List by agent</label>
                        <br />
                        <input type="radio" name="search[view][]" value="agency" /> <label>List by agency</label>
                        <br />
                        <input type="radio" name="search[view][]" value="property" /> <label>List by property</label>
                </li>*}
                <li class="wide">
                    <label>List by</label>

                    <div class="input-box input-select input-select-new">
                        <select name="search[view]" id="view" class="input-select">
                            <option value="agent" {if $form_data.view == 'agent'}selected{/if}>Agent</option>
                            <option value="property" {if $form_data.view == 'property'}selected{/if}>Property</option>
                        </select>
                    </div>
                </li>
            </ul>
        </form>

    </div>
        <div class="actions">
            <button class="btn-red btn-red-search" onclick="document.getElementById('frmSearch').submit()" style="padding-top:8px;*padding-top:2px;">
                <span><span>Search</span></span>
            </button>
        </div>

</div>
<br clear="all"/>
{/if}
