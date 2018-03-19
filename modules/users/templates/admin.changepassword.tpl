{literal}
	  <script src="../modules/users/templates/jsvalidate/prototype.js" type="text/javascript"></script> 
      <script src="../modules/users/templates/jsvalidate/validation.js" type= "text/javascript"> </script> 
 	  <script src="../modules/users/templates/jsvalidate/effects.js" type= "text/javascript"> </script> 
      <link rel="stylesheet" type="text/css"
 		    media="screen" href="../modules/users/templates/jsvalidate/style.css" />  
{/literal}

<form method="post" action="index.php?module=users&action=changepassword" enctype="multipart/form-data" id="frmchangepassword" name="frmchangepassword">
<br /> 
<table width="90%" align="center" border="0" cellspacing="0" cellpadding="0">
{if $message}
<tr > 
    <td colspan=2 align="center"><font color="#FF0000">{$message}</font></td>    
  </tr> 
{/if}
<tr  > 
    <td colspan=2 ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                         
                        <td align="center" valign="middle" style="padding:3px" bgcolor="#000000" class="bold12white">{$generalLang.ChangePassword}</td>
                        
                      </tr>
                  </table></td>    
  </tr>  
  <tr><td colspan="2">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="1" bgcolor="#CCCCCC"></td>
                        <td align="left" valign="top" class="padding1">
					    <table  align="center" cellpadding="5">
                            <tr>
                            	<td width="25%" class="lable">Email Address :</td>
                                <td width="75%" class="value"><input type="email" disabled="disabled"  name="oldEmail" value="{$profile.email}"/></td>
                            </tr>
                                
                             <tr>
                            	<td width="25%" class="lable">First Name :</td>
                                <td width="75%" class="value"><input type="firstname" name="oldFirstName" value="{$profile.firstname}" class="required"/></td>
                            </tr>
                            <tr>
                            	<td width="25%" class="lable">Last Name :</td>
                                <td width="75%" class="value"><input type="lastname" name="oldLastName" value="{$profile.lastname}" class="required"/></td>
                            </tr>
                             <tr>
                            	<td width="25%" class="lable">Telephone :</td>
                                <td width="75%" class="value"><input type="telephone" name="oldTelephone" value="{$profile.telephone}" class="required"/></td>
                            </tr>
                              
                            <tr > 
                                 <td width="25%" class="lable" >{$usersLang.oldPassword}:</td>
                                 <td width="75%" class="value" ><input type="password" name="oldPassword"></td>
                            </tr> 
                            <tr > 
                                <td width="25%" class="lable">{$usersLang.Password}:</td>
                                <td width="75%" class="value"><input type="password" name="Password"></td>
                            </tr> 
    
                            <tr > 
                                <td width="25%" class="lable">{$usersLang.confirmPassword}:</td>
                                <td width="75%" class="value"><input type="password" name="ConfirmPassword"></td>
                            </tr> 
                            <tr > 
                                <td width="25%" ></td>
                                <td width="75%"><input type="submit" name="submit" value="{$usersLang.Change}"></td>
                            </tr> 
						</table>
						
						</td>
                        <td width="1" bgcolor="#CCCCCC"></td>
                      </tr>
                  </table>
  </td></tr>
  
 <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="12" align="left" valign="top"><img src="{$templatesPath}/images/left_bot.jpg" width="16" height="16" /></td>
                        <td background="{$templatesPath}/images/bgd_bot.jpg">&nbsp;</td>
                        <td width="12" align="right" valign="top"><img src="{$templatesPath}/images/right_bot.jpg" width="16" height="16" /></td>
                      </tr>
                  </table></td>
                </tr>
</table>
</form>
<!-- Call Validate -->
{literal}

	<script type="text/javascript">
		 var valid = new Validation('frmchangepassword', true);	
	</script>
{/literal}
