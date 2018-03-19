{literal}
	<script language="javascript">
    var agent = new Agent();
    </script>
{/literal}
<div class="container-l">
    <div class="container-r">
        <div class="container col2-right-layout" id="container-login">
            <div class="main">
                <div class="col-main myaccount2" id="bg-login">
				    <table>
                    	<tr>
                        	<td valign="top">
                                <div class="bar-title" width="200px">
                                    <h2>{localize translate="NEW USER"}</h2>
                                </div>
                                <div class="ma-info mb-20px">
                                    <div class="col2-set mb-20px">
                                        <div class="col-11">
                                            <ul class="form-list">
                                                <li class="wide" style="font-size: 13px;font-weight: bold;margin-bottom: 10px;">
                                                    <a href="{$ROOTURL}/?module=agent&action=register-buyer">User registration</a>
                                                </li>
                                                <li class="wide" style="font-size: 13px;font-weight: bold;margin-bottom: 10px;">
                                                    <a href="{$ROOTURL}/?module=agent&action=register-agent">Agent Registration</a>
                                                </li>
                                                <li class="wide fb" style="font-size: 13px;font-weight: bold;margin-bottom: 10px">
                                                    <a href="javascript:void(0)">{localize translate="Log in using your facebook account"}</a>
                                                </li>
                                                <li class="wide tw" style="font-size: 13px;font-weight: bold;">
                                                    <a href="javascript:void(0)">{localize translate="Log in using your twitter account"}</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </td>
                     		<td valign="top">
                                <div class="bar-title">
                                    <h2>{localize translate="REGISTERED USER"}</h2>
                                </div>
                                <div class="ma-info mb-20px">
                                    <div class="col2-set mb-20px">
                                        <div class="col-11">
                                        	{if strlen($message)>0}
                                            	<div class="message-box">{$message}</div>
                                                <div class="clearthis"></div>
                                            {/if}
                                            <ul class="form-list form-list-login">
                                            <form name="frmLogin_" id="frmLogin_" method="post" action="{$ROOTURLS}/?module=agent&action=login" >
                                                <li class="wide">
                                                    <div class="input-box">
                                                        <select name="fields[instance]" id="instance" >
                                                            {html_options options=$account_instances selected=""}
                                                        </select>
                                                    </div>
                                                </li>
                                                <li class="wide">
                                                    <label>
                                                        <strong>{localize translate="Username / Email"} <span id="notify_username_">*</span></strong>
                                                    </label>
                                                    <div class="input-box">
                                                            <input type="text" name="fields[username]" id="username_" value="{$form_datas.username}" class="input-text validate-require" />
                                                    </div>
                                                </li>
                                                <li class="wide">
                                                    <label>
                                                        <strong>{localize translate="Password"} <span id="notify_password_">*</span></strong>
                                                    </label>
                                                    <div class="input-box">
                                                        <input type="password" name="fields[password]" id="password_" value="{$form_datas.password}" class="input-text validate-require" autocomplete="off"  onKeyPress="return submitenter(this,event)" />
                                                    </div>
                                                </li>
                                            </form>
                                            </ul>
                                         	<a href="#" onclick="return Chvalid(frmLogin_); ">
                                                <button class="btn-red" onclick="agent.submit('#frmLogin_')">
                                                        <span><span>{localize translate="Login"}</span></span>
                                                </button>
                                            </a>
                                            <a href="/?module=agent&action=forgot">{localize translate="Forgot password"}</a>
                                        </div>
                                    </div>
                                </div>
							</td>
                    	</tr>
                    </table>
                </div>
                <div class="col-right">
                </div>
                <div class="clearthis">
                </div>
            </div>
        </div>
    </div>
</div>
{literal}
<SCRIPT TYPE="text/javascript">
	function submitenter(myfield,e)
	{
        var keycode;
        if (window.event) keycode = window.event.keyCode;
        else if (e) keycode = e.which;
        else return true;

        if (keycode == 13)
           {
               myfield.form.submit();
               return false;
           }
        else
           return true;
	}
	function Chvalid(frm) {
	
		var validation = new Validation(frm);
		if(validation.isValid()){
			jQuery(frm).submit();
		}
	}
</SCRIPT>
{/literal}
