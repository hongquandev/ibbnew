<script type="text/javascript">
var agent = new Agent();
</script>
<div class="container-l">
    <div class="container-r">
        <div class="container col2-right-layout">
            <div class="main">
                <div class="col-main myaccount">
                    <div class="bar-title">
                        <h2>RETRIEVE YOUR PASSWORD HERE</h2>
                    </div>
                    <div class="ma-info mb-20px">
                        <div class="col2-set mb-20px">
                            <div class="col-11">
                                {if strlen($message)>0}
                                    <div class="message-box message-box-ie">{$message}</div>
                                {/if}
                                <ul class="form-list">
                                    <form name="frmLogin_" id="frmLogin_" method="post" action="?module=agent&action=forgot">
                                        <li class="wide" style="width:300px;">
                                            <label>
                                                <strong>Username / Email <span id="notify_username_">*</span></strong>
                                            </label>
                                            <div class="input-box">
                                                    <input type="text" name="fields[username]" id="username_" value="{$form_datas.username}" class="input-text validate-require" />
                                            </div>
                                        </li>
                                        <li class="wide" style="width:300px;">
                                            <label>
                                                <strong id="allow_tf">The your account is Facebook/Twitter<span >*</span></strong>
                                            </label>
                                            <div class="input-box">
                                                <select name="fields[allow_twitter_facebook]" id="allow_twitter_facebook" onchange="forgot_fbtw(this.value,'#is_show_security')" class="input-select">
                                                    {html_options options = $options_question_tf selected = $form_datas.allow_tf}
                                                </select>
                                            </div>
                                        </li>
                                        <div id="is_show_security">
                                            <ul style="list-style: none;">
                                                <li class="wide" style="width:300px;">
                                                    <label>
                                                        <strong id="notify_security_question">Security question <span >*</span></strong>
                                                    </label>
                                                    <div class="input-box">
                                                        <select name="fields[security_question]" id="security_question" class="input-select validate-number-gtzero">
                                                            {html_options options = $options_question selected = $form_datas.security_question}
                                                        </select>
                                                    </div>
                                                </li>

                                                <li class="wide" style="width:300px;">
                                                    <label>
                                                        <strong id="notify_asecurity_answer">Answer <span >*</span></strong>
                                                    </label>
                                                    <div class="input-box">
                                                        <input type="text" name="fields[security_answer]" id="security_answer" value="" class="input-text validate-require" autocomplete="off" />
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </form>
                                </ul>  
                                <button class="btn-red btn-red-forgot" onclick="agent.submit('#frmLogin_')">
                                    <span><span>Submit</span></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-right">
                	{include file = "`$ROOTPATH`/modules/general/templates/side.right.tpl"}
                </div>
                <div class="clearthis">
                </div>
            </div>
        </div>
    </div>
</div>
<div id="content_security" style="display: none;">
    <li class="wide" style="width:300px;">
        <label>
            <strong id="notify_security_question">Security question <span >*</span></strong>
        </label>
        <div class="input-box">
            <select name="fields[security_question]" id="security_question" class="input-select validate-number-gtzero">
                {html_options options = $options_question selected = $form_datas.security_question}
            </select>
        </div>
    </li>

    <li class="wide" style="width:300px;">
        <label>
            <strong id="notify_asecurity_answer">Answer <span >*</span></strong>
        </label>
        <div class="input-box">
            <input type="text" name="fields[security_answer]" id="security_answer" value="" class="input-text validate-require" autocomplete="off"/>
        </div>
    </li>
</div>
{literal}
<script type="text/javascript">
    function forgot_fbtw(val,id)
    {

        if(val == 1)
        {
            jQuery(id).hide();
            jQuery(id).html('');
        }
        else
        {   jQuery(id).html(jQuery('#content_security').html());
            jQuery(id).show();
        }
    }
</script>
{/literal}