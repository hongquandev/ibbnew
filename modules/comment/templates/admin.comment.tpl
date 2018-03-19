<script type="text/javascript" src="js/ext-base.js"></script>
<script type="text/javascript" src="js/ext-all.js"></script>
<script src="/modules/comment/templates/js/admin.js" type="text/javascript"></script>
<script type="text/javascript">
var comment = new Comment('#frmComment');
</script>

<div style="width:100%">
{if strlen($action) > 0 and $action!='list'}
	{include file="/modules/comment/templates/admin.comment.form.tpl"}
{else}
	<script type="text/javascript">
	var session = new Object();
	session.action_link = '../modules/comment/action.admin.php?[1]&token={$token}';
	session.action_type = 'comment';
	session.token = '{$token}';
	session.grid_title = 'Comment List';
	</script>
	{include file = 'admin.comment.list.tpl'}
{/if}
</div>

