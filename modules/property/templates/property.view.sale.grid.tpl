{literal}
<script type="text/javascript" src="modules/calendar/templates/js/calendar.popup.js"></script>
<script type="text/javascript">
    var pro = new Property();
    var ids = [];
</script>
{/literal}

<div class="auctions-box auctions-box-viewsg auctions-box-g">
	{include file = "`$ROOTPATH`/modules/property/templates/property.view.top-bar.tpl"}
    <div class="auctions-list">
        <ul>
            {if isset($property_data) and is_array($property_data) and count($property_data)>0}
                <!-- Duc Coding -->
                {assign var = jsearch value = 0}
                {assign var = isearch value = 0}
                
                {foreach from = $property_data key = k1 item = row}
                    {assign var = isearch value = $isearch+1}

                    <li>
                        <div class="auction-item">

                                <span class="f-left" style="padding-left:10px; padding-top: 5px;color:#980000">FOR SALE: {$row.suburb} </span>
                                <div class="clearthis"></div>
                                <span style="float: left;padding-left:10px;padding-top: 5px;">ID : {$row.property_id} </span>
                                <p class="detail-icons" style="float:right; padding-right:10px;padding-top:5px;">
                                    <span class="bed icons">{$row.bedroom_value}</span>
                                    <span class="bath icons">{$row.bathroom_value}</span>
                                    <span class="car icons">{$row.carport_value}</span>
                                </p>
                            <div class="sale-grid-img-watermark">
                                <a href="/?module=property&action=view-{$actions[1]}-detail&id={$row.property_id}"><img
                                src="{$MEDIAURL}/{$row.photo_default}" alt="img" style="padding: 5px;width:180px;height:115px;"/></a>
                            </div>
                            
                            <div class="auc-info" id="auc-{$data.property_id}">
                                <p class="name" style="min-height:30px; padding:0 5px 0 10px;" title="{$data.address_full}">
                                {$row.address_full}
                                </p>
                                <div align="center" style="width:200px; position:absolute; bottom:120px;">
                                    <span style="font-size:14px;color:#980000 !important ">{$row.price}</span>
                                    <script type="text/javascript">ids.push({$row.property_id});</script>
                                </div>
                            
                                <div class="tbl-info" style="position:absolute; bottom:50px; padding: 5px 5px 5px 10px;">
                                    <ul>
                                        <li style="width:180px;">
                                            <span class="title-star">Livability Rating</span>
                                            <span class="span-star"> {$row.livability_rating_mark}</span>
                                        </li>
                                        <li style="width:180px;">
                                            <span class="title-star">iBB Sustainability</span>
                                            <span class="span-star">{$row.green_rating_mark}</span>
                                        </li>
                                    </ul>
                                    <p style="float: right; padding-top: 5px; padding-right: 12px; font-size: 10px; color: rgb(152, 0, 0);"onclick="" >Open for Inspection: {$row.o4i}</p>
                                </div>
                            
                                <div class="f-right f-right-btn-sale f-right-vsale-gird">
                                    
                                    {assign var = btn_str1 value = "pro.addWatchlist('/modules/property/action.php?action=add-watchlist&property_id=`$row.property_id`')"}
                                    {if isset($db_checkpartner) and $db_checkpartner.type_id == 3}
                                        {assign var = btn_str1 value = "return showMess('Access denied. Please login as a vendor or buyer to use this function')"}
                                    {/if}
                                    <button class="btn-wht btn-wht-sale" style="float:left;" onclick="{$btn_str1}">
                                        <span style="font-size:12px;"><span style="font-size:12px;">Add to Watchlist</span></span>
                                    </button>
    
    								<button style="float:right;" class="btn-view btn-view-sale" onclick="document.location='?module=property&action=view-sale-detail&id={$row.property_id}'"></button>
                                    
                                </div>
                                <div class="clearthis"></div>
                            </div>
                        </div>   
                        
                          {assign var = len value = $len}
                              {assign var = dgetlist value = $getlist}                    
                              {assign var = c  value = $len}     
                              {assign var = x value = $len_arr}                         
                              {assign var = pid value = $pid}
                              {assign var = p value =$p}
                                                                     
                               {if $isearch % 3 == 0}
                        
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
                <script type="text/javascript">updateLastBidder();</script>

            {/if}
        </ul>

	</div>
    <div class="clearthis"></div>
    <div class="clearthis"></div>

	{$pag_str}
</div>

