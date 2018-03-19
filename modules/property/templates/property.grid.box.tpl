     <div class="hightlight-top-item">
         <div class="hightlight-top-item-top">
             {if $row.address_short}
                 {$row.address_short}
             {else}
                 {$row.address_full}
             {/if}
         </div>
         <div class="hightlight-top-item-bottom">
            <span class="price-bold">
                <span id="price-bold-{$row.property_id}">{*{$row.price}*}{$row.advertised_price}</span>
                {if in_array($row.pro_type_code,array('ebiddar','bid2stay'))}
                    <span class="period">{$row.period}</span>
                {/if}
                </span>
         </div>
     </div>
    <div class="{if ($row.kind == 1 and $property_kind == 0)}auction-item-highlight auction-item{else}auction-item{/if} pro-item-{$row.property_id}">
        <div class="auc-img-watermark">
            <div class="home_live_img img-big-watermark-{$row.property_id}" style="position: relative; margin-top: 25px;">
                <a {$link_target} href="{$row.detail_link}">
                    <img src="{$MEDIAURL}/{$row.photo_default}" alt="Photo" class="img-gird-box" />
                    {*<img id="img_mark_{$row.property_id}" class="img-watermark" style="display:none" alt=""/>*}
                </a>
            </div>
            <script type="text/javascript">
                AddWatermarkReaXml('#img_mark_rea_xml_{$row.property_id}','{$row.reaxml_status}','{$row.property_id}');
            </script>
            <div class="clearthis"></div>
            <div class="toolbar-img">
                <div class="toolbar-img-cont">
                    <span class="img-num img-num-ie">1/1</span>
                    <span class="icons img-prev img-prev-ie img-prev-ie-lfl" onclick="IS_{$row.property_id}.prev()"></span>
                    <span class="icons img-next img-next-ie img-next-ie-lfl" onclick="IS_{$row.property_id}.next();"></span>
                </div>
            </div>
            <div class="clearthis"></div>

            {*<div class="btn-view-wht" style="width: 300px">
                {assign var= btn_wht_class value="btn-wht-home"}
                {assign var = btn_view_class value = "btn-view"}
                {if $row.check_price and $row.pro_type == 'auction' }
                    {assign var = btn_view_class value = "btn-view-green"}
                    {assign var=btn_wht_class value="btn-wht-home-green"}
                {/if}
                {if $link_target}
                    <button id="btn-wht-{$row.property_id}" class="btn-wht {$btn_wht_class} btn-lan-home" style="float:left !important;margin-right:0px;" onclick="{$row.awl}">
                    </button>
                    <a href="{$row.detail_link}" target="_blank">
                        <button id="view-button-{$row.property_id}" style="float:left;margin-right:0px;" class="{$btn_view_class} btn-view-home"></button>
                    </a>
                {else}
                    <button id="btn-wht-{$row.property_id}" class="btn-wht {$btn_wht_class} btn-lan-home" style="float:left !important;margin-right:0px;" onclick="{$row.awl}">
                        *}{*<span style="font-size:12px;"><span style="font-size:12px;">Add to Watchlist</span></span>*}{*
                    </button>
                    <button id="view-button-{$row.property_id}" style="float:left;margin-right:0px;" class="{$btn_view_class} btn-view-home" onclick="document.location = '{$row.detail_link}'"></button>
                    {if $row.pro_type == 'forthcoming' AND in_array($row.pro_type_code,array('ebidda30'))
                    &&  !($row.buynow_buyer_id > 0) }
                        <input id="buynow-{$row.property_id}" type="button" class="btn-buynow" style="float: left;margin-left: 7px" onClick="pro.buynow('{$row.property_id}','{$row.buynow_price}')" />
                    {/if}
                {/if}
            </div>*}
            <div class="clearthis"></div>
            {assign var = mao_str value = "pro.openMakeAnOffer('#makeanoffer_`$row.property_id`','`$row.property_id`','`$agent_id`')"}
            {assign var = buynow_str value = "pro.buynow('`$row.property_id`','`$row.buynow_price`')"}
            {*{assign var = bid_str value = "PaymentBid(`$row.property_id`)"}*}
            {assign var = bid_str value = "bid_`$row.property_id`.click()"}
            {if $row.confirm_sold == 1}
                {assign var = bid_str value = "return showMess('This property is sold. You can not register to bid.')"}
                {assign var = mao_str value = "return showMess('This property is sold. You can not offer.')"}
                {assign var = buynow_str value = "return showMess('This property is sold. You can not Buy/Rent Now.')"}
            {elseif $row.stop_bid == 1}
                {assign var = bid_str value = "return showMess('This property is sold. You can not register to bid.')"}
            {elseif $row.getTypeProperty == 'live_auction'}
                {assign var = mao_str value = "return showMess('This property is live. You can not offer.')"}
                {assign var = buynow_str value = "return showMess('This property is live. You can not Buy/Rent Now.')"}
            {/if}
            {if $row.buynow_status == 0 AND !in_array($row.pro_type_code,array('ebidda30')) }
                {assign var = buynow_str value = "return showMess('This button is not enabled. You can not Buy/Rent Now.')"}
            {/if}
            {if ($row.buynow_buyer_id > 0)}
                {assign var = buynow_str value = "return showMess('You can not Buy/Rent Now.')"}
            {/if}
            {if $row.buynow_price == "\$0"}
                {assign var = buynow_str value = "return showMess('You can not Buy/Rent Now.')"}
            {/if}

            <div class="button-list" style="padding: 0;">
                <button onclick="pro.addWatchlist('/modules/property/action.php?action=add-watchlist&property_id={$row.property_id}')" class="btt-list btt-list-awl" title="Add to Wishlist"></button>
                <button onclick="document.location='{$row.detail_link}'" class="btt-list btt-list-view" title="View"></button>
                <button onclick="{$mao_str}" class="btt-list btt-list-offer" title="Offer"></button>
            </div>
            <div class="button-list" style="padding: 0;margin-bottom: 10px">
                <button style="width: 97px;background-position: -307px 0;" onclick="registerToTransact('{$row.property_id}','register_bid')" class="btt-list btt-list-register" title="Register"></button>
                {if !$row.isSold &&  !($row.buynow_buyer_id > 0)}
                    <button onclick="{$buynow_str}"  class="btt-list {if in_array($row.pro_type_code,array('ebidda30'))}btt-list-buynow{else}btt-list-rentnow{/if}" title="Buy Now"></button>
                {/if}
                <button onclick="{if $authentic.id>0}showContact('{$authentic.id}','{$authentic.full_name}','{$authentic.email_address}','{$authentic.telephone}','{$row.agent_id}','');{else}showLoginPopup();{/if}" class="btt-list btt-list-contact" title="Contact"></button>
                {$row.mao}
            </div>
            <div class="clearthis"></div>
            <span class="name-home-all" style="margin-left:5px; color:#CC8C04;">
                {$row.show_title}
            </span>
            <div class="clearthis"></div>
            <div style="height: 26px;">
                <div class="detail-icons detail-icons-a">
                    <span style="float:left;"> <b>ID: {$row.property_id}{if $row.kind == 1} - Commercial{/if} </b> </span>
                </div> 
                <div class="detail-icons detail-icons-b">
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
                </div>
            </div>
        </div>
        <div class="desc desc-list">
            <div class="css-word-wrap" style="margin:10px 0;min-height:64px">
                {php}$this->_tpl_vars['row']['description'] = strip_tags($this->_tpl_vars['row']['description']);{/php}
                {$row.description}</div>
        </div>

        <div class="tbl-info-item">
            <ul>
                <li>
                    <div class="col-span-1">{localize translate="Status"}:</div>
                    <div class="col-span-2">
                         <div class="auc-info" id="auc-{$row.property_id}">
                             {if $row.pro_type == 'auction'}
                                 {if $row.isSold}
                                     <p id="auc-time-{$row.property_id}">
                                         {localize translate="Sold"}
                                     </p>
                                 {else}
                                     {if $row.isBlock == 1 || ($row.ofAgent && $row.pro_type_code == 'auction')}
                                         <p id="count-{$row.property_id}">
                                             {$row.set_count}
                                         </p>

                                     {elseif $row.auction_type == 'passedin'}
                                         <p id="auc-time-{$row.property_id}">
                                             {localize translate="Passed In"}
                                         </p>
                                     {else}
                                         <p class="auc-time-{$row.property_id}" id="auc-time-{$row.property_id}">
                                             {*-d:-:-:-*}
                                         </p>
                                     {/if}
                                 {/if}
                                 {*<p class="bid" id="auc-price-{$row.property_id}"
                                    style="font-size:14px; text-align:center;  color:#CC8C04 !important ">
                                     {if $row.stop_bid == 1 or $row.isSold}
                                         {assign var=temp value = 0}
                                         {if $row.stop_bid == 1}
                                             {if $row.bidder == '--'}
                                                 Start Price:
                                                 {assign var=temp value = 1}
                                             {/if}
                                         {/if}
                                         {if !$temp}Last Bid:{/if}

                                     {elseif $row.check_start}
                                         Start Price:
                                     {else}
                                         Current Bid:
                                     {/if}
                                     {$row.price}
                                 </p>*}

                                 {*<p id="auc-bidder-{$row.property_id}">
                                     {if $row.isLastBidVendor}
                                     {else}
                                         {if $row.stop_bid == 1 or $row.transition == true}
                                             {$row.bidder}
                                         {else}
                                             {$row.bidder}
                                         {/if}
                                     {/if}
                                 </p>*}

                             {elseif $row.pro_type == 'sale'}
                                 {localize translate="Active"}
                             {elseif $row.pro_type == 'forthcoming'}{*forthcoming*}
                                 <div>
                                     {if $row.isSold}
                                         <p id="auc-time-{$row.property_id}">
                                             {localize translate="Sold"}
                                         </p>
                                     {else}
                                         {if $row.isBlock == 1}
                                             <p id="auc-time-{$row.property_id}">
                                                 {*-d:-:-:-*}
                                             </p>
                                         {else}
                                             <span>{localize translate="AUCTION STARTS"}: {$row.start_time}</span>
                                         {/if}
                                     {/if}

                                 </div>
                             {*{else}
                             <div align="center" style="position: absolute; top: 198px; margin-left: 55px;">
                                 <p class="time" id="auc-time-{$row.property_id}" style="color:#980000; font-size:16px; font-weight:bold; text-align:center; margin-left:5px; margin-right:5px;">
                                             Passed In
                                 </p>
                                 <span  id="live-fg-price" style="font-size:14px;text-align: center; color:#980000 !important ">{$row.price}</span>
                             </div>*}
                             {/if}
                         </div>
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

        {if $row.isSold }
            <script type="text/javascript">
                {if in_array($row.pro_type_code,array('ebiddar','bid2stay'))}
                    jQuery('#auc-time-'+ {$row.property_id},'Sold');
                    jQuery('#count-'+ {$row.property_id},'Sold');
                {else}
                    jQuery('#auc-time-'+ {$row.property_id},'Leased');
                {/if}

            </script>
        {/if}
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
    </div>
