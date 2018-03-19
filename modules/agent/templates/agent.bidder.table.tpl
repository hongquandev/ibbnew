<div class="edit-table" {*style="max-height:520px"*}>
    <table width="100%" class="grid-table" cellspacing="1" id="grid-table">
        <tr class="title">
            <td width="60px" align="center" style="font-weight:bold;color:#fff;">#</td>
            <td align="center" style="font-weight:bold;color:#fff;">Description</td>
            <td align="center" style="font-weight:bold;color:#fff;width:100px;">Remove</td>
        </tr>
        {if isset($data) and is_array($data) and count($data) > 0}
        {assign var = i value = 0}
        {foreach from = $data key = k item = row}
        {assign var = i value = $i+1}
        <tr class="item{if $i%2==0}1{else}2{/if}">
            <td align="center">{$row.property_id}</td>
            <td>
                <div style="margin: 4px">
                    <b>Vendor: {$row.agent_name}</b>
                    <br />
                    <b>Description: </b>
                    <br />
                    {$row.description}
                </div>
            </td>
            <td width="70px" align="center">
                {if $row.pay_bid_first_status == 2 || true}
                    <a href="javascript:void(0)" onclick ="deleteItem2('{$row.delete_link}')" style="color:#0000FF">Remove</a>
                {/if}
            </td>
        </tr>
        {/foreach}
        {/if}
    </table>
    {$pag_str}
</div>