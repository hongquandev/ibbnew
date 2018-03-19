<script type="text/javascript">
	var url = '{$ROOTURL}/?module=property&action=search';
{literal}
	var search_overlay = new Search();
	search_overlay._frm = '#frmSearch';
	search_overlay._text_search = '#region';
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
	}
	
	document.onclick = function() {search_overlay.closeOverlay()};
	
	function fbSearch() {
		var param = new Object();
		param.region = jQuery('#region').val();
		param.property_kind = jQuery('#property_kind').val();
		param.property_type = jQuery('#property_type').val();
		param.bedroom = jQuery('#bedroom').val();
		param.bathroom = jQuery('#bathroom').val();
		param.minprice = jQuery('#minprice').val();
		param.maxprice = jQuery('#maxprice').val();
		var _url = url;
		for (var i in param) {
			_url += '&' + i + '=' + escape(param[i]);
		}
		window.open(_url,'_new','toolbar=1,location=1,menubar=1,scrollbars=1,directories=1,status=1,resizable=1');
	}
	
{/literal}
</script>
<div class="quicksearch-box quicksearch-box-fb" style="width:140px">
    <div class="quicksearch-title">SEARCH</div>
    <div class="form-list">
        <form name="frmSearch" id="frmSearch" method="post" action="/?module=property& action=search" onsubmit="return false;">
            <ul style="list-style: none;">
                <li class="field">
                    <label>ID/Suburb/Postcode</label>
                    <div>
                        <input type="text" name="search[region]" id="region" value="{$form_data.region}" class="disable-auto-complete" onclick="search_overlay.getData(this)" onkeyup="search_overlay.moveByKey(event)" style="width:135px"/>
                        <div id="search_overlay" class="search_overlay quick_search_overlay_b" style="margin-top:-425px;display:none;"></div>
                    </div>
                </li>
                <li class="field">
                    <label>Property Kind</label>
                    <div>
                        <select name="search[property_kind]" id="property_kind" style="width:100%" onchange="pro.getKind('/modules/property/action.php?action=get_property_type', this, 'property_type'), pro.onChangeKind(this, new Array(), new Array('#p_kind2_1','#p_kind2_2'))">
                        {html_options options = $search_data.kinds selected = $form_data.property_kind}
                        </select>
                    </div>
                </li>
                <li class="field">    
                    <label>Property Type</label>
                    <div>
                        <select name="search[property_type]" id="property_type" style="width:100%">
                        {html_options options = $search_data.property_type selected = $form_data.property_type}
                        </select>
                    </div>
                </li>
                <li class="field" id="p_kind2_1">
                    <label>Bedrooms</label>
                    <div class="input-box">
                        <select name="search[bedroom]" id="bedroom" style="width:100%">
                        {html_options options = $search_data.bedroom selected = $form_data.bedroom}
                        </select>
                    </div>
                </li>
                <li class="field" id="p_kind2_2">
                    <label>Bathrooms</label>
                    <div class="input-box">
                        <select name="search[bathroom]" id="bathroom" style="width:100%">
                        {html_options options = $search_data.bathroom selected = $form_data.bathroom}
                        </select>
                    </div>
                </li>
                
                <li class="field">
                    <label>Min.price</label>
                    <div class="input-box">
                        <select name="search[minprice]" id="minprice" style="width:100%">
                        {html_options options=$search_data.min_price selected =$form_data.minprice}
                        </select>
                    </div>
                </li>
                <li class="field">        
                    <label>Max.price</label>
                    <div class="input-box">
                        <select name="search[maxprice]" id="maxprice" style="width:100%">
                        {html_options options=$search_data.max_price selected =$form_data.maxprice}
                        </select>
                    </div>
                </li>
            </ul>
        </form>
    </div>

    <div class="actions">
        <button class="btn-red btn-red-search" onclick="fbSearch()"><span><span>Search</span></span></button>
    </div>
</div>
<br clear="all"/>
<script type="text/javascript">
	pro.onChangeKind('#property_kind',new Array('#p_kind1'), new Array('#p_kind2_1','#p_kind2_2'));
</script>


