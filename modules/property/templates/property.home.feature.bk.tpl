{if isset($feature_data) and is_array($feature_data) and count($feature_data)>0}
<!--<div class="feature-box">
    <div><h3 class="f-left">FEATURE PROPERTY</h3><h3 class="f-right">{$feature_data.price}</h3></div>
    <br clear="all"/>
    <div class="f-left fea-info">
        <p class="title">
            {$feature_data.address_full}
        </p>
        <p class="content">
            {$feature_data.description}
        </p>
    </div>
    <div class="f-right fea-img" onclick="document.location='{$feature_data.href}'" style="cursor:pointer">
        <span></span>										
        <img src="{$feature_data.file_name}" alt="images" style="width:180px;height:115px"/>
    </div>
    <div class="clearthis">
    </div>
</div>-->
<div class="topselling-box" >
    <div class="bar-title">
        <h2>For Sale</h2>
        <a class="view-more view-all cufon" href="?module=property&action=view-auction-list">VIEW ALL</a>
        <div class="clearthis"></div>
    </div>
    <div id="sli3">
  
    <div class="topselling-list" >
        <ul>
        	<script>var ids = [];</script>
            
        	{if is_array($feature_data) and count($feature_data)>0}
            
        		{assign var = i value = 0}
              	{assign var = k value = 0}
                
            	{foreach from = $feature_data key = k item = data}
                       {if $i == 0}
                	{assign var = cls value = "hide"}
                {else}
                	{assign var = cls value = "show"}
                   
                {/if}
                	
                        <li class="first" >
                 
             			
                            <div class="topselling-item {$cls}">
                            
                                <div class="topsell-img">
                                 	<span class="f-left" style="margin-left:8px; color:#980000">FOR SALE {$data.end_time|date_format:"%d %B %Y"} </span>
									<div class="clearthis"></div>
                                     <div style="float:left">
                                              <p class="detail-icons" style="margin-top:5px; margin-bottom:5px;">
                                              	<span style="float:left; margin-left:6px; margin-right: 42px; "> ID : {$data.property_id} </span>     
                                                <span class="bed icons">{$data.bedroom_value}</span>
                                                <span class="bath icons">{$data.bathroom_value}</span>
                                                <span class="car icons">{$data.carport_value}</span>
                                              </p>
                                              
                                     </div>      
                                     <a href="/?module=property&action=view-auction-detail&id={$data.property_id}"><img src="{$data.file_name}" alt="Photo" style="width:180px;height:115px" onclick="bid_{$data.property_id}.click()" /></a>
                                    
                                </div>
                                
                                <div class="topsell-info" id="auc-{$data.property_id}">
                                        <p class="name" style="min-height:26px; padding:0 5px" title="{$data.address_full}">
                                            {$data.address_short}
                                        </p>
                                        <div align="center" >
                                    		<span style="font-size:14px;  margin-left:55px; margin-right:45px; color:#980000 !important ">{$data.price}</span>
                                  		</div>
                                         <!--<p class="time" style="color:#980000; font-size:16px; font-weight:bold; text-align:center;">
                                                -d:-:-:-
                                         </p>-->
                                </div>	    
                                    
                                <div class="tbl-info tbl-info-home-for-sale">
                                	<ul>
                                    	<li class="livability" style="margin-top:0px; margin-bottom:3px;">
                                             <span style="font-family:Arial,Helvetica,sans-serif; color:#666666; float:left; margin-right: 27px;margin-left:5px; margin-top:1px;"> Livability Rating </span>
                                              <span style=""> {$data.livability_rating_mark}</span>
                                        </li>
                                     </ul>
                                            
                                     <ul>
                                         <li style="margin: 0px 0px 0px 1px;">
                                              <span style="font-family:Arial,Helvetica,sans-serif; color:#666666; float:left; margin-right: 39px;margin-left:5px; margin-top:1px;">Green Rating </span> 
                                               <span style="">{$data.green_rating_mark}</span>
                                         </li>
                                      </ul>
  
                              	</div>
                                
                                   <div class="f-right btn-view-wht-sale-home">
                                      
                                   		<button style="float:right" class="btn-view btn-view-home" onClick="document.location = '/?module=property&action=view-auction-detail&id={$data.property_id}'">
                                        </button>
                                            
                                        <button class="btn-wht btn-wht-home" style="float:left !important;" onclick="pro.addWatchlist('/modules/property/action.php?action=add-watchlist&property_id={$row.property_id}')">
                                            <span style="font-size:12px;"><span style="font-size:12px;">Add to Watchlist</span></span>
                                        </button>
                                        
                                    </div>
                                    <div class="auc-bid">
                                    	<script>
                                    	if ({$data.remain_time}>0)
                                    		{literal}{{/literal}
                                        		ids.push({$data.property_id});
                                    		{literal}}{/literal}
                                    
                                    	var time_{$data.property_id} = {$data.remain_time};
                                    	var bid_{$data.property_id} = new Bid();
                                    	bid_{$data.property_id}.setContainerObj('auc-{$data.property_id}');
                                    	bid_{$data.property_id}.setTimeObj();
                                    	bid_{$data.property_id}.setBidderObj();
                                    	bid_{$data.property_id}.setPriceObj();
                                    	bid_{$data.property_id}.setTimeValue('{$data.remain_time}');
                                    	bid_{$data.property_id}.startTimer({$data.property_id});
                                    
                                    //bid_{$data.property_id}.getLastBidder({$data.property_id});
                                    
                                    </script>
                               	</div>
                            </div>
                        </li>
                    {assign var = i value = $i+1}
                  {/foreach}  
            {/if}

            </ul>

        </div>
        
    </div>
</div>
{/if}