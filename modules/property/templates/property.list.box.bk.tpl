<ul class="{if ($row.kind == 1 and $property_kind == 0)}pro-list pro-list-highlight{else}pro-list{/if} pro-list-item pro-item-{$row.property_id} ">
    <li style="min-height: 230px;">
        <a href="{$row.detail_link}"><div class="hightlight-top-item">
            <h2 class="hightlight-top-item-left f-left"><span itemprop="itemListElement">{$row.address_full}</span></h2>
            <div class="hightlight-top-item-right f-right">
                <span class="price-bold">
                    <span id="price-bold-{$row.property_id}">{$row.price}</span>{if in_array($row.pro_type_code,array('ebiddar','bid2stay'))}
                    <span class="period">{$row.period}</span>{/if}</span>
            </div>
        </div></a>
        <div class="clearthis"></div>
    
        <div class="i-info f-left i-info-fl-lan">
            {assign var = btn_str1 value = "pro.openMakeAnOffer('#makeanoffer_`$row.property_id`','`$row.property_id`')"}
            {if  isset($db_checkpartner) and $db_checkpartner.type_id == 3}
                {*assign var = btn_str1 value = "return showMess('Access denied. Please login as a vendor or buyer to use this function')"*}
            {/if}
            {$row.mao}
        
            <div class="title">
                <span class="f-left title-span">
                    {*{if !$row.isBlock && !$row.ofAgent}
                        {if $row.pro_type == 'forthcoming' or $row.pro_type == 'auction' }
                            {if $row.auction_type == 'passedin'}
                                {assign var = title value="Auction Ended: `$row.end_time`"}
                            {else}
                                {assign var = title value = "Auction Ends: `$row.end_time` "}
                            {/if}
                        {else}
                            {assign var = title value="For Sale: `$row.suburb`"}
                        {/if}
                        {if ($row.confirm_sold == 1 and $row.pro_type != 'sale') }
                            {assign var = title value="Auction End: `$row.end_time`"}
                        {/if}
                        {$title}
                    {elseif $row.isBlock}
                        *}{*OWNER: *}{*{$row.owner}
                    {else}
                        {$row.auction_title}: *}{*OWNER: *}{*{$row.agent.company_name}
                    {/if}*}
                    {$row.show_title}
                </span>
                <div class="clearthis"></div>
            </div>

            <div class="sr-new-info">
                <p>
                    ID : {$row.property_id}{if $row.kind == 1} - {localize translate="Commercial"}{/if}
                </p>
                <p class="detail-icons">
                	{if $row.kind != 1}
                        {if $row.bedroom_value > 0 }
                            <span class="bed icons">{$row.bedroom_value}</span>
                        {/if}
                        {if $row.bathroom_value > 0}
                            <span class="bath icons">{$row.bathroom_value}</span>
                        {/if}
                    {/if}
                    {if $row.parking == 1}
                        <span class="car icons">{$row.carport_value}</span>
                    {/if}
                    {*<span class="offi-lan" style="float:right;">Open for Inspection: {$row.o4i}</span>*}
                </p>
            </div>
              <div class="desc desc-list">
                <div class="css-word-wrap" style="margin:10px 0;min-height:33px">
                    {php}$this->_tpl_vars['row']['description'] = strip_tags($this->_tpl_vars['row']['description']);{/php}
                    {$row.description}
                </div>
                {if $row.agent && $row.agent.logo != ''}
                  <a href="{seo}?module=agent&action=view-detail-agency&uid={$row.agent.agent_id}{/seo}"><img src="{$MEDIAURL}/{$row.agent.logo}" style="max-width: 290px;width: auto" alt="{$MEDIAURL}/{$row.agent.company_name}" title="Click here to view all property"/></a>
                {/if}
              </div>
            <div class="clearthis"></div>
            {*BM*}
            <div>
            </div>
            {*EM*}
			
            <div class="tbl-info-item">
                <ul>
                    <li>
                        <div class="col-span-1">{localize translate="Status"}:</div>
                        <div class="col-span-2">
                            {if $row.pro_type == 'forthcoming'}
                                {if $row.isBlock == 1}
                                    <div id="auc-{$row.property_id}">
                                        {if $row.isSold}
                                            {if in_array($row.pro_type_code,array('ebiddar','bid2stay'))}
                                                <p>{localize translate="Leased"}  </p>
                                            {else}
                                                <p>{localize translate="Sold"}  </p>
                                            {/if}
                                        {else}
                                            <p style="color: #980000;" id="auc-time-{$row.property_id}">
                                                -d:-:-:-
                                            </p>
                                        {/if}
                                    </div>
                                {else}
                                    <div id="auc-{$row.property_id}">
                                        <p style="color: #980000;">
                                            {localize translate="Auction Starts"}  {$row.start_time}
                                        </p>
                                    </div>
                                {/if}
                            {elseif $row.pro_type == 'auction'}
                                {if $row.isSold}
                                    {if in_array($row.pro_type_code,array('ebiddar','bid2stay'))}
                                        <span> {localize translate="Leased"}  </span>
                                    {else}
                                        <span> {localize translate="Sold"}  </span>
                                    {/if}
                                {else}
                                    {if $row.isBlock || ($row.ofAgent AND $row.pro_type_code == 'auction')}
                                        <span id="count-{$row.property_id}">
                                            {$row.set_count}
                                        </span>
                                    {else}
                                        {if $row.auction_type != 'passedin'}
                                            <span id="auc-time-{$row.property_id}">
                                                -d:-:-:-
                                            </span>
                                        {else}
                                            <span id="auc-time-{$row.property_id}">
                                                {localize translate="Passed In"}
                                            </span>
                                        {/if}
                                    {/if}
                                {/if}
                            {*<div class="tbl-info">
                                <ul class="f-left col1">
                                    <li id="i-time-p" class="i-time" style="margin-right:0px;margin-bottom:0px;*width:190px;*height:38px">
                                       {if $row.isSold}
                                           {if $row.pro_type_code == 'ebiddar'}
                                               <p> Leased </p>
                                           {else}
                                               <p> Sold </p>
                                           {/if}
                                       {else}
                                           {if $row.isBlock || ($row.ofAgent AND $row.pro_type_code == 'auction')}
                                                <p id="count-{$row.property_id}">
                                                    {$row.set_count}
                                                </p>
                                           {else}
                                               {if $row.auction_type != 'passedin'}
                                                <p id="auc-time-{$row.property_id}">
                                                    -d:-:-:-
                                                </p>
                                               {else}
                                               <p id="auc-time-{$row.property_id}">
                                                    Passed In
                                                </p>
                                               {/if}
                                           {/if}
                                       {/if}
                                    </li>
                                </ul>
                                <ul class="f-left col2">
                                    <li class="i-bid" style="margin-bottom:0px">
                                        <p style="padding-left:5px;" class="lasted" id="auc-bidder-{$row.property_id}">
                                            {if $row.isLastBidVendor}
                                                Vendor Bid
                                            {else}
                                                {if $row.stop_bid == 1 or $row.transition == true}
                                                    Last Bidder: {$row.bidder}
                                                    {else}
                                                    Current Bidder: {$row.bidder}
                                                {/if}
                                            {/if}

                                        </p>
                                        <p style="padding-left: 5px;" class="bid" id="auc-price-{$row.property_id}">

                                            {if $row.stop_bid == 1 or $row.transition == true or $row.confirm_sold == 1}
                                                {assign var=temp value = 0}
                                                {if $row.stop_bid == 1}
                                                    {if $row.bidder == '--'}
                                                        Start Price:
                                                        {assign var=temp value = 1}
                                                    {/if}
                                                {/if}
                                                {if !$temp}Last Bid:{/if}

                                            {elseif $row.check_start or $row.bidder == '--'}
                                                Start Price:
                                            {else}
                                                Current Bid:
                                            {/if} {$row.price}
                                        </p>
                                    </li>
                                </ul>
                            </div>*}
                            {elseif $row.pro_type == 'sale'}
                                {localize translate="Active"}
                            {/if}
                        </div>
                        <div class="clearthis clearthis-ie7"></div>
                    </li>
                    <li>
                        <span class="col-span-1">{localize translate="Open For Inspection"}:</span>
                        <span class="col-span-2">
                            <span id="span-inspection-all" class="span-star">{$row.o4i}</span>
                        </span>
                        <div class="clearthis clearthis-ie7"></div>
                    </li>
                    {if !in_array($row.pro_type, array('forthcoming','sale'))}
                    <li>
                        <span class="col-span-1">
                        {if $row.stop_bid == 1 or $row.transition == true or $row.confirm_sold == 1}
                            {assign var=temp value = 0}
                            {if $row.stop_bid == 1}
                                {if $row.bidder == '--'}
                                    {localize translate="Start Price"}:
                                    {assign var=temp value = 1}
                                {/if}
                            {/if}
                            {if !$temp}{localize translate="Last Bid"}:{/if}
                        {elseif $row.check_start or $row.bidder == '--'}
                            {localize translate="Start Price"}:
                        {else}
                            {localize translate="Current Bid"}:
                        {/if}
                        </span>
                        <span class="col-span-2">
                            <span id="auc-price-{$row.property_id}">
                                {$row.price}
                            </span>
                        </span>
                        <div class="clearthis clearthis-ie7"></div>
                    </li>
                    {/if}
                    {if $row.pro_type == 'forthcoming'}
                    {elseif $row.pro_type == 'auction'}
                        <li>
                            <div class="col-span-1">{localize translate="Last Bidder"}:</div>
                            <div class="col-span-2">
                                <p id="auc-bidder-{$row.property_id}">
                                    {if $row.isLastBidVendor}
                                        {localize translate="Vendor Bid"}
                                    {else}
                                        {if $row.stop_bid == 1 or $row.transition == true}
                                            {$row.bidder}
                                        {else}
                                            {$row.bidder}
                                        {/if}
                                    {/if}
                                </p>
                            </div>
                            <div class="clearthis clearthis-ie7"></div>
                        </li>
                    {/if}
                    {*<li>
                        <div class="col-span-1">iBB Sustainability:</div>
                        <div class="col-span-2">
                            <span class="span-star">{$row.green_rating_mark}</span>
                        </div>
                        <div class="clearthis clearthis-ie7"></div>
                    </li>*}
                </ul>
                
            </div>

            {if $row.check_price}
                <script type="text/javascript">
                    var timer_id_ = "{$row.count}";
                    var id_ = {$row.property_id};
                </script>
                {literal}
                <script type="text/javascript">
                    if(typeof timer_id_ == 'string' && timer_id_ != ''){
                        jQuery('#auc-time-'+id_).addClass('change').css('color','#007700');
                        jQuery('#count-'+id_).addClass('change').css('color','#007700');
                    }
                </script>
                {/literal}
            {/if}
            {*<div class="tbl-info">
                <ul class="f-left col1">
                    <li class="li-open-inspection">
                        *}{*<span class="title-star">Livability Rating</span> <span class="span-star"> {$row.livability_rating_mark}</span>*}{*
                        <span class="title-star">Open for Inspection: </span><span id="span-inspection-all" class="span-star">{$row.o4i}</span>
                        <div class="clearthis clearthis-ie7"></div>
                    </li>
                </ul>
                <ul class="f-left col2 {if $row.pro_type_code == 'ebiddar'}ul-disable{/if}">
                    <li>
                        <span class="title-star">iBB Sustainability</span> <span class="span-star">{$row.green_rating_mark}</span>
                        <div class="clearthis clearthis-ie7"></div>
                    </li>
                </ul>
                <div class="clearthis"></div>
            </div>*}
        </div>
        <div class="f-right">
        {if isset($row.photo) and is_array($row.photo) and count($row.photo) > 0}
        
            <script type="text/javascript">var IS_{$row.property_id} = new ImageShow('container_simg_{$row.property_id}',{$row.photo|@count},{$row.property_id},'img_'+{$row.property_id});</script>
        
            <div class="img" id="container_simg_{$row.property_id}" itemscope itemtype="http://schema.org/ImageObject">
                <div class="img-big-watermark img-big-watermark-{$row.property_id}">
                    <a href="{$row.detail_link}">
                    {assign var = i value = 1}
                    {assign var = j value = 0}
                    {foreach from = $row.photo key = k item = rx}
                        {assign var = is_show value = ';display:none;'}
                        {if $rx.file_name == $row.photo_default}
                            {assign var = j value = $i}
                            {assign var = is_show value = ';display:block;'}
                        {/if}
                        <img id="img_{$row.property_id}_{$i}" src="{$MEDIAURL}/{$rx.file_name}" alt="property {$row.property_id}" style="cursor:pointer;width:300px;height:182px{$is_show}" itemprop="contentURL" />
                        {assign var = i value = $i+1}
                    {/foreach}
                        {*<img id="img_mark_{$row.property_id}" class="img-watermark" style="display:none" alt=""/>*}
                     </a>
                </div>

                <div class="toolbar-img toolbar-img-lfl">
                    <span class="img-num img-num-ie">1/{$row.photo|@count}</span>
                    <span class="icons img-prev img-prev-ie img-prev-ie-lfl" onclick="IS_{$row.property_id}.prev()"></span>
                    <span class="icons img-next img-next-ie img-next-ie-lfl" onclick="IS_{$row.property_id}.next();"></span>
                </div>
                {if $j >0}
                    <script type="text/javascript">
                        IS_{$row.property_id}.focus({$j});
                    </script>
                {else}
                    <script type="text/javascript">
                        IS_{$row.property_id}.focus(1);
                    </script>
                {/if}
            </div>
        {else}
            <div class="img">
                <div class="img-big-watermark img-big-watermark-{$row.property_id}">
                    <a href="{$row.detail_link}">
                        <img src="{$MEDIAURL}/{$row.photo_default}" alt="default image" style="width:300px;height:182px;cursor:pointer;" onclick="document.location='{$row.detail_link}'" />
                        {*<img id="img_mark_{$row.property_id}" class="img-watermark" style="display:none" alt=""/>*}
                    </a>
                </div>
                <div class="toolbar-img">
                    <span class="img-num img-num-ie">1/1</span>
                    <span class="icons img-prev img-prev-ie img-prev-ie-lfl" onclick="(typeof IS_{$row.property_id} != 'undefined') ? IS_{$row.property_id}.prev();: return false;"></span>
                    <span class="icons img-next img-next-ie img-next-ie-lfl" onclick="IS_{$row.property_id}.next();"></span>
                </div>
            </div>
        {/if}

        {* Begin Add Watermark on Photo of Property*}
            {if $row.isSold }
                <script type="text/javascript">
                   jQuery('#auc-time-'+ {$row.property_id},'Sold');
                   jQuery('#count-'+ {$row.property_id},'Sold');
                   {if $row.isRent}
                        AddWatermark('#img_mark_' + {$row.property_id}, 'Rent');
                   {else}
                        AddWatermark('#img_mark_' + {$row.property_id}, 'Sold');
                   {/if}
                </script>
            {else}
                {php}
                //print_r($this->_tpl_vars['row']);
                {/php}
                {if $row.check_price And $row.pro_type == 'auction' AND $row.auction_type != 'passedin' }
                    <script type="text/javascript">
                        AddWatermark('#img_mark_' + {$row.property_id},'OnTheMarket');
                    </script>
                {/if}
            {/if}
            {**}
            <script type="text/javascript">
                AddWatermarkReaXml('#img_mark_rea_xml_{$row.property_id}','{$row.reaxml_status}','{$row.property_id}');
            </script>
        {* End Add Watermark on Photo of Property*}

        <div class="sr-new-action-sale-list div-list-box">
            {assign var = btn_wl_event value = "pro.addWatchlist('/modules/property/action.php?action=add-watchlist&property_id=`$row.property_id`')"}
            {assign var = mao_str value = "pro.openMakeAnOffer('#makeanoffer_`$row.property_id`','`$row.property_id`','`$agent_id`')"}
            {if isset($db_checkpartner) and $db_checkpartner.type_id == 3}
                {*assign var = mao_str value = "return showMess('Access denied. Please login as a vendor or buyer to use this function')"*}
            {/if}
            <div class="clearthis"></div>
            <div class="btn-list1">
                {assign var = btn_view_class value = "btn-view"}
                {assign var = btn_wht_class value = "btn-add-to-wtachlist"}
                {assign var = btn_offer_class value="btn-make-an-ofer"}
                {if $row.check_price and $row.pro_type == 'auction' }
                    {assign var = btn_view_class value = "btn-view-green"}
                    {assign var = btn_wht_class value="btn-add-to-wtachlist-green"}
                    {assign var = btn_offer_class value="btn-make-an-ofer-green"}
                {/if}
                <button id="btn-wht-{$row.property_id}" class="btn-wht btn-list-box1 {$btn_wht_class}" onclick="{$btn_wl_event}" >
                    <!--<span><span>ADD TO WATCHLIST</span></span>-->
                </button>

                <button id="view-button-{$row.property_id}" class="{$btn_view_class} f-left btn-view-sale-list btn-list-box2"
                    onclick="document.location='{$row.detail_link}'" >
                </button>

                {*Begin offer button*} {*Disable Offer Button once the auction live*}
                {if !$row.isBlock AND !$row.isSold AND !($row.pro_type == 'forthcoming' AND $row.is_mine) AND $row.pro_type != 'auction'  }
                    <button id="btn-offer-{$row.property_id}" class="btn-wht {$btn_offer_class}" onclick="{$mao_str}" style="{$btn_mao_class};float : left;margin-top: 0">
                    </button>
                    {$row.mao}
                {/if}

                {*End offer button*}

                {if $row.pro_type == 'auction'}
                    {assign var = btn_bid_event value = "bid_`$row.property_id`.click()"}

                    {if $agent_info.type == 'theblock' && $row.isBlock && $row.register_bid}
                        {assign var = btn_bid_event value = $row.popup }
                    {/if}
                    {if !$row.isVendor}
                        {assign var = btn_bid_cls value = "btn-bid"}
                        {if $row.register_bid != true}
                            {assign var = btn_bid_cls value = "btn-bid-reg "}
                            {assign var = style_bid_cls value = "float:left !important"}
                        {/if}
                        {if $row.check_price}
                            {assign var = btn_bid_cls value = "btn-bid-green"}
                            {if $row.register_bid != true}
                                {assign var = btn_bid_cls value = "btn-bid-green-reg "}
                                {assign var = style_bid_cls value = "float:left !important"}
                            {/if}
                        {/if}
                    {else}
                        {assign var = btn_bid_cls value = "btn-bid-vendor"}
                        {if $row.check_price}
                            {assign var = btn_bid_cls value = "btn-bid-vendor-green"}
                        {/if}
                    {/if}
                    {if !$row.isSold AND $row.stop_bid == 0}
                        <button id = "btn_bid_{$row.property_id}" class="{$btn_bid_cls} f-left btn-bid-auc-list btn-list-box4"
                                style="margin-top: 0"
                                onclick="{$btn_bid_event}" >
                        </button>
                    {/if}
                {elseif $row.pro_type == 'forthcoming'}
                    {if !$row.register_bid and !$row.isVendor AND !$row.isSold AND $row.stop_bid == 0}
                        <input type="button" id="bid_button_{$row.property_id}" class="btn-bid-reg" style="margin-top: 0;margin-left: 0;"
                               onclick="PaymentBid({$row.property_id})" value=""/>
                    {elseif $row.is_mine}
                    {*<button id="cancel-button-{$row.property_id}" class="btn-cancel-frond" style="margin-top:5px;float:left;width: 109px;margin-left: 2px" onclick="show_confirm_stop_bidding({$row.property_id},'{$row.cancel_bidding_link}','')">
                        *}{*<span><span>CANCEL BIDDING</span></span>*}{*
                        </button>*}
                    {/if}
                    {if in_array($row.pro_type_code,array('ebidda30')) && !$row.isSold
                    &&  !($row.buynow_buyer_id > 0)  }
                        <input id="buynow-{$row.property_id}" type="button" class="btn-buynow" onClick="pro.buynow('{$row.property_id}','{$row.buynow_price}')" />
                    {/if}
                {/if}
                {$row.btn_open_for_inspection}
                {*<input type="button" class="btn-open-for-inspection f-left"
                       onClick="{if $authentic.id>0}showContact('{$authentic.id}','{$authentic.full_name}','{$authentic.email_address}','{$authentic.telephone}','{$row.agent_id}','');{else}showLoginPopup();{/if}" />*}
            </div>
            <div class="clearthis"></div>
        </div>
        </div>
        <div class="clearthis"></div>
    </li>
</ul>
<div class="clearthis"></div>
