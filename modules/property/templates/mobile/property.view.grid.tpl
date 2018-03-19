{literal}
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
                <li class="property-grid-item">
                    <script type="text/javascript">
                        ids.push({$row.property_id});
                    </script>
                    {assign var = isearch value = $isearch+1}
                    {include file = "`$ROOTPATH`/modules/property/templates/property.grid.box.tpl"}
                    {php}
                    $p = @$this->_tpl_vars['pid'];
                    if ($this->_tpl_vars['valueBanner'] > 0) :
                        $chk = ($this->_tpl_vars['isearch'] + $p*$this->_tpl_vars['len']) % $this->_tpl_vars['valueBanner'];
                        if ($chk == 0 && count($this->_tpl_vars['auction_cv']) > 0 ) :
                            $i = ($this->_tpl_vars['isearch'] + $p*$this->_tpl_vars['len']) / $this->_tpl_vars['valueBanner'];
                            $i = $i - 1;
                            $i = $i % count($this->_tpl_vars['auction_cv']);
                            $this->_tpl_vars['arr2'] = $this->_tpl_vars['auction_cv'][$i];
                            {/php}
                            {include file = "`$ROOTPATH`/modules/banner/templates/banner-step.tpl"}
                            {php}
                        endif;
                    endif;
                    {/php}
                    <script type="text/javascript">
                        ids.push({$row.property_id});
                        {if $row.remain_time > 0}
                        var time_{$row.property_id} = {$row.remain_time};
                        var timer_{$row.property_id} = '{$row.count}';
                        {/if}

                        var bid_{$row.property_id} = new Bid();
                        bid_{$row.property_id}.setContainerObj('auc-{$row.property_id}');
                        bid_{$row.property_id}.setTimeObj('auc-time-{$row.property_id}','class');
                        bid_{$row.property_id}.setBidderObj('auc-bidder-{$row.property_id}');
                        bid_{$row.property_id}.setPriceObj('auc-price-{$row.property_id}');
                        bid_{$row.property_id}.setTimeValue('{$row.remain_time}');
                        {if ($row.pro_type == 'auction') && $row.stop_bid == 0 && $row.confirm_sold == 0}
                        bid_{$row.property_id}.startTimer({$row.property_id});
                        {/if}
                        bid_{$row.property_id}._options.transfer = true;
                    </script>
                </li>
            {/foreach}
        {else}
            <div class="message-box message-box-add" style="width: 608px;"><center><i>Sorry, but there are no properties available based on your selection. Please modify the filters to search again. Thanks!</i></center></div>
        {/if}
        </ul>
    </div>
    <div class="clearthis"></div>
    {$pag_str}
</div>

{if in_array($action,array('view-auction-list',
                           'view-sale-list',
                           'search',
                           'search-auction',
                           'search-ebiddar',
                           'search-agent-auction',
                           'search-sale',
                           'view-live_agent-list',
                           'view-forthcoming_agent-list'))}
	<script type="text/javascript">
        {literal}
            jQuery(function(){
                updateLastBidder();
            });
        {/literal}
    </script>
    <script type="text/javascript">
            {literal}
            $(function(){
                jQuery('.btn-bid-green').tipsy({gravity: $.fn.tipsy.autoNS,fallback: " <div style='padding: 5px;text-align: justify'>When the bid button turns green the property is on the market</div>",html: true });
                jQuery('.btn-bid-vendor-green').tipsy({gravity: $.fn.tipsy.autoNS,fallback: " <div style='padding: 5px;text-align: justify'>When the bid button turns green the property is on the market</div>",html: true });
            });
            {/literal}
    </script>
{/if}


