{literal}
 <!-- <link href="../modules/general/templates/style/styles.css" type="text/css" rel="stylesheet" />-->
{/literal}
{if $action == 'contacts'}
	{include file = 'contacts.addcontact.tpl'}
{literal}
<script type="text/javascript">
    $(function() {
        $("#contactname").val("{/literal}{$name}{literal}");
        $("#email").val("{/literal}{$email}{literal}");
    });
</script>
{/literal}
{/if}
