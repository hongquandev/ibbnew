<table class="tbl-messages" cellpadding="0" cellspacing="0" style="width:100%" lang="report-logged">
    <colgroup>
        <col width="40%"/>
        <col width="30%"/>
        <col width="25%"/>
    </colgroup>
    <thead>
    <tr>
        <td>
            Bidder
        </td>
        <td>
            Email
        </td>
        <td>
            Last active
        </td>
    </tr>
    </thead>
    <tbody>

    {if isset($logged_data)}
        {foreach from = $logged_data key = i item = row}
        <tr>
            <td>
                <a id="tooltip_{$row.agent_id}" href="javascript:void(0)">{$row.name}</a>
                <div style="display:none">{$row.info}</div>
            </td>
            <td>{$row.email_address}</td>
            <td style="text-align:center;">{$row.last_active}</td>

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
<input type="hidden" name="new_logged" value="{$new_logged}"/>
{if isset($logged_data)}
    <div class="paging_bid" style="text-align: center;margin-top: 10;font-weight: bold;">
        {$pagingLoggedInBid}
    </div>
{/if}
