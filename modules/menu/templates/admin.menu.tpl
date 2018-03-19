<script src="/modules/menu/templates/js/admin.js" type="text/javascript"></script>
<script type="text/javascript">
	var menu = new Menu('#frmMenu');
</script>
<div style="width:100%">
<form  method="post" name="frmMenu" id="frmMenu" action="{$form_action}">
    <table width="1140px" align="center" border="0" cellspacing="0" cellpadding="0">
        <tr > 
        	<td colspan=2 align="center"><font color="#FF0000"></font></td>    
        </tr> 
        <tr> 
            <td colspan=2 >
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center" valign="middle" style="padding:3px" bgcolor="#000000" class="bold12white"> 
                            Menu Information
                        </td>
                    </tr>
                </table>
            </td>    
        </tr>  
        <tr>
        <td colspan="2" >
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="1" bgcolor="#CCCCCC"></td>
                    <td align="left" valign="top" class="padding1">
                        <table width="100%" cellspacing="15">
                            <tr>
                                <td width="20%" valign="top" class="bar" id="myaccount-nav">
									<!--bar-->
                                	{include file = 'admin.menu.bar.tpl'}
                                </td>
                                <td valign="top">
                                    {if isset($message) and strlen($message) > 0}
                                        <div class="message-box">{$message}</div>
                                    {/if}
                                    <table width="100%" cellspacing="0" class="box">
                                        <tr>
                                            <td class="box-title">
                                               <label>Menu detail</label>
                                            </td>
                                        </tr> 
                                        
                                        <tr>
                                        	<td class="box-content">
                                                {if isset($action)}
                                                    {include file = "admin.menu.`$action`.tpl"}
                                                {else}
                                                    Can not find the template with this request.
                                                {/if}
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
    <input type="hidden" name="menu_id" value="{$menu_id}" />
    <input type="hidden" name="token" id="token" value="{$token}"/>
</form>

</div>

