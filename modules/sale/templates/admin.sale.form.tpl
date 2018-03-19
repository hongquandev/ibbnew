<form  method="post" name="frmPayment" id="frmPayment" action="{$form_action}" enctype="multipart/form-data">
    <table width="1140px" align="center" border="0" cellspacing="0" cellpadding="0">
        <tr > 
        	<td colspan=2 align="center"><font color="#FF0000"></font></td>    
        </tr> 
        <tr> 
            <td colspan=2 >
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center" valign="middle" style="padding:3px" bgcolor="#000000" class="bold12white"> 
                            Payment Information
                        </td>
                    </tr>
                </table>
            </td>    
        </tr>  
        <tr>
        <td colspan="2">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="1" bgcolor="#CCCCCC"></td>
                    <td align="left" valign="top" class="padding1">
                        <table width="100%" cellspacing="15">
                            <tr>
                                <td width="22%" valign="top" class="bar" id="myaccount-nav">
                                	{include file = 'admin.sale.bar.tpl'}
                                </td>
                                <td valign="top">
                                   {if isset($message) and strlen($message) > 0}
                                        <div class="message-box all-step-message-box" id="message">{$message}</div>
                                   {/if}
                                    <table width="100%" cellspacing="0" class="box">
                                        <tr>
                                            <td class="box-title">
                                               <label>{$title}</label>
                                            </td>
                                        </tr> 
                                        
                                        <tr>
                                        	<td class="box-content">
                                            
                                            
                                            
                                            </td>
                                        </tr> 
                                    </table>                                  
                                </td>
                            </tr>             
                        </table>
                    </td>
                    <td width="1" bgcolor="#CCCCCC"></td>
                </tr>
            </table>
        </td>
        </tr>
        
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="12" align="left" valign="top"><img src="/modules/general/templates/images/left_bot.jpg" width="16" height="16" /></td>
                        <td background="/modules/general/templates/images/bgd_bot.jpg">&nbsp;</td>
                        <td width="12" align="right" valign="top"><img src="/modules/general/templates/images/right_bot.jpg" width="16" height="16" /></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <input type="hidden" name="id" id="id" value="{$id}" />
    <input type="hidden" name="token" id="token" value="{$token}"/>
</form>
