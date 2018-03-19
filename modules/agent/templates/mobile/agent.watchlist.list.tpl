{literal}
    <style type="text/css">
        .search-results .search-list .item .info .desc {
            /*height:75px;*/
            margin-bottom: 3px;
        }
        .search-results .search-list .item {
            /* height:202px;
            padding-bottom: 16px;*/
        }

    </style>
    <script type="text/javascript" src="modules/calendar/templates/js/calendar.popup.js"></script>
    <script type="text/javascript" src="modules/general/templates/mobile/js/confirm.js"></script>

    <script type="text/javascript">
        var pro = new Property();
    </script>
{/literal}
<div class="content-box content-box-watvhlist-l content-box-mof-list agent-list-box">

    {include file = "`$ROOTPATH`/modules/agent/templates/mobile/agent.view.top-bar.tpl"}
    <div class="clearthis"></div>
    <div class="content-details">
        <div class="toolbar">
            <div class="pager">
                <span>{$review_pagging}</span>
            </div>
        </div>
        <div class="locat-list">

            {if isset($message) and strlen($message) > 0}
                <div class="message-box message-box-comment-ie">{$message}</div>
            {/if}

            <script type="text/javascript">var ids = [];</script>
            {if isset($watchlist_data) and is_array($watchlist_data) and count($watchlist_data)>0}
                <ul class="pro-list pro-list-highlight">
                    {foreach from = $watchlist_data key = k item = property}
                        <li class="property-list-item">
                            <div class="info">
                                <!--div class="f-left info" -->
                                <div class="title">

                                    <span class="f-left"><a href="{$property.info.link}">{$property.info.title}</a><span class="note-button" > </span></span>
                                    {if $property.info.type != 'auction'}
                                        <span class="f-right"><strong>{$property.info.price}</strong></span>
                                    {/if}
                                    <div class="clearthis">
                                    </div>
                                </div>

                                <div class="sr-new-info">
                                    <p><b>ID: {$property.info.property_id} {if $property.info.kind == 1} - Commercial{/if}</b> </p>
                                    <p class="detail-icons ">
                                        {if $property.info.kind != 1}
                                            {if $property.info.bedroom_value > 0}
                                                <span class="bed icons">{$property.info.bedroom_value}</span>
                                            {/if}
                                            {if $property.info.bathroom_value > 0 }
                                                <span class="bath icons">{$property.info.bathroom_value}</span>
                                            {/if}
                                        {/if}
                                        {if $property.info.parking == 1}
                                            <span class="car icons">{$property.info.carport_value}</span>
                                        {/if}
                                        {*<span class="icon-ie7" style="float:right;"> Open for Inspection: {$property.info.o4i}</span>*}
                                    </p>

                                </div>
                                    
                                    {if isset($property.photos) and is_array($property.photos) and count($property.photos)>0}
                                        <script type="text/javascript">
                                            var IS_{$property.info.property_id} = new ImageShow('container_simg_{$property.info.property_id}',{$property.photos_count},{$property.info.property_id},'img_'+{$property.info.property_id});
                                        </script>

                                        <div class="img-mobile" id="container_simg_{$property.info.property_id}">
                                            <div >
                                                {assign var = i value = 1}
                                                {assign var = j value = 0}
                                                {foreach from = $property.photos key = k item = row}
                                                    {assign var = is_show value = ';display:none;'}
                                                    {if $row.file_name == $property.photo_default}
                                                        {assign var = j value = $i}
                                                    {/if}
                                                    <a href="{$property.info.link}" style="" >
                                                        <img id="img_{$property.info.property_id}_{$i}" src="{$MEDIAURL}/{$row.file_name|replace:'thumbs/':'crop_'}" alt="img" class="default-img main-img" style="max-width:300px;height:auto;{$is_show}"/>
                                                    </a>
                                                    {assign var = i value = $i+1}

                                                {/foreach}
                                                {if $property.info.isBlock}
                                                    <img src="/modules/general/templates/images/theblock.png" id="img_mark_block_{$property.info.property_id}" class="watermark" style="max-width:300px;height:auto;display: block;cursor: pointer;" onclick="document.location='/?module=property&action=view-auction-detail&id={$property.info.property_id}'"/>
                                                {/if}
                                                <a href="{$property.info.link}" style="" >
                                                    <span class="wm w-{$property.info.auction_sale_code}"></span>
                                                    <img id="img_mark_{$property.info.property_id}"  class="watermark" style="max-width:300px;height:auto;display: none;"/>
                                                    {*<img id="img_ebidda_mark_{$property.info.property_id}" src="{$property.info.ebidda_watermark}" class="watermark_ebidda" width="57" height="49"
                                                         style="{if $property.info.ebidda_watermark != '' } display: block ; {else} display: none;{/if}"/>*}
                                                </a>
                                            </div>
                                            <div class="desc"  >
                                                <p><strong>{$property.info.full_address}</strong></p> 
                                            </div>

                                          {if $j >0}
                                            <script type="text/javascript">
                                                IS_{$property.info.property_id}.focus({$j});
                                            </script>
                                          {/if}
                                        </div>
                                    {else}
                                        <div class="img-mobile">
                                            <div >
                                                <a href="{$property.info.link}" style="" >
                                                    <span class="wm w-{$row.pro_type_code}"></span>
                                                    <img src="modules/property/templates/images/search-img.jpg" alt="img" style="max-width:300px;height:auto;"/>
                                                    {if $property.info.isBlock}
                                                        <img src="/modules/general/templates/images/theblock.png" id="img_mark_block_{$property.info.property_id}" class="watermark" style="max-width:300px;height:auto;display: block;cursor: pointer;" onclick="document.location='/?module=property&action=view-auction-detail&id={$property.info.property_id}'"/>
                                                    {/if}
                                                    <img id="img_mark_fix_{$property.info.property_id}" class="watermark" style="max-width:300px;height:auto;display: none;"/>
                                                    {*<img id="img_ebidda_mark_{$property.info.property_id}" src="{$property.info.ebidda_watermark}" class="watermark_ebidda" width="57" height="49"
                                                         style="{if $property.info.ebidda_watermark != '' } display: block ; {else} display: none;{/if}"/>*}
                                                </a>
                                            </div> 
                                            <div class="desc" >
                                                <p><strong>{$property.info.full_address}</strong></p> 
                                            </div>
                                        </div>

                                    {/if}
                                    
                                <div class="pro-list">    
                                    {* FIx DESC*}
                                    {if $property.info.type == 'auction'}
                                        {assign var = fix_height value="52px"}
                                    {/if}
                                    {if $property.info.type == 'sale' }
                                        {assign var = fix_height value="94px"}
                                    {/if}
                                    {if $property.info.type == 'forthcoming'}
                                        {assign var = fix_height value="79px"}
                                    {/if}
                                    {if $property.info.isBlock == 1 || ($property.info.ofAgent == 1 && $property.info.auction_sale_code == 'auction')}
                                        {assign var = fix_height value="52px"}
                                    {/if}


                                    {if $property.info.transition == true}
                                        <div class="highlight" align="center" style="width: 300px;margin-top: 4px;">
                                            <span style="color:#980000 !important; font-size:12px;font-weight: bold;">This property had been switched to {$property.info.transition_to}</span>
                                        </div>
                                    {else}
                                        {*<div align="center" style="width: 420px;margin-top: 16px;*margin-top: 6px;"></div>*}
                                    {/if}
                                    {if $property.info.type == 'sale'}
                                        <div class="tbl-info" style="display: none;">
                                        </div>
                                        <table class="tbl-info-table">
                                            <tr>
                                                <td class="first">
                                                    <span class="title-star">Open for Inspection: </span> <span id="span-inspection-all" class="span-star">{$property.info.o4i}</span>
                                                    <div class="clearthis clearthis-ie7"></div>
                                                </td>
                                                <td class="{if in_array($property.info.auction_sale_code,array('ebiddar','bid2stay'))}ul-disable{/if}">
                                                    {*<span class="title-star">iBB Sustainability</span><br/><span class="span-star">{$property.info.green_rating_mark}</span>*}
                                                    <div class="clearthis clearthis-ie7"></div>
                                                </td>
                                            </tr>
                                        </table>

                                    {elseif $property.info.type == 'forthcoming'}
                                        <div id="coll3" class="tbl-info tbl-info-new">
                                            {if $property.info.type == 'forthcoming'}
                                                <div class="acc-s-ie acc-s-p" id="auc-{$property.info.property_id}" >
                                                    {if $property.info.isBlock == 1}
                                                        <p class="acc-sp-ie acc-sp-block" id="auc-time-{$property.info.property_id}">
                                                            -d:-:-:-
                                                        </p>
                                                    {else}
                                                        <p class="acc-sp-ie acc-sp-p">
                                                            Auction Starts: {$property.info.start_time}
                                                        </p>
                                                    {/if}
                                                </div>
                                            {/if}

                                            <ul class="col1" style="display: none;">
                                                {if $property.info.type == 'auction'}
                                                    <li class="li-price-ie7 li-price-ie9">
                                                        {if $property.info.isBlock || ($property.info.ofAgent && $property.info.auction_sale_code == 'auction')}
                                                            <p class="acc-sp-ie acc-sp-ie9-bb acc-sp-ie9-bbb acc-sp-ie8-blo acc-sp-all" id="count-{$property.info.property_id}">
                                                                {$property.info.set_count}
                                                            </p>
                                                        {elseif $property.info.auction_sale_code != 'private_sale'}
                                                            <p class="acc-sp-ie acc-sp-ie9-bb acc-sp-ie9-bbb acc-sp-ie8-blo acc-sp-all" id="auc-time-{$property.info.property_id}">
                                                                -d:-:-:-
                                                            </p>
                                                        {elseif $property.info.transition}
                                                            <p class="acc-sp-ie acc-sp-ie9-bb acc-sp-ie9-bbb acc-sp-ie8-blo acc-sp-all" id="switch-auc-time-{$property.info.property_id}">
                                                                Switch
                                                            </p>

                                                        {/if}
                                                    </li>
                                                    {if $property.info.check_price AND $property.info.stop_bid == 0 AND $property.info.confirm_sold == false }
                                                        <script type="text/javascript">
                                                            var id_ = {$property.info.property_id};
                                                            {if $property.info.isBlock || ($property.info.ofAgent && $property.info.auction_sale_code == 'auction')}
                                                                var timer_id_ = "{$property.info.set_count}";
                                                            {else}
                                                                var timer_id_ = "{$property.info.count}";
                                                            {/if}
                                                        </script>
                                                        {literal}
                                                            <script type="text/javascript">
                                                                if(typeof timer_id_ == 'string' && timer_id_ != '' && timer_id_ != "Sold"){
                                                                    jQuery('#auc-time-'+id_).addClass('change').css('color','#007700');
                                                                    jQuery('#count-'+id_).addClass('change').css('color','#007700');
                                                                }
                                                            </script>
                                                        {/literal}
                                                    {/if}
                                                {/if}
                                            </ul>
                                            <ul class="f-left col2" style="display: none;">
                                                {if $property.info.type == 'auction'}
                                                    <li>
                                                        <p class="lasted " id="auc-bidder-{$property.info.property_id}">
                                                            {if $property.info.isLastBidVendor}
                                                                Vendor bid
                                                            {else}
                                                                {if $property.info.stop_bid == 1
                                                                        or $property.info.confirm_sold
                                                                }
                                                                Last Bidder: {$property.info.bidder}
                                                            {else}
                                                                Current Bidder: {$property.info.bidder}
                                                            {/if}
                                                        {/if}
                                                    </p>
                                                    <p class="bid bid-pro-bids-lie9 price-all2" id="auc-price-{$property.info.property_id}">
                                                        <!--$property.info.transition_to-->
                                                        {if $property.info.stop_bid == 1 or $property.info.confirm_sold == true}
                                                            {assign var=temp value = 0}
                                                            {if $property.info.stop_bid == 1}
                                                                {if $property.info.bidder == '--'}
                                                                    Start Price:
                                                                    {assign var=temp value = 1}
                                                                {/if}
                                                            {/if}
                                                        {if !$temp}Last Bid:{/if}

                                                    {elseif $property.info.check_start }
                                                        Start Price:
                                                    {else}
                                                        Current Bid:
                                                    {/if} {$property.info.price}
                                                </p>
                                            </li>
                                        {/if}
                                    </ul>
                                </div>
                                <table class="tbl-info-table">
                                    <tr>
                                        <td class="first"><span class="title-star">Open for Inspection: </span> <span id="span-inspection-all" class="span-star">{$property.info.o4i}</span>
                                            <div class="clearthis clearthis-ie7"></div></td>
                                        <td>
                                            {*<span class="title-star">iBB Sustainability</span><br/><span class="span-star">{$property.info.green_rating_mark}</span>*}
                                            <div class="clearthis clearthis-ie7"></div>
                                        </td>
                                    </tr>
                                </table> 
                                {else} 
                                    {if $property.info.type == 'forthcoming'}
                                        <div class="acc-s-ie" id="auc-{$property.info.property_id}">
                                            {if $property.info.isBlock == 1}
                                                <p class="acc-sp-ie" id="auc-time-{$property.info.property_id}" >
                                                    -d:-:-:-
                                                </p>
                                            {else}
                                                <p class="acc-sp-ie">
                                                    Auction Starts: {$property.info.start_time}
                                                </p>
                                            {/if}
                                        </div>
                                    {/if}
                                    <table class="tbl-info-table">
                                        <tr>
                                            {if $property.info.type == 'auction'}
                                                <td class="first">
                                                    {if $property.info.isBlock || ($property.info.ofAgent && $property.info.auction_sale_code == 'auction')}
                                                        <p class="acc-sp-all" id="count-{$property.info.property_id}">
                                                            {$property.info.set_count}
                                                        </p>
                                                    {elseif $property.auction_sale_code != 'private_sale'}
                                                        <p class="acc-sp-all acc-sp-all-ie" id="auc-time-{$property.info.property_id}">
                                                            -d:-:-:-
                                                        </p>
                                                    {elseif $property.info.transition}
                                                        <p class="acc-sp-all" id="switch-auc-time-{$property.info.property_id}">
                                                            Switch
                                                        </p> 
                                                    {/if}
                                                </td>
                                            {/if}
                                            {if $property.info.check_price AND $property.info.stop_bid == 0 AND $property.info.confirm_sold == false }
                                            <script type="text/javascript">
                                                var id_ = {$property.info.property_id};
                                                {if $property.info.isBlock || ($property.info.ofAgent && $property.info.auction_sale_code == 'auction')}
                                                    var timer_id_ = "{$property.info.set_count}";
                                                {else}
                                                    var timer_id_ = "{$property.info.count}";
                                                {/if}
                                            </script>
                                            {literal}
                                                <script type="text/javascript">
                                                    if(typeof timer_id_ == 'string' && timer_id_ != '' && timer_id_ != "Sold"){
                                                        jQuery('#auc-time-'+id_).addClass('change').css('color','#007700');
                                                        jQuery('#count-'+id_).addClass('change').css('color','#007700');
                                                    }
                                                </script>
                                            {/literal}
                                        {/if}
                                        {if $property.info.type == 'auction'}
                                            <td>
                                                <p class="lasted " id="auc-bidder-{$property.info.property_id}">
                                                    Last Bidder: {$property.info.bidder}
                                                </p>

                                                <p style="font-weight: bold;" class="bid bid-property-price" id="auc-price-{$property.info.property_id}">
                                                    {if $property.info.stop_bid == 1 or $property.info.confirm_sold == true}
                                                        {assign var=temp value = 0}
                                                        {if $property.info.stop_bid == 1}
                                                            {if $property.info.bidder == '--'}
                                                                Start Price:
                                                                {assign var=temp value = 1}
                                                            {/if}
                                                        {/if}
                                                    {if !$temp}Last Bid:{/if}
                                                {elseif $property.info.check_start or $property.info.bidder == '--'}
                                                    Start Price:
                                                {else}
                                                    Current Bid:
                                                {/if} {$property.info.price}
                                            </p>
                                        </td>
                                    {/if}
                                    </tr>
                                </table>    
                                <table class="tbl-info-table">
                                    <tr> 
                                        <td class="first"><span class="title-star">Open for Inspection: </span> <span id="span-inspection-all" class="span-star">{$property.info.o4i}</span>
                                            <div class="clearthis clearthis-ie7"></div>
                                        </td>
                                        <td>
                                            {*<span class="title-star">iBB Sustainability</span><br/><span class="span-star">{$property.info.green_rating_mark}</span>*}
                                            <div class="clearthis clearthis-ie7"></div>
                                        </td>
                                    </tr>
                                </table>


                                {/if}
                                    <div class="clearthis"></div>

                                    <div class="line-bottom">{*color:#990000;*}
                                        {$property.history}
                                        <a href="javascript:void(0)" class="highlight-a-red" onclick="openNote('{$property.info.property_id}')" > Notes(<span id="note_{$property.info.property_id}">{$property.num_note}</span>) </a>
                                        {$property.view_detail}
                                        - <a href="javascript:void(0)" onclick="Common.del('Do you really want to remove this property from your watch list? ?','{$property.info.link_del}')" class="highlight-a-red"> Remove </a>
                                    </div>
                                    <!--/div-->
                                    <div class="clearthis"></div>
                                    <div class="f-right div-list-boxx">

                                        {if $property.info.confirm_sold == false}
                                            {if $property.info.transition == false or ($property.info.can_offer == true and $property.info.transition == true)}
                                                {assign var = mao_str value = "pro.openMakeAnOffer('#makeanoffer_`$property.info.property_id`','`$property.info.property_id`','$agent_id')"}
                                            {else}
                                                {if $property.info.confirm_sold == false}
                                                    {assign var = mao_str value = "showMess(' This property had been switched to `$property.info.transition_to`. You can offer it when this property become live `$property.info.transition_to` !')"}
                                                {/if}
                                            {/if}
                                        {else}
                                            {assign var = mao_str value = "showMess(' This property had been sold !')"}
                                        {/if}


                                        {if $property.info.type == 'auction'}
                                            {assign var = css value = "margin-right:3px;"}
                                        {else} {assign var = css value = "margin-right:-2px;"}
                                        {/if}
                                        {if !$property.info.confirm_sold}
                                            {if $property.info.check_price == false or( $property.info.transition == true)}
                                                {assign var = btn_offer_class value="btn-orange"}
                                            {else}
                                                {assign var = btn_offer_class value="btn-green"}
                                            {/if}

                                            <button id="btn-offer-{$property.info.property_id}" class="{$btn_offer_class} f-right" onclick="{$mao_str}">
                                                <span><span>Offer</span></span>
                                            </button>

                                        {/if}
                                        {$property.info.mao}

                                        {if $property.info.confirm_sold == false}
                                            {if $property.info.transition == false and $property.info.type == 'auction' }
                                                {assign var = btn_str value = "bid_`$property.info.property_id`.click()"}
                                                {if $property.info.remain_time < 0 OR $property.info.stop_bid == 1}
                                                    {if !$property.info.isBlock && !($property.info.ofAgent && $property.info.auction_sale_code == 'auction')}
                                                        <script type="text/javascript">
                                                            jQuery('#auc-time-{$property.info.property_id}').html('Ended');
                                                        </script>
                                                        {if !$property.info.check_price}
                                                            <script type="text/javascript">
                                                                jQuery('#auc-time-{$property.info.property_id}').html('Passed In');
                                                                /*AddMark('#img_mark_' + {$property.info.property_id},"PassedIn");
                                                                AddMark('#img_mark_fix_' + {$property.info.property_id},"PassedIn");*/
                                                                /*jQuery('#img_mark_' + {$property.info.property_id}).attr('src','/modules/general/templates/images/passedin_list.png');
                                                                jQuery('#img_mark_' + {$property.info.property_id}).css('display','block');
                                                                jQuery('#img_mark_fix_' + {$property.info.property_id}).attr('src','/modules/general/templates/images/passedin_list.png');
                                                                jQuery('#img_mark_fix_' + {$property.info.property_id}).css('display','block');*/
                                                            </script>
                                                        {/if}
                                                    {/if}
                                                {else}
                                                    {if $property.info.check_price}
                                                        <script type="text/javascript">
                                                            /*AddMark('#img_mark_' + "{$property.info.property_id}","OnTheMarket");
                                                            AddMark('#img_mark_fix_' + "{$property.info.property_id}","OnTheMarket");*/
                                                            /*jQuery('#img_mark_' + {$property.info.property_id}).attr('src','/modules/general/templates/images/onthemarket_list.png');
                                                            jQuery('#img_mark_' + {$property.info.property_id}).css('display','block');
                                                            jQuery('#img_mark_fix_' + {$property.info.property_id}).attr('src','/modules/general/templates/images/onthemarket_list.png');
                                                            jQuery('#img_mark_fix_' + {$property.info.property_id}).css('display','block');*/
                                                        </script>
                                                    {/if}
                                                {/if}
                                            {else}
                                                {if $property.info.transition_to != 'Sale'}
                                                    {assign var = btn_str value = "showMess(' This property had been switched to `$property.info.transition_to`. You can bid it when this property become live auction !')"}
                                                {else}
                                                    {assign var = btn_str value = "showMess(' This property had been switched to Sale. You can not bid it !')"}
                                                {/if}
                                            {/if}
                                            {if $agent_info.type == 'theblock' && $property.info.isBlock && $property.info.register_bid}
                                                {assign var = btn_str value = "return showMess('Please go to property detail to have full function to bid.')" }
                                            {/if}
                                        {else}
                                            {assign var = btn_str value = "showMess(' This property had been sold !')"}
                                            {if in_array($property.info.auction_sale_code,array('ebiddar','bid2stay'))}
                                                <script type="text/javascript">
                                                    jQuery('#img_mark_' + {$property.info.property_id}).attr('src','/modules/general/templates/images/RENT.png');
                                                    jQuery('#img_mark_' + {$property.info.property_id}).css('display','block');
                                                    jQuery('#img_mark_fix_' + {$property.info.property_id}).attr('src','/modules/general/templates/images/RENT.png');
                                                    jQuery('#img_mark_fix_' + {$property.info.property_id}).css('display','block');
                                                    jQuery('#auc-time-{$property.info.property_id}').html('Leased');
                                                    jQuery('#count-{$property.info.property_id}').html('Leased');
                                                </script>
                                            {else}
                                                <script type="text/javascript">
                                                    jQuery('#img_mark_' + {$property.info.property_id}).attr('src','/modules/general/templates/images/SOLD.png');
                                                    jQuery('#img_mark_' + {$property.info.property_id}).css('display','block');
                                                    jQuery('#img_mark_fix_' + {$property.info.property_id}).attr('src','/modules/general/templates/images/SOLD.png');
                                                    jQuery('#img_mark_fix_' + {$property.info.property_id}).css('display','block');
                                                    jQuery('#auc-time-{$property.info.property_id}').html('Sold');
                                                    jQuery('#count-{$property.info.property_id}').html('Sold');
                                                </script>
                                            {/if}
                                        {/if}

                                        {if $property.info.type == 'auction' AND $property.info.confirm_sold == false AND $property.info.stop_bid == 0 }
                                            {if $property.info.check_price == false or( $property.info.transition == true)}
                                                {assign var = btn_bid_class value="btn-orange"}
                                                {assign var = btn_bid_text value="Bid"}
                                                {if $property.info.register_bid != true}
                                                    {assign var = btn_bid_text value="Register to Bid"}
                                                    {assign var = style_bid_cls value = "float:left !important"}
                                                {/if}
                                            {else}
                                                {assign var = btn_bid_class value="btn-green"}
                                                {if $property.info.register_bid != true}
                                                    {assign var = btn_bid_text value="Register to Bid"}
                                                    {assign var = style_bid_cls value = "float:left !important"}
                                                {/if}
                                            {/if}
                                            <input type="button" id="bid_button_{$property.info.property_id}" class="{$btn_bid_class} f-right btn-bid-new mr-10px" value="{$btn_bid_text}"
                                                    onclick="{$btn_str}" />
                                        {elseif $property.info.type == 'forthcoming'}
                                            {if !$property.info.register_bid}
                                                <input type="button" id="bid_button_{$property.info.property_id}" class="btn-orange f-right btn-bid-new" value="Register to Bid"
                                                       onclick="PaymentBid({$property.info.property_id})"/>
                                            {/if}
                                        {/if}
                                    </div>
                                </div>
                                <div class="clearthis"></div>
                            </div>
                            {if $property.info.transition == false}
                                <script type="text/javascript">

                                    ids.push({$property.info.property_id});

                                    var time_{$property.info.property_id} = '{$property.info.remain_time}';
                                    var timer_{$property.info.property_id} = '{$property.info.count}';
                                    var test = bid_{$property.info.property_id};
                                    {literal}
                                    if (typeof test == 'undefined'){
                                    {/literal}
                                    var bid_{$property.info.property_id} = new Bid();
                                    {if $property.info.isBlock || ($property.info.ofAgent && $property.info.auction_sale_code == 'auction')}
                                        bid_{$property.info.property_id}.setContainer('count-{$property.info.property_id}');
                                        bid_{$property.info.property_id}._options.theblock = true;
                                        {if $property.info.is_mine}
                                            bid_{$property.info.property_id}._options.mine = true;
                                        {/if}
                                            var count_{$property.info.property_id} = new CountDown();
                                            count_{$property.info.property_id}.container = 'count-{$property.info.property_id}';
                                            count_{$property.info.property_id}.bid_button = 'bid_button_{$property.info.property_id}';
                                            count_{$property.info.property_id}.property_id = '{$property.info.property_id}';

                                    {/if}
                                        bid_{$property.info.property_id}.setContainerObj('auc-{$property.info.property_id}');
                                        bid_{$property.info.property_id}.setTimeObj('auc-time-{$property.info.property_id}');
                                        bid_{$property.info.property_id}.setBidderObj('auc-bidder-{$property.info.property_id}');
                                        bid_{$property.info.property_id}.setPriceObj('auc-price-{$property.info.property_id}');
                                        bid_{$property.info.property_id}.setTimeValue('{$property.info.remain_time}');
                                        bid_{$property.info.property_id}.startTimer({$property.info.property_id});
                                    {if $property.info.type == 'forthcoming'}
                                        bid_{$property.info.property_id}._options.transfer = false;
                                        bid_{$property.info.property_id}._options.transfer_template = 'list-watchlist';
                                        bid_{$property.info.property_id}._options.transfer_container = 'auc-{$property.info.property_id}';
                                    {else}
                                        bid_{$property.info.property_id}._options.transfer = true;
                                    {/if}
                                    }
                                </script>
                            {/if}
                            <div class="clearthis"></div>
                        </li>

                        {/foreach}
                </ul>
            {else}
                <ul class="search-list" id="message-height-all">
                    <li class="message-box message-box-add">
                        <center><i>Sorry, but there are no properties available based on your selection.</i></center>
                    </li>
                </ul>
            {/if}
            <script type="text/javascript">updateLastBidder();</script>
            <script type="text/javascript">
                {literal}
                $(function() {
                    //jQuery('.btn-bid-green').tipsy({gravity: $.fn.tipsy.autoNS,fallback: " <div style='padding: 5px;text-align: justify'>When the bid button turns green the property is on the market</div>",html: true });
                    //jQuery('.btn-bid-vendor-green').tipsy({gravity: $.fn.tipsy.autoNS,fallback: " <div style='padding: 5px;text-align: justify'>When the bid button turns green the property is on the market</div>",html: true });
                });
                {/literal}
            </script>
        </div>
        {$pag_str}
    </div>
</div>
{literal}
<script type="text/javascript">
    $(document).ready(function() {
        var width = $('ul.pro-list').width();
        $('.pro-form img,.default-img').css({
             'max-width' : width , 'height' : 'auto'
        });
    });
</script>
{/literal}