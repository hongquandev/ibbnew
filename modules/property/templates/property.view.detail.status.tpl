{if $property_data.info.confirm_sold == 0}
    <div class="auction-status-button auction-start-status">{$property_data.info.status_time}</div>
    {if $property_data.info.getTypeProperty == 'live_auction'}
        {*<div onclick="pro.openMakeAnOffer('#makeanoffer_{$property_data.info.property_id}','{$property_data.info.property_id}','{$agent_id}')"
             class="auction-status-button auction-mao-status">MAKE AN OFFER</div>*}
        <div onclick="bid_{$property_data.info.property_id}.click()" class="auction-status-button auction-mao-status">BID</div>
    {/if}
{/if}
{if $property_data.info.property_status == 'sold'}
    <div class="auction-status-button auction-sold-status">THIS PROPERTY HAS BEEN SOLD</div>
{/if}
{if $property_data.info.property_status == 'leased'}
    <div class="auction-status-button auction-leased-status">THIS PROPERTY HAS BEEN LEASED</div>
{/if}
{if $property_data.info.property_status == 'under-offer'}
    <div class="auction-status-button auction-underoffer-status">UNDER OFFER</div>
{/if}