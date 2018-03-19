<table class="tbl-messages" cellpadding="0" cellspacing="0" style="width: 100%" lang="report-bid">
    <colgroup>
        <col width="35%"/>
        <col width="30%"/>
        <col width="35%"/>
    </colgroup>
    <thead>
    <tr>
        {*<td>
            No
        </td>*}
        <td>
            Bidder
        </td>
        <td>
            Price
        </td>
        <td class="tcenter">
            Bid time
        </td>
    </tr>
    </thead>
    <tbody>
    {if is_array($actualBid_rows) and count($actualBid_rows) > 0}
        {foreach from = $actualBid_rows key = i item = row}
        <tr>
            <td>
                <a id="bid_tooltip_{$row.ID}_{$row.agent_id}" href="javascript:void(0)">{$row.name}</a>
                {if $is_mine}
                    <div style="display:none">{$row.info}</div>
                    {literal}
                    <script type="text/javascript">
                        $('#bid_tooltip_{/literal}{$row.ID}_{$row.agent_id}{literal}').tipsy({
                            gravity: 'w',
                            html: true,
                            title:function(){
                                return $(this).parent().find('div').html();
                            }
                        });
                    </script>
                    {/literal}
                {/if}
            </td>
            <td>
                <span>{$row.price}</span>
            </td>
            <td class="tcenter">{$row.time}</td>            
        </tr>
        {/foreach}
    {else}
        <tr>
            <td>
                There is no data
            </td>
        </tr>
    {/if}

    </tbody>
</table>
<input type="hidden" name="max-bid" value="{$bid_max}"/>
<div class="paging_bid" style="text-align: center;margin-top: 10;font-weight: bold;">
{$pagingBid}
</div>