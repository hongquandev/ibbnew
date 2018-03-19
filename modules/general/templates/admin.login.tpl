
{literal}
<style type="text/css">
    .mess-admin-log{
        border: 1px dashed #CC8C04;
        color: #CC8C04;
        font-size: 18px;
        margin-bottom: 9px;
        margin-top: 0;
        padding-bottom: 5px;
        padding-top: 5px;
        text-align: center;
    }
</style>
{/literal}
<br />
<table width="513" align="center" border="0" cellspacing="0" cellpadding="0">

      <tr>
        <td colspan="2" style="padding-bottom:10px; text-align:center;"> <img src="../modules/general/templates/images/logo.jpg"  alt="" /></td>
      </tr>
      <tr>
        <td colspan="2" bgcolor="">
            {php}
                if(isset($_SESSION['Admin_isLogin']) and !$_SESSION['Admin_isLogin'])
                {
            {/php}
                <div class="mess-admin-log">You have logged out.</div>
            {php}}{/php}
        </td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="1" bgcolor="#CCCCCC"></td>
              <td valign="top" class="padding1" style="border-top:1px solid #CCCCCC ">
			  <form method="post" {literal}onsubmit="if (this.Username.value == '' || this.Password.value =='') { alert('{/literal}{$usersLang.loginMsg}{literal}'); return false;}" {/literal} name="loginForm" id="loginForm" action="/fixit/"  enctype="multipart/form-data">

			  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

                    <tr>



                      <td><img src="{$templatesPath}/images/lock.png" width="150" alt="" style="padding-left: 45px;"/></td>
                      <td align="center" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                          <td height="30" align="right" valign="middle" class="buytext">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="left" style="font-weight:bold; text-transform:uppercase">{$usersLang.Login}</td>
                        </tr>
                      {if $message != ''}
                      	<tr>
                          <td colspan="3" valign="middle" style="color:#FF0000;text-align:center;">{$message}</td>

                        </tr>
                       {/if}
                        <tr>

                          <td width="20%" height="30" align="right" valign="middle" class="buytext">{$usersLang.Username}:</td>
                          <td width="10" rowspan="2">&nbsp;</td>
                          <td align="left" valign="middle"><span class="serchform">
                            <input name="Username" type="text" class="textbox disable-auto-complete" style="width:150px;" id="Username"/>
                          </span></td>
                        </tr>
                        <tr>
                          <td  height="30" align="right" valign="middle" class="buytext">{$usersLang.Password}:</td>

                          <td align="left" valign="middle"><span class="serchform">
                            <input name="Password" type="password" class="textbox disable-auto-complete" style="width:150px;" id="Password"/>
                          </span></td>
                        </tr>

                        <tr>
                          <td height="30" align="right" valign="middle" class="buytext">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td align="left" valign="middle">

                              <input name="Login" style="width:150px;" type="submit" id="Login" value="{$usersLang.Login}" />
                              {*<button class="btn-red btn-red-my-properties" style="width: 169px; margin-left: -11px;" onclick="submitForm()">
                                 <span><span>{$usersLang.Login}</span></span>
                              </button>*}

                              <br /><!--
                            <a href="#">&raquo; {$usersLang.Register}</a> --></td>
                        </tr>


                      </table></td>

                    </tr>

                  </table></td>
                </tr>
                <tr>
                  <td   align="center" valign="bottom">&nbsp;</td>
                </tr>
              </table>
			  </form>			  </td>
              <td width="1" bgcolor="#CCCCCC"></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="12" align="left" valign="top"><img src="{$templatesPath}/images/left_bot.jpg" width="16" height="16" alt="" /></td>

              <td style="background:url({$templatesPath}/images/bgd_bot.jpg)">&nbsp;</td>
              <td width="12" align="right" valign="top"><img src="{$templatesPath}/images/right_bot.jpg" width="16" height="16" alt="" /></td>
            </tr>
        </table></td>

      </tr>
    </table>

<script type="text/javascript">
	{literal}
        function submitForm(){
            jQuery('#loginForm').submit();
        }
    {/literal}
</script>
