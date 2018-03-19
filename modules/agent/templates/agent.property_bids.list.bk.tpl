<script type="text/javascript" src="modules/calendar/templates/js/calendar.popup.js"></script>
<script type="text/javascript" src="modules/general/templates/js/confirm.js"></script>
<script type="text/javascript">
    var pro = new Property();
    var ids = [];
</script>
<div class="content-box content-box-mof-list content-box-bids-list content-box-pro-bids agent-list-box">

    {include file = "`$ROOTPATH`/modules/agent/templates/agent.view.top-bar.tpl"}
    <div class="clearthis"></div>

    <script type="text/javascript">
		var pro = new Property();
	</script>

    <div class="content-details">
        <div class="toolbar">
            <div class="pager">
                <span>{$review_pagging}</span>
            </div>
        </div>
        <div class="search-results">
                 {if isset($message) and strlen($message) > 0}
                    <div class="message-box message-box-comment-ie">{$message}</div>
                 {/if}

            	{if isset($results) and is_array($results) and count($results)>0}
                    <ul class="search-list">
                    	{foreach from = $results key = k item = property}

                         {*{assign var = item_height value="padding-bottom:23px;height:192px;"}
                         {if $property.info.transition == true}
                            {assign var = item_height value="padding-bottom:23px;height: 205px;"}
                         {/if} *}

                         <li class="{if $property.info.kind == 1}hl{/if}">
                            <div class="item">
                                <div class="f-left info">
                                    <div class="title">
                                        <span class="f-left"><a href="{$property.info.link}" style="color:#CC8C04;">{$property.info.title}</a></span>
                                    </div>
									<div class="clearthis"></div>
                                    <div class="sr-new-info">
                                        <p class="detail-icons icon-ie7">
                                         	<span><b>ID : {$property.info.property_id}{if $property.info.kind == 1} - Commercial{/if}</b> </span>
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
                                            {*<span class="f-right ofi-bids">Open for Inspection: {$property.info.o4i}</span>*}
                                        </p>

                                    </div>
                                    <div class="desc" style="/*height:65px;*/clear:both;margin-bottom:3px">
                                        <p class="address-bold">{$property.info.full_address}</p>
                                        <p style="margin-top: 10px;" class="word-wrap-all word-justify">{$property.info.description}</p>
                                        <br />
                                        {if $property.agent && $property.agent.logo != ''}
                                          <a href="{seo}?module=action&action=view-detail-agency&uid={$property.agent.agent_id}{/seo}"><img src="{$MEDIAURL}/{$property.agent.logo}" alt="{$property.agent.company_name}" title="Click here to view all property"/></a>
                                        {/if}
                                    </div>
                                    <div class="clearthis"></div>
                                    {if $property.info.transition == true}
                                        <div class="highlight" align="center" style="width: 420px;*margin-top: 4px;">
                                                <span style="color:#980000 !important; font-size:12px;font-weight: bold;">This property had been switched from {$property.info.transition_from} to {$property.info.transition_to}</span>
                                        </div>
                                    {/if}

                                    {if $property.info.type == 'forthcoming'}
                                    <div class="tbl-info tbl-info-new">
                                            <div class="acc-s-ie acc-s-p" id="auc-{$property.info.property_id}" style="margin-bottom:1px">
                                                {if $property.info.isBlock == 1}
                                                    <p class="acc-sp-ie acc-sp-block"
                                                       id="auc-time-{$property.info.property_id}">
                                                        -d:-:-:-
                                                    </p>
                                                {else}
                                                    <p class="acc-sp-ie acc-sp-p">
                                                        Auction Starts: {$property.info.start_time}
                                                    </p>
                                                {/if}
                                            </div>
                                    </div>
                                    {else}
                                    <div class="tbl-info tbl-info-new">
                                        <ul class="f-left col1">
                                           <li class="col1-li">
                                                {if $property.info.isBlock || ($property.info.ofAgent && $property.info.auction_sale_code == 'auction')}
                                                    <p class="acc-sp-all" id="count-{$property.info.property_id}">
                                                                {$property.info.set_count}
                                                    </p>
                                                {elseif $property.info.transition == false }
                                                     <p class="acc-sp-all" id="auc-time-{$property.info.property_id}">
                                                        -d:-:-:-
                                                    </p>
                                                {else}
                                                    {*<p class="acc-sp-ie acc-sp-ie9-bb acc-sp-ie8-blo" id="auc-time-{$property.info.property_id}" style="color: #980000;font-size: 22px; font-weight: bold; text-align: center;margin-top:12px;" >
                                                        {if $property.info.transition == false }-d:-:-:- {else} Switch {/if}
                                                    </p>*}
                                                    <p class="acc-sp-all" id="switch-auc-time-{$property.info.property_id}">
                                                        Switch
                                                    </p>
                                                {/if}
                                           </li>
                                        </ul>
                                        <ul class="f-left col2">
                                           <li class="col2-li">
                                                <p class="lasted" id="auc-bidder-{$property.info.property_id}">
                                                    {if $property.info.isLastBidVendor}
                                                        Vendor bid
                                                    {else}
                                                        {if $property.info.stop_bid == 1
                                                            or $property.info.confirm_sold
                                                            or $property.info.transition == true}
                                                            Last Bidder: {$property.info.bidder}
                                                        {else}
                                                            Current Bidder: {$property.info.bidder}
                                                        {/if}
                                                    {/if}
                                                </p>
                                                <p style="font-weight: bold;" class="bid bid-property-price" id="auc-price-{$property.info.property_id}">
                                                      {if $property.info.stop_bid == 1 or $property.info.confirm_sold == true or $property.info.transition == true}
                                                        {assign var=temp value = 0}
                                                        {if $property.info.stop_bid == 1}
                                                            {if $property.info.bidder == '--'}
                                                                Start Price:
                                                                {assign var=temp value = 1}
                                                            {/if}
                                                        {/if}
                                                        {if !$temp}Last Bid:{/if}

                                                    {elseif $property.info.check_start}
                                                        Start Price:
                                                    {else}
                                                        Current Bid:
                                                     {/if}
                                                    {$property.info.price}
                                                </p>
                                           </li>
                                        </ul>
                                    </div>
                                    {/if}
                                    {if $property.info.check_price AND $property.info.transition == false AND $property.info.stop_bid == 0 AND $property.info.confirm_sold == false }
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
                                    <div class="tbl-info tbl-info-news">
                                        <ul class="f-left col1">
                                             <li class="li-open-inspection">
                                               {* <span class="title-star">Livability Rating</span> <span  class="span-star"> {$property.info.livability_rating_mark}</span>*}
                                                <span class="title-star">Open for Inspection: </span> <span id="span-inspection-all"  class="span-star">{$property.info.o4i}</span>
                                                <div class="clearthis clearthis-ie7"></div>
                                            </li>
                                        </ul>
                                        <ul class="f-left col2 {if in_array($property.info.auction_sale_code,array('ebiddar','bid2stay'))}ul-disable{/if}">
                                            <li>
                                                <span class="title-star">iBB Sustainability</span> <span  class="span-star">{$property.info.green_rating_mark}</span>
                                                <div class="clearthis clearthis-ie7"></div>
                                            </li>
                                        </ul>
                                        <div class="clearthis"></div>
                                        <div>
                                            <div class="line-bottom">
                                            	<a href="javascript:void(0)" style="color:#CC8C04; text-decoration:none" onclick="openNote('{$property.info.property_id}')" >
                                                    Notes(<span id="note_{$property.info.property_id}">{$property.num_note}</span>)  </a>
                                                {*{if $property.info.transition == false}
                                                   - <a href="{$property.info.link}" style="color:#990000; text-decoration:none" > View detail </a>
                                                {/if}*}
                                                {php}
                                                    //print_r($this->_tpl_vars['property']['info']);
                                                {/php}
                                                {if $property.info.isShowLinkDetail == true}
                                                    - <a href="{$property.info.link_detail}" style="color:#CC8C04; text-decoration:none">
                                                        View Detail
                                                    </a>
                                                {/if}
                                                - <a href="javascript:void(0)" onclick="Common.del('Do you really want to remove this property from your property bids list ?','{$property.info.link_del}')" style="color:#CC8C04; text-decoration:none"> Remove </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {if isset($property.photos) and is_array($property.photos) and count($property.photos)>0}
                                    <script type="text/javascript">
                                    var IS_{$property.info.property_id} = new ImageShow('container_simg_{$property.info.property_id}',{$property.photos_count},{$property.info.property_id},'img_'+{$property.info.property_id});
                                    </script>

                                    <div class="f-right img" id="container_simg_{$property.info.property_id}">
                                        <div class="img-big-watermark">
                                            {assign var = i value = 1}
                                            {assign var = j value = 0}
                                            {foreach from = $property.photos key = k item = row}
                                                {assign var = is_show value = ';display:none;'}
                                                {if $row.file_name == $property.photo_default}
                                                        {assign var = j value = $i}
                                                {/if}
                                                <a href="{$property.info.link}" style="" >
                                                    <img id="img_{$property.info.property_id}_{$i}" src="{$MEDIAURL}/{$row.file_name}" alt="img" style="width:180px;height:130px{$is_show}"/>
                                                </a>
                                                {assign var = i value = $i+1}
                                            {/foreach}
                                            {if $property.info.isBlock}
                                                <img src="/modules/general/templates/images/theblock.png" id="img_mark_block_{$property.info.property_id}" class="watermark" style="width:180px;height:130px;display: block;cursor: pointer;" onclick="document.location='/?module=property&action=view-auction-detail&id={$property.info.property_id}'"/>
                                            {/if}
                                            <a href="{$property.info.link}" style="" >
                                                <span class="wm w-{$property.info.auction_sale_code}"></span>
                                                <img id="img_mark_{$property.info.property_id}" class="watermark" style="width:180px;height:130px;padding: 0px !important; display: none;"/>
                                                {*<img id="img_ebidda_mark_{$property.info.property_id}" src="{$property.info.ebidda_watermark}" class="watermark_ebidda" width="57" height="49"
                                                     style="{if $property.info.ebidda_watermark != '' } display: block ; {else} display: none;{/if}"/>*}
                                            </a>

                                        </div>
                                        <div class="toolbar-img toolbar-img-lfl toolbar-img-ie7">
                                            <span class="img-num img-num-ie">1/{$property.photos_count}</span>
                                            <span class="icons img-prev img-prev-ie img-prev-ie-lfl" onclick="IS_{$property.info.property_id}.prev()"></span>
                                            <span class="icons img-next img-next-ie img-next-ie-lfl" onclick="IS_{$property.info.property_id}.next();"></span>
                                        </div>
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
                                    </div>
                                {else}
                                     <div class="f-right img">
                                        <div class="img-big-watermark">
                                            <a href="{$property.info.link}" style="" >
                                                <span class="wm w-{$property.info.auction_sale_code}"></span>
                                                <img src="modules/property/templates/images/search-img.jpg" alt="img" style="width:180px;height:130px"/>
                                                <img id="img_mark_fix_{$property.info.property_id}" class="watermark" style="width:180px;height:130px;padding: 0px !important;display: none;"/>
                                                {if $property.info.isBlock}
                                                    <img src="/modules/general/templates/images/theblock.png" id="img_mark_block_{$property.info.property_id}" class="watermark" style="width:180px;height:130px;display: block;cursor: pointer;" onclick="document.location='/?module=property&action=view-auction-detail&id={$property.info.property_id}'"/>
                                                {/if}
                                                {*<img id="img_ebidda_mark_{$property.info.property_id}" src="{$property.info.ebidda_watermark}" class="watermark_ebidda" width="57" height="49"
                                                     style="{if $property.info.ebidda_watermark != '' } display: block ; {else} display: none;{/if}"/>*}
                                            </a>
                                        </div>
                                        <div class="toolbar-img toolbar-img-lfl toolbar-img-ie7">
                                          <span class="img-num img-num-ie">1/1</span>
                                            <span class="icons img-prev img-prev-ie img-prev-ie-lfl" onclick="IS_{$property.info.property_id}.prev()"></span>
                                            <span class="icons img-next img-next-ie img-next-ie-lfl" onclick="IS_{$property.info.property_id}.next();"></span>
                                        </div>
                                    </div>
                                {/if}
                                {*BUTTON*}
                                <div class="f-right btn-ie7 div-list-boxx">
                                    {if $property.info.confirm_sold == false}
                                        {if $property.info.transition == false or ($property.info.can_offer == true and $property.info.transition == true)}
                                            {assign var = mao_str value = "pro.openMakeAnOffer('#makeanoffer_`$property.info.property_id`','`$property.info.property_id`','$agent_id')"}
                                        {else}
                                            {if $property.info.confirm_sold == false}
                                                {assign var = mao_str value = "showMess(' This property had been switched from Auction to `$property.info.transition_to`. You can offer it when this property become live `$property.info.transition_to` !')"}
                                            {/if}
                                        {/if}
                                    {else}
                                        {assign var = mao_str value = "showMess(' This property had been sold !')"}
                                    {/if}


                                    {if $property.info.type == 'live'}
                                        {if $property.info.check_price == false or( $property.info.transition == true)}
                                                {assign var = btn_offer_class value="btn-make-an-ofer"}
                                                {assign var = btn_bid_class value="btn-bid"}
                                                {if $property.info.isVendor}
                                                    {assign var = btn_bid_class value="btn-bid-vendor"}
                                                {/if}
                                        {else}
                                                {assign var = btn_offer_class value="btn-make-an-ofer-green"}
                                                {assign var = btn_bid_class value="btn-bid-green"}
                                                {if $property.info.isVendor}
                                                    {assign var = btn_bid_class value="btn-bid-vendor-green"}
                                                {/if}
                                        {/if}
                                    {/if}


                                    {if !$property.info.confirm_sold}
                                        
                                        <button id="btn-offer-{$property.info.property_id}" class="btn-wht {$btn_offer_class} btn-mao-ie7 btn-offer" onclick="{$mao_str}">
                                                {*<span><span>Offer</span></span>*}
                                        </button>
                                    {/if}
                                        {$property.info.mao}

                                        {if $property.info.confirm_sold == false}
                                            {if $property.info.transition == false }
                                                {assign var = btn_str value = "bid_`$property.info.property_id`.click()"}
                                                {if ($property.info.remain_time < 0 OR $property.info.stop_bid == 1) and $property.info.auction_sale_code == "auction"}
                                                    {if true }
                                                        <script type="text/javascript">
                                                            jQuery('#auc-time-{$property.info.property_id}').html('Ended');
                                                        </script>
                                                        {php}
                                                        {/php}
                                                        {if $property.info.isLastBidVendor == true OR !$property.info.check_price}
                                                            <script type="text/javascript">
                                                                jQuery('#auc-time-{$property.info.property_id}').html('Passed In');
                                                                jQuery('#img_mark_' + {$property.info.property_id}).attr('src','/modules/general/templates/images/passedin_list.png');
                                                                jQuery('#img_mark_' + {$property.info.property_id}).css('display','block');
                                                                jQuery('#img_mark_fix_' + {$property.info.property_id}).attr('src','/modules/general/templates/images/passedin_list.png');
                                                                jQuery('#img_mark_fix_' + {$property.info.property_id}).css('display','block');

                                                            </script>
                                                        {/if}
                                                    {/if}
                                                {else}
                                                    {if $property.info.check_price and $property.info.type == "live"}
                                                        <script type="text/javascript">
                                                            /*AddMark('#img_mark_' + "{$property.info.property_id}","OnTheMarket");
                                                            AddMark('#img_mark_fix_' + "{$property.info.property_id}","OnTheMarket");*/
                                                            jQuery('#img_mark_' + {$property.info.property_id}).attr('src','/modules/general/templates/images/onthemarket_list.png');
                                                            jQuery('#img_mark_' + {$property.info.property_id}).css('display','block');
                                                            jQuery('#img_mark_fix_' + {$property.info.property_id}).attr('src','/modules/general/templates/images/onthemarket_list.png');
                                                            jQuery('#img_mark_fix_' + {$property.info.property_id}).css('display','block');
                                                        </script>
                                                    {/if}
                                                {/if}
                                            {else}
                                                {if $property.info.transition_code != 'private_sale'}
                                                    {assign var = btn_str value = "showMess(' This property had been switched from Auction to `$property.info.transition_to`. You can bid it when this property become live auction !')"}
                                                {else}
                                                    {assign var = btn_str value = "showMess(' This property had been switched from Auction to Private Sale. You can not bid it !')"}
                                                {/if}
                                            {/if}
                                            {if $agent_info.type == 'theblock' && $property.info.isBlock}
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

                                        {if $property.info.confirm_sold == false AND $property.info.stop_bid == 0 AND $property.info.type == 'live'}
                                            <input type="button" id="bid_button_{$property.info.property_id}" class="{$btn_bid_class} f-left btn-bid-auc-list btn-bid-lan" value="" style="{$style_bid_cls}"
                                                    onclick="{$btn_str}" />
                                        {/if}
                                </div>
                                {*END*}

                                <div class="clearthis"></div>
                            </div>
                            {if $property.info.transition == false}

                                 <script type="text/javascript">
                                                ids.push({$property.info.property_id});
                                                var time_{$property.info.property_id} = "{$property.info.remain_time}";
                                                var timer_{$property.info.property_id} = '{$property.info.count}';
                                                var bid_{$property.info.property_id} = new Bid();
                                                {if $property.info.isBlock || ($property.info.ofAgent && $property.info.auction_sale_code == 'auction')}
                                                bid_{$property.info.property_id}.setContainer('count-{$property.info.property_id}');
                                                bid_{$property.info.property_id}._options.theblock = true;
                                                bid_{$property.info.property_id}._options.mine = true;

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
                                                    bid_{$property.info.property_id}._options.transfer_template = 'list-bid';
                                                    bid_{$property.info.property_id}._options.transfer_container = 'auc-{$property.info.property_id}';
                                                {else}
                                                    bid_{$property.info.property_id}._options.transfer = true;
                                                {/if}

                                 </script>
                            {/if}
                        </li>
                         <div class="clearthis"></div>
                	    {/foreach}
                    </ul>
               {else}
                 <ul class="search-list" id="message-height-all">
                    <div class="message-box message-box-add" style="width: 608px;"><center><i>Sorry, but there are no properties available based on your selection. Please modify the filters to search again. Thanks!</i></center></div>
                 </ul>
                {/if}

               <script type="text/javascript">updateLastBidder();</script>
                 <script type="text/javascript">
                     {literal}
                     $(function(){
                         jQuery('.btn-bid-green').tipsy({gravity: $.fn.tipsy.autoNS,fallback: " <div style='padding: 5px;text-align: justify'>When the bid button turns green the property is on the market</div>",html: true });
                         jQuery('.btn-bid-vendor-green').tipsy({gravity: $.fn.tipsy.autoNS,fallback: " <div style='padding: 5px;text-align: justify'>When the bid button turns green the property is on the market</div>",html: true });
                     });
                     {/literal}
                 </script>
        </div>
        {$pag_str}

    </div>
</div>
