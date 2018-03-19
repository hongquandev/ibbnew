<table class="tbl-messages" cellpadding="0" cellspacing="0" width="100%" lang="report-register-bid">
    <colgroup>
        <col width="20%">
        <col width="24%">
        <col width="10%">
        <col width="26%">
        <col width="10%">
        <col width="10%">
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
            Number
        </td>
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
        <tr>
            {*<td style="text-align:center;">{$row.ID}</td>*}
            <td>
                <a class="name" id="reg_tooltip_{$row.ID}_{$row.agent_id}" href="javascript:void(0)">
                    {if $row.is_disable == 1 || $row.allow == 0}<s>{$row.name}</s>
                    {else}
                        {$row.name}
                    {/if}</a>
                {if $is_mine}
                    <div style="display:none">{$row.info}</div>
                {/if}
            </td>
            <td>{$row.email}</td>
            <td style="text-align:center;">{$row.bidNumber}</td>
            <td style="text-align:center;">{$row.time}</td>
            <td style="text-align:center;">{$row.allow_str}</td>
            <td style="text-align:center;">{$row.disable}</td>
            <script type="text/javascript">
                {if $is_mine}
                {literal}
                    $('#reg_tooltip_{/literal}{$row.ID}_{$row.agent_id}{literal}').tipsy({
                        gravity: 'w',
                        html: true,
                        title:function(){
                            return $(this).parent().find('div').html();
                        }
                    });
                {/literal}
                {/if}

                {literal}
                $('#disable_{/literal}{$row.ID}{literal}').bind('click',function(){
                        bid_{/literal}{$property_id}{literal}.disable({/literal}{$row.agent_id}{literal},this);
                });
                $('#allow_{/literal}{$row.ID}{literal}').bind('click',function(){
                        bid_{/literal}{$property_id}{literal}.allow({/literal}{$row.agent_id}{literal},this);
                });
                {/literal}
            </script>
        </tr>
        {/foreach}
    {/if}
    </tbody>
</table>
<input type="hidden" name="new_reg" value="{$new_reg}"/>
<div class="paging_bid" style="text-align: center;margin-top: 10;font-weight: bold;">
{$pagingRegtoBid}
</div>