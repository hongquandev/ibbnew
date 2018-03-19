{literal}
<script type="text/javascript" src="js/ext-base.js"></script>
<script type="text/javascript" src="js/ext-all.js"></script> 
<script type="text/javascript" src="../modules/banner_setting/templates/js/paging.js"></script>
<script type="text/javascript" src="js/Ext.ux.plugin.PagingToolbarResizer.js"></script>
<script type="text/javascript" src="js/Ext.ux.grid.Search.js"></script>
{/literal}

<form method="post"  action="" enctype="" >
<table width="778" align="center" border="0" cellspacing="1" cellpadding="3">
        <tr>
        	<td ><div id="topic-grid"></div> </td>
        </tr>
</table>
</form>

<div id="blankDiv" style="position: absolute; left: 0pt; top: 0pt; visibility: hidden;"></div>
<script type="text/javascript">
    var session = new Object();
    session.action_link = '../modules/banner_setting/action.admin.php?[1]&token={$token}';
    session.action_type = 'banner_setting';
</script>
