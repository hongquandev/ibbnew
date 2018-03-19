{literal}
<style type="text/css">
.locat-list .pro-list .i-info .i-bid {
    background-color: #D9D9D9;
    height: 36px;
    padding: 5px 0;
    text-align: center;
}
.locat-list .pro-list .i-info .i-time {
    background-color: #D9D9D9;
    height: 30px;
    padding: 8px 0;
}
.locat-list .pro-list .i-info {
    height: 115px;
    position: relative;
    width: 413px;
}
.locat-list .locat-pro {

/*	float:left !important;*/
    width: 615px;
}

.tbl-info2 {
    margin-top: 0;

    right: 0;
}
ul{list-style:none;}
.auctions-box .bar-title .bar-filter .view-as {
    margin-left:-10px !important;
}
/* fix Safari */
{.btn-make-an-ofer span {padding: 2px 0 5px 8px;}}
{.btn-make-an-ofer span span {padding: 5px 5px 5px 0;}}

</style>
<script type="text/javascript" src="modules/calendar/templates/js/calendar.popup.js"></script>
<script type="text/javascript">
	var ids = [];
	var pro = new Property();
</script>
{/literal}
<div class="auctions-box">
    {include file = "`$ROOTPATH`/modules/property/templates/property.view.top-bar.tpl"}
    <div class="locat-list live-auction-list auctions-box-mof-list">
        <ul class="pro-list">

            {if isset($property_data) and is_array($property_data) and count($property_data) > 0}
                <!-- Duc Coding -->
                {assign var = jsearch value = 0}
                {assign var = isearch value = 0}
                {assign var = temp value = 0}
                
                {foreach from = $property_data key = k1 item = row}
                    {assign var = isearch value = $isearch+1}
                    {assign var = temp value = $temp+1}
                    <li>
                        <div class="locat-pro">
                            <div class="i-info" style="float:left !important;width:420px;">
                                <div class="details-info">
                                    <p class="detail-icons detail-icons-auc-list  detail-icons-ie" style="margin-bottom: 5px;">
                                        <span style="margin-right: 10px;">ID: {$row.property_id}</span>
                                        <span class="bed icons" style="z-index:1">{$row.bedroom_value}</span>
                                        <span class="bath icons">{$row.bathroom_value}</span>
                                        <span class="car icons">{$row.carport_value}</span>
                                        <span class="pfi-aul" style="float:right;color: rgb(152, 0, 0)">Open for Inspection: {$row.o4i}</span>
                                	</p> 
                                    <p></p> 
                                    <div class="clearthis"></div>
                                </div>
                                <p class="address-bold mb-10px">
                                    {$row.address_full}
                                </p>
                                <p class="description-auc-list">
                                    {$row.description}
                                </p>
                            </div>
                            {if isset($row.photo) and is_array($row.photo) and count($row.photo)>0}
                                <script type="text/javascript">
                                var IS_{$row.property_id} = new ImageShow('container_simg_{$row.property_id}',{$row.photo|@count},{$row.property_id},'img_'+{$row.property_id});
                                </script>
                                <div class="f-right img" id="container_simg_{$row.property_id}">
                                    <div class="img-big-watermark">
                                        {assign var = i value = 1}
                                        {assign var = j value = 0}
                                        {foreach from = $row.photo key = k item = rx}
                                            {assign var = is_show value = ';display:none;'}
                                          
                                            {if $rx.file_name == $row.photo_default}
                                                    {assign var = j value = $i}
                                           	{/if}
                                            <img id="img_{$row.property_id}_{$i}" src="{$MEDIAURL}/{$rx.file_name}" alt="img" style="width:180px;height:130px{$is_show}"/>                        
                                            {assign var = i value = $i+1}  
                                        {/foreach}
                                       <img id="img_mark_{$row.property_id}" src="" class="watermark" style="width:180px;height:130px;" alt=""/>
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
                                     {/if}
                                </div>
                            {else}
                                <div class="f-right img">
                                    <div class="img-big-watermark">
                                        <img src="{$MEDIAURL}/{$row.photo_default}" alt="img" style="width:180px;height:130px;"/>
                                        {if $row.check_price=='true'}
                                        <img src="modules/general/templates/images/onthemarket_list.png" class="watermark" alt="Watermark ON THE MARKET" style="width:180px;height:130px;" />
                                        {/if}
                                    </div>
                                    <div class="toolbar-img">
                                     <span class="img-num img-num-ie">1/1</span>
                                            <span class="icons img-prev img-prev-ie img-prev-ie-lfl" onclick="IS_{$property.info.property_id}.prev()"></span>
                                            <span class="icons img-next img-next-ie img-next-ie-lfl" onclick="IS_{$property.info.property_id}.next();"></span>
                                    </div>
                                </div>
                            {/if}
                            <div class="clearthis"></div>
                            <script type="text/javascript">/*ids.push({$row.property_id})*/</script>
                            <div class="i-time-bid i-time-bid-auc-list i-time-bid-lan"  id="auc-{$row.property_id}" style="position:relative;">
                                <div style="float:left;">
                                    <div class="f-left i-time">
                                        <p id="auc-time-{$row.property_id}">
                                            -d:-:-:-
                                        </p>
                                    </div>
                                    
                                    <div class="f-left i-bid" style="width:210px;text-align: left;">
                                        <p style="padding-left: 5px;" class="lasted" id="auc-bidder-{$row.property_id}">
                                            Last Bidder: {$row.bidder}
                                        </p>
                                        <p style="padding-left: 5px;" class="bid" id="auc-price-{$row.property_id}">

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
                                    
                                    <div class="tbl-info2" style="float:left;clear:both;margin-top: 1px;width: 421px;">
                                        <ul class="col1-auc-list" style="float:left;margin-right: 1px;" >
                                            <li class="livability-list">
                                                <span class="title-star">Livability Rating</span> <span class="span-star"> {$row.livability_rating_mark}</span>
                                            </li>
                                        </ul>
                                        <ul class="col1-auc-list" style="float:right;" >
                                            <li class="livability-list" style="margin-top:0px;">

                                                <span class="title-star">iBB Sustainability</span> <span class="span-star">{$row.green_rating_mark}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="sr-new-action sr-new-action-auction-list sr-new-action-lan" style="float:right;">
                                    <div>
                                    	{assign var = fnc_str1 value = "pro.addWatchlist('/modules/property/action.php?action=add-watchlist&property_id=`$row.property_id`')"}
                                        {if isset($db_checkpartner) and $db_checkpartner.type_id == 3}
                                        	{assign var = fnc_str1 value = "return showMess('Access denied. Please login as a vendor or buyer to use this function')"}
                                        {/if}
                                        <button  style="float:left;width:120px;" class="btn-wht"  onclick="{$fnc_str1}">
                                            <span><span>Add to Watchlist</span></span>
                                        </button> 
                                        {if $row.check_price=='true'}
                                            <button id="view-button-{$row.property_id}" class="btn-view-green f-right btn-view-sale-list" style="float:right;"
                                                    onclick="document.location='{$row.detail_link}'" >
                                            </button>
                                        {/if}
                                        {if $row.check_price=='false'}
                                            <button id="view-button-{$row.property_id}" class="btn-view f-right btn-view-sale-list" style="float:right;"
                                                    onclick="document.location='{$row.detail_link}'" >
                                            </button>
                                        {/if}
                                    </div>
                                    <div>
                                    	{assign var = mao_str value = "pro.openMakeAnOffer('#makeanoffer_`$row.property_id`','`$row.property_id`','`$agent_id`')"}
                                        {assign var = btn_str1 value = "bid_`$row.property_id`.click()"}
                                        {assign var = btn_str2 value = "bid_`$row.property_id`.click()"}
                                    	{if isset($db_checkpartner) and $db_checkpartner.type_id == 3}
                                        
                                            {assign var = mao_str value = "return showMess('Access denied. Please login as a vendor or buyer to use this function')"}
                                            {assign var = btn_str1 value = "return showMess('Access denied. Please login as a vendor or buyer to use this function')"}
                                            {assign var = btn_str2 value = "return showMess('Access denied. Please login as a vendor or buyer to use this function')"}
                                        {/if}
                                        <button style="float:left;width:120px;" class="btn-wht btn-make-an-ofer" onclick="{$mao_str}">
                                            <span><span>Make an Offer</span></span>
                                        </button>
                                        {$row.mao}
                                        {if $row.check_price=='true'}
                                            <input id="bid-button-{$row.property_id}" type="button" class="btn-bid-green f-right btn-bid-auc-list btn-bid-lan" value=""
                                            onclick="{$btn_str1}" />
                                        {/if}
                                        {if $row.check_price=='false'}
                                            <input id="bid-button-{$row.property_id}" type="button" class="btn-bid f-right btn-bid-auc-list btn-bid-lan" value=""
                                            onclick="{$btn_str2}" />
                                        {/if}
                                    </div>
                        		</div>
                                <p class="f-right">
                                    <script type="text/javascript">
                                        if ({$row.remain_time}>0)
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
                                    </script>
                                </p>
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
                {/foreach}

                <script type="text/javascript">
					{literal}
					$(function(){
						updateLastBidder();
					});
					{/literal}
                </script>
        	{/if}
        </ul>
        <div class="clearthis"></div>
        {*FOR PAGGING*}
        {$pag_str}
    </div> {* close div class="locat-list"*}

</div> {* div class="auctions-box" *}