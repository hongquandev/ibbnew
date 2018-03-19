<script type="text/javascript" src="js/ext-base.js"></script>
<script type="text/javascript" src="js/ext-all.js"></script>
<script type="text/javascript" src="js/Ext.ux.plugin.PagingToolbarResizer.js"></script>
<script type="text/javascript" src="js/Ext.ux.grid.Search.js"></script>
<script src="/modules/user/templates/js/admin.js" type="text/javascript"></script>

<script type="text/javascript">
	var user = new User('#frmUser');
</script>
<div style="width:100%">
{if strlen($action) > 0 and $action!='delete'}
<form  method="post" name="frmUser" id="frmUser" action="{$form_action}">
    <table width="1140px" align="center" border="0" cellspacing="0" cellpadding="0">
        <tr > 
        	<td colspan=2 align="center"><font color="#FF0000"></font></td>    
        </tr> 
        <tr> 
            <td colspan=2 >
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center" valign="middle" style="padding:3px" bgcolor="#000000" class="bold12white"> 
                            <span class="adm-left">{$prev}</span>
                            User Information
                            <span class="adm-right">{$next}</span>
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
                                	{include file = 'admin.user.bar.tpl'}
                                </td>
                                <td valign="top">
                                    {if isset($message) and strlen($message) > 0}
                                        <div class="message-box">{$message}</div>
                                    {/if}
                                    <table width="100%" cellspacing="0" class="box">
                                        <tr>
                                            <td class="box-title">
                                               <label>{$title}</label>
                                            </td>
                                        </tr> 
                                        
                                        <tr>
                                        	<td class="box-content">
                                                {if isset($action)}
                                                    {include file = "admin.user.`$action`.tpl"}
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
    <input type="hidden" name="user_id" value="{$user_id}" />
    <input type="hidden" name="token" id="token" value="{$token}"/>
</form>
{else}
	<script type="text/javascript">
        var session = new Object();
        session.action_link = '../modules/user/action.admin.php?[1]&token={$token}';
		session.add_link = '?module=user&action=add&token={$token}';
		session.action_type = 'user';
		session.grid_title = 'Users List';
	</script>
	{include file = 'admin.user.list.tpl'}
{/if}
</div>

