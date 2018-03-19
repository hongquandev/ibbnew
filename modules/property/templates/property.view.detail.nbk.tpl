{if $item_number}
{literal}
    <script type="text/javascript">jQuery(document).ready(function () {term.showPopup('{/literal}{$item_number}{literal}');});</script>
{/literal}
{/if}
{literal}
    <style type="text/css">
        #property_detail {
            margin-top: 10px
        }
        .pdf-documents-download {
            margin-bottom: 20px;
        }
        .pdf-documents-download .btn-pdf-download {
            background: url("../../modules/general/templates/images/btn-pdfdocument-fix.jpg") repeat scroll 0 0 transparent;
            border: medium none;
            cursor: pointer;
            height: 30px;
            padding-left: 5px;
            text-align: left;
            width: 205px;
        }
        #ftrtitle {
            font-size: 11px;
        }
        .increment-detail-fix #step_option_txt {
            width: 90px;
        }
        #step_option_txt {
            width: 90px;
        }
    </style>
{/literal}
<script type="text/javascript" src="/modules/calendar/templates/js/calendar.popup.js"></script>
<script type="text/javascript" src="/modules/general/templates/js/calc.js"></script>
<script type="text/javascript" src="/modules/general/templates/js/propose-increment.js"></script>
<script type="text/javascript" src="/modules/general/templates/js/ialert.js"></script>
<script type="text/javascript" src="/modules/general/templates/js/ipad.js"></script>
<script type="text/javascript" src="/modules/general/templates/js/audio.js"></script>
<script type="text/javascript" languange="javascript">
    var media = '{$MEDIAURL}';
    {literal}
    function img(obj) {
        jQuery(obj).click();
    }
    function myReport(id) {
        var width = 700;
        var height = 600;
        var left = (screen.width - width) / 2;
        var top = (screen.height - height) / 2;
        var params = 'width=' + width + ', height=' + height;
        params += ', top=' + top + ', left=' + left;
        params += ', directories=no';
        params += ', location=no';
        params += ', menubar=no';
        params += ', resizable=no';
        params += ', scrollbars=yes';
        params += ', status=no';
        params += ', toolbar=no';
        /*
         newwin = window.open('','', params);

         var html = '<link rel="stylesheet" type="text/css" href="/modules/general/templates/style/detail-print.css"/><style>.property-desc{margin-top:0px !important;}.address{padding-left:0px !important;}</style>';

         html += '<body> <div class="wrapper-print">\
         <div class="logo-box" style="float: left;height:80px;padding:0px">\
         <a href="'+ ROOTURL +'"><img src="'+media+'/modules/general/templates/images/ibb-logo.png" alt="logo iBB" id="print_logo" style="height:80px"/></a>\
         </div>\
         <p style="float:right; margin-top:50px;">\
         <a href="javascript:void(0)" id="prt" onclick="return prints_();">\
         <img src="'+media+'/modules/general/templates/images/Printer-icon.png" style="border:none" /></a></p>\
         <div class="clearthis"></div><div class="col-main-print property-box-detail" id="print_content">'+ jQuery('#property-box-d').html() +'</div></div></body>';

         newwin.document.write('<scr'+'ipt type="text/javascript" src="/modules/general/templates/js/jquery.min.js" ></scr'+'ipt>');

         newwin.document.write(html);
         newwin.document.write('<scr'+'ipt >jQuery(".tw-face").remove();jQuery(".if_google_map").remove();jQuery(".col2").html(jQuery(".property-desc").html());jQuery(".bar-title").remove();jQuery(".col1 .property-desc").hide();jQuery(".price").hide();</scr'+'ipt>');
         */
        newwin = window.open(id, '_blank');
        //newwin = window.open(id, '_blank', params);
        if (window.focus) {
            newwin.focus()
        }
        return false;
    }
</script>
{/literal}

<div class="property-box property-box-detail pro-item-{$property_data.info.property_id}" id="property-box-d">
    <div class="bar-title">
        <h2>
            <a href="{php}echo isset($_SESSION['redirect_link']) ? $_SESSION['redirect_link'] : '#' ;{/php}"
               class="bar-title-backto">
                {localize translate="BACK TO"} {php} echo isset($_SESSION['redirect_link']) ? $_SESSION['property_list_title_bar'] : '' {/php}
            </a>
        </h2>
    </div>
    <div class="hightlight-top-item">
        <h2 class="hightlight-top-item-left f-left">
            {$property_data.info.address_full}
        </h2>
        <div class="hightlight-top-item-right f-right">
            <span class="price">
                <span id="price-{$property_data.info.property_id}">{$property_data.info.price}</span>
                {if in_array($property_data.info.pro_type_code,array('ebiddar','bid2stay'))}
                    <span class="period">{$property_data.info.period}</span>
                {/if}
            </span>
        </div>
    </div>
        <div class="property-detail">
        <script type="text/javascript">
            var ids = [];
            var pro = new Property();
            ids.push({$property_data.info.property_id});
        </script>
        {if isset($property_data.info) and is_array($property_data.info) and count($property_data.info) > 0 }
        <div class="detail-2col">
            <div class="pag-short">
                {if $property_data.info.prev != ''}
                    <div class="l-r-icons f-left">
                        <span class="l icons">{$property_data.info.prev}</span>
                    </div>
                {elseif $property_data.info.prev_link != ""}
                    <div class="l-r-icons f-left">
                        <span class="l icons">{$property_data.info.prev_link}</span>
                    </div>
                {/if}
                {if $property_data.info.next != ''}
                    <div class="l-r-icons f-right">
                        <span class="r icons">{$property_data.info.next}</span>
                    </div>
                {elseif $property_data.info.next_link != '' }
                    <div class="l-r-icons f-right">
                        <span class="r icons">{$property_data.info.next_link}</span>
                    </div>
                {/if}
                <br clear="all"/>
            </div>
            <div class="col1 f-left">
                {*Col 1 top content*}
                <div class="a-left-right">
                    <div class="a-left-title">
                        {$property_data.info.title}
                    </div>
                    <div class="a-right-visits">{localize translate="Visits"} : <span id="view-no"> {$property_data.info.views}</span></div>
                    <div class="clearthis"></div>
                    <div class="a-left-info">
                        <p class="propertyid">ID: {$property_data.info.property_id}</p>
                        <p class="detail-icons">
                            {*<span class="type">{$property_data.info.type_name}</span>*}
                            {if $property_data.info.kind != 1}
                                {if $property_data.info.bedroom_value > 0}
                                    <span class="bed icons" id="bed_ic1">{$property_data.info.bedroom_value}</span>
                                {/if}
                                {if $property_data.info.bathroom_value > 0 }
                                    <span class="bath icons" id="bed_ic2">{$property_data.info.bathroom_value}</span>
                                {/if}
                            {/if}
                            {if $property_data.info.parking == 1}
                                <span class="car icons" id="bed_ic3">{$property_data.info.carport_value}</span>
                            {/if}
                        </p>
                    </div>
                    <div class="a-right-bids">
                        {if $property_data.info.pro_type == 'auction'}
                            {localize translate="Bids"}:
                            <span id="bid-no-{$property_data.info.property_id}"> {$property_data.info.bids}</span>
                        {/if}
                    </div>
                    <div class="clearthis"></div>
                </div>

                {*Begin share twitter/facebook*}
                {*{if $isShow }
                    <div class="clearthis"></div>
                    <div class="tw-face">
                        <iframe allowtransparency="true" frameborder="0" scrolling="no"
                                src="//platform.twitter.com/widgets/tweet_button.html"
                                style="width:55px; height:20px;float:left;">
                        </iframe>
                        <div class="fb-like" data-href="{$property_data.link}" data-send="false" data-width="341" data-show-faces="false" data-font="arial" style="float:right;"></div>
                    </div>
                {/if}*}
                {*End*}
                {*BUTTON PANEL*}
                    <div class="col2-theme1">
                        <div class="detail-info-box-theme1 detail-{$property_data.info.pro_type}">
                        {if $property_data.info.pro_type == 'sale'}
                        {*EMAIL - PRINT BUTTON - REPORT*}
                            <div class="action-panel action-panel-sale" style="float: left">
                                <input type="button" style="width: 107px;height: 23px;" class="btn-add-to-wtachlist f-left" onClick="pro.addWatchlist('/modules/property/action.php/?action=add-watchlist&property_id={$property_data.info.property_id}')"/>
                                {if $property_data.info.pro_type == 'sale'}
                                    {if !$isAgent}
                                        {if !$isSold}
                                            {assign var = btn_offer_class value="btn-make-an-ofer"}
                                            <button id="btn-offer-{$property_data.info.property_id}"
                                                    class="btn-wht {$btn_offer_class} btn-make-an-ofer-f"
                                                    onclick="pro.openMakeAnOffer('#makeanoffer_{$property_data.info.property_id}','{$property_data.info.property_id}','{$agent_id}')">
                                            </button>
                                        {/if}
                                        <!-- END CHECK PARTNER -->
                                        {$property_data.mao}
                                    {/if}
                                {/if}
                                {if !$isShow}
                                    <input type="button" class="btn-print f-left" onclick="return myReport(ROOTURL +'?module=property&action=print-detail&id={$property_data.info.property_id}')" />
                                {else}
                                    <input type="button" class="btn-email f-left" onClick="showSendfriend('{$property_data.info.property_id}','{$agent_info.email}')" />
                                    {assign var = show_contact_fnc value = "showContact('`$agent_info.agent_id`','`$agent_info.name`','`$agent_info.email`','`$agent_info.telephone`','`$property_data.info.agent_id`','')"}
                                    {if !$isLogin}
                                        {assign var = show_contact_fnc value = "showLoginPopup();"}
                                    {/if}
                                    <input type="button" class="btn-print f-left" onclick="return myReport(ROOTURL +'?module=property&action=print-detail&id={$property_data.info.property_id}')" />
                                {/if}
                                {if $property_data.info.pro_type != 'sale' OR ($property_data.info.pro_type == 'sale' AND $isAgent) }
                                    {if $property_data.info.isBlock}
                                        <input type="button" class="btn-bid-report f-left"  onclick="showRegisterBid('{$property_data.info.property_id}','registerToBid_blockReport','Bid Report')" />
                                    {else}
                                        {assign var=report_title value="Bid Report"}
                                        {if $property_data.info.pro_type == 'sale'}
                                            {assign var=report_title value="Offer Report"}
                                        {/if}
                                        {if $property_data.info.pro_type == 'sale'}
                                            <input type="button" class="btn-offer-report f-left" onclick="showRegisterBid('{$property_data.info.property_id}','registerToBid_history','{$report_title}')"/>
                                        {else}
                                            <input type="button" class="btn-bid-report f-left" onclick="showRegisterBid('{$property_data.info.property_id}','registerToBid_history','{$report_title}')"/>
                                        {/if}
                                    {/if}
                                {/if}
                                {*contact-vendor*}
                                {assign var = show_contact_fnc value = "showContact('`$agent_info.agent_id`','`$agent_info.name`','`$agent_info.email`','`$agent_info.telephone`','`$property_data.info.agent_id`','')"}
                                {if !$isLogin}
                                    {assign var = show_contact_fnc value = "showLoginPopup();"}
                                {/if}
                                <input type="button" class="btn-contact-vendor f-left" onClick="{$show_contact_fnc}" />
                                {$property_data.info.btn_open_for_inspection}
                            </div>
                        {elseif $property_data.info.pro_type == 'forthcoming'} {*Forthcoming Property *}
                            <div class="auction-info-box" id="auc-{$property_data.info.property_id}">
                                <div class="auc-time">
                                    <p id="auc-price-{$property_data.info.property_id}">
                                        {if $isSold }{localize translate="Sold"} {else} {localize translate="Auction Starts"}  {/if}
                                    </p>
                                </div>
                                {if !$isSold }
                                    <div class="auc-bid">
                                        <p class="bid" id="auc-time-{$property_data.info.property_id}">
                                            {if $property_data.info.isBlock}
                                                -d:-:-:-
                                            {else}
                                                {$property_data.info.start_time}
                                            {/if}
                                        </p>
                                    </div>
                                {/if}
                                {*&& $property_data.info.pro_type_code == 'auction' *}
                                {if ($property_data.info.isBlock || ($property_data.info.ofAgent)) AND !$isSold }
                                    <script type="text/javascript">
                                        var bid_{$property_data.info.property_id} = new Bid();
                                        bid_{$property_data.info.property_id}.setTimeObj('auc-time-{$property_data.info.property_id}');
                                        {if $property_data.info.isBlock || $property_data.info.pro_type_code == 'auction'}
                                        var time_{$property_data.info.property_id} = {$property_data.info.remain_time};
                                        bid_{$property_data.info.property_id}.setTimeValue('{$property_data.info.remain_time}');
                                        bid_{$property_data.info.property_id}.startTimer({$property_data.info.property_id});
                                        {/if}
                                        bid_{$property_data.info.property_id}._options.property_id = {$property_data.info.property_id};
                                        bid_{$property_data.info.property_id}._options.theblock = true;
                                        bid_{$property_data.info.property_id}._options.transfer = false;
                                        bid_{$property_data.info.property_id}._options.transfer_template = 'detail';
                                        bid_{$property_data.info.property_id}._options.transfer_container = 'auc-{$property_data.info.property_id}';
                                    </script>
                                {/if}
                                {*REGISTER BID FOR THE BLOCK AND FORTHCOMING: NHUNG*}
                                <div class="clearthis"></div>
                                <div id="property_detail">
                                    {if !$isAgent and !$isSold AND  !($property_data.info.ofAgent AND $property_data.info.pro_type_code == 'auction')}
                                        {assign var = check_show_bid value = false }
                                        {if !$property_data.info.register_bid}
                                            {assign var = check_show_bid value = true }
                                            <div style="float:left">
                                                <input type="button" id="bid_button_{$property_data.info.property_id}" class="btn-bid-reg"
                                                       onclick="PaymentBid({$property_data.info.property_id})" value=""/>
                                            </div>
                                        {/if}
                                        {if !$property_data.info.isBlock}
                                            {assign var = btn_offer_class value="btn-make-an-ofer"}
                                            <div id="makeanoffer-popup" style="{if !$check_show_bid }float: left;{else}float:left;{/if}">
                                                <button id="btn-offer-{$property_data.info.property_id}" style="margin-right:5px !important;"
                                                        class="btn-wht {$btn_offer_class} btn-make-an-ofer-f"
                                                        onclick="pro.openMakeAnOffer('#makeanoffer_{$property_data.info.property_id}','{$property_data.info.property_id}','{$agent_id}')">
                                                </button>
                                                {$property_data.mao}
                                            </div>
                                        {/if}
                                    {/if}
                                    {*EMAIL - PRINT BUTTON - REPORT*}
                                    <div class="action-panel" style="float: left">
                                        <input type="button" style="width: 107px;height: 23px;" class="btn-add-to-wtachlist f-left" onClick="pro.addWatchlist('/modules/property/action.php/?action=add-watchlist&property_id={$property_data.info.property_id}')"/>
                                        {if $property_data.info.pro_type == 'sale'}
                                            {if !$isAgent}
                                                {if !$isSold}
                                                    {assign var = btn_offer_class value="btn-make-an-ofer"}
                                                    <button id="btn-offer-{$property_data.info.property_id}"
                                                            class="btn-wht {$btn_offer_class} btn-make-an-ofer-f"
                                                            onclick="pro.openMakeAnOffer('#makeanoffer_{$property_data.info.property_id}','{$property_data.info.property_id}','{$agent_id}')">
                                                    </button>
                                                {/if}
                                                <!-- END CHECK PARTNER -->
                                                {$property_data.mao}
                                            {/if}
                                        {/if}
                                        {if !$isShow}
                                            <input type="button" class="btn-print f-left" onclick="return myReport(ROOTURL +'?module=property&action=print-detail&id={$property_data.info.property_id}')" />
                                        {else}
                                            <input type="button" class="btn-email f-left" onClick="showSendfriend('{$property_data.info.property_id}','{$agent_info.email}')" />
                                            {assign var = show_contact_fnc value = "showContact('`$agent_info.agent_id`','`$agent_info.name`','`$agent_info.email`','`$agent_info.telephone`','`$property_data.info.agent_id`','')"}
                                            {if !$isLogin}
                                                {assign var = show_contact_fnc value = "showLoginPopup();"}
                                            {/if}
                                            <input type="button" class="btn-print f-left" onclick="return myReport(ROOTURL +'?module=property&action=print-detail&id={$property_data.info.property_id}')" />
                                        {/if}
                                        {if $property_data.info.pro_type != 'sale' OR ($property_data.info.pro_type == 'sale' AND $isAgent) }
                                            {if $property_data.info.isBlock}
                                                <input type="button" class="btn-bid-report f-left"  onclick="showRegisterBid('{$property_data.info.property_id}','registerToBid_blockReport','Bid Report')" />
                                            {else}
                                                {assign var=report_title value="Bid Report"}
                                                {if $property_data.info.pro_type == 'sale'}
                                                    {assign var=report_title value="Offer Report"}
                                                {/if}
                                                {if $property_data.info.pro_type == 'sale'}
                                                    <input type="button" class="btn-offer-report f-left" onclick="showRegisterBid('{$property_data.info.property_id}','registerToBid_history','{$report_title}')"/>
                                                {else}
                                                    <input type="button" class="btn-bid-report f-left" onclick="showRegisterBid('{$property_data.info.property_id}','registerToBid_history','{$report_title}')"/>
                                                {/if}
                                            {/if}
                                        {/if}
                                    </div>
                                    {*Property Auction - Forthcoming*}
                                    {if in_array($property_data.info.pro_type_code,array('ebidda30'))
                                    AND !($property_data.info.buynow_buyer_id > 0) AND !$isSold}
                                        <div class="auc-actions-extra f-left" style="clear: left">
                                            <input id="buynow-{$property_data.info.property_id}" type="button" class="btn-buynow f-left" onClick="pro.buynow('{$property_data.info.property_id}','{$property_data.info.buynow_price}')" />
                                        </div>
                                    {else}
                                        <div style="clear: left"></div>
                                    {/if}


                                    <input type="button" value="" class="btn-more-info f-left" onclick="showPVM()" href="javascript:void(0)"/>
                                    {*contact-vendor*}
                                    {assign var = show_contact_fnc value = "showContact('`$agent_info.agent_id`','`$agent_info.name`','`$agent_info.email`','`$agent_info.telephone`','`$property_data.info.agent_id`','')"}
                                    {if !$isLogin}
                                        {assign var = show_contact_fnc value = "showLoginPopup();"}
                                    {/if}
                                    <input type="button" class="btn-contact-vendor f-left" onClick="{$show_contact_fnc}" />
                                    {$property_data.info.btn_open_for_inspection}
                                </div>
                            </div>
                        {else}{*Auction Property*}
                        {*<div class="top-info" style="height: 335px;">*}
                        {*{if $property_data.info.stop_bid == 0 and $property_data.info.pay_status == 2 and $property_data.info.confirm_sold == 0}*}
                            <div class="auction-info-box" id="auc-{$property_data.info.property_id}">
                                <div class="bidding-frame">
                                    <div class="bidding-frame-info1 f-left">
                                        <div class="bidding-frame-info1-content">
                                            <div class="auc-time-1">
                                                {if $isSold }
                                                    {if in_array($property_data.info.pro_type_code,array('ebiddar','bid2stay'))}
                                                        <p>{localize translate="Leased"}</p>
                                                    {else}
                                                        <p>{localize translate="Sold"} </p>
                                                    {/if}
                                                {else}
                                                    {if $property_data.info.isBlock || ($property_data.info.ofAgent && $property_data.info.pro_type_code == 'auction')}
                                                        <p id="count-{$property_data.info.property_id}">
                                                            {$property_data.info.set_count}
                                                        </p>
                                                    {else}
                                                        {if (($property_data.info.pro_type == 'auction'
                                                        and (!($property_data.info.check_price)
                                                        or ($property_data.info.isLastBidVendor)
                                                        or (($property_data.info.ofAgent && $property_data.info.pro_type_code == 'auction') || $property_data.info.isBlock)
                                                        )
                                                        and $property_data.info.stop_bid == 1
                                                        ))
                                                        }
                                                            <p id="passedin-{$property_data.info.property_id}">
                                                                {localize translate="Passed In"}
                                                            </p>
                                                        {else}
                                                            <p class="label-auc-time">
                                                                {localize translate="Time Left"}:
                                                            </p>
                                                            <p id="auc-time-{$property_data.info.property_id}">
                                                                -d:-:-:-
                                                            </p>
                                                        {/if}
                                                    {/if}
                                                {/if}
                                            </div>
                                            <div class="auc-bidder">
                                                <p class="lasted" id="auc-bidder-{$property_data.info.property_id}">
                                                    {if $property_data.info.isLastBidVendor}
                                                        {localize translate="Vendor Bid"}
                                                    {else}
                                                        {if $property_data.info.stop_bid == 1 or $property_data.info.transition == true or $property_data.info.confirm_sold == 1}
                                                            {localize translate="Last Bidder"}: {$property_data.info.bidder}
                                                        {else}
                                                            {localize translate="Current Bidder"}: {$property_data.info.bidder}
                                                        {/if}
                                                    {/if}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bidding-frame-info2 f-right">
                                        <div class="bidding-frame-info2-content">
                                            <div class="auc-bid">
                                                <p class="bid" id="auc-price-{$property_data.info.property_id}">
                                                    <span class="bid-text">
                                                    {if $property_data.info.stop_bid == 1 or $property_data.info.transition == true or $property_data.info.confirm_sold == 1}
                                                        {assign var=temp value = 0}
                                                        {if $property_data.info.stop_bid == 1}
                                                            {if $property_data.info.bidder == '--'}
                                                                {localize translate="Start Price"}:
                                                                {assign var=temp value = 1}
                                                            {/if}
                                                        {/if}
                                                        {if !$temp}{localize translate="Last Bid"}:{/if}
                                                    {elseif $property_data.info.check_start == 'true'}
                                                        {localize translate="Start Price"}:
                                                    {else}
                                                        {localize translate="Current Bid"}:
                                                    {/if}
                                                    </span>
                                                    <br>
                                                    <span class="bid-num">
                                                    {$property_data.info.price}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {if $property_data.info.check_price}
                                    <script type="text/javascript">
                                        var timer_id_ = "{$property_data.info.count}";
                                        var id_ = {$property_data.info.property_id}
                                    </script>
                                {literal}
                                    <script type="text/javascript">
                                        if (typeof timer_id_ == 'string' && timer_id_ != '') {
                                            jQuery('#auc-time-' + id_).addClass('change').css('color', '#007700');
                                            jQuery('#count-' + id_).addClass('change').css('color', '#007700');
                                        }
                                    </script>
                                {/literal}
                                {/if}

                                <div class="clearthis"></div>
                                <div class="buttons-set">
                                <script type="text/javascript"> var agent_id = {$agent_id}; </script>
                                <script type="text/javascript">
                                    if ({$property_data.info.remain_time} >
                                    0 || {$property_data.info.isBlock} ||
                                    {$property_data.info.ofAgent} )
                                    ids.push({$property_data.info.property_id});

                                    var time_{$property_data.info.property_id} = {$property_data.info.remain_time};
                                    var timer_{$property_data.info.property_id} = '{$property_data.info.count}';
                                    var bid_{$property_data.info.property_id} = new Bid();
                                    bid_{$property_data.info.property_id}.setPriceObj('auc-price-{$property_data.info.property_id}');
                                    bid_{$property_data.info.property_id}.setContainerObj('auc-{$property_data.info.property_id}');
                                    bid_{$property_data.info.property_id}.setTimeObj('auc-time-{$property_data.info.property_id}');
                                    bid_{$property_data.info.property_id}.setBidderObj('auc-bidder-{$property_data.info.property_id}');
                                    bid_{$property_data.info.property_id}.setTimeValue('{$property_data.info.remain_time}');
                                    bid_{$property_data.info.property_id}.startTimer({$property_data.info.property_id});
                                    bid_{$property_data.info.property_id}._options.transfer = true;

                                    {if ($property_data.info.isBlock == 1 || ($property_data.info.ofAgent == 1 && $property_data.info.pro_type_code == 'auction')) && $property_data.info.confirm_sold == 0}
                                    bid_{$property_data.info.property_id}.setContainer('count-{$property_data.info.property_id}');
                                    bid_{$property_data.info.property_id}._options.theblock = true;
                                    var count_{$property_data.info.property_id} = new CountDown();
                                    count_{$property_data.info.property_id}.container = 'count-{$property_data.info.property_id}';
                                    count_{$property_data.info.property_id}.bid_button = 'bid_button_{$property_data.info.property_id}';
                                    count_{$property_data.info.property_id}.button = 'btn_count_{$property_data.info.property_id}';
                                    count_{$property_data.info.property_id}.property_id = '{$property_data.info.property_id}';
                                    {/if}
                                    console.log(bid_{$property_data.info.property_id});
                                    {literal}
                                    var confirm_nh = new Confirm_popup();
                                    /* BEGIN RESET CALLBACK FUNCTION & LISTENER AUTOBID*/
                                    if (jQuery('#frmAutoBid_' + ids[0])) {
                                        {/literal}
                                        bid_{$property_data.info.property_id}.flushCallbackFnc();
                                        /*BEGIN SET CALLBACK FOR GETBID, AUTO BID*/
                                        bid_{$property_data.info.property_id}.addCallbackFnc('getBid_before', function (obj) {literal}{
                                            if (typeof obj.out_bidder_id != 'undefined' && obj.out_bidder_id == agent_id) {
                                                {/literal}
                                                return pro.listenerStopAutoBid('#frmAutoBid_' + ids[0], ids[0], obj);
                                                {literal}
                                            }
                                        });
                                        {/literal}
                                        /*END*/
                                        /*BEGIN SET CALLBACK FOR GETBID, AUTO BID*/
                                        bid_{$property_data.info.property_id}.addCallbackFnc('getBid_after', function (obj) {literal}{
                                            if (obj.bidder_id != agent_id) {
                                                {/literal}
                                                /*return pro.listenerAutoBid('#frmAutoBid_'+ids[0],ids[0],bid_
                                                {$property_data.info.property_id});*/
                                                {literal}
                                            }
                                        });
                                        {/literal}
                                        /*END*/

                                        /*BEGIN SET CALLBACK FOR BID, will be received after bidder bid*/
                                        /*
                                         bid_
                                        {$property_data.info.property_id}.addCallbackFnc('bid_after',function(obj)
                                        {literal}{
                                         if (obj.bidder_id == agent_id) {
                                         jQuery('#frmAutoBid_'+ids[0]+' #is_autobid').val(0);
                                         jQuery('#reg_autobid_btn').html('Accept');
                                         pro.closeAutoBidForm('#autobid_'+ids[0]);
                                         showMess(obj.msg);
                                         }
                                         });
                                         */
                                        /*END*/
                                    }
                                    /* END*/
                                    {/literal}
                                </script>
                                <script type="text/javascript">
                                    var id_bid = {$property_data.info.property_id};
                                    var reserve_price = {$property_data.info.reprice};
                                    var stop_bid = {$property_data.info.stop_bid};
                                    var confirm_sold = {$property_data.info.confirm_sold};
                                    var isAgent = {if $isAgent}1{else}0{/if};
                                    var isRent = false;
                                    {if in_array($property_data.info.pro_type_code,array('ebiddar','bid2stay'))}
                                    isRent = true;
                                    {/if}
                                    var register_bid = {if $property_data.info.register_bid }1{else}0{/if};
                                    {literal}
                                    function updatePrice() {

                                        var price = jQuery('#auc-price-' + id_bid).html().replace('$', '');
                                        price = parseFloat(price.replace(new RegExp(/[^\d+]/g), ''));
                                        if (price > 0) {
                                            jQuery('#price-' + id_bid).html(formatCurrency(price));
                                        }
                                    }
                                    function updatePriceTime() {
                                        updatePrice();
                                        setInterval("updatePrice()", 1000);
                                    }
                                    /*Update Watermark and Bid Button color ;*/
                                    function update_watermark() {
                                        var Sold = jQuery('#auc-time-' + id_bid).html();
                                        var price = document.getElementById('auc-price-' + id_bid).innerHTML;
                                        var i = price.indexOf("$");
                                        price = price.substr(i + 1, price.length - i + 1);
                                        /*format price*/
                                        var j = 0;
                                        for (j; j <= price.length; j++) {
                                            price = price.replace(",", "");
                                        }
                                        price = parseInt(price);
                                        /*end*/
                                        if (confirm_sold == 1 || Sold == 'Sold') {
                                            if (isRent) {
                                                document.getElementById('mark').src = "../modules/general/templates/images/rent_detail.png";
                                                jQuery('#auc-time-' + id_bid).html('Leased');
                                            } else {
                                                document.getElementById('mark').src = "../modules/general/templates/images/sold_detail.png";
                                                jQuery('#auc-time-' + id_bid).html('Sold');
                                            }
                                            document.getElementById('mark').style.display = "block";
                                        }
                                        else {
                                            if (price >= reserve_price && stop_bid == 0 && reserve_price > 0) {
                                                document.getElementById('mark').src = "modules/general/templates/images/onthemarket_detail.png";
                                                document.getElementById('mark').style.display = "block";
                                                if ($('#bid_button').length > 0) {
                                                    if (isAgent) {
                                                        document.getElementById('bid_button').className = "btn-bid-vendor-green";
                                                        document.getElementById('bid_room_button').className = "btn-bid-green";
                                                    }
                                                    else {
                                                        if (register_bid == 1) {
                                                            document.getElementById('bid_button').className = "btn-bid-green";
                                                        }
                                                        else {
                                                            document.getElementById('bid_button').className = "btn-bid-green-reg";
                                                        }
                                                    }
                                                }
                                            }

                                        }
                                    }
                                    {/literal}
                                </script>
                                <div id="property_detail">
                                    <div class="property-detail-a" style="margin-bottom: 8px;">
                                        <input type="hidden" value="{$default_inc}" id="default_inc"/>
                                        {if $agent_info.id > 0 AND !$isSold  AND $property_data.info.stop_bid == 0 }
                                            <script type="text/javascript">
                                                {literal}
                                                var value_show = '';
                                                $(document).ready(function () {
                                                    jQuery('#step_option1').val(jQuery("#step_option").val());
                                                    jQuery("#step_option_txt").keyup(function () {
                                                                this.value = format_price(this.value, '#step_option1', '#property_detail');
                                                                value_show = this.value;
                                                                jQuery("#step_option").val(jQuery('#step_option1').val());
                                                            }
                                                    );
                                                    jQuery("#step_option").change(function () {
                                                                jQuery('#step_option1').val(jQuery("#step_option").val());
                                                            }
                                                    );
                                                    jQuery("#step_option_txt").focusout(function () {
                                                        if (value_show == '$0' || value_show == '') {
                                                            jQuery('#uniform-step_option span').html(jQuery('#default_inc').val());
                                                        }
                                                        else {
                                                            jQuery('#uniform-step_option span').html(value_show);
                                                        }
                                                    });
                                                    jQuery("#step_option_txt").focusin(function () {
                                                        this.value = format_price(this.value, '#step_option1', '#property_detail');
                                                    });
                                                });
                                            </script>
                                        {/literal}
                                        {if $property_data.info.completed}
                                        {if in_array($authentic.type,array('theblock','agent')) && $property_data.is_mine == true}
                                            <span style="float:left;padding-top: 4px;">Bid price: </span>
                                                <input class="input-text" type="text" name="step_option" id="step_option_txt" value=""
                                                style="width:101px;float:right;margin-right: 2px;"/>
                                            <script>
                                                bid_{$property_data.info.property_id}._options.mine = true;
                                            </script>
                                        {elseif $isAgent  OR(!$isAgent AND $is_paid AND $property_data.info.register_bid) }
                                            <span style="float:left">{localize translate="Increment"}: </span>
                                            <strong class="strong-increment-detail increment-detail-fix">
                                                <select name="step_option" id="step_option" class="input-select" style="width:100%">
                                                    {html_options options = $inc_options selected = $step_init}
                                                </select>
                                            </strong>
                                            <script type="text/javascript">
                                                {if $property_data.info.isBlock }
                                                        {literal}var dis_input = true;
                                                {/literal}
                                                {else}
                                                        {literal}var dis_input = false;
                                                {/literal}
                                                {/if}
                                                {literal}
                                                /*BEGIN SELECT PLUGIN*/
                                                var selectPlugin = new SelectPlugin({'targetId': 'step_option', 'money_step': 'step_option1', disable_input: dis_input});
                                                selectPlugin.listener();
                                                /*END*/
                                                {/literal}
                                            </script>
                                        {if $property_data.info.isBlock}
                                            {assign var="detail_info" value="min-height:95px !important"}
                                            <p style="height: 18px"></p>
                                            <div style="clear: both;background-color: LemonChiffon;">
                                           <span style="display: block;text-align: center;">
                                               {*{$property_data.info.minmaxInc}*}
                                           </span>
                                           <span id="MinMax_mess_{$property_data.info.property_id}"
                                                 style="display: block;padding: 0px 5px;text-align: center;">
                                               {$property_data.info.minmaxInc_mess}
                                               {*Your increment must be satisfy conditions of min and max increment*}
                                           </span>
                                            </div>
                                        {/if}
                                        {/if}
                                        {/if}
                                            <input type="hidden" name="step_option1" id="step_option1" value="{$step_init}"/>
                                        {*BEGIN SET CALLBACK FOR BID, will be called before processing bid*}
                                        {*{if $property_data.info.isBlock}
                                            <script type="text/javascript">
                                                bid_{$property_data.info.property_id}.addCallbackFnc('bid_before',function(obj){literal}{
                                                    return {money_step:jQuery('#step_option').val()}
                                                });
                                                {/literal}
                                            </script>
                                        {else}*}
                                            <script type="text/javascript">
                                                bid_{$property_data.info.property_id}.addCallbackFnc('bid_before', function (obj) {literal}{
                                                    return {money_step: jQuery('#step_option1').val()}
                                                });
                                                {/literal}
                                            </script>
                                        {*{/if}*}
                                        {*END*}
                                        {/if}
                                    </div>
                                    <div class="property-detail-b" style="position: relative; float: left">
                                        {if !($property_data.info.isBlock AND $property_data.info.stop_bid == 0) AND !$isAgent AND  !($property_data.info.ofAgent AND $property_data.info.stop_bid == 0 AND $isAuction)  AND !$isSold}
                                            <div style="float:left;margin-right:5px !important;">
                                                {if $property_data.info.check_price }
                                                    {assign var = btn_offer_class value="btn-make-an-ofer-green"}
                                                {else}
                                                    {assign var = btn_offer_class value="btn-make-an-ofer"}
                                                {/if}
                                                {*Disable Offer Button once the auction live*}
                                                {*<button id="btn-offer-{$property_data.info.property_id}"
                                                        style="margin-right:0px !important;margin-top: 0px;"
                                                        class="btn-wht {$btn_offer_class} f-left btn-make-an-ofer-f"
                                                        onclick="pro.openMakeAnOffer('#makeanoffer_{$property_data.info.property_id}','{$property_data.info.property_id}','{$agent_id}');{$fnc_strAT}">
                                                </button>*}
                                                <!-- END CHECK PARTNER -->
                                                {$property_data.mao}
                                            </div>
                                        {/if}
                                        {assign var = fnc_str value = "bid_`$property_data.info.property_id`.click()"}
                                        {assign var = bid_dis value ="display: none"}
                                        {if !$isSold AND $property_data.info.stop_bid == 0}
                                            {assign var = bid_dis value ="display: block"}
                                        {/if}
                                        {if !$isAgent}
                                            {assign var = bid_class value = 'btn-bid'}
                                            {if $property_data.info.register_bid != true}
                                                {assign var = bid_class value = "btn-bid-reg"}
                                            {/if}
                                            {if $property_data.info.check_price}
                                                {assign var = bid_class value = 'btn-bid-green'}
                                                {if $property_data.info.register_bid != true}
                                                    {assign var = bid_class value = "btn-bid-green-reg"}
                                                {/if}
                                            {/if}
                                        {else}
                                            {assign var = bid_class value = 'btn-bid-vendor'}
                                            {if $property_data.info.check_price}
                                                {assign var = bid_class value = 'btn-bid-vendor-green'}
                                            {/if}
                                            {assign var = bid_room_class value = 'btn-bid'}
                                            {if $property_data.info.check_price}
                                                {assign var = bid_room_class value = 'btn-bid-green'}
                                            {/if}
                                        {/if}
                                        <input id="bid_button_{$property_data.info.property_id}" type="button" class="{$bid_class}" onclick="{$fnc_str}"
                                               style="float: right; margin-left: 0px;margin-top: 0px;{$bid_dis}"/>

                                        {if ($property_data.info.isBlock || ($property_data.info.ofAgent && $isAuction)) && $property_data.info.pro_type == 'auction'  && $property_data.info.completed }
                                            {if in_array($authentic.type,array('theblock','agent')) && $property_data.is_mine == true && $property_data.info.confirm_sold == 0 && $property_data.info.stop_bid == 0}
                                                <div style="float:left;margin-right:0px !important;width: 79px;">
                                                    <button id="btn_count_{$property_data.info.property_id}" class="btn-wht btn-countdown"
                                                            onclick="count_{$property_data.info.property_id}.showPopup('agent-block')">
                                                        <!--<span><span>MANAGE BID</span></span>-->
                                                    </button>
                                                    {$property_data.countdown}
                                                </div>
                                            {else}
                                                {if !$property_data.info.no_more_bids AND $is_paid AND $property_data.info.register_bid AND $property_data.info.confirm_sold == 0 AND $property_data.info.stop_bid == 0}
                                                    {if !$property_data.info.ofAgent}
                                                        <div style="float:left;margin-right:0px !important;width: 79px;">
                                                            <button id="btn_no_{$property_data.info.property_id}" class="btn-wht btn-no-more-bid"
                                                                    onclick="bid_{$property_data.info.property_id}.pauseBid()"></button>
                                                        </div>
                                                    {else}
                                                        <div style="float:left;margin-right:0px !important;width: 110px;">
                                                            <button id="btn_no_{$property_data.info.property_id}" class="btn-wht btn-no-more-bid2"
                                                                    onclick="bid_{$property_data.info.property_id}.pauseBid()"></button>
                                                        </div>
                                                        <div class="clearthis"></div>
                                                    {/if}
                                                {/if}
                                                {if $is_paid AND $property_data.info.register_bid AND $property_data.info.confirm_sold == 0 AND $property_data.info.stop_bid == 0}
                                                    <div style="position: absolute;margin-right:0 !important;width: 79px;top:28px;z-index:9; *left: 0px;">
                                                        <button id="btn_count_{$property_data.info.property_id}" class="btn-wht btn-countdown"
                                                                onclick="count_{$property_data.info.property_id}.showPopup('bidder-user')">
                                                        </button>
                                                        {$property_data.countdown}
                                                    </div>
                                                {/if}
                                            {/if}
                                        {/if}
                                    </div>
                                    {if in_array($authentic.type,array('theblock','agent'))  && ($isAgent && $property_data.info.pro_type_code == 'auction')}
                                        <input id="bid_room_button" type="button" class="{$bid_room_class}"
                                               onclick="bid_{$property_data.info.property_id}.click(true)"
                                               style="float: left; margin-left: 0px;margin-top: 0px;{$bid_dis}"/>
                                        <div class="clearthis"></div>
                                    {/if}
                                    {*EMAIL - PRINT BUTTON - REPORT*}
                                    <div class="action-panel" style="float: left">
                                        <input type="button" style="width: 107px;height: 23px;" class="btn-add-to-wtachlist f-left {$bid_class}" onClick="pro.addWatchlist('/modules/property/action.php/?action=add-watchlist&property_id={$property_data.info.property_id}')"/>
                                        {if $property_data.info.pro_type == 'sale'}
                                            {if !$isAgent}
                                                {if !$isSold}
                                                    {assign var = btn_offer_class value="btn-make-an-ofer"}
                                                    <button id="btn-offer-{$property_data.info.property_id}"
                                                            class="btn-wht {$btn_offer_class} btn-make-an-ofer-f"
                                                            onclick="pro.openMakeAnOffer('#makeanoffer_{$property_data.info.property_id}','{$property_data.info.property_id}','{$agent_id}')">
                                                    </button>
                                                {/if}
                                                <!-- END CHECK PARTNER -->
                                                {$property_data.mao}
                                            {/if}
                                        {/if}
                                        {if !$isShow}
                                            <input type="button" class="btn-print f-left" onclick="return myReport(ROOTURL +'?module=property&action=print-detail&id={$property_data.info.property_id}')" />
                                        {else}
                                            <input type="button" class="btn-email f-left" onClick="showSendfriend('{$property_data.info.property_id}','{$agent_info.email}')" />
                                            {assign var = show_contact_fnc value = "showContact('`$agent_info.agent_id`','`$agent_info.name`','`$agent_info.email`','`$agent_info.telephone`','`$property_data.info.agent_id`','')"}
                                            {if !$isLogin}
                                                {assign var = show_contact_fnc value = "showLoginPopup();"}
                                            {/if}
                                            <input type="button" class="btn-print f-left" onclick="return myReport(ROOTURL +'?module=property&action=print-detail&id={$property_data.info.property_id}')" />
                                        {/if}
                                        {if $property_data.info.pro_type != 'sale' OR ($property_data.info.pro_type == 'sale' AND $isAgent) }
                                            {if $property_data.info.isBlock}
                                                <input type="button" class="btn-bid-report f-left"  onclick="showRegisterBid('{$property_data.info.property_id}','registerToBid_blockReport','Bid Report')" />
                                            {else}
                                                {assign var=report_title value="Bid Report"}
                                                {if $property_data.info.pro_type == 'sale'}
                                                    {assign var=report_title value="Offer Report"}
                                                {/if}
                                                {if $property_data.info.pro_type == 'sale'}
                                                    <input type="button" class="btn-offer-report f-left" onclick="showRegisterBid('{$property_data.info.property_id}','registerToBid_history','{$report_title}')"/>
                                                {else}
                                                    <input type="button" class="btn-bid-report f-left" onclick="showRegisterBid('{$property_data.info.property_id}','registerToBid_history','{$report_title}')"/>
                                                {/if}
                                            {/if}
                                        {/if}
                                        <input type="button" value="" class="btn-more-info f-left" onclick="showPVM()" href="javascript:void(0)"/>
                                        {*contact-vendor*}
                                        {assign var = show_contact_fnc value = "showContact('`$agent_info.agent_id`','`$agent_info.name`','`$agent_info.email`','`$agent_info.telephone`','`$property_data.info.agent_id`','')"}
                                        {if !$isLogin}
                                            {assign var = show_contact_fnc value = "showLoginPopup();"}
                                        {/if}
                                        <input type="button" class="btn-contact-vendor f-left" onClick="{$show_contact_fnc}" />
                                        {$property_data.info.btn_open_for_inspection}
                                    </div>

                                    <div class="auc-actions">
                                        {if $agent_id > 0 AND $isShow}
                                            {assign var = fnc_str1 value = "showBidHistory('`$property_data.info.property_id`')"}
                                        {*{assign var = fnc_str2 value = "pro.openAutoBidForm('#autobid_`$property_data.info.property_id`','`$property_data.info.property_id`')"}*}
                                            {assign var = fnc_str2 value = "pro.before_openAutoBidForm('#autobid_`$property_data.info.property_id`','`$property_data.info.property_id`')"}
                                            {assign var = fnc_strAT value = "pro.closeAutoBidForm('#autobid_`$property_data.info.property_id`')"}
                                            {if !$isSold AND !$isAgent and $property_data.info.stop_bid == 0 and !($property_data.info.isBlock || ($property_data.info.ofAgent && $property_data.info.pro_type_code == 'auction'))}
                                                <input onclick="{$fnc_str2};pro.closeMakeAnOffer('#makeanoffer_{$property_data.info.property_id}')"
                                                       class="btn-autobid" style="height: 25px;margin-left: 0;width: 110px;"/>
                                                {$property_data.abs_tpl}
                                            {/if}
                                        {/if}
                                        <!-- END CHECK PARTNER -->
                                        <script type="text/javascript">
                                            {literal}
                                            /*FOR THE FIRST TIME BIDDER SET AUTOBID SETTINGS (it will send one request to server)*/
                                            pro.addCallbackFnc('reg_auto_bid_before', function (obj) {
                                                if (obj.autobid) {
                                                    {/literal}
                                                    bid_{$property_data.info.property_id}.click();
                                                    {literal}
                                                }
                                            });
                                            {/literal}
                                        </script>
                                    </div>

                                    <!--<br clear="all"/>-->
                                </div>
                                <script type="text/javascript">
                                    {if $property_data.info.pro_type == 'auction' &&  $property_data.info.pay_status == 'complete'}
                                    updatePriceTime();
                                    /*setInterval("update_watermark()",1000);*/
                                    {/if}
                                    updateLastBidder();
                                </script>
                                </div>

                            </div>
                        {/if} {*END LIVE AUCTION*}
                        <script type="text/javascript">
                            updateLastBidder();
                        </script>
                        {*<div style="text-align: center; border-bottom-width: 0px; padding-bottom: 6px;padding-top: 18px; color: #CC8C04;clear: both;"
                             class="o4i-info">
                            <span class=""> Open for Inspection: {$property_data.info.o4i}</span>
                        </div>*}
                        <div class="clearthis"></div>
                        {*<div class="detail-info" style="{$detail_info}">
                            <ul>
                                {if $property_data.info.kind != 1}
                                    <li>
                                        {if $property_data.info.bedroom_value > 0 }
                                            <span class="detail-info-span-a">{$property_data.info.bedroom_value}
                                                Bedroom{if $property_data.info.bedroom_value > 1}s{/if}</span>
                                        {/if}
                                        {if $property_data.info.bathroom_value > 0}
                                            <span class="detail-info-span">{$property_data.info.bathroom_value}
                                                Bathroom{if $property_data.info.bathroom_value > 1}s{/if}</span>
                                        {/if}
                                    </li>
                                {/if}
                                {if $property_data.info.parking == 1}
                                    <li>
                                          <span class="detail-info-span-a">

                                              {if $property_data.info.carport_value_ == ''}
                                                  {$property_data.info.carport_value} Car Space(s)
                                              {else}
                                                  {$property_data.info.carport_value} Car Parking
                                              {/if}

                                          </span>
                                        {if  $property_data.info.land_size == 0}
                                            <span style="display: none;" class="detail-info-span">{$property_data.info.land_size}</span>
                                        {else}
                                            <span class="detail-info-span">{$property_data.info.land_size}</span>
                                        {/if}
                                    </li>
                                {elseif $property_data.info.land_size != ''}
                                    {if  $property_data.info.land_size == 0}
                                        <li style="display: none;">
                                            <span class="detail-info-span-a">Land size</span>
                                            <span class="detail-info-span">{$property_data.info.land_size}</span>
                                        </li>
                                    {else}
                                        <li>
                                            <span class="detail-info-span-a">Land size</span>
                                            <span class="detail-info-span">{$property_data.info.land_size}</span>
                                        </li>
                                    {/if}
                                {/if}
                                *}{*<li>
                                    Livability Rating
                                    <div class="f-right" id="frgreen1">
                                 {$property_data.info.livability_rating_mark}
                                    </div>
                                </li>*}{*
                                <div class="clearthis"></div>
                                {if !in_array($property_data.info.pro_type_code,array('ebiddar','bid2stay'))}
                                    <li>
                                        iBB Sustainability
                                        <div class="f-right" id="frgreen2">
                                            {$property_data.info.green_rating_mark}
                                        </div>
                                    </li>
                                {/if}
                            </ul>
                            {if $isAgent AND $is_theblock == false}
                            *}{*{if $is_bid_history and $property_data.info.pro_type != 'auction'}
                                <div style="text-align: center; font-weight: bold; margin-top: 30px; margin-bottom: 19px; font-size: 11px;">
                                     <a href="javascript:void(0)" onclick="showBidHistory('{$property_data.info.property_id}')">Bid History &raquo;</a>
                                </div>
                            {/if}*}{*
                                {if $property_data.info.confirm_sold == 1}
                                    <div style="margin-top: 0px;">
                                        <span style="float: right;margin-top: 5px;"><a class="viewmore" href="javascript:void(0)"
                                                                                       onclick="showBidHistory('{$property_data.info.property_id}','agent','winner-info')">
                                                Winner Information &raquo;</a></span>
                                    </div>
                                {/if}
                            {/if}
                            <div class="p-detail-vm">
                                <span style="float:left;margin-top:5px;">{$property_data.view_more}</span>
                            </div>
                            <div class="clearthis"></div>
                            *}{*Begin Offer button for Sale *}{*
                            {if $property_data.info.pro_type == 'sale'}
                                {if !$isAgent}
                                    <div class="sale-detail" style="float:right;margin-right:0px !important;margin-top: -20px;">
                                        {if !$isSold}
                                            {assign var = btn_offer_class value="btn-make-an-ofer"}
                                            <button id="btn-offer-{$property_data.info.property_id}" style="margin-right:0px !important;"
                                                    class="btn-wht {$btn_offer_class} btn-make-an-ofer-f"
                                                    onclick="pro.openMakeAnOffer('#makeanoffer_{$property_data.info.property_id}','{$property_data.info.property_id}')">
                                                *}{*<span><spany style="">Offer</span></span>*}{*
                                            </button>
                                        {/if}
                                        <!-- END CHECK PARTNER -->
                                        {$property_data.mao}
                                    </div>
                                {/if}
                            {/if}
                            *}{*END*}{*
                        </div>*}
                        {*<div class="email-box bottom-info">
                            {if !$isShow}
                                <span> <a href="javascript:void(0)"
                                          onclick="return myReport('/modules/property/print.php?action={$action}&id={$property_data.info.property_id}')">PRINT
                                        BROCHURE </a> </span>
                            {else}
                                <div class="div-email-box"><span><a href="javascript:void(0)"
                                                                    onClick="showSendfriend('{$property_data.info.property_id}','{$agent_info.email}')">SEND
                                            TO A FRIEND</a></span>
                                    {if $agent_id > 0}
                                        <span><a href="javascript:void(0)"
                                                 onClick="pro.addWatchlist('/modules/property/action.php/?action=add-watchlist&property_id={$property_data.info.property_id}')">ADD
                                                TO WATCHLIST</a></span>
                                    {/if}
                                </div>
                                {assign var = show_contact_fnc value = "showContact('`$agent_info.agent_id`','`$agent_info.name`','`$agent_info.email`','`$agent_info.telephone`','`$property_data.info.agent_id`','')"}
                                {if !$isLogin}
                                    {assign var = show_contact_fnc value = "showLoginPopup();"}
                                {/if}
                                <span><a href="javascript:void(0)"
                                         onclick="return myReport('/modules/property/print.php?action={$action}&id={$property_data.info.property_id}')">PRINT
                                        BROCHURE</a> </span>
                                <span><a href="javascript:void(0)" onClick="{$show_contact_fnc}">CONTACT AGENT</a></span>
                            {/if}
                        </div>*}
                        </div>
                        {if $property_data.info.remain_time < 0}
                            <script type="text/javascript">
                                jQuery('#auc-time-{$property_data.info.property_id}').html('Ended');
                            </script>
                        {/if}
                        {if $property_data.info.show_agent_logo == 1}
                            <div class="logo-agent gradient-box">
                                <h2 style="text-align:left">Agent Details</h2>
                                <hr style="margin-bottom:10px;"/>
                                {if $property_data.info.logo != ''}
                                    <img src="{$MEDIAURL}/{$property_data.info.logo}" alt="{$property_data.info.agent_name}"
                                         title="{$property_data.info.agent_name}"/>
                                {/if}
                                <div class="info-agent" style="text-align:left">
                                    <div class="main-info">
                                        <p><strong>{$property_data.me.full_name}</strong></p>
                                        <p class="company">{$property_data.agent.company_name}</p>
                                        <a href="http://{$property_data.agent.website}" target="_blank">{$property_data.agent.website}</a>
                                    </div>
                                    <p class="vector tel">{$property_data.me.telephone}</p>
                                    <p class="vector address">{$property_data.me.full_address}</p>
                                    <a class="vector email"
                                       href="mailto:{$property_data.me.email_address}">{$property_data.me.email_address}</a>
                                    <a style="background-position:0 -80px; word-wrap: break-word;padding-left: 0px;" class="vector empty"
                                       href="http://{$property_data.me.website}" target="_blank">{$property_data.me.website}</a>
                                    <div class="format-desc">
                                        {if $property_data.info.isBlock}
                                            <div id="short_des">
                                                {$property_data.me.short_description}
                                            </div>
                                            <div id="full_des" style="display:none">
                                                {$property_data.me.description}
                                            </div>
                                        {literal}
                                            <script type="text/javascript">
                                                $(document).ready(function () {
                                                    $('.seemore-des').bind('click', function () {
                                                        $('#short_des').toggle();
                                                        $('#full_des').toggle();
                                                    });
                                                })
                                            </script>
                                        {/literal}
                                        {else}
                                            {$property_data.me.description}
                                        {/if}
                                    </div>
                                </div>
                            </div>
                        {/if}
                        {*END*}
                        {*{if $property_data.info.pro_type != 'sale' OR ($property_data.info.pro_type == 'sale' AND $isAgent) }
                            {if $property_data.info.isBlock}
                                <div class="report-register-to-bid" style="">
                                    <div style="" class="btn-report"
                                         onclick="showRegisterBid('{$property_data.info.property_id}','registerToBid_blockReport','Bid Report')">
                                        <div class="viewmore text-report" style=""> Bid Report</div>
                                    </div>
                                </div>
                            {else}
                                <div class="report-register-to-bid" style="">
                                    {assign var=report_title value="Bid Report"}
                                    {if $property_data.info.pro_type == 'sale'}
                                        {assign var=report_title value="Offer Report"}
                                    {/if}
                                    <div style="" class="btn-report"
                                         onclick="showRegisterBid('{$property_data.info.property_id}','registerToBid_history','{$report_title}')">
                                        <div class="viewmore text-report"
                                             style="">{if $property_data.info.pro_type == 'sale'}Offer Report{else}Bid Report{/if}</div>
                                    </div>
                                </div>
                            {/if}
                        {/if}*}
                        {*{if $agent_id > 0}
                            {if isset($property_data.docs) and is_array($property_data.docs) and count($property_data.docs)>0}
                                <div class="pdf-documents-download">
                                    {foreach from = $property_data.docs key = k item = row}
                                        <p>
                                            <button class="btn-pdf-download"
                                                    onclick="pro.downDoc('/modules/property/action.php?action=down-doc&property_id={$row.property_id}&document_id={$row.document_id}')">
                                                <div style="width:165px; margin-bottom:3px;">
                                                    <span id="ftrtitle">{$row.title}</span>
                                                </div>
                                            </button>
                                        </p>
                                    {/foreach}
                                </div>
                            {/if}
                        {/if}*}
                    </div>
                {*END*}
                <div class="detail-imgs">
                    {if isset($property_data.photo_default)}
                        <div class="img-main-watermark " itemscope itemtype="http://schema.org/ImageObject">
                            <img id="photo_main" src="{$MEDIAURL}/{$property_data.photo_default}" alt="Photo" class="p-watermark-detail-big" style="" itemprop="contentURL" />
                            <img id="mark" class="img-watermark" alt="onthemarket" style="display: none;"/>
                        </div>
                    {/if}
                    {*End Photo Main *}
                    {*Begin Photo Slide*}
                    {if isset($property_data.photo) and is_array($property_data.photo) and count($property_data.photo)>0}
                        <div class="img-list-box" id="img-list-box">
                            <div class="img-prev">
                                <span class="icons"></span>
                            </div>
                            <div class="img-list" style="overflow:hidden;float:left">
                                <div id="img-list-slide">
                                    {foreach from = $property_data.photo key = k item = row}
                                        {assign var = active value = ''}
                                        {if $row.file_name == $property_data.photo_default}
                                            {assign var = active value = 'active'}
                                        {/if}
                                        <div class="item {$active}">
                                            <a>
                                                <img src="{$MEDIAURL}/{$row.file_name}" onmouseover="img(this)" alt="photos" style=""/>
                                            </a>
                                        </div>
                                    {/foreach}
                                </div>
                            </div>
                            <div class="img-next">
                                <span class="icons"></span>
                            </div>
                            <div class="clearthis">
                            </div>
                        </div>
                        <script type="text/javascript">SlideShow.init('#img-list-box', '#photo_main')</script>
                    {/if}
                </div>
                <div class="property-desc">
                    {if $property_data.agent && $property_data.agent.logo != ''}
                        {if $property_data.info.isBlock}
                            <img src="{$MEDIAURL}/{$property_data.agent.logo}" alt="{$property_data.agent.company_name}"
                                 title="Click here to view all property" style="padding: 10px 0; max-width: 401px; width: auto;"/>
                        {else}
                            <a href="{seo}?module=agent&action=view-detail-agency&uid={$property_data.agent.agent_id}{/seo}"><img
                                        src="{$MEDIAURL}/{$property_data.agent.logo}" alt="{$property_data.agent.company_name}"
                                        title="Click here to view all property" style="padding: 10px 0;max-width: 401px; width: auto;"/></a>
                        {/if}

                    {/if}                    
                    <!-- Share buttons-->
                    <div class="tw-button">
                    <a href="https://twitter.com/share" class="twitter-share-button" data-count="none">Tweet</a>
                    {literal}<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                    {/literal}                    
                    </div>                    
                    <div class="fb-share-button" data-layout="button"></div>
                    <div class="clearthis"></div>
                    <!-- End share buttons-->
                    {*<h2>PROPERTY DESCRIPTION</h2>*}
                    <div class="div-des-detail" style="font-size:12px;">
                        <p class="word-wrap-all word-justify">
                            {$property_data.info.description}
                        </p>
                        <div class="pvm">
                            {$property_data.view_more}
                         </div>
                        <div class="clearthis"></div>
                    </div>
                </div>

                <div class="clearthis"></div>
                <div class="tbl-info-item">
                    <ul>
                        <li>
                            <div class="col-span-1">{localize translate="Status"}:</div>
                            <div class="col-span-2">
                                {if $property_data.info.active == 0}
                                    {localize translate="Inactive"}
                                {else}
                                    {localize translate="Active"}
                                {/if}

                            </div>
                            <div class="clearthis clearthis-ie7"></div>
                        </li>
                        <li>
                            <div class="col-span-1">{localize translate="Open for Inspection"}:</div>
                            <div class="col-span-2">
                                <span class="">{$property_data.info.o4i}</span>
                            </div>
                            <div class="clearthis clearthis-ie7"></div>
                        </li>
                        {*<li>
                            <div class="col-span-1">{localize translate="iBB Sustainability"}:</div>
                            <div class="col-span-2">
                                <span class="span-star">{$property_data.info.green_rating_mark}</span>
                            </div>
                            <div class="clearthis clearthis-ie7"></div>
                        </li>*}
                    </ul>
                </div>
            </div>
            <div class="clearthis"></div>
        </div>{*End Colmain*}
        {if !$is_localhost}
            <div class="map google-map" style="display:none">
                <div>
                    {*{assign var = new_address value = "`$property_data.info.address_full`"}*}
                    <iframe class="if_google_map" src=""  width="620" height="360" frameborder="0" scrolling="no"></iframe>
                </div>
            </div>
            <script type="text/javascript" charset="utf-8">
                var src_google_map = '{$ROOTURL}/modules/property/google_map.php?address={$new_address}';
                {literal}
                $(function () {
                    /*
                     jQuery('#div_google_map').show();
                     jQuery('#if_google_map').attr('src',src_google_map);
                     */
                    jQuery('.google-map').show();
                    jQuery('.google-map .if_google_map').attr('src', src_google_map);
                });
                {/literal}
            </script>
            <script type="text/javascript">
                {literal}
                $(function () {
                    jQuery('.btn-bid-green').tipsy({gravity: $.fn.tipsy.autoNS, fallback: " <div style='padding: 5px;text-align: justify'>When the bid button turns green the property is on the market</div>", html: true });
                    jQuery('.btn-bid-vendor-green').tipsy({gravity: $.fn.tipsy.autoNS, fallback: " <div style='padding: 5px;text-align: justify'>When the bid button turns green the property is on the market</div>", html: true });
                });
                {/literal}
            </script>
        {/if}
        {if $can_comment and $property_data.info.auction_blog == 1}
            {include file = 'property.comment.tpl'}
        {/if}
            <div class="backtotop-cls">
                <a title="back" href="javascript:void(0)" class="back-to-top" onclick="jQuery('html, body').scrollTop(0);">{localize translate="BACK TO TOP"}  </a>
            </div>
        {else}
            <div class="message-box message-box-add">
                <center>
                    <i>Sorry, but there are no properties available based on your selection. Please modify the
                        filters to search again. Thanks!
                    </i>
                </center>
            </div>
        {/if}
    </div>
    {*<script type="text/javascript" src="/modules/general/templates/js/jquery.min.js"></script>*}
    <script type="text/javascript">
        var title_bar = "{$property_data.info.title}";
        var property_id = "{$property_data.info.property_id}";
    </script>
    <script type="text/javascript" src="/modules/property/templates/js/print.js"></script>
</div>
<div style="display:none" id="no_more_bid_msg">{$no_more_bids_msg}</div>
{if $is_showalert && $is_showalert == 1}
    <script type="text/javascript">
        var url = '/modules/property/action.php?action=down-term&pid={$property_data.info.property_id}';
        jQuery('body').append('<iframe id="if-term" src="' + url + '" style="display:none; visibility:hidden;"></iframe>');
    </script>
{/if}
<script type="text/javascript">
   {literal}
    jQuery(document).ready(function(){
        //upload.showPopup({/literal}{$property_data.info.property_id}{literal});
        if(document.location.href.indexOf('bidreport') > -1 || document.location.href.indexOf('regtobidreport') > -1){
            jQuery('.btn-bid-report').click();
        }
    });
   {/literal}
</script>