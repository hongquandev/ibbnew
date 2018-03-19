{literal}
<script type="text/javascript" src="js/ext-base.js"></script>
<script type="text/javascript" src="js/ext-all.js"></script> 
<script type="text/javascript" src="../modules/systemlog/jslang/paging.en.js"></script>
<script type="text/javascript" src="js/Ext.ux.plugin.PagingToolbarResizer.js"></script>
<script type="text/javascript" src="js/Ext.ux.grid.Search.js"></script>
{/literal}

<table width="778" align="center" border="0" cellspacing="1" cellpadding="3">
	{if $message}
	<tr>
    	<td><div id="msgID" class="message-box">{$message}</div></td>
    </tr>
    {/if}
    <tr>
	    <td ><div id="topic-grid"></div></td>
    </tr>
</table> 

</div> 
<div id="blankDiv" style="position: absolute; left: 0pt; top: 0pt; visibility: hidden;"></div>
<script type="text/javascript">
    var session = new Object();
    session.action_link = '../modules/systemlog/action.admin.php?[1]&token={$token}';
	session.grid_title = 'System Logs List';
    session.action_type = 'log';
</script>

