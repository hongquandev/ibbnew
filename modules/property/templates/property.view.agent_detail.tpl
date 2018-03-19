{literal}
<style type="text/css">
.pdf-documents-download {
    margin-bottom: 20px;
}
.pdf-documents-download .btn-pdf-download {
    background: url("../../modules/general/templates/images/btn-pdfdocument-fix.jpg") repeat scroll 0 0 transparent;
    border: medium none;
    cursor: pointer;
    height: 30px;
    padding-left: 5px;
    text-align: left;
    width: 205px;
}
#ftrtitle {
	font-size:11px;
}

</style>
{/literal}

{literal}
<script type="text/javascript" languange="javascript">
 function img(obj)
 {
 //document.getElementById("im").src="{$row.file_name}"
 	jQuery(obj).click();
 }

function myReport(id){
//window.open(id,"","width=800,height=600,status=yes,toolbar=no,menubar=no scrolling=yes")
 var width  = 800;
 var height = 600;
 var left   = (screen.width  - width)/2;
 var top    = (screen.height - height)/2;
 var params = 'width='+width+', height='+height;
 params += ', top='+top+', left='+left;
 params += ', directories=no';
 params += ', location=no';
 params += ', menubar=no';
 params += ', resizable=no';
 params += ', scrollbars=yes';
 params += ', status=no';
 params += ', toolbar=no';
 newwin=window.open(id,'ibb', params);
 if (window.focus) {newwin.focus()}
 return false;

}
//set time button

</script>
{/literal}


<div class="property-box property-box-detail" id="property-box-d">
    <div class="bar-title">
        <h2>{$property_data.info.title}</h2>
    </div>
    <div class="property-detail">
        <script type="text/javascript">
		var ids = [];
        var pro = new Property();
        </script>
        {if isset($property_data.info) and is_array($property_data.info) and count($property_data.info) > 0 }
            <div class="detail-2col">
            <div class="pag-short">
                <span class="l icons">{$property_data.info.prev}</span>
                <span class="r icons">{$property_data.info.next}</span>
                <br clear="all"/>
            </div>            
            <div class="col1 f-left">
                <div>
                    <p class="price" id="price-{$property_data.info.property_id}">
                        {$property_data.info.price}
                    </p>
                    <p class="address">
                        {$property_data.info.address_full}
                    </p>
                </div>
                <div class="detail-imgs">
                    {if isset($property_data.photo_default)}
                        <div class="img-main-watermark">
                            <img id="photo_main" src="{$MEDIAURL}/{$property_data.photo_default}" alt="Photo" style="width:400px;height:300px;" />
                            {if isset($property_data.info.watermark) }
                                <img id="mark" src="modules/general/templates/images/{$property_data.info.watermark}" class="watermark" alt="Watermark ON THE MARKET" style="width:400px;height:300px;display: block;" />
                            {/if}
                        </div>
                    {/if}
                    {if isset($property_data.photo) and is_array($property_data.photo) and count($property_data.photo)>0}
                        <div class="img-list-box" id="img-list-box">
                            <div class="img-prev">
                                <span class="icons"></span>
                            </div>

                            <div class="img-list" style="width:372px;height:93px;overflow:hidden;float:left">
                                <div id="img-list-slide">
                                {foreach from = $property_data.photo key = k item = row}
                                    {assign var = active value = ''}
                                    {if $k==0}
                                        {assign var = active value = 'active'}
                                    {/if}
                                    <div class="item {$active}"><img src="{$MEDIAURL}/{$row.file_name}" onmouseover="img(this)" alt="photos" style="width:123px;height:93px"/></div>
                                {/foreach}
                                </div>
                            </div>

                            <div class="img-next">
                                <span class="icons"></span>
                            </div>
                            <div class="clearthis">
                            </div>
                        </div>
                        <script type="text/javascript">SlideShow.init('#img-list-box','#photo_main')</script>
                    {/if}
                </div>
                <div class="property-desc">

                    <h2>PROPERTY DESCRIPTION</h2>
                    <div>
                        <p>
                            {$property_data.info.description}
                        </p>
                        
                    </div>
                </div>
            </div>
            <div class="col2 f-right">
                <div class="a-right">
                    <p class="propertyid">
                        <strong>Property ID: {$property_data.info.property_id}</strong>
                    </p>
                    <p class="detail-icons">
                        <span class="type">{$property_data.info.type_name} </span>
                        <span class="bed icons" id="bed_ic1">{$property_data.info.bedroom_value}</span>
                        <span class="bath icons" id="bed_ic2">{$property_data.info.bathroom_value}</span>
                        <span class="car icons" id="bed_ic3">{$property_data.info.carport_value}</span>
                    </p>
                    <p style="color: #666; font-size: 11px; font-weight: bold; margin: 0; "> Visits : {$property_data.info.views}{if $property_data.info.pro_type == 'auction'}| Bids: {$property_data.info.bids}{/if}</p>
                </div>

                <div class="detail-info-box">
                    {if $property_data.info.pro_type == 'forthcoming'}
                          <div class="auction-info-box" id="auc-{$property_data.info.property_id}">
                                <div class="auc-time">
                                    <p id="auc-time-{$property_data.info.property_id}">
                                       Auction Starts
                                    </p>
                                </div>
                                <div class="auc-bid">
                                     <p class="bid" id="auc-price-{$property_data.info.property_id}">
                                       {$property_data.info.start_time}
                                    </p>
                                </div>
                          </div>
                    {/if}
                    {if $property_data.info.pro_type == 'auction' and $property_data.info.stop_bid == 0 and $property_data.info.pay_status == 2 and $property_data.info.confirm_sold == 0}
                            <div class="auction-info-box" id="auc-{$property_data.info.property_id}">
                                <div class="auc-time">
                                    <p id="auc-time-{$property_data.info.property_id}">
                                        -d:-:-:-
                                    </p>
                                </div>
                                <div class="auc-bid">
                                     <p class="bid" id="auc-price-{$property_data.info.property_id}">

                                        {if $property.info.stop_bid == 1 or $property.info.confirm_sold == true or $property.info.transition == 1}
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
                                        {/if}{$property_data.info.price}
                                     </p>
                                    <p class="lasted" id="auc-bidder-{$property_data.info.property_id}">
                                        Last Bidder: {$property_data.info.bidder}
                                    </p>
                                </div>
                                <div class="buttons-set">
                                	<script type="text/javascript"> var agent_id = {$agent_id}; </script>
                                    <script type="text/javascript">
                                        if ({$property_data.info.remain_time} > 0)
                                            ids.push({$property_data.info.property_id});

                                        var time_{$property_data.info.property_id} = {$property_data.info.remain_time};

                                        var bid_{$property_data.info.property_id} = new Bid();
                                        bid_{$property_data.info.property_id}.setPriceObj('auc-price-{$property_data.info.property_id}');
                                        bid_{$property_data.info.property_id}.setContainerObj('auc-{$property_data.info.property_id}');
                                        bid_{$property_data.info.property_id}.setTimeObj('auc-time-{$property_data.info.property_id}');
                                        bid_{$property_data.info.property_id}.setBidderObj('auc-bidder-{$property_data.info.property_id}');

                                        bid_{$property_data.info.property_id}.setTimeValue('{$property_data.info.remain_time}');
                                        bid_{$property_data.info.property_id}.startTimer({$property_data.info.property_id});

										{literal}
										// BEGIN RESET CALLBACK FUNCTION & LISTENER AUTOBID
										if (jQuery('#frmAutoBid_'+ids[0])) {
											{/literal}
											bid_{$property_data.info.property_id}.flushCallbackFnc();

											//BEGIN SET CALLBACK FOR GETBID, AUTO BID
											bid_{$property_data.info.property_id}.addCallbackFnc('getBid',function(obj){literal}{

												if (obj.bidder_id != agent_id) {
													{/literal}
													return pro.listenerAutoBid('#frmAutoBid_'+ids[0],ids[0],bid_{$property_data.info.property_id});
													{literal}
												}
											});
											//END
											{/literal}

											//BEGIN SET CALLBACK FOR BID, will be received after bidder bid
											bid_{$property_data.info.property_id}.addCallbackFnc('bid_after',function(obj){literal}{
												if (obj.bidder_id == agent_id) {
													jQuery('#frmAutoBid_'+ids[0]+' #is_autobid').val(0);
													jQuery('#reg_autobid_btn').html('Accept');
													pro.closeAutoBidForm('#autobid_'+ids[0]);
													showMess(obj.msg);
												}
											});
											//END
										}
                                        // END
										{/literal}

                                    </script>

                                    <script type="text/javascript">
                                        var id_bid = {$property_data.info.property_id};
                                        var reserve_price={$property_data.info.reprice};
                                        var stop_bid={$property_data.info.stop_bid};
                                        var confirm_sold={$property_data.info.confirm_sold};

                                        {literal}
                                            function updatePrice(){
                                                var price = document.getElementById('auc-price-'+id_bid).innerHTML;
                                                //var i = 0;
                                                //while (price[i] != '$') i++;
                                                i = price.indexOf("$");
                                                price = price.substr(i,price.length - i + 1);
                                                document.getElementById('price-'+id_bid).innerHTML = price;

                                            }
                                            function updatePriceTime(){
                                                updatePrice();
                                                setInterval("updatePrice()",1000);
                                            }
                                            //Update Watermark and Bid Button color ;
                                            function update_watermark(){

                                                var price=document.getElementById('auc-price-'+id_bid).innerHTML;
                                                i = price.indexOf("$");
                                                price = price.substr(i+1,price.length - i + 1);
                                                //format price
                                                var j=0;
                                                for(j;j<=price.length;j++)
                                                {
                                                    price=price.replace(",","");
                                                }
                                                price=parseInt(price);
                                                //end
                                                if(confirm_sold==1)
                                                {
                                                    document.getElementById('mark').src="modules/general/templates/images/sold_detail.png";
                                                    document.getElementById('mark').style.display="inline";
                                                }
                                                else
                                                {
                                                    if(price>=reserve_price && stop_bid==0)
                                                    {
                                                        document.getElementById('mark').src="modules/general/templates/images/onthemarket_detail.png";
                                                        document.getElementById('mark').style.display="inline";
                                                        document.getElementById('bid_button').className="btn-bid-green";
                                                    }

                                                }

                                            }
                                        {/literal}
                                    </script>
                                    <div>


                                        <div style="float:left;width:122px;margin-top:4px;display: none;">
                                            <span style="float:left">Increment: </span>
                                            <strong style="width:70px;text-align:left;float:left;">
                                                <select name="step_option" id="step_option" class="input-select" style="width:100%">
                                                    {html_options options = $step_options selected = $step_init}
                                                </select>
                                            </strong>
                                            <script type="text/javascript">
                                                //BEGIN SET CALLBACK FOR BID, will be called before processing bid
                                                bid_{$property_data.info.property_id}.addCallbackFnc('bid_before',function(obj){literal}{
                                                    return {money_step:jQuery('#step_option_txt').val()};
                                                });
                                                //END

                                                //BEGIN SELECT PLUGIN
                                                var selectPlugin = new SelectPlugin({'targetId':'step_option'});
                                                selectPlugin.listener();
                                                //END
                                                {/literal}
                                            </script>
                                        </div>
                                        <div style="float:right">
                                            {assign var = bid_class value = 'btn-bid'}
                                            {assign var = fnc_str value = "bid_`$property_data.info.property_id`.click()"}
                                            {if $property_data.info.check_price == 'true'}
	                                            {assign var = bid_class value = 'btn-bid-green'}
                                                {assign var = fnc_str value = "bid_`$property_data.info.property_id`.click()"}
                                            {/if}
                                            {if isset($db_checkpartner) and $db_checkpartner.type_id == 3}
                                                {assign var = fnc_str value = "return showMess('Access denied. Please login as a vendor or buyer to use this function')"}
                                            {/if}
                                            
                                            {*<input id="bid_button" type="button" class="{$bid_class}" onclick="{$fnc_str}"/>*}
                                        </div>
                                        <br clear="all"/>
                                    </div>                                    

									<script type="text/javascript">

                                        {if ($action == 'view-auction-detail')and $property_data.info.pay_status==2}
                                            updatePriceTime();
                                            updateLastBidder();
                                            setInterval("update_watermark()",1000);
                                        {/if}
                                    </script>
                                </div>
                                <div class="auc-actions" style="position:relative">
                                	<center>
                                    	{if $agent_id > 0}
                                        	{assign var = fnc_str1 value = "showBidHistory(`$property_data.info.property_id`,'agent')"}
                                            {assign var = fnc_str2 value = "pro.openAutoBidForm('#autobid_`$property_data.info.property_id`','`$property_data.info.property_id`')"}
                                        	{if isset($db_checkpartner) and $db_checkpartner.type_id == 3}
                                                {assign var = fnc_str1 value = "return showMess('Access denied. Please login as a vendor or buyer to use this function')"}
                                                {assign var = fnc_str2 value = "return showMess('Access denied. Please login as a vendor or buyer to use this function')"}
                                            {/if}
                                            {*{if $property_data.info.pro_type == 'sale'}
                                            <a href="javascript:void(0)" style="display: none;"
                                                onclick="{$fnc_str1}">Aution / Bid history &raquo;</a>
                                            {else}
                                                <a href="javascript:void(0)" style="display: none;"
                                                onclick="{$fnc_str1}">Aution / Bid history &raquo;</a>
                                            {/if}*}

                                        {else}  
                                        	<a href="/?module=agent&action=login">Join Auction (as a bidder) &raquo;</a>  
                                        {/if}
                                  	 <!-- END CHECK PARTNER -->
                                    </center>

                                    <script type="text/javascript">
									{literal}
									//FOR THE FIRST TIME BIDDER SET AUTOBID SETTINGS (it will send one request to server)
									pro.addCallbackFnc('reg_auto_bid_before',function(obj) {
										if (obj.autobid) {
											{/literal}
											bid_{$property_data.info.property_id}.click();
											{literal}
										}
									});
									{/literal}
									</script>
                                </div>
                            </div>
                    {/if}

                    <div class="detail-info">
                        <ul>
                            <li>
                               <span class="detail-info-span-a">{$property_data.info.bedroom_value} Bedroom{if $property_data.info.bedroom_value > 1}s{/if}</span>
                               <span class="detail-info-span">{$property_data.info.bathroom_value} Bathroom{if $property_data.info.bathroom_value > 1}s{/if}</span>
                            </li>

                            <li>
                               <span class="detail-info-span-a">{$property_data.info.carport_value} Car park{if $property_data.info.carport_value > 1}s{/if}</span>
                               <span class="detail-info-span">{$property_data.info.land_size}</span>
                            </li>

                            <li>
                                Livability Rating
                                <div class="f-right" id="frgreen1">
                             {$property_data.info.livability_rating_mark}
                                </div>
                            </li>
                            <li>
                                iBB Sustainability
                                <div class="f-right" id="frgreen2">
                                   {$property_data.info.green_rating_mark}
                                </div>
                            </li>
                        </ul>


                            {if $is_bid_history}
                                {if $property_data.info.pro_type == 'sale'}
                                    <div style="text-align: center; font-weight: bold; margin-top: 30px; margin-bottom: 19px; font-size: 11px;">
                                        <a href="javascript:void(0)" onclick="showBidHistory('{$property_data.info.property_id}','agent')"> Bid History  &raquo;</a>
                                    </div>
                                {else}
                                    <div style="text-align: center; font-weight: bold; margin-top: 30px; margin-bottom: 19px; font-size: 11px;">
                                        <a href="javascript:void(0)" onclick="showBidHistory('{$property_data.info.property_id}','agent')"> Aution / Bid history &raquo;</a>
                                    </div>
                                {/if}
                            {/if}

                        {if $property_data.info.confirm_sold == 1}
                            <div style="text-align: center; font-weight: bold; margin-top: 30px; margin-bottom: 19px; font-size: 11px;margin-top: 15px;">
                                 <a href="javascript:void(0)" onclick="showBidHistory('{$property_data.info.property_id}','agent','winner-info')"> Winner Information &raquo;</a>
                            </div>
                        {/if}
                        <div class="p-detail-vm">
                            <span style="float:left;margin-top:5px;">{$property_data.view_more}</span>
                            <div style="float:right;margin-right:0px !important;">
                                {if $agent_id > 0 and $db_checkpartner.type_id != 3 and !($property_data.info.stop_bid == 1 and $property_data.info.check_price=='true') }
                                    <button style="margin-right:0px !important;display: none;" class="btn-wht btn-make-an-ofer btn-make-an-ofer-f"
                                    onclick="pro.openMakeAnOffer('#makeanoffer_{$property_data.info.property_id}','{$property_data.info.property_id}')">
                                        <span><span>Make an Offer</span></span>
                                    </button>
                                {/if}

                            	<!-- END CHECK PARTNER -->
                                 {$property_data.mao}
                            </div>
                        </div>
                    </div>
                    <div class="email-box" style="">
                        <span style="display: none;"><a href="javascript:void(0)" onClick="showSendfriend('{$property_data.info.property_id}','{$agent_info.email}')" >SEND TO A FRIEND</a></span>
                        <span> <a href="javascript:void(0)" onclick="return myReport('modules/property/print.php?action={$action}&id={$property_data.info.property_id}')" >PRINT BROCHURE </a> </span>
                     
                    </div>
                </div>
                
                {if $agent_id > 0}
                    {if isset($property_data.docs) and is_array($property_data.docs) and count($property_data.docs)>0}
                        <div class="pdf-documents-download">
                            {foreach from = $property_data.docs key = k item = row}
                                <p>
                                    <!--<button class="btn-pdf-download" onclick="Property.downDoc('{$ROOTURL}/{$row.file_name}')">-->
                                    <button class="btn-pdf-download" onclick="pro.downDoc('/modules/property/action.php?action=down-doc&property_id={$row.property_id}&document_id={$row.document_id}')">
                                        <div style="width:165px; margin-bottom:3px;">
                                            <span id="ftrtitle">{$row.title}</span>
                                        </div>
                                    </button>
                                </p>
                            {/foreach}
                        </div>
                    {/if}
                {/if}
               
                
            </div>
            <div class="clearthis">
            </div>
        </div>
        {if !$is_localhost}
            <div class="map" id="div_google_map" style="display:none">
                <div>
                    {assign var = new_address value = "`$property_data.info.address_full`"}
                    <iframe id = "if_google_map" src="" width="620" height="360" frameborder="0" scrolling="no"> </iframe>
                </div>
            </div>
            <script type="text/javascript" charset="utf-8">
            var src_google_map = 'modules/property/google_map.php?address={$new_address}';
            {literal}
            $(function(){
                jQuery('#div_google_map').show();
                jQuery('#if_google_map').attr('src',src_google_map);
            });
            {/literal}
            </script>        
        {/if}
		{if $can_comment and $property_data.info.auction_blog == 1}
			{include file = 'property.comment.tpl'}
        {/if}
       	{/if}
    </div>
</div>