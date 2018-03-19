<div class="main"  >
    <div class="col-main">
        <div class="bg-f7f7f7" style="height: 400px; padding-left: 10px; padding-top: 10px;">
            <div class="payment-option-css" style="">
                <h2>Review Your Payment</h2>
                <div style="margin-top: 20px">
                    <table class="table-payment"  >
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

    <div class="clearthis"></div>
</div>
{*{if $is_showalert == 1}
<script type="text/javascript">
var url = '{$ROOTURL}/modules/property/action.php?action=down-term&pid={$item_number}';
 {literal}
$(document).ready(function(){
      var timer = setInterval(function(){window.location = url;clearTimeout(timer);},5000);
});
  {/literal}
</script>
{/if}*}


