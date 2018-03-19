<script type="text/javascript" src="js/ext-base.js"></script>
<script type="text/javascript" src="js/ext-all.js"></script>
<script type="text/javascript" src="js/Ext.ux.plugin.PagingToolbarResizer.js"></script>
<script type="text/javascript" src="js/Ext.ux.grid.Search.js"></script>

<script src="/modules/agent/templates/js/admin.js" type="text/javascript"></script>
<script type="text/javascript">
	var agent = new Agent('#frmAgent');
</script>            

<div style="width:100%">
{if strlen($action) > 0 and $action!='delete'}
    {if $action_arr[1] == 'bidder'}
         {if in_array($action_arr[0],array('add','edit'))}
            {include file='agent.bidder.form.tpl'}
         {else}
            {include file='agent.bidder.list.tpl'}
         {/if}
    {else}
<form  method="post" name="frmAgent" id="frmAgent" action="{$form_action}" enctype="multipart/form-data">
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
                            Agent Information
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
                                	{include file = 'admin.agent.bar.tpl'}
                                </td>
                                <td valign="top">
                                    {if isset($message) and strlen($message) > 0}
                                        <div class="message-box">{$message}</div>
                                    {/if}
                                    <div class="message-box" id="message-content" style="display: none;"></div>
                                    <table width="100%" cellspacing="0" class="box">
                                        <tr>
                                            <td class="box-title">
                                               <label id="titlx">{$title}</label>
                                            </td>
                                        </tr> 
                                        
                                        <tr>
                                        	<td class="box-content">
                                                {if isset($action_ar[1])}
                                                    {include file = "admin.agent.`$action_ar[1]`.tpl"}
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
    <input type="hidden" name="agent_id" id="agent_id" value="{$agent_id}" />
    <input type="hidden" name="token" id="token" value="{$token}"/>
</form>
    {/if}
{else}
	<script type="text/javascript">
	/*var list_link = '../modules/agent/action.admin.php?action=list-agent&token={$token}';
	var add_link = '?module=agent&action=add&token={$token}';*/
    var session = new Object();
		session.action_link = '../modules/agent/action.admin.php?[1]&token={$token}';
		session.url_link = '?[1]&token={$token}';
		session.add_link = '?module=agent&action=add&token={$token}';
		session.action_type = 'agent';
		session.token = '{$token}';
		session.grid_title = 'Customer List';
	</script>
	{include file = 'admin.agent.list.tpl'}
{/if}
</div>

