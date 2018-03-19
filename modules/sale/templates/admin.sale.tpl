<script type="text/javascript">
    var ROOTURL = "{$ROOTURL}";
</script>
<script type="text/javascript" src="js/ext-base.js"></script>
<script type="text/javascript" src="js/ext-all.js"></script>
<script type="text/javascript" src="js/Ext.ux.plugin.PagingToolbarResizer.js"></script>
<script type="text/javascript" src="js/Ext.ux.grid.Search.js"></script>
<script type="text/javascript" src="/modules/general/templates/js/cufon/cufon-yui.js"></script>
<script type="text/javascript" src="/modules/general/templates/js/cufon/Neutra_Text_500-Neutra_Text_700.font.js"></script>
<script type="text/javascript" src="/modules/general/templates/js/cufon/gos-api.js"></script>
<script type="text/javascript" src="/modules/general/templates/js/gos_api.js"></script>

<div style="width:100%">
{if (strlen($action) > 0) and !eregi('list',$action)}
	{include file="admin.sale.form.tpl"}
{elseif in_array($action, array('list', 'list-property', 'list-banner'))}
    <script type="text/javascript">
		var session = new Object();
		session.action_link = '/modules/sale/action.admin.php?[1]&token={$token}';
		session.url_link = '?[1]&token={$token}';
		session.add_link = '?module=sale&action=add&token={$token}';
		session.action_type = '{$type}';
		session.token = '{$token}';
		session.grid_title = 'Payment Collection For {$type}';
	</script>
	{include file = 'admin.sale.list.tpl'}
{/if}
</div>

