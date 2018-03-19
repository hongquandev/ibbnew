
    {literal}
    <script type="text/javascript">
        var pro = new Property();
        var ids = [];
    </script>
    <script type="text/javascript" src="modules/general/templates/js/confirm.js"></script>

    {/literal}

    <div class="auctions-box watchlist-box watchlist-box-mof-gird agent-grid-box auctions-box-terms">

        {include file = "`$ROOTPATH`/modules/agent/templates/agent.view.top-bar.tpl"}
        <div class="clearthis"></div>

        <div class="auctions-list" style="margin-left:-2px;">
            <div class="toolbar">
                <div class="pager" style="padding-right:12px;">
                    <span>{$review_pagging}</span>
                </div>
            </div>
            <div class="auctions-list">
                {if isset($message) and strlen($message) > 0}
                        <div class="message-box message-box-comment-ie">{$message}</div>
                {/if}
                <ul>
                        {if isset($results) and is_array($results) and count($results)>0}
                        {assign var = i1 value = 0}
                        {foreach from = $results key = k item = property}
                            {assign var = i1 value = $i1+1}
                            <li {if $i1==1} class="first" {/if}>
                                <div class="auction-item auction-item-terms">
                                    <div class="title">
                                        <span class="f-left" style="padding: 5px 5px 5px 10px;font-size:12px;"><a href="{$property.info.link}" style="color:#CC8C04;">{$property.info.titles}</a></span>
                                        <div class="clearthis"></div>
                                        <div>
                                             <span style="float:left;padding-left:10px;color:#CC8C04;">ID: {$property.info.property_id}</span>
                                             <p class="detail-icons" style="float:right;padding-right:10px;padding-top: 2px;">
                                                <span class="bed icons">{$property.info.bedroom_value}</span>
                                                <span class="bath icons">{$property.info.bathroom_value}</span>
                                                <span class="car icons">{$property.info.carport_value}</span>

                                             </p>
                                        </div>
                                        <div class="clearthis"></div>
                                    </div>

                                    <div class="watchlist-img-watermark">
                                       {if isset($property.photos) and is_array($property.photos) and count($property.photos)>0}
                                            <script type="text/javascript">
                                                var IS_{$property.info.property_id} = new ImageShow('container_simg_{$property.info.property_id}',{$property.photos_count});
                                            </script>
                                            {assign var = i value = 1}
                                            {foreach from = $property.photos key = k item = row}
                                                {assign var = is_show value = ';display:none;'}
                                                {if $i==1}
                                                    {assign var = is_show value = ''}
                                                {/if}
                                                <img id="img_{$i}" src="{$MEDIAURL}/{$row.file_name}" alt="img" style="width:180px;height:130px{$is_show}"/>
                                                {assign var = i value = $i+1}
                                            {/foreach}

                                        {else}
                                            <img src="modules/property/templates/images/search-img.jpg" alt="img" style="width:180px;height:130px"/>

                                        {/if}

                                        <img id="img_mark_{$property.info.property_id}" class="watermark" style="margin: 5px 0px 0px 5px;display: none;"/>
                                    <div class="clearthis"></div>

                                    </div>

                                    <div class="auc-info" style="padding: 0px 10px 0px 10px;">
                                        <div class="desc" style="min-height: 60px; margin-bottom: 10px;">
                                            {$property.info.full_address}
                                        </div>
                                        {* PRICE *}
                                        {if $property.info.type == 'sale' or $property.info.type =='not_payment'}
                                            <div align="center" style="margin-bottom: 30px; margin-top: 30px;font-weight: bold;">
                                                <span style=" color: #CC8C04;font-size: 14px;">{$property.info.price}</span>
                                            </div>
                                        {elseif $property.info.type == 'live_auction' or $property.info.type == 'stop_auction' or $property.info.type == 'not_payment_live'}
                                            <div class="main-info-property" align="center" style="margin-bottom: 20px">
                                               {* <script>ids.push({$property.info.property_id});</script>*}

                                                <p style="color:#CC8C04; font-size:16px; font-weight:bold; text-align:center;margin-top:0px;!important" class="time time-auc-grid" id="auc-time-{$property.info.property_id}" >
                                                    -d:-:-:-
                                                </p>

                                                <p class="lastbidder lastbidder-auc-grid"  id="auc-bidder-grid-{$property.info.property_id}" style="font-size:14px; text-align:center;  color:#CC8C04 !important;min-height:30px; " >
                                                    Last Bidder: {$property.info.bidder}
                                                </p>
                                                <p  id="auc-price-{$property.info.property_id}" style="margin-top:-13px;font-size:14px; text-align:center;  color:#CC8C04 !important;">

                                                    {if $property.info.stop_bid == 1 or $property.info.confirm_sold == true}
                                                        {assign var=temp value = 0}
                                                        {if $property.info.stop_bid == 1}
                                                            {if $property.info.bidder == '--'}
                                                                Start Price:
                                                                {assign var=temp value = 1}
                                                            {/if}
                                                        {/if}
                                                        {if !$temp}Last Bid:{/if}

                                                    {elseif $property.info.check_start == 'true'}
                                                        Start Price:
                                                    {else}
                                                        Current Bid:
                                                    {/if}{$property.info.bid_price}
                                                </p>

                                            </div>
                                        {elseif $property.info.type == 'forth_auction' or $property.info.type == 'not_payment_forth'}
                                            <div align="center" style="margin-bottom: 20px">
                                                <span class="" style="margin-bottom:5px; color:#CC8C04;font-size: 11px;text-align: center;font-weight: bold;">AUCTION STARTS : {$property.info.end_time}</span>
                                                <span  id="live-fg-price" style="font-size:14px;color:#CC8C04 !important ;text-align: center;">{$property.info.bid_price}</span>
                                            </div>
                                        {/if}
                                        <div class="clearthis"></div>

                                        {*END*}
                                        <ul class="" style="">
                                                       <li style="width:180px;">
                                                           <span class="title-star">Livability Rating</span>
                                                           <span class="span-star"> {$property.info.livability_rating_mark}</span>

                                                       </li>
                                                       {*<li style="width:180px;">
                                                           <span class="title-star">iBB Sustainability</span>
                                                           <span class="span-star">{$property.info.green_rating_mark}</span>

                                                       </li>*}
                                        </ul>
                                        <div class="clearthis"></div>


                                        <div style="min-height: 55px;">

                                                    <div style=" font-weight:bold; color:#990000; margin-top:5px; " >
                                                        {if $property.info.pay_status == 'unknown'}
                                                            Status:   <a onclick="show_confirm('{$property.info.link}',' This property is not payment. Do you really want to payment ?')" href="javascript:void(0)" id="status_{$property.info.property_id}" style="text-decoration:none">{$property.info.status}</a>
                                                        {/if}
                                                        {if $property.info.pay_status == 'pending'}
                                                            Status:   <a id="status_{$property.info.property_id}" style="text-decoration:none">{$property.info.status}</a>
                                                        {/if}
                                                        {if $property.info.pay_status == 'complete'}
                                                            <div style="float: left">
                                                                Status :
                                                                <a onclick="pro.status('{$property.info.property_id}','status_{$property.info.property_id}')" href="javascript:void(0)" id="status_{$property.info.property_id}" style="text-decoration:none">{$property.info.status} </a>
                                                            </div>
                                                            <div style=" float: right;">
                                                                <span style="margin-left: 20px;"> Sold:  </span> <a  onclick="confirm_sold_mess('{$property.info.property_id}','sold_{$property.info.property_id}','Do you really want to confirm {if $property.info.auction_sale_code == 'ebiddar'}rent{else}sold{/if} ?')" href="javascript:void(0)" id="sold_{$property.info.property_id}" style="text-decoration:none">{$property.info.confirm_sold}</a>
                                                            </div>
                                                        {/if}
                                                    </div>

                                                    <div style="float:right; margin-top:5px; ">
                                                            <a href="{$property.comment.link}" style="color:#990000; text-decoration:none">{$property.comment.comment}</a>
                                                            <a href="javascript:void(0)" style="color:#990000; text-decoration:none" onclick="openNote('{$property.info.property_id}')" > Notes(<span id="note_{$property.info.property_id}">{$property.num_note}</span>)</a>
                                                            - <a href="/{$property.info.link_detail}" style="color:#990000; text-decoration:none" >View detail</a>
                                                            {$property.history}
                                                    </div>
                                        </div>

                                        {*BUTTON*}
                                        <div class="clearthis"></div>

                                        <div class="btn-ie7" style="position: absolute;top:424px">

                                            {if $property.info.type == 'sale'}
                                                       <button id="edit-button-search-{$property.info.property_id}" class="btn-edit-red f-right btn-view-search-list" style="margin-top:0px;" onclick="show_confirm_stop_bidding({$property.info.property_id},'{$property.info.link}','edit')"></button>
                                                       {if $property.info.pay_status == 'complete'  }
                                                            <button id="remove-button-{$property.info.property_id}" class="btn-remove f-left btn-view-search-list" style="margin-top:0px;margin-right: 28px" onclick="showMess('You can not remove this property !')"></button>
                                                       {else}
                                                           <button id="remove-button-{$property.info.property_id}" class="btn-remove f-left btn-view-search-list" style="margin-top:0px;margin-right: 28px" onclick="show_confirm('{$property.info.link_del}','Do you really want to delete this property ?')"></button>
                                                       {/if}
                                                   {else}
                                                        {if $property.info.pay_status != 'complete'}
                                                            <button id="edit-button-search-{$property.info.property_id}" class="btn-edit-red f-right btn-view-search-list" style="margin-top:0px;" onclick="document.location='{$property.info.link}'"></button>
                                                            <button id="remove-button-{$property.info.property_id}" class="btn-remove f-left btn-view-search-list" style="margin-top:0px;margin-right: 28px" onclick="show_confirm('{$property.info.link_del}','Do you really want to delete this property ?')"></button>
                                                        {else}
                                                            <button id="edit-button-search-{$property.info.property_id}" class="btn-edit-red f-right btn-view-search-list" style="margin-top:0px;" onclick="show_confirm_stop_bidding({$property.info.property_id},'{$property.info.link}','edit')"></button>
                                                            <button id="cancel-button-{$property.info.property_id}" class="btn-cancel-bidding f-left btn-view-search-list" style="margin-top:0px;margin-right: 5px" onclick="show_confirm_stop_bidding({$property.info.property_id},'{$property.info.link_cancel_bidding}','')"></button>
                                                        {/if}
                                            {/if}

                                            {if $property.info.wait_for_activation == true }
                                             <script type="text/javascript">
                                                    jQuery('#img_mark_' + {$property.info.property_id}).attr('src','/modules/general/templates/images/wait-for-activation.png');
                                                    jQuery('#img_mark_' + {$property.info.property_id}).css('display','block');
                                                    jQuery('#img_mark_fix_' + {$property.info.property_id}).attr('src','/modules/general/templates/images/wait-for-activation.png');
                                                    jQuery('#img_mark_fix_' + {$property.info.property_id}).css('display','block');
                                             </script>
                                            {/if}
                                            {if $property.info.pay_status != 'complete'}
                                                <script type="text/javascript">
                                                    jQuery('#img_mark_' + {$property.info.property_id}).attr('src','/modules/general/templates/images/nopayment.png');
                                                    jQuery('#img_mark_' + {$property.info.property_id}).css('display','block');
                                                </script>
                                            {/if}

                                        </div>
                                        <div class="clearthis"></div>
                                        {*END*}

                                    </div>
                                    <div class="clearthis"></div>
                                </div>
                                 <script type="text/javascript">
                                                ids.push({$property.info.property_id});
                                                var time_{$property.info.property_id} = {$property.info.remain_time};
                                                var bid_{$property.info.property_id} = new Bid();
                                                bid_{$property.info.property_id}.setContainerObj('auc-{$property.info.property_id}');
                                                bid_{$property.info.property_id}.setTimeObj('auc-time-'+{$property.info.property_id});
                                                bid_{$property.info.property_id}.setBidderObj('auc-bidder-'+{$property.info.property_id});
                                                bid_{$property.info.property_id}.setPriceObj('auc-price-'+{$property.info.property_id});
                                                bid_{$property.info.property_id}.setTimeValue('{$property.info.remain_time}');
                                                bid_{$property.info.property_id}.startTimer({$property.info.property_id});

                                 </script>

                            </li>
                        {/foreach}
                   {else}
                        <li>Empty data.</li>
                   {/if}
                   <script type="text/javascript">updateLastBidder();</script>
                </ul>
                <div class="clearthis"></div>

            </div>
    
        </div>
         <div class="clearthis"></div>
         {$pag_str}
    </div>
