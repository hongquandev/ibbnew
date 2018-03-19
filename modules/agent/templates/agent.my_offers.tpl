<div class="bar-title">
    <h2>{localize translate="MY OFFERS"}</h2>
</div>
<div class="ma-info mb-20px message-acc-inbox">
    <div class="col2-set mb-20px">
        <div class="col">
            <div class="col-main myaccount" style="margin-top: 10px">
                {if isset($action_ar[0])}
                    {if isset($message) and strlen($message) > 0}
                        <div class="message-box message-box-dashbord">{$message}</div>
                    {/if}
                    {if in_array($action_ar[0], array('view','delete'))}
                        {if true}
                            <div class="ma-messages mb-20px">
                                <table style="width: 100%" class="tbl-messages tbl-messages2 tbl-my-registered-bidders" cellpadding="0" cellspacing="0">
                                    <colgroup>
                                        <col width="5%"/>
                                        <col width="7%"/>
                                        <col width="30%"/>
                                        <col width="10%"/>
                                        <col width="10%"/>
                                        <col width="10%"/>
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <td>
                                                No
                                            </td>
                                            <td>
                                                Pro ID
                                            </td>
                                            <td>
                                                Offer Details
                                            </td>
                                            <td>
                                                Offer Price
                                            </td>
                                            <td>
                                                Date of offer
                                            </td>
                                            <td style="text-align: center">Status</td>
                                            {*<td style="text-align: center">Mail</td>*}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {if is_array($rows) and count($rows) > 0}
                                            {foreach from = $rows key = i item = row}
                                                <tr id="tr_register_{$i+1}">
                                                    <td style="text-align:center;padding: 8px;font-size: 13px">{math equation = "(p-1) * len + (i+1)"
                                                        p = $p
                                                        len = $len
                                                        i = $i
                                                        }
                                                    </td>
                                                    <td>
                                                        {$row.property_id}
                                                    </td>
                                                    <td>
                                                        {$row.property_details}
                                                        <br>
                                                        <br>
                                                        <a href="{$row.link_detail}" style="text-decoration: underline; color: #980000">View property</a>
                                                    </td>
                                                    <td>{$row.offer_price}</td>
                                                    <td style="text-align:center;">{$row.time}</td>
                                                    <td style="text-align:center;">{$row.status}</td>
                                                    {*<td style="text-align:center;">Click to email<br> own property</td>*}
                                                    {literal}
                                                    <script type="text/javascript">
                                                    </script>
                                                    {/literal}
                                                </tr>
                                            {/foreach}
                                        {/if}
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="7" style="padding: 5px 20px;">
                                            {if strlen($pag_str) > 0}
                                                {$pag_str}
                                                <span style="float: right; margin-top: 2px; margin-right:4px; ">{localize translate="Page"}: {$p} </span>
                                            {/if}
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        {/if}
                    {/if}
                {/if}
            </div>
        </div>
    <div class="clearthis">
    </div>
    </div>
</div>