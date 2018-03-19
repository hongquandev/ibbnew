{literal}
<script type="text/javascript" src="modules/calendar/templates/js/calendar.popup.js"></script>
<script type="text/javascript" src="modules/general/templates/js/calc.js"></script>
<script type="text/javascript" src="modules/general/templates/js/propose-increment.js"></script>
<script type="text/javascript" src="modules/general/templates/js/ialert.js"></script>
<script type="text/javascript" src="modules/general/templates/js/ipad.js"></script>
<script type="text/javascript" src="modules/general/templates/js/audio.js"></script>
<script type="text/javascript">
    var ids = [];
    var pro = new Property();
</script>
{/literal}
{literal}
<script type="text/javascript" languange="javascript">

    function img(obj) {
        jQuery(obj).click();
    }

    function myReport(id) {
        var width = 800;
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
        newwin = window.open(id, 'ibb', params);
        if (window.focus) {
            newwin.focus()
        }
        return false;

    }

    function updatePrice() {

        if (ids.length > 0) {

            for (var ii = 0; ii < ids.length; ii++) {

                var price = document.getElementById('auc-price-' + ids[ii]).innerHTML;
                i = price.indexOf("$");
                price = price.substr(i, price.length - i + 1);
                document.getElementById('price-' + ids[ii]).innerHTML = price;

            }
        }
    }

    function updatePriceTime() {
        updatePrice();
        setInterval("updatePrice()", 1000);
    }
</script>
{/literal}
<div class="tv-show">

{if is_array($data) and count($data) > 0}
    {foreach from = $data key = i item = item}    
    <div class="tv-show-child tv-show-a">
    {*IMAGE*}
    <div class="tv-show-left f-left">
        {if isset($item.photo_default)}
            <div id="photo_{$item.property_id}" class="img-main-watermark" style="position: relative;">
            	
                <img id="photo_main_{$item.property_id}" src="{$MEDIAURL}/{$item.photo_default}" alt="Photo"
                     style="width:428px;height:253px;"/>
                <div class="text-mark">
                    <p class="title">
                        {$item.owner}
                    </p>
                </div>
                
            </div>
        {/if}
        {if isset($item.photo) and is_array($item.photo) and count($item.photo) > 0}
            <div class="img-list-box tv-show-img-list-box" id="img-list-box-{$item.property_id}">
                <div class="tv-show-img-prev" onclick="SS_{$item.property_id}.prev(this);">
                    <span class="tv-show-icon-a icons"></span>
                </div>

                <div class="img-list tv-show-img-list">
                    <div id="img-list-slide">
                        {foreach from = $item.photo key = k item = row}
                            {assign var = active value = ''}
                            {if $row.file_name == $item.photo_default}
                                {assign var = active value = 'active'}
                            {/if}

                            <div id="item-{$k}-{$item.property_id}" class="item {$active}" onclick="javascript:void(0)"
                                 onmouseover="SS_{$item.property_id}.item_click(this,'#item-{$k}-{$item.property_id}','{$item.property_id}','{$item.photo_count}');">
                                <img onclick="javascript:void(0)" src="{$MEDIAURL}/{$row.file_name}" alt="photos"
                                     style="width:123px;height:93px"/>
                            </div>
                        {/foreach}
                    </div>
                </div>

                <div class="tv-show-img-next" onclick="SS_{$item.property_id}.next(this);">
                    <span class="tv-show-icon-b icons"></span>
                </div>
                <div class="clearthis"></div>
            </div>
            <script type="text/javascript">
                var SS_{$item.property_id} = new SlideShow2('#img-list-box-' + '{$item.property_id}', '#photo_{$item.property_id} ' + '#photo_main_' + '{$item.property_id}');
            </script type="text/javascript">
            <script type="text/javascript">{*SlideShow.init('#img-list-box-' + '{$item.property_id}','#photo_main_' + '{$item.property_id}')*}</script>
            {else}
            <div class="img-list-box tv-show-img-list-box">
                <div class="img-prev tv-show-img-prev">
                    <span class="tv-show-icon-a icons"></span>
                </div>

                <div class="img-list tv-show-img-list">
                    <div id="img-list-slide2">
                        <div class="tv-show-item-active"><a><img src="{$item.photo_default_thumb}" alt="photos"
                                                                 style="width:123px;height:93px"/></a></div>
                    </div>
                </div>

                <div class="img-next tv-show-img-next">
                    <span class="tv-show-icon-b icons"></span>
                </div>
                <div class="clearthis"></div>
            </div>
        {/if}
    </div>

    <!--begin f-right-->
    <div class="tv-show-right f-right">
        {if $item.pro_type == 'forthcoming' || $item.stop_bid == 1}
        <div class="tv-show-top tv-forth-height">
            <div class="tv-show-a-left">
                <div class="tv-show-block-a">
                    <div class="tv-show-propertyid">
                        <strong>Property ID: {$item.property_id} {if $item.kind == 1} - Commercial{/if} </strong>
                    </div>
                    <div class="tv-show-detail-icons detail-icons">
                        {if $item.kind != 1 }
                            <span class="bed icons" id="bed_ic1">{$item.bedroom_value}</span>
                            <span class="bath icons" id="bed_ic2">{$item.bathroom_value}</span>
                        {/if}
                        {if $item.parking == 1}
                            <span class="car icons" id="bed_ic3">{$item.carport_value}</span>
                        {/if}
                    </div>
                    {*<div class="tv-show-oi"><span class="tv-show-pfi-home"> Open for Inspection: {$item.o4i}</span></div>*}
                </div>
                <div class="clearthis"></div>

                <div class="tv-show-block-b">
                    <div class="tv-show-time">{$item.title}</div>
                    <span class="price-bold f-right" id="price-{$item.property_id}">{$item.price}</span>
                </div>
                <div class="clearthis"></div>

                <div class="tv-show-view-visits">
                    <span class="tv-show-visits">VISITS: {$item.views}</span>
                    {if $item.pro_type == 'auction'}
                        <span style="float: right;" >BIDS: <span id="bid-no-{$item.property_id}">{$item.bids}</span></span>
                    {/if}
                </div>
            </div>
            <div class="clearthis"></div>

            <div class="tv-show-address" id="tv-show-address">{$item.address_full}</div>
            <div class="tv-show-description word-wrap-all word-justify"
                 id="tv-show-description">{$item.description}</div>
        </div>
            {else}
        <div class="tv-show-top tv-live-height">
            <div class="tv-show-a-left">
                <div class="tv-show-block-a">
                    <div class="tv-show-propertyid">
                        <strong>Property ID: {$item.property_id} {if $item.kind == 1} - Commercial{/if}</strong>
                    </div>
                    <div class="tv-show-detail-icons detail-icons">
                        {if $item.kind != 1}
                            <span class="bed icons" id="bed_ic1">{$item.bedroom_value}</span>
                            <span class="bath icons" id="bed_ic2">{$item.bathroom_value}</span>
                        {/if}
                        {if $item.parking == 1}
                            <span class="car icons" id="bed_ic3">{$item.carport_value}</span>
                        {/if}

                    </div>
                    {*<div class="tv-show-oi"><span class="tv-show-pfi-home"> Open for Inspection: {$item.o4i}</span>
                    </div>*}
                </div>
                <div class="clearthis"></div>

                <div class="tv-show-block-b">
                    <div class="tv-show-time">{$item.title}</div>
                    <span class="price-bold f-right" id="price-{$item.property_id}">{$item.price}</span>
                </div>
                <div class="clearthis"></div>

                <div class="tv-show-view-visits">
                    <span class="tv-show-visits">VISITS: {$item.views}</span>
                    {if $item.pro_type == 'auction'}
                        <span style="float: right;" >BIDS: <span id="bid-no-{$item.property_id}"> {$item.bids}</span></span>
                    {/if}
                </div>
            </div>
            <div class="clearthis"></div>

            <div class="tv-show-address" id="tv-show-address">{$item.address_full}</div>
            <div class="tv-show-description word-wrap-all word-justify"
                 id="tv-show-description">{$item.description}</div>
        </div>
        {/if}
    <div class="clearthis"></div>

    <div class="tw-face">
    	
        <iframe allowtransparency="true" frameborder="0" scrolling="no"
                src="//platform.twitter.com/widgets/tweet_button.html"
                style="width:57px; height:20px;float:left;margin: 2px 4px 0px 0px;">
        </iframe>
       
        <img src="{$item.photo_facebook}" width="1" height="1"/>
                
        <div class="fb-like" data-href="{$item.detail_link}" data-send="false" data-width="341" data-show-faces="false"
             data-font="arial" style="z-index: 1;"></div>


    </div>
    <div class="clearthis"></div>

    <div class="tv-show-einfo">
        <span class="tv-show-view-more">{$item.view_more}</span>
                         <span class="tv-show-auc-actions">
                             <a href="javascript:void(0)"
                                onclick="showRegisterBid('{$item.property_id}','registerToBid_blockReport','Bid Report')">&raquo;
                                 BID REPORT</a>
                         </span>

            <button id="view-button-{$item.property_id}" class="{if $item.check_price}btn-view-green{else}btn-view{/if} tv-show-btn-view"
                    onclick="document.location='{$item.detail_link}'"></button>

            {if $item.stop_bid == 1 && !$item.is_mine && $item.confirm_sold == 0}
                <button id="btn-offer-{$item.property_id}" style="float: right;margin-right: 4px;margin-top:0px" class="btn-wht
                        {if $item.check_price}btn-make-an-ofer-green{else}btn-make-an-ofer{/if}"
                        onclick="pro.openMakeAnOffer('#makeanoffer_{$item.property_id}','{$item.property_id}');"></button>
                {$item.mao}
            {/if}
        <div class="tv-show-bid">
        {*{if $item.pro_type == 'auction' && $item.stop_bid == 0 && $item.autobid_enable == 1}
            <span class="tv-show-auc-actions" style="width:55px">
                <a href="javascript:void(0)" onclick="pro.before_openAutoBidForm('#autobid_{$item.property_id}','{$item.property_id}');pro.closeMakeAnOffer('#makeanoffer_{$item.property_id}')">AUTO BID</a>
            </span>
            {$item.abs_tpl}
        {/if}*}
            {if $item.pro_type == 'forthcoming' && $item.register_bid == 0}
                <input type="button" id="bid_button_{$item.property_id}" class="btn-bid-reg"
                       onclick="PaymentBid('{$item.property_id}')" value=""/>
            {/if}
        </div>

    </div>
    <script type="text/javascript">
        var count_{$item.property_id} = new CountDown();
        count_{$item.property_id}.container = 'count-{$item.property_id}';
        count_{$item.property_id}.bid_button = 'bid_button_{$item.property_id}';
        count_{$item.property_id}.property_id = '{$item.property_id}';
        count_{$item.property_id}.button = 'btn_count_{$item.property_id}';
    </script>
    {*ACTION GET BID*}
        {if $item.pro_type == 'forthcoming'}
            <div class="auc-time-bid" id="auc-{$item.property_id}">
                <ul class="forth-time">
                    <li class="li-auc-time-bid">
                        <p class="time" id="auc-time-{$item.property_id}">
                            -d:-:-:-
                        </p>
                    </li>
                </ul>
            </div>
        {else}
            <div class="info-box tv-show-info-box" id="auc-{$item.property_id}">
                <div class="tv-show-buttons-set">
                    <div class="info-box tv-show-info-box">
                        {if $item.stop_bid == 0}
                        <div class="tv-show-vm-b">
                            <div class="auc-actions">
                                <div class="final-counts">
                                    {if $agent_info}
                                        {if $agent_info.type != 'theblock' || !$item.is_mine}
                                            {if !$item.no_more_bids}
                                                <button id="btn_no_{$item.property_id}" class="btn-wht btn-no-more-bid"
                                                        onclick="bid_{$item.property_id}.pauseBid()"></button>
                                            {/if}
                                        {else}{*BUTTON COUNT DOWN*}
                                            <button id="btn_count_{$item.property_id}"
                                                    class="btn-wht btn-make-an-ofer btn-countdown"
                                                    onclick="count_{$item.property_id}.showPopup('agent-block')">
                                                <!--<span><span>MANAGE BID</span></span>-->
                                            </button>
                                            {$item.countdown}
                                        {/if}
                                        {else}
                                        <span class="tv-show-auc-actions">
                                            <a href="/?module=agent&action=login">&raquo;JOIN AUCTION
                                                (as a bidder)</a>
                                        </span>
                                    {/if}


                                    <div id="property_detail_{$item.property_id}">
                                    {if $agent_id > 0 && $item.is_paid}
                                        <input type="hidden" value="{$item.default_inc}"
                                               id="default_inc_{$item.property_id}"/>
                                        {literal}
                                        <script>
                                        {/literal}
                                    var value_show_{$item.property_id} = "{$item.step_init_full}";
                                        {literal}
                                        $(document).ready(function (){
                                            jQuery('#step_option1_{/literal}{$item.property_id}{literal}').val(jQuery("#step_option_{/literal}{$item.property_id}{literal}").val());
                                            jQuery("#step_option_{/literal}{$item.property_id}{literal}_txt").keyup(function(){
                                                this.value = format_price(this.value,'#step_option1_{/literal}{$item.property_id}{literal}','#property_detail_{/literal}{$item.property_id}{literal}');
                                                value_show_{/literal}{$item.property_id}{literal} = this.value;
                                                jQuery("#step_option_{/literal}{$item.property_id}{literal}").val(jQuery('#step_option1_{/literal}{$item.property_id}{literal}').val());
                                            }
                                            );
                                            jQuery("#step_option_{/literal}{$item.property_id}{literal}").change(function(){
                                                jQuery('#step_option1_{/literal}{$item.property_id}{literal}').val(jQuery("#step_option_{/literal}{$item.property_id}{literal}").val());
                                            }
                                            );
                                            jQuery("#step_option_{/literal}{$item.property_id}{literal}_txt").focusout(function (){
                                            if(value_show_{/literal}{$item.property_id}{literal} == '$0')
                                            {
                                                jQuery('#uniform-step_option_{/literal}{$item.property_id}{literal} span').html(jQuery('#default_inc_{/literal}{$item.property_id}{literal}').val());
                                            }
                                            else
                                            {
                                                jQuery('#uniform-step_option_{/literal}{$item.property_id}{literal} span').html(value_show_{/literal}{$item.property_id}{literal});
                                            }
                                            });
                                            jQuery("#step_option_{/literal}{$item.property_id}{literal}_txt").focusin(function (){
                                                this.value = format_price(this.value,'#step_option1_{/literal}{$item.property_id}{literal}','#property_detail_{/literal}{$item.property_id}{literal}');
                                            });
                                        });
                                    </script>
                                    {/literal}
                                        {if $agent_info.type != 'theblock' || !$item.is_mine}
                                            <span class="tv-show-increment">INCREMENT: </span>
                                            <strong class="strong-tv-increment">
                                                <select name="step_option" id="step_option_{$item.property_id}"
                                                        class="input-select" style="width:100%">
                                                    {html_options options = $item.step_options selected = $item.step_init}
                                                </select>
                                            </strong>
                                        {else}
                                            <span class="tv-show-increment">BID PRICE: </span>
                                            <input type="text" value="{$item.now_price}" name="step_options"
                                                   id="step_option_{$item.property_id}_txt" class="input-text"
                                                   style="float:left; width:142px;font-weight:bold;font-size:11px;margin-top: 6px;"/>
                                        {/if}
                                        <input type="hidden" name="step_option1" id="step_option1_{$item.property_id}"
                                               value="{$item.step_init}"/>
                                    {/if}
                                    <div class="tv-show-bid">
                                        {if $item.pro_type == 'auction'}
                                            {assign var = btn_bid_event value = "bid_`$item.property_id`.click()"}

                                            {if $item.is_mine}
                                                <input type="button" id="bid_button_{$item.property_id}"
                                                   class="{if $item.check_price}btn-bid-vendor-green{else}btn-bid-vendor{/if}"
                                                   onclick="{$btn_bid_event}" value=""/>
                                            {else}
                                                {if !$item.register_bid}
                                                    <input type="button" id="bid_button_{$item.property_id}"
                                                       class="{if $item.check_price}btn-bid-green-reg{else}btn-bid-reg{/if}"
                                                       onclick="{$btn_bid_event}" value=""/>
                                                {else}
                                                    <input type="button" id="bid_button_{$item.property_id}"
                                                       class="{if $item.check_price}btn-bid-green{else}btn-bid{/if}"
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

                        <div class="auc-time-bid" id="auc-{$item.property_id}">
                            <ul class="auc-time auction-time-tv-show">
                                <li class="li-auc-time-bid">
                                    <p class="time" id="count-{$item.property_id}" {if $item.check_price}style="color:#007700"{/if}>
                                        {$item.set_count}
                                    </p>
                                </li>
                            </ul>
                            <ul class="auc-bid">
                                <li>
                                    <p class="lasted" id="auc-bidder-{$item.property_id}">
                                        {if $item.stop_bid == 1 or $item.transition == true}
                                            Last Bidder: {$item.bidder}
                                            {else}
                                            Current Bidder: {$item.bidder}
                                        {/if}
                                    </p>

                                    <p class="bid" id="auc-price-{$item.property_id}">
                                        {if $item.stop_bid == 1 || $item.confirm_sold == 1}
                                            Last Bid: {$item.price}
                                        {elseif $item.bids > 0}
                                           Current Bid: {$item.price}
                                        {else}
                                           Start Price: {$item.price}
                                        {/if}

                                    </p>
                                </li>
                            </ul>
                        </div>

                            <script type="text/javascript">
                                {if $item.confirm_sold == 1}
                                    AddWatermark('#img_mark_detail_{$item.property_id}','Sold_detail');
                                {else}
                                    {if $item.stop_bid == 0}
                                        {if $item.check_price}
                                            jQuery('#count-' + {$item.property_id}).addClass('change').css('color', '#007700');
                                            AddWatermark('#img_mark_detail_{$item.property_id}', 'OnTheMarket_detail');
                                        {/if}
                                    {else}
                                        AddWatermark('#img_mark_detail_{$item.property_id}', 'PassedIn_detail');
                                    {/if}
                                {/if}

                            </script>



                    </div>
                </div>
            </div>
        {/if}
    <script type="text/javascript">
        ids.push({$item.property_id});


        var time_{$item.property_id} = {$item.remain_time};
        var bid_{$item.property_id} = new Bid();
            {if $item.pro_type != 'forthcoming'}
            bid_{$item.property_id}.setPriceObj('auc-price-{$item.property_id}');
            bid_{$item.property_id}.setContainerObj('auc-{$item.property_id}');
            {/if}
        bid_{$item.property_id}.setBidderObj('auc-bidder-{$item.property_id}');
        bid_{$item.property_id}.setTimeObj('auc-time-{$item.property_id}');
        bid_{$item.property_id}.setTimeValue('{$item.remain_time}');
        bid_{$item.property_id}.startTimer({$item.property_id});
        bid_{$item.property_id}.setContainer('count-{$item.property_id}');
        bid_{$item.property_id}._options.theblock = true;
        {if $item.pro_type == 'forthcoming'}
            bid_{$item.property_id}._options.transfer = false;
            bid_{$item.property_id}._options.transfer_template = 'theblock';
            bid_{$item.property_id}._options.transfer_container = 'auc-{$item.property_id}';
        {else}
            bid_{$item.property_id}._options.transfer = true;
        {/if}

        /*BEGIN RESET CALLBACK FUNCTION & LISTENER AUTOBID
        BEGIN SET CALLBACK FOR BID, will be called before processing bid*/
        bid_{$item.property_id}.flushCallbackFnc();
            {if $authentic && $authentic.id > 0}
                    bid_{$item.property_id}.addCallbackFnc('bid_before',function (obj){literal}{
                    return {money_step:jQuery('#step_option1_{/literal}{$item.property_id}{literal}').val()}
            });
            /*END*/

            {/literal}
                {if $agent_info.type != 'theblock' || !$item.is_mine}{literal}
                /*BEGIN SELECT PLUGIN*/
                var selectPlugin_{/literal}{$item.property_id}{literal} = new SelectPlugin({'targetId':'step_option_{/literal}{$item.property_id}{literal}','disable_input' : true});
                        selectPlugin_{/literal}{$item.property_id}{literal}.listener();
                /*END*/
                {/literal}
                    {else}
                bid_{$item.property_id}._options.mine = true;
                {/if}
            {/if}
            {literal}



                    if (jQuery('#frmAutoBid_' + ids[0])) {
            {/literal}
            /*bid_{$item.property_id}.flushCallbackFnc();*/

                bid_{$item.property_id}.addCallbackFnc('getBid_before',function(obj){literal}{
                if (typeof obj.out_bidder_id != 'undefined' && obj.out_bidder_id == agent_id) {
        {/literal}
            return pro.listenerStopAutoBid('#frmAutoBid_' + ids[0], ids[0], obj);
            {literal}
            }
            });
            {/literal}

            /*BEGIN SET CALLBACK FOR GETBID, AUTO BID*/
                bid_{$item.property_id}.addCallbackFnc('getBid',function(obj){literal}{
                if (obj.bidder_id != agent_id) {
        {/literal}
            return pro.listenerAutoBid('#frmAutoBid_' + ids[0], ids[0], bid_{$item.property_id});
            {literal}
            }
            });
                /*END*/
            {/literal}


            /*BEGIN SET CALLBACK FOR BID, will be received after bidder bid*/
                bid_{$item.property_id}.addCallbackFnc('bid_after',function(obj){literal}{
            if (obj.bidder_id == agent_id) {
                jQuery('#frmAutoBid_' + ids[0] + ' #is_autobid').val(0);
                jQuery('#reg_autobid_btn').html('Accept');
                pro.closeAutoBidForm('#autobid_' + ids[0]);
                showMess(obj.msg);
            }
        });
            /*END*/
        }
        /*END*/
        {/literal}
    </script>

    <script type="text/javascript">
            {literal}
            /*FOR THE FIRST TIME BIDDER SET AUTOBID SETTINGS (it will send one request to server)*/
                    pro.addCallbackFnc('reg_auto_bid_before',function(obj) {
                    if (obj.autobid) {
            {/literal}
            bid_{$item.property_id}.click();
            {literal}
            }
            });
            {/literal}
    </script>
    <div class="tv-show-detail-info">
        <ul class="tv-show-ul-star">
            <li class="tv-show-li-star">
                {*Livability Rating*}
                     Open for Inspection:
                <div class="f-right span-star" id="frgreen1">
                    {*{$item.livability_rating_mark}*}
                    {$item.o4i}
                </div>
            </li>
        </ul>
        <ul class="tv-show-ul-star">
            <li>
                iBB Sustainability
                <div class="f-right span-star" id="frgreen2">
                    {$item.green_rating_mark}
                </div>
            </li>
        </ul>
    </div>
    <div class="clearthis"></div>
    <div class="email-box tv-show-email-box">
        <ul class="ul-show-email-box">
            <li>
                <span class="span-email-box-a">
                    <a href="javascript:void(0)"
                       onClick="showSendfriend('{$item.property_id}','{$agent_info.email}')">SEND TO A
                        FRIEND</a>
                </span>
                {if $agent_id > 0}
                    <span class="span-email-box-b">
                        <a href="javascript:void(0)"
                           onClick="pro.addWatchlist('/modules/property/action.php?action=add-watchlist&property_id={$item.property_id}')">ADD
                            TO WATCHLIST</a>
                    </span>
                {/if}
            </li>
        </ul>
        <ul>
            <li>
                <span class="span-email-box-a">
                    <a href="javascript:void(0)"
                       onclick="return myReport('modules/property/print.php?action={$action}&id={$item.property_id}')">PRINT
                        BROCHURE </a>
                </span>
                <span class="span-email-box-b">
                    {if !$isLogin}
                        <a  href="javascript:void(0)"
                            onClick="showLoginPopup();">
                            CONTACT VENDOR
                        </a>
                    {else}
                        <a  href="javascript:void(0)"
                            onClick="showContact('{$agent_info.agent_id}','{$agent_info.name}','{$agent_info.email}','{$agent_info.telephone}' ,'{$item.agent_id}','')">
                                CONTACT VENDOR
                        </a>
                    {/if}
                </span>
            </li>
        </ul>
    </div>
    </div>
    <!--f-right-->
    </div>
    {/foreach}
    <script type="text/javascript">
        {literal}
            $(function(){
                jQuery('.btn-bid-green').tipsy({gravity: $.fn.tipsy.autoNS,fallback: " <div style='padding: 5px;text-align: justify'>When the bid button turns green the property is on the market</div>",html: true });
                jQuery('.btn-bid-vendor-green').tipsy({gravity: $.fn.tipsy.autoNS,fallback: " <div style='padding: 5px;text-align: justify'>When the bid button turns green the property is on the market</div>",html: true });
            });
        {/literal}
    </script>
    {$vm_tpl}
{else}
    <div class="message-box message-box-add" style="text-align:center">
        <i>
            Only registered bidders for these properties can see this section.  We will show these properties after the show on Sunday again.
            If you really care and want to join these auctions, feel free to <a href="{$ROOTURL}/contact-us.html"
                                                    style="color:#CC8C04;font-size:16px;font-weight:bold">Contact Us</a> for
            support. Thanks!
        </i>
    </div>
{/if}
</div>
<div style="display:none" id="no_more_bid_msg">{$no_more_bids_msg}</div>
<div id="fb-root"></div>
<script type="text/javascript">
    var confirm_nh = new Confirm_popup();
    updateLastBidder();
</script>
<div id="fb-root"></div>
<script>
    {literal}
	
    window.fbAsyncInit = function() {
    FB.init({appId: '{/literal}{$fb.id}{literal}', status: true, cookie: true,
    xfbml: true});
    };
    (function() {
    var e = document.createElement('script'); e.async = true;
    e.src = document.location.protocol +
    '//connect.facebook.net/en_US/all.js';
    document.getElementById('fb-root').appendChild(e);
    }());
	
    {/literal}
</script>