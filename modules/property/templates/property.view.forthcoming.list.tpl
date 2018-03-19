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
    height: 210px;
    position: relative;
    width: 420px;
}
.locat-list .locat-pro {

	float:left !important;
    width: 610px;
}

.tbl-info .col1 li {
    background-color: #D9D9D9;
    margin: 1px 0;
    padding: 4px 10px;
	border:none;
}
.tbl-info .col2 li {
    background-color: #D9D9D9;
    margin: 1px 0;
    padding: 4px 10px;
	border:none;
}
.tbl-info .col1 {
    list-style: none outside none;
    margin-right: 1px;
}
.tbl-info .col2 {
    list-style: none outside none;
}
.tbl-info {
    margin-top: 0px;
    right: 0;
	width:421px;
}
</style>
<script type="text/javascript" src="modules/calendar/templates/js/calendar.popup.js"></script>
<script type="text/javascript">
	var ids = [];
	pro = new Property();
</script>
{/literal}
<div class="auctions-box auctions-box-mof-list">
	{include file = "`$ROOTPATH`/modules/property/templates/property.view.top-bar.tpl"}
    <div class="clearthis"></div>

    <div class="live-forthcomming-list">
        <ul class="locat-list">
            {if isset($property_data) and is_array($property_data) and count($property_data)>0}
                {assign var = k_tmp value = 0}
                
                <!-- Duc Coding -->
                {assign var = jsearch value = 0}
                {assign var = isearch value = 0}
                
                {foreach from = $property_data key = k1 item = row}
                
                    {assign var = isearch value = $isearch+1}
                    <ul class="pro-list">
                        <li>
                            <div class="i-info f-left i-info-fl-lan">
                                <div class="title">
                                    <span class="f-left" style="color:#980000; font-size:14px;">AUCTION ENDS: {$row.end_time}</span>
                                    <span class="price-bold f-right">{$row.price}</span>
                                    {*<span class="f-left" style="color:#980000; font-size:14px;">AUCTION STARTS: {$row.start_time}</span>*}
                                    <div class="clearthis"></div>
                                </div>
                                
                                <div class="sr-new-info">
                                    <p>
                                        ID: {$row.property_id}
                                    </p>
                                    <p class="detail-icons">
                                        <span class="bed icons">{$row.bedroom_value}</span>
                                        <span class="bath icons">{$row.bathroom_value}</span>
                                        <span class="car icons">{$row.carport_value}</span>
                                        <span class="offi-lan" style="float:right;">Open for Inspection: {$row.o4i}</span>
                                    </p>
                                </div>
                                <div class="desc desc-list" style="min-height:108px;">
                                    <p class="address-bold"> {$row.address_full} </p>
                                    <p class="css-word-wrap" style="margin-top:10px;"> {$row.description} </p>
                                </div>
                                <div>
                                    
                                    {assign var = btn_str1 value = "pro.openMakeAnOffer('#makeanoffer_`$row.property_id`','`$row.property_id`')"}
                                    {if  isset($db_checkpartner) and $db_checkpartner.type_id == 3}
                                    	{assign var = btn_str1 value = "return showMess('Access denied. Please login as a vendor or buyer to use this function')"}
                                    {/if}

       
                                    {$row.mao}
                                </div>
                                {$row.isBlock}
                                {if $row.isBlock == 'true'}
                                    <div class="forth-time-bid">
                                        <p class="time" id="auc-time-{$row.property_id}">
                                                        -d:-:-:-
                                        </p>
                                    </div>
                                    <script type="text/javascript">
                                        var time_{$row.property_id} = {$row.remain_time};
                                        var bid_{$row.property_id} = new Bid();
                                        bid_{$row.property_id}.setTimeObj('auc-time-{$row.property_id}');
                                        bid_{$row.property_id}.setTimeValue('{$row.remain_time}');
                                        bid_{$row.property_id}.startTimer({$row.property_id});
                                    </script>
                                {else}
                                    <div class="acc-s-ie" style=" background-color: #D9D9D9; width:421px; margin-top:8px;" id="auc-{$property.info.property_id}" >
                                            <p class="acc-sp-ie" style="padding-left: 10px;color: #980000;font-size: 16px; font-weight: bold; text-align: left;" >
                                            Auction : {$row.start_time}
                                            </p>
                                    </div>
                                {/if}

                                
                                <div class="tbl-info" style="margin-top:0px;">
                                    <ul class="f-left col1">
                                        <li>
                                            <span class="title-star">Livability Rating</span> <span class="span-star"> {$row.livability_rating_mark}</span>
                                            <div class="clearthis clearthis-ie7"></div>
                                        </li>
                                    </ul>
                                    <ul class="f-left col2">
                                        <li>
                                            <span class="title-star">iBB Sustainability</span> <span class="span-star">{$row.green_rating_mark}</span>
                                            <div class="clearthis clearthis-ie7"></div>
                                        </li>
                                    </ul>
                                    <div class="clearthis"></div>
                                </div>
                            </div>
                            {if isset($row.photo) and is_array($row.photo) and count($row.photo) > 0}
                                <script type="text/javascript">
                                var IS_{$row.property_id} = new ImageShow('container_simg_{$row.property_id}',{$row.photo|@count},{$row.property_id},'img_'+{$row.property_id});
                                </script>
                            
                                <div class="f-right img" id="container_simg_{$row.property_id}">
                                    <div class="img-big">
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
                                    <div>
                                        <img src="{$MEDIAURL}/{$row.photo_default}" alt="img" style="width:180px;height:130px"/>
                                    </div>
                                    <div class="toolbar-img"></div>
                                </div>
                            {/if}
                            <div class="sr-new-action sr-new-action-sale-list sr-action-sale-list-lan" style="position:relative;">
                                <button class="btn-view f-right btn-view-sale-list btn-action-view-lan" style="margin-top:159px; margin-right:-180px;"
                                onclick="document.location='/?module=property&action=view-forthcoming-detail&id={$row.property_id}'" >
                                </button>
                                
                                {assign var = btn_str1 value = "pro.addWatchlist('/modules/property/action.php?action=add-watchlist&property_id=`$row.property_id`')"}
                                {assign var = mao_str value = "pro.openMakeAnOffer('#makeanoffer_`$row.property_id`','`$row.property_id`','`$agent_id`')"}
                               {* {if  isset($db_checkpartner) and $db_checkpartner.type_id == 3}
                                	{assign var = btn_str1 value = "return showMess('Access denied. Please login as a vendor or buyer to use this function')"}
                                {/if}*}
                                
                                {if isset($db_checkpartner) and $db_checkpartner.type_id == 3}  
                                    {assign var = mao_str value = "return showMess('Access denied. Please login as a vendor or buyer to use this function')"}    
                                {/if}
                                <button class="btn-wht f-right btn-wht-sale-list btn-action-sale-list-lan" style="margin-right:-115px; margin-top:158px;" onclick="{$btn_str1}" >
                                    <span><span> Add to Watchlist </span></span>
                                </button>
                                <button class="btn-wht btn-make-an-ofer-fl btn-make-an-ofer btn-make-an-ofer-f" onclick="{$mao_str}">
                                        <span><span>Make an Offer</span></span>
                                </button>
                                {$row.mao}

                            </div>
                            
                            <div class="clearthis"></div>
                          <!--  {include file = "`$ROOTPATH`/modules/banner/templates/banner.property.list.tpl"} -->
                          
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
                    </ul>
                {/foreach}
            {/if}
		</ul>
    
       {$pag_str}
    </div>
</div>
<div class="clearthis"></div>


