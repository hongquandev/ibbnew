<div class="ma-info mb-20px">
    <div class="col2-set mb-20px">
        <div class="col">
            <div class="col-main myaccount">
                <span class="" style="float:right;padding-bottom:10px;">{$review_pagging}</span>
                <div class="clearthis"></div>
                <div class="ma-messages mb-20px my-report">
                    <table class="tbl-messages" cellpadding="0" cellspacing="0" style="width:100%">
                            <colgroup>
                                <col width="5%"/><col width="45%"/><col width="25%"/><col width="25%"/>
                            </colgroup>
                            <thead>
                                <tr>
                                    <td>ID</td>
                                    <td align="center">Description</td>
                                    <td align="center">Time</td>
                                    <td align="center">Amount</td>
                                </tr>
                            </thead>
                            {if isset($invoice) and is_array($invoice) and count($invoice)>0}
                                <tbody>
                                    {foreach from = $invoice key = k item = row}
                                        <tr {if $k%2 == 1} class="read" {/if}>
                                            <td style="padding-left:4px;">#{$k+1}</td>
                                            <td>{$row.description}</td>
                                            <td align="center">{$row.time}</td>
                                            <td align="center">{$row.value}</td>
                                        </tr>
                                    {/foreach}
                                </tbody>
                            {/if}
                    </table>
                </div>
            </div>
        </div>
        <div class="clearthis"></div>
        {$pag_str}
    </div>
</div>
