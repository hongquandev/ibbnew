{if $action == ''}
    {include file = 'admin.newsletter.list.tpl'}
{else}
    {include file = 'admin.newsletter.sendmail.tpl'}
{/if}