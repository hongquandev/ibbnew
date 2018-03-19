<script type="text/javascript" src="../modules/banner_setting/templates/js/admin.js"> </script>
{if in_array($action,array('add','edit'))}
	{include file = 'admin.banner_setting.form.tpl'}
{else}
	{include file = 'admin.banner_setting.list.tpl'}
{/if} 
