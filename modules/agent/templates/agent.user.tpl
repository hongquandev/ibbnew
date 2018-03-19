<script src="/modules/report/templates/js/report.js"></script>
<script type="text/javascript">
    var report = new Report();
</script>
<div class="bar-title">
    <h2>MY {$agent_type} USERS</h2>
    <div class="bar-filter" style="width:auto;">
    	<form name="frmUser" id="frmUser" method="post" action="{$form_action}">
              <div style="width:60px;float:right">
                 <select name='len' id='len' onchange="report.submit('#frmUser')" style="width:65px">
                        {html_options options = $len_ar selected = $len}
                 </select>
              </div>
           <input type="hidden" name="is_submit" id="is_submit" value="0"/>
        </form>
    </div>
</div>

<div class="ma-info mb-20px">
    <div class="col2-set mb-20px">
        <div class="col">
            <div class="col-main myaccount">
                {if $authentic.type == 'agent'}
                    {if ($package_arr.account_num > 0 && $total_row < $package_arr.account_num)
                        || ($package_arr.account_num == '' && count($package_arr) > 0)}
                        <button class="btn-red btn-red-user-properties" onclick="document.location='?module=agent&action=add-user'">
                             <span><span> Add New User </span></span>
                        </button>
                    {elseif count($package_arr) <= 0}
                        <i>Your account has expired. Please payment to continue.</i>
                    {else}
                        <i>Your package is only created {$package_arr.account_num} sub account(s). If you want more than {$package_arr.account_num} sub account(s), please upgrade <a style="color:#CC8C04;font-weight:bold" href="/?module=agent&action=view-payment">here</a>.</i>
                    {/if}
                {else}
                    <button class="btn-red btn-red-user-properties" onclick="document.location='?module=agent&action=add-user'">
                             <span><span> Add New User </span></span>
                    </button>
                {/if}

                <span class="" style="float:right;padding-bottom:10px;">{$review_pagging}</span>
                <div class="clearthis"></div>
                <div class="ma-messages mb-20px my-report" style="margin-top:10px">
                    <table class="tbl-messages" cellpadding="0" cellspacing="0">
                        <colgroup>
                          <col width="100px"/><col width="200px"/><col width="200px"/><col width="80px"/><col width="80px"/>
                        </colgroup>
                        <thead>
                               <tr>
                                    <td>ID</td>
                                    <td align="center">Full name</td>
                                    <td align="center">Email Address</td>
                                    <td align="center">Status</td>
                                    <td align="center"></td>
                               </tr>
                        </thead>
                        {if isset($users) and is_array($users) and count($users)>0}
                                <tbody></tbody>
                                    {foreach from = $users key = k item = row}
                                        <tr {if $k%2 == 1} class="read"{/if}>
                                            <td style="padding-left:4px;">#{$row.agent_id}</td>
                                            <td>{$row.full_name}</td>
                                            <td>{$row.email_address}</td>
                                            <td align="center"><a href="javascript:void(0)" onclick="agent.changeStatus('{$row.agent_id}',this)">{$row.status}</a></td>
                                            <td align="center"><a href="{$row.edit_link}">Edit</a></td>
                                        </tr>
                                    {/foreach}
                                </tbody>
                        {/if}
                    </table>
                </div>
            </div>
        </div>
        <div class="clearthis"></div>
        {$pag_str}
    </div>
</div>
