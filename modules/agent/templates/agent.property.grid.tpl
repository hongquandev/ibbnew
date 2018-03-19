{literal}
<style type="text/css">
.auctions-box .auctions-list .auction-item {
    /*background: url("modules/general/templates/images/auction-bg.jpg") no-repeat scroll 0 0 transparent;
    height: 294px;
    padding: 4px;*/
    position: relative;
    /*width: 192px;*/
}

/*.auctions-box .make-an-offer-popup {
    margin: -218px 0 0 -105px !important;
}*/

.auctions-box .auctions-list ul li {
    /*display: inline-block;*/
    float:left;
    margin: 2px 7px 2px 1px;
}
.popup_container #contact_wrapper{
    width:300px;
}

/*.popup_container .title{
    width:280px;
}*/
.popup_container .frm-mao{
    width:288px;
}
.view-search-list {
    margin-left: 45px !important;
}

</style>
<script type="text/javascript">
    var pro = new Property();
    var ids = [];
</script>
<script type="text/javascript" src="modules/general/templates/js/confirm.js"></script>

{/literal}

<div class="auctions-box watchlist-box watchlist-box-mof-gird agent-grid-box">

    {include file = "`$ROOTPATH`/modules/agent/templates/agent.view.top-bar.tpl"}
    <div class="clearthis"></div>

    <div class="auctions-list" style="margin-left:-2px;">
        <div class="toolbar">
            <div class="pager" id="pager-acc-proerty">
                 {if $page != 'view-auction'}
                        <button style="float:left;" class="btn-red btn-red-my-properties" onclick="check.regPro('/?module=package')">
                            <span><span> Register New Property </span></span>
                        </button>

                {/if}
                <span style="float:right;" class="pager-acc-property">{$review_pagging}</span>
            </div>
        </div>
        <div class="clearthis"></div>
        <div class="auctions-list">
            {if isset($message) and strlen($message) > 0}
                    <div class="message-box message-box-comment-ie">{$message}</div>
            {/if}
            <ul>
            	    {if isset($results) and is_array($results) and count($results)>0}
                	{assign var = i1 value = 0}
                	{foreach from = $results key = k item = property}
                    	{assign var = i1 value = $i1+1}
                        <li class="{if $i1==1}first{/if} property-grid-item">
                            <div class="auction-item {if $property.info.kind == 1}auction-item-pro-grid-hl{/if} auction-item-pro-grid">
                                <div class="hightlight-top-item">
                                    <div class="hightlight-top-item-top">
                                        {$property.info.full_address}
                                    </div>
                                    <div class="hightlight-top-item-bottom">
                                        <span class="price-bold">
                                            <span id="price-bold-{$property.info.property_id}">{$property.info.bid_price}</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="watchlist-img-watermark">
                                    <span class="wm w-{$property.info.auction_sale_code}"></span>
                                    {if isset($property.photos) and is_array($property.photos) and count($property.photos)>0}
                                        <script type="text/javascript">
                                            var IS_{$property.info.property_id} = new ImageShow('container_simg_{$property.info.property_id}', {$property.photos_count});
                                        </script>
                                        {assign var = i value = 1}
                                        {foreach from = $property.photos key = k item = row}
                                            {assign var = is_show value = ';display:none;'}
                                            {if $i==1}
                                                {assign var = is_show value = ''}
                                            {/if}
                                            <img id="img_{$i}" src="{$MEDIAURL}/{$row.file_name}" alt="img"
                                                 style="width:300px;height:182px{$is_show}"/>
                                            {assign var = i value = $i+1}
                                        {/foreach}
                                    {*{if $property.photos_count >0}
                                            <script type="text/javascript">
                                                IS_{$property.info.property_id}.focus(1);
                                            </script>
                                    {/if}*}
                                        {if $j >0}
                                            <script type="text/javascript">
                                                IS_{$property.info.property_id}.focus({$j});
                                            </script>
                                        {/if}
                                    {else}
                                        <img src="modules/property/templates/images/search-img.jpg" alt="img"
                                             style="width:300px;height:182px"/>
                                    {/if}
                                    <div class="clearthis"></div>
                                </div>
                                <div class="clearthis"></div>
                                <div class="toolbar-img">
                                    <div class="toolbar-img-cont">
                                        <span class="img-num img-num-ie">1/1</span>
                                        <span class="icons img-prev img-prev-ie img-prev-ie-lfl" onclick="IS_{$property.info.property_id}.prev()"></span>
                                        <span class="icons img-next img-next-ie img-next-ie-lfl" onclick="IS_{$property.info.property_id}.next();"></span>
                                    </div>
                                </div>
                                <div class="clearthis"></div>
                                <div class="btn-panel-ct1">
                                    {if $property.info.type == 'sale'}
                                        <button id="edit-button-search-{$property.info.property_id}"
                                                class="btn-edit-red f-left btn-view-search-list"
                                                style="margin-top:0px;"
                                                onclick="show_confirm_stop_bidding({$property.info.property_id},'{$property.info.link}','edit')"></button>
                                        {if $property.info.pay_status == 'complete'  }
                                            <button id="remove-button-{$property.info.property_id}"
                                                    class="btn-remove f-left btn-view-search-list"
                                                    style="margin-top:0px;margin-right: 5px"
                                                    onclick="showMess('You can not remove this property !')"></button>
                                        {else}
                                            <button id="remove-button-{$property.info.property_id}"
                                                    class="btn-remove f-left btn-view-search-list"
                                                    style="margin-top:0px;margin-right: 5px"
                                                    onclick="show_confirm('{$property.info.link_del}','Do you really want to delete this property ?')"></button>
                                        {/if}
                                    {else}
                                        {if $property.info.pay_status != 'complete'}
                                            <button id="remove-button-{$property.info.property_id}"
                                                    class="btn-remove f-left btn-view-search-list"
                                                    style="margin-top:0px;margin-right: 5px"
                                                    onclick="show_confirm('{$property.info.link_del}','Do you really want to delete this property ?')"></button>
                                            <button id="edit-button-search-{$property.info.property_id}"
                                                    class="btn-edit-red f-left btn-view-search-list"
                                                    style="margin-top:0px;"
                                                    onclick="document.location='{$property.info.link}'"></button>
                                        {else}
                                            <button id="cancel-button-{$property.info.property_id}"
                                                    class="btn-cancel-bidding f-left btn-view-search-list"
                                                    style="margin-top:0px;margin-right: 5px"
                                                    onclick="show_confirm_stop_bidding({$property.info.property_id},'{$property.info.link_cancel_bidding}','')"></button>
                                            <button id="edit-button-search-{$property.info.property_id}"
                                                    class="btn-edit-red f-left btn-view-search-list"
                                                    style="margin-top:0px;"
                                                    onclick="show_confirm_stop_bidding({$property.info.property_id},'{$property.info.link}','edit')"></button>
                                        {/if}
                                    {/if}
                                </div>
                                <div class="clearthis"></div>
                                <div class="title">
                                    <div>
                                         <span style="float:left"><b>ID : {$property.info.property_id}{if $property.info.kind == 1} - Commercial{/if}</b></span>
                                         <p class="detail-icons" style="float:left;">
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
                                         </p>
                                    </div>
                                    <div class="clearthis"></div>
                                </div>
                                <div class="clearthis"></div>
                                <div class="desc desc-list">
                                    <div class="css-word-wrap" style="margin:10px 0;min-height:33px">
                                        {php}$this->_tpl_vars['property']['info']['description'] = strip_tags($this->_tpl_vars['property']['info']['description']);{/php}
                                        {$property.info.description}</div>
                                </div>

                                <div class="tbl-info-item">
                                    <ul>
                                        <li>
                                            <div class="col-span-1">Status:</div>
                                            <div class="col-span-2">
                                                <div id="auc-{$property.info.property_id}">
                                                    {* PRICE *}
                                                    {if $property.info.type == 'sale'}
                                                    {elseif $property.info.type == 'live_auction' or $property.info.type == 'stop_auction'}
                                                        <div>
                                                            {* <script>ids.push({$property.info.property_id});</script>*}
                                                            {if $property.info.isBlock || ($property.info.ofAgent && $property.info.auction_sale_code == 'auction')}
                                                                <p id="count-{$property.info.property_id}">
                                                                    {$property.info.set_count}
                                                                </p>
                                                            {else}
                                                                <p id="auc-time-{$property.info.property_id}">
                                                                    -d:-:-:-
                                                                </p>
                                                            {/if}
                                                        </div>
                                                    {elseif $property.info.type == 'forthcoming' }
                                                        <div >
                                                            {if $property.info.isBlock == 1}
                                                                <p id="auc-time-{$property.info.property_id}">
                                                                    -d:-:-:-
                                                                </p>
                                                            {else}
                                                                <span>AUCTION STARTS : {$property.info.start_time}</span>
                                                            {/if}
                                                        </div>
                                                    {elseif ( $property.info.type == 'no_finish_auction')}
                                                        No finish
                                                    {/if}
                                                    <div class="clearthis"></div>
                                                </div>
                                            </div>
                                            <div class="clearthis clearthis-ie7"></div>
                                        </li>
                                        <li>
                                            <div class="col-span-1">Open For Inspection:</div>
                                            <div class="col-span-2">
                                                {$property.o4i}
                                            </div>
                                            <div class="clearthis clearthis-ie7"></div>
                                        </li>
                                        <li>
                                            <div class="col-span-1">Last Bidder Start Price:</div>
                                            <div class="col-span-2">
                                                {$property.info.bid_price}
                                            </div>
                                        </li>
                                        <li>
                                            <div class="col-span-1">Last Bidder</div>
                                            <div class="col-span-2">
                                                {if ($property.info.type == 'live_auction' or $property.info.type == 'stop_auction')}
                                                    {if $property.info.pay_status == 'complete'}
                                                        <p id="auc-bidder-{$property.info.property_id}">
                                                            {if $property.info.isLastBidVendor}
                                                                Vendor bid
                                                            {else}
                                                                {if $property.info.stop_bid == 1
                                                                or $property.info.confirm_sold == 'Sold'
                                                                or $property.info.transition == true}
                                                                    {$property.info.bidder}
                                                                {else}
                                                                    {$property.info.bidder}
                                                                {/if}
                                                            {/if}
                                                        </p>
                                                    {else}
                                                    {/if}
                                                {/if}
                                            </div>
                                        </li>
                                        {if !in_array($property.info.auction_sale_code,array('ebiddar','bid2stay'))}
                                            <li>
                                                {*<div class="col-span-1">iBB Sustainability:</div>
                                                <div class="col-span-2">
                                                    <span class="span-star">{$property.info.green_rating_mark}</span>
                                                </div>
                                                <div class="clearthis clearthis-ie7"></div>*}
                                            </li>
                                        {/if}
                                    </ul>
                                </div>

                                <div class="clearthis"></div>
                                {*END*}
                                <div class='auc-info-ct1'>
                                    <div>
                                        <div style=" font-weight:bold;margin-top:5px; ">
                                            {if $property.info.pay_status == 'unknown'}
                                                Active: <a
                                                    onclick="show_confirm('{$property.info.link}',' This property is not payment. Do you really want to payment ?')"
                                                    href="javascript:void(0)" id="status_{$property.info.property_id}"
                                                    style="text-decoration:none">{$property.info.status}</a>
                                            {/if}
                                            {if $property.info.pay_status == 'pending'}
                                                Active: <a id="status_{$property.info.property_id}"
                                                           style="text-decoration:none">{$property.info.status}</a>
                                            {/if}
                                            {if $property.info.pay_status == 'complete'}
                                                <div style="float: left">
                                                    Active:
                                                    <a onclick="pro.status('{$property.info.property_id}','status_{$property.info.property_id}')"
                                                       href="javascript:void(0)"
                                                       id="status_{$property.info.property_id}"
                                                       style="text-decoration:none">{$property.info.status} </a>
                                                </div>
                                                <div style="float: left;">
                                                    <span style="margin-left: 5px;"> Sold:  </span> <a
                                                        onclick="confirm_sold_mess('{$property.info.property_id}','sold_{$property.info.property_id}','Do you really want to confirm {if in_array($property.info.auction_sale_code,array('ebiddar','bid2stay'))}rent{else}sold{/if} ?')"
                                                        href="javascript:void(0)" id="sold_{$property.info.property_id}"
                                                        style="text-decoration:none">{$property.info.confirm_sold}</a>
                                                </div>
                                            {/if}
                                        </div>
                                        <div class="clearthis"></div>
                                        <div style="float:left; margin-top:5px;">
                                            {$property.history}
                                            <a href="{$property.comment.link}"
                                               style="text-decoration:none">{$property.comment.comment}</a>
                                            <a href="javascript:void(0)" style="text-decoration:none"
                                               onclick="openNote('{$property.info.property_id}')"> Notes(<span
                                                    id="note_{$property.info.property_id}">{$property.num_note}</span>)</a>
                                            - <a href="{$property.info.link_detail}"
                                                 style="text-decoration:none">View detail</a>
                                        </div>
                                    </div>

                                {*BUTTON*}
                                    <div class="clearthis"></div>

                                    <div class="btn-ie7" style="position: absolute;top:424px">
                                        {if $property.info.wait_for_activation == true }
                                            <script type="text/javascript">
                                                jQuery('#img_mark_' + {$property.info.property_id}).attr('src', '/modules/general/templates/images/wait-for-activation.png');
                                                jQuery('#img_mark_' + {$property.info.property_id}).css('display', 'block');
                                                jQuery('#img_mark_fix_' + {$property.info.property_id}).attr('src', '/modules/general/templates/images/wait-for-activation.png');
                                                jQuery('#img_mark_fix_' + {$property.info.property_id}).css('display', 'block');
                                            </script>

                                        {/if}

                                        {if $property.info.pay_status != 'complete'}
                                            <script type="text/javascript">
                                                jQuery('#img_mark_' + {$property.info.property_id}).attr('src', '/modules/general/templates/images/nopayment.png');
                                                jQuery('#img_mark_' + {$property.info.property_id}).css('display', 'block');
                                            </script>
                                        {/if}
                                        {if $property.info.remain_time < 0}
                                            <script type="text/javascript">
                                                jQuery('#auc-time-{$property.info.property_id}').html('Ended');
                                            </script>
                                        {/if}
                                        {if $property.info.confirm_sold == 'Sold' }
                                            <script type="text/javascript">
                                                jQuery('#img_mark_' + {$property.info.property_id}).attr('src', '/modules/general/templates/images/SOLD.png');
                                                jQuery('#img_mark_' + {$property.info.property_id}).css('display', 'block');
                                                jQuery('#img_mark_fix_' + {$property.info.property_id}).attr('src', '/modules/general/templates/images/SOLD.png');
                                                jQuery('#img_mark_fix_' + {$property.info.property_id}).css('display', 'block');
                                                jQuery('#auc-time-{$property.info.property_id}').html('Sold');
                                                jQuery('#count-{$property.info.property_id}').html('Sold');
                                            </script>
                                        {/if}
                                        {if in_array($property.info.auction_sale_code,array('ebiddar','bid2stay')) and $property.info.confirm_sold == 'Sold'}
                                            <script type="text/javascript">
                                                jQuery('#img_mark_' + {$property.info.property_id}).attr('src', '/modules/general/templates/images/RENT.png');
                                                jQuery('#img_mark_' + {$property.info.property_id}).css('display', 'block');
                                                jQuery('#img_mark_fix_' + {$property.info.property_id}).attr('src', '/modules/general/templates/images/RENT.png');
                                                jQuery('#img_mark_fix_' + {$property.info.property_id}).css('display', 'block');
                                                jQuery('#auc-time-{$property.info.property_id}').html('Leased');
                                                jQuery('#count-{$property.info.property_id}').html('Leased');
                                            </script>
                                        {/if}

                                    </div>
                                    <div class="clearthis"></div>
                                {*END*}

                                </div>
                                <div class="clearthis"></div>
                            </div>
                             {if $property.info.confirm_sold != 'Sold' }
                                 <script type="text/javascript">
                                     var time_{$property.info.property_id} = {$property.info.remain_time};
                                     var timer_{$property.info.property_id} = '{$property.info.count}';
                                 </script>
                             {/if}
                                 <script type="text/javascript">
                                     ids.push({$property.info.property_id});
                                     var bid_{$property.info.property_id} = new Bid();
                                                    {if $property.info.isBlock || ($property.info.ofAgent && $property.info.auction_sale_code == 'auction')}
                                                        bid_{$property.info.property_id}.setContainer('count-{$property.info.property_id}');
                                                        bid_{$property.info.property_id}._options.theblock = true;
                                                        var count_{$property.info.property_id} = new CountDown();
                                                            count_{$property.info.property_id}.container = 'count-{$property.info.property_id}';
                                                            count_{$property.info.property_id}.bid_button = 'btn_bid_{$property.info.property_id}';
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
                                                        bid_{$property.info.property_id}._options.transfer_template = 'grid';
                                                        bid_{$property.info.property_id}._options.transfer_container = 'auc-{$property.info.property_id}';
                                                    {else}
                                                        bid_{$property.info.property_id}._options.transfer = true;
                                                    {/if}
                                 </script>

                        </li>
                	{/foreach}
               {else}
                    <div class="message-box message-box-add" style="width: 608px;"><center><i>Sorry, but there are no properties available based on your selection. Please modify the filters to search again. Thanks!</i></center></div>               {/if}
               <script type="text/javascript">updateLastBidder();</script>
            </ul>
            <div class="clearthis"></div>
        </div>

    </div>
     <div class="clearthis"></div>
     {$pag_str}
</div>
