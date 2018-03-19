
<div itemscope itemtype="http://schema.org/ItemList">
<meta itemprop="itemListOrder" content="Descending"/>
</div>

<div class="content-box">
    <div class="bar-title"><h1>SEARCH RESULTS</h1></div>
    <div class="content-details">
        <div class="toolbar">
            <div class="pager">
                <span>{$review_pagging}</span>
            </div>
        </div>
        <div class="search-results">
            <ul class="search-list">
            	{if isset($results) and is_array($results) and count($results)>0}
                	{assign var = i1 value = 0}
                	{foreach from = $results key = k item = property}
                    	{assign var = i1 value = $i1+1}
                        <li {if $i1==1} class="first" {/if}>
                            <div class="item">
                                <div class="f-left info">
                                    <div class="title">
                                        <span class="f-left"><a href="{$property.infos.link}">AUCTION 28 September 2010</a></span>
                                        <span class="f-right">{$property.infos.pricerange_value}</span>
                                        <div class="clearthis">
                                        </div>
                                    </div>
                                    <div class="desc">
                                    	{assign var = property_address value = "`$property.infos.address`, `$property.infos.suburb`, `$property.infos.state_name`, `$property.infos.postcode`"}
                                        {$property_address} terrace, close to wonderful Mailing Road, blah, Blah, blah, blah, 2 bathrooms, gorgeous open fireplace,...
                                    </div>
                                    <div class="tbl-info">
                                        <ul class="f-left col1">
                                            <li>
                                                <span>{$property.infos.bedroom_value} Bedroom</span>
                                            </li>
                                            <li>
                                                <span>{$property.infos.bathroom_value} Bathroom</span>
                                            </li>
                                            <li>
                                                <span>{$property.infos.carport_value} Car parks</span>
                                            </li>
                                        </ul>
                                        <ul class="f-left col2">
                                            <li>
                                                <span>{$property.infos.landsize_title}</span>
                                            </li>
                                            <li>
                                                <span>iBB Livability Rating</span>
                                            </li>
                                            <li>
                                                <span>iBB Green Rating</span>
                                            </li>
                                        </ul>
                                        <div class="clearthis">
                                        </div>
                                    </div>
                                </div>
                                {if isset($property.photos) and is_array($property.photos) and count($property.photos)>0}
                                <script type="text/javascript">
								var IS_{$property.infos.property_id} = new ImageShow('container_simg_{$property.infos.property_id}',{$property.photos_count});
                                </script>
                                
                                <div class="f-right img" id="container_simg_{$property.infos.property_id}">
                                    <div  class="img-big">
                                        {assign var = i value = 1}                     
                                    	{foreach from = $property.photos key = k item = row}
                                        	{assign var = is_show value = ';display:none;'}
                                        	{if $i==1}
                                            	{assign var = is_show value = ''}
                                            {/if}
                                        	<img id="img_{$i}" src="{$MEDIAURL}/{$row.file_name}" alt="img" style="width:180px;height:130px{$is_show}"/>
                                            {assign var = i value = $i+1} 
                                        {/foreach}
                                       
                                    </div>
                                    <div class="toolbar-img toolbar-img-ie">
                                        <span class="img-num img-num-ie">1/{$property.photos_count}</span>
                                        <span class="icons img-prev img-prev-ie" onclick="IS_{$property.infos.property_id}.prev()"></span>
                                        <span class="icons img-next img-next-ie" onclick="IS_{$property.infos.property_id}.next();"></span>
                                    </div>
                                </div>
                                {else}
                                <div class="f-right img">
                                    <div>
                                        <img src="modules/property/templates/images/search-img.jpg" alt="img" style="width:180px;height:130px"/>
                                    </div>
                                    <div class="toolbar-img">
                                    </div>
                                </div>
                                {/if}
                                <div class="clearthis">
                                </div>
                            </div>
                        </li>
                	{/foreach}
               {/if}
                
            </ul>
        </div>
        {$pag_str}
    </div>
</div>
