<table bgcolor="FFFFFF" cellspacing="0" cellpadding="10" border="0" width="100%">
    <tr>
        <td valign="top">
            <h1 style="font-size:22px; font-weight:normal; line-height:22px; margin:0 0 11px 0;">
                Dear, {$buyer_name}
            </h1>
            <h2 style="font-size:12px; line-height:16px; margin:0;">
                You Buy Now with price {$price} has canceled by Agent of the property ID#{$property.property_id}
            </h2>
            <p style="font-size:12px; line-height:16px; margin:0;">
                Thanks for using bidRhino, if you have any issues or concerns please contact us at <a href="mailto:{$contact_email}" style="font-size: 14px;font-weight: bold;">{$contact_email}</a>.
            </p>
            <p style="font-size:12px; line-height:16px; margin:0;">
                The property infomation is below. Thank you again for your business.
            </p>
        </td>
    </tr>
    <tr>
        <td>
            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                <thead>
                <tr>
                    <th align="left" bgcolor="#edeae6"
                        style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;">Property Information:
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td valign="top"
                        style="font-size:12px; padding:7px 9px 9px 9px; border-left:1px solid #edeae6; border-bottom:1px solid #edeae6; border-right:1px solid #edeae6;">
                        Property ID: {$property.property_id}
                        <br>
                        Address: {$property.full_address}
                        <br>
                        Property kind:  {$property.pro_kind}
                        <br>
                        Land size: {$property.land_size}
                        &nbsp;
                        <br>
                    </td>
                </tr>
                </tbody>
            </table>
            <br/>
        </td>
    </tr>
</table>