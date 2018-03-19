<div class="auctions-list">
    <ul>
    {if is_array($auction_data) and count($auction_data)>0}
        {assign var = i value = 0}
        {foreach from = $auction_data key = k item = data}
            {if $i == 0}
                {assign var = cls value = "hide"}
            {else}
                {assign var = cls value = "show"}
            {/if}
        
            <li class="first" >
                <div class="auction-item {$cls}">
                    <div class="home-img-watermark">
                        <span style="margin-left:5px; color:#CC8C04;">{$data.title}</span>
                        
                        <div class="clearthis"></div>
                        <div style="float:left">
                            <div class="detail-icons detail-icons-a">
                                <span style="float:left; margin-left:6px;"> ID : {$data.property_id} </span>     
                            </div> 
                            <div class="detail-icons detail-icons-b">
                                <span class="bed icons">{$data.bedroom_value}</span>
                                <span class="bath icons">{$data.bathroom_value}</span>
                                <span class="car icons">{$data.carport_value}</span>
                            </div>
                        </div>  
                       {* <!-- onclick="bid_{$data.property_id}.click()" -->*}
                        <a href="{$data.link}">
                            <img src="{$data.file_name}" alt="Photo" style="width:180px;height:115px;padding: 5px;" />
                        </a>

                    </div>
                    <div class="auc-info" id="auc-{$data.property_id}">
                        <p class="name" style="min-height:26px; padding:0 10px" title="{$data.address_full}">
                            {$data.address_short}
                        </p>
                        {if $data.type == 'auction'}
                            <p class="time" style="color:#CC8C04; font-size:16px; font-weight:bold; text-align:center; margin-left:5px; margin-right:5px;">
                                -d:-:-:-
                            </p>
                            <p class="bid" style="font-size:14px; text-align:center;  color:#CC8C04 !important ">

                                {if $data.stop_bid == 1 or $data.transition == true}
                                    {assign var=temp value = 0}
                                    {if $data.stop_bid == 1}
                                        {if $data.bidder == '--'}
                                            Start Price:
                                            {assign var=temp value = 1}
                                        {/if}
                                    {/if}
                                    {if !$temp}Last Bid:{/if}

                                {elseif $data.check_start == 'true'}
                                    Start Price:
                                {else}
                                Current Bid:
                                {/if} {$data.price}
                            </p>
                        {elseif $data.type == 'sale'}
                            <div align="center" >
								<span style="font-size:14px;  margin-left:55px; margin-right:45px; color:#CC8C04 !important "><strong>{$data.price}</strong></span>
							</div>
                        {else}
                            <div align="center" style="position: absolute;top: 198px;">
                                <span class="f-left" style="margin-top: 0px;margin-left:10px;margin-bottom:5px; color:#CC8C04">AUCTION STARTS: {$data.start_time}</span>
                                <span  id="live-fg-price" style="font-size:14px;  margin-left:55px; margin-right:45px; color:#CC8C04 !important ">{$data.price}</span>
                            </div>
                        {/if}
                    </div>
                    <div class="tbl-info tbl-info-home" style="position: absolute;{if $data.type!='sale'}bottom:50px;{else}bottom:60px;{/if}left:4px;" >
                        <ul>
                            <li  style="margin-top:0px; margin-bottom:3px;">
                                <span style="font-family:Arial,Helvetica,sans-serif; color:#666666; float:left; margin-right: 27px;margin-left:6px; margin-top:1px;"> Livability Rating </span>
                                <span style=""> {$data.livability_rating_mark}</span>
                            </li>
                        </ul>
                        <ul>
                            <li  style="margin:0px;">
                                <span style="font-family:Arial,Helvetica,sans-serif; color:#666666; float:left; margin-right: 6px;margin-left:5px; margin-top:1px;">iBB Sustainability</span>
                                <span style="">{$data.green_rating_mark}</span>
                            </li>
                            <span class="pfi-home"> Open for Inspection: {$data.o4i}</span>
                        </ul>
                    </div>
                    <div class="f-right btn-view-wht" style="position: absolute;bottom:11px;left:11px;width:182px;">
                        {*{if $authentic.id > 0 and isset($db_checkpartner) and $db_checkpartner.type_id != 3}
                            <button class="btn-wht btn-wht-home btn-lan-home" style="float:left !important;margin-right:0px;" onclick="pro.addWatchlist('/modules/property/action.php?action=add-watchlist&property_id={$row.property_id}')">
                                <span style="font-size:12px;"><span style="font-size:12px;">Add to Watchlist</span></span>
                            </button>
                        {elseif $authentic.id > 0 and isset($db_checkpartner) and $db_checkpartner.type_id == 3} <!-- IS PARTNER -->
                            <button class="btn-wht btn-wht-home btn-lan-home" style="float:left !important;margin-right:0px;" 
                            onclick="return showMess('Access denied. Please login as a vendor or buyer to use this function')" >
                                <span style="font-size:12px;"><span style="font-size:12px;">Add to Watchlist</span></span>
                            </button>  
                        {else}*}

                            <button class="btn-wht btn-wht-home btn-lan-home" style="float:left !important;margin-right:0px;" onclick="{$data.awl}">
                                <span style="font-size:12px;"><span style="font-size:12px;">Add to Watchlist</span></span>
                            </button>  
                       {* {/if}    *}

                        <button id="view-button-{$data.property_id}" style="float:right;margin-right:0px;" class="btn-view btn-view-home" onClick="document.location = '{$data.link}'"></button>
                    </div>         
                    <div class="auc-bid">
                        <script type="text/javascript">

                            ids.push({$data.property_id});
                            
                            var time_{$data.property_id} = {$data.remain_time};
                            var bid_{$data.property_id} = new Bid();
                            bid_{$data.property_id}.setContainerObj('auc-{$data.property_id}');
                            bid_{$data.property_id}.setTimeObj();
                            bid_{$data.property_id}.setBidderObj();
                            bid_{$data.property_id}.setPriceObj();
                            bid_{$data.property_id}.setTimeValue('{$data.remain_time}');
                            bid_{$data.property_id}.startTimer({$data.property_id});
                        </script>
                    </div> 
                </div>
            </li>
            {assign var = i value = $i+1}
        {/foreach}  
    {/if}
    
    </ul>
    <script type="text/javascript">updateLastBidder();</script>
</div>
    
