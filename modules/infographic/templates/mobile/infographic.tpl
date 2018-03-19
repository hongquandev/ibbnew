<script type="text/javascript">
    var root_url = '{$ROOTURL}';
    var module_url = '{$ROOTURL}/modules/{$module}';
</script>
{if $action == 'howtosell'}
    {include file = 'infographic.howtosell.tpl'}
{elseif $action == 'howitwork'}
    {include file ="infographic.howitwork.tpl"}
{/if}