<script src="../modules/general/templates/js/jquery.min.js" type="text/javascript" charset="utf-8"> </script>
<script type="text/javascript" src="../modules/general/templates/js/validate.js"></script>
<script type="text/javascript" src="../modules/faq/templates/js/admin.js"> </script>

{if $action == 'add'}
		{include file = 'faq.formadd.tpl'}
    {elseif $action == 'edit'}
		{include file = 'faq.formupdate.tpl'}
{else}
	{include file = 'faq.formlist.tpl'}
{/if}