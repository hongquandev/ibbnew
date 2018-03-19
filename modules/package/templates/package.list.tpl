<script src="/modules/package/templates/js/package.js" type="text/javascript"></script>
<form id="frmPackage" name="frmPackage" action="{$next_action}" method="post">
{if isset($message) and strlen($message)>0}
    <div class="message-box message-box-v-ie">
        {$message}
    </div>
{/if}
<table class="price-list-table">
    <thead>
        <tr>
            <th align="left">{localize translate="Package"}</th>
            <th align="center" style="width:100px">{localize translate="Price"} $</th>
            {foreach from = $package key = package_id item = package_data}
                <th align="center">{localize translate=$package_data.name}</th>
            {/foreach}
        </tr>
    </thead>
    <tbody>

        {assign var = total_col value = $totalPackage+2}
        {foreach from = $data key = group_id item = row}
        <tr class="blank">
            <td colspan="{$total_col}"></td>
        </tr>
        <tr class="group-head">
            <td align="left"><div>{localize translate=$row.data.name}</div></td>
            <td align="center"><div></div></td>
            {if $row.is_extra_group}
                <td colspan="{$totalPackage}" align="center" class="extra-package">
                    <div>
                        {localize translate="Selections"}
                    </div>

                </td>
            {else}
                {foreach from = $package key = package_id item = package_data}
                    <td align="center" class="package" >
                        <div style="{$package_data.gradient}">
                            {localize translate=$package_data.name}
                        </div>
                        </td>
                {/foreach}
            {/if}

        </tr>
            {assign var = 'i' value = 0}
            {foreach from = $row.options key = option_id item = option}
                {if $row.is_extra_group}
                    <tr class="group-content {if $i++%2 == 0}odd{else}even{/if}">
                        <td>{localize translate=$option.name}
                            <a class="tooltip-package" href="javascript:void(0)" title=" <div style='text-align: justify;padding:0px 10px;0px;10px'>{$option.description}</div>">
                                <img style="margin-left: 0px;width: 14px" src="/modules/general/templates/images/img_question.png"  />
                            </a></td>
                        <td align="center">
                            {if (isset($option.price_formatted))}
                                {$option.price_formatted}
                            {/if}
                        </td>
                        <td colspan="{$totalPackage}" align="center" class="package">
                            <div>
                                <div class="input-checkbox">
                                    {assign var = checked value = ""}
                                    {assign var = disabled value = ""}
                                    {if isset($payment_packages.extra_options.$group_id.$option_id) }
                                        {assign var = checked value = "checked='checked'"}
                                        {if $property_id > 0 AND $payment_packages.extra_options.$group_id.$option_id  == $pay_complete}
                                            {assign var = disabled value = "disabled='disabled'"}
                                        {/if}
                                    {/if}
                                    <input type="checkbox" {$checked} {$disabled} value="{$option.price}" name="extra_options[{$group_id}][{$option_id}]" ref="{$option.code}" id="{$option.code}_price"/><label for="{$option.code}_price"></label>
                                </div>
                            </div>
                        </td>
                    </tr>
                {else}
                    <tr class="group-content {if $i++%2 == 0}odd{else}even{/if}">
                        <td>{localize translate=$option.name}
                            <a class="tooltip-package" href="javascript:void(0)" title=" <div style='text-align: justify;padding:0px 10px;0px;10px'>{$option.description}</div>">
                                <img style="margin-left: 20px;width: 14px" src="/modules/general/templates/images/img_question.png"  />
                            </a>
                        </td>
                        <td align="center"></td>
                        {foreach from = $package key = package_id item = package_data}
                            <td align="center" class="package">
                                {if (isset($option.packages.$package_id))}
                                    {localize translate=$option.packages.$package_id}
                                {/if}
                            </td>
                        {/foreach}
                    </tr>
                {/if}

            {/foreach}

            {if $row.is_extra_group}
                <tr class="group-content option-price">
                    <td colspan="2">{localize translate="Total Optional Service Price"}</td>
                    <td colspan="{$totalPackage}" align="center"><div id="total_extra">$0.00</div></td>
                </tr>
            {else}
                {foreach from = $row.price item = option}
                    <tr class="group-content option-{$option.code}">
                        <td>{localize translate=$option.name}</td>
                        <td align="center"></td>
                        {foreach from = $package key = package_id item = package_data}
                            <td align="center"class="package">
                                {if (isset($option.packages.$package_id))}
                                    {localize translate=$option.packages.$package_id}
                                {else}
                                    --
                                {/if}
                            </td>
                        {/foreach}
                    </tr>
                {/foreach}
            {/if}
            {*Select Price on each Package*}
            {if $row.is_extra_group}
            {else}
                <tr class="action action-group">
                    <td colspan="2" style="vertical-align: middle; text-align: center;">
                        <div class="action-select-mobile select-pack-label" style="text-align: center;display: none">{localize translate="Select Package"}</div>
                    </td>
                    {foreach from = $package key = package_id item = package_data}
                        <td align="center">
                            <div class="select-action" style="border-top:3px solid {$package_data.color}">
                                <div class="input-checkbox">
                                    {assign var = checked value = ""}
                                    {assign var = disabled value = ""}
                                    {if isset($payment_packages.package.$group_id.$package_id) }
                                        {assign var = checked value = "checked=checked"}
                                        {*{if $property_id > 0 AND $payment_packages.package.$group_id.$package_id == $pay_complete}
                                            {assign var = disabled value = "disabled='disabled'"}
                                        {/if}*}
                                    {/if}
                                    <input type="checkbox" name="package[{$group_id}][{$package_id}]" {$checked} {$disable_ar.$group_id} ref="{$package_data.name}" id="package_{$package_id}_{$group_id}" value="{$package_id}_{$group_id}"/><label for="package_{$package_id}_{$group_id}"></label>
                                    <span>{localize translate="Select this package"}</span>
                                </div>
                            </div>
                        </td>
                    {/foreach}
                </tr>
            {/if}
        <tr class="blank">
            <td colspan="{$total_col}"></td>
        </tr>
        {/foreach}

    </tbody>
    <tfoot>
        {*<tr class="total">
            <td colspan="2">Total Price</td>
            <td colspan="{$totalPackage}" style="text-align: center">
                <div id="total">$0.00</div>
            </td>
        </tr>*}
        <tr class="blank">
            <td colspan="{$total_col}" style="height: 10px"></td>
        </tr>
        {*<tr class="action">
            <td colspan="2"><div class="action-select-mobile" style="display: none">Select this package</div></td>
            {foreach from = $package key = package_id item = package_data}
                <td align="center">
                    <div class="select-action" style="border-top:3px solid {$package_data.color}">
                        <div class="input-checkbox">
                            <input type="checkbox" name="package" ref="{$package_data.name}" id="package_{$package_id}" value="{$package_id}"/><label for="package_{$package_id}"></label>
                            <span>Select this package</span>
                        </div>
                    </div>
                </td>
            {/foreach}
        </tr>*}
        <tr class="action total-box">
            <td colspan="2"></td>
            <td align="right" colspan="{$totalPackage}">
                <div class="total-box">
                    <p>{localize translate="Congratulations, you have selected our"} <span id="package_name"></span>{localize translate="package"}</p>
                    <p class="total-text">{localize translate="Total"} <span id="total">$0.00</span></p>
                </div>
                {foreach from = $package key = package_id item = package_data}
                    <input type="hidden" id="total_{$package_id}" value="{$package_data.total}"/>
                    {foreach from = $package_data.group key = group_id_price item = group_price_data }
                        <input type="hidden" id="total_{$package_id}_{$group_id_price}" value="{$group_price_data.total}"/>
                    {/foreach}
                {/foreach}
                <input type="hidden" name="property_id" id="property_id" value="{$property_id}"/>
            </td>
        </tr>
        <tr class="action">
            <td align="right" colspan="{$total_col}">
                <button class="green-btn" type="button">{localize translate="Next"}</button>
            </td>
        </tr>
    </tfoot>
</table>
</form>
<script type="text/javascript">
    {literal}
    function getTotalPackage() {
        var total = 0;
        var total_extra = 0;
        jQuery('input[type=checkbox][name^=package]').each(function () {
            if (jQuery(this).is(':checked') && !jQuery(this).is(':disabled') ) {
                total += parseFloat(jQuery('#total_' + jQuery(this).val()).val());
            }
        });
        /*Extra Option Price*/
        jQuery('input[type=checkbox][name^=extra_options]').each(function () {
            if (jQuery(this).is(':checked') && !jQuery(this).is(':disabled')) {
                total_extra += parseFloat(jQuery(this).val());
            }
        });
        total += total_extra;
        jQuery('#total_extra').text(formatCurrency(total_extra), 2);
        jQuery('#total').text(formatCurrency(total), 2);
        jQuery('#total-text').text(formatCurrency(total), 2);
        //jQuery('#package_name').text(jQuery(this).attr('ref'));
    }
    jQuery(document).ready(function () {
        jQuery("input[type=checkbox][name^=package],input[type=checkbox][name^=extra_options]").each(function () {
            jQuery(this).bind('click', function () {
                if (jQuery(this).is(':checked') && !jQuery(this).is(':disabled')) {
                    jQuery('input[type=checkbox][name^=package]', jQuery(this).parents('.action-group')).removeAttr('checked');
                    jQuery(this).attr('checked', 'checked');
                }
                getTotalPackage();
            });
        });
        var package = new Package('#frmPackage', '.green-btn');
        package.flushCallback();
        package.callback_func.push(function () {
            return validPackage();
        });
    });
    getTotalPackage();
    function validPackage() {
        var checked = 0;
        jQuery('input[type=checkbox][name^=package]').each(function () {
            if (jQuery(this).is(':checked')) {
                checked++;
            }
        });
        if (checked < 2) {
            alert('Please choose a pack for bidRhino Packages and Concierge Services .');
            return false;
        }
        return true;
    }
    $('.tooltip-package').tipsy({gravity: 'w',html:true});
    {/literal}
</script>