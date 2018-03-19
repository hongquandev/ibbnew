<script src="../modules/general/templates/js/jquery.min.js" type="text/javascript" charset="utf-8"> </script>
<script type="text/javascript" src="../modules/general/templates/js/validate.js"></script>
<script type="text/javascript" src="../modules/contentfaq/templates/js/admin.js"> </script>

{if in_array($action,array('add','edit'))}
    {include file = 'admin.contentfaq.form.tpl'}
{else}
	{include file = 'admin.contentfaq.list.tpl'}
{/if}