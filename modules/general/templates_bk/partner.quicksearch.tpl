{literal}
<script type="text/javascript">
    var search_overlay = new Search();
    search_overlay._frm = '#frmSearch';
    search_overlay._text_search = '#suburb';
    search_overlay._overlay_container = '#search_overlay';
    search_overlay._url_suff = '&'+'type=suburb';

    search_overlay._success = function (data) {
        var info = jQuery.parseJSON(data);
        var content_str = "";
        var id = 0;
        if (info.length > 0) {
            search_overlay._total = info.length;
            for (i = 0; i < info.length; i++) {
                var id = 'sitem_' + i;
                content_str += "<li onclick='search_overlay.set2SearchText(this)' id='" + id + "'>" + info[i] + "</li>";
                search_overlay._item.push(id);
            }
        }

        search_overlay._getValue = function (data) {
            var info = jQuery.parseJSON(data);
            jQuery(search_overlay._text_obj_1).val(info[0]);
            $('#uniform-state span').html($(search_overlay._text_obj_1 + " option:selected").text());
        };

        if (content_str.length > 0) {
            jQuery(search_overlay._overlay_container).html(content_str);
            jQuery(search_overlay._overlay_container).show();
            jQuery(search_overlay._overlay_container).width(jQuery(search_overlay._text_search).width());
        } else {
            jQuery(search_overlay._overlay_container).hide();
        }
    };
    document.onclick = function () {
        search_overlay.closeOverlay()
    };
</script>
<script src="modules/banner/templates/js/checksearch_partner.js" type="text/javascript"> </script>
{/literal}

{if $action == 'search-partner'}
<div class="refine-search-box">
    <div class="title">
        <h3>Refine Search</h3>
    </div>
    <div class="form">
    	 <form name="frmSearch" id="frmSearch" method="post" action="/services-list.html&rs=1{if isset($mode) and $mode == 'grid'}&mode=grid{/if}" enctype="multipart/form-data">
     
        <ul class="form-list">
            <li class="wide">
                <label class="labelqsearch2">
                   Company or Bussiness Register
                </label>
                <div class="input-box">
                    <input type="text" name="search[firstname]" id="firstname" value="{$form_data.firstname}"/>
                </div>
            </li>
            <li class="wide">
                <label class="labelqsearch2">
                    Region
                </label>
                <div class="input-box">
                       <input type="text" name="search[region]" id="suburb" value="{$form_data.region}" class="disable-auto-complete" onclick="search_overlay.getData(this)" onkeypress="search_overlay.keypress(event)" onkeyup="search_overlay.moveByKey(event)"/>
                         <ul style="list-style:none;">
                            <div id="search_overlay" class="search_overlay" style="display:none;"></div>
                        </ul>
                </div>
            </li>
           

            <li class="control">
		{if isset($authentic) and is_array($authentic) and count($authentic)>0 and $authentic.id > 0}
		{else}
                	<a href="/?module=agent&action=landing">REGISTER FOR EMAIL/SMS NOTIFICATIONS</a>
		{/if}
            </li>
        </ul>
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

    {literal}
        <script src="../modules/general/templates/js/jquery.maphilight.min.js" type="text/javascript"></script>
        <script src="../modules/general/templates/js/jquery.metadata.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(function() {
                $('.mapAreasAU').maphilight();
            });
            $.fn.maphilight.defaults = {
                    fill: true,
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
    {*{if $authentic.id > 0 and isset($db_checkpartner) and $db_checkpartner.type_id == 3} *}
      	{*{include file = "`$ROOTPATH`/modules/general/templates/partner.quicksearch.login.tpl"} *}
    {*{/if}*}

<div class="quicksearch-box-partner">
	<div class="quicksearch-title">
       		QUICK SEARCH
    </div>

    <div class="map-location">
            <img src="modules/general/templates/images/australia-map.png" alt="Australia Locations" name="areaMap" class="mapAreasAU" border="0" usemap="#mapAreasAU" id="areaMap" /><a href="#">Click on Location</a>
            {literal}
                 <map name="mapAreasAU" id="mapAreasAU">
                    <area shape="poly" id="area_WA"  coords="93,26,93,134,87,138,79,138,73,140,67,144,63,149,56,151,50,150,45,150,39,151,34,155,25,158,18,155,13,152,13,148,17,141,15,135,14,129,11,124,12,118,10,114,8,111,6,105,4,102,2,97,6,94,5,88,3,82,5,78,6,70,8,73,13,68,22,62,26,63,32,61,42,58,53,49,56,45,56,40,59,38,61,41,64,40,65,35,69,35,69,30,72,27,76,23,81,20,84,20,87,23" href="javascript:search_overlay.fromMapPartner('WA')" alt="Western Australia" title="Western Australia"  />
                    <area shape="poly" coords="155,88,155,38,161,44,166,41,169,36,171,32,171,24,171,17,171,12,173,5,177,4,180,11,182,20,186,24,190,26,192,32,193,38,196,42,198,50,203,55,207,59,214,59,215,66,217,71,223,72,226,78,229,84,235,89,239,92,238,102,233,103,226,100,218,104,206,105,173,105,173,89" href="javascript:search_overlay.fromMapPartner('QLD')" title="Queensland" alt="Queensland" />
                    <area shape="poly" coords="220,168,209,168,204,162,195,160,186,151,173,149,173,181,180,185,186,181,195,185,200,186,207,179,218,178,220,176" href="javascript:search_overlay.fromMapPartner('VIC')" title="Victoria" alt="Victoria" />
                    <area shape="poly" coords="188,199" href="#" alt=""/><area shape="poly" coords="200,204,210,201,213,211,211,217,209,223,203,224,197,223,191,218,191,212,188,204,188,200" href="javascript:search_overlay.fromMapPartner('TAS')" title="Tasmania" alt="Tasmania" />
                    <area shape="poly" coords="94,89,154,89,154,38,150,36,147,34,144,32,140,31,137,27,133,25,136,21,136,16,140,14,142,10,140,7,137,9,133,9,127,8,122,7,120,9,115,3,118,9,110,10,104,11,102,16,99,21,100,26,94,26" href="javascript:search_overlay.fromMapPartner('NT')" title="Nothern Territory" alt="Nothern Territory" />
                    <area shape="rect" coords="196,142,225,156" href="javascript:search_overlay.fromMapPartner('ACT')" alt="Canberra" title="Canberra" class="{strokeColor:'ebc26e',strokeWidth:1,fillColor:'121011',fillOpacity:0.2}" />
                    <area shape="poly" coords="174,107,218,107,231,104,241,105,239,123,240,130,235,139,227,150,221,168,210,168,196,158,183,151,174,149" href="javascript:search_overlay.fromMapPartner('NSW')" alt="New South Wales" />
                    <area shape="poly" coords="94,89,172,89,171,182,166,181,162,177,160,165,154,162,152,159,151,155,149,145,145,148,140,151,137,157,133,154,131,149,129,145,125,139,121,137,117,136,110,134,94,134" href="javascript:search_overlay.fromMapPartner('SA')" alt="South Australia" title="South Australia" />
                  </map>
            {/literal}
    </div>
    <div class="form-list">
    	<form name="frmSearch" id="frmSearch" method="post" action="/search-partner.html&rs=1" onsubmit="return false;">
            <ul style="list-style: none;">
                {*<li class="wide" style="clear:both;display:block;">
                    <div class="field">
                         <label class="labelqsearch2">
                               Company or Bussiness Register
                            </label>
                            <div class="input-box">
                                <input type="text" name="search[firstname]" id="firstname" value="{$form_data.firstname}" class="w260px" />
                            </div>
                    </div>
                </li>
                <li class="wide">
                    <label class="labelqsearch2">
                        Suburbs or Regions
                    </label>
                    <div class="input-box">
                        <input type="text" name="search[suburb]" id="suburb" value="{$form_data.suburb}" class="w260px disable-auto-complete" onclick="search_overlay.getData(this)" onkeyup="search_overlay.moveByKey(event)"/>
                        <div id="search_overlay" class="search_overlay quick_search_overlay" style="display:none;"></div>
                    </div>
                </li>
                <li class="wide">
                        <label class="labelqsearch2">
                            Postal Address
                        </label>
                        <div class="input-box">
                            <input type="text" name="search[postal_address]" id="postal_address" value="{$form_data.postal_address}" class="w260px" />
                        </div>
                </li>*}
                    <li class="wide">
                        <label class="labelqsearch2">
                            Company or Bussiness Register
                        </label>

                        <div class="input-box">
                            <input type="text" name="search[firstname]" id="firstname" value="{$form_data.firstname}"
                                   class="w260px" />
                        </div>
                    </li>
                    <li class="wide">
                        <label class="labelqsearch2">
                            Regions
                        </label>
                        <div class="input-box">
                            <input type="text" name="search[region]" id="suburb" value="{$form_data.region}"
                                   class="w260px disable-auto-complete" onclick="search_overlay.getData(this)"
                                   onkeypress="search_overlay.keypress(event)"
                                   onkeyup="search_overlay.moveByKey(event)" />
                            <ul style="list-style:none;">
                                <div id="search_overlay" class="search_overlay" style="display:none;"></div>
                            </ul>
                        </div>
                    </li>
                   {* <li class="fields">
                        <div class="field">
                            <label class="labelqsearch2">
                               Address
                            </label>
                            <div class="input-box">
                                <input type="text" name="search[address]" id="address"
                                       value="{$form_data.address}" />
                            </div>
                        </div>
                        <div class="field">
                            <label class="labelqsearch2">
                                Postal Address
                            </label>

                            <div class="input-box">
                                <input type="text" name="search[postal_address]" id="postal_address"
                                       value="{$form_data.postal_address}" class="mg-left6" />
                            </div>
                        </div>
                    </li>
                    <li class="fields">
                        <div class="field">
                            <label class="labelqsearch2">
                               Website
                            </label>
                            <div class="input-box">
                                <input type="text" name="search[website_partner]" id="website_partner"
                                       value="{$form_data.website_partner}" />
                            </div>
                        </div>
                        <div class="field">
                            <label class="labelqsearch2">
                                Telephone
                            </label>

                            <div class="input-box">
                                <input type="text" name="search[telephone]" id="telephone"
                                       value="{$form_data.telephone}" class="mg-left6" />
                            </div>
                        </div>
                    </li>*}
            </ul>

          </form>
    </div>
    <div class="actions">
        <button class="btn-red btn-red-search" onclick="document.getElementById('frmSearch').submit()" style="margin-top:10px;">
            <span><span>Search</span></span>
        </button>
    </div>

</div>
<br clear="all"/>
{/if} <!-- IF ACTION ==  'search-partner' -->
<script type="text/javascript">
onReloadSearchPartners(document.getElementById("frmSearch"));
</script>
 

