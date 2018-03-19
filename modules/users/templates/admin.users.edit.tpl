 {literal}

  	  <script src="../modules/users/templates/jsvalidate/prototype.js" type="text/javascript"></script> 
      <script src="../modules/users/templates/jsvalidate/validation.js" type= "text/javascript"> </script> 
 	  <script src="../modules/users/templates/jsvalidate/effects.js" type= "text/javascript"> </script> 
      <link rel="stylesheet" type="text/css"
 	 media="screen" href="../modules/users/templates/jsvalidate/style.css" />  
{/literal}
 

<form method="post" action="index.php?module=users&action=edituser&ID={$row.agent_id}" name="frmCreate" id="frmCreate" enctype="multipart/form-data">
<br /> 
<table width="1132" align="center" border="0" cellspacing="0" cellpadding="0">
{if $message}
<tr > 
    <td colspan=2 align="center"><font color="#FF0000"></font></td>    
  </tr> 
{/if}
<tr  > 
    <td colspan=2 ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                         
                        <td align="center" valign="middle" style="padding:3px" bgcolor="#000000" class="bold12white">Edit User</td>
                        
                      </tr>
                  </table></td>    
  </tr>  
  <tr><td colspan="2">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="1" bgcolor="#CCCCCC"></td>
                        <td align="left" valign="top" class="padding1">
						<table  align="center" cellpadding="5">
						<tr  > 
    <td width="25%" class="labelName" > 
 	   <label for="First Name"> First Name : </label>
     </td>
    <td width="75%" style="width:300px;" ><input type="firstname" name="firstname" value="{$row.firstname}" style="width:300px;" class="required error" /></td>
  </tr> 
  <tr>
    <tr><td class="labelName" ><label for="Last Name"> Last Name : </label> </td>
    <td >
   <input type="lastname" name="lastname" value="{$row.lastname}" style="width:300px;" class="required error" />
    </td>
    </tr> 
    <tr>
         <td class="labelName" ><label for="Email"> Email : </label> </td>
         <td><input type="email" name="email" value="{$row.email_address}" style="width:300px;" class="required validate-email" /></td>
    </tr> 
    <tr>	
        <td class="labelName" ><label for="Telephone">Telephone : </label> </td>
        <td><input type="telephone" name="telephone" value="{$row.telephone}" style="width:200px; margin-right:100px;" class="required validate-number" /></td>
    </tr>
    <tr>
        <td class="labelName" ><label for="Country">Country : </label> </td>
        <td>
        <select style="width:150px; margin-right:150px;" name="country" class="required error" >
    <option value="">Select...</option>
    {html_options options=$country selected=$row.country}
    </select>
        </td>
    </tr>
    <tr>
        <td class="labelName" > <label for="State"> State : </label> </td>
        <td>
        <select style="width:150px; margin-right:150px;" name="state" class="required error" ><option value="">Select...</option>
        {html_options options=$state selected=$row.suburb}
        </select>
        </td>
    </tr>
	<tr > 
    <td width="25%"></td>
    <td width="75%">
    <input type="submit" name="submit" value="Save" /> 
     <input type="button" value="Back" onclick="window.location='index.php?module=users&action=list'" /></td>
  
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
		 var valid = new Validation('frmCreate', true);	
	</script>
{/literal}
