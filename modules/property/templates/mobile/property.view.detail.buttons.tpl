{literal}
<script type="text/javascript">
    function myReport(id) {
        var width = 700;
        var height = 600;
        var left = (screen.width - width) / 2;
        var top = (screen.height - height) / 2;
        var params = 'width=' + width + ', height=' + height;
        params += ', top=' + top + ', left=' + left;
        params += ', directories=no';
        params += ', location=no';
        params += ', menubar=no';
        params += ', resizable=no';
        params += ', scrollbars=yes';
        params += ', status=no';
        params += ', toolbar=no';
        newwin = window.open(id, '_blank');
        if (window.focus) {
            newwin.focus()
        }
        return false;
    }
</script>
{/literal}
<div class="buttons-col-1">
    {if $property_data.info.confirm_sold == 1}
        {assign var = disabled_button_bid value = "disabled"}
        {assign var = disabled_button_offer value = "disabled"}
        {assign var = disabled_button_buynow value = "disabled"}
    {/if}
    {if $property_data.info.stop_bid == 1}
        {assign var = disabled_button_bid value = "disabled"}
    {/if}
    {if $property_data.info.getTypeProperty == 'live_auction'}
        {assign var = disabled_button_offer value = "disabled"}
        {assign var = disabled_button_buynow value = "disabled"}
    {/if}
    {if $property_data.info.buynow_status == 0 AND $property_data.info.isRentProperty}
        {assign var = disabled_button_buynow value = "disabled"}
    {/if}
    {if !$property_data.info.is_release_time}
        {assign var = disabled_button_offer value = "disabled"}
        {assign var = disabled_button_buynow value = "disabled"}
    {/if}
    <button {$disabled_button_bid}
            onclick="{if $property_data.info.getTypeProperty == 'live_auction'}bid_{$property_data.info.property_id}.click();
                {else}registerToTransact('{$property_data.info.property_id}','register_bid');{/if}"
            type="button" title="Register" class="btn-pv btn-pv-register btn-status-{$disabled_button_bid}">
        <span><span>{if $property_data.info.getTypeProperty == 'live_auction'}Bid{else}Register{/if}</span></span>
    </button>
    <button {$disabled_button_offer} onclick="pro.openMakeAnOffer('#makeanoffer_{$property_data.info.property_id}','{$property_data.info.property_id}','{$agent_id}')"
                                     type="button" title="Offer" class="btn-pv btn-pv-offer  btn-status-{$disabled_button_offer}">
        <span><span>Offer</span></span>
    </button>
    {if $property_data.info.getTypeProperty == 'live_auction'}
        <button {$disabled_button_bid} onclick="registerToTransact('{$property_data.info.property_id}','register_bid')"
                                       type="button" title="Register" class="btn-pv btn-pv-register btn-status-{$disabled_button_bid}">
            <span><span>Register</span></span>
        </button>
    {else}
        {if ($property_data.info.buynow_buyer_id > 0)}
            {assign var = disabled_button_buynow value = "disabled"}
        {/if}
        <button {$disabled_button_buynow} id="buynow-{$property_data.info.property_id}"
                                          onclick="pro.buynow('{$property_data.info.property_id}','{$property_data.info.buynow_price}')"
                                          type="button" title="Buy Now" class="btn-pv btn-pv-buynow btn-status-{$disabled_button_buynow}">
            <span><span>{if $property_data.info.isRentProperty}Rent Now{else}Buy Now{/if}</span></span>
        </button>
    {/if}
    <button onclick="window.location.reload();" type="button" title="Refresh" class="btn-pv btn-pv-refresh">
        <span><span>Refresh</span></span>
    </button>
</div>
<div class="buttons-col-2">
    {*<button class="btn-pv1 btn-pv-inspect" title="Inspect"></button>*}
    {$property_data.info.btn_open_for_inspection}
    {assign var = show_contact_fnc value = "showContact('`$agent_info.agent_id`','`$agent_info.name`','`$agent_info.email`','`$agent_info.telephone`','`$property_data.info.agent_id`','')"}
    {if !$isLogin}
    {assign var = show_contact_fnc value = "showLoginPopup();"}
    {/if}
    <button onclick="{$show_contact_fnc}" class="btn-pv1 btn-pv-contact" title="Contact"></button>
    <button onclick="pro.addWatchlist('/modules/property/action.php/?action=add-watchlist&property_id={$property_data.info.property_id}')"
         class="btn-pv1 btn-pv-watchlist" title="Watchlist">
    </button>
</div>
{$property_data.mao}