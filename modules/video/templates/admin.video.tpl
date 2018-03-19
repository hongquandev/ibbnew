<script type="text/javascript" src="/modules/video/templates/js/admin.js"></script>
<script type="text/javascript" src="/modules/general/templates/js/admin.js"></script>
{if $action == 'edit' }
    {include file = 'admin.video.edit.tpl'}
{elseif TRUE}
    {include file = 'admin.video.lists.tpl'}
{/if}