<script type="text/javascript" src="../modules/report/templates/js/agent.paging.js"></script>
{if $Admin.Level == 1}
    <table align="center" border="0" cellspacing="1" cellpadding="3">
    	<tr>
        	<td colspan="2" align="right">
            	{include file="admin.report.agent.search.tool.tpl"}
            </td>
        </tr>
        <tr>
            <td colspan="2"><div id="msgID" class="message-box" style="display:none;"></div> </td>
        </tr>
        <tr>
            <td><div id="topic-grid2"></div> </td>
            <td><div id="topic-grid"></div> </td>
        </tr>
    </table> 
	<div id="blankDiv" style="position: absolute; left: 0pt; top: 0pt; visibility: hidden;"></div>
{else}
    <table align="center" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td >You do not have permission to view this module.</td>
      </tr>
    </table> 
{/if}

<script type="text/javascript">
    var list_link = '../modules/report/action.admin.php?action=list-agent&token={$token}';
	var list_link2 = '../modules/report/action.admin.php?action=list-agent_time&token={$token}';
</script>