{literal}
<style type="text/css">
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
}
</style>
{/literal}
<script type="text/javascript" src="/modules/calendar/templates/js/calendar.popup.js"></script>
<script type="text/javascript" src="/modules/property/templates/js/search.js"></script>

<div itemscope itemtype="http://schema.org/ItemList">
<meta itemprop="itemListOrder" content="Descending"/>
</div>

<div class="content-box content-box-search-results">
    <div class="bar-title">
        <h1>SEARCH RESULTS</h1>
		{include file = "`$ROOTPATH`/modules/property/templates/search.view.top-bar.tpl"}
        <div class="clearthis"></div>
    </div>
    <div class="content-details">
        <div class="search-results">
            <ul class="search-list">
                {if isset($results) and is_array($results) and count($results) > 0}
                    {assign var = i1 value = 0}
                    <!-- Duc Coding -->
                    {assign var = isearch value = 0}
                    {assign var = jsearch value = 0}
                    {assign var = pid value = $pid}
                    
                    {foreach from = $results key = k item = property}
                        <!-- Assign And Count -->
                        {assign var = isearch value = $isearch+1}
                        {assign var = i1 value = $i1+1}

                        <script type="text/javascript">ids.push({$property.info.property_id});</script>

                        <li {if $i1==1} class="first" {/if}>
                            <div class="item">
                                <div class="f-left info" style="height:185px !important;">
                                    <div class="title">
                                        <span class="f-left">{$property.info.title}</span>
                                        <span class="price-bold f-right">{$property.info.price}</span>
                                        <div class="clearthis"></div>
                                    </div>
                                
                                    <div class="sr-new-info">
                                        <p>
                                            ID: {$property.info.property_id}
                                        </p>
                                        <p class="detail-icons">
                                            <span class="bed icons">{$property.info.bedroom_value}</span>
                                            <span class="bath icons">{$property.info.bathroom_value}</span>
                                            <span class="car icons">{$property.info.carport_value}</span>
                                            <span style="*margin-top:-15px;float:right;"> Open for Inspection: {$property.o4i}</span>
                                        </p>
                                    </div>
                                    <div class="desc" style="min-height:80px;">
                                        <p class="address-bold"> {$property.info.address_full} </p>
                                        <p style="margin-top:10px;"> {$property.info.description} </p>
                                    </div>
                                

                                    
                                    <div class="tbl-info" style="margin-top:0px;position: absolute;bottom:0px;">
                                    {if $property.info.pro_type == 'auction'}
                                        <div class="acc-s-ie la" style=" background-color: #D9D9D9; width:421px;" id="auc-{$property.info.property_id}" >
                                           {if $property.info.isBlock}
                                                            <p class="acc-sp-ie" id="count-{$property.info.property_id}" style="color: #980000;font-size: 22px; font-weight: bold; text-align: center;margin-top:11px !important;">
                                                                {$property.info.set_count}
                                                            </p>
                                           {else}
                                                <p class="acc-sp-ie" id="auc-time-{$property.info.property_id}" style="color: #980000;font-size: 18px; font-weight: bold; text-align: left; margin-top:8px;*margin-top:2px;;padding-left:10px;" >
                                                -d:-:-:-
                                                </p>
                                           {/if}

                                           {* <script type="text/javascript">
                                                var time_{$property.info.property_id} = {$property.info.remain_time};
                                                var bid_{$property.info.property_id} = new Bid();
                                                bid_{$property.info.property_id}.setContainerObj('auc-{$property.info.property_id}');
                                                bid_{$property.info.property_id}.setTimeObj('auc-time-'+{$property.info.property_id});
                                                bid_{$property.info.property_id}.setBidderObj('auc-bidder-'+{$property.info.property_id});
                                                bid_{$property.info.property_id}.setPriceObj('auc-price-'+{$property.info.property_id});
                                                bid_{$property.info.property_id}.setTimeValue('{$property.info.remain_time}');
                                                bid_{$property.info.property_id}.startTimer({$property.info.property_id});
                                            </script>*}
                                        </div>
                                    {elseif $property.info.pro_type == 'forthcoming'}
                                        <div class="acc-s-ie la" style=" background-color: #D9D9D9; width:421px; margin-top:8px;" id="auc-{$property.info.property_id}" >
                                            {if $property.info.isBlock == 1}
                                                <p class="acc-sp-ie" id="auc-time-{$property.info.property_id}" style="padding-left: 5px;color: #980000;font-size: 28px; font-weight: bold; text-align: center;" >
                                                        -d:-:-:-
                                                </p>
                                            {else}
                                                <p class="acc-sp-ie" style="padding-left: 10px;color: #980000;font-size: 16px; font-weight: bold; text-align: left;" >
                                                    Auction Starts: {$property.info.start_time}
                                                </p>
                                            {/if}
                                        </div>
                                    {/if}
                                        <ul class="f-left col1">
                                            <li>
                                                <span>Livability Rating</span> <span class="spxgreen1" style="float:right"> {$property.info.livability_rating_mark}</span>
                                            </li>
                                        </ul>
                                        <ul class="f-left col2">
                                            <li>
                                                <span>iBB Sustainability</span> <span class="spxgreen2" style="float:right">{$property.info.green_rating_mark}</span>
                                            </li>
                                        </ul>
                                        <div class="clearthis"></div>
                                    </div>

                                    <div class="clearthis"></div>
                                </div>
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
                                {if isset($property.photo) and is_array($property.photo) and count($property.photo) > 0}
                                    <script type="text/javascript">var IS_{$property.info.property_id} = new ImageShow('container_simg_{$property.info.property_id}',{$property.photo|@count},{$property.info.property_id},'img_'+{$property.info.property_id});</script>
                                    
                                    <div class="f-right img" id="container_simg_{$property.info.property_id}">
                                        <div class="img-big-watermark">
                                            {assign var = i value = 1}
                                            {assign var = j value = 0}
                                            {foreach from = $property.photo key = k item = row}
                                                {assign var = is_show value = ';display:none;'}
                                                {if $row.file_name == $property.photo_default}
                                                    {assign var = j value = $i}
                                           	    {/if}
                                                <img id="img_{$property.info.property_id}_{$i}" src="{$MEDIAURL}/{$row.file_name}" alt="{$row.file_name}" style="width:180px;height:130px{$is_show}"/>
                                                {assign var = i value = $i+1}
                                            {/foreach}
                                        </div>
                                        <div class="toolbar-img toolbar-img-ie">
                                            <span class="img-num img-num-ie">1/{$property.photo|@count}</span>
                                            <span class="icons img-prev img-prev-ie" onclick="IS_{$property.info.property_id}.prev()"></span>
                                            <span class="icons img-next img-next-ie" onclick="IS_{$property.info.property_id}.next();"></span>
                                        </div>
                                        {if $j >0}
                                            <script type="text/javascript">
                                                IS_{$property.info.property_id}.focus({$j});
                                            </script>
                                        {/if}
                                    </div>
                                {else}
                                    <div class="f-right img">
                                        <div class="img-big-watermark">
                                            <img src="{$MEDIAURL}/{$property.photo_default}" alt="img" style="width:180px;height:130px"/>
                                        </div>
                                        <div class="toolbar-img toolbar-img-ie">
                                            <span class="img-num img-num-ie">1/1</span>
                                            <span class="icons img-prev img-prev-ie" onclick="IS_{$property.info.property_id}.prev()"></span>
                                            <span class="icons img-next img-next-ie" onclick="IS_{$property.info.property_id}.next();"></span>
                                        </div>
                                    </div>
                                {/if}

                                {if $property.info.confirm_sold }
                                {/if}

                                <div class="sr-new-action sr-view-list" style="position:relative;">
                                 	
                                    <!-- {assign var = fnc_bid value = "document.location='`$property.info.link`'"} -->
                                    
                                	{assign var = fnc_str1 
                                    value = "pro.addWatchlist('/modules/property/action.php?action=add-watchlist&property_id=`$property.info.property_id`')" }
                                    
                                    {if isset($db_checkpartner) and $db_checkpartner.type_id == 3}
                                    	
                                    	<!-- 
                                        {assign var = fnc_bid value = "return showMess('Access denied. Please login as a vendor or buyer to use this function')"}
                                        -->
                                    	{assign var = fnc_str1 value = "return showMess('Access denied. Please login as a vendor or buyer to use this function')"}
                                    {/if}
                                    <button id="view-button-{$property.info.property_id}" class="{if $property.info.check_price == false}btn-view {else} btn-view-green{/if} f-right btn-view-search-list" style="margin-top:7px;" onclick="document.location='{$property.info.link}'">
                                    </button>
                                    <button class="btn-wht f-left btn-wht-search-list" style="margin-right:0px; margin-top:5px;margin-left:13px;width:125px;" onclick="{$fnc_str1}">
                                    	<span><span> Add to Watchlist </span></span>
                                    </button>
                                </div>
                                <div class="clearthis"></div>
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
        {$pag_str}
    </div>
</div>
