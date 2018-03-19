<ul class="{if ($row.kind == 1 and $property_kind == 0)}pro-list pro-list-highlight{else}pro-list{/if}">
    <li style="min-height: 230px;padding-bottom: 0">
    <div class="i-info i-info-fl-lan" onclick="document.location='{$row.detail_link}'">
            <div class="title">
                <span class="f-left title">
                    {$row.show_title}
                </span>
                <span class="price-bold f-right">
                    <span>{*{$row.price}*}{$row.advertised_price}</span>
                    {if in_array($row.pro_type_code, array('ebiddar','bid2stay'))}<span class="period">{$row.period}</span>{/if}
                </span>
                <div class="clearthis"></div>
            </div>
            <div class="sr-new-info">
                <p>
                    <b>ID : {$row.property_id}{if $row.kind == 1} - Commercial{/if}</b>
                </p>
                <p class="detail-icons">
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
                    {*<span class="offi-lan" style="float:right;">Open for Inspection: {$row.o4i}</span>*}
                </p>
            </div>
            <div class="img-mobile" id="container_simg_{$row.property_id}">
                <div class="img-big-watermark-{$row.property_id}">
                    <span class="wm w-{$row.pro_type_code}"></span>
                    {if isset($row.photo) and is_array($row.photo) and count($row.photo) > 0}
                    <a href="{$row.detail_link}">
                         <img id="img_{$row.property_id}_{$i}" src="{$MEDIAURL}/{$row.file_name}" alt="img" class="default-img main-img"/>
                    {else}
                         <img src="{$MEDIAURL}/{$row.photo_default}" alt="img" class="main-img" onclick="document.location='{$row.detail_link}'" />
                    {/if}
                    </a>
                </div>
                    <div class="desc desc-list">
                        <p class="address-bold"> {$row.address_full} </p>
                    </div>
                </div>
                <script type="text/javascript">
                    AddWatermarkReaXml('#img_mark_rea_xml_{$row.property_id}','{$row.reaxml_status}','{$row.property_id}');
                </script>
                {* End Add Watermark on Photo of Property*}
                <div class="clearthis"></div>
            </div>
            <div class="clearthis"></div>
            <div>
                {assign var = btn_str1 value = "pro.openMakeAnOffer('#makeanoffer_`$row.property_id`','`$row.property_id`')"}
                {if  isset($db_checkpartner) and $db_checkpartner.type_id == 3}
                    {*assign var = btn_str1 value = "return showMess('Access denied. Please login as a vendor or buyer to use this function')"*}
                {/if}
                {$row.mao}
            </div>

        <div class="pro-form">
            {if $row.agent && $row.agent.logo != ''}
               <img src="{$MEDIAURL}/{$row.agent.logo}" alt="{$MEDIAURL}/{$row.agent.company_name}"
                    class="agent_logo"
                    style="max-width: 150px" title="Click here to view all property"/>
            {/if}
            {if $row.pro_type == 'forthcoming'}
                {if $row.isBlock == 1}
                    <div class="acc-s-ie g-list-box-ie" style=" background-color: #D9D9D9;margin-top:8px;" id="auc-{$row.property_id}" >
                        {if $row.isSold}
                            <p class="time acc-sp-ie"  style="padding-left: 5px;color: #980000;font-size: 28px; font-weight: bold; text-align: center;" >
                               {if $row.pro_type_code == 'ebiddar'}
                                   <p> Leased </p>
                               {else}
                                   <p> Sold </p>
                               {/if}
                            </p>
                        {else}
                            <p class="time acc-sp-ie" id="auc-time-{$row.property_id}" style="padding-left: 5px;color: #980000;font-size: 28px; font-weight: bold; text-align: center;" >
                                -d:-:-:-
                            </p>
                        {/if}
                    </div>
                {else}
                    <div class="acc-s-ie g-list-box-ie">
                        <p class="acc-sp-ie" style="padding-left: 5px;color: #980000;font-size: 16px; font-weight: bold; text-align: left;" >
                            Status: {$row.start_time}
                        </p>
                    </div>
                {/if}

            {elseif $row.pro_type == 'auction'}
                <table class="tbl-info-table">
                    <tr>
                        <td id="i-time-p" class="i-time first">
                            {if $row.isSold}
                               {if $row.pro_type_code == 'ebiddar'}
                                   <p> Leased </p>
                               {else}
                                   <p> Sold </p>
                               {/if}
                           {else}
                               {if $row.isBlock || ($row.ofAgent AND $row.pro_type_code == 'auction')}
                                    <p id="count-{$row.property_id}">
                                        {$row.set_count}
                                    </p>
                               {else}
                                   {if $row.auction_type != 'passedin'}
                                    <p id="auc-time-{$row.property_id}">
                                        -d:-:-:-
                                    </p>
                                   {else}
                                   <p id="auc-time-{$row.property_id}">
                                        Passed In
                                    </p>
                                   {/if}
                               {/if}
                           {/if}
                        </td>
                        <td>
                            <p class="lasted" id="auc-bidder-{$row.property_id}">
                                {if $row.isLastBidVendor}
                                    Vendor Bid
                                {else}
                                    {if $row.stop_bid == 1 or $row.transition == true}
                                        <span>Last Bidder:</span><strong> {$row.bidder}</strong>
                                        {else}
                                        <span>Current Bidder:</span><strong> {$row.bidder}</strong>
                                    {/if}
                                {/if}
                            </p>
                            <p class="bid" id="auc-price-{$row.property_id}">
                                <span>
                                {if $row.stop_bid == 1 or $row.transition == true or $row.confirm_sold == 1}
                                    {assign var=temp value = 0}
                                    {if $row.stop_bid == 1}
                                        {if $row.bidder == '--'}
                                            Start Price:
                                            {assign var=temp value = 1}
                                        {/if}
                                    {/if}
                                    {if !$temp}Last Bid:{/if}

                                {elseif $row.check_start or $row.bidder == '--'}
                                    Start Price:
                                {else}
                                    Current Bid:
                                {/if}</span><strong> {$row.price}</strong>
                            </p>
                        </td>
                    </tr>
                </table>
            {/if}
            {if $row.check_price}
                <script type="text/javascript">
                    var timer_id_ = "{$row.count}";
                    var id_ = {$row.property_id};
                </script>
                {literal}
                <script type="text/javascript">
                    if(typeof timer_id_ == 'string' && timer_id_ != ''){
                        jQuery('#auc-time-'+id_).addClass('change').css('color','#007700');
                        jQuery('#count-'+id_).addClass('change').css('color','#007700');
                    }
                </script>
                {/literal}
            {/if}
            <table class="tbl-info-table">
                <tr>
                    <td class="first" style="border: 0 none;padding: 10px 0">
                        <span class="title-star">Open for Inspection: &nbsp;</span>
                        <span id="span-inspection-all" class="span-star">{$row.o4i}</span>
                        {if $row.isVendor}
                            <a href="javascript:void(0)"
                               onclick="show_confirm_stop_bidding({$row.property_id},'{$ROOTURL}/?module=property&action=register&step=2&id={$row.property_id}','edit')"
                               style="color: #980000;text-align: right;float: right;text-decoration: underline">
                                Edit Property
                            </a>
                            <s
                        {/if}
                    </td>
                </tr>
            </table>
            <div class="clearthis clearthis-ie7"></div>
        </div>
    </li>
</ul>
<div class="clearthis"></div>
{literal}
<script type="text/javascript">
    $(document).ready(function() {
        var width = $('ul.pro-list').width();
        $('.pro-form img,.default-img,.main-img, .img-banner-g img').css({
             'max-width' : width , 'height' : 'auto','width': '100%'
        }).show();
    });
</script>
{/literal}
