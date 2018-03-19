{if $template == 'detail'}
<div class="auction-info-box" id="auc-{$property_data.info.property_id}">
    <div class="auc-time">
        {if $isSold }<p> Sold </p> {else}
            {if $property_data.info.isBlock || ($property_data.info.ofAgent AND $property_data.info.pro_type_code == 'auction')}
                <p id="count-{$property_data.info.property_id}">{$property_data.info.set_count}</p>
            {else}
                {if $property_data.info.pro_type == 'auction'
                    && (!($property_data.info.check_price) || ($property_data.info.isLastBidVendor) || (($property_data.info.ofAgent AND $property_data.info.pro_type_code == 'auction') || $property_data.info.isBlock))
                    && $property_data.info.stop_bid == 1
                }
                    <p id="passedin-{$property_data.info.property_id}">Passed In</p>
                {else}
                    <p id="auc-time-{$property_data.info.property_id}">-d:-:-:-</p>
                {/if}
            {/if}
        {/if}
    </div>

    <div class="auc-bid">
        <p class="bid" id="auc-price-{$property_data.info.property_id}">
             <span class="bid-text">
                {if $property_data.info.stop_bid == 1 or $property_data.info.transition == true or $property_data.info.confirm_sold == 1}
                   {assign var=temp value = 0}
                   {if $property_data.info.stop_bid == 1}
                       {if $property_data.info.bidder == '--'}
                           Start Price:
                       {assign var=temp value = 1}
                   {/if}
                {/if}

                {if !$temp}Last Bid:{/if}
                {elseif $property_data.info.check_start == 'true'}
                      Start Price:
                {else}
                      Current Bid:
                {/if}
             </span>
             <span class="bid-num">{$property_data.info.price}</span>
        </p>

        <p class="lasted" id="auc-bidder-{$property_data.info.property_id}">
        {if $property_data.info.isLastBidVendor}
            Vendor Bid
        {elseif $property_data.info.stop_bid == 1 or $property_data.info.transition == true or $property_data.info.confirm_sold == 1}
            Last Bidder: {$property_data.info.bidder}
        {else}
            Current Bidder: {$property_data.info.bidder}
        {/if}
        </p>
    </div>

<div class="buttons-set">
    <div id="property_detail">
        <div class="property-detail-a" style="margin-bottom: 8px;">
            <input type="hidden" value="{$default_inc}" id="default_inc"/>
            {if $authentic.id > 0 AND !$isSold  AND $property_data.info.stop_bid == 0 }
                {if $property_data.info.completed}
                    {if in_array($authentic.type,array('theblock','agent')) && $property_data.is_mine == true}
                        <span style="float:left;padding-top: 4px;">Bid price: </span>
                        <input class="input-text" type="text" name="step_option" id="step_option_txt" value=""
                               style="width:101px;float:right;margin-right: 2px;"/>
                        <script type="text/javascript">
                            bid_{$property_data.info.property_id}._options.mine = true;
                        </script>

                    {elseif $isAgent  OR(!$isAgent AND $is_paid AND $property_data.info.register_bid) }
                        <span style="float:left">Increment: </span>
                        <strong class="strong-increment-detail increment-detail-fix">
                            <select name="step_option" id="step_option" class="input-select" style="width:100%">
                                {html_options options = $inc_options selected = $step_init}
                            </select>
                        </strong>
                        <script type="text/javascript">
                                {if $property_data.info.isBlock }
                                    var dis_input = true;
                                {else}
                                    var dis_input = false;
                                {/if}

                                /*BEGIN SELECT PLUGIN*/
                                {literal}
                                function selectInit(){
                                    if ($('#step_option').length > 0){
                                        var selectPlugin = new SelectPlugin({'targetId':'step_option','money_step' : 'step_option1',disable_input: dis_input});
                                        selectPlugin.listener();

                                    }else{
                                        setTimeout(selectInit,50);
                                    }
                                }
                                selectInit();
                                {/literal}
                                 /*END*/
                        </script>

                        {if $property_data.info.isBlock}
                            {assign var="detail_info" value="min-height:95px !important"}
                            <p style="height: 18px"></p>

                            <div style="clear: both;background-color: LemonChiffon;">
                                <span style="display: block;text-align: center;"></span>
                                <span id="MinMax_mess_{$property_data.info.property_id}" style="display: block;padding: 0px 5px;text-align: center;">
                                      {$property_data.info.minmaxInc_mess}
                                </span>
                            </div>
                        {/if}
                    {/if}
                {/if}

                <input type="hidden" name="step_option1" id="step_option1" value="{$step_init}"/>
                {literal}
                    <script type="text/javascript">
                         var value_show = '';
                         $(document).ready(function (){
                             jQuery('#step_option1').val(jQuery("#step_option").val());
                             jQuery("#step_option_txt").keyup(function(){
                                   this.value = format_price(this.value,'#step_option1','#property_detail');
                                   value_show = this.value;
                                   jQuery("#step_option").val(jQuery('#step_option1').val());
                             });
                             jQuery("#step_option").change(function(){
                                 jQuery('#step_option1').val(jQuery("#step_option").val());
                             });
                             jQuery("#step_option_txt").focusout(function (){
                                  if(value_show == '$0' || value_show == ''){
                                        jQuery('#uniform-step_option span').html(jQuery('#default_inc').val());
                                  }else{
                                        jQuery('#uniform-step_option span').html(value_show);
                                  }
                             });
                             jQuery("#step_option_txt").focusin(function (){
                                  this.value = format_price(this.value,'#step_option1','#property_detail');
                             });
                         });
                    </script>
                {/literal}
                <script type="text/javascript">
                    bid_{$property_data.info.property_id}.addCallbackFnc('bid_before',function(obj){literal}{
                        return {money_step:jQuery('#step_option1').val()}
                    });
                    {/literal}
                </script>
            {/if}
        </div>

        <div class="property-detail-b">
            {if !($property_data.info.isBlock AND $property_data.info.stop_bid == 0) AND !$isAgent AND !$isSold}
                <div style="float:left;margin-right:0px !important;">
                    <button id="btn-offer-{$property_data.info.property_id}"
                            style="margin-right:0px !important;margin-top: 0px;"
                            class="btn-wht btn-make-an-ofer-f {if $property_data.info.check_price}btn-make-an-ofer-green{else}btn-make-an-ofer{/if}"
                            onclick="pro.openMakeAnOffer('#makeanoffer_{$property_data.info.property_id}','{$property_data.info.property_id}');{$fnc_strAT}">
                    </button>
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
                       style="float:right;margin-top: 0px;margin-right:0px ;width: 110px;margin-bottom: 10px;{$bid_dis}"/>

        </div>

        {if in_array($authentic.type,array('theblock','agent'))  && $isAgent AND $property_data.info.pro_type_code == 'auction'}
            <input id="bid_room_button" type="{if ($property_data.info.isBlock || ($property_data.info.ofAgent && $isAuction)) && $property_data.info.pro_type == 'auction'  && $property_data.info.completed }
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
                            <div style="float:right;margin-right:0px !important;width: 110px;">
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
            {/if}button" class="{$bid_room_class}"
                   onclick="bid_{$property_data.info.property_id}.click(true)"
                   style="float: right; margin-left: 0px;margin-top: 5px;{$bid_dis}"/>
        {/if}
        <br clear="all"/>
        </div>
    </div>

    <div class="auc-actions" style="margin-bottom: 6px;position:relative;float: left;width: 190px;">
        {if $agent_id > 0 AND $isShow}
            {assign var = fnc_str1 value = "showBidHistory('`$property_data.info.property_id`')"}
            {assign var = fnc_str2 value = "pro.before_openAutoBidForm('#autobid_`$property_data.info.property_id`','`$property_data.info.property_id`')"}
            {assign var = fnc_strAT value = "pro.closeAutoBidForm('#autobid_`$property_data.info.property_id`')"}
            {if !$isSold AND !$isAgent and $property_data.info.stop_bid == 0 and !($property_data.info.isBlock || $property_data.info.ofAgent)}
                <input onclick="{$fnc_str2};pro.closeMakeAnOffer('#makeanoffer_{$property_data.info.property_id}')"
                       class="btn-autobid" style="height: 25px;margin-left: 84px;width: 110px;"/>
                {$property_data.abs_tpl}
            {/if}
        {/if}
    </div>
</div>
<script type="text/javascript">
    $("select").uniform();
    var confirm_nh = new Confirm_popup();
    {if ($property_data.info.isBlock == 1 || $property_data.info.ofAgent == 1) && $property_data.info.confirm_sold == 0}
        bid_{$property_data.info.property_id}.setContainer('count-{$property_data.info.property_id}');
        bid_{$property_data.info.property_id}._options.theblock = true;
        var count_{$property_data.info.property_id} = new CountDown();
            count_{$property_data.info.property_id}.container = 'count-{$property_data.info.property_id}';
            count_{$property_data.info.property_id}.bid_button = 'bid_button_{$property_data.info.property_id}';
            count_{$property_data.info.property_id}.button = 'btn_count_{$property_data.info.property_id}';
            count_{$property_data.info.property_id}.property_id = '{$property_data.info.property_id}';
    {/if}
</script>
{elseif in_array($template,array('list','list-watchlist','list-bid'))}
<div class="tbl-info" {if $template == 'list-bid'}style="float:left;margin-bottom:1px"{/if}>
    <ul class="f-left col1">
       <li id="i-time-p" class="i-time" style="margin-right:0px;margin-bottom:0px;*width:190px;*height:38px">
         {if $row.isSold} <p> Sold </p>
         {else}
             {if $property_data.info.isBlock || ($property_data.info.ofAgent AND $property_data.info.pro_type_code == 'auction')}
                <p class="acc-sp-all acc-sp-all-ie" id="count-{$row.property_id}">
                     {$property_data.info.set_count}
                </p>
             {else}
                  {if $property_data.info.auction_type != 'passedin'}
                       <p class="acc-sp-all acc-sp-all-ie" id="auc-time-{$property_data.info.property_id}">-d:-:-:-</p>
                  {else}
                       <p class="acc-sp-all acc-sp-all-ie" id="auc-time-{$property_data.info.property_id}">Passed In</p>
                  {/if}
             {/if}
         {/if}
       </li>
    </ul>
    <ul class="f-left col2">
        <li class="i-bid" style="margin-bottom:0px">
           <p style="{if $template == 'list'}padding-left:5px;{else}padding-bottom:4px{/if}" class="lasted" id="auc-bidder-{$property_data.info.property_id}">
                 {if $property_data.info.isLastBidVendor}Vendor Bid
                 {else}
                     {if $property_data.info.stop_bid == 1 or $property_data.info.transition == true}
                         Last Bidder: {$property_data.info.bidder}
                     {else}
                         Current Bidder: {$property_data.info.bidder}
                     {/if}
                 {/if}
           </p>

           <p style="{if $template == 'list'}padding-left: 5px;{else}font-weight: bold{/if}" class="bid bid-property-price" id="auc-price-{$property_data.info.property_id}">
                  {if $property_data.info.stop_bid == 1 or $property_data.info.transition == true or $property_data.info.confirm_sold == 1}
                     {assign var=temp value = 0}
                     {if $property_data.info.stop_bid == 1}
                         {if $property_data.info.bidder == '--'}Start Price:
                             {assign var=temp value = 1}
                         {/if}
                     {/if}
                     {if !$temp}Last Bid:{/if}
                     {elseif $property_data.info.check_start == 'true' or $property_data.info.bidder == '--'}Start Price:
                     {else}Current Bid:
                     {/if} {$property_data.info.price}
           </p>
        </li>
    </ul>
</div>
{elseif $template == 'grid'}
    <p class="name" style="min-height:10px; padding:0 0px 18px 0px;*padding-bottom:14px;" title="{$property_data.info.address_full}">
        {if $property_data.info.address_short}{$property_data.info.address_short}
        {else}{$property_data.info.address_full}
        {/if}
    </p>
    {if $row.isSold}
        <p class="time"
           style="color:#980000; font-size:16px; font-weight:bold; text-align:center; margin-left:0px; margin-right:0px;">
            Sold
        </p>
    {else}
        {if $property_data.info.isBlock == 1 || ($property_data.info.ofAgent AND $property_data.info.pro_type_code == 'auction')}
            <p class="time" id="count-{$property_data.info.property_id}"
               style="color:#980000; font-size:15px; font-weight:bold; text-align:center; margin-left:0px; margin-right:0px;">
                {$property_data.info.set_count}
            </p>

        {elseif $property_data.info.auction_type == 'passedin'}
            <p class="time" id="auc-time-{$property_data.info.property_id}"
               style="color:#980000; font-size:15px; font-weight:bold; text-align:center; margin-left:0px; margin-right:0px;">
                Passed In
            </p>

        {else}
            <p class="time" id="auc-time-{$property_data.info.property_id}"
               style="color:#980000; font-size:15px; font-weight:bold; text-align:center; margin-left:0px; margin-right:0px;">
                -d:-:-:-
            </p>
        {/if}
    {/if}

    <p class="bid" id="auc-price-{$property_data.info.property_id}"
       style="font-size:14px; text-align:center;  color:#980000 !important ">
        {if $property_data.info.stop_bid == 1 or $property_data.info.isSold}
            {assign var=temp value = 0}
            {if $property_data.info.stop_bid == 1}
                {if $property_data.info.bidder == '--'}
                    Start Price:
                    {assign var=temp value = 1}
                {/if}
            {/if}
            {if !$temp}Last Bid:{/if}

            {elseif $property_data.info.check_start == 'true'}
            Start Price:
            {else}
            Current Bid:
        {/if} {$property_data.info.price}
    </p>

    <p class="bid"
       id="auc-bidder-{$property_data.info.property_id}"
       style="font-size:10px; text-align:center;  color:#980000 !important ">
        {if $property_data.info.isLastBidVendor}
            Vendor Bid
            {else}
            {if $property_data.info.stop_bid == 1 or $property_data.info.transition == true}
                Last Bidder: {$property_data.info.bidder}
                {else}
                Current Bidder: {$property_data.info.bidder}
            {/if}
        {/if}
    </p>
{elseif $template == 'list-detail'}
<ul class="f-left col1">
    {if $property_data.info.isBlock || ($property_data.info.ofAgent AND $property_data.info.pro_type_code == 'auction')}
            {if $property_data.info.pay_status != 'complete'}
                <li>
                    <p class="acc-sp-ie acc-sp-pass6" id="count-{$property_data.info.property_id}">
                        {$property_data.info.set_count}
                    </p>
                </li>
            {else}
                <li id="li-sit" class="li-status-ie9 li-price-ie7">
                    <p class="acc-sp-ie acc-sp-all" id="count-{$property_data.info.property_id}">
                        {$property_data.info.set_count}
                    </p>
                </li>
            {/if}
    {else}
                {if $property_data.info.pay_status == 'complete'}
                    <li id="li-sit" class="li-status-ie9 li-price-ie7">
                        <p class="acc-sp-ie acc-sp-all" id="auc-time-{$property_data.info.property_id}">
                            -d:-:-:-
                        </p>
                    </li>

                {else}
                    <li class="li-status2-ie9">
                        <p class="acc-sp-ie acc-sp-all-b" id="auc-time-{$property_data.info.property_id}" align="center">
                            -d:-:-:-
                        </p>
                    </li>
                {/if}
    {/if}
</ul>
<ul class="f-left col2">
        {if $property_data.info.pay_status == 'complete'}
            <li id="li-sit2" class="start-property-ie9">
                <p style="height: 14px;" class="lasted last-bid-ie8" id="auc-bidder-{$property_data.info.property_id}">
                    {if $property_data.info.isLastBidVendor}
                        Vendor bid
                    {else}
                        {if $property_data.info.stop_bid == 1
                        or $property_data.info.confirm_sold == 'Sold'
                        or $property_data.info.transition == true}
                            Last Bidder: {$property_data.info.bidder}
                        {else}
                            Current Bidder: {$property_data.info.bidder}
                        {/if}
                    {/if}
                </p>

                <p class="bid price-all2 bid-property-price" id="auc-price-{$property_data.info.property_id}">

                    {if $property_data.info.stop_bid == 1 or $property_data.info.confirm_sold == 'Sold' or $property_data.info.transition == true}
                        {assign var=temp value = 0}
                        {if $property_data.info.stop_bid == 1}
                            {if $property_data.info.bidder == '--'}
                                Start Price:
                                {assign var=temp value = 1}
                            {/if}
                        {/if}
                        {if !$temp}Last Bid:{/if}
                    {elseif $property_data.info.check_start == 'true'}
                        Start Price:
                    {else}
                        Current Bid:
                    {/if}{$property_data.info.price}
                </p>
            </li>
        {else}
            <li id="start-price-chrome" class="start-property-ie9">
                <p class="bid bid-price-coll3 bid-property-price bid-price-coll8 "
                   id="auc-price-{$property_data.info.property_id}">
                    Start Price:  {$property_data.info.price}
                </p>
            </li>
        {/if}
</ul>
{elseif $template == 'theblock'}
<div class="info-box tv-show-info-box" id="auc-{$property_data.info.property_id}">
    <div class="tv-show-buttons-set">
        <div class="info-box tv-show-info-box">
            {if $property_data.info.stop_bid == 0}
                <div class="tv-show-vm-b">
                    <div class="auc-actions">
                        <div class="final-counts">
                            {if $authentic}
                                {if ($property_data.info.isBlock || ($property_data.info.ofAgent && $isAuction)) && $property_data.info.pro_type == 'auction'  && $property_data.info.completed }
                                    {if in_array($authentic.type,array('theblock','agent')) && $property_data.is_mine == true && $property_data.info.confirm_sold == 0 && $property_data.info.stop_bid == 0}
                                        <div style="float:left;margin-right:0px !important;width: 79px;">
                                            <button id="btn_count_{$property_data.info.property_id}"
                                                    class="btn-wht btn-countdown"
                                                    onclick="count_{$property_data.info.property_id}.showPopup('agent-block')">
                                            </button>
                                            {$property_data.countdown}
                                        </div>
                                        {else}
                                        {if !$property_data.info.no_more_bids AND $is_paid AND $property_data.info.register_bid AND $property_data.info.confirm_sold == 0 AND $property_data.info.stop_bid == 0}
                                            {if !$property_data.info.ofAgent}
                                                <div style="float:left;margin-right:0px !important;width: 79px;">
                                                    <button id="btn_no_{$property_data.info.property_id}"
                                                            class="btn-wht btn-no-more-bid"
                                                            onclick="bid_{$property_data.info.property_id}.pauseBid()"></button>
                                                </div>
                                                {else}
                                                <div style="float:right;margin-right:0px !important;width: 110px;">
                                                    <button id="btn_no_{$property_data.info.property_id}"
                                                            class="btn-wht btn-no-more-bid2"
                                                            onclick="bid_{$property_data.info.property_id}.pauseBid()"></button>
                                                </div>
                                                <div class="clearthis"></div>
                                            {/if}
                                        {/if}
                                        {if $is_paid AND $property_data.info.register_bid AND $property_data.info.confirm_sold == 0 AND $property_data.info.stop_bid == 0}
                                            <div style="position: absolute;margin-right:0 !important;width: 79px;top:28px;z-index:9; *left: 0px;">
                                                <button id="btn_count_{$property_data.info.property_id}"
                                                        class="btn-wht btn-countdown"
                                                        onclick="count_{$property_data.info.property_id}.showPopup('bidder-user')">
                                                </button>
                                                {$property_data.countdown}
                                            </div>
                                        {/if}
                                    {/if}
                                {/if}
                            {else}
                                <span class="tv-show-auc-actions">
                                            <a href="/?module=agent&action=login">&raquo;JOIN AUCTION
                                                (as a bidder)</a>
                                        </span>
                            {/if}


                            <div id="property_detail_{$property_data.info.property_id}">
                                {if $authentic.id > 0 && $is_paid}
                                    <input type="hidden" value="{$property_data.info.default_inc}"
                                           id="default_inc_{$property_data.info.property_id}"/>
                                    {if $authentic.type != 'theblock' || !$property_data.is_mine}
                                        <span class="tv-show-increment">INCREMENT: </span>
                                        <strong class="strong-tv-increment">
                                            <select name="step_option" id="step_option_{$property_data.info.property_id}"
                                                    class="input-select" style="width:100%">
                                                {html_options options = $inc_options selected=$step_init}
                                            </select>
                                        </strong>
                                        {literal}
                                        <script type="text/javascript">
                                             /*BEGIN SELECT PLUGIN*/
                                             var selectPlugin_{/literal}{$property_data.info.property_id}{literal} = new SelectPlugin({'targetId':'step_option_{/literal}{$property_data.info.property_id}{literal}','disable_input' : true});
                                                 selectPlugin_{/literal}{$property_data.info.property_id}{literal}.listener();
                                             /*END*/
                                        </script>
                                        {/literal}
                                    {else}
                                        <span class="tv-show-increment">BID PRICE: </span>
                                        <input type="text" value="" name="step_options"
                                               id="step_option_{$property_data.info.property_id}_txt" class="input-text"
                                               style="float:left; width:142px;font-weight:bold;font-size:11px;margin-top: 6px;"/>
                                    {/if}
                                    <input type="hidden" name="step_option1" id="step_option1_{$property_data.info.property_id}"
                                           value="{$step_init}"/>
                                {/if}
                                <div class="tv-show-bid">
                                    {if $property_data.info.pro_type == 'auction'}
                                        {assign var = btn_bid_event value = "bid_`$property_data.info.property_id`.click()"}

                                        {if $property_data.info.is_mine}
                                            <input type="button" id="bid_button_{$property_data.info.property_id}"
                                                   class="{if $property_data.info.check_price}btn-bid-vendor-green{else}btn-bid-vendor{/if}"
                                                   onclick="{$btn_bid_event}" value=""/>
                                            {else}
                                            {if !$property_data.info.register_bid}
                                                <input type="button" id="bid_button_{$property_data.info.property_id}"
                                                       class="{if $property_data.info.check_price}btn-bid-green-reg{else}btn-bid-reg{/if}"
                                                       onclick="{$btn_bid_event}" value=""/>
                                                {else}
                                                <input type="button" id="bid_button_{$property_data.info.property_id}"
                                                       class="{if $property_data.info.check_price}btn-bid-green{else}btn-bid{/if}"
                                                       onclick="{$btn_bid_event}" value=""/>
                                            {/if}

                                        {/if}

                                    {/if}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {/if}
        {*</div>*}

            <div class="auc-time-bid">
                <ul class="auc-time auction-time-tv-show">
                    <li class="li-auc-time-bid">
                        <p class="time" id="count-{$property_data.info.property_id}" {if $property_data.info.check_price}style="color:#007700"{/if}>
                            {$property_data.info.set_count}
                        </p>
                    </li>
                </ul>
                <ul class="auc-bid">
                    <li>
                        <p class="lasted" id="auc-bidder-{$property_data.info.property_id}">
                            {if $property_data.info.stop_bid == 1 or $property_data.info.transition == true}
                                Last Bidder: {$property_data.info.bidder}
                                {else}
                                Current Bidder: {$property_data.info.bidder}
                            {/if}
                        </p>

                        <p class="bid" id="auc-price-{$property_data.info.property_id}">
                            {if $property_data.info.stop_bid == 1 || $property_data.info.confirm_sold == 1}
                                Last Bid: {$property_data.info.price}
                                {elseif $item.bids > 0}
                                Current Bid: {$property_data.info.price}
                                {else}
                                Start Price: {$property_data.info.price}
                            {/if}

                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    {literal}$("select").uniform();{/literal}
    bid_{$property_data.info.property_id}.flushCallbackFnc();
       {if $authentic && $authentic.id > 0}
              bid_{$property_data.info.property_id}.addCallbackFnc('bid_before',function (obj){literal}{
                return {money_step:jQuery('#step_option1_{/literal}{$property_data.info.property_id}{literal}').val()}
              });
            {/literal}
             {if $authentic.type != 'theblock' || !$property_data.info.is_mine}
             {else}
                 bid_{$property_data.info.property_id}._options.mine = true;
             {/if}
       {/if}

                                var value_show_{$property_data.info.property_id} = "{$step_init}";
                                    {literal}
                                            $(document).ready(function (){
                                            jQuery('#step_option1_{/literal}{$property_data.info.property_id}{literal}').val(jQuery("#step_option_{/literal}{$property_data.info.property_id}{literal}").val());
                                        jQuery("#step_option_{/literal}{$property_data.info.property_id}{literal}_txt").keyup(function(){
                                        this.value = format_price(this.value,'#step_option1_{/literal}{$property_data.info.property_id}{literal}','#property_detail_{/literal}{$property_data.info.property_id}{literal}');
                                        value_show_{/literal}{$property_data.info.property_id}{literal} = this.value;
                                        jQuery("#step_option_{/literal}{$item.property_id}{literal}").val(jQuery('#step_option1_{/literal}{$property_data.info.property_id}{literal}').val());
                                }
                                );
                                        jQuery("#step_option_{/literal}{$property_data.info.property_id}{literal}").change(function(){
                                        jQuery('#step_option1_{/literal}{$property_data.info.property_id}{literal}').val(jQuery("#step_option_{/literal}{$property_data.info.property_id}{literal}").val());
                                }
                                );
                                        jQuery("#step_option_{/literal}{$property_data.info.property_id}{literal}_txt").focusout(function (){
                                        if(value_show_{/literal}{$property_data.info.property_id}{literal} == '$0')
                                {
                                        jQuery('#uniform-step_option_{/literal}{$property_data.info.property_id}{literal} span').html(jQuery('#default_inc_{/literal}{$property_data.info.property_id}{literal}').val());
                                }
                                else
                                {
                                        jQuery('#uniform-step_option_{/literal}{$property_data.info.property_id}{literal} span').html(value_show_{/literal}{$property_data.info.property_id}{literal});
                                }
                                });
                                        jQuery("#step_option_{/literal}{$property_data.info.property_id}{literal}_txt").focusin(function (){
                                        this.value = format_price(this.value,'#step_option1_{/literal}{$property_data.info.property_id}{literal}','#property_detail_{/literal}{$property_data.info.property_id}{literal}');
                                });
                                });
{/literal}
</script>

{/if}
<script type="text/javascript">
    time_{$property_data.info.property_id} = {$property_data.info.remain_time};
    bid_{$property_data.info.property_id}.setTimeObj('auc-time-{$property_data.info.property_id}');
    bid_{$property_data.info.property_id}.setTimeValue('{$property_data.info.remain_time}');
    bid_{$property_data.info.property_id}.startTimer({$property_data.info.property_id});
    bid_{$property_data.info.property_id}.setBidderObj('auc-bidder-{$property_data.info.property_id}');
    bid_{$property_data.info.property_id}.setPriceObj('auc-price-{$property_data.info.property_id}');
</script>