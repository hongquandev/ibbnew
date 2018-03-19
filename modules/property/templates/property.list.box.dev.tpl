<ul class="property-list-item property-list-item-{$row.property_id}">
    <li class="property-i">
        <a href="{$row.detail_link}">
            <div class="hightlight-top-item">
                <h2 class="hightlight-top-item-left f-left"><span itemprop="itemListElement">{$row.address_full}</span></h2>
                <div class="hightlight-top-item-right f-right">
                    <span class="price-bold">
                        <span id="price-bold-{$row.property_id}">{*{$row.price}*}{$row.advertised_price}</span>
                        {if in_array($row.pro_type_code,array('ebiddar','bid2stay'))}
                            <span class="period">{$row.period}</span>
                        {/if}
                    </span>
                </div>
            </div>
        </a>
        <div class="clearthis"></div>
        <div class="i-info-left f-left">
            <div class="title">
                <span class="title-span">
                    {$row.show_title}
                </span>
                <div class="clearthis"></div>
            </div>
            <div class="more-detail-info">
                <span class="detail-id">
                    ID : {$row.property_id}{if $row.kind == 1} - {localize translate="Commercial"}{/if}
                </span>
                <span class="detail-icons">
                    {if $row.kind != 1}
                        {if $row.bedroom_value > 0 }
                            <span class="bed icons">{$row.bedroom_value}</span>
                        {/if}
                        {if $row.bathroom_value > 0}
                            <span class="bath icons">{$row.bathroom_value}</span>
                        {/if}
                    {/if}
                    {if $row.parking == 1}
                        <span class="car icons">{$row.carport_value}</span>
                    {/if}
                </span>
            </div>
        </div>
        {if $row.getTypeProperty == 'live_auction'}
        <div class="f-right i-info-right ">
            <div class="btn-live"><a href="#">LIVE</a></div>
        </div>
        {/if}
        <div class="clearthis"></div>
        <div class="description">
            <div class="description-wrap">
                {php}$this->_tpl_vars['row']['description'] = strip_tags($this->_tpl_vars['row']['description']);{/php}
                {$row.description}
            </div>
        </div>
        <div class="clearthis"></div>
        <div class="f-left agent-list-info">
            <div class="agent-list-info-main">
                {if $row.agent && $row.agent.logo != ''}
                    <a href="{$row.agent.link}"><img src="{$MEDIAURL}/{$row.agent.logo}" style="max-width: 190px;width: 100%;height: auto" alt="{$MEDIAURL}/{$row.agent.company_name}" title="Click here to view all property"/></a>
                {/if}
            </div>

        </div>
        <div class="f-right images-list-info">
            <script type="text/javascript">var IS_{$row.property_id} = new ImageShow('container_simg_{$row.property_id}',{$row.photo|@count},{$row.property_id},'img_'+{$row.property_id});</script>
            <div class="img" id="container_simg_{$row.property_id}" itemscope itemtype="http://schema.org/ImageObject">
                <div class="img-big-watermark img-big-watermark-{$row.property_id}">
                    <a href="{$row.detail_link}">
                        {assign var = i value = 1}
                        {assign var = j value = 0}
                        {foreach from = $row.photo key = k item = rx}
                            {assign var = is_show value = ';display:none;'}
                            {if $rx.file_name == $row.photo_default}
                                {assign var = j value = $i}
                                {assign var = is_show value = ';display:block;'}
                            {/if}
                            <img id="img_{$row.property_id}_{$i}" src="{$MEDIAURL}/{$rx.file_name}" alt="property {$row.property_id}" style="cursor:pointer;width:300px;height:192px{$is_show}" itemprop="contentURL" />
                            {assign var = i value = $i+1}
                        {/foreach}
                    </a>
                </div>
                <div class="toolbar-img toolbar-img-list">
                    <span class="img-prev" onclick="IS_{$row.property_id}.prev()"> < </span>
                    <span class="img-num img-num-ie">1/{$row.photo|@count}</span>
                    <span class="img-next" onclick="IS_{$row.property_id}.next();"> > </span>
                </div>
                {if $j >0}
                    <script type="text/javascript">
                        IS_{$row.property_id}.focus({$j});
                    </script>
                {else}
                    <script type="text/javascript">
                        IS_{$row.property_id}.focus(1);
                    </script>
                {/if}
            </div>
            <script type="text/javascript">
                AddWatermarkReaXml('#img_mark_rea_xml_{$row.property_id}','{$row.reaxml_status}','{$row.property_id}');
            </script>
        </div>
        <div class="clearthis"></div>
        {assign var = mao_str value = "pro.openMakeAnOffer('#makeanoffer_`$row.property_id`','`$row.property_id`','`$agent_id`')"}
        {assign var = buynow_str value = "pro.buynow('`$row.property_id`','`$row.buynow_price`')"}
        {*{assign var = bid_str value = "PaymentBid(`$row.property_id`)"}*}
        {assign var = bid_str value = "bid_`$row.property_id`.click()"}
        {if $row.confirm_sold == 1}
            {assign var = bid_str value = "return showMess('This property is sold. You can not register to bid.')"}
            {assign var = mao_str value = "return showMess('This property is sold. You can not offer.')"}
            {assign var = buynow_str value = "return showMess('This property is sold. You can not Buy/Rent Now.')"}
        {elseif $row.stop_bid == 1}
            {assign var = bid_str value = "return showMess('This property is sold. You can not register to bid.')"}
        {elseif $row.getTypeProperty == 'live_auction'}
            {assign var = mao_str value = "return showMess('This property is live. You can not offer.')"}
            {assign var = buynow_str value = "return showMess('This property is live. You can not Buy/Rent Now.')"}
        {/if}
        {if $row.buynow_status == 0 AND !in_array($row.pro_type_code,array('ebidda30')) }
        {assign var = buynow_str value = "return showMess('This button is not enabled. You can not Buy/Rent Now.')"}
        {/if}
        {if ($row.buynow_buyer_id > 0)}
            {assign var = buynow_str value = "return showMess('You can not Buy/Rent Now.')"}
        {/if}
        {if $row.buynow_price == "\$0"}
            {assign var = buynow_str value = "return showMess('You can not Buy/Rent Now.')"}
        {/if}
        {if !($row.list_price > 0) }
            {assign var = mao_str value = "return showMess('You can not offer.')"}
        {/if}
        <div class="button-list">
            <button onclick="pro.addWatchlist('/modules/property/action.php?action=add-watchlist&property_id={$row.property_id}')" class="btt-list btt-list-awl" title="Add to Wishlist"></button>
            <button onclick="document.location='{$row.detail_link}'" class="btt-list btt-list-view" title="View"></button>
            <button onclick="{$mao_str}" class="btt-list btt-list-offer" title="Offer"></button>
            <button onclick="registerToTransact('{$row.property_id}','register_bid')" class="btt-list btt-list-register" title="Register"></button>
            {if !$row.isSold &&  !($row.buynow_buyer_id > 0)}
            <button onclick="{$buynow_str}"  class="btt-list {if in_array($row.pro_type_code,array('ebidda30'))}btt-list-buynow{else}btt-list-rentnow{/if}" title="Buy Now"></button>
            {/if}
            <button onclick="{if $authentic.id>0}showContact('{$authentic.id}','{$authentic.full_name}','{$authentic.email_address}','{$authentic.telephone}','{$row.agent_id}','');{else}showLoginPopup();{/if}" class="btt-list btt-list-contact" title="Contact"></button>
            {$row.mao}
        </div>
        <div class="clearthis"></div>
        <div class="status-panel">
            <div class="status-list"><span class="label">Status: </span><span class="value">{*{$row.start_time}*}{$row.title_status}</span></div>
            <div class="opi"><span class="label">Open for inspection: </span><span class="value">Contact vendor</span></div>
        </div>
    </li>
</ul>
<div class="clearthis"></div>
