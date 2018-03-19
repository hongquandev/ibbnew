{if $property_data.info.release_time}
    <div style="color: #017db9;margin-bottom: 10px" class="release-time-label">
        {if $property_data.is_release_time}Released{else}Release{/if} Date: {$property_data.info.release_time}</div>
{/if}
<div class="a-left-title">
    {$property_data.info.title}
</div>
<br />
<div style="display: inline-block;margin-right: 10px" class="a-left-info">
    <div style="display: inline-block;margin-right: 5px" class="propertyid">ID: {$property_data.info.property_id}</div>
    <div style="display: inline-block" class="detail-icons">
        {if $property_data.info.kind != 1}
            {if $property_data.info.bedroom_value > 0}
                <span class="bed icons" id="bed_ic1">{$property_data.info.bedroom_value}</span>
            {/if}
            {if $property_data.info.bathroom_value > 0 }
                <span class="bath icons" id="bed_ic2">{$property_data.info.bathroom_value}</span>
            {/if}
        {/if}
        {if $property_data.info.parking == 1}
            <span class="car icons" id="bed_ic3">{$property_data.info.carport_value}</span>
        {/if}
        {if $property_data.info.land_size > 0}
            <span style="color: #017db9" class="landsize">&nbsp; Land size {$property_data.info.land_size}</span>
        {/if}
        {if $property_data.info.frontage > 0}
            <span style="color: #017db9" class="landsize">&nbsp; Frontage {$property_data.info.frontage}m</span>
        {/if}
    </div>
</div>
<div style="display: inline-block;margin-right: 5px" class="a-right-visits">{localize translate="Visits"} : <span id="view-no"> {$property_data.info.views}</span></div>
<div style="display: inline-block" class="a-right-bids">
    {if $property_data.info.pro_type == 'auction'}
        {localize translate="Bids"}:
        <span id="bid-no-{$property_data.info.property_id}"> {$property_data.info.bids}</span>
    {/if}
</div>
