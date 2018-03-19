{literal}
<style type="text/css">

.auctions-box .auctions-list .auction-item .auc-info p.name {
    font-size: 11px;
    margin-bottom: 0px !important;
    min-height: 30px;
    padding: 0 1px 0 4px;
}
.view-search-list {
    margin-left: 45px !important;
}
.auction-item ul {
    width:180px !important;
}
</style>
<script type="text/javascript">
    var pro = new Property();
    var ids = [];

</script>
<script type="text/javascript" src="modules/calendar/templates/js/calendar.popup.js"></script>
<script type="text/javascript" src="modules/general/templates/js/confirm.js"></script>
{/literal}


<div class="auctions-box watchlist-box-mof-gird auctions-box-bids-gird agent-grid-box">
    {*<div class="bar-title">
        <h2>MY PROPERTY BIDS</h2>
        <div class="bar-filter">
             <div class="view-search-list" style="margin-left: 45px;">
                            <span  style="float:left; font-weight:bold; color:#CCCCCC;"> View as : </span>
                                <div style="float:left; margin-left:5px; margin-right:5px;">
                                     <a href="?module=agent&action=view-property_bids" style="color:#666666">
                                            <img src="'../../modules/general/templates/images/list_up.png" style="margin-left:5px;"/>
                                     </a>
                                     <a href="?module=agent&action=view-property_bids&mode=grid" style="color:#666666">
                                        <img src="'../../modules/general/templates/images/grid_selected.png" style="margin-left:5px;" />
                                     </a>

                                </div>
             </div>
        </div>
    </div>*}
    {include file = "`$ROOTPATH`/modules/agent/templates/agent.view.top-bar.tpl"}
    <div class="clearthis"></div>

    <div>
        <div class="toolbar">
            <div class="pager">
                <span>{$review_pagging}</span>
            </div>
        </div>
        <div class="auctions-list">
            <ul>

                 {if isset($message) and strlen($message) > 0}
                    <div class="message-box message-box-comment-ie">{$message}</div>
                 {/if}

            	    {if isset($results) and is_array($results) and count($results)>0}

                	{foreach from = $results key = k item = property}
                         <li>

                            <div class="auction-item {if $property.info.kind == 1}auction-item-highlight{/if}">
                                <div class="title">
                                    <span class="f-left" style="padding: 5px 5px 5px 10px;font-size:12px;"><a href="{$property.info.link}"style="color:#CC8C04;">{$property.info.title}</a></span>
                                    <div class="clearthis"></div>
                                    <div>
                                         <span class="f-left" style="padding-left:10px;color: #CC8C04;"><b>ID : {$property.info.property_id}{if $property.info.kind == 1} - Commercial{/if}</b></span>
                                         <p class="detail-icons" style="float:right;padding-right:10px;padding-top: 2px;color: #CC8C04;">
                                         	{if $property.info.kind != 1}
                                                 {if $property.info.bedroom_value > 0}
                                                     <span class="bed icons">{$property.info.bedroom_value}</span>
                                                 {/if}
                                                 {if $property.info.bathroom_value > 0 }
                                                     <span class="bath icons">{$property.info.bathroom_value}</span>
                                                 {/if}
                                            {/if}
                                            {if $property.info.parking == 1}
                                            <span class="car icons">{$property.info.carport_value}</span>
											{/if}
                                         </p>

                                    </div>
                                    <div class="clearthis"></div>
                                </div>

                                <div class="bid-img-watermark">
                                   {if isset($property.photos) and is_array($property.photos) and count($property.photos)>0}
                                        <script type="text/javascript">
								            var IS_{$property.info.property_id} = new ImageShow('container_simg_{$property.info.property_id}',{$property.photos_count});
                                        </script>
                                        {assign var = i value = 1}
                                    	{foreach from = $property.photos key = k item = row}
                                        	{assign var = is_show value = ';display:none;'}
                                        	{if $i==1}
                                            	{assign var = is_show value = ''}
                                            {/if}
                                            <a href="{$property.info.link}" style="" >
                                        	    <img id="img_{$i}" src="{$MEDIAURL}/{$row.file_name}" alt="img" style="width:180px;height:130px{$is_show}"/>
                                            </a>
                                            {assign var = i value = $i+1}
                                        {/foreach}
                                        {*{if $property.photos_count >0}
                                                <script type="text/javascript">
                                                    IS_{$property.info.property_id}.focus(1);
                                                </script>
                                        {/if}*}
                                        {if $j >0}
                                            <script type="text/javascript">
                                                    IS_{$property.info.property_id}.focus({$j});
                                            </script>
                                        {/if}
                                   {else}
                                        <a href="{$property.info.link}" style="" >
                                            <img src="modules/property/templates/images/search-img.jpg" alt="img" style="width:180px;height:130px"/>
                                        </a>
                                   {/if}
                                    {if $property.info.isBlock}
                                        <img src="/modules/general/templates/images/theblock.png" id="img_mark_block_{$property.info.property_id}" class="watermark" style="width:180px;height:130px;display: block;cursor: pointer;" onclick="document.location='/?module=property&action=view-auction-detail&id={$property.info.property_id}'"/>
                                    {/if}
                                    <a href="{$property.info.link}" style="" >
                                        <span class="wm w-{$property.info.auction_sale_code}"></span>
                                        <img id="img_mark_{$property.info.property_id}" class="watermark" style="width:180px;height:130px;margin: 5px 0px 0px 5px; display: none;"/>
                                        {*<img id="img_ebidda_mark_{$property.info.property_id}" src="{$property.info.ebidda_watermark}" class="watermark_ebidda" width="57" height="49"
                                             style="{if $property.info.ebidda_watermark != '' } display: block ; {else} display: none;{/if}"/>*}
                                    </a>
                                <div class="clearthis"></div>
                                </div>

                                <div class="auc-info" id="auc-{$property.info.property_id}" style="padding: 0px 10px 0px 10px;">
                                    <div class="desc">
                                        {$property.info.full_address}
                                    </div>
                                    {*PRICE*}
                                    {if $property.info.type != 'forthcoming'}
                                    <div class="btn-grid-ie7" align="center" style="position: absolute;bottom:95px;width:200px;right:3px;">
                                        {if $property.info.transition == false }

                                                {if $property.info.isBlock || ($property.info.ofAgent && $property.info.auction_sale_code == 'auction')}
                                                        <p class="acc-sp-ie" id="count-{$property.info.property_id}" style="color: #CC8C04;font-size: 15px; font-weight: bold; text-align: center;margin-top:11px !important;">
                                                               {$property.info.set_count}
                                                        </p>
                                                {else}

                                                        <p style="color:#CC8C04; font-size:15px; font-weight:bold; text-align:center;margin-top:0px;!important" class="time time-auc-grid" id="auc-time-{$property.info.property_id}" >
                                                            -d:-:-:-
                                                        </p>
                                                {/if}
                                        {else}
                                                    <p style="color:#CC8C04; font-size:15px; font-weight:bold; text-align:center;margin-top:0px;!important" class="time time-auc-grid" id="switch-auc-time-{$property.info.property_id}" >
                                                        Switched to {$property.info.transition_to}
                                                    </p>
                                        {/if}
                                        <p class="lastbidder lastbidder-auc-grid"  id="auc-bidder-{$property.info.property_id}-grid" style="font-size:13px; text-align:center;  color:#CC8C04 !important;min-height:30px; " >
                                            {if $property.info.isLastBidVendor}
                                                Vendor bid
                                                {else}
                                                {if $property.info.stop_bid == 1
                                                    or $property.info.confirm_sold
                                                    or $property.info.transition == true}
                                                    Last Bidder: {$property.info.bidder}
                                                {else}
                                                    Current Bidder: {$property.info.bidder}
                                                {/if}
                                            {/if}
                                        </p>

                                        <p  id="auc-price-{$property.info.property_id}" style="margin-top:-13px;font-size:13px; text-align:center;  color:#CC8C04 !important;">

                                            {if $property.info.stop_bid == 1 or $property.info.confirm_sold == true or $property.info.transition == true}
                                                {assign var=temp value = 0}
                                                {if $property.info.stop_bid == 1}
                                                    {if $property.info.bidder == '--'}
                                                        Start Price:
                                                        {assign var=temp value = 1}
                                                    {/if}
                                                {/if}
                                                {if !$temp}Last Bid:{/if}

                                            {elseif $property.info.check_start }
                                                Start Price:
                                            {else}
                                                Current Bid:
                                            {/if} {$property.info.price}
                                        </p>
                                    </div>
                                    <div class="clearthis"></div>
                                    {*END*}
                                    {if $property.info.check_price AND $property.info.transition == false AND $property.info.stop_bid == 0 AND $property.info.confirm_sold == false }
                                        <script type="text/javascript">
                                            var id_ = {$property.info.property_id};
                                            {if $property.info.isBlock || ($property.info.ofAgent && $property.info.auction_sale_code == 'auction')}
                                                var timer_id_ = "{$property.info.set_count}";
                                            {else}
                                                var timer_id_ = "{$property.info.count}";
                                            {/if}
                                        </script>
                                        {literal}
                                        <script type="text/javascript">
                                            if(typeof timer_id_ == 'string' && timer_id_ != '' && timer_id_ != "Sold"){
                                                jQuery('#auc-time-'+id_).addClass('change').css('color','#007700');
                                                jQuery('#count-'+id_).addClass('change').css('color','#007700');
                                            }
                                        </script>
                                        {/literal}
                                    {/if}
                                {else}
                                     <div class="live-price-watchlist" align="center" style="position: absolute;top: 207px;width:180px;text-align: center;">
                                            {if $property.info.isBlock == 1}
                                                <p class="acc-sp-ie" id="auc-time-{$property.info.property_id}" style="color: #CC8C04;font-size: 16px; font-weight: bold; text-align: center;" >
                                                        -d:-:-:-
                                                </p>
                                            {else}
                                            <p style="margin-top: 0px;margin-bottom:5px; color:#CC8C04">{$property.info.title}</p>
                                            {/if}
                                            <span  id="live-fg-price" style="font-size:14px; color:#CC8C04 !important; ">{$property.info.price}</span>
                                        </div>
                                {/if}
                                </div>
                                <div class="auc-info">
                                    <ul class="f-left" style="position: absolute; bottom: 55px;">
                                                   {*<li style="width:180px;">
                                                       <span class="title-star">Livability Rating</span>
                                                       <span class="span-star"> {$property.info.livability_rating_mark}</span>

                                                   </li>*}
                                                   {if !in_array($property.info.auction_sale_code, array('ebiddar','bid2stay'))}
                                                       <li style="width:180px;">
                                                           <span class="title-star">iBB Sustainability</span>
                                                           <span class="span-star">{$property.info.green_rating_mark}</span>
                                                       </li>
                                                   {/if}
                                    </ul>
                                    <div class="clearthis"></div>


                                    <div style="float:right; padding:12px 5px 0px 0px;position: absolute;bottom:42px;right:6px;">
                                            	<a href="javascript:void(0)" style="color:#CC8C04; text-decoration:none" onclick="openNote('{$property.info.property_id}')" > Notes(<span id="note_{$property.info.property_id}">{$property.num_note}</span>)  </a>
                                                {*- <a href="{$property.info.link}" style="color:#990000; text-decoration:none" > View detail </a>*}
                                        {if $property.info.isShowLinkDetail == true}
                                            <a href="{$property.info.link_detail}" style="color:#CC8C04; text-decoration:none">
                                                View Detail
                                            </a>
                                        {/if}
                                        - <a href="javascript:void(0)" onclick="Common.del('Do you really want to remove this property from your property bids list ?','{$property.info.link_del}')" style="color:#CC8C04; text-decoration:none"> Remove </a>
                                    </div>

                                    {*BUTTON*}
                                    <div class="btn-ie7 div-btn-bids">

                                    {if $property.info.confirm_sold == false}
                                        {if $property.info.transition == false or ($property.info.can_offer == true and $property.info.transition == true)}
                                            {assign var = mao_str value = "pro.openMakeAnOffer('#makeanoffer_`$property.info.property_id`','`$property.info.property_id`','$agent_id')"}
                                        {else}
                                            {if $property.info.confirm_sold == false}
                                                {assign var = mao_str value = "showMess(' This property had been switched to `$property.info.transition_to`. You can offer it when this property become live `$property.info.transition_to` !')"}
                                            {/if}
                                        {/if}
                                    {else}
                                        {assign var = mao_str value = "showMess(' This property had been sold !')"}
                                    {/if}
                                        {if !$property.info.confirm_sold}
                                            {if $property.info.check_price == false or( $property.info.transition == true)}
                                                {assign var = btn_offer_class value="btn-make-an-ofer"}
                                                {assign var = btn_bid_class value="btn-bid"}
                                                {if $property.info.isVendor}
                                                    {assign var = btn_bid_class value="btn-bid-vendor"}
                                                {/if}
                                            {else}
                                                {assign var = btn_offer_class value="btn-make-an-ofer-green"}
                                                {assign var = btn_bid_class value="btn-bid-green"}
                                                {if $property.info.isVendor}
                                                    {assign var = btn_bid_class value="btn-bid-vendor-green"}
                                                {/if}
                                            {/if}
                                            <button id="btn-offer-{$property.info.property_id}" class="btn-wht {$btn_offer_class}  btn-mao-ie7 btn-offer-g" onclick="{$mao_str}">
                                                    {*<span><span>Make an Offer</span></span>*}
                                            </button>
                                        {/if}
                                        {$property.info.mao}

                                        {if $property.info.confirm_sold == false}
                                            {if $property.info.transition == false }
                                                {assign var = btn_str value = "bid_`$property.info.property_id`.click()"}
                                                {if ($property.info.remain_time < 0 OR $property.info.stop_bid == 1) and $property.info.auction_sale_code == "auction"}
                                                    {if true }
                                                        <script type="text/javascript">
                                                            jQuery('#auc-time-{$property.info.property_id}').html('Ended');
                                                        </script>
                                                        {php}
                                                        {/php}
                                                        {if $property.info.isLastBidVendor == true OR !$property.info.check_price}
                                                            <script type="text/javascript">
                                                                jQuery('#auc-time-{$property.info.property_id}').html('Passed In');
                                                                jQuery('#img_mark_' + {$property.info.property_id}).attr('src','/modules/general/templates/images/passedin_list.png');
                                                                jQuery('#img_mark_' + {$property.info.property_id}).css('display','block');
                                                                jQuery('#img_mark_fix_' + {$property.info.property_id}).attr('src','/modules/general/templates/images/passedin_list.png');
                                                                jQuery('#img_mark_fix_' + {$property.info.property_id}).css('display','block');

                                                            </script>
                                                        {/if}
                                                    {/if}
                                                    {else}
                                                    {if $property.info.check_price and $property.info.type == "live"}
                                                        <script type="text/javascript">
                                                            /*AddMark('#img_mark_' + "{$property.info.property_id}","OnTheMarket");
                                                            AddMark('#img_mark_fix_' + "{$property.info.property_id}","OnTheMarket");*/
                                                            jQuery('#img_mark_' + {$property.info.property_id}).attr('src','/modules/general/templates/images/onthemarket_list.png');
                                                            jQuery('#img_mark_' + {$property.info.property_id}).css('display','block');
                                                            jQuery('#img_mark_fix_' + {$property.info.property_id}).attr('src','/modules/general/templates/images/onthemarket_list.png');
                                                            jQuery('#img_mark_fix_' + {$property.info.property_id}).css('display','block');
                                                        </script>
                                                    {/if}
                                                {/if}
                                                {else}
                                                {if $property.info.transition_code != 'private_sale'}
                                                    {assign var = btn_str value = "showMess(' This property had been switched from Auction to `$property.info.transition_to`. You can bid it when this property become live auction !')"}
                                                    {else}
                                                    {assign var = btn_str value = "showMess(' This property had been switched from Auction to Private Sale. You can not bid it !')"}
                                                {/if}
                                            {/if}
                                            {if $agent_info.type == 'theblock' && $property.info.isBlock}
                                                {assign var = btn_str value = "return showMess('Please go to property detail to have full function to bid.')" }
                                            {/if}
                                            {else}
                                            {assign var = btn_str value = "showMess(' This property had been sold !')"}
                                            {if in_array($property.info.auction_sale_code,array('ebiddar','bid2stay'))}
                                                <script type="text/javascript">
                                                    jQuery('#img_mark_' + {$property.info.property_id}).attr('src','/modules/general/templates/images/RENT.png');
                                                    jQuery('#img_mark_' + {$property.info.property_id}).css('display','block');
                                                    jQuery('#img_mark_fix_' + {$property.info.property_id}).attr('src','/modules/general/templates/images/RENT.png');
                                                    jQuery('#img_mark_fix_' + {$property.info.property_id}).css('display','block');
                                                    jQuery('#auc-time-{$property.info.property_id}').html('Leased');
                                                    jQuery('#count-{$property.info.property_id}').html('Leased');
                                                </script>
                                                {else}
                                                <script type="text/javascript">
                                                    jQuery('#img_mark_' + {$property.info.property_id}).attr('src','/modules/general/templates/images/SOLD.png');
                                                    jQuery('#img_mark_' + {$property.info.property_id}).css('display','block');
                                                    jQuery('#img_mark_fix_' + {$property.info.property_id}).attr('src','/modules/general/templates/images/SOLD.png');
                                                    jQuery('#img_mark_fix_' + {$property.info.property_id}).css('display','block');
                                                    jQuery('#auc-time-{$property.info.property_id}').html('Sold');
                                                    jQuery('#count-{$property.info.property_id}').html('Sold');
                                                </script>
                                            {/if}
                                        {/if}
                                        
                                        {if $property.info.confirm_sold == false AND $property.info.stop_bid == 0 AND $property.info.type == 'live'}
                                            <input type="button" id="bid_button_{$property.info.property_id}" class="{$btn_bid_class} f-right btn-bid-auc-list btn-bid-ie7" value=""
                                                    onclick="{$btn_str}" />
                                        {/if}

                                    </div>
                                    <div class="clearthis"></div>
                                    {*END*}
                                       		

                                </div>
                                <div class="clearthis"></div>
                            </div>
                             {if $property.info.transition == false}
                             <script type="text/javascript">
                                    	    ids.push({$property.info.property_id});
                                            var time_{$property.info.property_id} = '{$property.info.remain_time}';
                                            var timer_{$property.info.property_id} = '{$property.info.count}';
                                            var bid_{$property.info.property_id} = new Bid();
                                            {if $property.info.isBlock || ($property.info.ofAgent && $property.info.auction_sale_code == 'auction')}
                                            bid_{$property.info.property_id}.setContainer('count-{$property.info.property_id}');
                                            bid_{$property.info.property_id}._options.theblock = true;
                                            bid_{$property.info.property_id}._options.mine = true;
                                            var count_{$property.info.property_id} = new CountDown();
                                                count_{$property.info.property_id}.container = 'count-{$property.info.property_id}';
                                                count_{$property.info.property_id}.bid_button = 'bid-button-{$property.info.property_id}';
                                                count_{$property.info.property_id}.property_id = '{$property.info.property_id}';

                                            {/if}
                                            bid_{$property.info.property_id}.setContainerObj('auc-{$property.info.property_id}');
                                            bid_{$property.info.property_id}.setTimeObj('auc-time-{$property.info.property_id}');
                                            bid_{$property.info.property_id}.setBidderObj('auc-bidder-{$property.info.property_id}');
                                            bid_{$property.info.property_id}.setPriceObj('auc-price-{$property.info.property_id}');
                                            bid_{$property.info.property_id}.setTimeValue('{$property.info.remain_time}');
                                            bid_{$property.info.property_id}.startTimer({$property.info.property_id});
                                            {if $property.info.type == 'forthcoming'}
                                                bid_{$property.info.property_id}._options.transfer = false;
                                                bid_{$property.info.property_id}._options.transfer_template = 'grid';
                                                bid_{$property.info.property_id}._options.transfer_container = 'auc-{$property.info.property_id}';
                                            {else}
                                                bid_{$property.info.property_id}._options.transfer = true;
                                            {/if}


                             </script>
                             {/if}
                        </li>
                	{/foreach}
               {else}
                    <div class="message-box message-box-add" style="width: 608px;"><center><i>Sorry, but there are no properties available based on your selection. Please modify the filters to search again. Thanks!</i></center></div>               {/if}
                <script type="text/javascript">updateLastBidder();</script>
                 <script type="text/javascript">
                     {literal}
                     $(function(){
                         jQuery('.btn-bid-green').tipsy({gravity: $.fn.tipsy.autoNS,fallback: " <div style='padding: 5px;text-align: justify'>When the bid button turns green the property is on the market</div>",html: true });
                         jQuery('.btn-bid-vendor-green').tipsy({gravity: $.fn.tipsy.autoNS,fallback: " <div style='padding: 5px;text-align: justify'>When the bid button turns green the property is on the market</div>",html: true });
                     });
                     {/literal}
                 </script>
            </ul>
        </div>

    </div>
    <div class="clearthis"></div>
        {$pag_str}
</div>
