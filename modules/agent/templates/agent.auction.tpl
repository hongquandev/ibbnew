{if $mode_fix != 'grid'}
<script type="text/javascript" src="modules/calendar/templates/js/calendar.popup.js"></script>
<script type="text/javascript">
var isBasic = {$check_agent};
{literal}
 function regPro(){
	if (isBasic){
		var url='?module=agent&action=add-info';
		//showMess('Please complete your information before register a property !',url);
		//document.location='?module=agent&action=add-info';
		showMess('This is the first time you register property on iBB. We need your full information before you can proceed.\
				  Please <a href="'+url+'" style="color:#980000;font-weight:bold;font-size:16px">Click Here</a> to complete. Thank you !','',false);
		return;
	}
	document.location='?module=property&action=register&step=0';
 }
{/literal}		 
var pro = new Property();
var ids = [];
	 
</script>
<div class="content-box content-box-aution-acc">   
    {include file = "`$ROOTPATH`/modules/agent/templates/agent.view.top-bar.tpl"}
    <div class="clearthis"></div>
    {* Begin Details*}
    <div class="content-details">
        <div class="search-results">
            <ul class="search-list">
                 <script type="text/javascript">var ids = [];</script>
                {if isset($results) and is_array($results) and count($results)>0}

                    {assign var = i1 value = 0}
                    {foreach from = $results key = k item = property}

                    <script type="text/javascript">ids.push({$property.info.property_id});</script>
                    {assign var = isearch value = $isearch+1}
                    {assign var = i1 value = $i1+1}

                        <li {if $i1==1} class="first" style="height: 266px" {/if}>
                            {if $property.info.type == 'live_auction' or $property.info.type == 'not_payment_live'  }
                                <div class="item" style="padding-bottom: 45px;height: 220px">
                            {else}
                                <div class="item" style="padding-bottom: 45px;{if $property.info.type == 'not_payment_forth'}height: 185px; {else} height: 170px{/if}">
                            {/if}
                                <div class="f-left info" >
                                    <div class="title">

                                       <span class="f-left">{$property.info.titles}</span>
                                           {if $property.info.type != 'live_auction' }
                                                <span class="f-right" style="color:#980000; font-size:14px;font-weight: bold;">{$property.info.bid_price}</span>
                                           {/if}
                                            <div class="clearthis">
                                            </div>
                                    </div>

                                    <div class="sr-new-info">
                                        <p>
                                            ID: {$property.info.property_id}
                                        </p>
                                        <p class="detail-icons">
                                            <span class="bed icons">{$property.info.bedroom_value}</span>
                                            <span class="bath icons">{$property.info.bathroom_value}</span>
                                            <span class="car icons">{$property.info.carport_value}</span>
                                            <span class="ofi-my-prodetail"> Open for Inspection: {$property.o4i}</span>
                                            {if $property.info.mao_num > 0}
                                            <span id="offer-message-{$property.info.property_id}" class="ofi-my-prodetail" style="margin-right:2px;cursor:pointer" onclick="openMAOGB('{$property.info.property_id}')">Offer({$property.info.mao_num}) -</span>
                                            {/if}
                                        </p>
                                    </div>
                                        {if ($property.info.type == 'live_auction')or ($property.info.type == 'not_payment_live') or ($property.info.type == 'not_payment_forth')}
                                            <span style="color:#980000; font-size:14px;"> Reserve Price: {$property.info.reserve_price}</span>
                                        {/if}

                                    <div class="desc" style="height:80px">
                                        <p style="font-weight:bold;font-size: 11px"> {$property.info.full_address} </p>
                                         <p style="margin-top:10px;"> {$property.info.description} {$property.info.pay_status}  </p>
                                    </div>

                                    {* Begin Highlight no payment and fix layout*}
                                    {assign var=fix_photo value="0px"}
                                    {if $property.info.type == 'forth_auction'}
                                        {assign var=fix_photo value="15px"}
                                        {if $property.info.pay_status != 'complete' }
                                            <div class="highlight" align="center" style="width: 420px;margin-top: 0px;">
                                                <span style="color:#980000 !important; font-size:12px;font-weight: bold;">Please <a href="{$property.info.link}" ><strong>CLICK HERE </strong></a>to complete your property registration.</span>
                                            </div>
                                        {else}
                                            <div class="clearthis"></div>
                                        {/if}
                                    {/if}

                                    {if ($property.info.type=='live_auction')}
                                         {if $property.info.pay_status!='complete' }
                                            <div class="highlight" align="center" style="width: 420px">
                                                <span style="color:#980000 !important; font-size:12px;font-weight: bold;">Please <a href="{$property.info.link}" ><strong>CLICK HERE </strong></a>to complete your property registration.</span>
                                            </div>
                                        {else}
                                            <div class="clearthis"></div>
                                        {/if}
                                        {assign var=fix_photo value="45px"}
                                    {/if}

                                    {if ($property.info.type=='not_payment_live') or ($property.info.type=='not_payment_forth') }
                                        {if $property.info.pay_status != 'complete' }
                                            <div class="highlight" align="center" style="width: 420px;margin-top: 7px;">
                                                <span style="color:#980000 !important; font-size:12px;font-weight: bold;">Please <a href="{$property.info.link}" ><strong>CLICK HERE </strong></a>to complete your property registration.</span>
                                            </div>
                                            {assign var=fix_photo value="55px"}
                                        {else}
                                            <div style="width: 420px;margin-top: 22px;"></div>
                                        {/if}
                                    {/if}
                                    {if $property.info.type == 'not_payment'}
                                        <div class="highlight" align="center" style="width: 420px;margin-top: 7px;">
                                                <span style="color:#980000 !important; font-size:12px;font-weight: bold;">Please <a href="{$property.info.link}" ><strong>CLICK HERE </strong></a>to complete your property registration.</span>
                                        </div>
                                    {else}
                                    {/if}
                                    {* End Highlight no payment and fix layout*}

                                        <div class="tbl-info" style="margin-top:0px;float: right;">
                                            {if $property.info.type=='forth_auction' or ($property.info.type == 'not_payment_forth')}
                                                <div class="acc-s-ie" style=" background-color: #D9D9D9; width:420px; margin-top:0px;" id="auc-{$property.info.property_id}" >
                                                     <p class="acc-sp-ie" style="padding-left: 10px;color: #980000;font-size: 16px; font-weight: bold; text-align: left;" >
                                                    Auction starts: {$property.info.start_time}
                                                    </p>
                                                </div>
                                            {/if}
                                            <ul class="f-left col1">
                                                {if ($property.info.type == 'live_auction') or ($property.info.type == 'not_payment_live')}
                                                    {if $property.info.pay_status == 'complete'}
                                                        <li style="height: 22px;padding:12px 0px !important;margin:0px !important;">
                                                            <p id="auc-time-{$property.info.property_id}" style="color: #980000;font-size: 22px; font-weight: bold; text-align: center;height: 27px" >
                                                                -d:-:-:-
                                                            </p>
                                                        </li>
                                                    {else}
                                                        <li style="height: 22px;">
                                                            <p id="auc-time-{$property.info.property_id}" style="color: #980000;font-size: 22px; font-weight: bold; text-align: center;" >
                                                                -d:-:-:-
                                                            </p>
                                                        </li>
                                                    {/if}
                                                {/if}
                                                <li>
                                                    <span>Livability Rating</span> <span class="spxgreen1" style="float:right"> {$property.info.livability_rating_mark}</span>
                                                </li>
                                            </ul>
                                            <ul class="f-left col2">
                                                {if ($property.info.type=='live_auction') or ($property.info.type == 'not_payment_live')}
                                                    {if $property.info.pay_status=='complete'}
                                                        <li style="margin: 0px ! important; height: 32px; padding: 7px 9px ! important;">
                                                            <p style="" class="lasted" id="auc-bidder-{$property.info.property_id}">
                                                                Last Bidder: {$property.info.bidder}
                                                            </p>
                                                            <p style="padding-left: 0px;color: #FF7700;font-size: 18px;" class="bid" id="auc-price-{$property.info.property_id}">
                                                                Current Bid: {$property.info.bid_price}
                                                            </p>
                                                        </li>
                                                    {else}
                                                        <li style="height: 22px;">
                                                            <p style="padding-left: 0px;color: #FF7700;font-size: 17px; margin-top: 2px;height: 27" class="bid" id="auc-price-{$property.info.property_id}">
                                                                Start Price: {$property.info.bid_price}
                                                            </p>
                                                        </li>
                                                    {/if}
                                                {/if}
                                                <li>
                                                    {*<span>iBB Sustainability</span> <span class="spxgreen2" style="float:right">{$property.info.green_rating_mark}</span>*}
                                                </li>
                                            </ul>
                                            <div class="clearthis"></div>
                                        </div>

                                        {if $property.info.type == 'live_auction' or ($property.info.type=='not_payment_live')}
                                            <script type="text/javascript">
                                                var time_{$property.info.property_id} = {$property.info.remain_time};
                                                var bid_{$property.info.property_id} = new Bid();
                                                bid_{$property.info.property_id}.setContainerObj('auc-{$property.info.property_id}');
                                                bid_{$property.info.property_id}.setTimeObj('auc-time-'+{$property.info.property_id});
                                                bid_{$property.info.property_id}.setBidderObj('auc-bidder-'+{$property.info.property_id});
                                                bid_{$property.info.property_id}.setPriceObj('auc-price-'+{$property.info.property_id});
                                                bid_{$property.info.property_id}.setTimeValue('{$property.info.remain_time}');
                                                bid_{$property.info.property_id}.startTimer({$property.info.property_id});
                                            </script>
                                        {/if}

                                    <div class="clearthis">
                                    </div>

                                    <div class="botton" style="height: 22px">
                                            <div style="float:left; font-weight:bold; color:#CC8C04; margin-top:5px; " >
                                                {if $property.info.pay_status!='complete'}
                                                    Status:   <a onclick="show_confirm('{$property.info.link}',' This property is not payment. Do you really want to payment ?')" href="javascript:void(0)" id="status_{$property.info.property_id}" style="text-decoration:none">{$property.info.status}</a>

                                                {else}
                                                    Status :   <a onclick="pro.status('{$property.info.property_id}','status_{$property.info.property_id}')" href="javascript:void(0)" id="status_{$property.info.property_id}" style="text-decoration:none">{$property.info.status} </a>
                                                    {/if}
                                               </div>
                                            <div style="float:right; margin-top:5px; ">
                                                {$property.history}
                                                <a href="{$property.comment.link}" style="color:#CC8C04; text-decoration:none">{$property.comment.comment}</a>
                                                <a href="javascript:void(0)" style="color:#CC8C04; text-decoration:none" onclick="openNote('{$property.info.property_id}')" > Notes(<span id="note_{$property.info.property_id}">{$property.num_note}</span>)</a>
                                                - <a href="/{$property.info.link_detail}" style="color:#CC8C04; text-decoration:none" >View detail</a>
                                            </div>
                                    </div>
                                    <div class="bottom1" style="float:left; font-weight:bold; color:#CC8C04;">
                                        <span style=""> Confirm Sold:  </span>
                                        <a  onclick="confirm_sold_mess('{$property.info.property_id}','sold_{$property.info.property_id}','Do you really want to confirm {if $property.info.auction_sale_code == 'ebiddar'}rent{else}sold{/if} ?')" href="javascript:void(0)" id="sold_{$property.info.property_id}" style="text-decoration:none">{$property.info.confirm_sold}</a>
                                    </div>    
                                </div>

                                {if isset($property.photos) and is_array($property.photos) and count($property.photos)>0}
                                        <script type="text/javascript">
                                        var IS_{$property.info.property_id} = new ImageShow('container_simg_{$property.info.property_id}',{$property.photos_count},{$property.info.property_id},'img_'+{$property.info.property_id});
                                        </script>
                                    <div class="f-right img" id="container_simg_{$property.info.property_id}" style="margin-top: {$fix_photo}">
                                        <div class="img-big-watermark">
                                            {assign var = i value = 1}
                                            {assign var = j value = 0}
                                            {foreach from = $property.photos key = k item = row}
                                                {assign var = is_show value = ';display:none;'}
                                                {*{if $i==1}
                                                    {assign var = is_show value = ''}
                                                {/if}*}
                                                {if $row.file_name == $property.photo_default}
                                                        {assign var = j value = $i}
                                                {/if}
                                                {*<img id="img_{$i}" src="{$row.file_name}" alt="img" style="width:180px;height:130px{$is_show}"/>*}
                                                <img id="img_{$property.info.property_id}_{$i}" src="{$MEDIAURL}/{$row.file_name}" alt="img" style="width:180px;height:130px{$is_show}"/>
                                                {assign var = i value = $i+1}
                                            {/foreach}
                                            {* Add watermark and change wiev button color for auction Pro *}
                                            {if $property.info.pay_status=='complete'}
                                                <img id="img_mark_{$property.info.property_id}" class="watermark" alt="" style="width:180px;height:130px;display: none;" />
                                            {else}
                                                <img id="img_mark_payment_{$property.info.property_id}" src="modules/general/templates/images/nopayment.png" class="watermark" alt="" style="width:180px;height:130px;display: block;" />
                                            {/if}
                                        </div>

                                        <div class="toolbar-img toolbar-img-ie">
                                            <span class="img-num img-num-ie">1/{$property.photos_count}</span>
                                            <span class="icons img-prev img-prev-ie" id="img-prev-aution-acc" onclick="IS_{$property.info.property_id}.prev()"></span>
                                            <span class="icons img-next img-next-ie" id="img-next-aution-acc" onclick="IS_{$property.info.property_id}.next();"></span>
                                        </div>
                                        {if $j >0}
                                                <script type="text/javascript">
                                                    IS_{$property.info.property_id}.focus({$j});
                                                </script>
                                        {/if}
                                        <div class="sr-new-action" style="position:relative;">

                                            {if $property.info.edit_term == false}
                                                <button id="edit-button-search-{$property.info.property_id}" class="btn-edit-red f-right btn-view-search-list" style="margin-top:20px;" onclick="showMess(' You can not edit term this property !')"></button>
                                            {else}
                                                <button id="edit-button-search-{$property.info.property_id}" class="btn-edit-red f-right btn-view-search-list" style="margin-top:20px;" onclick="show_confirm_stop_bidding({$property.info.property_id},'{$property.info.link}','edit')"></button>
                                            {/if}
                                            {if $property.info.pay_status == 'complete'}
                                                <button id="cancel-button-{$property.info.property_id}" class="btn-cancel-bidding f-right btn-view-search-list" style="margin-top:20px;margin-right: 5px" onclick="show_confirm_stop_bidding({$property.info.property_id},'{$property.info.link_cancel_bidding}','')"></button>
                                            {else}
                                                <button id="remove-button-{$property.info.property_id}" class="btn-remove f-right btn-view-search-list" style="margin-top:20px;margin-right: 28px" onclick="show_confirm('{$property.info.link_del}','Do you really want to delete this property ?')"></button>
                                            {/if}

                                        </div>

                                    </div>
                                {else}

                                    <div class="f-right img" style="margin-top:{$fix_photo}">
                                        <div class="img-big-watermark">
                                            <img src="modules/property/templates/images/search-img.jpg" alt="img" style="width:180px;height:130px;margin-top: 0px"/>
                                            {* Add watermark if it don't have photo*}
                                            {if $property.info.pay_status=='complete'}
                                                <img id="img_mark_fix_{$property.info.property_id}" class="watermark" style="width:180px;height:130px;display: none;" />
                                            {else}
                                                <img id="" src="modules/general/templates/images/nopayment.png" class="watermark" alt="" style="width:180px;height:130px;display: block;" />
                                            {/if}
                                        </div>
                                        <div class="toolbar-img" style="height: 15px;">
                                            <span class="img-num" style="display: none;"></span>
                                            <span class="icons img-prev" style="display: none;"></span>
                                            <span class="icons img-next" style="display: none;"></span>
                                        </div>
                                         {if $j >0}
                                                <script type="text/javascript">
                                                    IS_{$property.info.property_id}.focus({$j});
                                                </script>
                                          {/if}
                                        <div class="sr-new-action" style="position:relative;">
                                            {if $property.info.edit_term == false}
                                                <button id="edit-button-search-{$property.info.property_id}" class="btn-edit-red f-right btn-view-search-list" style="margin-top:20px;" onclick="showMess(' You can not edit term !')"></button>
                                            {else} {* forcomming*}
                                                <button id="edit-button-search-{$property.info.property_id}" class="btn-edit-red f-right btn-view-search-list" style="margin-top:20px;" onclick="show_confirm_stop_bidding({$property.info.property_id},'{$property.info.link}','edit')"></button>
                                            {/if}
                                            {if $property.info.pay_status == 'complete'}
                                                <button id="cancel-button-{$property.info.property_id}" class="btn-cancel-bidding f-right btn-view-search-list" style="margin-top:20px;margin-right: 5px" onclick="show_confirm_stop_bidding({$property.info.property_id},'{$property.info.link_cancel_bidding}','')"></button>
                                            {else}
                                                <button id="remove-button-{$property.info.property_id}" class="btn-remove f-right btn-view-search-list" style="margin-top:20px;margin-right: 28px" onclick="show_confirm('{$property.info.link_del}','Do you really want to delete this property ?')"></button>
                                            {/if}
                                        </div>
                                    </div>
                                {/if}
                                 <div class="clearthis">
                                 </div>

                                {if $property.info.wait_for_activation == true }
                                         <script type="text/javascript">
                                                jQuery('#img_mark_' + {$property.info.property_id}).attr('src','/modules/general/templates/images/wait-for-activation.png');
                                                jQuery('#img_mark_' + {$property.info.property_id}).css('display','block');
                                                jQuery('#img_mark_fix_' + {$property.info.property_id}).attr('src','/modules/general/templates/images/wait-for-activation.png');
                                                jQuery('#img_mark_fix_' + {$property.info.property_id}).css('display','block');
                                         </script>
                                {/if}


                            </div>
                        </li>
                    {/foreach}
               {else}
                    There is no data.
               {/if}
                <script type="text/javascript">updateLastBidder();</script>
            </ul>
        </div>
        {$pag_str}
    </div>
</div>
{* </form>*}

{else}
   {include file='agent.auction.grid.tpl'}
{/if}