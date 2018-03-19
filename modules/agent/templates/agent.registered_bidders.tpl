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

                                <a style="float: right;margin: 10px 0" target="_blank" href="/?module=agent&action=export_csv_registered_offers">
                                    <button class="btn-pv"><span>Export CSV</span></button>
                                </a>
                                <br/>
                                <table style="width: 100%; clear: both" class="tbl-messages tbl-messages2 tbl-my-registered-bidders" cellpadding="0" cellspacing="0">
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
                                                        <a class="name" href="javascript:void(0)">
                                                            {if $row.is_disable == 1 || $row.allow == 0}
                                                                <s>{$row.agent_id}</s>
                                                            {else}
                                                                {$row.agent_id}
                                                            {/if}
                                                        </a>

                                                    </td>
                                                    <td>
                                                        {$row.email}
                                                        <br/>
                                                        <br/>
                                                        <a href="javascript:void(0)" style="font-weight: bold; font-style: italic;text-decoration: underline;" onclick="viewUserDetail(this)">View user detail</a>
                                                        <br/>
                                                        <br/>
                                                        <div class="rb-user-detail" style="display: none">
                                                            <span>Driver License:</span><span style="padding-left: 10px;font-style: italic; " >{if $row.dataTerm}<a href="{$ROOTURL}{$row.dataTerm.file_drivers_license_link}" target="_blank">click here</a>{else}Not yet upload{/if}</span><br/>
                                                            <span>Passport Birth:</span><span style="padding-left: 10px;font-style: italic;">{if $row.dataTerm}<a href="{$ROOTURL}{$row.dataTerm.file_passport_birth_link}" target="_blank">click here</a>{else}Not yet upload{/if}</span><br/>
                                                            <span>Fullname:</span><span style="padding-left: 10px;font-style: italic;">{$row.fullname}</span><br/>
                                                            <span>Phone Number:</span><span style="padding-left: 10px;font-style: italic;">{$row.mobilephone} - {$row.telephone}</span><br/>
                                                        </div>
                                                    </td>
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
{literal}
<script type="text/javascript">
    function viewUserDetail(obj) {
        jQuery(obj).parent().find('.rb-user-detail').show();
    }
</script>
{/literal}