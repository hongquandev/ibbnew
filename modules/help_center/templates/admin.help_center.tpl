<script type="text/javascript" src="js/ext-base.js"></script>
<script type="text/javascript" src="js/ext-all.js"></script>
<script type="text/javascript" src="js/Ext.ux.plugin.PagingToolbarResizer.js"></script>
<script type="text/javascript" src="js/Ext.ux.grid.Search.js"></script>
<script src="/modules/help_center/templates/js/admin.js" type="text/javascript"></script>


<div style="width:100%">
{if eregi('list',$action)}
    <script type="text/javascript">

		var session = new Object();
		session.action_link = '../modules/help_center/action.admin.php?[1]&token={$token}';
		session.url_link = '?module=help_center&action=[1]&token={$token}';
        var catID = '{$catID}';
	</script>
    {include file = 'admin.help.list.tpl'}
{elseif $action == 'popup'}
    {include file = 'admin.help.popup.tpl'}
{else}
    {include file = 'admin.help.form.tpl'}
{/if}
</div>