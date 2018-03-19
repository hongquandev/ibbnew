{literal}
<script type="text/javascript">
    var msg = new Message('#frmMessage');
</script>
<script type="text/javascript" src="modules/general/templates/js/confirm.js"></script>

<script type="text/javascript">
    function mySelect(frm) {
        window.location.href = frm.options[frm.selectedIndex].value;
        frm.options[frm.selectedIndex].value;
    }
</script>
{/literal}
<div class="bar-title">
    <h2>{localize translate="MY MESSAGES"} {if isset($action_ar[2])} - {$action_ar[2]|upper} {/if}</h2>

    <div class="bar-filter" id="bar-filter-messages">
        <select onChange="javascript:mySelect(this);">
            <option value="/?module=agent&action=view-message-inbox" {if isset($action_ar[2]) && $action_ar[2]=='inbox'}
                    selected="selected" {/if}>{localize translate="Inbox"} ({$message_data.num_inbox})
            </option>
            <option value="/?module=agent&action=view-message-outbox" {if isset($action_ar[2]) && $action_ar[2]=='outbox'}
                    selected="selected" {/if}>{localize translate="Outbox"} ({$message_data.num_outbox})
            </option>
            <option value="/?module=agent&action=view-message-draft" {if isset($action_ar[2]) && $action_ar[2]=='draft'}
                    selected="selected" {/if}>{localize translate="Drafts"}
            </option>
        </select>
    </div>
</div>

<div class="ma-info mb-20px message-acc-inbox">
<div class="col2-set mb-20px">

<div class="col">

<div class="col-main myaccount">
<!--onsubmit="return false;"-->
<form id="frmMessage" name="frmMessage" action="{$form_action}" method="post" onsubmit="return msg.isSubmit();">
{if isset($action_ar[0])}
    {if isset($message) and strlen($message) > 0}
        <div class="message-box message-box-dashbord">{$message}</div>
    {/if}

    {if in_array($action_ar[0], array('view','delete'))}
        {if $message_id == 0}
            <div class="ma-messages mb-20px">
                <table class="tbl-messages tbl-messages2" cellpadding="0" cellspacing="0">
                    <colgroup>
                        <col width="20px"/>
                        <col width="150px"/>
                        <col width="350px"/>
                        <col width="130px"/>
                    </colgroup>
                    <thead>
                    <tr>
                        <td>
                            <input type="checkbox" name="all_chk" value="" onclick="Common.checkAll(this,'chk')"/>
                        </td>
                        <td>
                            {if $action_ar[2] == 'outbox'}
                                {localize translate="To"}
                                {else}
                                {localize translate="From"}
                            {/if}
                        </td>
                        <td>
                            {localize translate="Subject"}
                        </td>
                        <td>
                            {localize translate="Date Received"}
                        </td>
                    </tr>
                    </thead>
                    {if isset($message_rows) and is_array($message_rows) and count($message_rows)>0}
                        <tbody>
                        {foreach from = $message_rows key = k item = row}
                            <tr  {if $row.read == 1} class="read" {/if}>
                                <td class="first">
                                    <input type="checkbox" name="chk[{$row.message_id}]" id="chk_{$row.message_id}"
                                           value="{$row.message_id}"/>
                                </td>
                                <td onclick="msg.rowClick('{$row.message_id}')">
                                    {if $action_ar[2]=='outbox'}
                                                {if strlen(trim($row.email_to2)) > 0 }
                                        {$row.email_to2}
                                        {else}
                                        {$row.email_to}
                                    {/if}
                                            {else}
                                                {if strlen(trim($row.email_from2)) > 0}
                                        {$row.email_from2}
                                        {else}
                                        {$row.email_from}
                                    {/if}
                                            {/if}
                                </td>
                                <td onclick="msg.rowClick('{$row.message_id}')">
                                    {if $row.read == 1}
                                        {$row.title}
                                        {else}
                                        <b>{$row.title}</b>
                                    {/if}
                                </td>
                                <td onclick="msg.rowClick('{$row.message_id}')">
                                    {$row.send_date|date_format}
                                </td>
                            </tr>
                        {/foreach}
                        </tbody>
                    {/if}
                    <tfoot>
                    <tr>
                        <td colspan="3">
                            <a href="javascript:void(0)" onclick="msg.newMsg('/?module=agent&action=add-message')">
                                {localize translate="New Message"}</a>
                            {if isset($action_ar[2]) and $action_ar[2] == 'inbox'}
                                |<a href="javascript:void(0)" onclick="msg.redirectReplyForword('reply')">{localize translate="Reply"}</a>
                                |<a href="javascript:void(0)" onclick="msg.redirectReplyForword('forward')">{localize translate="Forward"}</a>
                            {/if}
                            |<a href="javascript:void(0)"
                                onclick="msg.delMsg('/?module=agent&action=delete-message-{$action_ar[2]}')">{localize translate="Delete"}</a>
                        </td>
                        <td colspan="1">
                            {if strlen($pag_str) > 0}
                                {$pag_str}
                                <span style="float: right; margin-top: 2px; margin-right:4px; ">{localize translate="Page"}: </span>
                            {/if}
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
    {else}
        <div class="ma-messages-read mb-20px">
            <div class="form-read">
                <div class="form-title">
                    {localize translate="From"}: {$message_detail.email_main}
                </div>
                <div class="form-box">
                    <p>
                        <strong>{localize translate="Subject"}: {$message_detail.title}</strong> <br/>
                        <strong>{localize translate="From date"}: {*Today - 21:06*}{$message_detail.send_date}</strong>
                    </p>

                    <div>
                        {$message_detail.content2}
                    </div>


                    {if isset($action_ar[2]) and $action_ar[2] == 'inbox'}

                        <ul class="form-list">
                            <li>
                                <a href="javascript:void(0)" onclick="msg.replyMsg('{$message_detail.message_id}')">{localize translate="Reply"}</a>
                                | <a href="javascript:void(0)"
                                     onclick="msg.forwardMsg('{$message_datail.message_id}')">{localize translate="Forward"}</a>
                            </li>
                            <li id="tab_email" style="display:none">
                                {localize translate="To"}:<br/>
                                <input type="text" name="email" id="email" value=""
                                       class="input-text validate-email"/>
                            </li>
                            <li>
                                <textarea name="content" id="content" class="input-textarea validate-require"
                                          onclick="msg.textareaReply('{$message_detail.message_id}')"></textarea>
                                <input type="hidden" name="message_id" id="message_id"
                                       value="{$message_detail.message_id}"/>
                                <input type="hidden" name="req" id="req" value=""/>
                            </li>
                        </ul>
                        <div class="buttons-set-s">
                            <button style="margin-left:5px" class="btn-red btn-back"
                                    onclick="(document.location.href='/?module=agent&action={$action}')">
                                <span><span>{localize translate="Back"}</span></span></button>
                            <button class="btn-red btn-red-mess-send" onclick="msg.send()">
                                <span><span>{localize translate="Send"}</span></span>
                            </button>
                        </div>

                        <div style="display:none">
                            <div id="container_message">
                                <p id="reply_from" name="reply_from">{$message_detail.email_main}</p>

                                <p id="reply_content" name="reply_content">
                                    {$message_detail.send_date}, {$message_detail.email_main}
                                    {localize translate=""}wrote:{$message_detail.content_reply}
                                </p>

                                <p id="forward_content" name="forward_content">
                                    -----Forwarded Message-----
                                    {localize translate=""}{localize translate="From"} :{$message_detail.email_main}
                                    {$message_detail.send_date}
                                    {localize translate=""}{localize translate="Subject"}:{$message_detail.title}
                                    {localize translate=""}{localize translate="To"}:{$message_detail.email_to}
                                    {$message_detail.content_forward}
                                </p>
                            </div>
                        </div>
                        {else}
                        <button class="btn-red btn-back"
                                onclick="(document.location.href='/?module=agent&action={$action}')">
                            <span><span>{localize translate="Back"}</span></span>
                        </button>
                    {/if}
                </div>
            </div>
        </div>

            {if $type == 'reply'}
                <script type="text/javascript">
                    msg.replyMsg('{$message_detail.message_id}')
                </script>
                {elseif $type == 'forward'}
                <script type="text/javascript">
                    msg.forwardMsg('{$message_detail.message_id}')
                </script>
            {/if}

        {/if}
    {elseif $action_ar[0] == 'add'}
        <div class="ma-messages-read mb-20px">
            <div class="form-read">
                <div class="form-title">
                    {localize translate="New Message"}
                </div>
                <div class="form-box">
                    <ul class="form-list">
                        <li>
                            <input type="text" name="email" id="email" class="input-text validate-email" value="To"
                                   onFocus="msg.eventOnElement(this,'focus','To')"
                                   onBlur="msg.eventOnElement(this,'blur','To')"/>
                        </li>
                        <li>
                            <input type="text" name="subject" id="subject" class="input-text validate-require"
                                   value="Subject" onFocus="msg.eventOnElement(this,'focus','Subject')"
                                   onBlur="msg.eventOnElement(this,'blur','Subject')"/>
                        </li>
                        <li>
                            <textarea name="content" id="content" class="input-textarea validate-require"
                                      style="width: 581px;height: 250px">
                            </textarea>
                            <input type="hidden" name="req" id="req" value="new"/>
                        </li>
                    </ul>

                    <div class="buttons-set-s">
                        <button style="margin-left:5px" class="btn-red btn-back"
                                onclick="(document.location.href='/?module=agent&action=view-message')">
                            <span><span>{localize translate="Back"}</span></span></button>
                        <button class="btn-red btn-red-mess-send" onclick="msg.submit()">
                            <span><span>{localize translate="Send"}</span></span>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    {/if}
{/if}
    <input type="hidden" name="is_submit" id="is_submit" value="0"/>
</form>

</div>
</div>
<div class="clearthis">
</div>
</div>
</div>