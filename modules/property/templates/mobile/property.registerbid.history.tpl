{literal}
<style type="text/css">
    /******* MENU REGISTER BID POPUP *******/
    .clear-register-bid{
        clear: both;
        height: 0;
        visibility: hidden;
        display: block;
    }
    #container-register-bid{
        /*margin: 7em auto;
        width: 400px;*/
    }
    #container-register-bid ul{
        list-style: none;
        list-style-position: outside;
    }
    #container-register-bid ul.menu-register li{
        float: left;
        margin-right: 5px;
        margin-bottom: -1px;
    }
    #container-register-bid ul.menu-register li{
        font-weight: 700;
        display: block;
        padding: 5px 10px 5px 10px;
        background: #efefef;
        border: 1px solid #d0ccc9;
        border-width: 1px 1px 0 1px;
        position: relative;
        color: #898989;
        cursor: pointer;
        margin-bottom:-2px;

    }
    #container-register-bid ul.menu-register li.active{
        background: #fff;
        top: 1px;
        /*border-bottom: 0;*/
        border-bottom: 1px solid white;
        color: #5f95ef;
    }
    /******* /MENU *******/
    /******* CONTENT *******/
    .menu-register-bid .content{
        margin: 0pt auto;
        background: white;
        /*background: #fff;
        border: 1px solid #d0ccc9;*/
        text-align: left;
        padding: 10px;
        padding-bottom: 20px;
        font-size: 11px;
    }
    .menu-register-bid .content.bid-report{
        display: block;
    }
        .menu-register-bid .content.actual-bid-report{
        display: none;
    }

    .menu-register-bid .content.reg-to-bid-report{
        display: none;
    }
    .menu-register-bid  .content.links a{
        color: #5f95ef;
    }
    .tabs-container{
        border: 1px solid #D0CCC9; 
        clear: both; 
        min-height: 20px;}
    /*END*/
</style>
{/literal} 
<div id="register-Agent" class="myaccount ma-messages mb-20px bid-history-dt" style="overflow-y: auto;max-height: 270px;">
    {* BEGIN tabs*}
    <div id="container-register-bid" class="menu-register-bid">
		<ul class="menu-register">
			<li id="BidReport" rel="bid-report" class="active">Bids Report</li>
            {if $isAgent}
                {*<li id="ActualBidReport" rel="actual-bid-report">Actual Bids Report</li>*}
                <li id="RegToBidReport" rel="reg-to-bid-report">Register To Bid Report</li>
                {*{if $authentic.type == 'theblock' || ($authentic.type == 'agent' && $isAuction)}
                    <li id="NoMoreBids" rel="no-more-bids">No More Bids Report</li>
                {/if}*}
                {*{if $isSwitchBid}
                    <li onclick="showSwitchBid()"> Switched Bid Report</li>
                {/if}*}
            {/if}
		</ul>
		<span class="clear-register-bid"></span>

        <div class="tabs-container">
            <div class="content bid-report" style="margin-top: 0px;">
                <table class="tbl-messages" cellpadding="0" cellspacing="0" style="width:100%;">
                    <!--colgroup>
                        <col width="20px"/>
                        <col width="100px"/>
                        <col width="70px"/>
                        <col width="70px"/>
                    </colgroup-->
                    <thead>
                    <tr>
                        <td >
                            No
                        </td>
                        <td>
                            Bidder
                        </td>
                        <td>
                            Price
                        </td>
                        <td>
                            Bid time
                        </td>
                    </tr>
                    </thead>
                    <tbody>
                    {if is_array($actualBid_rows) and count($actualBid_rows) > 0}
                        {foreach from = $actualBid_rows key = i item = row}
                        <tr {if $isAgent} onclick="showRegisterBidAgent('{$row.agent_id}','#tr_register_{$i+1}')" {/if}>
                            <td style="text-align:center;">{math equation = "(p-1) * len + (i+1)"
                                p = $p
                                len = $len
                                i = $i
                            }</td>
                            <td>{$row.name}</td>
                            <td>{$row.price}</td>
                            <td>{$row.time}</td>
                        </tr>
                        {/foreach}
                    {/if}

                    </tbody>
                </table>
                <div class="paging_bid" style="text-align: center;margin-top: 10;font-weight: bold;">
                    {$pagingBid}
                </div>
            </div>
            <div class="content actual-bid-report" style="margin-top: 0px;">
            {*<table class="tbl-messages" cellpadding="0" cellspacing="0">
                <colgroup>
                    <col width="20px"/><col width="300px"/><col width="150px"/><col width="130px"/>
                </colgroup>
                <thead>
                    <tr>
                        <td>
                            No
                        </td>
                        <td>
                            Bidder
                        </td>
                        <td>
                            Price
                        </td>
                        <td>
                            Bid time
                        </td>
                    </tr>
                </thead>
                <tbody>
                {if is_array($actualBid_rows) and count($actualBid_rows) > 0}
                    {foreach from = $actualBid_rows key = i item = row}
                        <tr onclick="showRegisterBidAgent('{$row.agent_id}','#tr_register_{$i+1}')">
                            <td style="text-align:center;">{math equation = "(p-1) * len + i"
                                p = $p
                                len = $len
                                i = $i
                            }</td>
                            <td>{$row.name}</td>
                            <td>{$row.price}</td>
                            <td>{$row.time}</td>
                        </tr>
                    {/foreach}
                {/if}

                </tbody>
            </table>*}
            </div>
            <div class="content reg-to-bid-report" style="margin-top: 0px;">
                <table class="tbl-messages" cellpadding="0" cellspacing="0">
                    <colgroup>

                    {if $action == 'registerToBid_blockReport'}
                        <col width="20px"/>
                        <col width="140px"/>
                        <col width="150px"/>
                        <col width="150px"/>
                        <col width="130px"/>
                        {else}
                        <col width="20px">
                        <col width="150px">
                        <col width="150px">
                        <col width="130px">
                    {/if}
                        <col width="80px"/>
                    </colgroup>
                    <thead>
                    <tr>

                        <td>
                            No
                        </td>
                        <td>
                            Bidder
                        </td>
                        <td>
                            Email
                        </td>
                    {if $action == 'registerToBid_blockReport'}
                        <td>
                            Bid Number
                        </td>
                    {/if}
                        <td>
                            Register time
                        </td>
                        <td style="text-align: center">Allow</td>
                        <td style="text-align: center">Enable</td>
                    </tr>
                    </thead>
                    <tbody>
                    {assign var = "count_regtobid" value = "false"}
                    {if is_array($rows) and count($rows) > 0}
                        {assign var = "count_regtobid" value = "true" }
                        {foreach from = $rows key = i item = row}
                        <tr id="tr_register_{$i+1}"
                            onclick="showRegisterBidAgent('{$row.agent_id}','#tr_register_{$i+1}')">
                            <td style="text-align:center;">{math equation = "(p-1) * len + (i+1)"
                                    p = $p_reg2bid
                                    len = $len
                                    i = $i
                                }</td>
                            <td><a class="name" href="javascript:void(0)">{if $row.is_disable == 1}
                                <s>{$row.name}</s>{else}{$row.name}{/if}</a></td>
                            <td style="word-break:break-all">{$row.email}</td>
                            {if $action == 'registerToBid_blockReport'}
                                <td style="text-align:center;">{$row.bidNumber}</td>
                            {/if}
                            <td style="text-align:center;">{$row.time}</td>
                            <td style="text-align:center;">{$row.allow_str}</td>
                            <td style="text-align:center;">{$row.disable}</td>
                            {literal}
                            <script type="text/javascript">
                                    $('#disable_{/literal}{$row.ID}{literal}').bind('click',function(){
                                        bid_{/literal}{$property_id}{literal}.disable({/literal}{$row.agent_id}{literal},this);
                                    });
                                    $('#allow_{/literal}{$row.ID}{literal}').bind('click',function(){
                                            bid_{/literal}{$property_id}{literal}.allow({/literal}{$row.agent_id}{literal},this);
                                    });
                            </script>
                        {/literal}
                        </tr>
                        {/foreach}
                    {/if}

                    </tbody>
                </table>

            </div>
           {* <div class="content no-more-bids">
                {include file="`$ROOTPATH`/modules/property/templates/mobile/tabs.no_more_bids.tpl"}
            </div>*}
        </div>

	</div>

    {*content*}

</div>
<div id="register-agent-loading" style="position:absolute;display:none;margin-top:5px;text-align: center;" align="center">
    <img src="/modules/general/templates/images/loading.gif" style="height:30px;" alt="" />
 </div>
<div class="register-agent-content" id="register-bid-agent">

</div>
{if $isAgent }
    {if $count_regtobid == 'true'}
        {*<div class="content-bid reg-to-bid-report" id="regtobid-csv">
            <a target="_blank" href="{$ROOTURL}/?module=property&action=exportCSV&page=RegisterToBid&file_name=RegisterToBid_{$property_id}&property_id={$property_id}">
                <button style="margin-right: 0px ! important; width: 120px; float: right;" class="btn-red btn-red-search" *}{*onclick="exportCSV('{$property_id}')"*}{*>
                    <span><span>Export CSV</span></span>
                </button>
            </a>
        </div>*}
        <div class="content-bid reg-to-bid-report" id="regtobid-csv">
            <a href="javascript:void(0)">
                <button style="margin-right: 0px ! important; width: 120px; float: right;" class="btn-red btn-red-search" onclick="exportCSV('{$property_id}')">
                    <span><span>Export CSV</span></span>
                </button>
            </a>
        </div>
    {/if}
    <div class="clearthis"></div>
    <div id="note-actual-bid" class="content-bid actual-bid-report" style="margin-bottom: 20px; padding-left: 20px; font-weight: bold; text-align: center;">
       Note * :<i> This report to show how many people actual bid on this property.</i>
    </div>

    <div id="note-register-bid" class="content-bid reg-to-bid-report" style="margin-bottom: 20px; padding-left: 20px; font-weight: bold; text-align: center;display: none;">
       Note * :<i> This report to show how many people have registered to {if isset($auctionSaleCode) && $auctionSaleCode != 'private_sale'}bid{else}offer{/if} on this property.</i>
    </div>

{/if}
<script type="text/javascript">
    var link_switch = "{$link_switch_bid}";
</script>
{literal}
<script type="text/javascript">
    function showSwitchBid()
    {
        document.location = link_switch;
    }
    function  showRegisterBidAgent(agent_id,tr_id)
    {
        jQuery('#register-agent-loading').show();
        jQuery('tr','#register-Agent').each(function(){
            jQuery(this).css('background-color','#fff');
        });
        jQuery(tr_id).css('background-color','rgb(247, 247, 247)');
        jQuery('#register-bid-agent').html('');
        par = new Object();
        par.agent_id = agent_id;
        par.action = 'registerBidAgent';
        jQuery.post('/modules/general/action.php',par,
        function success(data)
        {
            jdata = jQuery.parseJSON(data);
            if(jdata.success)
            {
                jQuery('#register-agent-loading').hide();
                jQuery('#register-bid-agent').show();
                jQuery('#register-bid-agent').html(jdata.info);
            }
        },'html'
        )
    }
$(document).ready(function(){
	/*$(".menu-register > li").click(function(e){
		switch(e.target.id){
			case "BidReport":
				$("#BidReport").addClass("active");
				$("#ActualReport").removeClass("active");
				$("#RegToBidReport").removeClass("active");
				$("div.bid-report").fadeIn();
                jQuery('#note-register-bid').hide();
                jQuery('#note-actual-bid').show();
				$("div.actual-bid-report").css("display", "none");
				$("div.reg-to-bid-report").css("display", "none");
                jQuery('#register-bid-agent').hide();
                jQuery('#regtobid-csv').hide();
			break;
			case "AuctualReport":
				$("#BidReport").removeClass("active");
				$("#ActualReport").addClass("active");
				$("#RegToBidReport").removeClass("active");
				$("div.actual-bid-report").fadeIn();
				$("div.bid-report").css("display", "none");
				$("div.reg-to-bid-report").css("display", "none");
                jQuery('#register-bid-agent').hide();
                jQuery('#regtobid-csv').hide();
			break;
			case "RegToBidReport":
				$("#BidReport").removeClass("active");
				$("#ActualReport").removeClass("active");
				$("#RegToBidReport").addClass("active");
				$("div.reg-to-bid-report").fadeIn();
                jQuery('#regtobid-csv').show();
                jQuery('#note-register-bid').show();
                jQuery('#note-actual-bid').hide();   
				$("div.bid-report").css("display", "none");
				$("div.actual-bid-report").css("display", "none");
                jQuery('#register-bid-agent').hide();
			break;
		}
		return false;
	});*/

  
    jQuery('.menu-register li').click(function(){
          switch_tabs($(this));
    });
    function switch_tabs(obj) {
             var id = obj.attr("rel");
             jQuery('#register-Agent .content').hide();
             jQuery('.content-bid').hide();
             jQuery('.menu-register li').removeClass("active");
             jQuery('.' + id).show();
             obj.addClass("active");
    }
    switch_tabs(jQuery('.active'));
});
    function exportCSV(id){
        //jQuery.post(ROOTURL + "/modules/general/action.php?action=exportCSV&page=RegisterToBid",{file_name:'RegisterToBid',property_id:id},function (data){},'html');
        document.location = ROOTURL + "/?module=property&action=exportCSV&page=RegisterToBid&file_name=RegisterToBid_"+ id +"&property_id=" + id ;
    }
</script>
{/literal}
