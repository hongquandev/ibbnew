<table bgcolor="FFFFFF" cellspacing="0" cellpadding="10" border="0" width="100%">
    <tr>
        <td valign="top">
            <h1 style="font-size:22px; font-weight:normal; line-height:22px; margin:0 0 11px 0;">
                Hello, {$data.agent.firstname}
            </h1>
            <h2 style="font-size:12px; line-height:16px; margin:0;">
                Your payment is successful!
            </h2>
            <p style="font-size:12px; line-height:16px; margin:0;">
                Thanks for using bidRhino, your property will be posted live to the site after a quick content review and check.
                <br>
                This will happen within the next 48 hours,
                if you have any issues or concerns please contact us at <a href="mailto:{$data.contact_email}" style="font-size: 14px;font-weight: bold;">{$data.contact_email}</a>.
            </p>
            <p style="font-size:12px; line-height:16px; margin:0;">
                Your payment confirmation is below. Thank you again for your business.
            </p>
        </td>
    </tr>
    <tr>
        <td>
            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                <thead>
                <tr>
                    <th align="left" bgcolor="#edeae6"
                        style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;">Your Contact Information:
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td valign="top" style="font-size:12px; padding:7px 9px 9px 9px; border-left:1px solid #edeae6; border-bottom:1px solid #edeae6; border-right:1px solid #edeae6;">
                        Name: {$data.agent.name}
                        <br>
                        Email: {$data.agent.email_address}
                        <br>
                        Address: {$data.agent.address}
                        <br>
                        {if $data.agent.type_id != 3}
                            Telephone:{$data.agent.telephone}
                            <br>
                        {/if}
                        {if $data.agent.type_id != 3}
                            MobilePhone: {$data.agent.mobilephone}
                        {else}
                            Contact Phone Number: {$data.agent.telephone}
                        {/if}
                        <br>
                        {if $data.agent.type_id != 3}
                            Drivers Register Number: {$data.agent.license_number}
                        {else}
                            ABN/ACN: {$data.agent.license_number}
                        {/if}
                        <br>
                        &nbsp;
                    </td>
                </tr>
                </tbody>
            </table>
            <br/>
            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                <thead>
                <tr>
                    <th align="left" bgcolor="#edeae6"
                        style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;">Property General Information:
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td valign="top"
                        style="font-size:12px; padding:7px 9px 9px 9px; border-left:1px solid #edeae6; border-bottom:1px solid #edeae6; border-right:1px solid #edeae6;">
                        Property ID: {$data.property.property_id}
                        <br>
                        Address: {$data.property.full_address}
                        <br>
                        Property kind:  {$data.property.pro_kind}
                        <br>
                        Land size: {$data.property.land_size}
                        &nbsp;
                        <br>
                    </td>
                </tr>
                </tbody>
            </table>
            <br/>
            <table cellspacing="0" cellpadding="0" border="0" width="100%"
                   style="border:1px solid #EAEAEA;">
                <thead>
                <tr>
                    <th align="left" bgcolor="#EAEAEA" style="font-size:13px; padding:3px 9px">Service Information</th>
                    <th align="center" bgcolor="#EAEAEA" style="font-size:13px; padding:3px 9px">
                        Package
                    </th>
                    <th align="right" bgcolor="#EAEAEA" style="font-size:13px; padding:3px 9px">
                        Price
                    </th>
                </tr>
                </thead>

                {foreach from = $packageData key = group_id item = row}
                    <tbody>
                    <tr>
                        <td align="left" valign="top"
                            style="font-size:11px; padding:3px 9px; border-bottom:1px dotted #CCCCCC;">
                            <strong style="font-size:11px;">{$row.name}</strong>
                            <dl class="item-options" style="margin: 5px 0 5px 10px">
                                <!--<dt></dt>-->
                                <dd style="margin: 0">
                                    {foreach from = $row.options key = option_id item = option}
                                        {*{$option.name}: <i>{$option.value_html}</i>*}
                                        {$option.value_html}
                                        <br>
                                    {/foreach}
                                </dd>
                            </dl>
                        </td>
                        <td align="center" valign="top"
                            style="font-size:11px; padding:3px 9px; border-bottom:1px dotted #CCCCCC;text-align: center">{$row.package_name}
                        </td>
                        <td align="right" valign="top"
                            style="font-size:11px; padding:3px 3px; border-bottom:1px dotted #CCCCCC;">
                            <span class="price">
                                {$row.price_formatted}
                            </span>
                        </td>
                    </tr>
                    </tbody>
                {/foreach}
                <tbody>
                <tr class="subtotal">
                    <td colspan="2" align="right" style="padding:3px 9px">
                        Subtotal
                    </td>
                    <td align="right" style="padding:3px 9px">
                        <span class="price">{$data.property.package_price}</span>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
</table>