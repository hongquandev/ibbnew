<script type="text/javascript" src="/modules/cms/templates/js/admin.js"></script>
<script type="text/javascript" src="/modules/general/templates/js/admin.js"></script>
{if $action_ar[0] == 'tourguide'}
    {assign var = "page" value="admin.cms.tourguide-$action_ar[1].tpl"}
    {include file = $page}
{elseif $action == 'landing-page'}
    {include file = "admin.cms.landing-page.tpl"}
{elseif $action == 'edit' }
    {include file = 'admin.cms.edit.tpl'}
{elseif TRUE}
    {include file = 'admin.cms.lists.tpl'}
{/if}


