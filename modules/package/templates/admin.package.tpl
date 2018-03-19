<script type="text/javascript" src="js/ext-base.js"></script>
<script type="text/javascript" src="js/ext-all.js"></script>
<script type="text/javascript" src="js/Ext.ux.plugin.PagingToolbarResizer.js"></script>
<script type="text/javascript" src="js/Ext.ux.grid.Search.js"></script>
<script src="/modules/package/templates/js/admin.js" type="text/javascript"></script>
<script type="text/javascript">
    var package = new Package('#frmPackage');
</script>

{if in_array($action,array('view-property_new','edit-property_new','edit-group','view-manage_group'))}
    {if $action == 'view-property_new'}
        {include file = 'admin.package.property_new.list.tpl'}
    {elseif $action == 'edit-property_new'}
        {include file = 'admin.package.property_new.tpl'}
    {elseif $action == 'view-manage_group'}
        {include file = 'admin.package.manage_group.tpl'}
    {else}
        {include file = 'admin.package.group.tpl'}
    {/if}
{else}

<div style="width:100%">
<form method="post" name="frmPackage" id="frmPackage" action="{$form_action}">
    <table width="1140px" align="center" border="0" cellspacing="0" cellpadding="0">
        <tr > 
        	<td colspan=2 align="center"><font color="#FF0000"></font></td>    
        </tr> 
        <tr> 
            <td colspan=2 >
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center" valign="middle" style="padding:3px" bgcolor="#000000" class="bold12white"> 
                            Package Price Information
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
                                <!--bar-->
                                	{include file = 'admin.package.bar.tpl'}
                                </td>
                                <td valign="top">
                                    {if $message}
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
                                                {if isset($action_ar[1])}
                                                    {include file = "admin.package.`$action_ar[1]`.tpl"}
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
    <input type="hidden" name="package_id" id="package_id" value="{$package_id}" />
    <input type="hidden" name="token" id="token" value="{$token}"/>
</form>
</div>
{/if}

