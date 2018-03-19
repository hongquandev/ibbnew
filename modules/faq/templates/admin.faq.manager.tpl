<script type="text/javascript" src="js/ext-base.js"></script>
<script type="text/javascript" src="js/ext-all.js"></script>   
<script src="/modules/property/templates/js/admin.js" type="text/javascript"></script>

<script type="text/javascript">
var pro = new Property('#frmProperty');
</script>

<div style="width:100%">
{if (strlen($action) > 0) and !eregi('list',$action)}

<form  method="post" name="frmProperty" id="frmProperty" action="{$form_action}">
    <table width="90%" align="center" border="0" cellspacing="0" cellpadding="0">
        <tr > 
        	<td colspan=2 align="center"><font color="#FF0000"></font></td>    
        </tr> 
        <tr> 
            <td colspan=2 >
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center" valign="middle" style="padding:3px" bgcolor="#000000" class="bold12white"> 
                            <span class="adm-left">{$prev}</span>
                            Property Information
                            <span class="adm-right">{$next}</span>
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
                                	{include file = 'admin.property.bar.tpl'}
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
                                                {if isset($action_ar[1])}
                                                    {include file = "admin.property.`$action_ar[1]`.tpl"}
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
    <input type="hidden" name="property_id" id="property_id" value="{$property_id}" />
    <input type="hidden" name="token" id="token" value="{$token}"/>
</form>
{elseif in_array($action,array('list','list-focus','list-feature'))}
    <script type="text/javascript">
        var list_link = '../modules/property/action.admin.php?action=list-property&token={$token}';
		var add_link = '?module=property&action=add&token={$token}';
    </script>
    {if $action == 'list-focus'}
        <script type="text/javascript">
            var list_link = '../modules/property/action.admin.php?action=list-property-focus&token={$token}';
        </script>
    {elseif $action == 'list-feature'}
        <script type="text/javascript">
            var list_link = '../modules/property/action.admin.php?action=list-property-feature&token={$token}';
        </script>
    {/if}
	{include file = 'admin.property.list.tpl'}
{elseif $action == 'list-comment'}
	{include file = 'admin.property.comment.list.tpl'}
{elseif $action == 'list-note'}
	{include file = 'admin.property.note.list.tpl'}    
{/if}
</div>

