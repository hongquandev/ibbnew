<script type="text/javascript">
    var pro = new Property();
    var ids = [];
    {literal}
    var new_property_popup = new Popup();
    function showCopyNewPropertyPopup(content){
        new_property_popup.removeChild();
        new_property_popup.init({id:'new_property_popup',className:'popup_overlay'});
        new_property_popup.updateContainer('<div class="popup_container" style="width:400px;height: auto;min-height: 100px;"><div id="new_property_popup-wrapper">\
			 <div class="title"><h2>Copy as new property<span id="btnclosex" class="btn-x" onclick="closeCopyNewPropertyPopup()">Close X</span></h2> </div>\
			 <div class="clearthis" style="clear:both;"></div>\
			 <div align="center" style="margin-bottom: 20px; margin-top: 20px;" class="content content-po" id="msg"> '+content+'</div>\
			 <div align="center" class="button" style="margin: 5px 25px 0px 30px;"><button class="btn-red" style="margin-right: 25px;" onclick="addCopyNewPropertyAction()"><span><span>OK</span></span></button>\
             <button style="width:84px;*width:74px;" class="btn-red" onclick="closeCopyNewPropertyPopup()"><span><span>CANCEL</span></span></button></div>\
			  </div></div></div>');
        new_property_popup.show().toCenter();
    }
    function closeCopyNewPropertyPopup(){
        new_property_popup.hide();
    }
    function addCopyNewProperty(){
        showLoadingPopup();
        var url = ROOTURL + '/modules/property/action.php?action=list-copy-property';
        jQuery.post(url,'',function(data){
            closeLoadingPopup();
            var result = jQuery.parseJSON(data);
            if(result.success && result.html){
                showCopyNewPropertyPopup(result.html);
            }else{
                console.log(result.message);
            }
        },'html');
    }
    function addCopyNewPropertyAction(){
        closeCopyNewPropertyPopup();
        showLoadingPopup();
        var url = ROOTURL + '/modules/property/action.php?action=copy-new-property&';
        url += jQuery('#new_property_popup-wrapper input[type=radio]').serialize();
        jQuery.get(url,'',function(data){
            closeLoadingPopup();
            var result = jQuery.parseJSON(data);
            if(result.success){
                showMess__(result.message);
                if(result.link){
                    setTimeout(function(){ document.location = result.link; }, 3000);
                }
            }else{
                console.log(result.message);
            }
        },'html');
    }
    {/literal}
</script>
{if $mode_fix !='grid'}
    <script type="text/javascript" src="modules/calendar/templates/js/calendar.popup.js"></script>
    <div id="content-dashboard" class="content-box content-box-myacc agent-list-box">
        {if $page != 'view-dashboard'}
            {include file = "`$ROOTPATH`/modules/agent/templates/agent.view.top-bar.tpl"}
            <div class="clearthis"></div>
        {/if}
        {* Begin Details*}
        <div class="content-details">
        {if $page != 'view-dashboard'}
            <div style="*margin-bottom: 10px;" class="toolbar">
                <div class="tn">
                    {if $page != 'view-auction'}
                        <button style="float: left;" class="btn-red btn-red-my-properties" onclick="check.regPro('/?module=package')">
                            <span><span>{localize translate="Register New Property"}</span></span>
                        </button>
                        <button style="float: left;margin-left: 5px" class="btn-red btn-red-my-properties" onclick="addCopyNewProperty()">
                            <span><span>{localize translate="Add New Property By Copy Listing"}</span></span>
                        </button>
                    {/if}
                    <span style="float: right;">{$review_pagging}</span>
                </div>
            </div>
        {/if}
            <div class="clearthis"></div>
            <div class="search-results agent-product-list">
                <ul class="search-list" id="search-list-property">
                     <script type="text/javascript">var ids = [];</script>
                    {if isset($results) and is_array($results) and count($results)>0}

                        {assign var = i1 value = 0}
                        {foreach from = $results key = k item = property}

                        <script type="text/javascript">ids.push({$property.info.property_id});</script>
                        {assign var = isearch value = $isearch+1}
                        {assign var = i1 value = $i1+1}
                            <li  class="agent-property-item {if $i1==1}first{/if} {if $property.info.kind == 1}hl{/if}">
                                <div class="item"{* style="padding-bottom: 65px;"*}>
                                    <div class="hightlight-top-item">
                                        <div class="hightlight-top-item-left f-left">
                                            {$property.info.full_address}
                                        </div>
                                        <div class="hightlight-top-item-right f-right">
                                            <div class="hightlight-top-price">
                                                {*{$property.info.bid_price}*}
                                                <span class="price-bold">
                                                    <span id="price-bold-{$property.info.property_id}">{$property.info.advertised_price}</span>
                                                    {if in_array($property.info.pro_type_code,array('ebiddar','bid2stay'))}
                                                    <span class="period">{$property.info.period}</span>{/if}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="f-left info" >
                                        <div class="title"><span class="f-left">{localize translate=$property.info.titles}</span></div>
                                        {*{if $property.info.type != 'live_auction' AND $property.info.type != 'stop_auction'}
                                            <span id="bid-price-acc-{$property.info.property_id}" class="f-right" style="color:#CC8C04; font-size:14px;font-weight: bold;">{$property.info.bid_price}</span>
                                        {/if}*}
                                        {* Combo box to change for type property *}
                                        <div class="clearthis"></div>
                                        {*{if isset($property.reset_options) and count($property.reset_options) > 0 and $property.info.confirm_sold == 'None' and !$property.info.isBlock and !($property.info.ofAgent && $property.info.auction_sale_code == 'auction') and !$property.info.wait_for_activation }
                                            <div id="reset_options_{$property.info.property_id}" style="float: left;margin-top: 10px;width: 40%;">
                                                <select name="fields[option_id]" id="option_id_{$property.info.property_id}" class="input-select" style="width:100%" onchange="show_confirm(this.value,'Do you really want to switch this property ?',{$property.info.property_id})">
                                                    {html_options options = $property.reset_options selected = ''}
                                                </select>
                                            </div>
                                        {/if}*}
                                        <div class="clearthis"></div>
                                            {* Combo box to change manager manage property's the block *}
                                        {if in_array($authentic.type,array('theblock','agent')) && $authentic.parent_id == 0}
                                        <div class="sub_title" style="float: left;width:300px">
                                            <span style="float:left">{localize translate="Manager"}: &nbsp;</span>
                                            <select id="property_{$property.info.property_id}" class="input-select theblock_change">
                                                {foreach from=$agent_options key = key item=row}
                                                      <option value="{$key}" {if $row.active == 0}disabled="disabled"{/if} {if $key == $property.info.agent_id}selected="selected"{/if}>{$row.value}</option>
                                                {/foreach}
                                                {*{html_options options = $agent_options selected=$property.info.agent_id}*}
                                            </select>
                                            <span></span>
                                        </div>
                                        <div class="clearthis"></div>
                                        {/if}
                                        <div class="clearthis"></div>
                                        <div class="sr-new-info">
                                            <p class="f-left" style="margin-right: 15px">
                                                <span>ID : {$property.info.property_id}{if $property.info.kind == 1} - {localize translate="Commercial"}{/if}</span>
                                            </p>
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
                                            </p>
                                            <div class="clearthis"></div>
                                            <div class="ofi-my-prodetail ofi-my-prodetail-das f-left" style="margin-right: 15px">
                                                {*Open for Inspection: {$property.o4i}*}
                                                <a href="{$property.comment.link}" style="color:#2f2f2f; text-decoration:none">{$property.comment.comment}</a>
                                            </div>
                                            {*{if $property.info.mao_num > 0}
                                            <span id="offer-message-{$property.info.property_id}" class="ofi-my-prodetail f-left" style="margin-top: 10px;margin-right:2px;cursor:pointer;color: #2f2f2f;" onclick="openMAOGB('{$property.info.property_id}')">Offer List ({$property.info.mao_num}) -</span>
                                            {/if}*}
                                            <p></p>
                                        </div>
                                        <div class="clearthis"></div>
                                        {php}$this->_tpl_vars['property']['info']['description'] = strip_tags($this->_tpl_vars['property']['info']['description']);{/php}
                                        {if $property.info.isBlock}
                                            {if ($property.info.type=='forthcoming' ) }
                                                <div class="desc desc-mycc-ie7 css-word-wrap" style="">
                                                     <p class="css-word-wrap" style="margin-top:10px;"> {$property.info.description} </p>
                                                </div>
                                            {else}
                                                 <div class="desc desc-mycc-ie7 css-word-wrap" style="">
                                                     <p class="css-word-wrap" style="margin-top:10px;"> {$property.info.description} </p>
                                                </div>
                                            {/if}
                                        {elseif $property.info.wait_for_activation}
                                            <div class="desc desc-mycc-ie7 css-word-wrap" style="">
                                                 <p class="css-word-wrap" style="margin-top:10px;"> {$property.info.description} </p>
                                            </div>
                                        {else}
                                            <div class="desc desc-mycc-ie7 css-word-wrap" style="">
                                                 <p class="css-word-wrap" style="margin-top:10px;"> {$property.info.description} </p>
                                            </div>
                                        {/if}
                                        <div class="clearthis"></div>
                                        <div class="tbl-info-item">
                                            <ul>
                                                {if $property.info.release_time}
                                                    <li>
                                                        <div class="col-span-1">{if $property.info.is_release_time}{localize translate="Released Date"}{else}{localize translate="Release Date"}{/if} : </div>
                                                    <div class="col-span-2">{$property.info.release_time}</div>
                                                    <div class="clearthis"></div>
                                                    </li>
                                                {/if}
                                                <li>
                                                    {if $property.info.type}
                                                    <div class="col-span-1">{localize translate="Status"}:</div>
                                                    {/if}
                                                    <div class="col-span-2">
                                                        {if $property.info.type == 'sale'}
                                                            {localize translate="sale"}
                                                        {elseif $property.info.type == 'forthcoming'}
                                                            <div id="auc-{$property.info.property_id}">
                                                                {if $property.info.type == 'forthcoming'}
                                                                    <div id="auc-{$property.info.property_id}" >
                                                                        {if $property.info.isBlock == 1}
                                                                            <p id="auc-time-{$property.info.property_id}" >
                                                                                -d:-:-:-
                                                                            </p>
                                                                        {else}
                                                                            <p>
                                                                                {localize translate="Auction starts"}: {$property.info.start_time}
                                                                            </p>
                                                                        {/if}
                                                                    </div>
                                                                {/if}
                                                            </div>
                                                        {elseif ($property.info.type == 'live_auction' or $property.info.type == 'stop_auction')}
                                                            <div id="auc-{$property.info.property_id}">
                                                                {if ($property.info.type == 'live_auction' or $property.info.type == 'stop_auction')}
                                                                    {if $property.info.isBlock || ($property.info.ofAgent && $property.info.auction_sale_code == 'auction')}
                                                                        {if $property.info.pay_status != 'complete'}
                                                                            <p id="count-{$property.info.property_id}">
                                                                                {$property.info.set_count}
                                                                            </p>
                                                                        {else}
                                                                            <p id="count-{$property.info.property_id}">
                                                                                {$property.info.set_count}
                                                                            </p>
                                                                        {/if}
                                                                    {else}
                                                                        {if $property.info.pay_status == 'complete'}
                                                                            <p class="auc-time-{$property.info.property_id}" id="auc-time-{$property.info.property_id}">
                                                                                -d:-:-:-
                                                                            </p>
                                                                        {else}
                                                                            <p class="auc-time-{$property.info.property_id}" id="auc-time-{$property.info.property_id}">
                                                                                No Complete
                                                                            </p>
                                                                        {/if}
                                                                    {/if}
                                                                {/if}
                                                            </div>
                                                        {elseif ( $property.info.type == 'no_finish_auction')}
                                                            {localize translate="No finish"}
                                                        {else}
                                                            {localize translate=$property.info.titles}
                                                        {/if}
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="col-span-1">{localize translate="Open for Inspection"}:</div>
                                                    <div class="col-span-2">
                                                        {$property.o4i}
                                                    </div>
                                                </li>
                                                {if ($property.info.type == 'live_auction' or $property.info.type == 'stop_auction')}
                                                <li>
                                                    <div class="col-span-1">{localize translate="Start price"}:</div>
                                                    <div class="col-span-2">
                                                        {if ($property.info.type == 'live_auction' or $property.info.type == 'stop_auction')}
                                                            {if $property.info.pay_status == 'complete'}
                                                                <p id="auc-price-{$property.info.property_id}">
                                                                    {if $property.info.stop_bid == 1 or $property.info.confirm_sold == 'Sold' or $property.info.transition == true}
                                                                        {assign var=temp value = 0}
                                                                        {if $property.info.stop_bid == 1}
                                                                            {if $property.info.bidder == '--'}
                                                                                {assign var=temp value = 1}
                                                                            {/if}
                                                                        {/if}
                                                                        {if !$temp}{/if}
                                                                    {elseif $property.info.check_start == 'true'}
                                                                    {else}
                                                                    {/if}{$property.info.bid_price}
                                                                </p>
                                                            {else}
                                                                <p id="auc-price-{$property.info.property_id}">
                                                                    {$property.info.bid_price}
                                                                </p>
                                                            {/if}
                                                        {/if}
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="col-span-1">{localize translate="Last Bidder"}:</div>
                                                    <div class="col-span-2">
                                                        {if ($property.info.type == 'live_auction' or $property.info.type == 'stop_auction')}
                                                            {if $property.info.pay_status == 'complete'}
                                                                <p id="auc-bidder-{$property.info.property_id}">
                                                                    {if $property.info.isLastBidVendor}
                                                                        {localize translate="Vendor bid"}
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
                                                {/if}
                                                <li>
                                                    {*<div class="col-span-1">iBB Sustainability:</div>
                                                    <div class="col-span-2">
                                                        <span class="span-star">{$property.info.green_rating_mark}</span>
                                                    </div>*}
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="clearthis"></div>
                                        <div class="reserve-require" style="padding-top: 10px">
                                            {if ($property.info.type=='live_auction' or $property.info.type=='stop_auction')}
                                                {*<span class="reserve-price"> Reserve Price: {$property.info.reserve_price}</span>*}
                                            {/if}
                                            {if $property.info.wait_for_activation AND $property.info.confirm_sold != 'Sold'}
                                                {if $property.allowActive }
                                                    <a href="javascript:void(0)" class="a-require-active-fix" onclick="OpenrequireActive('{$property.info.property_id}')">Require Active</a>
                                                    {$property.re_active_popup}
                                                {else}
                                                    <a href="javascript:void(0)" class="a-require-active-fix" onclick="showMess('Please change the end time to active !')">Require Active</a>
                                                {/if}
                                            {/if}
                                        </div>
                                        {* Begin Highlight no payment and fix layout*}
                                        {assign var=fix_photo value="0px"}
                                        {if $property.info.type=='forthcoming'}
                                            {assign var=fix_photo value="0px"}
                                            {if $property.info.pay_status!='complete' }
                                                <div class="highlight-ct1" align="center" style="margin-top: 0;">
                                                    <span style="font-size:12px;">Please <a href="{$property.info.link}" ><strong>CLICK HERE </strong></a>to complete your property registration.</span>
                                                </div>
                                            {else}
                                                {if $authentic.type == 'theblock'}
                                                    <div class="" style="display: none;"></div>
                                                {else}
                                                    <div class="" style="width: 420px;margin-top: 16px;*margin-top: 4px;"></div>
                                                {/if}
                                            {/if}
                                        {/if}
                                        {if ($property.info.type=='live_auction' OR $property.info.type=='stop_auction')}
                                             {if $property.info.pay_status!='complete' }
                                                <div class="highlight-ct1" align="center" style="margin-top: 0px;">
                                                    <span style="font-size:12px;">Please <a href="{$property.info.link}" ><strong>CLICK HERE </strong></a>to complete your property registration.</span>
                                                </div>
                                            {else}
                                                <div class="clearthis"></div>
                                            {/if}
                                            {assign var=fix_photo value="45px"}
                                        {/if}

                                        {if ($property.info.type=='no_finish_auction' )}
                                            {if $property.info.pay_status!='complete' }
                                                <div class="highlight-ct1" align="center" style="margin-top: 10px;">
                                                    <span style="font-size:12px;">Please <a href="{$property.info.link}" ><strong>CLICK HERE </strong></a>to complete your property registration.</span>
                                                </div>
                                            {else}
                                                <div class="highlight-ct1"></div>
                                            {/if}
                                        {/if}

                                        {if $property.info.type=='sale' }
                                            {if $property.info.pay_status != 'complete' }
                                                <div class="highlight-ct1" align="center" style="margin-top: 10px;">
                                                    <span style="font-size:12px;">Please <a href="{$property.info.link}" ><strong>CLICK HERE </strong></a>to complete your property registration.</span>
                                                </div>
                                            {else}
                                                <div class="highlight-ct1"></div>
                                            {/if}
                                        {/if}

                                        <div class="botton" style="margin-top: 5px">
                                            <div style="float:left;margin-top:5px;margin-right: 5px;width: 99%" >
                                                {if $property.info.pay_status == 'complete'}
                                                    <div class="bottom-act">
                                                        <label for="online_selector">Online:</label>
                                                        <select onchange="pro.status('{$property.info.property_id}','status_{$property.info.property_id}')"
                                                                class="bo-selector" id="online_selector">
                                                            <option value="Enable" {if $property.info.status == 'Enable'}selected{/if}>Enable</option>
                                                            <option value="Disable" {if $property.info.status == 'Disable'}selected{/if}>Disable</option>
                                                        </select>
                                                    </div>
                                                    <div class="bottom-act">
                                                        <label for="online_selector">Confirm:</label>
                                                        <select onchange="confirm_sold_mess('{$property.info.property_id}','sold_{$property.info.property_id}','Do you really want to confirm {if $property.info.auction_sale_code == 'ebiddar'}rent{else}sold{/if} ?')"
                                                                class="bo-selector" id="online_selector">
                                                            <option value="None" {if $property.info.confirm_sold == 'None'}selected{/if}>Not {if $property.info.auction_sale_code == 'ebiddar'}Rent{else}Sold{/if}</option>
                                                            <option value="Sold" {if $property.info.confirm_sold == 'Sold'}selected{/if}>{if $property.info.auction_sale_code == 'ebiddar'}Rent{else}Sold{/if}</option>
                                                        </select>
                                                    </div>
                                                    <div class="bottom-act">
                                                        <label for="pro_status_selector">Property Status:</label>
                                                        <select onchange="changeReaStatus(this.value,'{$property.info.property_id}')" class="bo-selector" id="pro_status_selector">
                                                            <option value="current" {if $property.info.reaxml_status == 'current'}selected{/if}>Current</option>
                                                            <option value="sold" {if $property.info.reaxml_status == 'sold'}selected{/if}>Sold</option>
                                                            <option value="leased" {if $property.info.reaxml_status == 'leased'}selected{/if}>Leased</option>
                                                            <option value="passed_in" {if $property.info.reaxml_status == 'passed_in'}selected{/if}>Passed in</option>
                                                            <option value="underoffer" {if $property.info.reaxml_status == 'under_offer'}selected{/if}>Under Offer</option>
                                                            <option value="withdrawn" {if $property.info.reaxml_status == 'withdrawn'}selected{/if}>Withdrawn</option>
                                                            <option value="offmarket" {if $property.info.reaxml_status == 'offmarket'}selected{/if}>Offmarket</option>
                                                        </select>
                                                    </div>
                                                    {if $property.info.auction_sale_code == 'ebiddar'}
                                                        <div class="bottom-act">
                                                            <label for="pro_status_rentnow_selector">Rent Now:</label>
                                                            <select onchange="pro.rentNowActive('{$property.info.property_id}','rentnow-status_{$property.info.property_id}')" class="bo-selector" id="pro_status_selector">
                                                                <option value="No" {if $property.info.buynow_status == 'No'}selected{/if}>Disable</option>
                                                                <option value="Yes" {if $property.info.buynow_status == 'Yes'}selected{/if}>Enable</option>
                                                            </select>
                                                        </div>
                                                        {*<span style="margin-left: 5px">Enable Rent Now: <a class="bottom-alink" onclick="pro.rentNowActive('{$property.info.property_id}','rentnow-status_{$property.info.property_id}')" href="javascript:void(0)" id="rentnow-status_{$property.info.property_id}">{$property.info.buynow_status}</a></span>*}
                                                    {/if}
                                                {/if}
                                                {if $authentic.type == 'theblock'}
                                                    <span style="margin-left: 15px">{localize translate="Show Logo"}: </span><a href="javascript:void(0)" onclick="pro.setLogo('{$property.info.property_id}','logo_{$property.info.property_id}')" id="logo_{$property.info.property_id}">{if $property.info.show_agent_logo == 1}Yes{else}No{/if}</a>
                                                {/if}
                                            </div>
                                            <div class="clearthis"></div>
                                            <div style="float: none;clear: both;margin-top: 2px;">
                                                {*{$property.history}*}
                                                <a class="bottom-alink" href="{$ROOTURL}/?module=agent&action=view-registered_bidders" style="text-decoration:none">Registered Users</a>
                                                - <a class="bottom-alink" href="javascript:void(0)" style="text-decoration:none" onclick="openNote('{$property.info.property_id}')" > {localize translate="Notes"}(<span id="note_{$property.info.property_id}">{$property.num_note}</span>)</a>
                                                {if $property.info.confirm_sold != 'Sold'}
                                                - <a class="bottom-alink" href="{php} echo ROOTURL.'/?module=package&property_id='; {/php}{$property.info.property_id}" style="/*text-decoration:none;font-size: 16px;color: #980000*/" >{localize translate="Add Extra Options"} </a>
                                                {/if}
                                            </div>
                                        </div>
                                    </div>
                                    {if isset($property.photos) and is_array($property.photos) and count($property.photos)>0}
                                    <script type="text/javascript">
                                    var IS_{$property.info.property_id} = new ImageShow('container_simg_{$property.info.property_id}',{$property.photos_count},{$property.info.property_id},'img_'+{$property.info.property_id});
                                    </script>
                                    {* Fix margin_top of photo*}
                                    {*-------*}
                                    <div class="f-right img" id="container_simg_{$property.info.property_id}" style="margin-top: {$fix_photo}">
                                       <div class="img-big-watermark img-big-watermark-{$property.info.property_id}">
                                           <a href="{$property.info.link}">
                                            {assign var = i value = 1}
                                            {assign var = j value = 0}
                                            {foreach from = $property.photos key = k item = row}
                                                {assign var = is_show value = ';display:none;'}
                                                {if $row.file_name == $property.photo_default}
                                                    {assign var = is_show value = ';display:block;'}
                                                    {assign var = j value = $i}
                                                {/if}
                                                <img id="img_{$property.info.property_id}_{$i}" src="{$MEDIAURL}/{$row.file_name}" alt="img" style="width:300px;height:182px{$is_show}"/>
                                                {assign var = i value = $i+1}
                                            {/foreach}
                                            </a>
                                       </div>
                                           <div class="toolbar-img toolbar-img-ie">
                                                <span class="img-num img-num-ie">1/{$property.photos_count}</span>
                                                <span class="icons img-prev img-prev-ie" onclick="IS_{$property.info.property_id}.prev()"></span>
                                                <span class="icons img-next img-next-ie" onclick="IS_{$property.info.property_id}.next();"></span>
                                            </div>
                                           <script type="text/javascript">
                                                {if $j > 0}
                                                    IS_{$property.info.property_id}.focus({$j});
                                                {/if}
                                                IS_{$property.info.property_id}.showMarkPM('{$property.info.pay_status}');
                                            </script>

                                           <div class="sr-new-action" style="position:relative;">
                                               {if $property.info.type == 'sale'}
                                                   <button id="edit-button-search-{$property.info.property_id}" class="btn-edit-red f-left btn-view-search-list" style="margin-top:20px;" onclick="show_confirm_stop_bidding({$property.info.property_id},'{$property.info.link}','edit')"></button>
                                                   {if $property.info.pay_status == 'complete'  }
                                                        <button id="remove-button-{$property.info.property_id}" class="btn-remove f-left btn-view-search-list" style="margin-top:20px;margin-right: 28px" onclick="showMess('You can not remove this property !')"></button>
                                                   {else}
                                                       <button id="remove-button-{$property.info.property_id}" class="btn-remove f-left btn-view-search-list" style="margin-top:20px;margin-right: 28px" onclick="show_confirm('{$property.info.link_del}','Do you really want to delete this property ?')"></button>
                                                   {/if}
                                               {else}
                                                    {if $property.info.pay_status != 'complete'}
                                                        <button id="edit-button-search-{$property.info.property_id}" class="btn-edit-red f-left btn-view-search-list" style="margin-top:20px;" onclick="document.location='{$property.info.link}'"></button>
                                                        <button id="remove-button-{$property.info.property_id}" class="btn-remove f-left btn-view-search-list" style="margin-top:20px;margin-right: 28px" onclick="show_confirm('{$property.info.link_del}','Do you really want to delete this property ?')"></button>
                                                    {else}
                                                        <button id="edit-button-search-{$property.info.property_id}" class="btn-edit-red f-left btn-view-search-list" style="margin-top:20px;" onclick="show_confirm_stop_bidding({$property.info.property_id},'{$property.info.link}','edit')"></button>
                                                        {if !$property.info.isBlock && !($property.info.ofAgent && $property.info.auction_sale_code == 'auction')}
                                                            <button id="cancel-button-{$property.info.property_id}" class="btn-cancel-bidding f-left btn-view-search-list" style="margin-top:20px;margin-right: 5px" onclick="show_confirm_stop_bidding({$property.info.property_id},'{$property.info.link_cancel_bidding}','')"></button>
                                                        {/if}
                                                    {/if}
                                               {/if}
                                               <button onclick="document.location='{$property.info.link_detail}'"
                                                       class="btn-view-detail f-left"  style="margin-top:20px;"></button>
                                            </div>
                                        </div>
                                    {else}
                                        <div class="f-right img" style="margin-top:{$fix_photo}">
                                            <div class="img-big-watermark img-big-watermark-{$property.info.property_id}">
                                                <a href="{$property.info.link}">
                                                    <img src="modules/property/templates/images/search-img.jpg" alt="img"
                                                     style="width:300px;height:182px;margin-top: 0px"/>
                                                </a>
                                            </div>
                                            <div class="toolbar-img toolbar-img-ie">
                                                <span class="img-num img-num-ie">1/1</span>
                                                <span class="icons img-prev img-prev-ie"
                                                      onclick="IS_{$property.info.property_id}.prev()"></span>
                                                <span class="icons img-next img-next-ie"
                                                      onclick="IS_{$property.info.property_id}.next();"></span>
                                            </div>
                                            <div class="sr-new-action" style="position:relative;">
                                                {if $property.info.type == 'sale'}
                                                    <button id="edit-button-search-{$property.info.property_id}"
                                                            class="btn-edit-red f-left btn-view-search-list"
                                                            style="margin-top:20px;"
                                                            onclick="show_confirm_stop_bidding({$property.info.property_id},'{$property.info.link}','edit')"></button>
                                                    {if $property.info.pay_status == 'complete'  }
                                                        <button id="remove-button-{$property.info.property_id}"
                                                                class="btn-remove f-left btn-view-search-list"
                                                                style="margin-top:20px;margin-right: 28px"
                                                                onclick="showMess('You can not remove this property !')"></button>
                                                    {else}
                                                        <button id="remove-button-{$property.info.property_id}"
                                                                class="btn-remove f-left btn-view-search-list"
                                                                style="margin-top:20px;margin-right: 28px"
                                                                onclick="show_confirm('{$property.info.link_del}','Do you really want to delete this property ?')"></button>
                                                    {/if}
                                                {else}
                                                    {if $property.info.pay_status != 'complete'}
                                                        <button id="edit-button-search-{$property.info.property_id}"
                                                                class="btn-edit-red f-left btn-view-search-list"
                                                                style="margin-top:20px;"
                                                                onclick="document.location='{$property.info.link}'"></button>
                                                        <button id="remove-button-{$property.info.property_id}"
                                                                class="btn-remove f-left btn-view-search-list"
                                                                style="margin-top:20px;margin-right: 28px"
                                                                onclick="show_confirm('{$property.info.link_del}','Do you really want to delete this property ?')"></button>
                                                    {else}
                                                        <button id="edit-button-search-{$property.info.property_id}"
                                                                class="btn-edit-red f-left btn-view-search-list"
                                                                style="margin-top:20px;"
                                                                onclick="show_confirm_stop_bidding({$property.info.property_id},'{$property.info.link}','edit')"></button>
                                                        {if !$property.info.isBlock && !($property.info.ofAgent && $property.info.auction_sale_code == 'auction')}
                                                            <button id="cancel-button-{$property.info.property_id}"
                                                                    class="btn-cancel-bidding f-left btn-view-search-list"
                                                                    style="margin-top:20px;margin-right: 5px"
                                                                    onclick="show_confirm_stop_bidding({$property.info.property_id},'{$property.info.link_cancel_bidding}','')"></button>
                                                        {/if}
                                                    {/if}
                                                {/if}
                                                <button onclick="document.location='{$property.info.link_detail}'"
                                                        class="btn-view-detail f-left"  style="margin-top:20px;"></button>
                                            </div>
                                        </div>
                                {/if}
                                     <div class="clearthis"></div>
                                </div>

                                <script type="text/javascript">
                                    {if $property.info.remain_time > 0}
                                    var time_{$property.info.property_id} = {$property.info.remain_time};
                                    var timer_{$property.info.property_id} = '{$property.info.count}';
                                    {/if}
                                    var bid_{$property.info.property_id} = new Bid();
                                    bid_{$property.info.property_id}.setContainerObj('auc-{$property.info.property_id}');
                                    bid_{$property.info.property_id}.setTimeObj('auc-time-{$property.info.property_id}','class');
                                    bid_{$property.info.property_id}.setBidderObj('auc-bidder-{$property.info.property_id}');
                                    bid_{$property.info.property_id}.setPriceObj('auc-price-{$property.info.property_id}');
                                    bid_{$property.info.property_id}.setTimeValue('{$property.info.remain_time}');
                                    {if $property.info.type == 'live_auction' && $property.info.stop_bid == 0 && $property.info.confirm_sold != 'Sold'}
                                    bid_{$property.info.property_id}.startTimer({$property.info.property_id});
                                    {/if}
                                    bid_{$property.info.property_id}._options.transfer = true;
                                </script>
                                <div class="clearthis"></div>
                            </li>
                        {/foreach}
                </ul>
                {else}
                <ul class="search-list" id="message-height-all" style="border-bottom: none;">
                     <div class="message-box message-box-add" style="width: 608px;"><center><i>Sorry, but there are no properties available based on your selection. Please modify the filters to search again. Thanks!</i></center></div>
                </ul>
                {/if}
                <script type="text/javascript">updateLastBidder();</script>
            </div>
            {if $page != 'view-dashboard'}
                {$pag_str}
            {/if}
        </div>
    </div>
    {*</form>*}
    {literal}
        <script type="text/javascript">
            function OpenrequireActive(id) {
                jQuery('#requireActive_' + id).show();
            }
        </script>
    {/literal}
{else}
    {include file = 'agent.property.grid.tpl'}
{/if}
<script type='text/javascript'>
{literal}
$('.theblock_change').change(function () {
    var id = $(this).attr('id');
    var property_id = id.split('_');
    var url = '/modules/property/action.php?action=change-manager';
    $.post(url, {property_id: property_id[1], agent_id: $(this).val()}, function (data) {
        var result = $.parseJSON(data);
        if (result.error) {
            showMess(result.msg);
        } else {
            showMess('Change successful!');
        }
    }, 'html');
});
function changeReaStatus(status,id){
    var url = '/modules/property/action.php?action=change-reastatus';
    showLoadingPopup();
    $.post(url, {property_id: id, status: status, endtime_ar: '5000-06-06 00:00:00', starttime_ar: '5000-05-05 00:00:00'}, function (data) {
        closeLoadingPopup();
        var result = $.parseJSON(data);
        if (result.error) {
            showMess(result.msg);
        } else {
            showMess('Change status successful!.');

        }
    }, 'html');
}
{/literal}
</script>
