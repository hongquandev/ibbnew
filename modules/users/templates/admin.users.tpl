{if $action == 'changepassword'}
	{include file = 'admin.changepassword.tpl'}
{elseif $action == 'list'}
	{include file = 'admin.users.list.tpl'}
{elseif $action == 'edituser'}
    {include file ='admin.users.edit.tpl'}
{elseif $action == 'adduser'}
	{include file ='admin.users.add.tpl'}
{else}
{include file = 'admin.users.list.tpl'}
{/if}