<div class="bar-title">
    <h2>{localize translate="MY REGISTERED BIDDERS"}</h2>
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
                                <table style="width: 100%" class="tbl-messages tbl-messages2" cellpadding="0" cellspacing="0">
                                    <colgroup>
                                        <col width="20px"/>
                                        <col width="50px"/>
                                        <col width="50px"/>
                                        <col width="250px"/>
                                        <col width="130px"/>
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
                                                Bidder
                                            </td>
                                            <td>
                                                Email
                                            </td>
                                            <td>
                                                Register time
                                            </td>
                                            <td style="text-align: center">Allow</td>
                                            <td style="text-align: center">Enable</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {if is_array($rows) and count($rows) > 0}
                                            {foreach from = $rows key = i item = row}
                                                <tr id="tr_register_{$i+1}">
                                                    <td style="text-align:center;">{math equation = "(p-1) * len + (i+1)"
                                                        p = $p
                                                        len = $len
                                                        i = $i
                                                        }
                                                    </td>
                                                    <td>
                                                        {$row.property_id}
                                                    </td>
                                                    <td>
                                                        <a class="name" href="javascript:void(0)">
                                                            {if $row.is_disable == 1 || $row.allow == 0}
                                                                <s>{$row.name}</s>
                                                            {else}
                                                                {$row.name}
                                                            {/if}
                                                        </a>
                                                    </td>
                                                    <td>{$row.email}</td>
                                                    <td style="text-align:center;">{$row.time}</td>
                                                    <td style="text-align:center;">{$row.allow_str}</td>
                                                    <td style="text-align:center;">{$row.disable}</td>
                                                    {literal}
                                                    <script type="text/javascript">
                                                        $('#allow_{/literal}{$row.ID}{literal}').unbind('click').bind('click',function(){
                                                            if (typeof bid_{/literal}{$row.property_id}{literal} === 'undefined'){
                                                                var bid_{/literal}{$row.property_id}{literal} = new Bid();
                                                                bid_{/literal}{$row.property_id}{literal}._options.property_id = {/literal}{$row.property_id}{literal};
                                                            }
                                                            //showLoadingPopup();
                                                            bid_{/literal}{$row.property_id}{literal}.allow({/literal}{$row.agent_id}{literal},this);
                                                        });
                                                        $('#disable_{/literal}{$row.ID}{literal}').unbind('click').bind('click',function(){
                                                            if (typeof bid_{/literal}{$row.property_id}{literal} === 'undefined'){
                                                                var bid_{/literal}{$row.property_id}{literal} = new Bid();
                                                                bid_{/literal}{$row.property_id}{literal}._options.property_id = {/literal}{$row.property_id}{literal};
                                                            }
                                                            bid_{/literal}{$row.property_id}{literal}.disable({/literal}{$row.agent_id}{literal},this);
                                                        });
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
                                                <span style="float: right; margin-top: 2px; margin-right:4px; ">{localize translate="Page"}: </span>
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