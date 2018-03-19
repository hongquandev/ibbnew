{literal}

<script type="text/javascript" src="modules/calendar/templates/js/calendar.popup.js"></script>
<script type="text/javascript">
	var ids = [];
    var pro=new Property();
</script>
{/literal}

<div class="auctions-box auctions-box-g">
	{include file = "`$ROOTPATH`/modules/property/templates/property.view.top-bar.tpl"}
    <div class="auctions-list">
        <ul>
            {if isset($property_data) and is_array($property_data) and count($property_data) > 0}
                <!-- Duc Coding -->
                {assign var = jsearch value = 0}
                {assign var = isearch value = 0}
                
                {foreach from = $property_data key = k1 item = row}
                    {assign var = isearch value = $isearch+1}
                    <li>
                        {assign var = len value = $len}
                        {assign var = dgetlist value = $getlist}
                        {assign var = c  value = $len}
                        {assign var = x value = $len_arr}
                        {assign var = pid value = $pid}
                        {assign var = p value =$p}
                        
                        <div class="auction-item">
                            <div class="auc-img-watermark" style="padding: 5px;">
                                <span class="f-left" style="margin-left:8px; color:#CC8C04">AUCTION ENDS: {$row.end_time} </span>
                                <div style="float:left">
                                    <div class="detail-icons detail-icons-a">
                                        <span style="float:left; margin-left:6px;"> ID : {$row.property_id} </span>     
                                    </div> 
                                    <div id="detail-icons-b" class="detail-icons detail-icons-b">
                                        <span class="bed icons">{$row.bedroom_value}</span>
                                        <span class="bath icons">{$row.bathroom_value}</span>
                                        <span class="car icons">{$row.carport_value}</span>
                                    </div>
                                </div>
                                <a href="/?module=property&action=view-{$actions[1]}-detail&id={$row.property_id}"><img src="{$MEDIAURL}/{$row.photo_default}" alt="img" style="width:180px;height:115px;"/></a>
                                <a href="/?module=property&action=view-{$actions[1]}-detail&id={$row.property_id}"><img id="img_mark_{$row.property_id}" src="" class="watermark" style="width:180px;height:120px;margin:45px 0px 0px 5px;display: none;" /></a>
                            </div>
                            
                            <div class="auc-info" id="auc-{$data.property_id}">
                                <p class="name" title="{$data.address_full}">
                                {$row.address_full}
                                </p>
                            </div>
                            
                            <div align="center" style="position: absolute;bottom:92px;width:200px;">
                                <script type="text/javascript">{*ids.push({$row.property_id});*}</script>
                            
                                <p style="color:#CC8C04; font-size:16px; font-weight:bold; text-align:center;" class="time time-auc-grid" id="auc-time-{$row.property_id}" >
                                    -d:-:-:-
                                </p>
                                
                                <p class="lastbidder lastbidder-auc-grid"  id="auc-bidder-{$row.property_id}" style="font-size:14px; text-align:center;  color:#CC8C04 !important;min-height:30px; " >
                                    Last Bidder: {$row.bidder}
                                </p>
                                <p class="bid" id="auc-price-{$row.property_id}" style="margin-top:-13px;font-size:14px; text-align:center;  color:#CC8C04 !important;">

                                    {if $row.stop_bid == 1 or $row.transition == true}
                                        {assign var=temp value = 0}
                                        {if $row.stop_bid == 1}
                                            {if $row.bidder == '--'}
                                                Start Price:
                                                {assign var=temp value = 1}
                                            {/if}
                                        {/if}
                                        {if !$temp}Last Bid:{/if}

                                    {elseif $row.check_start == 'true'}
                                        Start Price:
                                    {else}
                                        Current Bid:
                                    {/if} {$row.price}
                                </p>
                            </div>
                            
                            <div class="clearthis"></div>
                            
                            <div class="tbl-info tbl-info-auc-grid" style="position: absolute;bottom:40px;left:4px;">
                                <ul>
                                    <li style="margin-top:0px; margin-bottom:3px;">
                                        <span style="font-family:Arial,Helvetica,sans-serif; color:#666666; float:left; margin-right: 27px;margin-left:5px; margin-top:1px;"> Livability Rating </span>
                                        <span> {$row.livability_rating_mark}</span>
                                    </li>
                                </ul>
                            
                                <ul>
                                    <li  style="margin:0px;">
                                        <span style="font-family:Arial,Helvetica,sans-serif; color:#666666; float:left; margin-right: 5px;margin-left:5px; margin-top:1px;">iBB Sustainability</span>
                                        <span style="">{$row.green_rating_mark}</span>
                                    </li>
                                </ul>
                                <span style="float: right; padding-top: 0px; padding-right: 15px; font-size: 10px; color: rgb(152, 0, 0);" onclick="" >Open for Inspection: {$row.o4i}</span>
                            </div>	


                            <div class="f-right btn-bid-wht-grid" style="position: absolute;bottom:10px;width:200px;">
                                <script type="text/javascript">
                                    if ({$row.remain_time} >0)
                                        ids.push({$row.property_id});
                                    
                                    var time_{$row.property_id} = {$row.remain_time};
                                    var bid_{$row.property_id} = new Bid();
                                    bid_{$row.property_id}.setContainerObj('auc-{$row.property_id}');
                                    bid_{$row.property_id}.setTimeObj('auc-time-'+{$row.property_id});
                                    bid_{$row.property_id}.setBidderObj('auc-bidder-'+{$row.property_id});
                                    bid_{$row.property_id}.setPriceObj('auc-price-'+{$row.property_id});
                                    bid_{$row.property_id}.setTimeValue('{$row.remain_time}');
                                    bid_{$row.property_id}.startTimer({$row.property_id});
                                    
                                    //BEGIN LISTENER AUTOBID
                                    bid_{$row.property_id}.addCallbackFnc('getBid',function(obj){literal}{
                                    if (obj.bidder_id !={/literal} {$agent_id} && {$row.property_id} == {$auto_property_id}) {literal}{{/literal}										
                                    bid_{$row.property_id}.bid({$row.property_id});
                                    {literal}}
                                    });	{/literal}
                                    //END
                                    
                                    //bid_{$data.property_id}.getLastBidder({$data.property_id});
                                </script>
                                {*
                                {if $row.check_price=='true'}
                                    <input type="button" style="float: right;margin-right:10px;" class="btn-bid-green" value="" onclick="{$bid_s1}"/>
                                {/if}
                                {if $row.check_price=='false'}
                                    <input type="button" style="float: right;margin-right:10px;" class="btn-bid" value="" onclick="{$bid_s1}"/>
                                {/if}
                                *}
                            
                            	{assign var = btn_str1 value = "pro.addWatchlist('/modules/property/action.php?action=add-watchlist&amp;property_id=`$row.property_id`')"}
                                 {assign var = bid_s1 value = "bid_`$row.property_id`.click()"}
                               
                                {if isset($db_checkpartner) and $db_checkpartner.type_id == 3}
                                	{assign var = btn_str1 value = "return showMess('Access denied. Please login as a vendor or buyer to use this function')"}
                                    
                                    {assign var = bid_s1 value = "return showMess('Access denied. Please login as a vendor or buyer to use this function')"}
                                    {assign var = bid_s2 value = "return showMess('Access denied. Please login as a vendor or buyer to use this function')"}
                                    
                                {/if}
                                
                                <button class="btn-wht btn-wht-auc-grid" style="float:left !important;margin-left:10px;" onclick="{$btn_str1}">
                                    <span style="font-size:12px;"><span style="font-size:12px;">Add to Watchlist</span></span>
                                </button>
                                {if $row.check_price=='false'}
                                    <input id="bid-button-{$row.property_id}" type="button" class="btn-bid f-right btn-bid-auc-list btn-bid-lan btn-bid-view-auction-g" value="" onclick="{$bid_s1}"/>
                                {/if}
                                {if $row.check_price=='true'}
                                    <input id="bid-button-{$row.property_id}" type="button" class="btn-bid-green f-right btn-bid-auc-list btn-bid-lan btn-bid-view-auction-g" value="" onclick="{$bid_s1}"/>
                                {/if}
                                <div class="clearthis"></div>
                            </div>
                            <div class="clearthis"></div>
                        </div>
                        
                          {assign var = len value = $len}
                              {assign var = dgetlist value = $getlist}                    
                              {assign var = c  value = $len}     
                              {assign var = x value = $len_arr}                         
                              {assign var = pid value = $pid}
                              {assign var = p value =$p}
                                                                     
                               {if $isearch % 6 == 0}
                        
                                    {if isset($dgetlist) and $pid > 0 or  $pid == ''}   
                                         
                                           {if $len_arr > 0} {* Check Array Banner > 0 With Don't error divide zero *} 
                                            	{assign var = xsearch value = $pid%$len_arr}  
                                           {/if}
                                          {if $pid > 0 and $len_arr >= 2 and $len >= 6}
                                                {assign var = jsearch value = $jsearch+1}
                							{elseif $pid > 0 and $len_arr >= 2 and $len >= 12}
                                                {assign var = jsearch value = $jsearch+1}	                           
                                          {/if}                  
                                                                        
                                            {assign var = arr2 value = $auction_cv[$jsearch]}
                                            {include file = "`$ROOTPATH`/modules/banner/templates/banner-step.tpl"}
                                           {if $len_arr >= 2 and $pid == ''} 
                                            	{assign var = jsearch value = $jsearch+1}
                                           {/if}                                         
    
                                      {/if}  
                               {/if}    
                               
                    </li>
                    <!-- {include file = "`$ROOTPATH`/modules/banner/templates/banner.property.list.tpl"} -->
                    
                {/foreach}
                {if $action=='view-auction-list'}
                    <script type="text/javascript">updateLastBidder();</script>
                {/if}            
            {/if}
        </ul>
    </div>
    <div class="clearthis"></div>
    {*FOR PAGGING*}
    {$pag_str}
</div>

