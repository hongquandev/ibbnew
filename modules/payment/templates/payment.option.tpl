<div class="main" style="width: 915px;">
    <div class="col-main" style="float: left; width: 620px;">
        <div class="bg-f7f7f7" style="margin: 10px 10px 50px; padding-left: 15px; padding-top: 15px;padding-bottom: 40px">
            <div class="payment-option-css" style="">
                <h2>Review Your Payment</h2>
                <div style="margin-top: 20px">
                    <table class="table-payment" width="570px">
                        <colgroup>
                            <col width="80%"/>
                            <col />
                        </colgroup>
                        <thead>
                            <tr class = "payment-header">
                                <td class="name">[{$item_number}] {$item_desc}</td>
                                <td class="total" style="text-align:right">Price</td>
                            </tr>
                        </thead>
                        <tbody></tbody>
                            {if count($order_review) > 0}
                                {foreach from = $order_review key = key item = row}
                            <tr>
                                <td class="name" style="text-align:left;">{$row.title}</td>
                                <td style="text-align:right">${$row.price} AUD</td>
                            </tr>
                                {/foreach}
                            {/if}
                            <tr class="payment-footer">
                                <td colspan=2 style="text-align:right;"><b>Total : ${$payment_money} AUD</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="payment-option-css" style="">
                {include file = "payment.methods.tpl"}
            </div>
        </div>
    </div>

    <div class="col-right">
          {include file = "`$ROOTPATH`/modules/general/templates/side.right.tpl"}
    </div>

    <div class="clearthis"></div>
</div>
{*
{if $is_showalert == 1}
<script type="text/javascript">
var url = '/modules/property/action.php?action=down-term&pid={$item_number}';
jQuery('body').append('<iframe id="if-term" src="'+url+'" style="display:none; visibility:hidden;"></iframe>');
</script>
{/if}
*}


