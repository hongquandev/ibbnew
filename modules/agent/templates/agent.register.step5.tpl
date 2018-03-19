<div class="step-5-info">
    <div class="step-name">
        <h2>{localize translate="Review Your Payment"}</h2>

    </div>
    <div class="step-detail">
        <div class="">
            <div class="payment-option-css">
                <div style="margin-top: 20px">
                    <table class="table-payment" width="433px">
                        <colgroup>
                            <col width="80%"/>
                            <col/>
                        </colgroup>
                        <thead>
                        <tr class="payment-header">
                            <td class="name">{$item_name}</td>
                            <td class="total" style="text-align:right">{localize translate="Price"}</td>
                        </tr>
                        </thead>
                        <tbody></tbody>
                            <tr>
                                <td class="name" style="text-align:left;">{localize translate="Package"}: {$package.title}</td>
                                <td style="text-align:right">${$package.price} AUD</td>
                            </tr>
                        <tr class="payment-footer">
                            <td colspan=2 style="text-align:right;"><b>{localize translate="Total"} : ${$package.price} AUD</b></td>
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
                            <button class="btn-blue" onclick="$('#frmAgent').submit()">
                                <span><span>{localize translate="Finish"}</span></span>
                            </button>
                        </div>
                    </form>
                {/if}

            </div>
        </div>
        <div class="clearthis"></div>
    </div>
</div>