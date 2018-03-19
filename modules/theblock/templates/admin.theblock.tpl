{if preg_match('/-banner/', $action)}
	{include file="admin.banner.list.tpl"}
{else}
	{include file="admin.background.list.tpl"}
{/if}
