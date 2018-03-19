{literal}
<style type="text/css">
/*.auctions-box .auctions-list .auction-item {
    background: url("modules/general/templates/images/auction-bg.jpg") no-repeat scroll 0 0 transparent;
    height: 294px;
    padding: 4px;
    position: relative;
    width: 192px;
}

.auctions-box .auctions-list ul li.first {
    margin: 10px 1px 10px 1px;
}

.auctions-box .auctions-list .auction-item .auc-info p.name {
    font-size: 11px;
    margin-bottom: 0px !important;
    min-height: 30px;
    padding: 0 5px 10px 10px;
}
*/

</style>
<script type="text/javascript" src="modules/calendar/templates/js/calendar.popup.js"></script>
<script type="text/javascript">
	var ids = [];
	pro = new Property();
</script>
{/literal}

<div class="auctions-box auctions-box-live-fg auctions-box-g">
	{include file = "`$ROOTPATH`/modules/property/templates/property.view.top-bar.tpl"}
   <div class="clearthis"></div>
   	<div class="auctions-list">
        <ul>
        {if isset($property_data) and is_array($property_data) and count($property_data)>0}
            {assign var = k_tmp value = 0}
            
            <!-- Duc Coding -->
            {assign var = jsearch value = 0}
            {assign var = isearch value = 0}
            {foreach from = $property_data key = k1 item = row}
            
                {assign var = isearch value = $isearch+1}
                <li>
                    <div class="auction-item">
                        <div class="auc-img">
                            <span class="f-left" style="padding-left:5px; color:#CC8C04">AUCTION ENDS: {$row.end_time} </span>
                            <div class="clearthis"></div>
                            <div style="float: left;padding-left:5px;">
                                <span>ID : {$row.property_id} </span>
                            </div>
                            <div class="detail-icons" style="float:right;padding-right:5px;">
                                <span class="bed icons">{$row.bedroom_value}</span>
                                <span class="bath icons">{$row.bathroom_value}</span>
                                <span class="car icons">{$row.carport_value}</span>
                            </div>
                            <div class="clearthis"></div>
                            <a href="/?module=property&action=view-forthcoming-detail&id={$row.property_id}"><img src="{$row.photo_default}" alt="img" style="padding:5px;width:180px;height:115px;"/></a>
                        </div>
                    
                        <div class="clearthis"></div>
                        
                        <div class="auc-info" id="auc-{$data.property_id}">
                            <p class="name" title="{$data.address_full}">{$row.address_full}</p>
                        </div>
                        <div align="center" style="position: absolute;top: 215px;">
                            <span class="f-left" style="margin-top: 0px;margin-left:10px;margin-bottom:5px; color:#CC8C04">AUCTION STARTS: {$row.start_time}</span>
                            <span  id="live-fg-price" style="font-size:14px;  margin-left:55px; margin-right:45px; color:#CC8C04 !important ">{$row.price}</span>
                        </div>
                        <div class="tbl-info tbl-info-home tbl-info-live-fg" style="position: absolute;bottom:41px;left:5px;">
                            <ul style="height:16px;">
                                <li>
                                    <span id="tbl-info-live-fg-a" style="font-family:Arial,Helvetica,sans-serif; color:#666666; float:left; margin-left:5px; margin-right: 28px; margin-top:1px;"> Livability Rating </span>
                                    <span style=""> {$row.livability_rating_mark}</span>
                                </li>
                            </ul>
                        
                            <ul>
                                <li>
                                    <span id="tbl-info-live-fg-b" style="font-family:Arial,Helvetica,sans-serif; color:#666666; float:left; margin-left:5px; margin-right: 5px; margin-top:1px;">iBB Sustainability</span>
                                    <span>{$row.green_rating_mark}</span>
                                </li>
                            </ul>
                            <span style="float: right; padding-top: 0px; padding-right: 15px; font-size: 10px; color: rgb(152, 0, 0);"onclick="" >Open for Inspection: {$row.o4i}</span>
                        </div>
                        <div class="f-right btn-view-wht" style="position: absolute;bottom:12px;padding: 0px 5px 0px 10px">
                        	{assign var = btn_str1 value = "pro.addWatchlist('/modules/property/action.php?action=add-watchlist&property_id=`$row.property_id`')"}
                            {if  isset($db_checkpartner) and $db_checkpartner.type_id == 3}
                            	{assign var = btn_str1 value = "return showMess('Access denied. Please login as a vendor or buyer to use this function')"}
                            {/if}
                            <button style="margin-right:0px;float:left;" class="btn-wht btn-wht-home" onclick="{$btn_str1}">
                                <span style="font-size:12px;"><span style="font-size:12px;">Add to Watchlist</span></span>
                            </button>

                            <button class="btn-view btn-view-home" onclick="document.location = '/?module=property&action=view-forthcoming-detail&id={$row.property_id}'" style="float:right;"></button>
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
        {/if}
        </ul>
    </div>
    <div class="clearthis"></div>
    {$pag_str}
</div>

