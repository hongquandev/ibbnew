<div class="auctions-list">
    <ul class="locat-list">
    {if is_array($auction_data) and count($auction_data)>0}
        {foreach from = $auction_data key = k item = row}
            <li class="property-list-item">
            {include file = "`$ROOTPATH`/modules/property/templates/mobile/property.grid.box.tpl"}

            {if $action == 'home_auction'}
                <script type="text/javascript">
                   if ({$row.remain_time} > 0 || {$row.isBlock} == 1)
                                ids.push({$row.property_id});
                            var id_ = "{$row.property_id}";
                            {literal}
                            if(typeof self['bid_'+id_] == 'object')
                            {
                                self['bid_'+id_].stopTimer();
                                delete (self['bid_'+id_]._options);
                            }
                            {/literal}
                            var time_{$row.property_id} = {$row.remain_time};
                            var bid_{$row.property_id} = new Bid();
                            var timer_{$row.property_id} = '{$row.count}';
                            {if $row.isBlock == 1 || ($row.ofAgent == 1 && $row.pro_type_code == 'auction')}
                                bid_{$row.property_id}.setContainer('count-{$row.property_id}');
                                bid_{$row.property_id}._options.theblock = true;
                                var count_{$row.property_id} = new CountDown();
                                    count_{$row.property_id}.container = 'count-{$row.property_id}';
                                    count_{$row.property_id}.property_id = '{$row.property_id}';

                            {/if}
                            bid_{$row.property_id}.setContainerObj('auc-{$row.property_id}');
                            bid_{$row.property_id}.setTimeObj('auc-time-{$row.property_id}');
                            bid_{$row.property_id}.setBidderObj('auc-bidder-{$row.property_id}');
                            bid_{$row.property_id}.setPriceObj('auc-price-{$row.property_id}');
                            bid_{$row.property_id}.setTimeValue('{$row.remain_time}');
                            bid_{$row.property_id}.startTimer({$row.property_id});
                            bid_{$row.property_id}._options.type = "auction";
                            {if $row.pro_type == 'forthcoming'}
                                bid_{$row.property_id}._options.transfer = false;
                                bid_{$row.property_id}._options.transfer_template = 'grid';
                                bid_{$row.property_id}._options.transfer_container = 'auc-{$row.property_id}';
                            {else}
                                bid_{$row.property_id}._options.transfer = true;
                            {/if}

                </script>
            {elseif $action == 'home_forthcoming'}
                <script type="text/javascript">
                    {if ($row.isBlock == 1)}
                        /*alert(typeof self['bid_{$row.property_id}']);*/
                        var id_ = "{$row.property_id}";
                        {literal}
                        if(typeof self['bid_'+id_] == 'object')
                        {
                            self['bid_'+id_].stopTimer();
                            delete (self['bid_'+id_]._options);
                        }
                        {/literal}
                        ids.push({$row.property_id});
                        var time_{$row.property_id} = {$row.remain_time};
                        var bid_{$row.property_id} = new Bid();
                        bid_{$row.property_id}._options.theblock = true;
                        bid_{$row.property_id}.setTimeObj('auc-time-{$row.property_id}');
                        bid_{$row.property_id}.setTimeValue('{$row.remain_time}');
                        bid_{$row.property_id}.startTimer({$row.property_id});
                        bid_{$row.property_id}.setContainer(null);
                        bid_{$row.property_id}._options.type = "forthcoming";
                        bid_{$row.property_id}._options.transfer = true;
                    {/if}
                </script>
            {elseif $action == 'home_sale'}
                <script type="text/javascript">
                    ids.push({$row.property_id});

                </script>
            {/if}
            </li>
        {/foreach}
    {/if}
    
    </ul>
    {if $action == 'home_auction' or $action == 'home_sale'}
    <script type="text/javascript">stopTimerGlobal();updateLastBidder();</script>
    {/if}
</div>
    
