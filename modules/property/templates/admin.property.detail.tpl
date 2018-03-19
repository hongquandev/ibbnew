<script type="text/javascript" src="/modules/calendar/templates/js/calendar.js"></script>
<script type="text/javascript" src="/modules/calendar/templates/js/calendar.popup.js"></script>
<link rel="stylesheet" type="text/css" href="/modules/calendar/templates/style/calendar.css"/>
{literal}
<script type="text/javascript" src="../editor/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
    tinyMCE.init({
        mode : "specific_textareas",
        editor_selector : "content",
        theme:"advanced",
        height:"300",
        width:"640",
        plugins : "ibrowser,autolink,lists,pagebreak,style,layer,table,save,advhr,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,searchreplace,print,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,link,unlink,sub,sup,|,hr,removeformat,,charmap",
        theme_advanced_buttons2 : "",
        theme_advanced_buttons3 : "",

        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing_min_width: 640,
        /*theme_advanced_source_editor_width:500,*/
        theme_advanced_resizing : true,

        content_css : "css/content.css",

        template_external_list_url : "lists/template_list.js",
        external_link_list_url : "lists/link_list.js",
        external_image_list_url : "lists/image_list.js",
        media_external_list_url : "lists/media_list.js",

        style_formats : [
            {title : 'Bold text', inline : 'b'},
            {title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
            {title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
            {title : 'Example 1', inline : 'span', classes : 'example1'},
            {title : 'Example 2', inline : 'span', classes : 'example2'},
            {title : 'Table styles'},
            {title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
        ],
        template_replace_values : {
            username : "Some User",
            staffid : "991234"
        }
    });
</script>
{/literal}
<script type="text/javascript">
{literal}

function o4i(obj) {
	if (jQuery(obj).attr('checked')) {
		jQuery('#btn_openforinspection').show();
	} else {
		jQuery('#btn_openforinspection').hide();
	}
}
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
			 jQuery(search_overlay._text_search).removeClass('search_loading');
        }

        search_overlay._getValue = function(data){
             var info = jQuery.parseJSON(data);
             jQuery(search_overlay._text_obj_1).val(info[0]);
             changeState(search_overlay._text_obj_1);
        }

        if (content_str.length > 0) {
            jQuery(search_overlay._overlay_container).html(content_str);
            jQuery(search_overlay._overlay_container).show();
            jQuery(search_overlay._overlay_container).width(jQuery(search_overlay._text_search).width());
        } else {
            jQuery(search_overlay._overlay_container).hide();
        }
    }

    var sug_agent = new Search();
        sug_agent._frm = '#frmProperty';
        sug_agent._text_search = '#agent_name';
        sug_agent._text_obj_1 = '#agent_id';
        sug_agent._overlay_container = '#sug_agent';
        sug_agent._url_suff = '&type=agent';
        sug_agent._name_id = 'item_';
        sug_agent._location = '?module=property&action=edit&property_id={/literal}{$form_data.property_id}{literal}&agent_id=[1]&token=';

        sug_agent._success = function(data) {
            var info = jQuery.parseJSON(data);
            var content_str = "";
            var id = 0;
            if (info.length > 0) {
                sug_agent._total = info.length;
                for (var i = 0; i < info.length; i++) {
                    var id = 'item_' + i;
                    if (info[i]['status'] == 1){
                        content_str +="<li onclick='sug_agent.set2SearchText_agent(this,"+info[i]['agent_id']+","+info[i]['status']+")' id="+id+" class="+info[i]['agent_id']+">"+info[i]['full_name']+"<span>"+info[i]['email_address']+"</span></li>";
                    }else{
                        content_str +="<li class='li-inactive "+info[i]['agent_id']+"' onclick='sug_agent.set2SearchText_agent(this,"+info[i]['agent_id']+","+info[i]['status']+")'>"+info[i]['full_name']+"<span>"+info[i]['email_address']+"</span></li>";
                    }
                    sug_agent._item.push(id);
             }
			 jQuery(sug_agent._text_search).removeClass('search_loading');
        }

        if (content_str.length > 0) {
            jQuery(sug_agent._overlay_container).html(content_str);
            jQuery(sug_agent._overlay_container).show();
            jQuery(sug_agent._overlay_container).width(jQuery(sug_agent._text_search).width());
        } else {
            jQuery(sug_agent._overlay_container).hide();
        }
    }

    document.onclick = function() {
        search_overlay.closeOverlay();
        sug_agent.closeOverlay();
    };

</script>

{/literal}

<div id=admin_property_detail>
<table width="100%" cellspacing="10">
	<tr>
    	<td width="19%">
        	<strong id="notify_agent_id"> Vendor/ Main Agent <span class="require">*</span></strong>
        </td>
        <td width="30%">
            <input type="text" name="fields[agent_name]" id="agent_name" value="{$form_data.agent_name}" onclick="sug_agent.getData(this)" onkeyup="sug_agent.moveByKey(event)" class="input-text validate-require disable-auto-complete" style="width:98%"/>
            <input type="hidden" name="fields[agent_id]" id="agent_id" value="{$form_data.agent_id}" />
	        <ul>
                <div id="sug_agent" class="search_overlay" style="display:none; position: absolute;"></div>
            </ul>
            {*<select name="fields[agent_id]" id="agent_id" class="input-select validate-number-gtzero" style="width:100%" onchange="A_change(this)">
                {html_options options = $agent_options selected = $form_data.agent_id}
            </select>*}
        </td>
        <td width="19%"></td>
        <td width="30%"></td>
    </tr>

    {if $type == 'theblock' || $form_data.owner != ''}
    <tr>
    	<td>
        	<strong id="notify_owner"> Owner <span class="require">*</span></strong>
        </td>
        <td>
            <input type="text" name="fields[owner]" value="{$form_data.owner}" class="input-text validate-require disable-auto-complete" style="width:98%"/>
        </td>
    </tr>
    {/if}

    {if $type == 'agent' || $form_data.agent_manager != ''}
        <tr>
            <td>
                <strong id="notify_owner"> Agent Manager</strong>
            </td>
            <td>
                <select name="fields[agent_manager]" id="agent_manager" class="input-select" style="width:100%">
                    {*{html_options options = $agent_manager_options selected = $form_data.agent_manager}*}
                    {foreach from=$agent_manager_options key = key item=row}
                        <option value="{$key}" {if $row.active == 0} disabled="disabled" {/if} {if $key == $form_data.agent_manager} selected="selected"{/if}>{$row.value}</option>
                    {/foreach}
                </select>
                {*<input type="text" name="fields[agent_manager]" value="{$form_data.agent_manager}" class="input-text disable-auto-complete" style="width:98%"/>*}
            </td>
        </tr>
    {/if}

	<tr>
    	<td>
        	<strong id="notify_auction_sale">Auction Type <span class="require">*</span></strong>
        </td>
        <td>
            <select name="fields[auction_sale]" id="auction_sale" class="input-select validate-number-gtzero" style="width:100%" {if $isBlock || $form_data.isBlock}disabled="disabled"{else}onchange="cmbAuction(this)"{/if}>
                {html_options options = $auction_sales selected = $form_data.auction_sale}
            </select>
        </td>
    </tr>

    {*{if $type != 'agent'}*}
    {*<tr id="package_content">
           {$package_tpl}
    </tr>*}
   {* {/if}*}

	<tr>
    	<td>
            <strong id="notify_type">Property Kind <span class="require">*</span></strong>
        </td>
        <td>
            <select name="fields[kind]" id="kind" class="input-select validate-number-gtzero" style="width:100%" onchange="pro.getKind('/modules/property/action.php?action=get_property_type', this, 'type'), pro.onChangeKind(this, new Array(), new Array('#p_kind2'))">
                {html_options options = $property_kinds selected = $form_data.kind}
            </select>
        </td>
    </tr>

    
	<tr>
    	<td>
            <strong id="notify_type">Property Type <span class="require">*</span></strong>
        </td>
        <td>
            <select name="fields[type]" id="type" class="input-select validate-number-gtzero" style="width:100%">
                {html_options options = $property_types selected = $form_data.type}
            </select>
        </td>
    </tr>

	<tr>
    	<td>
	        <strong id="notify_address">Address <span class="require">*</span></strong>
        </td>
        <td>
        	<input type="text" name="fields[address]" id="address" value="{$form_data.address}" class="input-text validate-require disable-auto-complete" style="width:98%"/>
        </td>

    </tr>  

	<tr>
    	 <td>
            <strong id="notify_suburb">Suburb <span class="require">*</span></strong>
        </td>
        <td>
	        <input type="text" name="fields[suburb]" id="suburb" value="{$form_data.suburb}" onclick="search_overlay.getData(this)" onkeyup="search_overlay.moveByKey(event)" class="input-text validate-require validate-letter disable-auto-complete" style="width:98%"/>
	        <ul>
                <div id="search_overlay" class="search_overlay" style="display:none; position: absolute;"></div>
            </ul>
        </td>
        <td align="right">
            <strong id="notify_postcode">Post code <span class="require">*</span></strong>
        </td>
        <td>
        	<input type="text" name="fields[postcode]" id="postcode" value="{$form_data.postcode}" class="input-text validate-postcode disable-auto-complete" style="width:98%" onkeyup="Common.validRegion('/modules/property/action.admin.php?action=validate-property','#suburb','#state','#postcode','#frmProperty')"/>
        </td>
    </tr>       

	<tr>
        <td>
            <strong id="notify_state">State <span class="require">*</span></strong>
        </td>
        <td>

            <select name="fields[state]" id="state" class="input-select validate-number-gtzero" onchange="Common.validRegion('/modules/property/action.admin.php?action=validate-property','#suburb','#state','#postcode','#frmProperty')" style="width:100%">
                {html_options options = $states selected = $form_data.state}
            </select>
        </td>
        <td align="right">
        	<strong id="notify_country">Country <span class="require">*</span></strong>
        </td>
        <td>
            <select name="fields[country]" id="country" class="input-select validate-number-gtzero" onchange="Common.changeCountry('/modules/general/action.php?action=get_states',this,'state')" style="width:100%">
                {html_options options = $countries selected = $form_data.country}
            </select>
        </td>
    </tr>
    
    <tr>
    	<td valign="top">
            <strong id="notify_price">List Price</strong> <br/> <span style="font-size: 10px;font-style: italic">This is the price of the property, if only a list price is entered then only the offer button is shown.</span>
        </td>
        <td>
            <div class="col1-set" style="display:none">
                <input type="text"  value="{$form_data.show_price}" class="input-text disable-auto-complete" onkeyup="this.value=format_price(this.value,'#price','#admin_property_detail')" style="width:100%" {if !$isBlock}{$readonly}{/if}/>
                <input type="hidden" name="fields[price]" id="price" value="{$form_data.price}" class="input-text disable-auto-complete" style="width:100%" {$readonly}/>
            </div>
            <div class="col2-set" style="display:none">
                <input type="text"  value="{$form_data.show_price}" class="input-text disable-auto-complete col-1" onkeyup="this.value=format_price(this.value,'#price','#admin_property_detail')"{if !$isBlock}{$readonly}{/if}/>
                <select name="fields[period]" id="period" class="input-select col-2">
                    {html_options options=$period_options selected=$form_data.period}
                </select>
                <input type="hidden" name="fields[price]" id="price" value="{$form_data.price}" class="input-text disable-auto-complete"{$readonly}/>
            </div>
        </td>
    </tr>
    <tr {* id="buynow_step2_tr" style="display: none"*} >
        <td valign="top">
            <strong id="notify_price">Rent Now/Buy Now Price</strong> <br/> <span style="font-size: 10px;font-style: italic">This price used for buy now or rent now button and process.</span>
        </td>
        <td>
            {* Buy Now Price*}
            <div class="input-box" id="pro_buynow_step2">
                <div style="{if in_array($form_data.auction_sale_code,array('ebiddar','bid2stay'))}display:none{/if};margin-bottom: 15px">
                    <input style="width: 100%" type="text"  value="{$form_data.show_buynow_price}" class="input-text" {if $authentic.type != 'theblock'}{$readonly.price}{/if} onkeyup="this.value=format_price(this.value,'#buynow_price_auction_value','#pro_buynow_step2')"/>
                    <input type="hidden" name="fields[buynow_price]" id="buynow_price_auction_value" value="{$form_data.buynow_price}" class="input-text "/>
                </div>
            </div>
        </td>
    </tr>
    <tr id="pro_advertised_price_step2">
        <td valign="top">
            <label>
                <strong id="notify_price">Advertised Price</strong>
            </label>
            <br/>
        </td>
        <td>
            From: <input type="text" style="width: 100px" value="{$form_data.show_advertised_price_from}" class="input-text" onkeyup="this.value=format_price(this.value,'#advertised_price_from_value','#pro_advertised_price_step2')"/>
            <br/>
            <br/>
            To&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <input type="text" style="width: 100px" value="{$form_data.show_advertised_price_to}" class="input-text" onkeyup="this.value=format_price(this.value,'#advertised_price_to_value','#pro_advertised_price_step2')"/>
            <input type="hidden" name="fields[advertised_price_from]" id="advertised_price_from_value" value="{$form_data.advertised_price_from}" class="input-text "/>
            <input type="hidden" name="fields[advertised_price_to]" id="advertised_price_to_value" value="{$form_data.advertised_price_to}" class="input-text "/>
        </td>
    </tr>

    <tr id="pro_advertised_price_view">
        <td valign="top">
            <label>
                <strong id="notify_price">Advertised Price View</strong>
            </label>
            <br/>
        </td>
        <td>
            <input id="price-view" value="{$form_data.price_view}" name="fields[price_view]" type="text" class="input-text" placeholder="POA, Price on request, ..." />
        </td>
    </tr>

    <tr id="price_poa" style="display: none;">
        <td valign="top">
            {*<strong>POA (Price on application) <span class="require">*</span></strong>*}
        </td>
        <td>
{*            <input type="text"  value="{$form_data.show_price_on_application}" class="input-text disable-auto-complete" onkeyup="this.value=format_price(this.value,'#price_on_application','#admin_property_detail')" style="width:100%" {$readonly}/>*}
{*            <input type="hidden" name="fields[price_on_application]" id="price_on_application" value="{$form_data.price_on_application}" class="input-text disable-auto-complete" style="width:100%" {$readonly}/>*}
              <input type="checkbox" value="1" name="fields[price_on_application]" id="price_on_application" {if $form_data.price_on_application ==1}checked{/if}>
              <label>POA (Price on application)</label>
        </td>
    </tr>

    <tr id="p_kind2">
    	<td>
        	<strong id="notify_bedroom">Bedrooms {*<span class="require">*</span>*}</strong>
        </td>
        <td>
            <select name="fields[bedroom]" id="bedroom" class="input-select " style="width:100%">
                {html_options options = $bedrooms selected = $form_data.bedroom}
            </select>
        </td>
		<td align="right">
        	<strong id="notify_bathroom">Bathrooms {*<span class="require">*</span>*}</strong>
        </td>
        <td>
            <select name="fields[bathroom]" id="bathroom" class="input-select" style="width:100%">
                {html_options options = $bathrooms selected = $form_data.bathroom}
            </select>
        </td>
    </tr> 
    
    <tr>
    	<td>
        	<strong id="notify_land_size_number">Land size</strong>
        </td>
        <td>
             <input type="text" name="fields[land_size_number]" id="land_size_number" value="{$form_data.land_size_number}" class="input-text validate-number disable-auto-complete" style="width:98%"/>
        </td>
        <td align="right">
        	<strong id="notify_unit">Unit <span class="require">*</span></strong>
        </td>
        <td>
            <select name="fields[unit]" id="unit" class="input-select validate-number-gtzero" style="width:100%">
                {html_options options = $unit selected = $form_data.unit}
            </select>
        </td>
    </tr>

    <tr>
        <td>
            <strong id="notify_frontage">Frontage (m)</strong>
        </td>
        <td>
            <input type="text" name="fields[frontage]" id="frontage" value="{$form_data.frontage}" class="input-text disable-auto-complete" style="width:98%"/>
        </td>
    </tr>

    <tr id="p_kind1">
    	<td>
        	<strong id="notify_parking">Parking</strong>
        </td>
        <td>
            <select name="fields[parking]" id="parking" class="input-select" style="width:100%" onchange="pro.onChangeKind(this, new Array('#p_parking2'), new Array())">
                {html_options options = $parkings selected = $form_data.parking}
            </select>
        </td>
		<td align="right"></td>
        <td></td>
    </tr> 
   
   <tr id="p_parking2">
        <td>
	        <strong id="notify_car_space">Car spaces {*<span class="require">*</span>*}</strong>
        </td>
        <td>
            <select name="fields[car_space]" id="car_space" class="input-select validate-number-gtzero" style="width:100%">
                {html_options options = $car_spaces selected = $form_data.car_space}
            </select>
        </td>

   		<td align="right">
        	<strong id="notify_car_port">Garage / Carport {*<span class="require">*</span>*}</strong>
        </td>
        <td>
            <select name="fields[car_port]" id="car_port" class="input-select validate-number-gtzero" style="width:100%">
                {html_options options = $car_ports selected = $form_data.car_port}
            </select>
        </td>
   </tr>
    
	
    <tr>
    	<td valign="top">
        	<strong id="notify_description">Description <span class="require">*</span></strong>
        </td>
        <td colspan=3>
        	<textarea name="fields[description]" id="description" class="input-select content" style="width:100%;height:150px">{$form_data.description}</textarea>
        </td>
    </tr>

	{if $form_data.stop_bid == 1 and $is_auction == 1}
    <tr>
    	<td valign="top">
        	<strong id="notify_restart">Restart bid</strong>
        </td>
        <td colspan=3>
            <input type="text" name="fields[restart_bid]" id="restart_bid" value="" class="input-text disable-auto-complete" style="width:98%"/> seconds
        </td>
    </tr>
	{/if}

	{if $property_id > 0}
    <tr>
    	<td valign="top">
        	<strong id="">Pay status</strong>
        </td>
        <td colspan=3>{$form_data.pay_status}</td>
    </tr>
	{/if}

   <tr>
   		<td>
        	
        </td>
        <td colspan=3>
           <div style="margin-top:5px">
            	<div style="float:left;width:30%;" title="It was actived by admin">
                    <label for="focus">
                        {assign var = 'chked' value = ''}
                        {if $form_data.focus==1}
                            {assign var = 'chked' value = 'checked'}
                        {/if}
                    
                        <input type="checkbox" name="fields[focus]" id="focus" {$chked}/>
                        <strong><u>Set focus</u></strong>
                    </label>
                    <br/>
                    <label for="set_jump">
                            {assign var = 'chked' value = ''}
                            {if $form_data.set_jump == 1}
                                {assign var = 'chked' value = 'checked'}
                            {/if}

                            <input type="checkbox" name="fields[set_jump]" id="set_jump" {$chked}/>
                            <strong>Set home page </strong>
                    </label>
                    
                </div>

                <div style="float:left;width:30%">
                    <label for="active">
                        {assign var = 'chked' value = ''}
                        {if $form_data.active == 1}
                            {assign var = 'chked' value = 'checked'}
                        {/if}

                        <input type="checkbox" name="fields[active]" id="active" {$chked}/>
                        <strong>Is active?</strong>
                    </label>
                    <br/>
                        {assign var = 'chked' value = ''}
                        {if $form_data.open_for_inspection == 1}
                            {assign var = 'chked' value = 'checked'}
                        {/if}
                        <input type="checkbox" name="fields[open_for_inspection]" id="open_for_inspection" {$chked} onclick="o4i(this)"/>
                        <strong><u>Open for inspection?</u></strong>
                    </label> 
                    
                    <div id="btn_openforinspection" class="btn-red btn-calendar2" style="padding-top:10px;{if $form_data.open_for_inspection == 0}display:none{/if}" onclick="openNoteTimeForm('{$form_data.property_id}');return false;">
                        <span><span>Add inspection details</span></span>
                    </div>                            
                     
                </div>
               {*<div style="float:left;width:30%">
                   <label id="l_auction_blog" for="auction_blog">
                       {assign var = 'chked' value = ''}
                       {if $form_data.auction_blog == 1}
                           {assign var = 'chked' value = 'checked'}
                       {/if}

                       <input type="checkbox" name="fields[auction_blog]" id="auction_blog" {$chked}/>
                       <strong id="blog">Auction blog?</strong>
                   </label>
                   <br/>


                   <br/>
               </div>*}
            </div>
         </td>
   </tr>


	<tr>
    	<td colspan="4" align="right">
        	<hr/>
            <input type="hidden" name="next" id="next" value="0"/>
            {*<input type="hidden" name="_package" value="{$form_data.package_id}"/>*}
			<input type="button" class="button" value="Save" onclick="pro.validAgent()"/>
            <input type="button" class="button" value="Save & Next" onclick="pro.validAgent(true)"/>
        </td>
    </tr>
    
</table>
</div>
<div id="error" style="display:none">{$error}</div>
<script type="text/javascript">

    var type ='{$type}';
    var area = '{$restrict_area}';
    var isBlock = '{$isBlock}'
    {literal}
    function validPOA() {
        var obj;
        if (($('#price').val() == 0 || $(obj).val() == '' ) && !$('#price_on_application').is(":checked")) {
            Ext.Msg.show({
                title:'Warning?'
                ,msg: 'Please fill Price or POA (Price on application)'
                ,icon:Ext.Msg.WARNING
                ,buttons:Ext.Msg.OK
            });
            return false;
        }
        return true;
    }

    function validEditor(){
        if(typeof tinyMCE.get('description') != 'undefined'){
            var editorContent = tinyMCE.get('description').getContent();
        }else{
            var editorContent = jQuery('#description').val();
        }
        if(editorContent == ''){
            Ext.Msg.show({
                title:'Warning?'
                ,msg: 'Please fill Property description'
                ,icon:Ext.Msg.WARNING
                ,buttons:Ext.Msg.OK
            });
            return false;
        }else{
            jQuery('#message_content').hide();
            return true;
        }
    }

    pro.flushCallback();
	pro.onChangeKind('#kind', new Array(), new Array('#p_kind2'));
	pro.onChangeKind('#parking', new Array('#p_parking2'), new Array());
    /*pro.addCallbackFnc('valid', function() {return validEditor();});*/
    pro.callback_func.push(function() {
        return validEditor();
    });
	function A_change(obj) {
		var agent_id = jQuery(obj).val();
		var token = jQuery('#token').val();
		//document.location = '?module=property&action=add&agent_id='+agent_id+'&token='+token;
        document.location = '?module=property&action=edit&agent_id='+agent_id+'&property_id={/literal}{$form_data.property_id}{literal}token='+token;
	}

    /*var package_tpl = jQuery('#package_content').html();*/
	function cmbAuction(obj) {
        pro.flushCallback();
		if (!parseInt(isBlock) && (type == 'agent' || type == 'vendor' || type == 'buyer')){
            if (jQuery(obj).val() != {/literal}{$auction_sale_ar.private_sale}{literal}) {
                jQuery('#blog').html('Auction Blog');
                //clickPackage(jQuery('input[name=_package]').val());
                jQuery('#price_poa').hide();
                if(type == 'agent' && jQuery(obj).val() == {/literal}{$auction_sale_ar.auction}{literal} ){
                    jQuery('#price_poa').show();
                    pro.callback_func.push(function() {
                        return validPOA();
                    });
                }
                if (jQuery(obj).val() == {/literal}{$auction_sale_ar.ebiddar}{literal} || jQuery(obj).val() == {/literal}{$auction_sale_ar.bid2stay}{literal}) {
                    _show_el('td .col2-set');
                    _hide_el('td .col1-set');
                    _hide_el('#buynow_step2_tr');
                }else{
                    _show_el('td .col1-set');
                    _show_el('#buynow_step2_tr');
                    _hide_el('td .col2-set');
                }
                //loadPakage(obj);
            } else {
                jQuery('#blog').html('Property Blog');
                //jQuery('#package_content').html('');
                jQuery('#price_poa').show();
                _show_el('td .col1-set');
                _hide_el('td .col2-set');
                pro.callback_func.push(function() {
                    return validPOA();
                 });
                //clickPackage(1);
            }
            /*listenerLeftMenu(jQuery(obj).val());*/
        }else if(parseInt(isBlock) > 0){
            jQuery('#blog').html('Auction Blog');
            //jQuery('#package_content').html(package_tpl);
            //clickPackage(jQuery('input[name=_package]').val());
            jQuery('#price_poa').show();
            pro.callback_func.push(function() {
                    return validPOA();
            });
        }

	}
    cmbAuction('#auction_sale');
	/*function clickPackage(obj) {
		var val = jQuery.type(obj) === "object"?jQuery(obj).val():obj;
        var token = jQuery('#token').val();
        $.post('/modules/property/action.admin.php?action=get-package&token='+token,{package:val,*//*auction:$('#auction_sale').val(),*//*field:'can_blog'},function(data){
                var result = jQuery.parseJSON(data);
                if (result == 0 ||  result.error){
                    jQuery('#l_auction_blog').hide();

                }else{
                    jQuery('#l_auction_blog').show();

                }
        });

	}*/

    function _show_el(obj){
        jQuery(obj).show();
        jQuery('input,select',obj).each(function(){
            jQuery(this).removeAttr('disabled');
        })
    }
    function _hide_el(obj){
        jQuery(obj).hide();
        jQuery('input,select',obj).each(function(){
            jQuery(this).attr('disabled','disable');
        })
    }
	/*function listenerPackage() {
		jQuery('input[id^=package_id]').each(function(){
			if (jQuery(this).attr('checked')) {
				clickPackage(this);
			}
		});
	}
    listenerPackage();*/

	/*function checkPackage() {
		var type = jQuery('#auction_sale').val();
		if (type == 10) return true;

		var ok = false;
		jQuery('input[id^=package_id]').each(function(){
			if (jQuery(this).attr('checked')) {
				ok = true;
			}
		});
		if (ok) {
			Common.warningObject('#notify_package',true);
			return true;
		} else {
			Common.warningObject('#notify_package',false);
			return false;
		}
	}
    if ($('#package_content').length > 0){
        pro.callback_func.push(function(){return checkPackage();});
    }*/

    function activeAgent(agent_id){
        var url = '/modules/agent/action.admin.php?action=active-agent&token='+$('#token').val();
        $.post(url,{agent_id:agent_id},function(data){
             var result = jQuery.parseJSON(data);
             if (result.success){
               /*alert( jQuery('input[name='+agent_id+']').val());*/
               jQuery('#'+agent_id).removeAttr("disabled");
               jQuery('#'+agent_id).parent().removeClass('x-item-disabled');
               jQuery('a[name='+agent_id+']').remove();
               //Ext.getCmp('rdAgent').items.get('280').value();
             }
        });
    }
    /*function loadPakage(obj){
        var token = jQuery('#token').val();
        $.post('/modules/property/action.admin.php?action=getPackage&token='+token,{type:jQuery(obj).val(),property_id:{/literal}{$form_data.property_id}{literal},agent:{/literal}{$form_data.agent_id}{literal}},function(data){
             var result = jQuery.parseJSON(data);
             jQuery('#package_content').html(result);
        });
    }*/
    jQuery(document).ready(function(){
        $('#state').bind('change',function(){
             changeState(this);
        });
    });
    function changeState(obj){
         var arr = area.split(',');
        if ($.inArray($(obj).val(), arr) > -1 && type != 'agent') {
            Ext.Msg.show({
                title:'Warning?'
                ,msg: $('#error').html()
                ,icon:Ext.Msg.WARNING
                ,buttons:Ext.Msg.OK
            });
        }
    }
{/literal}
</script>
{if $restrict_register}
    {literal}
    <script type="text/javascript">        
            jQuery(document).ready(function(){
                 Ext.Msg.show({
                    title:'Warning?'
                    ,msg: 'This account didn\'t payment for this month. So you are not add/edit property.'
                    ,icon:Ext.Msg.WARNING
                    ,buttons:Ext.Msg.OK
                    ,fn:function(){
                        document.location('?module=property&action=add&token='+{/literal}{$token}{literal});
                    }
                });
            });
    </script>
    {/literal}
{/if}

