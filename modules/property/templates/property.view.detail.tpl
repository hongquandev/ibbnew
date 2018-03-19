<link href="/modules/general/templates/style/styles2.css" type="text/css" rel="stylesheet"/>
{if isset($property_data.info) and is_array($property_data.info) and count($property_data.info) > 0 }
<script type="text/javascript">
    var media = '{$MEDIAURL}';
    var agent_id = '{$agent_id}';
    var ids = [];
    var pro = new Property();
    var property_id = "{$property_data.info.property_id}";
    ids.push(property_id);
</script>
<script type="text/javascript" src="/modules/calendar/templates/js/calendar.popup.js"></script>
{*<script type="text/javascript" src="/modules/general/templates/js/calc.js"></script>
<script type="text/javascript" src="/modules/general/templates/js/propose-increment.js"></script>
<script type="text/javascript" src="/modules/general/templates/js/ialert.js"></script>
<script type="text/javascript" src="/modules/general/templates/js/ipad.js"></script>
<script type="text/javascript" src="/modules/general/templates/js/audio.js"></script>*}

<div class="property-view-detail" id="property-view-detail-{$property_data.info.property_id}">
    {include file="property.view.detail.title.tpl"}
    <div class="clearthis"></div>
    <div class="property-pag-short pag-short" style="margin-bottom: 0" >
        {include file="property.view.detail.links.tpl"}
        <div class="clearthis"></div>
    </div>
    <div class="property-head a-left-right">
        {include file="property.view.detail.head.tpl"}
        <div class="clearthis"></div>
    </div>
    <div class="property-control-buttons">
        {include file="property.view.detail.buttons.tpl"}
        <div class="clearthis"></div>
    </div>
    <div class="property-agentdetail">
        {include file="property.view.detail.agentdetail.tpl"}
        <div class="clearthis"></div>
    </div>
    {if !$property_data.info.isNoSetAuctionTime}
        <div class="property-bid-history">
            <div class="property-bid-history-content">
                <div class="bid-title"><h3>Bids History</h3></div>
                {include file="property.view.detail.bidhistory.tpl"}
            </div>
            <div class="loading-overlay"><img src="/modules/general/templates/images/loading3.gif" title="loading" alt="loading"/></div>
        </div>
        {* {if $property_data.info.pro_type == 'auction'}*}
        <div class="auction-time-bid-rt">
            {include file="property.view.detail.timebid.tpl"}
        </div>
        {*{/if}*}
        <div class="auction-status">
            {include file="property.view.detail.status.tpl"}
        </div>
    {/if}
    <div class="auction-media">
        {include file="property.view.detail.media.tpl"}
    </div>
</div>
<script type="text/javascript">
    {if $property_data.info.remain_time > 0 }
    var time_{$property_data.info.property_id} = {$property_data.info.remain_time};
    var timer_{$property_data.info.property_id} = '{$property_data.info.count}';
    {/if}

    // BID OBJECT INIT
    var bid_{$property_data.info.property_id} = new Bid();
    bid_{$property_data.info.property_id}._options.property_id = {$property_data.info.property_id};
    bid_{$property_data.info.property_id}.setPriceObj('auc-price-{$property_data.info.property_id}');
    bid_{$property_data.info.property_id}.setContainerObj('auc-{$property_data.info.property_id}');
    bid_{$property_data.info.property_id}.setTimeObj('auc-time-{$property_data.info.property_id}','class');
    bid_{$property_data.info.property_id}.setBidderObj('auc-bidder-{$property_data.info.property_id}');
    bid_{$property_data.info.property_id}.setTimeValue('{$property_data.info.remain_time}');
    {if $property_data.info.pro_type == 'auction' && $property_data.info.stop_bid == 0 && $property_data.info.confirm_sold == 0}
    //BEGIN COUNTDOWN
    bid_{$property_data.info.property_id}.startTimer({$property_data.info.property_id});
    {/if}
    bid_{$property_data.info.property_id}._options.transfer = true;
    //AJAX UPDATE = REALTIME
    updateLastBidder();

</script>
{literal}
<script type="text/javascript">
    jQuery(document).ready(function () {
        {/literal}{if $item_number}{literal}
        term.showPopup('{/literal}{$item_number}{literal}');
        {/literal}{/if}{literal}
        updateBidHistory('',property_id);
    });
    function updateBidHistory(url,property_id){
        if(url == ''){
            url = ROOTURL + '/modules/general/action.php?action=updateBidViewAction&property_id='+property_id;
        }
        jQuery('.loading-overlay','.property-bid-history').show();
        jQuery.post(url,{},function(data){
            jQuery('.loading-overlay','.property-bid-history').hide();
            var result = jQuery.parseJSON(data);
            jQuery('#tbl-bid-property-view').replaceWith(result);
        },'html');
    }
</script>
{/literal}
{else}
    <div class="message-box message-box-add"><center><i>Sorry, but there are no properties available based on your selection. Please modify the filters to search again. Thanks!</i></center></div>
{/if}
