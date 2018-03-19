{literal}
<style type="text/css" media="all" >
.sr-new-info {
    margin-left: 0;
    margin-top: 12px;
    right: 0;
}

.auctions-box .auctions-list ul li.lis li {
    display: inline-block;
    margin: 0px 1px;
}
.auctions-box .auctions-list ul li.lis{display: inline-block;;margin-right:8px;}
.tbl-info .col1 li {
 	/*background-color: #D9D9D9 *; */
    margin: 1px 0;
    padding: 4px 5px;
}
.tbl-info .col1 {
    list-style: none outside none;
    margin-right: 1px;
}

.tbl-info .col2 {
    list-style: none outside none;
	margin-right: 1px;
}
.sr-new-action {
    bottom: 0;
    margin-top: 57px;
    right: 0;
	position:inherit;
}

/*.f-left, .left {
    float: none !important;
}*/
/*.tbl-info {
    margin-top: 56px;
    position: relative !important;
    right: 0;
}
*/
.auctions-box .auctions-list .auction-item .auc-img {
    margin: 3px auto !important;
    text-align: center;
}
#st1 {
	margin-bottom:4px;
}
#st2 {

}
/*
.btn-wht {
	border: medium none;
}
.btn-wht {
	border-bottom-style:none;
	border-bottom-width:medium;
	border-color:initial;
	border-left-style:none;
	border-left-width:medium;
	border-right-style:none;
	border-right-width:medium;
	border-top-style:none;
	border-top-width:medium;
	height:24px !important;
	padding-top:3px;
}*/
.mau {
background: url("modules/general/templates/images/list_selected_search.png") no-repeat scroll 0 0 transparent;
width:17px;
height:14px;
border:none;

}
.btn-wht-auc-grid{
    margin-top:0px !important;
    margin-left:0px !important;
}
.auctions-box .bar-title .bar-filter {
    width:160px !important;
}


</style>

{/literal}
<script type="text/javascript" src="modules/calendar/templates/js/calendar.popup.js"></script>
<script type="text/javascript" src="/modules/property/templates/js/search-grid.js"></script>


<div itemscope itemtype="http://schema.org/ItemList">
<meta itemprop="itemListOrder" content="Descending"/>
</div>

<div class="auctions-box auctions-box-searchvg auctions-box-g">
    <div class="bar-title">
        <h1>SEARCH RESULTS</h1>
        {include file = "`$ROOTPATH`/modules/property/templates/search.view.top-bar.tpl"}
        <div class="clearthis"></div>
    </div>
    
    <div class="auctions-list">
        <ul>
        {if isset($results) and is_array($results) and count($results)>0}
            {assign var = i1 value = 0}
            <!-- Duc Coding -->
            {assign var = isearch value = 0}
            {assign var = jsearch value = 0}
            {assign var = pid value = $pid}		
            {foreach from = $results key = k item = property}
                <!-- Assign And Count -->
                {assign var = isearch value = $isearch+1}                        				 
                {assign var = i1 value = $i1+1}
                <script type="text/javascript">ids.push({$property.info.property_id})</script>
                <li class="">
                
                    <div class="auction-item">
                        <div class="title">
                            <span class="f-left" style="padding-left:10px;padding-top:3px; padding-bottom: 2px;color:#980000">{$property.info.title}</span>
                            <!-- <span style="float:left; margin-left:5px;">  ID : {$property.info.property_id} </span> -->
                            <div class="clearthis"></div>
                            
                            <div style="padding-left:10px;float:left;">
                                <span>ID : {$property.info.property_id}</span>
                            </div>
                            <div class="detail-icons detail-icons-ie" style="float:right;padding-right:8px;">
                                <span class="bed icons">{$property.info.bedroom_value}</span>
                                <span class="bath icons">{$property.info.bathroom_value}</span>
                                <span class="car icons">{$property.info.carport_value}</span>
                            </div>
                        </div>
                        <div class="clearthis"></div>
                        <div class="search-gird-img-watermark">
                            {if isset($property.photo) and is_array($property.photo) and count($property.photo) > 0}
                                <script type="text/javascript">
                                var IS_{$property.info.property_id} = new ImageShow('container_simg_{$property.info.property_id}',{$property.photo|@count});
                                </script>
                                
                                <div id="container_simg_{$property.info.property_id}" style=" position: relative;margin-top: 25px">
                                    {assign var = i value = 1}                     
                                    {foreach from = $property.photo key = k item = row}
                                        {assign var = is_show value = ';display:none;'}
                                        {if $i==1}
                                            {assign var = is_show value = ''}
                                        {/if}
                                        <img id="img_{$i}" src="{$MEDIAURL}/{$row.file_name}" alt="img"  style="width:180px;height:115px{$is_show}"/>
                                        {assign var = i value = $i+1} 
                                    {/foreach}

                                </div>
                            {else}
                                <div style=" position: relative;margin-top: 25px">
                                    <img src="{$MEDIAURL}/{$property.photo_default}" alt="img" style="width:180px;height:115px"/>
                                    <div class="toolbar-img"></div>
                                </div>
                            {/if}
                        </div>
                    
                        <div class="desc desc-auction desc-auction-sr-ie" style="padding: 0px 5px 5px 10px; min-height: 20px;font-size:11px; ">
                            {$property.info.address_full} <!-- {$property.info.description} -->
                        </div>
                        {if $property.info.pro_type == 'forthcoming'}
                            <div align="center center-sg" style="position:absolute; top:198px;width:200px;">
                                 {if $property.info.isBlock == 1}
                                     <p class="acc-sp-ie" id="auc-time-{$property.info.property_id}" style="padding-left: 5px;color: #980000;font-size: 28px; font-weight: bold; text-align: center;" >
                                              -d:-:-:-
                                     </p>
                                 {else}
                                    <span class="f-left" style="margin-left:10px;margin-top:7px; color:#980000">AUCTION STARTS : {$property.info.start_time} </span>
                                 {/if}
                                 <span style="font-size:14px; color:#980000 !important ">{$property.info.price}</span>
                            </div>
                        {elseif $property.info.pro_type == 'auction'}
                            <div align="center" style="position:absolute; top:215px;width:200px;" id="sr-{$property.info.property_id}">
                                {if $property.info.isBlock}
                                    <p class="acc-sp-ie" id="count-{$property.info.property_id}" style="color: #980000;font-size: 22px; font-weight: bold; text-align: center;margin-top:11px !important;">
                                                                {$property.info.set_count}
                                    </p>
                                {else}
                                    <p id="auc-time-{$property.info.property_id}" class="time" style="color:#980000; font-size:16px; font-weight:bold; text-align:center;">
                                    -d:-:-:-
                                    </p>
                                {/if}
                                <span style="font-size:14px; color:#980000 !important ">

                                    {if $property.info.stop_bid == 1 or $property.info.transition == true}
                                        {assign var=temp value = 0}
                                        {if $property.info.stop_bid == 1}
                                            {if $property.info.bidder == '--'}
                                                Start Price:
                                                {assign var=temp value = 1}
                                            {/if}
                                        {/if}
                                        {if !$temp}Last Bid:{/if}

                                    {elseif $property.info.check_start == 'true'}
                                        Start Price:
                                    {else}
                                        Current Bid:
                                    {/if}{$property.info.price}</span>
                            </div>
                        {else}
                            <div align="center" style="position:absolute; top:220px;width:200px;">
                                <span style="font-size:14px; color:#980000 !important ">{$property.info.price}</span>
                            </div>
                        {/if}
                        <script type="text/javascript">
                                    if ({$property.info.remain_time} > 0 || {$property.info.isBlock})
                                        ids.push({$property.info.property_id});

                                    var time_{$property.info.property_id} = {$property.info.remain_time};
                                    var bid_{$property.info.property_id} = new Bid();
                                    {if $property.info.isBlock}
                                        bid_{$property.info.property_id}.setContainer('count-{$property.info.property_id}');
                                        bid_{$property.info.property_id}._options.theblock = true;
                                        bid_{$property_data.info.property_id}._options.mine = true;
                                        var count_{$property.info.property_id} = new CountDown();
                                            count_{$property.info.property_id}.container = 'count-{$property.info.property_id}';
                                            count_{$property.info.property_id}.bid_button = 'btn_bid_{$property.info.property_id}';
                                            count_{$property.info.property_id}.property_id = '{$property.info.property_id}';

                                    {/if}
                                    bid_{$property.info.property_id}.setContainerObj('auc-{$property.info.property_id}');
                                    bid_{$property.info.property_id}.setTimeObj('auc-time-{$property.info.property_id}');
                                    bid_{$property.info.property_id}.setBidderObj('auc-bidder-{$property.info.property_id}');
                                    bid_{$property.info.property_id}.setPriceObj('auc-price-{$property.info.property_id}');
                                    bid_{$property.info.property_id}.setTimeValue('{$property.info.remain_time}');
                                    bid_{$property.info.property_id}.startTimer({$property.info.property_id});
                        </script>
                        <div class="tbl-info" id="fixstrates" style="position: absolute;bottom:44px;width:197px;">
                            <ul id="st1" class="">
                                <li>
                                    <span style="font-family:Arial,Helvetica,sans-serif; color:#666666; float:left; margin-left:5px; margin-right: 26px; margin-top:1px;"> Livability Rating </span>
                                    <span style=""> {$property.info.livability_rating_mark}</span>
                                </li>
                            </ul>
                            <ul id="st2" class="">
                                <li>
                                    <span style="font-family:Arial,Helvetica,sans-serif; color:#666666; float:left; margin-left:5px; margin-right: 4px; margin-top:1px;">iBB Sustainability</span>
                                    <span style="">{$property.info.green_rating_mark}</span>
                                </li>
                            </ul>
                            <p style="z-index:9999;float:right; font-size:10px; margin-top:0px; color: #980000;padding-right:10px;" id="fixstopen" >
                                Open for Inspection: {$property.o4i}
                            </p>
                        </div>
                    
                        <div class="btn-bid-wht-grid btn-search-grid" style="position: absolute;bottom:10px;width:196px;">
                            {assign var = fnc_str1 value = "pro.addWatchlist('/modules/property/action.php?action=add-watchlist&property_id=`$property.info.property_id`')"}
                            {if isset($db_checkpartner) and $db_checkpartner.type_id == 3}
                                {assign var = fnc_str1 value = "return showMess('Access denied. Please login as a vendor or buyer to use this function')"}
                            {/if}
                            <button class="btn-wht f-left btn-wht-search-list" style="margin-left:5px; margin-top:6px;width:125px;" onclick="{$fnc_str1}">
                                <span><span> Add to Watchlist &nbsp;</span></span>
                            </button>
                            
                               {assign var = fnc_bid value = "document.location='`$property.info.link`'"}
                                    {if isset($db_checkpartner) and $db_checkpartner.type_id == 3}
                                    	{assign var = fnc_str1 value = "return showMess('Access denied. Please login as a vendor or buyer to use this function')"}
                                    {/if}
                            <button id="view-button-{$property.info.property_id}" class="{if $property.info.check_price == false}btn-view {else} btn-view-green{/if} f-right btn-view-search-list" style="margin-top:7px;margin-right:5px;" onclick="{$fnc_bid}"></button>
                         </div>
                    </div>
                </li>
				{include file = "`$ROOTPATH`/modules/banner/templates/banner.search.list.tpl"}
            {/foreach}
        {else}
        	There is no data.
        {/if}
        <script type="text/javascript">updateLastBidder();</script>
        </ul>
     
	</div>
    <div class="clearthis"></div>
        {$pag_str}    
 </div>
test

