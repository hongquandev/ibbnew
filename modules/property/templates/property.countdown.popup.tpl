{php}
    //$this->_tpl_vars['type_popup'] = '123';
    //$this->_tpl_vars['row']['is_mobile_nexus7'] = '123';
{/php}
{literal}
<style type="text/css">
    .popup-countdown-child .content .auc-bid {
        padding: 12px 0;
    }
    .popup-countdown-child .content .auc-bid .bid {
        margin-bottom: 5px !important;
    }
    .popup-countdown-child .content .bid-inc-content button,
    .popup-countdown-child .content .bid-inc-content button span{
        color: rgb(255, 255, 255) !important;
    }
    .popup-countdown-child .content .auc-bid p{
        color: #ffffff;
    }
    .popup-countdown-child .manage-bid-content .fs-inc {
        padding-bottom: 17px; margin-bottom: 12px;
    }
    .popup-countdown-child .inc-content fieldset {
        padding-bottom: 20px;
    }
    .popup-countdown-child  .grid-content-bidder-user .report {
        height: 241px;
        margin-bottom: 12px ;
    }
    .popup-countdown-child  .action-panel-bidder-bidder-user {
        padding: 10px 0;
    }
</style>
{/literal}
{if $row.is_mobile > 0}
    {literal}
        <style type="text/css">
            .popup-countdown-child .btn-count-content-mobile {
                padding: 5px 5px!important;
            }
            .popup-countdown-child .btn-action-panel-start-mobile {
                float: left !important;
            }
            .popup-countdown-child .label-inc1 {
                padding: 4px 15px !important;
            }
            .popup-countdown-child .inc-setting-panel {
                padding: 10px !important;
            }
            .popup-countdown-child .min_max_mes_bidder {
                padding: 15px !important;
            }
            .popup-countdown-child .btn-count-content-mobile {
                padding: 10px 0 !important;
            }
            .popup-countdown-child .inc-content fieldset {
                padding-bottom: 0 !important;
            }
        </style>
    {/literal}
{/if}
{if $row.is_mobile_nexus7 > 0}
{literal}
<style type="text/css">
    .popup-countdown-child .content .btn-action-panel-pre {
        margin-right: 15px;
    }
</style>
{/literal}
{/if}
<div class="popup-countdown-child" id="count_popup_{$row.property_id}" style="width:auto">
    <div class="title">
        <h2 id="txtt"> {if $type_popup == 'agent-block'} bidRhino Agent Bid Manager {else}  bidRhino Bidder Manager{/if}  - ID: {$row.property_id}  <span id="btnclosex" onclick="count_{$row.property_id}.close()">x</span></h2>
    </div>
    <div class="content normal-width" style="width:auto">
    <div class="f-left" style="">
        <div class="manage-bid-content">
            <fieldset style="" class="fs-inc">
                <legend> BIDS STATUS</legend>
                <div class="auction-info-box" id="popup-auc-{$row.property_id}" style="">
                    <div class="auc-time" style="margin-bottom: 10px;">
                        <p id="popup-auc-time-{$row.property_id}">
                        {$row.set_count}
                        </p>
                    </div>
                    <div class="auc-bid">
                        <p class="bid" id="popup-auc-price-{$row.property_id}" style="font-size: 18px;">
                            Start Price: {$row.price}
                        </p>
                        <p class="lasted" id="popup-auc-bidder-{$row.property_id}" style="font-size: 14px;">
                        {if $row.isLastBidVendor}
                            Vendor Bid
                            {else}
                            {if $row.stop_bid == 1 or $row.confirm_sold == 1}
                                Last Bidder: {$row.bidder}
                                {else}
                                Current Bidder: {$row.bidder}
                            {/if}
                        {/if}
                        </p>
                    </div>
                    <div class="bid-content" id="bid-content-m" style="margin-top: 10px;position: relative;{if $row.is_mobile_nexus7 > 0 } display: block; {/if}">
                        <div class="txt-content">
                            {if $type_popup == 'agent-block'}
                                {assign var="cls_txt" value="agent"}
                                <label class="lb-txt-agent" for="popup_total_option_{$row.property_id}">BID TOTAL:</label>
                            {else}
                                {assign var="cls_txt" value="bidder"}
                                <label class="lb-txt-bidder" for="popup_total_option_{$row.property_id}">YOUR BID IS:</label>
                            {/if}
                            <input class="input-text input-txt-{$cls_txt}" type="text" name="total_option" id="popup_total_option_{$row.property_id}" value="{$row.price}"/>
                        </div>
                        <div class="txt-content">
                            {if $type_popup == 'agent-block'}
                                {assign var="cls_txt" value="agent"}
                                <label class="lb-txt-agent" for="popup_step_option_{$row.property_id}">BID VALUE:</label>
                            {else}
                                {assign var="cls_txt" value="bidder"}
                                <label class="lb-txt-bidder" for="popup_step_option_{$row.property_id}" >YOUR ARE BIDDING:</label>
                            {/if}
                                <input class="input-text input-txt-{$cls_txt}" type="text" name="step_option" id="popup_step_option_{$row.property_id}" value="{$row.min_increment_}" />
                                <input class="input-text" type="hidden" name="step_option" id="_popup_step_option_{$row.property_id}" value="{$row.min_increment_}"/>
                        </div>
                    </div>
                    {*{if $row.is_mobile_nexus7 > 0 }
                        <div onclick="changeBidText('#bid-content-m',this)" style="text-align: center; color:#9acd32;font-size:13px;font-weight: bold;cursor: pointer ">
                            Show Bid Text Box
                        </div>
                    {/if}*}
                </div>
            </fieldset>
        </div>


        <div>
            <div class="btn-left-content">
                <div class="" >
                    <fieldset style="*width: 324px;">
                        <legend>MANAGE BID & INCREMENT</legend>
                        <div class="bid-inc-content">
                            <div class="btn-bid-panel">
                                <ul class="btn-bid-panel-ul">
                                    {if $type_popup == 'agent-block'}
                                        <li>
                                            <button id="bid_button_{$row.property_id}" type="button"
                                                    class="btn-bid-popup-fix btn-bid-vendor-popup-fix {if $row.check_price} btn-bid-vendor-green-popup{/if} cufon-btn"
                                                    onclick="bid_{$row.property_id}.click()" style="" >
                                                <span style=""><span>VENDOR BID</span></span>
                                            </button>
                                            <button id="bid_room_button_{$row.property_id}" type="button"
                                                    class="btn-bid-popup-fix btn-bid-in-room-popup-fix {if $row.check_price} btn-bid-in-room-green-popup {/if} cufon-btn"
                                                    onclick="bid_{$row.property_id}.click(true)" style="">
                                                <span style=""><span>IN ROOM BID</span></span>
                                            </button>
                                        </li>
                                    {else}
                                        <li class="btn-bid-panel-ul-li" >
                                            <button type="button" class="btn-p-pad btn-plus" id="btn-plus" title="+" style="margin-bottom: 0;margin-right: 2px">
                                                <span><span style="font-size: 18px;">+</span></span>
                                            </button>
                                            <button id="bid_room_button_{$row.property_id}" type="button"
                                                    class="btn-bid-popup-fix {if $row.check_price} btn-bid-green-popup {/if} cufon-btn bid-button-bidder "
                                                    onclick="bid_{$row.property_id}.click(true)" style="">
                                                <span><span>BID</span></span>
                                            </button>
                                        </li>
                                    {/if}
                                </ul>
                                <div class="clearthis" style="padding: 0;margin: 0;"></div>
                            </div>
                            <div id="price-pad">
                                <ul>
                                    <li>
                                    {assign var="k" value="0"}
                                    {foreach from = $price_ar_options key = price item = priceShow}
                                        {php}
                                            $this->_tpl_vars['k']++;
                                        {/php}
                                        <button onclick="" class="btn-p-pad btn-p-pad-ie" style="" title="{$price}">
                                            <span><span>{$priceShow}</span></span>
                                        </button>
                                        {if (($k)%3)== 0}
                                            </li><li class="pad-li-{$k}">
                                        {/if}
                                    {/foreach}
                                    </li>
                                </ul>
                            </div>
                            <div class="clearthis" style="padding: 0;margin: 0;"></div>
                            <div id="number-pad" style="display: none; ">
                                <ul>
                                    <li>
                                    {section name=val start=1 loop=10 step=1}
                                        <button class="btn-p-pad btn-p-pad-ie" style="" title="{$smarty.section.val.index}">
                                            <span><span style="font-size: 16px">{$smarty.section.val.index}</span></span>
                                        </button>
                                        {if (($smarty.section.val.index)%3)== 0}
                                            </li><li class="number-li-{$smarty.section.val.index}">
                                        {/if}
                                    {/section}
                                    </li>
                                    <li class="del-plus-btn del-plus-btn-ie" style="margin-bottom: 5px;">
                                        <button type="button" class="btn-p-pad btn-delete-pad" id="btn-delete" title="delete">
                                            <span><span>DELETE</span></span>
                                        </button>
                                        <button type="button" class="btn-bid-popup-fix btn-n-pad-zero-ie" style="" id="btn-zero" title="0">
                                            0
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <div class="clearthis" style="padding: 0;margin: 0;"></div>
                            <div class="btn-pad-content">
                                <ul style="margin-top: 0;">
                                    <li class="btn-pad-content-li">
                                        {if $type_popup == 'agent-block'}
                                            <button type="button" class="btn-p-pad btn-p-pad-ie inl-b"  id="btn-plus" title="+">
                                                <span><span style="font-size: 18px">+</span></span>
                                            </button>
                                        {/if}
                                        <button type="button" class="btn-p-pad btn-p-pad-ie inl-b" style="{if $type_popup != 'agent-block'}float: left;{/if}" id="btn-reset" title="reset">
                                            <span><span style="font-size: 16px"> RESET </span></span>
                                        </button>
                                        <button type="button" onclick="number_pad()" class="{if $type_popup == 'agent-block'}btn-p-pad btn-n-pad{else} btn-bid-popup-fix {/if} f-right-popup btn-number-pad-ie inl-b " style="margin-right: 0">
                                        {if $type_popup == 'agent-block'}
                                            <span style="">
                                                <span style="font-size: 14px">NUMBER <br/> PAD</span>
                                            </span>
                                        {else}
                                            NUMBER PAD
                                        {/if}
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <div class="clearthis" style="padding: 0;margin: 0;"></div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
    <div class="f-right" style="width:auto;padding-left: 10px;">
        <div>
            <div class="grid-content grid-content-{$type_popup}" style="width:585px;">
                <fieldset class="report" style="position: relative;padding: 0 10px 0 10px">
                    <legend id="title_report">BIDS REPORT</legend>
                    <div id="marking" class="marking" style="display:block;"></div>
                    <div id="report-bid" style="{if $row.is_mobile_nexus7 >0}{else} min-height: 175px; {/if}"></div>
                    <div class="btn-report-panel" style="margin-bottom: 15px;">
                        <div class="clearthis"></div>
                        {if $type_popup == 'agent-block'}
                            <div class="btn-grid-content" style="text-align: center;">
                                <button onclick="reloadReportBid('');" class="btn-on-grid btn-grid-active" accesskey="" style="width: 100px; height: 30px;">
                                    <span><span>Bid Report</span></span>
                                </button>

                                <button type="button" onclick="reloadReportRegisterBid('');" class="btn-on-grid" accesskey="" style="width: 130px; height: 30px;margin-right: 5px;">
                                    <span><span>Registered Bid</span></span>
                                </button>

                                <button type="button" onclick="reloadReportNoMoreBid('');" class="btn-on-grid" accesskey="" style="width: 100px; height: 30px;">
                                    <span><span>Bidders out</span></span>
                                </button>

                                <button type="button" class="btn-on-grid" accesskey="" style="width: 155px; height: 30px;margin-right: 0" onclick="reloadLoggedInBid('')">
                                    <span><span>Logged in Bidders</span></span>
                                </button>
                            </div>
                        {/if}
                    </div>
                </fieldset>
            </div>
            <div class="panel-ext" style="text-align: center;width:593px;">
            {if $type_popup == 'agent-block'}
                <div class="inc-content" style="float: right; margin-top: 5px;">
                    <fieldset style="margin-right: 0;">
                        <legend>INCREMENT SETTINGS</legend>
                        <div class="{*content *}content-po" style="">
                            <div id="min_max_mes" class="min_max_mes" style="height: 36px;">
                                Bid Increment set at <br />
                                <label id="lbl-incre-{$row.property_id}">{$row.min_max_increment_mess}</label>
                            </div>
                            <div id="increment_{$row.property_id}" class="tab-content normal-el normal-ell increment-sub" style="">
                                <p id="msg_inc_{$row.property_id}" class="message-box message-box-v-ie" style="margin-bottom:4px;display:none"></p>
                                <div class="div-normal-el inc-panel inc-panel-ie" style="{if $row.is_mobile_nexus7} margin: 0 0 2px 0;padding:2px 10px 10px 10px; {else} margin: 17px 0 2px 0 ;padding:15px 10px;{/if} ">
                                    <div id="label-inc" style="font-size: 13px;font-weight: bold;padding: 2px 15px 15px;">
                                        SET INCREMENT
                                    </div>
                                    <script type="text/javascript">
                                        Cufon.replace('#label-inc');
                                    </script>
                                    <form id="frmInc_{$row.property_id}" onsubmit="return false;">
                                        <div style="">
                                            {*<div style="text-align: left;padding-left: 15px;">
                                                <span style="margin-right: 21px;"><b>Min Increment</b></span>
                                                <span style=""><b>Max Increment</b></span>
                                            </div>
                                            <div class="" style="padding: 0 15px;">
                                                <input type="text" name="min-incre" id="min-incre-{$row.property_id}" value="{$row.min_increment}" class="input-text"  style="display: inline-block;width:85px;"/>
                                                <span style="margin: 0 2px;display: inline-block;">-</span>
                                                <input type="text" name="max-incre" id="max-incre-{$row.property_id}" value="{$row.max_increment}" class="input-text" style="display: inline-block;width:85px;"/>
                                            </div>*}

                                            <div style="float: left;text-align: center;margin-right: 15px;">
                                                <div style="font-size: 11px;"><b>Min Inc</b></div>
                                                <div>
                                                    <input type="text" name="min-incre" id="min-incre-{$row.property_id}" value="{$row.min_increment}" class="input-text"  style="display: inline-block;width:85px;"/>
                                                </div>
                                            </div>
                                            <div style="float: right;text-align: center">
                                                <div style="font-size: 11px;"><b>Max Inc</b></div>
                                                <div>
                                                    <input type="text" name="max-incre" id="max-incre-{$row.property_id}" value="{$row.max_increment}" class="input-text" style="display: inline-block;width:85px;"/>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="inc_default_{$row.property_id}" value="{$row.inc_default}"/>
                                        <input type="hidden" id="price_inc_default_{$row.property_id}" value="{$row.price_inc_default}"/>
                                    </form>
                                    <div class="clearthis"></div>
                                    <div class="" style="margin-top: 15px;text-align: left">
                                        <button type="button" class="btn-on-grid" id="btn-set" onclick="count_{$row.property_id}.setIncrement('#frmInc_{$row.property_id}')" style="height: 30px; width: 90px;margin: 0 14px 0 0">
                                            <span style="">
                                                <span style="">SET</span>
                                            </span>
                                        </button>
                                        <button type="button" class="btn-on-grid" id="btn-cancel" onclick="count_{$row.property_id}.resetIncrement();" style="height: 30px; width: 90px;margin: 0">
                                            <span style=""><span style="">RESET</span></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearthis"></div>
                    </fieldset>
                </div>
            {else}
                <div class="inc-content-bidder" style="margin-top: 5px;">
                    <fieldset style="margin-right: 0;">
                        <legend>INCREMENT SETTINGS</legend>
                        <div class="inc-setting-panel" style="padding: 10px 30px;">
                            <div class="f-left">
                                <div class="btn-count-content min_max_mes_bidder_content " style="padding: 21px 10px; height: 110px;">
                                    <div id="min_max_mes_bidder" class="min_max_mes_bidder" style="font-size: 16px;padding: 15px 25px;margin: 20px 0">
                                        Bid Increment set at <br />
                                        <label id="lbl-incre-{$row.property_id}">{$row.min_max_increment_mess}</label>
                                    </div>
                                </div>
                            </div>
                            <div id="increment_{$row.property_id}" class="" style="float: right;">
                                <p id="msg_inc_{$row.property_id}" class="" style="margin-bottom:4px;display:none"></p>
                                <div class="btn-count-content btn-count-content-mobile" style="padding: 10px 20px;">
                                    <div style="">
                                        <div id="label-inc1" style="font-size: 15px; font-weight: bold; padding: 0 15px 15px;">
                                            Will you take? (drop Increment)
                                        </div>
                                        <script type="text/javascript">
                                            Cufon.replace('#label-inc1');
                                        </script>
                                        <div style="margin: 0;">
                                            <input class="input-text" id="require_{$row.property_id}" type="text" value="" style="width: 175px; height: 30px;"/>
                                        </div>
                                        <button type="button" class="btn-on-grid btn-inc-panel" id="btn-require" style="width: 100px; height: 35px; display: inline-block; margin-top: 20px; margin-bottom: 6px;">
                                            <span><span style="">SUBMIT</span></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="clearthis"></div>
                        </div>
                        <div class="clearthis"></div>
                    </fieldset>
                </div>
            {/if}
                <div class="btn-f" style="{if $type_popup == 'agent-block'}float: left;{/if}">
                    {if $type_popup == 'agent-block'}
                        <div style="margin-top: 8px;" class="fn-content">
                            <fieldset style="padding:0 5px" class="fs-final-count">
                                <legend>FINAL COUNTS</legend>
                                <div class="content-po" style="{if $row.is_mobile_nexus7 > 0} padding: 0 5px 5px 5px; {else}padding: 5px;{/if}">
                                    <div id="countdown_{$row.property_id}" class="tab-content normal-el" style="{if $row.is_mobile_nexus7 >0} {else} padding-bottom: 14px; {/if}">
                                        <div class="btn-count-content btn-count-content-mobile" style=" padding: 5px 20px;{if $row.is_mobile_nexus7 >0} padding: 3px 20px !important; {else} padding: 5px 20px;{/if}">
                                            <div style="text-align: center;">
                                            {*<span><b>ACTION:</b></span>*}
                                                <div class="">
                                                    <button type="button" class="btn-action-g" onclick="count_{$row.property_id}.step(1)">
                                                        <span><span>G1</span></span>
                                                    </button>
                                                    <button type="button" class="btn-action-g" onclick="count_{$row.property_id}.step(2)" >
                                                        <span><span>G2</span></span>
                                                    </button>
                                                    <button type="button" class="btn-action-g" onclick="count_{$row.property_id}.step(3)" >
                                                        <span><span>G3</span></span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="clearthis"></div>
                                            <div class="" style="text-align: center;margin-top: 10px">
                                                <button type="button" class="btn-action-agent btn-action-passedin f-left"
                                                        onclick="count_{$row.property_id}.step('passedin')">
                                                    PASSED <br /> IN</button>
                                                <button type="button" class="btn-action-agent btn-action-sold"
                                                        onclick="count_{$row.property_id}.step('sold')" >
                                                    SOLD</button>
                                                <button type="button" class="btn-action-agent btn-action-reset"
                                                        onclick="count_{$row.property_id}.step('reset')" >
                                                    RESET</button>
                                                <div class="clearthis"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    {/if}
                        <div class="action-content">
                        {if $type_popup == 'agent-block'}
                            <fieldset style="min-height: 50px;margin: 0 0 0 0;{if $row.is_mobile_nexus7 > 0} padding-bottom: 8px; {/if}" class="fs-action-ie">
                                <legend>ACTION</legend>
                                <div class="action-panel-agent" style="{if $row.is_mobile_nexus7 > 0} padding: 0; {else} padding: 16px 0;{/if}">
                                    <div style="text-align: center;padding: 0 5px;">
                                        <button type="button" class="btn-action-panel-fix btn-action-panel-pre f-left-fix" style="display: inline-block;" onclick="count_{$row.property_id}.step('pre_amble')">
                                            <span><span>Pre Amble</span></span>
                                        </button>
                                        <button type="button" class="btn-action-panel-fix btn-action-panel-start btn-action-panel-start-mobile" style="display: inline-block;" onclick="count_{$row.property_id}.step('start')">
                                            <span><span>Start <br /> Auction</span></span>
                                        </button>

                                        {if $row.is_mobile > 0}
                                        	{*<a href="http://www.bidrhino.com.au/{$row.property_id}/0">Audio</a>*}
                                            <a href="http://www.bidrhino.com.au/{$row.property_id}/0/0" style="color: #E0C046">
                                            <button type="button" class="btn-action-panel-fix btn-action-panel-audio f-right-fix" style="display: inline-block;position: relative;margin-right: 0" id="record_btn">
                                                <span><span>AUDIO</span></span>
                                            </button>
                                            </a>
                                        {else}
                                            <button type="button" class="btn-action-panel-fix btn-action-panel-audio f-right-fix" style="display: inline-block;position: relative;margin-right: 0" id="record_btn">
                                                <span><span>AUDIO</span></span>
                                            </button>
                                        {/if}
                                    </div>
                                </div>
                                <div class="clearthis" style="padding: 0;margin: 0"></div>
                            </fieldset>
                        {else}
                            <fieldset style="min-height: 50px;margin: 0">
                                <legend>ACTION</legend>
                                <div class="action-panel-bidder action-panel-bidder-{$type_popup}" style="{if $row.is_mobile_nexus7 > 0} padding: 10px 0; {/if}">
                                    <div style="text-align: center">
                                        {if !$no_more_bid}
                                            <button type="button" class="btn-action-panel-fix btn-action-panel-bidder-nmbid  inl-b" style="margin-right: 5px" onclick="bid_{$row.property_id}.pauseBid()" id="popup_btn_no_{$row.property_id}">
                                                <span><span >NO MORE BID</span></span>
                                            </button>
                                        {/if}
                                        {if $row.is_mobile > 0}
                                        	<a href="http://www.bidrhino.com.au/{$row.property_id}/1/{php} echo @$_SESSION['agent']['id'];{/php}" style="color: #E0C046" >
                                            <button type="button" class="btn-action-panel-fix btn-action-panel-bidder-audio inl-b" style="position: relative;" id="play_btn">
                                                <span><span>AUDIO</span></span>
                                            </button>
                                            </a>
                                        {else}
                                            <button type="button" class="btn-action-panel-fix btn-action-panel-bidder-audio  inl-b" style="position: relative;" id="play_btn">
                                                <span><span>AUDIO</span></span>
                                            </button>
                                        {/if}
                                    </div>
                                </div>
                            </fieldset>
                        {/if}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<a href="javascript:void(0)" id="ipad-anchor"></a>
<script type="text/javascript">
    var property_id = "{$row.property_id}";
	var agent_id = "{php} echo @$_SESSION['agent']['id'];{/php}";
	var owner_ar = [{$row.owner}];
	var is_mobile = {$row.is_mobile};
	var is_mobile_nexus7 = {$row.is_mobile_nexus7};
    {literal}
    function LoadingMark(id){
        jQuery(id).show();
    }
    function closeLoadingMark(id){
        jQuery(id).hide();
    }
    jQuery(document).ready(function() {
        self['count_'+property_id].reloadBidReport = setInterval("refresh()",10000);
        jQuery('[name=min-incre]','#frmInc_' + property_id).val(
                format_price($('#min-incre-' + property_id).val(),
                        '#min-incre-' + property_id)
        );

        jQuery('[name=max-incre]','#frmInc_' + property_id).val(
                format_price($('#max-incre-' + property_id).val(),
                        '#max-incre-' + property_id)
        );
        if(format_price($('#max-incre-' + property_id).val()) == '$0'){
            jQuery('[name=max-incre]','#frmInc_' + property_id).val("");
        };
        jQuery('#popup_step_option_' + property_id).val(
                format_price($('#popup_step_option_' + property_id).val(),
                        '#popup_step_option_' + property_id)
        );

        jQuery('[name=max-incre]','#frmInc_' + property_id).bind('keyup',function(){
            $('#max-incre-' + property_id).val(this.value);
            this.value = format_price(this.value,'#max-incre-' + property_id);
            if(this.value == "$" || this.value == null || this.value == ""){
                jQuery(this).val("$$"); /*$$ is allow empty value*/
            }
        });

        jQuery('[name=min-incre]').bind('keyup',function(){
            $('#min-incre-' + property_id).val(this.value);
            this.value = format_price(this.value,'#min-incre-' + property_id);
        });
        jQuery('#popup_step_option_' + property_id).bind('keyup',function(){
            {/literal}
            {if $type_popup == 'agent-block'}
            {else}
                 //$('#_popup_step_option_' + property_id).val(this.value);
            {/if}
            {literal}
            //this.value = format_price(this.value,'#_popup_step_option_' + property_id);
        });
        reloadReportBid('');
        $('.btn-grid-content button').bind('click',function(){
           $('.btn-grid-content button').removeClass('btn-grid-active');
           $(this).addClass('btn-grid-active');
        });

    });
    function switch_tabs(obj) {
        var id = obj.attr("rel");
        $('.tab-content').hide();
        $('.tabs-popup a').removeClass("selected");
        $('#' + id).show();
        obj.addClass("selected");
        $('.message-box').hide();
    }

    function reloadReportBid(p){
        $(".tipsy").remove();
        LoadingMark('#marking');
        var url = '/modules/general/action.php?action=loadReportBid' + p;
            $.post(url,{property_id:{/literal}{$row.property_id}{literal},is_nexus7: is_mobile_nexus7},
            function (data) {
                closeLoadingMark('#marking');
                jQuery('#title_report').html("Bidder Report");
                $('#report-bid').html(data);
            },'html');
    }

    function reloadReportNoMoreBid(p){
        $(".tipsy").remove();
        LoadingMark('#marking');
        var url = '/modules/general/action.php?action=loadReportNoMoreBid' + p;
            $.post(url,{property_id:{/literal}{$row.property_id}{literal}},function (data) {
        closeLoadingMark('#marking');
        jQuery('#title_report').html("Bidder Out Report");
        $('#report-bid').html(data);
    },'html');
    }

    function reloadReportRegisterBid(p){
        $(".tipsy").remove();
        LoadingMark('#marking');
        var url = '/modules/general/action.php?action=loadReportRegisterBid' + p;
            $.post(url,{property_id:{/literal}{$row.property_id}{literal}},function (data) {
                closeLoadingMark('#marking');
                jQuery('#title_report').html("Registered Bidder Report");
                $('#report-bid').html(data);
            },'html');
    }

    function reloadLoggedInBid(p){
        $(".tipsy").remove();
        LoadingMark('#marking');
        var url = '/modules/general/action.php?action=loadLoggedInBid' + p;
            $.post(url,{property_id:{/literal}{$row.property_id}{literal}},function (data) {
                closeLoadingMark('#marking');
                jQuery('#title_report').html("Logged In Bidders Report");
                $('#report-bid').html(data);
            },'html');
    }

    function refreshBeforeBid(){
            $('#popup_step_option_{/literal}{$row.property_id}{literal}').val('');
            $('#_popup_step_option_{/literal}{$row.property_id}{literal}').val('');
        $('#remind-box').hide();
    }

    function refresh(){
        var url = '/modules/general/action.php?action=refresh&t=' + new Date().getTime();
        $.post(url,{property_id:{/literal}{$row.property_id}{literal}},function (data) {
            var result = jQuery.parseJSON(data);
            if (result.callbackFnc && result.callbackFnc.length > 0) {
                for (var i = 0; i < result.callbackFnc.length; i++) {
                    if (result.callbackFnc[i] != '' || result.callbackFnc[i] != null) {
                        self[result.callbackFnc[i]]('');
                    }
                }
            }
            /*Report Bid*/
            if (result.nr && $('#report-bid table').attr('lang') == 'report-bid') {
                var lastest_price = $('#report-bid [name=max-bid]').val();
                if (result.nr > lastest_price && typeof lastest_price != 'undefined') {
                    reloadReportBid('');
                    //reloadReportRegisterBid('');
                }
            }
            if (result._nr && $('#report-bid table').attr('lang') == 'report-register-bid') {
                var reg_id = $('#report-bid').find('[name=new_reg]').val();
                if (result._nr > reg_id && typeof reg_id != 'undefined') {
                    reloadReportRegisterBid('');
                    //reloadReportNoMoreBid('');
                }
            }
            if (result.nn && $('#report-bid table').attr('lang') == 'report-no-more-bid') {
                var lastest_id_ = $('#report-bid').find('[name=new_no_more_bids]').val();
                if (result.nn > lastest_id_ && typeof lastest_id_ != 'undefined') {
                    reloadReportNoMoreBid('');
                }
            }

            if (result.nl && $('#report-bid table').attr('lang') == 'report-logged') {
                var lastest_id_ = $('#report-bid').find('[name=new_logged]').val();
                if (result.nl != lastest_id_ && typeof lastest_id_ != 'undefined') {
                    reloadLoggedInBid('');
                }
            }
        });
    }
    {/literal}
    {literal}
    function number_pad(){
        if(jQuery('#number-pad').css('display') != 'none'){
            jQuery('#number-pad').slideUp();
            jQuery('#price-pad').slideDown();
        }else{
            jQuery('#number-pad').slideDown();
            jQuery('#price-pad').slideUp();
        }
    }
    function price_pad(){
        jQuery('#number-pad').slideUp();
        jQuery('#price-pad').slideDown();
    }
    var objFocus = null;
    function getObjFocus(){
        /*return jQuery("*:focus").attr('id');*/
        return objFocus;
    }
    function bindFocus(){
        jQuery('input','.popup-countdown-child').each(function(){
            jQuery(this).bind('focus',function(){
                objFocus = jQuery(this).attr("id");
                jQuery(this).addClass('input-focus');
                jQuery(this).focus();
            })
        })
    }

	/*BEGIN CALCULATE BOARD*/

	var args = {'boardScan' : '#price-pad button, #btn-plus, #btn-reset',
				'boardManualScan' : '#number-pad button, #btn-zero, #btn-delete',
				'maxLimit' : 1000000000};

	var calc = new Calc(args);
	calc.init();
	calc.setupTarget(['#popup_step_option_' + property_id, '#require_' + property_id, '#min-incre-'+ property_id, '#max-incre-'+property_id]);
	calc.addCallbackFnc('bid', function() {});
	calc.addCallbackFnc('delete', function() {});
    calc.addCallbackFnc('reset', function() {
        var url = '/modules/property/action.php?action=getDefaultPrice';
        jQuery.post(url,{property_id:property_id},function(data){
                   var result = jQuery.parseJSON(data);
                   if (result.price){
                       $('#popup_step_option_' + property_id).val(calc.toPrice(result.price));
                       calc.targetObj[calc.targetCurrent] = result.price;
                   }
                });
    });
	calc.addCallbackFnc('maxLimit', function(msg) {
		showMess(msg);
		jQuery('#mess_popup_child').css('zIndex', 102);
	});

	calc.updateNextPrice(function() {
		var v1 = jQuery('p[id^=popup-auc-price]').html();
		var v2 = jQuery('#popup_step_option_' + property_id).val();
		jQuery('#popup_total_option_' + property_id).val(calc.toPrice(calc.toValid(v1) + calc.toValid(v2)));
        {/literal}
            {if $type_popup == 'agent-block'}
                    $('#_popup_step_option_' + property_id).val(calc.toValid($('#popup_total_option_'+property_id).val()));
                {else}
                    $('#_popup_step_option_' + property_id).val(calc.toValid($('#popup_step_option_'+property_id).val()));
            {/if}
        {literal}

	}, 1000);

	// BEGIN WDLoader
	var WDLoader = function () {
	}

	WDLoader.prototype = {
		show : function() {
			closeLoadingPopup();
			showLoadingPopup();
			jQuery('#loading_popup_child').css('zIndex', 103);
		},

		hide : function() {
			closeLoadingPopup();
		}
	}

	var wdloader = new WDLoader();
	// END

	ibb.addCallbackFnc('set_increment_before', function () {
		wdloader.show();
	});

	ibb.addCallbackFnc('set_increment_receive_data', function () {
		wdloader.hide();
	});

	ibb.addCallbackFnc('reset_increment_before', function () {
		wdloader.show();
	});

	ibb.addCallbackFnc('reset_increment_receive_data', function () {
		wdloader.hide();
	});

	/*BEGIN PROPOSE INCREMENT*/

	args = {'submitBtn' : '#btn-require',
			'requireTxt' : '#require_' + property_id,
			'incTxt' : '#min-incre-' + property_id,
			'maxTxt' : '#max-incre-' + property_id,
			'propertyId' : property_id,
			'fromId' : agent_id};

	var proposeInc = new ProposeIncrement(args);
	proposeInc.init();

	proposeInc.addCallbackFnc('propose_require_before', function() {
		wdloader.show();
		//show waiting
	});

	proposeInc.addCallbackFnc('propose_require_after', function(data) {
		wdloader.hide();
		if (data.success && data.success == 1) {
			jQuery('#ialert_popup').remove();
			jQuery('#ialert_popup_child').remove();
			var ialert = new iAlert();
			//ialert.iconAlert = '';
			//ialert.topTool = '<span id="btnclosex" onclick="proposeInc.callBackObjAr[\'ialert\'].hide()">x</span>';
			ialert.msg = 'Your setting increment has been sent.';
			ialert.init();
			ialert.show();
			jQuery('#' + ialert.id + '_child').css('zIndex', 102);
			var t = setTimeout(function() {
				jQuery('#ialert_popup_child').fadeOut('slow', function() {
					jQuery('#ialert_popup_child').remove();
					jQuery('#ialert_popup').remove();
				});
			}, 2000);
		}
		//hide waiting
	});

	proposeInc.addCallbackFnc('propose_accept_before', function() {
		//show waiting
	});

	proposeInc.addCallbackFnc('propose_accept_after', function(data) {
		/*
		from_id, to_id, property_id, amount
		---
		set value and set process
		*/
		if (data.success && data.success == 1) {
			var min_val = calc.toValid(jQuery('#min-incre-' + data.property_id).val());
			var max_val = calc.toValid(jQuery('#max-incre-' + data.property_id).val());

			if (data.amount > max_val && max_val >= min_val) {
				jQuery('#max-incre-' + data.property_id).val(formatCurrency(data.amount));
			} else {
				jQuery('#min-incre-' + data.property_id).val(formatCurrency(data.amount));
			}

			jQuery('#popup_step_option_' + data.property_id).val(formatCurrency(data.amount));
			self['count_' + data.property_id].setIncrement('#frmInc_' + data.property_id);
		}
		proposeInc.callBackObjAr['ialert'].delCallbackFnc();
		proposeInc.callBackObjAr['ialert'].addCallbackFnc('hide_in', function () {proposeInc.isShowed = false;});
		proposeInc.callBackObjAr['ialert'].hide();
		//hide waiting
	});

	proposeInc.addCallbackFnc('propose_refuse_before', function() {
		//show waiting
	});

	proposeInc.addCallbackFnc('propose_refuse_after', function(data) {
		if (data.success && data.success == 1) {

		}
		proposeInc.callBackObjAr['ialert'].delCallbackFnc();
		proposeInc.callBackObjAr['ialert'].addCallbackFnc('hide_in', function () {proposeInc.isShowed = false;});
		proposeInc.callBackObjAr['ialert'].hide();
		// hide waiting
	});

	proposeInc.addCallbackFnc('propose_finish_after', function(data) {
		if (data.success && data.success == 1) {
		}
		proposeInc.isShowed = false;
		//set min-increment's value, max-increment's value to label
	});


	if (is_mobile > 0) {
		var ipad = new iPad({'targetRef' : '#ipad-anchor'});
		ipad.init();
		ipad.setupTarget(['#popup_step_option_' + property_id, '#require_' + property_id, '[name=min-incre]', '#frmInc_' + property_id + '  input[name=max-incre]']);
	}



	self['bid_'+ property_id].addCallbackFnc('bid_before',function(obj){
         return {money_step:jQuery('#_popup_step_option_'+property_id).val()}
    });
    self['bid_' + property_id].addCallbackFnc('getBid_before',function(obj){
		if (obj.propose_increment) {
			for (var i in obj.propose_increment) {
				// FOR VENDOR

				//if (obj.propose_increment[i].to_id == agent_id && proposeInc.isShowed == false && obj.propose_increment[i].type_approved == 0) {
				if (jQuery.inArray(agent_id, owner_ar) >= 0  && proposeInc.isShowed == false && obj.propose_increment[i].type_approved == 0) {
					proposeInc.toId = obj.propose_increment[i].from_id;

					jQuery('#ialert_popup').remove();
					jQuery('#ialert_popup_child').remove();
					var ialert = new iAlert();
					//ialert.iconAlert = '';
					ialert.bottomTool = '<button class="btn-red" onclick="proposeInc.accept()"><span><span>Accept</span></span></button>';
					ialert.bottomTool += '&nbsp;';
					ialert.bottomTool += '<button class="btn-red" onclick="proposeInc.refuse()"><span><span>Rejected</span></span></button>';

					ialert.msg = 'New bid increment : ' + formatCurrency(obj.propose_increment[i].amount) + '.';
					ialert.msg += '<br/>';
					ialert.msg += 'From bidder : ' + obj.propose_increment[i].fullname + '.';

					ialert.init();
					ialert.show();

					jQuery('#' + ialert.id + '_child').css('zIndex', 102);
					proposeInc.isShowed = true;
					proposeInc.callBackObjAr['ialert'] = ialert;
				}

				// FOR BIDDER
				if (obj.propose_increment[i].from_id == agent_id && proposeInc.isShowed == false && obj.propose_increment[i].type_approved >= 1 && obj.propose_increment[i].type_approved <= 2) {

					jQuery('#ialert_popup').remove();
					jQuery('#ialert_popup_child').remove();
					var ialert = new iAlert();
					//ialert.iconAlert = '';
					ialert.topTool = '<span id="btnclosex" onclick="proposeInc.callBackObjAr[\'ialert\'].hide()">x</span>';

					ialert.msg = 'New bid increment : ' + formatCurrency(obj.propose_increment[i].amount) + '.';
					ialert.msg += '<br/>';
					ialert.msg += '<center><font style="font-weight:bold;font-size:25px;color:#980000">' + obj.propose_increment[i].label_approved + '</font></center>';

					ialert.init();
					ialert.show();

					jQuery('#' + ialert.id + '_child').css('zIndex', 102);
					proposeInc.isShowed = true;
					proposeInc.callBackObjAr['ialert'] = ialert;
					proposeInc.callBackObjAr['ialert'].delCallbackFnc();
					proposeInc.callBackObjAr['ialert'].addCallbackFnc('hide_in', function () {proposeInc.isShowed = false;});
					if (obj.propose_increment[i].type_approved == 1) {
						//min_increment, max_increment
						jQuery('#popup_step_option_' + property_id).val(formatCurrency(obj.propose_increment[i].amount));
					}
					var args = new Object();
					args.fromId = obj.propose_increment[i].from_id;
					args.toId = obj.propose_increment[i].to_id;
					args.propertyId = obj.propose_increment[i].property_id;
					proposeInc.finish(args);

				}
			};
		}

		if (proposeInc.isShowed == false && obj.win_info && obj.win_info.agent_id == agent_id ) {
			var ialert = new iAlert();
			ialert.iconAlert = '';
			ialert.topTool = '<span id="btnclosex" onclick="proposeInc.callBackObjAr[\'ialert\'].hide()">x</span>';

			ialert.msg = '<center>';
			ialert.msg += '<font style="font-weight:bold;font-size:25px;color:#980000">Congratulations!</font>';
			ialert.msg += '<br/>';
			ialert.msg += 'You are the winning bidder and as the Highest bidder, you are buying this property.';
			ialert.msg += '<br/>';
			ialert.msg += 'Please contact the Managing Agent.';
			ialert.msg += '<br/>';
			ialert.msg += '</center>';

			ialert.msg += '<center>';
			ialert.msg += '<table>';

			ialert.msg += '<tr><td>Agent name</td><td> : ' + obj.win_info.agent_fullname + '</td></tr>';
			ialert.msg += '<tr><td>Phone</td><td> : ' + obj.win_info.agent_phone + '</td></tr>';
			ialert.msg += '<tr><td>Address</td><td> : ' + obj.win_info.agent_address + '</td></tr>';

			ialert.msg += '</table>';
			ialert.msg += '</center>';

			ialert.init();
			ialert.show();

			jQuery('#' + ialert.id + '_child').css('zIndex', 102);
			proposeInc.isShowed = true;
			proposeInc.callBackObjAr['ialert'] = ialert;
			proposeInc.callBackObjAr['ialert'].delCallbackFnc();
			proposeInc.callBackObjAr['ialert'].addCallbackFnc('hide_in', function () {proposeInc.isShowed = false;});

			var args = new Object();
			args.price = obj.win_info.price;
			args.property_id = obj.win_info.property_id;
			args.agent_id = obj.win_info.agent_id;
			jQuery.post('/modules/general/action.php?action=win_finish', args, function (data) {}, 'html');
		}

		if (obj.min_increment || obj.max_increment) {
			var min_val = calc.toValid(obj.min_increment);
			var max_val = calc.toValid(obj.max_increment);
			var lbl_val = 'none';
			if (min_val > 0 && max_val > 0) {
				lbl_val = formatCurrency(obj.min_increment) + ' to ' + formatCurrency(obj.max_increment);
			} else if (min_val > 0) {
				lbl_val = formatCurrency(obj.min_increment) + ' (min)';
			} else if (max_val > 0) {
				lbl_val = formatCurrency(obj.max_increment) + ' (max)';
			}

			jQuery('#lbl-incre-' + property_id).html(lbl_val);
            var step_val = calc.toValid(jQuery('#popup_step_option_' + property_id).val());
            if (step_val < min_val && min_val > 0) {
                jQuery('#popup_step_option_' + property_id).val(calc.toPrice(min_val));
            }
            if (step_val > max_val && max_val > 0) {
                jQuery('#popup_step_option_' + property_id).val(calc.toPrice(max_val));
            }

			if (calc.targetCurrent != '#min-incre-' + property_id && calc.targetCurrent != '#max-incre-' + property_id) {
				if (obj.min_increment) {
					jQuery('#min-incre-' + property_id).val(formatCurrency(obj.min_increment) = '$0' ? " " : formatCurrency(obj.min_increment) );
				}

				if (obj.max_increment) {
					jQuery('#max-incre-' + property_id).val(formatCurrency(obj.max_increment) = "$0" ? " " : formatCurrency(obj.max_increment)
                    );
				}
			}

			/*if (calc.targetCurrent != '#popup_step_option_' + property_id) {
				var step_val = calc.toValid(jQuery('#popup_step_option_' + property_id).val());
				if (step_val < min_val) {
                    jQuery('#popup_step_option_' + property_id).val(calc.toPrice(min_val));
					//jQuery('#popup_step_option_' + property_id).val(formatCurrency(obj.min_increment));
				}

				if (step_val > max_val) {
					jQuery('#popup_step_option_' + property_id).val(calc.toPrice(max_val));
				}
			}*/
			//alert(calc.targetCurrent);
		}

		if (is_mobile > 0) {
			if (obj.is_record >= 0) {
				switch (obj.is_record) {
					case 1:
						//Recording
						jQuery('#record_btn').removeClass('btn-action-panel-fix').addClass('btn-action-panel-fix-recording');
					break;
					case 0:
						//Audio
						jQuery('#record_btn').removeClass('btn-action-panel-fix-recording').addClass('btn-action-panel-fix');
					break;
				}
			}

			if (obj.is_play >= 0) {
				switch (obj.is_play) {
					case 1:
						//Playing
						jQuery('#play_btn').removeClass('btn-action-panel-fix').addClass('btn-action-panel-fix-playing');
					break;
					case 0:
						//Audio
						jQuery('#play_btn').removeClass('btn-action-panel-fix-playing').addClass('btn-action-panel-fix');
					break;
				}
			}
		}
	});


	/*BEGIN AUDIO*/
	var args = new Object();
	args.recordBtn = '#record_btn';
	args.playBtn = '#play_btn';
	args.audioRecordContainer = 'audio_record';
	args.audioPlayContainer = 'audio_play';
	args.type = 'rtmp';//rtmp,rtsp
	//args.red5Link = 'rtmp://127.0.0.1/my-test';
	//args.red5Link = 'rtmp://ibbdev.bidRhino.com/live';
	//args.red5Link = 'rtmp://199.195.214.39/live';
	args.red5Link = 'rtmp://54.252.97.107/live';

	jQuery("<div id='" + args.audioRecordContainer + "' style='width:0px;height:0px'></div>").appendTo('body');
	jQuery("<div id='" + args.audioPlayContainer + "' style='width:0px;height:0px'></div>").appendTo('body');

	var audio = new Audio(args);
	audio.init();
	audio.isRecord = false;
	audio.isPlay = false;
	audio.addCallbackFnc('record', function () {
		if (is_mobile > 0) return ;
		if (audio.isRecord == false) {

			//jQuery(args.recordBtn + ' span span').html('Close');

			var iARecord = new iAlert();
			iARecord.topLabel = 'Record Audio';
			iARecord.iconAlert = '';
			iARecord.id = 'ialert_record_popup';
			iARecord.topTool = '<span id="btnclosex" onclick="audio.callBackObjAr[\'ia\'].hide()">x</span>';
			jQuery('#record_1').remove();
			iARecord.msg = '<center>';
			iARecord.msg += '<object id="record_1" width="222" height="145" ';

			if (navigator.appName.indexOf("Microsoft") != -1) {// IE
				iARecord.msg += ' classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"';
			}

			iARecord.msg += '>';

			iARecord.msg += '<param name="movie" value="/utils/flash-player/record/record.swf"/>';

			iARecord.msg += '<param name="allowfullscreen" value="true" />';
			iARecord.msg += '<param name="allowscriptaccess" value="always" />';
			iARecord.msg += '<param name="flashvars" value="info=' + property_id + '" />';
			iARecord.msg += '<embed type="application/x-shockwave-flash" width="222" height="145"';

			iARecord.msg += 'name="record_1" ';
			//iARecord.msg += '  ';
			iARecord.msg += 'src="/utils/flash-player/record/record.swf" ';
			iARecord.msg += 'allowscriptaccess="always" ';
			//iARecord.msg += 'allowscriptaccess="sameDomain"';
			iARecord.msg += 'allowfullscreen="true" ';
			iARecord.msg += 'flashvars="info=' + property_id + '&streamer=' + args.red5Link + '"/>';
			iARecord.msg += '</object>';
			iARecord.msg += '</center>';
			iARecord.init();
			iARecord.show();

			jQuery('#' + iARecord.id + '_child').css('zIndex', 102);
			audio.callBackObjAr['ia'] = iARecord;
		} else {
			try {
				audio.isRecord = false;
				var rc = navigator.appName.indexOf("Microsoft") != -1 ? window['record_1'] : document['record_1'];
				rc.stopRecord('stop');
			} catch (e) {
				//alert(e);
				jQuery('#record_1').remove();
			}
			//jQuery(args.recordBtn + ' span span').html('Audio');
			jQuery(args.recordBtn).removeClass('btn-action-panel-fix-recording').addClass('btn-action-panel-fix');
		}
	});

	//args.type = 'rtmp';//rtmp,rtsp
	//args.red5Link = args.type + '://ibbdev.bidRhino.com/live';
	
	audio.addCallbackFnc('play', function () {
		if (is_mobile > 0) return ;
		if (audio.isPlay == false) {
			audio.isPlay = true;
			//jQuery(audio.playBtn + ' span span').html('PLAYING');
			jQuery(audio.playBtn).removeClass('btn-action-panel-fix').addClass('btn-action-panel-fix-playing');
			
			jQuery('#' + args.audioPlayContainer).html('<embed type="application/x-shockwave-flash" src="/utils/flash-player/jwplayer/player.swf" quality="high" allowfullscreen="true" allowscriptaccess="always" wmode="opaque" flashvars="streamer=' + args.red5Link + '&amp;file=' + property_id + '&amp;type='+args.type+'&amp;fullscreen=true&amp;autostart=true&amp;controlbar=bottom&amp;stretching=exactfit&amp;" style="width: 1px; height: 1px;">');
		} else {
			audio.isPlay = false;
			//jQuery(audio.playBtn + ' span span').html('AUDIO');
			jQuery(audio.playBtn).removeClass('btn-action-panel-fix-playing').addClass('btn-action-panel-fix');
			jQuery('#' + args.audioPlayContainer).html('');
		}
	});
	
	function flashRecord() {
		//Recording
		jQuery(args.recordBtn).removeClass('btn-action-panel-fix').addClass('btn-action-panel-fix-recording');
		if (typeof audio.callBackObjAr['ia'] == 'object') {
			audio.callBackObjAr['ia'].hide();
			audio.isRecord = true;
		}
	}
	function changeBidText(id,ob){
        var obj = jQuery(id);
        if(obj.css('display') != 'none'){
            obj.hide();
            jQuery(ob).html('Show Bid Text Box');
        }else
        {
            /*background-color: white;
            display: none;
            left: 10px;
            margin-top: 10px;
            position: absolute;
            top: 56px;
            width: 320px;*/
            obj.css({'position': 'absolute','background-color':'white','left':'8px','top':'55px','width':'323px','height':'98px'});
            obj.show();
            jQuery(ob).html('Close Bid Text Box');
        }
    }
	/*END AUDIO*/	
    {/literal}	
</script>
