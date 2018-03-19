<script src="../modules/general/templates/js/jquery.min.js" type="text/javascript" charset="utf-8"> </script>
<script type="text/javascript" src="../modules/general/templates/js/validate.js"></script>

{literal}
<script type="text/javascript">
	var list_link = '../modules/emailalert/action.admin.php?action=list';
</script>
{/literal}
{if $action == 'list'}
    {include file = 'admin.emailalert.list.tpl'}
{/if}