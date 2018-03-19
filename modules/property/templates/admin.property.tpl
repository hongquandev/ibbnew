<script type="text/javascript" src="js/ext-base.js"></script>
<script type="text/javascript" src="js/ext-all.js"></script>
<script type="text/javascript" src="js/Ext.ux.plugin.PagingToolbarResizer.js"></script>
<script type="text/javascript" src="js/Ext.ux.grid.Search.js"></script>
{*<script type="text/javascript" src="http://dev.sencha.com/deploy/ext-4.0.7-gpl/ext-all.js"></script>*}
<script src="/modules/property/templates/js/admin.js" type="text/javascript"></script>
 <script type="text/javascript" src="../modules/general/templates/js/cufon/cufon-yui.js"></script>
 <script type="text/javascript" src="../modules/general/templates/js/cufon/Neutra_Text_500-Neutra_Text_700.font.js"></script>
 <script type="text/javascript" src="../modules/general/templates/js/cufon/gos-api.js"></script>
 <script type="text/javascript" src="../modules/general/templates/js/gos_api.js"></script>
<!--calendar-->
<script src="../modules/general/templates/calendar/js/jscal2.js"></script>
<script src="../modules/general/templates/calendar/js/lang/en.js"></script>
<link rel="stylesheet" type="text/css" href="../modules/general/templates/calendar/css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="../modules/general/templates/calendar/css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="../modules/general/templates/calendar/css/steel/steel.css" />
<script type="text/javascript">var pro = new Property('#frmProperty');</script>

<div style="width:100%">
{if $action == 'reaxml_import_products'}
    {include file = 'admin.property.reaxml_import_products.tpl'}
{elseif (strlen($action) > 0) and !eregi('list',$action)}
    <script type="text/javascript">
	var left_json = {$left_json};
	{literal}
	function listenerLeftMenu(id) {
		jQuery('[id^=left_]').each(function(){
			jQuery(this).hide();
		});
		
		var obj = left_json[id];
		
		for(var key in obj) {
			jQuery('#left_' + key).show();
		}
	}
	{/literal}
	listenerLeftMenu({$auction});
	</script>
	{include file="`$ROOTPATH`/modules/property/templates/admin.property.form.tpl"}
{elseif in_array($action,array('list','list-focus','list-home','list-inactive'))}
    <script type="text/javascript">
		var session = new Object();
		session.action_link = '../modules/property/action.admin.php?[1]&token={$token}';
		session.url_link = '?[1]&token={$token}';
		session.add_link = '?module=property&action=add&token={$token}';
		session.action_type = 'property';
		session.token = '{$token}';
		session.grid_title = 'Property List';
	</script>
    {if $action == 'list-focus'}
    	<script type="text/javascript">
        	//session.action_link = '../modules/property/action.admin.php?[1]&token={$token}';
			session.action_type = 'property-focus';
			session.grid_title = 'Focus Property List';
		</script>
    {elseif $action == 'list-home'}
    	<script type="text/javascript">
        	//session.action_link = '../modules/property/action.admin.php?[1]&token={$token}';
			session.action_type = 'property-home';
			session.grid_title = 'Home Property List';
		</script>
    {elseif $action == 'list-inactive'}
    	<script type="text/javascript">
        	//session.action_link = '../modules/property/action.admin.php?[1]&token={$token}';
			session.action_type = 'property-inactive';
			session.grid_title = 'Inactive Property List';
		</script>
    {/if}
	{include file = 'admin.property.list.tpl'}
{elseif $action == 'list-comment'}
	{include file = 'admin.property.comment.list.tpl'}
{elseif $action == 'list-note'}
	{include file = 'admin.property.note.list.tpl'}
{/if}
</div>

