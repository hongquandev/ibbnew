<script type="text/javascript" src="js/ext-base.js"></script>
<script type="text/javascript" src="js/ext-all.js"></script>
<script type="text/javascript" src="js/Ext.ux.plugin.PagingToolbarResizer.js"></script>
<script type="text/javascript" src="js/Ext.ux.grid.Search.js"></script>
<script src="/modules/press/templates/js/admin.js" type="text/javascript"></script>


<div style="width:100%">
{if eregi('^list',$action)}
    <script type="text/javascript">
		var session = new Object();
		session.action_link = '../modules/press/action.admin.php?[1]&token={$token}';
		session.url_link = '?module=press&action=[1]&token={$token}';
        var catID = '{$catID}';
	</script>
    {include file = 'admin.press.list.tpl'}
{else}
    {include file = 'admin.press.form.tpl'}
{/if}
</div>