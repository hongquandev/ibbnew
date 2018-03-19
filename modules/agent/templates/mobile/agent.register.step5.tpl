<div class="step-5-info">
    <div class="step-name">
        <h2>Review Your Payment</h2>

    </div>
    <div class="step-detail">
        <div class="col-2 bg-f7f7f7 f-left">
            <div class="payment-option-css" style="margin: 20px">
                <div style="margin-top: 20px">
                    <table class="table-payment" width="570px">
                        <colgroup>
                            <col width="80%"/>
                            <col/>
                        </colgroup>
                        <thead>
                        <tr class="payment-header">
                            <td class="name">{$item_name}</td>
                            <td class="total" style="text-align:right">Price</td>
                        </tr>
                        </thead>
                        <tbody></tbody>
                            <tr>
                                <td class="name" style="text-align:left;">Package: {$package.title}</td>
                                <td style="text-align:right">${$package.price} AUD</td>
                            </tr>
                        <tr class="payment-footer">
                            <td colspan=2 style="text-align:right;"><b>Total : ${$package.price} AUD</b></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                {if $package.price != 0}
                    <div class="payment-option-css" style="">
                        {include file = "`$ROOTPATH`/modules/payment/templates/payment.methods.tpl"}
                    </div>
                {else}
                    <form id="frmAgent" method="post" action="{$form_action}">
                        <div class="buttons-set" style="padding-right:0">
                            <button class="btn-red pay-btn-red" onclick="$('#frmAgent').submit()">
                                <span><span>Finish</span></span>
                            </button>
                        </div>
                    </form>
                {/if}

            </div>
        </div>
        <div class="clearthis">
        </div>
    </div>
</div>