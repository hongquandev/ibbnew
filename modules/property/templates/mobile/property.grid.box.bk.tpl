<ul class="{if ($row.kind == 1 and $property_kind == 0)}pro-list pro-list-highlight{else}pro-list{/if}">
<li style="min-height: 230px;">
        <div class="i-info i-info-fl-lan" onclick="document.location='{$row.detail_link}'">
            <div class="title">
                <span class="f-left" style="color:#CC8C04; font-size:14px;">
                    {if !$row.isBlock && !$row.ofAgent}
                        {if $row.pro_type == 'forthcoming' or $row.pro_type == 'auction' }
                            {if $row.auction_type == 'passedin'}
                                {assign var = title value="AUCTION ENDED: `$row.end_time`"}
                            {else}
                                {assign var = title value = "AUCTION ENDS: `$row.end_time` "}
                            {/if}
                        {else}
                            {assign var = title value="FOR SALE: `$row.suburb`"}
                        {/if}
                        {if ($row.confirm_sold == 1 and $row.pro_type != 'sale') }
                            {assign var = title value="AUCTION ENDED: `$row.end_time`"}
                        {/if}
                        {$title}
                    {elseif $row.isBlock}
                        {*OWNER: *}{$row.owner}
                    {else}
                        {$row.auction_title}: {*OWNER: *}{$row.agent.company_name}
                    {/if}
                </span>
                <span class="price-bold f-right"><span>{$row.price}</span>{if $row.pro_type_code == 'ebiddar'}<span class="period">{$row.period}</span>{/if}</span>
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
                <div>
                <span class="wm w-{$row.pro_type_code}"></span>
                <img src="{$MEDIAURL}/{$row.photo_default}" alt="img" class="default-img main-img" onclick="document.location='{$row.detail_link}'" />
                {if $row.isBlock == 1}
                    <img src="/modules/general/templates/images/theblock.png" id="img_mark_block_{$row.property_id}"
                         class="watermark main-img" style="display:block;cursor: pointer;"
                         onclick="document.location='{$row.detail_link}'"/>
                {else}
                    {if $row.auction_type == 'passedin' and !$row.isSold}
                        <img src="/modules/general/templates/images/passedin_list.png"
                             id="img_mark_block_{$row.property_id}" class="watermark watermark-top-left"
                             style="display: block;cursor: pointer;" onclick="document.location='{$row.detail_link}'"/>
                    {/if}
                {/if}
                    <img id="img_mark_{$row.property_id}" class="watermark main-img"
                         style="display:none;cursor: pointer;" onclick="document.location='{$row.detail_link}'"/>
                    {*<img id="img_ebidda_mark_{$row.property_id}" src="{$row.ebidda_watermark}" class="watermark_ebidda"
                         width="57" height="49"
                         style="{if $row.ebidda_watermark != ""}display: block{else}display: none{/if}"/>*}
                </div>
                    <div class="desc desc-list">
                        <p class="address-bold"> {$row.address_full} </p>
                    </div>
                </div>

                {* Begin Add Watermark on Photo of Property*}
                    {if $row.isSold }
                        <script type="text/javascript">
                           jQuery('#auc-time-'+ {$row.property_id},'Sold');
                           jQuery('#count-'+ {$row.property_id},'Sold');
                           {if $row.isRent}
                                AddWatermark('#img_mark_' + {$row.property_id}, 'Rent');
                           {else}
                                AddWatermark('#img_mark_' + {$row.property_id}, 'Sold');
                           {/if}
                        </script>
                    {else}
                        {php}
                        //print_r($this->_tpl_vars['row']);
                        {/php}
                        {if $row.check_price And $row.pro_type == 'auction' AND $row.auction_type != 'passedin' }
                            <script type="text/javascript">
                                AddWatermark('#img_mark_' + {$row.property_id},'OnTheMarket');
                            </script>
                        {/if}
                    {/if}
                {* End Add Watermark on Photo of Property*}
                <div class="clearthis"></div>
            </div>

            <div class="clearthis"></div>

        <div class="pro-form">
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
                    <div class="acc-s-ie g-list-box-ie" style=" background-color: #D9D9D9;margin-top:8px;" id="auc-{$row.property_id}" >
                        <p class="acc-sp-ie" style="padding-left: 5px;color: #980000;font-size: 16px; font-weight: bold; text-align: left;" >
                            Auction Starts: {$row.start_time}
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
                                        Last Bidder: {$row.bidder}
                                        {else}
                                        Current Bidder: {$row.bidder}
                                    {/if}
                                {/if}

                            </p>
                            <p class="bid" id="auc-price-{$row.property_id}">

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
                                {/if} {$row.price}
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
                    <td class="first">
                        <span class="title-star">Open for Inspection: </span>
                        <br />
                        <span id="span-inspection-all" class="span-star">{$row.o4i}</span>
                        <div class="clearthis clearthis-ie7"></div>
                    </td>
                    <td>
                        <span class="title-star">iBB Sustainability</span>
                        <br />
                        <span class="span-star">{$row.green_rating_mark}</span>
                        <div class="clearthis clearthis-ie7"></div>
                    </td>
                </tr>
            </table>
        </div>
    </li>
</ul>
{literal}
<script type="text/javascript">
    $(document).ready(function() {
        var width = $('ul.pro-list').width();
        $('.pro-form img,.default-img').css({
             'max-width' : width , 'height' : 'auto'
        });
        if (jQuery('.loading').length > 0){
            jQuery('.loading').show();
        }
    });
</script>
{/literal}