<div class="property-bar-title bar-title">
    <h2>
        <a href="{php}echo isset($_SESSION['redirect_link']) ? $_SESSION['redirect_link'] : '#' ;{/php}"
           class="bar-title-backto" style="text-transform: uppercase">
            < {localize translate="BACK"} {php} echo isset($_SESSION['redirect_link']) ? "TO ".$_SESSION['property_list_title_bar'] : '' {/php}
        </a>
    </h2>
</div>
<div class="hightlight-top-item">
    <h2 class="hightlight-top-item-left f-left">
        {$property_data.info.address_full}
    </h2>
    <div class="hightlight-top-item-right f-right">
        <span class="price">
            <span id="price-{$property_data.info.property_id}">{*{$property_data.info.price}*}{$property_data.info.advertised_price}</span>
            {if in_array($property_data.info.pro_type_code,array('ebiddar','bid2stay'))}
                <span class="period">{$property_data.info.period}</span>
            {/if}
        </span>
    </div>
</div>
