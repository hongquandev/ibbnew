<link href="/modules/property/templates/mobile/style/styles.css" type="text/css" rel="stylesheet"/>
<link href="/modules/property/templates/mobile/style/style1.css" type="text/css" rel="stylesheet"/>
{literal}
<style type="text/css">
    .locat-list .pro-list .i-info {
        position: relative;
        /*width: 420px;*/
    }
    .locat-list .pro-list li .tbl-info li{
        border-bottom: 0px;
    }
</style>
{/literal}
<script type="text/javascript">
	var ids = [];
	pro = new Property();
</script>
<ul class="tabs">
    <li><a href="javascript:void(0)" rel="live" class="{if $key == 'live' || $key == ''}defaulttab{/if}">Agency Property Listings</a></li>
    {*<li><a href="javascript:void(0)" rel="forthcoming" class="{if $key == 'forthcoming'}defaulttab{/if}">Forthcoming Auctions</a></li>*}
    {*<li><a href="javascript:void(0)" rel="sale" class="{if $key == 'sale'}defaulttab{/if}">For Sale</a></li>*}
</ul>
{foreach from=$property_data item=property key=k}
<div id="{$k}" class="live-forthcomming-list tab-content">
    <ul class="locat-list">
        {if isset($property) and is_array($property) and count($property) > 0}

            {foreach from = $property key = k1 item = row}
                <script type="text/javascript"> ids.push({$row.property_id}) </script>

            {include file = "`$ROOTPATH`/modules/property/templates/mobile/property.list.box.tpl"}

                {if ($row.pro_type == 'auction') || ($row.isBlock == 1) || $row.ofAgent}
                    {php}
                        if ( !isset($this->_tpl_vars['row']['remain_time']) OR ($this->_tpl_vars['row']['remain_time'])
                        == ""):
                        $this->_tpl_vars['row']['remain_time'] = 0;
                        endif;
                    {/php}
                    <script type="text/javascript">
                        if ({$row.remain_time} > 0 || {$row.isBlock} || {$row.ofAgent})
                        ids.push({$row.property_id});

                        var time_{$row.property_id} = {$row.remain_time};
                        var bid_{$row.property_id} = new Bid();
                        var timer_{$row.property_id} = '{$row.count}';
                            {if $row.isBlock || ($row.ofAgent && $row.pro_type_code == 'auction')}
                            bid_{$row.property_id}.setContainer('count-{$row.property_id}');
                            bid_{$row.property_id}._options.theblock = true;
                            var count_{$row.property_id} = new CountDown();
                            count_{$row.property_id}.container = 'count-{$row.property_id}';
                            count_{$row.property_id}.bid_button = 'btn_bid_{$row.property_id}';
                            count_{$row.property_id}.property_id = '{$row.property_id}';
                                {if $row.isAgent}
                                bid_{$row.property_id}._options.mine = true;
                                {/if}
                            {/if}
                        bid_{$row.property_id}.setContainerObj('auc-{$row.property_id}');
                        bid_{$row.property_id}.setTimeObj('auc-time-{$row.property_id}');
                        bid_{$row.property_id}.setBidderObj('auc-bidder-{$row.property_id}');
                        bid_{$row.property_id}.setPriceObj('auc-price-{$row.property_id}');
                        bid_{$row.property_id}.setTimeValue('{$row.remain_time}');
                        bid_{$row.property_id}.startTimer({$row.property_id});
                            {if $row.pro_type == 'forthcoming'}
                            bid_{$row.property_id}._options.transfer = false;
                            bid_{$row.property_id}._options.transfer_template = 'list';
                            bid_{$row.property_id}._options.transfer_container = 'auc-{$row.property_id}';
                                {else}
                            bid_{$row.property_id}._options.transfer = true;
                            {/if}

                    </script>
                {/if}
            {/foreach}
            {else}
            <div class="message-box message-box-add" style="width: 608px;">
                <center><i>Sorry, but there are no properties available based on your selection. Please modify the
                    filters to search again. Thanks!</i></center>
            </div>
        {/if}
    </ul>
{*{$pag_str}*}
</div>
{/foreach}

<script type="text/javascript">
     {literal}
     $(document).ready(function() {
         $('.tabs a').click(function(){
            switch_tabs($(this));
            //$('#wrap-left, #wrap-right').height($('.wrapper').height());
            //$('#wrap-left, #wrap-right').height($(document).height());
         });
         switch_tabs($('.defaulttab'));
     });

     function switch_tabs(obj) {
         var id = obj.attr("rel");
         $('.tab-content').hide();
         $('.tabs a').removeClass("selected");
         $('#' + id).show();
         obj.addClass("selected");
     }
     jQuery(function() {
         updateLastBidder();
     });
     $(function() {
         jQuery('.btn-bid-green').tipsy({gravity: $.fn.tipsy.autoNS,fallback: " <div style='padding: 5px;text-align: justify'>When the bid button turns green the property is on the market</div>",html: true });
         jQuery('.btn-bid-vendor-green').tipsy({gravity: $.fn.tipsy.autoNS,fallback: " <div style='padding: 5px;text-align: justify'>When the bid button turns green the property is on the market</div>",html: true });
     });
     {/literal}
</script>