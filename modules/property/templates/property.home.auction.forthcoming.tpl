{literal}
 <script src="utils/slide/slide-homesale.js" type="text/javascript"></script>
{/literal}

{if isset($sale_data) and is_array($sale_data) and count($sale_data)>0}
<div class="property-box">
    <div class="bar-title">
        <h2>FORTHCOMING AUCTIONS<a style="float:right;clear:none;" class="view-more view-more-forthcoming" href="?module=property&action=view-forthcoming-list">VIEW ALL</a></h2>
    </div>
     <div id="sli2">
     
    <div class="property-list">
        <ul>
        	  {if is_array($sale_data) and count($sale_data)>0}
            
        		{assign var = i value = 0}
              	{assign var = k value = 0}
               
            		{foreach from = $sale_data key = k item = data}
                       {if $i == 0}
                	{assign var = cls value = "show"}
                {else}
                	{assign var = cls value = "hide"}
                {/if}
                

                    <li class="first">
                        <div class="property-item {$cls}">
                            <div class="pro-img">
                                <a href="/?module=property&action=view-sale-detail&id={$data.property_id}"><img src="{$data.file_name}" alt="Photo" style="width:180px;height:115px"/></a>
                            </div>
                            <div class="pro-info">
                                <p class="name" title="{$data.address_full}">
                                    {$data.address_short}
                                </p>
                                <p class="pro-icons">
                                    <span class="icons bed">{$data.bedroom_value}</span>
                                    <span class="icons bath">{$data.bathroom_value}</span>
                                    <span class="icons car">{$data.carport_value}</span>
                                </p>
                                <p class="price-viewmore" style="position: absolute;bottom:12px;left:10px;">
                                    <span class="price f-left">{$data.price}</span>
                                    <span class="viewmore icons f-right"><a href="?module=property&action=view-sale-detail&id={$data.property_id}">View more</a></span>
                                    <span class="clearthis"></span>
                                </p>
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