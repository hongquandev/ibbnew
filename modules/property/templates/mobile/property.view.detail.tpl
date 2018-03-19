<link href="{$ROOTURL}/modules/general/templates/js/tab/style.css" rel="stylesheet" type="text/css"/>
{if $item_number}
    <script type="text/javascript">
        {literal}
        jQuery(document).ready(function () {
            term.showPopup('{/literal}{$item_number}{literal}');
        });
        {/literal}
    </script>
{/if}
<script type="text/javascript">
    var media = '{$MEDIAURL}';
    var agent_id = '{$agent_id}';
    var ids = [];
    var pro = new Property();
    var property_id = "{$property_data.info.property_id}";
    ids.push(property_id);
</script>
<script type="text/javascript" src="/modules/calendar/templates/js/calendar.popup.js"></script>
<script type="text/javascript" src="/modules/general/templates/js/calc.js"></script>
<script type="text/javascript" src="/modules/general/templates/js/propose-increment.js"></script>
<script type="text/javascript" src="/modules/general/templates/js/ialert.js"></script>
{*<script type="text/javascript" src="/modules/general/templates/js/ipad.js"></script>*}
<script type="text/javascript" src="/modules/general/templates/js/audio.js"></script>

<script type="text/javascript" src="/modules/general/templates/js/tab/sprinkle.js"></script>

<div id="tabvanilla" class="property-view-detail">
    <ul class="tabnav">
        <li>
            <a href="#info">
                <div>Information</div>
            </a>
        </li>
        <li>
            <a onclick="updateBidHistory('',{$property_data.info.property_id})" href="#bid">
                <div>Bid History</div>
            </a>
        </li>
        <li>
            <a href="#view-more">
                <div>Legals</div>
            </a>
        </li>
    </ul>
    <div style="clear: both"></div>
    <div id="info" class="tabdiv">
        <div class="property-view-detail" id="property-view-detail-{$property_data.info.property_id}">
            {include file="property.view.detail.title.tpl"}
            <div class="clearthis"></div>
            <div class="property-head a-left-right" style="margin-bottom: 0">
                {include file="property.view.detail.head.tpl"}
                <div class="clearthis"></div>
            </div>
            <div class="property-control-buttons">
                {include file="property.view.detail.buttons.tpl"}
                <div class="clearthis"></div>
            </div>
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
            <div class="property-agentdetail">
                {include file="property.view.detail.agentdetail.tpl"}
                <div class="clearthis"></div>
            </div>
            <div class="auction-media">
                {include file="property.view.detail.media.tpl"}
            </div>
        </div>
    </div>
    <div id="bid" class="tabdiv">
        <div class="property-bid-history">
            <div class="property-bid-history-content">
                <div class="bid-title"><h3>Bids History</h3></div>
                {include file="property.view.detail.bidhistory.tpl"}
            </div>
            <div class="loading-overlay"><img src="/modules/general/templates/images/loading3.gif" title="loading" alt="loading"/></div>
        </div>
        <div class="property-control-buttons">
            {include file="property.view.detail.buttons.tpl"}
            <div class="clearthis"></div>
        </div>
        <div class="property-agentdetail">
            {include file="property.view.detail.agentdetail.tpl"}
            <div class="clearthis"></div>
        </div>
    </div>
    <div id="view-more" class="tabdiv">
        {include file="property.viewmore.popup.tpl"}
        <div class="clearthis"></div>
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
    bid_{$property_data.info.property_id}.setTimeObj('auc-time-{$property_data.info.property_id}');
    bid_{$property_data.info.property_id}.setBidderObj('auc-bidder-{$property_data.info.property_id}');
    bid_{$property_data.info.property_id}.setTimeValue('{$property_data.info.remain_time}');
    {if $property_data.info.pro_type == 'auction'}
    //BEGIN COUNTDOWN
    bid_{$property_data.info.property_id}.startTimer({$property_data.info.property_id});
    bid_{$property_data.info.property_id}._options.transfer = true;
    {/if}
    //THE BLOCK || AGENT PROPERTIES
    {if ($property_data.info.isBlock == 1 || ($property_data.info.ofAgent == 1 && $property_data.info.pro_type_code == 'auction'))
    && $property_data.info.confirm_sold == 0}
    /*bid_{$property_data.info.property_id}.setContainer('count-{$property_data.info.property_id}');
     bid_{$property_data.info.property_id}._options.theblock = true;
     var count_{$property_data.info.property_id} = new CountDown();
     count_{$property_data.info.property_id}.container = 'count-{$property_data.info.property_id}';
     count_{$property_data.info.property_id}.bid_button = 'bid_button_{$property_data.info.property_id}';
     count_{$property_data.info.property_id}.button = 'btn_count_{$property_data.info.property_id}';
     count_{$property_data.info.property_id}.property_id = '{$property_data.info.property_id}';*/
    {/if}
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
            jQuery('.tbl-bid-property-view').replaceWith(result);
        },'html');
    }
</script>
{/literal}