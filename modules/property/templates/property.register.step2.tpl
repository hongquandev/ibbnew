{*<script type="text/javascript" src="/editor/jscripts/tinymce/tinymce.min.js"></script>*}
{*<script type="text/javascript" src="/editor/jscripts/tiny_mce/tiny_mce.js"></script>*}
<script type="text/javascript" src="/editor/jscripts/tiny_mce_v3.5.11/tiny_mce.js"></script>
{*<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>*}
{literal}
    <script type="text/javascript">
        function tinyMCEinit(){
            tinyMCE.init({
                mode : "specific_textareas",
                editor_selector : "content",
                theme:"advanced",
                height:"300",
                width:"590",
                //plugins : "ibrowser,autolink,lists,pagebreak,style,layer,table,save,advhr,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,searchreplace,print,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

                theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,link,unlink,sub,sup,|,hr,removeformat,,charmap",
                //theme_advanced_buttons2 : "",
                //theme_advanced_buttons3 : "",

                /*theme_advanced_toolbar_location : "top",
                theme_advanced_toolbar_align : "left",
                theme_advanced_statusbar_location : "bottom",
                theme_advanced_resizing_min_width: 590,
                theme_advanced_resizing : true,*/

                //content_css : "css/content.css",

                /*template_external_list_url : "lists/template_list.js",
                external_link_list_url : "lists/link_list.js",
                external_image_list_url : "lists/image_list.js",
                media_external_list_url : "lists/media_list.js",*/

                style_formats : [
                    {title : 'Bold text', inline : 'b'},
                    {title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
                    {title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
                    {title : 'Example 1', inline : 'span', classes : 'example1'},
                    {title : 'Example 2', inline : 'span', classes : 'example2'},
                    {title : 'Table styles'},
                    {title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
                ]

            });
        }
        var myEditor = null;
        function YUIEditor() {
            myEditor = new YAHOO.widget.SimpleEditor('description', {
                height: '300px',
                width: '590px',
                dompath: true
            });
            myEditor.render();
        }
        tinyMCEinit();

        /*tinymce.init({
            selector: ".content",
            menubar:false,
            statusbar: false,
            *//*plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste moxiemanager"
            ],*//*
            toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"

        });*/
    </script>
{/literal}

<script src="modules/property/templates/js/main.js" type= "text/javascript">  </script>
<script type="text/javascript" src="/modules/calendar/templates/js/calendar.js"></script>
<script type="text/javascript" src="/modules/calendar/templates/js/calendar.popup.js"></script>
<link rel="stylesheet" type="text/css" href="/modules/calendar/templates/style/calendar.css"/>
<script src="/modules/general/templates/calendar/js/jscal2.js"></script>
<script src="/modules/general/templates/calendar/js/lang/en.js"></script>
<link rel="stylesheet" type="text/css" href="/modules/general/templates/calendar/css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="/modules/general/templates/calendar/css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="/modules/general/templates/calendar/css/steel/steel.css" />
{literal}
    <script type="text/javascript">
        $(function() {
            $('#tooltip_0').tipsy({gravity: 'w',html:true});
            $('#tooltip_1').tipsy({gravity: 'w',html:true});
            $('#tooltip_0_0').tipsy({gravity: 'w',html:true});
            $('#tooltip_0_1').tipsy({gravity: 'w',html:true});
        });
    </script>
{/literal}
{literal}
    <script type="text/javascript">
        var search_overlay = new Search();
        search_overlay._frm = '#frmProperty';
        search_overlay._text_search = '#suburb';
        search_overlay._text_obj_1 = '#state';
        search_overlay._text_obj_2 = '#frmProperty #postcode';
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
                changeState(search_overlay._text_obj_1);
            };

            if (content_str.length > 0) {
                jQuery(search_overlay._overlay_container).html(content_str);
                jQuery(search_overlay._overlay_container).show();
                jQuery(search_overlay._overlay_container).width(jQuery(search_overlay._text_search).width());
            } else {
                jQuery(search_overlay._overlay_container).hide();
            }
            jQuery(search_overlay._text_search).removeClass('search_loading');
        };

        document.onclick = function() {search_overlay.closeOverlay()};
        function validRegion(suburb,state,postcode){
            pro.isSubmit('#frmProperty');
            var url='/modules/property/action.php?action=validate-property';
            var region = jQuery(suburb).val()+"+"+jQuery(state).val()+"+"+jQuery(postcode).val();
            var ok;
            jQuery.ajax({
                url:url,
                type: 'POST',
                data:'region='+region,
                success:function(result){
                    var info = jQuery.parseJSON(result);
                    if (info == ''){
                        ok = false;
                        Common.warningObject(suburb);
                        Common.warningObject(state);
                        Common.warningObject(postcode);
                    }
                    else{
                        ok = true;
                    }
                }
            });
            return ok;
        }
    </script>
{/literal}
<div class = "step-1-info step2-property yui-skin-sam">
<div class = "step-name">
    <h2>{localize translate="Property Details"}</h2>
</div>
<div class="step-detail col2-set">
<div class="col-1">
    <p style="text-align: justify">
        Please enter all the fields outlining the details of your property.
        The fields cover all the core components to ensure potential buyers can search and find your property.
    </p>
    <br/>
    <p style="text-align: justify">
        When entering your Price, please be aware that some states require a maximum of a 10% range +/- for advertised prices and consider your reserve price for the auction when setting this price.  This is the Advertised Price for your property, and will appear on your property page.
    </p>
    <br/>
    <p style="text-align: justify">
        The Property description is an important opportunity for you to outline and highlight the benefits, features and character of your property.  Use the description to communicate what potential buyers will like, are looking for and make sure to remember to promote those special things, including the street, suburb and local facilities.
    </p>
</div>
<div class="col-2 bg-f7f7f7">
{if strlen($message)>0}
    <div class="message-box all-step-message-box" id="message">{$message}</div>
{/if}
<div class="message-box all-step-message-box" id="message_content" style="display: none;"></div>
<form name="frmProperty" id="frmProperty" method="post" action="{$form_action}" onsubmit="return pro.isSubmit('#frmProperty')">
<div class="col22-set">
<div class="col-11">
    <ul class="form-list form-property">
        <li class="wide">
            <label>
                <strong id="notify_auction_sale">{localize translate="Auction Type"}<span >*</span></strong>
            </label>
            <div class="input-box">
                <select {if is_array($disableFields) and in_array('auction_sale',$disableFields)}disabled="disabled"{/if} name="fields[auction_sale]" id="auction_sale" class="input-select validate-number-gtzero" {if $isBlock}disabled="disabled"{else}onchange="cmbAuction(this,'{$form_data.auction_sale}','{$id}','{$is_paid}')"{/if} >
                    {html_options options = $auction_sales selected = $form_data.auction_sale}
                </select>
            </div>
        </li>
        {* {if $authentic.type != 'agent'}*}
        {*<li class="wide" id="package_content">
            {$package_tpl}
        </li>
        {*{/if}*}

        <li class="wide">
            <label>
                <strong id="notify_type">{localize translate="Property Kind"} <span >*</span></strong>
            </label>
            <div class="input-box">
                <select {if is_array($disableFields) and in_array('kind',$disableFields)}disabled="disabled"{/if} name="fields[kind]" id="kind" class="input-select validate-number-gtzero" onchange="pro.getKind('/modules/property/action.php?action=get_property_type', this, 'type'), pro.onChangeKind(this, new Array(), new Array('#p_kind2'))">
                    {html_options options = $property_kinds selected = $form_data.kind}
                </select>
            </div>
        </li>


        <li class="wide">
            <label>
                <strong id="notify_type">{localize translate="Property Type"} <span >*</span></strong>
            </label>
            <div class="input-box">
                <select {if is_array($disableFields) and in_array('type',$disableFields)}disabled="disabled"{/if} name="fields[type]" id="type" class="input-select validate-number-gtzero">
                    {html_options options = $property_types selected = $form_data.type}
                </select>
            </div>
        </li>
        <li class="wide">
            <label>
                <strong id="notify_address">{localize translate="Address"} <span >*</span></strong>
            </label>
            <div class="input-box">
                <input {if is_array($disableFields) and in_array('address',$disableFields)}disabled="disabled"{/if} type="text" name="fields[address]" id="address" value="{$form_data.address}" class="input-text validate-require" />
            </div>
        </li>

        <li class="fields">
            <div class="field" id="field-step2-respeb">
                <label>
                    <strong id="notify_suburb">{localize translate="Suburb"} <span >*</span></strong>
                </label>
                <div class="input-box">
                    <input {if is_array($disableFields) and in_array('suburb',$disableFields)}disabled="disabled"{/if} type="text" name="fields[suburb]" id="suburb" value="{$form_data.suburb}" class="input-text validate-require validate-letter disable-auto-complete" onclick="search_overlay.getData(this)" onkeyup="search_overlay.moveByKey(event)" autocomplete="off"/>
                    <div class=""> <!-- class = step2-suburb -->
                        <ul style="display: none;" id="search_overlay" class="search_overlay step2-suburb-so"></ul>
                    </div>
                </div>
            </div>
            <div class="field">
                <label>
                    <strong id="notify_postcode">{localize translate="Post code"} <span >*</span></strong>
                </label>
                <div class="input-box">
                    <input {if is_array($disableFields) and in_array('postcode',$disableFields)}disabled="disabled"{/if} type="text" name="fields[postcode]" id="postcode" value="{$form_data.postcode}" class="input-text validate-postcode disable-auto-complete" onkeyup="Common.validRegion('/modules/property/action.php?action=validate-property','#suburb','#state','#postcode','#frmProperty')"/>
                </div>
            </div>
            <div class="clearthis">
            </div>
        </li>

        <li class="fields">
            <div class="field" id="field-step2-respeb">
                <label>
                    <strong id="notify_state">{localize translate="State"} <span >*</span></strong>
                </label>
                {*                                <div class="input-box">*}
                <select {if is_array($disableFields) and in_array('state',$disableFields)}disabled="disabled"{/if} name="fields[state]" id="state" class="input-select validate-number-gtzero" onchange="Common.validRegion('/modules/property/action.php?action=validate-property','#suburb','#state','#postcode','#frmProperty')">
                    {html_options options = $states selected = $form_data.state}
                </select>
                {*                                </div>*}
            </div>
            <div class="field">
                <label>
                    <strong id="notify_country">{localize translate="Country"} <span >*</span></strong>
                </label>
                <div class="input-box" style="margin-top: 0px;">
                    <select {if is_array($disableFields) and in_array('country',$disableFields)}disabled="disabled"{/if} name="fields[country]" id="country" class="input-select validate-number-gtzero" onchange="Common.changeCountry('/modules/general/action.php?action=get_states',this,'state')">
                        {html_options options = $countries selected = $form_data.country}
                    </select>
                </div>
            </div>
            <div class="clearthis">
            </div>
        </li>

        <li class="fields" id="p_kind1">
            <div class="field">
                <label>
                    <strong id="notify_parking">{localize translate="Parking"}</strong>
                </label>
                <div class="input-box">
                    <select {if is_array($disableFields) and in_array('parking',$disableFields)}disabled="disabled"{/if} name="fields[parking]" id="parking" class="input-select" onchange="pro.onChangeKind(this, new Array('#p_parking2'), new Array())">
                        {html_options options = $parkings selected = $form_data.parking}
                    </select>
                </div>
            </div>
            <div class="clearthis"></div>
        </li>

        <li class="fields" id="p_parking2">
            <div class="field field2">
                <label>
                    <strong id="notify_car_space">{localize translate="Car spaces"} <span >*</span></strong>
                </label>
                <div class="input-box">
                    <select {if is_array($disableFields) and in_array('car_space',$disableFields)}disabled="disabled"{/if} name="fields[car_space]" id="car_space" class="input-select validate-number-gtzero">
                        {html_options options = $car_spaces selected = $form_data.car_space}
                    </select>
                </div>
            </div>
            <div class="field">
                <label>
                    <strong id="notify_car_port">{localize translate="Car parking"}<span >*</span></strong>
                </label>
                <div class="input-box">
                    <select {if is_array($disableFields) and in_array('car_port',$disableFields)}disabled="disabled"{/if} name="fields[car_port]" id="car_port" class="input-select ">
                        {html_options options = $car_ports selected = $form_data.car_port}
                    </select>
                </div>
            </div>
            <div class="clearthis"></div>
        </li>
        <li class="wide"><div style="font-size: 13px;font-weight: bold;text-align: center;color: #6f6666;background-color: #cbcbcb;padding: 5px;">Additional Property Notification Contact</div></li>
        <li class="wide" style="">
            <label>
                <strong>{localize translate="Email Address"}<span></span></strong>
            </label>
            <div class="input-box">
                <input type="text" name="fields[nd2_email_address]" value="{$form_data.nd2_email_address}" class="input-text"/>
            </div>
        </li>
        <li class="fields">
            <div class="field field2">
                <label>
                    <strong>{localize translate="Phone Number"}</strong>
                </label>
                <div class="input-box">
                    <input name="fields[nd2_phone_number]" value="{$form_data.nd2_phone_number}" type="text" class="input-text"/>
                </div>
            </div>
            <div class="clearthis">
            </div>
        </li>
    </ul>
</div>
<div class="col-22">
    <ul class="form-list form-property">
        {*Begin Price For Sale*}
        <li class="wide" id="price_sale" style="display: none;">
            <label>
                <strong>{localize translate="Price"} <span >*</span></strong>
                <a id="tooltip_0_0" href="javascript:void(0)" title=" <div style='text-align: justify;padding:0px 10px;0px;10px'>Please enter the price you are looking to advertise.  Please be aware that some states require a maximum of a 10% range +/- for advertised prices and consider your reserve price when setting the advertised price.  This will appear on your property advertising page.</div>">
                    <img style="margin-left: 20px;" src="/modules/general/templates/images/img_question.png"  />
                </a>
            </label>
            <div class="input-box" id="price_step2">
                <input type="text"  value="{$form_data.show_price}" class="input-text " onkeyup="this.value = format_price(this.value,'#price_sale_value','#price_step2')"/>
                <input type="hidden" name="fields[price]" id="price_sale_value" value="{$form_data.price}" class="input-text "/>
            </div>
        </li>

        {*Price For Auction*}
        <li class="wide" id="price_auction" style="display: none;">
            {*<label>
                <strong id="notify_price">{localize translate="Reserve Price"} <span >*</span></strong> - <span style="font-size: 13px;">You can change price of property Before it is becoming live  on {$form_data.date_to_lock_before_live} days.</span>
                <a id="tooltip_0" href="javascript:void(0)" title="<div style='text-align: justify;padding:0px 10px;0px;10px'>Please enter the price you are looking to advertise.  Please be aware that some states require a maximum of a 10% range +/- for advertised prices and consider your reserve price when setting the advertised price.  This will appear on your property advertising page.</div>">
                    <img style="margin-left: 20px;" src="/modules/general/templates/images/img_question.png" />
                </a>
            </label>*}
            <div class="input-box" id="pro_step2">
                {*<div class="col1-set" style="{if in_array($form_data.auction_sale_code,array('ebiddar','bid2stay'))}display:none{/if};margin-bottom: 15px">
                    <input type="text"  value="{$form_data.show_price}" class="input-text " {if $authentic.type != 'theblock'}{$readonly.price}{/if} onkeyup="this.value=format_price(this.value,'#price_auction_value','#pro_step2')"/>
                    <input type="hidden" name="fields[price]" id="price_auction_value" value="{$form_data.price}" class="input-text "/>
                </div>*}
                <div class="col2-set" {if !in_array($form_data.auction_sale_code,array('ebiddar','bid2stay'))}style="display:none"{/if}>
                    {*<input type="text" style="margin-bottom: 15px"  value="{$form_data.show_price}" class="input-text col-1" {if $authentic.type != 'theblock'}{$readonly.price}{/if} onkeyup="this.value=format_price(this.value,'#price_auction_value_1','#pro_step2')"/>
                    <input type="hidden" name="fields[price]" id="price_auction_value_1" value="{$form_data.price}" class="input-text "/>*}
                    <label>
                        <strong><span>Period of Rental Price</span><span>*</span></strong>
                    </label>
                    <select name="fields[period]" id="period" class="col-2">
                        {html_options options=$period_options selected=$form_data.period}
                    </select>
                </div>
            </div>
        </li>
        <li class="wide">
            {* List price (New) – non mandatory, this is the price of the property, if only a list price is entered then only the offer button is shown*}
            <div class="input-box" id="pro_listprice_step2">
                <div style="margin-bottom: 15px">
                    <label>
                        <strong id="notify_price">List Price</strong> - <span style="font-size: 13px;">This is the price of the property, if only a list price is entered then only the offer button is shown.</span>
                    </label>
                    <input type="text" value="{$form_data.show_price}" class="input-text" {if $authentic.type != 'theblock'}{$readonly.price}{/if} onkeyup="this.value=format_price(this.value,'#list_price_value','#pro_listprice_step2')"/>
                    <input type="hidden" name="fields[price]" id="list_price_value" value="{$form_data.price}" class="input-text "/>
                </div>
            </div>
        </li>
        <li class="wide">
            {* Buy Now/ Rent Now Price*}
            <div class="input-box" id="pro_buynow_step2">
                <div style="margin-bottom: 15px">
                    <label>
                        <strong id="notify_price">Rent Now/Buy Now Price</strong> - <span style="font-size: 13px;">This price used for buy now or rent now button and process.</span>
                    </label>
                    <input type="text" value="{$form_data.show_buynow_price}" class="input-text" {if $authentic.type != 'theblock'}{$readonly.price}{/if} onkeyup="this.value=format_price(this.value,'#buynow_price_value','#pro_buynow_step2')"/>
                    <input type="hidden" name="fields[buynow_price]" id="buynow_price_value" value="{$form_data.buynow_price}" class="input-text "/>
                </div>
            </div>
        </li>
        <li class="wide">
            {* advertised price*}
            <div class="input-box" id="pro_advertised_price_step2">
                <div style="margin-bottom: 15px">
                    <label>
                        <strong id="notify_price">Advertised Price</strong>
                    </label>
                    <br/>
                    From: <input type="text" style="width: 100px" value="{$form_data.show_advertised_price_from}" class="input-text" onkeyup="this.value=format_price(this.value,'#advertised_price_from_value','#pro_advertised_price_step2')"/>
                    &nbsp; - &nbsp;
                    To: <input type="text" style="width: 100px" value="{$form_data.show_advertised_price_to}" class="input-text" onkeyup="this.value=format_price(this.value,'#advertised_price_to_value','#pro_advertised_price_step2')"/>
                    <input type="hidden" name="fields[advertised_price_from]" id="advertised_price_from_value" value="{$form_data.advertised_price_from}" class="input-text "/>
                    <input type="hidden" name="fields[advertised_price_to]" id="advertised_price_to_value" value="{$form_data.advertised_price_to}" class="input-text "/>
                    <br/>
                    <br/>
                    <label>
                        <strong id="notify_price">Advertised Price View</strong>
                    </label>
                    <br/>
                    <input id="price-view" name="fields[price_view]" type="text" value="{$form_data.price_view}" class="input-text" placeholder="POA, Price on request, ..." />
                </div>
            </div>
        </li>
        {*<li class="wide" id="price_poa_sale" style="display: none;">
            <input type="checkbox" value="1" name="fields[price_on_application]" id="poa" {if $form_data.price_on_application == 1}checked{/if} />
            <label>
                <strong>{localize translate="POA"}<span>*</span></strong>
                - <span style="font-size: 10px;">{localize translate=""}{localize translate="Price On Application"}</span>
                <a id="tooltip_0_1" href="javascript:void(0)" title=" <div style='text-align: justify;padding:0px 10px;0px;10px'>POA is a term often seen on price lists, classified advertisements and is commonly used with regard to real estate prices. It means the seller or selling agent must be contacted in order to obtain the price.</div>">
                    <img style="margin-left: 20px;" src="/modules/general/templates/images/img_question.png"  />
                </a>
            </label>
        </li>*}
        <li class="fields" id="p_kind2">
            <div class="field field2">
                <label>
                    <strong id="notify_bedroom">{localize translate="Bedrooms"} <span></span></strong>
                </label>
                <div class="input-box">
                    <select {if is_array($disableFields) and in_array('bedroom',$disableFields)}disabled="disabled"{/if} name="fields[bedroom]" id="bedroom" class="input-select">
                        {html_options options = $bedrooms selected = $form_data.bedroom}
                    </select>
                </div>
            </div>
            <div class="field">
                <label>
                    <strong id="notify_bathroom">{localize translate="Bathrooms"} <span ></span></strong>
                </label>
                <div class="input-box">
                    <select {if is_array($disableFields) and in_array('bathroom',$disableFields)}disabled="disabled"{/if} name="fields[bathroom]" id="bathroom" class="input-select">
                        {html_options options = $bathrooms selected = $form_data.bathroom}
                    </select>
                </div>
            </div>
            <div class="clearthis"></div>
        </li>

        <li class="fields">
            <div class="field field2">
                <label>
                    <strong id="notify_land_size">{localize translate="Land size"}</strong>
                </label>
                <div class="input-box">
                    {*<select name="fields[land_size]" id="land_size" class="input-select validate-number-gtzero">
                        {html_options options = $land_sizes selected = $form_data.land_size}*}
                    <input style="padding: 3.5px 0" {if is_array($disableFields) and in_array('land_size_number',$disableFields)}disabled="disabled"{/if} type="text" name="fields[land_size_number]" id="land_size_number" value="{$form_data.land_size_number}" class="input-text validate-number" />
                    {*</select>*}
                </div>
            </div>
            {*unit*}
            <div class="field">
                <label>
                    <strong id="notify_unit">{localize translate="Unit"} <span></span></strong>
                </label>
                <div class="input-box">
                    <select {if is_array($disableFields) and in_array('unit',$disableFields)}disabled="disabled"{/if} name="fields[unit]" id="unit" class="input-select validate-number-gtzero">
                        {html_options options = $unit selected = $form_data.unit}
                    </select>
                </div>
            </div>

            <div class="clearthis">
            </div>
        </li>
        {if $authentic.type == 'theblock'}
            <li class="wide">
                <label>
                    <strong id="notify_owner">{localize translate="Owner"} <span>*</span></strong>
                    {*- <span style="font-size: 10px;">your current price requirement, can change 5 days</span>*}
                </label>
                <div class="input-box" >
                    <input type="text"  name="fields[owner]" id="owner" value="{$form_data.owner}" class="input-text validate-require"/>
                </div>
            </li>
        {/if}
        <li class="wide">
            <label>
                <strong id="notify_frontage">{localize translate="Frontage"} (m)</strong>
            </label>
            <div class="input-box" >
                <input type="text"  name="fields[frontage]" id="frontage" value="{$form_data.frontage}" class="input-text"/>
            </div>
        </li>
        {*{if $package.can_blog == 1 || count($package) < 1}*}
        {if false}
            <li class="control control-r-ie" id ="auction_blog_li" >
                <label for="auction_blog">
                    {assign var = 'chked' value = ''}
                    {if $form_data.auction_blog == 1}
                        {assign var = 'chked' value = 'checked'}
                    {/if}
                    <input type="checkbox" name="fields[auction_blog]" id="auction_blog" {$chked}/>
                    <strong id = "blog">
                        {if $form_data.auction_sale != $auction_sale_ar.private_sale}
                            {localize translate="Auction Blog"}
                        {else}
                            {localize translate="Property Blog"}
                        {/if}
                    </strong>
                </label>

                <strong>
                    <a id="tooltip_1" href="javascript:void(0)" title=" Auction Blog">
                        <img style="margin-left: 20px;" src="/modules/general/templates/images/img_question.png"  />
                    </a>
                </strong>
            </li>
        {/if}


        <li class="control">
            <label for="open_for_inspection">
                {assign var = 'chked' value = ''}
                {if $form_data.open_for_inspection == 1}
                    {assign var = 'chked' value = 'checked'}
                {/if}
                <input type="checkbox" name="fields[open_for_inspection]" id="open_for_inspection" {$chked} onclick="o4i(this)"/>
                <strong>{localize translate="Open for inspection"}</strong>
            </label>
            <div id="btn_openforinspection" class="btn-red btn-calendar" style="{if $form_data.open_for_inspection == 0}display:none{/if}" onclick="openNoteTimeForm('{$form_data.property_id}');return false;">
                <span><span>{localize translate="Add inspection details"}</span></span>
            </div>
        </li>
        <li class="wide"><div style="font-size: 13px;font-weight: bold;text-align: center;color: #6f6666;background-color: #cbcbcb;padding: 5px;">Bank Account Details</div></li>
        <li class="wide" style="">
            <label>
                <strong>{localize translate="Account name"}<span></span></strong>
            </label>
            <div class="input-box">
                <input type="text" name="fields[bank_info][name]" value="{$form_data.bank_info.name}" class="input-text"/>
            </div>
        </li>
        <li class="fields">
            <div class="field field2">
                <label>
                    <strong>{localize translate="BSB"}</strong>
                </label>
                <div class="input-box">
                    <input name="fields[bank_info][bsb]" value="{$form_data.bank_info.bsb}" type="text" class="input-text"/>
                </div>
            </div>
            <div class="field">
                <label>
                    <strong>{localize translate="Account Number"}<span></span></strong>
                </label>
                <div class="input-box">
                    <input name="fields[bank_info][number]"  value="{$form_data.bank_info.number}" type="text" class="input-text"/>
                </div>
            </div>
            <div class="clearthis">
            </div>
        </li>
    </ul>
</div>
<div class="clearthis"></div>
</div>

<ul>
    <li style="list-style-type: none;">
        <div style="padding: 10px;">
            <div class="field">
                <label>
                    <strong id="notify_description">{localize translate="Property description"} <span >*</span></strong>
                </label>
                <div class="input-box">
                    <textarea name="fields[description]" id="description" class="input-select content" style="height:250px;width:588px;; padding: 0 3px;text-align: justify;">{$form_data.description}</textarea>
                </div>
            </div>
            <div class="clearthis">
            </div>
        </div>
    </li>
</ul>

<input type="hidden" name="track" id="track" value="0"/>
<input type="hidden" name="_package" value="{$form_data.package_id}"/>
<input type="hidden" name="is_submit2" id="is_submit2" value="0"/>
</form>
<div class="buttons-set">
    <button class="btn-red step-eight-btn-red" onclick="(document.location.href='/?module=property&action=register&step=1')"><span><span>Back</span></span></button>
    <button class="btn-red" onclick="pro.submit('#frmProperty',true);">
        <span><span>{localize translate="Save"}</span></span>
    </button>
    <button class="btn-red" onclick="pro.submit('#frmProperty');">
        <span><span>{localize translate="Next"}</span></span>
    </button>
</div>
</div>
<div class="clearthis">
</div>
</div>
</div>
<div id="error" style="display:none">{$error}</div>
{literal}
    <script type="text/javascript">
        function validEditor(){
            if(typeof tinyMCE.get('description') != 'undefined'){
                var editorContent = tinyMCE.get('description').getContent();
            }else
            {
                var editorContent = jQuery('#description').val();
            }
            if(editorContent == ''){
                jQuery('#message_content').show();
                jQuery('#message_content').html('Please input Property description.');
                return false;
            }else{
                jQuery('#message_content').hide();
                return true;
            }
        }
        function validPOA(){
            var obj;
            if ($('#price_auction_value').is(':disabled') && $('#price_auction_value_1').is(':disabled')){
                obj = '#price_sale_value';
            }else if ($('#price_auction_value_1').is(':disabled') && $('#price_auction_sale').is(':disabled')){
                obj = '#price_auction_value';
            }else{
                obj = '#price_auction_value_1';
            }
            if (($(obj).val() == 0 || $(obj).val() == '' )&& !$('#poa').is(":checked")){
                showMess('Please fill Price or POA (Price on application)');
                return false;
            }
            return true;
        }
        function validPrice(){
            var obj;
            if ($('#price_auction_value').is(':disabled')){
                obj = '#price_auction_value_1';
            }else{
                obj = '#price_auction_value';
            }
            if (($(obj).val() == 0 || $(obj).val() == '' )){
                showMess('Please fill Price');
                return false;
            }
            if (($('#buynow_price_auction_value').val() == 0 || $('#buynow_price_auction_value').val() == '' )){
                showMess('Please fill Rent Now/ Buy Now Price');
                return false;
            }
            return true;
        }
    </script>
{/literal}
<script type="text/javascript">
    var property_id = {$id};
    var type ='{$authentic.type}';
    var area = '{$restrict_area}';
    {literal}
    /*//var package_tpl = jQuery('#package_content').html();*/
    function o4i(obj) {
        if (jQuery(obj).attr('checked')) {
            jQuery('#btn_openforinspection').show();
        } else {
            jQuery('#btn_openforinspection').hide();
        }
    }

    function cmbAuction(obj,old_value,id,pay) {
        /*if(old_value != null)
        {
            if(jQuery(obj).val() != old_value && pay == 'complete'){
                var type = 'sale';
                if(jQuery(obj).val() != {/literal}{$auction_sale_ar.private_sale}{literal}){
                    type = 'live';
                }
                var url = '/?module=agent&action=view-property-rs-'+ type+'&page=reg-property&type='+jQuery(obj).val()+'&id='+id;
                show_confirm(url,'Do you want to change type of property ?',id,'step2',old_value);
            }
        }*/
        /*//loadPakage(obj);*/
        jQuery('#blog').html('Auction Blog');
        /*//clickPackage(jQuery('input[name=_package]').val());*/
        if (jQuery(obj).val() == {/literal}{$auction_sale_ar.private_sale}{literal}){
            _hide_el('#price_auction');
            _show_el('#price_sale');
            _show_el('#price_poa_sale');
        }else{
            _show_el('#price_auction');
            _hide_el('#price_sale');
            _hide_el('#price_poa_sale');
        }
        var title = jQuery(obj).val() == {/literal}{$auction_sale_ar.ebiddar}{literal} || jQuery(obj).val() == {/literal}{$auction_sale_ar.bid2stay}{literal} ?'RENT YOUR PROPERTY':'SELL YOUR PROPERTY';
        $('.auction-register h2').html(title);
        Cufon.replace('.auction-register h2');

        if (jQuery(obj).val() == {/literal}{$auction_sale_ar.ebiddar}{literal} || jQuery(obj).val() == {/literal}{$auction_sale_ar.bid2stay}{literal}){
            _show_el('#price_auction .col2-set');
            _hide_el('#price_auction .col1-set');
        }else if (jQuery(obj).val() != {/literal}{$auction_sale_ar.private_sale}{literal}){
            _show_el('#price_auction .col1-set');
            _hide_el('#price_auction .col2-set');
        }

        pro.flushCallback();
        if (!$('#poa').is(':disabled')){
            pro.addCallbackFnc('valid', function() {return validPOA();});
        }else{
            pro.addCallbackFnc('valid', function() {return validPrice();});
        }
        pro.addCallbackFnc('valid', function() {return validEditor();});
    }
    cmbAuction(jQuery('#auction_sale'));

    function show_el(id,tag)
    {
        jQuery('#' + id).show();
        jQuery(tag,'#' + id).each(function(){
            jQuery(this).removeAttr('disabled');
        });
    }
    function hide_el(id,tag)
    {
        jQuery('#' + id).hide();
        jQuery(tag,'#' + id).each(function(){
            jQuery(this).attr('disabled','disabled');
        });
    }

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
        });
    }
    /*function clickPackage(obj) {
        *//*
         var val = jQuery(obj).val();
         if (val == 5) {
         jQuery('#auction_blog_li').show();
         } else {
         jQuery('#auction_blog_li').hide();
         }
         *//*
        if (type != 'agent'){
            var val = jQuery.type(obj) === "object"?jQuery(obj).val():obj;
            $.post('/modules/property/action.php?action=get-package',{package:val,field:'can_blog'},function(data){
                var result = jQuery.parseJSON(data);
                if (result == 0 || result.error){
                    jQuery('#auction_blog_li').hide();
                }else{
                    jQuery('#auction_blog_li').show();

                }
            });
        }
    }*/
    /*function listenerPackage() {
        jQuery('input[id^=package_id]').each(function(){
            if (jQuery(this).attr('checked')) {
                clickPackage(this);
            }
        });
    }*/
    //listenerPackage();
    /*function checkPackage() {
        var auction_type = jQuery('#auction_sale').val();
        if (auction_type == {/literal}{$auction_sale_ar.private_sale}{literal}) return true;

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
    }*/

    jQuery(document).ready(function(){
        $('#state').bind('change',function(){
            changeState(this);
        });
    });
    function changeState(obj){
        var arr = area.split(',');
        if($.inArray($(obj).val(),arr) > -1 && type != 'agent'){
            showMess($('#error').html());
            $(obj).val(0);
            $('#suburb').val('');
            $('#postcode').val('');
        }
    }

    /*function loadPakage(obj){
        $.post('/modules/property/action.php?action=getPackage',{type:jQuery(obj).val(),property_id:{/literal}{$form_data.property_id}{literal}},function(data){
            var result = jQuery.parseJSON(data);
            jQuery('#package_content').html(result);
            pro.addCallbackFnc('valid',function(){return checkPackage();});
        });
    }*/
    pro.is_submit = 'is_submit2';
    /*//pro.addCallbackFnc('valid',function(){return checkPackage();});*/
    jQuery('select#kind').change();
    pro.onChangeKind('#kind',new Array(), new Array('#p_kind2'));
    pro.onChangeKind('#parking', new Array('#p_parking2'),new Array());
    {/literal}
</script>
