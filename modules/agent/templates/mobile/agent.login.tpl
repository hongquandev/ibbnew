{literal}
<script type="text/javascript">
    var agent = new Agent();
    var fb_url = '{/literal}{$fb.url}{literal}';
    var fb_id = '{/literal}{$fb.id}{literal}';
</script>
{/literal}
<div id="fb-root"></div>
<div class="container-l">
    <div class="container-r">
        <div class="main login-page">
            <div class="bar-title">
                <h2>REGISTERED USER</h2>
            </div>

            <div class="ma-info mb-20px">
                <div class="col2-set mb-20px">
                    <div class="col-11">
                        {if strlen($message)>0}
                            <div class="message-box">{$message}</div>
                            <div class="clearthis"></div>
                        {/if}
                        <ul class="form-list form-list-login">
                            <form name="frmLogin_" id="frmLogin_" method="post"
                                  action="{$ROOTURLS}/?module=agent&action=login">

                                <li class="wide">
                                    <label>
                                        <strong>Username / Email <span id="notify_username_">*</span></strong>
                                    </label>

                                    <div class="input-box">
                                        <input type="text" name="fields[username]" id="username_"
                                               value="{$form_datas.username}"
                                               class="input-text validate-require"/>
                                    </div>
                                </li>
                                <li class="wide">
                                    <label>
                                        <strong>Password <span id="notify_password_">*</span></strong>
                                    </label>

                                    <div class="input-box">
                                        <input type="password" name="fields[password]" id="password_"
                                               value="{$form_datas.password}"
                                               class="input-text validate-require" autocomplete="off"
                                               onKeyPress="return submitenter(this,event)"/>
                                    </div>
                                </li>
                            </form>
                        </ul>
                        {*<a href="#" onclick="return Chvalid(frmLogin_); ">
                        </a>*}
                        <button class="btn-yellow" onclick="agent.submit('#frmLogin_')">
                            <span><span>Login</span></span>
                        </button>
                        <a style="margin-left: 10px" href="/?module=agent&action=forgot">Forgot password</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<ul class="register-list">
    <li class="social-list">
        {if ($fb.enable == 1)}
            {if $authentic.login == false || !isset($authentic)}
                <div class="fb-mobile">
                    <button class="social" onclick="loginFB();" style="border:0px;" alt="Sign in with Facebook"></button>
                </div>
            {/if}
        {/if}
    </li>
    <li class="social-list last-child">
        {*TWITTER*}
        {if $tw.enable == 1}
            {if $authentic.login == false || !isset($authentic)}
                <div class="block-twitter">
                    <a href="javascript:void(0)" class="tw social" alt="Sign in with Twitter" ></a>
                </div>
                <script type="text/javascript">var tw_url = '{$tw.url}&isMobile=1';</script>
            {/if}
            <input type="hidden" name="email" id="email_address" {if $agent_email}value="{$agent_email}"
                   {else}value="{$authentic.email_address}"{/if}/>
            <input type="hidden" name="login" id="login" value="{$authentic.login}"/>
        {/if}
    </li>
    {*<li>
        <a href="{$ROOTURL}/?module=agent&action=register-vendor">VENDOR REGISTRATION</a>
    </li>*}
    <li>
        <a href="{$ROOTURL}/?module=agent&action=register-buyer">USER REGISTRATION</a>
    </li>
</ul>
{literal}
<script type="text/javascript" src="/modules/general/templates/js/fb-tw.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function () {
        var windowH = jQuery(document).height();
        var containerH = jQuery('.container-l').outerHeight();
        var height = windowH - jQuery('header').outerHeight() - containerH - jQuery('.footer').height() - jQuery('.register-list').height();
        jQuery('.register-list').css('margin-top', height + 'px');
    });
    function submitenter(myfield, e) {
        var keycode;
        if (window.event) keycode = window.event.keyCode;
        else if (e) keycode = e.which;
        else return true;

        if (keycode == 13) {
            myfield.form.submit();
            return false;
        }
        else
            return true;
    }
    function Chvalid(frm) {

        var validation = new Validation(frm);
        if (validation.isValid()) {
            jQuery(frm).submit();
        }
    }
</script>
{/literal}
