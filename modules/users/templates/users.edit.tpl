 
{literal}
<script language="javascript" type="text/javascript">
function change(url)
{  
	if (document.implementation && document.implementation.createDocument)
	{
		xmlDoc = document.implementation.createDocument("", "", null);
		xmlDoc.onload = updateJobs;
	}
	else if (window.ActiveXObject)
	{
		xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
		xmlDoc.onreadystatechange = function () {
			if (xmlDoc.readyState == 4) updateJobs()
		};
 	}
	else
	{
		alert('Your browser can\'t handle this script');
		return;
	}
	xmlDoc.load(url);
}

function changeDepart(url)
{  
	if (document.implementation && document.implementation.createDocument)
	{
		xmlDoc = document.implementation.createDocument("", "", null);
		xmlDoc.onload = updatePos;
	}
	else if (window.ActiveXObject)
	{
		xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
		xmlDoc.onreadystatechange = function () {
			if (xmlDoc.readyState == 4) updatePos()
		};
 	}
	else
	{
		alert('Your browser can\'t handle this script');
		return;
	}
	xmlDoc.load(url);
}

function updateJobs(){
var x = xmlDoc.getElementsByTagName('Jobs');
var y = xmlDoc.getElementsByTagName('JID');
document.frmEdit.JID.options.length=0

	document.frmEdit.JID.options[0]=new Option('-- Select --','');

	for (i=0; i<=x.length; i++){
	
	document.frmEdit.JID.options[document.frmEdit.JID.options.length]=new Option(x[i].firstChild.data,y[i].firstChild.data);
	
	}

	

}

function updatePos(){
var x = xmlDoc.getElementsByTagName('Position');
var y = xmlDoc.getElementsByTagName('PID');
document.frmEdit.PID.options.length=0

 
	document.frmEdit.PID.options[0]=new Option('-- Select --','');

	for (i=0; i<=x.length; i++){
	
	document.frmEdit.PID.options[document.frmEdit.PID.options.length]=new Option(x[i].firstChild.data,y[i].firstChild.data);
	
	}

	

}
</script>

{/literal}
 

<form method="post" action="index.php?module=users&action=edituser&ID={$row.agent_id}" name="frmUserEdit" enctype="multipart/form-data">
<br /> 
<table width="1132" align="center" border="0" cellspacing="0" cellpadding="0">
{if $message}
<tr > 
    <td colspan=2 align="center"><font color="#FF0000">{$message}</font></td>    
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
    <td width="25%" >First Name :</td>
    <td width="75%" style="width:300px;" ><input type="firstname" name="firstname" value="{$row.firstname}" style="width:300px;" ></td>
  </tr> 
  <tr>
    <tr><td>Last Name :</td>
    <td >
   <input type="lastname" name="lastname" value="{$row.lastname}" style="width:300px;" />
    </td>
    </tr> 
    <tr>
         <td>Email :</td>
         <td><input type="email" name="email" value="{$row.email_address}" style="width:300px;" /></td>
    </tr> 
    <tr>	
        <td>Telephone :</td>
        <td><input type="telephone" name="telephone" value="{$row.telephone}" style="width:200px;" /></td>
    </tr>
    <tr>
        <td>Country</td>
        <td>
        <select style="width:150px;" name="country" >
    <option class="country" value="{$row.country}">----</option>
    {html_options options=$country selected=$row.country}
    </select>
        </td>
    </tr>
    <tr>
        <td>State</td>
        <td>
        <select style="width:150px;" name="state" ><option value="">-----</option>
        {html_options options=$state selected=$row.suburb}
        </select>
        </td>
    </tr>
	<tr > 
    <td width="25%"></td>
    <td width="75%">
    <input type="submit" name="submit" value="Submit"> 
     <input type="button" value="Back" onclick="window.location='index.php?module=users&action=list'"></td>
  
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