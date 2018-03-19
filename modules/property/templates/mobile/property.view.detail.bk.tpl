<link href="{$ROOTURL}/modules/general/templates/js/tab/style.css" rel="stylesheet" type="text/css" />
{if $item_number}
    <script type="text/javascript">
      
        {literal}
       jQuery(document).ready(function(){   
           term.showPopup('{/literal}{$item_number}{literal}'); 
             
       });
        {/literal}
    </script>
{/if}
{literal}
    <style type="text/css">
        #property_detail{margin-top:10px}
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
            margin-top:5px;
            width: 205px;
        }
        #ftrtitle {
            font-size:11px;
        }
        .increment-detail-fix #step_option_txt {
            width: 90px;z-index: 1;
        }
        #step_option_txt {
            width: 90px;
        }
         
    </style>
{/literal}
 
<script type="text/javascript" src="/modules/calendar/templates/js/calendar.popup.js"></script>
<script type="text/javascript" src="/modules/general/templates/js/calc.js"></script>
<script type="text/javascript" src="/modules/general/templates/js/propose-increment.js"></script>
<script type="text/javascript" src="/modules/general/templates/js/ialert.js"></script>
{*<script type="text/javascript" src="/modules/general/templates/js/ipad.js"></script>*}
<script type="text/javascript" src="/modules/general/templates/js/audio.js"></script>


<script type="text/javascript" src="/modules/general/templates/js/tab/sprinkle.js"></script>

<script type="text/javascript" languange="javascript">
    var media = '{$MEDIAURL}';
    {literal}
function img(obj) {
    jQuery(obj).click();
}
function myReport(id){
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
    newwin = window.open('','', params);
    var html = '<link rel="stylesheet" type="text/css" href="/modules/general/templates/style/detail-print.css"/>';
	 	
    html += '<body> <div class="wrapper-print">\
             <div class="logo-box" style="float: left;">\
                 <a href="'+ ROOTURL +'"><img src="'+media+'/modules/general/templates/images/ibb-logo.png" alt="logo iBB" id="print_logo"/></a>\
             </div>\
             <p style="float:right; margin-top:85px;">\
                 <a href="javascript:void(0)" id="prt" onclick="return prints_();">\
                     <img src="'+media+'/modules/general/templates/images/Printer-icon.png" style="border:none" /></a></p>\
             <div class="clearthis"></div><div class="col-main-print property-box-detail" id="print_content">'+ jQuery('#property-box-d').html() +'</div></div></body>';
		
    newwin.document.write('<scr'+'ipt type="text/javascript" src="/modules/general/templates/js/jquery.min.js" ></scr'+'ipt>');
    newwin.document.write(html);

    if (window.focus) {newwin.focus()}
    return false;
}
    </script>
{/literal}
<div class="pag-short">
    {if $property_data.info.prev != ''}
        <span class="l icons">{$property_data.info.prev}</span>
    {/if}
    {if $property_data.info.next != ''}
        <span class="r icons">{$property_data.info.next}</span>
    {/if}
    <br clear="all"/>
</div>
    <div style="height:10px;"></div>
<div id="tabvanilla" >

    <ul class="tabnav">
        <li><a href="#info"><div style="width:90px;height:30px;">Information</div></a></li>
        <li><a href="#bid"><div style="width:90px;height:30px;">Bid</div></a></li>
        {if $property_data.info.show_agent_logo == 1}
        <li><a href="#agent-info"><div style="width:90px;height:30px;">Agent Details</div></a></li> 
        {/if}
    </ul>
    <div style="clear: both"></div>
    <div id="info" class="tabdiv">
             
        <div class="property-box property-box-detail" id="property-box-d">
            <div class="bar-title">
                <h2>{$property_data.info.title}</h2>
            </div>
        
            <div class="property-detail">
                <script type="text/javascript">
                    var ids = [];
                    var pro = new Property();
                    ids.push({$property_data.info.property_id});
                </script>
                {if isset($property_data.info) and is_array($property_data.info) and count($property_data.info) > 0 }
                    <div class="detail-2col">

                        <div class="col1">
                            <div>
                                <p class="propertyid">
                                    <strong>Property ID: {$property_data.info.property_id}</strong>
                                    </p>
                                    <p><span class="price"><span id="price-{$property_data.info.property_id}">{$property_data.info.price}</span>{if $property_data.info.pro_type_code == 'ebiddar'}<span class="period">{$property_data.info.period}</span>{/if}</span>
                                </p>

                                 <div class="visit-block">

                                <p class="detail-icons">
                                    <span class="type">{$property_data.info.type_name} </span>
                                    {if $property_data.info.kind != 1}
                                        {if $property_data.info.bedroom_value > 0}
                                            <span class="bed icons" id="bed_ic1">{$property_data.info.bedroom_value}</span>
                                        {/if}
                                        {if $property_data.info.bathroom_value > 0 }
                                            <span class="bath icons" id="bed_ic2">{$property_data.info.bathroom_value}</span>
                                        {/if}
                                    {/if}
                                    {if $property_data.info.parking == 1}
                                        <span class="car icons" id="bed_ic3">{$property_data.info.carport_value}</span>
                                    {/if}
                               &nbsp;&nbsp;
                                <span style="color: #666; font-size: 11px; font-weight: bold; margin: 0; ">
                                    Visits : <span id="view-no"> {$property_data.info.views}</span>
                                    {if $property_data.info.pro_type == 'auction'}
                                        | Bids: <span id="bid-no-{$property_data.info.property_id}"> {$property_data.info.bids}</span>
                                    {/if}
                                </span>
                                 </p>
                            </div>
                                <p class="address" style="margin-top:10px;">
                                    {$property_data.info.address_full}
                                </p>
                            </div>
                            <div class="detail-imgs">
                                {if isset($property_data.photo_default)}
                                    <div class="img-main-watermark">
                                        <img id="photo_main" src="{$MEDIAURL}/{$property_data.photo_default}" alt="Photo"
                                             class="p-watermark-detail-big" style=""/>
                                        <img id="mark" src="{$MEDIAURL}/{$property_data.photo_default}" class="watermark" alt="onthemarket"
                                             style="display: none;"/>
                                        <img id="img_ebidda_mark_detail_{$property_data.info.property_id}" src="{$property_data.ebidda_detail_watermark}" class="watermark_ebidda" width="107" height="95"
                                             style="{if $property_data.ebidda_detail_watermark != ""}display: block{else}display: none{/if}"/>
                                        {* Begin Add watermark *}
                                        {if $property_data.info.pay_status == 'complete'}
                                            {if $property_data.info.active == 0 AND $isAgent AND $property_data.info.confirm_sold == 0}
                                                <script type="text/javascript">
                                                    jQuery('#mark').attr('src', '{$MEDIAURL}/modules/general/templates/images/wait_activation_detail.png');
                                                    jQuery('#mark').css('display', 'block');
                                                </script>
                                            {else}
                                                {if $property_data.info.confirm_sold == 1}
                                                        <script type="text/javascript">
                                                            {if $property_data.info.pro_type_code == 'ebiddar'}
                                                        jQuery('#mark').attr('src', '{$MEDIAURL}/modules/general/templates/images/rent_detail.png');
                                                            {else}
                                                        jQuery('#mark').attr('src', '{$MEDIAURL}/modules/general/templates/images/sold_detail.png');
                                                        {/if}
                                                    jQuery('#mark').css('display', 'block');
                                                    </script>
                                                {else}
                                                    {if ($property_data.info.check_price and  $property_data.info.stop_bid == 0)}
                                                        <script type="text/javascript">
                                                            jQuery('#mark').attr('src','{$MEDIAURL}/modules/general/templates/images/onthemarket_detail.png');
                                                            jQuery('#mark').css('display', 'block');
                                                        </script>
                                                        {elseif (($property_data.info.pro_type == 'auction'
                                               and (!($property_data.info.check_price)
                                                   or ($property_data.info.isLastBidVendor)
                                                   or ($property_data.info.ofAgent || $property_data.info.isBlock)
                                                   )
                                               and $property_data.info.stop_bid == 1
                                               ))
                                                        }
                                                        <script type="text/javascript">
                                                            jQuery('#mark').attr('src', '{$MEDIAURL}/modules/general/templates/images/passedin_detail.png');
                                                            jQuery('#mark').css('display', 'block');
                                                        </script>
                                                    {/if}
                                                {/if}
                                            {/if}
                                        {elseif $isAgent}
                                            <script type="text/javascript">
                                                jQuery('#mark').attr('src', '{$MEDIAURL}/modules/general/templates/images/notcomplete_detail.png');
                                                jQuery('#mark').css('display', 'block');
                                            </script>
                                        {/if}
                                        {*End Add watermark *}
                                        {* Begin For The block*}
                                        {if $property_data.info.isBlock}
                                            <img src="{$MEDIAURL}/modules/general/templates/images/block_detail.png" class="watermark"
                                                 alt="" style="display: block"/>

                                            <div class="text-mark" style="position: relative;">
                                                <p class="title">
                                                    {$property_data.info.owner}
                                                </p>
                                            </div>
                                        {/if}
                                        {* END*}
                                    </div>
                                {/if}
                                {*End Photo Main *}
                                {*Begin Photo Slide*}
                                {if isset($property_data.photo) and is_array($property_data.photo) and count($property_data.photo)>0}
                                    <div class="img-list-box" id="img-list-box">
                                        <div class="img-prev">
                                            <span class="icons"></span>
                                        </div>
                                        <div class="img-list" style="width:440px;height:93px;overflow:hidden;float:left">
                                            <div id="img-list-slide">
                                                {foreach from = $property_data.photo key = k item = row}
                                                    {assign var = active value = ''}
                                                    {if $row.file_name == $property_data.photo_default}
                                                        {assign var = active value = 'active'}
                                                    {/if}
                                                    <div class="item {$active}">
                                                        <a>
                                                            <img src="{$MEDIAURL}/{$row.file_name}" onmouseover="img(this)" alt="photos"
                                                                 style="width:123px;height:93px"/>
                                                        </a>
                                                    </div>
                                                {/foreach}
                                            </div>
                                        </div>
                                        <div class="img-next">
                                            <span class="icons"></span>
                                        </div>
                                        <div class="clearthis">
                                        </div>
                                    </div>
                                    <script type="text/javascript">SlideShow.init('#img-list-box', '#photo_main')</script>
                                {/if}
                            </div>
                            {*Begin share twitter/facebook*}
                            {if $isShow }
                                <div class="clearthis"></div>
                                <div class="tw-face">
                                    <iframe allowtransparency="true" frameborder="0" scrolling="no"
                                            src="//platform.twitter.com/widgets/tweet_button.html"
                                            style="width:55px; height:20px;float:left;">
                                    </iframe>
                                    <div class="fb-like" data-href="{$property_data.link}" data-send="false" data-width="341" data-show-faces="false" data-font="arial" style="float:right;"></div>
                                </div>
                            {/if}
                            {*End*}
                            <div class=clearthis></div>
                           





                            {if $property_data.info.remain_time < 0}
                                <script type="text/javascript">
                                    jQuery('#auc-time-{$property_data.info.property_id}').html('Ended');
                                </script>
                            {/if}



                            {if $agent_id > 0}
                                {if isset($property_data.docs) and is_array($property_data.docs) and count($property_data.docs)>0}
                                    <div class="pdf-documents-download">
                                        {foreach from = $property_data.docs key = k item = row}
                                            <p>
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
                            <div class="property-desc">
                                {if $property_data.agent && $property_data.agent.logo != ''}
                                    {if $property_data.info.isBlock}
                                        <img id="imgCompanyLogo" src="{$MEDIAURL}/{$property_data.agent.logo}" alt="{$property_data.agent.company_name}" title="Click here to view all property" width="100%" style="padding: 10px 0"/>
                                    {else}
                                        <img id="imgCompanyLogo"  src="{$MEDIAURL}/{$property_data.agent.logo}" alt="{$property_data.agent.company_name}" title="Click here to view all property" width="401" style="padding: 10px 0"/>
                                        {/if}

                                {/if}
                                <h2>PROPERTY DESCRIPTION</h2>
                                <div class="div-des-detail" style="font-size:12px;">
                                    <p class="word-wrap-all word-justify">
                                        {$property_data.info.description}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {*Begin Right*}
                         
                        <!-- End right column-->
                        <div class="clearthis">
                        </div>
                    </div> {*End Colmain*}

                    {if !$is_localhost}
                        <div class="map google-map" style="display:none">
                            <div>
                                {assign var = new_address value = "`$property_data.info.address_full`"}
                                <iframe class = "if_google_map" src="" width="290" height="230" frameborder="0" scrolling="no"> </iframe>
                            </div>
                        </div>
                        <script type="text/javascript" charset="utf-8">
                            var src_google_map = '{$ROOTURL}/modules/property/google_map_mobile.php?address={$new_address}';
                            {literal}
                        $(function(){
                                             /*
                            jQuery('#div_google_map').show();
                            jQuery('#if_google_map').attr('src',src_google_map);
                                        */
                            jQuery('.google-map').show();
                            jQuery('.google-map .if_google_map').attr('src',src_google_map);
                            jQuery('.if_google_map').attr('width',jQuery(window).width() - 17);   
                        });
                            {/literal}
                        </script>
                        <script type="text/javascript">
                            {literal}
               $(function(){ 
                   jQuery('.img-list').css('width', jQuery(window).width() - 60);
                      jQuery( ".img-list img" ).each(function() {
                        jQuery(this).css('width', (jQuery(window).width() - 62)/2);
                      });
                    jQuery('#if_google_map').css('width', jQuery(window).width());
                    jQuery('#imgCompanyLogo').css('width', jQuery(window).width()-30);
                        
                             
                 //  jQuery('.btn-bid-green').tipsy({gravity: $.fn.tipsy.autoNS,fallback: " <div style='padding: 5px;text-align: justify'>When the bid button turns green the property is on the market</div>",html: true });
                   //jQuery('.btn-bid-vendor-green').tipsy({gravity: $.fn.tipsy.autoNS,fallback: " <div style='padding: 5px;text-align: justify'>When the bid button turns green the property is on the market</div>",html: true });
               });
                            {/literal}
                        </script>
                    {/if}
                    {if $can_comment and $property_data.info.auction_blog == 1}
                        {include file = 'property.comment.tpl'}
                    {/if}
                {else}
                    <div class="message-box message-box-add" style=""><center><i>Sorry, but there are no properties available based on your selection. Please modify the filters to search again. Thanks!</i></center></div>
                     
                {/if}
            </div>
            {*<script type="text/javascript" src="/modules/general/templates/js/jquery.min.js"></script>*}
            <script type="text/javascript">
                        var title_bar = "{$property_data.info.title}";
                        var property_id = "{$property_data.info.property_id}";
            </script>
            <script type="text/javascript" src="/modules/property/templates/js/print.js"></script>
        </div>
    </div> 
            
    <div id="bid" class="tabdiv">
        {if isset($property_data.info) and is_array($property_data.info) and count($property_data.info) > 0 }
        <div class="detail-info-box  gradient-box">

            {if $property_data.info.pro_type == 'sale'}
        {elseif $property_data.info.pro_type == 'forthcoming'} {*Forthcoming Property *}
            <div class="auction-info-box" id="auc-{$property_data.info.property_id}">
                <div class="auc-time">
                    <p id="auc-price-{$property_data.info.property_id}">
                {if $isSold } Sold {else} Auction Starts {/if}
            </p>
        </div>
        {if !$isSold }
            <div class="auc-bid">
                <p class="bid" id="auc-time-{$property_data.info.property_id}">
                    {if $property_data.info.isBlock}
                        -d:-:-:-
                    {else}
                        {$property_data.info.start_time}
                    {/if}
                </p>
            </div>
        {/if}
        {*&& $property_data.info.pro_type_code == 'auction' *}
        {if ($property_data.info.isBlock || ($property_data.info.ofAgent)) AND !$isSold }
            <script type="text/javascript">
                var test = bid_{$property_data.info.property_id};
                {literal}
                if (typeof test == 'undefined'){
                {/literal}
                var bid_{$property_data.info.property_id} = new Bid();
                bid_{$property_data.info.property_id}.setTimeObj('auc-time-{$property_data.info.property_id}');
                {if $property_data.info.isBlock}
                    var time_{$property_data.info.property_id} = {$property_data.info.remain_time};
                    bid_{$property_data.info.property_id}.setTimeValue('{$property_data.info.remain_time}');
                    bid_{$property_data.info.property_id}.startTimer({$property_data.info.property_id});
                {/if}
                                bid_{$property_data.info.property_id}._options.property_id = {$property_data.info.property_id};
                                bid_{$property_data.info.property_id}._options.theblock = true;
                                bid_{$property_data.info.property_id}._options.transfer = false;
                                bid_{$property_data.info.property_id}._options.transfer_template = 'detail';
                                bid_{$property_data.info.property_id}._options.transfer_container = 'auc-{$property_data.info.property_id}';
                }
            </script>
        {/if}
        {*REGISTER BID FOR THE BLOCK AND FORTHCOMING: NHUNG*}
        <div id="property_detail">
            {if !$isAgent and !$isSold AND  !($property_data.info.ofAgent AND $property_data.info.pro_type_code == 'auction')}
                {assign var = check_show_bid value = false }
                {if !$property_data.info.register_bid}
                    {assign var = check_show_bid value = true }
                    <div style="float:right">
                        <input type="button" id="bid_button_{$property_data.info.property_id}" class="btn-bid-reg"
                               onclick="PaymentBid({$property_data.info.property_id})" value=""/>
                    </div>
                {/if}
                {if !$property_data.info.isBlock}
                    {assign var = btn_offer_class value="btn-make-an-ofer"}
                    <div id="makeanoffer-popup" style="{if !$check_show_bid }float: right;{else}float:left;{/if}">
                        <button id="btn-offer-{$property_data.info.property_id}" style="margin-right:0px !important;" class="btn-wht {$btn_offer_class} btn-make-an-ofer-f"
                                onclick="pro.openMakeAnOffer('#makeanoffer_{$property_data.info.property_id}','{$property_data.info.property_id}')">
                        </button>
                        {$property_data.mao}
                    </div>
                {/if}
            {/if}
            <div class="clearthis"></div>
        </div>
    </div>
{else} {*Auction Property*}
    {*<div class="top-info" style="height: 335px;">*}
    {*{if $property_data.info.stop_bid == 0 and $property_data.info.pay_status == 2 and $property_data.info.confirm_sold == 0}*}
    <div class="auction-info-box" id="auc-{$property_data.info.property_id}">
        <div class="auc-time">
            {if $isSold }
                {if $property_data.info.pro_type_code == 'ebiddar'}
                    <p>Leased</p>
                {else}
                    <p> Sold </p>
                {/if}
            {else}
                {if $property_data.info.isBlock || ($property_data.info.ofAgent && $property_data.info.pro_type_code == 'auction')}
                    <p id="count-{$property_data.info.property_id}">
                        {$property_data.info.set_count}
                    </p>
                {else}
                    {if (($property_data.info.pro_type == 'auction'
                                               and (!($property_data.info.check_price)
                                               or ($property_data.info.isLastBidVendor)
                                               or (($property_data.info.ofAgent && $property_data.info.pro_type_code == 'auction') || $property_data.info.isBlock)
                                               )
                                               and $property_data.info.stop_bid == 1
                                               ))
                    }
                    <p id="passedin-{$property_data.info.property_id}">
                        Passed In
                    </p>
                {else}
                    <p id="auc-time-{$property_data.info.property_id}">
                        -d:-:-:-
                    </p>
                {/if}
            {/if}
        {/if}
    </div>
    {if $property_data.info.check_price}
        <script type="text/javascript">
                    var timer_id_ = "{$property_data.info.count}";
                    var id_ = {$property_data.info.property_id}
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
    <div class="auc-bid">
        <p class="bid" id="auc-price-{$property_data.info.property_id}">
            <span class="bid-text">
                {if $property_data.info.stop_bid == 1 or $property_data.info.transition == true or $property_data.info.confirm_sold == 1}
                    {assign var=temp value = 0}
                    {if $property_data.info.stop_bid == 1}
                        {if $property_data.info.bidder == '--'}
                            Start Price:
                            {assign var=temp value = 1}
                        {/if}
                    {/if}
                {if !$temp}Last Bid:{/if}

            {elseif $property_data.info.check_start == 'true'}
                Start Price:
            {else}
                Current Bid:
            {/if}
        </span>
        <span class="bid-num">
            {$property_data.info.price}
        </span>
    </p>
    <p class="lasted" id="auc-bidder-{$property_data.info.property_id}">
        {if $property_data.info.isLastBidVendor}
            <span>Vendor Bid</span>
        {else}
            {if $property_data.info.stop_bid == 1 or $property_data.info.transition == true or $property_data.info.confirm_sold == 1}
                <span>Last Bidder:</span><strong> {$property_data.info.bidder}</strong>
            {else}
                <span>Current Bidder:</span><strong> {$property_data.info.bidder}</strong>
            {/if}
        {/if}
    </p>
</div>

<div class="buttons-set">
    <script type="text/javascript"> var agent_id = {$agent_id}; </script>
    <script type="text/javascript">
                if ({$property_data.info.remain_time} > 0 || {$property_data.info.isBlock} || {$property_data.info.ofAgent} )
                ids.push({$property_data.info.property_id});
 
                var time_{$property_data.info.property_id} = {$property_data.info.remain_time};
                var timer_{$property_data.info.property_id} = '{$property_data.info.count}';
                var test = bid_{$property_data.info.property_id};
                {literal}
                if (typeof test == 'undefined'){
                {/literal}
                var bid_{$property_data.info.property_id} = new Bid();
                bid_{$property_data.info.property_id}.setPriceObj('auc-price-{$property_data.info.property_id}');
                bid_{$property_data.info.property_id}.setContainerObj('auc-{$property_data.info.property_id}');
                bid_{$property_data.info.property_id}.setTimeObj('auc-time-{$property_data.info.property_id}');
                bid_{$property_data.info.property_id}.setBidderObj('auc-bidder-{$property_data.info.property_id}');
                bid_{$property_data.info.property_id}.setTimeValue('{$property_data.info.remain_time}');
                bid_{$property_data.info.property_id}.startTimer({$property_data.info.property_id});
                bid_{$property_data.info.property_id}._options.transfer = true;

            {if ($property_data.info.isBlock == 1 || ($property_data.info.ofAgent == 1 && $property_data.info.pro_type_code == 'auction')) && $property_data.info.confirm_sold == 0}
                    bid_{$property_data.info.property_id}.setContainer('count-{$property_data.info.property_id}');
                    bid_{$property_data.info.property_id}._options.theblock = true;
                    var count_{$property_data.info.property_id} = new CountDown();
                    count_{$property_data.info.property_id}.container = 'count-{$property_data.info.property_id}';
                    count_{$property_data.info.property_id}.bid_button = 'bid_button_{$property_data.info.property_id}';
                    count_{$property_data.info.property_id}.button = 'btn_count_{$property_data.info.property_id}';
                    count_{$property_data.info.property_id}.property_id = '{$property_data.info.property_id}';
        {/if}
                }
        {literal}
                                                var confirm_nh = new Confirm_popup();
                                               /* BEGIN RESET CALLBACK FUNCTION & LISTENER AUTOBID*/
                                               if (jQuery('#frmAutoBid_' + ids[0])) {
        {/literal}
                    bid_{$property_data.info.property_id}.flushCallbackFnc();
                    /*BEGIN SET CALLBACK FOR GETBID, AUTO BID*/
                    bid_{$property_data.info.property_id}.addCallbackFnc('getBid_before',function(obj){literal}{
                                                       if (typeof obj.out_bidder_id != 'undefined' && obj.out_bidder_id == agent_id) {
        {/literal}
                        return pro.listenerStopAutoBid('#frmAutoBid_' + ids[0], ids[0], obj);
            {literal}
                                                       }
                                                   });
            {/literal}
                            /*END*/
                            /*BEGIN SET CALLBACK FOR GETBID, AUTO BID*/
                            bid_{$property_data.info.property_id}.addCallbackFnc('getBid_after',function(obj){literal}{
                                                       if (obj.bidder_id != agent_id) {
            {/literal}
                                    /*return pro.listenerAutoBid('#frmAutoBid_'+ids[0],ids[0],bid_{$property_data.info.property_id});*/
                {literal}
                                                       }
                                                   });
                {/literal}
                                    /*END*/
 
                                    /*BEGIN SET CALLBACK FOR BID, will be received after bidder bid*/
                                    /*
                                                   bid_{$property_data.info.property_id}.addCallbackFnc('bid_after',function(obj){literal}{
                                                       if (obj.bidder_id == agent_id) {
                                                           jQuery('#frmAutoBid_'+ids[0]+' #is_autobid').val(0);
                                                           jQuery('#reg_autobid_btn').html('Accept');
                                                           pro.closeAutoBidForm('#autobid_'+ids[0]);
                                                           showMess(obj.msg);
                                                       }
                                                   });
                                                   */
                                                   /*END*/
                                               }
                                               /* END*/
                {/literal}
 
                </script>

                <script type="text/javascript">
                             
                                    var id_bid = {$property_data.info.property_id};
                                    var reserve_price = {$property_data.info.reprice};
                                    var stop_bid = {$property_data.info.stop_bid};
                                    var confirm_sold = {$property_data.info.confirm_sold};
                                    var isAgent = {if $isAgent}1{else}0{/if};
                                    var isRent = false;
                    {if $property_data.info.pro_type_code == 'ebiddar'}
                                        isRent = true;
                    {/if}
                        
                                        var register_bid = {if $property_data.info.register_bid }1{else}0{/if};
                    {literal}
                                                   function updatePrice(){

                                                       var price = jQuery('#auc-price-'+id_bid).html().replace('$','');
                                                       price = parseFloat(price.replace(new RegExp(/[^\d+]/g),''));
                                                       if(price > 0 )
                                                       {
                                                           jQuery('#price-'+id_bid).html(formatCurrency(price));
                                                       }
                                                   }
                                                   function updatePriceTime(){
                                                       updatePrice();
                                                       setInterval("updatePrice()",1000);
                                                   }
                                                   /*Update Watermark and Bid Button color ;*/
                                               function update_watermark() {
                                                   var Sold = jQuery('#auc-time-' + id_bid).html();
                                                   var price = document.getElementById('auc-price-' + id_bid).innerHTML;
                                                   var i = price.indexOf("$");
                                                   price = price.substr(i + 1, price.length - i + 1);
                                                   /*format price*/
                                                   var j = 0;
                                                   for (j; j <= price.length; j++) {
                                                       price = price.replace(",", "");
                                                   }
                                                   price = parseInt(price);
                                                   /*end*/
                                                   if (confirm_sold == 1 || Sold == 'Sold') {
                                                       if(isRent){
                                                           document.getElementById('mark').src = "../modules/general/templates/images/rent_detail.png";
                                                           jQuery('#auc-time-' + id_bid).html('Leased');
                                                       }else{
                                                           document.getElementById('mark').src = "../modules/general/templates/images/sold_detail.png";
                                                           jQuery('#auc-time-' + id_bid).html('Sold');
                                                       }
                                                       document.getElementById('mark').style.display = "block";
                                                   }
                                                   else {
                                                       if (price >= reserve_price && stop_bid == 0 && reserve_price > 0) {
                                                           document.getElementById('mark').src = "modules/general/templates/images/onthemarket_detail.png";
                                                           document.getElementById('mark').style.display = "block";
                                                           if ($('#bid_button').length > 0) {
                                                               if (isAgent) {
                                                                   document.getElementById('bid_button').className = "btn-bid-vendor-green";
                                                                   document.getElementById('bid_room_button').className = "btn-bid-green";
                                                               }
                                                               else {
                                                                   if (register_bid == 1) {
                                                                       document.getElementById('bid_button').className = "btn-bid-green";
                                                                   }
                                                                   else {
                                                                       document.getElementById('bid_button').className = "btn-bid-green-reg";
                                                                   }
                                                               }
                                                           }
                                                       }
 
                                                   }
                                               }
                    {/literal}
                      
                </script>
                <div id="property_detail">
                    <div class="property-detail-a" style="margin-bottom: 8px;">
                        <input type="hidden" value="{$default_inc}" id="default_inc" />
                        {if $agent_info.id > 0 AND !$isSold  AND $property_data.info.stop_bid == 0 }
                            <script type="text/javascript">
                                {literal}
                                                               var value_show = '';
                                                               $(document).ready(function (){

                                                                  jQuery('#step_option1').val(jQuery("#step_option").val());
                                                                   jQuery("#step_option_txt").keyup(function(){
                                                                       this.value = format_price(this.value,'#step_option1','#property_detail');
                                                                       value_show = this.value;
                                                                       jQuery("#step_option").val(jQuery('#step_option1').val());
                                                                   }
                                                                   );
                                                                   jQuery("#step_option").change(function(){
                                                                      jQuery('#step_option1').val(jQuery("#step_option").val());
                                                                   }
                                                                   );
                                                                   jQuery("#step_option_txt").focusout(function (){
                                                                       if(value_show == '$0' || value_show == '')
                                                                       {
                                                                           jQuery('#uniform-step_option span').html(jQuery('#default_inc').val());
                                                                       }
                                                                       else
                                                                       {
                                                                           jQuery('#uniform-step_option span').html(value_show);
                                                                       }
                                                                   });
                                                                    jQuery("#step_option_txt").focusin(function (){
                                                                       this.value = format_price(this.value,'#step_option1','#property_detail');
                                                                   });
                                                               });
                                </script>
                            {/literal}

                            {if $property_data.info.completed}
                                {if in_array($authentic.type,array('theblock','agent')) && $property_data.is_mine == true}
                                    <span style="float:left;padding-top: 4px;">Bid price: </span>
                                    <input class="input-text" type="text" name="step_option" id="step_option_txt" value="" style="width:101px;float:right;margin-right: 2px;margin-bottom: 10px;"/>
                                    <script>
                                                        bid_{$property_data.info.property_id}._options.mine = true;
                                    </script>
                                {elseif $isAgent  OR(!$isAgent AND $is_paid AND $property_data.info.register_bid) }
                                    <span style="float:left">Increment: </span>
                                    <strong class="strong-increment-detail increment-detail-fix" >
                                        <select name="step_option" id="step_option" class="input-select" style="width:107px;height: 25px;-webkit-appearance: menulist-button;z-index: 999;">
                                            {html_options options = $inc_options selected = $step_init}
                                        </select>
                                    </strong>
                                        
                        <div class="clearthis"></div>
                                    <script type="text/javascript">
                                        {if $property_data.info.isBlock }
                                        {literal}var dis_input = true;{/literal}
                                    {else}
                                    {literal}var dis_input = false;{/literal}
                                {/if}
                                {literal}
                                                                           /*BEGIN SELECT PLUGIN*/
                                                                           //var selectPlugin = new SelectPlugin({'targetId':'step_option','money_step' : 'step_option1',disable_input: dis_input});
                                                                           //selectPlugin.listener();
                                                                           /*END*/
                                {/literal}
                            </script>

                            {if $property_data.info.isBlock}
                                {assign var="detail_info" value="min-height:75px !important"}
                                <p style="height: 10px"></p>
                                <div style="clear: both;background-color: LemonChiffon;">
                                    <span style="display: block;text-align: center;">
                                        {*{$property_data.info.minmaxInc}*}
                                    </span>
                                    <span id="MinMax_mess_{$property_data.info.property_id}" style="display: block;padding: 0px 5px;text-align: center;">
                                        {$property_data.info.minmaxInc_mess}
                                        {*Your increment must be satisfy conditions of min and max increment*}
                                    </span>
                                </div>
                            {/if}
                        {/if}
                    {/if}

                    <input type="hidden" name="step_option1" id="step_option1" value="{$step_init}" />
                    {*BEGIN SET CALLBACK FOR BID, will be called before processing bid*}
                    {*{if $property_data.info.isBlock}
                    <script type="text/javascript">
                    bid_{$property_data.info.property_id}.addCallbackFnc('bid_before',function(obj){literal}{
                    return {money_step:jQuery('#step_option').val()}
                    });
                    {/literal}
                    </script>
                    {else}*}
                    <script type="text/javascript">
                                        bid_{$property_data.info.property_id}.addCallbackFnc('bid_before',function(obj){literal}{
                                return {money_step:jQuery('#step_option1').val()}
                                });
                        {/literal}
                        </script>
                        {*{/if}*}
                        {*END*}
                        {/if}
                        </div>  
                        <div class="property-detail-b" style="position: relative; *display: inline-block;">
                            {if !($property_data.info.isBlock AND $property_data.info.stop_bid == 0) AND !$isAgent AND  !($property_data.info.ofAgent AND $property_data.info.stop_bid == 0 AND $isAuction)  AND !$isSold}
                                <div style="float:left;margin-right:5px !important;">

                                    {if $property_data.info.check_price }
                                        {assign var = btn_offer_class value="btn-make-an-ofer-green"}
                                    {else}
                                        {assign var = btn_offer_class value="btn-make-an-ofer"}
                                    {/if}
                                    <button id="btn-offer-{$property_data.info.property_id}" style="margin-right:0px !important;margin-top: 0px;" class="btn-wht {$btn_offer_class} btn-make-an-ofer-f"
                                            onclick="pro.openMakeAnOffer('#makeanoffer_{$property_data.info.property_id}','{$property_data.info.property_id}');{$fnc_strAT}">
                                    </button>

                                    <!-- END CHECK PARTNER -->
                                    {$property_data.mao}
                                </div>
                            {/if}


                            {assign var = fnc_str value = "bid_`$property_data.info.property_id`.click()"}
                            {assign var = bid_dis value ="display: none"}

                            {if !$isSold AND $property_data.info.stop_bid == 0}
                                {assign var = bid_dis value ="display: block"}
                            {/if}
                            {if !$isAgent}
                                {assign var = bid_class value = 'btn-bid'}
                                {if $property_data.info.register_bid != true}
                                    {assign var = bid_class value = "btn-bid-reg"}
                                {/if}
                                {if $property_data.info.check_price}
                                    {assign var = bid_class value = 'btn-bid-green'}
                                    {if $property_data.info.register_bid != true}
                                        {assign var = bid_class value = "btn-bid-green-reg"}
                                    {/if}
                                {/if}
                            {else}
                                {assign var = bid_class value = 'btn-bid-vendor'}
                                {if $property_data.info.check_price}
                                    {assign var = bid_class value = 'btn-bid-vendor-green'}
                                {/if}
                                {assign var = bid_room_class value = 'btn-bid'}
                                {if $property_data.info.check_price}
                                    {assign var = bid_room_class value = 'btn-bid-green'}
                                {/if}
                            {/if}
                            <input id="bid_button_{$property_data.info.property_id}" type="button" class="{$bid_class}" onclick="{$fnc_str}" style="float: right; margin-left: 5px;margin-top: 0px;margin-bottom: 5px;{$bid_dis}"/>

                            {if ($property_data.info.isBlock || ($property_data.info.ofAgent && $isAuction)) && $property_data.info.pro_type == 'auction'  && $property_data.info.completed }
                                {if in_array($authentic.type,array('theblock','agent')) && $property_data.is_mine == true && $property_data.info.confirm_sold == 0 && $property_data.info.stop_bid == 0}
                                    <!--div style="float:left;margin-right:5px !important;width: 79px;">
                                        <button id="btn_count_{*$property_data.info.property_id*}" class="btn-wht btn-countdown" onclick="count_{*$property_data.info.property_id*}.showPopup('agent-block')"-->
                                            <!--<span><span>MANAGE BID</span></span>-->
                                        <!--/button-->
                                        {*$property_data.countdown*}
                                    <!--/div-->
                                {else}
                                    {if !$property_data.info.no_more_bids AND $is_paid AND $property_data.info.register_bid AND $property_data.info.confirm_sold == 0 AND $property_data.info.stop_bid == 0}
                                        {if !$property_data.info.ofAgent}
                                            <div style="float:left;margin-right:5px !important;width: 79px;">
                                                <button id="btn_no_{$property_data.info.property_id}" class="btn-wht btn-no-more-bid" onclick="bid_{$property_data.info.property_id}.pauseBid()"></button>
                                            </div>
                                        {else}
                                            <div style="float:right;margin-right:5px !important;width: 110px;">
                                                <button id="btn_no_{$property_data.info.property_id}" class="btn-wht btn-no-more-bid2" onclick="bid_{$property_data.info.property_id}.pauseBid()"></button>
                                            </div>

                                        {/if}
                                    {/if}
                                    {*if $is_paid AND $property_data.info.register_bid AND $property_data.info.confirm_sold == 0 AND $property_data.info.stop_bid == 0}
                                        <div style="float:left;margin-right:0 !important;width: 79px;top:28px;z-index:9;">
                                            <button id="btn_count_{$property_data.info.property_id}" class="btn-wht btn-countdown" onclick="count_{$property_data.info.property_id}.showPopup('bidder-user')">
                                            </button>
                                            {$property_data.countdown}
                                        </div>
                                    {/if*}
                                {/if}
                            {/if}
                        </div>
                        {if in_array($authentic.type,array('theblock','agent'))  && ($isAgent && $property_data.info.pro_type_code == 'auction')}
                            <input id="bid_room_button" type="button" class="{$bid_room_class}" onclick="bid_{$property_data.info.property_id}.click(true)" style="float: right; margin-left: 0px;margin-top: 0px;{$bid_dis}"/>
                            <div class="clearthis"></div>
                        {/if}
                        <!--<br clear="all"/>-->
                    </div>
                        
                    <script type="text/javascript">
                        {if $property_data.info.pro_type == 'auction' &&  $property_data.info.pay_status == 'complete'}
                                                updatePriceTime();
                                                /*setInterval("update_watermark()",1000);*/
                        {/if}
                                                updateLastBidder();
                    </script>
                    
                </div>

                <div class="auc-actions" style="margin-bottom: 6px;clear: both;
margin-right: 4px; ">
                   
                        {if $agent_id > 0 AND $isShow}
                            {assign var = fnc_str1 value = "showBidHistory('`$property_data.info.property_id`')"}
                            {*{assign var = fnc_str2 value = "pro.openAutoBidForm('#autobid_`$property_data.info.property_id`','`$property_data.info.property_id`')"}*}
                            {assign var = fnc_str2 value = "pro.before_openAutoBidForm('#autobid_`$property_data.info.property_id`','`$property_data.info.property_id`')"}
                            {assign var = fnc_strAT value = "pro.closeAutoBidForm('#autobid_`$property_data.info.property_id`')"}
                            {if !$isSold AND !$isAgent and $property_data.info.stop_bid == 0 and !($property_data.info.isBlock || ($property_data.info.ofAgent && $property_data.info.pro_type_code == 'auction'))}
                                {$property_data.abs_tpl}
                            {/if}
                        {/if}
                        <!-- END CHECK PARTNER -->
                    

                    <script type="text/javascript">
                        {literal}
                                           /*FOR THE FIRST TIME BIDDER SET AUTOBID SETTINGS (it will send one request to server)*/
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
            {/if} {*END LIVE AUCTION*}
                    <script type="text/javascript">
                                    updateLastBidder();
                    </script>
                    <div class="clearthis"></div>
                    <div style="text-align: center; border-bottom-width: 0px; padding-bottom: 6px;padding-top: 10px; color: #CC8C04;clear: both;" class="o4i-info">
                        <span class=""> Open for Inspection: {$property_data.info.o4i}</span>
                    </div>
                    <div class="clearthis"></div>
                    <div class="detail-info" style="{$detail_info}">
                        <ul>
                            {if $property_data.info.kind != 1}
                                <li>
                                    {if $property_data.info.bedroom_value > 0 }
                                        <span class="detail-info-span-a">{$property_data.info.bedroom_value} Bedroom{if $property_data.info.bedroom_value > 1}s{/if}</span>
                                    {/if}
                                    {if $property_data.info.bathroom_value > 0}
                                        <span class="detail-info-span">{$property_data.info.bathroom_value} Bathroom{if $property_data.info.bathroom_value > 1}s{/if}</span>
                                    {/if}
                                </li>
                            {/if}
                            {if $property_data.info.parking == 1}
                                <li>
                                    <span class="detail-info-span-a">

                                        {if $property_data.info.carport_value_ == ''}
                                            {$property_data.info.carport_value} Car Space(s)
                                        {else}
                                            {$property_data.info.carport_value} Car Parking
                                        {/if}

                                    </span>
                                    {if  $property_data.info.land_size == 0}
                                        <span style="display: none;" class="detail-info-span">{$property_data.info.land_size}</span>
                                    {else}
                                        <span class="detail-info-span">{$property_data.info.land_size}</span>
                                    {/if}
                                </li>
                            {elseif $property_data.info.land_size != ''}
                                {if  $property_data.info.land_size == 0}
                                    <li style="display: none;">
                                        <span class="detail-info-span-a">Land size</span>
                                        <span class="detail-info-span">{$property_data.info.land_size}</span>
                                    </li>
                                {else}
                                    <li>
                                        <span class="detail-info-span-a">Land size</span>
                                        <span class="detail-info-span">{$property_data.info.land_size}</span>
                                    </li>
                                {/if}
                            {/if}
                            {*<li>
                            Livability Rating
                            <div class="f-right" id="frgreen1">
                            {$property_data.info.livability_rating_mark}
                            </div>
                            </li>*}
                            <div class="clearthis"></div>
                            {if $property_data.info.pro_type_code != 'ebiddar'}
                                <li>
                                    iBB Sustainability
                                    <div class="f-right" id="frgreen2">
                                        {$property_data.info.green_rating_mark}
                                    </div>
                                </li>
                            {/if}
                        </ul>

                        {if $isAgent AND $is_theblock == false}
                            {*{if $is_bid_history and $property_data.info.pro_type != 'auction'}
                            <div style="text-align: center; font-weight: bold; margin-top: 30px; margin-bottom: 19px; font-size: 11px;">
                            <a href="javascript:void(0)" onclick="showBidHistory('{$property_data.info.property_id}')">Bid History &raquo;</a>
                            </div>
                            {/if}*}
                            {if $property_data.info.confirm_sold == 1}
                                <div style="margin-top: 0px;">
                                    <span style="float: right;margin-top: 5px;"><a class="viewmore" href="javascript:void(0)" onclick="showBidHistory('{$property_data.info.property_id}','agent','winner-info')"> Winner Information &raquo;</a></span>
                                </div>
                            {/if}
                        {/if}


                        <div class="p-detail-vm">
                            <span style="float:left;margin-top:5px;">{$property_data.view_more}</span>
                        </div>
                        <div class="clearthis"></div>
                        {*Begin Offer button for Sale *}
                        {if $property_data.info.pro_type == 'sale'}
                            {if !$isAgent}
                                <div class="sale-detail" style="float:right;margin-right:0px !important;margin-top: -20px;">
                                    {if !$isSold}
                                        {assign var = btn_offer_class value="btn-make-an-ofer"}
                                        <button id="btn-offer-{$property_data.info.property_id}" style="margin-right:0px !important;" class="btn-wht {$btn_offer_class} btn-make-an-ofer-f"
                                                onclick="pro.openMakeAnOffer('#makeanoffer_{$property_data.info.property_id}','{$property_data.info.property_id}')">
                                            {*<span><spany style="">Offer</span></span>*}
                                        </button>
                                    {/if}
                                    <!-- END CHECK PARTNER -->
                                    {$property_data.mao}
                                </div>
                            {/if}
                        {/if}
                        {*END*}
                    </div>

                    <div class="email-box bottom-info">
                        {if !$isShow}
                            <span> <a href="javascript:void(0)" onclick="return myReport('modules/property/print.php?action={$action}&id={$property_data.info.property_id}')" >PRINT BROCHURE </a> </span>
                        {else}
                            <div class="div-email-box"><span><a href="javascript:void(0)" onClick="showSendfriend('{$property_data.info.property_id}','{$agent_info.email}')" >SEND TO A FRIEND</a></span>
                                {if $agent_id > 0}
                                    <span><a href="javascript:void(0)" onClick="pro.addWatchlist('/modules/property/action.php/?action=add-watchlist&property_id={$property_data.info.property_id}')">ADD TO WATCHLIST</a></span>
                                {/if}
                            </div>

                            {assign var = show_contact_fnc value = "showContact('`$agent_info.agent_id`','`$agent_info.name`','`$agent_info.email`','`$agent_info.telephone`','`$property_data.info.agent_id`','')"}
                            {if !$isLogin}
                                {assign var = show_contact_fnc value = "showLoginPopup();"}
                            {/if}
                            <span><a href="javascript:void(0)" onclick="return myReport('modules/property/print.php?action={$action}&id={$property_data.info.property_id}')" >PRINT BROCHURE</a> </span>
                            <span><a href="javascript:void(0)" onClick="{$show_contact_fnc}">CONTACT AGENT</a></span>
                        {/if}
                    </div> 
                </div>
                    
                            {if $property_data.info.pro_type != 'sale' OR ($property_data.info.pro_type == 'sale' AND $isAgent) }
                                {if $property_data.info.isBlock}
                                    <div class="report-register-to-bid" style="">
                                        <div style="" class="btn-report" onclick="showRegisterBid('{$property_data.info.property_id}','registerToBid_blockReport','Bid Report')">
                                            <div class="viewmore text-report" style="">  Bid Report </div>
                                        </div>
                                    </div>
                                    {* {if $property_data.info.logo != '' && $property_data.info.show_agent_logo}
                                    <div class="logo-block">
                                    <img src="{$MEDIAURL}/{$property_data.info.logo}" alt="{$property_data.info.agent_name}"
                                    title="{$property_data.info.agent_name}"/>
                                    </div>
                                    {/if}*}
                                {else}
                                    <div class="report-register-to-bid" style="">
                                        <div style="" class="btn-report" onclick="showRegisterBid('{$property_data.info.property_id}','registerToBid_history','Bid Report')">
                                            <div class="viewmore text-report" style="">  Bid Report </div>
                                        </div>
                                    </div>
                                {/if}
                            {/if}
                            {else}
                                <br>
                                <div class="message-box message-box-add" style=""><center><i>Sorry, but there are no properties available based on your selection. Please modify the filters to search again. Thanks!</i></center></div>
                     
                           {/if}
            </div> 
{if $property_data.info.show_agent_logo == 1}
            <div id="agent-info" class="tabdiv">
                {if isset($property_data.info) and is_array($property_data.info) and count($property_data.info) > 0 }
                    <div class="logo-agent gradient-box">
                        <h2 style="text-align:left">Agent Details</h2>
                        <hr style="margin-bottom:10px;" />
                        {if $property_data.info.logo != ''}
                            <img src="{$MEDIAURL}/{$property_data.info.logo}" alt="{$property_data.info.agent_name}"
                                 title="{$property_data.info.agent_name}"/>
                        {/if}
                        <div class="info-agent" style="text-align:left">
                            <div class="main-info">
                                <p><strong>{$property_data.me.full_name}</strong></p>

                                <p class="company">{$property_data.agent.company_name}</p>
                                <p><a href="http://{$property_data.agent.website}" target="_blank">{$property_data.agent.website}</a></p>
                            </div>

                            <p class="vector tel">{$property_data.me.telephone}</p>
                            
                            <p class="vector address">{$property_data.me.full_address}</p>
                            <p><a class="vector email"
                               href="mailto:{$property_data.me.email_address}">{$property_data.me.email_address}</a></p>
                               <p><a style="background-position:0 -80px; word-wrap: break-word;padding-left: 0px;" class="vector empty" href="http://{$property_data.me.website}" target="_blank">{$property_data.me.website}</a></p>

                            <div class="format-desc">
                                {if $property_data.info.isBlock}
                                    <div id="short_des">
                                        {$property_data.me.short_description}
                                    </div>
                                    <div id="full_des" style="display:none">
                                        {$property_data.me.description}
                                    </div>
                                    {literal}
                                        <script type="text/javascript">
                                            $(document).ready(function(){
                                                $('.seemore-des').bind('click',function(){
                                                    $('#short_des').toggle();
                                                    $('#full_des').toggle();
                                                });
                                            })
                                        </script>
                                    {/literal}
                                {else}
                                    {$property_data.me.description}
                                {/if}
                            </div>
                        </div>
                    </div>
                     {else}
                         <div class="message-box message-box-add" style=""><center><i>Sorry, but there are no properties available based on your selection. Please modify the filters to search again. Thanks!</i></center></div>
                     
                {/if}
            </div>   
                            {/if}
        </div><!--/widget-->

        <script>
                         {literal}
         jQuery(document).ready(function(){  
               jQuery('.container-l').css('min-height', jQuery(window).height()-80);  
       });    
           
          
            {/literal} 
    </script>
        <div style="display:none" id="no_more_bid_msg">{$no_more_bids_msg}</div>
        {if ($is_showalert && $is_showalert == 1)} 
        
            <script type="text/javascript">
                        
                            var url1 = '{$ROOTURL}/modules/property/action.php?action=down-term&pid={$property_data.info.property_id}';
                               
                            {*if $isSafari == 0*}
                            {literal}
                                $(document).ready(function(){  
                                    var timer1 = setInterval(function(){window.location = url1;clearTimeout(timer1);},3000);
                                 });
                                 {/literal} 
                             {*else}
                                jQuery('body').append('<iframe id="if-term" src="'+url1+'" style="display:none; visibility:hidden;"></iframe>');         
                           {/if*}
            </script>
        {/if}
