<table class="tbl-messages" cellpadding="0" cellspacing="0" style="width:100%" lang="report-no-more-bid">
    <colgroup>
        {*<col width="5%"/>*}
        <col width="40%"/>
        <col width="30%"/>
        <col width="25%"/>
    </colgroup>
    <thead>
    <tr>
       {* <td>
            No.
        </td>*}
        <td>
            Bidder
        </td>
        <td>
            Email
        </td>
        <td>
            Register time
        </td>
    </tr>
    </thead>
    <tbody>

    {if isset($no_more_bids_data)}
        {foreach from = $no_more_bids_data key = i item = row}
        <tr>
            {assign var=i value=$key+1}
            {*<td style="text-align:center;">{$i}</td>*}
            <td>
                <a id="tooltip_{$row.agent_id}" href="javascript:void(0)">{$row.firstname} {$row.lastname}</a>
                <div style="display:none">{$row.info}</div>
            </td>
            <td>{$row.email_address}</td>
            <td style="text-align:center;">{$row.time}</td>

            {literal}
            <script type="text/javascript">
                $('#tooltip_{/literal}{$row.agent_id}{literal}').tipsy({
                    gravity: 'w',
                    html: true,
                    title:function(){
                        return $(this).parent().find('div').html();
                    }
                });
            </script>
            {/literal}
        </tr>
        {/foreach}
    {/if}

    </tbody>
</table>
{if $no_more_bids_msg == 1}
<div class="hight-light">No More Online Bids</div>
{/if}
<input type="hidden" name="new_no_more_bids" value="{$new_no_more_bids}"/>
{if isset($no_more_bids_data)}
    <div class="paging_bid" style="text-align: center;margin-top: 10;font-weight: bold;">
        {$paging}
    </div>
{/if}
