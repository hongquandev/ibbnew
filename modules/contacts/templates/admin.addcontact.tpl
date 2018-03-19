	{literal}
  	<link rel="stylesheet" type="text/css"
 	 media="screen" href="../modules/contacts/templates/css/style.css"/>

     <script src="../modules/contacts/templates/jsvalidate/jquery.js" type="text/javascript"></script>
	 <script src="../modules/contacts/templates/jsvalidate/jquery.validate.js" type="text/javascript">	     	     </script>
     
     <script type="text/javascript"> 
			$(document).ready(function() {
				$("#xmlCreate").validate();
			});
   		 </script> 
         
         <style type="text/css">

		#xmlCreate label.error
		{
			color: #CC0000;
			display: inline;
			font-size: 12px;
			margin-left:10px;	
			margin-left: -327px;
   			margin-top: 24px;
   			position: absolute;		
		}
		
		</style> 
     {/literal}

<form name="xmlCreate" id="xmlCreate" action="{$part}createxml.php" method="post">
<table width="90%" align="center" border="0" cellspacing="0" cellpadding="0">
<tr > 
    <td colspan=2 align="center"><font color="#FF0000"></font></td>    
  </tr> 

<tr  > 
    <td colspan=2 ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                         
                        <td align="center" valign="middle" style="padding:3px" bgcolor="#000000" class="bold12white">Contact Email </td>
                        
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
                            	<td class="lable" id="gosPos" >Send Email To : </td>
                              <td class="value" height="60px"><input type="text" size="50" name="txtEmail" id="txtEmail" class="required email" value="{$emailTo}" /></td>
                              <td class="value"> <input type="submit" name="submit" value="Save Email" /> </td>
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
                        <td width="12" align="left" valign="top"><img src="{$imagepart}left_bot.jpg" width="16" height="16" /></td>
                        <td background="{$imagepart}bgd_bot.jpg">&nbsp;</td>
                        <td width="12" align="right" valign="top"><img src="{$imagepart}right_bot.jpg" width="16" height="16" /></td>
                      </tr>
                  </table></td>
                </tr>
</table>


</form>