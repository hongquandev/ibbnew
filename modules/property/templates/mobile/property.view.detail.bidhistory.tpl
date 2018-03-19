<table class="tbl-bid tbl-bid-property-view" cellpadding="0" cellspacing="0" id="tbl-bid-property-view">
    <colgroup>
        <col width="100px"/>
        <col width="200px"/>
        <col width="200px"/>
        <col width="300px"/>
    </colgroup>
    <thead>
    <tr>
        <td>
            No.
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
            <tr {if $isAgent} {*onclick="showRegisterBidAgent('{$row.agent_id}','#tr_register_{$i+1}')"*} {/if}>
                <td style="text-align:left;">{math equation = "(p-1) * len + (i+1)"
                    p = $p
                    len = $len
                    i = $i
                    }</td>
                <td>{$row.name}</td>
                <td>{$row.price}</td>
                <td style="text-transform: uppercase;">{$row.time}</td>
            </tr>
        {/foreach}
        {if $pagingBid != ""}
            <tr>
                <td colspan="4" style="text-align: center;">{$pagingBid}</td>
            </tr>
        {/if}
    {else}
        <tr><td class="empty" colspan="4">There is no data</td></tr>
    {/if}
    </tbody>
</table>