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
<script type="text/javascript" src="modules/general/templates/js/confirm.js"></script>

<script type="text/javascript">
    var pro = new Property();
</script>
{/literal}
<div class="content-box content-box-watvhlist-l content-box-mof-list agent-list-box">
    {*<div class="bar-title">
        <h2>MY WATCHLIST</h2>
        <div class="bar-filter">
             <div class="view-search-list" style="margin-left: 45px;">
                   <span  style="float:left; font-weight:bold; color:#CCCCCC;"> View as : </span>
                        <div style="float:left; margin-left:5px; margin-right:5px;">
                             <a href="/?module=agent&action=view-watchlist" style="color:#666666">
                                 <img src="'../../modules/general/templates/images/list_selected.png" style="margin-left:5px;"/>
                             </a>
                             <a href="?module=agent&action=view-watchlist&mode=grid" style="color:#666666">
                                 <img src="'../../modules/general/templates/images/grid_up.png" style="margin-left:5px;" />
                             </a>
                        </div>
             </div>
        </div>
    </div>*}
    {include file = "`$ROOTPATH`/modules/agent/templates/agent.view.top-bar.tpl"}
    <div class="clearthis"></div>
    <div class="content-details">
        <div class="toolbar">
            <div class="pager">
                <span>{$review_pagging}</span>
            </div>
        </div>
        <div class="search-results agent-product-list">

            {if isset($message) and strlen($message) > 0}
                <div class="message-box message-box-comment-ie">{$message}</div>
            {/if}

                <script type="text/javascript">var ids = [];</script>
            	{if isset($watchlist_data) and is_array($watchlist_data) and count($watchlist_data)>0}
                   <ul class="search-list">
                	{foreach from = $watchlist_data key = k item = property}
                        <li style="clear: both" class="agent-property-item">
                            <div class="item">
                                <div class="hightlight-top-item">
                                    <div class="hightlight-top-item-left f-left">
                                        {$property.info.full_address}
                                    </div>
                                    <div class="hightlight-top-item-right f-right">
                                        <div class="hightlight-top-price">
                                            {$property.info.bid_price}
                                        </div>
                                    </div>
                                </div>

                                <div class="f-left info" {*style="height:190px !important;"*}>
                                    <div class="title">
                                        <span class="f-left"><a href="{$property.info.link}">{$property.info.title}</a><span class="note-button" ></span></span>
                                        <div class="clearthis"></div>
                                    </div>
                                    <div class="sr-new-info">
                                        <p class="f-left" style="margin-right: 15px"><span>ID: {$property.info.property_id} {if $property.info.kind == 1} - Commercial{/if} </span></p>
                                        <p class="detail-icons f-left">
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
                                    <div class="clearthis"></div>
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
                                    <div class="desc" {*style="height: {$fix_height}"*}>
                                        {php}$this->_tpl_vars['property']['info']['description'] = strip_tags($this->_tpl_vars['property']['info']['description']);{/php}
                                        <p style="{*height: 40px;*}" class="word-wrap-all word-justify">{$property.info.description}</p>
                                        {if $property.agent && $property.agent.logo != ''}
                                          <a href="{seo}?module=action&action=view-detail-agency&uid={$property.agent.agent_id}{/seo}">
                                              <img src="{$MEDIAURL}/{$property.agent.logo}" alt="{$property.agent.company_name}" title="Click here to view all property"/>
                                          </a>
                                        {/if}
                                    </div>

                                    {if $property.info.transition == true}
                                        <div class="highlight" align="center" style="width: 420px;margin-top: 4px;">
                                                <span style="color:#980000 !important; font-size:12px;font-weight: bold;">This property had been switched to {$property.info.transition_to}</span>
                                        </div>
                                    {else}
                                        {*<div align="center" style="width: 420px;margin-top: 16px;*margin-top: 6px;"></div>*}
                                    {/if}

                                    <div class="tbl-info-item">
                                        <ul>
                                            <li>
                                                <div class="col-span-1">Status:</div>
                                                <div class="col-span-2">
                                                {if $property.info.type == 'sale'}
                                                    {if $property.info.confirm_sold}Sold{else}Active{/if}
                                                {elseif $property.info.type == 'forthcoming'}
                                                        {if $property.info.type == 'forthcoming'}
                                                            <div id="auc-{$property.info.property_id}" >
                                                                {if $property.info.isBlock == 1}
                                                                    <p id="auc-time-{$property.info.property_id}">
                                                                        -d:-:-:-
                                                                    </p>
                                                                {else}
                                                                    <p>
                                                                        Auction Starts: {$property.info.start_time}
                                                                    </p>
                                                                {/if}
                                                            </div>
                                                        {/if}
                                                            {if $property.info.type == 'auction'}
                                                                    {if $property.info.isBlock || ($property.info.ofAgent && $property.info.auction_sale_code == 'auction')}
                                                                        <p id="count-{$property.info.property_id}">
                                                                            {$property.info.set_count}
                                                                        </p>
                                                                    {elseif $property.info.auction_sale_code != 'private_sale'}
                                                                        <p id="auc-time-{$property.info.property_id}">
                                                                            -d:-:-:-
                                                                        </p>
                                                                    {elseif $property.info.transition}
                                                                        <p id="switch-auc-time-{$property.info.property_id}">
                                                                            Switch
                                                                        </p>
                                                                    {*<p class="acc-sp-ie acc-sp-ie9-bb acc-sp-ie8-blo" id="auc-time-{$property.info.property_id}" style="color: #980000;font-size: 22px; font-weight: bold; text-align: center;margin-top:12px;" >
                                                                        {if $property.info.transition == false }-d:-:-:- {else} Switch {/if}
                                                                    </p>*}
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
                                                            {/if}

                                                {else}
                                                        {if $property.info.type == 'forthcoming'}
                                                            <div id="auc-{$property.info.property_id}">
                                                                {if $property.info.isBlock == 1}
                                                                    <p id="auc-time-{$property.info.property_id}" >
                                                                        -d:-:-:-
                                                                    </p>
                                                                {else}
                                                                    <p >
                                                                        Auction Starts: {$property.info.start_time}
                                                                    </p>
                                                                {/if}
                                                            </div>
                                                        {/if}
                                                            {if $property.info.type == 'auction'}
                                                                    {if $property.info.isBlock || ($property.info.ofAgent && $property.info.auction_sale_code == 'auction')}
                                                                        <p id="count-{$property.info.property_id}">
                                                                            {$property.info.set_count}
                                                                        </p>
                                                                    {elseif $property.auction_sale_code != 'private_sale'}
                                                                        <p id="auc-time-{$property.info.property_id}">
                                                                            -d:-:-:-
                                                                        </p>
                                                                    {elseif $property.info.transition}
                                                                        <p id="switch-auc-time-{$property.info.property_id}">
                                                                            Switch
                                                                        </p>
                                                                    {*<p class="acc-sp-ie acc-sp-ie9-bb acc-sp-ie8-blo" id="auc-time-{$property.info.property_id}" style="color: #980000;font-size: 22px; font-weight: bold; text-align: center;margin-top:12px;" >
                                                                        {if $property.info.transition == false }-d:-:-:- {else} Switch {/if}
                                                                    </p>*}
                                                                    {/if}
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

                                                    </div>
                                                {/if}
                                            </li>
                                            <li>
                                                <div class="col-span-1">Open for Inspection:</div>
                                                <div class="col-span-2">
                                                    {$property.info.o4i}
                                                </div>
                                            </li>
                                            {if !in_array($property.info.type, array('forthcoming','sale'))}
                                            <li>
                                                <div class="col-span-1">
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
                                                    {/if}
                                                </div>
                                                <div class="col-span-2">
                                                    <p id="auc-price-{$property.info.property_id}">{$property.info.price}</p>
                                                </div>
                                            </li>
                                            {/if}
                                            {*<li>
                                                <div class="col-span-1">iBB Sustainability:</div>
                                                <div class="col-span-2">
                                                    <span class="span-star">{$property.info.green_rating_mark}</span>
                                                </div>
                                            </li>*}
                                        </ul>
                                    </div>

                                    <div class="clearthis"></div>

                                    <div class="line-bottom-ct1" style="margin-top: 15px">{*color:#990000;*}
                                      {$property.history}
                                      <a href="javascript:void(0)" style="text-decoration:none" onclick="openNote('{$property.info.property_id}')" > Notes(<span id="note_{$property.info.property_id}">{$property.num_note}</span>) </a>
                                      {$property.view_detail}
                                      - <a href="javascript:void(0)" onclick="Common.del('Do you really want to remove this property from your watch list? ?','{$property.info.link_del}')" style="text-decoration:none"> Remove </a>
                                    </div>
                                </div>
                               
                                <div class="f-right">
                                    {if isset($property.photos) and is_array($property.photos) and count($property.photos)>0}
                                <script type="text/javascript">
								var IS_{$property.info.property_id} = new ImageShow('container_simg_{$property.info.property_id}',{$property.photos_count},{$property.info.property_id},'img_'+{$property.info.property_id});
                                </script>

                                <div class="img" id="container_simg_{$property.info.property_id}">
                                    <div class="img-big-watermark">
                                        {assign var = i value = 1}
                                        {assign var = j value = 0}
                                    	{foreach from = $property.photos key = k item = row}
                                        	{assign var = is_show value = ';display:none;'}
                                        	{if $row.file_name == $property.photo_default}
                                                    {assign var = j value = $i}
                                            {/if}
                                            <a href="{$property.info.link}" style="" >
                                        	    <img id="img_{$property.info.property_id}_{$i}" src="{$MEDIAURL}/{$row.file_name}" alt="img" style="width:300px;height:182px{$is_show}"/>
                                            </a>
                                            {assign var = i value = $i+1}
                                        {/foreach}
                                    </div>

                                    <div class="toolbar-img toolbar-img-lfl">
                                        <span id="wll-img-num" class="img-num img-num-ie">1/{$property.photos_count}</span>
                                        <span id="wll-img-prev" class="icons img-prev img-prev-ie" onclick="IS_{$property.info.property_id}.prev()"></span>
                                        <span id="wll-img-next" class="icons img-next img-next-ie" onclick="IS_{$property.info.property_id}.next();"></span>
                                    </div>
                                    {if $j >0}
                                            <script type="text/javascript">
                                                IS_{$property.info.property_id}.focus({$j});
                                            </script>
                                    {/if}
                                </div>
                                {else}
                                <div class="img">
                                    <div class="img-big-watermark">
                                        <a href="{$property.info.link}" style="" >
                                            <img src="modules/property/templates/images/search-img.jpg" alt="img" style="width:300px;height:182px"/>
                                        </a>
                                    </div>
                                    <div class="toolbar-img">
                                        <span id="wll-img-num" class="img-num img-num-ie">1/1</span>
                                        <span id="wll-img-prev" class="icons img-prev img-prev-ie" onclick="IS_{$property.info.property_id}.prev()"></span>
                                        <span id="wll-img-next" class="icons img-next img-next-ie" onclick="IS_{$property.info.property_id}.next();"></span>
                                    </div>
                                </div>

                            {/if}
                                <div class="btn-ie7 div-list-boxx" style="width: 300px">

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
                                                {assign var = btn_offer_class value="btn-make-an-ofer"}
                                            {else}
                                                {assign var = btn_offer_class value="btn-make-an-ofer-green"}
                                            {/if}

                                            <button id="btn-offer-{$property.info.property_id}" class="btn-wht {$btn_offer_class}  btn-mao-ie7 btn-wht-list btn-offer f-left" onclick="{$mao_str}">
                                                    {*<span><span style="{$btn_mao_span_class}">{$btn_mao_txt}</span></span>*}
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
                                            {assign var = btn_bid_class value="btn-bid"}
                                            {if $property.info.register_bid != true}
                                                {assign var = btn_bid_class value = "btn-bid-reg "}
                                                {assign var = style_bid_cls value = "float:left !important"}
                                            {/if}
                                        {else}
                                            {assign var = btn_bid_class value="btn-bid-green"}
                                            {if $property.info.register_bid != true}
                                                {assign var = btn_bid_class value = "btn-bid-green-reg "}
                                                {assign var = style_bid_cls value = "float:left !important"}
                                            {/if}
                                        {/if}
                                        <input  type="button" id="bid_button_{$property.info.property_id}" class="{$btn_bid_class} f-left btn-bid-auc-list btn-bid-lan" value=""
                                            onclick="{$btn_str}" />
                                   {elseif $property.info.type == 'forthcoming'}
                                        {if !$property.info.register_bid}
                                            <input type="button" id="bid_button_{$property.info.property_id}" class="btn-bid-reg"
                                                   onclick="PaymentBid({$property.info.property_id})" value=""/>
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


                            </script>
                            {/if}

                            
                        </li>
                	{/foreach}
                   </ul>
               {else}
                 <ul class="search-list"  id="message-height-all">
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
