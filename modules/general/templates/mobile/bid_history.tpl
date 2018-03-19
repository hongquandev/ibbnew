<div class="myaccount ma-messages mb-20px bid-history-dt" style="overflow-y: scroll;max-height: 300px;">
    <table class="tbl-messages" cellpadding="0" cellspacing="0">
        <colgroup>
            <col width="20px"/><col width="100px"/><col width="70px"/><col width="70px"/>
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
        {if is_array($rows) and count($rows) > 0}
        	{foreach from = $rows key = i item = row}
            <tr>
                <td style="text-align:center;">{$i+1}</td>
                <td>{$row.name}</td>
                <td>{$row.price}</td>
                <td>{$row.time}</td>
            </tr>
            {/foreach}
        {/if}	

        </tbody>
    </table>
</div>
{if $show_all}
    <div id="bid-his-showall" style="text-align: right; margin-bottom: 20px;{if !$show_all}display: none;{/if}">
       <button class="btn-red btn-red-bid-history-all" style="width: 185px !important;" onclick="document.location='{$link_showall}'">
          <span><span>Show all</span></span><br>
       </button>

    </div>
{/if}
{if $show_his_all}
    <div id="bid-his-showall" style="text-align: right; margin-bottom: 20px;">
       <button class="btn-red btn-red-bid-history-all" style="width: 185px !important;;" onclick="document.location='{$link_showall}'">
          <span><span>Show bid switched history </span></span><br>
       </button>
    </div>
{/if}
{if $action == 'registerToBid_blockReport'}
    <div id="" style="margin-bottom: 20px; padding-left: 20px; font-weight: bold; text-align: center;">
       Note * :<i> This report to show how many people have registered to bid on this property.</i>
    </div>
{/if}
